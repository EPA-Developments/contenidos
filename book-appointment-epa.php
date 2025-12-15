<?php
/**
 * EPA Bienestar - Sistema de Turnos Integrado
 * FHIR R4 (Medplum) + Google Calendar + Google Sheets
 * 
 * @author Alejandro D'Alessandro
 * @version 1.0
 */

// ============================================================================
// CONFIGURACIÓN
// ============================================================================

// Medplum Configuration
define('MEDPLUM_BASE_URL', 'https://api.epa-bienestar.com.ar/fhir/R4');
define('MEDPLUM_AUTH_URL', 'https://api.epa-bienestar.com.ar/oauth2/token');
define('MEDPLUM_CLIENT_ID', '188d147c-a397-482e-898e-928fbd445321');
define('MEDPLUM_CLIENT_SECRET', '9a19158956a155a4ed8d95649d046b4830fa960cbf92258c153989f05266c027');
define('MEDPLUM_PROJECT_ID', '79679343-1b6e-47b9-bee7-32929111451d');

// Google Configuration (COMPLETAR DESPUÉS DE CREAR SERVICE ACCOUNT)
define('GOOGLE_SERVICE_ACCOUNT_EMAIL', 'TU-SERVICE-ACCOUNT@EPA-BIENESTAR-TURNOS.iam.gserviceaccount.com');
define('GOOGLE_PRIVATE_KEY', '-----BEGIN PRIVATE KEY-----
TU_PRIVATE_KEY_AQUI
-----END PRIVATE KEY-----');
define('GOOGLE_CALENDAR_ID', 'TU_CALENDAR_ID@group.calendar.google.com'); // o 'primary'
define('GOOGLE_SHEET_ID', 'TU_GOOGLE_SHEET_ID'); // De la URL del Sheet

// Doctor Configuration
define('PRACTITIONER_ID', '01963669-5948-744d-9895-756c2494b912'); // ID del Dr. D'Alessandro en Medplum
define('DOCTOR_NAME', 'Dr. Alejandro Sergio D\'Alessandro');
define('APPOINTMENT_DURATION_MINUTES', 20);
define('TIMEZONE', 'America/Argentina/Buenos_Aires');

// Schedule: Jueves 14:00 - 17:00
$DOCTOR_SCHEDULE = [
    'thursday' => ['start' => '14:00', 'end' => '17:00']
];

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set(TIMEZONE);

// ============================================================================
// MEDPLUM FUNCTIONS
// ============================================================================

/**
 * Get Medplum Access Token
 */
function getMedplumToken() {
    $ch = curl_init(MEDPLUM_AUTH_URL);
    
    $data = [
        'grant_type' => 'client_credentials',
        'client_id' => MEDPLUM_CLIENT_ID,
        'client_secret' => MEDPLUM_CLIENT_SECRET
    ];
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        return $result['access_token'] ?? null;
    }
    
    return null;
}

/**
 * Create FHIR Appointment Resource
 */
function createFHIRAppointment($patientId, $appointmentData) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }
    
    // Build FHIR Appointment Resource
    $appointment = [
        'resourceType' => 'Appointment',
        'status' => 'proposed', // proposed, pending, booked, arrived, fulfilled, cancelled
        'serviceType' => [
            [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/service-type',
                        'code' => $appointmentData['type'] === 'telemedicina' ? '540' : '124',
                        'display' => $appointmentData['type'] === 'telemedicina' ? 'Telemedicine' : 'General Practice'
                    ]
                ],
                'text' => $appointmentData['type'] === 'telemedicina' ? 'Telemedicina' : 'Segunda Opinión'
            ]
        ],
        'appointmentType' => [
            'coding' => [
                [
                    'system' => 'http://terminology.hl7.org/CodeSystem/v2-0276',
                    'code' => $appointmentData['type'] === 'telemedicina' ? 'ROUTINE' : 'FOLLOWUP',
                    'display' => $appointmentData['type'] === 'telemedicina' ? 'Routine appointment' : 'Follow-up'
                ]
            ]
        ],
        'reasonCode' => [
            [
                'text' => $appointmentData['reason']
            ]
        ],
        'description' => $appointmentData['reason'],
        'start' => $appointmentData['datetime'], // ISO 8601 format
        'end' => date('c', strtotime($appointmentData['datetime']) + (APPOINTMENT_DURATION_MINUTES * 60)),
        'created' => date('c'),
        'comment' => $appointmentData['comments'] ?? '',
        'participant' => [
            [
                'actor' => [
                    'reference' => "Patient/{$patientId}",
                    'display' => $appointmentData['patient_name']
                ],
                'required' => 'required',
                'status' => 'accepted'
            ],
            [
                'actor' => [
                    'reference' => 'Practitioner/' . PRACTITIONER_ID,
                    'display' => DOCTOR_NAME
                ],
                'required' => 'required',
                'status' => 'accepted'
            ]
        ],
        'meta' => [
            'tag' => [
                [
                    'system' => 'http://epa-bienestar.com.ar/tags',
                    'code' => 'web-booking',
                    'display' => 'Web Booking'
                ]
            ]
        ]
    ];
    
    // Add patient contact info as extension
    if (!empty($appointmentData['email']) || !empty($appointmentData['phone'])) {
        $appointment['extension'] = [];
        
        if (!empty($appointmentData['email'])) {
            $appointment['extension'][] = [
                'url' => 'http://epa-bienestar.com.ar/fhir/StructureDefinition/patient-email',
                'valueString' => $appointmentData['email']
            ];
        }
        
        if (!empty($appointmentData['phone'])) {
            $appointment['extension'][] = [
                'url' => 'http://epa-bienestar.com.ar/fhir/StructureDefinition/patient-phone',
                'valueString' => $appointmentData['phone']
            ];
        }
    }
    
    // Create appointment in Medplum
    $ch = curl_init(MEDPLUM_BASE_URL . '/Appointment');
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($appointment));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/fhir+json',
        'Accept: application/fhir+json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 201 || $httpCode === 200) {
        $result = json_decode($response, true);
        return $result['id'] ?? null;
    } else {
        throw new Exception('Error creando Appointment en Medplum: ' . $response);
    }
}

// ============================================================================
// GOOGLE FUNCTIONS
// ============================================================================

/**
 * Generate Google JWT Token
 */
function generateGoogleJWT() {
    $now = time();
    
    $header = json_encode([
        'alg' => 'RS256',
        'typ' => 'JWT'
    ]);
    
    $claim = json_encode([
        'iss' => GOOGLE_SERVICE_ACCOUNT_EMAIL,
        'scope' => 'https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/spreadsheets',
        'aud' => 'https://oauth2.googleapis.com/token',
        'exp' => $now + 3600,
        'iat' => $now
    ]);
    
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlClaim = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($claim));
    
    $signature = '';
    openssl_sign(
        $base64UrlHeader . "." . $base64UrlClaim,
        $signature,
        GOOGLE_PRIVATE_KEY,
        OPENSSL_ALGO_SHA256
    );
    
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
    return $base64UrlHeader . "." . $base64UrlClaim . "." . $base64UrlSignature;
}

/**
 * Get Google Access Token
 */
function getGoogleAccessToken() {
    $jwt = generateGoogleJWT();
    
    $ch = curl_init('https://oauth2.googleapis.com/token');
    
    $data = [
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt
    ];
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        return $result['access_token'] ?? null;
    }
    
    return null;
}

/**
 * Create Google Calendar Event
 */
function createCalendarEvent($appointmentData, $fhirAppointmentId) {
    $token = getGoogleAccessToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Google');
    }
    
    $startDateTime = new DateTime($appointmentData['datetime'], new DateTimeZone(TIMEZONE));
    $endDateTime = clone $startDateTime;
    $endDateTime->add(new DateInterval('PT' . APPOINTMENT_DURATION_MINUTES . 'M'));
    
    $event = [
        'summary' => DOCTOR_NAME . ' - ' . $appointmentData['patient_name'],
        'description' => "Tipo: " . ucfirst($appointmentData['type']) . "\n" .
                        "Motivo: " . $appointmentData['reason'] . "\n" .
                        "Email: " . $appointmentData['email'] . "\n" .
                        "Teléfono: " . $appointmentData['phone'] . "\n" .
                        "DNI: " . $appointmentData['dni'] . "\n" .
                        "FHIR ID: " . $fhirAppointmentId,
        'start' => [
            'dateTime' => $startDateTime->format('c'),
            'timeZone' => TIMEZONE
        ],
        'end' => [
            'dateTime' => $endDateTime->format('c'),
            'timeZone' => TIMEZONE
        ],
        'attendees' => [
            ['email' => $appointmentData['email']]
        ],
        'reminders' => [
            'useDefault' => false,
            'overrides' => [
                ['method' => 'email', 'minutes' => 24 * 60], // 1 day before
                ['method' => 'popup', 'minutes' => 60]  // 1 hour before
            ]
        ]
    ];
    
    if (!empty($appointmentData['comments'])) {
        $event['description'] .= "\n\nComentarios: " . $appointmentData['comments'];
    }
    
    $ch = curl_init('https://www.googleapis.com/calendar/v3/calendars/' . urlencode(GOOGLE_CALENDAR_ID) . '/events');
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($event));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $result = json_decode($response, true);
        return $result['id'] ?? null;
    } else {
        throw new Exception('Error creando evento en Calendar: ' . $response);
    }
}

/**
 * Add to Google Sheets
 */
function addToGoogleSheet($appointmentData, $fhirAppointmentId, $calendarEventId) {
    $token = getGoogleAccessToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Google');
    }
    
    $values = [
        [
            date('Y-m-d H:i:s'), // Timestamp
            $appointmentData['patient_name'],
            $appointmentData['dni'],
            $appointmentData['email'],
            $appointmentData['phone'],
            DOCTOR_NAME,
            date('Y-m-d', strtotime($appointmentData['datetime'])),
            date('H:i', strtotime($appointmentData['datetime'])),
            ucfirst($appointmentData['type']),
            $appointmentData['reason'],
            'Confirmado',
            $fhirAppointmentId,
            $calendarEventId
        ]
    ];
    
    $body = [
        'values' => $values
    ];
    
    $url = 'https://sheets.googleapis.com/v4/spreadsheets/' . GOOGLE_SHEET_ID . '/values/A:M:append';
    $url .= '?valueInputOption=RAW&insertDataOption=INSERT_ROWS';
    
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        throw new Exception('Error agregando a Google Sheets: ' . $response);
    }
    
    return true;
}

// ============================================================================
// AVAILABILITY FUNCTIONS
// ============================================================================

/**
 * Generate available time slots for next 30 days
 */
function getAvailableSlots() {
    global $DOCTOR_SCHEDULE;
    
    $slots = [];
    $today = new DateTime('now', new DateTimeZone(TIMEZONE));
    
    // Generate slots for next 30 days
    for ($i = 0; $i < 30; $i++) {
        $date = clone $today;
        $date->add(new DateInterval('P' . $i . 'D'));
        
        $dayOfWeek = strtolower($date->format('l'));
        
        if (isset($DOCTOR_SCHEDULE[$dayOfWeek])) {
            $schedule = $DOCTOR_SCHEDULE[$dayOfWeek];
            
            $startTime = new DateTime($date->format('Y-m-d') . ' ' . $schedule['start'], new DateTimeZone(TIMEZONE));
            $endTime = new DateTime($date->format('Y-m-d') . ' ' . $schedule['end'], new DateTimeZone(TIMEZONE));
            
            $currentSlot = clone $startTime;
            
            while ($currentSlot < $endTime) {
                if ($currentSlot > $today) { // Only future slots
                    $slots[] = [
                        'datetime' => $currentSlot->format('c'),
                        'display' => $currentSlot->format('l d/m/Y - H:i') . 'hs'
                    ];
                }
                
                $currentSlot->add(new DateInterval('PT' . APPOINTMENT_DURATION_MINUTES . 'M'));
            }
        }
    }
    
    return $slots;
}

// ============================================================================
// FORM PROCESSING
// ============================================================================

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $required = ['patient_id', 'patient_name', 'dni', 'email', 'phone', 'appointment_type', 'appointment_datetime', 'reason'];
        
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception('Campo requerido faltante: ' . $field);
            }
        }
        
        // Prepare appointment data
        $appointmentData = [
            'patient_name' => trim($_POST['patient_name']),
            'dni' => trim($_POST['dni']),
            'email' => trim($_POST['email']),
            'phone' => trim($_POST['phone']),
            'type' => $_POST['appointment_type'],
            'datetime' => $_POST['appointment_datetime'],
            'reason' => trim($_POST['reason']),
            'comments' => trim($_POST['comments'] ?? '')
        ];
        
        $patientId = trim($_POST['patient_id']);
        
        // Step 1: Create FHIR Appointment
        $fhirAppointmentId = createFHIRAppointment($patientId, $appointmentData);
        
        if (!$fhirAppointmentId) {
            throw new Exception('Error al crear el turno en el sistema');
        }
        
        // Step 2: Create Google Calendar Event
        $calendarEventId = createCalendarEvent($appointmentData, $fhirAppointmentId);
        
        // Step 3: Add to Google Sheets
        addToGoogleSheet($appointmentData, $fhirAppointmentId, $calendarEventId);
        
        $response['success'] = true;
        $response['message'] = '¡Turno confirmado exitosamente!';
        $response['appointment_id'] = $fhirAppointmentId;
        
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    // Return JSON response for AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Get available slots for dropdown
$availableSlots = getAvailableSlots();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Turno - EPA Bienestar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .doctor-info {
            background: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #667eea;
            margin: 20px;
            border-radius: 8px;
        }
        
        .doctor-info h3 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .doctor-info p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .required {
            color: #dc3545;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .container {
                border-radius: 0;
            }
            
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏥 Solicitar Turno</h1>
            <p>EPA Bienestar - Sistema de Turnos Online</p>
        </div>
        
        <div class="doctor-info">
            <h3>👨‍⚕️ <?php echo DOCTOR_NAME; ?></h3>
            <p><strong>Especialidad:</strong> Cardiología</p>
            <p><strong>Disponibilidad:</strong> Jueves de 14:00 a 17:00hs</p>
            <p><strong>Duración:</strong> <?php echo APPOINTMENT_DURATION_MINUTES; ?> minutos</p>
        </div>
        
        <div class="form-container">
            <?php if (isset($response['message']) && !empty($response['message'])): ?>
                <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-error'; ?>" style="display: block;">
                    <?php echo htmlspecialchars($response['message']); ?>
                    <?php if ($response['success']): ?>
                        <br><br><strong>ID del turno:</strong> <?php echo htmlspecialchars($response['appointment_id']); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <form id="appointmentForm" method="POST" action="">
                <!-- Patient ID (hidden - viene de sesión/login) -->
                <input type="hidden" name="patient_id" value="PATIENT_FHIR_ID_AQUI">
                
                <div class="form-group">
                    <label>Nombre Completo <span class="required">*</span></label>
                    <input type="text" name="patient_name" required placeholder="Juan Pérez">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>DNI <span class="required">*</span></label>
                        <input type="text" name="dni" required placeholder="12345678">
                    </div>
                    
                    <div class="form-group">
                        <label>Teléfono <span class="required">*</span></label>
                        <input type="tel" name="phone" required placeholder="+54 11 1234-5678">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" required placeholder="ejemplo@email.com">
                </div>
                
                <div class="form-group">
                    <label>Tipo de Consulta <span class="required">*</span></label>
                    <select name="appointment_type" required>
                        <option value="">Seleccione una opción</option>
                        <option value="telemedicina">Telemedicina</option>
                        <option value="segunda_opinion">Segunda Opinión</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Fecha y Hora del Turno <span class="required">*</span></label>
                    <select name="appointment_datetime" required>
                        <option value="">Seleccione fecha y hora</option>
                        <?php foreach ($availableSlots as $slot): ?>
                            <option value="<?php echo htmlspecialchars($slot['datetime']); ?>">
                                <?php echo htmlspecialchars($slot['display']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Motivo de Consulta <span class="required">*</span></label>
                    <textarea name="reason" required placeholder="Describa brevemente el motivo de su consulta"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Comentarios Adicionales (Opcional)</label>
                    <textarea name="comments" placeholder="Antecedentes, medicación actual, etc."></textarea>
                </div>
                
                <button type="submit" class="btn-submit">
                    📅 Confirmar Turno
                </button>
            </form>
        </div>
    </div>
    
    <script>
        // Form validation and UX enhancements
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-submit');
            btn.textContent = '⏳ Procesando...';
            btn.disabled = true;
        });
        
        // Phone number formatting (Argentina)
        document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0 && !value.startsWith('54')) {
                value = '54' + value;
            }
            e.target.value = '+' + value;
        });
        
        // DNI validation (only numbers)
        document.querySelector('input[name="dni"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>

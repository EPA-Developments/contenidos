<?php
/**
 * EPA Bienestar - Evaluación Inicial con FHIR R4
 * Prototipo MVP para validar integración con Medplum
 *
 * @author Alejandro D'Alessandro
 * @version 1.0 MVP
 */

// ============================================================================
// CONFIGURACIÓN
// ============================================================================

// Medplum Configuration
define('MEDPLUM_BASE_URL', 'https://api.epa-bienestar.com.ar/fhir/R4');
define('MEDPLUM_AUTH_URL', 'https://api.epa-bienestar.com.ar/oauth2/token');
// Credenciales: fuera del repositorio (include/config.php: variable de entorno o
// epa-config.php fuera de la carpeta pública). Nunca escribirlas acá.
require_once __DIR__ . '/include/config.php';
define('MEDPLUM_CLIENT_ID', epa_config('MEDPLUM_CLIENT_ID') ?? '');
define('MEDPLUM_CLIENT_SECRET', epa_config('MEDPLUM_CLIENT_SECRET') ?? '');
define('MEDPLUM_PROJECT_ID', '79679343-1b6e-47b9-bee7-32929111451d');

// Doctor Configuration
define('PRACTITIONER_ID', '01963669-5948-744d-9895-756c2494b912');
define('DOCTOR_NAME', 'Dr. Alejandro Sergio D\'Alessandro');
define('APPOINTMENT_DURATION_MINUTES', 20);
define('TIMEZONE', 'America/Argentina/Buenos_Aires');

// Errores: al log, nunca en pantalla (pueden mostrar rutas, URLs o respuestas del servidor).
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
date_default_timezone_set(TIMEZONE);

// ============================================================================
// MEDPLUM AUTHENTICATION
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

// ============================================================================
// PATIENT FUNCTIONS
// ============================================================================

/**
 * Search for existing patient by DNI
 */
function findPatientByDNI($dni) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }

    // Search for patient with DNI identifier
    $searchUrl = MEDPLUM_BASE_URL . '/Patient?identifier=http://www.renaper.gob.ar/dni|' . urlencode($dni);

    $ch = curl_init($searchUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Accept: application/fhir+json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $bundle = json_decode($response, true);
        if (isset($bundle['entry']) && count($bundle['entry']) > 0) {
            // Patient found, return first match
            return $bundle['entry'][0]['resource']['id'];
        }
    }

    return null;
}

/**
 * Create new FHIR Patient Resource
 */
function createPatient($patientData) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }

    // Build FHIR Patient Resource
    $patient = [
        'resourceType' => 'Patient',
        'identifier' => [
            [
                'system' => 'http://www.renaper.gob.ar/dni',
                'value' => $patientData['dni']
            ]
        ],
        'name' => [
            [
                'use' => 'official',
                'text' => $patientData['nombre_completo'],
                'family' => $patientData['apellido'] ?? '',
                'given' => explode(' ', $patientData['nombre'] ?? $patientData['nombre_completo'])
            ]
        ],
        'telecom' => [
            [
                'system' => 'phone',
                'value' => $patientData['telefono'],
                'use' => 'mobile'
            ],
            [
                'system' => 'email',
                'value' => $patientData['email'],
                'use' => 'home'
            ]
        ],
        'gender' => strtolower($patientData['sexo'] ?? 'unknown'),
        'birthDate' => $patientData['fecha_nacimiento'] ?? null,
        'active' => true,
        'meta' => [
            'tag' => [
                [
                    'system' => 'http://epa-bienestar.com.ar/tags',
                    'code' => 'evaluacion-inicial',
                    'display' => 'Evaluación Inicial'
                ]
            ]
        ]
    ];

    // Remove null birthDate if not provided
    if (empty($patient['birthDate'])) {
        unset($patient['birthDate']);
    }

    // Create patient in Medplum
    $ch = curl_init(MEDPLUM_BASE_URL . '/Patient');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($patient));
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
        throw new Exception('Error creando Patient en Medplum: ' . $response);
    }
}

/**
 * Find or Create Patient by DNI
 */
function findOrCreatePatient($patientData) {
    // First, try to find existing patient
    $patientId = findPatientByDNI($patientData['dni']);

    if ($patientId) {
        return [
            'id' => $patientId,
            'status' => 'existing',
            'message' => 'Paciente existente encontrado'
        ];
    }

    // If not found, create new patient
    $patientId = createPatient($patientData);

    return [
        'id' => $patientId,
        'status' => 'created',
        'message' => 'Nuevo paciente creado'
    ];
}

// ============================================================================
// APPOINTMENT FUNCTIONS
// ============================================================================

/**
 * Create FHIR Appointment Resource
 */
function createAppointment($patientId, $appointmentData) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }

    // Calculate appointment datetime (next available Thursday 14:00)
    $now = new DateTime('now', new DateTimeZone(TIMEZONE));
    $daysUntilThursday = (4 - $now->format('N') + 7) % 7;
    if ($daysUntilThursday === 0 && $now->format('H') >= 14) {
        $daysUntilThursday = 7; // Next week if today is Thursday after 2pm
    }

    $appointmentDate = clone $now;
    $appointmentDate->add(new DateInterval('P' . $daysUntilThursday . 'D'));
    $appointmentDate->setTime(14, 0, 0);

    // Build FHIR Appointment Resource
    $appointment = [
        'resourceType' => 'Appointment',
        'status' => 'proposed',
        'serviceType' => [
            [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/service-type',
                        'code' => '124',
                        'display' => 'General Practice'
                    ]
                ],
                'text' => 'Evaluación Cardiovascular Inicial'
            ]
        ],
        'appointmentType' => [
            'coding' => [
                [
                    'system' => 'http://terminology.hl7.org/CodeSystem/v2-0276',
                    'code' => 'ROUTINE',
                    'display' => 'Routine appointment'
                ]
            ]
        ],
        'reasonCode' => [
            [
                'text' => 'Evaluación Inicial - Life\'s Essential 8'
            ]
        ],
        'description' => 'Evaluación cardiovascular inicial con medición de Life\'s Essential 8',
        'start' => $appointmentDate->format('c'),
        'end' => $appointmentDate->add(new DateInterval('PT' . APPOINTMENT_DURATION_MINUTES . 'M'))->format('c'),
        'created' => date('c'),
        'comment' => $appointmentData['comentarios'] ?? '',
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
                    'code' => 'evaluacion-inicial',
                    'display' => 'Evaluación Inicial'
                ]
            ]
        ]
    ];

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
        return [
            'id' => $result['id'] ?? null,
            'datetime' => $appointmentDate->format('d/m/Y H:i')
        ];
    } else {
        throw new Exception('Error creando Appointment en Medplum: ' . $response);
    }
}

// ============================================================================
// OBSERVATION FUNCTIONS (Life's Essential 8)
// ============================================================================

/**
 * Create Blood Pressure Observation (LOINC 55284-4)
 */
function createBloodPressureObservation($patientId, $systolic, $diastolic) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }

    $observation = [
        'resourceType' => 'Observation',
        'status' => 'final',
        'category' => [
            [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
                        'code' => 'vital-signs',
                        'display' => 'Vital Signs'
                    ]
                ]
            ]
        ],
        'code' => [
            'coding' => [
                [
                    'system' => 'http://loinc.org',
                    'code' => '55284-4',
                    'display' => 'Blood pressure systolic and diastolic'
                ]
            ],
            'text' => 'Presión Arterial'
        ],
        'subject' => [
            'reference' => "Patient/{$patientId}"
        ],
        'effectiveDateTime' => date('c'),
        'issued' => date('c'),
        'component' => [
            [
                'code' => [
                    'coding' => [
                        [
                            'system' => 'http://loinc.org',
                            'code' => '8480-6',
                            'display' => 'Systolic blood pressure'
                        ]
                    ]
                ],
                'valueQuantity' => [
                    'value' => (float)$systolic,
                    'unit' => 'mmHg',
                    'system' => 'http://unitsofmeasure.org',
                    'code' => 'mm[Hg]'
                ]
            ],
            [
                'code' => [
                    'coding' => [
                        [
                            'system' => 'http://loinc.org',
                            'code' => '8462-4',
                            'display' => 'Diastolic blood pressure'
                        ]
                    ]
                ],
                'valueQuantity' => [
                    'value' => (float)$diastolic,
                    'unit' => 'mmHg',
                    'system' => 'http://unitsofmeasure.org',
                    'code' => 'mm[Hg]'
                ]
            ]
        ],
        'meta' => [
            'tag' => [
                [
                    'system' => 'http://epa-bienestar.com.ar/tags',
                    'code' => 'life-essential-8',
                    'display' => 'Life\'s Essential 8'
                ]
            ]
        ]
    ];

    return createObservation($observation);
}

/**
 * Create HbA1c Observation (LOINC 4548-4)
 */
function createHbA1cObservation($patientId, $hba1c) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }

    $observation = [
        'resourceType' => 'Observation',
        'status' => 'final',
        'category' => [
            [
                'coding' => [
                    [
                        'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
                        'code' => 'laboratory',
                        'display' => 'Laboratory'
                    ]
                ]
            ]
        ],
        'code' => [
            'coding' => [
                [
                    'system' => 'http://loinc.org',
                    'code' => '4548-4',
                    'display' => 'Hemoglobin A1c/Hemoglobin.total in Blood'
                ]
            ],
            'text' => 'Hemoglobina Glicosilada (HbA1c)'
        ],
        'subject' => [
            'reference' => "Patient/{$patientId}"
        ],
        'effectiveDateTime' => date('c'),
        'issued' => date('c'),
        'valueQuantity' => [
            'value' => (float)$hba1c,
            'unit' => '%',
            'system' => 'http://unitsofmeasure.org',
            'code' => '%'
        ],
        'meta' => [
            'tag' => [
                [
                    'system' => 'http://epa-bienestar.com.ar/tags',
                    'code' => 'life-essential-8',
                    'display' => 'Life\'s Essential 8'
                ]
            ]
        ]
    ];

    return createObservation($observation);
}

/**
 * Generic function to create any Observation resource
 */
function createObservation($observation) {
    $token = getMedplumToken();
    if (!$token) {
        throw new Exception('No se pudo obtener token de Medplum');
    }

    $ch = curl_init(MEDPLUM_BASE_URL . '/Observation');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($observation));
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
        throw new Exception('Error creando Observation en Medplum: ' . $response);
    }
}

// ============================================================================
// FORM PROCESSING
// ============================================================================

$response = ['success' => false, 'message' => '', 'data' => []];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        $required = ['nombre_completo', 'dni', 'email', 'telefono', 'sexo'];

        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception('Campo requerido faltante: ' . $field);
            }
        }

        // Prepare patient data
        $patientData = [
            'nombre_completo' => trim($_POST['nombre_completo']),
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido' => trim($_POST['apellido'] ?? ''),
            'dni' => trim($_POST['dni']),
            'email' => trim($_POST['email']),
            'telefono' => trim($_POST['telefono']),
            'sexo' => $_POST['sexo'],
            'fecha_nacimiento' => !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null
        ];

        // Step 1: Find or Create Patient
        $patientResult = findOrCreatePatient($patientData);
        $response['data']['patient'] = $patientResult;

        if (!$patientResult['id']) {
            throw new Exception('Error al crear o buscar el paciente');
        }

        // Step 2: Create Appointment
        $appointmentData = [
            'patient_name' => $patientData['nombre_completo'],
            'comentarios' => trim($_POST['comentarios'] ?? '')
        ];

        $appointmentResult = createAppointment($patientResult['id'], $appointmentData);
        $response['data']['appointment'] = $appointmentResult;

        // Step 3: Create Observations (if data provided)
        $observations = [];

        // Blood Pressure
        if (!empty($_POST['presion_sistolica']) && !empty($_POST['presion_diastolica'])) {
            $bpId = createBloodPressureObservation(
                $patientResult['id'],
                $_POST['presion_sistolica'],
                $_POST['presion_diastolica']
            );
            $observations[] = [
                'type' => 'Blood Pressure',
                'id' => $bpId,
                'value' => $_POST['presion_sistolica'] . '/' . $_POST['presion_diastolica'] . ' mmHg'
            ];
        }

        // HbA1c
        if (!empty($_POST['hba1c'])) {
            $hba1cId = createHbA1cObservation(
                $patientResult['id'],
                $_POST['hba1c']
            );
            $observations[] = [
                'type' => 'HbA1c',
                'id' => $hba1cId,
                'value' => $_POST['hba1c'] . '%'
            ];
        }

        $response['data']['observations'] = $observations;

        $response['success'] = true;
        $response['message'] = '¡Evaluación inicial registrada exitosamente!';

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

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Inicial - EPA Bienestar</title>
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
            max-width: 800px;
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

        .info-box {
            background: #f0f7ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px;
            border-radius: 8px;
        }

        .info-box h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .info-box p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .form-container {
            padding: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e0e0e0;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .form-section h2 {
            color: #667eea;
            font-size: 20px;
            margin-bottom: 20px;
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
        input[type="date"],
        input[type="number"],
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

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
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

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .required {
            color: #dc3545;
        }

        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .result-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .result-box h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .result-box ul {
            list-style: none;
            padding-left: 0;
        }

        .result-box li {
            padding: 5px 0;
            color: #666;
        }

        .result-box li strong {
            color: #333;
        }

        @media (max-width: 768px) {
            .form-row,
            .form-row-3 {
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
            <h1>🏥 Evaluación Inicial Cardiovascular</h1>
            <p>EPA Bienestar - Integración FHIR R4 con Medplum</p>
            <p style="margin-top: 10px; font-size: 12px; opacity: 0.8;">Prototipo MVP - Life's Essential 8</p>
        </div>

        <div class="info-box">
            <h3>ℹ️ Sobre esta evaluación</h3>
            <p>Esta es una <strong>evaluación inicial de prueba</strong> para validar la integración con la API FHIR R4 de Medplum. Los datos ingresados serán:</p>
            <ul style="margin-top: 10px; margin-left: 20px;">
                <li>✓ Creados como recurso <code>Patient</code> (o vinculados si ya existe por DNI)</li>
                <li>✓ Asociados a un <code>Appointment</code> automático</li>
                <li>✓ Guardados como <code>Observations</code> con códigos LOINC estándar</li>
            </ul>
        </div>

        <div class="form-container">
            <?php if (isset($response['message']) && !empty($response['message'])): ?>
                <div class="alert <?php echo $response['success'] ? 'alert-success' : 'alert-error'; ?>" style="display: block;">
                    <?php echo htmlspecialchars($response['message']); ?>

                    <?php if ($response['success'] && !empty($response['data'])): ?>
                        <div class="result-box">
                            <h4>📋 Resultados de la integración:</h4>
                            <ul>
                                <li><strong>Patient:</strong>
                                    <?php echo htmlspecialchars($response['data']['patient']['status']); ?>
                                    (ID: <?php echo htmlspecialchars($response['data']['patient']['id']); ?>)
                                </li>
                                <li><strong>Appointment:</strong>
                                    <?php echo htmlspecialchars($response['data']['appointment']['datetime']); ?>
                                    (ID: <?php echo htmlspecialchars($response['data']['appointment']['id']); ?>)
                                </li>
                                <?php if (!empty($response['data']['observations'])): ?>
                                    <li><strong>Observations creadas:</strong>
                                        <ul style="margin-left: 20px; margin-top: 5px;">
                                            <?php foreach ($response['data']['observations'] as $obs): ?>
                                                <li><?php echo htmlspecialchars($obs['type']); ?>:
                                                    <?php echo htmlspecialchars($obs['value']); ?>
                                                    (ID: <?php echo htmlspecialchars($obs['id']); ?>)
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <form id="evaluacionForm" method="POST" action="">

                <!-- Datos del Paciente -->
                <div class="form-section">
                    <h2>👤 Datos del Paciente</h2>

                    <div class="form-group">
                        <label>Nombre Completo <span class="required">*</span></label>
                        <input type="text" name="nombre_completo" required placeholder="Juan Pérez">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" placeholder="Juan">
                            <div class="help-text">Opcional - se extrae del nombre completo</div>
                        </div>

                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" name="apellido" placeholder="Pérez">
                            <div class="help-text">Opcional - se extrae del nombre completo</div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>DNI <span class="required">*</span></label>
                            <input type="text" name="dni" required placeholder="12345678" pattern="[0-9]{7,8}">
                            <div class="help-text">Se usa para buscar paciente existente</div>
                        </div>

                        <div class="form-group">
                            <label>Sexo <span class="required">*</span></label>
                            <select name="sexo" required>
                                <option value="">Seleccione</option>
                                <option value="male">Masculino</option>
                                <option value="female">Femenino</option>
                                <option value="other">Otro</option>
                                <option value="unknown">Prefiero no decir</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento">
                            <div class="help-text">Opcional</div>
                        </div>

                        <div class="form-group">
                            <label>Teléfono <span class="required">*</span></label>
                            <input type="tel" name="telefono" required placeholder="+54 11 1234-5678">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required placeholder="ejemplo@email.com">
                    </div>
                </div>

                <!-- Mediciones Life's Essential 8 (MVP: 2 métricas) -->
                <div class="form-section">
                    <h2>🩺 Mediciones Iniciales</h2>
                    <p style="color: #666; font-size: 14px; margin-bottom: 20px;">
                        Complete los datos disponibles. Los campos vacíos se omitirán.
                    </p>

                    <h3 style="font-size: 16px; color: #333; margin-bottom: 15px;">Presión Arterial</h3>
                    <div class="form-row-3">
                        <div class="form-group">
                            <label>Sistólica (mmHg)</label>
                            <input type="number" name="presion_sistolica" placeholder="120" min="70" max="250" step="1">
                        </div>

                        <div class="form-group">
                            <label>Diastólica (mmHg)</label>
                            <input type="number" name="presion_diastolica" placeholder="80" min="40" max="150" step="1">
                        </div>

                        <div style="padding-top: 30px; color: #666; font-size: 12px;">
                            LOINC: 55284-4
                        </div>
                    </div>

                    <h3 style="font-size: 16px; color: #333; margin-bottom: 15px; margin-top: 25px;">Glucosa en Sangre</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>HbA1c (%)</label>
                            <input type="number" name="hba1c" placeholder="5.7" min="3" max="15" step="0.1">
                            <div class="help-text">Hemoglobina Glicosilada - LOINC: 4548-4</div>
                        </div>

                        <div style="padding-top: 30px; color: #666; font-size: 12px;">
                            <strong>Referencia:</strong><br>
                            &lt;5.7% = Normal<br>
                            5.7-6.4% = Prediabetes<br>
                            ≥6.5% = Diabetes
                        </div>
                    </div>
                </div>

                <!-- Comentarios Adicionales -->
                <div class="form-section">
                    <h2>📝 Comentarios</h2>

                    <div class="form-group">
                        <label>Observaciones o Comentarios Adicionales</label>
                        <textarea name="comentarios" placeholder="Antecedentes médicos, medicación actual, alergias, etc."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    🚀 Enviar Evaluación a API FHIR
                </button>

                <div class="alert alert-info" style="display: block; margin-top: 20px;">
                    <strong>ℹ️ Nota:</strong> Esta es una versión de prueba (MVP). Al enviar:
                    <ul style="margin-left: 20px; margin-top: 10px;">
                        <li>Se buscará el paciente por DNI en Medplum</li>
                        <li>Se creará el paciente si no existe</li>
                        <li>Se agendará automáticamente un turno para el próximo jueves a las 14:00hs</li>
                        <li>Se guardarán las observaciones con códigos LOINC estándar</li>
                    </ul>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation and UX enhancements
        document.getElementById('evaluacionForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('.btn-submit');
            btn.textContent = '⏳ Procesando...';
            btn.disabled = true;
        });

        // Phone number formatting (Argentina)
        document.querySelector('input[name="telefono"]').addEventListener('input', function(e) {
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

        // Auto-populate nombre/apellido from nombre_completo
        document.querySelector('input[name="nombre_completo"]').addEventListener('blur', function(e) {
            const nombreCompleto = e.target.value.trim();
            const parts = nombreCompleto.split(' ');

            if (parts.length >= 2 && !document.querySelector('input[name="nombre"]').value) {
                document.querySelector('input[name="nombre"]').value = parts.slice(0, -1).join(' ');
            }

            if (parts.length >= 2 && !document.querySelector('input[name="apellido"]').value) {
                document.querySelector('input[name="apellido"]').value = parts[parts.length - 1];
            }
        });
    </script>
</body>
</html>

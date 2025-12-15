<?php
// Configuración
$fhirBaseUrl = 'https://api.epa-bienestar.com.ar/fhir/r4';
$accessToken = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjAxOTYzNjVjLWM3MjEtNzE3Ny1hNDE4LTU0MjQwZWJlNmNkYiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRfaWQiOiIxODhkMTQ3Yy1hMzk3LTQ4MmUtODk4ZS05MjhmYmQ0NDUzMjEiLCJsb2dpbl9pZCI6IjQxNzVhYzkxLWYxZmEtNDZlNy1hZTJjLTcyZDg3OTQwOWFjZCIsInN1YiI6IjE4OGQxNDdjLWEzOTctNDgyZS04OThlLTkyOGZiZDQ0NTMyMSIsInVzZXJuYW1lIjoiMTg4ZDE0N2MtYTM5Ny00ODJlLTg5OGUtOTI4ZmJkNDQ1MzIxIiwic2NvcGUiOiJvcGVuaWQiLCJwcm9maWxlIjoiQ2xpZW50QXBwbGljYXRpb24vMTg4ZDE0N2MtYTM5Ny00ODJlLTg5OGUtOTI4ZmJkNDQ1MzIxIiwiaWF0IjoxNzY1MjM2NTIzLCJpc3MiOiJodHRwczovL2FwaS5lcGEtYmllbmVzdGFyLmNvbS5hci8iLCJhdWQiOiIxODhkMTQ3Yy1hMzk3LTQ4MmUtODk4ZS05MjhmYmQ0NDUzMjEiLCJleHAiOjE3NjUyNDAxMjN9.LRtjARVmdd9aJdLd8xwh8IUPSpffZ2M25JATvRMJu2dl3IuBdKUYuq50O1_trreQb5xSlVNlrHysAMhW_yVfX3UhW4zJPawWEOzRGc9kx-11CcApOjd6ZSoKg1jdVdadrVRWqlGlmbSWbuIGf7aOnvKQ-1et5xAXf7dk2u5ehrf2lSt_fNpE8RHCkSiUNWd6ZA2VxPCUJu6zvZDwcW2H4axg7tn0aCiYXMsSDd726puHzTLrvtqexK0ZdaFGt_1frWl-fTqfWa5cZzeBA3LKhTrW-PQQNpvSPNIq2cLgTF0GRcqVuB-iA7LDxuO5I_xxAhiL4apFHlj7UFBH-wyCDQ'; // O null si tu servidor permite acceso público

// Función para obtener practitioners
function getPractitioners($baseUrl, $token = null) {
    $ch = curl_init($baseUrl . '/Practitioner?_count=100&active=true');
    
    $headers = ['Accept: application/fhir+json'];
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => true
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        return json_decode($response, true);
    }
    
    return null;
}

$bundle = getPractitioners($fhirBaseUrl, $accessToken);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesionales - EPA Bienestar</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        .practitioners-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .practitioner-card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .practitioner-card h3 { color: #2563eb; margin-bottom: 10px; }
        .practitioner-card p { color: #666; margin: 5px 0; }
        .specialty { display: inline-block; background: #e0f2fe; color: #0369a1; padding: 4px 12px; border-radius: 12px; font-size: 14px; margin-top: 8px; }
        .error { background: #fee; color: #c00; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Profesionales de Salud</h1>
        
        <?php if ($bundle && isset($bundle['entry'])): ?>
            <div class="practitioners-grid">
                <?php foreach ($bundle['entry'] as $entry): 
                    $practitioner = $entry['resource'];
                    $name = $practitioner['name'][0] ?? [];
                    $fullName = ($name['prefix'][0] ?? '') . ' ' . 
                                ($name['given'][0] ?? '') . ' ' . 
                                ($name['family'] ?? '');
                ?>
                    <div class="practitioner-card">
                        <h3><?= htmlspecialchars(trim($fullName)) ?></h3>
                        
                        <?php if (isset($practitioner['identifier'])): ?>
                            <p><strong>ID:</strong> <?= htmlspecialchars($practitioner['identifier'][0]['value'] ?? '') ?></p>
                        <?php endif; ?>
                        
                        <?php if (isset($practitioner['telecom'])): 
                            foreach ($practitioner['telecom'] as $telecom): 
                                if ($telecom['system'] === 'email'): ?>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($telecom['value']) ?></p>
                                <?php elseif ($telecom['system'] === 'phone'): ?>
                                    <p><strong>Teléfono:</strong> <?= htmlspecialchars($telecom['value']) ?></p>
                                <?php endif;
                            endforeach;
                        endif; ?>
                        
                        <?php if (isset($practitioner['qualification'])): 
                            foreach ($practitioner['qualification'] as $qual): ?>
                                <span class="specialty"><?= htmlspecialchars($qual['code']['text'] ?? $qual['code']['coding'][0]['display'] ?? 'Especialidad') ?></span>
                            <?php endforeach;
                        endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="error">
                <strong>Error:</strong> No se pudieron cargar los profesionales. Verifica la conexión al servidor FHIR.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

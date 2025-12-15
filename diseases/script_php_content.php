<?php
// migrate_content_to_fhir.php

$medplumUrl = 'https://api.epa-bienestar.com.ar/fhir/r4';
$accessToken = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjAxOTYzNjVjLWM3MjEtNzE3Ny1hNDE4LTU0MjQwZWJlNmNkYiIsInR5cCI6IkpXVCJ9.eyJjbGllbnRfaWQiOiIwMTk3NjAwZS1mNDhiLTc2ZmUtOTZiOC0xMGU3YjNjZTI4MDMiLCJsb2dpbl9pZCI6ImRmZGExODhkLTdlZDUtNDljYS04ZDAyLTIwMjkyNWJjNDEwMSIsInN1YiI6IjAxOTc2MDBlLWY0OGItNzZmZS05NmI4LTEwZTdiM2NlMjgwMyIsInVzZXJuYW1lIjoiMDE5NzYwMGUtZjQ4Yi03NmZlLTk2YjgtMTBlN2IzY2UyODAzIiwic2NvcGUiOiJvcGVuaWQiLCJwcm9maWxlIjoiQ2xpZW50QXBwbGljYXRpb24vMDE5NzYwMGUtZjQ4Yi03NmZlLTk2YjgtMTBlN2IzY2UyODAzIiwiaWF0IjoxNzY1NzYxMTExLCJuYmYiOjE3NjU3NjExMTEsImlzcyI6Imh0dHBzOi8vYXBpLmVwYS1iaWVuZXN0YXIuY29tLmFyLyIsImF1ZCI6IjAxOTc2MDBlLWY0OGItNzZmZS05NmI4LTEwZTdiM2NlMjgwMyIsImV4cCI6MTc2NTc2NDcxMX0.uFXLsqS6buEiPD5gafsT-X3fyv33K3EeNsxMeuwRBDIOTBRfatJ_m1Ynfq0iSGm-wDhWaQAf92GU_wrZVp5dulxDYPD-2E2udPyGZJF7AldUfJpuLTTwMHDgG5mh9LLcArF2DnafiaHDCmufeNEUrcniJSWZKiMDct4I8hemCdliz7cIczcbze-taARFa_huuCKDecoNaSMFeQEeTuwNhD7cxREnYOwNgvmxIOEHshpHe5OKlru1HGUsCgtJucz3nzs_x0snvE8GynMoYwahn6M3K-urFFHrJXA9glmoTO9hspJyGSQtovcdglAmg-LUsCwGlXCR1DzD_h4SwGer8Q';

// Lista de tus artículos PHP
$articles = [
    [
        'file' => 'hypertension.php',
        'title' => 'Hypertension: Guide',
        'category' => 'Hypertension',
        'keywords' => ['blood pressure', 'HTN', 'cardiovascular']
    ],
    [
        'file' => 'life-essential-8.php',
        'title' => 'Life\'s Essential 8 - AHA',
        'category' => 'prevencion',
        'keywords' => ['LE8', 'AHA', 'métricas']
    ],
    // ... más artículos
];

function createDocumentReference($article, $medplumUrl, $token) {
    // Leer contenido HTML del archivo PHP
    $htmlContent = file_get_contents($article['file']);
    
    // Convertir a base64
    $base64Content = base64_encode($htmlContent);
    
    // Crear recurso DocumentReference
    $documentReference = [
        'resourceType' => 'DocumentReference',
        'status' => 'current',
        'type' => [
            'coding' => [[
                'system' => 'http://loinc.org',
                'code' => '34133-9',
                'display' => 'Summary of episode note'
            ]],
            'text' => 'Contenido Educativo Cardiovascular'
        ],
        'category' => [[
            'coding' => [[
                'system' => 'http://epa-bienestar.com.ar/fhir/CodeSystem/content-category',
                'code' => $article['category'],
                'display' => ucfirst($article['category'])
            ]]
        ]],
        'subject' => null, // Contenido general, no específico de paciente
        'date' => date('c'),
        'author' => [[
            'reference' => 'Organization/epa-bienestar',
            'display' => 'EPA Bienestar IA'
        ]],
        'description' => $article['title'],
        'content' => [[
            'attachment' => [
                'contentType' => 'text/html',
                'language' => 'es-AR',
                'data' => $base64Content,
                'title' => $article['title'],
                'creation' => date('c')
            ]
        ]],
        'context' => [
            'related' => array_map(function($keyword) {
                return [
                    'reference' => 'SearchParameter/' . urlencode($keyword)
                ];
            }, $article['keywords'])
        ]
    ];
    
    // POST a Medplum
    $ch = curl_init($medplumUrl . '/DocumentReference');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($documentReference));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/fhir+json',
        'Authorization: Bearer ' . $token
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'success' => $httpCode == 201,
        'response' => json_decode($response, true)
    ];
}

// Migrar todos los artículos
foreach ($articles as $article) {
    $result = createDocumentReference($article, $medplumUrl, $accessToken);
    echo "Artículo: {$article['title']} - ";
    echo $result['success'] ? "✓ Creado\n" : "✗ Error\n";
}
?>

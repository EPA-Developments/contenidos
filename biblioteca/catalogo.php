<?php
/**
 * Catálogo de la Biblioteca CKM-LE8, para reutilizar los contenidos en el ecosistema
 * (App, Dashboard, Recepción y Plan Bienestar 100 Días® de SOM).
 *
 *   /biblioteca/catalogo                 → JSON propio (todo)
 *   /biblioteca/catalogo?formato=fhir    → Bundle FHIR R4 (collection) de DocumentReference
 *   Filtros (se combinan): ?le8=presion  ?ckm=2  ?tipo=evidencia
 *
 * Ejemplo: el Dashboard muestra el material de la métrica LE8 más baja del paciente con
 * ?le8=<métrica>; el Plan Bienestar 100 Días, el de su estadío CKM con ?ckm=<estadío>.
 * Solo lectura y sin datos de pacientes.
 */
require __DIR__ . '/_biblioteca.php';

$items = array_merge(array_values(biblioteca_articulos()), biblioteca_paginas_le8());

$filtro = function (string $clave): ?string {
    $v = isset($_GET[$clave]) ? strtolower(trim((string) $_GET[$clave])) : '';
    return $v !== '' ? preg_replace('/[^a-z0-9-]/', '', $v) : null;
};
$le8 = $filtro('le8');
$ckm = $filtro('ckm');
$tipo = $filtro('tipo');
$items = array_values(array_filter($items, function ($a) use ($le8, $ckm, $tipo) {
    if ($le8 !== null && !in_array($le8, $a['le8'] ?? [], true)) {
        return false;
    }
    if ($ckm !== null && !in_array($ckm, array_map('strval', $a['ckm'] ?? []), true)) {
        return false;
    }
    return $tipo === null || ($a['tipo'] ?? '') === $tipo;
}));

$opciones = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT;
header('Cache-Control: public, max-age=3600');

if (($filtro('formato') ?? 'json') === 'fhir') {
    header('Content-Type: application/fhir+json; charset=utf-8');
    echo json_encode([
        'resourceType' => 'Bundle',
        'type' => 'collection',
        'timestamp' => date('c'),
        'entry' => array_map(function ($a) {
            return ['resource' => biblioteca_document_reference($a)];
        }, $items),
    ], $opciones);
    return;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'version' => 1,
    'fuente' => BIBLIOTECA_URL,
    'generado' => date('c'),
    'total' => count($items),
    'contenidos' => array_map('biblioteca_item', $items),
], $opciones);

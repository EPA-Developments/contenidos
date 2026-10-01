<?php
// Biblioteca CKM-LE8 · Insuficiencia cardíaca y pre-insuficiencia cardíaca
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'insuficiencia-cardiaca',
    'orden' => 25,
    'tipo' => 'condicion',
    'titulo' => 'Insuficiencia cardíaca y pre-insuficiencia cardíaca',
    'resumen' => 'Los estadíos de la insuficiencia cardíaca, cómo se detecta la pre-insuficiencia antes de los síntomas y qué tratamientos cambian el pronóstico.',
    'le8' => [
        'presion',
        'glucosa',
        'imc',
    ],
    'ckm' => [
        3,
        4,
    ],
    'claves' => [
        'La insuficiencia cardíaca se puede detectar antes de los síntomas: es la pre-insuficiencia cardíaca, un criterio del estadío 3 del síndrome CKM.',
        'Se busca con péptidos natriuréticos (BNP o NT-proBNP), troponina y ecocardiograma.',
        'Los síntomas típicos son falta de aire, cansancio e hinchazón de piernas.',
        'Con la fracción de eyección reducida, cuatro grupos de medicamentos mejoran la supervivencia.',
    ],
    'secciones' => [
        [
            'titulo' => 'Los estadíos',
            'html' => '<table class="biblio-tabla">
<tr><th>Estadío</th><th>Qué significa</th></tr>
<tr><td>A</td><td>En riesgo: hipertensión, diabetes, obesidad, enfermedad renal, sin daño del corazón.</td></tr>
<tr><td>B</td><td>Pre-insuficiencia cardíaca: cambios en el corazón o biomarcadores elevados, sin síntomas.</td></tr>
<tr><td>C</td><td>Insuficiencia cardíaca con síntomas actuales o pasados.</td></tr>
<tr><td>D</td><td>Insuficiencia cardíaca avanzada.</td></tr>
</table>
<p>El estadío B corresponde a la pre-insuficiencia cardíaca del estadío 3 del síndrome CKM; los estadíos C y D, al estadío 4.</p>',
        ],
        [
            'titulo' => 'Cómo se detecta la pre-insuficiencia',
            'html' => '<ul>
<li>NT-proBNP ≥ 125 pg/mL o BNP ≥ 35 pg/mL.</li>
<li>Troponina ultrasensible elevada.</li>
<li>Ecocardiograma con alteraciones de la estructura o la función del corazón.</li>
</ul>
<p>La guía CKM 2026 sugiere buscarla cuando el riesgo PREVENT de insuficiencia cardíaca a 10 años es ≥ 5 %. Con enfermedad renal, los péptidos natriuréticos se interpretan con cautela.</p>',
        ],
        [
            'titulo' => 'Síntomas para consultar',
            'html' => '<ul>
<li>Falta de aire al hacer esfuerzos o al acostarte.</li>
<li>Cansancio que no se explica.</li>
<li>Hinchazón de tobillos y piernas, o aumento rápido de peso por retención de líquido.</li>
</ul>',
        ],
        [
            'titulo' => 'Tratamiento',
            'html' => '<p>Con la fracción de eyección reducida (40 % o menos), cuatro grupos de medicamentos mejoran la supervivencia y reducen las internaciones: sacubitril-valsartán (o un IECA o ARA II), betabloqueantes, antagonistas de la aldosterona e inhibidores de SGLT2. Los inhibidores de SGLT2 también se usan con fracción de eyección levemente reducida o preservada. Además: controlar la presión, pesarse a diario y consultar si el peso sube rápido.</p>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Heidenreich PA, et al. 2022 AHA/ACC/HFSA Guideline for the Management of Heart Failure. Circulation. 2022;145:e895–e1032.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001063',
        ],
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'Khan SS, et al. Development and Validation of the American Heart Association\'s PREVENT Equations. Circulation. 2024;149:430–449.',
            'url' => 'https://doi.org/10.1161/CIRCULATIONAHA.123.067626',
        ],
    ],
    'actualizado' => '2026-10-01',
];

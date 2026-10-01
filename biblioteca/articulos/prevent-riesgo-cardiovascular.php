<?php
// Biblioteca CKM-LE8 · Ecuaciones PREVENT: tu riesgo cardiovascular a 10 y 30 años
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'prevent-riesgo-cardiovascular',
    'orden' => 12,
    'tipo' => 'ckm',
    'titulo' => 'Ecuaciones PREVENT: tu riesgo cardiovascular a 10 y 30 años',
    'resumen' => 'Qué calculan las ecuaciones PREVENT de la AHA, qué datos usan y cómo la guía CKM 2026 usa sus resultados para decidir tratamientos.',
    'le8' => [
        'nicotina',
        'imc',
        'colesterol',
        'glucosa',
        'presion',
    ],
    'ckm' => [
        0,
        1,
        2,
        3,
    ],
    'claves' => [
        'PREVENT estima la probabilidad de tener un infarto, un ACV o insuficiencia cardíaca en los próximos 10 y 30 años.',
        'Se usa entre los 30 y los 79 años, en personas sin enfermedad cardiovascular conocida.',
        'Incluye la función renal y la insuficiencia cardíaca, y no usa la raza.',
        'Un riesgo a 10 años ≥ 20 % equivale al estadío 3 del síndrome CKM.',
    ],
    'secciones' => [
        [
            'titulo' => '¿Qué es PREVENT?',
            'html' => '<p>Las ecuaciones PREVENT (<em>Predicting Risk of cardiovascular disease EVENTs</em>) fueron desarrolladas por la American Heart Association con datos de más de 6 millones de adultos de Estados Unidos y publicadas en 2024. La guía CKM 2026 las usa para estimar el riesgo de:</p>
<ul>
<li><strong>Enfermedad cardiovascular total</strong> (ECV).</li>
<li><strong>Enfermedad cardiovascular aterosclerótica</strong> (ASCVD): infarto y ACV.</li>
<li><strong>Insuficiencia cardíaca</strong> (IC).</li>
</ul>
<p>Cada riesgo se calcula a 10 y a 30 años.</p>',
        ],
        [
            'titulo' => '¿Qué datos usa?',
            'html' => '<p>Edad (30 a 79 años), sexo, colesterol total y HDL, presión sistólica, si tomás medicación para la presión o estatinas, diabetes, tabaquismo, filtrado glomerular estimado (eGFR) y, para la insuficiencia cardíaca, el IMC. Se le pueden sumar la albuminuria (UACR) y la HbA1c para afinar el cálculo.</p>',
        ],
        [
            'titulo' => '¿Cómo usa la guía el resultado?',
            'html' => '<ul>
<li><strong>ECV total a 10 años ≥ 20 %</strong>: equivale al estadío 3 del síndrome CKM.</li>
<li><strong>ECV total a 10 años ≥ 7,5 %</strong>: con diabetes tipo 2, priorizar medicamentos con beneficio cardiovascular y renal (inhibidores de SGLT2 o agonistas del receptor de GLP-1); también es el umbral para tratar con medicación la hipertensión estadío 1.</li>
<li><strong>ASCVD a 10 años ≥ 5 %</strong>: iniciar tratamiento para bajar el colesterol. Entre 3 % y 5 %, considerarlo según otros factores (riesgo a 30 años o calcio coronario).</li>
<li><strong>ASCVD a 10 años entre 3 % y 10 %</strong>: si hay dudas, evaluar aterosclerosis subclínica con un puntaje de calcio coronario.</li>
<li><strong>ASCVD a 30 años ≥ 10 %</strong>: considerar tratamiento para bajar el colesterol.</li>
<li><strong>IC a 10 años ≥ 5 %</strong>: evaluar pre-insuficiencia cardíaca con biomarcadores (péptidos natriuréticos o troponina).</li>
</ul>
<p>Además del número, el médico tiene en cuenta los potenciadores de riesgo, como la proteína C reactiva ultrasensible ≥ 2 mg/L.</p>',
        ],
        [
            'titulo' => 'Lo que PREVENT no hace',
            'html' => '<ul>
<li>No se usa si ya tenés enfermedad cardiovascular (estadío 4): en ese caso el riesgo ya es alto y el tratamiento se decide por la enfermedad.</li>
<li>Es una estimación para grupos de personas, desarrollada con población de Estados Unidos: no reemplaza la evaluación médica.</li>
<li>Cambia con tus hábitos y tratamientos: por eso conviene recalcularlo en cada control.</li>
</ul>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Khan SS, et al. Development and Validation of the American Heart Association\'s PREVENT Equations. Circulation. 2024;149:430–449.',
            'url' => 'https://doi.org/10.1161/CIRCULATIONAHA.123.067626',
        ],
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
    ],
    'actualizado' => '2026-10-01',
];

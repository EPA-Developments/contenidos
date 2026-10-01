<?php
// Biblioteca CKM-LE8 · Enfermedad renal crónica
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'enfermedad-renal-cronica',
    'orden' => 24,
    'tipo' => 'condicion',
    'titulo' => 'Enfermedad renal crónica',
    'resumen' => 'Cómo se detecta la enfermedad renal crónica con dos análisis simples, qué significan las categorías KDIGO y cómo se protege el riñón.',
    'le8' => [
        'presion',
        'glucosa',
    ],
    'ckm' => [
        2,
        3,
        4,
    ],
    'claves' => [
        'Al principio no da síntomas: se detecta con un análisis de sangre (creatinina, para estimar el filtrado) y uno de orina (albúmina).',
        'Hay enfermedad renal crónica si el filtrado es menor de 60 o la albúmina en orina es de 30 mg/g o más durante más de 3 meses.',
        'Según su riesgo, ubica a la persona en el estadío 2 o 3 del síndrome CKM, y aumenta el riesgo de infarto, ACV e insuficiencia cardíaca.',
        'Controlar la presión y la glucosa, y algunos medicamentos, frenan su avance.',
    ],
    'secciones' => [
        [
            'titulo' => 'Cómo se detecta',
            'html' => '<p>Se recomienda controlar a las personas con diabetes, hipertensión, enfermedad cardiovascular o antecedentes familiares de enfermedad renal, con dos análisis:</p>
<ul>
<li><strong>Filtrado glomerular estimado (eGFR)</strong>, calculado con la creatinina en sangre.</li>
<li><strong>Cociente albúmina/creatinina en orina (UACR)</strong>, en una muestra de orina.</li>
</ul>',
        ],
        [
            'titulo' => 'Las categorías KDIGO',
            'html' => '<table class="biblio-tabla">
<tr><th>Filtrado (mL/min/1,73 m²)</th><th>Albúmina en orina (mg/g)</th></tr>
<tr><td>G1 ≥ 90 · G2 60 a 89 · G3a 45 a 59 · G3b 30 a 44 · G4 15 a 29 · G5 &lt; 15</td><td>A1 &lt; 30 · A2 30 a 299 · A3 ≥ 300</td></tr>
</table>
<p>La combinación de las dos define el riesgo. Las de riesgo moderado o alto corresponden al estadío 2 del síndrome CKM; las de muy alto riesgo (G3a con A3, G3b con A2 o A3, o G4 a G5), al estadío 3. Con filtrado menor de 15 o diálisis y enfermedad cardiovascular, al estadío 4b.</p>',
        ],
        [
            'titulo' => 'Cómo se protege el riñón',
            'html' => '<ul>
<li>Controlar la presión arterial y la glucemia.</li>
<li>Menos sal y no fumar.</li>
<li>Evitar el uso habitual de antiinflamatorios (como ibuprofeno o diclofenac) sin indicación médica.</li>
<li>Los inhibidores de SGLT2 y otros medicamentos que indique el médico frenan el avance de la enfermedad en muchas personas.</li>
<li>Con enfermedad renal de muy alto riesgo, controlar filtrado y albúmina cada 3 a 6 meses.</li>
</ul>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314.',
            'url' => 'https://doi.org/10.1016/j.kint.2023.10.018',
        ],
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
    ],
    'actualizado' => '2026-10-01',
];

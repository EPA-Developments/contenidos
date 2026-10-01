<?php
// Biblioteca CKM-LE8 · Prediabetes y diabetes tipo 2
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'prediabetes-y-diabetes-tipo-2',
    'orden' => 22,
    'tipo' => 'condicion',
    'titulo' => 'Prediabetes y diabetes tipo 2',
    'resumen' => 'Cómo se diagnostican la prediabetes y la diabetes tipo 2, qué lugar ocupan en el síndrome CKM y qué se puede hacer para prevenirlas y tratarlas.',
    'le8' => [
        'glucosa',
        'dieta',
        'actividad-fisica',
        'imc',
    ],
    'ckm' => [
        1,
        2,
        3,
        4,
    ],
    'claves' => [
        'Prediabetes: glucemia en ayunas de 100 a 125 mg/dL o HbA1c de 5,7 a 6,4 % (estadío 1 del síndrome CKM).',
        'Diabetes tipo 2: glucemia en ayunas ≥ 126 mg/dL o HbA1c ≥ 6,5 %, confirmadas (estadío 2).',
        'Con cambios de hábitos y bajar alrededor de un 7 % del peso, el riesgo de pasar de prediabetes a diabetes bajó un 58 % en el estudio DPP.',
        'En diabetes tipo 2 con riesgo cardiovascular alto, se priorizan medicamentos que protegen el corazón y el riñón.',
    ],
    'secciones' => [
        [
            'titulo' => 'El diagnóstico',
            'html' => '<table class="biblio-tabla">
<tr><th></th><th>Normal</th><th>Prediabetes</th><th>Diabetes</th></tr>
<tr><td>Glucemia en ayunas</td><td>&lt; 100 mg/dL</td><td>100 a 125 mg/dL</td><td>≥ 126 mg/dL</td></tr>
<tr><td>HbA1c</td><td>&lt; 5,7 %</td><td>5,7 a 6,4 %</td><td>≥ 6,5 %</td></tr>
<tr><td>Glucemia 2 h después de 75 g de glucosa</td><td>&lt; 140 mg/dL</td><td>140 a 199 mg/dL</td><td>≥ 200 mg/dL</td></tr>
</table>
<p>Sin síntomas claros, el diagnóstico de diabetes se confirma con un segundo análisis. La American Diabetes Association recomienda controlar a todos los adultos desde los 35 años, y antes si hay sobrepeso y otros factores de riesgo.</p>',
        ],
        [
            'titulo' => 'Prevenir la diabetes',
            'html' => '<p>En el Diabetes Prevention Program, las personas con prediabetes que bajaron alrededor de un 7 % de su peso y caminaron 150 minutos por semana redujeron un 58 % el riesgo de desarrollar diabetes; la metformina lo redujo un 31 %.</p>',
        ],
        [
            'titulo' => 'Tratar la diabetes tipo 2',
            'html' => '<ul>
<li>Alimentación, actividad física y peso siguen siendo la base.</li>
<li>Para muchos adultos la meta es una HbA1c menor de 7 %; el médico la ajusta a cada persona.</li>
<li>Con riesgo cardiovascular alto (PREVENT ≥ 7,5 % a 10 años), enfermedad cardiovascular o enfermedad renal, la guía CKM 2026 prioriza inhibidores de SGLT2 o agonistas del receptor de GLP-1, que protegen el corazón y el riñón.</li>
<li>Con diabetes, controlar cada año la función renal y la albúmina en orina, la vista y los pies.</li>
</ul>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'American Diabetes Association Professional Practice Committee. 2. Diagnosis and Classification of Diabetes: Standards of Care in Diabetes—2025. Diabetes Care. 2025;48(Supl. 1).',
            'url' => 'https://diabetesjournals.org/care/issue/48/Supplement_1',
        ],
        [
            'cita' => 'Diabetes Prevention Program Research Group; Knowler WC, et al. Reduction in the Incidence of Type 2 Diabetes with Lifestyle Intervention or Metformin. N Engl J Med. 2002;346:393–403.',
            'url' => 'https://doi.org/10.1056/NEJMoa012512',
        ],
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'Lloyd-Jones DM, et al. Life\'s Essential 8: Updating and Enhancing the American Heart Association\'s Construct of Cardiovascular Health. Circulation. 2022;146:e18–e43.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001078',
        ],
    ],
    'actualizado' => '2026-10-01',
];

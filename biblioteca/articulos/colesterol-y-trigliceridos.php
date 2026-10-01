<?php
// Biblioteca CKM-LE8 · Colesterol y triglicéridos
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'colesterol-y-trigliceridos',
    'orden' => 21,
    'tipo' => 'condicion',
    'titulo' => 'Colesterol y triglicéridos',
    'resumen' => 'Qué significan el colesterol LDL, el HDL, el no HDL, los triglicéridos y la lipoproteína(a), y cómo se decide el tratamiento.',
    'le8' => [
        'colesterol',
        'dieta',
        'actividad-fisica',
    ],
    'ckm' => [
        2,
        3,
        4,
    ],
    'claves' => [
        'El colesterol LDL es el que se deposita en las arterias: cuanto más bajo y por más tiempo, menor el riesgo.',
        'Life’s Essential 8 usa el colesterol no HDL (total menos HDL), que suma todas las partículas que dañan las arterias.',
        'Los triglicéridos ≥ 150 mg/dL son un criterio del estadío 2 del síndrome CKM.',
        'La necesidad de tratamiento no depende solo del valor: se decide con tu riesgo cardiovascular (PREVENT) y tu estadío.',
    ],
    'secciones' => [
        [
            'titulo' => 'Los valores',
            'html' => '<table class="biblio-tabla">
<tr><th>Análisis</th><th>Referencia</th></tr>
<tr><td>Colesterol LDL</td><td>Óptimo &lt; 100 mg/dL (la meta depende del riesgo de cada persona).</td></tr>
<tr><td>Colesterol HDL</td><td>Bajo si es &lt; 40 mg/dL en varones o &lt; 50 mg/dL en mujeres.</td></tr>
<tr><td>Colesterol total</td><td>Deseable &lt; 200 mg/dL.</td></tr>
<tr><td>Triglicéridos</td><td>Normal &lt; 150 mg/dL.</td></tr>
<tr><td>Lipoproteína(a)</td><td>Aumenta el riesgo si es ≥ 125 nmol/L (≥ 50 mg/dL).</td></tr>
<tr><td>Apolipoproteína B</td><td>Aumenta el riesgo si es ≥ 130 mg/dL.</td></tr>
</table>',
        ],
        [
            'titulo' => 'Cómo se decide el tratamiento',
            'html' => '<ul>
<li>Con LDL ≥ 190 mg/dL (posible hipercolesterolemia familiar) se indica tratamiento sin necesidad de calcular el riesgo.</li>
<li>En prevención primaria, la guía CKM 2026 usa el riesgo PREVENT de enfermedad aterosclerótica a 10 años: desde 5 %, iniciar tratamiento para bajar el colesterol; entre 3 % y 5 %, considerarlo según otros factores.</li>
<li>Con enfermedad cardiovascular (estadío 4), el tratamiento es intensivo para bajar el LDL lo más posible.</li>
</ul>
<p>La lipoproteína(a) es en gran parte hereditaria; muchas sociedades recomiendan medirla al menos una vez en la vida, sobre todo con antecedentes familiares de enfermedad cardiovascular temprana.</p>',
        ],
        [
            'titulo' => 'Qué se puede hacer',
            'html' => '<ul>
<li>Reemplazar grasas saturadas por aceites vegetales líquidos (ver <a href="/biblioteca/grasas-y-aceites">grasas y aceites</a>).</li>
<li>Más fibra: legumbres, avena, frutas y verduras.</li>
<li>Para los triglicéridos: menos azúcar y alcohol, bajar de peso y moverse más.</li>
<li>Si el médico indica estatinas u otros medicamentos, tomarlos de forma continua: el beneficio depende de mantenerlos en el tiempo.</li>
</ul>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Grundy SM, et al. 2018 AHA/ACC Guideline on the Management of Blood Cholesterol. Circulation. 2019;139:e1082–e1143.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000000625',
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

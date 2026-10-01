<?php
// Biblioteca CKM-LE8 · Hipertensión arterial
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'hipertension',
    'orden' => 20,
    'tipo' => 'condicion',
    'titulo' => 'Hipertensión arterial',
    'resumen' => 'Cuándo la presión es alta, cómo medirla bien en casa y qué se puede hacer, con los criterios de la AHA/ACC y de la guía CKM 2026.',
    'le8' => [
        'presion',
        'dieta',
        'actividad-fisica',
        'imc',
    ],
    'ckm' => [
        2,
        3,
        4,
    ],
    'claves' => [
        'Se habla de hipertensión desde 130/80 mmHg, confirmada con varias mediciones en distintos días.',
        'Casi nunca da síntomas: la única forma de saberlo es medirla.',
        'Es un criterio del estadío 2 del síndrome CKM y el principal factor de riesgo modificable de ACV.',
        'Los hábitos bajan la presión; si hace falta medicación, la indica el médico según tu riesgo.',
    ],
    'secciones' => [
        [
            'titulo' => 'Cuándo la presión es alta',
            'html' => '<table class="biblio-tabla">
<tr><th>Categoría</th><th>Sistólica</th><th></th><th>Diastólica</th></tr>
<tr><td>Normal</td><td>&lt; 120 mmHg</td><td>y</td><td>&lt; 80 mmHg</td></tr>
<tr><td>Elevada</td><td>120 a 129 mmHg</td><td>y</td><td>&lt; 80 mmHg</td></tr>
<tr><td>Hipertensión estadío 1</td><td>130 a 139 mmHg</td><td>o</td><td>80 a 89 mmHg</td></tr>
<tr><td>Hipertensión estadío 2</td><td>≥ 140 mmHg</td><td>o</td><td>≥ 90 mmHg</td></tr>
</table>
<p>El diagnóstico se hace con el promedio de al menos dos lecturas en dos o más ocasiones. Una presión mayor de 180/120 mmHg necesita atención médica inmediata, sobre todo si hay dolor de pecho, falta de aire, dolor de cabeza intenso o alteraciones de la vista o del habla.</p>',
        ],
        [
            'titulo' => 'Cómo medirla bien en casa',
            'html' => '<ul>
<li>Usá un tensiómetro automático de brazo validado.</li>
<li>No tomes café, no fumes ni hagas ejercicio en los 30 minutos previos.</li>
<li>Sentate con la espalda apoyada y los pies en el piso, y descansá 5 minutos.</li>
<li>Apoyá el brazo a la altura del corazón, sin ropa debajo del manguito.</li>
<li>Tomá dos lecturas separadas por un minuto y anotalas para mostrarlas en la consulta.</li>
</ul>',
        ],
        [
            'titulo' => 'Qué se puede hacer',
            'html' => '<ul>
<li><strong>Menos sal</strong>: no más de 2.300 mg de sodio por día, idealmente 1.500 mg.</li>
<li><strong>Patrón DASH</strong>: frutas, verduras, lácteos descremados, legumbres y granos integrales.</li>
<li><strong>Bajar de peso</strong> si hay sobrepeso: la presión baja alrededor de 1 mmHg por cada kilo.</li>
<li><strong>Actividad física</strong> regular y <strong>menos alcohol</strong>.</li>
</ul>
<p>La guía CKM 2026 usa el riesgo PREVENT para decidir la medicación en la hipertensión estadío 1 (cuando el riesgo de enfermedad cardiovascular a 10 años es ≥ 7,5 %); en el estadío 2 se indica medicación además de los hábitos. La meta para la mayoría de los adultos es menos de 130/80 mmHg.</p>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Whelton PK, et al. 2017 ACC/AHA Guideline for the Prevention, Detection, Evaluation, and Management of High Blood Pressure in Adults. Hypertension. 2018;71:e13–e115.',
            'url' => 'https://doi.org/10.1161/HYP.0000000000000065',
        ],
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'Sacks FM, et al. Effects on Blood Pressure of Reduced Dietary Sodium and the Dietary Approaches to Stop Hypertension (DASH) Diet. N Engl J Med. 2001;344:3–10.',
            'url' => 'https://doi.org/10.1056/NEJM200101043440101',
        ],
        [
            'cita' => 'Lloyd-Jones DM, et al. Life\'s Essential 8: Updating and Enhancing the American Heart Association\'s Construct of Cardiovascular Health. Circulation. 2022;146:e18–e43.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001078',
        ],
    ],
    'actualizado' => '2026-10-01',
];

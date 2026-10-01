<?php
// Biblioteca CKM-LE8 · Sobrepeso, obesidad y grasa abdominal
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'obesidad-y-grasa-abdominal',
    'orden' => 23,
    'tipo' => 'condicion',
    'titulo' => 'Sobrepeso, obesidad y grasa abdominal',
    'resumen' => 'Por qué el exceso de grasa, sobre todo la abdominal, es el punto de partida del síndrome CKM, cómo se mide y qué tratamientos tienen evidencia.',
    'le8' => [
        'imc',
        'dieta',
        'actividad-fisica',
        'sueno',
    ],
    'ckm' => [
        1,
        2,
        3,
        4,
    ],
    'claves' => [
        'Un IMC ≥ 25 kg/m² o una cintura ≥ 88 cm (mujeres) o ≥ 102 cm (varones) marcan el estadío 1 del síndrome CKM.',
        'La grasa abdominal es la más relacionada con la diabetes, la hipertensión y la enfermedad cardiovascular.',
        'Bajar entre un 5 % y un 10 % del peso ya mejora la presión, la glucemia y los lípidos.',
        'Hay medicamentos con beneficio cardiovascular demostrado en personas con obesidad; los indica el médico.',
    ],
    'secciones' => [
        [
            'titulo' => 'Cómo se mide',
            'html' => '<ul>
<li><strong>IMC</strong> (peso en kilos dividido por la altura en metros al cuadrado): 25 a 29,9 es sobrepeso; 30 o más, obesidad.</li>
<li><strong>Cintura</strong>, a la altura del ombligo: aumentada desde 88 cm en mujeres y 102 cm en varones.</li>
<li>En personas de ascendencia asiática los umbrales son más bajos (IMC ≥ 23; cintura ≥ 80 cm en mujeres y ≥ 90 cm en varones).</li>
</ul>
<p>El IMC solo no alcanza: la cintura ayuda a ver la grasa abdominal, que es la de mayor riesgo.</p>',
        ],
        [
            'titulo' => 'Por qué importa',
            'html' => '<p>El exceso de grasa, sobre todo abdominal, favorece la resistencia a la insulina, la diabetes tipo 2, la hipertensión, los triglicéridos altos y el hígado graso, y con ellos la enfermedad renal y cardiovascular. Por eso la guía lo pone en el estadío 1 del síndrome CKM.</p>',
        ],
        [
            'titulo' => 'Qué funciona',
            'html' => '<ul>
<li><strong>Alimentación y actividad física</strong>: bajar entre un 5 % y un 10 % del peso mejora la presión, la glucemia y los lípidos.</li>
<li><strong>Dormir bien</strong>: dormir poco favorece el aumento de peso (ver la métrica de <a href="/le8-sueno-es">sueño</a>).</li>
<li><strong>Medicamentos</strong>: en el estudio SELECT, la semaglutida redujo un 20 % los eventos cardiovasculares mayores en personas con enfermedad cardiovascular y sobrepeso u obesidad, sin diabetes. La indicación es médica.</li>
<li><strong>Cirugía bariátrica</strong>: una opción para algunas personas con obesidad severa, evaluada por un equipo especializado.</li>
</ul>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'Jensen MD, et al. 2013 AHA/ACC/TOS Guideline for the Management of Overweight and Obesity in Adults. Circulation. 2014;129(25 Supl. 2):S102–S138.',
            'url' => 'https://doi.org/10.1161/01.cir.0000437739.71477.ee',
        ],
        [
            'cita' => 'Lincoff AM, et al. Semaglutide and Cardiovascular Outcomes in Obesity without Diabetes (SELECT). N Engl J Med. 2023;389:2221–2232.',
            'url' => 'https://doi.org/10.1056/NEJMoa2307563',
        ],
        [
            'cita' => 'Lloyd-Jones DM, et al. Life\'s Essential 8: Updating and Enhancing the American Heart Association\'s Construct of Cardiovascular Health. Circulation. 2022;146:e18–e43.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001078',
        ],
    ],
    'actualizado' => '2026-10-01',
];

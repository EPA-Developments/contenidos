<?php
// Biblioteca CKM-LE8 · Chocolate y cacao: ¿es bueno para el corazón?
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
// Reemplaza, con evidencia, 18 páginas viejas de blogs/ (redirigen acá; ver .htaccess).
return [
    'slug' => 'chocolate-y-cacao',
    'orden' => 53,
    'tipo' => 'evidencia',
    'titulo' => 'Chocolate y cacao: ¿es bueno para el corazón?',
    'resumen' => 'Qué mostró el estudio COSMOS sobre los flavanoles del cacao y por qué el chocolate no es un tratamiento para la presión ni el colesterol.',
    'le8' => [
        'dieta',
        'presion',
        'colesterol',
    ],
    'ckm' => [
        0,
        1,
        2,
        3,
        4,
    ],
    'claves' => [
        'Los flavanoles del cacao se estudiaron en un ensayo grande (COSMOS, más de 21.000 adultos): no redujeron de forma significativa el total de eventos cardiovasculares.',
        'Se usó un extracto en cápsulas, no chocolate: el chocolate aporta además azúcar, grasas saturadas y calorías.',
        'El chocolate amargo puede ser un gusto ocasional en porciones chicas, no una forma de cuidar el corazón.',
    ],
    'secciones' => [
        [
            'titulo' => 'Qué dice la evidencia',
            'html' => '<p>El estudio COSMOS comparó, en 21.442 adultos de Estados Unidos, un extracto de cacao con 500 mg diarios de flavanoles contra placebo durante una mediana de 3,6 años. Los eventos cardiovasculares totales fueron un 10 % menores con el extracto, una diferencia que no fue estadísticamente significativa. La muerte cardiovascular fue menor, pero era un resultado secundario que necesita confirmación.</p>',
        ],
        [
            'titulo' => 'El chocolate no es el extracto',
            'html' => '<p>Para obtener esa cantidad de flavanoles habría que comer mucho chocolate, con su azúcar, sus grasas saturadas y sus calorías, que van en contra del peso y del colesterol. El efecto del estudio no se puede trasladar a comer chocolate.</p>',
        ],
        [
            'titulo' => 'Presión y colesterol',
            'html' => '<p>Algunos estudios cortos mostraron cambios pequeños en la presión arterial con productos de cacao, pero no reemplazan a los hábitos ni a los tratamientos. Para la presión, lo que más ayuda es menos sal, el patrón DASH, la actividad física y, si hace falta, la medicación.</p>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Sesso HD, et al. Effect of cocoa flavanol supplementation for the prevention of cardiovascular disease events: the COSMOS randomized clinical trial. Am J Clin Nutr. 2022;115(6):1490–1500.',
            'url' => 'https://doi.org/10.1093/ajcn/nqac055',
        ],
        [
            'cita' => 'Lichtenstein AH, et al. 2021 Dietary Guidance to Improve Cardiovascular Health: A Scientific Statement From the American Heart Association. Circulation. 2021;144:e472–e487.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001031',
        ],
    ],
    'actualizado' => '2026-10-01',
    'reemplaza' => [
        'blogs/atherosclerosis-and-chocolate',
        'blogs/cardioprotective-effects-of-chocolate',
        'blogs/chocolate-and-atherosclerosis',
        'blogs/chocolate-and-blood-flow',
        'blogs/chocolate-and-blood-sugar',
        'blogs/chocolate-and-cholesterol',
        'blogs/chocolate-and-heart-health',
        'blogs/chocolate-and-hypertension',
        'blogs/dark-chocolate-and-arrhythmia',
        'blogs/dark-chocolate-and-blood-pressure',
        'blogs/dark-chocolate-and-cholesterol',
        'blogs/dark-chocolate-and-hypertension',
        'blogs/dark-chocolate-cardiovascular-benefits',
        'blogs/dark-chocolate-for-diabetes-and-heart-health',
        'blogs/dark-chocolate-for-heart-health',
        'blogs/dark-chocolate-heart-health',
        'blogs/dark-chocolate-in-cardiac-rehab',
        'blogs/flavonoids-in-chocolate',
    ],
];

<?php
// Biblioteca CKM-LE8 · Plan Bienestar 100 Días®
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'plan-bienestar-100-dias',
    'orden' => 40,
    'tipo' => 'programa',
    'titulo' => 'Plan Bienestar 100 Días®',
    'resumen' => 'El programa de Segunda Opinión Médica para mejorar tu salud cardiovascular, renal y metabólica en 100 días: consultas, evaluaciones y seguimiento según tu estadío CKM.',
    'le8' => [
        'dieta',
        'actividad-fisica',
        'nicotina',
        'sueno',
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
        4,
    ],
    'claves' => [
        'Tres consultas incluidas: inicial (día 1), de mitad (día 50) y final (día 100), presenciales o por teleconsulta.',
        'Evaluaciones en la app los días 0, 30, 60 y 100, con tu tablero de Life’s Essential 8.',
        'El plan se arma según tu estadío CKM (0 a 4), con alertas y derivaciones definidas por el equipo médico.',
        'Plan Bienestar 100 Días® es marca registrada del Dr. Alejandro Sergio D’Alessandro.',
    ],
    'secciones' => [
        [
            'titulo' => '¿Qué es?',
            'html' => '<p>Un programa de 100 días para mejorar la salud del corazón, los riñones y el metabolismo, con seguimiento del equipo médico de Segunda Opinión Médica. Su estructura la definieron el Dr. Alejandro Sergio D’Alessandro y el Dr. Alejandro Barbagelata.</p>',
        ],
        [
            'titulo' => '¿Qué incluye?',
            'html' => '<table class="biblio-tabla">
<tr><th></th><th>Detalle</th></tr>
<tr><td>Consultas del plan</td><td>Inicial (día 1), día 50 y final (día 100), con una ventana de ± 7 días para las dos últimas. Están incluidas: no se pagan ni requieren seña.</td></tr>
<tr><td>Evaluaciones en la app</td><td>Días 0, 30, 60 y 100: biomarcadores y cuestionarios que cargás en la app.</td></tr>
<tr><td>Modalidad</td><td>Cada consulta puede ser presencial o por teleconsulta.</td></tr>
<tr><td>Recordatorios</td><td>Te avisamos por WhatsApp cuando se abre la ventana de cada consulta.</td></tr>
<tr><td>Otras consultas</td><td>Las consultas por especialidad fuera del plan tienen cargo.</td></tr>
</table>',
        ],
        [
            'titulo' => 'Personalizado según tu estadío CKM',
            'html' => '<p>El plan parte de tu <a href="/biblioteca/estadios-ckm">estadío del síndrome CKM</a> y de tus métricas de <a href="/life-essential-8-es">Life’s Essential 8</a>. Según el estadío y tus condiciones, el equipo médico tiene definidas alertas y derivaciones a cardiología, nutrición, kinesiología, endocrinología, nefrología y otras especialidades. El sistema ayuda a detectarlas, pero las decisiones las toma tu médico.</p>',
        ],
        [
            'titulo' => '¿Cómo empiezo?',
            'html' => '<p>Pedí tu turno para la consulta inicial por WhatsApp o en el portal. Desde ese día corre el plan y el sistema calcula las fechas de las otras dos consultas.</p>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'Lloyd-Jones DM, et al. Life\'s Essential 8: Updating and Enhancing the American Heart Association\'s Construct of Cardiovascular Health. Circulation. 2022;146:e18–e43.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001078',
        ],
        [
            'cita' => 'Catálogo de alertas y derivaciones del Plan Bienestar 100 Días® por estadío CKM, firmado por los Dres. Alejandro Barbagelata y Alejandro Sergio D\'Alessandro (27/09/2026).',
            'url' => '',
        ],
    ],
    'actualizado' => '2026-10-01',
];

<?php
// Biblioteca CKM-LE8 · Enfermedad coronaria e infarto
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'enfermedad-coronaria',
    'orden' => 26,
    'tipo' => 'condicion',
    'titulo' => 'Enfermedad coronaria e infarto',
    'resumen' => 'Qué es la enfermedad coronaria, cómo reconocer un infarto, cómo se detecta la aterosclerosis antes de los síntomas y qué tratamientos tienen evidencia.',
    'le8' => [
        'colesterol',
        'presion',
        'nicotina',
        'glucosa',
    ],
    'ckm' => [
        3,
        4,
    ],
    'claves' => [
        'Ante un dolor u opresión en el pecho que dura más de unos minutos, llamá enseguida al servicio de emergencias (107 o 911).',
        'La aterosclerosis se puede detectar antes de los síntomas: un puntaje de calcio coronario ≥ 100 es un criterio del estadío 3 del síndrome CKM.',
        'La enfermedad coronaria con factores CKM corresponde al estadío 4.',
        'El tratamiento combina hábitos, medicamentos (sobre todo para bajar el LDL) y rehabilitación cardíaca.',
    ],
    'secciones' => [
        [
            'titulo' => 'Señales de alarma de un infarto',
            'html' => '<ul>
<li>Dolor, presión u opresión en el pecho, que puede irse al brazo, la mandíbula, la espalda o el estómago.</li>
<li>Falta de aire, sudor frío, náuseas o mareo.</li>
<li>En mujeres, personas mayores y personas con diabetes los síntomas pueden ser menos típicos: cansancio extremo, falta de aire o malestar.</li>
</ul>
<p>No esperes a ver si se pasa: llamá al servicio de emergencias (107 o 911). El tratamiento temprano salva músculo cardíaco.</p>',
        ],
        [
            'titulo' => 'Detectarla antes de los síntomas',
            'html' => '<p>Cuando hay dudas sobre el riesgo (PREVENT de enfermedad aterosclerótica entre 3 % y 10 % a 10 años), el puntaje de calcio coronario en una tomografía ayuda a decidir el tratamiento. Un puntaje ≥ 100 indica aterosclerosis subclínica.</p>',
        ],
        [
            'titulo' => 'Tratamiento',
            'html' => '<ul>
<li><strong>Hábitos</strong>: no fumar, alimentación saludable, actividad física y control del peso.</li>
<li><strong>Medicamentos</strong>: para bajar el LDL de forma intensa, antiagregantes cuando están indicados, control de la presión y, con diabetes, medicamentos con beneficio cardiovascular.</li>
<li><strong>Rehabilitación cardíaca</strong> después de un infarto o de una angioplastia o cirugía.</li>
<li><strong>Angioplastia o cirugía</strong> cuando el médico las indica según los síntomas y los estudios.</li>
</ul>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Virani SS, et al. 2023 AHA/ACC/ACCP/ASPC/NLA/PCNA Guideline for the Management of Patients With Chronic Coronary Disease. Circulation. 2023;148:e9–e119.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001168',
        ],
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'Grundy SM, et al. 2018 AHA/ACC Guideline on the Management of Blood Cholesterol. Circulation. 2019;139:e1082–e1143.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000000625',
        ],
    ],
    'actualizado' => '2026-10-01',
];

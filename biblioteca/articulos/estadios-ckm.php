<?php
// Biblioteca CKM-LE8 · Estadíos del síndrome CKM: del 0 al 4
// Datos del artículo (los muestra biblioteca/_biblioteca.php). Revisión médica: pendiente.
return [
    'slug' => 'estadios-ckm',
    'orden' => 11,
    'tipo' => 'ckm',
    'titulo' => 'Estadíos del síndrome CKM: del 0 al 4',
    'resumen' => 'Los criterios de cada estadío del síndrome cardiovascular-renal-metabólico según la guía AHA/ACC/ADA/ASN 2026, y cada cuánto controlarse.',
    'le8' => [
        'imc',
        'glucosa',
        'colesterol',
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
        'Cada persona queda en el estadío más alto cuyos criterios cumple.',
        'Los estadíos 3 y 4 requieren además factores CKM (exceso de grasa corporal, factores metabólicos o enfermedad renal): una enfermedad cardiovascular sin esos factores no se clasifica como síndrome CKM.',
        'La hipertensión y la enfermedad renal crónica se confirman con más de una medición.',
        'Cuanto más alto el estadío, más frecuentes los controles.',
    ],
    'secciones' => [
        [
            'titulo' => 'Cómo se clasifica',
            'html' => '<p>La guía ordena el síndrome en cinco estadíos, del 0 al 4. Los umbrales de esta página son los de la guía (Tabla 4) y son los mismos que usa Segunda Opinión Médica para estimar el estadío de cada paciente; el médico lo confirma con la historia clínica completa.</p>',
        ],
        [
            'titulo' => 'Estadío 0: sin factores de riesgo CKM',
            'html' => '<p>IMC y cintura normales, glucemia normal, presión arterial y lípidos normales, sin enfermedad renal crónica ni enfermedad cardiovascular. El objetivo es mantenerlo con buenos hábitos.</p>',
        ],
        [
            'titulo' => 'Estadío 1: exceso o disfunción del tejido graso',
            'html' => '<p>Al menos uno de:</p>
<ul>
<li>IMC ≥ 25 kg/m².</li>
<li>Cintura ≥ 88 cm en mujeres o ≥ 102 cm en varones.</li>
<li>Prediabetes: glucemia en ayunas de 100 a 125 mg/dL o HbA1c de 5,7 a 6,4 %.</li>
</ul>
<p>En personas de ascendencia asiática los umbrales son más bajos: IMC ≥ 23 kg/m² y cintura ≥ 80 cm en mujeres o ≥ 90 cm en varones.</p>',
        ],
        [
            'titulo' => 'Estadío 2: factores de riesgo metabólicos o enfermedad renal',
            'html' => '<p>Al menos uno de:</p>
<ul>
<li>Triglicéridos ≥ 150 mg/dL.</li>
<li>Hipertensión: ≥ 130/80 mmHg (promedio de al menos dos lecturas en dos o más ocasiones) o tratamiento para la presión.</li>
<li>Diabetes tipo 2: glucemia en ayunas ≥ 126 mg/dL o HbA1c ≥ 6,5 %.</li>
<li>Síndrome metabólico: 3 o más de 5 componentes (cintura aumentada; triglicéridos ≥ 150 mg/dL; colesterol HDL &lt; 50 mg/dL en mujeres o &lt; 40 mg/dL en varones; presión ≥ 130/80 mmHg; glucemia en ayunas ≥ 100 mg/dL).</li>
<li>Enfermedad renal crónica de riesgo moderado o alto según KDIGO: filtrado (eGFR) &lt; 60 mL/min/1,73 m² o albuminuria (UACR) ≥ 30 mg/g, en dos mediciones separadas por al menos 3 meses.</li>
</ul>',
        ],
        [
            'titulo' => 'Estadío 3: enfermedad cardiovascular subclínica o riesgo equivalente',
            'html' => '<p>En personas con factores CKM, al menos uno de:</p>
<ul>
<li><strong>Aterosclerosis subclínica</strong>: puntaje de calcio coronario ≥ 100 (Agatston), aterosclerosis coronaria documentada o índice tobillo-brazo bajo.</li>
<li><strong>Pre-insuficiencia cardíaca</strong>: NT-proBNP ≥ 125 pg/mL, BNP ≥ 35 pg/mL, troponina ultrasensible elevada (T ≥ 14 ng/L en mujeres o ≥ 22 ng/L en varones; I ≥ 10 ng/L en mujeres o ≥ 12 ng/L en varones) o alteraciones de la estructura o la función del corazón en el ecocardiograma.</li>
<li><strong>Enfermedad renal de muy alto riesgo</strong> según KDIGO (G3a con A3, G3b con A2 o A3, o G4 a G5).</li>
<li><strong>Riesgo PREVENT</strong> de enfermedad cardiovascular a 10 años ≥ 20 %.</li>
</ul>',
        ],
        [
            'titulo' => 'Estadío 4: enfermedad cardiovascular clínica',
            'html' => '<p>Enfermedad coronaria, insuficiencia cardíaca, ACV o accidente isquémico transitorio, enfermedad arterial periférica o fibrilación auricular, en personas con factores CKM.</p>
<ul>
<li><strong>4a</strong>: sin falla renal.</li>
<li><strong>4b</strong>: con falla renal (filtrado &lt; 15 mL/min/1,73 m² o diálisis).</li>
</ul>',
        ],
        [
            'titulo' => 'Cada cuánto controlarse',
            'html' => '<table class="biblio-tabla">
<tr><th>Quién</th><th>Qué controlar y cada cuánto</th></tr>
<tr><td>Todos</td><td>IMC y cintura: una vez por año. Presión arterial: al menos una vez por año, idealmente en cada consulta.</td></tr>
<tr><td>Estadío 0</td><td>Lípidos, glucemia y filtrado renal: al menos cada 5 años.</td></tr>
<tr><td>Estadío 1</td><td>Lípidos, glucemia y filtrado renal: cada 2 a 3 años. Con prediabetes, glucemia o HbA1c cada año.</td></tr>
<tr><td>Estadío 2 o más</td><td>Lípidos, glucemia (HbA1c si hay diabetes), filtrado renal y albuminuria: al menos una vez por año.</td></tr>
<tr><td>Enfermedad renal de muy alto riesgo</td><td>Filtrado y albuminuria: cada 3 a 6 meses.</td></tr>
<tr><td>30 a 79 años sin enfermedad cardiovascular clínica</td><td>Recalcular el riesgo PREVENT con cada evaluación.</td></tr>
</table>',
        ],
        [
            'titulo' => 'Tu estadío en Segunda Opinión Médica',
            'html' => '<p>Con tus estudios, Segunda Opinión Médica estima tu estadío CKM y tu riesgo PREVENT, y tu médico los confirma y define el plan. Si querés saber en qué estadío estás, pedí tu turno.</p>',
        ],
    ],
    'fuentes' => [
        [
            'cita' => 'Ndumele CE, Rodriguez F, et al. 2026 AHA/ACC/ADA/ASN Guideline for the Prevention, Detection, Evaluation, and Management of Cardiovascular-Kidney-Metabolic Syndrome. Circulation. 2026.',
            'url' => 'https://doi.org/10.1161/CIR.0000000000001453',
        ],
        [
            'cita' => 'KDIGO 2024 Clinical Practice Guideline for the Evaluation and Management of Chronic Kidney Disease. Kidney Int. 2024;105(4S):S117–S314.',
            'url' => 'https://doi.org/10.1016/j.kint.2023.10.018',
        ],
        [
            'cita' => 'Khan SS, et al. Development and Validation of the American Heart Association\'s PREVENT Equations. Circulation. 2024;149:430–449.',
            'url' => 'https://doi.org/10.1161/CIRCULATIONAHA.123.067626',
        ],
    ],
    'actualizado' => '2026-10-01',
];

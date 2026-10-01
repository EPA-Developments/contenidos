<?php
require __DIR__ . '/_biblioteca.php';

$articulos = biblioteca_articulos();
$porTipo = [];
foreach ($articulos as $a) {
    $porTipo[$a['tipo']][] = $a;
}
$tipos = biblioteca_tipos();
$le8 = biblioteca_le8();
$introTipos = [
    'ckm' => 'La guía 2026 de AHA, ACC, ADA y ASN une corazón, riñón y metabolismo en un solo síndrome con cinco estadíos.',
    'condicion' => 'Las condiciones que definen el síndrome CKM, con los criterios de la guía.',
    'programa' => 'Cómo te acompaña Segunda Opinión Médica.',
    'evidencia' => 'Qué dicen los estudios y las guías sobre alimentos «milagrosos», remedios caseros y suplementos.',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Biblioteca CKM y Life's Essential 8 | EPA Bienestar</title>
  <meta name="description" content="Contenidos en español sobre el síndrome cardiovascular-renal-metabólico (guía AHA/ACC/ADA/ASN 2026) y las 8 métricas de Life's Essential 8, con fuentes y revisión médica." />
  <meta name="robots" content="index, follow" />
  <meta property="og:locale" content="es_AR" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="Biblioteca CKM y Life's Essential 8">
  <meta property="og:url" content="<?= BIBLIOTECA_URL ?>/">
  <link rel="canonical" href="<?= BIBLIOTECA_URL ?>/" />
  <style>
    .biblio-grilla{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin:16px 0 40px}
    .biblio-tarjeta{border:1px solid #d6e4f5;border-radius:12px;padding:16px;background:#fff}
    .biblio-tarjeta h3{font-size:18px;margin-bottom:8px}
    .biblio-tarjeta p{font-size:15px;margin:0}
  </style>
  <?php include __DIR__ . '/../include/header.php' ?>

  <div class="page-banner-area">
    <div class="container">
      <div class="page-banner-content">
        <ul>
          <li><a href="<?= BIBLIOTECA_SITIO ?>/">Inicio</a></li>
          <li>Biblioteca CKM-LE8</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="blog-details-area ptb-100">
    <div class="container">
      <h1>Biblioteca CKM y Life's Essential 8</h1>
      <p>Información en español sobre la salud del corazón, los riñones y el metabolismo, basada en la guía
      2026 de la American Heart Association, el American College of Cardiology, la American Diabetes
      Association y la American Society of Nephrology (síndrome CKM) y en Life's Essential 8 de la AHA.
      Cada artículo cita sus fuentes y lo revisa el equipo médico de Segunda Opinión Médica.</p>

      <?php foreach (['ckm', 'condicion'] as $t): if (empty($porTipo[$t])) continue; ?>
      <h2><?= biblioteca_e($tipos[$t]) ?></h2>
      <p><?= biblioteca_e($introTipos[$t]) ?></p>
      <div class="biblio-grilla">
        <?php foreach ($porTipo[$t] as $a): ?>
        <div class="biblio-tarjeta"><h3><a href="<?= biblioteca_e($a['url']) ?>"><?= biblioteca_e($a['titulo']) ?></a></h3><p><?= biblioteca_e($a['resumen']) ?></p></div>
        <?php endforeach ?>
      </div>
      <?php endforeach ?>

      <h2><?= biblioteca_e($tipos['le8']) ?></h2>
      <p>Las 8 métricas de la AHA para medir y mejorar la salud cardiovascular: cuatro hábitos y cuatro factores de salud.</p>
      <div class="biblio-grilla">
        <div class="biblio-tarjeta"><h3><a href="<?= BIBLIOTECA_SITIO ?>/life-essential-8-es">Life's Essential 8</a></h3><p>Qué es y cómo se calcula el puntaje de 0 a 100.</p></div>
        <?php foreach ($le8 as $m): ?>
        <div class="biblio-tarjeta"><h3><a href="<?= BIBLIOTECA_SITIO . $m['url'] ?>"><?= biblioteca_e($m['nombre']) ?></a></h3><p>Métrica de Life's Essential 8.</p></div>
        <?php endforeach ?>
      </div>

      <?php foreach (['programa', 'evidencia'] as $t): if (empty($porTipo[$t])) continue; ?>
      <h2><?= biblioteca_e($tipos[$t]) ?></h2>
      <p><?= biblioteca_e($introTipos[$t]) ?></p>
      <div class="biblio-grilla">
        <?php foreach ($porTipo[$t] as $a): ?>
        <div class="biblio-tarjeta"><h3><a href="<?= biblioteca_e($a['url']) ?>"><?= biblioteca_e($a['titulo']) ?></a></h3><p><?= biblioteca_e($a['resumen']) ?></p></div>
        <?php endforeach ?>
      </div>
      <?php endforeach ?>

      <div class="row justify-content-center"><div class="col-lg-8"><?= som_cta_turno('', 'biblioteca') ?></div></div>

      <p class="mt-4"><small>¿Desarrollás para el ecosistema? Todo el contenido está en
      <a href="<?= BIBLIOTECA_URL ?>/catalogo">/biblioteca/catalogo</a> (JSON) y
      <a href="<?= BIBLIOTECA_URL ?>/catalogo?formato=fhir">como FHIR R4</a>, filtrable por métrica LE8, estadío CKM o tipo.</small></p>
    </div>
  </div>

<?php include __DIR__ . '/../include/footer.php' ?>
</html>

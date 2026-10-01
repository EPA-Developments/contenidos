<?php
/**
 * Biblioteca CKM-LE8 de EPA Bienestar.
 *
 * Contenidos en español alineados con la guía 2026 AHA/ACC/ADA/ASN del síndrome
 * cardiovascular-renal-metabólico (Ndumele) y con Life's Essential 8 de la AHA, pensados
 * para reutilizarse en todo el ecosistema: la App y el Dashboard, Recepción y el Plan
 * Bienestar 100 Días® de Segunda Opinión Médica (SOM).
 *
 *  - Cada artículo es un archivo de datos: articulos/<slug>.php devuelve un array (título,
 *    resumen, secciones, métricas LE8, estadíos CKM, fuentes). Nada de HTML de página.
 *  - Esta plantilla lo muestra (biblioteca_pagina) con el pedido de turno de SOM al costado.
 *  - catalogo.php publica todo en JSON y como Bundle FHIR R4 de DocumentReference, para
 *    que las otras aplicaciones enlacen el mismo material.
 *  - Los umbrales son los mismos que usa SOM (recepcionistas: src/config/ckm.ts).
 *
 * Gobernanza: todo contenido médico queda con revisión «pendiente» hasta que lo firma el
 * equipo médico de SOM; la página lo dice y el catálogo lo publica (docStatus preliminary).
 */

require_once __DIR__ . '/../include/som-turnos.php';

if (!defined('BIBLIOTECA_SITIO')) {
    define('BIBLIOTECA_SITIO', 'https://plataforma.epa-bienestar.com.ar');
    define('BIBLIOTECA_URL', BIBLIOTECA_SITIO . '/biblioteca');
    // Sistemas de códigos (los de contenidos siguen la convención que ya usaba EPA).
    define('BIBLIOTECA_CS_CATEGORIA', 'http://epa-bienestar.com.ar/fhir/CodeSystem/content-category');
    define('BIBLIOTECA_CS_LE8', 'http://epa-bienestar.com.ar/fhir/CodeSystem/le8-metrica');
    define('BIBLIOTECA_CS_CKM', 'http://epa-bienestar.com.ar/fhir/CodeSystem/estadio-ckm');
}

/** Las 8 métricas de Life's Essential 8, con su página en español y su LOINC validado. */
function biblioteca_le8(): array
{
    return [
        'dieta' => ['nombre' => 'Alimentación', 'url' => '/le8-dieta-es', 'loinc' => null],
        'actividad-fisica' => ['nombre' => 'Actividad física', 'url' => '/le8-actividad-fisica-es', 'loinc' => '82290-8'],
        'nicotina' => ['nombre' => 'Exposición a nicotina', 'url' => '/le8-nicotina-es', 'loinc' => '72166-2'],
        'sueno' => ['nombre' => 'Sueño', 'url' => '/le8-sueno-es', 'loinc' => '93832-4'],
        'imc' => ['nombre' => 'Peso (IMC)', 'url' => '/le8-imc-es', 'loinc' => '39156-5'],
        'colesterol' => ['nombre' => 'Colesterol (no HDL)', 'url' => '/le8-colesterol-es', 'loinc' => '43396-1'],
        'glucosa' => ['nombre' => 'Glucosa (HbA1c)', 'url' => '/le8-glucosa-es', 'loinc' => '4548-4'],
        'presion' => ['nombre' => 'Presión arterial', 'url' => '/le8-presion-es', 'loinc' => '55284-4'],
    ];
}

/** Nombre de cada tipo de contenido (CodeSystem content-category). */
function biblioteca_tipos(): array
{
    return [
        'ckm' => 'Síndrome CKM',
        'le8' => "Life's Essential 8",
        'condicion' => 'Condiciones',
        'programa' => 'Programas',
        'evidencia' => 'Alimentos y suplementos: qué dice la evidencia',
    ];
}

/** Revisión médica por defecto: pendiente hasta la firma del equipo médico de SOM. */
function biblioteca_revision_pendiente(): array
{
    return ['estado' => 'pendiente', 'equipo' => 'Equipo médico de Segunda Opinión Médica'];
}

/**
 * Las páginas de Life's Essential 8 en español que ya existían (fuera de /biblioteca):
 * entran al catálogo tal cual, con revisión pendiente.
 */
function biblioteca_paginas_le8(): array
{
    $paginas = [
        ['life-essential-8-es', "Life's Essential 8: las 8 métricas de la salud cardiovascular", array_keys(biblioteca_le8())],
        ['le8-dieta-es', "Calidad de la alimentación (Life's Essential 8)", ['dieta']],
        ['le8-actividad-fisica-es', "Actividad física (Life's Essential 8)", ['actividad-fisica']],
        ['le8-nicotina-es', "Exposición a nicotina (Life's Essential 8)", ['nicotina']],
        ['le8-sueno-es', "Duración del sueño (Life's Essential 8)", ['sueno']],
        ['le8-imc-es', "Índice de masa corporal (Life's Essential 8)", ['imc']],
        ['le8-colesterol-es', "Colesterol y lípidos (Life's Essential 8)", ['colesterol']],
        ['le8-glucosa-es', "Glucosa en sangre (Life's Essential 8)", ['glucosa']],
        ['le8-presion-es', "Presión arterial (Life's Essential 8)", ['presion']],
        ['le8-estudiantes-es', "Life's Essential 8 para estudiantes de medicina", array_keys(biblioteca_le8())],
        ['le8-residentes-es', "Life's Essential 8 para residentes de cardiología", array_keys(biblioteca_le8())],
    ];
    $salida = [];
    foreach ($paginas as $p) {
        $salida[] = [
            'slug' => $p[0],
            'tipo' => 'le8',
            'titulo' => $p[1],
            'resumen' => '',
            'url' => BIBLIOTECA_SITIO . '/' . $p[0],
            'le8' => $p[2],
            'ckm' => [],
            'fuentes' => [[
                'cita' => "Lloyd-Jones DM, et al. Life's Essential 8: Updating and Enhancing the American Heart Association's Construct of Cardiovascular Health. Circulation. 2022;146:e18–e43.",
                'url' => 'https://doi.org/10.1161/CIR.0000000000001078',
            ]],
            'actualizado' => '2026-01-08',
        ];
    }
    return $salida;
}

/** Todos los artículos de /biblioteca (articulos/*.php), en el orden de su campo `orden`. */
function biblioteca_articulos(): array
{
    static $articulos = null;
    if ($articulos === null) {
        $articulos = [];
        foreach (glob(__DIR__ . '/articulos/*.php') as $archivo) {
            $a = include $archivo;
            if (is_array($a) && !empty($a['slug'])) {
                $a['url'] = BIBLIOTECA_URL . '/' . $a['slug'];
                $articulos[$a['slug']] = $a;
            }
        }
        uasort($articulos, function ($x, $y) {
            return ($x['orden'] ?? 999) <=> ($y['orden'] ?? 999);
        });
    }
    return $articulos;
}

/** Escapa para HTML. */
function biblioteca_e(?string $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/** Un ítem del catálogo (JSON), para la App, el Dashboard y Recepción. */
function biblioteca_item(array $a): array
{
    $le8 = biblioteca_le8();
    $loinc = [];
    foreach ($a['le8'] ?? [] as $m) {
        if (!empty($le8[$m]['loinc'])) {
            $loinc[] = $le8[$m]['loinc'];
        }
    }
    return [
        'id' => $a['slug'],
        'titulo' => $a['titulo'],
        'resumen' => $a['resumen'] ?? '',
        'url' => $a['url'],
        'tipo' => $a['tipo'],
        'idioma' => 'es-AR',
        'le8' => array_values($a['le8'] ?? []),
        'ckm' => array_values($a['ckm'] ?? []),
        'loinc' => array_values(array_unique($loinc)),
        'fuentes' => $a['fuentes'] ?? [],
        'revision' => $a['revision'] ?? biblioteca_revision_pendiente(),
        'actualizado' => $a['actualizado'] ?? null,
    ];
}

/** El mismo ítem como FHIR R4 DocumentReference (la página es el adjunto). */
function biblioteca_document_reference(array $a): array
{
    $tipos = biblioteca_tipos();
    $le8 = biblioteca_le8();
    $revision = $a['revision'] ?? biblioteca_revision_pendiente();
    $categorias = [[
        'coding' => [['system' => BIBLIOTECA_CS_CATEGORIA, 'code' => $a['tipo'], 'display' => $tipos[$a['tipo']] ?? $a['tipo']]],
    ]];
    foreach ($a['le8'] ?? [] as $m) {
        $coding = [['system' => BIBLIOTECA_CS_LE8, 'code' => $m, 'display' => $le8[$m]['nombre'] ?? $m]];
        if (!empty($le8[$m]['loinc'])) {
            $coding[] = ['system' => 'http://loinc.org', 'code' => $le8[$m]['loinc']];
        }
        $categorias[] = ['coding' => $coding];
    }
    foreach ($a['ckm'] ?? [] as $estadio) {
        $categorias[] = ['coding' => [['system' => BIBLIOTECA_CS_CKM, 'code' => (string) $estadio, 'display' => 'Estadío CKM ' . $estadio]]];
    }
    return [
        'resourceType' => 'DocumentReference',
        'id' => 'epa-biblioteca-' . $a['slug'],
        'identifier' => [['system' => BIBLIOTECA_URL, 'value' => $a['slug']]],
        'status' => 'current',
        'docStatus' => ($revision['estado'] ?? 'pendiente') === 'aprobado' ? 'final' : 'preliminary',
        'type' => ['text' => 'Contenido educativo'],
        'category' => $categorias,
        'date' => ($a['actualizado'] ?? date('Y-m-d')) . 'T00:00:00-03:00',
        'author' => [['display' => 'EPA Bienestar IA']],
        'description' => $a['titulo'],
        'content' => [[
            'attachment' => [
                'contentType' => 'text/html',
                'language' => 'es-AR',
                'url' => $a['url'],
                'title' => $a['titulo'],
            ],
        ]],
    ];
}

/** Muestra la página de un artículo (o 404). */
function biblioteca_pagina(string $slug): void
{
    $articulos = biblioteca_articulos();
    if (!isset($articulos[$slug])) {
        http_response_code(404);
        echo 'Artículo no encontrado.';
        return;
    }
    $a = $articulos[$slug];
    $le8 = biblioteca_le8();
    $tipos = biblioteca_tipos();
    $revision = $a['revision'] ?? biblioteca_revision_pendiente();

    $jsonld = [
        '@context' => 'https://schema.org',
        '@type' => 'MedicalWebPage',
        'name' => $a['titulo'],
        'description' => $a['resumen'] ?? '',
        'url' => $a['url'],
        'inLanguage' => 'es-AR',
        'dateModified' => $a['actualizado'] ?? null,
        'publisher' => ['@type' => 'Organization', 'name' => 'EPA Bienestar IA'],
        'citation' => array_map(function ($f) {
            return $f['cita'];
        }, $a['fuentes'] ?? []),
    ];
    $migas = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Inicio', 'item' => BIBLIOTECA_SITIO . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Biblioteca CKM-LE8', 'item' => BIBLIOTECA_URL . '/'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $a['titulo'], 'item' => $a['url']],
        ],
    ];
    $json = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT;
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= biblioteca_e($a['titulo']) ?> | Biblioteca CKM-LE8 · EPA Bienestar</title>
  <meta name="description" content="<?= biblioteca_e($a['resumen'] ?? '') ?>" />
  <meta name="robots" content="index, follow, max-image-preview:large" />
  <meta property="og:locale" content="es_AR" />
  <meta property="og:type" content="article">
  <meta property="og:title" content="<?= biblioteca_e($a['titulo']) ?>">
  <meta property="og:description" content="<?= biblioteca_e($a['resumen'] ?? '') ?>">
  <meta property="og:url" content="<?= biblioteca_e($a['url']) ?>">
  <link rel="canonical" href="<?= biblioteca_e($a['url']) ?>" />
  <script type="application/ld+json"><?= json_encode($jsonld, $json) ?></script>
  <script type="application/ld+json"><?= json_encode($migas, $json) ?></script>
  <style>
    .biblio-claves{background:#f5f9ff;border-left:4px solid #1f6fd1;border-radius:8px;padding:16px 20px;margin:20px 0}
    .biblio-claves ul{margin:0;padding-left:20px}
    .biblio-tabla{width:100%;border-collapse:collapse;margin:16px 0}
    .biblio-tabla th,.biblio-tabla td{border:1px solid #d6e4f5;padding:8px 10px;vertical-align:top;text-align:left}
    .biblio-tabla th{background:#eef4fc}
    .biblio-etiquetas a,.biblio-etiquetas span{display:inline-block;margin:0 6px 6px 0;padding:3px 10px;border-radius:14px;background:#eef4fc;font-size:14px}
    .biblio-fuentes li{margin-bottom:6px;font-size:15px}
    .biblio-revision{font-size:14px;color:#5b6b7f;border-top:1px solid #e3e9f1;padding-top:12px;margin-top:24px}
  </style>
  <?php include __DIR__ . '/../include/header.php' ?>

  <div class="page-banner-area">
    <div class="container">
      <div class="page-banner-content">
        <ul>
          <li><a href="<?= BIBLIOTECA_SITIO ?>/">Inicio</a></li>
          <li><a href="<?= BIBLIOTECA_URL ?>/">Biblioteca CKM-LE8</a></li>
          <li><?= biblioteca_e($a['titulo']) ?></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="blog-details-area ptb-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12">
          <div class="blog-details-desc">
            <div class="article-content">
              <p class="biblio-etiquetas"><span><?= biblioteca_e($tipos[$a['tipo']] ?? '') ?></span></p>
              <h1><?= biblioteca_e($a['titulo']) ?></h1>
              <p><?= biblioteca_e($a['resumen'] ?? '') ?></p>

              <?php if (!empty($a['claves'])): ?>
              <div class="biblio-claves">
                <strong>Lo más importante</strong>
                <ul>
                  <?php foreach ($a['claves'] as $clave): ?><li><?= $clave ?></li><?php endforeach ?>
                </ul>
              </div>
              <?php endif ?>

              <?php foreach ($a['secciones'] ?? [] as $i => $sec): ?>
              <h2 id="s<?= $i + 1 ?>"><?= biblioteca_e($sec['titulo']) ?></h2>
              <?= $sec['html'] ?>
              <?php endforeach ?>

              <?php if (!empty($a['le8']) || !empty($a['ckm'])): ?>
              <h2 id="relacionado">Relacionado</h2>
              <p class="biblio-etiquetas">
                <?php foreach ($a['le8'] ?? [] as $m): ?>
                <a href="<?= BIBLIOTECA_SITIO . $le8[$m]['url'] ?>">LE8 · <?= biblioteca_e($le8[$m]['nombre']) ?></a>
                <?php endforeach ?>
                <?php if (!empty($a['ckm'])): ?>
                <a href="<?= BIBLIOTECA_URL ?>/estadios-ckm">Estadíos CKM <?= biblioteca_e(implode(', ', $a['ckm'])) ?></a>
                <?php endif ?>
              </p>
              <?php endif ?>

              <h2 id="fuentes">Fuentes</h2>
              <ol class="biblio-fuentes">
                <?php foreach ($a['fuentes'] ?? [] as $f): ?>
                <li><?= biblioteca_e($f['cita']) ?><?php if (!empty($f['url'])): ?> <a href="<?= biblioteca_e($f['url']) ?>" target="_blank" rel="noopener"><?= biblioteca_e(preg_replace('#^https?://#', '', $f['url'])) ?></a><?php endif ?></li>
                <?php endforeach ?>
              </ol>

              <p class="biblio-revision">
                Contenido educativo: no reemplaza la consulta con un profesional.
                Revisión médica: <?= ($revision['estado'] ?? '') === 'aprobado' ? 'aprobada' : 'pendiente' ?>
                (<?= biblioteca_e($revision['equipo'] ?? '') ?>). Actualizado: <?= biblioteca_e($a['actualizado'] ?? '') ?>.
              </p>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-12">
          <aside class="widget-area">
            <div class="widget widget_categories">
              <ul class="desktop_scroll">
                <?php foreach ($a['secciones'] ?? [] as $i => $sec): ?>
                <li><a href="#s<?= $i + 1 ?>"><?= biblioteca_e($sec['titulo']) ?></a></li>
                <?php endforeach ?>
                <li><a href="#fuentes">Fuentes</a></li>
              </ul>
            </div>
            <div class="article-leave-comment" id="book-an-appointment">
              <?= som_cta_turno($a['titulo'], 'biblioteca-' . $a['slug']) ?>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </div>

<?php include __DIR__ . '/../include/footer.php' ?>
</html>
<?php
}

<?php include_once __DIR__ . '/include/som-turnos.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pedí tu turno | Segunda Opinión Médica · EPA Bienestar</title>
  <meta name="description" content="Pedí tu turno con Segunda Opinión Médica: consultas por especialidad, presenciales o por teleconsulta, y el Plan Bienestar 100 Días®. Te responde el equipo de Recepción por WhatsApp o en el portal." />
  <meta name="robots" content="index, follow" />
  <meta property="og:locale" content="es_AR" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="Pedí tu turno | Segunda Opinión Médica">
  <meta property="og:url" content="https://plataforma.epa-bienestar.com.ar/turnos">
  <link rel="canonical" href="https://plataforma.epa-bienestar.com.ar/turnos" />
  <?php include 'include/header.php' ?>

  <div class="page-banner-area">
    <div class="container">
      <div class="page-banner-content">
        <ul>
          <li><a href="https://plataforma.epa-bienestar.com.ar/">Inicio</a></li>
          <li>Pedí tu turno</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="blog-details-area ptb-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12">
          <h2>Pedí tu turno con Segunda Opinión Médica</h2>
          <p>Si leíste alguno de nuestros contenidos y querés que un especialista revise tu caso,
          el equipo de Recepción de Segunda Opinión Médica te ayuda a encontrar el turno.</p>

          <h3>¿Qué consultas hay?</h3>
          <ul>
            <li><strong>Consulta de segunda opinión por especialidad</strong>, presencial o por teleconsulta.</li>
            <li><strong>Plan Bienestar 100 Días®</strong>: un programa con consultas de seguimiento a lo largo de 100 días.</li>
          </ul>

          <h3>¿Cómo pido el turno?</h3>
          <ol>
            <li><strong>Por WhatsApp:</strong> escribinos y te responde Recepción. Tu consulta queda registrada y te avisamos por el mismo chat.</li>
            <li><strong>En el portal:</strong> creá tu cuenta o entrá con la tuya y reservá desde «Reservar».</li>
          </ol>

          <?= som_cta_turno('', 'turnos') ?>

          <p class="mt-4"><small>Este sitio no guarda tus datos: el turno se gestiona por WhatsApp o en el
          portal de Segunda Opinión Médica. El contenido de este sitio es informativo y no reemplaza la
          consulta con un profesional.</small></p>
        </div>
      </div>
    </div>
  </div>

<?php include 'include/footer.php' ?>
</html>

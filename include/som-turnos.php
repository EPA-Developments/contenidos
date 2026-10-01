<?php
/**
 * Turnos: la conexión de los contenidos con Recepción de Segunda Opinión Médica (SOM).
 *
 * Reemplaza los formularios de turnos anteriores (book-appointment*.php, el del lateral y
 * el de la portada), que guardaban credenciales en el código o mandaban los datos del
 * paciente a terceros. Este sitio ya no guarda credenciales ni datos de nadie: el turno se
 * pide por los dos canales que atiende Recepción de SOM.
 *
 *  - WhatsApp de SOM: el mensaje entra en Mensajes de Recepción (un número nuevo queda como
 *    contacto nuevo, con su aviso en la pestaña WhatsApp y la campanita), con el tema que
 *    estaba leyendo ya escrito, así Recepción sabe de dónde viene.
 *  - Portal del paciente: crear la cuenta o entrar y reservar. Lleva
 *    `utm_source=contenidos` para que el CRM de SOM registre el origen del paciente.
 *
 * Todo se configura acá, en un solo lugar.
 */

/** Portal del paciente de SOM. */
if (!defined('SOM_PORTAL_URL')) {
    define('SOM_PORTAL_URL', 'https://app.segundaopinionmedica.org');
}
/** WhatsApp de SOM (E.164 sin "+"): el número de la WABA que atiende Recepción. */
if (!defined('SOM_WHATSAPP')) {
    define('SOM_WHATSAPP', '15554435352');
}
/** Origen de los pacientes que llegan desde estos contenidos (CRM de SOM: origen-lead). */
if (!defined('SOM_UTM_SOURCE')) {
    define('SOM_UTM_SOURCE', 'contenidos');
}

if (!function_exists('som_slug_actual')) {
    /** El slug de la página actual ("acute-myocarditis"), para saber qué contenido trajo el turno. */
    function som_slug_actual(): string
    {
        $ruta = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $slug = strtolower(preg_replace('/\.php$/', '', basename($ruta)));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        return trim(substr($slug, 0, 80), '-');
    }

    /** "acute-myocarditis" → "acute myocarditis" (el tema, legible, para el mensaje). */
    function som_tema_de_slug(string $slug): string
    {
        // Las páginas en español, con su nombre (el slug no lleva tildes).
        $temas = [
            'life-essential-8-es' => "Life's Essential 8",
            'le8-actividad-fisica-es' => "Life's Essential 8: actividad física",
            'le8-colesterol-es' => "Life's Essential 8: colesterol",
            'le8-dieta-es' => "Life's Essential 8: alimentación",
            'le8-estudiantes-es' => "Life's Essential 8 para estudiantes",
            'le8-glucosa-es' => "Life's Essential 8: glucosa",
            'le8-imc-es' => "Life's Essential 8: peso (IMC)",
            'le8-nicotina-es' => "Life's Essential 8: nicotina",
            'le8-presion-es' => "Life's Essential 8: presión arterial",
            'le8-residentes-es' => "Life's Essential 8 para residentes",
            'le8-sueno-es' => "Life's Essential 8: sueño",
            'evaluacion-inicial' => 'Evaluación inicial',
        ];
        return $temas[$slug] ?? trim(str_replace('-', ' ', $slug));
    }

    /** Link de WhatsApp a Recepción con el mensaje ya escrito. */
    function som_url_whatsapp(string $tema = ''): string
    {
        $tema = strip_tags($tema);
        $tema = trim(function_exists('mb_substr') ? mb_substr($tema, 0, 120) : substr($tema, 0, 120));
        $texto = 'Hola, quiero pedir un turno en Segunda Opinión Médica.'
            . ($tema !== '' ? " Vengo de leer: «{$tema}»." : '');
        return 'https://wa.me/' . SOM_WHATSAPP . '?text=' . rawurlencode($texto);
    }

    /** Link al portal de SOM, con el origen para el CRM. */
    function som_url_portal(string $campania = ''): string
    {
        return SOM_PORTAL_URL . '/?' . http_build_query([
            'utm_source' => SOM_UTM_SOURCE,
            'utm_medium' => 'web',
            'utm_campaign' => $campania !== '' ? $campania : 'turnos',
        ]);
    }

    /**
     * El bloque "Pedí tu turno" (WhatsApp + portal). Sin argumentos usa la página actual
     * como tema del mensaje y como campaña; `$tema = ''` manda el mensaje sin tema (portada,
     * página de turnos).
     */
    function som_cta_turno(?string $tema = null, string $campania = ''): string
    {
        static $estilos = false;
        $slug = som_slug_actual();
        $campania = $campania !== '' ? $campania : ($slug !== '' && $slug !== 'index' ? $slug : 'turnos');
        $tema = $tema ?? ($slug !== 'index' ? som_tema_de_slug($slug) : '');
        $whatsapp = htmlspecialchars(som_url_whatsapp($tema), ENT_QUOTES, 'UTF-8');
        $portal = htmlspecialchars(som_url_portal($campania), ENT_QUOTES, 'UTF-8');

        $css = '';
        if (!$estilos) {
            $estilos = true;
            $css = '<style>'
                . '.som-turno{border:1px solid #d6e4f5;border-radius:12px;padding:24px;background:#f5f9ff}'
                . '.som-turno h4{margin-bottom:8px}.som-turno p{margin-bottom:16px}'
                . '.som-turno .som-turno-botones{display:flex;flex-wrap:wrap;gap:12px}'
                . '.som-turno .som-turno-botones a{flex:1 1 200px;text-align:center}'
                . '.som-turno small{display:block;margin-top:12px;color:#5b6b7f}'
                . '</style>';
        }

        return $css
            . '<div class="som-turno" id="pedir-turno">'
            . '<h4>Pedí tu turno con Segunda Opinión Médica</h4>'
            . '<p>Consultas por especialidad, presenciales o por teleconsulta, y el Plan Bienestar 100 Días®. '
            . 'Te responde el equipo de Recepción.</p>'
            . '<div class="som-turno-botones">'
            . '<a class="default-btn" href="' . $whatsapp . '" target="_blank" rel="noopener">Escribinos por WhatsApp</a>'
            . '<a class="default-btn" href="' . $portal . '" target="_blank" rel="noopener">Reservá en el portal</a>'
            . '</div>'
            . '<small>No te pedimos datos en esta página: el turno se gestiona por WhatsApp o en el portal de Segunda Opinión Médica.</small>'
            . '</div>';
    }
}

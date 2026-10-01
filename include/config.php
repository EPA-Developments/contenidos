<?php
/**
 * Configuración privada del sitio (credenciales de la base de datos, de Medplum…).
 *
 * NUNCA va en el repositorio ni dentro de la carpeta pública. Se lee, en este orden:
 *  1. de una variable de entorno (p. ej. `SetEnv DB_PASSWORD …` en el VirtualHost de
 *     Apache, o el panel del hosting);
 *  2. de `epa-config.php`, en la carpeta de ARRIBA de la raíz del sitio (fuera de
 *     public_html), que devuelve un array:
 *         <?php return ['DB_PASSWORD' => '…', 'MEDPLUM_CLIENT_SECRET' => '…'];
 *
 * Si falta, devuelve null y la página que la necesita lo informa sin mostrar nada privado.
 */

if (!function_exists('epa_config')) {
    function epa_config(string $clave): ?string
    {
        static $archivo = null;

        $valor = getenv($clave);
        if ($valor !== false && $valor !== '') {
            return $valor;
        }
        if ($archivo === null) {
            $ruta = dirname(__DIR__, 2) . '/epa-config.php';
            $archivo = is_file($ruta) ? (array) include $ruta : [];
        }
        return isset($archivo[$clave]) && $archivo[$clave] !== '' ? (string) $archivo[$clave] : null;
    }
}

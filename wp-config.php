<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'vtrycomunidad');//Base de datos Wordpress  
define('DB_NAME_2', 'portalcable');// Base de datos portalcable

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'vtruser');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'aplicada2012');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'pmavtr.ida.cl');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'tl1>}VGbnWdBx%ryF-#2Bbc@oH!H`R+(Eb1:vJ=orsnr[A#l6i9YHa@L08?nd3Rr'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'vmH0rG-y1e~1ngzE5)#(2s8 `G*r7Yw.=~_}v][7R$)7_~pQADbQ/%-^H<WZvQy}'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 'Y^B_>lkunY_%DhY8Z-3X8RnnZ6qi7:MvS?@QF3B*-:R2|q`o]-do[UKJ%Mz+Y.tk'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', '|PX#nOTg(CWYJpHlH?ILujs*]qo)8>URI:cj+-l5YkS:xExpgkb<(fWu+t|L4$@m'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', '@9<Ez|`n}/rACk^_Q[UAlJ&L r]o~H8VHSXd.`e)-Q*b<bh|<ax1NbAPcjvdE=(*'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'ItlqJ!*x`x0{0,V_m2a.w+E]>l;MPw+ zvHp3.|^~L^B|z3QRfdJ)DCgz.!reH-F'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', 'v.w_4IwYooF,0Vr0!pK2ya}+D|ca12cnv_t5+jBs(G;;SuyQ X6*(~hZ6nF3E)7e'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', '7e2nm0lf@gM#j$,#>F[mCI5.)i%T}:v$rU|#CtS(=r[|#NSw0bD9jy?0l8wh<Nh#'); // Cambia esto por tu frase aleatoria.

define('WP_ALLOW_REPAIR', true);
define('WP_MEMORY_LIMIT', '256M');
/**#@-*/
define('WP_SITEURL', 'http://' . $_SERVER['HTTP_HOST'] );
define('WP_HOME', 'http://' . $_SERVER['HTTP_HOST'] );
/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_2_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_POST_REVISIONS', 1);

define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');


define('CONCATENATE_SCRIPTS', false);

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


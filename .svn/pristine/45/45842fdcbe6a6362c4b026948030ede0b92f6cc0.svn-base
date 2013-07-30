<?php

/*
 * Plugin Name: Utilidades IDA
 * Plugin URI: http://ida.cl
 * Description: Conjunto de Funciones Utilitarias
 * Version: 1.0
 * Author: Max Villegas, Fernando Silva, jorge Codina
 * Author URI: http://ida.cl
 */

/**
 * 
 * printMe
 * 
 * Imprime string formateado "<pre>$thing</pre>"
 *
 * @name printMe
 * @param string|array|object|int $thing 
 * @return string
 */
function printMe($thing) {
    echo '<pre>';
    print_r($thing);
    echo '</pre>';
}

class Ida {

    function __construct() {
        add_action('wp_ajax_ajax_zone', array($this, 'ajax_zone'));
        add_action('wp_ajax_nopriv_ajax_zone', array($this, 'ajax_zone'));
    }

    function ajax_zone() {
        require_once 'ajax.php';
        $handler = new AjaxHandler();
        if (method_exists($handler, $_REQUEST['func'])) {
            $handler->{$_REQUEST['func']}();
        } else {
            die("Error D:");
        }
    }

    /**
     *
     * cortar
     * 
     * Devuelve el valor de $str cortado en base al numero de caracteres ($n) terminando con "..."
     * 
     * @name cortar
     * @param string $str
     * @param int $n
     * @return string
     */
    function cortar($str, $n, $vermas = false) {
        
        $vermas = $vermas ? $vermas : '...';
        
        $str = trim($str);
        $str = strip_tags($str);
        if (strlen($str) > $n) {
            $out = substr($str, 0, $n);
            $out = explode(" ", $out);
            array_pop($out);
            $out = implode(" ", $out) . $vermas;
        } else {
            $out = $str;
        }
        return $out;
    }

    /**
     *
     * get_the_embed
     * 
     * Recibe un url de un video online y devuelve el embed formateado bajo los parametros que se pasan en $sizeStr, lista de sitios soportados por wordpress en http://codex.wordpress.org/Embeds
     * 
     * @name get_the_embed
     * @global object $wp_embed
     * @param string $url ej: http://www.youtube.com/?v=ss645vasd
     * @param string $sizeStr ej: 'width="100" height="300"'
     * @return string 
     */
    function get_the_embed($url, $sizeStr = '') {
        global $wp_embed;
        $post_embed = $wp_embed->run_shortcode('[embed ' . $sizeStr . ']' . $url . '[/embed]');
        return $post_embed;
    }

    /**
     *
     * tellTheDate
     * 
     * Recibe un string de fecha en formato dd/mm/yyyy y lo devuelveescrito en palabras en espa�ol!
     * 
     * @param string $dateStr Debe tener el formato dd/mm/yyyy, sino este gato morira http://www.funnypictures.net.au/images/kitten-with-hands-up-gun-pointed-at-it1.jpg
     * @param string $format Formato de fecha, formatos disponibles en http://cl.php.net/manual/es/function.strftime.php
     * @return string fecha formateada ej : Viernes 14 de Mayo, 2012
     */
    function tellTheDate($dateStr, $format = "%A %d de %B, %Y") {
        setlocale(LC_TIME, 'es_ES'); // setea el idioma
        if ($dateStr) {
            $fecha = explode("/", $dateStr);
            $timeStamp = gmmktime(0, 0, 0, $fecha[1], $fecha[0], $fecha[2]);
            return utf8_encode(strftime($format, $timeStamp));
        }
    }

    /**
     *
     * return_comments_number
     * 
     * Devuelve el n�mero de comentarios asociados a un post
     * 
     * @name return_comments_number
     * @param int $pid, post_id
     * @return string 
     */
    function return_comments_number($pid = false) {
        $number = get_comments_number($pid);
        if ($number > 1) {
            $output = str_replace('%', number_format_i18n($number), '%');
        } elseif ($number == 0) {
            $output = '0';
        } else {
            $output = '1';
        }
        return $output;
    }

    /**
     *
     * countPostOverTime
     * 
     * Devuelve el n�ero de posts publicados en los ultimos x dias ($dayNum), este numero puede ser filtrado por $post_type y por $category
     * 
     * @name countPostOverTime
     * @global object $wpdb
     * @param string $post_type
     * @param srting|int $dayNum
     * @param string $category
     * @return int 
     */
    function countPostOverTime($post_type, $dayNum, $category = false, $author = false) {
        global $wpdb;

        if ($author) {
            $author = "AND $wpdb->posts.post_author = $author";
        }

        if ($category) {
            $number = $wpdb->get_var("
                SELECT COUNT(ID) 
                FROM $wpdb->posts 
                INNER JOIN $wpdb->term_relationships
                ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
                INNER JOIN $wpdb->terms
                ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->terms.term_id)
                WHERE $wpdb->posts.post_status = 'publish' 
                AND $wpdb->posts.post_type = '$post_type' 
                AND $wpdb->posts.post_date >= DATE_SUB(CURRENT_DATE, INTERVAL $dayNum DAY) 
                AND $wpdb->terms.slug = '$category' 
            ");
        } else {
            $number = $wpdb->get_var("
                SELECT COUNT(ID) 
                FROM $wpdb->posts 
                WHERE $wpdb->posts.post_status = 'publish' 
                AND $wpdb->posts.post_type = '$post_type' 
                AND $wpdb->posts.post_date >= DATE_SUB(CURRENT_DATE, INTERVAL $dayNum DAY)
            ");
        }
        return $number;
    }

    /**
     *
     * breadcrumb
     * 
     * Devuelve un string html con los breadcrums, Es importante revisar la estructura html devuelto en cada sitio en que se use
     * 
     * @name breadcrumb
     * @global object $post
     * @return string html
     */
    function breadcrumb() {
        global $post;
        $out = "";

        if (!is_front_page()) {
            $out .= '<div id="breadcrumb">';
            $out .= '<a href="' . home_url() . '" title="Inicio" rel="index">Guía TV VTR</a>';
            if (is_category()) {
                $out .= '<span class="separador">&raquo;</span>';
                $out .= ucfirst(single_cat_title("", false));
            } elseif (is_page()) {
                if ($post->post_parent && count($post->ancestors) <= 1) {
                    $out .= '<span class="separador"> &raquo; </span>';
                    $out .= '<a class="bc-item" href="' . get_permalink($post->post_parent) . '" title="' . get_the_title($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>';
                }
            } elseif (is_single() && !is_attachment()) {
                if (get_post_type() != 'post') {
                    $term =  wp_get_post_terms($post->ID, 'categoria-entradas');
                    $out .= '<span class="separador"> &raquo; </span>';
                    $out .= '<a href="' . home_url() . '/' . $term[0]->slug . '/">' . $term[0]->name . '</a>';
                    $out .= '<span class="separador"> &raquo; </span>';
                    $out .= get_the_title();
                } else {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $out .= '<span class="separador"> &raquo; </span>';
                    $out .= '<a href="' . get_category_link($cat->term_id) . '">' . ucfirst($cat->name) . '</a>';
                    $out .= '<span class="separador"> &raquo; </span>';
                    $out .= get_the_title();
                }
            } elseif (is_tax()) {
                $out .= '<span class="separador"> &raquo; </span>';
                $out .= '<span class="bc-item end-item">' . single_term_title('', false) . '</span>';
            }
            if (!is_single() && !is_category() && !is_search() && !is_tax()) {
                $out .= '<span class="separador"> &raquo; </span>';
                $out .= '<span class="bc-item end-item">' . get_the_title() . '</span>';
            }
            $out .= '</div>';
        }
        return $out;
    }

    /**
     *
     * mailMe
     * 
     * Envia un mail formateado en base a la plantilla propuesta, 
     * 
     * @todo proponer formato de html en base al sitio
     * @param string $titulo 
     * @param string $subtitulo
     * @param string $contenido
     * @param string $subject 
     * @param string $from
     * @param string $destino
     * @param string $attachment 
     * @uses wp_mail()
     * @return void
     */
    function mailMe($titulo, $subtitulo, $contenido, $subject, $from, $destino, $attachment = null) {
        /**
         * filtro para enviar mails html 
         */
        add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));

        $cont = '
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            </head>
            <body style="background-color:#EDEDED">
            <div style="background-color:#fff; padding:60px;">
                <div style="height: 137px; width: 500px; padding-top: 20px; padding-left: 20px; padding-right: 20px; padding-bottom: 20px; text-align: left;">
                    <img alt="Fundación Democracia y Desarrollo" src="' . get_bloginfo('template_directory') . '/images/logo.png" />
                </div>
                <div style="color: #666; width: 500px; padding-top: 20px; padding-left: 115px; padding-right: 20px; padding-bottom: 20px; text-align: left; font-size: 12px; border-bottom:3px solid #AAA">
                    <h1 style="font-size: 28px; font-weight: bold; text-transform: uppercase; line-height: 100%; margin-bottom: 20px; color:#333;">' . $titulo . '</h1>
                    <p style="font-size: 14px; line-height: 100%; margin-bottom: 20px; color:#666" >' . $subtitulo . '</p>
                    ' . $contenido . '
                </div>
                <div style="color: #666; width: 500px; padding-top: 20px; padding-left: 115px; padding-right: 20px; padding-bottom: 20px; text-align: left; font-size: 12px; background-color:#EDEDED">
                    <img alt="Fundacion Democracia y Desarrollo" src="' . get_bloginfo('template_directory') . '/images/logo-footer.png" />
                </div>        
            </div>
            </body>
        </html>';
        $headers = 'From: Contacto | Fundación Democracia y Desarrollo <' . $from . '>' . "\r\n";
        wp_mail($destino, $subject, $cont, $headers, $attachment);
    }

    /**
     *
     * getPagination
     * 
     * Devuelve un string html formateado con los lnks de paginaci�n
     * 
     * @name getPagination
     * @param object $query, WP_Query, puede ser el objeto $wp_query o cualquier instancia personalizada de WP_Query
     * @param string $baseURL, debe ser el url de la pagina en donde se ejecuta la funci�n, ej: si la pagina es http://www.misitio.com/entradas/ entonces $baseURL = "/entradas/"
     * @param bool $echo, echo or return?
     * @return string 
     */
    function getPagination($query = false, $prev = 'Anterior', $next = 'Siguiente') {
        global $wp_query, $wp_rewrite;
        $out = '';

        if ($query == false) {
            $query = $wp_query;
        }

        $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;
        $pagination = array(
            'base' => @add_query_arg('paged', '%#%'),
            'format' => '',
            'total' => $query->max_num_pages,
            'current' => $current,
            'prev_text' => __($prev),
            'next_text' => __($next),
            'type' => 'array'
        );
        if ($wp_rewrite->using_permalinks())
            $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'pagina/%#%/', 'paged');

        if (!empty($query->query_vars['s']))
            $pagination['add_args'] = array('s' => $query->get('s'));

        $pageLinks = paginate_links($pagination);

        foreach ((array) $pageLinks as $linkTag) {
            $out .= '<li>' . $linkTag . '</li>';
        }

        return '<ul id="pagination" class="pagination">' . $out . '</ul>';
    }

    /**
     *
     * get_calendario
     * 
     * Devuelve un string html formateado en base a un <table> a modo de calendario
     * 
     * @param int $year
     * @param int $month
     * @param int $day_name_length
     * @param int $first_day
     * @return string 
     */
    function get_calendario($year = false, $month = false, $day_name_length = 2, $first_day = 0) {
        setlocale(LC_TIME, 'es_ES'); // setea el idioma
        if ($year == false) {
            $year = date('Y');
        }
        if ($month == false) {
            $month = date('n');
        }
        $first_of_month = gmmktime(0, 0, 0, $month, 1, $year);

        $day_names = array(); // Genera los nombres de los dias segun el idioma
        for ($n = 0, $t = (3 + $first_day) * 86400; $n < 7; $n++, $t+=86400) { // Magia negra ( January 4, 1970 was a Sunday )
            $day_names[$n] = ucfirst(gmstrftime('%A', $t));
        } // %A devuelve el nombre del dia completo

        list($month, $year, $month_name, $weekday) = explode(',', gmstrftime('%m,%Y,%B,%w', $first_of_month));
        $weekday = ($weekday + 7 - $first_day) % 7; // Ajuste para el primer dia del mes
        $title = ucfirst($month_name) . ' - ' . $year;  // may�sculas al nombre del mes, junto con el a�o

        $calendar = '<table id="calendarioGeneral" data-curmes="' . $month . '" data-curyear="' . $year . '">' . "\n" .
                '<caption class="calendar-month">' . $title . "</caption>\n<tr>";

        if ($day_name_length) { // si $day_name_length es mayor a 4, renderea el nombre completo
            foreach ($day_names as $d) {
                $calendar .= '<th abbr="' . htmlentities($d) . '">' . htmlentities($day_name_length < 4 ? substr($d, 0, $day_name_length) : $d) . '</th>';
            }
            $calendar .= "</tr>\n<tr>";
        }

        if ($weekday > 0) {
            $calendar .= '<td colspan="' . $weekday . '">&nbsp;</td>';
        } // genera un td vac�o para completar los dias que faltan
        for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {
            if ($weekday == 7) {
                $weekday = 0; // Empieza una semana nueva
                $calendar .= "</tr>\n<tr>";
            }
            if (date('Y') . date('n') . date('j') == $year . $month . $day) {
                $bold = '<strong>';
                $boldend = '</strong>';
            } else {
                $bold = '';
                $boldend = '';
            }

            $calendar .= '<td data-realdate="' . $year . $month . $day . '" >' . $bold . $day . $boldend . '</td>';
        }
        if ($weekday != 7)
            $calendar .= '<td colspan="' . (7 - $weekday) . '">&nbsp;</td>'; // genera un td vac�o para completar los dias que faltan

        return $calendar . "</tr>\n</table>\n";
    }

    function getTitleTag() {
        global $post, $paged;
        $out = '';
        if (is_home() || is_front_page()) {
            $out.= get_bloginfo('description') ? get_bloginfo('name') . ' | ' . get_bloginfo('description') : get_bloginfo('name');
        } else {
            if (is_singular()) {
                $out .= get_the_title($post->ID) . ' | ';
            } elseif (is_404()) {
                $out .= 'P&aacutegina no encontrada | ';
            } elseif (is_search()) {
                $out .= 'B&uacutesqueda por "' . $_GET['s'] . '" | ';
            } elseif (is_category() || is_tag() || is_tax()) {
                $out .= single_term_title('', false);
            }
            if ($paged > 1) {
                $out .= 'p&aacutegina ' . $paged . ' | ';
            }
            $out .= get_bloginfo('name');
        }
        echo $out;
    }

    function getDescriptionTag() {
        global $post, $paged;
        $out = '';
        if (is_home() || is_front_page()) {
            $out.= get_bloginfo('description');
        } else {
            if (is_singular()) {
                $out .= $this->cortar($post->post_content, 140);
            } else {
                $out .= get_bloginfo('description');
            }
        }
        echo $out;
    }

    /**
     * rastrea una pagina  o sitio por curl y obtiene el estado del servicio (200 = ok)
     * @param string url //completa inclye http://
     * @return status 200 o 305
     */
    function getcurl($getURL, $formvars = false) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($formvars != false)
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formvars);
        $page = curl_exec($ch);
        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
        }
        curl_close($ch);
        return $page;
    }

}

$ida = new Ida();
?>

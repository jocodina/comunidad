<?php

setlocale(LC_ALL, "es_ES");
$gloablTransienTime = 60 * 6 * 1;
include ('functions-vod.php');
include(get_stylesheet_directory() . '/includes/widget-facebook-wall.php');

function query_destacados($param = false) {
    global $gloablTransienTime;
    $fecha = date("Y") . date("m") . date("d");
    extract(shortcode_atts(array(
                'post_type' => 'post',
                'items' => 5, //posts_per_page
                'taxonomy' => "posiciones",
                'term' => "destacado",
                'post_status' => 'publish',
                'transient' => false
                    ), $param));

    $args = array(
        'post_type' => $post_type,
        'category_name' => $cat,
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term
            )
        ),
        'posts_per_page' => $items,
        'order' => 'DESC',
        'orderby' => 'meta_value_num', //menu_order
        'meta_key' => 'fecha_destacado',
        'post_status' => $post_status,
        'meta_query' => array(
            array(
                'key' => 'fecha_destacado',
                'value' => $fecha,
                'compare' => "<=",
                'type' => "DATE"
            )
        ),
    );


    if (false === ( $dest = get_transient($transient) )) {
        $dest = new WP_Query($args);
        set_transient($transient, $dest, $gloablTransienTime);
    }
}

if (!is_admin()) {
    add_action('loadDestacado', 'query_destacados', 10, 1);
}

function loop_destacados($param = false, $quiero) {
    global $ida, $wpdb_pr;

    if (false === ( $dest = get_transient("query_destacado_" . $param["post_type"]) )) {
        do_action('loadDestacado', array("post_type" => $param["post_type"], "items" => 5, 'transient' => "query_destacado_" . $param["post_type"]));
        do_action('loadDestacado', array("post_type" => 'post', "items" => 6, 'transient' => 'query_destacado_xml'));
    }

    $out = "";
    $i = 100;
    $dest = get_transient("query_destacado_" . $param["post_type"]);
    while ($dest->have_posts()) : $dest->the_post();
        $right = "";
        $canal_horario = get_post_meta($dest->post->ID, 'ficha_data', true);
        $image = $param["post_type"] == "fichas-vod" ? wp_get_attachment_image(get_field("imagen_destacada_home"), 'slideHome') : get_the_post_thumbnail($dest->post->ID, 'slideHome');
        if ($quiero == "control") {
            $acti = $i == 100 ? 'class = "active"' : "";
            $out .= '<li ' . $acti . '><p><a href="#" class="evt" data-func="control_destacados" data-tab="tab_' . $dest->post->ID . '"><strong>' . get_the_title() . ' &raquo</strong>' . $ida->cortar(get_field('ficha_abstract'), 85) . '</a></p></li>';
        }
        if ($quiero == "slide") {
            $pidsField = get_field('ProgramID', $post->ID);
            $pidsArray = explode(',', $pidsField);

            foreach ($pidsArray as $pidsList) {
                $pidsArrayToImplode[] = "'" . $pidsList . "'";
            }

            $pids = implode(",", $pidsArrayToImplode);
            $query = "SELECT ChannelID FROM $wpdb_pr->sch WHERE ProgramID IN ($pids) LIMIT 1";
            $sch = $wpdb_pr->get_var($query) ? $wpdb_pr->get_var($query) : '';

            $imagen_url = $wpdb_pr->get_var("SELECT imagentrans FROM $wpdb_pr->chn_web WHERE codigo = '$sch' LIMIT 1");
            $imagen_url = $imagen_url ? '<img src="' . get_bloginfo('template_url') . '/img/foto/' . $imagen_url . '" alt="' . get_the_title() . '" />' : '';

            if (get_the_content()) {
                $content = get_the_content();
            } elseif (get_the_excerpt()) {
                $content = get_the_excerpt();
            } else {
                $content = get_field('ficha_abstract');
            }
            if (!empty($imagen_url))
                $right = '<p class="rigth">';
            $right .= $imagen_url;
            if (get_field('dia_destacado') && get_field('hora_destacado')) {
                $right .= '<span>';
                $right .= get_field('dia_destacado') . ' ' . get_field('hora_destacado');
                $right .= '</span>';
            }
            $right .= '</p>';

            $acti = $i == 100 ? 'style = "display:block"' : 'style = "display:none"';
            $out .= '<li ' . $acti . ' data-tab="tab_' . $dest->post->ID . '" style="z-index: ' . ($i) . '; "><div class="thumb"><a href="' . get_permalink() . '" title="' . get_the_title() . '" rel="contents">' . $image . '</a></div><div class="sliderDesc clearfix"><p class="left"><strong><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></strong><span>' . $ida->cortar($content, 160) . '</span></p> ' . $right . ' </div></li>';
            unset($pidsArrayToImplode);
        }
        $i--;
    endwhile;

    return $out;
}

function loop_destacados_goVTR($quiero) {
    global $ida, $gloablTransienTime;
    $out = "";
    $i = 100;
    $fichas = get_field('fichas_govtr', "option");
    foreach ($fichas as $ficha):
        if ($quiero == "control") {
            $acti = $i == 100 ? 'class = "active"' : "";
            $out .= '<li ' . $acti . '><p><a href="#" class="evt" data-func="control_destacados" data-tab="tab_' . $i . '"><strong>' . $ficha["titulo_govtr"] . ' &raquo</strong>' . $ida->cortar($ficha['descripcion_govtr'], 85) . '</a></p></li>';
        }
        if ($quiero == "slide") {
            $out .= '<li data-tab="tab_' . $i . '" style="z-index: ' . ($i) . '; "><div class="thumb"><a href="' . $ficha["url_govtr"] . '" title="' . $ficha["titulo_govtr"] . '"><img src="' . $ficha["imagen_govtr"]["sizes"]["slideHome"] . '" alt="' . $ficha["alt"] . '"/></a></div><div class="sliderDesc"><strong>' . $ficha["titulo_govtr"] . '</strong><p>' . $ida->cortar($ficha['descripcion_govtr'], 160) . '</p></div></li>';
        }
        $i--;
    endforeach;
    return $out;
}

function hoyVTRTransient() {
    global $wpdb_pr, $wpdb;
    $hoyenvtr = get_transient("hoyenvtr");
    if (false == $hoyenvtr || $hoyenvtr == '') :
        //obtengo las programadas por sebastian
        $wp_query = new WP_Query($args = array(
                    'post_type' => 'post',
                    'order' => 'DESC',
                    'posts_per_page' => 12,
                    'tax_query' => array(
                        array(
                            'taxonomy' => "posiciones",
                            'field' => 'slug',
                            'terms' => "hoy-en-vtr"
                        )
                    ),
                    'order' => 'DESC',
                    'orderby' => 'meta_value_num', //menu_order
                    'meta_key' => 'fecha_hoyvtr',
                    'post_status' => "publish",
                    'meta_query' => array(
                        array(
                            'key' => 'fecha_hoyvtr',
                            'value' => date('ymd'),
                            'compare' => "=",
                            'type' => "DATE"
                        )
                    ),
                ));
        if ($wp_query->have_posts()) :
            while ($wp_query->have_posts()) : $wp_query->the_post();
                $fichas[] = $wp_query->post->ID;
            endwhile;
        endif;
        wp_reset_postdata();
        wp_reset_query();
        //obtengo las randoms        
        $wpdb->query("DELETE FROM wp_options WHERE `option_name` = 'hoy_en_vtr'");
        $fecha = !$fecha ? date('mdy') : $fecha;
        $channels = $wpdb_pr->get_results("SELECT ChannelID FROM CHN_PC WHERE 1 ORDER BY RAND() LIMIT 50");
        foreach ($channels as $channel) {
            $result_prg = get_chnprog($channel->ChannelID, $fecha);
            foreach ($result_prg as $program) {
                $fichaid = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
                if ($fichaid != 0) {
                    $fichas[] = $fichaid;
                }
            }
            $result_prg_next = get_chnprog_next($channel->ChannelID, $fecha);
            foreach ($result_prg_next as $program) {
                $fichaid = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
                if ($fichaid != 0) {
                    $fichas[] = $fichaid;
                }
            }
        }
        $hoyenvtr = rand(1, 5000);
        $fichas = array_unique($fichas, SORT_NUMERIC);
        update_option("hoy_en_vtr", $fichas, "no");
        set_transient("hoyenvtr", $fichas, $gloablTransienTime);
    endif;
}

function hoyenvtr($args = array()) {
    global $wpdb_pr, $wpdb, $gloablTransienTime, $horario;

    extract(shortcode_atts(array(
                'items' => 12,
                'imageSize' => 'thumbnail',
                'sociales' => true,
                'transient' => 'query_hoy_en_vtr',
                'post_status' => 'publish'
                    ), $args));

    $out = "";
    $fecha = date('mdy');
    $hora = (date('H')) . date("i");
    $manana = date('m') . (date('d') + 1) . date('y');
    if ($horario == 4) {
        $bn = '0400';
        $bp = '2000';
    } else {
        $bn = '0300';
        $bp = '2100';
    }


    //Post desde el tarnsient con array de IDs
    $postin = get_option("hoy_en_vtr");

    $args = array(
        'post_type' => 'post',
        'order' => 'DESC',
        'posts_per_page' => $items,
        'post__in' => $postin,
        'order' => 'DESC',
        'orderby' => 'post__in', //Preserve post ID order given
    );

    if (false === ( $wp_query = get_transient($transient) )) {
        $wp_query = new WP_Query($args);
        set_transient($transient, $wp_query, $gloablTransienTime);
    }

    $i = 0;
    if ($wp_query->have_posts()) :

        while ($wp_query->have_posts()) : $wp_query->the_post();
            $seguimiento = false;
            $pids = explode(",", get_post_meta($wp_query->post->ID, 'ProgramID', true));
            foreach ($pids as $pid) {
                $schs = $wpdb_pr->get_results("SELECT ProgramID, ChannelID, StartTime FROM $wpdb_pr->sch WHERE $wpdb_pr->sch.ProgramID = '$pid' AND StartDate ='$fecha' ORDER BY StartTime ASC LIMIT 1", 'OBJECT'); // AND StartTime >= '$hora'
                foreach ((array) $schs as $sch) {
                    if ($sch->ChannelID != "") {
                        $channelid = $sch->ChannelID;
                        $starttime = $sch->StartTime;
                        break;
                    }
                }
                $schs_manana = $wpdb_pr->get_results("SELECT ProgramID, ChannelID, StartTime FROM $wpdb_pr->sch WHERE $wpdb_pr->sch.ProgramID = '$pid' AND StartDate ='$manana' AND StartTime >= '0000' AND StartTime <= '$bn' ORDER BY StartTime ASC LIMIT 1", 'OBJECT');
                foreach ($schs_manana as $sch_manana) {
                    if ($sch_manana->ChannelID != "") {
                        $channelid = $sch_manana->ChannelID;
                        $starttime = $sch_manana->StartTime;
                        break;
                    }
                }
            }
            $premiumImg = get_field("tipo_ficha", $wp_query->post->ID) == "Premium" ? '<img class="premiumimg" src="' . get_bloginfo('template_url') . '/images/premicon.png" />' : '';
            $cat = wp_get_object_terms($wp_query->post->ID, "category");
            $out .= '<article data-chnid = "' . $sch->ChannelID . '" data-postID="' . $wp_query->post->ID . '" class="grid_4 alpha program-info">';
            $out .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail($wp_query->post->ID, $imageSize) . '</a>';
            $out .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            $out .= '<small class="cat-list">' . $cat[0]->name . '</small>';
            $out .= '<div class="date prem">' . get_horalocal($starttime) . ' | ' . get_nombre_canal($channelid) . $premiumImg . '</div>';
            if ($sociales == true) {
                $out .= '<div class="sharers-box clearfix">';
                $out .= '<div class="fb-like" data-href="' . get_permalink() . '" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>';
                $out .= '<div class="tw-share"><a href="https://twitter.com/share" class="twitter-share-button" data-url="' . get_permalink() . '" data-via="ComunidadTV" data-lang="es">Tweet</a>';
                $out .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
                $out .= '</div>';
                $out .= '</div>';
            }

            $out .= '</article>';
            $i++;
            $sch->ChannelID = "";
            $sch->StartTime = "";
            $sch->ProgramID = "";
            $starttime = "";
            $channelid = "";
            
        endwhile;
        wp_reset_postdata();
        wp_reset_query();
        return $out;
    else:
        wp_reset_postdata();
        wp_reset_query();
        return "<p>No hay publicaciones.</p>";
    endif;
}

add_action('init', 'hoyVTRTransient');

function get_horalocal($starttime, $GTM = true, $format = false) {
    global $horario;

    $hour = mktime(substr($starttime, 0, 2) - $horario, substr($starttime, -2), 0, date('m'), date('d'), date('Y'));

    $hour = date("H:i", $hour);
    if ($format) {
        $hour = date("Hi", $hour);
    }

    $minutos = substr($starttime, -2);
    return $hour;
}

function get_horalocal_duration($starttime, $duration) {
    global $horario;
    $hora = substr($starttime, 0, 2) + substr($duration, 0, 2) - $horario;
    $minutos = substr($starttime, -2) + substr($duration, -2);
    $horareal = mktime($hora, $minutos);

    return date("G:i", $horareal);
}

function get_fechalocal($startdate) {
    $fechaLocal = mktime(00, 00, 00, substr($startdate, 0, 2), substr($startdate, 2, 2), substr($startdate, -2));
    $date = date("d/m/Y", $fechaLocal);
    return $date;
}

function get_nombre_canal($chnid) {
    global $wpdb_pr, $wpdb;
    return $wpdb_pr->get_var("SELECT senal FROM tbl_data WHERE codigo = '$chnid'");
}

function mostshared($param) {
    $out = "";
    extract(shortcode_atts(array(
                'post_type' => 'post',
                'cat' => false,
                'items' => 6, //posts_per_page
                'taxonomy' => false,
                'field' => false,
                'terms' => false,
                'order' => "DESC",
                'orderby' => false,
                'meta_key' => false,
                'post_status' => 'publish',
                'key' => false,
                'value' => false,
                'compare' => false,
                'type' => false,
                'quiero' => false
                    ), $param));

    if ($post_type) {
        $cons['post_type'] = $post_type;
    }
    if ($cat) {
        $cons['category_name'] = $cat;
    }
    if ($items) {
        $cons['posts_per_page'] = $items;
    }
    if ($taxonomy) {
        $cons['tax_query'][0]['taxonomy'] = $taxonomy;
    }
    if ($field) {
        $cons['tax_query'][0]['field'] = $field;
    }
    if ($terms) {
        $cons['tax_query'][0]['terms'] = $terms;
    }
    if ($order) {
        $cons['order'] = $order;
    }
    if ($orderby) {
        $cons['orderby'] = $orderby;
    }
    if ($post_status) {
        $cons['post_status'] = $post_status;
    }
    if ($meta_key) {
        $cons['meta_key'] = $meta_key;
    }

    $consulta = new WP_Query($cons);

    while ($consulta->have_posts()) : $consulta->the_post();
        $cat = wp_get_object_terms($consulta->post->ID, "category");
        if ($quiero == "shared") {
            $pid = get_the_ID();
            $sharedTotal = get_post_meta($pid, "_sharedTotal", true);
            $sharedTwitter = get_post_meta($pid, "_sharedTwitter", true);
            $sharedFacebook = get_post_meta($pid, "_sharedFacebook", true);
            $block = '<div class="social ' . $css_class_font . '"><span class="fb-count">' . $sharedFacebook . '</span><span class="tw-count">' . $sharedTwitter . '</span></div>'; //<span class="gplus-count">' . $plusones . '</span>
        }
        if ($quiero == "commented") {

            $num_comments = get_comments_number(); // get_comments_number returns only a numeric value

            if (comments_open()) {
                if ($num_comments == 0) {
                    $comments = __('Sin Comentarios');
                } elseif ($num_comments > 1) {
                    $comments = $num_comments . __(' Comentarios');
                } else {
                    $comments = __('1 Comentario');
                }
                $write_comments = '<a href="' . get_comments_link() . '">' . $comments . '</a>';
            } else {
                $write_comments = __('Comments are off for this post.');
            }


            $block = '<div class="comment-count">' . $comments . ' </div>';
        }
        $tipo = wp_get_post_terms($post->ID, 'categoria_ficha', array("fields" => "names"));
        $out .=' <li><a href="' . get_permalink() . '" title="' . get_the_title() . '"><strong>' . get_the_title() . '</strong></a><small>' . $cat[0]->name . '</small>' . $block . '</li>';
    endwhile;
    wp_reset_query();
    return $out;
}

function lo_mas_visto() {
    global $wpdb_pr;
    $out = "";
    $items = get_field("mas_vistoVTR", 'option');
    $key = 0;
    foreach ($items as $item) {
        $pidsField = get_field('ProgramID', $item->ID);
        $pidsArray = explode(',', $pidsField);

        foreach ($pidsArray as $pidsList) {
            $pidsArrayToImplode[] = "'" . $pidsList . "'";
        }

        $pids = implode(",", $pidsArrayToImplode);
        $query = "SELECT ChannelID FROM $wpdb_pr->sch WHERE ProgramID IN ($pids) LIMIT 1";
        $sch = $wpdb_pr->get_var($query) ? $wpdb_pr->get_var($query) : '';

        $imagen_url = $wpdb_pr->get_var("SELECT imagen40x40 FROM $wpdb_pr->chn_web WHERE codigo = '$sch' LIMIT 1");
        $imagen_url = $imagen_url ? '<img src="' . get_bloginfo('template_url') . '/img/foto/' . $imagen_url . '" alt="' . $item->post_title . '" />' : '<img src="' . get_bloginfo('template_url') . '/images/chan_default.png" alt="' . $item->post_title . '" class="chan_thumbnail" />';

        $out .= '<li class="lo-mas-visto-' . $key . ' clearfix"><a href="' . get_permalink($item->ID) . '" title="' . $item->post_title . '"><h2 class="chan_title">' . $item->post_title . '</h2></a>' . $imagen_url . '</li>';
        $key++;

        unset($pidsArrayToImplode);
    }
    return $out;
}

function blockNews($param) {
    global $ida;
    $out = "";
    extract(shortcode_atts(array(
                'post_type' => 'post',
                'category_name' => false,
                'items' => 6, //posts_per_page
                'taxonomy' => false,
                'field' => false,
                'terms' => false,
                'order' => "ASC",
                'orderby' => false,
                'meta_key' => false,
                'post_status' => 'publish',
                'quiero' => false
                    ), $param));

    if ($post_type) {
        $cons['post_type'] = $post_type;
    }
    if ($category_name) {
        $cons['category_name'] = $category_name;
    }
    if ($items) {
        $cons['posts_per_page'] = $items;
    }
    if ($taxonomy) {
        $cons['tax_query'][0]['taxonomy'] = $taxonomy;
    }
    if ($field) {
        $cons['tax_query'][0]['field'] = $field;
    }
    if ($terms) {
        $cons['tax_query'][0]['terms'] = $terms;
    }
    if ($order) {
        $cons['order'] = $order;
    }
    if ($orderby) {
        $cons['orderby'] = $orderby;
    }
    if ($meta_key) {
        $cons['meta_key'] = $meta_key;
    }
    if ($post_status) {
        $cons['post_status'] = $post_status;
    }
    $news = new WP_Query($cons);
    if ($news->have_posts()) : $i = 0;
        $out = "";
        while ($news->have_posts()) :
            $i++;
            $news->the_post();
            $sharedTotal = get_post_meta($news->post->ID, "_sharedTotal", true) ? get_post_meta($news->post->ID, "_sharedTotal", true) : 2;
            $out .='<div class="poster-thumb grid_1 alpha"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail($news->post->ID, "newshome") . '</a></div>';
            $out .='<div class="noticia-content grid_3 omega">';
            $out .='    <h1><a href="' . get_permalink() . '" title="' . get_the_title() . '"> ' . get_the_title() . '</a></h1>';
            if ($terms == "opinion-y-top-10")
                $out .= '<small class="meta-data">Por: <span>' . get_the_author() . '</span> | ' . get_the_date("d-m-Y") . '</small>';
            $content = get_field('bajada_entrada', $news->post->ID) ? $ida->cortar(get_field('bajada_entrada', $news->post->ID), 150) : $ida->cortar(get_the_content(), 150);
            $out .='    <p>' . $content . '</p>';
            $out .='    <a class="button-see" href="' . get_permalink() . ' ">leer más</a><span class="shared-count"> Compartido ' . $sharedTotal . ' veces</span>';
            $out .='</div>';
        endwhile;
    else:
        return " <p>No hay posts!</p>";
    endif;
    wp_reset_query();
    return $out;
}

function registerSidebars() {
    if (function_exists('register_sidebar')) {

        register_sidebar(array(
            'name' => 'Sidebar Comunidad',
            'id' => 'sidebar-comunidad',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>'
        ));

        register_sidebar(array(
            'name' => 'Sidebar Noticias Comunidad',
            'id' => 'sidebar-comunidad-noticias',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>'
        ));

        register_sidebar(array(
            'name' => 'Widgets 2 (Central Izquierdo - Home)',
            'id' => 'widgets-2',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h1>',
            'after_title' => '</h1>'
        ));

        register_sidebar(array(
            'name' => 'Sidebar VOD',
            'id' => 'sidebar-vod',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>'
        ));
    }
}

add_action('init', 'registerSidebars');

function SearchFilter($query) {
    if ($query->is_search) {
        // Insert the specific post type you want to search
        $query->set('post', 'feeds');
    }
    return $query;
}

//add_filter('pre_get_posts', 'SearchFilter');
/* =============================================================================
  Theme Support
  ========================================================================== */

if (function_exists('add_theme_support')) {

    add_theme_support('menus'); // Add Menu Support

    add_theme_support('post-thumbnails'); // Add Thumbnail Theme Support
}

/* =============================================================================
  Functions
  ========================================================================== */

// Load Custom Theme Scripts using Enqueue
function html5blank_scripts() {

    if (!is_admin()) {

//        wp_deregister_script('jquery'); // Unregister WordPress jQuery
//        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', 'jquery', '1.8.1'); // Load Google CDN jQuery
//        wp_enqueue_script('jquery'); // Enqueue it!
//
//        wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', 'jquery', '2.6.2'); // Modernizr with version Number at the end
//        wp_enqueue_script('modernizr'); // Enqueue it!
//
//        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/script.js', 'script', '1.0.0'); // HTML5 Blank script with version number
//        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        };
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    };

    return $classes;
}

function horarioSingle() {
    global $wpdb, $post, $wpdb_pr, $horario;

    if ($horario == 4) {
        $bn = '0400';
        $bp = '2000';
    } else {
        $bn = '0300';
        $bp = '2100';
    }
    $out = "<h2>Horario</h2>";
    $pidsField = get_field('ProgramID', $post->ID);
    $pidsArray = explode(',', $pidsField);

    foreach ($pidsArray as $pidsList) {
        $pidsArrayToImplode[] = "'" . $pidsList . "'";
    }

    $i = 0;
    $date = setStartDate(date('mdy'), date("Hi"));
    $ahora = date("Hi");
    $pids = implode(",", $pidsArrayToImplode);
    $query = "SELECT StartTime,StartDate,ChannelID,Duration,ProgramID FROM $wpdb_pr->sch WHERE ProgramID IN ($pids) AND StartTime > $ahora LIMIT 100";
    $sch = $wpdb_pr->get_results($query);
    //query 1
    foreach ($sch as $var) {
        $row[setStartDate($var->StartDate, $var->StartTime)]["StartTime"] = $var->StartTime;
        $row[setStartDate($var->StartDate, $var->StartTime)]["StartDate"] = $var->StartDate;
        $row[setStartDate($var->StartDate, $var->StartTime)]["ChannelID"] = $var->ChannelID;
        $row[setStartDate($var->StartDate, $var->StartTime)]["Duration"] = $var->Duration;
        $row[setStartDate($var->StartDate, $var->StartTime)]["ProgramID"] = $var->ProgramID;
    }
    //query 2 
    $hoy = date('mdy');
    $query_next = "SELECT StartTime,StartDate,ChannelID,Duration,ProgramID FROM $wpdb_pr->sch WHERE ProgramID IN ($pids) AND StartTime >= 0000 AND StartTime <= $bn AND StartDate!= $hoy LIMIT 100";
    $sch_next = $wpdb_pr->get_results($query_next);
    foreach ($sch_next as $var) {
        $row[setStartDate($var->StartDate, $var->StartTime)]["StartTime"] = $var->StartTime;
        $row[setStartDate($var->StartDate, $var->StartTime)]["StartDate"] = $var->StartDate;
        $row[setStartDate($var->StartDate, $var->StartTime)]["ChannelID"] = $var->ChannelID;
        $row[setStartDate($var->StartDate, $var->StartTime)]["Duration"] = $var->Duration;
        $row[setStartDate($var->StartDate, $var->StartTime)]["ProgramID"] = $var->ProgramID;
    }
    
    $row ? ksort($row) : '';

    if ($row) {
        foreach ((array) $row as $var):
            $dato->StartTime = $var["StartTime"];
            $dato->StartDate = $var["StartDate"];
            $dato->ChannelID = $var["ChannelID"];
            $dato->Duration = $var["Duration"];
            $dato->ProgramID = $var["ProgramID"];
            $imagen_url = $wpdb_pr->get_var("SELECT imagen FROM $wpdb_pr->chn_web WHERE codigo = '$dato->ChannelID' LIMIT 1");
            $senal = $wpdb_pr->get_var("SELECT senal FROM $wpdb_pr->chn_web WHERE codigo = '$var->ChannelID' LIMIT 1");
            $out .='<div data-startime="' . $var->StartTime . '" data-startdate="' . $dato->StartDate . '" data-channel="' . $dato->ChannelID . '" data-programid="' . $dato->ProgramID . '"  data-channel="' . $dato->ChannelID . '" data-duration="' . $dato->Duration . '" class="canales-programacion-detalle clearfix">';
            $out .='<span class="logoCanal"><img src="' . get_bloginfo('template_url') . '/img/foto/' . $imagen_url . '" alt="' . $senal . '" /></span>';
            $out .='<span class="fechaLocal">' . get_fechalocal($dato->StartDate) . '</span>';
            $out .='<span class="HoraLocal">' . get_horalocal($dato->StartTime) . ' hrs - ' . get_horalocal_duration($dato->StartTime, $dato->Duration) . ' hrs</span>';
            $out .='</div>';
            $i++;
            if ($i > 5) {
                break;
            }

        endforeach;
    } else {
        $out .='<div class="no-horario">';
        $out .='<p>No existe horario de programación para este programa.';
        $out .='</div>';
        $out .= '<h2 class="mbottom">Recomendamos Hoy</h2>';
        $out .= hoyenvtr($args = array('items' => 2, 'imageSize' => 'ficha-vod-small', 'sociales' => false, 'transient' => 'query-hoyvtr_single'));
    }

    return $out;
}

function ordenarfechas($a, $b) {
    if ($a->timestamp == $b->timestamp) {
        return 0;
    }
    return ($a->timestamp > $b->timestamp) ? -1 : 1;
}

function setStartDate($date, $time) {
    $mes = substr($date, 0, 2);
    $dia = substr($date, 2, 2);
    $ano = substr($date, -2);
    $hora = substr($date, 0, 2);
    $minuto = substr($date, -2);

    $timestamp = mktime($hora, $minuto, 0, $mes, $dia, $ano);

    return $timestamp;
}

function mes_abreviado($f) {

    $mes = $f;
    switch ($f) {
        case "Jan": $mes = "Ene";
            break;
        case "Apr": $mes = "Abr";
            break;
        case "Dec": $mes = "Dic";
            break;
    }
    return $mes;
}

//nuevo RSS

if ($_GET['grilla'] == 'xml' and $_GET['get'] == 'destacado') {
    xmldestacado();
}

if ($_GET['type'] == 'xml' and $_GET['featured'] == 'destacado') {
    xmldestacado();
}

function get_comescore_script() {

    $ctag = '200846';
    $pag = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

    if (is_page(49494) || is_page(49771)) {
        $ctag = '200847';
    } elseif (is_category(4)) {
        $ctag = '200848';
    } elseif (is_category(5)) {
        $ctag = '200849';
    } elseif (is_category(35)) {
        $ctag = '200851';
    } elseif (is_singular('post')) {
        $ctag = '200863';
    }

    $out = '<script src="http://b.scorecardresearch.com/c2/6906514/cs.js#sitio_id=' . $ctag . '&path=http://' . $pag . '"></script>';
    return $out;
}

function get_analytics() {


    if ((is_page('vod') || is_tax('categorias-vod') || is_singular('fichas-vod'))) {
        echo <<<EOD
   
<script type="text/javascript"> var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-8061465-11']); _gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); })(); swfobject.registerObject("FlashID"); </script>

EOD;
    } else {
        echo <<<EOD
   
   <script type="text/javascript">
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
   </script>
   <script type="text/javascript">
        try {
        var pageTracker = _gat._getTracker("UA-8061465-48");
        pageTracker._trackPageview();
        } catch(err) {}
   </script>

EOD;
    }
}

function get_external_html($getURL, $transient) {
    global $ida, $gloablTransienTime;
    $html = get_transient($transient);
    if ($html === false || $html === '') {
        $html = base64_encode($ida->getcurl($getURL));
        set_transient($transient, $html, $gloablTransienTime);
    }
    return base64_decode($html);
}

/* =============================================================================
  Actions + Filters + ShortCodes
  ========================================================================== */

// Filters
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)

add_action('wp_enqueue_scripts', 'html5blank_scripts');
add_action('wp_footer', 'get_analytics');

add_image_size('slideHome', 630, 400, true); //(cropped)
add_image_size('single', 620, 315, true); //(cropped)

add_image_size('newshome', 60, 60, true); //(cropped)

/* =============================================================================
  Shortcodes
  ========================================================================== */
?>

<?php

/*
  Plugin Name: Ajax by Ida
  Plugin URI: http://ida.cl
  Description: Desarrollo de funciones ajax para wordpress
  Version: 1.0
  Author: Ideas Digitales plicadas
  Author URI: http://ida.cl
  License: Open Source
 */

function ajax_vod() {

    if ($_GET['func'] == 'getFeatVOD') {
        $i = 0;

        $destacados = new WP_Query(array(
                    'post_type' => 'fichas-vod',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'posiciones',
                            'field' => 'slug',
                            'terms' => 'destacado-vod'
                        )
                    ),
                    'posts_per_page' => 7,
                    'post_status' => 'publish'
                ));


        if ($destacados->have_posts()) {
            while ($destacados->have_posts()) {
                $destacados->the_post();
                $imageurl = wp_get_attachment_image_src(get_post_thumbnail_id($destacados->post->ID), "ficha-vod-single");

                $fichas[$i] = array('src' => $imageurl[0],
                    'callurl' => get_permalink(),
                    'target' => '_self',
                    'desde' => '2013-01-02 00:00:00', //todo fechas?
                    'hasta' => '2015-12-31 23:59:59');               //todo fechas?

                $i++;
            }
        }

        $out = json_encode($fichas);

        die($out);
    } elseif ($_POST['func'] == 'lightboxGallery') {
        $out = "";
        $i = 1;
        foreach (get_field('ficha_wallpaper2', $_POST['pid']) as $imagen) {
            if ($i == $_POST['imagen']) {


                $file = wp_get_attachment_metadata($imagen['adjuntar_wallpaper']);

                if ($file["width"] > $file["height"]) {
                    $width = 800;
                }
                if ($file["width"] < $file["height"]) {
                    $width = 440;
                }
                if ($file["width"] == $file["height"]) {
                    $width = 800;
                }
                $src = wp_get_attachment_image_src($imagen['adjuntar_wallpaper'], 'full');


                $out .= '<div class="fancybox-skin">';
                $out .= '<div class="fancybox-outer">';
                $out .= '<div class="fancybox-inner">';
                $out .= '<img src="' . $src[0] . '" alt="' . get_the_title($_POST['pid']) . '" width="' . $width . '" />';
                $out .= '</div>';
                $out .= '</div>';
                $out .= '<div class="fancybox-title fancybox-title-float-wrap">';
                $out .= '<span class="child">' . $imagen['image_descripcion'] . '</span>';
                $out .= '</div>';
                $out .= '<a href="#" class="a-close evtnew" data-func="closelightbox">Cerrar</a>';
                $out .= '</div>';
            }
            $i++;
        }

        die(json_encode(array("width" => $width, "out" => $out)));
    } elseif ($_POST['func'] == 'ajaxPagination') {

        $postnotin = json_decode($_POST['noin']);

        $out = getBlockEntradas(array('post_type' => 'entradas', 'posts_per_page' => 10, 'taxonomy' => 'categoria-entradas', 'term' => $_POST['term'], 'post_not_in' => $postnotin, 'offset' => $_POST['offset']));

        die($out);
    } elseif ($_POST['func'] == 'searchPagination') {
        $pagination = $_POST['pagination'] != 'false' ? $_POST['pagination'] : false;
        $out = searchQuery(array('post_type' => $_POST['term'], 'posts_per_page' => 10, 'offset' => $_POST['offset'], 'taxonomy' => $_POST['tax'], 'term' => $_POST['cat'], 'search' => $_POST['search'], 'pagination' => $pagination));
        die($out);
    }
}

add_action('wp_ajax_ajax_vod', 'ajax_vod');
add_action('wp_ajax_nopriv_ajax_vod', 'ajax_vod');

function mobiledetection(){
    global $platform;

    if (method_exists($platform, 'isMobile')) {
        if (($platform->isMobile() == true && $platform->isTablet() == false) && (!is_page('mobile'))) {
            echo json_encode(array('device' => 'mobile'));
            exit;
        } elseif ($platform->isTablet() == true && !is_page('tablet')) {
            echo json_encode(array('device' => 'tablet'));
            exit;
        }else{
            echo json_encode(array('device' => 'desktop'));
            exit;
        }
    }
}

add_action('wp_ajax_mobiledetection', 'mobiledetection');
add_action('wp_ajax_nopriv_mobiledetection', 'mobiledetection');

function saveShared() {
    global $ida;

    if (is_numeric($_GET['saveSharedPid'])) {

        $pid = $_GET['saveSharedPid'];
        $plink = get_permalink($pid);
        $fbcount = json_decode($ida->getcurl("http://graph.facebook.com/" . urldecode($plink)));
        $twcount = json_decode($ida->getcurl("http://urls.api.twitter.com/1/urls/count.json?url=" . urldecode($plink)));

        update_post_meta($pid, '_sharedFacebook', $fbcount->shares);
        update_post_meta($pid, '_sharedTwitter', $twcount->count);

        $sharedTwitter = get_post_meta($pid, "_sharedTwitter", true);
        $sharedFacebook = get_post_meta($pid, "_sharedFacebook", true);


        update_post_meta($pid, '_sharedTotal', $sharedTwitter + $sharedFacebook);
        $sharedTotal = get_post_meta($pid, "_sharedTotal", true);

        $out = json_encode(array("shared" => array("twitter" => $sharedTwitter, "facebook" => $sharedFacebook, "total" => $sharedTotal)));
    } else {
        $out = json_encode(array("shared" => "error no pid"));
    }
    die($out);
}

add_action('wp_ajax_saveShared', 'saveShared');
add_action('wp_ajax_nopriv_saveShared', 'saveShared');

function xmldestacado() {
    global $wpdb, $wpdb_pr;

    if ( $dest = get_transient("query_destacado_xml") ) {
        $out .= '<rss version="2.0">' . "\n";
        $out .= '<channel>' . "\n";
        $out .= '<title>Destacados de guiatvvtr.cl</title>' . "\n";
        $out .= '<copyright>Copyright (c) 2011 VTR.COM All rights reserved.</copyright>' . "\n";
        $out .= '<link>http://guiatvvtr.cl</link>' . "\n";
        $out .= '<category>Televisión</category>' . "\n";
        $out .= '<description>Destacados del Portal de televisión de VTR</description>' . "\n";
        $out .= '<language>es-CL</language>' . "\n";
        $out .= '<lastBuildDate>' . date('D, d M Y H:i:s') . ' GMT </lastBuildDate>' . "\n";
        $out .= '<ttl>35</ttl>' . "\n";
        $out .= '<image><title>VTR</title><url>http://vtr.com/images/logo_vtr_rss.jpg</url><link>http://vtr.com/</link></image>' . "\n";

        while ($dest->have_posts()) {
            $dest->the_post();
            $post_id = $dest->post->ID;
            $progid = "";
            $pids = "";
            $pids = $wpdb->get_var("SELECT meta_value FROM  $wpdb->postmeta WHERE meta_key='ProgramID' AND post_id = " . $post_id . " LIMIT 1");
            $i = 1;
            $progid = split(",", $pids);
            foreach ($progid as $pid) {
                $existe = $wpdb_pr->get_var("SELECT Title FROM $wpdb_pr->prog WHERE ProgramID = '" . $pid . "' LIMIT 1");
                if ($existe) {
                    $prog_id = $pid;
                    break;
                } else {
                    $prog_id = "";
                }
                $i++;
            }
            $Title = $wpdb_pr->get_var("SELECT Title FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1") ? $wpdb_pr->get_var("SELECT Title FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1") : "";

            if ($Title != "") {
                $Duration = $wpdb_pr->get_var("SELECT Duration FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $MovieReleaseYear = $wpdb_pr->get_var("SELECT MovieReleaseYear FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Director = $wpdb_pr->get_var("SELECT Director FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Actor1 = $wpdb_pr->get_var("SELECT Actor1 FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Actor2 = $wpdb_pr->get_var("SELECT Actor2 FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Actor3 = $wpdb_pr->get_var("SELECT Actor3 FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Actor4 = $wpdb_pr->get_var("SELECT Actor4 FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Actor5 = $wpdb_pr->get_var("SELECT Actor5 FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $Actor6 = $wpdb_pr->get_var("SELECT Actor6 FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");
                $ChannelID = $wpdb_pr->get_var("SELECT ChannelID FROM $wpdb_pr->prog WHERE ProgramID = '" . $prog_id . "' LIMIT 1");

                $out .= "<item>\n";
                if ($Title) {
                    $out .= '<title><![CDATA[' . $Title . ']]></title>' . "\n";
                }
                if ($Duration) {
                    $out .= '<duration>' . $Duration . '</duration>' . "\n";
                }
                if ($MovieReleaseYear) {
                    $out .= '<year>' . $MovieReleaseYear . '</year>' . "\n";
                }
                if ($Director) {
                    $out .= '<director><![CDATA[' . $Director . ']]></director>' . "\n";
                }
                if ($Actor1) {
                    $out .= '<actor1><![CDATA[' . $Actor1 . ']]></actor1>' . "\n";
                }
                if ($Actor2) {
                    $out .= '<actor2><![CDATA[' . $Actor2 . ']]></actor2>' . "\n";
                }
                if ($Actor3) {
                    $out .= '<actor3><![CDATA[' . $Actor3 . ']]></actor3>' . "\n";
                }
                if ($Actor4) {
                    $out .= '<actor4><![CDATA[' . $Actor4 . ']]></actor4>' . "\n";
                }
                if ($Actor5) {
                    $out .= '<actor5><![CDATA[' . $Actor5 . ']]></actor5>' . "\n";
                }
                if ($Actor6) {
                    $out .= '<actor6><![CDATA[' . $Actor6 . ']]></actor6>' . "\n";
                }
                if ($ChannelID) {
                    $out .= "<channel>" . $ChannelID . "</channel>\n";
                }
                $attachment_id = get_post_thumbnail_id($post_id);




                $full = wp_get_attachment_image_src($attachment_id, "slideHome");
                $fichaTablet = wp_get_attachment_image_src($attachment_id, "fichaTablet");
                $destacadoTablet = wp_get_attachment_image_src($attachment_id, "destacadoTablet");
                $destacadoMobilSmall = wp_get_attachment_image_src($attachment_id, "destacadoMobilSmall");
                $destacadoMobilBig = wp_get_attachment_image_src($attachment_id, "destacadoMobilBig");
                $fichaMobile = wp_get_attachment_image_src($attachment_id, "fichaMobile");
                $mobileProgram = wp_get_attachment_image_src($attachment_id, "mobileProgram");
                $mobileSearch = wp_get_attachment_image_src($attachment_id, "mobileSearch");
                $programacion = wp_get_attachment_image_src($attachment_id, "programacion");
                $thumbnail = wp_get_attachment_image_src($attachment_id, "thumbnail");
                $content = $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE ID=$post_id");
                $abstarct = !empty($content) ? $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE ID=$post_id") : get_post_meta($post_id, "ficha_abstract", true);

                $out .= '<fichaid>' . $post_id . '</fichaid>' . "\n";
                $out .= '<porgramid>' . $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='ProgramID' AND post_id=$post_id") . '</porgramid>' . "\n";
                $out .= '<image_fichatablet><![CDATA[' . $fichaTablet[0] . ']]></image_fichatablet>' . "\n";
                $out .= '<image_destacadotablet><![CDATA[' . $destacadoTablet[0] . ']]></image_destacadotablet>' . "\n";
                $out .= '<image_destacadomobilsmall><![CDATA[' . $destacadoMobilSmall[0] . ']]></image_destacadomobilsmall>' . "\n";
                $out .= '<image_destacadomobilbig><![CDATA[' . $destacadoMobilBig[0] . ']]></image_destacadomobilbig>' . "\n";
                $out .= '<image_fichamobile><![CDATA[' . $fichaMobile[0] . ']]></image_fichamobile>' . "\n";
                $out .= '<image_mobileprogram><![CDATA[' . $mobileProgram[0] . ']]></image_mobileprogram>' . "\n";
                $out .= '<image_mobilesearch><![CDATA[' . $mobilesearch[0] . ']]></image_mobilesearch>' . "\n";
                $out .= '<image_programacion><![CDATA[' . $programacion[0] . ']]></image_programacion>' . "\n";
                $out .= '<image_thumbnail><![CDATA[' . $thumbnail[0] . ']]></image_thumbnail>' . "\n";
                $out .= '<image><![CDATA[' . $full . ']]></image>' . "\n";
                $out .= '<link><![CDATA[' . get_permalink($post_id) . ']]></link>' . "\n";
                $out .= '<linkmobile><![CDATA[' . get_permalink($post_id) . '#pid=' . $prog_id . '&programs_id=' . $pids . ']]></linkmobile>' . "\n";
                $out .= '<description><![CDATA[<img src="' . $full[0] . '" alt="imagen"> <br /> ]]>' . $abstarct . '</description>' . "\n";
                $out .= "<pubDate>" . date('D, d M Y H:i:s') . " GMT</pubDate>\n";
                $out .= "</item>\n";
            }
            $imagen = "";
            $Title = "";
        }
        $out .= "</channel>\n";
        $out .= "</rss>\n";

        if (false === get_transient("xmlDest")) {
            update_option("xmlDest", $out);
        }
    }
    else{
        $out = get_option("xmlDest");
    }
    header("Content-Type:text/xml");
    echo $out;
    exit;
}

function searchprg() {
    global $grilla;
    if (isset($_GET['callback']) && $_GET['callback'] != "")
        echo $_GET['callback'] . "(" . json_encode($grilla->get_canales_busqueda(strip_tags($_GET['search']))) . ")";
    exit;
}

add_action('wp_ajax_searchprg', 'searchprg');
add_action('wp_ajax_nopriv_searchprg', 'searchprg');

add_action('wp_ajax_destacado', 'xmldestacado');
add_action('wp_ajax_nopriv_destacado', 'xmldestacado');
?>

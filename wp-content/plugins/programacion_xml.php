<?php

/*
  Plugin Name: programacion XML
  Plugin URI: maxvillegas.com
  Description: Sirve XML con datos de grilla segun
  Version: 2
  Author: Max Villegas
  Author URI: http://mvillegas.com/
 */
date_default_timezone_set('Chile/Continental');
$horario = date(Z) / 60 / 60 * -1;
//$horario=0;

if ($_GET['grilla'] == 'xml' and $_GET['get'] == 'channels') {
    $_GET['obt'] = true;    
    $inicio = $_GET['start'] ? $_GET['start'] : 0;
    $cantidad = $_GET['items'] ? $_GET['items'] : 10;
    $canal_tipo = $_GET['type'] ? $_GET['type'] : false;
    $favoritos = $_GET['chnid']? $_GET['chnid']:false;
    $ciudad = $_GET['ciudad']? $_GET['ciudad']:"santiago";    


    $r = get_canales($inicio, $cantidad, $canal_tipo, $favoritos, $ciudad);

    header("Content-Type:text/xml");
echo' <rss version="2.0">
            <channel>
               <title>Canales de Televisión</title>
                        <copyright>Copyright (c) 2011 VTR.COM All rights reserved.</copyright>
                        <link>http://televisionvtr.cl/programacion/</link>
                        <category>Channels Television</category>
                        <description>Lista de canales del portal de televisión de VTR</description>
                        <language>es-CL</language>
                        <lastBuildDate>'.date('D, d M Y H:i:s').' GMT </lastBuildDate>
                        <ttl>35</ttl>
                                   <image>
                                               <title>VTR</title>
                                               <url>http://vtr.com/images/logo_vtr_rss.jpg</url>
                                               <link>http://vtr.com/</link>
                                   </image>'
            ;

    foreach ($r as $canal) {
       $canal->senal = str_replace('&', "&amp;", $canal->senal);        
        echo "<item>
            <title>" . $canal->senal . "</title>
            <guid>" . $canal->codigo . "</guid> 
            <link>http://televisionvtr.cl/programacion/?grilla=xml&amp;get=schedule&amp;channel=" . $canal->codigo . "</link>                 
            <image>http://televisionvtr.cl/wp-content/themes/televisionvtr/img/foto/" .  $canal->imagen . "</image>
            <category><![CDATA[" . $canal->genero . "]]></category>
            <description><![CDATA[" . $canal->driver . "]]></description>
            </item>
            ";
    }
echo "  </channel></rss>";
    exit;
}

if ($_GET['grilla'] == 'xml' and $_GET['get'] == 'schedule') {
    $channel = $_GET['channel'] ? $_GET['channel'] : false;
    $date = $_GET['date'] ? $_GET['date'] : false;
    $first = get_chnprog($channel, $date);
    $second = get_chnprog_next($channel, $date);
    $chan = get_canal_nombre($channel);
    $chan = str_replace('&', "&amp;", $chan);
    
    header("Content-Type:text/xml");
echo' <rss version="2.0">
            <channel>
               <title>Programación de Canal:  '. $chan .' </title>
                        <copyright>Copyright (c) 2011 VTR.COM All rights reserved.</copyright>
                        <link>http://televisionvtr.cl/</link>
                        <category>Scheduling Television</category>
                        <description>Scheduling de '.$chan .'</description>
                        <language>es-CL</language>
                        <lastBuildDate>'.date('D, d M Y H:i:s').' GMT </lastBuildDate>
                        <ttl>35</ttl>
                                   <image>
                                               <title>VTR</title>
                                               <url>http://vtr.com/images/logo_vtr_rss.jpg</url>
                                               <link>http://vtr.com/</link>
                                   </image>';

    foreach ($first as $program) {
        echo "<item>";
        $program->Title = str_replace('&', "&amp;", $program->Title);        
        $program->ficha = 0;
        $program->image = "http://televisionvtr.cl/wp-content/themes/televisionvtr/img/foto/minificha.jpg";
        $program->description =  $program->Desc1? "<![CDATA[".$program->Desc1."]]>": "<![CDATA[".$program->Desc2."]]>";
        $program->link = "http://televisionvtr.cl/programacion/?grilla=xml&amp;get=program&amp;pid=$program->ProgramID&amp;startdate=$program->StartDate&amp;starttime=$program->StartTime";
        $ini_hora =  substr($program->StartTime, 0, 2) - $horario;
        if ($ini_hora<0) $ini_hora = 24 + $ini_hora;
        if ($ini_hora<10) $ini_hora="0".$ini_hora;
        $ini_min =  substr($program->StartTime, -2);
        $program->pubDate = date('D, d M Y').' '.$ini_hora.':'.$ini_min.':00 GMT';
        unset($program->permalink, $cate_id, $ficha_url, $program->Desc1, $program->Desc2);
        $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
        if ($ficha)
            $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
        if ($ficha)
            $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
        if ($ficha)
            $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));
        if ($cate_id and $ficha_url) {
            $program->permalink = 'http://televisionvtr.cl/' . $cate_id . '/' . $ficha_url . '/';
            $program->ficha = 1;
            $program->description = "<![CDATA[".$wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1")."]]>";
            $imageSrc = wp_get_attachment_image_src(get_field('imagen_cabecera2', $ficha));
            $program->image = $imageSrc;
            $program->category = "<![CDATA[".$cate_id."]]>";
        }
        foreach ($program as $key => $val) {
                $key = $key!="pubDate" ? strtolower($key): $key;
            if ($val) echo "     <" .  $key . ">" . $val . '</'.$key.'>';
        }
        echo "</item>";
    }
    foreach ($second as $program) {
        echo "<item>";
        $program->ficha = 0;
        $program->image = "http://televisionvtr.cl/wp-content/themes/televisionvtr/img/foto/minificha.jpg";
        $program->description =  $program->Desc1? "<![CDATA[".$program->Desc1."]]>": "<![CDATA[".$program->Desc2."]]>";
        $program->link = "http://televisionvtr.cl/?grilla=xml&amp;get=program&amp;pid=$program->ProgramID&amp;startdate=$program->StartDate&amp;starttime=$program->StartTime";        
        $ini_hora =  substr($program->StartTime, 0, 2) - $horario;
        if ($ini_hora<0) $ini_hora = 24 + $ini_hora;
        if ($ini_hora<10) $ini_hora="0".$ini_hora;
        $ini_min =  substr($program->StartTime, -2);
        $program->pubDate = date('D, d M Y').' '.$ini_hora.':'.$ini_min.':00 GMT';
        unset($program->permalink, $cate_id, $ficha_url, $program->Desc1, $program->Desc2);
        $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
        if ($ficha)
            $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
        if ($ficha)
            $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
        if ($ficha)
            $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));
        if ($cate_id and $ficha_url) {
            $program->permalink = 'http://televisionvtr.cl/' . $cate_id . '/' . $ficha_url . '/';
            $program->ficha = 1;
            $program->description = "<![CDATA[".$wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1")."]]>";
            $imageSrc = wp_get_attachment_image_src(get_field('imagen_cabecera2', $ficha));
            $program->image = $imageSrc;
            $program->category = "<![CDATA[".$cate_id."]]>";            
        }
        foreach ($program as $key => $val) {
                $key = $key!="pubDate" ? strtolower($key): $key;
            if ($val) echo "     <" .  $key . ">" . $val . '</'.$key.'>';            
        }
        echo "</item>";
    }
    echo "  </channel></rss>";
    exit;
}
if ($_GET['grilla'] == 'xml' and $_GET['get'] == 'program') {
    $programa = $_GET['pid'] ? $_GET['pid'] : false;
    $startdate = $_GET['startdate'] ? $_GET['startdate'] : false;
    $starttime = $_GET['starttime'] ? $_GET['starttime'] : false;
    $program = $wpdb_pr->get_row("SELECT $wpdb_pr->sch.ChannelID, $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,Subtitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration FROM $wpdb_pr->prog INNER JOIN $wpdb_pr->sch ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID) WHERE $wpdb_pr->prog.ProgramID = '$programa' AND $wpdb_pr->sch.StartDate = '$startdate' AND $wpdb_pr->sch.StartTime = '$starttime'  LIMIT 1", 'OBJECT');
    header("Content-Type:text/xml");
echo' <rss version="2.0">
            <channel>
               <title>Programa de Televisión</title>
                        <copyright>Copyright (c) 2011 VTR.COM All rights reserved.</copyright>
                        <link>http://televisionvtr.cl/</link>
                        <category>Programa Television</category>
                        <description>Programa del Portal de televisión de VTR</description>
                        <language>es-CL</language>
                        <lastBuildDate>'.date('D, d M Y H:i:s').' GMT </lastBuildDate>
                        <ttl>35</ttl>
                                   <image>
                                               <title>VTR</title>
                                               <url>http://vtr.com/images/logo_vtr_rss.jpg</url>
                                               <link>http://vtr.com/</link>
                                   </image>';


    echo "<item>";
    $program->ficha = 0;
    $program->image = "http://televisionvtr.cl/wp-content/themes/televisionvtr/img/foto/minificha.jpg";
    $program->description =  $program->Desc1? "<![CDATA[".$program->Desc1."]]>": "<![CDATA[".$program->Desc2."]]>";
    $ini_hora =  substr($program->StartTime, 0, 2) - $horario;
    if ($ini_hora<0) $ini_hora = 24 + $ini_hora;
    if ($ini_hora<10) $ini_hora="0".$ini_hora;
    $ini_min =  substr($program->StartTime, -2);
    $program->pubDate = date('D, d M Y').' '.$ini_hora.':'.$ini_min.':00 GMT';    
    unset($program->link, $cate_id,  $ficha_url,$program->Desc1, $program->Desc2);
    $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
    if ($ficha)
        $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
    if ($ficha)
        $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
    if ($ficha)
        $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));
    if ($cate_id and $ficha_url) {
        $program->link = 'http://televisionvtr.cl/' . $cate_id . '/' . $ficha_url . '/';
        $program->ficha = 1;
        $program->description = "<![CDATA[".$wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1")."]]>";
        $imageSrc = wp_get_attachment_image_src(get_field('imagen_cabecera2', $ficha));
        $program->image = $imageSrc;
        $program->category = "<![CDATA[".$cate_id."]]>";        
    }
    foreach ($program as $key => $val) {
                $key = $key!="pubDate" ? strtolower($key): $key;
            if ($val) echo "     <" .  $key . ">" . $val . '</'.$key.'>';            
    }
    echo "</item>";
    echo "  </channel></rss>";
    exit;
}
?>
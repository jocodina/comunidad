<?php

/*
  Plugin Name: tablet  data
  Plugin URI: maxvillegas.com
  Description: mobile theme
  Version: 2
  Author: Max Villegas
  Author URI: http://mvillegas.com/
 */

//GRILL
date_default_timezone_set('Chile/Continental');

class tabgrill {

    var $timezone;
    var $date;
    var $time;
    var $county;
    var $channel;
    var $genre;
    var $category;
    var $type;
    var $group;
    var $program;
    var $next_day;
    var $search;
    var $allProgramsID;
    var $mq;

    //GRILL
    function tabgrill() {
        global $horario;
        
        $this->sanitize_gets($_GET);
        
        if(get_field('_timezone','options')){
           $this->timezone = get_field('_timezone','options');
        }else{
           $this->timezone = $horario; 
        }
        
        
        $this->next_day = $this->timezone == 4 ? '0400' : '0300';
        $this->date = $this->mq["date"] != 'null' && $this->mq["date"] != "" ? $this->mq["date"] : date('mdy');
        $this->county = $this->getLocation($this->mq["county"]);
        $this->genre = $this->get_genre($this->mq["genre"]);
        $this->type = $this->get_type($this->mq["type"]);
        $this->category = $this->get_category($this->mq["category"]);
        $this->group = $this->get_group($this->mq["group"]);
        $this->search = $this->get_search($this->mq["search"]);
        $this->programid = $this->get_programid($this->mq["programid"]);
        
    }

    //PROGRAMS
    function get_programs() {
        global $wpdb_pr;
        if ($this->mq["when"] == "now") {
            $ahora = date("Hi", mktime(date('H') + $this->timezone, date('i') - 25, 0, 0, 0, 0));
            $proxi = date("Hi", mktime(date('H') + $this->timezone, date('i'), 0, 0, 0, 0));
        }
        if ($this->mq["when"] == "tostart") {
            $ahora = date("Hi", mktime(date('H') + $this->timezone, date('i'), 0, 0, 0, 0));
            $proxi = date("Hi", mktime(date('H') + $this->timezone, date('i') + 15, 0, 0, 0, 0));
        }
         if ($this->mq["when"] == "noon") {
            $ahora = date("Hi", mktime(11 + $this->timezone, "00", 0, 0, 0));
            $proxi = date("Hi", mktime(14 + $this->timezone, "00", 0, 0, 0, 0));
        }
        if ($this->mq["when"] == "prime") {
            
            $dia = substr($this->date, 2, 2);
            $mes = substr($this->date, 0, 2);
            $ano = substr($this->date, 4, 2);
            
            $this->date = date("mdy", mktime(0, 0, 0, date($mes), date($dia) + 1, date($ano)));
            
            $ahora = date("Hi", mktime(21 + $this->timezone,  "00", 0, 0, 0, 0));
            $proxi = date("Hi", mktime(23 + $this->timezone,  "59", 0, 0, 0, 0));
        }

        if ($this->mq["destacados"] != "") {
            $fecha = date("Y") . date("m") . date("d");
            
            $cons = array(
                'post_type' => 'post',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'posiciones',
                        'field' => 'slug',
                        'terms' => 'destacado'
                    )
                ),
                'posts_per_page' => 6,
                'order' => 'DESC',
                'orderby' => 'meta_value_num', //menu_order
                'meta_key' => 'fecha_destacado',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'fecha_destacado',
                        'value' => $fecha,
                        'compare' => "<=",
                        'type' => "DATE"
                    )
                )
            );
            
            $destacado = new WP_Query($cons);
            if ($destacado->have_posts()):
                while ($destacado->have_posts()):
                    $destacado->the_post();
                    $progid = split(",", get_post_meta($destacado->post->ID, 'ProgramID', true));

                    foreach ($progid as $fic) {
                        $checkTime = $wpdb_pr->get_var("
                            SELECT $wpdb_pr->sch.StartTime
                            FROM $wpdb_pr->sch  
                            WHERE $wpdb_pr->sch.ProgramID = '$fic'
                            ");

                        $checkProgram = $wpdb_pr->get_var("
                            SELECT $wpdb_pr->prog.Title
                            FROM $wpdb_pr->prog  
                            WHERE $wpdb_pr->prog.ProgramID = '$fic'
                            ");   
                        if ($checkTime != "" && $checkProgram != "") {
                            $fichaCont = $fic;
                        }  
                    }   
                    $pid[] = $fichaCont;
                endwhile;

            endif;
            $this->mq["programid"] = implode(",",$pid);
            $this->programid = $this->get_programid($this->mq["programid"]);   
        }

        $between = " AND ($wpdb_pr->sch.StartTime >= '$ahora' AND $wpdb_pr->sch.StartTime <= '$proxi') ";
        $betweenNext = " AND ($wpdb_pr->sch.StartTime >= '$ahoraNext' AND $wpdb_pr->sch.StartTime <= '$proxiNext') ";
        
        if($this->mq["when"]== "now" && $proxi < 2359){ 
            $between = " AND ($wpdb_pr->sch.StartTime >= '$ahora' AND $wpdb_pr->sch.StartTime <= '$proxi')";
        }
        if($this->mq["when"]== "now" && $ahora > 2319){ 
            $between = " AND ($wpdb_pr->sch.StartTime >= '$ahora') ";
        }
        if ($this->mq["when"] == "tostart" && $proxi < 2359){
            $between = " AND ($wpdb_pr->sch.StartTime >= '$ahora' AND $wpdb_pr->sch.StartTime <= '$proxi') ";
        }
        if ($this->mq["when"] == "tostart"&& $ahora > 2344){
            $between = " AND ($wpdb_pr->sch.StartTime >= '$ahora' ";
        }
        
        $date = " AND $wpdb_pr->sch.StartDate = '$this->date' ";
        
        if($this->mq["date"] == 'no'){
            $date = "";
            $between = "";
        }
        
        $query = ("
		SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration,imagen, senal, genero, $this->county, tipo 
        	FROM $wpdb_pr->sch
                INNER JOIN $wpdb_pr->prog
        	ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
                INNER JOIN $wpdb_pr->chn_web
                ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->sch.ChannelID)
                INNER JOIN $wpdb_pr->full
                ON ($wpdb_pr->full.codigo = $wpdb_pr->sch.ChannelID)
        	WHERE
                
                1
               
                $date
                $between
                AND $this->county > 0
                $this->genre
                $this->type
                $this->category
                $this->group
                $this->search
                $this->programid
                ORDER BY $wpdb_pr->sch.StartTime ASC              
         ");
        if ($this->mq["format"] == "xml") {
            header("Content-Type:text/xml");
            return $this->xmlencode($wpdb_pr->get_results($query, 'OBJECT'));
        }
        if ($this->mq["format"] == "json") {
            return json_encode($this->jsonencode($wpdb_pr->get_results($query, 'OBJECT')));
        }

        

        return $this->htmlencode($wpdb_pr->get_results($query, 'OBJECT'));
    }

    function htmlencode($objects) {
        
        
        foreach ($objects as $object) {
            $out .= "<li>" . $object->ProgramID . "</li>";
        }
        
        return $out;
    }

    function xmlencode($objects, $objectsNext = false) {
        global $wpdb;
        $out = '<?xml version="1.0" encoding="UTF-8"?>';
        $out .= '<rss version="2.0">
            <channel>
               <title>Canales Televisión</title>
                <copyright>Copyright (c) 2011 VTR.COM All rights reserved.</copyright>
                <link>http://televisionvtr.cl/</link>
                <description>Canales del VTR Televisión</description>
                <language>es-CL</language>
                <lastBuildDate>' . date('D, d M Y H:i:s') . ' GMT </lastBuildDate>
                <ttl>35</ttl>
                <image>
                           <title>VTR</title>
                           <url>http://vtr.com/images/logo_vtr_rss.jpg</url>
                           <link>http://vtr.com/</link>
                </image>' . "\n";
        foreach ($objects as $clave => $program) {
            
            
            $out .= "       <item>" . "\n";
            $program->Title = str_replace('&', "&amp;", $program->Title);
            $program->allPrograms = $this->get_allPrograms($program->ProgramID);
            $program->ficha = 'no';
//            $program->imagedest = "http://televisionvtr.cl/wp-content/themes/televisionvtr/img/auxi/noimg.jpg";
            $program->description = $program->Desc1 ? "<![CDATA[" . $program->Desc1 . "]]>" : "<![CDATA[" . $program->Desc2 . "]]>";
            $program->link = "http://televisionvtr.cl/programacion/?grilla=xml&amp;get=program&amp;pid=$program->ProgramID&amp;startdate=$program->StartDate&amp;starttime=$program->StartTime";
            if(!$program->MpaaRating){
                $program->mpaarating = 'none';
            }
            $ini_hora = substr($program->StartTime, 0, 2);
            $ini_hora = date('H',mktime($ini_hora - $this->timezone,0,0,0,0,0));
            if ($ini_hora < 0)
                $ini_hora = 24 + $ini_hora;
            
            $ini_min = substr($program->StartTime, -2);
            
            $hora_duration = substr($program->Duration, 0, 2);
            $min_duration = substr($program->Duration, -2);
            
            $dia = substr($program->StartDate, 2, 2);
            $mes = substr($program->StartDate, 0, 2);
            $ano = substr($program->StartDate, 4, 2);
            $date = date('l d', mktime(0,0,0,$mes,$dia,$ano));
            $date = $this->spanishDates($date);
            $program->pubDate = $date . ' ' . $ini_hora . ':' . $ini_min . ':00 GMT';
            $program->horariodate = $date;
            $program->startime = $ini_hora . ':' . $ini_min;
            $program->endTime = $this->sumarHoras($ini_hora,$ini_min,$hora_duration,$min_duration);
            $today = date('l d F', mktime(0,0,0,$mes,$dia,$ano));
            if ($this->mq["when"] == "prime") {
                $today = date('l d F', mktime(0, 0, 0, date($mes), date($dia) - 1, date($ano)));
            }
            $program->today = $this->spanishDates($today);
            $program->options = $this->getDaysOptions();
            if($this->mq["regiones"]){$program->regiones = $this->optionsRegiones();}
            if($this->mq["comuna"]){$program->comunas = $this->optionComunas($this->mq["comuna"]);}
            $program->city = $this->county;
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
                $program->ficha = '1';
                $program->description = "<![CDATA[" . $wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1") . "]]>";
                
                $attachmentImg = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_destacado2' AND post_id LIKE '%$ficha%' ");
                $imgSrc = wp_get_attachment_image(get_post_thumbnail_id( $ficha ), 'full');
                $program->imagedest = "<![CDATA[" . $imgSrc . "]]>";
                
                $program->category = "<![CDATA[" . $cate_id . "]]>";
            }
            foreach ($program as $key => $val) {
                $key = $key != "pubDate" ? strtolower($key) : $key;
                if ($val) {
                    if (eregi("Cine&Series", $val)) {
                        $val = eregi_replace("Cine&Series", "series-peliculas", $val);
                    }
                    if (eregi("tendencias", $val)) {
                        $val = eregi_replace("Estilos & Tendencias", "tendencias", $val);
                    }
                    if ($key == "senal")
                        $val = eregi_replace("&", " ", $val);
                    $out .= "            <" . $key . ">" . $val . '</' . $key . '>' . "\n";
                }
            }
            $out .= "       </item>" . "\n";
        }
        $out .= "  </channel>\n</rss>\n";
        return $out;
    }

    function jsonencode($objects) {
        global $wpdb;
        
        foreach ($objects as $clave => $program) {
            $program->Title = str_replace('&', "&amp;", $program->Title);
            $program->ficha = 'no';
            $program->allPrograms = $this->get_allPrograms($program->ProgramID);
            $program->description = $program->Desc1 ? $program->Desc1 : $program->Desc2 ;
            $program->link = home_url().'/programacion/?grilla=xml&amp;get=program&amp;pid=$program->ProgramID&amp;startdate=$program->StartDate&amp;starttime=$program->StartTime';
             if(!$program->MpaaRating){
                $program->mpaarating = 'none';
            }
            
            $ini_hora = substr($program->StartTime, 0, 2);
            $ini_hora = $ini_hora - $this->timezone;
            if ($ini_hora < 0)
                $ini_hora = 24 + $ini_hora;
            $ini_min = substr($program->StartTime, -2);
            
            $hora_duration = substr($program->Duration, 0, 2);
            $min_duration = substr($program->Duration, -2);
            
            $dia = substr($program->StartDate, 2, 2);
            $mes = substr($program->StartDate, 0, 2);
            $ano = substr($program->StartDate, 4, 2);
            
            $date = date('l d', mktime(0,0,0,$mes,$dia,$ano));
            $date = $this->spanishDates($date);
            
            $program->pubDate = $date . ' ' . $ini_hora . ':' . $ini_min . ':00 GMT';
            $program->horariodate = $date;
            $program->startime = $ini_hora . ':' . $ini_min;
            $program->endTime = $this->sumarHoras($ini_hora,$ini_min,$hora_duration,$min_duration);
            $today = date('l d F', mktime(0,0,0,$mes,$dia,$ano));
            if ($this->mq["when"] == "prime") {
                $today = date('l d F', mktime(0, 0, 0, date($mes), date($dia) - 1, date($ano)));
            }
            $program->today = $this->spanishDates($today);
            $program->options = $this->getDaysOptions();
            $program->city = trim($this->county, " ");
            if($this->mq["regiones"]){$program->regiones = $this->optionsRegiones();}
            if($this->mq["comuna"]){$program->comunas = $this->optionComunas($this->mq["comuna"]);}
            unset($program->permalink, $cate_id, $ficha_url, $program->Desc1, $program->Desc2);
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");

            $imgSrc = wp_get_attachment_image_src(get_post_thumbnail_id( $ficha ), array($this->mq["width"],$this->mq["height"]));
            $program->imagedest = $imgSrc[0];
            
            if ($ficha) {
                $program->permalink = get_permalink($ficha);
                $program->ficha = 1;
                $program->description = $wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
                $imgSrc = wp_get_attachment_image_src(get_post_thumbnail_id( $ficha ), array($this->mq["width"],$this->mq["height"]));
                if($this->mq["width"] == 450 || $this->mq["height"] == 250){
                    $imgSrc = wp_get_attachment_image_src(get_post_thumbnail_id( $ficha ), 'destacadoTablet');
                }
                $program->imagedest = $imgSrc[0];
                $program->category = "<![CDATA[" . $cate_id . "]]>";
                $program->desc = 'hola';
                $postObject = get_post($ficha);
                if($postObject->post_content){ 
                    $program->description = $postObject->post_content; 
                }elseif($postObject->post_excerpt){
                    $program->description = $postObject->post_excerpt;   
                }
                
            }  
            foreach ($program as $key => $val) {
                $key = $key != "pubDate" ? strtolower($key) : $key;
                if ($val) {
                    if (eregi("Cine&Series", $val)) {
                        $val = eregi_replace("Cine&Series", "series-peliculas", $val);
                    }
                    if (eregi("tendencias", $val)) {
                        $val = eregi_replace("Estilos & Tendencias", "tendencias", $val);
                    }

                    $item[$key] = $val;
                }
            }
            if($this->mq["horarios"]){
                $startDate = date('mdy', $item->startdate);
                $timestampHoy = mktime(0,0,0,date('m'),date('d'),date('y'));
                $diaProg = substr($item['startdate'], 2, 2);
                $mesProg = substr($item['startdate'], 0, 2);
                $anoProg = substr($item['startdate'], 4, 2);
                $timestampProg = mktime(0,0,0,$mesProg,$diaProg,$anoProg);

                if($timestampProg >= $timestampHoy){
                   $out[] = $item;
                }
            }else{
                $out[] = $item;
            } 
        }
        
        return $out;
    }

    
    
    function get_allPrograms($programid){
        global $wpdb_pr;
        
        $i = 0;
        
        $titles = $wpdb_pr->get_var("SELECT Title FROM $wpdb_pr->prog WHERE ProgramID = '$programid'");        
        $pids = $wpdb_pr->get_results("SELECT ProgramID FROM $wpdb_pr->prog WHERE Title = '$titles'");

        foreach($pids as $pid){
            $pids[$i] = $pid->ProgramID;   
            $i++;  
        }    
        $pids = implode(',',$pids);
        
        return $pids;
        
    }
    
    function getPostMeta($programid){
        global $wpdb;
        
        $p =  $wpdb->get_var("SELECT post_id FROM vtr_postmeta WHERE meta_key = 'ProgramID' AND meta_value = $programid ");
        
        echo '<pre>';
        print_r($programid);
        echo '<pre>';
    }
    
    function getSO(){
        $agent = $_SERVER['HTTP_USER_AGENT']; 
        
        if(preg_match('/iPhone/i', $agent)){  
            $out .= 'http://www.baytex.net/clientes/vtr_2011/download.php?device=ios&app=epg&version=2.2';
        }elseif(preg_match('/Android/i', $agent)){
            $out .= 'http://www.baytex.net/clientes/vtr_2011/download.php?device=android&app=epg&version=2.2';
        }
        
        
    }

    function sumarHoras($ini_hora,$ini_min,$hora_duration,$min_duration) {
        
            $hora1 = $ini_hora.':'.$ini_min;
            $hora2 = $hora_duration.':'.$min_duration;
            $hora1=split(":",$hora1);
            $hora2=split(":",$hora2);
            $horas=(int)$hora1[0]+(int)$hora2[0];
            $minutos=(int)$hora1[1]+(int)$hora2[1];
            $horas+=(int)($minutos/60);
            $minutos=$minutos%60;
            if($minutos < 10)$minutos="0".$minutos; 
            if(abs($horas) < 10)$horas = '0'.abs($horas);
            
            if($horas > 23)
                $horas = 0 + ($horas % 24);
            if($horas < 10)
                $horas = '0'.abs($horas);
            $endTime = $horas.':'.$minutos;
            return $endTime;
     }
    
    function tellTheDate($dateStr, $format = "%A %d de %B, %Y"){
        setlocale(LC_TIME, 'es_ES'); // setea el idioma
        if($dateStr){
            $fecha = explode("/", $dateStr);
            $timeStamp = gmmktime(0,0,0,$fecha[1],$fecha[0],$fecha[2]);
            return utf8_encode( strftime($format, $timeStamp) );
        }
    }
    
    function getDaysOptions(){
        $out = "";
        
        $hoy = date('l d F');
        $optionDate = date('mdy', strtotime("$hoy")).'">'.$hoy;
        $optionDate = $this->spanishDates($optionDate);
        $out .= '<option value="'.$optionDate.'</option>';
        
        for($i = 1; $i <=7; $i++){
            $optionDate = date('l d F', strtotime("$hoy +$i days "));
            $optionDate = $this->spanishDates($optionDate);
            $out .= '<option value="'.date('mdy', strtotime("$hoy +$i days")).'">'.$optionDate.'</option>';
        }
        
        return $out;
    }
    
    
    function getLocation($location=false) {
        global $wpdb_pr;

        $county = $wpdb_pr->get_var("
                SELECT grilla
                FROM $wpdb_pr->comunas
                WHERE comuna = '$location'
                GROUP BY grilla
                LIMIT 1
                ");

        $location = $county ? $county : "santiago";
        return $location;
    }

    //TAXONOMY
    function get_genres() {
        global $wpdb_pr;
        return $wpdb_pr->get_results("SELECT categoria, slug, type FROM $wpdb_pr->chn_cat ORDER BY id ASC", 'OBJECT');
    }

    function get_genre($genre=false) {
        if (eregi("series-peliculas", $genre)) {
            $genre = eregi_replace("series-peliculas", "'Cine&Series'", $genre);
        }
        if (eregi("compra-eventos", $genre)) {
            $genre = eregi_replace("compra-eventos", "'Compra de Eventos'", $genre);
        }
        if (eregi("tendencias", $genre)) {
            $genre = eregi_replace("tendencias", "'Estilos & Tendencias'", $genre);
        }

        if (eregi("Deportes", $genre)) {
            $genre = eregi_replace("Deportes", "'Deportes'", $genre);
        }

        if (eregi("Cultural", $genre)) {
            $genre = eregi_replace("Cultural", "'Cultural'", $genre);
        }

        if (eregi("hd", $genre)) {
            $genre = eregi_replace("hd", "'Alta Definición'", $genre);
        }

        if (eregi("Musica", $genre)) {
            $genre = eregi_replace("Musica", "'Musica'", $genre);
        }
        
        if (eregi("Noticias", $genre)) {
            $genre = eregi_replace("Noticias", "'Noticias'", $genre);
        }

        if (eregi("Nacional", $genre)) {
            $genre = eregi_replace("Nacional", "'Nacional'", $genre);
        }

        if (eregi("Intern", $genre)) {
            $genre = eregi_replace("Intern", "'Internacional'", $genre);
        }
        if (eregi("Adulto", $genre)) {
            $genre = eregi_replace("Adulto", "'Adulto'", $genre);
        }
        if (eregi("Infantil", $genre)) {
            $genre = eregi_replace("Infantil", "'Infantil'", $genre);
        }


        return $genre ? " AND genero IN ($genre) " : false;
    }

    function get_type($type) {
        return $type ? " AND tipo = '$type' " : " AND  tipo IN ('Con d-Box','Básico') ";
    }

    function get_category($category=false) {
        return $category ? " AND categoria = '$category' " : " AND  categoria IN ('Premium','Básico') ";
    }

    function get_group($group=false) {
        return $group ? " AND grupo = '$group' " : false;
    }

    function get_search($search) {
        global $wpdb_pr;
        if ($search != "")
            return " AND $wpdb_pr->prog.Title LIKE '%$search%' ";
    }

    function get_programid($ids) {
        global $wpdb_pr;
        
        if($this->mq["agrupar"] == 'no'){
            $group = "";
        }else{
            $group = "GROUP BY $wpdb_pr->prog.ProgramID";
        }
        if ($ids != "" && eregi(',', $ids)) {
            $ids = explode(",", $ids);
            $ids = implode("','", $ids);
            return " AND $wpdb_pr->prog.ProgramID IN ('$ids') $group ";
        } 
        if ($ids != "" && !eregi(',', $ids)){
            return " AND $wpdb_pr->prog.ProgramID ='$ids' $group ";
        }
    }

    function sanitize_gets($mobile_query = false) {
        if ($mobile_query) {
            foreach ($mobile_query as $name => $value) {
                $this->mq[$name] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', urldecode($value));
            }
        }
    }


    function optionsRegiones() {
        global $wpdb_pr;

        $out = "";

        $comunas = $wpdb_pr->get_results("
                    SELECT region
                    FROM $wpdb_pr->comunas
                    GROUP BY region
            ");

        foreach ($comunas as $comuna) {

            if ($comuna->region == 1) {
                $region = "Tarapacá";
            } elseif ($comuna->region == 2) {
                $region = "Antofagasta";
            } elseif ($comuna->region == 3) {
                $region = "Atacama";
            } elseif ($comuna->region == 4) {
                $region = "Coquimbo";
            } elseif ($comuna->region == 5) {
                $region = "Valparaíso";
            } elseif ($comuna->region == 6) {
                $region = "O'Higgins";
            } elseif ($comuna->region == 7) {
                $region = "Maule";
            } elseif ($comuna->region == 8) {
                $region = "Bío-bío";
            } elseif ($comuna->region == 9) {
                $region = "Araucanía";
            } elseif ($comuna->region == 10) {
                $region = "Los Lagos";
            } elseif ($comuna->region == 11) {
                $region = "Aysén";
            } elseif ($comuna->region == 12) {
                $region = "Magallanes";
            } elseif ($comuna->region == 13) {
                $region = "Región Metropolitana";
            } elseif ($comuna->region == 14) {
                $region = "Los Ríos";
            } elseif ($comuna->region == 15) {
                $region = "Arica y Parinacota";
            }
            $out .= '<option value="' . $comuna->region . '">';
            $out .= $region;
            $out .= '</option>';
        }
        return $out;
    }

    function optionComunas($region) {
        global $wpdb_pr;

        $comunas = $wpdb_pr->get_results("
                    SELECT comuna
                    FROM $wpdb_pr->comunas
                    WHERE $wpdb_pr->comunas.region = $region
            ");

        $out .= '<option value="">Selecciona tu Comuna</option>';

        foreach ($comunas as $comuna) {

            $out .= '<option value="' . $comuna->comuna . '">' . $comuna->comuna . '</option>';
        }
        return $out;
    }
    
    function spanishDates($date){
        
        if (eregi("monday", $date)) {
            $date = str_replace("Monday" , "lunes" , $date);
        }elseif(eregi("tuesday", $date)){
            $date = str_replace("Tuesday" , "martes" , $date);
        }elseif(eregi("wednesday", $date)){
            $date = str_replace("Wednesday" , "miércoles" , $date);
        }elseif(eregi("thursday", $date)){
            $date = str_replace("Thursday" , "jueves" , $date);
        }elseif(eregi("friday", $date)){
            $date = str_replace("Friday" , "viernes" , $date);
        }elseif(eregi("saturday", $date)){
            $date = str_replace("Saturday" , "sábado" , $date);
        }elseif(eregi("sunday", $date)){
            $date = str_replace("Sunday" , "domingo" , $date);
        }
        
        if (eregi("january", $date)) {
            $date = str_replace("January" , "enero" , $date);
        }elseif(eregi("february", $date)){
            $date = str_replace("February" , "febrero" , $date);
        }elseif(eregi("march", $date)){
            $date = str_replace("March" , "marzo" , $date);
        }elseif(eregi("april", $date)){
            $date = str_replace("April" , "abril" , $date);
        }elseif(eregi("may", $date)){
            $date = str_replace("May" , "mayo" , $date);
        }elseif(eregi("june", $date)){
            $date = str_replace("June" , "junio" , $date);
        }elseif(eregi("july", $date)){
            $date = str_replace("July" , "julio" , $date);
        }elseif(eregi("august", $date)){
            $date = str_replace("August" , "agosto" , $date);
        }elseif(eregi("september", $date)){
            $date = str_replace("September" , "septiembre" , $date);
        }elseif(eregi("october", $date)){
            $date = str_replace("October" , "octubre" , $date);
        }elseif(eregi("november", $date)){
            $date = str_replace("November" , "noviembre" , $date);
        }elseif(eregi("december", $date)){
            $date = str_replace("December" , "diciembre" , $date);
        }
        
        return $date;
    }
}

function ajax_tablet() {
    
    $tab = new tabgrill();
    echo $tab->get_programs();
    exit;
}

add_action('wp_ajax_ajax_tablet', 'ajax_tablet');
add_action('wp_ajax_nopriv_ajax_tablet', 'ajax_tablet');
?>
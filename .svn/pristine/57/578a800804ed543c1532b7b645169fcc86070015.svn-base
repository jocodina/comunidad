<?php

/*
  Plugin Name: mobile data
  Plugin URI: maxvillegas.com
  Description: mobile theme
  Version: 2
  Author: Max Villegas
  Author URI: http://mvillegas.com/
 */
date_default_timezone_set('America/Santiago');

//GRILL
class getgrill {

    var $time_zone;
    var $date;
    var $time;
    var $county;
    var $channel;
    var $gender;
    var $category;
    var $type;
    var $group;
    var $program;
    var $next_day;
    var $tab = 0;

    //GRILL
    function getgrill($mobile_query) {
        $mq = $this->sanitize_gets($mobile_query);
        $this->time_zone = date(Z) / 60 / 60 * -1;
        $this->next_day = $this->time_zone == 4 ? '0400' : '0300';
        $this->date = $mq["date"] ? $mq["date"] : date('mdy');
        $this->get_location($mq["location"]);
        $this->get_gender($mq["gender"]);
        $this->get_category($mq["category"]);
        $this->get_type($mq["type"]);
        $this->get_group($mq["group"]);
        $this->channel = $mq["channel"];

        //carga el php inicial
        if ($mq["display"] == "phpload") {


            //destacados
            print $this->get_specials();
            //categorias
            print $this->genders_list($this->get_genders());
            //canales
            print $this->channels_list($this->get_channels());

            $this->get_gender("series-peliculas");
            print $this->channels_list($this->get_channels());

            $this->get_gender("infantil");
            print $this->channels_list($this->get_channels());

            $this->get_gender("deportes");
            print $this->channels_list($this->get_channels());

            $this->get_gender(""); //borro el genero
            $this->get_category("Premium");
            print $this->channels_list($this->get_channels());

            $this->get_category(""); //borro el category
            $this->get_group("HD");
            print $this->channels_list($this->get_channels());

            //wachtlist
            print $this->get_specials();


            print $this->get_preferencias();


//            print $this->search_box();
        } else {

            //carga las pantallas por ajax

            if ($mq["display"] == "channels") {
                return $this->channels_list($this->get_channels());
            }
            if ($mq["display"] == "programs") {
                return $this->programs_list($this->get_programs());
            }
            if ($mq["display"] == "program") {
                return $this->program($mq["programID"]);
            }
            if ($mq["display"] == "preferencias") {
                return $this->preferencias($this->get_genders());
            }
            if ($mq["display"] == "search_list") {
                return $this->search_result($mq["search"]);
            }
            if ($mq["display"] == "channelList") {
               return $this->channelsByGender($this->get_channels());
            }
                   
        }
    }

    //CHANNELS
    function get_channel() {
        
    }

    function get_channels() {
        global $wpdb_pr;
        $query = ("SELECT $wpdb_pr->chn_web.codigo, tipo, grupo, categoria, genero, senal, imagen, $this->county 
				FROM $wpdb_pr->full 
				INNER JOIN $wpdb_pr->chn_web 
				ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->full.codigo) 
				WHERE 1     
				AND $this->county != 0 
				$this->gender
				$this->category
				$this->type
				$this->group
				GROUP BY $this->county 
				ORDER BY $this->county ASC");
        $r = $wpdb_pr->get_results($query, 'OBJECT');
        return $r;
    }

    function get_channels_by_date() {
        
    }



    function get_channels_by_type() {
        
    }

    function get_channels_by_search() {
        
    }

    function get_channels_by_selected() {
        
    }

    //PROGRAMS
    function get_programs() {
        global $wpdb_pr;

        $query = ("
		SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration,imagen, senal, genero, $this->county 
        	FROM $wpdb_pr->sch
                INNER JOIN $wpdb_pr->prog
        	ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
                INNER JOIN $wpdb_pr->chn_web
                ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->sch.ChannelID)
                INNER JOIN $wpdb_pr->full
                ON ($wpdb_pr->full.codigo = $wpdb_pr->sch.ChannelID)
        	WHERE $wpdb_pr->sch.StartDate = '$this->date'
                AND $wpdb_pr->sch.StartTime >= '$this->next_day'
                AND $wpdb_pr->sch.ChannelID = '$this->channel'
                ORDER BY $wpdb_pr->sch.StartDate , $wpdb_pr->sch.StartTime ASC
         ");
        
        

        return $wpdb_pr->get_results($query, 'OBJECT');
    }

    function get_programs_by_channels() {
        
    }

    function get_programs_by_date() {
        
    }

    function get_programs_by_channel() {
        
    }

    function get_programs_by_search() {
        
    }

    function get_programs_by_time() {
        
    }

    function get_programs_next() {
        
    }

    function get_programs_previous() {
        
    }

    //PROGRAM
    function get_program() {
        global $wpdb_pr;
        $query = ("
                SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration
        	FROM
        	$wpdb_pr->sch 
                INNER JOIN $wpdb_pr->prog
        	ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
        	WHERE $wpdb_pr->sch.StartDate = '$this->date' 
		AND $wpdb_pr->sch.StartTime >= '$this->next_day'
        	AND $wpdb_pr->sch.ChannelID = '$this->channel'
         ");
        return $wpdb_pr->get_results($query, 'OBJECT');
    }

    function get_program_by_date() {
        
    }

    function get_program_repetitions() {
        
    }

    function get_program_next() {
        
    }

    function get_program_previous() {
        
    }

    function get_program_special_sheet() {
        
    }

    function get_program_similar_by_channel() {
        
    }

    function get_program_similar_by_channel_type() {
        
    }

    function get_program_similar_by_channel_category() {
        
    }

    function get_program_similar_by_channel_search() {
        
    }

    function get_program_duration() {
        
    }

    function translate_program_duration() {
        
    }

    //LOCATION	
    function get_cities() {
        
    }

    function get_location($location=false) {

        $location = $location ? $location : "santiago";
        $this->county = $location;
    }

    function get_city() {
        
    }

    function set_county() {
        
    }

    //TAXONOMY
    function get_genders() {
        global $wpdb_pr;
        return $wpdb_pr->get_results("SELECT categoria, slug, type FROM $wpdb_pr->chn_cat ORDER BY id ASC", 'OBJECT');
    }

    function get_gender($gender=false) {
        if ($gender == "series-peliculas") {
            $gender = "Cine&Series";
        }
        if ($gender == "tendencias") {
            $gender = "Estilos & Tendencias";
        }
        $gender = $gender ? " AND genero = '$gender' " : false;
        $this->gender = $gender;
    }

    function get_type($type) {
        $type = $type ? " AND tipo = '$type' " : " AND  tipo IN ('Con d-Box','Básico') ";
        $this->type = $type;
    }

    function get_category($category=false) {
        $category = $category ? " AND categoria = '$category' " : " AND  categoria IN ('Premium','Básico') ";
        $this->category = $category;
    }

    function get_group($group=false) {
        $group = $group ? " AND grupo = '$group' " : false;
        $this->group = $group;
    }

    //SEARCH
    function get_search($search) {
        global $wpdb_pr;
        $query = (
                "SELECT $wpdb_pr->chn_web.genero,$wpdb_pr->chn_web.senal, $wpdb_pr->prog.ProgramID, $wpdb_pr->sch.StartDate, $wpdb_pr->sch.StartTime, $wpdb_pr->sch.ChannelID, $wpdb_pr->prog.Title
        FROM
            $wpdb_pr->sch,
            $wpdb_pr->prog,
            $wpdb_pr->chn_web
        WHERE
            (
            $wpdb_pr->prog.Title LIKE '%$search%'
            )
        
        AND $wpdb_pr->chn_web.codigo = $wpdb_pr->sch.ChannelID
        AND $wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID

		GROUP BY $wpdb_pr->sch.ChannelID
        ORDER BY $wpdb_pr->sch.StartDate ASC"
                );
        return $wpdb_pr->get_results($query, 'OBJECT');
    }

    function search_result($search) {
        global $wpdb;

        foreach ($this->get_search($search) as $s) {

            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$s->ProgramID%'  LIMIT 1");
            $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera' AND post_id=$ficha  LIMIT 1");

            $out .= '<li class="programa"><a href="#" class="evt" data-func="loadContent"  data-program="' . $s->ProgramID . '" >';
            if ($imagen) {
                $out .= '<img class="searchImg" src="/wp-content/files_flutter/' . $imagen . '" class="program_img" alt="' . $s->Title . '">';
            } else {
                $out .= '<img class="searchImg" src="/wp-content/themes/televisionvtr/img/mobile/generico.jpg' . $imagen . '" class="program_img" alt="' . $s->Title . '" >';
            }
            $out .= '<h2 class="searchTitle">' . $s->Title . '</h2>';
            $out .= '</a></li>';
        }
        return $out;
    }

    function get_search_by_category() {
        
    }

    function get_search_by_channel() {
        
    }

    function get_search_by_type() {
        
    }

    function get_search_by_date() {
        
    }

    function get_search_by_time() {
        
    }

    //DATES
    function get_dates() {
        
    }

    function get_date_now() {
        
    }

    function get_date_by_selection() {
        
    }

    function get_date_next() {
        
    }

    function get_date_previous() {
        
    }

    function translate_date() {
        
    }

    function set_date() {
        
    }

    //TIME
    function get_time() {
        
    }

    function set_time_prime() {
        
    }

    function translate_time() {
        
    }

    function set_time() {
        
    }

    //AUXILIARES
    function encode_data() {
        
    }

    function decode_data() {
        
    }

    function serial_data() {
        
    }

    function unserial_data() {
        
    }

    function sanitize_gets($mobile_query) {
        foreach ($mobile_query as $name => $value) {
            $mq[$name] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', urldecode($value));
        }
        return $mq;
    }

    //htmlCode
    function channels_list($chnnels, $ajax=false) {
        $out = '<ul data-role="listview" class="listin">';
        foreach ($chnnels as $channel) {
            $out .= '<li class="canal">';
            $out .= '<a href="#"  class="evt" data-func="loadPrograms" data-chnid="' . $channel->codigo . '" title="' . $channel->senal . '">';
            $out .= '<img  class="img-canal" src="/wp-content/themes/televisionvtr/img/foto/' . strtolower($channel->imagen) . '" alt="' . $channel->senal . '" /> ';
            $out .= '<span class="meta-data channel-number">' . $channel->{$this->county} . '</span> <span class="meta-data">' . $channel->senal . '</span>';
            $out .= "</a>";
            $out .= '</li>';
        }
        $out .="</ul>";

        if ($ajax != false) {
            return $out;
        } else {
            return $this->tabSlider($out);
        }
    }

    function channelsByGender($chnnels) {


        if ($chnnels[0]->genero == 'Cine&Series') {
            $out .= '<h1 class = "pad num_1">Series y Películas</h1>';
        } elseif ($chnnels[0]->genero == 'Infantil') {
            $out .= '<h1 class = "pad num_2">Infantil</h1>';
        } elseif ($chnnels[0]->genero == 'Deportes') {
            $out .= '<h1 class = "pad num_3">Deportes</h1>';
        } elseif ($chnnels[0]->genero == 'Musica') {
            $out .= '<h1 class = "pad num_4">Música</h1>';
        } elseif ($chnnels[0]->genero == 'Estilos & Tendencias') {
            $out .= '<h1 class = "pad num_5">Tendencias</h1>';
        } elseif ($chnnels[0]->genero == 'Cultural') {
            $out .= '<h1 class = "pad num_6">Cultura</h1>';
        } elseif ($chnnels[0]->genero == 'Noticias') {
            $out .= '<h1 class = "pad num_7">Noticias</h1>';
        } elseif ($chnnels[0]->genero == 'Nacional') {
            $out .= '<h1 class = "pad num_8">Nacional</h1>';
        } elseif ($chnnels[0]->genero == 'Internacional') {
            $out .= '<h1 class = "pad num_9">Internacional</h1>';
        } elseif ($chnnels[0]->genero == 'Adulto') {
            $out .= '<h1 class = "pad num_10">Adulto</h1>';
        } elseif ($chnnels[0]->categoria == 'Premium') {
            $out .= '<h1 class = "pad num_11">Premium</h1>';
        } elseif ($chnnels[0]->genero == 'HD') {
            $out .= '<h1 class = "pad num_12">HD</h1>';
        } elseif ($chnnels[0]->genero != $chnnels[10]->genero || $chnnels[0]->genero != $chnnels[60]->genero || $chnnels[0]->genero != $chnnels[80]->genero) {
            $out .= '<h1 class = "pad num_1">Todos los canales</h1>';
        }


        ;
        $out .= '<ul data-role="listview" class="listin">';

        foreach ($chnnels as $channel) {

            $out .= '<li class="canal">';

            $out .= '<a href="#" class="evt" data-func="loadPrograms" data-chnid="' . $channel->codigo . '" title="' . $channel->senal . '">';

            $out .= '<img  class="img-canal" src="/wp-content/themes/televisionvtr/img/foto/' . strtolower($channel->imagen) . '" alt="' . $channel->senal . '" /> ';

            $out .= '<span class="meta-data channel-number">' . $channel->{$this->county} . '</span> <span class="meta-data">' . $channel->senal . '</span>';

            $out .= "</a>";

            $out .= '</li>';

        }


        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function genders_list($genders) {

        $out .= '<ul class="gen-list">';

        $i = 0;
        foreach ($genders as $gender) {
            $i++;
            $out .= '<li class="cate num_' . $i . '"><a class="evt" data-func="loadChannel" data-location="' . $this->county . '" data-gender="' . $gender->slug . '" data-type="' . $gender->type . '" href="/mobile/?version_mobile=true&display=channels&location=' . $this->county . '&' . $gender->type . '=' . $gender->slug . '" title="Programación de ' . $gender->categoria . '">' . $gender->categoria . '</a></li>';
        }
        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function programs_list($programs) {
        global $wpdb;


        $fechaHoy = date('mdy');


        for ($i = 1; $i <= 5; $i++) {
            $timeStamp = StrToTime($fechaHoy);
            $inday[$i] = StrToTime('+' . $i . ' days', $timeStamp);
            $inday[$i] = date('mdy', $inday[$i]);
        }


        $out .='<div class = "channelTitle">';
        $out .='<img src="/wp-content/themes/televisionvtr/img/foto/' . $programs[0]->imagen . '" alt="' . $programs[0]->senal . '" title="' . $programs[0]->senal . '" />';
        $out .='<span class="chnNum">' . $programs[0]->{$this->county} . '</span>';
        $out .='<h1>' . $programs[0]->senal . '</h1>';
        $out .='<a href="" class="evt cancel" data-func="backButton" data-fade="channels" title="Volver">Volver</a>';
        $out .='</div>';
        $out .='<select name="fechaSelect" id="selectChange" class ="evt selectDays" data-func="getDate" data-event="change" data-gender="' . $programs[0]->genero . '" data-chanel="' . $programs[0]->ChannelID . '">';
        $out .='<option value="' . $fechaHoy . '" class = "selectDaysOption">' . $fechaHoy . '</option>';

        for ($i = 1; $i <= 5; $i++) {
            $out .='<option value="' . $inday[$i] . '" class = "selectDaysOption">' . $inday[$i] . '</option>';
        }

        $out .='</select>';
        $out .='<ul class="gen-list" data-role="listview" data-theme="g">';

        foreach ($programs as $program) {

            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
            $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera' AND post_id=$ficha  LIMIT 1");


            $out .= '<li class="programa">';
            $out .= '<a href="" class="evt" data-func="loadContent" title="" data-program=' . $program->ProgramID . '>';
            if ($imagen) {
                $out .= '<img src="/wp-content/files_flutter/' . $imagen . '" class="program_img" alt="' . $program->Title . '" title="' . $program->Title . '">';
            } else {
                $out .= '<img src="/wp-content/themes/televisionvtr/img/mobile/generico.jpg' . $imagen . '" class="program_img" alt="' . $program->Title . '" title="' . $program->Title . '">';
            }
            $out .= '<h2>' . $program->Title . '</h2>';

            $out .= '<span class=horario>' . $program->StartTime . ' - ' . $program->Duration . '</span>';

            if ($program->MpaaRating) {
                $out .= '<span class="rating">(' . $program->MpaaRating . ')</span>';
            }

            $out .= '</a>';
            $out .= '</li>';
        }
        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function program($programID) {
        global $wpdb, $wpdb_pr;

        $ficha = $wpdb->get_results("
                    SELECT * 
                    FROM $wpdb->posts 
                    INNER JOIN $wpdb->postmeta 
                    ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
                    WHERE meta_key = 'ProgramID'
                    AND meta_value LIKE '%$programID%'
                ");

        $fichaID = $ficha[0]->post_id;

        $fichaImg = $wpdb->get_var("
                    SELECT meta_value 
                    FROM $wpdb->postmeta  
                    WHERE meta_key = 'imagen_destacado'
                    AND post_id = $fichaID
                ");

        $fichaProg = $wpdb_pr->get_results("
                    SELECT *
                    FROM $wpdb_pr->prog
                    WHERE ProgramID = '$programID' 
                ");

        $fichaDates = $wpdb_pr->get_results("
                    SELECT $wpdb_pr->sch.StartTime,StartDate,ChannelID
                    FROM $wpdb_pr->sch
                    WHERE ProgramID = '$programID' 
                ");

        $i = 0;



        foreach ($fichaDates as $fichaDate) {
            $mes[$i] = substr($fichaDate->StartDate, 0, 2);
            $dia[$i] = substr($fichaDate->StartDate, 2, 2);
            $ano[$i] = substr($fichaDate->StartDate, 4, 2);
            $ano[$i] = (int) $ano[$i];
            $ano[$i] = $ano[$i] + 2000;

            $fecha[$i] = $ano[$i] . $mes[$i] . $dia[$i];

            $i++;
        }

//        $fechaReciente = max($fecha);
//        $recentMes = substr($fechaReciente,6,2);
//        $recentdia = substr($fechaReciente,4,2);
//        $recentano = substr($fechaReciente,0,4);
//        $recentano = $recentano - 2000;
//        
//        $fechaReciente = $recentdia . $recentMes . $recentano;
//        
//        foreach($fichaDates as $fichaDate){
//            if($fichaDate->StartDate == $fechaReciente){
//                $horaInicio[] = $fichaDate->StartTime; 
//            }
//        }


        $out .='<div class="tabWrap">';
        $out .='<h1 class="titleFicha">' . $ficha[0]->post_title . '</h1>';
        $out .='<a href="#" class="evt cancel" data-fade="inicio" data-func="backButton" title="Volver">Volver</a>';


        if ($fichaImg) {
            $out .='<img class="imgFicha" src="http://televisionvtr.cl/wp-content/files_flutter/' . $fichaImg . '" alt="" title="" />';
        } else {
            $out .='<img class="imgFicha" src="' . get_bloginfo('template_url') . '/img/auxi/noimg.jpg' . $fichaImg . '" alt="" title="" />';
        }


        $out .='<div class="metaProgram">';
        $out .='<span class="duracion">00:00 - 00:30</span>';
        $out .='<span class="watchlist">';
        $out .='<label for="watch">Agregar a favoritos</label>';
        $out .='<input type="checkbox" class="evt" data-event="change" name="watch" id="watch" value="" data-program="' . $programID . '" data-func="watchlist" />';
        $out .='</span>';
        $out .='</div>';

        if ($ficha[0]->post_excerpt) {
            $out .='<p>' . $ficha[0]->post_excerpt . '</p>';
        } elseif ($fichaProg[0]->Desc1) {
            $out .='<p>' . $fichaProg[0]->Desc1 . '</p>';
        } elseif ($fichaProg[0]->Desc2) {
            $out .='<p>' . $fichaProg[0]->Desc2 . '</p>';
        } elseif ($fichaProg[0]->Desc3) {
            $out .='<p>' . $fichaProg[0]->Desc3 . '</p>';
        } else {
            $out .='<p>Aún no hay descripción</p>';
        }

        $out .='<span class="showItems">';
        $out .='<span class="Item">';
        $out .='<strong>Género: </strong>Sitcom';
        $out .='</span>';
        $out .='<span class="Item">';
        if ($fichaProg[0]->Director) {
            $out .='<strong>Director: </strong>' . $fichaProg[0]->Director . '';
        }
        $out .='</span>';
        $out .='<span class="Item">';

        if ($fichaProg[0]->Actor1) {
            $out .='<strong>Protagonistas: </strong>';

            if (!$fichaProg[0]->Actor1) {
                $out .='Aun no se han registrado datos';
            } elseif (!$fichaProg[0]->Actor2) {
                $out .=$fichaProg[0]->Actor1 . '.';
            } elseif (!$fichaProg[0]->Actor3) {
                $out .=$fichaProg[0]->Actor1 . ', ' . $fichaProg[0]->Actor2 . '.';
            } elseif (!$fichaProg[0]->Actor4) {
                $out .=$fichaProg[0]->Actor1 . ', ' . $fichaProg[0]->Actor2 . ', ' . $fichaProg[0]->Actor3 . '.';
            } elseif (!$fichaProg[0]->Actor5) {
                $out .=$fichaProg[0]->Actor1 . ', ' . $fichaProg[0]->Actor2 . ', ' . $fichaProg[0]->Actor3 . ', ' . $fichaProg[0]->Actor4 . '.';
            } elseif (!$fichaProg[0]->Actor6) {
                $out .=$fichaProg[0]->Actor1 . ', ' . $fichaProg[0]->Actor2 . ', ' . $fichaProg[0]->Actor3 . ', ' . $fichaProg[0]->Actor4 . ', ' . $fichaProg[0]->Actor5 . '.';
            } else {
                $out .=$fichaProg[0]->Actor1 . ', ' . $fichaProg[0]->Actor2 . ', ' . $fichaProg[0]->Actor3 . ', ' . $fichaProg[0]->Actor4 . ', ' . $fichaProg[0]->Actor5 . ', ' . $fichaProg[0]->Actor6 . '.';
            }
        }

        $out .='</span>';
        $out .='</span>';
        $out .='</div>';

//        foreach ($programs as $program) {
//            $out .= '<li>' . $program->Title . '</li>';
//        }
//        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function search_box() {
        $out = '<ul id="search" class="listin">';
        $out .= '<li class="search"><input type="search" value="" placeholder="the tudors"> </li>';
        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function tabSlider($code = false) {
        $this->tab +=1;
        return '<li  class="tab " data-page="' . $this->tab . '" >' . $code . '</li>';
    }

    function get_specials() {
        global $wpdb, $post;
        $destacados = new WP_Query();
        $fecha = date(Y) . '-' . date(m) . '-' . date(d);

        $categoria = 'infantil';
        $destacados->query(array(
            'category__and' => array(id_slug($categoria), id_slug('destacado')),
            'showposts' => 6,
            'meta_key' => 'imagen_destacado',
            'orderby' => 'rand'
        ));



        $li = '
					<ul id="fondos">';
        $i = 0;
        if ($destacados->have_posts()):
            while ($destacados->have_posts()): $destacados->the_post();


                if ($i == 0 || $i == 3) {
                    $w = 298;
                    $h = 170;
                    $size = "big";
                    $sh = 142;
                } elseif ($i == 1 || $i == 4) {
                    $w = 144;
                    $h = 84;
                    $size = "small first";
                    $sh = 100;
                } else {
                    $w = 144;
                    $h = 84;
                    $size = "small second";
                    $sh = 100;
                }

                $ficha = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND post_id = $post->ID  ");
                $ficha = explode(",", $ficha);

                $li .= '<li class="destacados ' . $size . '">
                             <img class="fondo" src="' . pt() . '?src=' . get('imagen_destacado') . '&amp;h=' . $h . '&amp;w=' . $w . '&amp;sy=0&amp;sh=' . $sh . '&amp;zc=1" alt="' . get_the_title() . '" height="' . $h . '" width="' . $w . '" />
                             <a class="evt destTitle" href="/mobile/?version_mobile=true&get_program=true&program_id=' . $ficha[0] . '" title="' . get_the_title() . '" data-func="loadContent" data-program="' . $ficha[0] . '"><span class="title">' . get_the_title() . '</span></a>        
                        </li>
                        ';
                $i++;
            endwhile;
        endif;
        $li .='</ul>';
        return $this->tabSlider($li);
    }

    function get_preferencias() {
        $out = "";

        $out .= '<ul class="gen-list">';
        $out .= '<li class="cate pref">';
        $out .= '<a href="#" class="evt" data-func="loadDest">Categorías Destacadas</a>';
        $out .= '</li>';
        $out .= '<li class="cate pref">';
        $out .= '<a href="#" class="evt" data-func="loadFavoritos">Favoritos</a>';
        $out .= '</li>';
        $out .= '<li class="cate pref">';
        $out .= '<a href="#" class="evt" data-func="loadUbicacion">Ubicación</a>';
        $out .= '</li>';
        $out .= '</ul>';

        return $this->tabSlider($out);
    }

    function preferencias($genders) {



        $out .= '<div class="prefTitle"><h1>Tus Categorías Destacadas</h1><span class="subPref">Sólo puedes escoger 3</span></div>';
        $out .= '<ul class="gen-list">';
        $i = 0;
        foreach ($genders as $gender) {
            $i++;
            if ($gender->slug != "HD" && $gender->slug != "Premium") {
                $out .= '<li class="prefList cate num_' . $i . '"><label for="' . $gender->slug . '">' . $gender->categoria . '</label>';
                $out .= '<input type="checkbox" id="' . $gender->slug . '" name="' . $gender->slug . '" class="evt categoria" value="' . $gender->slug . '" data-func="checkdata" data-event="change" />';
            }
        }
        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function favoritos($programs) {
        global $wpdb_pr, $wpdb;


        $out .='<div class = "prefTitle">';
        $out .='<h1>Tus Programas Favoritos</h1>';
        $out .='</div>';
        $out .='<ul class="gen-list" data-role="listview" data-theme="g">';

        foreach ($programs as $program) {

            $prog = $wpdb_pr->get_results("
                    SELECT Title, StartDate, StartTime, Duration, MpaaRating
                    FROM $wpdb_pr->prog
                    INNER JOIN $wpdb_pr->sch
                    ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
                    WHERE $wpdb_pr->prog.ProgramID = '$program'
                    ");



            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program%'  LIMIT 1");
            $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera' AND post_id=$ficha  LIMIT 1");



            $postContent = $wpdb->get_var("
                    SELECT $wpdb->posts.post_title 
                    FROM $wpdb->posts 
                    INNER JOIN $wpdb->postmeta 
                    ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
                    WHERE meta_key = 'ProgramID'
                    AND meta_value LIKE '%$program%'
                ");


            $out .= '<li class="programa">';
            if ($imagen) {
                $out .= '<img src="/wp-content/files_flutter/' . $imagen . '" class="program_img" alt="' . $postContent . '">';
            } else {
                $out .= '<img src="/wp-content/themes/televisionvtr/img/mobile/generico.jpg' . $imagen . '" class="program_img" alt="' . $postContent . '">';
            }
            $out .= '<label for="' . $program . '">' . $postContent . '</label>';


            if ($prog[0]->StartTime && $prog[0]->Duration) {
                $out .= '<span class=horario>' . $prog[0]->StartTime . ' - ' . $prog[0]->Duration . '</span>';
            }

            if ($prog[0]->MpaaRating) {
                $out .= '<span class="rating">(' . $prog[0]->MpaaRating . ')</span>';
            }
            $out .= '<input type="checkbox" class="evt categoria"  data-program="' . $program . '" data-event="change" data-func="watchlist" value="' . $program . '" name="' . $program . '" checked="checked" />';
            $out .= '</li>';
        }
        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function favoritosDest($programs) {
        global $wpdb, $post;
        $i = 0;
        $out = "";

        $out .= '<ul id="fondos">';
        foreach ($programs as $program) {

            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program%'  LIMIT 1");
            $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera' AND post_id=$ficha  LIMIT 1");

            $postContent = $wpdb->get_var("
                    SELECT $wpdb->posts.post_title 
                    FROM $wpdb->posts 
                    INNER JOIN $wpdb->postmeta 
                    ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
                    WHERE meta_key = 'ProgramID'
                    AND meta_value LIKE '%$program%'
                ");

            if ($i == 0 || $i == 3) {
                $w = 298;
                $h = 170;
                $size = "big";
                $sh = 142;
            } elseif ($i == 1 || $i == 4) {
                $w = 144;
                $h = 84;
                $size = "small first";
                $sh = 100;
            } else {
                $w = 144;
                $h = 84;
                $size = "small second";
                $sh = 100;
            }

            $out .= '<li class="destacados ' . $size . '">';
            $out .= '<img class="fondo" src="/wp-content/files_flutter/' . $imagen . '" alt="' . $postContent . '" height="' . $h . '" width="' . $w . '" />';
            $out .= '<a class="evt destTitle" href="" title="' . $postContent . '" data-func="loadContent" data-program="' . $program . '"><span class="title">' . $postContent . '</span></a>';
            $out .= '</li>';


            $i++;
        }

        $out .= '</ul>';

        return $this->tabSlider($out);
    }

    function geoubicacion() {
        global $wpdb_pr;

        $out = "";

        $comunas = $wpdb_pr->get_results("
                    SELECT *
                    FROM $wpdb_pr->comunas
                    GROUP BY region
            ");



        $out .= '<div id="geocode">';
        $out .= '<div id="actual">';
//        $out .= '<h1>Tu Ubicación</h1>';
//        $out .= '<span class="textoUb">Tu ubicación actual es:</span><span class="ubicacion">';
//        
//        $out .= '</span>';
//        $out .= '<span class="textoUb">Comuna:</span>';
//        $out .= '<span class="ubicacion">';
//        
//        $out .= '</span>';
        $out .= '</div>';
        $out .= '<span class="textoUb">Tu grilla actual es:</span><span class="ubicacion">' . $this->county . '</span></span>';
        $out .= '<select id="selectRegion" class="evt" data-func="selectUbicacion" data-event="change" name="selectRegion">';
        $out .= '<option value="">Selecciona tu Región</option>';
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


        $out .= '</select>';
        $out .= '<select id="selectComuna" name="selectComuna" >';
        $out .= '<option value="">Selecciona tu Comuna</option>';
        $out .= '</select>';

        $out .= '<a href="#" class="evt savebtn" data-func="changeLocation">Guardar</a>';


        $out .= '</div>';




        return $this->tabSlider($out);
    }

    function comunas($region) {
        global $wpdb_pr;


        $comunas = $wpdb_pr->get_results("
                    SELECT *
                    FROM $wpdb_pr->comunas
                    WHERE $wpdb_pr->comunas.region = $region
            ");




        $out .= '<option value="">Selecciona tu Comuna</option>';

        foreach ($comunas as $comuna) {

            $out .= '<option value="' . $comuna->grilla . '">' . $comuna->comuna . '</option>';
        }




        return $out;
    }

}

function ajax_zone() {



    if ($_POST["newDate"]) {

        $datos = array(
            "gender" => $_POST["genero"],
            "channel" => $_POST["channel"],
            "date" => $_POST["newDate"],
            "display" => "programs"
        );

        $ajaxGrill = new getgrill($datos);
        $out = $ajaxGrill->getgrill($datos);
        die($out);
    } elseif ($_POST["program"]) {

        $programID = $_POST["program"];
        $datos['display'] = "program";

        $mobile_query = array(
            
            "display" => "program",
            "programID" => $programID
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->getgrill($mobile_query);
        
        die($out);
        
    } elseif ($_POST["display"] == "channelList") {

        $mobile_query = array(
            
            "gender" => $_POST["genders"],
            "location" => $_POST["location"],
            "display" => "channelList"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->getgrill($mobile_query);
        
        $foo = array(
            "out" => $out,
            "dataPage" => $_POST["dataPage"]
        );

        die(json_encode($foo));
    } elseif ($_POST["display"] == "programList") {


        $mobile_query = array(
            "display" => "programs",
            "channel" => $_POST["channelID"]
        );


        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->getgrill($mobile_query);

        $foo = array(
            "out" => $out,
            "dataPage" => $_POST["dataPage"]
        );

        die(json_encode($foo));
    } elseif ($_POST["display"] == "preferencias") {


        $mobile_query = array(
            "display" => "preferencias"
        );


        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->getgrill($mobile_query);

        die($out);
    } elseif ($_POST["display"] == "favoritos") {


        $mobile_query = array(
            "display" => "favoritos"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->favoritos($_POST["programs"]);

        die($out);
    } elseif ($_POST["display"] == "favoritosDest") {


        $mobile_query = array(
            "display" => "favoritos"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->favoritosDest($_POST["programs"]);

        die($out);
    } elseif ($_POST["display"] == "destacados") {


        $mobile_query = array(
            "display" => "favoritos"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_specials();

        die($out);
    } elseif ($_POST["display"] == "ubicacion") {


        $mobile_query = array(
            "display" => "favoritos",
            "location" => $_POST["county"]
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->geoubicacion();

        die($out);
    } elseif ($_POST["display"] == "selectorUbicacion") {


        $mobile_query = array(
            "display" => "favoritos"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->comunas($_POST["region"]);

        die($out);
    } elseif ($_POST["display"] == "changeLocacion") {


        $mobile_query = array(
            "location" => $_POST["county"],
            "display" => "phpload"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->getgrill($mobile_query);

        die($out);
    } elseif ($_POST["slug"]) {

        $mobile_query = array(
            "gender" => $_POST["slug"],
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->channels_list($ajaxGrill->get_channels(), true);

        die($out);
    } else {
        die("error");
    }
}

add_action('wp_ajax_ajax_zone', 'ajax_zone');
add_action('wp_ajax_nopriv_ajax_zone', 'ajax_zone');
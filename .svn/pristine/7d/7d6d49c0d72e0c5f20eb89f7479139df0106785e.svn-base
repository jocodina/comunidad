<?php
/*
  Plugin Name: mobile data
  Plugin URI: maxvillegas.com
  Description: mobile theme
  Version: 2
  Author: Max Villegas
  Author URI: http://mvillegas.com/
 */
//GRILL
date_default_timezone_set('Chile/Continental');
class getgrill {

    var $timezone;
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
    var $mq;

    //GRILL
    function getgrill($mobile_query = false) {
        global $horario;
        $mq = $this->sanitize_gets($mobile_query);
        $this->mq = $this->sanitize_gets($mobile_query);
         if(get_field('_timezone','options')){
           $this->timezone = get_field('_timezone','options');
        }else{
           $this->timezone = $horario; 
        }
        $this->next_day = $this->timezone == 4 ? '0400' : '0300';
        $this->date = date('mdy');
        $this->get_location($this->mq["location"]);
        $this->get_gender($this->mq["gender"]);
        $this->get_category($this->mq["category"]);
        $this->get_type($this->mq["type"]);
        $this->get_group($this->mq["group"]);
        $this->channel = $this->mq["channel"];
       

        
    }
    
    function get_data() {
        //carga el php inicial
        if ($this->mq["display"] == "phpload") {
            //destacados
            print $this->get_specials();
            //categorias
            if($this->mq["localgenders"] == null && $this->mq["firstLoad"] == null){
                print $this->genders_list($this->get_genders()); 
            }else{
                $localGenders = explode(',',$this->mq["localgenders"]);
                print $this->tabSlider($this->localGenderList($localGenders));
            }
            
            //horarios
//            print $this->get_horarios();

        } else {

            //carga las pantallas por ajax

            if ($this->mq["display"] == "channels") {
                return $this->channels_list($this->get_channels());
            }
            if ($this->mq["display"] == "programs") {
                return $this->programs_list($this->get_programs());
            }
            if ($this->mq["display"] == "program") {
                return $this->program($this->mq["programID"],$this->mq["startTime"],$this->mq["contentLast"]);
            }
            if ($this->mq["display"] == "preferencias") {
                return $this->preferencias($this->get_genders());
            }
            if ($this->mq["display"] == "search_list") {
                print $this->search_result($this->mq["search"]);
            }
            if ($this->mq["display"] == "channelList") {
               return $this->channelsByGender($this->get_channels());
            }
            if ($this->mq["display"] == "loadPreferencias") {
                return $this->get_preferencias();
            }       
        }
    }

    //CHANNELS

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

    function get_channels_by_gender() {
        return $this->channelsByGender($this->get_channels());
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
                GROUP BY $wpdb_pr->sch.StartTime
         ");
        
        

        return $wpdb_pr->get_results($query, 'OBJECT');
    }
    
    function get_channelprog() {
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
        GROUP BY $wpdb_pr->sch.StartTime
        "
            );
    
    return $wpdb_pr->get_results($query, 'OBJECT');
}
    
    function get_channelprog_next() {
    global $wpdb_pr;
    if ($this->date) {
        $nextday = substr($this->date, 2, 2) + 1;
        $month = substr($this->date, 0, 2);
        $sumaunmes = mktime(0, 0, 0, $month, $nextday, date('Y'));
        $nextday = date("mdy", $sumaunmes);
    } else {
        $fecha = date('mdy');
        $nextday = substr($fecha, 2, 2) + 1;
        $sumaunmes = mktime(0, 0, 0, date('m'), $nextday, date('Y'));
        $nextday = date("mdy", $sumaunmes);
    }


    $query = ("
        SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration,Duration,imagen, senal, genero, $this->county
        FROM $wpdb_pr->sch 
        INNER JOIN $wpdb_pr->prog
        ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
        INNER JOIN $wpdb_pr->chn_web
        ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->sch.ChannelID)
        INNER JOIN $wpdb_pr->full
        ON ($wpdb_pr->full.codigo = $wpdb_pr->sch.ChannelID)
        WHERE $wpdb_pr->sch.StartDate = '$nextday' AND $wpdb_pr->sch.StartTime < '$this->next_day'
        AND $wpdb_pr->sch.ChannelID = '$this->channel'
        GROUP BY $wpdb_pr->sch.StartTime"
    );
    return $wpdb_pr->get_results($query, 'OBJECT');
}
    
    function get_channelprog_prev() {
     global $wpdb_pr;
     
    $query = ("
        SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration,Duration,imagen, senal, genero, $this->county
        FROM $wpdb_pr->sch 
        INNER JOIN $wpdb_pr->prog
        ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
        INNER JOIN $wpdb_pr->chn_web
        ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->sch.ChannelID)
        INNER JOIN $wpdb_pr->full
        ON ($wpdb_pr->full.codigo = $wpdb_pr->sch.ChannelID)
        WHERE $wpdb_pr->sch.StartDate = $this->date 
        AND $wpdb_pr->sch.StartTime < '$this->next_day'
        AND $wpdb_pr->sch.ChannelID = '$this->channel' 
        ORDER BY  $wpdb_pr->sch.StartTime 
        DESC LIMIT 1"
            );
    return $wpdb_pr->get_row($query, 'OBJECT');
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

  

    function get_location($location=false) {
        global $wpdb_pr;
        
        $county = $wpdb_pr->get_var("
                SELECT grilla
                FROM $wpdb_pr->comunas
                WHERE comuna = '$location'
                GROUP BY grilla
                LIMIT 1
                ");
        
        $location = $county ? $county : "santiago";
        $this->county = $location;
    }

    //TAXONOMY
    function get_genders() {
        global $wpdb_pr;
        return $wpdb_pr->get_results("SELECT categoria, slug FROM $wpdb_pr->chn_cat ORDER BY id ASC", 'OBJECT');
    }

    function get_gender($gender=false) {
        if ($gender == "series-peliculas") {
            $gender = "Cine&Series";
        }
        if ($gender == "tendencias") {
            $gender = "Estilos & Tendencias";
        }
        if($gender == "Premium"){
            $this->gender = "";
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

        if(!$this->get_search($search)){
                $out .= '<li class="programa"><a href="#" class="evt">';
                $out .= '<h2 class="searchTitle"> No se encontró el programa ingresado</h2>';
                $out .= '</a></li>';
        }else{
        
        foreach ($this->get_search($search) as $s) {

            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$s->ProgramID%'  LIMIT 1");

            $out .= '<li class="programa"><a href="#" class="evt" data-func="loadContent"  data-program="' . $s->ProgramID . '" >';
            $out .= has_post_thumbnail($ficha) ? wp_get_attachment_image(get_post_thumbnail_id( $ficha ), 'mobileSearch', false, array('class' => 'program_img')) : '<img src="/wp-content/themes/comunidadtv/img/mobile/generico.jpg" class="program_img" alt="' . $result_prev->Title . '" title="' . $result_prev->Title . '">' ;
            $out .= '<h2 class="searchTitle">' . $s->Title . '</h2>';
            $out .= '</a></li>';
            
        }
        }
        return $out;
    }



    function sanitize_gets($mobile_query = false) {
        if($mobile_query){
            foreach ($mobile_query as $name => $value) {
                $this->mq[$name] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', urldecode($value));
            }
        }
        return $this->mq;
    }

    //htmlCode
    function channels_list($chnnels, $ajax=false) {
        $out = '<ul data-role="listview" class="listin">';
        foreach ($chnnels as $channel) {
            $out .= '<li class="canal">';
            $out .= '<a href="#"  class="evt" data-date="'. $this->date .'" data-func="loadPrograms" data-chnid="' . $channel->codigo . '" title="' . $channel->senal . '">';
            $out .= '<img  class="img-canal" src="/wp-content/themes/comunidadtv/img/foto/' . strtolower($channel->imagen) . '" alt="' . $channel->senal . '" /> ';
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
//        echo '<pre>';
//        print_r($chnnels[0]->genero);
//        echo '</pre>';

        if ($chnnels[0]->genero == 'Cine&Series') {
            $out .= '<h1 class = "pad num_1">Cine y series</h1>';
        } elseif ($chnnels[0]->genero == 'Infantil') {
            $out .= '<h1 class = "pad num_2">Infantil</h1>';
        } elseif ($chnnels[0]->genero == 'Deportes' && $chnnels[0]->categoria != 'Premium') {
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
        } elseif ($chnnels[0]->categoria == 'Premium' && $chnnels[0]->grupo != 'HD' && $chnnels[0]->genero != 'Compra de Eventos') {
            $out .= '<h1 class = "pad num_11">Premium</h1>';
        } elseif ($chnnels[0]->genero == 'Compra de Eventos') {
            $out .= '<h1 class = "pad num_13">Eventos Pagados</h1>';
        } elseif ($chnnels[0]->grupo == 'HD') {
            $out .= '<h1 class = "pad num_12">HD</h1>';
        } elseif ($chnnels[0]->genero != $chnnels[10]->genero || $chnnels[0]->genero != $chnnels[60]->genero || $chnnels[0]->genero != $chnnels[80]->genero) {
            $out .= '<h1 class = "pad num_1">Todos los canales</h1>';
        }

        ;
        $out .= '<ul data-role="listview" class="listin">';

        foreach ($chnnels as $channel) {

            $out .= '<li class="canal">';

            $out .= '<a href="#" class="evt" data-func="loadPrograms" data-chnid="' . $channel->codigo . '" title="' . $channel->senal . '">';

            $out .= '<img  class="img-canal" src="/wp-content/themes/comunidadtv/img/foto/' . strtolower($channel->imagen) . '" alt="' . $channel->senal . '" /> ';

            $out .= '<span class="meta-data channel-number">' . $channel->{$this->county} . '</span> <span class="meta-data">' . $channel->senal . '</span>';

            $out .= "</a>";

            $out .= '</li>';

        }


        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function genders_list($genders) {
            $svgClass = "";
            
        
            $out .= '<ul class="gen-list">';
            $out .= '<div class="prefTitle"><h1>Tus Categorías Destacadas</h1><span class="subPref">Puedes administrar las categorías desde los Ajustes</span></div>';
            $out .= '<li class="cate"><a id="Series & Películas" class="evt num_1" data-func="loadChannel" data-location="' . $this->county . '" data-gender="series-peliculas" data-type="gender">Cine y series</a></li>';
            $out .= '<li class="cate "><a id="Premium" class="evt num_11" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Premium" data-type="group" >Premium</a></li>';
            $out .= '<li class="cate"><a id="Eventos pagados" class="evt num_13" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Compra de Eventos" data-type="gender">Eventos Pagados</a></li>';
            $out .= '<li class="cate"><a id="deportes" class="evt num_3" data-func="loadChannel" data-location="' . $this->county . '" data-gender="deportes" data-type="gender">Deportes</a></li>';
            $out .= '<li class="cate"><a id="infantil" class="evt num_2" data-func="loadChannel" data-location="' . $this->county . '" data-gender="infantil" data-type="gender">Infantil</a></li>';
            $out .= '<li class="cate"><a id="Cultura" class="evt num_6" data-func="loadChannel" data-location="' . $this->county . '" data-gender="cultural" data-type="gender">Cultura</a></li>';
            $out .= '<li class="cate"><a id="musica" class="evt num_4" data-func="loadChannel" data-location="' . $this->county . '" data-gender="musica" data-type="gender">Música</a></li>';
            $out .= '<li class="cate"><a id="tendencias" class="evt num_5" data-func="loadChannel" data-location="' . $this->county . '" data-gender="tendencias" data-type="gender">Tendencias</a></li>';
            $out .= '<li class="cate"><a id="noticias" class="evt num_7" data-func="loadChannel" data-location="' . $this->county . '" data-gender="noticias" data-type="gender">Noticias</a></li>';
            $out .= '<li class="cate"><a id="Nacional" class="evt num_8" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Nacional" data-type="gender">Nacional</a></li>';
            $out .= '<li class="cate"><a id="internacional" class="evt num_9" data-func="loadChannel" data-location="' . $this->county . '" data-gender="internacional" data-type="gender">Internacional</a></li>';
            $out .= '<li class="cate "><a id="HD" class="evt num_12" data-func="loadChannel" data-location="' . $this->county . '" data-gender="HD" data-type="group" >HD</a></li>';
            $out .= '<li class="cate"><a id="adulto" class="evt num_10" data-func="loadChannel" data-location="' . $this->county . '" data-gender="adulto" data-type="gender">Adulto</a></li>';
            $out .="</ul>";
            
            return $this->tabSlider($out);

    }

    function programs_list() {
        global $wpdb;
        
        $result_prev = $this->get_channelprog_prev();        
        $result_prg = $this->get_channelprog();
        $result_prg_next = $this->get_channelprog_next(); 
        
        $fechaHoy = date('mdy');

        for ($i = 1; $i <= 5; $i++) {
            $timeStamp = StrToTime($fechaHoy);
            $inday[$i] = StrToTime('+' . $i . ' days', $timeStamp);
            $inday[$i] = date('mdy', $inday[$i]);
        }

        $out .='<div class = "channelTitle">';
        $out .='<img src="/wp-content/themes/comunidadtv/img/foto/' . $result_prg[0]->imagen . '" alt="' . $result_prg[0]->senal . '" title="' . $result_prg[0]->senal . '" />';
        $out .='<span class="chnNum">' . $result_prg[0]->{$this->county} . '</span>';
        $out .='<h1>' . $result_prg[0]->senal .'</h1>';
        $out .='<a href="" class="evt cancel" data-func="backButton" data-fade="channels" title="Volver">Volver</a>';
        $out .='</div>';
        $out .='<select name="fechaSelect" id="selectChange" class ="evt selectDays" data-func="getDate" data-event="change" data-gender="' . $result_prg[0]->genero . '" data-chanel="' . $programs[0]->ChannelID . '">';
        $out .='<option value="' . $fechaHoy . '" class = "selectDaysOption">' . $fechaHoy . '</option>';

        for ($i = 1; $i <= 5; $i++) {
            $out .='<option value="' . $inday[$i] . '" class = "selectDaysOption">' . $inday[$i] . '</option>';
        }

        $out .='</select>';
        $out .='<ul class="gen-list" data-role="listview" data-theme="g">';
        
        $p = 0;
        
        foreach ($result_prg as $program) {

            $hora = substr($program->StartTime, 0, 2);
            $minuto = substr($program->StartTime, -2);

            $horaEnd = substr($program->Duration , 0, 2);
            $minutoEnd = substr($program->Duration , -2);

            $hora1 = $hora.':'.$minuto;
            $hora2 = $horaEnd.':'.$minutoEnd;
            $hora1=split(":",$hora1);
            $hora2=split(":",$hora2);
            $horas=(int)$hora1[0]+(int)$hora2[0];
            $minutos=(int)$hora1[1]+(int)$hora2[1];
            $horas+=(int)($minutos/60);
            $minutos=$minutos%60;
            if($minutos < 10)$minutos="0".$minutos; 
            if(abs($horas) < 10)$horas = '0'.abs($horas);
            
            if($p == 0 && $program->StartTime > $this->next_day ){
                
                $horaPrev = substr($result_prev->StartTime, 0, 2);
                $minutoPrev = substr($result_prev->StartTime, -2);

                $horaPrevEnd = substr($result_prev->Duration , 0, 2);
                $minutoPrevEnd = substr($result_prev->Duration , -2);

                $horaPrev1 = $horaPrev.':'.$minutoPrev;
                $horaPrev2 = $horaPrevEnd.':'.$minutoPrevEnd;
                $horaPrev1=split(":",$horaPrev1);
                $horaPrev2=split(":",$horaPrev2);
                $horasPrev=(int)$horaPrev1[0]+(int)$horaPrev2[0];
                $minutosPrev=(int)$horaPrev1[1]+(int)$horaPrev2[1];
                $horasPrev+=(int)($minutosPrev/60);
                $minutosPrev=$minutosPrev%60;
                if($minutosPrev < 10)$minutosPrev="0".$minutosPrev; 
                if($horasPrev > 23)$horasPrev = 24 - $horasPrev;
                if(abs($horasPrev) < 10)$horasPrev = '0'.abs($horasPrev);
                
                
                $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$result_prev->ProgramID%'  LIMIT 1");
                
                $horaPrev = date('H',mktime($horaPrev - $this->timezone,0,0,0,0,0));
                $horasPrev = date('H',mktime($horasPrev - $this->timezone,0,0,0,0,0));
                
                $out .= '<li class="programa">';
                $out .= '<a href="#" class="evt" data-func="loadContent" data-program=' . $result_prev->ProgramID . ' data-startTime="'.$result_prev->StartTime.'" data-cont="true">';
                
                $out .= has_post_thumbnail($ficha) ? wp_get_attachment_image(get_post_thumbnail_id( $ficha ), 'mobileProgram', false, array('class' => 'program_img')) : '<img src="/wp-content/themes/comunidadtv/img/mobile/generico.jpg" class="program_img" alt="' . $result_prev->Title . '" title="' . $result_prev->Title . '">' ;

                $out .= '<h2>' . $result_prev->Title . '</h2>';
                
                $out .= '<span class=horario>' . $horaPrev . ':' . $minutoPrev . ' - ' . $horasPrev . ':' . $minutosPrev . '</span>';

                if ($result_prev->MpaaRating) {
                    $out .= '<span class="rating">(' . $result_prev->MpaaRating . ')</span>';
                }
                $out .= '</a>';
                $out .= '</li>';
            }
            
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
            
            //resto las horas
            $hora = date('H',mktime($hora-$this->timezone,0,0,0,0,0));
            $horas = date('H',mktime($horas-$this->timezone,0,0,0,0,0));
            
            $out .= '<li class="programa">';
            $out .= '<a href="#" class="evt" data-func="loadContent" data-hour="'.$hora.'"  data-program=' . $program->ProgramID . ' data-startTime="'.$program->StartTime.'" data-cont="true">';
            
            $out .= has_post_thumbnail($ficha) ? wp_get_attachment_image(get_post_thumbnail_id( $ficha ), 'mobileProgram', false, array('class' => 'program_img')) : '<img src="/wp-content/themes/comunidadtv/img/mobile/generico.jpg" class="program_img" alt="' . $result_prev->Title . '" title="' . $result_prev->Title . '">' ;
            
            $out .= '<h2>' . $program->Title . '</h2>';
            
            
            $out .= '<span class=horario>' .$hora.':'.$minuto.' - ' .$horas.':'.$minutos.'</span>';

            if ($program->MpaaRating) {
                $out .= '<span class="rating">(' . $program->MpaaRating . ')</span>';
            }
            

            $out .= '</a>';
            $out .= '</li>';
            
            $p++;
        }
        foreach ($result_prg_next as $program) {
            $hora = substr($program->StartTime, 0, 2);
            $minuto = substr($program->StartTime, -2);

            $horaEnd = substr($program->Duration , 0, 2);
            $minutoEnd = substr($program->Duration , -2);

            $hora1 = $hora.':'.$minuto;
            $hora2 = $horaEnd.':'.$minutoEnd;
            $hora1=split(":",$hora1);
            $hora2=split(":",$hora2);
            $horas=(int)$hora1[0]+(int)$hora2[0];
            $minutos=(int)$hora1[1]+(int)$hora2[1];
            $horas+=(int)($minutos/60);
            $minutos=$minutos%60;
            if($minutos < 10)$minutos="0".$minutos; 
            if($horas > 23)$horas = 24 - $horas;
            if(abs($horas) < 10)$horas = '0'.abs($horas);
            
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
           
            
            $hora = date('H',mktime($hora-$this->timezone,0,0,0,0,0));
            $horas = date('H',mktime($horas-$this->timezone,0,0,0,0,0));
            
            $out .= '<li class="programa">';
            $out .= '<a href="#" class="evt" data-func="loadContent" data-hour="'.$hora.'" data-program=' . $program->ProgramID . ' data-startTime="'.$program->StartTime.'" data-cont="true">';
            
            $out .= has_post_thumbnail($ficha) ? wp_get_attachment_image(get_post_thumbnail_id( $ficha ), 'mobileProgram', false, array('class' => 'program_img')) : '<img src="/wp-content/themes/comunidadtv/img/mobile/generico.jpg" class="program_img" alt="' . $result_prev->Title . '" title="' . $result_prev->Title . '">' ;
            
            $out .= '<h2>' . $program->Title . '</h2>';
            
            $out .= '<span class=horario>' .$hora.':'.$minuto.' - ' .$horas.':'.$minutos.'</span>';

            if ($program->MpaaRating) {
                $out .= '<span class="rating">(' . $program->MpaaRating . ')</span>';
            }
            

            $out .= '</a>';
            $out .= '</li>';
            
        }
        
        
        $out .="</ul>";

        return $this->tabSlider($out);
    }

    function program($programID, $startTime=false, $lastCont=false) {
        global $wpdb, $wpdb_pr;

        $fechaHoy = date('mdy');
        $favoritos = true;
        
        $ficha = $wpdb->get_results("
                    SELECT * 
                    FROM $wpdb->posts 
                    INNER JOIN $wpdb->postmeta 
                    ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
                    WHERE meta_key = 'ProgramID'
                    AND meta_value LIKE '%$programID%'
                ");

        $fichaID = $ficha[0]->post_id;

        
        $genero = $wpdb->get_var("
                    SELECT meta_value 
                    FROM $wpdb->postmeta 
                    WHERE meta_key = 'info_category'
                    AND post_id = '$fichaID'
                ");

        $fichaProg = $wpdb_pr->get_results("
                    SELECT *
                    FROM $wpdb_pr->prog
                    WHERE ProgramID = '$programID' 
                ");

        if ($startTime != false) {
            $fichaDates = $wpdb_pr->get_results("
                        SELECT $wpdb_pr->sch.StartTime,StartDate,Duration,ChannelID
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$programID' 
                        AND StartTime = '$startTime'
                    ");
        } else {
            $fichaDates = $wpdb_pr->get_results("
                        SELECT $wpdb_pr->sch.StartTime,StartDate,Duration,ChannelID
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$programID'
                    ");
        }
        
       

        if ($startTime == false) {
            if ($fichaDates) {
                date_default_timezone_set('Chile/Continental');
                $hoy = date('mdyHi');

                $hoyMes = substr($hoy, 0, 2);
                $hoyDia = substr($hoy, 2, 2);
                $hoyAno = substr($hoy, 4, 2);
                $hoyHora = substr($hoy, 6, 2);
                $hoyMinuto = substr($hoy, -2);
                $timestampHoy = mktime($hoyHora, $hoyMinuto, 0, $hoyMes, $hoyDia, $hoyAno);

                $i = 0;
                foreach ($fichaDates as $date) {
                    
                    $dateMes = substr($date->StartDate, 0, 2);
                    $dateDia = substr($date->StartDate, 2, 2);
                    $dateAno = substr($date->StartDate, -2);
                    $dateHora = substr($date->StartTime, 0, 2);
                    $dateMinuto = substr($date->StartTime, -2);

                    $timestampDate = mktime($dateHora, $dateMinuto, 0, $dateMes, $dateDia, $dateAno);
                    
                    if ($timestampDate >= $timestampHoy) {
                        $datesMayores[$i] = date('mdy', $timestampDate);
                        $i++;
                    }
                }
                
              if($datesMayores){  
                  
                sort($datesMayores);
                $startDate = $datesMayores[0];

                $startTimes = $wpdb_pr->get_results("
                        SELECT $wpdb_pr->sch.StartTime, StartDate
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$programID'
                        AND StartDate >= '$startDate'
                        ");  

                date_default_timezone_set('Chile/Continental');

                $timestampTiempo = mktime(date('H'), date('i'), 0, date('m'), date('d'), date('y'));

                $i = 0;
                foreach ($startTimes as $start) {
                    
                    $horaTime = substr($start->StartTime, 0, 2);
                    $minutoTime = substr($start->StartTime, -2);
                    $mesTime = substr($start->StartDate, 0, 2);
                    $diaTime = substr($start->StartDate, 2, 2);
                    $anoTime = substr($start->StartDate, -2);

                    $timestampTime = mktime($horaTime-$this->timezone, $minutoTime, 0, $mesTime, $diaTime, $anoTime);

                    if ($timestampTime >= $timestampTiempo) {
                        $horaArray[$i] = date('mdyHi', $timestampTime);
                        $i++;
                    }
                }
                
                
                if ($horaArray) {
                    sort($horaArray);
                    $Nearest = $horaArray[0];
                    $startDate = substr($Nearest, 0, 6);
                    $Nearest = substr($Nearest, -4);
                    
                    
                    $timestamp = mktime(substr($Nearest,0,2)+$this->timezone, substr($Nearest,-2), 0, substr($startDate,0,2), substr($startDate,2,2), '20'.substr($startDate,-2));
                    $startDate = date('mdy',$timestamp);
                    $timestamp = date('Hi',$timestamp);
                    
                    $durationDest = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->sch.Duration
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$programID'
                        AND StartDate = '$startDate'
                        AND StartTime = '$timestamp'
                        ");

                    $canal = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->sch.ChannelID
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$programID'
                        AND StartDate = '$startDate'
                        AND StartTime = '$timestamp'
                        ");
                    $canal = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->chn_web.senal
                        FROM $wpdb_pr->chn_web 
                        WHERE codigo = '$canal'
                        ");
                    
                    $startDate = substr($horaArray[0], 0, 6);
                    
                }else{
                   $favoritos = false;  
                }
              }else{
                 $favoritos = false; 
              }
            } else {
                $favoritos = false;
            }
        }
        $out .= '<div class="tabWrap titleProgram">';
        $out .= $fichaProg[0]->Title ? '<h1 class="titleFicha">' . $fichaProg[0]->Title . '</h1>' : '<h1 class="titleFicha">' . $ficha[0]->post_title . '</h1>';
        $out .= '<span class="canal">'.$canal .'</span>';
        if ($lastCont == false) {
            $out .='<a href="#" class="evt cancel cont" data-fade="inicio" data-func="backButton" title="Volver">Volver</a>';
        } else {
            $out .='<a href="#" class="evt cancel cont" data-fade="last" data-func="backButton" title="Volver">Volver</a>';
        }
        $out .= '</div>';
        $out .='<div class="tabWrap">';

        $out .= has_post_thumbnail($fichaID) ? wp_get_attachment_image(get_post_thumbnail_id( $fichaID ), 'fichaMobile', false, array('class' => 'imgFicha')) : '<img class="imgFicha" src="' . get_bloginfo('template_url') . '/img/auxi/noimg.jpg' . $fichaImg . '" alt="" title="" />';


        if ($favoritos == true) {
            
            $out .='<div class="metaProgram">';

            if ($startTime == false) {
                $hora = substr($Nearest, 0, 2);
                $minuto = substr($Nearest, -2);

                $horaEnd = substr($durationDest, 0, 2);
                $minutoEnd = substr($durationDest, -2);
            } else {
                $hora = substr($fichaDates[0]->StartTime, 0, 2);
                $minuto = substr($fichaDates[0]->StartTime, -2);

                $horaEnd = substr($fichaDates[0]->Duration, 0, 2);
                $minutoEnd = substr($fichaDates[0]->Duration, -2);
            }


            $hora1 = $hora . ':' . $minuto;
            $hora2 = $horaEnd . ':' . $minutoEnd;
            $hora1 = split(":", $hora1);
            $hora2 = split(":", $hora2);
            $horas = (int) $hora1[0] + (int) $hora2[0];
            $minutos = (int) $hora1[1] + (int) $hora2[1];
            $horas+=(int) ($minutos / 60);
            $minutos = $minutos % 60;
            if ($minutos < 10)
                $minutos = "0" . $minutos;
            if ($horas > 23)
                $horas = 24 - $horas;
            if (abs($horas) < 10)
                $horas = '0' . abs($horas);
            
            if ($startTime != false) {
                $hora = date('H',mktime($hora-$this->timezone,0,0,0,0,0));
                $horas = date('H',mktime($horas-$this->timezone,0,0,0,0,0));
                $out .=$fichaDates[0]->StartTime ? '<span class="duracion">' . $hora . ':' . $minuto . ' - ' . $horas . ':' . $minutos . '</span>' : "";
            } else {
                $recentDay = substr($startDate, 2,2);
                $recentMonth = substr($startDate, 0,2);
                $recentYear = substr($startDate, -2);
                $out .= $Nearest ? '<p class="duracion"><span>'.$recentDay .'/'.$recentMonth .'/'.$recentYear.' - '.$hora . ':' . $minuto.'  hrs.</span></p>' : "";
            }
            $out .='<span class="watchlist">';
            $out .='<label for="watch">Agregar a favoritos</label>';
            if ($startTime == false) {
                $out .='<input type="checkbox" class="evt" data-event="change" name="watch" id="watch" value="" data-program="' . $programID . '" data-startTime="' . $fichaDates[0]->StartTime . '" data-func="watchlist" />';
            } else {
                $out .='<input type="checkbox" class="evt" data-event="change" name="watch" id="watch" value="" data-program="' . $programID . '" data-startTime="' . $fichaDates[0]->StartTime . '" data-func="watchlist" />';
            }
            $out .='</span>';
            $out .='</div>';
        }

        $classMargin = "";
        if ($startTime == false)
            $classMargin = 'class="marginTop"';

        $out .='<p ' . $classMargin . '>';
        if ($ficha[0]->post_excerpt) {
            $out .=$ficha[0]->post_excerpt;
        } elseif ($fichaProg[0]->Desc1) {
            $out .=$fichaProg[0]->Desc1;
        } elseif ($fichaProg[0]->Desc2) {
            $out .=$fichaProg[0]->Desc2;
        } elseif ($fichaProg[0]->Desc3) {
            $out .=$fichaProg[0]->Desc3;
        } else {
            $out .='Aún no hay descripción';
        }
        $out .='</p>';


        $out .='<span class="showItems">';
        $out .='<span class="Item">';
        $out .=$genero ? '<strong>Género: </strong>'.$genero : "";
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
        global $wpdb, $post, $wpdb_pr;
        $destacados = new WP_Query();
        $fecha = date('Y') . '-' . date('m') . '-' . date('d');

        $destacados->query(array(
                'post_type' => 'post',
                'orderby' => 'meta_value_num', //menu_order
                'meta_key' => 'fecha_destacado',
                'order' => 'DESC',
                'meta_query' => array(
                    array(
                        'key' => 'fecha_destacado',
                        'value' => $fecha,
                        'compare' => "<=",
                        'type'=>"DATE"
                    )
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'posiciones',
                        'field' => 'slug',
                        'terms' => 'destacado'
                    )
                ),
                'posts_per_page' => 6

            
        ));



        $li = '<ul id="fondos">';
        $i = 0;
        if ($destacados->have_posts()):
            while ($destacados->have_posts()): $destacados->the_post();
                if ($i == 0 || $i == 3) {
                    $crop = 'destacadoMobilBig';
                    $size = "big";
                    $sh = 142;
                } elseif ($i == 1 || $i == 4) {
                    $crop = 'destacadoMobilSmall';
                    $size = "small first";
                    $sh = 100;
                } else {
                    $crop = 'destacadoMobilSmall';
                    $size = "small second";
                    $sh = 100;
                }
                $ficha = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND post_id = $post->ID  ");
                $ficha = explode(",", $ficha);
                
                $sinFicha = true;
                
                
                foreach ($ficha as $fic) {

                    $prog = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->sch.StartTime
                        FROM $wpdb_pr->sch  
                        WHERE $wpdb_pr->sch.ProgramID = '$fic'
                        ");
                    $check = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->sch.StartTime
                        FROM $wpdb_pr->sch  
                        WHERE $wpdb_pr->sch.ProgramID = '$fic'
                        ");

                    if ($check != "") {
                        $fichaCont = $fic;
                        $sinFicha = false;
                    }
                }
               
                
                $li .= '<li class="destacados ' . $size . '">';
                if($sinFicha == false){
                    
                    $canal = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->sch.ChannelID
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$fichaCont'
                        ");
                
                    $canal = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->chn_web.senal
                        FROM $wpdb_pr->chn_web 
                        WHERE codigo = '$canal'
                        ");
                    
                    $li .= '<a href="#" class="evt" title="' . get_the_title() . '" data-func="loadContent" data-program="' . $fichaCont . '" >'.get_images(get_post_thumbnail_id( $post->ID ), $crop);
                }else{
                    
                    $canal = $wpdb_pr->get_var("
                        SELECT $wpdb_pr->sch.ChannelID
                        FROM $wpdb_pr->sch
                        WHERE ProgramID = '$ficha[0]'
                        ");
                
                    $canal = $wpdb_pr->get_var("
                            SELECT $wpdb_pr->chn_web.senal
                            FROM $wpdb_pr->chn_web 
                            WHERE codigo = '$canal'
                            ");
                    
                    
                    $li .= '<a href="#" class="evt" title="' . get_the_title() . '" data-func="loadContent" data-program="' . $ficha[0] . '" >'.get_images(get_post_thumbnail_id( $post->ID ), $crop);
                }
                $li .= '<div class="destTitle">
                        <span class="title">' . get_the_title() . '</span>
                        <span class="subtitle">' . $canal . '</span>
                        </div>'; 
                $li .= '</a>';
                $li .= '</li>';
                
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
        $out .= '<a href="#" class="evt pref" data-func="loadDest">Categorías Destacadas</a>';
        $out .= '</li>';
        $out .= '<li class="cate pref">';
        $out .= '<a href="#" class="evt pref" data-func="loadFavoritos">Favoritos</a>';
        $out .= '</li>';
        $out .= '<li class="cate pref">';
        $out .= '<a href="#" class="evt pref" data-func="loadUbicacion">Ubicación</a>';
        $out .= '</li>';
        $out .= '</ul>';

        return $this->tabSlider($out);
    }

    function preferencias($genders) {

        $out .= '<div class="prefTitle"><h1>Tus Categorías Destacadas</h1></div>';
        $out .= '<ul class="gen-list">';
//        $i = 0;
//        foreach ($genders as $gender) {
//            $i++;
//            if ($gender->slug != "HD" && $gender->slug != "Premium") {
//                $out .= '<li class="prefList cate num_' . $i . '"><label for="' . $gender->slug .'Dest">' . $gender->categoria . '</label>';
//                $out .= '<input type="checkbox" id="' . $gender->slug .'Dest" name="' . $gender->slug . '" class="evt categoria" value="' . $gender->slug . '" data-func="checkdata" data-event="change" />';
//            }
//        }
        $out .= '<li class="prefList cate num_1"><label for="series-peliculasDest">Cine y series </label><input type="checkbox" id="series-peliculasDest" name="series-peliculas" class="evt categoria" value="series-peliculas" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_2"><label for="infantilDest">Infantil</label><input type="checkbox" id="infantilDest" name="infantil" class="evt categoria" value="infantil" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_3"><label for="deportesDest">Deportes</label><input type="checkbox" id="deportesDest" name="deportes" class="evt categoria" value="deportes" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_4"><label for="musicaDest">Música</label><input type="checkbox" id="musicaDest" name="musica" class="evt categoria" value="musica" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_5"><label for="tendenciasDest">Tendencias</label><input type="checkbox" id="tendenciasDest" name="tendencias" class="evt categoria" value="tendencias" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_6"><label for="CulturalDest">Cultura</label><input type="checkbox" id="CulturalDest" name="Cultural" class="evt categoria" value="Cultural" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_7"><label for="noticiasDest">Noticias</label><input type="checkbox" id="noticiasDest" name="noticias" class="evt categoria" value="noticias" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_8"><label for="NacionalDest">Nacional</label><input type="checkbox" id="NacionalDest" name="Nacional" class="evt categoria" value="Nacional" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_9"><label for="internacionalDest">Internacional</label><input type="checkbox" id="internacionalDest" name="internacional" class="evt categoria" value="internacional" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_10"><label for="adultoDest">Adulto</label><input type="checkbox" id="adultoDest" name="adulto" class="evt categoria" value="adulto" data-func="checkdata" data-event="change"></li>';
        $out .= '<li class="prefList cate num_13"><label for="EventosPagado">Eventos Pagados</label><input type="checkbox" id="EventosPagados" name="Compra de Eventos" class="evt categoria" value="Compra de Eventos" data-func="checkdata" data-event="change"></li>';
        $out .= '</ul>';
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
                    SELECT Title, StartDate, StartTime, Duration, MpaaRating,ChannelID
                    FROM $wpdb_pr->prog
                    INNER JOIN $wpdb_pr->sch
                    ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
                    WHERE $wpdb_pr->prog.ProgramID = $program
                    ");

            
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program%'  LIMIT 1"); 
            $postContent = $wpdb->get_var("
                    SELECT $wpdb->posts.post_title 
                    FROM $wpdb->posts 
                    INNER JOIN $wpdb->postmeta 
                    ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) 
                    WHERE meta_key = 'ProgramID'
                    AND meta_value LIKE '%$program%'
                ");
            
            date_default_timezone_set('Chile/Continental');
            $hoy = date('mdyHi');

            $hoyMes = substr($hoy, 0, 2);
            $hoyDia = substr($hoy, 2, 2);
            $hoyAno = substr($hoy, 4, 2);
            $hoyHora = substr($hoy, 6, 2);
            $hoyMinuto = substr($hoy, -2);
            $timestampHoy = mktime($hoyHora, $hoyMinuto, 0, $hoyMes, $hoyDia, $hoyAno);

            $i = 0;
            foreach ($prog as $date) {

                $dateMes = substr($date->StartDate, 0, 2);
                $dateDia = substr($date->StartDate, 2, 2);
                $dateAno = substr($date->StartDate, -2);
                $dateHora = substr($date->StartTime, 0, 2);
                $dateMinuto = substr($date->StartTime, -2);

                $timestampDate = mktime($dateHora, $dateMinuto, 0, $dateMes, $dateDia, $dateAno);

                if ($timestampDate >= $timestampHoy) {
                    $datesMayores[$i] = date('mdy', $timestampDate);
                    $i++;
                }
            }

            sort($datesMayores);
            $startDate = $datesMayores[0];
            
            $startTimes = $wpdb_pr->get_results("
                    SELECT $wpdb_pr->sch.StartTime, StartDate
                    FROM $wpdb_pr->sch
                    WHERE ProgramID = '$program'
                    AND StartDate >= '$startDate'
                    ");

            date_default_timezone_set('Chile/Continental');

            $timestampTiempo = mktime(date('H'), date('i'), 0, date('m'), date('d'), date('y'));

            $i = 0;
            foreach ($startTimes as $start) {

                $horaTime = substr($start->StartTime, 0, 2);
                $minutoTime = substr($start->StartTime, -2);
                $mesTime = substr($start->StartDate, 0, 2);
                $diaTime = substr($start->StartDate, 2, 2);
                $anoTime = substr($start->StartDate, -2);

                $timestampTime = mktime($horaTime-$this->timezone, $minutoTime, 0, $mesTime, $diaTime, $anoTime);

                if ($timestampTime >= $timestampTiempo) {
                    $horaArray[$i] = date('mdyHi', $timestampTime);
                    $i++;
                }
            }
            
            if ($horaArray) {
                sort($horaArray);
                $Nearest = $horaArray[0];
                $Nearest = substr($Nearest, -4);

                $timestamp = mktime(substr($Nearest,0,2)+$this->timezone, substr($Nearest,-2), 0, date('m'), date('d'), date('y'));
                $timestamp = date('Hi',$timestamp);

                $durationDest = $wpdb_pr->get_var("
                    SELECT $wpdb_pr->sch.Duration
                    FROM $wpdb_pr->sch
                    WHERE ProgramID = '$program'
                    AND StartDate = '$startDate'
                    AND StartTime = '$timestamp'
                    ");
            }

            $hora = substr($Nearest, 0, 2);
            $minuto = substr($Nearest, -2);

            $horaEnd = substr($durationDest, 0, 2);
            $minutoEnd = substr($durationDest, -2);
            
            $hora1 = $hora . ':' . $minuto;
            $hora2 = $horaEnd . ':' . $minutoEnd;
            $hora1 = split(":", $hora1);
            $hora2 = split(":", $hora2);
            $horas = (int) $hora1[0] + (int) $hora2[0];
            $minutos = (int) $hora1[1] + (int) $hora2[1];
            $horas+=(int) ($minutos / 60);
            $minutos = $minutos % 60;
            if ($minutos < 10)
                $minutos = "0" . $minutos;
            if ($horas > 23)
                $horas = 24 - $horas;
            if (abs($horas) < 10)
                $horas = '0' . abs($horas);

            $out .= '<li class="programa">';
            $out .= has_post_thumbnail($ficha) ? wp_get_attachment_image(get_post_thumbnail_id( $ficha ), 'mobileProgram', false, array('class' => 'program_img')) : '<img src="/wp-content/themes/comunidadtv/img/mobile/generico.jpg" class="program_img" alt="' . $result_prev->Title . '" title="' . $result_prev->Title . '">' ;
            $out .= '<a href="#" class="evt washlistLink" data-func="loadContent" data-program="'.$program.'"><h2 class="watchTitle">' . $prog[0]->Title . '</h2></a>';
            
            
            if ($prog[0]->StartTime && $prog[0]->Duration) {
                $out .= '<span class=horario>'. $hora .':'. $minuto .' - '. $horas .':'.$minutos.'</span>';
            }

            if ($prog[0]->MpaaRating) {
                $out .= '<span class="rating">(' . $prog[0]->MpaaRating . ')</span>';
            }
            $out .= '<input type="checkbox" class="evt categoria"  data-program="' . $program . '"  data-event="change" data-func="watchlist" value="' . $programID  . '" name="' . $programID  . '" checked="checked" />';
            $out .= '</li>';
        }
        $out .="</ul>";
        return $this->tabSlider($out);
    }

    function geoubicacion() {
        global $wpdb_pr;

        $out = "";

        $county = $this->county;
        $county = explode("_",$county);
        $county = implode(" ",$county);
        
        $comunas = $wpdb_pr->get_results("
                    SELECT *
                    FROM $wpdb_pr->comunas
                    GROUP BY region
            ");

        $out .= '<div class="prefTitle"><h1>Tu Ubicación</h1></div>';
        $out .= '<div id="geocode">';
        $out .= '<div id="actual">';

        $out .= '</div>';
        $out .= '<span class="textoUb">Tu grilla actual es: </span><span class="ubicacion">' . $county . '</span></span>';
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
                    SELECT comuna
                    FROM $wpdb_pr->comunas
                    WHERE $wpdb_pr->comunas.region = $region
            ");




        $out .= '<option value="">Selecciona tu Comuna</option>';

        foreach ($comunas as $comuna) {

            $out .= '<option value="' . $comuna->comuna. '">' . $comuna->comuna . '</option>';
        }




        return $out;
    }
    
    function get_horarios() {
        $agent = $_SERVER['HTTP_USER_AGENT']; 
        $out = "";
        
        $out .= '<div id=horarios>';
        $out .= '<a class="guiaTVlogo" href=""><img src="'.get_bloginfo('template_directory').'/img/mobile/guialogo.jpg" /></a>';
        $out .= '<p class="horarioText">Para una mejor experiencia y ver la programacion de este momento, descarga la aplicación móvil gratis.</p>';
  
        if(preg_match('/iPhone/i', $agent)){  
            $out .= '<a class="guiaTVlogo" href="http://www.baytex.net/clientes/vtr_2011/download.php?device=ios&app=epg&version=2.2"><img class="marketLogo" src="'.get_bloginfo('template_directory').'/img/mobile/applestore.jpg" /></a>';
            $out .= '<a class="disponible" href="http://www.baytex.net/clientes/vtr_2011/download.php?device=ios&app=epg&version=2.2">Disponible en Apple Store</a>';
        }elseif(preg_match('/Android/i', $agent)){
            $out .= '<a class="guiaTVlogo" href="http://www.baytex.net/clientes/vtr_2011/download.php?device=android&app=epg&version=2.2"><img class="marketLogo" src="'.get_bloginfo('template_directory').'/img/mobile/androidmarket.jpg" /></a>';
            $out .= '<a class="disponible" href="http://www.baytex.net/clientes/vtr_2011/download.php?device=android&app=epg&version=2.2">Disponible en Android Market</a>'; 
        }else{
            $out .= '<a class="guiaTVlogo" href="http://www.baytex.net/clientes/vtr_2011/download.php?device=android&app=epg&version=2.2"><img class="marketLogo" src="'.get_bloginfo('template_directory').'/img/mobile/androidmarket.jpg" /></a>';
            $out .= '<a class="guiaTVlogo" href="http://www.baytex.net/clientes/vtr_2011/download.php?device=ios&app=epg&version=2.2"><img class="marketLogo" src="'.get_bloginfo('template_directory').'/img/mobile/applestore.jpg" /></a>';
            $out .= '<a class="disponible" href="#">Disponible en Apple Store y Android Market</a>';
        }
        $out .= '</div>';
        return $this->tabSlider($out);
    }
    
    function localGenderList($localGenders){
        
   $out .= '<ul class="gen-list">';
   $out .= '<div class="prefTitle"><h1>Tus Categorías Destacadas</h1><span class="subPref">Puedes administrar las categorías desde los Ajustes</span></div>';
    if(in_array('series-peliculas', $localGenders))     
        $out .= '<li class="cate"><a id="Series & Películas" class="evt num_1" data-func="loadChannel" data-location="' . $this->county . '" data-gender="series-peliculas" data-type="gender" >Cine y series</a></li>';
    $out .= '<li class="cate"><a id="Premium" class="evt num_11" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Premium" data-type="group" >Premium</a></li>';
    if(in_array('Compra de Eventos', $localGenders))     
        $out .= '<li class="cate"><a id="Eventos Pagados" class="evt num_13" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Compra de Eventos" data-type="gender" >Eventos Pagados</a></li>';
    if(in_array('deportes', $localGenders))     
        $out .= '<li class="cate"><a id="deportes" class="evt num_3" data-func="loadChannel" data-location="' . $this->county . '" data-gender="deportes" data-type="gender" >Deportes</a></li>';
    if(in_array('infantil', $localGenders))     
        $out .= '<li class="cate"><a id="infantil" class="evt num_2" data-func="loadChannel" data-location="' . $this->county . '" data-gender="infantil" data-type="gender" >Infantil</a></li>';
    if(in_array('Cultural', $localGenders))     
        $out .= '<li class="cate"><a id="cultura" class="evt num_6" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Cultural" data-type="gender" >Cultura</a></li>';
    if(in_array('musica', $localGenders))     
        $out .= '<li class="cate"><a id="musica" class="evt num_4" data-func="loadChannel" data-location="' . $this->county . '" data-gender="musica" data-type="gender" >Música</a></li>';
    if(in_array('tendencias', $localGenders))     
        $out .= '<li class="cate"><a id="tendencias" class="evt num_5" data-func="loadChannel" data-location="' . $this->county . '" data-gender="tendencias" data-type="gender" >Tendencias</a></li>';
    if(in_array('noticias', $localGenders))     
        $out .= '<li class="cate"><a id="noticias" class="evt num_7" data-func="loadChannel" data-location="' . $this->county . '" data-gender="noticias" data-type="gender" >Noticias</a></li>';
    if(in_array('Nacional', $localGenders))     
        $out .= '<li class="cate"><a id="Nacional" class="evt num_8" data-func="loadChannel" data-location="' . $this->county . '" data-gender="Nacional" data-type="gender" >Nacional</a></li>';
    if(in_array('internacional', $localGenders))     
        $out .= '<li class="cate"><a id="internacional" class="evt num_9" data-func="loadChannel" data-location="' . $this->county . '" data-gender="internacional" data-type="gender" >Internacional</a></li>';
    $out .= '<li class="cate "><a id="HD" class="evt num_12" data-func="loadChannel" data-location="' . $this->county . '" data-gender="HD" data-type="group" >HD</a></li>';
    if(in_array('adulto', $localGenders))     
        $out .= '<li class="cate"><a id="adulto" class="evt num_10" data-func="loadChannel" data-location="' . $this->county . '" data-gender="adulto" data-type="gender" >Adulto</a></li>';
    $out .="</ul>";
       
    
    return $out;
    }
    
    
}

function ajax_zone_mobile() {


    if($_POST["display"] == "inicio"){
        
        $mobile_query = array(
            
            "display" => "phpload",
            "location" => $_POST["county"],
            "localgenders" => $_POST["localGenders"],
            "firstLoad" => $_POST["firstLoad"],
            "date" => false
        );


        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_data();
        
        
   } elseif ($_POST["newDate"]) {

        $datos = array(
            "gender" => $_POST["genero"],
            "channel" => $_POST["channel"],
            "date" => $_POST["newDate"],
            "display" => "programs"
        );

        $ajaxGrill = new getgrill($datos);
        $out = $ajaxGrill->get_data();
        die($out);
    } elseif ($_POST["program"]) {

        $programID = $_POST["program"];
        $datos['display'] = "program";

        $mobile_query = array(
            
            "display" => "program",
            "programID" => $programID,
            "startTime" => $_POST["startTime"],
            "contentLast" => $_POST["cont"]
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_data();
        
        die($out);
        
    } elseif ($_POST["display"] == "channelList") {

        $type = "gender";
        
        if($_POST["genders"] == "Premium"){
            $type = "category";
        }
        elseif($_POST["genders"] == 'HD'){
            $type = "group";
        }
        
        $mobile_query = array(
            
            $type => $_POST["genders"],
            "location" => $_POST["location"],
            "display" => "channelList"
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_data();
        
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
        $out = $ajaxGrill->get_data();

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
        $out = $ajaxGrill->get_data();

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
            "display" => "phpload",
            "localgenders" => $_POST["localGenders"]
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_data();

        die($out);
    } elseif ($_POST["localGenders"]) {
        
        $mobile_query = array(
            "location" => $_POST["county"]
        );
        
        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->localGenderList($_POST["localGenders"]);
        die($out);
        
    } elseif($_POST["display"] == "search_list") {


        $mobile_query = array( 
            "display" => $_POST["display"],
            "search" => $_POST["palabra"]
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_data();
        
        die($out);
    
    }elseif($_POST["display"] == "loadPreferencias") {


        $mobile_query = array( 
            "display" => $_POST["display"]
        );

        $ajaxGrill = new getgrill($mobile_query);
        $out = $ajaxGrill->get_data();
        
        die($out);
    
    } else {
        die("error");
    }
}

add_action('wp_ajax_ajax_zone_mobile', 'ajax_zone_mobile');
add_action('wp_ajax_nopriv_ajax_zone_mobile', 'ajax_zone_mobile');
?>
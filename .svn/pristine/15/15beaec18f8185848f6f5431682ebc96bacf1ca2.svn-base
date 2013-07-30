<?php

/*
  Plugin Name: Programacion (actual)
  Plugin URI: maxvillegas.com
  Description: Funciones de grilla de programacion vtr
  Version: 2.3
  Author: Max Villegas
  Author URI: http://mvillegas.com/
 */

// Crear instancia de bbdd
$wpdb_pr = new wpdb(DB_USER, DB_PASSWORD, DB_NAME_2, DB_HOST);
$wpdb_pr->cat = "CategoryLookup";
$wpdb_pr->chn = "CHN_PC";
$wpdb_pr->prog = "PRG_PC";
$wpdb_pr->sch = "SCH_PC";
$wpdb_pr->chn_web = "tbl_data";
$wpdb_pr->chn_cat = "tbl_categorias";
$wpdb_pr->full = "tbl_full";
$wpdb_pr->light = "tbl_light";
$wpdb_pr->mipack = "tbl_mipack";
$wpdb_pr->comunas = "tbl_comunas";

date_default_timezone_set('Chile/Continental');

$horario = date(Z) / 60 / 60 * -1;

if (get_field('_timezone', 'options')!="" && get_field('_timezone', 'options')!= 0) {
    $horario = get_field('_timezone', 'options');
} 

if ($horario == 4) {
    $bn = '0400';
    $bp = '2000';
} else {
    $bn = '0300';
    $bp = '2100';
}

function get_canales_byname($canales) {
    global $wpdb_pr;
    $arychns = split(",", $canales);
    $n = count($arychns);
    $i = 1;
    foreach ($arychns as $arychn) {
        $donde .= "senal = '$arychn'";
        if ($i < $n)
            $donde .= " OR ";
        $i++;
    }
    $query = ("SELECT codigo FROM $wpdb_pr->chn_web WHERE $donde");
    $serialdata = $wpdb_pr->get_results($query, 'OBJECT');
    foreach ($serialdata as $valor) {
        $nuevo_serial[] = $valor->codigo;
    }
    return $nuevo_serial;
}

function get_canal_nombre($canal_id) {
    global $wpdb_pr;
    return $wpdb_pr->get_var("SELECT senal FROM $wpdb_pr->chn_web WHERE codigo = $canal_id LIMIT 1");
}

function get_canal_id($canal_nombre) {
    global $wpdb_pr;
    return $wpdb_pr->get_var("SELECT codigo FROM $wpdb_pr->chn_web WHERE senal = '$canal_nombre' LIMIT 1");
}

function fecha($suma = 0, $type) {
    $fecha = date($type, mktime(0, 0, 0, date(m), date(d) + $suma, date(y)));
    if ($type == "D") {
        switch ($fecha) {
            case "Mon":$fecha = "lun";
                break;
            case "Tue":$fecha = "mar";
                break;
            case "Wed":$fecha = "mie";
                break;
            case "Thu":$fecha = "jue";
                break;
            case "Fri":$fecha = "vie";
                break;
            case "Sat":$fecha = "sab";
                break;
            case "Sun":$fecha = "dom";
                break;
        }
    }
    return $fecha;
}

/**
 *
 */
function get_chnprog($canal, $fecha = false) {
    global $wpdb_pr, $bn, $bp;
    $fecha = !$fecha ? date('mdy') : $fecha;
    $query = ("SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration
        FROM
        $wpdb_pr->sch INNER JOIN $wpdb_pr->prog
        ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
        WHERE $wpdb_pr->sch.StartDate = $fecha AND $wpdb_pr->sch.StartTime >= '$bn'
        AND $wpdb_pr->sch.ChannelID = '$canal'"
            );
    return $wpdb_pr->get_results($query, 'OBJECT');
}

function get_chnprog_next($canal, $fecha = false) {
    global $wpdb_pr, $bn, $bp;
    if ($fecha) {
        $nextday = substr($fecha, 2, 2) + 1;
        $month = substr($fecha, 0, 2);
        //si estoy en diciempre y el día es mayor 17 sumo un año
        $sumaunmes = mktime(0, 0, 0, $month, $nextday, date('Y'));
        $nextday = date("mdy", $sumaunmes);
    } else {
        $fecha = date('mdy');
        $nextday = substr($fecha, 2, 2) + 1;
        $sumaunmes = mktime(0, 0, 0, date('m'), $nextday, date('Y'));
        $nextday = date("mdy", $sumaunmes);
    }


    $query = ("SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration
        FROM
        $wpdb_pr->sch INNER JOIN $wpdb_pr->prog
        ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
        WHERE $wpdb_pr->sch.StartDate = '$nextday' AND $wpdb_pr->sch.StartTime < '$bn'
        AND $wpdb_pr->sch.ChannelID = '$canal'"
            );
    return $wpdb_pr->get_results($query, 'OBJECT');
}

function get_chnprog_prev($canal, $fecha = false) {
    global $wpdb_pr, $bn, $bp, $bdp;
    $fecha = !$fecha ? date('mdy') : $fecha;
    $query = ("SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration
        FROM
        $wpdb_pr->sch INNER JOIN $wpdb_pr->prog
        ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
        WHERE $wpdb_pr->sch.StartDate = $fecha AND $wpdb_pr->sch.StartTime < '$bn'
        AND $wpdb_pr->sch.ChannelID = '$canal' ORDER BY  $wpdb_pr->sch.StartTime DESC LIMIT 1"
            );
    return $wpdb_pr->get_row($query, 'OBJECT');
}

/** function get_canales:
 * Obtiene la lista de canales en forma de array asoc mysql
 * @name get_canales
 * @param  canal_inicio parametro para la query mysql ( Limit canal_inicio, 10)
 * @param  canal_catidiad parametro para la query mysql ( Limit 0, canal_cantidad)
 * @param  canal_tipo parametro para la query mysql (Clausula Where genero = canal_tipo)
 * @return array
 * @internal
 * */
function get_canales($canal_inicio = false, $canal_cantidad = false, $canal_tipo = false, $favoritos = false, $comuna = false) {
    global $wpdb_pr;
    if ($canal_tipo)
        $canal_tipo = urldecode($canal_tipo);
    if ($canal_tipo == "peliculas")
        $canal_tipo = "Cine&Series";
    if ($canal_tipo == "series")
        $canal_tipo = "Cine&Series";
    if ($canal_tipo == "series-peliculas")
        $canal_tipo = "Cine&Series";
    if ($canal_tipo == "series-películas")
        $canal_tipo = "Cine&Series";
    if ($canal_tipo == "hd") {
        $canal_tipo = "Alta Definición";
    }
    if ($canal_tipo == "tendencias")
        $canal_tipo = "Estilos & Tendencias";
    if ($canal_tipo == "cultura")
        $canal_tipo = "Cultural";
    if ($canal_tipo == "adulto")
        $canal_tipo = "Adulto";
    if ($canal_tipo == "premium") {
        unset($canal_tipo);
        $canal_premium = " AND categoria = 'Premium' ";
    }
    $canal_inicio = $canal_inicio == false ? 0 : $canal_inicio;
    $canal_cantidad = $canal_cantidad == false ? 20 : $canal_cantidad;
    $limit = " LIMIT $canal_inicio, $canal_cantidad ";

    if (!$canal_tipo) {
        $limit = "";
    }
    if ($canal_tipo == "cate") {
        unset($canal_tipo);
    }

    if ($favoritos) {
        $favoritos = explode(",", $favoritos);
        if (is_array($favoritos)) {
            foreach ($favoritos as $fav) {
                $chn_code[] = "'" . $fav . "'";
            }
        }
        $favoritos = " AND $wpdb_pr->full.codigo IN (" . implode(",", $chn_code) . ") ";
        unset($limit);
    }

    $comuna_user = strtolower($wpdb_pr->get_var("SELECT grilla FROM $wpdb_pr->comunas WHERE comuna='$comuna'"));
    $canal_tipo = $canal_tipo == false ? '' : " AND genero = '$canal_tipo' ";
    $query = ("SELECT $wpdb_pr->chn_web.codigo, tipo, categoria, senal, imagen, genero, driver, grupo, $comuna_user FROM $wpdb_pr->full INNER JOIN $wpdb_pr->chn_web ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->full.codigo) WHERE 1 $favoritos $canal_tipo $canal_premium $grupo AND $comuna_user != 0 AND $wpdb_pr->chn_web.genero != 'Compra de Eventos' GROUP BY $comuna_user ORDER BY $comuna_user ASC $limit");
    $r = $wpdb_pr->get_results($query, 'OBJECT');
    return $r;
}

/** function canales:
 * Obtiene la lista de canales y devuelve codigo html
 * @name get_canales
 * @param  canal_inicio parametro para la query mysql ( Limit canal_inicio, 10)
 * @param  canal_catidiad parametro para la query mysql ( Limit 0, canal_cantidad)
 * @param  canal_tipo parametro para la query mysql (Clausula Where genero = canal_tipo)
 * @todo falta definir un parametro para fecha
 * @return html
 * */
function canales($canal_inicio = false, $canal_cantidad = false, $canal_tipo = false, $favoritos = false, $comuna_user = false) {
    require_once(ABSPATH . "/wp-content/plugins/utilidades/utilidades.php");
    global $wpdb_pr, $wpdb;

    $result_chn = get_canales($canal_inicio, $canal_cantidad, $canal_tipo, $favoritos, $comuna_user);

    $queryGetComuna = "SELECT grilla FROM $wpdb_pr->comunas WHERE comuna='$comuna_user' LIMIT 1";
    $comuna_user = strtolower($wpdb_pr->get_var($queryGetComuna));

    foreach ($result_chn as $channel) {
        $queryGetCanal = "SELECT `$comuna_user` FROM $wpdb_pr->full WHERE $comuna_user!=0 AND codigo = '$channel->codigo' AND grupo ='$channel->grupo'  LIMIT 1";
        $num = $wpdb_pr->get_var($queryGetCanal);
        $num = '<strong>' . $num . '</strong>';
        if ($channel->genero == "Cine&Series")
            $channel->genero = "peliculas";
        $alt = strip_tags(strtolower($channel->senal));
        $out .= '<li class="logo cf" id="' . $channel->codigo . '">
              <img class="logoc ' . $channel->tipo . '" src="' . css_dir() . '/img/foto/' . strtolower($channel->imagen) . '" alt="' . $alt . '" title="' . $channel->senal . ' ' . $channel->driver . '" />
              <div class="chan">' . $num . '</div>
              </li>';
    }
    return $out;
}

/**
 * function grilla:
 * Llama a la grilla de programacion normal y versión ajax
 * @name grilla
 * @param  canal_inicio parametro para la query mysql ( Limit canal_inicio, 10)
 * @param  canal_catidiad parametro para la query mysql ( Limit 0, canal_cantidad)
 * @param  canal_tipo parametro para la query mysql (Clausula Where genero = canal_tipo)
 * @param  ajax parametro devolver return en formato html o json
 * @todo falta definir un parametro para fecha
 * @return html, ajax
 * */
function grilla($canal_inicio = false, $canal_cantidad = false, $canal_tipo = false, $ajax = false, $fecha = false, $favoritos = false, $comuna = false) {

    if (!$comuna)
        $comuna = $_SESSION['comuna'];
    global $wpdb_pr, $wpdb, $horario;

    //echo "en la linea ".__LINE__. " Comuna $comuna ";
    $result_chn = get_canales($canal_inicio, $canal_cantidad, $canal_tipo, $favoritos, $comuna);

    $i = $canal_inicio ? $canal_inicio : 0;
    foreach ($result_chn as $channel) {
        if ($channel->genero == "Cine&Series")
            $channel->genero = "peliculas";
        $result_prev = get_chnprog_prev($channel->codigo, $fecha);
        $result_prg = get_chnprog($channel->codigo, $fecha);
        $result_prg_next = get_chnprog_next($channel->codigo, $fecha);

        $out .= '<ul id="canal_' . $channel->codigo . '" class="program n_' . $i . ' ' . $channel->genero . '"  style="position:relative">';
        $pi = 0;
        foreach ($result_prg as $program) {
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
            $ficha_url = "";
            $cate_id = "";
            $cate_rel_id = "";
            if ($ficha && $program->ProgramID != 13) {
                $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
                $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
                $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));
            }
            $ini_hora = (substr($program->StartTime, 0, 2) - $horario) * 60;
            $ini_min = substr($program->StartTime, -2);
            $left = ($ini_hora + $ini_min) * 4;
            $dura_hora = substr($program->Duration, 0, 2) * 60;
            $dura_min = substr($program->Duration, -2);
            $dura = $dura_hora + $dura_min;
            $width = ($dura * 4);

            if ($cate_id and $ficha_url) {
                $fclass = ' class="fcomp ini_' . $left . '"';
                $url = '/' . $cate_id . '/' . $ficha_url . '/';
            } else {
                $fclass = ' class="nolink ini_' . $left . '"';
                $url = '#';
            }
            if ($pi == 0 && $program->StartTime > '0415') {
                $out .= '<li 
                data-duration="' . $result_prev->Duration . '"  
                data-startTime="' . $result_prev->StartTime . '" 
                data-startDate="' . $result_prev->StartDate . '"  
                data-chn="' . $channel->codigo . '"  
                data-prog="' . $result_prev->ProgramID . '" 
                style="left:0px; width:' . $left . 'px">
                <a href="' . $url . '" class="verficha starttime_' . $result_prev->StartTime . ' startdate_' . $result_prev->StartDate . '" id="' . $result_prev->codigo . '_' . $result_prev->ProgramID . '_' . $pi . '" title="Ver ficha">' . $result_prev->Title . '</a><span>' . $result_prev->MpaaRating . '</span></li>';
                $pi++;
            }

            $out .= '<li 
                data-duration="' . $program->Duration . '"  
                data-startTime="' . $program->StartTime . '" 
                data-startDate="' . $program->StartDate . '"  
                data-chn="' . $channel->codigo . '"  
                data-prog="' . $program->ProgramID . '" 
                style="left:' . $left . 'px; width:' . $width . 'px"' . $fclass . '>
                <a href="' . $url . '" class="verficha starttime_' . $program->StartTime . ' startdate_' . $program->StartDate . '" id="' . $channel->codigo . '_' . $program->ProgramID . '_' . $pi . '" title="Ver ficha">' . $program->Title . '</a><span>' . $program->MpaaRating . '</span></li>';

            $pi++;
        }
        $pi = 0;
        foreach ($result_prg_next as $program) {
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
            $ficha_url = "";
            $cate_id = "";
            $cate_rel_id = "";

            if ($ficha && $program->ProgramID != 13) {
                $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
                $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
                $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));
            }

            if (substr($program->StartTime, 0, 2) - $horario < 0)
                $ini_hora = (substr($program->StartTime, 0, 2) + 24 - $horario) * 60;

            $ini_min = substr($program->StartTime, -2);
            $left = ($ini_hora + $ini_min) * 4;
            $dura_hora = substr($program->Duration, 0, 2) * 60;
            $dura_min = substr($program->Duration, -2);
            $dura = $dura_hora + $dura_min;
            $width = ($dura * 4);

            if ($cate_id and $ficha_url) {
                $fclass = ' class="fcomp ini_' . $left . '"';
                $url = '/' . $cate_id . '/' . $ficha_url . '/';
            } else {
                $fclass = ' class="nolink ini_' . $left . '"';
                $url = '#';
            }
            $out .= '<li 
                data-duration="' . $program->Duration . '"  
                data-startTime="' . $program->StartTime . '" 
                data-startDate="' . $program->StartDate . '"  
                data-chn="' . $channel->codigo . '"  
                data-prog="' . $program->ProgramID . '"  style="left:' . $left . 'px; width:' . $width . 'px"' . $fclass . '><a href="' . $url . '" class="verficha starttime_' . $program->StartTime . ' startdate_' . $program->StartDate . '" id="' . $channel->codigo . '_' . $program->ProgramID . '_' . $pi . '" title="Ver ficha">' . $program->Title . '</a><span>' . $program->MpaaRating . '</span></li>';
            $pi++;
        }
        $out .= '</ul>';
        $i++;
    }

    return !$ajax ? $out : array("grilla" => $out, "canales" => canales($canal_inicio, $canal_cantidad, $canal_tipo, $favoritos, $comuna));
}

function grilla_externa($canal_inicio = false, $canal_cantidad = false, $canal_tipo = false, $ajax = false, $fecha = false, $favoritos = false) {
    global $wpdb_pr, $wpdb, $horario;
    $result_chn = get_canales($canal_inicio, $canal_cantidad, $canal_tipo, $favoritos);
    $i = $canal_inicio ? $canal_inicio : 0;

    foreach ($result_chn as $channel) {
        if ($channel->genero == "Cine&Series")
            $channel->genero = "peliculas";
        $result_prg = get_chnprog($channel->codigo, $fecha);
        $result_prg_next = get_chnprog_next($channel->codigo, $fecha);
        $out .= '<ul id="canal_' . $channel->codigo . '" class="program n_' . $i . ' ' . $channel->genero . '"  style="position:relative">';
        $pi = 0;
        foreach ($result_prg as $program) {
            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
            $ficha_url = "";
            $cate_id = "";
            $cate_rel_id = "";
            if ($ficha)
                $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
            if ($ficha)
                $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
            if ($ficha)
                $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));

            $ini_hora = (substr($program->StartTime, 0, 2) - 3) * 60;
            $ini_min = substr($program->StartTime, -2);
            $left = ($ini_hora + $ini_min) * 4;
            $dura_hora = substr($program->Duration, 0, 2) * 60;
            $dura_min = substr($program->Duration, -2);
            $dura = $dura_hora + $dura_min;
            $width = ($dura * 4);

            if ($cate_id and $ficha_url) {
                $fclass = ' class="fcomp ini_' . $left . '"';
                $url = 'http://' . $_SERVER["HTTP_HOST"] . '/' . $cate_id . '/' . $ficha_url . '/';
            } else {
                $fclass = ' class="ini_' . $left . '"';
                $url = '#';
            }
            $out .= '<li style="left:' . $left . 'px; width:' . $width . 'px"' . $fclass . '><a href="' . $url . '" class="verficha starttime_' . $program->StartTime . ' startdate_' . $program->StartDate . '" id="' . $channel->codigo . '_' . $program->ProgramID . '_' . $pi . '" title="Ver ficha"><span>' . $program->Title . '</span></a><span>' . $program->MpaaRating . '</span></li>';
            $pi++;
        }
        $pi = 0;
        foreach ($result_prg_next as $program) {

            $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
            $ficha_url = "";
            $cate_id = "";
            $cate_rel_id = "";
            if ($ficha)
                $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha  LIMIT 1");
            if ($ficha)
                $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
            if ($ficha)
                $cate_id = sanitize_title(strtolower(get_cat_name($cate_rel_id)));
            if (substr($program->StartTime, 0, 2) - $horario < 0)
                $ini_hora = (substr($program->StartTime, 0, 2) + 24 - $horario) * 60;
            $ini_min = substr($program->StartTime, -2);
            $left = ($ini_hora + $ini_min) * 4;
            $dura_hora = substr($program->Duration, 0, 2) * 60;
            $dura_min = substr($program->Duration, -2);
            $dura = $dura_hora + $dura_min;
            $width = ($dura * 4);

            if ($cate_id and $ficha_url) {
                $fclass = ' class="fcomp ini_' . $left . '"';
                $url = 'http://' . $_SERVER["HTTP_HOST"] . '/' . $cate_id . '/' . $ficha_url . '/';
            } else {
                $fclass = ' class="ini_' . $left . '"';
                $url = '#';
            }
            $out .= '<li style="left:' . $left . 'px; width:' . $width . 'px"' . $fclass . '><a href="' . $url . '" class="verficha starttime_' . $program->StartTime . ' startdate_' . $program->StartDate . '" id="' . $channel->codigo . '_' . $program->ProgramID . '_' . $pi . '" title="' . $program->Title . '"><span>' . $program->Title . '</span></a><span>' . $program->MpaaRating . '</span></li>';
            $pi++;
        }
        $out .= '</ul>';
        $i++;
    }
    return !$ajax ? $out : array("grilla" => $out, "canales" => canales($canal_inicio, $canal_cantidad, $canal_tipo, $favoritos));
}

function mihorariodia($startdate) {
    global $bp, $bn;
    $dias = explode(',', 'Lunes, Martes, Mi&eacute;rcoles, Jueves, Viernes, S&aacute;bado, Domingo');
    $day = substr($startdate, 2, 2);
    if ($startime >= $bp) {
        $day--;
    }
    $month = substr($startdate, 0, 2);
    $year = substr($startdate, -2);

    $day_name = mktime(0, 0, 0, $month, $day, $year);
    $dia = $dias[date("N", $day_name) - 1];

    return $dia . ' ' . date("j", $day_name);
}

function mihorariodia2($startdate, $starttime) {
    $dias = explode(',', 'Lunes, Martes, Mi&eacute;rcoles, Jueves, Viernes, S&aacute;bado, Domingo');
    $day = substr($startdate, 2, 2);
    $month = substr($startdate, 0, 2);
    $year = substr($startdate, -2);


    $day_name = mktime(0, 0, 0, $month, $day, $year);
    $fecha_d = date("j", $day_name);
    if ($starttime >= 24) {
        $dia = $dias[date("N", $day_name) - 2];
        $fecha_d = date("j", $day_name - 86400);
    } else {
        $dia = $dias[date("N", $day_name) - 1];
    }
    return $dia . ' ' . $fecha_d;
}

/**
 * function minificha
 * Llama a la minificha
 *
 */
function minificha($channel, $programs, $starttime, $startdate, $canal_tipo) {
    global $wpdb_pr, $wpdb, $horario, $ida;
    $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$programs%'  LIMIT 1");
    if (!$ficha || $programs == 13) {
        $ficha = false;
    } else {
        $ficha_url = $wpdb->get_var("SELECT post_name FROM $wpdb->posts WHERE ID = $ficha");
        $cate_rel_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_relationships WHERE object_id = $ficha  LIMIT 1");
        $cate_id = strtolower(get_cat_name($cate_rel_id));
        $imagen = get_the_post_thumbnail($ficha, 'programacion');
        $post = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE ID =$ficha LIMIT 1");
    }

    if ($cate_id and $ficha_url) {
        $url = '/' . $cate_id . '/' . $ficha_url . '/';
    } else {
        $url = '#';
    }
    $datos = $wpdb_pr->get_row("SELECT $wpdb_pr->sch.ChannelID, $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,Subtitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration FROM $wpdb_pr->prog INNER JOIN $wpdb_pr->sch ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID) WHERE $wpdb_pr->prog.ProgramID = '$programs' AND $wpdb_pr->sch.StartDate = '$startdate' AND $wpdb_pr->sch.StartTime = '$starttime'  LIMIT 1", 'OBJECT');
    $datosNext = $wpdb_pr->get_results("SELECT ChannelID,StartDate,StartTime,Duration FROM $wpdb_pr->sch WHERE $wpdb_pr->sch.ProgramID = '$programs' AND StartDate>='$datos->StartDate' AND StartTime > $datos->StartTime ORDER BY StartDate ASC, StartTime DESC LIMIT 3", 'OBJECT');
    global $user_ID;
    include(ABSPATH . "wp-includes/pluggable.php");
    $user = wp_get_current_user();
    if ($user->ID == 182)
        $idProgToShow = $datos->ProgramID ? ' ID: ' . $datos->ProgramID : ' ID: ' . $datosNext->ProgramID;
    if ($datosNext) {
        $i = 0;
        foreach ($datosNext as $dn) {
            $ini_hora_a[$i] = substr($dn->StartTime, 0, 2) - $horario;
            if ($ini_hora_a[$i] < 0)
                $ini_hora_a[$i] = 24 + $ini_hora_a[$i];
            if ($ini_hora_a[$i] < 10)
                $ini_hora_a[$i] = "0" . $ini_hora_a[$i];
            $ini_min_a[$i] = substr($dn->StartTime, -2);


            $dura_hora_a[$i] = substr($dn->Duration, 0, 2) * 60;
            $dura_min_a[$i] = substr($dn->Duration, -2);

            $dura_a[$i] = (($ini_hora_a[$i] * 60) + $ini_min_a[$i]) + ($dura_hora_a[$i] + $dura_min_a[$i]);

            $hora_fin_a[$i] = ($dura_a[$i]) / 60;
            if ($hora_fin_a[$i] < 10)
                $hora_fin_a[$i] = "0" . $hora_fin_a[$i];
            $fin_hora_a[$i] = substr($hora_fin_a[$i], 0, 2);
            if ($hora_fin_a[$i] > 24)
                $fin_hora_a[$i] = "0" . $fin_hora_a[$i] - 24;
            $fin_min_a[$i] = ($dura_a[$i]) % 60 ? ceil(($dura_a[$i]) % 60) : "00";
            $dia[$i] = mihorariodia($dn->StartDate);
            $i++;
        }
    }
    $canal = get_canal_nombre($channel);
    $ini_hora = substr($datos->StartTime, 0, 2) - $horario;

    if ($ini_hora < 0)
        $ini_hora = 24 + $ini_hora;
    if ($ini_hora < 10)
        $ini_hora = "0" . $ini_hora;
    $ini_min = substr($datos->StartTime, -2);
    $dura_hora = substr($datos->Duration, 0, 2) * 60;
    $dura_min = substr($datos->Duration, -2);

    $dura = (($ini_hora * 60) + $ini_min) + ($dura_hora + $dura_min);
    $duragc = (( substr($datos->StartTime, 0, 2) * 60) + $ini_min) + ($dura_hora + $dura_min);

    $hora_fin = ($dura) / 60;
    $hora_fingc = ($duragc) / 60;

    if ($hora_fin < 10)
        $hora_fin = "0" . $hora_fin;
    $fin_hora = substr($hora_fin, 0, 2);
    if ($hora_fin > 24)
        $fin_hora = "0" . $fin_hora - 24;


    if ($hora_fingc < 10)
        $hora_fingc = "0" . $hora_fingc;
    $fin_horagc = substr($hora_fingc, 0, 2);
    if ($hora_fingc > 24)
        $fin_horagc = "0" . $fin_horagc - 24;


    $fin_min = ($dura) % 60 ? ceil(($dura) % 60) : "00";
    $hora_u = $ini_hora + 3;
    $dian = mihorariodia2($datos->StartDate, $hora_u);
    include_once("wp-content/plugins/utilidades/utilidades.php");
    if ($canal_tipo == "Deportes" && $datos->Subtitle) {
        $episodio = "<p>" . $datos->Subtitle . "</p>";
    }
    if ($canal_tipo == "peliculas" && $datos->EpisodeTitle) {
        $episodio = "<p>Episodio: " . $datos->EpisodeTitle . "</p>";
    }
    $mesgc = substr($datos->StartDate, 0, 2);
    $diagc = substr($datos->StartDate, 2, 2);
    $anogc = substr($datos->StartDate, 4, 2);

    if ($ini_hora_a[0]) {
        $nx = "<span class='horario'>Repeticion:</span>";
        $next1 = '<strong>' . $dia[0] . "</strong>, " . $ini_hora_a[0] . ':' . $ini_min_a[0] . ' a ' . $fin_hora_a[0] . ':' . $fin_min_a[0] . ' hrs, <strong>' . $canal_a[0] . '</strong>';
    }
    if ($ini_hora_a[1]) {
        $nx = "<span class='horario'>Repeticion:</span>";
        $next2 = '<strong>' . $dia[1] . "</strong>, " . $ini_hora_a[1] . ':' . $ini_min_a[1] . ' a ' . $fin_hora_a[1] . ':' . $fin_min_a[1] . ' hrs, <strong>' . $canal_a[1] . '</strong>';
    }
    if ($ini_hora_a[2]) {
        $nx = "<span class='horario'>Repetición:</span>";
        $next3 = '<strong>' . $dia[2] . "</strong>, " . $ini_hora_a[2] . ':' . $ini_min_a[2] . ' a ' . $fin_hora_a[2] . ':' . $fin_min_a[2] . ' hrs, <strong>' . $canal_a[2] . '</strong>';
    }
    if ($ficha) {
        $out = '<div id="ficha">
                    <div class="minificha cf">
                        ' . $imagen . '
                        <div class="text">
                            <a href="#" id="cerrarf" title="cerrar ficha">cerrar</a>
                            <strong>' . $datos->Title . '<span class="fichaClas">' . $datos->MpaaRating . '</span></strong>
                            ' . $episodio . '
                            <p>' . $ida->cortar($post->post_excerpt, 150) . '</p>
                            <span class="horario"><strong>' . $dian . "</strong>, " . $ini_hora . ':' . $ini_min . ' a ' . $fin_hora . ':' . $fin_min . ' hrs, <strong>' . $canal . '</strong></span>
                            ' . $nx . '
                            <div class="repeticiones">' . $next1 . '
                            ' . $next2 . '
                            ' . $next3 . '</div>
                             <a class="recordatorio" target ="_blank"  href="http://www.google.com/calendar/event?action=TEMPLATE&text=Ver en VTR:  ' . $datos->Title . ' ' . $episodio . '&dates=20' . $anogc . $mesgc . $diagc . 'T' . $datos->StartTime . '00Z/20' . $anogc . $mesgc . $diagc . 'T' . $fin_horagc . $fin_min . '00Z&sprop=website:www.televisionvtr.cl&details= ' . $ida->cortar($post->post_excerpt, 200) . ' ">recordatorio</a><a class="ficha" title="Ir a ficha completa" href="' . $url . '">ver ficha</a>
                            ' . $idProgToShow . '
                        </div>
                   </div>
            </div>';
        return $out;
    } else {

        $titulo = '<strong>' . $datos->Title . '</strong>';
        if ($datos->Director)
            $director = '<p>Director: ' . $datos->Director . '</p>';
        if (strlen($datos->Desc1) > strlen($datos->Desc2)) {
            $desc = '<p>' . $datos->Desc1 . '</p>';
        } else {
            $desc = '<p>' . $ida->cortar($datos->Desc2, 210) . '</p>';
        }

        $actor = '<p>Actores: ';
        if ($datos->Actor1)
            $actor .= $datos->Actor1;
        if ($datos->Actor2)
            $actor .= ', ' . $datos->Actor2;
        if ($datos->Actor3)
            $actor .= ', ' . $datos->Actor3;
        $actor .= '</p>';

        if (!$datos->Director)
            $director = '';
        if (!$datos->Actor1 && !$datos->Actor2 && !$datos->Actor3 && !$datos->Actor4 && !$datos->Actor5 && !$datos->Actor6)
            $actor = '';
        return '<div id="ficha" class="gris">
            <div class="minificha cf">
            <img src="'.get_bloginfo('template_url').'/img/foto/minificha.jpg" alt="ficha">
                    <div class="text">
                    <a href="#" id="cerrarf" title="cerrar ficha">cerrar</a>
                    ' . $titulo . $episodio . $desc . $director . $actor . '
                     <span style="display:block;clear:both" class="horario"><strong>' . $dian . "</strong>, " . $ini_hora . ':' . $ini_min . ' a ' . $fin_hora . ':' . $fin_min . ' hrs, <strong>' . $canal . '</strong></span>
                           ' . $nx . '
                           <div class="repeticiones">' . $next1 . '
                            ' . $next2 . '
                            ' . $next3 . '</div>
                    <a class="recordatorio" target = "_blank" href="http://www.google.com/calendar/event?action=TEMPLATE&text=Ver en VTR:  ' . $datos->Title . ' ' . $episodio . '&dates=20' . $anogc . $mesgc . $diagc . 'T' . $datos->StartTime . '00Z/20' . $anogc . $mesgc . $diagc . 'T' . $fin_horagc . $fin_min . '00Z&sprop=website:www.televisionvtr.cl&details= ' . $desc . '">recordatorio</a>
                     ' . $idProgToShow . '
                    </div>
                 </div>
            </div>';
    }
}

/**
 * function horario
 * @return html
 */
function selector_canales() {
    global $wpdb_pr;
    $query = ("SELECT categoria FROM $wpdb_pr->chn_cat ORDER BY id ASC");
    $cates = $wpdb_pr->get_results($query, 'OBJECT');
    $out .= '<li style="display:none"><a  id="sel_cate" class="sel_despl" href="#" title="Todos">Todos los canales</a></li>';
    foreach ($cates as $cate) {
        $out .= '<li style="display:none"><a id="sel_' . apply_filters('sanitize_title', $cate->categoria) . '" class="sel_despl" href="#" title="Programación de ' . $cate->categoria . '">' . $cate->categoria . '</a></li>';
    }
    echo $out;
}

function selector_fechas_13() {
    $fechas = range(3, 13);
    $out .= '<li class="ie"><a  id="sel_fecha" class="sel_fecha" href="#" title="Todos">más</a></li>';
    foreach ($fechas as $fecha) {
        $out .= '<li style="display:none"><a href="#"  id="fecha_' . date("mdy", mktime(0, 0, 0, date(m), date(d) + $fecha, date(y))) . '" class="sel_date_desp">' . fecha($fecha, "D") . ' ' . fecha($fecha, "d") . '</a></li>';
    }
    echo $out;
}

function delete_alarma($uid, $pid) {
    global $wpdb;
    return $wpdb->query("DELETE FROM wp_alarmas WHERE user_id=$uid and programa_id=$pid");
}

function canalesregion() {
    global $wpdb_pr;
    $senales = $wpdb_pr->get_results("SELECT $wpdb_pr->chn_web.codigo, senal, imagen FROM $wpdb_pr->chn_web JOIN $wpdb_pr->full ON ($wpdb_pr->chn_web.codigo=$wpdb_pr->full.codigo) WHERE $wpdb_pr->chn_web.codigo!='' AND imagen!='' AND grupo != 'Canales de Música Digital' AND grupo != 'Radios Nacionales' AND grupo != 'Radios Internacionales'   GROUP BY $wpdb_pr->chn_web.codigo ORDER BY santiago");

    foreach ($senales as $senal) {
        echo '<ul>';
        echo '<li class="chanreg"><img src="'.get_bloginfo('template_url').'/img/foto/' . $senal->imagen . '" alt="' . $senal->imagen . '"/></li>';
        grillaregion($senal->codigo);
        echo '<li class="chanreg"><img src="'.get_bloginfo('template_url').'/img/foto/' . $senal->imagen . '" alt="' . $senal->imagen . '"/></li>';
        echo '</ul>';
    }
}

function grillaregion($codigo) {
    global $wpdb_pr;
    $senales = $wpdb_pr->get_results("SELECT arica,iquique,tocopilla,calama,antofagasta,el_salvador,copiapo,vallenar,la_serena,illapel,la_ligua,aconcagua,vina_del_mar,san_antonio,santiago,rancagua,san_fernando,curico,talca,linares,parral,cauquenes,chillan,san_carlos,constitucion,concepcion,los_angeles,angol,victoria,temuco,valdivia,osorno,puerto_montt,ancud,castro,coyhaique FROM $wpdb_pr->full WHERE codigo=$codigo GROUP BY codigo", ARRAY_A);
    foreach ($senales as $k) {
        foreach ($k as $v) {
            $v = $v == 0 ? "" : $v;
            echo '<li>' . $v . '</li>';
        }
    }
}

class grilla {

    public function __construct() {
        
    }

    public function get_tms_canales_limit($canal_tipo = false, $comuna = false) {
        global $wpdb_pr;
        if ($canal_tipo)
            $canal_tipo = urldecode($canal_tipo);
        if ($canal_tipo == "peliculas")
            $canal_tipo = "Cine&Series";
        if ($canal_tipo == "series")
            $canal_tipo = "Cine&Series";
        if ($canal_tipo == "series-peliculas")
            $canal_tipo = "Cine&Series";
        if ($canal_tipo == "hd")
            $canal_tipo = "Alta Definición";
        if ($canal_tipo == "tendencias")
            $canal_tipo = "Estilos & Tendencias";
        if ($canal_tipo == "cultura")
            $canal_tipo = "Cultural";
        if ($canal_tipo == "adulto")
            $canal_tipo = "Adulto";
        if ($canal_tipo == "premium") {
            unset($canal_tipo);
            $canal_premium = " AND categoria = 'Premium' ";
        }
        $canal_inicio = $canal_inicio == false ? 0 : $canal_inicio;
        $canal_cantidad = $canal_cantidad == false ? 20 : $canal_cantidad;
        $limit = " LIMIT $canal_inicio, $canal_cantidad ";

        if (!$canal_tipo) {
            $limit = "";
        }
        if ($canal_tipo == "cate") {
            unset($canal_tipo);
        }

        if ($favoritos) {
            $favoritos = explode(",", $favoritos);
            if (is_array($favoritos)) {
                foreach ($favoritos as $fav) {
                    $chn_code[] = "'" . $fav . "'";
                }
            }
            $favoritos = " AND $wpdb_pr->full.codigo IN (" . implode(",", $chn_code) . ") ";
            unset($limit);
        }

        $comuna_user = strtolower($wpdb_pr->get_var("SELECT grilla FROM $wpdb_pr->comunas WHERE comuna='$comuna'"));
        $canal_tipo = $canal_tipo == false ? '' : " AND genero = '$canal_tipo' ";
        $query = ("SELECT $wpdb_pr->chn_web.codigo, tipo, categoria, senal, imagen, genero, driver, $comuna_user FROM $wpdb_pr->full INNER JOIN $wpdb_pr->chn_web ON ($wpdb_pr->chn_web.codigo = $wpdb_pr->full.codigo) WHERE 1 $favoritos $canal_tipo $canal_premium AND $comuna_user != 0 AND $wpdb_pr->chn_web.genero != 'Compra de Eventos' GROUP BY codigo ORDER BY $comuna_user ASC $limit");
        $results = $wpdb_pr->get_results($query, 'OBJECT');
        foreach ($results as $result) {
            $channels[] = $result->codigo;
        }
        return $channels;
    }

    public function get_canal_prog($canal, $fecha = false) {
        global $wpdb_pr;
        $fecha = !$fecha ? date('mdy') : $fecha;
        $query = ("SELECT $wpdb_pr->prog.ProgramID,Title,EpisodeTitle,MpaaRating,Director,Actor1,Actor2,Actor3,Desc1,Desc2,ChannelID,StartDate,StartTime,Duration
        FROM
            $wpdb_pr->sch INNER JOIN $wpdb_pr->prog
	ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
            WHERE $wpdb_pr->sch.StartDate = '$fecha'
        AND $wpdb_pr->sch.ChannelID = '$canal'"
                );
        return $wpdb_pr->get_results($query, 'OBJECT');
    }

    public function put_resultado($fecha, $hora, $channel, $tipo, $comuna = false) {
        global $bn, $bp;
        if ($hora < $bn) {
            $dia = substr($fecha, 2, 2) - 1;
            if ($dia < 10)
                "0" . $dia;
            $fecha = date('m') . $dia . date('y');
        }

        $chn_code = $this->get_tms_canales_limit($tipo, $comuna);
        $chnc = implode(",", $chn_code);
        echo $fechaz;

        $grilla = grilla(false, false, $tipo, true, $fecha, $chnc, $comuna);

        return $grilla;
    }

    public function get_canales_busqueda($data) {
        global $wpdb_pr, $wpdb;
        $query = (
                "SELECT $wpdb_pr->chn_web.genero,$wpdb_pr->chn_web.senal, $wpdb_pr->prog.ProgramID, $wpdb_pr->sch.StartDate, $wpdb_pr->sch.StartTime, $wpdb_pr->sch.ChannelID, $wpdb_pr->prog.Title
        FROM
            $wpdb_pr->sch,
            $wpdb_pr->prog,
            $wpdb_pr->chn_web
        WHERE
            (
            $wpdb_pr->prog.Title LIKE '%$data%'
            )
        
        AND $wpdb_pr->chn_web.codigo = $wpdb_pr->sch.ChannelID
        AND $wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID
        GROUP BY $wpdb_pr->sch.ProgramID
        ORDER BY $wpdb_pr->sch.StartDate ASC LIMIT 200"

                );
        return $wpdb_pr->get_results($query, 'OBJECT');
    }

    public function update_admin() {
        global $wpdb_pr, $form;
        unset($_POST['update-ajax']);
        if ($_POST[dbox] == "No") {
            $_POST[dbox] = "";
        }
    }

}

$grilla = new grilla();

/* ------------------------------------------------------------------------------------------------- llamados ajax */
if ($_POST['update-ajax']) {
    $grilla->update_admin();
}

if ($_GET['obt'] == 'grilla') {/* grilla normal y avance de scroll */
    echo json_encode(grilla($_GET['canal_inicio'], $_GET['canal_cantidad'], $_GET['canal_tipo'], true, $_GET['fecha'], false, $_GET['comuna']));
    exit;
}

if ($_GET['obt'] == 'grillacat') {
    echo json_encode(grilla(false, false, $_GET['canal_tipo'], true, $_GET['fecha'], false, $_GET['comuna']));
    exit;
}

/* grilla normal y avance de scroll */
if ($_GET['obt'] == 'grillaDate') {
    echo json_encode(grilla(0, 11, $_GET['canal_tipo'], true, $_GET['fecha'], false, $_GET['comuna']));
    exit;
}
/* grilla normal y avance de scroll */

if ($_GET['obt'] == 'minificha') {
    echo minificha($_GET['channels'], $_GET['programs'], $_GET['starttime'], $_GET['startdate'], $_GET['canal_tipo']);
    exit;
}
if ($_GET['obt'] == 'search') {
    echo json_encode($grilla->get_canales_busqueda($_GET['search']));
    exit;
}
if ($_GET['obt'] == 'gotoresu') {
    echo json_encode($grilla->put_resultado($_GET['fecha'], $_GET['hora'], $_GET['channel'], $_GET['tipo'], $_GET['comuna']));
    exit;
}
if ($_GET['obt'] == 'delete') {
    echo json_encode(delete_alarma($_GET['uid'], $_GET['pid']));
    exit;
}
if ($_GET['obt'] == 'grillacurl') {
    $favcurl = split(',', $_GET[chnid]);
    echo json_encode(grilla_externa($_GET['canal_inicio'], $_GET['canal_cantidad'], false, true, false, $favcurl));
    exit;
} /* grilla normal y avance de scroll */
if (!function_exists(css_dir)) {

    function css_dir() {
        return "http://" . $_SERVER['HTTP_HOST'] . "/wp-content/themes/" . get_template();
    }

}

function horario() {
    return ' <ul id="horas">
                            <li>
                                00:00 am
                            </li>
                            <li>
                                01:00 am
                            </li>
                            <li>
                                02:00 am
                            </li>
                            <li>
                                03:00 am
                            </li>
                            <li>
                                04:00 am
                            </li>
                            <li>
                                05:00 am
                            </li>
                            <li>
                                06:00 am
                            </li>
                            <li>
                                07:00 am
                            </li>
                            <li>
                                08:00 am
                            </li>
                            <li>
                                09:00 am
                            </li>
                            <li>
                                10:00 am
                            </li>
                            <li>
                                11:00 am
                            </li>
                            <li>
                                12:00 pm
                            </li>
                            <li>
                                13:00 pm
                            </li>
                            <li>
                                14:00 pm
                            </li>
                            <li>
                                15:00 pm
                            </li>
                            <li>
                                16:00 pm
                            </li>
                            <li>
                                17:00 pm
                            </li>
                            <li>
                                18:00 pm
                            </li>
                            <li>
                                19:00 pm
                            </li>

                            <li>
                                20:00 pm
                            </li>

                            <li>
                                21:00 pm
                            </li>

                            <li>
                                22:00 pm
                            </li>
                            <li>
                                23:00 pm
                            </li>
                        </ul>
                        <ul id="horario">
                            <li>
                                00:00 am
                            </li>
                            <li>
                                00:15 am
                            </li>
                            <li>
                                00:30 am
                            </li>
                            <li>
                                00:45 am
                            </li>
                            <li>
                                01:00 am
                            </li>
                            <li>
                                01:15 am
                            </li>
                            <li>
                                01:30 am
                            </li>
                            <li>
                                01:45 am
                            </li>
                            <li>
                                02:00 am
                            </li>
                            <li>
                                02:15 am
                            </li>
                            <li>
                                02:30 am
                            </li>
                            <li>
                                02:45 am
                            </li>
                            <li>
                                03:00 am
                            </li>
                            <li>
                                03:15 am
                            </li>
                            <li>
                                03:30 am
                            </li>
                            <li>
                                03:45 am
                            </li>
                            <li>
                                04:00 am
                            </li>
                            <li>
                                04:15 am
                            </li>
                            <li>
                                04:30 am
                            </li>
                            <li>
                                04:45 am
                            </li>
                            <li>
                                05:00 am
                            </li>
                            <li>
                                05:15 am
                            </li>
                            <li>
                                05:30 am
                            </li>
                            <li>
                                05:45 am
                            </li>
                            <li>
                                06:00 am
                            </li>
                            <li>
                                06:15 am
                            </li>
                            <li>
                                06:30 am
                            </li>
                            <li>
                                06:45 am
                            </li>
                            <li>
                                07:00 am
                            </li>
                            <li>
                                07:15 am
                            </li>
                            <li>
                                07:30 am
                            </li>
                            <li>
                                07:45 am
                            </li>
                            <li>
                                08:00 am
                            </li>
                            <li>
                                08:15 am
                            </li>
                            <li>
                                08:30 am
                            </li>
                            <li>
                                08:45 am
                            </li>
                            <li>
                                09:00 am
                            </li>
                            <li>
                                09:15 am
                            </li>
                            <li>
                                09:30 am
                            </li>
                            <li>
                                09:45 am
                            </li>
                            <li>
                                10:00 am
                            </li>
                            <li>
                                10:15 am
                            </li>
                            <li>
                                10:30 am
                            </li>
                            <li>
                                10:45 am
                            </li>
                            <li>
                                11:00 am
                            </li>
                            <li>
                                11:15 am
                            </li>
                            <li>
                                11:30 am
                            </li>
                            <li>
                                11:45 am
                            </li>
                            <li>
                                12:00 pm
                            </li>
                            <li>
                                12:15 pm
                            </li>
                            <li>
                                12:30 pm
                            </li>
                            <li>
                                12:45 pm
                            </li>
                            <li>
                                13:00 pm
                            </li>
                            <li>
                                13:15 pm
                            </li>
                            <li>
                                13:30 pm
                            </li>
                            <li>
                                13:45 pm
                            </li>
                            <li>
                                14:00 pm
                            </li>
                            <li>
                                14:15 pm
                            </li>
                            <li>
                                14:30 pm
                            </li>
                            <li>
                                14:45 pm
                            </li>
                            <li>
                                15:00 pm
                            </li>
                            <li>
                                15:15 pm
                            </li>

                            <li>
                                15:30 pm
                            </li>
                            <li>
                                15:45 pm
                            </li>
                            <li>
                                16:00 pm
                            </li>
                            <li>
                                16:15 pm
                            </li>
                            <li>
                                16:30 pm
                            </li>
                            <li>
                                16:45 pm
                            </li>
                            <li>
                                17:00 pm
                            </li>
                            <li>
                                17:15 pm
                            </li>
                            <li>
                                17:30 pm
                            </li>
                            <li>
                                17:45 pm
                            </li>
                            <li>
                                18:00 pm
                            </li>
                            <li>
                                18:15 pm
                            </li>
                            <li>
                                18:30 pm
                            </li>
                            <li>
                                18:45 pm
                            </li>
                            <li>
                                19:00 pm
                            </li>
                            <li>
                                19:15 pm
                            </li>
                            <li>
                                19:30 pm
                            </li>
                            <li>
                                19:45 pm
                            </li>
                            <li>
                                20:00 pm
                            </li>
                            <li>
                                20:15 pm
                            </li>
                            <li>
                                20:30 pm
                            </li>
                            <li>
                                20:45 pm
                            </li>
                            <li>
                                21:00 pm
                            </li>
                            <li>
                                21:15 pm
                            </li>
                            <li>
                                21:30 pm
                            </li>
                            <li>
                                21:45 pm
                            </li>
                            <li>
                                22:00 pm
                            </li>
                            <li>
                                22:15 pm
                            </li>
                            <li>
                                22:30 pm
                            </li>
                            <li>
                                22:45 pm
                            </li>
                            <li>
                                23:00 pm
                            </li>
                            <li>
                                23:15 pm
                            </li>
                            <li>
                                23:30 pm
                            </li>
                            <li>
                                23:45 pm
                            </li>
                         </ul>';
}

?>
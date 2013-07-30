<?php
/*
Plugin Name: utilidades de television
Plugin URI: maxvillegas.com
Description: Funciones extra
Version: 0.5
Author: Max Villegas
Author URI: http://mvillegas.com/
*/
//include "wp-includes/rss.php";



    $_POST      = array_map( 'stripslashes_deep', $_POST );
    $_GET       = array_map( 'stripslashes_deep', $_GET );
    $_COOKIE    = array_map( 'stripslashes_deep', $_COOKIE );
    $_REQUEST   = array_map( 'stripslashes_deep', $_REQUEST );

if (!function_exists(css_dir)) {
    function css_dir() {
        return "http://" .$_SERVER['HTTP_HOST'] . "/wp-content/themes/" .get_template();
    }
}

function secure_https() {
    if ((!eregi('wp-admin/', $_SERVER['REQUEST_URI']) && !eregi('wp-login.php', $_SERVER['REQUEST_URI']) && !eregi('perfil/', $_SERVER['REQUEST_URI']) && !eregi('registro/', $_SERVER['REQUEST_URI']) )&& $_SERVER['HTTPS']) {header("location: http://" .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);}



}
function get_css_dir() {
    echo css_dir();
}

function my_xml2array($__url) {
    $xml_values = array();
    $contents = $__url;
    $parser = xml_parser_create('');
    if(!$parser)
        return false;

    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values)
        return array();

    $xml_array = array();
    $last_tag_ar =& $xml_array;
    $parents = array();
    $last_counter_in_tag = array(1=>0);
    foreach ($xml_values as $data) {
        switch($data['type']) {
            case 'open':
                $last_counter_in_tag[$data['level']+1] = 0;
                $new_tag = array('name' => $data['tag']);
                if(isset($data['attributes']))
                    $new_tag['attributes'] = $data['attributes'];
                if(isset($data['value']) && trim($data['value']))
                    $new_tag['value'] = trim($data['value']);
                $last_tag_ar[$last_counter_in_tag[$data['level']]] = $new_tag;
                $parents[$data['level']] =& $last_tag_ar;
                $last_tag_ar =& $last_tag_ar[$last_counter_in_tag[$data['level']]++];
                break;
            case 'complete':
                $new_tag = array('name' => $data['tag']);
                if(isset($data['attributes']))
                    $new_tag['attributes'] = $data['attributes'];
                if(isset($data['value']) && trim($data['value']))
                    $new_tag['value'] = trim($data['value']);

                $last_count = count($last_tag_ar)-1;
                $last_tag_ar[$last_counter_in_tag[$data['level']]++] = $new_tag;
                break;
            case 'close':
                $last_tag_ar =& $parents[$data['level']];
                break;
            default:
                break;
        };
    }
    return $xml_array;
}
function comunas($region) {
    if ($region =="RM") {
        $comunas = array(
            ""=>"Elije una opción",
            "CERR"=>"Cerrillos",
            "CNAV"=>"Cerro Navia",
            "COLI"=>"Colina",
            "CNCH"=>"Conchalí",
            "ELBO"=>"El Bosque",
            "ECEN"=>"Estación Central",
            "HUEC"=>"Huechuraba",
            "INDE"=>"Independencia",
            "LACI"=>"La Cisterna",
            "LFLO"=>"La Florida",
            "LGRA"=>"La Granja",
            "LPIN"=>"La Pintana",
            "LREI"=>"La Reina",
            "LAMP"=>"Lampa",
            "LCON"=>"Las Condes",
            "LBAR"=>"Lo Barnechea",
            "LESP"=>"Lo Espejo",
            "LPRA"=>"Lo Prado",
            "MACU"=>"Macul",
            "MAIP"=>"Maipú",
            "NUNO"=>"Ñuñoa",
            "PACE"=>"Pedro Aguirre Cerda",
            "PLOR"=>"Peñaflor",
            "PENA"=>"Peñalolén",
            "PROV"=>"Providencia",
            "PUDA"=>"Pudahuel",
            "PALT"=>"Puente Alto",
            "QUIL"=>"Quilicura",
            "QNOR"=>"Quinta Normal",
            "RECO"=>"Recoleta",
            "RENC"=>"Renca",
            "SRAM"=>"San Ramón",
            "SBER"=>"San Bernardo",
            "SJOA"=>"San Joaquin",
            "SMGL"=>"San Miguel",
            "SACE"=>"Santiago",
            "VITA"=>"Vitacura");
    }
    if ($region =="01") {
        $comunas = array(""=>"Elije una opción",
            "AHOS"=>"Alto Hospicio",
            "IQUI"=>"Iquique"
        );
    }
    if ($region =="02") {
        $comunas = array (""=>"Elije una opción",
            "ANTO"=>"Antofagasta",
            "CALA"=>"Calama",
            "CHUQ"=>"Chuquicamata",
            "TOCO"=>"Tocopilla");
    }
    if ($region =="03") {
        $comunas = array (""=>"Elije una opción",
            "ACAR"=>"Alto del Carmen",
            "COPI"=>"Copiapó",
            "ESAL"=>"El Salvador",
            "VALL"=>"Vallenar");
    }
    if ($region =="04") {
        $comunas = array (""=>"Elije una opción",
            "COQU"=>"Coquimbo",
            "ILLA"=>"Illapel",
            "LSER"=>"La Serena");
    }
    if ($region =="05") {
        $comunas = array (""=>"Elije una opción",
            "CART"=>"Cartagena",
            "CCON"=>"ConCon",
            "CALE"=>"La Calera",
            "LCRU"=>"La Cruz",
            "LLIG"=>"La Ligua",
            "LIMA"=>"Limache",
            "LLLA"=>"Llay Llay",
            "LAND"=>"Los Andes",
            "MAIT"=>"Maitencillo",
            "NOGA"=>"Nogales",
            "OLMU"=>"Olmue",
            "PUTA"=>"Putaendo",
            "QOTA"=>"Quillota",
            "QPUE"=>"Quilpue",
            "SANT"=>"San Antonio",
            "SEST"=>"San Esteban",
            "SFEL"=>"San Felipe",
            "SMAR"=>"Santa Maria",
            "SDOM"=>"Santo Domingo",
            "VALP"=>"Valparaiso",
            "VALE"=>"Villa Alemana",
            "VINA"=>"Vina Del Mar",
        );
    }
    if ($region =="06") {
        $comunas = array (""=>"Elije una opción",
            "MACH"=>"Machalí",
            "RANC"=>"Rancagua",
            "RENG"=>"Rengo",
            "SFER"=>"San Fernando"
        );
    }
    if ($region =="07") {
        $comunas = array (""=>"Elije una opción",
            "CAUQ"=>"Cauquenes",
            "CONS"=>"Constitucion",
            "CURI"=>"Curicó",
            "PARR"=>"Parral",
            "TALC"=>"Talca");
    }
    if ($region =="08") {
        $comunas = array (""=>"Elije una opción",
            "CHIL"=>"Chillán",
            "CHIU"=>"Chiguayante",
            "CONC"=>"Concepcion",
            "LIN"=>"Linares",
            "LANG"=>"Los Angeles",
            "PENC"=>"Penco",
            "SCAR"=>"San Carlos",
            "SPED"=>"San Pedro",
            "THNO"=>"Talcahuano"
        );
    }
    if ($region =="09") {
        $comunas = array (""=>"Elije una opción",
            "ANGO"=>"Angol",
            "LABR"=>"Labranza",
            "PCAS"=>"Padre las Casas",
            "VICT"=>"Victoria"
        );
    }
    if ($region =="10") {
        $comunas = array (""=>"Elije una opción",
            "ANCU"=>"Ancud",
            "CAST"=>"Castro",
            "LLAN"=>"Llanquihue",
            "OSOR"=>"Osorno",
            "PMON"=>"Puerto Montt",
            "PVAR"=>"Puerto Varas"
        );
    }
    if ($region =="11") {
        $comunas = array (""=>"Elije una opción",
            "COIH"=>"Coyhaique");
    }
    if ($region =="12") {
        $comunas = array (""=>"Elije una opción",
            "ANTA"=>"Antartica",
            "LBLA"=>"Laguna Blanca",
            "NAVA"=>"Navarino",
            "PORV"=>"Porvenir",
            "PRIM"=>"Primavera",
            "PARE"=>"Punta Arenas",
            "RVER"=>"Rio Verde",
            "SGRE"=>"San Gregorio",
            "TIMA"=>"Timaukel");
    }
    if ($region =="14") {
        $comunas = array (""=>"Elije una opción",
            "OSOR"=>"Osorno",
            "LUNI"=>"La Union",
            "VALD"=>"Valdivia");
    }
    if ($region =="15") {
        $comunas = array (""=>"Elije una opción",
            "ARIC"=>"Arica");
    }


    return $comunas;
}
function region() {

    return array("RM"=>"Región Metropolitana",
    "01"=>"Región de Tarapacá",
    "02"=>"Región de Antofagasta",
    "03"=>"Región de Atacama",
    "04"=>"Región de Coquimbo",
    "05"=>"Región de Valparaíso",
    "06"=>"Región de O´Higgins",
    "07"=>"Región del Maule",
    "08"=>"Región del Biobío",
    "09"=>"Región de la Araucanía",
    "10"=>"Región de los Lagos",
    "11"=>"Región Aisén",
    "14"=>"Región de los Ríos",
    "15"=>"Región de Arica");
}
function validador() {

    global $form;
    if ($_POST & $_POST['userkey']==""):
        unset($_POST['userkey']);
        $form->requeridos=array(
            "nombre"=> "presencia",
            "apellido"=> "presencia",
            "genero"=> "presencia",
            "user_login"=> "presencia",
            "rday"=> "presencia",
            "rmonth"=> "presencia",
            "ryear"=> "presencia",
            "user_email"=> "email",
            "cliente_television"=>"presencia",
            "acepto"=>"presencia"
        );
        $form->mensajes=array(
            "error"=>array(
            "nombre"=> "presencia",
            "apellido"=> "presencia",
            "genero"=> "presencia",
            "user_login"=> "presencia",
            "rday"=> "presencia",
            "rmonth"=> "presencia",
            "ryear"=> "presencia",
            "user_email"=> "email",
            "cliente_television"=>"presencia",
            "acepto"=>"presencia"
            ),
            "defecto"=>array(
            "nombre"=> "presencia",
            "apellido"=> "presencia",
            "genero"=> "presencia",
            "user_login"=> "presencia",
            "rday"=> "presencia",
            "rmonth"=> "presencia",
            "ryear"=> "presencia",
            "user_email"=> "presencia",
            "cliente_television"=>"presencia",
            "acepto"=>"presencia"
            )
        );
        if ($_SERVER[REQUEST_URI]=="/registro/") {
            $form->requeridos['user_pass']="clave";
            $form->mensajes['error']['user_pass']="clave";
            $form->mensajes['defecto']['user_pass']="clave";

            $form->requeridos[user_passcon]="clave";
            $form->mensajes[error][user_passcon]="clave";
            $form->mensajes[defecto][user_passcon]="clave";
            if($_POST['user_email'] != $_POST["user_email_confirm"] or $_POST["user_email_confirm"] =='' or eregi("[(*.+?)|]",$_POST['user_email_confirm']) or !eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,6}$",$_POST['user_email_confirm'])) {
                $_POST['user_email_confirm'] = str_replace(explode(',', 'ª,¨,Ç,?,\,/,|,",\',;,(,),*,:,<,>,!,|,&,#,%,$,+,[,],^,~,`,=,½,¬,{,},·,¿,'), '', $_POST['user_email_confirm']);
                $form->requeridos[user_email_confirm]="email";
                $form->mensajes[error][user_email_confirm]="email";
                $form->mensajes[defecto][user_email_confirm]="email";
                $from->track_error[user_email_confirm]=" alert";
                $from->track_error[user_email]=" alert";

            }


            if ($_POST['cliente_television']=="si") {
                $form->requeridos[region]="presencia";
                $form->mensajes[error][region]="presencia";
                $form->mensajes[defecto][region]="presencia";

                $form->requeridos[comuna]="presencia";
                $form->mensajes[error][comuna]="presencia";
                $form->mensajes[defecto][comuna]="presencia";

                $form->requeridos[producto]="presencia";
                $form->mensajes[error][producto]="presencia";
                $form->mensajes[defecto][producto]="presencia";
            }
            if ($_POST['producto']=="TV Cable Light") {
                $form->requeridos[dbox_clight]="presencia";
                $form->mensajes[error][dbox_clight]="presencia";
                $form->mensajes[defecto][dbox_clight]="presencia";
            }
            if ($_POST['producto']=="TV Cable Full") {
                $form->requeridos[dbox_cfull]="presencia";
                $form->mensajes[error][dbox_cfull]="presencia";
                $form->mensajes[defecto][dbox_cfull]="presencia";
            }
        }
        else {
        //Editar perfil
            $_POST['acepto'] = 'true';
            unset($_POST['editar_perfil']);

            if($_POST[region]=="default")$_POST[comuna]='';
            if($_POST[comuna]=="default")$_POST[comuna]='';

            if ($_GET['editar']=="datos_conexion") {
                if ($_POST['cliente_television']=="si") {
                    $form->requeridos[region]="presencia";
                    $form->mensajes[error][region]="presencia";
                    $form->mensajes[defecto][region]="presencia";

                    $form->requeridos[comuna]="presencia";
                    $form->mensajes[error][comuna]="presencia";
                    $form->mensajes[defecto][comuna]="presencia";

                    $form->requeridos[producto]="presencia";
                    $form->mensajes[error][producto]="presencia";
                    $form->mensajes[defecto][producto]="presencia";
                }
                if ($_POST['producto']=="TV Cable Light") {
                    $form->requeridos[dbox_clight]="presencia";
                    $form->mensajes[error][dbox_clight]="presencia";
                    $form->mensajes[defecto][dbox_clight]="presencia";
                }
                if ($_POST['producto']=="TV Cable Full") {
                    $form->requeridos[dbox_cfull]="presencia";
                    $form->mensajes[error][dbox_cfull]="presencia";
                    $form->mensajes[defecto][dbox_cfull]="presencia";
                }
            }
        }
        $estado = $form->verificar();

        if($_POST['user_email'] != $_POST["user_email_confirm"]) {
            $form->track_error[user_email_confirm]=" alert";
            $form->track_error[user_email]=" alert";
        }

        if($_POST[dbox_clight]=="default")$_POST[dbox_clight]='';
        if($_POST[dbox_cfull]=="default")$_POST[dbox_cfull]='';

        $_POST[fecha_nacimiento] = $_POST[rday]."/".$_POST[rmonth]."/".$_POST[ryear];
        $_POST[dbox] = $_POST[dbox_clight]?$_POST[dbox_clight]:$_POST[dbox_cfull];
        if ($_POST['producto'] == "Cable Mi Pack") { $_POST['dbox'] = "si"; }
        $_POST[premium] = serialize($_POST[pack]);
        $_POST[carta] = serialize($_POST[carta]);
        upload_avatar('avatar');
        if(!$estado['error']):
            unset($_POST[user_email_confirm]);
            unset($_POST[rday]);
            unset($_POST[rmonth]);
            unset($_POST[ryear]);
            unset($_POST[user_passcon]);
            unset($_POST[acepto]);
            unset($_POST[Insert]);
            unset($_POST[dbox_clight]);
            unset($_POST[dbox_cfull]);
            unset($_POST[pack]);

            $_POST[action]= !$_POST[action]?"insert":$_POST[action];
            $_POST[tabla_site]= !$_POST[tabla_site]?"wp_vtr_tv":$_POST[tabla_site];
            $_POST[redirect]= !$_POST[redirect]?"http://televisionvtr.cl/registro/gracias/":$_POST[redirect];
            $xml = getcurl("http://televisionvtr.cl/index.php?userxml=true", $_POST);
            $r=my_xml2array($xml);


            if ($r[0][0][name]=="method" && $r[0][1][name]=="status" && $r[0][1][value]=="complete") {
                $status[api_status]="complete";
                $status[api_method]=$r[0][0][value];
                $status[api_data]=$r[0][2];
                $status[api_data_type]="array";
            }
            if($r[0][0][name]=="Error") {
                header('HTTP/1.1 403 Forbidden');
                $status[api_code] = $r[0][0][ attributes][Code];
                $status[api_desc] = $r[0][0][ value];
                $status[api_status] = $r[0][0][name];
            }
            if ( $status[api_status]=="complete") {
                require_once(ABSPATH . "/wp-content/plugins/wp-mail-smtp/wp_mail_smtp.php");
                //Envio email de agradecimiento
                $mailto['para'] = $_POST['user_email'];
                $mailto['asunto'] = "Gracias por registrarte en televisionvtr.cl";
                $mailto['mensaje'] = "<html>";
                $mailto['mensaje'] .= "<head><title>Television VTR</title>";
                $mailto['mensaje'] .= "</head><body>";
                $mailto['mensaje'] .= "<p><img src='http://televisionvtr.cl/wp-content/themes/televisionvtr/img/titulos/mail.jpg' /><br><b>".$_POST['nombre']." ".$_POST['apellido']."</b></p>";
                $mailto['mensaje'] .= "<p>Felicitaciones, te has registrado en el sitio de <a href='http://televisionvtr.cl'>televisión VTR </a>.</p>";
                $mailto['mensaje'] .= "<p><b>No olvides</b> que para ver tu programación personalizada y participar activamente de este sitio debes ingresar tu nombre de usuario y contraseña en la página de <a href='https://televisionvtr.cl/login/'>login</a></p>";
                $mailto['mensaje'] .= "<h2>Guarda tus datos en un lugar seguro</h2>";
                $mailto['mensaje'] .= "<p>Te has regisrado en el sitio de televisión de VTR con los siguientes datos."."</p>";
                $mailto['mensaje'] .= "<ul><li>usuario:".$_POST['user_login']."</li>";
                $mailto['mensaje'] .= "<li>password:".$_POST['user_pass']."</li></ul>";
                $mailto['mensaje'] .= "<p>Te esperamos <br> <a href='http://televisionvtr.cl/'>Television VTR</a></p></body></html>";
                $headers .= "Content-type: text/html;";
                wp_mail($mailto['para'], $mailto['asunto'], $mailto['mensaje'], $headers);
                header("location: $_POST[redirect]");
            }
            else {
                return $status;
            }
        else:
            return $estado;
    endif;
endif;

}
function validador_sb() {
    global $form;
    if ($_POST & $_POST['userkey']==""):
        unset($_POST['userkey']);
        $form->requeridos=array(
            "nombre"=> "presencia",
            "apellido"=> "presencia",
            "genero"=> "presencia",
            "user_login"=> "presencia",
            "rday"=> "presencia",
            "rmonth"=> "presencia",
            "ryear"=> "presencia",
            "user_email"=> "email",
            "acepto"=>"presencia"
        );
        $form->mensajes=array(
            "error"=>array(
            "nombre"=> "presencia",
            "apellido"=> "presencia",
            "genero"=> "presencia",
            "user_login"=> "presencia",
            "rday"=> "presencia",
            "rmonth"=> "presencia",
            "ryear"=> "presencia",
            "user_email"=> "email",
            "acepto"=>"presencia"
            ),
            "defecto"=>array(
            "nombre"=> "presencia",
            "apellido"=> "presencia",
            "genero"=> "presencia",
            "user_login"=> "presencia",
            "rday"=> "presencia",
            "rmonth"=> "presencia",
            "ryear"=> "presencia",
            "user_email"=> "presencia",
            "acepto"=>"presencia"
            )
        );
        if ($_SERVER[REQUEST_URI]=="/registro/") {
            $form->requeridos[user_pass]="clave";
            $form->mensajes[error][user_pass]="clave";
            $form->mensajes[defecto][user_pass]="clave";

            $form->requeridos[user_passcon]="clave";
            $form->mensajes[error][user_passcon]="clave";
            $form->mensajes[defecto][user_passcon]="clave";

            if($_POST['user_email'] != $_POST["user_email_confirm"] or $_POST["user_email_confirm"] =='') {
                $form->requeridos[user_email_confirm]="email";
                $form->mensajes[error][user_email_confirm]="email";
                $form->mensajes[defecto][user_email_confirm]="email";
                $from->track_error[user_email_confirm]=" alert";
                $from->track_error[user_email]=" alert";

            }
        }
        else {
        //Editar perfil
            $_POST['acepto'] = 'true';
            unset($_POST['editar_perfil']);
            if($_POST[region]=="default")$_POST[comuna]='';
            if($_POST[comuna]=="default")$_POST[comuna]='';
            if ($_GET['editar']=="datos_conexion") {
                if ($_POST['cliente_television']=="si") {
                    $form->requeridos[region]="presencia";
                    $form->mensajes[error][region]="presencia";
                    $form->mensajes[defecto][region]="presencia";

                    $form->requeridos[comuna]="presencia";
                    $form->mensajes[error][comuna]="presencia";
                    $form->mensajes[defecto][comuna]="presencia";

                    $form->requeridos[producto]="presencia";
                    $form->mensajes[error][producto]="presencia";
                    $form->mensajes[defecto][producto]="presencia";
                }
            }
        }
        $estado = $form->verificar();

        if($_POST['user_email'] != $_POST["user_email_confirm"]) {
            $form->track_error[user_email_confirm]=" alert";
            $form->track_error[user_email]=" alert";
        }


        $_POST[fecha_nacimiento] = $_POST[rday]."/".$_POST[rmonth]."/".$_POST[ryear];
        upload_avatar('avatar');
        if(!$estado['error']):
            unset($_POST[user_email_confirm]);
            unset($_POST[rday]);
            unset($_POST[rmonth]);
            unset($_POST[ryear]);
            unset($_POST[user_passcon]);
            unset($_POST[acepto]);
            unset($_POST[Insert]);

            $_POST[action]= !$_POST[action]?"insert":$_POST[action];
            $_POST[tabla_site]= !$_POST[tabla_site]?"wp_somosblog":$_POST[tabla_site];
            $_POST[redirect]= !$_POST[redirect]?"http://somosblogs.cl/registro/gracias/":$_POST[redirect];
            $xml = getcurl("http://somosblogs.cl/index.php?userxml=true", $_POST);
            $r=my_xml2array($xml);


            if ($r[0][0][name]=="method" && $r[0][1][name]=="status" && $r[0][1][value]=="complete") {
                $status[api_status]="complete";
                $status[api_method]=$r[0][0][value];
                $status[api_data]=$r[0][2];
                $status[api_data_type]="array";
            }
            if($r[0][0][name]=="Error") {
                $status[api_code] = $r[0][0][ attributes][Code];
                $status[api_desc] = $r[0][0][ value];
                $status[api_status] = $r[0][0][name];
            }
            if ( $status[api_status]=="complete") {
                require_once(ABSPATH . "/wp-content/plugins/wp-mail-smtp/wp_mail_smtp.php");
                //Envio email de agradecimiento
                $mailto['para'] = $_POST['user_email'];
                $mailto['asunto'] = "Gracias por registrarte en somosblogs.cl";
                $mailto['mensaje'] = "<html>";
                $mailto['mensaje'] .= "<head><title>SomosBlogs</title>";
                $mailto['mensaje'] .= "</head><body>";
                $mailto['mensaje'] .= "<p><img src='http://somosblogs.cl/wp-content/themes/televisionvtr/img/titulos/mail.jpg' /><br><b>".$_POST['nombre']." ".$_POST['apellido']."</b></p>";
                $mailto['mensaje'] .= "<p>Felicitaciones, te has registrado en el sitio de <a href='http://televisionvtr.cl'>televisión VTR </a>.</p>";
                $mailto['mensaje'] .= "<p><b>No olvides</b> que para ver tu programación personalizada y participar activamente de este sitio debes ingresar tu nombre de usuario y contraseña en la página de <a href='https://somosblogs.cl/login/'>login</a></p>";
                $mailto['mensaje'] .= "<h2>Guarda tus datos en un lugar seguro</h2>";
                $mailto['mensaje'] .= "<p>Te has regisrado en la comunidad de SomosBlogs con los siguientes datos."."</p>";
                $mailto['mensaje'] .= "<ul><li>usuario:".$_POST['user_login']."</li>";
                $mailto['mensaje'] .= "<li>password:".$_POST['user_pass']."</li></ul>";
                $mailto['mensaje'] .= "<p>Te esperamos <br> <a href='http://somosblogs.cl/'>SomosBlogs</a></p></body></html>";
                $headers .= "Content-type: text/html;";
                wp_mail($mailto['para'], $mailto['asunto'], $mailto['mensaje'], $headers);
                header("location: $_POST[redirect]");
            }
            else {
                return $status;
            }
        else:
            return $estado;
    endif;
endif;

}
function panel_soyfan() {
    $fan = user_fan();

    if (!is_array($fan)) return '<tr><td class="large">No te has hecho fan de nada aún</td></tr>';

    foreach($fan as $var) {
        $out .= '<tr><td class="large">'.get_the_title($var[ficha_id]).'</td><td class="chica"><a href="#" id="fan_'.$var[ficha_id].'" class="eliminar_fan" title="Eliminar '.get_the_title($var[ficha_id]).'">eliminar</a></td></tr>';
    }
    return $out;
}
function edit_udata() {
    global $wpdb;
    $id_user = get_current_user_id();
    $udata->userdata = @get_object_vars(get_userdata($id_user));
    $udata->vtr_user = @$wpdb->get_results("SELECT * FROM wp_vtr_tv WHERE user_id=$id_user", ARRAY_A);
    return @array_merge($udata->userdata, $udata->vtr_user[0]);
}
/**
 * Query para llamar a las noticias transversales de cada blog
 * @param string id del blog requerido
 * @param string id de la categoria requerida, segun el tipo de blog
 * @return function php
 */
function post_cn($idblog,$tipo) {
    global $wpdb;
    
    $wpdb->base_prefix  = 'cn_';
    $wpdb->prefix= 'cn_';
    $wpdb->posts= ' cn_posts';
    $cate = $wpdb->get_var("SELECT term_id FROM  cn_terms WHERE slug ='$tipo'");
    $postCn = get_posts('category='.$cate.'&numberposts=4oderby=date&order=desc');
    $wpdb->base_prefix  = 'wp_2_';
    $wpdb->base_prefix  = 'wp_2_';
    $wpdb->prefix= 'wp_2_';
    $wpdb->posts= 'wp_2_posts';

    return $postCn;
}
function cableNews($blogid,$tipo) {
    global $wpdb;
    
    if(function_exists('wp_crop_image') == false){
        require_once(ABSPATH . 'wp-admin/includes/image.php');
    }
    $rss = post_cn($blogid,$tipo);

    if ( $rss ) {

        $i=0;
        foreach ( (array) $rss as $item ) {
            $cb = $wpdb->get_var("SELECT meta_value FROM cn_postmeta WHERE meta_key ='image_news2' AND post_id=$item->ID");
            $img = $wpdb->get_var("SELECT guid FROM cn_posts WHERE ID=$cb");
//           
//            $img = explode("wp-content/", $img);
//            $img = end($img);
//            $path = ABSPATH .'wp-content/' . $img;
//            
//            print_r($path);
//            
//            $img = wp_crop_image($path , 1, 1, 40, 40, 40, 40);
//            $img = explode("/", $img);
//            $img = end($img);
//            
//            $dir = wp_upload_dir();
            
            
            echo '<li>';
            if ($cb) echo '<a title="'.$item->post_title.'"><img src="'.$img.'" alt="'.$item->post_name.'" height="40" width="40" /></a>';
            echo '<p>'."\n";
            echo '<a class="dest" href="http://cablenews.vtr.cl/'.$tipo."/".sanitize_title($item->post_name).'" title="'.$item->post_title.'">'. cortar($item->post_title, 55)."</a>\n";

            echo "</p></li>";

            $i++;
        }
    }

}
function cableNewsCat($blogid,$tipo) {
    global $wpdb, $post;

    $items = post_cn($blogid,$tipo);

    if ( $items ) {

        $i=0;
        foreach ( (array) $items as $item ) {
            $cb = $wpdb->get_var("SELECT meta_value FROM  wp_3_postmeta WHERE meta_key ='image_news' AND post_id=$item->ID");
            echo '<li>';
            if ($cb!="") echo '<a href="http://' .$_SERVER['HTTP_HOST'] ."/". $tipo."/".sanitize_title(" ","-",$item->post_title).'" title="'.$item->post_title.'"><img class="img" alt="ir a '.$item->post_title.'" src="'.pt().'?src=http://'.$_SERVER['HTTP_HOST'].'/wp-content/files_flutter/'.$cb.'&amp;w=30&amp;h=30&amp;zc=1" style="float:left; margin-right:5px;"/></a>';
            echo '<p class="ficha_cat"><span class="'.$tipo.'">'.$tipo.'</span></p>';
            echo '<a href="h' .$_SERVER['HTTP_HOST'] ."/".$tipo."/".sanitize_title(" ","-",$item->post_title).'" title="'.$item->post_title.'">'. cortar($item->post_title, 32)."</a>\n";
            echo "</p></li>";

            $i++;
        }
    } else {
        return false;
    }

}
function rss_vd($url, $num=4) {
    require_once(ABSPATH . WPINC . "/rss.php");
    $rss = fetch_rss("http://www.vivedeportes.cl/feed/rss");
    if ( $rss ) {
        $rss->items = array_slice($rss->items, 0, $num);
        foreach ( (array) $rss->items as $item ) {
            preg_match_all("/src=[\"']?([^\"']?.*(png|jpg|gif))[\"']?/i", $item[description], $matches, PREG_OFFSET_CAPTURE);
            echo '  <li class="dest cf" style="height: inherit">';
            echo '<a rel = "external " href="'.$item[link].'" title="'.$item[title].'"><strong>'. $item['title']."</strong></a>\n";
            echo strip_tags(cortar($item[description], 85))."</p>";
            echo '</li>';
        }
    } else {
    //return false;
    }
}
function save_data($vars, $tabla, $id=false) {
    global $wpdb;
    $fields=$wpdb->get_results("SELECT * FROM $tabla", OBJECT);

    foreach ($fields[0] as $k => $v) {
        $fieldsname[] = $k;

    }
    foreach($vars as $clave => $valor) {
        if (!in_array($clave, $fieldsname)) {
            $clavelist[]=$clave;
        }
        $value_vars .= "'" . $valor . "', ";
        $name_vars .= $clave .", ";
        $pares .= $clave ." = '". $valor ."', ";

    }
    $name_vars=trim($name_vars, ", ");
    $value_vars=trim($value_vars, ", ");
    $pares = trim($pares, ", ");


    if (isset($clavelist)) {
        return array("action"=>"insert", "error"=>$clavelist);
    }
    else {
        if (!$id) {
            $wpdb->query("INSERT INTO $tabla ($name_vars) values ($value_vars)");
            return array("action"=>"insert");
        }
        else {
            $wpdb->query("UPDATE $tabla SET $pares WHERE user_id = $id");
            return array("action"=>"update");
        }

    }
}
function save_alarm() {
    $hyd = split('_',$_GET[hyd]);
    $_GET[hora] = $hyd[0];
    $_GET[dia] = $hyd[1];
    $canal = split('_',$_GET[canal]);
    $_GET[canal]=$canal[1];
    unset($_GET[hyd]);
    unset($_GET[push]);
    $saved = save_data($_GET, 'wp_alarmas');

}


function ads() {
    return ' <script type="text/javascript"> GA_googleFillSlot("VTR_TELEVISION_ABROBA_300x250");</script>';
}

if ( !function_exists('add_js') ) {
	function add_js() {
		echo '<script type="text/javascript" src="/wp-content/themes/televisionvtr/ajax/ajax-admin.js"></script>';
		echo '<link rel="stylesheet" type="text/css" src="/wp-content/themes/televisionvtr/css/css-admin.css" />';
	}
}
function get_the_avatar($size=40) {
    global $user_data;

    $str = $user_data[avatar];
    $pattern = '([^\s]+(?=\.(jpg|gif|png)))';
    $avatar = preg_match($pattern, $str);

    if ($user_data[avatar] && $avatar>0) {
        return '<img  width="'.$size.'" class="avatar" src="'.$user_data[avatar].'" alt="avatar de '.$user_data[nombre].'"/>';
    }else {
        return '<img width="'.$size.'" src="/wp-content/themes/somosblogs/img/general/avatar-generic.jpg" alt="Avatar genérico para '.$user_data[nombre].'" />';
    }
}
function the_avatar($size=40) {
    global $user_data;
    echo get_the_avatar($size);
}

function sb_avatar($user_id, $size=40) {
    global $wpdb;

    $avatar = $wpdb->get_var("SELECT avatar FROM wp_somosblog WHERE user_id = $user_id");
    $user_nicename = $wpdb->get_var("SELECT user_nicename FROM wp_users WHERE ID = $user_id");

    if ($avatar) {
        return '<img  width="'.$size.'" class="avatar" src="'.$avatar.'" alt="avatar de '.$user_nicename.'"/>';
    }else {
        return '<img width="'.$size.'" src="/wp-content/themes/somosblogs/img/general/avatar-generic.jpg" alt="Avatar genérico para '.$user_nicename.'" />';
    }


}

/* Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'myplugin_add_custom_box');

/* Use the save_post action to do something with the data entered */
add_action('save_post', 'myplugin_save_postdata');

/* Adds a custom section to the "advanced" Post and Page edit screens */
function myplugin_add_custom_box() {

  if( function_exists( 'add_meta_box' )) {
    add_meta_box( 'myplugin_sectionid', __( 'Orden', 'myplugin_textdomain' ),
                'myplugin_inner_custom_box', 'post', 'advanced' );
    add_meta_box( 'myplugin_sectionid', __( 'Orden', 'myplugin_textdomain' ),
                'myplugin_inner_custom_box', 'page', 'advanced' );
   } else {
    add_action('dbx_post_advanced', 'myplugin_old_custom_box' );
    add_action('dbx_page_advanced', 'myplugin_old_custom_box' );
  }
}

/* Prints the inner fields for the custom post/page section */
function myplugin_inner_custom_box() {

  // Use nonce for verification

  echo '<input type="hidden" name="myplugin_noncename" id="myplugin_noncename" value="' .
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

  // The actual fields for data entry

  echo '<label for="myplugin_new_field">' . __("Orden destacado", 'myplugin_textdomain' ) . '</label> ';
  echo '<input type="text" value="0" id="menu_order" size="4" name="menu_order">';
}

/* Prints the edit form for pre-WordPress 2.5 post/page */
function myplugin_old_custom_box() {

  echo '<div class="dbx-b-ox-wrapper">' . "\n";
  echo '<fieldset id="myplugin_fieldsetid" class="dbx-box">' . "\n";
  echo '<div class="dbx-h-andle-wrapper"><h3 class="dbx-handle">' .
        __( 'My Post Section Title', 'myplugin_textdomain' ) . "</h3></div>";

  echo '<div class="dbx-c-ontent-wrapper"><div class="dbx-content">';

  // output editing form

  myplugin_inner_custom_box();

  // end wrapper

  echo "</div></div></fieldset></div>\n";
}

/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return $post_id;


  // Check permissions
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data

  $mydata = $_POST['menu_order'];

  // Do something with $mydata
  // probably using add_post_meta(), update_post_meta(), or
  // a custom table (see Further Reading section below)

   return $mydata;
}


add_action('admin_head', 'add_js');
//GETS
if ($_GET['obt'] == 'comuna') {print json_encode(comunas($_GET['comuna']));exit;}
if ($_GET['obt'] == 'uid') {if( usuario() != 0) {print json_encode(array("uid"=>usuario()));}else {print json_encode(array("login"=>true));}exit;}
if ($_GET['push'] == 'alarma') {save_alarm();exit;}
?>
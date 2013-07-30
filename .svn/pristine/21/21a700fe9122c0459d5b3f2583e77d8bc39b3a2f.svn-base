<?php
if( function_exists('w3tc_objectcache_flush') ) w3tc_objectcache_flush();

$mobile_query = $_GET;
$grill = new getgrill($mobile_query, $programID);
unset($mobile_query);

if ($_GET["search"]) {
    exit;
}
?>
<?php
/*
  Template Name: mobile
 */
?><!DOCTYPE html>
<html lang="es" >
    <head>

        <meta charset = "UTF-8">
        <title>Guía TV VTR</title>
        <meta name="viewport" content="width=device-width; initial-scale=1; maximum-scale=1; user-scalable=0;"/>
        <meta http-equiv='cache-control' content='no-cache'>
        <meta http-equiv='expires' content='0'>
        <meta http-equiv='pragma' content='no-cache'>
        
        <link rel="apple-touch-icon" href="<?php bloginfo('template_url') ?>/touch-icon-iphone.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_url') ?>/touch-icon-ipad.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_url') ?>/touch-icon-iphone-retina.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_url') ?>/touch-icon-ipad-retina.png" />
        
        
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/mobile-grid.css" />        
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/mobile-reset.css" />                
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/mobile.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>


        <script src="<?php bloginfo('template_url') ?>/js/mobile.js"></script>
        <script src="<?php bloginfo('template_url') ?>/js/modernizr.js"></script>
       
        <?php wp_head() ?>

    </head>
    <body>


        <div class="wrap">
            <header>
                <div id="itemsConfig">
                    <a id="logoGuia" href="" title="Inicio"><img class="header-logo-guia" src="<?php bloginfo('template_directory'); ?>/img/mobile/guia_tv_logo.jpg" alt="VTR Mobile" title="GuíaTV" /></a>
                    <ul class="configMenu">
                        <li><a class="evt searchBtn" href="#" title="Buscar" data-func="showSearch">Buscar</a></li>
                        <li><a href="#" class="evt ajustes" data-func="loadPreferencias">Preferencias</a></li>
                    </ul>
                </div>
                <div id="nav">
                    <ul>
                        <li><a href="#"  class="active evt"  data-func="menu"  data-page="1">Destacados</a></li>
                        <li><a href="#" class="evt" data-func="menu" data-page="2">Categorías</a></li>

                    </ul>
                </div>
            </header>
            <div id="searchHeader">
                    <ul id="search" class="listin">
                        <li class="search"><input type="search" class="searchForm" value="" placeholder="Ingrese programa"> </li>
                    </ul>
                    <a class="evt searchCancel" data-func="hideSearch">Cancelar</a> 
            </div>
            <div class="content flexslider">
                <ul id="infoDragg" class="slides">

                </ul> 
                
                <div id="channelLoad">
                </div>
                <div id="programLoad">    
                </div>
                <div id="contentLoad">
                </div>
                <img class="ajaxloader" src="<?php bloginfo('template_directory'); ?>/img/mobile/ajax-loader.gif" />
            </div>
            <div id="firstLoad">
                    <img class="firstLoadimg" src="<?php bloginfo('template_directory'); ?>/img/mobile/guiatv-firstload.jpg" alt="VTR Mobile" title="GuíaTV" />
            </div>
        </div>    
    </body>
</html>

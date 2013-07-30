<?php
/*
  Template Name: tablet
 */
?>
<?php $grill = new tabgrill(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Guía TV VTR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <link rel="apple-touch-icon" href="<?php bloginfo('template_url') ?>/touch-icon-iphone.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_url') ?>/touch-icon-ipad.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_url') ?>/touch-icon-iphone-retina.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_url') ?>/touch-icon-ipad-retina.png" />
             
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/1140.css" />
        <link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/tablet.css" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>

        <script src="<?php bloginfo('template_url') ?>/js/tablet.js"></script>
        <script src="<?php bloginfo('template_url') ?>/js/modernizr.js"></script>
        
        <?php wp_head() ?>

    </head>
    <body>
        <div class="container">
<!--------------------------------------------------------------------------------HEADER-->
            <header class="row">
                <div id="primaryHead">
                    <div class="logo">
                        <a href="<?php bloginfo('home') ?>/tablet"><img src="http://vtr.ida.cl/wp-content/themes/televisionvtr/img/tablet/logoTablet.jpg"/></a>
                    </div>
                    <ul>
                        <li class="searchButon">
                            <input id="buscador" type="text" placeholder="Ingrese nombre del programa" value="" />
                            <a id="search" href="#" class="evt" data-func="buscador">Buscar</a>
                        </li>
                        <li class="ajustes lista">
                            <a href="#" class="evt ajustesIcon" data-func="menuAjustes">Ajustes</a>
                            <ul class="ajustesList">
                                <li><a href="#" class="evt" data-func="loadUbicacion">Ubicación</a></li>
                                <li><a href="#" class="evt" data-func="loadCategorias">Categorías</a></li>
                            </ul>    
                        </li>
                    </ul>
                </div>
                <div id="nav">
                    <ul>
                        <li><a class="evt current" href="#" data-tab="1" data-func="tabChange">Destacados</a></li>
                        <li><a class="evt" href="#" data-tab="2" data-func="tabChange">Guía</a></li>
                        <li><a class="evt" href="#" data-tab="3" data-func="tabChange">Favoritos</a></li>
                    </ul>
                     <?php   $agent = $_SERVER['HTTP_USER_AGENT']; 
                            if(preg_match('/iPad/i', $agent)){
                                if(get_field('_downloadLinkIpad','options')){
                                    echo '<a class="downloadApp" href="'. get_field('_linkDescargaIpad','options') .'" title="Descarga la aplicación para tu dispositivo">Descargar Aplicación</a>';
                                }else{
                                    echo '<a class="downloadApp evt" data-func="linkMensaje" data-mensaje="'.get_field('_mensajeIpad','options').'" href="'. get_field('_linkDescargaIpad','options') .'" title="Descarga la aplicación para tu dispositivo">Descargar Aplicación</a>';
                                }
                                
                            }elseif(preg_match('/Android/i', $agent)){
                                if(get_field('_downloadLinkAndroid','options') == true){
                                    echo '<a class="downloadApp" href="'. get_field('_linkDescargaAndroid','options') .'" title="Descarga la aplicación para tu dispositivo">Descargar Aplicación</a>';
                                }else{
                                    echo '<a class="downloadApp evt" data-func="linkMensaje" data-mensaje="'.get_field('_mensajeAndroid','options').'" href="'. get_field('_linkDescargaAndroid','options') .'" title="Descarga la aplicación para tu dispositivo">Descargar Aplicación</a>';
                                }
                            }?>
                </div>
            </header>
<!--------------------------------------------------------------------------------FIN HEADER-->
<!--------------------------------------------------------------------------------CONTENIDO-->
            <section id="mainCont">
                <ul id="tabs">

                    <li class="tab row" data-tab="1"> 

                    </li>  
                    <li class="tab row" data-tab="2"> 

                    </li>
                    <li class="tab row" data-tab="3">   

                    </li>
                </ul>
                
                <!--------------------------------------------------------------------------------LIGHTBOX-->
                <div class="blocker evt" data-func="searchClose">
                </div>

                
                <img class="ajaxLoader" src="<?php bloginfo('template_url') ?>/img/tablet/ajax-loader.gif" />

                <!--------------------------------------------------------------------------------RESULTADOS DE BUSQUEDA-->
                    <div class="searchContent lista">
                        <div class="innerSearch">
                            
                        </div>
                        <a class="closeFicha newEvt" data-func="cerrarFicha">Cerrar</a>
                    </div>
                    
                <!--------------------------------------------------------------------------------FICHA-->
                <div id="callFicha">

                </div>
                <!--------------------------------------------------------------------------------FIN RESULTADOS DE BUSQUEDA-->
                <!--------------------------------------------------------------------------------SPASH----------------------->
               
            </section>
            
        </div> 
        <div id="splash">
                <img src="http://vtr.ida.cl/wp-content/themes/televisionvtr/img/tablet/splash.jpg"/>
                <img src="http://vtr.ida.cl/wp-content/themes/televisionvtr/img/tablet/ajax-loader.gif"/>
        </div>
        <!--------------------------------------------------------------------------------FIN CONTENIDO PRINCIPAL-->   
    </body>
</html>

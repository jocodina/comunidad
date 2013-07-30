<!doctype html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7" lang="en"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> 
<html class="no-js" lang="es"> <!--<![endif]-->
<head><?php global $ida; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" >
    
    <title><?php $ida->getTitleTag(); ?></title>
    <meta name="Author" content="Fenando Silva">
    <meta name="Description" content="<?php $ida->getDescriptionTag(); ?>">
    <meta property="og:title" content="<?php $ida->getTitleTag(); ?>" >
    <meta property="og:url" content="<?php echo 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>" >
    <meta property="og:description" content="<?php $ida->getDescriptionTag(); ?>" >
    <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" >

    <link rel="shortcut icon" href="<?php bloginfo("template_directory"); ?>/favicon.png" />
    
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/normalize.css" type="text/css" media="screen, projection" />
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/grid.css" type="text/css" media="screen, projection" />
    <link id="reload" rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/screen.css" type="text/css" media="screen, projection" />
    <?php if(is_page('guia-tv') || is_page('grilla-de-canales-por-ciudad')){ ?>
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/program.css" type="text/css" media="screen, projection" />
    <?php }?>  
    <!-- <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/screen.less"> -->
    <!--[if lt IE 9]>
    <link rel="stylesheet/less" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/ie.css">
    <![endif]-->    

    <?php if(!get_option("header_css")){ update_option("header_css", "http://vtr.com/header2011-chico/css/header-late2011-small.css");} ?>   
    <?php if(!get_option("footer_css")){ update_option("footer_css", "http://vtr.com/footer2011/css/estilos_footer2011_ngro.css");} ?>  
    <?php if(!get_option("footerchico_css")){ update_option("footerchico_css", "http://vtr.com/footer2011-chico/css/footer2011_ngro_chico.css");} ?>  
    <!-- header css -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_option("header_css") ?>" />
    <!-- footer css -->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_option("footer_css") ?>" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_option("footerchico_css") ?>" />
    
   <?php wp_head(); ?>
   <?php if(is_page('vod')){ ?>
        <script src="http://vtr.com/vod/flajax/swfobject.js" type="text/javascript"></script>  
        <script type="text/javascript" src="http://takeout.dmmotion.com/commons/admplayer_uncompressed.js"></script> 
        <script src="<?php bloginfo('template_directory'); ?>/js/admplayer.js"></script>

        <link rel="stylesheet" href="http://vtr.com/vod/css/splide.css">
        <script src="<?php bloginfo('template_directory'); ?>/js/splide.js"></script>
        
    <?php }?> 

    <!--[if lte IE 8]>
        <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/selectivizr-min.js"></script>
    <![endif]--> 
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/modernizr.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/script.js"></script>
   

    <!--<script src="<?php bloginfo('template_directory'); ?>/js/modernizr.js"></script>-->
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
    <!--<script src="<?php bloginfo('template_directory'); ?>/js/script.js"></script>-->
    
   <?php if(is_page('guia-tv') || is_page('grilla-de-canales-por-ciudad')){ ?>
        <script src="<?php bloginfo('template_directory'); ?>/js/ajax-prog.js"></script>
   <?php }?>  
    
    <!-- Header VTR: JS -->
    <script type="text/javascript" src=" http://vtr.com/header2011-chico/js/header-footer-chico.js"></script>
    
    <script src="<?php bloginfo('template_directory'); ?>/js/timeline.js"></script>
    
</head>
<body <?php body_class(); ?>>
<div id="fb-root"></div>

    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=291578820916259";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    
    <?php if(!get_option("header_html")){ update_option("header_html", "http://vtr.com/header2011-chico/");} ?>   
    <?php echo get_external_html(get_option('header_html'),"header2011");?>  
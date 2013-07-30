<?php get_header(); ?>	
<div id="main" class="container_12">
    <?php /* destacados */ ?>           
    <div id="destacados">
        <?php /* Controlador de pestanas */ ?>           
        <div class="tabs">
            <ul>
                <li class="tabGO"><a class="evt" href="#" data-func="pestaDest" data-tab="tabGO">GO</a></li>
                <li class="tabVOD"><a class="evt" href="#" data-func="pestaDest" data-tab="tabVOD">VOD</a></li>
                <li class="tabTV active"><a class="evt" href="#" data-func="pestaDest" data-tab="tabTV">GuíaTV</a></li>
            </ul>
        </div>    
        <?php /* Pestana de GO VTR */ ?>           
        <div class="destacadostabs" style="display:none"  data-tab="tabGO">
            <ul class="slide">
                <?php /* incluye la imagen y descripcion sobre ella */ ?>   
                <?php echo loop_destacados_goVTR('slide'); ?>   
            </ul>    
            <ul  class="control">
                <?php /* incluye el controlador lateral ul */ ?>   
                <?php echo loop_destacados_goVTR('control'); ?>
            </ul>															
        </div>
        <?php /* Pestana de VOD */ ?>           
        <div class="destacadostabs" style="display:none" data-tab="tabVOD">
            <ul class="slide">
                <?php echo loop_destacados(array('post_type' => 'fichas-vod'), 'slide'); ?>   
            </ul>    
            <ul class="control">
                <?php echo loop_destacados(array('post_type' => 'fichas-vod'), 'control'); ?>
            </ul>															
        </div>
        <?php /* Pestana de TV */ ?>           
        <div class="destacadostabs" data-tab="tabTV">
            <ul class="slide">
                <?php echo loop_destacados(array('post_type' => 'post'), 'slide'); ?>   
            </ul>    
            <ul  class="control">
                <?php echo loop_destacados(array('post_type' => 'post'), 'control'); ?>
            </ul>

        </div>
    </div>			
    <?php /* seccion principal content */ ?>               
    <div id="content" class="grid_8 alpha">
        <?php /* HOY en VTR @todo corregir h1 & style */ ?>               
        <div id="vtr_hoy" class="vtrtoday widget clearfix">				
            <h1 class="widget-title">Hoy en VTR <span><a href="<?php echo get_permalink(49494) ?>">Ver Guía de Programación</a> »</span></h1>			
            <?php echo hoyenvtr(); ?>										
        </div>
        <?php /* LO + de la semana @todo corregir h1 & style */ ?>                       
        <div id="widget_lo_mas_vtr" class="widget clearfix">
            <h1 class="widget-title">Lo + VTR de la Semana</h1>
            <div class="grid_4 alpha">
                <ul class="tabs clearfix">
                    <li class="active"><a href="#lo-mas-compartido"  data-tab="shared" class="evt " data-func="tabmost">Lo + Compartido</a></li>
                    <li><a href="#lo-mas-comentado"  data-tab="commented"  class="evt"  data-func="tabmost">Lo + Comentado</a></li>
                </ul>
                <div class="tab_container">
                    <div id="lo-mas-compartido" class="tab_content" data-tab="shared" >
                        <p><?php echo strftime("%d de %B"); ?></p>
                        <ul>
                            <?php echo mostshared(array('post_type' => array("post", "fichas-vod"), 'items' => 4, 'order' => 'DESC', 'orderby' => 'meta_value_num', 'meta_key' => '_sharedTotal', 'quiero' => 'shared')); ?>
                        </ul>

                    </div>
                    <div id="lo-mas-comentado" class="tab_content" data-tab="commented" style="display:none">
                        <p><?php echo strftime("%d de %B"); ?></p>
                        <ul>
                            <?php echo mostshared(array('items' => 4, 'order' => "DESC", 'orderby' => "comment_count", 'quiero' => 'commented')); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php /* @todo corregir h1 & style */ ?>               
            <div id="lo-mas-visto" class="grid_4 omega">
                <h1>Lo + Visto</h1>
                <ul id="lo-mas-visto-list">
                    <?php echo lo_mas_visto(); ?>
                </ul>	
                <?php setlocale(LC_ALL,"es_ES"); ?>
                <p>Semana del <?php echo strftime("%d de %B"); ?></p>
                <p>Fuente: Time Ibope - Rating Hogares con cable último mes</p>
            </div>
        </div>
        <div class="widget clearfix">        
            <?php /* Noticias @todo corregir h1 & style & link x algo dinamico */ ?>               
            <div id="widget_noticias" class="grid_4 clearfix widget_half alpha">
                <h1 class="widget-title">Noticias <span><a href="<?php echo get_permalink(49496) ?>">Ver todas »</a></span></h1>
                <?php echo blockNews(array('post_type' => 'entradas', 'items' => '1', 'order' => 'DESC', 'orderby' => 'post_date', 'taxonomy' => 'categoria-entradas', 'field' => 'slug', "terms" => "noticias-y-entrevistas")); ?>
            </div> 
            <?php /* Noticias @todo corregir h1 & style & link x algo dinamico */ ?>               
            <div id="widget_opinion_top_10" class="grid_4 clearfix widget_half omega">
                <h1 class="widget-title">Opinion y Top 10 <span><a href="<?php echo get_permalink(49498) ?>">Ver todas »</a></span></h1>
                <?php echo blockNews(array('post_type' => 'entradas', 'items' => '1', 'order' => 'DESC', 'orderby' => 'post_date', 'taxonomy' => 'categoria-entradas', 'field' => 'slug', "terms" => "opinion-y-top-10")); ?>
            </div> 
        </div> 
    </div>
    <?php get_sidebar() ?>
</div>
<? get_footer(); ?>
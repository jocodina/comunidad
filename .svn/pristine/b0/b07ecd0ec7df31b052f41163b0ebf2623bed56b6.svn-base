<?php
/*
Template Name: Entradas
*/
?>
<?php get_header(); ?>
<div id="main" class="container_12">			
    <div id="content" class="grid_8 alpha">
        <div class="page">
            <?php echo $ida->breadcrumb(); ?>
            <?php 
                $pagenum = get_query_var('paged');
                $items = 10;
            ?>
            <hgroup><h1 class="page-title">Lo Más Reciente</h1></hgroup>
            <div id="page-noticias-y-entrevistas" class="page-content">
                <?php $args = array('post_type' => 'entradas', 'posts_per_page' => 3, 'taxonomy' => 'categoria-entradas', 'term' => get_query_var('pagename'), 'type' => 'destacados' ) ?>
                <?php 
                if($pagenum == 0){
                    $items = 4
                ?>
                <div class="page-thirds clearfix">
                    <?php echo getBlockEntradas($args) ?>
                </div>
                <?php }else{ ?>
                    <?php getBlockEntradas($args) ?>
                <?php } ?>
                <?php echo getBlockEntradas(array('post_type' => 'entradas', 'posts_per_page' => $items, 'taxonomy' => 'categoria-entradas', 'term' => get_query_var('pagename'), 'post_not_in' => $notpost, 'pagination' => true) ) ?>
            </div>
        </div>					
    </div>
    <?php get_sidebar()?>
</div>
<?php get_footer(); ?>
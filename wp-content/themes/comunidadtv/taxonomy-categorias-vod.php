<?php get_header(); ?>
<div id="main" class="container_12 vod-categoria vod">
    <div class="bar-sup"></div>	
    <img src="<?php echo get_bloginfo('template_url') ?>/images/portada-categoria.png" alt="VOD Canal 900" /> 
    <div class="bar-inf"></div>
    <div class="grid_12">
        <a class="editor-send" href="mailto:<?php echo get_field('mail_editor', 'options') ?>"><img src="<?php echo get_bloginfo('template_url') ?>/images/vod/btn-mail.png" alt=""></a>
    </div>
    <div class="grid_4 alpha menu">
        <?php echo getChildTerms() ?>	
    </div>
    <div class="grid_8 omega breadcumb-wrapp">
        <?php 
        $category = get_query_var('categorias-vod');
        echo breadcrumbVOD($category); 
        ?>
    </div>
    <div class="grid_8 alpha vod-contenido">
        <?php if( $category == 'pagados' || $category == 'adultos' || $category == 'gratis' || $category == 'premium' ){ ?>
                    <?php echo getCategoryVOD(get_query_var('categorias-vod')) ?>
        <?php }else{ ?>
                    <?php echo getBlockProgram(array('post_type' => 'fichas-vod', 'posts_per_page' => 12, 'taxonomy' => 'categorias-vod', 'term' => $category, 'pagination' => true)); ?>
        <?php } ?>
    </div>    
</div>
<?php get_footer(); ?>
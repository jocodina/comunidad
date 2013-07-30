<?php get_header(); ?>
<div id="main" class="container_12">			
    <div id="content" class="grid_8 alpha">
        <div class="page">
            <?php echo $ida->breadcrumb(); ?>
            <hgroup><h1 class="page-title"><?php echo get_query_var('category_name') ?></h1></hgroup>
            <div id="page-noticias-y-entrevistas" class="page-content">
                <?php if(have_posts()){
                        while(have_posts()) { the_post(); ?>
                            <div class="item-row clearfix">
                                <div class="grid_3 alpha">
                                    <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="contents"><?php echo get_the_post_thumbnail($post->ID, 'destacado-entrada') ?></a>
                                </div>
                                <div class="grid_5 omega">
                                    <hgroup><h1><a href="<?php the_permalink() ?>" title="<?php the_title() ?>" rel="contents"><?php the_title() ?></a></h1></hgroup>
                                    <?php $content = get_the_content() ? $ida->cortar(get_the_content(), 300) : $ida->cortar(get_field('ficha_abstract', $post->ID), 300); ?>
                                    <p><?php echo $content ?></p>
                                    <a href="<?php the_permalink() ?>" class="read-more">[leer más+]</a>
                                </div>
                            </div>
                <?php }
                } ?>
                <div class="pagination center"><?php echo pagination('Anterior', 'Siguiente') ?></div>
            </div>
        </div>					
    </div>
    <?php get_sidebar()?>
</div>
<?php get_footer(); ?>
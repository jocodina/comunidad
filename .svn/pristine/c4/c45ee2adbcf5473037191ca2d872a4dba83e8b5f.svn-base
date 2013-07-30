<?php get_header(); ?>
<div id="main" class="container_12">			
    <div id="content" class="grid_8 alpha">
        <div class="page">
            <?php echo $ida->breadcrumb(); ?>
            <?php $term =  get_term_by('slug', get_query_var('tags-entradas'), 'tags-entradas') ?>
            <hgroup><h1 class="page-title"><?php echo $term->name ?></h1></hgroup>
            <div id="page-noticias-y-entrevistas" class="page-content">
                <?php echo getBlockEntradas(array('post_type' => 'entradas', 'posts_per_page' => 10, 'taxonomy' => 'tags-entradas', 'term' => get_query_var('tags-entradas'), 'pagination' => true, 'paged' => get_query_var('page') ? get_query_var('page') : get_query_var('paged')) ) ?>
            </div>
        </div>					
    </div>
    <?php get_sidebar()?>
</div>
<?php get_footer(); ?>
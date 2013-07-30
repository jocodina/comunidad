<?php get_header(); ?>
<div id="main" class="container_12">			
    <div id="content" class="grid_8 alpha">
        <div class="page">
            <?php if($wp_query->found_posts > 0) {
                      $title = '<hgroup><h1 class="page-title">Resultados de búsqueda</h1></hgroup>';
//                      $title .= '<span class="description">Se encontraron '. $wp_query->found_posts .' coincidencias con  "<strong>'.get_query_var('s').'</strong>"</span>';
                  }else{
                      $title = '<h2>No se han encontrado resultados de búsqueda para "'.get_query_var('s').'".</h2>';
                  } ?>
            <?php echo $ida->breadcrumb(); ?>
            <?php echo $title ?>
            <div id="page-noticias-y-entrevistas" class="page-content">
                <aside class="searchFilters grid_2 alpha">
                    <button class="active evt" data-func="ajaxFilter" data-ptype="post" data-search="<?php echo $_GET['s'] ?>">Programación</button>
                    <button class="evt" data-func="ajaxFilter" data-ptype="fichas-vod" data-search="<?php echo $_GET['s'] ?>">Programación VOD</button>
                    <button class="evt" data-func="ajaxFilter" data-ptype="entradas" data-taxonomy="categoria-entradas" data-term="noticias-y-entrevistas" data-search="<?php echo $_GET['s'] ?>">Noticias y Entrevistas</button>
                    <button class="evt" data-func="ajaxFilter" data-ptype="entradas" data-taxonomy="categoria-entradas" data-term="opinion-y-top-10" data-search="<?php echo $_GET['s'] ?>">Opinión y Top 10</button>
                </aside>
                <div class="result grid_6 omega">
                    <?php echo searchQuery(array('post_type' => 'post' , 'pagination' => true)); ?>
                </div>
            </div>
        </div>					
    </div>
    <?php get_sidebar()?>
</div>
<?php get_footer(); ?>
<?php get_header(); ?>
<div id="main" class="container_12">			
    <div id="content" class="grid_8 alpha">
        <div class="page">
            <?php echo $ida->breadcrumb(); ?>
            <hr>
            <div id="page-noticias-detalle" class="page-content">
                <article>
                    <div class="grid_8 alpha">	
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <hgroup><h1><?php the_title() ?></h1></hgroup>
                        <?php echo $avatar = get_avatar(get_the_author_ID(), 32); ?>
                        <?php $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'); ?>
                        <small>Publicado el <?php echo the_date('d') ?> de <?php echo $meses[date('n') - 1] ?> por <span><?php echo get_the_author() ?></span></small><br>
                        <?php 
                            $tags = wp_get_post_terms( $post->ID, 'tags-entradas' ); 
                            foreach($tags as $tag){
                                $tag_link = get_term_link( $tag, 'tags-entradas' );
                                $array[] = '<a href="'.$tag_link .'" title="ir a archivo de '. $tag->name .'" rel="contents"><small>'. $tag->name .'</small></a>';
                            }

                        ?>
                        <?php if($array){ ?>
                            <small> Tags: <span><?php echo implode(', ', $array) ?></span> </small>
                        <?php } ?>
                    </div>
                    <?php if(get_field('bajada_entrada', $dest->post->ID)){ ?>
                        <div class="grid_4 alpha noticas-detalle-descripcion">
                            <p class="bajada"><?php echo get_field('bajada_entrada', $dest->post->ID) ?></p>
                            <div>
                                <?php the_content() ?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="grid_4 omega noticas-detalle-portada">
                        <?php the_post_thumbnail('banner-vod') ?>
                        <div class="noticias-detalle-galeria">
                            <?php echo getGalleryFicha() ?>
                        </div>
                    </div>
                </article>
                <div class="grid_8 alpha redes-sociales">
                        <script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script>
                        <fb:like href="<?php the_permalink();?>" layout='box_count' send='false' show_faces='false' width="70px" font="arial" action="like" colorscheme="light"></fb:like>

                        <a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical" data-via="WebmasterCV" data-lang="es" data-related="WebmasterCV">Twittear</a>
                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                        <script type="text/javascript" src="http://apis.google.com/js/plusone.js"> {lang: 'es'}</script><script type="text/javascript">
                        //<![CDATA[
                        document.write('<g:plusone size="tall"></g:plusone>');
                        //]]>
                        </script>												
                </div>
                <div id ="comment" class="comentario">
                    <?php comments_template(); ?>                    
                </div> 


                <?php endwhile; 
                      endif; ?>
            </div>
        </div>
    </div>
    <?php get_sidebar()?>
</div>
</div>
<?php get_footer(); ?>

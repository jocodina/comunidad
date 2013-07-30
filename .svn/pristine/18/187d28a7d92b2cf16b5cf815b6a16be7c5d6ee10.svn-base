<?php get_header(); ?>
<div id="main" class="container_12 vod-categoria vod">
    <div class="bar-sup"></div>	
    <img src="<?php echo get_bloginfo('template_url') ?>/images/portada-categoria.png" alt="VOD Canal 900" /> 
    <div class="bar-inf"></div>
    <div class="grid_4 alpha menu">
        <?php echo getChildTerms() ?>	
    </div>
    <div class="grid_8 omega">
        <?php echo breadcrumbVOD(); ?>
        <div class="vod-contenido">
            <div class="ficha">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="title"><?php the_title() ?></div>
                <?php
                    $quality = get_field('quality_vod', $post->ID);
                    echo $hdimage = in_array('HD', (array)$quality) ? '<img src="'. get_bloginfo('template_url') .'/images/vod/hd.png" alt="HD" class="icon">' : '';
                    echo $sdimage = in_array('SD', (array)$quality) ? '<img src="'. get_bloginfo('template_url') .'/images/vod/sd.png" alt="SD" class="icon">' : '';
                ?>
                <div class="contenido-ficha">
                    <div class="contenido-img">
                        <?php the_post_thumbnail('ficha-vod-single') ?>
                    </div>
                    <div class="info-detalle">
                        <?php echo get_field('ano_vod', $post->ID) ? 'Año: <small>'. get_field('ano_vod', $ficha->ID) .'</small>' : ''; ?>
                    </div>
                    <div class="info-detalle">
                        <?php echo get_field('duración_vod', $post->ID) ? 'Duración: <small>'. get_field('duración_vod', $ficha->ID) .'</small>' : ''; ?>
                    </div>
                    <div class="info-detalle">
                        <?php echo get_field('director_vod', $post->ID) ? 'Director: <small>'. get_field('director_vod', $ficha->ID) .'</small>' : ''; ?>
                    </div>
                    <div class="info-detalle">
                        <?php echo get_field('actores_vod', $post->ID) ? 'Actores: <small>'. get_field('actores_vod', $ficha->ID) .'</small>' : ''; ?>
                    </div>
                    <div class="info-detalle">
                        <?php echo get_field('disponibilidad_vod', $post->ID) ? 'Disponible hasta: <small>'. get_field('disponibilidad_vod', $ficha->ID) .'</small>' : ''; ?>
                    </div>
                    <div class="info-detalle">
                        Descripción: <small><?php echo get_field('ficha_abstract', $post->ID) ?></small>
                    </div>
                    <div class="info-detalle">
                        <?php
                            $terms = wp_get_post_terms( $post->ID, 'categorias-vod' );

                        ?>
                        Encuéntrala en: 
                        <?php foreach($terms as $term){
                            $term_link = get_term_link( $term, 'categorias-vod' );
                            $array[] = '<a href="'.$term_link .'" title="ir a categoría de '. $term->name .'" rel="contents"><small>'. $term->name .'</small></a>';
                         }
                         echo implode(', ', $array);
                         ?>
                    </div>
                    <?php if(get_field('video', $post->ID)) : ?>
                    <div id="video-container" style="margin-bottom:20px;">								
                        <?php echo $ida->get_the_embed(get_field('video', $post->ID), 'width="300" height="200"'); ?>									
                    </div>
                    <?php endif; ?>
                </div>
                <div class="fb-like" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                <div class="tw-like">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-via="comunidadtv" data-lang="es" data-hashtags="comunidadtv">Twittear</a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>									
                </div>
                <?php endwhile; 
                      endif; ?>
                <div class="vod-ranking">
                    <?php echo getRecomendados(); ?>
		</div>
                
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
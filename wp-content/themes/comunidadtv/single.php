<?php get_header(); ?>
	
    		<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
            <div class="container_12">
                <?php echo $ida->breadcrumb(); ?>
                <h1 class="ficha-title"><?php the_title(); ?></h2>
            </div>
			
        <div class="banner-programa-detalle">
            <div class="container_12">
                <div class="grid_8 alpha banner-content">
                    <?php the_post_thumbnail('single'); ?>
                </div>
                <div class="grid_4 horario_single banner-content">
                    <?php echo horarioSingle(); ?>
                </div>	
            </div>
        </div>
        <div id="page-programacion-detalle" class="container_12">
            <div class="grid_8 contenido-programacion-detalle">
	            	<h2>Descripción</h2>
                            <hr>
                            <?php
                                $pidsField = get_field('ProgramID', $post->ID);
                                $pidsArray = explode(',', $pidsField);

                                foreach ($pidsArray as $pidsList) {
                                    $pidsArrayToImplode[] = "'" . $pidsList . "'";
                                }
                                
                                $pids = implode(",", $pidsArrayToImplode);
                                $query = "SELECT MpaaRating FROM $wpdb_pr->prog WHERE ProgramID IN ($pids) LIMIT 1";
                                $calificacion = $wpdb_pr->get_var($query);
                            ?>
                            <?php
                            if(get_the_content()){
                                echo the_content(); 
                            }elseif(get_the_excerpt()){
                                echo '<p>'.get_the_excerpt().'</p>';
                            }else{
                                echo '<p>'.get_field('ficha_abstract', $post->ID).'</p>';
                            }
                            
                            ?>	
                            <div class="clearfix">						
	                            <div class="grid_4 alpha redes-sociales">
	                                <div class="fb-like" data-send="false" data-layout="box_count" data-width="60" data-show-faces="false"></div>
	                                <div class="tw-share">
	                                    <a href="https://twitter.com/share" data-count="vertical" class="twitter-share-button" data-via="VTRComunidad" data-width="60" data-lang="es" data-hashtags="VTRComunidad">Twittear</a>
	                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>									
	                                </div>		
	                                <div class="gplus-share">									
	                                    <div class="g-plusone" data-size="tall"></div>
	                                </div>					
	                            </div>
	                            <div class="grid_4 omega promo">
	                                <?php
                                        $banner = get_field('banner_link',$post->ID);
	                                if ($banner) {
	                                    echo '
                                            <a href="' . get_field('banner_url', $banner->ID) . '" title="ir a sitio externo" target="_blank" rel="external">
                                            '.  wp_get_attachment_image(get_field('banner_image', $banner->ID), 'banner-single' ).'
                                            </a>
                                            ';
	                                }
	                                ?>
	                            </div>
                            </div>
                            <!-- 1 -->	
                          <div class="info">
                            <h2>Información</h2>                                                            
                            <hr>	                            
                           <?php if (get_field('info_category',$post->ID)): ?>                             
                            <div class="info-detalle">
                                Calificación: <small><?php the_field("info_category") ?></small>
                            </div>
                           <?php elseif($calificacion): ?>
                            <div class="info-detalle">
                                Calificación: <small><?php echo $calificacion ?></small>
                            </div>
                           <?php endif; ?>
                           <?php if (get_field('categoria',$post->ID)): ?>                             
                            <div class="info-detalle">
                                Categoría: <small><?php the_field("categoria"); ?></small>
                            </div>
                           <?php endif; ?>                                
                           <?php if (get_field('info_director',$post->ID)): ?>                             
                            <div class="info-detalle">
                                Director:
                                <small><?php the_field("info_director"); ?></small>
                            </div>
                           <?php endif; ?>                                
                           <?php if (get_field('info_actores',$post->ID)): ?>                             
                            <div class="info-detalle">
                                Protagonistas:
                                <small><?php the_field("info_actores"); ?></small>
                            </div>
                           <?php endif; ?>                                
                           <?php if (get_field('yearmovie',$post->ID)): ?> 
                            <div class="info-detalle">
                                Año: <small><?php the_field("yearmovie"); ?></small>
                            </div>
                           <?php endif; ?>                                
                           <?php if (get_field('ficha_estado',$post->ID)): ?>                                 
                            <div class="info-detalle">
                                Estado: <small><?php the_field("ficha_estado"); ?></small>
                            </div>
                            <?php endif; ?>                             
                            <?php if (get_field('razones',$post->ID)  || get_post_meta( $post->ID, 'razon_1')): ?>   
                            <div class="razones-detalle">
                                <h2>Razones para ver este programa</h2>
                                <?php 
                                if (!get_field("razones")){
	                               for ($i = 1; $i <= 3; $i++) {
	                                	$razon = get_post_meta( $post->ID, 'razon_' . $i);
	                                		if ($razon) {
		                                			echo '<p>' . $razon[0] . '</p>';
		                                			}
		                                }	                                
                                }else{
                                
	                                the_field("razones"); 	                                
                                }
                                ?>
                            </div>
                            <?php endif; ?>                                                       
                           <?php if (get_field('masinfo_ficha',$post->ID)): ?>                            
                            <div class="razones-detalle">
                                <h2>Otra información relevante</h2>
                                <?php the_field('masinfo_ficha',$post->ID); ?>
                            </div> 
                            <?php endif; ?>                           
                        </div> 
                        
                        <div class="comentario">
                            <h2>Comentarios</h2>
                            <hr />
                            <?php comments_template(); ?>
                        </div>                              		
                                        
            </div>
            <div class="grid_4 contenido-programacion-detalle">
                       <div id="trailer">
                           <?php if(get_field('video',$post->ID)){ ?>
                            <h2>Video</h2>
                            <hr>
                            <?php if(get_field('video_title',$post->ID)){ ?>
                            <h2><?php get_field('video_title',$post->ID) ?></h2>
                            <?php } ?>
                            <?php echo $ida->get_the_embed(get_field('video',$post->ID)); ?>
                            <?php } ?>
                            	
                        </div>	
                        <div class=" detalle-galeria">
<!--                            <div class="grid_2 alpha">Galería de imágenes</div>
                            <?php
                            $attachments =  get_children("post_parent=" . $post->ID . "&post_type=attachment&post_mime_type=image&posts_per_page=6");
                            $count = count($attachments);
                            if ($count > 1) {
                                $count_text = "Imágenes";
                            } else {
                                $count_text = "Imagen";
                            }
                            ?>
                            <div class="grid_2 omega total-images">(<?php echo $count . ' ' . $count_text; ?>)</div>
                            <hr class="grid_4 alpha">
                            <ul class="ficha-imagenes">
                                <?php
                                foreach ($attachments as $imagen) {
                                    $full_img = wp_get_attachment_image_src($imagen->ID, "full");
                                    echo '<a href="' . $full_img[0] . '" class="fancybox"><li> ' . wp_get_attachment_image($imagen->ID, "thumbnail") . '	 </li></a>';
                                }
                                ?>
                            </ul>-->
                            <?php echo getGalleryFicha() ?>
                        </div>
                        
            </div>
								
            </div><!-- container_12 -->
    <?php endwhile; ?>
<?php else : ?>
<?php endif; ?>
</div><!-- #main  -->
<? get_footer(); ?>

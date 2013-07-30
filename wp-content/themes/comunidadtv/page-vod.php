<?php
/*
Template Name: VOD Home
*/
?>
<?php get_header(); ?>
<script>
  $(document).ready(function() {
  	splide("#player","<?php echo get_bloginfo('template_url') ?>/data.php","images/vod.png");
    });              
</script>
<div id="main" class="container_12">		
    <div class="logo-vod">
        <img src="<?php echo get_bloginfo('template_url') ?>/images/logo_vod.png" alt="VTR On Demand" />
    </div>
    <div id="destacados_vod">
        <div id="player">
        </div>
        <div id="barker">
            <?php echo get_field('objectPromocional_vod', 'options') ?>
            <div id="jsapiplayer">
                <?php echo get_field('embedPromocional_vod', 'options') ?>
            </div>
      	</div> 
   </div>
   <div class="content-vod">
        <div class="canales-on-demand">
            CANALES<br>ON DEMAND<br>
        </div>
       <div class="vod-wrapper">
           <a class="evt left" data-func="movevod">Mover a la Derecha</a>
           <a class="evt right" data-func="movevod">Mover a la Derecha</a>
           <div class="canales-on-demand-img">
                <?php echo getCanalesVOD(); ?>
           </div>
       </div>
   </div>
   <div class="grid_8 alpha vod-contenido">
       <div class="vod-ranking">
           <?php echo getFeaturedVOD(get_field('titulocatFirst_vod', $post->ID), 'First'); ?>
       </div>
       <div class="vod-ranking">
           <?php echo getFeaturedVOD(get_field('titulocatSecond_vod', $post->ID), 'Second'); ?>
       </div>
       <div class="vod-ranking">
           <?php echo getFeaturedVOD(get_field('titulocatThird_vod', $post->ID), 'Third'); ?>
       </div>
       <div class="vod-ranking">
           <?php echo getFeaturedVOD(get_field('titulocatFourth_vod', $post->ID), 'Fourth'); ?>
       </div>

   </div>
   <div class="grid_4 omega slide-publicidad">
       <?php echo getBanner('First'); ?>
       <?php echo getBanner('Second'); ?>
       <div class="lo-mas-visto">
           <?php echo lomasvistoVOD(); ?>				
       </div>
       <?php echo getTwitterBox() ?>
   </div>
    <div class="grid_12 alpha">
        <div class="line"></div>
        <div class="premium">
            <hgroup><h1>Premium</h1></hgroup><br>
            <?php echo getPremiumProgram() ?>
        </div>
    </div>
    <div class="grid_12 alpha">
        <div class="publicidad">
            <a href="<?php echo get_field('bannerFooterUrl', 'options') ?>" title="Ir a url externa" rel="nofollow"><?php echo wp_get_attachment_image(get_field('bannerFooter', 'options'), 'banner-footer') ?></a>
        </div>
    </div>
</div>


<?php get_footer(); ?>

<?php require_once 'meta-header.php'; ?>
<header id="branding">
    <div id="header-container" class="container_12">
        <hgroup class="grid_4">
            <h1 id="site-title">
                <a href="/" title="Comunidad TV VTR" rel="home">guía tv vtr</a>
            </h1>
        </hgroup>
        <div id="search" class="push_5 grid_3 omega">
            <form action="<?php echo home_url() ?>" method="get">
                <input type="text" name="s" value="" placeholder="Buscar" />
<!--                <input type="hidden" name="post_type" value="post" />-->
            </form>			
        </div>
        <nav id="access">
            <?php wp_nav_menu( array(
                                    'menu' => 'Principal',
                                    'container' => '',
                                    'menu_class' => '',
                                    'items_wrap' => '<ul>%3$s</ul>',
           )); ?>			
        </nav>
        <aside>
            <span>Conéctate:</span>
            <ul>
                <li><a href='<?php echo get_field('facebook_comunidad', 'options') ?>' title="Ir al Facebook de VTR" rel="external"><img src="/wp-content/themes/comunidadtv/images/icon-facebook.png" alt="Visítanos en Twitter"></a></li>
                <li><a href="<?php echo get_field('twitter_comunidad', 'options') ?>" title="Ir al Twitter de VTR" rel="external"><img src="/wp-content/themes/comunidadtv/images/icon-google-plus.png" alt="Vísitanos en Google+"></a></li>
                <li><a href="<?php echo get_field('google_comunidad', 'options') ?>" title="Ir al Google Plus de VTR" rel="external"><img src="/wp-content/themes/comunidadtv/images/icon-twitter.png" alt="Síguenos en Twitter"></a></li>
            </ul>
        </aside>
    </div><!-- interno header -->
</header>
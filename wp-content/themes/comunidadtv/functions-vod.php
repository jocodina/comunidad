<?php

/* =============================================================================
   External Modules/Files
   ========================================================================== */

/* ============================================================================= 
   Theme Support
   ========================================================================== */
   
    add_image_size('mobileSearch', 30, 30, true); //imagen listas mobile
    add_image_size('mobileProgram', 48, 48, true); //imagen listas mobile
    add_image_size('fichaMobile', 620, 276, true); //imagen ficha single mobile
    add_image_size('destacadoMobilBig', 298, 170, true); // imagen destacado principal mobile grande
    add_image_size('destacadoMobilSmall', 144, 84, true); // imagen destacado principal mobile chica
    add_image_size('destacadoTablet', 450, 250, true); //destacado tablet, mismo tamaño para favoritos
    add_image_size('fichaTablet', 780, 300, true); //imagen ficha single tablet
    add_image_size('ficha-vod-small', 50, 50, true);
    add_image_size('banner-vod', 300, 250, true);
    add_image_size('logos-top-vod', 75, 40, true);
    add_image_size('banner-footer', 940, 130, true);    

    add_image_size('ficha-vod', 139, 196, true);
    add_image_size('ficha-vod-premium', 116, 164, true);
    add_image_size('ficha-vod-single', 182, 280, true);
    add_image_size('ficha-vod-small', 50, 50, true);
    add_image_size('banner-vod', 300, 250, true);
    add_image_size('logos-top-vod', 75, 40, true);
    add_image_size('banner-footer', 940, 130, true);
    add_image_size('galeria-thumb', 98, 66, true);
    add_image_size('programacion', 140, 100, true);
    add_image_size('wallpaper', 450, 600, true);
    add_image_size('banner-single', 300, 100, true);
    
    add_image_size('destacado-entrada', 195, 130, true);

/* =============================================================================
   Functions
   ========================================================================== */
function searchQuery($items){
    global $wpdb_pr, $ida;
    $out = "";
    
    extract(shortcode_atts(array(
                'post_type' => 'post',
                'posts_per_page' => 10,
                'post_status' => 'publish',
                'taxonomy' => false,
                'term' => false,
                'pagination' => false,
                'type' => false,
                'offset' => false,
                'paged' => false,
                'post_not_in' => false,
                'search' => $_GET['s']
                    ), $items));

    $args = array(
            'post_type' => $post_type,
            's' => $search,
            'posts_per_page' => $posts_per_page,
            'offset' => $offset,
    );
    $args['tax_query'] = $taxonomy && $term ? array(array('taxonomy' => $taxonomy, 'field' => 'slug', 'terms' => $term)) : false;
    $searchQuery = new WP_Query($args);
    
   if($searchQuery->have_posts()){
        while($searchQuery->have_posts()) { $searchQuery->the_post();
            $out .= '<div class="item-row clearfix">';
            $out .= '<div class="grid_2_search alpha">';
            $out .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'" rel="contents">'. get_the_post_thumbnail($searchQuery->post->ID, 'thumbnail') .'</a>';
            $out .= '</div>';
            $out .= '<div class="grid_4 omega">';  
            
            $pidsField = get_field('ProgramID', $item->ID);
            $pidsArray = explode(',', $pidsField);
            foreach ($pidsArray as $pidsList) {
                $pidsArrayToImplode[] = "'" . $pidsList . "'";
            }
            $pids = implode(",", $pidsArrayToImplode);
            $query = "SELECT ChannelID FROM $wpdb_pr->sch WHERE ProgramID IN ($pids) LIMIT 1";
            $channelID = $wpdb_pr->get_var($query);
            $channel = $post_type == 'post' ? '<span> | '. get_nombre_canal($channelID).'</span>' : '';
            $out .= '<hgroup><h1><a href="'. get_permalink() .'" title="'. get_the_title() .'" rel="contents">'. get_the_title().' '. $channel .'</a></h1></hgroup>';
            if(get_the_content()){
                $content = get_the_content(); 
            }elseif(get_the_excerpt()){
                $content = get_the_excerpt();
            }else{
                $content = get_field('ficha_abstract', $searchQuery->post->ID).'</p>';
            }
            $out .= '<p>'. $ida->cortar($content, 100) .'</p>';
            $out .= '<div class="sharers-box clearfix">';
            $out .= '<div class="fb-like" data-href="'. get_permalink() .'" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>';
            $out .= '<div class="tw-share"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'. get_permalink() .'" data-via="ComunidadTV" data-lang="es">Tweet</a>';
            $out .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
            $out .= '</div>';
            $out .= '</div>';
            $out .= '</div>';
            $out .= '</div>';
        }
   }
   if($searchQuery->have_posts()){ 
    $out .= $pagination && ($searchQuery->found_posts > 10) ? '<button class="pagination center evt" data-func="ajaxpagination" data-cat="'.$post_type.'" data-ajax="searchPagination" data-search="'.$search.'">Ver Siguientes 10</button>' : '';
   }
   
                            
    
    return $out;
}


function getCanalesVOD(){
    global $post;
    $out = "";
    
    foreach(get_field('canales_vod', 'options') as $item){
        $out .= wp_get_attachment_image($item['logo_canalvod'], 'logos-top-vod');
        
    }
    
    return $out;
}

function getFeaturedVOD($catname, $type){
    global $ida, $post;
    
    $out = "";
    $post_objects = get_field('postcat'.$type.'_vod', 'options');
    
    $term = get_term_by('name', $catname , 'categorias-vod');
    $term_link = get_term_link( $term, 'categorias-vod' );
  
    
    $out .= '<div class="vod-ranking">';
    $out .= '<a href="'. $term_link .'"><h1>'. $catname .' <span class="mas">Ver más +</span></h1></a>';
    foreach($post_objects as $ficha){
        
        $quality = get_field('quality_vod', $ficha->ID);
        $hdimage = in_array('HD', (array)$quality) ? '<img src="'. get_bloginfo('template_url') .'/images/vod/icono.png" alt="HD" class="icon">' : '';
        $sdimage = in_array('SD', (array)$quality) ? '<img src="'. get_bloginfo('template_url') .'/images/vod/iconosd.png" alt="SD" class="icon">' : '';
        
        $out .= '<div class="grid_2 alpha">';
        $out .= '<a href="'. get_permalink($ficha->ID) .'" class="stand" title="'. $ficha->post_title .'">'. get_the_post_thumbnail($ficha->ID, 'ficha-vod') .'</a>';
        $out .= '<div class="tooltip" style="position: absolute; top: 100px; left: 140.5px; opacity: 0; display: none;">';
        $out .= '<h1>'. $ficha->post_title .' '. $hdimage . $sdimage.'</h1>';
        $out .= get_field('ano_vod', $ficha->ID) ? '<div>Año: <small>'. get_field('ano_vod', $ficha->ID) .'</small></div>' : '';
        $out .= get_field('director_vod', $ficha->ID) ? '<div>Director: <small>'. get_field('director_vod', $ficha->ID) .'</small></div>' : '';
        $out .= '<div class="descripcion">';
        $out .= '<p>'. $ida->cortar(get_field('ficha_abstract', $ficha->ID), 200) .'</p>';
        $out .= '</div>';
        $out .= '</div>';						
        $out .= '<a href="'. get_permalink($ficha->ID) .'" title="'. $ficha->post_title .'" rel="contents">'. $ficha->post_title .'</a>';
        $out .= '</div>';
    }
    $out .= '</div>';
    
    return $out;
}

function getBanner($type){
    global $post;
    $out = "";
    
    foreach(get_field('banner'.$type.'Right_vod', 'options') as $item){
        $out .= wp_get_attachment_image($item['banner'.$type.'Right_vod'], 'banner-vod') != '' ? '<a href="'. $item['banner'. $type .'RightUrl_vod'] .'" title="'. $item['banner'. $type .'RightTitle_vod'] .'" rel="external" >'. wp_get_attachment_image($item['banner'.$type.'Right_vod'], 'banner-vod') .'</a>' : $item['banner'.$type.'RightFlash_vod'];
    }
    
    
    return $out;
}

function lomasvistoVOD(){
    global $post;
    
   $out = "";
   $i = 1;
   
   $out .= '<hgroup><h1>Lo Más Visto</h1></hgroup>';
   
   foreach(get_field('masvisto_vod', 'options') as $ficha){
           $out .= '<div class="ls-mas-visto">';
           $out .= '<div class="btn-numero">'. $i .'</div>';
           $out .= '<div class="avatar">'. get_the_post_thumbnail($ficha->ID, 'ficha-vod-small') .'</div>';
           $out .= '<div class="titulo"><a href="'. get_permalink($ficha->ID) .'" title="'. $ficha->post_title .'" rel="contents">'. $ficha->post_title .'</a></div>';
           $out .= '</div>';
           
           $i++;
   }
   
   
   return $out;
}

function getPremiumProgram() {
    $out = "";

    foreach(get_field('premiumVOD', 'options') as $item){
        $out .= '<div class="grid_4 alpha premium-block clearfix">';
        $out .= '<div class="premium-logo">';
        $out .= wp_get_attachment_image($item['logo_premium'], 'full');
        $out .= '</div> ';
        foreach($item['premium_ficha'] as $ficha){
            $out .= '<a href="'. get_permalink($ficha->ID).'" title="'. $ficha->post_title .'" rel="contents">'. get_the_post_thumbnail($ficha->ID, 'ficha-vod-premium') .'</a>';
        }
        $out .= '</div>';
    }
    
    
    return $out;
}


function add_body_class( $classes ) {
		global $post;
                
                if(($key = array_search('body', $classes)) !== false) {
                    unset($classes[$key]);
                }
                
		if((is_page('vod') || is_tax('categorias-vod') || is_singular('fichas-vod'))) {
                        $classes[] =  'body';
		}

		return $classes;
	}
        
function getTwitterBox(){
    global $post;
    $out = "";
    
    $out .= '<div id="widget_twitter" class="widget widget-tabbed">';
    $out .= '<ul class="tabs clearfix">';
    $out .= '<li class="active"><a href="#tab-comunidadtv" title="@VTRprogramacion" rel="nofollow" class="evt" data-func="changeTab" data-num="1">@VTRprogramacion</a></li>';
    $out .= '<li><a href="#tab-mas-famosos" title="Los màs Famosos" rel="nofollow" class="evt" data-func="changeTab" data-num="2">los + famosos</a></li>';
    $out .= '</ul>';
    $out .= '<div class="tab_container">';
    $out .= '<div id="tab-comunidadtv" class="tab_content" data-num="1">';
    $out .= '<ul id="tweets" class="clearfix" data-twitter="@vtrprogramacion">';								
    $out .= '</ul>';						
    $out .= '</div>';
    $out .= '<div id="tab-mas-famosos" class="tab_content" data-num="2" style="display:none">';
    $out .= '<ul id="mas-famosos" class="clearfix" data-twitter="'. get_field('mas_famosos', 'options') .'">'; //todo: cambiar custom field a options
    $out .= '</ul>';						 
    $out .= '</div>';
    $out .= '</div>';
    $out .= '<aside class="follow-us"><a href="'. get_field('twitter_comunidad', 'options') .'" title="Ir al Twitter de la comunidad" rel="external">¡Síguenos en twitter!</a></aside>';
    $out .= '</div>';
    
    return $out;
}

function getChildTerms(){
    global $wp_query, $post;
    
    $out = "";
    
    $terms = get_terms( 'categorias-vod', 'orderby=id&hide_empty=0&parent=0' );
    
    $out .= '<ul>';
    $out .= '<li><a href="'. home_url() .'/vod" title="Ir a la Portada de VOD" rel="home">Portada VOD</a></li>';
    
    if(get_query_var('categorias-vod')){
        $slug = get_query_var('categorias-vod');
    }else{
         $postterm = wp_get_post_terms( $post->ID, 'categorias-vod' );
         $slug = $postterm[0]->slug;
    }
    $termcompare = get_term_by('slug', $slug, 'categorias-vod');
    
    foreach($terms as $term){
        if(($termcompare->term_id == $term->term_id) || ($termcompare->parent == $term->term_id)){$active = 'active';}else{$active = '';}
        $out .= '<li class="dropdown '.$active.'">';
        $out .= '<a href="#" class="categoria-menu evt" data-func="ToggleVODmenu">'.  $term->name  .'</a>';
        $out .= getchildVOD($term->term_id);
        $out .= '</li>';
    }
    $out .= '</ul>';
    return $out;
}

function getchildVOD($parentid){
    global $wp_query;
    
    $terms = get_terms( 'categorias-vod', 'orderby=id&hide_empty=true&parent='. $parentid );
    $slug = get_query_var('categorias-vod');
    $termcompare = get_term_by('slug', $slug, 'categorias-vod');
    

    $out = "";
    if($terms){             
        $out .= '<ul class="sub-menu">';
        foreach($terms as $term){
            $term_link = get_term_link( $term, 'categorias-vod' );
            $out .= '<li><a href="'. $term_link  .'" title="'.  $term->name  .'" rel="section">'.  $term->name  .'</a></li>';
        }
        $out .= '</ul>';
    }
    
    return $out;
}

function breadcrumbVOD($category = false){
    global $post;
    $out = "";
    $separador = ' » '; 
    
    
    $out .= '<div class="font">';
    if(is_singular('fichas-vod')){
        $out .= 'VOD | ';
        $terms = wp_get_post_terms( $post->ID, 'categorias-vod' );
        
        foreach($terms as $term){
            if($term->parent){ $parentid = $term->parent;}
            $term_name = $term->name;
        }
        $termparent = get_term( $parentid, 'categorias-vod' );
        $term_link = get_term_link( $termparent, 'categorias-vod' );

        if($termparent->name){
            $out .= '<a href="'. $term_link .'" class="active">'.$termparent->name.'</a>';
            $out .= $separador;
        }
        $out .= '<span>'.$term_name.'</span>';
    }
    
    if(is_taxonomy('categorias-vod')){
        $term = get_term_by('slug', $category , 'categorias-vod');
        $termparent = get_term( $term->parent, 'categorias-vod' );
        $term_link = get_term_link( $termparent, 'categorias-vod' );
        if($termparent->name){
            $out .= '<a href="'. $term_link .'" class="active">'.$termparent->name.'</a>';
            $out .= $separador;
        }
        
        $out .= '<span>'.$term->name.'</span>';
        
    }
    
    $out .= '</div>';
    
    return $out;
}

function getRecomendados(){
    global $post;
    $out = "";
    $i = 0;
    $terms = wp_get_post_terms( $post->ID, 'categorias-vod' );
    
    $recomendados = new WP_Query(array(
                'post_type' => 'fichas-vod',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorias-vod',
                        'field' => 'slug',
                        'terms' => $terms[0]->slug
                    )
                ),
                'posts_per_page' => 4,
                'orderby' => 'rand',
                'post__not_in' => array( $post->ID ) 
    ));
    if($recomendados->have_posts()){
        $out .= '<hgroup><h1 class="h1_13">Te recomendamos</h1></hgroup>';
        while ($recomendados->have_posts()) { 
            $recomendados->the_post();
            
            if($i == 0){ $class = " alpha"; }elseif($i == 3){ $class = " omega"; }else{$class = '';}
            
            $out .= '<div class="grid_2  '.$class.'">';
            $out .= '<a href="'.get_permalink().'" title="Ver ficha de '.get_the_title().'" rel="contents">'. get_the_post_thumbnail($post->ID, 'ficha-vod').'</a>';
            $out .= '<a href="'.get_permalink().'" title="Ver ficha de '.get_the_title().'" rel="contents">'.get_the_title().'</a>';
            $out .= '</div>';
            
            
            $i++;
        }
    }
        return $out;
}

function getBlockProgram($args){
    $out = "";
    extract(shortcode_atts(array(
                'post_type' => 'fichas_vod',
                'posts_per_page' => 10,
                'post_status' => 'publish',
                'taxonomy' => false,
                'term' => false,
                'pagination' => false
                    ), $args));
    
                    

    $dest = new WP_Query(array(
                'post_type' => $post_type,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $term
                    )
                ),
                'posts_per_page' => $posts_per_page,
                'paged' => get_query_var('page') ? get_query_var('page') : get_query_var('paged')
            ));
    while ($dest->have_posts()) { $dest->the_post();
            $out .= '<div class="grid_2 alpha">';
            $out .= '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents" >'.get_the_post_thumbnail($post->ID, 'ficha-vod').'</a>';
            $out .= '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents" >'.get_the_title().'</a>';
            $out .= '</div>';
    }
    
    $out .= $pagination && ($searchQuery->found_posts > 10) ? '<div class="pagination center">' . pagination('Anterior', 'Siguiente', $dest) . '</div>' : '';
    
    return $out;
}

function getBlockEntradas($args) {
    global $ida, $notpost;
    $out = '';
    $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    
    extract(shortcode_atts(array(
                'post_type' => 'entradas',
                'posts_per_page' => 3,
                'post_status' => 'publish',
                'taxonomy' => false,
                'term' => false,
                'pagination' => false,
                'type' => false,
                'offset' => false,
                'paged' => false,
                'post_not_in' => false
                    ), $args));

    $dest = new WP_Query(array(
                'post_type' => $post_type,
                'offset' => $offset,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $term
                    )
                ),
                'post__not_in' => $post_not_in,
                'posts_per_page' => $posts_per_page,
                'paged' => $paged
            ));
    while ($dest->have_posts()) { $dest->the_post();
            if($type == 'destacados'){
                $notpost[] = $dest->post->ID;
                $out .= '<div class="page-third">';
                $out .= '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents">'.get_the_post_thumbnail($dest->post->ID, 'destacado-entrada').'</a>';
                $out .= '<hgroup><h1><a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents">'.get_the_title().'</a></h1></hgroup>';
                $out .= '<small>Publicado el '.get_the_date('d').' de '. $meses[date('n') - 1] .' por <span>'. get_the_author() .'</span></small>';			
                $content = get_field('bajada_entrada', $dest->post->ID) ? $ida->cortar(get_field('bajada_entrada', $dest->post->ID), 300, '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents" class="read-more"> [leer más +]</a>') : $ida->cortar(get_the_content(), 300, '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents" class="read-more">[leer más +]</a>');
                $out .= '<p>'. $content .'</p>';						
                $out .= '</div>';
            }else{
                $out .= '<div class="item-row clearfix">';
		$out .= '<div class="grid_3 alpha">';
		$out .= '<a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents">'.get_the_post_thumbnail($dest->post->ID, 'destacado-entrada').'</a>';
		$out .= '</div>';
		$out .= '<div class="grid_5 omega">';
		$out .= '<hgroup><h1><a href="'.get_permalink().'" title="'.get_the_title().'" rel="contents">'.get_the_title().'</a></h1></hgroup>';
		$content = get_field('bajada_entrada', $dest->post->ID) ? $ida->cortar(get_field('bajada_entrada', $dest->post->ID), 300) : $ida->cortar(get_the_content(), 300);
                $out .= '<p>'. $content .'</p>';
                $out .= '<a href="'.get_permalink().'" class="read-more">[leer más+]</a>';
		$out .= '</div>';
		$out .= '</div>';
            }
    }

    if($dest->have_posts()){
        $out .= $pagination && ($dest->found_posts > $posts_per_page)? '<button class="pagination center evt" data-func="ajaxpagination" data-cat="'.$term.'" data-notin=\''.json_encode($post_not_in).'\' data-ajax="ajaxPagination">Ver Siguientes 10</button>' : '';
    }
    
    
    return $out;
}

function getCategoryVOD($parentcat){
    $out = "";
    
    $parentcat = get_term_by('slug', $parentcat , 'categorias-vod');
    $childrens = get_terms( 'categorias-vod', 'orderby=id&hide_empty=false&parent='. $parentcat->term_id );
    
    foreach($childrens as $child){
        $term_link = get_term_link( $child, 'categorias-vod' );
        $out .= '<div class="vod-ranking category-vod">';
        $out .= '<hgroup><h1 class="h1_13 more"><a href="'.$term_link.'" title="Ir a la categoría '. $child->name .'" rel="contents">'.$child->name.'</a></h1></hgroup>';
        $out .= getBlockProgram(array('post_type' => 'fichas-vod', 'posts_per_page' => 4, 'taxonomy' => 'categorias-vod', 'term' => $child->slug));
        $out .= '</div>';
        
    }
    
    
    return $out;
}

function pagination($prev = 'Anterior', $next = 'Siguiente', $query = false, $onlylink = false) {
    global $wp_query, $wp_rewrite;
    if ($query == false) {
        $query = $wp_query;
    }

    $query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged', '%#%'),
        'format' => '',
        'total' => $query->max_num_pages,
        'current' => $current,
        'prev_text' => __($prev),
        'next_text' => __($next),
        'type' => 'plain'
    );
    if ($wp_rewrite->using_permalinks())
        $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');

    if (!empty($query->query_vars['s']))
        $pagination['add_args'] = array('s' => urlencode(get_query_var('s')));
    
    return paginate_links($pagination);
}

function get_images($attachment, $size) {

    if (wp_get_attachment_image($attachment, $size)) {
        return wp_get_attachment_image($attachment, $size);
    } else {
        $filename = 'noimg.jpg';
        $wp_upload_dir = wp_upload_dir();
        $src = $wp_upload_dir['baseurl'] . '/' . $filename;

        $attachment_id = get_attachment_id_from_src($src);
        return wp_get_attachment_image($attachment_id, $size);
    }
}

function get_attachment_id_from_src($link) {
    global $wpdb;
    $link = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $link);
    return $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE guid='$link'");
}

function mobileload() {
    global $platform;
    if (method_exists($platform, 'isMobile')) {
        if (($platform->isMobile() == true && $platform->isTablet() == false) && (!is_page('mobile'))) {
//            include 'mobile_theme.php';
            wp_redirect('/mobile/');
            exit;
        } elseif ($platform->isTablet() == true && !is_page('tablet')) {
//            include 'tablet-theme.php';
            wp_redirect('/tablet/');
            exit;
        }
    }
}

function getGalleryFicha(){
    global $post;
    $out = "";
    $cont = 0;
    $i = 1;
    
    if(get_field('ficha_wallpaper2', $post->ID)){
        foreach(get_field('ficha_wallpaper2', $post->ID) as $imagen){
            $cont++;
        }
        $out .='<div class="grid_2 alpha">Galería de imágenes</div>';
        $out .='<div class="grid_2 omega total-images">('.$cont.' Imágenes)</div>';
        $out .='<hr class="grid_4 alpha">';
        $out .='<ul id="gallery-1" class="gallery galleryid-78 gallery-columns-3 gallery-size-94x95">';

        foreach(get_field('ficha_wallpaper2', $post->ID) as $imagen){
            $out .='<li class="evt" data-func="lightboxGallery" data-pid="'.$post->ID.'" data-image="'.$i.'">'.  wp_get_attachment_image($imagen['adjuntar_wallpaper'], 'galeria-thumb').'</li>';
            $i++;
            
        }

        $out .='</ul>';
    }
    
    return $out;
}

function usuario() {
    global $user_ID;
    include(ABSPATH . "wp-includes/pluggable.php");
    $user = wp_get_current_user();
    return $user->ID;
}

/* =============================================================================
   RSS
   ========================================================================== */

//RSS de programación
function get_prog_all() {
        global $horario;
        global $wpdb_pr, $wpdb;
        
        $timezone = $horario;
        $next_day = $timezone == 4 ? '0400' : '0300';

        $today = date('mdy');

        $daynext = substr($today, 2, 2) + 1;
        $sumaunmes = mktime(0, 0, 0, date('m'), $daynext, date('Y'));
        $daynext = date("mdy", $sumaunmes);
        
        $query_prev = $wpdb_pr->get_results("
            SELECT $wpdb_pr->prog.ProgramID,Title,StartDate,StartTime
            FROM $wpdb_pr->sch 
            INNER JOIN $wpdb_pr->prog
            ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
            WHERE $wpdb_pr->sch.StartDate = $today 
            AND $wpdb_pr->sch.StartTime < '$next_day'
            ORDER BY  $wpdb_pr->sch.StartTime 
            DESC"
            ,'OBJECT');
        
        
        $query = $wpdb_pr->get_results("
            SELECT $wpdb_pr->prog.ProgramID,Title,StartDate,StartTime
            FROM $wpdb_pr->sch 
            INNER JOIN $wpdb_pr->prog
            ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
            WHERE $wpdb_pr->sch.StartDate = '$today'
            AND $wpdb_pr->sch.StartTime >= '$next_day'
            ORDER BY $wpdb_pr->sch.StartTime
            ASC
            "
                , 'OBJECT');
        
        $query_next = $wpdb_pr->get_results("
            SELECT $wpdb_pr->prog.ProgramID,Title,StartDate,StartTime
            FROM $wpdb_pr->sch 
            INNER JOIN $wpdb_pr->prog
            ON ($wpdb_pr->prog.ProgramID = $wpdb_pr->sch.ProgramID)
            WHERE $wpdb_pr->sch.StartDate = '$daynext' AND $wpdb_pr->sch.StartTime < '$next_day'
            "
                , 'OBJECT');

       foreach($query_prev as $clave => $program){
           $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
           $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera2' AND post_id=$ficha  LIMIT 1");
           $imagen = wp_get_attachment_image_src($imagen, 'full');
           if($imagen){
               $program->imagen = $imagen[0];
               $program->ids = get_all_programs_day($program->ProgramID);
               
               unset($program->ProgramID, $program->Title, $program->StartDate, $program->StartTime);
           
               $item[] = $program;
           }
       }

       foreach($query as $clave => $program){
           
           $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
           $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera2' AND post_id=$ficha  LIMIT 1");
           $imagen = wp_get_attachment_image_src($imagen, 'full');
           if($imagen){
               $program->imagen = $imagen[0];
               $program->ids = get_all_programs_day($program->ProgramID);
               
               unset($program->ProgramID, $program->Title, $program->StartDate, $program->StartTime);
           
               $item[] = $program;
           }
       }

       foreach($query_next as $clave => $program){
           $ficha = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ProgramID' AND meta_value LIKE '%$program->ProgramID%'  LIMIT 1");
           $imagen = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'imagen_cabecera2' AND post_id=$ficha  LIMIT 1");
           $imagen = wp_get_attachment_image_src($imagen, 'full');
           if($imagen){
              
               $program->imagen = $imagen[0];
               $program->ids = get_all_programs_day($program->ProgramID);
               
               unset($program->ProgramID, $program->Title, $program->StartDate, $program->StartTime);
           
               $item[] = $program;
           }
       }
       $out[] = $item; 
      
       
       return $out;
    
    
}

function get_all_programs_day($programid){
        global $wpdb_pr;
        
        $i = 0;
        
        $titles = $wpdb_pr->get_var("SELECT Title FROM $wpdb_pr->prog WHERE ProgramID = '$programid'");        
        $pids = $wpdb_pr->get_results("SELECT ProgramID FROM $wpdb_pr->prog WHERE Title = '$titles'");

        foreach($pids as $pid){
            $pids[$i] = $pid->ProgramID;   
            $i++;  
        }    
        $pids = implode(',',$pids);
        
        return $pids;
        
    }

function all_program_day(){
    if($_GET['program'] == 'all'){
        
        die (json_encode(get_prog_all()));
        
        exit;
    }
    
}


/* =============================================================================
   Actions + Filters + ShortCodes
   ========================================================================== */

//filters
  add_filter( 'body_class', 'add_body_class' );
  
  
//actions
  
//  add_action('template_redirect', 'mobileload');
  add_action('init', 'all_program_day');
  
  
//Registro de option pages
register_options_page('Global');
register_options_page('Home VOD');
register_options_page('Guia TV');
  
  


/* =============================================================================
   Shortcodes
   ========================================================================== */
    
?>

<?php //
/*
 * Plugin Name: Widget Me
 * Plugin URI: http://www.ida.cl
 * Description: Widgets para sitio Comunidad TV
 * Version: 1.0
 * Author: Jorge Codina
 */

class twitter_box extends WP_Widget {

	function twitter_box() {
		// Instantiate the parent object
		parent::__construct( false, 'Twitter Box' );
	}

	function widget( $args, $instance ) {;
		echo getTwitterBox();
	}

	function update( $new_instance, $old_instance ) {

	}

	function form( $instance ) {

	}
}

class hoyenVTR extends WP_Widget {

	function hoyenVTR() {
		// Instantiate the parent object
		parent::__construct( false, 'Hoy en VTR' );
	}

	function widget( $args, $instance ) {;
                global $wpdb_pr, $wpdb;
                
                $out = "";
                $out .= '<div id="vtr_hoy_widget" class="widget vtrtoday">';
                $out .= '<h2 class="widget-title">Hoy en VTR</h2>';
		
                $fecha = date('mdy');
                $hora = date('Hi');
                $postin = get_option("hoy_en_vtr");
                $args = array(
                    'post_type' => 'post',
                    'order' => 'DESC',
                    'orderby' => 'rand',
                    'posts_per_page' => 3,
                    'post__in' => $postin
                );
                $wp_query = new WP_Query($args);
                $i = 0;
                if ($wp_query->have_posts()) :

                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        $pids = explode(",", get_post_meta($wp_query->post->ID, 'ProgramID', true));
                        foreach ($pids as $pid) {
                            $sch->ChannelID = "";
                            $sch->StartTime = "";
                            $schs = $wpdb_pr->get_results("SELECT ChannelID, StartTime FROM $wpdb_pr->sch WHERE $wpdb_pr->sch.ProgramID = '$pid' AND StartDate >='$fecha' AND StartTime >= '$hora' ORDER BY StartDate ASC, StartTime DESC LIMIT 1", 'OBJECT');
                            foreach ($schs as $sch) {
                                if ($sch->ChannelID != "") {
                                    continue;
                                }
                            }
                        }
                        
                        $cat = wp_get_object_terms($wp_query->post->ID, "category");
                        $out .= '<article class="grid_4 alpha">';
                        $out .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail($wp_query->post->ID, 'thumbnail') . '</a>';
                        $out .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                        $out .= '<small class="cat-list">' . $cat[0]->name . '</small>';
                        $out .= '<div class="date prem">' . get_horalocal($sch->StartTime) . ' | ' . get_nombre_canal($sch->ChannelID) . '</div>';
                        $out .= '<div class="sharers-box clearfix">';
                        $out .= '<div class="fb-like" data-href="' . get_permalink() . '" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>';
                        $out .= '<div class="tw-share"><a href="https://twitter.com/share" class="twitter-share-button" data-url="' . get_permalink() . '" data-via="ComunidadTV" data-lang="es">Tweet</a>';
                        $out .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
                        $out .= '</div>';
                        $out .= '</div>';
                        $out .= '</article>';
                        $i++;
                    endwhile;
                    $out .= '<a class="guia" href="/guia-tv" title="Guía de programación" rel="contents">Guía de programación &raquo</a>';
                    $out .= '</div>';
                    echo $out;
                endif;
                
	}

	function update( $new_instance, $old_instance ) {

	}

	function form( $instance ) {

	}
}

class fbwall_widget_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function fbwall_widget_Widget() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'fbwall_widget', 'description' => __('Widget de Facebook Wall', 'framework') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 300, 'id_base' => 'fbwall_widget_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fbwall_widget_widget', __('Facebook Wall', 'framework'), $widget_ops, $control_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', ''.$instance['title'].'' );
		$fbwall_url = apply_filters('widget_fbwall_url', ''.$instance['fbwall_url'].'' );

		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Widget */
		?>
		<div id="widget_facebook-wall" class="widget">
			<iframe src="//www.facebook.com/plugins/likebox.php?href=<?= urlencode($fbwall_url); ?>&amp;width=300&amp;height=590&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=true&amp;header=true&amp;appId=434342906607120" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:590px;" allowTransparency="true"></iframe>
		</div>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['fbwall_url'] = $new_instance['fbwall_url'];

		/* No need to strip tags for.. */

		return $instance;
	}
	
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	 
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'fbwall_url' => 'https://www.facebook.com/VTRChile',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Título:', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fbwall_url' ); ?>"><?php _e('URL de Facebook: ', 'framework') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fbwall_url' ); ?>" name="<?php echo $this->get_field_name( 'fbwall_url' ); ?>" value="<?php echo $instance['fbwall_url']; ?>" />
		</p>		
	<?php
	}
}


function myplugin_register_widgets() {
	register_widget( 'twitter_box' );
        register_widget( 'fbwall_widget_widget' );
        register_widget( 'hoyenVTR' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );
?>
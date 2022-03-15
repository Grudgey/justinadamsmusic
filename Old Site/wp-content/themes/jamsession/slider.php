<?php
 
/*
	Enqueue Slider Files
*/
if ( ! function_exists( 'JAMSESSION_SWP_js_add_slider_scripts' ) ) : 
function JAMSESSION_SWP_js_add_slider_scripts()
{
	/* use this call to get correct results for conditional tags like is_home() and is_front_page() */
	wp_reset_query();
	
	/* for front page and single [jamsession_slides] post type*/
	if ((is_page_template('page_main_slider.php')) || ( is_single() && ('jamsession_slides' == get_post_type()) ))
	{
		wp_register_style( 'supersized-style',  get_template_directory_uri().'/supersized/css/supersized.css' );
		wp_enqueue_style( 'supersized-style');
		
		wp_register_style( 'supersized-shutter-style',  get_template_directory_uri().'/supersized/css/supersized.shutter.css' );
		wp_enqueue_style( 'supersized-shutter-style');
		
		wp_register_script( 'touchWipe',  get_template_directory_uri().'/supersized/js/jquery.touchwipe.min.js', array('jquery'), '', true);
		wp_enqueue_script( 'touchWipe');
		
		wp_register_script( 'supersized-shutter-script',  get_template_directory_uri().'/supersized/js/supersized.shutter.js', array('jquery'), '', true );
		wp_enqueue_script( 'supersized-shutter-script');
		
		wp_register_script( 'supersized-script',  get_template_directory_uri().'/supersized/js/supersized.3.2.7.js', array('jquery'), '', true );
		wp_enqueue_script( 'supersized-script');

		wp_register_script( 'news_badge_hover',  get_template_directory_uri().'/js/news_badge_hover.js', array('jquery'), '', true );
		wp_enqueue_script( 'news_badge_hover');
	}
	
	if (is_page_template('page_main_rev_slider.php')) {
		wp_register_script( 'news_badge_hover',  get_template_directory_uri().'/js/news_badge_hover.js', array('jquery'), '', true );
		wp_enqueue_script( 'news_badge_hover');
	}
}
endif;
	
	
/*
Initialize Slider
*/
if ( ! function_exists( 'JAMSESSION_SWP_js_slider_initialize_script' ) ) :
function JAMSESSION_SWP_js_slider_initialize_script()
{
	wp_reset_query();
	if ((is_page_template('page_main_slider.php')) || ( is_single() && ('jamsession_slides' == get_post_type()) ))
	{
		wp_register_script( 'initialize_slider',  get_template_directory_uri().'/js/initialize_slider.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'initialize_slider');
	}
}
endif;

/* initialize the main slider */
function JAMSESSION_SWP_js_slider_initialize()
{
	wp_reset_query();

	if (!(is_page_template('page_main_slider.php')))
	{
		return;
	}
	
	$args = array(
	'post_type' => 'jamsession_slides', 
	'posts_per_page' => 20 
	);
	
	/*main array*/
	$slider_values = array();

	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
		// check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) 
		{
			$single_image = array();
			
			$pID = get_the_ID();
			$post_thumbnail_id = get_post_thumbnail_id();
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			$slide_show_title = esc_html( get_post_meta( $pID, 'slide_show_title', true ) );
			
			$button_text =  esc_html( get_post_meta( $pID, 'button_text', true ) );
			$button_url =  esc_html( get_post_meta( $pID, 'button_url', true ) );
			
			
			$youtube_url = esc_html( get_post_meta( $pID, 'youtube_url', true ));
			$video = 0;
			$video_id = "";
			if (isset($youtube_url) && $youtube_url != '')
			{
				$video = 1;
				$video_id = JAMSESSION_SWP_getIDFromShortURL( esc_url($youtube_url));
			}
			else
			{
				$vimeo_url = esc_html( get_post_meta( $pID, 'vimeo_url', true ));
				if (isset($vimeo_url) && $vimeo_url != '')
				{
					$video = 2;
					$video_id = JAMSESSION_SWP_getIDFromShortURL( esc_url($vimeo_url));
				}
				
			}
			
			$single_image["button_text"] = $button_text;
			$single_image["button_url"] = $button_url;
			
			if ( isset($slide_show_title) && $slide_show_title != '' && $slide_show_title != '0')					
			{
				$single_image["image"] = $post_thumbnail_url;
				$single_image["slideTitle"] = "";
				$single_image["slideMessage"] = "";
				$single_image["slideURL"] = "";
				$single_image["video"] = $video;
				$single_image["video_id"] = $video_id;
			}
			else
			{
				/* SHOW title and message */
				$message = get_post_meta( $pID, 'slide_message', true );
				$slideURL = get_post_meta( $pID, 'slide_url', true );
				$title = get_the_title();
				
				$single_image["image"] = $post_thumbnail_url;
				$single_image["slideTitle"] = $title;
				$single_image["slideMessage"] = $message;
				$single_image["slideURL"] = $slideURL;
				$single_image["video"] = $video;
				$single_image["video_id"] = $video_id;
			}
			
			$slider_values[] = $single_image;
		}
	endwhile;

	/* default slide - it will be overwritten by the first defined slide */
	if ( 0 == count( $slider_values))
	{
		$single_image = array();
		
		$single_image["image"] = get_template_directory_uri()."/images/default_slide_image.jpg";
		$single_image["slideTitle"] = "Amazing Theme Features";
		$single_image["slideMessage"] = "JamSession is an awesome music WordPress theme";
		$single_image["slideURL"] = "http://smartwpress.com/jamsession/";
		$single_image["video"] = "2";
		$single_image["video_id"] = "57832093";	
		
		$single_image["button_text"] = "";
		$single_image["button_url"] = "";
		
		$slider_values[] = $single_image;
	}
	
	
	$slider_image_protect = JAMSESSION_SWP_get_slider_image_protect();
	$slider_interval 	  = JAMSESSION_SWP_get_slider_interval();
	$slider_transition	  = JAMSESSION_SWP_get_slider_transition();
	
	$json_array = json_encode($slider_values);

	$returned_array = array( 'images' => $json_array, 
							 'images_count' => count($slider_values),
							 'image_protect' => $slider_image_protect,
							 'slider_interval' => $slider_interval,
							 'slider_transition' => $slider_transition);
	wp_localize_script( 'initialize_slider', 'jamsession_slideshow_images', $returned_array );
}
	
	



/*
Initialize SINGLE SLIDE Slider
*/
function JAMSESSION_SWP_js_slider_initialize_single()
{
	if ( !(is_single() && ('jamsession_slides' == get_post_type())) )
	{
		return;
	}
	
	/*main array*/
	$slider_values = array();
	
	if ( have_posts() ) : while ( have_posts() ) : the_post();
	
		// check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) 
		{
			$single_image = array();
			
			$pID = get_the_ID();
			$post_thumbnail_id = get_post_thumbnail_id();
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
			$slide_show_title = esc_html( get_post_meta( $pID, 'slide_show_title', true ) );

			$button_text =  esc_html( get_post_meta( $pID, 'button_text', true ) );
			$button_url =  esc_html( get_post_meta( $pID, 'button_url', true ) );
			
			$youtube_url = esc_html( get_post_meta( $pID, 'youtube_url', true ));
			$video = 0;
			$video_id = "";
			if (isset($youtube_url) && $youtube_url != '')
			{
				$video = 1;
				$video_id = JAMSESSION_SWP_getIDFromShortURL( esc_url($youtube_url));
			}
			else
			{
				$vimeo_url = esc_html( get_post_meta( $pID, 'vimeo_url', true ));
				if (isset($vimeo_url) && $vimeo_url != '')
				{
					$video = 2;
					$video_id = JAMSESSION_SWP_getIDFromShortURL( esc_url($vimeo_url));
				}
			}
			
			$single_image["button_text"] = $button_text;
			$single_image["button_url"] = $button_url;
			
			if ( isset($slide_show_title) && $slide_show_title != '' && $slide_show_title != '0')					
			{
				/* HIDE title and message */
				$single_image["image"] = $post_thumbnail_url;
				$single_image["slideTitle"] = "";
				$single_image["slideMessage"] = "";
				$single_image["slideURL"] = "";
				$single_image["video"] = "";
				$single_image["video_id"] = "";	
			}
			else
			{
				/* SHOW title and message */
				$message = get_post_meta( $pID, 'slide_message', true );
				$slideURL = get_post_meta( $pID, 'slide_url', true );
				$title = get_the_title();
				
				$single_image["image"] = $post_thumbnail_url;
				$single_image["slideTitle"] = $title;
				$single_image["slideMessage"] = $message;
				$single_image["slideURL"] = $slideURL;
				$single_image["video"] = $video;
				$single_image["video_id"] = $video_id;						
			}
			
			$slider_values[] = $single_image;
		}
	endwhile;
	endif;

	$json_array = json_encode($slider_values);

	$returned_array = array( 'images' => $json_array, 'images_count' => count($slider_values) );
	wp_localize_script( 'initialize_slider', 'jamsession_slideshow_images', $returned_array );
}

function JAMSESSION_SWP_getIDFromShortURL( $shortURL)
{
	@$elements = explode("/", $shortURL);
	@$dim = count( $elements); 
	if ( $dim == 0)
	{
		return "";
	}
	else
	{
		return $elements[ $dim - 1];
	}
}
	
?>
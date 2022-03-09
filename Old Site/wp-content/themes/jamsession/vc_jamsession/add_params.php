<?php
	
if ( function_exists('vc_add_param') )
{
	vc_add_param( "vc_row", array(
		"type"			=> "dropdown",
		"class"			=> "",
		"heading"		=> "Parallax Background",
		"param_name"	=> "js_parallax_bg",
		"value"			=> Array( "No" => "no",
							"Yes" => "yes"),
		"description"	=> "Use the background image as parallax background"
	));
	
	vc_add_param( "vc_row", array(
		"type"			=> "colorpicker",
		"class"			=> "",
		"heading"		=> "Color Overlay",
		"param_name"	=> "js_color_overlay",
		"value"			=> "",
		"description"	=> "Use a color overlay over the background image"
	));
	
	vc_add_param( "vc_row", array(
		"type"			=> "textfield",
		"class"			=> "",
		"heading"		=> "Video Background",
		"param_name"	=> "js_video_background",
		"value"			=> "",
		"description"	=> "Specify the video URL to use it as background. Supported formats: MP4, WebM, and Ogg."
	));
}

if ( function_exists('vc_remove_param') ) {
	/*REMOVE VC PARAMS IMPLEMENTED BY THE THEME*/
	vc_remove_param( "vc_row", "parallax_image" );
	vc_remove_param( "vc_row", "parallax" );
	vc_remove_param( "vc_row", "video_bg" );
	vc_remove_param( "vc_row", "video_bg_url" );
	vc_remove_param( "vc_row", "video_bg_parallax" );
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_gallery')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_map_js_swp_gallery' );
		function JAMSESSION_SWP_map_js_swp_gallery() {
			vc_map( array(
				  "name" => "Gallery",
				  "base" => "js_swp_gallery",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Specify a title for your gallery"
					), 
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Row height in pixels" ),
						"param_name" => "rowheight",
						"value" => "",
						"description" => "Row height in pixels. Digits only. Default value: 180"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "View all text message" ),
						"param_name" => "viewallmessage",
						"value" => "",
						"description" => "View all text message. If empty, default value is: View All Images"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Gallery Page URL" ),
						"param_name" => "photosurl",
						"value" => "",
						"description" => "URL to all Photo Gallery page."
					),						
					array(
						"type" => "attach_images",
						"class" => "",
						"heading" => __( "Add images" ),
						"param_name" => "images",
						"value" => "",
						"description" => "Add your images here"
					)
				  )
			));
		}
	}

	if (shortcode_exists('js_swp_gallery_grid')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_map_js_swp_gallery_grid' );
		function JAMSESSION_SWP_map_js_swp_gallery_grid() {
			vc_map( array(
				  "name" => "Gallery Grid",
				  "base" => "js_swp_gallery_grid",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Specify a title for your gallery"
					), 
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "View all text message" ),
						"param_name" => "viewallmessage",
						"value" => "",
						"description" => "View all text message. If empty, default value is: View All Images"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Gallery Page URL" ),
						"param_name" => "photosurl",
						"value" => "",
						"description" => "URL to all Photo Gallery page."
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Cell Height" ),
						"param_name" => "cell_height",
						"value" => "350px",
						"description" => "Cell height in pixels."
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __( "Items on row" ),
						"param_name" => "items_on_row",
						"value" =>  array( 
										"3 Default" => "3",
										"4 On Row" => "4",
										"5 On Row" => "5"
									)
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Gap" ),
						"param_name" => "gap",
						"value" => "5px"
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __( "Open Image In" ),
						"param_name" => "open_image",
						"value" =>  array( 
										"Lightbox" => "lightbox",
										"Same Window" => "same_window",
										"New Broser Tab" => "new_tab"
									)
					),
					array(
						"type" => "attach_images",
						"class" => "",
						"heading" => __( "Add images" ),
						"param_name" => "images",
						"value" => "",
						"description" => "Add your images here"
					)
				  )
			));
		}
	}
}

if (function_exists('vc_map'))
{
	if (shortcode_exists('js_swp_last_album')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_map_js_swp_last_album' );
		function JAMSESSION_SWP_map_js_swp_last_album() {
			vc_map( array(
				  "name" => "Latest Album",
				  "base" => "js_swp_last_album",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Section title"
					)
				  )
			));
		}
	}
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_last_videos')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_map_js_swp_last_videos' );
		function JAMSESSION_SWP_map_js_swp_last_videos() {
			vc_map( array(
				  "name" => "Latest Videos",
				  "base" => "js_swp_last_videos",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Section title"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Number of videos" ),
						"param_name" => "videos_no",
						"value" => "2",
						"description" => "Number of videos to show"
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => __( "Items on row" ),
						"param_name" => "videos_on_row",
						"value" =>  array( 
										"2 Default" => "2",
										"4 On Row" => "4"
									),
						"description" => "Number of videos to show"
					),
					array(
						"type" => "js_video_cat",
						"class" => "",
						"heading" => esc_html__("Video Category", "jamsession-post-types"),
						"param_name" => "video_category",
						"admin_label"	=> true,
						"value" => "",
						"description" => esc_html__("Choose the video category. By default, videos from all categories are shown.", "jamsession-post-types")
					)
				  )
			));
		}
	}
}


if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_blog_shortcode')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_map_js_swp_blog_shortcode' );
		function JAMSESSION_SWP_map_js_swp_blog_shortcode() {
			vc_map( array(
				  "name" => "Blog",
				  "base" => "js_swp_blog_shortcode",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Section title"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Number of Posts" ),
						"param_name" => "postsnumber",
						"value" => "5",
						"description" => "Number of Posts To Be Displayed. Default value: 5."
					),
					array(
						"type" => "js_post_cat",
						"class" => "",
						"heading" => __("Post Category"),
						"param_name" => "post_category",
						"value" => "",
						"admin_label"	=> true,
						"description" => __("Choose the post category. By default, posts from all categories are shown.")
					),
				  )
			));
		}
	}
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_last_events')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_map_js_swp_last_events_shortcode' );
		function JAMSESSION_SWP_map_js_swp_last_events_shortcode() {
			vc_map( array(
				  "name" => "Next Events",
				  "base" => "js_swp_last_events",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Section title"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "View all text message" ),
						"param_name" => "viewallmessage",
						"value" => "",
						"description" => "View all text message. If empty, default value is: View All Events"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Gallery Page URL" ),
						"param_name" => "eventspageurl",
						"value" => "",
						"description" => "URL to Events page."
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Number of Events" ),
						"param_name" => "eventsnumber",
						"value" => "",
						"description" => "Number of Events Displayed. Default value: 5."
					),
					array(
						"type" => "js_event_cat",
						"class" => "",
						"heading" => __( "Event Category"),
						"param_name" => "event_category",
						"value" => "",
						"description" => "Event Category"
					),
					array(
						"type" => "dropdown",
						"class" => "",
						"heading" => esc_html__( "Show Events", "jamsession-post-types"),
						"param_name" => "past_next",
						"value" =>  array( 
										"Upcoming" => "next",
										"Past" => "past"
									),
						"admin_label"	=> true,
						"description" => esc_html__("Choose to display upcoming or past events.", "jamsession-post-types")
					)
				  )
			));
		}
	}
}


if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_ajax_contact_form')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_js_swp_ajax_contact_shortcode' );
		function JAMSESSION_SWP_js_swp_ajax_contact_shortcode() {
			vc_map( array(
				  "name" => "Ajax Contact Form",
				  "base" => "js_swp_ajax_contact_form",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Section title"
					)
				  )
			));
		}
	}
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_row_heading')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_js_swp_row_heading_shortcode' );
		function JAMSESSION_SWP_js_swp_row_heading_shortcode() {
			vc_map( array(
				  "name" => "Row Heading",
				  "base" => "js_swp_row_heading",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Simple Title For Visual Composer Row"
					)
				  )
			));
		}
	}
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_social_profiles_icons')) {
	
		add_action( 'vc_before_init', 'JAMSESSION_SWP_js_swp_social_icons_shortcode' );
		function JAMSESSION_SWP_js_swp_social_icons_shortcode() {
			vc_map( array(
				  "name" => "Social Media Icons",
				  "base" => "js_swp_social_profiles_icons",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "",
						"description" => "Add a title if you use this element as only element in the row"
					),
					array(
						"type"			=> "dropdown",
						"class"			=> "",
						"heading"		=> "Center Icons",
						"param_name"	=> "center_icons",
						"value"			=> Array( 
											"Middle" => "text_center",
											"Left" => "text_left",
											"Right" => "text_right"),
						"description"	=> "Center icons middle/left/right"
					)
				  )
			));
		}
	}
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_theme_button')) {
		add_action( 'vc_before_init', 'JAMSESSION_SWP_js_swp_theme_button_shortcode' );
		function JAMSESSION_SWP_js_swp_theme_button_shortcode() {
			vc_map( array(
				  "name" => "JamSession Button",
				  "base" => "js_swp_theme_button",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Button Text" ),
						"param_name" => "button_text",
						"value" => "",
						"description" => "Add a text for your button"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Button URL" ),
						"param_name" => "button_url",
						"value" => "",
						"description" => "URL"
					),
					array(
						"type"			=> "dropdown",
						"class"			=> "",
						"heading"		=> "Align Button",
						"param_name"	=> "button_align",
						"value"			=> Array( 
											"Left" => "button_left",
											"Middle" => "button_center",
											"Right" => "button_right"),
						"description"	=> "Align button left/middle/right"
					)					
				  )
			));
		}
	}
}

if (function_exists('vc_map')) 
{
	if (shortcode_exists('js_swp_latest_tweets')) {
		add_action( 'vc_before_init', 'JAMSESSION_SWP_js_swp_latest_tweets_shortcode');
		function JAMSESSION_SWP_js_swp_latest_tweets_shortcode() {
			vc_map( array(
				  "name" => "Latest Tweets",
				  "base" => "js_swp_latest_tweets",
				  "class" => "",
				  "category" => "JamSession",
				  "params" => array(
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Title" ),
						"param_name" => "title",
						"value" => "Latest Tweets",
						"description" => "Title For VC Element"
					),				  
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Screen Name" ),
						"param_name" => "screen_name",
						"value" => "",
						"description" => "Screen Name"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Consumer Key" ),
						"param_name" => "consumer_key",
						"value" => "",
						"description" => "Similar to: Mg3Bm2jHaNiJ9LKJuyTy65Mi"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Consumer Secret" ),
						"param_name" => "consumer_secret",
						"value" => "",
						"description" => "Similar to: JHJs9D7MkjUkjhadPm7MNBzmnS7MNjhmnasdaHTR50Oh6Byt"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Access Token" ),
						"param_name" => "access_token",
						"value" => "",
						"description" => "Similar to: 2784764804-KHGFG6Hu8CkjhkjhdMHY5dslfksjfdsYH7H2Oig"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Access Token Secret" ),
						"param_name" => "access_token_secret",
						"value" => "",
						"description" => "Similar to: Ksjahdga7YKJ23JHsadkljlk,mnasdaadalkjJHG34jhg"
					),
					array(
						"type" => "textfield",
						"class" => "",
						"heading" => __( "Tweets Count"),
						"param_name" => "tweets_count",
						"value" => "",
						"description" => "How Many Tweets To Get"
					)					
				  )
			));
		}
	}
}

/*
	add new params for visual composer
*/
add_action( 'vc_before_init', 'JAMSESSION_SWP_add_js_new_params');
function JAMSESSION_SWP_add_js_new_params() {
	vc_add_shortcode_param('js_video_cat', 'JAMSESSION_SWP_vc_param_video_cat');
	vc_add_shortcode_param('js_event_cat', 'JAMSESSION_SWP_vc_param_event_cat');
	vc_add_shortcode_param('js_post_cat', 'JAMSESSION_SWP_vc_param_post_cat');
}

function JAMSESSION_SWP_vc_param_video_cat($settings, $value) {
	$args = array(
		'taxonomy'           => 'video_category',
		'show_option_all'    => 'All',
		'class'              => 'wpb_vc_param_value',
		'name'               => $settings['param_name'],
		'selected'           => $value
	);

	ob_start();
	wp_dropdown_categories($args);
	$output = ob_get_clean();
	return $output;
}

function JAMSESSION_SWP_vc_param_event_cat($settings, $value) {
	$args = array(
		'taxonomy'           => 'event_category',
		'show_option_all'    => 'All',
		'class'              => 'wpb_vc_param_value',
		'name'               => $settings['param_name'],
		'selected'           => $value
	);

	ob_start();
	wp_dropdown_categories($args);
	$output = ob_get_clean();
	return $output;
}

function JAMSESSION_SWP_vc_param_post_cat($settings, $value) {
	$args = array(
		'show_option_all'    => 'All',
		'class'              => 'wpb_vc_param_value',
		'name'               => $settings['param_name'],
		'selected'           => $value
	);

	ob_start();
	wp_dropdown_categories($args);
	$output = ob_get_clean();
	return $output;
}
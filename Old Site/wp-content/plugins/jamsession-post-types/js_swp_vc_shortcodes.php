<?php
	
/*
	This file contains shortcodes definitions used by the theme to extend Visual Composer
*/

add_shortcode('js_swp_gallery', 'JAMSESSION_SWP_js_gallery');
function JAMSESSION_SWP_js_gallery($atts) {
	$defaults = array(
	  'title' => 'Featured Images',
	  'rowheight' => '',
	  'viewallmessage' => '',
	  'photosurl' => '',
	  'images' => ''
	);
	extract(shortcode_atts($defaults, $atts));

	$output = '<h2 class="short_title">'.$title.'</h2>';
	if ('' == $images){
		return $output;
	}
	
	if ( empty($rowheight) || !is_numeric($rowheight)) {
		$rowheight = 180;
	}
	if ( empty($viewallmessage)) {
		$viewallmessage = "View All Images";
	}
	$output .= '<div class="js_swp_gallery_container" data-rheight="'.$rowheight.'">';
	
	$photoAlbumUnique = "photoAlbum".rand();
	$images = explode( ',', $images );
	foreach($images as $imageId) {
	
		$singleImgTag = wp_get_attachment_image( $imageId, 'full' );
		$imageAttributes = wp_get_attachment_image_src($imageId, "medium");
		
		$output .= '<div class="img_box">';
		$output .= '<a href="'.wp_get_attachment_url($imageId).'" data-lightbox="'.$photoAlbumUnique.'">';
		$output .= '<div class="img_mask"><i class="icon-picture"></i></div>';
		$output .= $singleImgTag;
		$output .= '</a></div>';
	}
	$output .= "</div>";
	
	$output .= '<div class="view_more js_swp_container"><a href="'.$photosurl.'">'.$viewallmessage.'</a></div>';
	return $output;
}

add_shortcode('js_swp_last_album', 'JAMSESSION_SWP_js_swp_last_album');
function JAMSESSION_SWP_js_swp_last_album($atts) {
	$defaults = array(
		'title' => 'Music'
	);
	extract(shortcode_atts($defaults, $atts));
	
	$args = array(
		'numberposts'	=> 1,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'ASC',
		'post_type'        => 'js_albums',
		'post_status'      => 'publish',
		'posts_per_page'   => -1,
		'suppress_filters' => false
	); 
			
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	
	$album = $artist = $image = '';
	$tracks = array();
	$attr = array();
	if ( $wp_query->have_posts())
	{
		while ( $wp_query->have_posts() )
		{
			$wp_query->the_post();
			$album = get_the_title();
			$artist = esc_html(get_post_meta(get_the_ID(), 'album_artist', true));
			$image = get_the_post_thumbnail(get_the_ID(), 'medium');
			$tracks = get_attached_media('audio', get_the_ID());
		}
	}
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();	
	
	
	$output = '<h2 class="short_title">'.$title.'</h2>';
	
	if ( empty($album)) {
		return $output; 
	}
	
	$output .= '<div class="js_swp_center_container js_swp_container js_swp_player">';
	$output .= '<div class="album_widget_left">'.$image.'</div>';
	$output .= '<div class="album_widget_right"><h3>'.$album.'</h3>';
	$output .= '<div class="album_artist">'.$title.'</div>';

	$output .= '<div class="js_swp_audio_controls">';
	$output .= '<i class="icon-fast-bw"></i>';
	$output .= '<span class="play_pause"><i class="icon-play"></i><i class="icon-pause"></i></span><i class="icon-fast-fw"></i></div>';
	
	$output .= '<div class="js_swp_tracks">';
	$playerNo = 0;
	foreach ($tracks as $track)
	{
		$player_id = "js_swp_player_entry_".$playerNo;
		$output .= '<audio class="mejs__player '.$player_id.'" src="'.wp_get_attachment_url($track->ID).'" data-title="'.$track->post_title.'" preload="none">';
		$output .= '</audio>';
		$playerNo++;
	}	
	$output .= '</div>';
	
	$output .= '</div>';
	$output .= '</div>';	
	
	return $output;
}


/*
	Latest Two Videos
*/
add_shortcode('js_swp_last_videos', 'JAMSESSION_SWP_js_swp_last_videos');
function JAMSESSION_SWP_js_swp_last_videos($atts) {
	$defaults = array(
		'title' 	=> 'New Videos',
		'videos_no'	=> '2',
		'videos_on_row'	=> '2',	/*2, 4*/	
		'video_category'	=> '0'
	);
	extract(shortcode_atts($defaults, $atts));

	$videos_no = intval($videos_no);

	$args = array(
		'numberposts'	   => $videos_no,
		'posts_per_page'   => $videos_no,
		'category'         => '',
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'js_videos',
		'post_status'      => 'publish',
		'suppress_filters' => false
	);

	if (('0' != $video_category) && strlen($video_category)) {
		$args["tax_query"] = array(
								array(
									'taxonomy' => 'video_category',
									'field'    => 'term_id',
									'terms'    => $video_category,
								)
							);		
	}

	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);

	$all_videos = array();
	if ($wp_query->have_posts()) {
		while ($wp_query->have_posts()) {
			$wp_query->the_post();
			$single_video['youtube'] = esc_html(get_post_meta(get_the_ID(), 'video_youtube_url', true ) ); 			
			$single_video['vimeo'] = esc_html(get_post_meta(get_the_ID(), 'video_vimeo_url', true ) );
			$all_videos[] = $single_video;
		}
	}
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();
	
	if (empty($all_videos)) {
		return "";
	}

	$items_on_row_class = "items_" . $videos_on_row . "_on_row";
	$container_class = (4 == $videos_on_row) ? "js_swp_full_container" : "js_swp_center_container";

	ob_start();
?>

	<h2 class="short_title"><?php echo esc_html($title); ?> </h2>
	<div class="<?php echo esc_attr($container_class); ?> float_container <?php echo esc_attr($items_on_row_class); ?>">
		<?php
		$video_no = 0;
		foreach($all_videos as $single_video) { 
			$video_no++;
			$css_class = "video_scd_item " . $items_on_row_class;
			?>

			<div class="<?php echo esc_attr($css_class); ?>">
				<div class="iframe_container">
					<?php echo JAMSESSION_SWP_put_embedded_video($single_video['youtube'], $single_video['vimeo']); ?>
				</div>
			</div>

		<?php } ?>
	</div>

<?php
	$output = ob_get_clean();
	return $output;
}

add_shortcode('js_swp_blog_shortcode', 'JAMSESSION_SWP_js_swp_blog_shortcode');
function JAMSESSION_SWP_js_swp_blog_shortcode($atts) {
	$defaults = array(
		'title' => 'Blog',
		'postsnumber' => '5',
		'post_category'		=> 'all',
	);
	extract(shortcode_atts($defaults, $atts));

	if ('all' == $post_category) {
		$post_category = '';
	}

	$args = array(
		'numberposts'	=> $postsnumber,
		'posts_per_page'   => $postsnumber,
		'ignore_sticky_posts' => 1,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => array( 'post'),
		'post_status'      => 'publish',
		'cat'				=> $post_category,
		'suppress_filters' => false
	); 	
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);	
	
	$output = '<h2 class="short_title">'.$title.'</h2>';
	$output .= '<div id="post_content_container">';
	if ( $wp_query->have_posts())
	{
		while ( $wp_query->have_posts() )
		{
			$wp_query->the_post();
			$output .= '<div class="post_item">';
			if (has_post_thumbnail()) 
			{
				$output .=  '<a href="'.get_the_permalink().'">';
				$output .=	'<div class="post_image_container fixed_image_container">';
				$output	.=	'<div class="post_icon_more small_icon_more">';
				$output	.=	'<i class="icon-link"></i>';
				$output	.=	'</div>';
				$output .=	'<div class="post_fader"></div>';
				$output .=	get_the_post_thumbnail(get_the_ID(), 'medium');
				$output .=	'</div>';
				$output .=  '</a>';
			}
			$output .=  '<div class="post_item_title">';
			$output .=	'<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
			$output .=	'</div>';
			$output .=	'<div class="post_item_excerpt">';
			$output .=	'<p>'.get_the_excerpt().'</p>';
			$output .=	'</div>';
			$output .=	'<div class="post_item_date">';
			$output .=	get_the_date(get_option('date_format'));
			$output .=	'</div>';
			$output .=	'</div>';
		}
	}
	$output .= '</div>';
	
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();		

	return $output;
}

add_shortcode('js_swp_social_profiles_icons', 'JAMSESSION_SWP_social_profiles_icons');
function JAMSESSION_SWP_social_profiles_icons($atts) {
	$defaults = array(
		'title' => '', 
		'center_icons' => 'text_center'
	);
	extract(shortcode_atts($defaults, $atts));	
	
	ob_start();
	
	if (!empty($title)) {
		echo '<h2 class="short_title">'.$title.'</h2>';		
	}
	
	$centeringClass = "text_center";
	switch ($center_icons) {
		case "text_left":
			$centeringClass = "text_left";
			break;
		case "text_right":
			$centeringClass = "text_right";
			break;
	}
	
	echo '<div class="social_profiles_contact js_vc_social_profiles '.$centeringClass.'">';
	if (function_exists('JAMSESSION_SWP_front_page_social_profiles')) {
		JAMSESSION_SWP_front_page_social_profiles();
	}
	echo '</div>';
	
	$output = ob_get_clean();
	
	return $output;
}

add_shortcode('js_swp_last_events', 'JAMSESSION_SWP_js_swp_last_events');
function JAMSESSION_SWP_js_swp_last_events($atts) {
	$defaults = array(
		'title' => 'Next Events',
		'eventspageurl' => '',
		'viewallmessage' => 'View All Events',
		'eventsnumber' 	 => '5',
		'event_category' => '0',
		'past_next'		 =>	"next"		/*next/past*/
	);
	extract(shortcode_atts($defaults, $atts));

	/*default - next events*/
	$meta_query_event = array(
			'relation' => 'AND',
			'event_date' => array(
			   'key' => 'event_date',
			   'value' => date('Y/m/d',current_time('timestamp')),
			   'compare' => '>='
			),
			'event_time' => array(
			   'key' => 'event_time'
			)
		);
	$order_events_by = array('event_date' => 'ASC', 'event_time' => 'ASC');

	/*shows past events*/
	if ("past" == $past_next) {
		$meta_query_event = array(
				'relation' => 'AND',
				'event_date' => array(
				   'key' => 'event_date',
				   'value' => date('Y/m/d',current_time('timestamp')),
				   'compare' => '<'
				),
				'event_time' => array(
				   'key' => 'event_time'
				)
			);
		$order_events_by = array('event_date' => 'DESC', 'event_time' => 'DESC');	
	}

	$args = array(
		'numberposts'	=> $eventsnumber,
		'posts_per_page'   => $eventsnumber,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => $order_events_by,
		'order'            => 'ASC',
		'meta_key'         => 'event_date',
		'post_type'        => 'js_events',
		'post_status'      => 'publish',
		'suppress_filters' => false,
		'meta_query' 	   => $meta_query_event
	);

	if (('0' != $event_category) && strlen($event_category)) {
		$args["tax_query"] = array(
								array(
									'taxonomy' => 'event_category',
									'field'    => 'term_id',
									'terms'    => $event_category,
								),
							);
	}	
	
	$wp_query= null;
	$wp_query = new WP_Query();
	$wp_query->query($args);
	
	$output = '<h2 class="short_title">'.$title.'</h2>';
	if ( $wp_query->have_posts())
	{
		$output .= '<div class="js_swp_center_container for_events">';
		while ( $wp_query->have_posts() )
		{
			$wp_query->the_post();
			$output .= '<div class="js_swp_event_container js_swp_container">';
			
			$output .= '<div class="js_swp_event_date">';
			$event_date = esc_html( get_post_meta( get_the_ID(), 'event_date', true ) );
				if ( $event_date != "")
				{
					@$event_date = str_replace("/","-", $event_date);
					@$dateObject = new DateTime($event_date);
				}
			$output .= date_i18n(get_option('date_format'), $dateObject->format('U'));
			$output .= '</div>';
			
			$output .= '<div class="js_swp_event_location"><a href="'.get_the_permalink().'">';
			$event_location = esc_html( get_post_meta( get_the_ID(), 'event_location', true ) );
			$output .= $event_location;
			$output .= '</a></div>';
			
			$output .= '<div class="js_swp_event_venue">';
			$event_venue = esc_html( get_post_meta( get_the_ID(), 'event_venue', true ) );
			$output .= $event_venue;
			$output .= '</div>';
			
			$output .= '<div class="js_swp_event_buy">';
			$event_buy_tickets_url = esc_html(get_post_meta(get_the_ID(), 'event_buy_tickets_url', true ));
			$event_buy_tickets_message = esc_html( get_post_meta( get_the_ID(), 'event_buy_tickets_message', true ) );		
			if ( empty($event_buy_tickets_message)) {
				$event_buy_tickets_message = __('Tickets', 'jamsession');
			}
			if ( empty($event_buy_tickets_url)) {
				$output .= __('Coming Soon', 'jamsession');
			} else {
				$output .= '<a href="'.$event_buy_tickets_url.'" target="_blank">'.$event_buy_tickets_message.'</a>';
			}
			
			$output .= '</div>';
			
			
			$output .= '</div>';
		}
		if ( !empty($eventspageurl)) {
			$output .= '<div class="view_more js_swp_container"><a href="'.$eventspageurl.'">'.$viewallmessage.'</a></div>';
		}
		$output .= '</div>';
	}
	/* Reset main query loop */
	wp_reset_query ();
	wp_reset_postdata ();	
	
	return $output;
}


add_shortcode('js_swp_ajax_contact_form', 'JAMSESSION_SWP_js_swp_ajax_contact_form');
function JAMSESSION_SWP_js_swp_ajax_contact_form($atts) {
	$defaults = array(
		'title' => 'Contact Us'
	);
	extract(shortcode_atts($defaults, $atts));
	
	$output = '<h2 class="short_title">'.$title.'</h2>';
	$output .= '<div class="js_swp_center_container for_ajax_contact">';
	if ( function_exists( 'JAMSESSION_SWP_render_ajax_contact' ) ) {
		$output .= JAMSESSION_SWP_render_ajax_contact();	
	}
	$output .= '</div>';
	
	return $output;
}


add_shortcode('js_swp_row_heading', 'JAMSESSION_SWP_js_swp_row_heading');
function JAMSESSION_SWP_js_swp_row_heading($atts) {
	$defaults = array(
		'title' => 'Some Title'
	);
	extract(shortcode_atts($defaults, $atts));
	
	$output = '<h2 class="short_title">'.$title.'</h2>';
	
	return $output;
}

add_shortcode('js_swp_theme_button', 'JAMSESSION_SWP_js_swp_theme_button');
function JAMSESSION_SWP_js_swp_theme_button($atts) {
	$defaults = array(
		'button_text' => 'button text',
		'button_url' => '',
		'button_align' => 'left'
	);
	
	extract(shortcode_atts($defaults, $atts));
	
	$centeringClass = "button_left";
	$hasClearfix = 0;
	switch ($button_align) {
		case "button_center":
			$centeringClass = "button_center";
			break;
		case "button_right":
			$centeringClass = "button_right";
			$hasClearfix = 1;
			break;
		default: 
			$centeringClass = "button_left";
			$hasClearfix = 1;
			break;		
	}
	
	
	$output = '<div class="js_swp_theme_button '.$centeringClass.'"><a href="'.$button_url.'" alt="'.$button_text.'">'.$button_text.'</a></div>';
	if ($hasClearfix) {
		$output .= '<div class="clearfix"></div>';		
	}

	return $output;
}

add_shortcode('js_swp_latest_tweets', 'JAMSESSION_SWP_js_swp_latest_tweets');
function JAMSESSION_SWP_js_swp_latest_tweets($atts) {
	$defaults = array(
		'title' 				=> 'Latest Tweets',
		'screen_name' 			=> '',
		'consumer_key' 			=> '',
		'consumer_secret' 		=> '',
		'access_token' 			=> '',
		'access_token_secret' 	=> '',
		'tweets_count'			=> '1'
	);

	extract(shortcode_atts($defaults, $atts));
	
    if( !strlen( $screen_name ) || !strlen( $consumer_key ) || !strlen( $consumer_secret ) || !strlen( $access_token ) || !strlen( $access_token_secret ) ) {
        return '';
    }
	
	include_once plugin_dir_path( __FILE__ ). '/vendor/TwitterOAuth/autoload.php';
	
	$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token, $access_token_secret );	
	$latest_tweets = $connection->get( 'statuses/user_timeline', array(
		'screen_name' => $screen_name, 'count' => $tweets_count
	));
	
	if( isset( $latest_tweets->errors ) ) {
		return 'Error :' . $latest_tweets->errors[0]->code . ' - ' . $latest_tweets->errors[0]->message;
	}
	
	ob_start();
	if (!empty($title)) {
		echo '<h2 class="short_title">'.$title.'</h2>'; 
	}
	
	if (count($latest_tweets)) {
		$tweets_count = min($tweets_count, count( $latest_tweets ));
		for($i = 0; $i < $tweets_count; $i++) {
			$profileImage =  is_ssl() ? $latest_tweets[$i]->user->profile_image_url_https : $latest_tweets[$i]->user->profile_image_url;
			$userName 	= $latest_tweets[$i]->user->name;
			$userScreen = $latest_tweets[$i]->user->screen_name;
			$tweetText = $latest_tweets[$i]->text;
			$tweetId = $latest_tweets[$i]->id;
			
			?>
			<div class="js_swp_lt_items js_swp_container js_swp_center_container">
				<div class="js_swp_lt_item">
					<div class="js_swp_lt_head">
						<div class="js_swp_lt_image">
							<img src="<?php echo $profileImage;?>" alt="<?php echo $userName; ?>">
						</div>
						<div class="js_swp_lt_details">
							<div class="js_swp_lt_name"><?php echo $userName; ?></div>
							<div class="js_swp_lt_screen">&#64<?php echo $userScreen; ?></div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="js_swp_lt_text">
						<a href="https://twitter.com/<?php echo $userScreen ?>/status/<?php echo $tweetId; ?>" target="_blank" rel="nofollow">
							<?php echo $tweetText; ?>
						</a>
						
					</div>
				</div>
			</div>
			<?php
		}
	}		
	$output = ob_get_clean();
	
	return $output;
}

/*
	Utilities
*/
function JAMSESSION_SWP_put_embedded_video($youtube, $vimeo) {
	if (!function_exists('JAMSESSION_SWP_getIDToEmbed')) {
		return;
	}

	$output = '';
	$website_protocol = is_ssl() ? 'https' : 'http';
	if ( $youtube != "") {
		$output = '<iframe src="'.$website_protocol.'://www.youtube.com/embed/'.JAMSESSION_SWP_getIDToEmbed(esc_url($youtube)).'?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent&amp;showinfo=0&amp;controls=2&amp;rel=0" allowfullscreen></iframe>';
	}
	else {
		if ( $vimeo != "") {
			$output = '<iframe src="'.$website_protocol.'://player.vimeo.com/video/'.JAMSESSION_SWP_getIDToEmbed(esc_url($vimeo)).'?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}
	}
	return $output;
}
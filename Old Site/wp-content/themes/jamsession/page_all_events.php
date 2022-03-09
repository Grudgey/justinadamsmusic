<?php
/*
	Template Name: All Events
*/
?>

<?php
	get_header();
?>
	
<div id="main_content">

	<?php 
	JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", "");
	
	while (have_posts()) 
	{
		the_post();

		$args = array(
			'numberposts'	=> 100,
			'posts_per_page'   => 100,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => array('event_date' => 'DESC', 'event_time' => 'DESC'),
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => 'event_date',
			'meta_value'       => '',
			'post_type'        => 'js_events',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'meta_query' => array(
				'relation' => 'AND',
				'event_date' => array(
				   'key' => 'event_date'
				),
				'event_time' => array(
				   'key' => 'event_time'
				)				
			),			
			'suppress_filters' => false
		);

		$myposts = get_posts( $args);
		
		echo '<div id="postmeta_custom">';
		echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('event_category', '', 'all'); echo "</span>";
		echo '</div>';
		
		/*events_content using $myposts var*/
		if ('masonry' == JAMSESSION_SWP_get_events_view()) {
			require_once(get_template_directory().'/views/events_content_masonry.php');
		} else {
			require_once(get_template_directory().'/views/events_content_list.php');
		}
	}
	?>
	
	<div class="clearfix"></div>
	
</div>

<?php	
	get_footer();
?>
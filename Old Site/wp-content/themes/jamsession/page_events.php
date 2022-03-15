<?php
/*
	Template Name: Events
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
			'orderby'          => array('event_date' => 'ASC', 'event_time' => 'ASC'),
			'order'            => 'ASC',
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
				   'key' => 'event_date',
				   'value' => date('Y/m/d',current_time('timestamp')),
				   'compare' => '>='
				),
				'event_time' => array(
				   'key' => 'event_time'
				)				
			),
			'suppress_filters' => false
		); 

		$myposts = get_posts( $args);
		
		echo '<div id="postmeta_custom">';
		echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('event_category'); echo "</span>";
		echo '</div>';

		/*print page content if exists*/
		$content = trim(get_the_content());
		if (!empty($content)) {
			?>
			<div class="custom_content content_before_masonry">
				<?php the_content(); ?>
			</div>
			<?php
		}
		
		/*events_content using $myposts var*/
		set_query_var('myposts', $myposts);
		if ('masonry' == JAMSESSION_SWP_get_events_view()) {
			get_template_part("/views/events_content_masonry");
		} else {
			get_template_part("/views/events_content_list");
		}
		
	}
	?>
	
	<div class="clearfix"></div>
	
</div>
	

<?php	
	get_footer();
?>
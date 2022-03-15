<?php
/*
Template Name: Archives
*/
?>

<?php
	get_header();
?>
	
<div id="main_content">
	<?php
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged'); 
		} elseif ( get_query_var('page') ) { 
			$paged = get_query_var('page'); 
		} else {
			$paged = 1; 
		}
	
		$posts_per_page = get_option('posts_per_page');
		$offset = ($paged -1) * $posts_per_page;
		
		$args = array(
			'numberposts'	=> -1,
			'posts_per_page'   => $posts_per_page,
			'paged'			   => $paged,
			'offset'           => $offset,
			'category'         => '',
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => array( 'post', 'js_videos', 'js_photo_albums'),
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => false);

		$temp = $wp_query;
		$wp_query= null;
		$wp_query = new WP_Query();
		$wp_query->query($args);
		
		require_once(get_template_directory().'/views/archives/masonry.php');

		$wp_query = null; $wp_query = $temp;
	?>

	<div class="clearfix"></div>
</div>
	

	

<?php	
	get_footer();
?>
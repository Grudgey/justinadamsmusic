<?php
/*
Template Name: Blog (only posts)
*/
?>

<?php
	get_header();
?>
	
<div id="main_content">
	<?php JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", ""); ?>

	<?php
	echo '<div id="postmeta_custom">';
	echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('category'); echo "</span>";
	echo '</div>';
	?>
	
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
				'post_type'        => array( 'post'),
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => false ); 

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
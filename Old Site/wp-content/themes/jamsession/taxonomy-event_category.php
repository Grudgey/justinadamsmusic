<?php
	get_header();
?>
	
<div id="main_content">
	
	<?php 
	JAMSESSION_SWP_put_the_title("div", JAMSESSION_SWP_get_event_tax_title(), "post_title", "");

	/*get current term name and display it properly*/
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	$events_type= get_query_var( "events", "next");
		
	if ( !empty($term))
	{
		echo '<div id="postmeta_custom">';
		echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('event_category', $term->name, $events_type); echo "</span>";
		echo '</div>';
	}

	/*decide if show past or next or all events*/
	$compare_sign = ">=";
	$orderValue = "ASC";
	if ("past" == $events_type) {
		$compare_sign = "<";
		$orderValue = "DESC";
	}

	$meta_query_value = array();
	if ("all" != $events_type) {
		$meta_query_value = array(
							array(
							   'key' => 'event_date',
							   'value' => date('Y/m/d',time()),
							   'compare' => $compare_sign
							)
						);
	}
	
	$args = array(
			'orderby'          => 'meta_value',
			'meta_key'         => 'event_date',
			'order'            => $orderValue,
			'post_type'        => 'js_events',
			'tax_query' => array(
								array(
									'taxonomy' => 'event_category',
									'field' => 'slug',
									'terms' => $term->name
								)
							),
			'meta_query' => $meta_query_value
	);
	
	$the_query = new WP_Query( $args );

	/*events_content using $myposts var*/
	if ('masonry' == JAMSESSION_SWP_get_events_view()) {
		require_once(get_template_directory().'/views/events_taxonomy_content_masonry.php');
	} else {
		require_once(get_template_directory().'/views/events_taxonomy_content_list.php');
	}
	?>

	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
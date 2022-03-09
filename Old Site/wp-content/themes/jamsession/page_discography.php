<?php
/*
	Template Name: Discography
*/
?>

<?php
	get_header();
?>
	
<div id="main_content">

	<?php JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", ""); ?>
	
	<?php
	echo '<div id="postmeta_custom">';
	echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('album_category'); echo "</span>";
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

	$masonry_cols = get_post_meta(get_the_ID(), 'js_swp_masonry_settings_meta', true);
	$cols_on_row_class = "standard_cols_no";
	if ((isset($masonry_cols)) && ("6" == $masonry_cols)) {
		$cols_on_row_class = "salvatore_six_cols";
	}

	?>	
	<div id="post_content_container" class="<?php echo esc_attr($cols_on_row_class); ?>" data-columns>
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
				'paged'			   => $paged,
				'posts_per_page'   => $posts_per_page,
				'offset'           => $offset,
				'category'         => '',
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'include'          => '',
				'exclude'          => '',
				'meta_key'         => '',
				'meta_value'       => '',
				'post_type'        => 'js_albums',
				'post_mime_type'   => '',
				'post_parent'      => '',
				'post_status'      => 'publish',
				'suppress_filters' => false ); 
		
		
		$temp = $wp_query;
		$wp_query= null;
		wp_reset_query();
		$wp_query = new WP_Query($args);
		
		if ( $wp_query->have_posts() )
		{
			while ( $wp_query->have_posts() )
			{
				$wp_query->the_post();
	?>
				<div class="post_item" >
					<?php
						if ( has_post_thumbnail() ) 
						{
							?>
							<a href="<?php the_permalink(); ?>">
								<div class="post_image_container">
									<div class="post_icon_more">
									<i class="icon-headphones"></i> 
									</div>
									<div class="post_fader"></div>
									<?php the_post_thumbnail('medium'); ?>
								</div>
							</a>
							<?php
						}
					?>
					<div class="post_item_title">
						<a href="<?php the_permalink(); ?>"> <?php the_title();?> </a>
					</div>

					<div class="album_release_date">
						<?php 
						$releaseDate = get_post_meta( get_the_ID(), 'album_release_date', true );
						@$releaseDate = str_replace("/","-", $releaseDate);
						try {
							@$mydate = new DateTime($releaseDate);
						} catch (Exception $e) {
							@$mydate = new DateTime('NOW');
						}

						if (phpversion() >= "5.3") {
							echo date_i18n(get_option('date_format'), $mydate->getTimestamp()); 
						} else {
							echo date_i18n(get_option('date_format'), $mydate->format('U')); 
						} 
						
						?>
					</div>
				</div>
	
		<?php
			} /*while*/
		?>
		<div id="content_loader"></div>		
	</div>
			<div class="page_navigation">
				<div class="alignleft"><?php next_posts_link(esc_html__('&laquo; Older posts', 'jamsession')); ?></div>
				<div class="alignleft"><?php previous_posts_link(esc_html__('Newer posts &raquo;', 'jamsession')); ?></div>
			</div>
		<?php
		}/*if*/
		$wp_query = null; $wp_query = $temp;
		?>



	
	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
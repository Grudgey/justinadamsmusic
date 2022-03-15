<?php
/*
	Template Name: Video Gallery
*/
?>

<?php
	get_header();
?>
	
<div id="main_content">
	<?php JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", ""); ?>
	
	<?php
	
	echo '<div id="postmeta_custom">';
	echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('video_category'); echo "</span>";
	echo '</div>';
	?>
	
	<div id="post_content_container">
		<?php
		while (have_posts()) 
		{
			the_post();
			$args = array(
	'numberposts'	=> 100,
	'posts_per_page'   => 100,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'js_videos',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => false ); 

			$myposts = get_posts( $args);
			

			
			foreach($myposts as $post)
			{
				setup_postdata( $post );
		?>
				<div class="post_item">
					<?php
						if ( has_post_thumbnail() ) 
						{
							?>
							<a href="<?php the_permalink(); ?>">
								<div class="post_image_container">
									<div class="post_icon_more">
										<i class="icon-play"></i>
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
				
					<div class="post_item_excerpt">
						<?php
						the_excerpt();
						?>
					</div>
					<div class="post_item_date">
						<?php
						if ( !JAMSESSION_SWP_get_hide_archive_date()) {
							echo get_the_date(); 
						}
						?>
					</div>
				</div>
	
		<?php
			}	/*foreach*/
		} /*while*/

		?>
		<div id="content_loader"></div>		
	</div>


	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
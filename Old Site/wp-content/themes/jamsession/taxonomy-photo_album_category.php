
<?php
	get_header();
?>
	
<div id="main_content">

	<?php JAMSESSION_SWP_put_the_title("div", JAMSESSION_SWP_get_photo_tax_title(), "post_title", ""); ?>
	
	<?php
	/*get current term name and display it properly*/
	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	if ( !empty($term))
	{
		echo '<div id="postmeta_custom">';
		echo ' <span class="post_cat">';  JAMSESSION_SWP_list_custom_terms_with_links('photo_album_category', $term->name); echo "</span>";
		echo '</div>';
	}
	?>
	
	<div id="post_content_container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();			
			?>
				<div <?php post_class('post_item');?> >
					<?php
						if ( has_post_thumbnail() ) 
						{
							?>
							<a href="<?php the_permalink(); ?>">
								<div class="post_image_container">
									<div class="post_icon_more">
										<i class="icon-picture"></i>
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
						<?php echo get_the_date(); ?>
					</div>
				</div>
	
			<?php
			endwhile;
			?>
	</div>
	<div class="page_navigation">
		<div class="alignleft"><?php next_posts_link(esc_html__('&laquo; Older posts', 'jamsession')); ?></div>
		<div class="alignleft"><?php previous_posts_link(esc_html__('Newer posts &raquo;', 'jamsession')); ?></div>
	</div>
		
		<?php 
		else:  
		?>
			<p><?php __( 'Sorry, no posts matched your criteria.', 'jamsession' ); ?></p>
		<?php
		endif; 
		?>

	<div class="clearfix"></div>
	
</div>
	
<?php	
	get_footer();
?>
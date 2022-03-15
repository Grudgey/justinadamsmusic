<?php
    /**
     * @var $wp_query - wp_query object
     */
?>

<?php if ($wp_query->have_posts()) { ?>
	<div id="post_content_container">
		<?php while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			
			$iconClass = '';
			switch (get_post_type()) {
				case 'js_videos':
					$iconClass = 'icon-play';
					break;
				case 'js_photo_albums':
					$iconClass = 'icon-picture';
					break;
				default:
					$iconClass = 'icon-link';
					break;
			}
			?>
			

				<div <?php post_class('post_item');?>>
					<?php if (has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>">
								<div class="post_image_container">
									<div class="post_icon_more">
										<i class="<?php echo $iconClass; ?>"></i>
									</div>
									<div class="post_fader"></div>
									<?php the_post_thumbnail('medium'); ?>
								</div>
						</a>
					<?php } ?>
					
					<div class="post_item_title">
						<a href="<?php the_permalink(); ?>"> <?php the_title();?> </a>
					</div>
				
					<div class="post_item_excerpt">
						<?php the_excerpt(); ?>
					</div>
					
					<div class="post_item_date">
						<?php echo get_the_date(get_option('date_format')); ?>
					</div>
				</div>			
				<div id="content_loader"></div>	
			
				
		<?php } /*while*/ ?>
	</div>
	
	<div class="page_navigation">
		<div class="alignleft"><?php next_posts_link(esc_html__('&laquo; Older posts', 'jamsession')); ?></div>
		<div class="alignleft"><?php previous_posts_link(esc_html__('Newer posts &raquo;', 'jamsession')); ?></div>
	</div>
		
<?php } else { ?>
	<p><?php __( 'Sorry, no posts matched your criteria.', 'jamsession' ); ?></p>
<?php }


?>

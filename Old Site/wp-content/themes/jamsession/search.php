<?php
	get_header();
?>
	
<div id="main_content">
		<div id="archive_title"> 
				<?php echo __("Search results for ","jamsession"); echo '<span class="archive_name">'.get_search_query().'</span>'; ?>
		</div>	
		<?php
	if (have_posts())
	{
	?>
		<div id="post_content_container">
		<?php
			while (have_posts()) 
			{
				the_post();
				?>
				<div <?php post_class('post_item');?> >
					<?php
						if ( has_post_thumbnail() ) 
						{
							?>
							<a href="<?php the_permalink(); ?>">
								<div class="post_image_container">
									<div class="post_icon_more">
									<?php if ( ( 'js_videos' == get_post_type()) || ( 'js_albums' == get_post_type())   )
									{ ?>
										<i class="icon-play"></i>
									<?php 
									}
									elseif ( 'js_photo_albums' == get_post_type())
									{
									?>	
										<i class="icon-picture"></i>
									<?php 
									} 
									else
									{
									?>
										<i class="icon-link"></i>
									<?php
									}
									?>
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
							if ('js_events' == get_post_type()) {
								$event_date = esc_html( get_post_meta( get_the_ID(), 'event_date', true ));
								if ("" != $event_date) {
									@$event_date = str_replace("/","-", $event_date);
									@$dateObject = new DateTime($event_date);

									?> <span class="txt_upper"> <?php
									echo date_i18n(get_option('date_format'), $dateObject->format('U'));
									?> </span> <?php
								}
							} else {
								echo get_the_date(); 
							}
						?>
					</div>
				</div>
		
		<?php 
			} /*while*/?>
		</div>
		<div class="page_navigation">
			<div class="alignleft"><?php next_posts_link(esc_html__('&laquo; Older posts', 'jamsession')); ?></div>
			<div class="alignleft"><?php previous_posts_link(esc_html__('Newer posts &raquo;', 'jamsession')); ?></div>
		</div>
	
	
		<?php
	}	/*if*/
	else
	{
		echo '<div id="post_content">';
		echo '<p>'.__('Sorry, no results were found matching your criteria. Please try something else.', 'jamsession').'</p>';
		echo '</div>';
		get_sidebar();
	}
	?>	

</div>

	<div class="clearfix"></div>
	


<?php	
	get_footer();
?>
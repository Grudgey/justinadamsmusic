<?php
	get_header();
?>
	
<div id="main_content">

	<?php 
		$arch_title = __("Posts for ","jamsession").'<span class="archive_name">'.get_the_time(get_option('date_format')).'</span>';
		JAMSESSION_SWP_put_the_title("div", $arch_title, "archive_title", "");
	?>
	
	<div id="post_content_container">
	<?php
	if (have_posts()) 
	{	
		while (have_posts()) 
		{
			the_post();
			?>
			<div <?php post_class('post_item'); ?>>
				<?php
					if ( has_post_thumbnail() ) 
					{
						?>
						<a href="<?php the_permalink(); ?>">
							<div class="post_image_container">
								<div class="post_icon_more"><i class="icon-link"></i></div>							
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
					<?php echo get_the_date(get_option('date_format')); ?>
				</div>
			</div>
	
	<?php 
		} /*while*/ ?>
		<div id="content_loader"></div>
	</div>
		<div class="page_navigation">
			<div class="alignleft"><?php next_posts_link(esc_html__('&laquo; Older posts', 'jamsession')); ?></div>
			<div class="alignleft"><?php previous_posts_link(esc_html__('Newer posts &raquo;', 'jamsession')); ?></div>
		</div>
		<?php
	}	/*if*/
	else
	{
		echo '<p>'.__('Sorry, no pages matched your criteria.', 'jamsession').'</p>';
	}
	?>	
	
	


	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
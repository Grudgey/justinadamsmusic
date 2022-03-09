<?php
	get_header();
?>
	
<div id="main_content">
	
	<div id="post_content">
	<?php
	if (have_posts()) 
	{	
		while (have_posts()) 
		{
			the_post();
			
			?><div id="post_title"><?php the_title();?></div>
			<div id="postmeta">

			</div>
			<div class="alignnone">
			
			<?php
			echo '<a href="'.wp_get_attachment_url($post->ID).'" target="_blank">';
			echo wp_get_attachment_image( $post->ID, 'full' );
			echo '</a>';
			the_content();
			
			?>
			</div>
			<div class="clearfix"></div>
			<?php
				if(function_exists('the_post_thumbnail'))
				{
					$image_string =  wp_get_attachment_url(get_post_thumbnail_id());
				}
				JAMSESSION_SWP_add_social_sharing_icons(get_permalink(), get_the_title(), $image_string);
			?>
			<div class="post_tags">
				<?php 
				$before_tag = '<span class="post_tag">'; 
				$after_tag = '</span>';
				the_tags( $before_tag, ' ', $after_tag);  
				?>
			</div>
			
			
			
	<?php  comments_template();  ?>
	
	<?php 
		} /*while*/
	}	/*if*/
	else
	{
		echo '<p>'.__('Sorry, no posts matched your criteria.', 'jamsession').'</p>';
	}
	?>	
		
	</div>

	<?php	get_sidebar();	?>

	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
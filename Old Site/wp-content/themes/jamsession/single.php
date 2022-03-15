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
			
			JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", ""); 
	?>			
			<div id="postmeta">
				 <?php 
					JAMSESSION_SWP_put_single_post_meta();
					
					if (has_category())
					{ 
						echo ' <span class="post_cat">';  the_category(' '); echo "</span>";
					}
				?> 
			</div>
			<?php
			the_content();
			
			?>
			<?php 
				$args = array(
					'before'           => '<div class="pagination_links">' . __('Pages:', 'jamsession'),
					'after'            => '</div>',
					'link_before'      => '',
					'link_after'       => '',
					'next_or_number'   => 'number',
					'nextpagelink'     => __('Next page', 'jamsession'),
					'previouspagelink' => __('Previous page', 'jamsession'),
					'pagelink'         => '%',
					'echo'             => 1
				); 
				?><div class="clearfix"></div><?php
				wp_link_pages( $args );
			?>		
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
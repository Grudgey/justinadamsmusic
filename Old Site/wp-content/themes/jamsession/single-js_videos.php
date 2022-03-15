<?php
	get_header();
?>
	
<div id="main_content">
	
	<div id="post_content_full">
	<?php
	if (have_posts()) 
	{	
		while (have_posts()) 
		{
			the_post();
			
			JAMSESSION_SWP_put_the_title("div", get_the_title(), "post_title", ""); 
	?>
			<div id="postmeta_custom">
				 <?php 

					JAMSESSION_SWP_put_single_post_meta();
					
					if (has_term( '', 'video_category' ))
					{
						echo ' <span class="post_cat">'; the_terms( get_the_ID(), 'video_category', '', ' ' ); echo "</span>"; 
					}
				?> 
			</div>

				<?php 
					$videoCssClass = "albumPromo alignright";
					if ( !get_the_content()) {
						$videoCssClass = "albumPromoFull";
					}
				
					$album_youtube = esc_html( get_post_meta( get_the_ID(), 'video_youtube_url', true ) ); 			
					$album_vimeo = esc_html( get_post_meta( get_the_ID(), 'video_vimeo_url', true ) );
					$website_protocol = is_ssl() ? 'https' : 'http';
					
					if ( $album_youtube != "")
					{
						echo '<div class="'.$videoCssClass.'">';
						echo '<iframe type="text/html" src="'.$website_protocol.'://www.youtube.com/embed/'.JAMSESSION_SWP_getIDToEmbed(esc_url($album_youtube)).'?autoplay=0&amp;enablejsapi=1&amp;wmode=transparent&amp;rel=0" frameborder="0" allowfullscreen></iframe>';
						echo '</div>';
					}
					else
					{
						if ( $album_vimeo != "")
						{
							echo '<div class="'.$videoCssClass.'">';
							echo '<iframe  type="text/html" src="'.$website_protocol.'://player.vimeo.com/video/'.JAMSESSION_SWP_getIDToEmbed(esc_url($album_vimeo)).'?autoplay=0&amp;byline=0&amp;title=0&amp;portrait=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
							echo '</div>';
						}
					}
					the_content(); 
				?>
				<?php
					if(function_exists('the_post_thumbnail'))
					{
						$image_string =  wp_get_attachment_url(get_post_thumbnail_id());
					}
					JAMSESSION_SWP_add_social_sharing_icons(get_permalink(), get_the_title(), $image_string);
				?>				
	
	
	<?php  comments_template();  ?>
	
	<?php 
		} /*while*/
	}	/*if*/
	else
	{
		echo '<p>'.__('Sorry, no pages matched your criteria.', 'jamsession').'</p>';
	}
	?>	
		
	</div>


	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
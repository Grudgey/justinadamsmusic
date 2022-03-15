<?php
/*
	Template Name: Full Width Template
*/
?>

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
			
			JAMSESSION_SWP_put_the_title("div", get_the_title(), "page_title", "");

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
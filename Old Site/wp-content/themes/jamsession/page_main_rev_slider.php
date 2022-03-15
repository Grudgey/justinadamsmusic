<?php
/*
	Template Name: Main RevSlider Page
*/
?>


<?php get_header();?>
	
<div id="nooverflow">
	<?php
		if (have_posts()) 
		{	
			while (have_posts()) 
			{
				the_post();
				
				the_content();
			}
		}
	?>	
	
	<?php 
	
		if ( JAMSESSION_SWP_has_upcoming_events())
		{
			JAMSESSION_SWP_put_upcoming_events_title();

			echo '<div id="front_page_news_bar">';
			JAMSESSION_SWP_get_next_shows();
			echo '</div>';
		}
		
	echo '<div id="front_page_footer">';
	JAMSESSION_SWP_front_page_social_profiles();
	echo '</div>';
	
	?>
</div>
	
<?php get_footer(); ?>
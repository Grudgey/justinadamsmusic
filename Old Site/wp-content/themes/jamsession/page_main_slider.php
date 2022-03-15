<?php
/*
	Template Name: Main Slider Page
*/
?>

<?php get_header();?>

	<!--Thumbnail Navigation-->
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>
	
	<!--Arrow Navigation-->
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>
	
	<?php 
		if ( JAMSESSION_SWP_has_upcoming_events())
		{
			JAMSESSION_SWP_put_upcoming_events_title();
	?>
			<div id="front_page_news_bar">
				<?php JAMSESSION_SWP_get_next_shows(); ?>
			</div>
	<?php
		}
	?>
	
	<div id="front_page_footer">
		<?php JAMSESSION_SWP_front_page_social_profiles(); ?>
	</div>
	
	
<?php get_footer(); ?>
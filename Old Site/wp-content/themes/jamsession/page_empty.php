<?php
/*
	Template Name: Empty Template
*/
?>

<?php
	get_header();
?>

<div id="full_page_container">
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
</div>
<?php	
	get_footer();
?>
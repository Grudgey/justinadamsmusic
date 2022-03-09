<?php
	get_header();
?>
	
<div id="main_content">
	
	<div id="post_content">
		<div id="page_title"><?php echo __("404 Page not found ","jamsession"); ?></div>
		<?php echo __("Sorry, the page you requested doesn't exist.", "jamsession"); ?>
		<?php echo __("Don't worry, you can try these simple things:", "jamsession"); ?>
		<ul>
			<li>
			<?php echo __("Hit your browser's back button, it'll take you back to the previous page.", "jamsession"); ?>
			</li>
			<li>
			<?php echo __("Go to the ", "jamsession"); ?><a href="<?php echo home_url(); ?>"><?php echo __("Homepage.","jamsession");?></a>
			</li>			
			<li>
			<?php echo __("If you want to report a problem, please ", "jamsession"); ?>
			<a href="<?php echo home_url(); ?>"><?php echo __("contact us.","jamsession");?></a>
			</li>				
			
		</ul>
		
	</div>

	<?php	get_sidebar();	?>

	<div class="clearfix"></div>
	
</div>
	

	

<?php	
	get_footer();
?>
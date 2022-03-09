<?php wp_reset_postdata(); ?>

<?php if ( !JAMSESSION_SWP_is_main_slider_page()) { 

	$page_id = get_the_ID();
	if (function_exists("is_shop")) {
		if (is_shop()) {
			$page_id = get_option('woocommerce_shop_page_id');
		}
	}
	?>

	<div id="canvas_image" class="js_swp_background_image_cover" data-bgimage="<?php echo JAMSESSION_SWP_get_background_image($page_id); ?>">
	</div>

<?php } else {

	$last_slide_image = JAMSESSION_SWP_get_last_slide_image();
	if ("" != $last_slide_image) {
		?>
		<div id="share_image">
			<img src="<?php echo $last_slide_image; ?>">
		</div>
		<?php
	}
}
?>
<?php

	$show_sidebar = "page_main_rev_slider.php" == basename( get_page_template()) ? false : true;


if ( $show_sidebar && 
	(is_active_sidebar('footer-sidebar-1') || 
	is_active_sidebar('footer-sidebar-2') ||
	is_active_sidebar( 'footer-sidebar-3') ||
	is_active_sidebar( 'footer-sidebar-4' ))) {
		?>

		<div id="footer_sidebars" class="js_full_container">
			<div id="footer_sidebars_inner" class="clearfloat js_full_container_inner">
				<div id="footer_sidebar1" class="lc_footer_sidebar">
					<?php 
				 	if (is_active_sidebar('footer-sidebar-1')) {
				 		dynamic_sidebar('footer-sidebar-1');
				 	}
					?>
				</div>

				<div id="footer_sidebar2" class="lc_footer_sidebar">
					<?php 
				 	if (is_active_sidebar('footer-sidebar-2')) {
				 		dynamic_sidebar('footer-sidebar-2');
				 	}
					?>
				</div>

				<div id="footer_sidebar3" class="lc_footer_sidebar">
					<?php 
				 	if (is_active_sidebar('footer-sidebar-3')) {
				 		dynamic_sidebar('footer-sidebar-3');
				 	}
					?>
				</div>

				<div id="footer_sidebar4" class="lc_footer_sidebar">
					<?php 
				 	if (is_active_sidebar('footer-sidebar-4')) {
				 		dynamic_sidebar('footer-sidebar-4');
				 	}
					?>
				</div>
			</div>
		</div>

<?php }
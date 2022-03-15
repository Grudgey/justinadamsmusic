<div class="mobile_menu_items show_on_mobile_only">
	<div class="mobile_menu_bar">
		<div id="logo_mobile">
			<?php get_template_part('views/utils/menu_logo'); ?>
		</div>

		<div class="mobile_menu_hmb in_mobile_menu_bar">
			<div class="mobile_hmb_container">
				<div class="mobile_hmb in_mobile_menu_bar">
					<span class="menu_1"></span>
					<span class="menu_2"></span>
					<span class="menu_3"></span>
				</div>
			</div>	
		</div>
	</div>

	<div class="mobile_menu_container">
		<?php wp_nav_menu(
				array( 
				'theme_location'	=> 'main-menu',				
				'container'			=> 'nav',
				'container_class'	=> 'mobile_navigation',
				'menu_class'		=> 'menu js_mobile_menu'
				) 
			); 
		?>
	</div>
</div>
<div class="mobile_menu_spacer show_on_mobile_only"></div>
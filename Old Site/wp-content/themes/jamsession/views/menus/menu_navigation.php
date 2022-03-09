<div id="menu_navigation">

	<?php if (JAMSESSION_SWP_have_social_on_menu()) {?>
	<span class="menu_social_links">
		<?php JAMSESSION_SWP_front_page_social_profiles(); ?>
	</span>
	<?php } ?>

	<?php if ( !JAMSESSION_SWP_use_mobile_menu_setting()) { ?>
	<div id="search_blog">
		<div id="display_none">
			<div id="inline_search">
				<?php get_search_form();?>
			</div>
		</div>
		<a title="<?php echo __('Search...','jamsession'); ?>" href="#TB_inline?width=500&amp;height=45&amp;inlineId=display_none" class="thickbox">
			<span>
					<i class="icon-search"></i>
			</span>
		</a>
	</div>
	<?php } ?>

	<?php
	$use_mobile_on_desk = false;

	$options = get_option('jamsession_theme_general_options');
	if (isset($options['use_mobile_menu']) &&
		($options['use_mobile_menu'] == "use_mobile_menu")) {
		
		$use_mobile_on_desk = true;
	}
	?>

	<?php if ($use_mobile_on_desk) { ?>
	<div class="mobile_menu_hmb on_desktop">
		<div class="mobile_permanent_container">
			<div class="mobile_permanent">
				<span class="menu_1 for_desk"></span>
				<span class="menu_2 for_desk"></span>
				<span class="menu_3 for_desk"></span>
			</div>
		</div>	
	</div>
	<?php } ?>

	<?php 
	if( !JAMSESSION_SWP_use_mobile_menu_setting()) {
		wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'main_menu') ); 
	}
	?>


</div>

<?php
$sticky_enabled = false;

$options = get_option('jamsession_theme_general_options');
if(isset($options['disable_sticky_menu'])) {
    if ("keep_sticky" == $options['disable_sticky_menu']) {
		$sticky_enabled = true;
    }
}
?>

<?php if ($sticky_enabled) { ?>
<div class="desk_menu_spacer"></div>
<?php } ?>
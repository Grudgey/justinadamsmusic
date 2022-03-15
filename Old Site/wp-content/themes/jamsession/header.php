<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo('name'); ?> | <?php (is_home() || is_front_page()) ? bloginfo('description') : wp_title('');  ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
	<?php JAMSESSION_SWP_put_favicon(); ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php add_thickbox(); ?>
	<?php wp_head(); ?>
</head>

<body  <?php body_class(); ?> >
	<?php
	if (JAMSESSION_SWP_use_mobile_menu_setting()) 
	{
		echo '<div class="use_mobile">';
		wp_nav_menu( array( 'theme_location' => 'main-menu', 'container_id' => 'main_menu') ); 
		echo '</div>';
	}
	?>

	<div class="wraper">

		<div id="header">
			<?php get_template_part('views/menus/mobile_menu'); ?>

			<div id="logo">
				<?php get_template_part('views/utils/menu_logo'); ?>
			</div>
			
			<?php get_template_part('views/menus/menu_navigation'); ?>
		</div>
		
		<?php JAMSESSION_SWP_put_page_title_for_mobile_menu(); ?>
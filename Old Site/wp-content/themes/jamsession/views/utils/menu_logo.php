<?php
	/* custom logo */
	$custom_logo = 0;
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( !empty( $general_options['logo_select'])) {
		if ("custom_image" == $general_options['logo_select']) 	{
			if ( !empty(  $general_options['logo_upload_value'])) {
				?>

				<a href="<?php echo home_url(); ?>"> <img src="<?php echo $general_options['logo_upload_value']; ?>" alt="<?php bloginfo('name'); ?>"> </a>

				<?php
				$custom_logo = 1; 
			}
		}
	}
	
	if (0 == $custom_logo) {
		?>
			<a href="<?php echo home_url(); ?>"> <?php bloginfo('name'); ?></a>
		<?php
	}
?>
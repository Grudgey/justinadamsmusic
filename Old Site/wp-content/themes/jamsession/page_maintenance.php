<?php
/*
	Template Name: Maintenance Page
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php bloginfo('name'); ?> | <?php (is_home() || is_front_page()) ? bloginfo('description') : wp_title('');  ?></title>
		<meta name="description" content="<?php bloginfo( 'description' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
		<?php
			$general_options = get_option( 'jamsession_theme_general_options' );
			
			/* custom favicon */
			if ( !empty(  $general_options['favicon_upload_value']))
			{
				echo '<link rel="shortcut icon" href="'.$general_options['favicon_upload_value'].'" type="image/x-icon" />';
			}
			else
			{
				?>
				<link rel="shortcut icon" href="<?php echo get_template_directory_uri().'/images/favicon.ico'; ?>" type="image/x-icon" />
				<?php		
			}
			
		?>
		<?php wp_head(); ?>
	</head>

	<body  <?php body_class(); ?>>
		<div class="wraper">

			
			<?php
			if (have_posts()) 
			{	
				while (have_posts()) 
				{
					the_post();

					if(function_exists('the_post_thumbnail'))
					{
						$image_string =  wp_get_attachment_url(get_post_thumbnail_id());
					}
					
					if ( $image_string != "") {
					?>
						<div id="canvas_image">
							<img src="<?php echo $image_string; ?>">
						</div>
						<div class="img_overlay"></div>
					<?php 
					}
					?>
					
					<div id="maintenance_container">
						<div id="maintenance_logo">
							<?php
								/* custom logo */
								$custom_logo = 0;

								if ( !empty( $general_options['logo_select']))
								{
															
									if ("custom_image" == $general_options['logo_select'])
									{
										if ( !empty(  $general_options['logo_upload_value']))
										{
											?>
											<a href="<?php echo home_url(); ?>"> <img src="<?php echo $general_options['logo_upload_value']; ?>" alt="<?php bloginfo('name'); ?>"> </a>
											<?php
											$custom_logo = 1;
										}
									}
								}
								
								if (0 == $custom_logo)
								{
									?>
										<a href="<?php echo home_url(); ?>"> <?php bloginfo('name'); ?></a>
									<?php
								}
							?>
						</div>					
						
						<div id="maintenance_title"><?php the_title();?></div>

						<div class="maintenance_content">
							<?php
								the_content();
							?>
						</div>
						
						<div class="maintenance_social">
							<?php JAMSESSION_SWP_front_page_social_profiles(); ?>
						</div>
					</div>

			<?php 
				} /*while have posts*/
			} /* if have posts*/		
			?>
			
			
		</div> <!-- wraper -->
		<?php wp_footer(); ?>
	</body>
</html>

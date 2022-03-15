<?php

if (!function_exists( 'JAMSESSION_SWP_setup_admin_menus')) {
    function JAMSESSION_SWP_setup_admin_menus()
    {  

    	add_theme_page(
            'Jam Session Theme Settings', /* page title*/
    		'Jam Session Settings',  /* menu title */
    		'administrator',    /*capability*/
            'jamsession_menu_page',  /*menu_slug*/
    		'JAMSESSION_SWP_option_page_settings'  /*function */
    		);		
    }
}

/*add theme settings to admin bar*/
function JAMSESSION_SWP_add_settings_to_adminbar($admin_bar) {

    $admin_bar->add_menu( 
        array(
        'id'    => 'jamsession-settings',
        'title' => esc_html__("JamSession Settings", "jamsession"),
        'href'  => admin_url( 'themes.php?page=jamsession_menu_page'),
        'meta'  => array(
            'title' => esc_html__("Go To Jamsession Settings", "jamsession")
            )
        )
    );
}
add_action('admin_bar_menu', 'JAMSESSION_SWP_add_settings_to_adminbar', 9999);

// This tells WordPress to call the function named "setup_theme_admin_menus"  when it's time to create the menu pages.  
add_action("admin_menu", "JAMSESSION_SWP_setup_admin_menus");
function JAMSESSION_SWP_option_page_settings() {
?>  
    <!-- Create a header in the default WordPress 'wrap' container -->  
    <div class="wrap js_swp_settings">
  
        <!-- Add the icon to the page -->  
        <div id="icon-themes" class="icon32"></div>  
        <h2>Jam Session Theme Settings</h2>  
  
        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->  
        <?php settings_errors(); ?> 
		
		<?php  
		if( isset( $_GET[ 'tab' ] ) ) 
		{
			$active_tab = $_GET[ 'tab' ];  
		}
		else
		{
		    $active_tab = 'general_options';
		}
		// end if  
		?>  		
		
		<h2 class="nav-tab-wrapper"> 
			<a href="?page=jamsession_menu_page&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>">General Options</a>	
			<a href="?page=jamsession_menu_page&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social Options</a>  
			<a href="?page=jamsession_menu_page&tab=footer_options" class="nav-tab <?php echo $active_tab == 'footer_options' ? 'nav-tab-active' : ''; ?>">Footer Options</a>  
			<a href="?page=jamsession_menu_page&tab=font_options" class="nav-tab <?php echo $active_tab == 'font_options' ? 'nav-tab-active' : ''; ?>">Fonts</a>
		</h2> 		
  
        <!-- Create the form that will be used to render our options -->  
        <form method="post" action="options.php"> 
			<?php
				if ( $active_tab == 'general_options') {
					settings_fields( 'jamsession_theme_general_options' ); 
					do_settings_sections( 'jamsession_theme_general_options' );
				}
				elseif( $active_tab == 'social_options' ) {
					settings_fields( 'jamsession_theme_social_options' ); 
					do_settings_sections( 'jamsession_theme_social_options' );
				}
				elseif ( $active_tab == 'footer_options') {
					settings_fields( 'jamsession_theme_footer_options' ); 
					do_settings_sections( 'jamsession_theme_footer_options' );
				}
				elseif ( $active_tab == 'font_options') {
					settings_fields( 'jamsession_theme_font_options' ); 
					do_settings_sections( 'jamsession_theme_font_options' );
				}
				submit_button(); 
			?>  
        </form>  
  
    </div><!-- /.wrap -->  
<?php  
}

define("JS_SWP_PRINT_SETTINGS", false);

add_action('admin_init', 'JAMSESSION_SWP_initialize_theme_options');
/** 
 * Initializes the theme's social options by registering the Sections, 
 * Fields, and Settings. 
 * 
 * This function is registered with the 'admin_init' hook. 
 */ 
function JAMSESSION_SWP_initialize_theme_options()
{ 
	// If the social options don't exist, create them. 
	if( false == get_option( 'jamsession_theme_general_options' ) ) 
	{    
		add_option( 'jamsession_theme_general_options' );  
	}
	
	if( false == get_option( 'jamsession_theme_social_options' ) ) 
	{    
		add_option( 'jamsession_theme_social_options' );  
	}

	// If the social options don't exist, create them.  
	if( false == get_option( 'jamsession_theme_footer_options' ) ) 
	{    
		add_option( 'jamsession_theme_footer_options' );  
	} 

	if (false == get_option( 'jamsession_theme_font_options')) {    
		add_option('jamsession_theme_font_options');
	}

	add_settings_section(  
		'jamsession_general_settings_section',          // ID used to identify this section and with which to register options  
		'General Settings',                   // Title to be displayed on the administration page  
		'JAMSESSION_SWP_general_options_callback',  // Callback used to render the description of the section
		'jamsession_theme_general_options'      // Page on which to add this section of options  
	);	
	
	add_settings_section(  
		'jamsession_social_settings_section',          // ID used to identify this section and with which to register options  
		'Social Media Settings',                   // Title to be displayed on the administration page  
		'JAMSESSION_SWP_social_options_callback',  // Callback used to render the description of the section
		'jamsession_theme_social_options'      // Page on which to add this section of options  
	);
	
	add_settings_section(  
		'jamsession_footer_settings_section',          // ID used to identify this section and with which to register options  
		'Footer Settings',                   // Title to be displayed on the administration page  
		'JAMSESSION_SWP_footer_options_callback',  // Callback used to render the description of the section
		'jamsession_theme_footer_options'      // Page on which to add this section of options  
	);

	add_settings_section(  
		'jamsession_font_settings_section',          // ID used to identify this section and with which to register options  
		'Font Settings',                   // Title to be displayed on the administration page  
		'JAMSESSION_SWP_font_options_callback',  // Callback used to render the description of the section
		'jamsession_theme_font_options'      // Page on which to add this section of options  
	);	
	
	/*=========== ADD SETTINGS  ========================*/
	/* GENERAL OPTIONS */
    add_settings_field(   
        'logo_select',          					// ID used to identify the field throughout the theme                
        'Logo Type',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_logo_select_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    ); 
    add_settings_field(   
        'logo_upload_value',          					// ID used to identify the field throughout the theme                
        'Select Logo',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_logo_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    ); 
    add_settings_field(   
        'logo_upload_preview',          					// ID used to identify the field throughout the theme                
        'Preview Logo',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_logo_preview_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    ); 	
    add_settings_field(   
        'favicon_upload_value',          					// ID used to identify the field throughout the theme                
        'Select Favicon',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_favicon_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
    add_settings_field(   
        'favicon_upload_preview',          					// ID used to identify the field throughout the theme                
        'Preview Favicon',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_favicon_preview_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
	
    add_settings_field(   
        'use_mobile_menu',          					// ID used to identify the field throughout the theme                
        'Use Mobile Menu',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_use_mobile_menu', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
    add_settings_field(   
        'add_social_to_menu',          					// ID used to identify the field throughout the theme                
        'Add Social Icons To Menu',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_add_social_to_menu', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );	    	

    add_settings_field(   
        'contact_form_email',          					// ID used to identify the field throughout the theme                
        'Contact Form Email',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_contact_form_email', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
	
    add_settings_field(   
        'remove_default_background',
        'Remove Default Background Image',
        'JAMSESSION_SWP_remove_default_bgimg_callback',
        'jamsession_theme_general_options',
        'jamsession_general_settings_section'
    );	
	
    add_settings_field(   
        'bgimage_upload_value',          					// ID used to identify the field throughout the theme                
        'Select Background Image',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_bgimage_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    ); 
    add_settings_field(   
        'bgimage_upload_preview',          					// ID used to identify the field throughout the theme                
        'Preview Background Image',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_bgimage_preview_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
	
    add_settings_field(   
        'hide_upcoming_events',          					// ID used to identify the field throughout the theme                
        'Hide Upcoming Events',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_hide_upcoming_events_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
	
    add_settings_field(   
        'upcoming_events_title',          					// ID used to identify the field throughout the theme                
        'Upcoming Events Bar Title',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_upcoming_events_title_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );
	
    add_settings_field(   
        'upcoming_events_shows',          					// ID used to identify the field throughout the theme                
        'Upcoming Events Bar Shows',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_upcoming_events_shows_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    );		
	
    add_settings_field(   
        'recaptcha_public_key',          					// ID used to identify the field throughout the theme                
        'Recaptcha Site Key',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_recaptcha_public_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    ); 	

    add_settings_field(   
        'recaptcha_private_key',          					// ID used to identify the field throughout the theme                
        'Recaptcha Secret Key',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_recaptcha_private_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_general_options',   	// The page on which this option will be displayed  
        'jamsession_general_settings_section'    // The name of the section to which this field belongs  
    ); 	

	add_settings_field(   
	'slider_image_protect',          					// ID used to identify the field throughout the theme                
	'Slider Image Protect',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_slider_image_protect', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    ); 		

	add_settings_field(   
	'slider_interval',          					// ID used to identify the field throughout the theme                
	'Slider Interval',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_slider_interval', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    );
	
	add_settings_field(   
	'slider_transition',
	'Slider Transition Effect',
	'JAMSESSION_SWP_slider_transition',
	'jamsession_theme_general_options',
	'jamsession_general_settings_section'
    ); 		

	add_settings_field(   
	'maintenance_mode',          					// ID used to identify the field throughout the theme                
	'Maintenance Mode',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_maintenance_mode', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    ); 
	
	add_settings_field(   
	'maintenance_page',          					// ID used to identify the field throughout the theme                
	'Maintenance Page',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_maintenance_page', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    ); 	
		
	add_settings_field(   
	'hide_post_meta',          					// ID used to identify the field throughout the theme                
	'Hide Post Meta',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_hide_post_meta', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    );
	
	add_settings_field(   
	'hide_archive_date',          					// ID used to identify the field throughout the theme                
	'Hide Archive Pages Date ',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_hide_archive_date', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    ); 	

	add_settings_field(   
	'disable_sticky_menu',          					// ID used to identify the field throughout the theme                
	'Disable Sticky Menu',		// The label to the left of the option interface element            
	'JAMSESSION_SWP_disable_sticky_menu', 		// The name of the function responsible for rendering the option interface
	'jamsession_theme_general_options',   				// The page on which this option will be displayed  
	'jamsession_general_settings_section'    			// The name of the section to which this field belongs  
    );
	
	add_settings_field(   
	'back_to_top',
	'Back To Top Button',
	'JAMSESSION_SWP_back_to_top',
	'jamsession_theme_general_options',
	'jamsession_general_settings_section'
    );
	
	add_settings_field(   
	'hide_social_sharing',
	'Hide Social Sharing Icons',
	'JAMSESSION_SWP_hide_social_sharing_cbk',
	'jamsession_theme_general_options',
	'jamsession_general_settings_section'
    );	

    add_settings_field(   
    'js_woo_sidebar',
    'Add WooCommerce Sidebar',
    'JAMSESSION_SWP_js_woo_sidebar_cbk',
    'jamsession_theme_general_options',
    'jamsession_general_settings_section'
    );
	
	add_settings_field(   
	'photo_tax_title',          					
	'Photos Taxonomy Title',		
	'JAMSESSION_SWP_photo_tax_title', 		
	'jamsession_theme_general_options', 
	'jamsession_general_settings_section'
    ); 
	
	add_settings_field(   
	'album_tax_title',          					
	'Albums Taxonomy Title',		
	'JAMSESSION_SWP_album_tax_title', 		
	'jamsession_theme_general_options', 
	'jamsession_general_settings_section'
    );
	
	add_settings_field(   
	'event_tax_title',          					
	'Events Taxonomy Title',		
	'JAMSESSION_SWP_event_tax_title', 		
	'jamsession_theme_general_options', 
	'jamsession_general_settings_section'
    );	
	
	add_settings_field(   
	'video_tax_title',          					
	'Videos Taxonomy Title',		
	'JAMSESSION_SWP_video_tax_title',
	'jamsession_theme_general_options', 
	'jamsession_general_settings_section'
    );

	add_settings_field(   
	'events_view',          					
	'View Events Pages As',		
	'JAMSESSION_SWP_events_view',
	'jamsession_theme_general_options', 
	'jamsession_general_settings_section'
    );	
	
	
	/* SOCIAL OPTIONS */
    add_settings_field(   
        'twitter',          					// ID used to identify the field throughout the theme                
        'Twitter URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_twitter_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    ); 
    add_settings_field(   
        'facebook',          					// ID used to identify the field throughout the theme                
        'Facebook URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_facebook_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );
    add_settings_field(   
        'google_plus',          					// ID used to identify the field throughout the theme                
        'Google+ URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_google_plus_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    ); 
    add_settings_field(   
        'youtube',          					// ID used to identify the field throughout the theme                
        'YouTube URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_youtube_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );
    add_settings_field(   
        'vimeo',          					// ID used to identify the field throughout the theme                
        'Vimeo URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_vimeo_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );   	
    add_settings_field(   
        'soundcloud',          					// ID used to identify the field throughout the theme                
        'SoundCloud URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_soundcloud_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );   	
    add_settings_field(   
        'myspace',          					// ID used to identify the field throughout the theme                
        'Myspace URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_myspace_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );
   	add_settings_field(   
        'flickr',          					// ID used to identify the field throughout the theme                
        'Flickr URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_flickr_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );
	
   	add_settings_field(   
        'pinterest',          					// ID used to identify the field throughout the theme                
        'Pinterest URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_pinterest_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );   	
   	add_settings_field(   
        'instagram',          					// ID used to identify the field throughout the theme                
        'Instagram URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_instagram_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );

   	add_settings_field(   
        'itunes',          					// ID used to identify the field throughout the theme                
        'iTunes URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_itunes_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );

   	add_settings_field(   
        'spotify',          					// ID used to identify the field throughout the theme                
        'Spotify URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_spotify_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );

   	add_settings_field(   
        'tumblr',          					// ID used to identify the field throughout the theme                
        'Tumblr URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_tumblr_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );	
	
   	add_settings_field(   
        'rnation',          					// ID used to identify the field throughout the theme                
        'ReverbNation URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_rnation_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );	

	add_settings_field(   
		'bandcamp',          					// ID used to identify the field throughout the theme                
		'BandCamp URL',               // The label to the left of the option interface element            
		'JAMSESSION_SWP_bandcamp_callback', 			// The name of the function responsible for rendering the option interface
		'jamsession_theme_social_options',   	// The page on which this option will be displayed  
		'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );
	
	add_settings_field(   
		'linkedin',
		'LinedIn URL',
		'JAMSESSION_SWP_linkedin_callback',
		'jamsession_theme_social_options',
		'jamsession_social_settings_section'
    );
	
	add_settings_field(   
		'mixcloud',
		'Mixcloud URL',
		'JAMSESSION_SWP_mixcloud_callback',
		'jamsession_theme_social_options',
		'jamsession_social_settings_section'
    );		
	
	
   	add_settings_field(   
        'custom',          					// ID used to identify the field throughout the theme                
        'Custom Social Network URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_custom_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_social_options',   	// The page on which this option will be displayed  
        'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );	

	add_settings_field(   
		'custom_name',          					// ID used to identify the field throughout the theme                
		'Custom Social Network Name',               // The label to the left of the option interface element            
		'JAMSESSION_SWP_custom_name_callback', 			// The name of the function responsible for rendering the option interface
		'jamsession_theme_social_options',   	// The page on which this option will be displayed  
		'jamsession_social_settings_section'    // The name of the section to which this field belongs  
    );	
	
	/* -------------------- footer options -------------------- */
    add_settings_field(   
        'footer_text',          					// ID used to identify the field throughout the theme                
        'Footer Text',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_footer_text_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_footer_options',   	// The page on which this option will be displayed  
        'jamsession_footer_settings_section'    // The name of the section to which this field belongs  
    );

    add_settings_field(   
        'footer_text_url',          					// ID used to identify the field throughout the theme                
        'Footer Text URL',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_footer_text_url_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_footer_options',   	// The page on which this option will be displayed  
        'jamsession_footer_settings_section'    // The name of the section to which this field belongs  
    );	
	
    add_settings_field(   
        'analytics_code',          					// ID used to identify the field throughout the theme                
        'Analytics Code',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_analytics_code_callback', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_footer_options',   	// The page on which this option will be displayed  
        'jamsession_footer_settings_section'    // The name of the section to which this field belongs  
    );

    /* -------------------- font options -------------------- */
    add_settings_field(   
        'fonts_custom_default',
        'Fonts In Use',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_fonts_custom_default_cbk', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_font_options',   	// The page on which this option will be displayed  
        'jamsession_font_settings_section'    // The name of the section to which this field belongs  
    );

	add_settings_field(
        'primary_font',
        'Custom Primary Font',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_primary_font_cbk', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_font_options',   	// The page on which this option will be displayed  
        'jamsession_font_settings_section'    // The name of the section to which this field belongs  
    );
	add_settings_field(
        'secondary_font',
        'Custom Secondary Font',                				// The label to the left of the option interface element            
        'JAMSESSION_SWP_secondary_font_cbk', 			// The name of the function responsible for rendering the option interface
        'jamsession_theme_font_options',   	// The page on which this option will be displayed  
        'jamsession_font_settings_section'    // The name of the section to which this field belongs  
    );    


	/*=========== REGISTER SETTINGS  ========================*/
	register_setting(  
		'jamsession_theme_general_options',  	//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'jamsession_theme_general_options',  		// option_name -  The name of an option to sanitize and save. 
		'JAMSESSION_SWP_sanitize_general_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);		
    register_setting(  
		'jamsession_theme_social_options',  	//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'jamsession_theme_social_options',  		// option_name -  The name of an option to sanitize and save. 
		'JAMSESSION_SWP_sanitize_social_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);
    register_setting(  
		'jamsession_theme_footer_options',  	//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'jamsession_theme_footer_options',  		// option_name -  The name of an option to sanitize and save. 
		'JAMSESSION_SWP_sanitize_footer_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);
	register_setting(
		'jamsession_theme_font_options',  	//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'jamsession_theme_font_options',  		// option_name -  The name of an option to sanitize and save. 
		'JAMSESSION_SWP_sanitize_font_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);	

} // end  jamsession_initialize_social_options
 

function JAMSESSION_SWP_general_options_callback()
{
	echo '<p>Setup custom logo and favicon.</p>';

	/*print theme settings*/
	if (JS_SWP_PRINT_SETTINGS) {
		$general = get_option( 'jamsession_theme_general_options' );
		
		echo '<pre>jamsession_theme_general_options:';
		echo (json_encode($general));
		echo '</pre>';
	}
}
 
function JAMSESSION_SWP_social_options_callback()
{
	echo '<p>Provide the URL to the social networks you\'d like to display.</p>';
	
}

function JAMSESSION_SWP_footer_options_callback()
{
	echo '<p>Setup footer text, footer text URL and analytics code.</p>';
}

function JAMSESSION_SWP_font_options_callback() {
	echo '<p>Choose theme fonts.</p>';
}

/*================== ADD SETTING CALLBACKS BEGIN =====================*/
/*==================================================================*/
function JAMSESSION_SWP_logo_select_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $logo = ''; 
    if( isset( $options['logo_select'] ) ) 
	{ 
        $logo = $options['logo_select']; 
    } // end if 

    // Render the output 
	echo '<select id="logo_select" name="jamsession_theme_general_options[logo_select]">';
	if ( ( $logo == "")||($logo == "blog_title")) 
	{
		echo '<option value="blog_title" selected="selected">Blog Title</option>';
		echo '<option value="custom_image">Custom Logo Image</option>';
	}
	else
	{
		echo '<option value="blog_title" >Blog Title</option>';
		echo '<option value="custom_image" selected="selected">Custom Logo Image</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Use the blog title as text based logo, or add your custom logo image.</p>';
	
}

function JAMSESSION_SWP_logo_callback()
{
   // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $logo = ''; 
    if( isset( $options['logo_upload_value'] ) ) 
	{ 
        $logo = $options['logo_upload_value']; 
    } // end if 
     
    // Render the output
	echo '<input id="logo_upload_value" type="text" name="jamsession_theme_general_options[logo_upload_value]" size="150" value="'.esc_url($logo).'"/>';  
    echo '<input id="upload_logo_button" type="button" class="button" value="Upload Logo" />';  
    echo '<p class="description">Upload an image for logo. Recommended image width: 200px.</p>';  	
}

function JAMSESSION_SWP_logo_preview_callback()
{
// First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $logo = ''; 
    if( isset( $options['logo_upload_value'] ) ) 
	{ 
        $logo = $options['logo_upload_value']; 
    } // end if 
     
    // Render the output
?>
	<div id="logo_upload_preview" style="min-height: 100px;">  
        <img style="max-width:100%;" src="<?php echo esc_url($logo); ?>" />  
    </div> 
<?php	
}

function JAMSESSION_SWP_favicon_callback()
{
   // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $favicon = ''; 
    if( isset( $options['favicon_upload_value'] ) ) 
	{ 
        $favicon = $options['favicon_upload_value']; 
    } // end if 
     
    // Render the output
	echo '<input id="favicon_upload_value" type="text" name="jamsession_theme_general_options[favicon_upload_value]"  value="'.esc_url( $favicon).'" size="150"/>';
    echo '<input id="upload_favicon_button" type="button" class="button" value="Upload Favicon" />';  
    echo '<p class="description">Upload an image for favicon.</p>';  	
}

function JAMSESSION_SWP_favicon_preview_callback()
{
// First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $favicon = ''; 
    if( isset( $options['favicon_upload_value'] ) ) 
	{ 
        $favicon = $options['favicon_upload_value']; 
    } // end if 
     
    // Render the output
?>
	<div id="favicon_upload_preview" style="min-height: 100px;">  
        <img style="max-width:100%;" src="<?php echo esc_url($favicon); ?>" />  
    </div> 
<?php	
}

function JAMSESSION_SWP_use_mobile_menu()
{
    $options = get_option( 'jamsession_theme_general_options' );  
      
    $use_mobile_menu = ''; 
    if( isset( $options['use_mobile_menu'] ) ) 
	{ 
        $use_mobile_menu = $options['use_mobile_menu']; 
    }

	echo '<select id="use_mobile_menu" name="jamsession_theme_general_options[use_mobile_menu]">';
	if ( ( $use_mobile_menu == "")||($use_mobile_menu == "use_normal_menu")) 
	{
		echo '<option value="use_normal_menu" selected="selected">Use Normal Menu</option>';
		echo '<option value="use_mobile_menu">Use Mobile Menu</option>';
	}
	else
	{
		echo '<option value="use_normal_menu" >Use Normal Menu</option>';
		echo '<option value="use_mobile_menu" selected="selected">Use Mobile Menu</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Use mobile menu on every screen resolution.</p>';
}

function JAMSESSION_SWP_add_social_to_menu() {
	$options = get_option('jamsession_theme_general_options');

	$add_icons = 'no';
    if (isset($options['add_social_to_menu'])) { 
        $add_icons = $options['add_social_to_menu']; 
    }

	$add_options = array(
		esc_html__('No - Menu Without Icons', 'jamsession')	=> 'no',
		esc_html__('Yes - Add Icons To Menu', 'jamsession')	=> 'yes'
	);	
?>
	<select id="add_social_to_menu" name="jamsession_theme_general_options[add_social_to_menu]">
		<?php JAMSESSION_SWP_render_select_options($add_options, $add_icons); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Add social icons with links to your social profiles to the menu. This option does not apply to the mobile menu.', 'jamsession'); ?>
	</p>
<?php
}

function JAMSESSION_SWP_bgimage_callback()
{
   // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $bgimage = ''; 
    if( isset( $options['bgimage_upload_value'] ) ) 
	{ 
        $bgimage = $options['bgimage_upload_value']; 
    } // end if 
     
    // Render the output
	echo '<input id="bgimage_upload_value" type="text" name="jamsession_theme_general_options[bgimage_upload_value]"  value="'.esc_url( $bgimage).'" size="150"/>';
    echo '<input id="upload_bgimage_button" type="button" class="button" value="Upload Background Image" />';  
    echo '<p class="description">Upload a custom image for background.</p>';  	
}

function JAMSESSION_SWP_bgimage_preview_callback()
{
// First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $bgimage = ''; 
    if( isset( $options['bgimage_upload_value'] ) ) 
	{ 
        $bgimage = $options['bgimage_upload_value']; 
    } // end if 
     
    // Render the output
?>
	<div id="bgimage_upload_preview" style="min-height: 100px;">  
        <img style="max-width:200px; height: auto;" src="<?php echo esc_url($bgimage); ?>" />  
    </div> 
<?php	
}

function  JAMSESSION_SWP_remove_default_bgimg_callback() {
	$options = get_option( 'jamsession_theme_general_options' );

	$removeDefaBg = '';
    if( isset( $options['remove_default_background'])) { 
        $removeDefaBg = $options['remove_default_background']; 
    }
	
	echo '<select id="remove_default_background" name="jamsession_theme_general_options[remove_default_background]">';
	if ( ( $removeDefaBg == "")||($removeDefaBg == "not_remove_bgimg")) 
	{
		echo '<option value="not_remove_bgimg" selected="selected">Do Not Remove Default Background Image</option>';
		echo '<option value="remove_bgimg">Remove Default Background Image</option>';
	}
	else
	{
		echo '<option value="not_remove_bgimg" >Do Not Remove Default Background Image</option>';
		echo '<option value="remove_bgimg" selected="selected">Remove Default Background Image</option>';
	}
	echo '</select>';

?>	
	<p class="description">
		Remove the default background image. If you want to use a different image as background, leave this untouched and click on Upload Background Image button below. <br>
		<span style="color: #0074a2;">Remove the default background image only if you plan to set a solid color as website background. </span> <br>
		To set a color as background for your website, please set this option to Remove Default Background Image, save the settings, then go to Appearance - Customize - Colors - Background Color.
	</p>
<?php	
}

function JAMSESSION_SWP_hide_upcoming_events_callback()
{
    $options = get_option( 'jamsession_theme_general_options' );  
      
    $hide = ''; 
    if( isset( $options['hide_upcoming_events'] ) ) 
	{ 
        $hide = $options['hide_upcoming_events']; 
    }

    // Render the output 
	echo '<select id="hide_upcoming_events" name="jamsession_theme_general_options[hide_upcoming_events]">';
	if ( ( $hide == "")||($hide == "hide_no")) 
	{
		echo '<option value="hide_no" selected="selected">Do Not Hide</option>';
		echo '<option value="hide_yes">Hide</option>';
	}
	else
	{
		echo '<option value="hide_no" >Do Not Hide</option>';
		echo '<option value="hide_yes" selected="selected">Hide</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Hide Upcoming Events bottom tab on the main page.</p>';	
}

function JAMSESSION_SWP_upcoming_events_title_callback() 
{
    $options = get_option( 'jamsession_theme_general_options' );  

	$title = 'Upcoming Events';
    if( isset( $options['upcoming_events_title'] ) ) 
	{ 
        $title = $options['upcoming_events_title']; 
    }
	
	echo '<input id="upcoming_events_title" type="text" name="jamsession_theme_general_options[upcoming_events_title]"  value="'.esc_html($title).'" size="150"/>'; 
	echo '<p class="description">Title for upcoming events bar on the Main Slider Page and Main RevSlider Page templates.</p>';
}

function JAMSESSION_SWP_upcoming_events_shows_callback() {
    $options = get_option( 'jamsession_theme_general_options' );  
      
    $optionToShow = ""; 
    if( isset( $options['upcoming_events_shows'] ) ) 
	{ 
        $optionToShow = $options['upcoming_events_shows']; 
    }

    // Render the output 
	echo '<select id="upcoming_events_shows" name="jamsession_theme_general_options[upcoming_events_shows]">';
	if ( ( $optionToShow == "")||($optionToShow == "date_and_venue")) 
	{
		echo '<option value="date_and_venue" selected="selected">Date&amp;Venue</option>';
		echo '<option value="date_and_title">Date&amp;Title</option>';
	}
	else
	{
		echo '<option value="date_and_venue" >Date&amp;Venue</option>';
		echo '<option value="date_and_title" selected="selected">Date&amp;Title</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Choose what Upcoming Events bottom tab on the main page displays.</p>';	
}

/*
	Old:	 public key	
	Current: site key
*/
function JAMSESSION_SWP_recaptcha_public_callback(){
	$options = get_option( 'jamsession_theme_general_options' );  

	$pKey = '';     
	if( isset( $options['recaptcha_public_key'] ) ) {
		$pKey = $options['recaptcha_public_key'];     
	}
	
	echo '<input id="recaptcha_public_key" type="text" name="jamsession_theme_general_options[recaptcha_public_key]"  value="'.esc_html( $pKey).'" size="150"/>'; 	
	echo '<p class="description">Insert recaptcha <strong>site key</strong> - live it empty if you do not want recapthca validation on contact form.</p>';  	
}

/*
	Old:	 private key	
	Current: secret key
*/
function JAMSESSION_SWP_recaptcha_private_callback()
{
// First, we read the social options collection  
    $options = get_option( 'jamsession_theme_general_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $pKey = ''; 
    if( isset( $options['recaptcha_private_key'] ) ) 
	{ 
        $pKey = $options['recaptcha_private_key']; 
    } // end if 
     
    // Render the output

	echo '<input id="recaptcha_private_key" type="text" name="jamsession_theme_general_options[recaptcha_private_key]"  value="'.esc_html( $pKey).'" size="150"/>'; 
	echo '<p class="description">Insert recaptcha <strong>secret key</strong> - live it empty if you do not want recapthca validation on contact form.</p>';  	
}

function JAMSESSION_SWP_slider_image_protect()
{
    $options = get_option( 'jamsession_theme_general_options' );  
      
    $protect = ''; 
    if( isset( $options['slider_image_protect'] ) ) 
	{ 
        $protect = $options['slider_image_protect']; 
    }

    // Render the output 
	echo '<select id="slider_image_protect" name="jamsession_theme_general_options[slider_image_protect]">';
	if ( ( $protect == "")||($protect == "allow_click")) 
	{
		echo '<option value="allow_click" selected="selected">Allow Right Click</option>';
		echo '<option value="prevent_click">Prevent Right Click</option>';
	}
	else
	{
		echo '<option value="allow_click">Allow Right Click</option>';
		echo '<option value="prevent_click" selected="selected">Prevent Right Click</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Slider image protect option - prevent right mouse click on slider - only for the built in slider.</p>';		
}

function JAMSESSION_SWP_slider_interval()
{
	 $options = get_option( 'jamsession_theme_general_options' );
	 
	 $interval = '';
    if( isset( $options['slider_interval'] ) ) 
	{ 
        $interval = $options['slider_interval'];
    }
	
	if ( !ctype_digit($interval) || ( $interval > 10000) || ($interval < 1000))
	{
		$interval = 10000;
	}
	
	echo '<input type="text" size="150 id="slider_interval" name="jamsession_theme_general_options[slider_interval]" value="' . $interval . '" />'; 
	echo '<p class="description">Slider interval - length between transitions - in milliseconds - 1000 milliseconds = 1 second - ex. 1000/2000. The default value is 10000 (10 seconds). Allowed values between 1000 and 10000. Only for the built in slider</p>';
	
}

function JAMSESSION_SWP_slider_transition()
{
	$options = get_option( 'jamsession_theme_general_options' );
	 
	$transition_effect = '';
    if( isset( $options['slider_transition'] ) ) 
	{ 
        $transition_effect = $options['slider_transition'];
    }
	
	echo '<select id="slider_transition" name="jamsession_theme_general_options[slider_transition]">';
	
	if ( ( $transition_effect == "")||($transition_effect == "6")) {
		echo '<option value="6" selected="selected">Carousel Right</option>';
	} else {
		echo '<option value="6">Carousel Right</option>';
	}	
	
	if ( $transition_effect == "1") {
		echo '<option value="1" selected="selected">Fade</option>';
	} else {
		echo '<option value="1">Fade</option>';
	}
		
	if ( $transition_effect == "3") {
		echo '<option value="3" selected="selected">Slide Right</option>';
	} else {
		echo '<option value="3">Slide Right</option>';
	}
	
	if ( $transition_effect == "5") {
		echo '<option value="5" selected="selected">Slide Left</option>';
	} else {
		echo '<option value="5">Slide Left</option>';
	}
	
	if ( $transition_effect == "7") {
		echo '<option value="7" selected="selected">Carousel Left</option>';
	} else {
		echo '<option value="7">Carousel Left</option>';
	}
	echo '</select>';
	echo '<p class="description">Transition effect for the built in slider.</p>';
	
}

function JAMSESSION_SWP_maintenance_mode()
{
   $options = get_option( 'jamsession_theme_general_options' );  
      
    $mmode = ''; 
    if( isset( $options['maintenance_mode'] ) ) 
	{ 
        $mmode = $options['maintenance_mode']; 
    }

    // Render the output 
	echo '<select id="maintenance_mode" name="jamsession_theme_general_options[maintenance_mode]">';
	if ( ( $mmode == "")||($mmode == "maintenance_disabled")) 
	{
		echo '<option value="maintenance_disabled" selected="selected">Maintenance Mode Disabled</option>';
		echo '<option value="maintenance_enabled">Maintenance Mode Enabled</option>';
	}
	else
	{
		echo '<option value="maintenance_disabled">Maintenance Mode Disabled</option>';
		echo '<option value="maintenance_enabled" selected="selected">Maintenance Mode Enabled</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Maintenance mode - when enabled, only logged in users will be able to see the website. The rest of the visitors will see the under construction page.</p>';	
	echo '<p class="description" style="color: #0074a2;">You must define a maintenance page based on Maintenance Page template. Choose the maintenance page below.</p>';		
}

function JAMSESSION_SWP_maintenance_page()
{
	$options = get_option( 'jamsession_theme_general_options' );  
      
    $mmode = ''; 
    if( isset( $options['maintenance_page'] ) ) 
	{ 
        $mmode = $options['maintenance_page'];
    }

	$pages = JAMSESSION_SWP_get_maintenance_pages();

	if ( empty($pages))
	{
		echo '<select id="maintenance_page" name="jamsession_theme_general_options[maintenance_page]">';
		echo '<option value="maintenance_page_none" selected="selected">No Maintenance Page Selected</option>';
		echo '</select>';
	} 
	else 
	{
		// Render the output 
		echo '<select id="maintenance_page" name="jamsession_theme_general_options[maintenance_page]">';
		if ( ( $mmode == "")||($mmode == "maintenance_page_none")) 
		{
			echo '<option value="maintenance_page_none" selected="selected">No Maintenance Page Selected</option>';
			foreach($pages as $page){
				$page_value = urlencode($page->guid);
				echo '<option value="'.$page_value.'">'.$page->post_title.'</option>';
			}
		}
		else
		{
			echo '<option value="maintenance_page_none">No Maintenance Page Selected</option>';
			foreach($pages as $page){
				$page_value = urlencode($page->guid);
				if ( $page_value == $mmode) {
					echo '<option value="'.$page_value.'" selected="selected">'.$page->post_title.'</option>';
				}
				else {
					echo '<option value="'.$page_value.'">'.$page->post_title.'</option>';
				}
			}			
		}
		echo '</select>';
	}
	
	echo '<p class="description">Maintenance page - choose the page used as comming soon page. The page must exists and based on Maintenange Page template.</p>';	
}

function JAMSESSION_SWP_hide_post_meta()
{
	$options = get_option( 'jamsession_theme_general_options' );
	
	$hide_meta = ''; 
    if( isset( $options['hide_post_meta'] ) ) 
	{ 
        $hide_meta = $options['hide_post_meta'];
    }

	echo '<select id="hide_post_meta" name="jamsession_theme_general_options[hide_post_meta]">';
	if ( ( $hide_meta == "")||($hide_meta == "do_not_hide")) 
	{
		echo '<option value="do_not_hide" selected="selected">Do Not Hide</option>';
		echo '<option value="hide_meta">Hide Meta</option>';
	}
	else
	{
		echo '<option value="do_not_hide">Do Not Hide</option>';
		echo '<option value="hide_meta" selected="selected">Hide Meta</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Hide post meta on single pages - hide text similar to: by[user]on[published_date].</p>';	
}

function JAMSESSION_SWP_hide_archive_date()
{
	$options = get_option( 'jamsession_theme_general_options' );
	
	$hide_archive_date = ''; 
    if( isset( $options['hide_archive_date'] ) ) 
	{ 
        $hide_archive_date = $options['hide_archive_date'];
    }

	echo '<select id="hide_archive_date" name="jamsession_theme_general_options[hide_archive_date]">';
	if ( ( $hide_archive_date == "")||($hide_archive_date == "do_not_hide")) 
	{
		echo '<option value="do_not_hide" selected="selected">Do Not Hide</option>';
		echo '<option value="hide_date">Hide Date</option>';
	}
	else
	{
		echo '<option value="do_not_hide">Do Not Hide</option>';
		echo '<option value="hide_date" selected="selected">Hide Date</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Hide published date on archive pages for custom post types - available for Video and Photo Gallery</p>';	
}

function JAMSESSION_SWP_disable_sticky_menu() 
{
	$options = get_option( 'jamsession_theme_general_options' );
	
	$disable_sticky_menu = ''; 
    if( isset( $options['disable_sticky_menu'] ) ) 
	{ 
        $disable_sticky_menu = $options['disable_sticky_menu'];
    }

	echo '<select id="disable_sticky_menu" name="jamsession_theme_general_options[disable_sticky_menu]">';
	if ( ( $disable_sticky_menu == "")||($disable_sticky_menu == "disable_sticky")) {
		echo '<option value="keep_sticky">Keep Sticky Menu</option>';
		echo '<option value="disable_sticky" selected="selected">Disable Sticky Menu</option>';
	} else {
		echo '<option value="keep_sticky" selected="selected">Keep Sticky Menu</option>';
		echo '<option value="disable_sticky">Disable Sticky Menu</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Disable sticky menu on page scroll.</p>';	
}

function JAMSESSION_SWP_back_to_top() {
	$options = get_option( 'jamsession_theme_general_options' );
	
	$back_to_top = ''; 
    if( isset( $options['back_to_top'] ) ) 
	{ 
        $back_to_top = $options['back_to_top'];
    }

	echo '<select id="back_to_top" name="jamsession_theme_general_options[back_to_top]">';
	if ( ( $back_to_top == "")||($back_to_top == "back_to_top_disabled")) 
	{
		echo '<option value="back_to_top_disabled" selected="selected">Disabled</option>';
		echo '<option value="back_to_top_enabled">Enabled</option>';
	}
	else
	{
		echo '<option value="back_to_top_disabled">Disabled</option>';
		echo '<option value="back_to_top_enabled" selected="selected">Enabled</option>';
	}
	echo '</select>';
	
	echo '<p class="description">Add a back to top button at the end of the page.</p>';	
}

function  JAMSESSION_SWP_hide_social_sharing_cbk() {
	$options = get_option( 'jamsession_theme_general_options' );
	
	$hide_sharing = '';
    if(isset($options['hide_social_sharing'])) { 
        $hide_sharing = $options['hide_social_sharing'];
    }
	
	echo '<select id="hide_social_sharing" name="jamsession_theme_general_options[hide_social_sharing]">';
	if (($hide_sharing == '') || ($hide_sharing == "dont_hide_sharing_icons")) {
		echo '<option value="dont_hide_sharing_icons" selected="selected">Do not hide</option>';
		echo '<option value="hide_sharing_icons">Hide sharing icons</option>';
	} else {
		echo '<option value="dont_hide_sharing_icons">Do not hide</option>';
		echo '<option value="hide_sharing_icons" selected="selected">Hide sharing icons</option>';		
	}
	echo '</select>';
	
	echo '<p class="description">Hide social sharing icons at the end of the pages or posts.</p>';
}

function JAMSESSION_SWP_js_woo_sidebar_cbk() {
    $options = get_option('jamsession_theme_general_options');
    
    $add_woo_sidebar = '';
    if(isset($options['js_woo_sidebar'])) { 
        $add_woo_sidebar = $options['js_woo_sidebar'];
    }
    
    echo '<select id="js_woo_sidebar" name="jamsession_theme_general_options[js_woo_sidebar]">';
    if (($add_woo_sidebar == '') || ($add_woo_sidebar == "no_woo_sidebar")) {
        echo '<option value="no_woo_sidebar" selected="selected">No</option>';
        echo '<option value="add_woo_sidebar">Yes</option>';
    } else {
        echo '<option value="no_woo_sidebar">No</option>';
        echo '<option value="add_woo_sidebar" selected="selected">Yes</option>';      
    }
    echo '</select>';
    
    echo '<p class="description">Choose to add a sidebar to WooCommerce shop page.</p>';
}


function JAMSESSION_SWP_photo_tax_title()
{
	$options = get_option( 'jamsession_theme_general_options' );

	$photo_tax_title = '';
	if( isset( $options['photo_tax_title'] ) ) 
	{ 
		$photo_tax_title = $options['photo_tax_title']; 
	}

	echo '<input type="text" size="150 id="photo_tax_title" name="jamsession_theme_general_options[photo_tax_title]" value="' . $photo_tax_title . '" />'; 
	echo '<p class="description">Title for taxnonomy pages for photo albums. Default value:  - Photo Gallery - translated into the theme language</p>';
}

function JAMSESSION_SWP_album_tax_title()
{
	$options = get_option( 'jamsession_theme_general_options' );

	$album_tax_title = '';
	if( isset( $options['album_tax_title'] ) ) 
	{ 
		$album_tax_title = $options['album_tax_title']; 
	}

	echo '<input type="text" size="150 id="album_tax_title" name="jamsession_theme_general_options[album_tax_title]" value="' . $album_tax_title . '" />'; 
	echo '<p class="description">Title for taxnonomy pages for albums (discography). Default value: - Discography - translated into the theme language</p>';	
}

function JAMSESSION_SWP_event_tax_title()
{
	$options = get_option( 'jamsession_theme_general_options' );

	$event_tax_title = '';
	if( isset( $options['event_tax_title'] ) ) 
	{ 
		$event_tax_title = $options['event_tax_title']; 
	}

	echo '<input type="text" size="150 id="event_tax_title" name="jamsession_theme_general_options[event_tax_title]" value="' . $event_tax_title . '" />'; 
	echo '<p class="description">Title for taxnonomy pages for Events. Default value: - Tour Dates - translated into the theme language</p>';		
}

function JAMSESSION_SWP_video_tax_title()
{
	$options = get_option( 'jamsession_theme_general_options' );

	$video_tax_title = '';
	if( isset( $options['video_tax_title'] ) ) 
	{ 
		$video_tax_title = $options['video_tax_title']; 
	}

	echo '<input type="text" size="150 id="video_tax_title" name="jamsession_theme_general_options[video_tax_title]" value="' . $video_tax_title . '" />'; 
	echo '<p class="description">Title for taxnonomy pages for Videos. Default value: - Video Gallery - translated into the theme language</p>';		
}

function JAMSESSION_SWP_events_view()
{
	$options = get_option( 'jamsession_theme_general_options' );

	$events_view = 'masonry';
	if( isset( $options['events_view'] ) ) 
	{ 
		$events_view = $options['events_view']; 
	}

	$events_view_values = array(
		"Masonry" => "masonry",
		"List" => "list"
	);	
	
	echo '<select id="events_view" name="jamsession_theme_general_options[events_view]">';
	foreach( $events_view_values as $view_name => $view_value ) {
		if( $events_view == $view_value ) {
			echo '<option value="'.$view_value.'"  selected="selected">'.$view_name.'</option>';
		} else {
			echo '<option value="'.$view_value.'">'.$view_name.'</option>';
		}
	}
	echo '</select>';
	
	echo '<p class="description">Select layout for events pages.</p>';		
}


function JAMSESSION_SWP_get_maintenance_pages()
{
	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'page_maintenance.php',
		'post_status' => 'publish'
	));
	
	return $pages;
}


function JAMSESSION_SWP_contact_form_email()
{
	 $options = get_option( 'jamsession_theme_general_options' );
	 
	 $contact_email = '';
    if( isset( $options['contact_form_email'] ) ) 
	{ 
        $contact_email = sanitize_email($options['contact_form_email']); 
    }
	
	echo '<input type="text" size="150 id="contact_form_email" name="jamsession_theme_general_options[contact_form_email]" value="' . $contact_email . '" />'; 
	echo '<p class="description">Email address to which messages from the contact form are sent. You can leave it empty if you want, and if so, the messages would be sent to the default website administrator email address.</p>';
}

function JAMSESSION_SWP_twitter_callback()
{
      
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['twitter'] ) ) 
	{ 
        $url = esc_url_raw($options['twitter']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="twitter" name="jamsession_theme_social_options[twitter]" value="' . $url . '" />';  
      
} // end JAMSESSION_SWP_twitter_callback

function JAMSESSION_SWP_facebook_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['facebook'] ) ) 
	{ 
        $url = esc_url_raw($options['facebook']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="facebook" name="jamsession_theme_social_options[facebook]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_google_plus_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['google_plus'] ) ) 
	{ 
        $url = esc_url_raw($options['google_plus']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="google_plus" name="jamsession_theme_social_options[google_plus]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_youtube_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['youtube'] ) ) 
	{ 
        $url = esc_url_raw($options['youtube']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="youtube" name="jamsession_theme_social_options[youtube]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_vimeo_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['vimeo'] ) ) 
	{ 
        $url = esc_url_raw($options['vimeo']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="vimeo" name="jamsession_theme_social_options[vimeo]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_soundcloud_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['soundcloud'] ) ) 
	{ 
        $url = esc_url_raw($options['soundcloud']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="soundcloud" name="jamsession_theme_social_options[soundcloud]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_myspace_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['myspace'] ) ) 
	{ 
        $url = esc_url_raw($options['myspace']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="myspace" name="jamsession_theme_social_options[myspace]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_flickr_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['flickr'] ) ) 
	{ 
        $url = esc_url_raw($options['flickr']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="flickr" name="jamsession_theme_social_options[flickr]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_pinterest_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['pinterest'] ) ) 
	{ 
        $url = esc_url_raw($options['pinterest']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="pinterest" name="jamsession_theme_social_options[pinterest]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_instagram_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['instagram'] ) ) 
	{ 
        $url = esc_url_raw($options['instagram']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="instagram" name="jamsession_theme_social_options[instagram]" value="' . $url . '" />';  
      	
}

function JAMSESSION_SWP_itunes_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['itunes'] ) ) 
	{ 
        $url = esc_url_raw($options['itunes']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="itunes" name="jamsession_theme_social_options[itunes]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_spotify_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['spotify'] ) ) 
	{ 
        $url = esc_url_raw($options['spotify']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="spotify" name="jamsession_theme_social_options[spotify]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_tumblr_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['tumblr'] ) ) 
	{ 
        $url = esc_url_raw($options['tumblr']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="tumblr" name="jamsession_theme_social_options[tumblr]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_rnation_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_social_options' );  
      
    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $url = ''; 
    if( isset( $options['rnation'] ) ) 
	{ 
        $url = esc_url_raw($options['rnation']); 
    } // end if 
     
    // Render the output 
	echo '<input type="text" size="150 id="rnation" name="jamsession_theme_social_options[rnation]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_bandcamp_callback()
{
    $options = get_option( 'jamsession_theme_social_options' );  
      
    $url = ''; 
    if( isset( $options['bandcamp'] ) ) 
	{ 
        $url = esc_url_raw($options['bandcamp']); 
    }
     
    // Render the output 
	echo '<input type="text" size="150 id="bandcamp" name="jamsession_theme_social_options[bandcamp]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_linkedin_callback() {
    $options = get_option( 'jamsession_theme_social_options' );  
      
    $url = ''; 
    if( isset( $options['linkedin'])) { 
        $url = esc_url_raw($options['linkedin']); 
    }
     
	echo '<input type="text" size="150 id="linkedin" name="jamsession_theme_social_options[linkedin]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_mixcloud_callback() {
	$options = get_option( 'jamsession_theme_social_options' );  
      
    $url = ''; 
    if( isset( $options['mixcloud'])) { 
        $url = esc_url_raw($options['mixcloud']); 
    }
     
	echo '<input type="text" size="150 id="mixcloud" name="jamsession_theme_social_options[mixcloud]" value="' . $url . '" />';  
}

function JAMSESSION_SWP_custom_callback()
{
    $options = get_option( 'jamsession_theme_social_options' );  
      
    $url = ''; 
    if( isset( $options['custom'] ) ) 
	{ 
        $url = esc_url_raw($options['custom']); 
    }
	
	echo '<input type="text" size="150 id="custom" name="jamsession_theme_social_options[custom]" value="' . $url . '" />';	
	echo '<p class="description">Use this field if your favourite social network is not in the list above.</p>';
}

function JAMSESSION_SWP_custom_name_callback()
{
    $options = get_option( 'jamsession_theme_social_options' );  
      
    $name = ''; 
    if( isset( $options['custom_name'] ) ) 
	{ 
        $name = esc_html($options['custom_name']); 
    }
	
	echo '<input type="text" size="150 id="custom_name" name="jamsession_theme_social_options[custom_name]" value="' . $name . '" />';	
	echo '<p class="description">The name of your custom social network. Ex: Sonicbids</p>';	
}

function JAMSESSION_SWP_footer_text_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_footer_options' ); 

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $text = ''; 
    if( isset( $options['footer_text'] ) ) 
	{ 
        $text = esc_html($options['footer_text']); 
    } // end if 
     
    // Render the output 
	echo '<textarea  cols="147" rows="10" id="footer_text" name="jamsession_theme_footer_options[footer_text]" >' . $text . '</textarea>';  
}

function JAMSESSION_SWP_footer_text_url_callback()
{
   // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_footer_options' ); 

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $text_url = ''; 
    if( isset( $options['footer_text_url'] ) ) 
	{ 
        $text_url = esc_url_raw($options['footer_text_url']); 
    } // end if

	// Render the output 
	echo '<input type="text" size="147" id="footer_text_url" name="jamsession_theme_footer_options[footer_text_url]" value="' . $text_url . '" />';   	
}

function JAMSESSION_SWP_analytics_code_callback()
{
    // First, we read the social options collection  
    $options = get_option( 'jamsession_theme_footer_options' ); 

    // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.  
    $acode = ''; 
    if( isset( $options['analytics_code'] ) ) 
	{ 
		$acode = esc_html($options['analytics_code']); 
    } // end if 
     
    // Render the output 
	echo '<textarea  cols="147" rows="10" id="analytics_code" name="jamsession_theme_footer_options[analytics_code]" >' . $acode . '</textarea>';  
		
}
function JAMSESSION_SWP_fonts_custom_default_cbk() {
	$options = get_option('jamsession_theme_font_options');

	$font_usage = 'use_defaults';
	if (isset($options['fonts_custom_default'])) {
		$font_usage = $options['fonts_custom_default'];
	}

	$fonts_usage_opts = array(
		esc_html__('Use Theme Defaults', 'jamsession')	=> 'use_defaults',
		esc_html__('Use Custom Fonts', 'jamsession')	=> 'use_custom'
	);	
?>
	<select id="fonts_custom_default" name="jamsession_theme_font_options[fonts_custom_default]">
		<?php JAMSESSION_SWP_render_select_options($fonts_usage_opts, $font_usage); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose to use custom fonts for JamSession theme.', 'jamsession'); ?>
		<br>
		<?php echo esc_html__('Select [Use Custom Fonts] to enable the custom fonts below.', 'jamsession'); ?>
		<br>
		<?php echo esc_html__('Select [Use Default Fonts] to use the theme defaults.', 'jamsession'); ?>
	</p>
<?php
}

function JAMSESSION_SWP_primary_font_cbk() {
	$options = get_option('jamsession_theme_font_options');
	
	$primary_font = 'Open Sans';
	if (isset($options['primary_font'])) {
		$primary_font = $options['primary_font'];
	}

	$font_families = JAMSESSION_SWP_get_google_fonts_array();

?>
	<select id="primary_font" name="jamsession_theme_font_options[primary_font]">
		<?php JAMSESSION_SWP_render_select_options($font_families, $primary_font); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the primary font. This is the generic font, used for the content.', 'jamsession'); ?>
	</p>	
<?php
}

function JAMSESSION_SWP_secondary_font_cbk() {
	$options = get_option('jamsession_theme_font_options');
	
	$secondary_font = 'Oswald';
	if (isset($options['secondary_font'])) {
		$secondary_font = $options['secondary_font'];
	}

	$font_families = JAMSESSION_SWP_get_google_fonts_array();

?>
	<select id="secondary_font" name="jamsession_theme_font_options[secondary_font]">
		<?php JAMSESSION_SWP_render_select_options($font_families, $secondary_font); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the secondary font. This is the font used for headings and several other elements that are meant to stand out.', 'jamsession'); ?>
	</p>	
<?php
}

/*==================================================================*/
/*================== ADD SETTING CALLBACKS END =====================*/

function JAMSESSION_SWP_sanitize_font_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_html(trim($input[$key]));	
		}
	}

	return apply_filters('JAMSESSION_SWP_sanitize_font_options', $output, $input);
}

function JAMSESSION_SWP_sanitize_footer_options( $input )
{
    // Define the array for the updated options  
    $output = array();  
  
    //footer text
	$output['footer_text'] = esc_html( trim($input['footer_text']));
	
	//footer text url
	$output['footer_text_url'] = esc_url_raw( trim($input['footer_text_url']));
	
	 //analytics_code footer_text
	$output['analytics_code'] = $input['analytics_code'];
	
    // Return the new collection  
    return apply_filters( 'JAMSESSION_SWP_sanitize_footer_options', $output, $input );
} // end JAMSESSION_SWP_sanitize_footer_options

function JAMSESSION_SWP_sanitize_general_options( $input)
{
    // Define the array for the updated options  
    $output = array();  
  
    // Loop through each of the options sanitizing the data  
    foreach( $input as $key => $val ) 
	{  
        if( isset ( $input[$key] ) ) 
		{  
			if ($key == 'contact_form_email')
			{
				$output[$key] = sanitize_email( trim( $input[$key] ) );
			}
			else
			{
				if ( $key == 'slider_interval')
				{
					if ( $input[$key] < 0 || $input[$key] > 10000)
					{
						$input[$key] = 10000;
					}
				}
				
				$output[$key] =  esc_html( trim( $input[$key] ) ) ;

			}
        } // end if   
      
    }
	return apply_filters( 'JAMSESSION_SWP_sanitize_general_options', $output, $input );
}

function JAMSESSION_SWP_sanitize_social_options( $input )
{
    // Define the array for the updated options  
    $output = array();  
  
    // Loop through each of the options sanitizing the data  
    foreach( $input as $key => $val ) 
	{  
        if( isset ( $input[$key] ) ) 
		{  
			if ( $key == 'custom_name')
			{
				//sanitize simple text
				$output[$key] =  esc_html( trim( $input[$key] ) ) ;
			}
			else
			{
				// the rest of the input fields are URLs
				$output[$key] = esc_url_raw( trim( $input[$key] ) );  
			}
        } // end if   
      
    } // end foreach  
      
    // Return the new collection  
    return apply_filters( 'JAMSESSION_SWP_sanitize_social_options', $output, $input );
} // end JAMSESSION_SWP_sanitize_social_options



//add necessary javascript
function JAMSESSION_SWP_options_enqueue_scripts() {  
    wp_register_script( 'jamsession-settings-upload', get_template_directory_uri() .'/js/jamsession-settings-upload.js', array('jquery','media-upload','thickbox'), '', true );  
  
    /*appearance_page_[menu_slug]*/
    if ( 'appearance_page_jamsession_menu_page' == get_current_screen()->id ) {  
        wp_enqueue_script('jquery');  
  
        wp_enqueue_script('thickbox');  
        wp_enqueue_style('thickbox');  

        wp_enqueue_script('media-upload');
		wp_enqueue_media();
        wp_enqueue_script('jamsession-settings-upload');
    }
}  
add_action('admin_enqueue_scripts', 'JAMSESSION_SWP_options_enqueue_scripts');

/*change insert into post text inside thickbox*/
function JAMSESSION_SWP_options_setup()
{  
    global $pagenow;  
  
    if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) 
	{
        // Now we'll replace the 'Insert into Post Button' inside Thickbox  
        add_filter( 'gettext', 'JAMSESSION_SWP_replace_thickbox_text'  , 1, 3 );
    } 
}
add_action( 'admin_init', 'JAMSESSION_SWP_options_setup' );
 
function JAMSESSION_SWP_replace_thickbox_text($translated_text, $text, $domain)
{ 
    if ('Insert into Post' == $text) 
	{ 
        $referer = strpos( wp_get_referer(), 'jamsession_menu_page' ); 
        if ( $referer != '' ) 
		{	
			$referer = strpos( wp_get_referer(), 'jamsession_menu_page_logo' ); 
			if (  $referer != '' )
            {
				return __('Use this image as logo', 'jamsession' );
			}
			$referer = strpos( wp_get_referer(), 'jamsession_menu_page_favicon' ); 
			if (  $referer != '' )
            {
				return __('Use this image as favicon', 'jamsession' );
			}
			$referer = strpos( wp_get_referer(), 'jamsession_menu_page_bgimage' ); 
			if (  $referer != '' )
            {
				return __('Use this image as background', 'jamsession' );
			}
        }  
    }  
    return $translated_text;  
} 

function JAMSESSION_SWP_render_select_options($options, $selected) {
	if (empty($selected)) {
		return;
	}

	foreach($options as $key => $value) {
		if ($value == $selected) {
			?>
			<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_attr($key); ?> </option>
			<?php
		} else {
			?>
			<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_attr($key); ?> </option>
			<?php
		}
	}
}

/*
	Get all google fonts and creates an array like: 
	 array(
		'Open Sans',	=> 'Open Sans'
	);
*/
function JAMSESSION_SWP_get_google_fonts_array() {
	$str = file_get_contents(get_template_directory() . '/assets/google_fonts/fonts.json'); 
	$fonts_json = json_decode($str, true);

	$array_fonts = array();
	foreach($fonts_json as $font_json) {
		$array_fonts[$font_json['family']] = $font_json['family'];
	}

	return $array_fonts;
}

/*
	SETTINGS GETTERS
*/

function JAMSESSION_SWP_use_default_fonts() {
	$options = get_option('jamsession_theme_font_options');
	$fonts_custom_default = "";

    if (isset($options['fonts_custom_default'])) {
        $fonts_custom_default  = $options['fonts_custom_default'];
    }

	if (empty($fonts_custom_default)) {
		return true;
	}

	if ("use_defaults" == $fonts_custom_default) {
		return true;
	}

	return false;
}

function jamsession_src_have_woo_sidebar() {
    $options = get_option('jamsession_theme_general_options');

    $woo_sidebar = isset($options['js_woo_sidebar']) ? $options['js_woo_sidebar'] : "no_woo_sidebar";

    return $woo_sidebar == "add_woo_sidebar";
}

function JAMSESSION_SWP_have_social_on_menu() {
	$options = get_option('jamsession_theme_general_options');

	if (!isset($options['add_social_to_menu'])) {
		return false;
	}

	
    if ("yes" == $options['add_social_to_menu']) {
    	return true;
    }

    return false;
}

function JAMSESSION_SWP_get_user_primary_font() {
	$options = get_option('jamsession_theme_font_options');
	
	if (isset($options['primary_font'])) {
		return $options['primary_font'];
	}

	return 'Open Sans';
}

function JAMSESSION_SWP_get_user_secondary_font() {
	$options = get_option('jamsession_theme_font_options');
	
	if (isset($options['secondary_font'])) {
		return $options['secondary_font'];
	}
	
	return 'Oswald';
}

if ( !function_exists('JAMSESSION_SWP_get_fonts_family_from_settings') ) {
	function JAMSESSION_SWP_get_fonts_family_from_settings() {
		if (JAMSESSION_SWP_use_default_fonts()) {
			return 'Open+Sans:400,600,700,800|Oswald:300,400,700&subset=latin,latin-ext';
		}

		$primary_font = JAMSESSION_SWP_get_user_primary_font();
		$secondary_font = JAMSESSION_SWP_get_user_secondary_font();

		return JAMSESSION_SWP_generate_fonts_family($primary_font, $secondary_font);
	}
}

function JAMSESSION_SWP_generate_fonts_family($primary, $secondary) {
	$str = file_get_contents(get_template_directory() . '/assets/google_fonts/fonts.json'); 
	$fonts_json = json_decode($str, true);

	$final_fonts = '';
	$found_fonts = 0;
	foreach($fonts_json as $font_json) {
		if (($primary == $font_json['family']) || 
			($secondary == $font_json['family'])) {

			$found_fonts++;
			if (strlen($final_fonts)) {
				$final_fonts .= '|';
			}
			$final_fonts .= str_replace(' ', '+', $font_json['family']) . ':' . $font_json['variants'];

			/*get out of the loop after two fonts found*/
			if (2 == $found_fonts) {
				break;
			}
		}/*if*/
	}/*foreach*/

	return $final_fonts . '&subset=latin,latin-ext';
}

?>
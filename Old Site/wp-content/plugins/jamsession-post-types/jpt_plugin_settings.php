<?php
/*create menu entry*/
function JAMSESSION_SWP_JPT_menu_entry() {    
	add_options_page(
		"JamSession Post Types Settings",
		"JamSession Post Types Settings",
		"manage_options",
		"JamSession-Post-Types-Settings",
		"JAMSESSION_SWP_JPT_output_content"
	);
}
add_action('admin_menu', 'JAMSESSION_SWP_JPT_menu_entry');

/*add the plugin settings to admin bar*/
function JAMSESSION_SWP_add_JPT_to_admin_bar($admin_bar) {

    $admin_bar->add_menu(
        array(
        'id'    => 'jamsession-post-types-settings',
        'title' => esc_html__("JamSession Core Settings", "jamsession-post-types"),
        'href'  => admin_url('options-general.php?page=JamSession-Post-Types-Settings'),
        'meta'  => array(
            'title' => esc_html__("Go To JamSession Core Settings", "jamsession-post-types")
           )
       )
   );
}
add_action('admin_bar_menu', 'JAMSESSION_SWP_add_JPT_to_admin_bar', 9999);



function JAMSESSION_SWP_JPT_output_content() {
?> 
	<!-- Create a header in the default WordPress 'wrap' container -->      
	<div class="wrap">
		<!-- Add the icon to the page -->          
		<h2><?php echo esc_html__("Jam Session Post Types Plugin Settings", "jamsession-post-types"); ?></h2>				 
		
		<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->          
		<?php settings_errors(); ?> 				       
		
		<!-- Create the form that will be used to render our options -->
		<form method="post" action="options.php"> 			
			<?php   			
			settings_fields('JPT_plugin_options');  		
			do_settings_sections('JPT_plugin_options');						
			submit_button(); 			
			?>        
		</form>  
	
	</div>
 <?php
	/* very important call*/
	flush_rewrite_rules();
 }
 
 add_action('admin_init', 'JAMSESSION_SWP_JPT_initialize_jpt_options');
  function JAMSESSION_SWP_JPT_initialize_jpt_options() {	
	 /* Create plugin options */	
	if(false == get_option('JPT_plugin_options')) {
		add_option('JPT_plugin_options');	
	}			
	 
	 /* Create settings section	*/
	 add_settings_section( 		
		 'JPT_plugin_section',          /* ID used to identify this section and with which to register options  */		
		 'Slug Settings',                   /* Title to be displayed on the administration page   */		
		 'JPT_plugin_options_callback',  /* Callback used to render the description of the section */		
		 'JPT_plugin_options'      /* Page on which to add this section of options  */	
	);	
	 
	register_setting( 
		'JPT_plugin_options',  		//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
		'JPT_plugin_options',  		// option_name -  The name of an option to sanitize and save. 
		'JPT_sanitize_plugin_options'  	//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
	);		
 
	 
	 //settings fields	 
	 add_settings_field(          
		 'events_slug',          					/* ID used to identify the field throughout the theme                */      
		 'Event Post Type Slug',                				/* The label to the left of the option interface element   */             
		 'JPT_plugin_options_event_slug_callback', 			/* The name of the function responsible for rendering the option interface */     
		 'JPT_plugin_options',   	/* The page on which this option will be displayed   */      
		 'JPT_plugin_section'    /* The name of the section to which this field belongs   */    
	); 

	 add_settings_field(          
		 'photo_albums_slug',          					/* ID used to identify the field throughout the theme                */      
		 'Photo Album Post Type Slug',                				/* The label to the left of the option interface element   */             
		 'JPT_plugin_options_photo_album_slug_callback', 			/* The name of the function responsible for rendering the option interface */     
		 'JPT_plugin_options',   	/* The page on which this option will be displayed   */      
		 'JPT_plugin_section'    /* The name of the section to which this field belongs   */    
	); 

	 add_settings_field(          
		 'videos_slug',          					/* ID used to identify the field throughout the theme                */      
		 'Video Post Type Slug',                				/* The label to the left of the option interface element   */             
		 'JPT_plugin_options_video_slug_callback', 			/* The name of the function responsible for rendering the option interface */     
		 'JPT_plugin_options',   	/* The page on which this option will be displayed   */      
		 'JPT_plugin_section'    /* The name of the section to which this field belongs   */    
	); 

	 add_settings_field(          
		 'albums_slug',          					/* ID used to identify the field throughout the theme                */      
		 'Audio Post Type Slug',                				/* The label to the left of the option interface element   */             
		 'JPT_plugin_options_album_slug_callback', 			/* The name of the function responsible for rendering the option interface */     
		 'JPT_plugin_options',   	/* The page on which this option will be displayed   */      
		 'JPT_plugin_section'    /* The name of the section to which this field belongs   */    
	);
	
	/*CPT taxonomy slug*/
	add_settings_field(          
		'events_tax_slug',
		'Event Category Slug',
		'JPT_plugin_options_event_tax_slug_callback',
		'JPT_plugin_options',
		'JPT_plugin_section'
	);
	
	add_settings_field(          
		'photo_albums_tax_slug',
		'Photo Album Category Slug',
		'JPT_plugin_options_photo_album_tax_slug_callback',
		'JPT_plugin_options',
		'JPT_plugin_section'
	);
	
	add_settings_field(          
		'video_tax_slug',
		'Video Category Slug',
		'JPT_plugin_options_video_tax_slug_callback',
		'JPT_plugin_options',
		'JPT_plugin_section'
	);

	add_settings_field(          
		'album_tax_slug',
		'Album Category Slug',
		'JPT_plugin_options_album_tax_slug_callback',
		'JPT_plugin_options',
		'JPT_plugin_section'
	);		
 }
 
 function JPT_plugin_options_callback() {
	echo '<p>Set up the slugs for custom post types.</p>';
 }
 
 function JPT_plugin_options_event_slug_callback() {
    $options = get_option('JPT_plugin_options');  
      
    $slug = ''; 
    if(isset($options['event'])) { 
        $slug = esc_html($options['event']); 
    }
     
	echo '<input type="text" size="50 id="event" name="JPT_plugin_options[event]" value="' . $slug . '" />';  	
 }
 
 function JPT_plugin_options_photo_album_slug_callback() {
	$options = get_option('JPT_plugin_options');  
	  
	$slug = ''; 
	if(isset($options['photo_album'])) { 
		$slug = esc_html($options['photo_album']); 
	}
	 
	echo '<input type="text" size="50 id="photo_album" name="JPT_plugin_options[photo_album]" value="' . $slug . '" />';  		
 }
 
function JPT_plugin_options_video_slug_callback() {
	$options = get_option('JPT_plugin_options');  
	  
	$slug = ''; 
	if(isset($options['video'])) { 
		$slug = esc_html($options['video']); 
	}
	 
	echo '<input type="text" size="50 id="video" name="JPT_plugin_options[video]" value="' . $slug . '" />';  		
}
 
function JPT_plugin_options_album_slug_callback() {
	$options = get_option('JPT_plugin_options');  
	  
	$slug = ''; 
	if(isset($options['album'])) { 
		$slug = esc_html($options['album']); 
	}
	 
	echo '<input type="text" size="50 id="album" name="JPT_plugin_options[album]" value="' . $slug . '" />';  		
}

function JPT_plugin_options_event_tax_slug_callback() {
	$options = get_option('JPT_plugin_options');
	
	$slug = ''; 
	if(isset($options['event_tax'])) { 
		$slug = esc_html($options['event_tax']); 
	}
	
	echo '<input type="text" size="50 id="event_tax" name="JPT_plugin_options[event_tax]" value="' . $slug . '" />';  			
}

function JPT_plugin_options_photo_album_tax_slug_callback() {
	$options = get_option('JPT_plugin_options');
	
	$slug = ''; 
	if(isset($options['photo_album_tax'])) { 
		$slug = esc_html($options['photo_album_tax']); 
	}
	
	echo '<input type="text" size="50 id="photo_album_tax" name="JPT_plugin_options[photo_album_tax]" value="' . $slug . '" />';  			
}

function JPT_plugin_options_video_tax_slug_callback() {
	$options = get_option('JPT_plugin_options');
	
	$slug = ''; 
	if(isset($options['video_tax'])) { 
		$slug = esc_html($options['video_tax']); 
	}
	
	echo '<input type="text" size="50 id="video_tax" name="JPT_plugin_options[video_tax]" value="' . $slug . '" />'; 
}

function JPT_plugin_options_album_tax_slug_callback() {
	$options = get_option('JPT_plugin_options');
	
	$slug = ''; 
	if(isset($options['album_tax'])) { 
		$slug = esc_html($options['album_tax']); 
	}
	
	echo '<input type="text" size="50 id="album_tax" name="JPT_plugin_options[album_tax]" value="' . $slug . '" />'; 	
}
 
 function JPT_sanitize_plugin_options($input) {
	// Define the array for the updated options  
    $output = array();  
  
    // Loop through each of the options sanitizing the data  
    foreach($input as $key => $val)	{  
        if(isset ($input[$key])) {  
            $output[$key] = esc_html(trim($input[$key]));  
        }
      
    }
      
    return apply_filters('JPT_sanitize_plugin_options', $output, $input);
 }
 
 
 ?>
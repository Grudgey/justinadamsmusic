<?php

/*
	Theme Customiser Functionality
*/
/**
 * Contains methods for customizing the theme customization screen.
 * 
 * @link http://codex.wordpress.org/Theme_Customization_API
 */
class JAMSESSION_SWP_Customize
{
	/**
	* This hooks into 'customize_register' (available as of WP 3.4)
    */
	public static function register ( $wp_customize ) 
	{
		/* set default values for options */
		if (!isset($jamsession_options['logo_transparent_bgc']))
		{
			$jamsession_options['logo_transparent_bgc'] = "1";
		}
		if (!isset($jamsession_options['transparent_menu']))
		{
			$jamsession_options['transparent_menu'] = "";
		}
		if (!isset($jamsession_options['remove_content_container_border'])) {
			$jamsession_options['remove_content_container_border'] = "";
		}
		if ( !isset( $jamsession_options['menu_width']))
		{
			$jamsession_options['menu_width'] = 'full';
		}
		if ( !isset( $jamsession_options['header_layout']))
		{
			$jamsession_options['header_layout'] = 'layout2';
		}

		/*********************************************************************************************************
		*				LOGO OPTIONS 
		*********************************************************************************************************/
		//1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'jamsession_logo_color_options', 
			array(
				'title' => __( 'Logo Color Options', 'jamsession' ), 		//Visible title of section
				'priority' => 3, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => __('Allows you to customize logo colors', 'jamsession'), //Descriptive tooltip
			) 
		);
      
	  /*	==========================================================
	  *		====================== logo text color ========================
	  *     ==========================================================
	  */
		
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[logo_textcolor]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#FFFFFF', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'jamsession_logo_textcolor', 	//Set a unique ID for the control
										array(
										'label' => __( 'Logo Text Color', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_logo_color_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[logo_textcolor]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));
		
	  /*	==========================================================
	  *		====================== logo transparent ========================
	  *     ==========================================================
	  */
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[logo_transparent_bgc]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => $jamsession_options['logo_transparent_bgc'], 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		); 

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'logo_transparent_bgc' ,
										array(
										'label' => __( 'Logo Transparent Background', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_logo_color_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[logo_transparent_bgc]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 2, //Determines the order this control appears in for the specified section
										'type'	=> 'checkbox',
										) 
		);			
		
	  /*	==========================================================
	  *		====================== logo background ========================
	  *     ==========================================================
	  */
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[logo_bgcolor]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#7c003a', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'jamsession_logo_bgcolor', 	//Set a unique ID for the control
										array(
										'label' => __( 'Logo Background Color', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_logo_color_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[logo_bgcolor]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										) 
		));
		
	
	
		/*********************************************************************************************************
		*				MENU OPTIONS 
		*********************************************************************************************************/

		//1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'jamsession_menu_options', 
			array(
				'title' => __( 'Menu Options', 'jamsession' ), 		//Visible title of section
				'priority' => 2, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => __('Allows you to customize main menu', 'jamsession'), //Descriptive tooltip
			) 
		);
		
		/************************************************* menu text color *********************************************/
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[menu_text_color]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#ffffff', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'jamsession_menu_text_color', 	//Set a unique ID for the control
										array(
										'label' => __( 'Menu Text Color', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_menu_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[menu_text_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));	

		/************************************************* menu text color active *********************************************/
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[menu_active_text_color]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#ffffff', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'jamsession_menu_active_text_color', 	//Set a unique ID for the control
										array(
										'label' => __( 'Active Menu Item Color', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_menu_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[menu_active_text_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));		
		

		/************************************************* menu bg color *********************************************/
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[menu_color]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#7c003a', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'jamsession_menu_color', 	//Set a unique ID for the control
										array(
										'label' => __( 'Menu Color', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_menu_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[menu_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 2, //Determines the order this control appears in for the specified section
										) 
		));			

		
		/************************************************* menu width *********************************************/
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[menu_width]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => $jamsession_options['menu_width'], 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		); 

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'menu_width_control' ,
										array(
										'label' => __( 'Menu Width', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_menu_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[menu_width]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										'type'	=> 'select',
										'choices'    => array(
														'full' => __( 'Full Width', 'jamsession' ),
														'boxed' => __( 'Boxed', 'jamsession' ),
														),
										)
		);
		
		/************************************************* transparent menu *********************************************/
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[transparent_menu]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => $jamsession_options['transparent_menu'], 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		); 

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'transparent_menu' ,
										array(
										'label' => __( 'Transparent Menu Bar', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_menu_options', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[transparent_menu]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 4, //Determines the order this control appears in for the specified section
										'type'	=> 'checkbox',
										)
		);

		/*********************************************************************************************************
		*				HEADER LAYOUTS 
		*********************************************************************************************************/

		//1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'jamsession_header_layouts', 
			array(
				'title' => __( 'Header Layouts', 'jamsession' ), 		//Visible title of section
				'priority' => 1, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => __('Allows you to customize header layout', 'jamsession'), //Descriptive tooltip
			) 
		);
		
		/************************************************* header layouts poptext *********************************************/
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[header_layout]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => $jamsession_options['header_layout'], 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);  		

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'header_layout_control' ,
										array(
										'label' => __( 'Menu &amp; Logo Position', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_header_layouts', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[header_layout]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										'type'	=> 'select',
										'choices'    => array(
														'layout1' => __( 'Stuck on Top', 'jamsession' ),
														'layout11' => __( 'Stuck on Top (slim)', 'jamsession' ),
														'layout2' => __( 'Distanced', 'jamsession' ),
														'layout3' => __( 'Logo Above Menu', 'jamsession' ),
														/*'layout4' => __( 'Increased Logo', 'jamsession' ),*/
														),
										)
		);	
      
      	//1. Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'jamsession_second_color', 
			array(
				'title' => __( 'Secondary Color', 'jamsession' ), 		//Visible title of section
				'priority' => 4, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => __('Choose the secondary color', 'jamsession'), //Descriptive tooltip
			) 
		);
		
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[second_color]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#005b66', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'jamsession_second_color', 	//Set a unique ID for the control
										array(
										'label' => __( 'Secondary Color', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_second_color', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[second_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));

		/*********************************************************************************************************
		*				TEXT CONTAINER
		*********************************************************************************************************/

		// New Section
		$wp_customize->add_section( 'jamsession_content_container', 
			array(
				'title' => __( 'Content Container', 'jamsession' ), 		//Visible title of section
				'priority' => 5, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => __('Allows you to customize the containers for content.', 'jamsession'), //Descriptive tooltip
			) 
		);	
		
		// New Settings to the WP Database
		$wp_customize->add_setting( 'jamsession_options[content_container_opacity]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => 'value_4',		 			//Default setting/value to save
				'type' => 'option', 					//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 	//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 			//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		); 

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'content_container_opacity' ,
										array(
										'label' => __( 'Opacity for Content Container', 'jamsession' ), 	     //Admin-visible name of the control
										'section' => 'jamsession_content_container', 					//ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[content_container_opacity]',  //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, 												//Determines the order this control appears in for the specified section
										'type'	=> 'select',
										'choices'    => array(
														'value_0' => '0',
														'value_1' => '0.1',
														'value_2' => '0.2',
														'value_3' => '0.3',
														'value_4' => '0.4',
														'value_5' => '0.5',
														'value_6' => '0.6',
														'value_7' => '0.7',
														'value_8' => '0.8',
														'value_9' => '0.9',
														'value_10' => '1',
														),
										)
		);
		
		// New Settings to the WP Database
		$wp_customize->add_setting( 'jamsession_options[masonry_container_opacity]',
			array(
				'default' => 'value_4',
				'type' => 'option',
				'capability' => 'edit_theme_options',
				'transport' => 'postMessage',
			) 
		);
		
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'masonry_container_opacity' ,
										array(
										'label' => __( 'Opacity for Masonry and List Containers', 'jamsession' ),
										'section' => 'jamsession_content_container',
										'settings' => 'jamsession_options[masonry_container_opacity]',
										'priority' => 2,
										'type'	=> 'select',
										'choices'    => array(
														'value_0' => '0',
														'value_1' => '0.1',
														'value_2' => '0.2',
														'value_3' => '0.3',
														'value_4' => '0.4',
														'value_5' => '0.5',
														'value_6' => '0.6',
														'value_7' => '0.7',
														'value_8' => '0.8',
														'value_9' => '0.9',
														'value_10' => '1',
														),
										)
		);
		
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[content_container_bgc]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#000000', 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);      
            
		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'content_container_bgc', 	//Set a unique ID for the control
										array(
										'label' => __( 'Background Color For Content Containers (both masonry and content)', 'jamsession' ), //Admin-visible name of the control
										'section' => 'jamsession_content_container', //ID of the section this control should render in (can be one of yours, or a WordPress default section)
										'settings' => 'jamsession_options[content_container_bgc]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 3, //Determines the order this control appears in for the specified section
										) 
		));		
		
		
		//2. Register new settings to the WP database...
		$wp_customize->add_setting( 'jamsession_options[remove_content_container_border]', //Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => $jamsession_options['remove_content_container_border'], 			//Default setting/value to save
				'type' => 'option', 				//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 		//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		); 

		//3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( 'remove_content_container_border' ,
										array(
											'label' => __( 'Remove border around all content containers', 'jamsession' ), //Admin-visible name of the control
											'section' => 'jamsession_content_container', 	//ID of the section this control should render in (can be one of yours, or a WordPress default section)
											'settings' => 'jamsession_options[remove_content_container_border]', //Which setting to load and manipulate (serialized is okay)
											'priority' => 4, //Determines the order this control appears in for the specified section
											'type'	=> 'checkbox',
										)
		);
   }


   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * keep 'transport'=>'postMessage' instead of the default 'transport' => 'refresh'
    * Used by hook: 'customize_preview_init'
    */
   public static function live_preview() 
   {
		wp_enqueue_script( 
           'jamsession-themecustomizer', 									// Give the script a unique ID
           get_template_directory_uri().'/js/theme_customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ),				 // Define dependencies
           '', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   }


   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * Used by hook: 'wp_head'
    * @see add_action('wp_head',$func)
    * @since MyTheme 1.0
    */
   public static function header_output() 
   {
      ?>
      <!--Customizer CSS--> 
      <style type="text/css">
        <?php
			$themeOptions = get_option('jamsession_options');

			/* default values*/
			if (!isset($themeOptions['logo_transparent_bgc']))
			{
				$themeOptions['logo_transparent_bgc'] = "1";
			}
			if (!isset($themeOptions['transparent_menu']))
			{
				$themeOptions['transparent_menu'] = "";
			}		
			if ( !isset( $themeOptions['menu_width']))
			{
				$themeOptions['menu_width'] = 'full';
			}
			if ( !isset( $themeOptions['header_layout']))
			{
				$themeOptions['header_layout'] = 'layout2';
			}
			if ( !isset( $themeOptions['logo_textcolor']))
			{
				$themeOptions['logo_textcolor'] = '#ffffff';
			}
			if ( !isset( $themeOptions['logo_bgcolor']))
			{
				$themeOptions['logo_bgcolor'] = '#7c003a';
			}
			if ( !isset( $themeOptions['menu_text_color']))
			{
				$themeOptions['menu_text_color'] = '#ffffff';
			}
			if ( !isset( $themeOptions['menu_active_text_color']))
			{
				$themeOptions['menu_active_text_color'] = '#ffffff';
			}			
			if ( !isset( $themeOptions['menu_color']))
			{
				$themeOptions['menu_color'] = '#7c003a';
			}
			if ( !isset( $themeOptions['second_color']))
			{
				$themeOptions['second_color'] = '#005b66';
			}
			if ( !isset( $themeOptions['content_container_opacity'])) {
				$themeOptions['content_container_opacity'] = 'value_4';
			}
			if ( !isset( $themeOptions['masonry_container_opacity'])) {
				$themeOptions['masonry_container_opacity'] = 'value_4';
			}
			if ( !isset( $themeOptions['content_container_bgc'])) {
				$themeOptions['content_container_bgc'] = '#000000';
			}			
			if (!isset($themeOptions['remove_content_container_border'])) {
				$themeOptions['remove_content_container_border'] = "";
			}			
			
			
		
			/*logo textcolor*/
			self::generate_css('#logo a', 'color', 'logo_textcolor', '', '');
			self::generate_css('#logo_mobile a', 'color', 'logo_textcolor', '', '');
			
			/* logo background*/
			if ( !($themeOptions['logo_transparent_bgc']))
			{
				@$my_logo_color = self::hex_to_rgb( $themeOptions['logo_bgcolor']);
			    @$my_rgba_logo_val = 'rgba('.$my_logo_color['r'].','.$my_logo_color['g'].','.$my_logo_color['b'].',0.9)';
				echo ' #logo { background-color : '.$my_rgba_logo_val.';}';
			}
			else
			{
				echo " #logo { background-color : transparent; outline: 0;}";
			}
			

			@$color = self::hex_to_rgb( $themeOptions['menu_color']);
			@$colorValue = 'rgba('.$color['r'].','.$color['g'].','.$color['b'].',0.9)';
			
			/*menu options*/
			if ( !($themeOptions['transparent_menu']))
			{
				/* show menu color */
				if ('full' == $themeOptions['menu_width'])
				{
					/* full width menu */
					echo "#main_menu, .menu { background-color : transparent;}";
					echo '#menu_navigation { background-color : '.$colorValue.';}';
					echo "#search_blog { background-color : transparent;}";
				}
				else
				{
					/* menu boxed version */
					echo "#menu_navigation { background-color : transparent;}";
				//	echo '#main_menu, .menu { background-color  : '.$colorValue.';}';
					echo '.menu { background-color  : '.$colorValue.';}';
					echo '#search_blog { background-color  : '.$colorValue.';}';
				}

			}
			else
			{	
				/* transparent menu */
				echo "#menu_navigation { background-color : transparent;}";
				echo "#main_menu, .menu { background-color : transparent;}";
				echo "#search_blog, #search_blog span { background-color : transparent;}";
			}
			/*set the background for .use_mobile in all cases */
			echo '.use_mobile { background-color : '.$colorValue.';}';
			
			if ($themeOptions['remove_content_container_border']) {
				echo '#post_content, #post_content_full, .js_full_container_inner, .album_meta, .event_meta, #album_listing, #event_listing, #sidebar, .post_item, .post_item_woo { border-width: 0;}';
			}
			
			/*dropdown menus*/
			@$colorValue = 'rgba('.$color['r'].','.$color['g'].','.$color['b'].',0.9)';
			
			echo '#main_menu ul ul, .menu ul ul, #news_badge, #front_page_news_bar { background-color : '.$colorValue.';}';
			echo '#main_menu ul li:hover, .menu ul li:hover { background-color : '.$colorValue.';}';
			echo '.copy, .price_container, p.price ins { color: '.$themeOptions['menu_color'].';}';

			/*mobile menu bg color*/
			echo '.mobile_menu_bar, nav.mobile_navigation ul li { background-color: '.$themeOptions['menu_color'].';}';

			/*mobile menu text color*/
			echo '.mobile_menu_container ul li a { color: '.$themeOptions['menu_text_color'].';}';
			
			/*menu text color*/
			self::generate_css('#main_menu ul li a', 'color', 'menu_text_color', '', '');
			self::generate_css('.menu ul li a', 'color', 'menu_text_color', '', ''); 				
			self::generate_css('.btt_left, .btt_right', 'background-color', 'menu_text_color', '', ''); 				
			self::generate_css('.copy', 'background-color', 'menu_text_color', '', ''); 
			self::generate_css('#main_menu li.current-menu-item > a, .menu li.current-menu-item > a', 'color', 'menu_active_text_color', '', '');
			self::generate_css('#main_menu li.current-menu-ancestor > a, .menu li.current-menu-ancestor > a', 'color', 'menu_active_text_color', '', '');
			
			/*header_layout - options*/
			if ('layout2' == $themeOptions['header_layout'])
			{
				/*logo and menu same line - distanced from the top*/
				echo '#logo {top: 20px; line-height: 75px; font-size: 30px;}';
				echo '.menu_social_links i {line-height: 75px;}';
				echo '#menu_navigation {top: 20px; }';
				echo '#main_menu ul li a, .menu ul li a {line-height: 75px;}';
				echo '#main_menu ul ul li a, .menu ul ul li a {line-height: 35px;} '; 
			}
			//menu & logo centered 
			if ('layout3' == $themeOptions['header_layout'])
			{
				echo '#main_menu ul li a, .menu ul li a {line-height: 60px;}';
				echo '.menu_social_links i {line-height: 60px;}';
				echo '#main_menu ul ul li a, .menu ul ul li a {line-height: 30px;}';
				echo '#main_menu, .menu {display: table; margin: auto; float: none; right: 0; position: absolute; left: 50%; transform: translateX(-50%);}';
				echo '#logo { font-size: 32px; line-height: 65px; letter-spacing: 8px; display: table; margin: auto; top: 0; left: 0; position: relative;}';
				
				echo '#search_blog span {margin: 13px 25px 0px 0px;}';
				echo '#search_blog {height: 60px;}';
				
				/*
				* For boxed menu and logo on top, the search icon should not  be visible, since it breaks the layout centering
				*/
				if ('full' != $themeOptions['menu_width'])
				{
					echo '#search_blog {display: none;}';
				}
			}
			
			//menu stuck on top
			if ('layout1' == $themeOptions['header_layout'])
			{
				echo '#search_blog span {margin: 29px 25px 0px 0px;}';
				echo '#search_blog {height: 90px;}';
				echo '.menu_social_links i {line-height: 90px;}';
			}
			
			/*stuck on top (slim)*/
			if ('layout11' == $themeOptions['header_layout'])
			{
				echo '#logo {line-height: 75px; font-size: 30px;}';
				echo '.menu_social_links i {line-height: 75px;}';
				echo '#main_menu ul li a, .menu ul li a {line-height: 75px;}';
				echo '#main_menu ul ul li a, .menu ul ul li a {line-height: 35px;} '; 
			}			
			
			
			/*secondary color as background-color*/
			$second_bgc = '#commentform input[type="submit"]:hover, #sidebar input[type="submit"]:hover, #inline_search input[type="submit"]:hover, .js_swp_theme_button:hover, ';
			$second_bgc .= ' #contactform input[type="submit"]:hover, .reply:hover, .post_cat a, .pagination_links a, .post_tag a:hover, .event_actions a:hover, ';
			$second_bgc .= '.custom_actions, .fb_actions:hover, .mejs-time-current, #wp-calendar thead, #sidebar .tagcloud a:hover,  .slideTitle, .woocommerce span.onsale, .woocommerce-page span.onsale, ';
			$second_bgc .= '.woocommerce a.added_to_cart, .woocommerce-page a.added_to_cart, .main_spinner ';
			$second_bgc .= '{background-color: '.$themeOptions['second_color'].';}';
			echo $second_bgc;
			
			/*secondary color as color*/
			$second_co = 'a, .post_author a, #sidebar a:hover, .required, .required_field, .error, .archive_name, ';
			$second_co .= '.social_share a:hover, .social_links a:hover, .footer_share a:hover, .event_meta_date, ';
			$second_co .= '.event_buy_list a ';
			/*$second_co .= '.use_mobile #main_menu ul li a:hover, .use_mobile .menu ul li a:hover';*/
			$second_co .= '{color: '.$themeOptions['second_color'].';}';
			echo $second_co;
			
			/* menu color as background color*/
			$menu_col_bgc = '#commentform input[type="submit"], #sidebar input[type="submit"], #inline_search input[type="submit"], #contactform input[type="submit"], .js_swp_theme_button, ';
			$menu_col_bgc .= ' .reply, .post_cat a:hover, .current_tax, .post_tag a, #sidebar .tagcloud a, .pagination_links a:hover, .event_actions a, .custom_actions:hover, .back_to_top_btn ';
			$menu_col_bgc .= '{background-color: '.$themeOptions['menu_color'].';}';
			echo $menu_col_bgc;
			
			$commerce_button = '.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, ';
			$commerce_button  .= '.woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, ';
			$commerce_button  .= '.woocommerce-page button.button, .woocommerce-page input.button';
			$commerce_button .= '{background-color: '.$themeOptions['menu_color'].' !important;}';
			echo $commerce_button;
			
			$commerce_button_hover = '.woocommerce #content input.button:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, ';
			$commerce_button_hover .= '.woocommerce input.button:hover, .woocommerce-page #content input.button:hover, .woocommerce-page #respond input#submit:hover, .woocommerce-page a.button:hover, ';
			$commerce_button_hover .= '.woocommerce-page button.button:hover, .woocommerce-page input.button:hover ';
			$commerce_button_hover .= '{background-color: '.$themeOptions['second_color'].' !important;}';
			echo $commerce_button_hover;
			
			
			/*commerce [[[*/
			$commerce = "#single_price p.price, .price .amount ";
			$commerce .= '{color: '.$themeOptions['menu_color'].';}';
			echo $commerce;			
			/*commerce ]]]*/
		
			
			echo '.post_cat a, .post_tag a { color : #ffffff;}';	/*main body  color*/

			echo '.post_item:hover, .post_item_gallery:hover, .post_item_woo:hover {box-shadow: 0 0 16px 10px '.$themeOptions['second_color'].';}';
			
			echo '.post_item_event:hover {box-shadow: 0 0 25px '.$themeOptions['second_color'].';}';
			
			$menu_text_color = '.mobile_menu_hmb, #news_badge, #front_page_news_bar a, #sidebar .tagcloud a, .post_tag a, .post_cat a:hover, .custom_actions:hover > a, ';
			$menu_text_color .= '#comments .reply a, .pagination_links a:hover, #commentform input[type="submit"], #sidebar input[type="submit"], #inline_search input[type="submit"], .js_swp_theme_button a, ';
			$menu_text_color .= '#contactform input[type="submit"], .woocommerce a.button, .woocommerce-page a.button, .current_tax, ';
			$menu_text_color .= '.woocommerce-page button.button.alt, .woocommerce button.button.alt, .woocommerce-page #respond input#submit {color: '.$themeOptions['menu_text_color'].';}';
			echo $menu_text_color;
			
			echo '.mobile_menu_hmb span { background-color: '.$themeOptions['menu_text_color'].';}';
			
			echo '#sidebar a:hover, .view_more a:hover, .event_item_list:hover > .event_venue_list a  {border-color: '.$themeOptions['second_color'].';}';
			
			echo '.post_item_title a:hover { border-bottom-color: '.$themeOptions['second_color'].';}';
			echo '.post_item:hover > .post_item_title a, .post_item_commerce_container:hover > .product_title a, .post_item_event_container:hover > .post_item_title a { border-bottom-color: '.$themeOptions['second_color'].';}';
			//echo ' { border-bottom-color: '.$themeOptions['second_color'].';}';
			
			echo '::selection  {background: '.$themeOptions['second_color'].';}';
			echo '::-moz-selection  {background: '.$themeOptions['second_color'].';}';
			echo '::-webkit-selection  {background: '.$themeOptions['second_color'].';}';
	//		echo '.mejs-time-current {background-color: '.$themeOptions['second_color'].' !important;}';
			echo 'blockquote {border-left-color: '.$themeOptions['second_color'].';}';
			
			@$containerRGBBgc = self::hex_to_rgb($themeOptions['content_container_bgc']);
			$containerOpacity = self::valueToOpacity($themeOptions['content_container_opacity']);
			$masonryOpacity = self::valueToOpacity($themeOptions['masonry_container_opacity']);
			
			@$containerBgColor = 'rgba('.$containerRGBBgc['r'].','.$containerRGBBgc['g'].','.$containerRGBBgc['b'].','.$containerOpacity.')';
			$masonryBgColor = 'rgba('.$containerRGBBgc['r'].','.$containerRGBBgc['g'].','.$containerRGBBgc['b'].','.$masonryOpacity.')';

			echo '#post_content, #post_content_full, .js_full_container_inner, #sidebar, .event_meta, .album_meta, #album_listing, #event_listing, .js_swp_container { background-color: '.$containerBgColor.'; }';
			echo '.post_item, .event_item_list { background-color: '.$masonryBgColor.'; }';
			
			$focusColor = '.for_ajax_contact #contactform input[type="text"]:focus, .for_ajax_contact #contactform textarea:focus';
			$focusColor .= '{border-bottom-color: '.$themeOptions['second_color'].'; border-left-color: '.$themeOptions['second_color'].';}';
			echo $focusColor;
		?>
		   
      </style> 
      <!--/Customizer CSS-->
      <?php
   }
   
    /**
     * This will generate a line of CSS for use in header output. 
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     */
	public static function generate_css( $selector, $style, $mod_name, $preval, $postval) 
	{
		$return = '';
		$themeOptions = get_option('jamsession_options');

		/* set default values */
		if (!isset($themeOptions['logo_transparent_bgc']))
		{
			$themeOptions['logo_transparent_bgc'] = "1";
		}
		if (!isset($themeOptions['transparent_menu']))
		{
			$themeOptions['transparent_menu'] = "";
		}		
		if ( !isset( $themeOptions['menu_width']))
		{
			$themeOptions['menu_width'] = 'full';
		}
		if ( !isset( $themeOptions['header_layout']))
		{
			$themeOptions['header_layout'] = 'layout2';
		}
		if ( !isset( $themeOptions['logo_textcolor']))
		{
			$themeOptions['logo_textcolor'] = '#ffffff';
		}
		if ( !isset( $themeOptions['logo_bgcolor']))
		{
			$themeOptions['logo_bgcolor'] = '#7c003a';
		}
		if ( !isset( $themeOptions['menu_text_color']))
		{
			$themeOptions['menu_text_color'] = '#ffffff';
		}
		if ( !isset( $themeOptions['menu_active_text_color']))
		{
			$themeOptions['menu_active_text_color'] = '#ffffff';
		}		
		if ( !isset( $themeOptions['menu_color']))
		{
			$themeOptions['menu_color'] = '#7c003a';
		}
		if ( !isset( $themeOptions['second_color']))
		{
			$themeOptions['second_color'] = '#005b66';
		}
		if (!isset($themeOptions['remove_content_container_border'])) {
			$themeOptions['remove_content_container_border'] = "";
		}		
		
		
		$option = $themeOptions[$mod_name];
	
		if ( ! empty( $option ) ) 
		{
			$return = sprintf('%s { %s:%s; }',
							$selector,
							$style,
							$preval.' '.$option.' '.$postval
							);
							
			echo $return;
		}
		return $return;
    }
	
	/**
	* transform hex string (#ffffff) to rgb 
	* @param string hex color #ffffff
	*/
	public static function hex_to_rgb($hex) 
	{
		$hex = str_replace("#", "", $hex);
		$color = array();
 
		if(strlen($hex) == 3) 
		{
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else
		{
			if(strlen($hex) == 6) 
			{
				$color['r'] = hexdec(substr($hex, 0, 2));
				$color['g'] = hexdec(substr($hex, 2, 2));
				$color['b'] = hexdec(substr($hex, 4, 2));
			}
		}
 
		return $color;
	}
	
	public static function valueToOpacity($value)
	{
		/*value_1, value_2, etc.*/
		$arr = explode("_", $value);
		
		return floatval($arr[1])/10.0;
		//return $arr[1];
	}
}

?>
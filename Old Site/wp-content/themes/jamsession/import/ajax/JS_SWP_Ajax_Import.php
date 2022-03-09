<?php
/*
	Static front page name for each demo
	'import_name' => 'static front page name'
	'import_name' = xml file name
*/
$GLOB_FRONT_PAGES = array(
	'classic' => 'Main Slider Page',
	'minimal' => 'Main Slider Page',
	'extended' => 'Empty Page Visual Composer'
);

/*
	use the image title for: - logo_upload_value
							 - bgimage_upload_value
*/
$GLOB_IMPORT_THEME_SETTINGS = array(
	'classic'	=> '{
					   "logo_select":"blog_title",
					   "favicon_upload_value":"",
					   "use_mobile_menu":"use_normal_menu",
					   "contact_form_email":"",
					   "bgimage_upload_value":"",
					   "hide_upcoming_events":"hide_no",
					   "slider_image_protect":"allow_click",
					   "slider_interval":"10000",
					   "slider_transition":"6",
					   "maintenance_mode":"maintenance_disabled",
					   "maintenance_page":"maintenance_page_none",
					   "hide_post_meta":"do_not_hide",
					   "hide_archive_date":"do_not_hide",
					   "photo_tax_title":"",
					   "album_tax_title":"",
					   "event_tax_title":"",
					   "video_tax_title":""
					}',
	'minimal'	=> '{  
					   "logo_select":"custom_image",
					   "logo_upload_value":"new_logo",
					   "favicon_upload_value":"",
					   "use_mobile_menu":"use_mobile_menu",
					   "contact_form_email":"",
					   "bgimage_upload_value":"speaker_web",
					   "hide_upcoming_events":"hide_no",
					   "recaptcha_public_key":"",
					   "recaptcha_private_key":"",
					   "slider_image_protect":"allow_click",
					   "slider_interval":"10000",
					   "maintenance_mode":"maintenance_disabled",
					   "maintenance_page":"maintenance_page_none",
					   "hide_post_meta":"hide_meta"
					}',
	'extended'	=> '{
					   "logo_select":"blog_title",
					   "favicon_upload_value":"",
					   "use_mobile_menu":"use_normal_menu",
					   "contact_form_email":"",
					   "bgimage_upload_value":"speaker4web",
					   "hide_upcoming_events":"hide_no",
					   "upcoming_events_title":"Upcoming Events",
					   "upcoming_events_shows":"date_and_venue",
					   "recaptcha_public_key":"",
					   "recaptcha_private_key":"",
					   "slider_image_protect":"allow_click",
					   "slider_interval":"10000",
					   "slider_transition":"6",
					   "maintenance_mode":"maintenance_disabled",
					   "maintenance_page":"maintenance_page_none",
					   "hide_post_meta":"do_not_hide",
					   "hide_archive_date":"do_not_hide",
					   "disable_sticky_menu":"keep_sticky",
					   "photo_tax_title":"",
					   "album_tax_title":"",
					   "event_tax_title":"",
					   "video_tax_title":""
					}'
);

$GLOB_IMPORT_THEME_CUSTOMIZER = array(
	'classic'	=>	'{  
					   "logo_textcolor":"#ffffff",
					   "logo_transparent_bgc":true,
					   "logo_bgcolor":"#0e6782",
					   "menu_text_color":"#ffffff",
					   "menu_color":"#7c003a",
					   "menu_width":"full",
					   "transparent_menu":false,
					   "header_layout":"layout2",
					   "second_color":"#005b66"
					}',
	'minimal'	=>	'{  
					   "menu_color":"#af053e",
					   "second_color":"#af053e"
					}',
	'extended'	=>	'{
					   "menu_color":"#005466",
					   "second_color":"#006a82",
					   "content_container_opacity":"value_5"
					}'
);


function JAMSESSION_SWP_flush_buffer($str) {
	$allowed_tags = array(
		'br' 		=> array(),
		'strong'	=> array(),
		'span'		=> array(
				'class'	=> array()
		),
		'a'	=> array(
			'href'		=> array(),
			'target'	=> array()
		)
	);

	echo wp_kses($str, $allowed_tags);
    echo str_pad('',4096)."\n";
	ob_flush();
	flush();	
}

/*
	Import content from xml
*/
function JAMSESSION_SWP_import_content_by_name($import_name, &$importer_output) {
	$importer_output = "";
	
	JAMSESSION_SWP_flush_buffer('Preparing to import <strong>' . $import_name . '</strong> demo...<br>');

	/*create the path to the xml file*/
	$import_file = get_template_directory().'/import/xml/'.$import_name.'/1.xml';
	
	if (!defined('WP_LOAD_IMPORTERS')) {
		define('WP_LOAD_IMPORTERS', true);
	}		
	require_once ABSPATH . 'wp-admin/includes/import.php';
	
	/*get WP_Importer from wordpress*/
	if (!class_exists('WP_Importer')) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if (file_exists( $class_wp_importer)) {
			require_once($class_wp_importer);
		} else {
			$importer_error = true;
			JAMSESSION_SWP_flush_buffer("Could not locate class WP_Importer.<br>");
		}
	}

	/*get WP_Import*/
	if (!class_exists('WP_Import')) {
		require_once(get_template_directory()."/import/lib/wordpress-importer.php");				
	}
	
	if(!is_file($import_file)){
		$errorLoc = "The XML file containing the dummy content located at: <br>".$import_file." <br>is not available or could not be read.<br>";
		$errorLoc .= " You might want to try to set the file permission to chmod 755.<br>";
		JAMSESSION_SWP_flush_buffer($errorLoc);
	} else {
		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;			
		
		add_filter( 'import_post_meta_key', array( $wp_import, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$wp_import, 'bump_request_timeout' ) );
		
		JAMSESSION_SWP_flush_buffer("Starting the import process!");
		$wp_import->import_start($import_file);

		JAMSESSION_SWP_flush_buffer("<br>Importing author information... ");
		$wp_import->get_author_mapping();
		
		wp_suspend_cache_invalidation(true);
		
		JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span> <br>Importing post categories... ');
		
		ob_start();
		$wp_import->process_categories();
		$wp_import->process_tags();
		$wp_import->process_terms();
		$importer_output = ob_get_clean();
		
		JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span> <br>Importing content, please be patient, this might take a while');
		
		/*ob_start();*/
		$wp_import->process_posts();
		/*$importer_output .= ob_get_clean();*/

		JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span> <br>');
		
		wp_suspend_cache_invalidation(false);

		/* update incorrect/missing information in the DB*/
		$wp_import->backfill_parents();
		$wp_import->backfill_attachment_urls();
		$wp_import->remap_featured_images();

		ob_start();
		$wp_import->import_end();
		$importer_output .= ob_get_clean();
		
		$wp_import->flag_as_imported['content'] = true;
	}	
}


/*
	Set static front page
*/
function JAMSESSION_SWP_set_static_front_page($importName) {
	global $GLOB_FRONT_PAGES;

	JAMSESSION_SWP_flush_buffer('Setting static front page for <strong>'.$importName.'</strong> demo... ');
	
	/* check if array elem exists */
	if (!array_key_exists($importName, $GLOB_FRONT_PAGES)) {
		JAMSESSION_SWP_flush_buffer('Incorrect demo import name when setting static front page: '.$importName.'<br>');
		return false;
	}
	
	/* Use a static front page */
	$pageObj = get_page_by_title($GLOB_FRONT_PAGES[$importName]);
	update_option('page_on_front', $pageObj->ID);
	update_option('show_on_front', 'page');
	
	JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span><br>');
	return true;
}

/*
	Import theme settings
*/
function JAMSESSION_SWP_set_import_theme_settings($importName) {
	global $GLOB_IMPORT_THEME_SETTINGS;

	JAMSESSION_SWP_flush_buffer('Importing theme settings for <strong>'.$importName.'</strong> demo... ');
	
	/* check if array elem exists */
	if (!array_key_exists($importName, $GLOB_IMPORT_THEME_SETTINGS)) {
		JAMSESSION_SWP_flush_buffer('Incorrect demo import name when setting static front page: '.$importName.'<br>');
		return false;
	}
	
	$themeOptionsArray = array();
	$themeOptionsArray = json_decode($GLOB_IMPORT_THEME_SETTINGS[$importName], true);
	
	/*
		Images set as file name, to be able to take the image from the own server
	*/
	if (!empty($themeOptionsArray['logo_upload_value'])) {
		$themeOptionsArray['logo_upload_value'] = JAMSESSION_SWP_get_img_url_by_name($themeOptionsArray['logo_upload_value']);
	}
	if (!empty($themeOptionsArray['bgimage_upload_value'])) {
		$themeOptionsArray['bgimage_upload_value'] = JAMSESSION_SWP_get_img_url_by_name($themeOptionsArray['bgimage_upload_value']);
	}	
	update_option( 'jamsession_theme_general_options', $themeOptionsArray);	
	
	/*update theme customizer options*/
	$customizerImportError = JAMSESSION_SWP_set_import_theme_customizer($importName);
	if ($customizerImportError != '') {
		JAMSESSION_SWP_flush_buffer($customizerImportError);
		return false;
	}

	JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span><br>');	
	return true;	
}

/*
	called from theme settings function - JAMSESSION_SWP_set_import_theme_settings
*/
function  JAMSESSION_SWP_set_import_theme_customizer($importName) {
	global $GLOB_IMPORT_THEME_CUSTOMIZER;
	
	/* check if array elem exists */
	if (!array_key_exists($importName, $GLOB_IMPORT_THEME_CUSTOMIZER)) {
		return 'Incorrect demo import name when setting customizer options: '.$importName;
	}
	
	$themeCustomizerArray = array();
	$themeCustomizerArray = json_decode($GLOB_IMPORT_THEME_CUSTOMIZER[$importName], true);
	
	update_option( 'jamsession_options', $themeCustomizerArray);	

	return '';
}


function JAMSESSION_SWP_set_menu_location($menu_name, $menu_location) {
	/*
	   Menu_Object (
		   term_id => 4
		   name => My Menu Name
		   slug => my-menu-name
		   term_group => 0
		   term_taxonomy_id => 4
		   taxonomy => nav_menu
		   description => 
		   parent => 0
		   count => 6
	   )
	*/
	JAMSESSION_SWP_flush_buffer('Setting menu location...');
	
	$menu_object = wp_get_nav_menu_object($menu_name);
	$locations = get_theme_mod('nav_menu_locations');
	$locations[$menu_location] = $menu_object->term_id;
	set_theme_mod('nav_menu_locations', $locations);

	JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span><br>');	
}

function JAMSESSION_SWP_get_img_url_by_name($post_name) {
		$args = array(
            'post_per_page' => 1,
            'post_type'     => 'attachment',
            'name'          => trim($post_name),
        );
        $result = new WP_Query($args);
		$imageURL = "";
		if ($result->have_posts()) {
			$imageURL = wp_get_attachment_url($result->posts[0]->ID);
		}
       
		wp_reset_postdata();
		return $imageURL;
}

function JAMSESSION_SWP_import_slider($slider_name) {

	JAMSESSION_SWP_flush_buffer('Importing slider...');

	/*get the path tp WP*/
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path);
	$path_to_wp = $path_to_file[0];
	 
	/*require needed WP files*/
	require_once( $path_to_wp.'/wp-load.php' );
	require_once( $path_to_wp.'/wp-includes/functions.php');
	 
	/**/	 
	$slider_array = array(get_template_directory()."/import/sliders/" . $slider_name);
	$slider = new RevSlider();
	 
	foreach($slider_array as $filepath){
		$slider->importSliderFromPost(true, true, $filepath);  
	}

	JAMSESSION_SWP_flush_buffer('<span class="swp_msg_ok">Done!</span><br>');

	return true;
}

?>
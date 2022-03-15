<?php
/**
 * Plugin Name: JamSession Post Types
 * Plugin URI: http://www.smartwpress.com/jamsession/
 * Description: This plugin adds custom post types used by JamSession wordpress theme.
 * Version: 2.4.9.6
 * Author: SmartWpress
 * Author URI: http://www.smartwpress.com
 * Text Domain: jamsession
 * Domain Path: /languages
 * License: GNU General Public License version 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 
 /*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
	if (! defined('CDIR_PATH'))	{
		define('CDIR_PATH', plugin_dir_path(__FILE__));
	}

 
/* 
|--------------------------------------------------------------------------
| PLUGIN DEVELOPMENT
|--------------------------------------------------------------------------
*/


/* 
	Plugin Settings
*/
require_once(CDIR_PATH."/jpt_plugin_settings.php");


/*
	Custom Post Types 
*/
require_once(CDIR_PATH."/slides.php");
require_once(CDIR_PATH."/videos.php");
require_once(CDIR_PATH."/photo_albums.php");
require_once(CDIR_PATH."/albums.php");
require_once(CDIR_PATH."/events.php");
require_once(CDIR_PATH."/js_swp_vc_shortcodes.php");
require_once(CDIR_PATH."/custom_meta.php");

/*Widgets*/
require_once(CDIR_PATH."/jpt_widgets.php");


/*load text domain*/
function JAMSESSION_SWP_jamsession_post_types_init() {
	$domain = "jamsession-post-types";
	$locale = apply_filters('plugin_locale', get_locale(), $domain);
	$trans_location = trailingslashit(WP_LANG_DIR) . "plugins/" . $domain . '-' . $locale . '.mo';
	
	if ($loaded = load_plugin_textdomain($domain, FALSE, $trans_location)) {
		return $loaded;
	} else {
		/*old location, languages dir in the plugin dir*/
		load_plugin_textdomain($domain, FALSE, basename(dirname(__FILE__)) . '/languages/');
	}
}
add_action('init', 'JAMSESSION_SWP_jamsession_post_types_init');


/* load the needed scripts and styles */
function JAMSESSION_SWP_load_all_assets() {
	JAMSESSION_SWP_register_style_for_gallery();
	JAMSESSION_SWP_plugin_backend_style();
	JAMSESSION_SWP_register_scripts();
	JAMSESSION_SWP_enqueue_scripts();
	JAMSESSION_SWP_enqueque_time_picker();
	JAMSESSION_SWP_enqueue_scripts_and_styles();
	JAMSESSION_SWP_get_style_for_album();
	JAMSESSION_SWP_get_script_for_album();
	JAMSESSION_SWP_call_date_picker();
}
add_action('admin_enqueue_scripts', 'JAMSESSION_SWP_load_all_assets');


/*
	Flush rewrite rules on activation/deactivation
*/
function JAMSESSION_SWP_activate() {
	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'JAMSESSION_SWP_activate');

function JAMSESSION_SWP_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'JAMSESSION_SWP_deactivate');



/*
	register styles and scripts BEGIN [[[
*/
function JAMSESSION_SWP_register_style_for_gallery() {
	wp_register_style('js_gallery_post_admin', plugins_url('/css/js_gallery_post_admin.css', __FILE__));
	wp_enqueue_style('js_gallery_post_admin');
}

function JAMSESSION_SWP_plugin_backend_style() {
	wp_register_style('js_backend_css', plugins_url('/css/backend_style.css', __FILE__));
	wp_enqueue_style('js_backend_css');
}

function JAMSESSION_SWP_enqueue_scripts() {
	wp_enqueue_script('handle_image_actions');	
	/*TODO: remove this script*/
	wp_enqueue_script('media_upload_assets');
}

function JAMSESSION_SWP_register_scripts() {
	wp_register_script('handle_image_actions', plugins_url('/js/handle_image_actions.js', __FILE__), array(), '', true);
	wp_register_script('media_upload_assets', plugins_url('/js/media_upload_assets.js', __FILE__), array(), '', true);
}

function JAMSESSION_SWP_enqueque_time_picker() {
	wp_register_style('jquery.ui.timepicker', plugins_url('/css/jquery.ui.timepicker.css', __FILE__));
	wp_enqueue_style('jquery.ui.timepicker');

	wp_register_script('jquery.ui.timepicker', plugins_url('/js/jquery.ui.timepicker.js', __FILE__), array(), '', true);
	wp_enqueue_script('jquery.ui.timepicker');
}

/*	javascript & styles stuff for albums */
function JAMSESSION_SWP_enqueue_scripts_and_styles() {
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-style', plugins_url('/css/jquery-ui.css', __FILE__));
}

function JAMSESSION_SWP_get_style_for_album() {
	wp_register_style('js_audio_styles',  plugins_url('/css/js_audio_styles.css', __FILE__));
	wp_enqueue_style('js_audio_styles');
}

function JAMSESSION_SWP_get_script_for_album() {
	wp_register_script('handle_audio_actions', plugins_url('/js/handle_audio_actions.js', __FILE__), array(), '', true);
	wp_enqueue_script('handle_audio_actions');	
}

function JAMSESSION_SWP_call_date_picker() {
	/* call datepicker & initialize datepicker */
	wp_register_script('initialize_datepicker', plugins_url('/js/initialize_datepicker.js', __FILE__), array(), '', true);
	wp_enqueue_script('initialize_datepicker');
}
/*
	register styles and scripts END ]]]
*/

/*
	Retreive plugin option
*/
function JAMSESSION_SWP_JPT_get_plugin_option($option) {
	$options = get_option('JPT_plugin_options'); 
	
	if (isset($options[$option]))	{
		return $options[ $option ];
	}
	
	return "";
}


 ?>
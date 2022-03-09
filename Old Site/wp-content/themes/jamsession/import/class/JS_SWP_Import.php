<?php 

	// Exit if accessed directly
	if (!defined('ABSPATH')) {
		exit;
	}

if (!class_exists('JS_SWP_Import')) {
	class JS_SWP_Import {
		public function __construct() {
		
		}
		
		public function import_content($file) {
			$returnVal = array(
				'status' 	=> '',
				'message'	=> ''
			);
		
			if (!defined('WP_LOAD_IMPORTERS')) {
				define('WP_LOAD_IMPORTERS', true);
			}

	        require_once ABSPATH . 'wp-admin/includes/import.php';

	        $importer_error = false;
			$error_message = '';

			/*get WP_Importer from wordpress*/
	        if ( !class_exists('WP_Importer')) {

	            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	            if (file_exists( $class_wp_importer)) {
	                require_once($class_wp_importer);
	            } else {
	                $importer_error = true;
					$error_message = "Could not locate class WP_Importer.<br>";
	            }
	        }

			/*get WP_Import*/
	        if (!class_exists( 'WP_Import' )) {
				require_once(get_template_directory()."/import/lib/wordpress-importer.php");				
	        }

	        if($importer_error){
				$returnVal['status'] = 'IMPORT_ERROR';
				$returnVal['message'] = $error_message;
				return $returnVal;
	        }
			
			if(!is_file($file)){
				$errorLoc = "The XML file containing the dummy content located at: <br>".$file." <br>is not available or could not be read.<br>";
				$errorLoc .= " You might want to try to set the file permission to chmod 755.<br>";
				
				$returnVal['status'] = 'IMPORT_ERROR';
				$returnVal['message'] = $errorLoc;
				
				return $returnVal;
			} else {
				/*import content - print error messages*/
				set_time_limit(0);
				ob_start();
				$wp_import = new WP_Import();
				$wp_import->fetch_attachments = true;

				//$wp_import->import( $file );
		
					add_filter( 'import_post_meta_key', array( $wp_import, 'is_valid_meta_key' ) );
					add_filter( 'http_request_timeout', array( &$wp_import, 'bump_request_timeout' ) );

					$wp_import->import_start( $file );

					$wp_import->get_author_mapping();

					wp_suspend_cache_invalidation( true );
					$wp_import->process_categories();
					$wp_import->process_tags();
					$wp_import->process_terms();
					$wp_import->process_posts();
					wp_suspend_cache_invalidation( false );

					// update incorrect/missing information in the DB
					$wp_import->backfill_parents();
					$wp_import->backfill_attachment_urls();
					$wp_import->remap_featured_images();

					$wp_import->import_end();
					$wp_import->flag_as_imported['content'] = true;

					$returnVal['message'] = ob_get_clean();
			}
			
			$returnVal['status'] = "IMPORT_SUCCESS";
			
			return $returnVal;
		}
	}/*class JS_SWP_Import*/
}
 
 ?>
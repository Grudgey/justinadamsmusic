<?php
/*
	Demo data
	IMPORTANT: 
		- add new demo here involves adding 
		  new static front page in JS_SWP_Ajax_Import in GLOB_FRONT_PAGES array:
		  ex: 'minimal' => 'Main Slider Page'	
*/
$GLOB_IMPORT_DEMOS = array(
	array(
		'name'	=> 'Classic',
		'import_name'	=> 'classic',
		'img' => 'main.png'
	),
	array(
		'name'	=> 'Minimal',
		'import_name'	=> 'minimal',
		'img'=> 'minimal.png'
	),
	array(
		'name'	=> 'Extended',
		'import_name'	=> 'extended',
		'img' => 'extended.png'
	)
);

function JAMSESSION_SWP_setup_admin_import_menu() {
	add_theme_page(
        'Import JamSession Demo', 	/* page title*/
		'Jam Session Import',  	/* menu title */
		'administrator',    		/*capability*/
        'jamsession_import_demo',  	/*menu_slug*/
		'JAMSESSION_SWP_import_page_settings'  /*function */
	);
}
add_action("admin_menu", "JAMSESSION_SWP_setup_admin_import_menu");
define("JS_SWP_PRINT_IMPORTER", false);

function JAMSESSION_SWP_import_page_settings() {
	global $GLOB_IMPORT_DEMOS;
?>
	<!-- Create a header in the default WordPress 'wrap' container -->  
	<div class="wrap" id="demo_chooser">  
		<div id="icon-themes" class="icon32"></div>  
		<h2 class="import_demo_title">Import JamSession Demo</h2>

		<form method="post">
			<div class="available_demos">
				<div class="import_items">
					<?php
					$demoNo = 0;
					$DEMO_ON_ROW = 3;
					$IMG_URL = get_template_directory_uri().'/import/img/';
					foreach ($GLOB_IMPORT_DEMOS as $demo) {
						if (!($demoNo % $DEMO_ON_ROW)) {
							if ($demoNo != 0) {
								echo '</div>';
							}
							
							echo '<div class="items_row">';
						}
					?>					
						<div class="items_cell">
							<img src="<?php echo $IMG_URL.$demo['img']; ?>" alt="<?php  echo $demo['name']; ?>">
							<button class="import_jamsession_btn button button-primary" type="submit" data-importname="<?php echo $demo['import_name']; ?>">Import <?php  echo $demo['name']; ?> Demo</button>
						</div>
						
					<?php					
						$demoNo++;
					}
					?>
					</div> <!-- latest .items_row -->
				</div> <!-- .import_items -->
			</div> <!-- .available_demos -->

			<input type="text" name="demo_to_import" id="demo_to_import" value=""/>
			
			<div class="import_spinner">
				<img src="<?php echo get_template_directory_uri().'/import/asset/spinner.gif';?>">
			</div>
		</form>

		<?php if (isset($_POST['demo_to_import'])) { ?>
			<div class="importer_overlay"></div>
		<?php } ?>
	</div> <!-- wrap-->
	
		
	<hr class="after_demos">
	<?php  
	JAMSESSION_SWP_flush_buffer("");
	
	$import_name = "";
	if (isset($_POST['demo_to_import'])) {
		$import_name = $_POST['demo_to_import'];
	} else {
		return;
	}	
	?>

	<div id="import_message">
		<?php 
			$importer_output = "";
			JAMSESSION_SWP_import_content_by_name($import_name, $importer_output);

			JAMSESSION_SWP_set_static_front_page($import_name);

			JAMSESSION_SWP_set_import_theme_settings($import_name);

			JAMSESSION_SWP_set_menu_location("Main Menu", "main-menu");

			if ("extended" == $import_name) {
				JAMSESSION_SWP_import_slider("mainrevslider.zip");
			}

			JAMSESSION_SWP_flush_buffer('<strong>Importer process finished <span class="swp_msg_ok no_padding">successfully</span>, visit your <a href="'.home_url().'">new website</a>!</strong><br>');
		?>
	</div>
		
	<div id="js_swp_import_details">
		<?php
			if (!empty($importer_output)) {
				JAMSESSION_SWP_flush_buffer($importer_output);
			}
		?>
	</div>
<?php
}


/*
	Demo Import Related Files
*/
require_once(get_template_directory()."/import/class/JS_SWP_Import.php");
require_once(get_template_directory()."/import/ajax/JS_SWP_Ajax_Import.php");


function JAMSESSION_SWP_enqueue_import() {
	wp_register_script( 'jamsession_import_js', get_template_directory_uri(). '/import/js/jamsession_import.js', array( 'jquery'), '', true);
	wp_enqueue_script( 'jamsession_import_js');
	
	wp_register_style('jamsession_import_admin_style', get_template_directory_uri(). '/import/css/import_demo.css');
	wp_enqueue_style('jamsession_import_admin_style');
	

}
add_action('admin_enqueue_scripts', 'JAMSESSION_SWP_enqueue_import');

?>
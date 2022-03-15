<?php

function JAMSESSION_SWP_custom_bg_meta() {
    add_meta_box( 'js_swp_custom_bg_meta', "Add Custom Background Image", 'JAMSESSION_SWP_custom_bg_meta_callback',  'post');
	add_meta_box( 'js_swp_custom_bg_meta', "Add Custom Background Image", 'JAMSESSION_SWP_custom_bg_meta_callback',  'page');

	add_meta_box( 'js_swp_custom_bg_meta', "Add Custom Background Image", 'JAMSESSION_SWP_custom_bg_meta_callback',  'js_albums');
	add_meta_box( 'js_swp_custom_bg_meta', "Add Custom Background Image", 'JAMSESSION_SWP_custom_bg_meta_callback',  'js_events');
	add_meta_box( 'js_swp_custom_bg_meta', "Add Custom Background Image", 'JAMSESSION_SWP_custom_bg_meta_callback',  'js_photo_albums');
	add_meta_box( 'js_swp_custom_bg_meta', "Add Custom Background Image", 'JAMSESSION_SWP_custom_bg_meta_callback',  'js_videos');
	
	/*add custom meta to Discography page template only*/
	global $post;
	$post_id = $post->ID;
	$page_template = get_post_meta($post_id,'_wp_page_template', TRUE);
	if ('page_discography.php' == $page_template) {
		add_meta_box(
			"js_swp_masonry_settings_meta", 
			esc_html__("Masonry Settings", 'jamsession-post-types'), 
			"JAMSESSION_SWP_masonry_settings_cbk", 
			"page");
	}
}
add_action( 'add_meta_boxes', 'JAMSESSION_SWP_custom_bg_meta', 0);
	
function JAMSESSION_SWP_custom_bg_meta_callback($post) {
	
    $js_swp_stored_meta = get_post_meta($post->ID);
	$meta_bg = '';
	if (isset($js_swp_stored_meta['js_swp_meta_bg_image'])) {
		$meta_bg = $js_swp_stored_meta['js_swp_meta_bg_image'][0];
	}

	wp_nonce_field( basename( __FILE__ ), 'js_swp_nonce' );
	ob_start();
?>	
	<p>
		<input type="text" style="width:100%; margin-bottom: 5px;" name="js_swp_meta_bg_image" id="js_swp_meta_bg_image" value="<?php echo $meta_bg; ?>" />
		<div class="js_swp_meta_bg_image_buttons">
			<input type="button" id="js_swp_meta_bg_image-button" class="button" value="Choose Image" />
			<input type="button" id="js_swp_meta_bg_image-buttondelete" class="button" value="Remove Image" />
		</div>
	</p>
	<div id="custom_bg_meta_preview">
		<img style="max-width:100%;" src="<?php echo $meta_bg; ?>" />
    </div>
<?php

	$output = ob_get_clean();
	echo $output;
}

function JAMSESSION_SWP_masonry_settings_cbk($post) {
	$stored_meta = get_post_meta($post->ID);

	$masonry_cols = "5";
	if (isset($stored_meta['js_swp_masonry_settings_meta'])) {
		$masonry_cols = $stored_meta['js_swp_masonry_settings_meta'][0];
	}

	$masonry_cols_support = array(
		'5 Columns'	=> '5',
		'6 Clumns'	=> '6'
	);

	ob_start();
?>
	<p>
		<select id="js_swp_masonry_settings_meta" name="js_swp_masonry_settings_meta">
		<?php
			foreach($masonry_cols_support as $key => $value) {
				if ($value == $masonry_cols) {
					?>
					<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_html($key); ?> </option>
					<?php
				} else {
					?>
					<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_html($key); ?> </option>
					<?php
				}
			}
		?>
		</select>
		<p class="description show_on_right">
			<?php echo esc_html__('Choose the number of columns on row on masonry layout for Discography page.', 'lucille'); ?>
		</p>
	</p>
<?php

	$output = ob_get_clean();
	echo $output;
}

function JAMSESSION_SWP_blog_layout_type_cbk($post) {
	$js_swp_stored_meta = get_post_meta($post->ID);
	
	$meta_blog_layout_type = 'masonry_blog_layout';
	if (isset($js_swp_stored_meta['js_swp_blog_layout_type'])) {
		$meta_blog_layout_type = $js_swp_stored_meta['js_swp_blog_layout_type'][0];
	}
	
	$values = array(
		"blog_as_masonry" => "View Blog Page as Masonry Layout (default)",
		"blog_as_list"	  => "View Blog Page as List Layout"
	);

	ob_start();
	echo '<p class="js_swp_blog_layout_type_select_container"><select name="js_swp_blog_layout_type" id="js_swp_blog_layout_type">';
	foreach($values as $key	=> $value) {
		if ($meta_blog_layout_type == $key) {
			echo '<option value="'.$key.'" selected="selected">'.$value.'</option>';
		} else {
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}
	echo '</select></p>';
	$output = ob_get_clean();
	echo $output;
}

function JAMSESSION_SWP_custom_bg_meta_save($post_id) {
     // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'js_swp_nonce' ] ) && wp_verify_nonce( $_POST[ 'js_swp_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
	
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

	// Checks for input and saves if needed
	if( isset( $_POST[ 'js_swp_meta_bg_image' ] ) ) {
		update_post_meta( $post_id, 'js_swp_meta_bg_image', trim(esc_url($_POST['js_swp_meta_bg_image']))) ;
	}
	/*
	if( isset( $_POST[ 'js_swp_blog_layout_type' ] ) ) {
		update_post_meta( $post_id, 'js_swp_blog_layout_type', trim($_POST['js_swp_blog_layout_type'])) ;
	}
	*/	
}
add_action( 'save_post', 'JAMSESSION_SWP_custom_bg_meta_save' );

function JAMSESSION_SWP_masonry_settings_save($post_id) {
	$is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
	
	if ($is_autosave || $is_revision) {
		return;
	}

	if(isset($_POST['js_swp_masonry_settings_meta'])) {
		update_post_meta($post_id, 'js_swp_masonry_settings_meta', trim($_POST['js_swp_masonry_settings_meta'])) ;
	}	
}
add_action( 'save_post', 'JAMSESSION_SWP_masonry_settings_save' );


function JAMSESSION_SWP_custom_bg_script() {
    global $typenow;
    if (($typenow == 'page') || ($typenow == 'post') || 
	($typenow == 'js_videos') || ($typenow == 'js_photo_albums') || ($typenow == 'js_events') || ($typenow == 'js_albums')) {
        wp_enqueue_media();
 
        // Registers and enqueues the required javascript.
        wp_register_script( 'js_swp_custom_bg_meta', plugin_dir_url( __FILE__ ) . '/js/js_swp_custom_bg_meta.js', array( 'jquery' ) );
        wp_enqueue_script( 'js_swp_custom_bg_meta' );
    }
}
add_action( 'admin_enqueue_scripts', 'JAMSESSION_SWP_custom_bg_script' );

?>
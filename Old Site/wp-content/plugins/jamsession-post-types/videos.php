<?php

add_action( 'init', 'JAMSESSION_SWP_create_videos_post', 11);
function JAMSESSION_SWP_create_videos_post() 
{
	$slug = JAMSESSION_SWP_JPT_get_plugin_option("video");
	
	if ( "" == $slug)
	{
		$slug = "js_videos";
	}
	
	register_post_type( 'js_videos',
		array(
			'labels' => array(
				'name' =>  __('Videos', 'jamsession-post-types') ,
				'singular_name' =>  __('Video', 'jamsession-post-types') ,
				'add_new' => __('Add New Video', 'jamsession-post-types'),
				'add_new_item' => __('Add New Video', 'jamsession-post-types'),
				'edit' => __('Edit', 'jamsession-post-types'),
				'edit_item' => __('Edit Video', 'jamsession-post-types'),
				'new_item' => __('New Video', 'jamsession-post-types'),
				'view' => __('View', 'jamsession-post-types'),
				'view_item' => __('View Video', 'jamsession-post-types'),
				'search_items' => __('Search Videos', 'jamsession-post-types'),
				'not_found' => __('No Videos Found','jamsession-post-types'),
				'not_found_in_trash' => __('No Videos Found in Trash','jamsession-post-types'),
				'parent' => __('Parent Video','jamsession-post-types')
			),
		'public' => true,
		'rewrite' => array(
			'slug' => $slug,
			'with_front' => false
			),			
/*		'has_archive' => true,*/
		'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
		'menu_icon' => 'dashicons-video-alt2'
		)
	); 
}

/*
	admin section
*/

add_action( 'admin_init', 'JAMSESSION_SWP_videos_admin_init' );
function JAMSESSION_SWP_videos_admin_init() 
{
    add_meta_box( 'video_meta_box', 		/*the required HTML id attribute*/
        __('Video Custom Settings','jamsession-post-types'), 	/*text visible in the heading of meta box section*/
        'JAMSESSION_SWP_display_videos_meta_box',			/* callback FUNCTION which renders the contents of the meta box*/
        'js_videos', 						/* the name of the custom post type where the meta box will be displayed*/
		'normal', 							/*defines the part of the page where the edit screen section should be shown*/
		'high' 								/*defines the priority within the context where the boxes should show*/
    );
}

/*
	callback FUNCTION which renders the contents of the meta box
	$slideObject
*/
function JAMSESSION_SWP_display_videos_meta_box( $videoObject ) 
{

    // Retrieve current name of the youtube and vimeo based on js_video id
	$youtube_url = esc_html( get_post_meta( $videoObject->ID, 'video_youtube_url', true ) ); 	
	$vimeo_url = esc_html( get_post_meta( $videoObject->ID, 'video_vimeo_url', true ) ); 		
	
    ?>
    <table style= "width: 100%;">
        <tr >
            <td style= "width: 30%;"><?php echo __('Youtube URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text"  name="js_video_youtube_url" value="<?php echo $youtube_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Youtube short url like - http://youtu.be/jUk-5nsGedM .','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Vimeo URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="js_video_vimeo_url" value="<?php echo $vimeo_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Vimeo short url like - http://vimeo.com/8119784 .','jamsession-post-types'); ?></div>
			</td>
        </tr>				
    </table>
    <?php
}



/* 
	register save custom post (js_video) function 
*/
add_action( 'save_post', 'JAMSESSION_SWP_save_video_fields', 10, 2 );

/*
	save post function - triggered on save 
	$js_video_id
	$js_videoObject
*/
function JAMSESSION_SWP_save_video_fields( $js_video_id, $js_video ) 
{
    // Check post type jamsession_slides type
    if ( $js_video->post_type == 'js_videos' ) 
	{
        // Store data in post meta table if present in post data
        if ( isset( $_POST['js_video_youtube_url'] )  ) 
		{
            update_post_meta( $js_video_id, 'video_youtube_url', $_POST['js_video_youtube_url'] );
        }		
        if ( isset( $_POST['js_video_vimeo_url'] ) ) 
		{
            update_post_meta( $js_video_id, 'video_vimeo_url', $_POST['js_video_vimeo_url'] );
        }				
    }
}

/*adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]*/
add_filter('manage_edit-js_videos_columns', 'JAMSESSION_SWP_videos_admin_columns_func');

function JAMSESSION_SWP_videos_admin_columns_func( $columns)
{
	$columns = array(
		'cb'	=> '<input type="checkbox" />',
		'title' => __('Video Title', 'jamsession-post-types'),
		'video_youtube_url'	=>	__('Youtube URL', 'jamsession-post-types'),		
		'video_vimeo_url'	=>	__('Vimeo URL', 'jamsession-post-types'),
		'author'	=> __('Author', 'jamsession-post-types'),
		'date'		=> __('Date', 'jamsession-post-types')		
		
	);
	
	return $columns;
}



/*
	fill the custom columns on admin 	manage_{post_type}_posts_custom_column
*/

add_action( 'manage_js_videos_posts_custom_column', 'JAMSESSION_SWP_manage_js_videos_columns_func', 10, 2 );

function JAMSESSION_SWP_manage_js_videos_columns_func($column, $js_video_id)
{
	global $post;
	
	switch( $column ) 
	{
		case 'video_youtube_url' :
			$slide_message = esc_html( get_post_meta( $js_video_id, 'video_youtube_url', true ) );
			echo $slide_message;
			break;
		case 'video_vimeo_url':
			$slide_url = esc_html( get_post_meta( $js_video_id, 'video_vimeo_url', true ) );
			echo $slide_url;
			break;
		default:
			break;
	}
}


/* making custom columns sortable*/
add_filter( 'manage_edit-js_videos_sortable_columns', 'JAMSESSION_SWP_videos_sortable_columns' );

function JAMSESSION_SWP_videos_sortable_columns( $columns ) {

	$columns['video_youtube_url'] = 'video_youtube_url';
	$columns['video_vimeo_url'] = 'video_vimeo_url';
	$columns['author'] = 'author';

	return $columns;
}


/*
	Create Category for Videos
*/
add_action( 'init', 'JAMSESSION_SWP_create_video_category', 11);

function JAMSESSION_SWP_create_video_category()
{
	$slug = JAMSESSION_SWP_JPT_get_plugin_option("video_tax");
	if ( "" == $slug) {
		$slug = "video_category";
	}

	register_taxonomy(
			'video_category',
			'js_videos',
			array(
				'labels' => array(
					'name' => __('Video Categories', 'jamsession-post-types'),
					'singular_name'     => __( 'Video Category', 'jamsession-post-types' ),
					'search_items'      => __( 'Search Video Categories', 'jamsession-post-types'  ),
					'all_items'         => __( 'All Video Categories', 'jamsession-post-types'  ),
					'parent_item'       => __( 'Parent Video Category', 'jamsession-post-types'  ),
					'parent_item_colon' => __( 'Parent Video Category:', 'jamsession-post-types'  ),
					'edit_item'         => __( 'Edit Video Category', 'jamsession-post-types'  ),
					'update_item'       => __( 'Update Video Category', 'jamsession-post-types'  ),
					'add_new_item' 		=> __('Add New Video Category', 'jamsession-post-types'),
					'new_item_name' 	=> __('New Video Category', 'jamsession-post-types'),
				),
				'rewrite' => array(
					'slug' => $slug,
					'with_front' => false
				),
				'show_ui' => true,
				'show_tagcloud' => false,
				'hierarchical' => true
			)
		);
}

?>
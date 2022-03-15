<?php

/*========================= SLIDES SECTION BEGIN ==========================================*/
add_action( 'init', 'JAMSESSION_SWP_create_slide_post', 11);
function JAMSESSION_SWP_create_slide_post() 
{
	register_post_type( 'jamsession_slides',
		array(
			'labels' => array(
				'name' =>  __('Slides', 'jamsession-post-types') ,
				'singular_name' =>  __('Slide', 'jamsession-post-types') ,
				'add_new' => __('Add New Slide', 'jamsession-post-types'),
				'add_new_item' => __('Add New Slide', 'jamsession-post-types'),
				'edit' => __('Edit', 'jamsession-post-types'),
				'edit_item' => __('Edit Slide', 'jamsession-post-types'),
				'new_item' => __('New Slide', 'jamsession-post-types'),
				'view' => __('View', 'jamsession-post-types'),
				'view_item' => __('View Slide', 'jamsession-post-types'),
				'search_items' => __('Search Slides', 'jamsession-post-types'),
				'not_found' => __('No Slides Found','jamsession-post-types'),
				'not_found_in_trash' => __('No Slides Found in Trash','jamsession-post-types'),
				'parent' => __('Parent Slide','jamsession-post-types')
			),
		'public' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'show_in_nav_menus' => false,
		'has_archive' => false,
		'supports' => array( 'author', 'title', 'thumbnail'),
		'menu_icon' => 'dashicons-images-alt2',
		)
	); 
}

/*
	admin section - custom metabox
*/

add_action( 'admin_init', 'JAMSESSION_SWP_slides_admin_init' );
function JAMSESSION_SWP_slides_admin_init() 
{
    add_meta_box( 'slide_meta_box', /*the required HTML id attribute*/
        __('Slide Settings','jamsession-post-types'), 	/*text visible in the heading of meta box section*/
        'JAMSESSION_SWP_display_slides_meta_box',	/* callback FUNCTION which renders the contents of the meta box*/
        'jamsession_slides', /*the name of the custom post type where the meta box will be displayed*/
		'normal', /*defines the part of the page where the edit screen section should be shown*/
		'high' /*defines the priority within the context where the boxes should show*/
    );
}

/*
	callback FUNCTION which renders the contents of the meta box
	$slideObject
*/
function JAMSESSION_SWP_display_slides_meta_box( $slideObject ) 
{

    // Retrieve current name of the custom fields slide ID
	$slide_show_title = esc_html( get_post_meta( $slideObject->ID, 'slide_show_title', true ) );
    $slide_message = esc_html( get_post_meta( $slideObject->ID, 'slide_message', true ) );
    $slide_url = esc_html( get_post_meta( $slideObject->ID, 'slide_url', true ) ); 
	$youtube_url = esc_html( get_post_meta( $slideObject->ID, 'youtube_url', true ) ); 	
	$vimeo_url = esc_html( get_post_meta( $slideObject->ID, 'vimeo_url', true ) ); 		
	
    ?>
    <table style= "width: 100%;">
       <tr >
            <td style= "width: 30%;"><?php echo __('Hide Title &amp; Message','jamsession-post-types');?></td>
            <td >
				<?php 
					if ( isset($slide_show_title) && $slide_show_title != '' && $slide_show_title != '0')
					{
				?>
				<input style="margin-left:2px;" type="checkbox" checked="yes" name="jamsession_slide_show_title" value="1" />
				<?php
					}
					else
					{
				?>	
					<input  style="margin-left:2px;" type="checkbox" name="jamsession_slide_show_title" value="1" />
				<?php	
					}
				?>
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Hide Title and Message on front page.','jamsession-post-types'); ?> </div>
			</td>
        </tr>	
        <tr >
            <td style= "width: 30%;"><?php echo __('Message','jamsession-post-types');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="jamsession_slide_message" value="<?php echo $slide_message; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Message for the front page.','jamsession-post-types'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%;  display: block;"  type="text"  name="jamsession_slide_url" value="<?php echo $slide_url; ?>" /> 
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('URL loaded when visitor clicks on message.','jamsession-post-types');  ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Youtube URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text"  name="jamsession_youtube_url" value="<?php echo $youtube_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Youtube short url like - http://youtu.be/jUk-5nsGedM ','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Vimeo URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="jamsession_vimeo_url" value="<?php echo $vimeo_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Vimeo short url like - http://vimeo.com/8119784 ','jamsession-post-types'); ?></div>
			</td>
        </tr>				
    </table>
    <?php
}

/* register save post function */
add_action( 'save_post', 'JAMSESSION_SWP_save_slide_fields', 10, 2 );

/*
	save post function - triggered on save 
	$slide_id
	$slideObject
*/
function JAMSESSION_SWP_save_slide_fields( $slide_id, $slide ) 
{

    // Check post type jamsession_slides type
    if ( $slide->post_type == 'jamsession_slides' ) 
	{
        // Store data in post meta table if present in post data
        if ( isset( $_POST['jamsession_slide_show_title'] ) ) 
		{
            update_post_meta( $slide_id, 'slide_show_title', '1' );
        }
		else
		{
			update_post_meta( $slide_id, 'slide_show_title', '0' );
		}
        if ( isset( $_POST['jamsession_slide_message'] )  ) 
		{
            update_post_meta( $slide_id, 'slide_message', $_POST['jamsession_slide_message'] );
        }
        if ( isset( $_POST['jamsession_slide_url'] )  ) 
		{
            update_post_meta( $slide_id, 'slide_url', $_POST['jamsession_slide_url'] );
        }
        if ( isset( $_POST['jamsession_youtube_url'] ) ) 
		{
            update_post_meta( $slide_id, 'youtube_url', $_POST['jamsession_youtube_url'] );
        }		
        if ( isset( $_POST['jamsession_vimeo_url'] )  ) 
		{
            update_post_meta( $slide_id, 'vimeo_url', $_POST['jamsession_vimeo_url'] );
        }				
    }
}

/*
	adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]
*/
add_filter('manage_edit-jamsession_slides_columns', 'JAMSESSION_SWP_slides_admin_columns_func');

function JAMSESSION_SWP_slides_admin_columns_func( $columns)
{
	$columns = array(
		'cb'	=> '<input type="checkbox" />',
		'title' => __('Slide Title', 'jamsession-post-types'),
		'slide_message' => __('Slide Message', 'jamsession-post-types'),
		'slide_url'	=>	__('Slide URL', 'jamsession-post-types'),
		'author'	=> __('Author', 'jamsession-post-types'),
		'date'		=> __('Date', 'jamsession-post-types')		
		
	);
	
	return $columns;
}

/*
	fill the custom columns on admin
*/

add_action( 'manage_jamsession_slides_posts_custom_column', 'JAMSESSION_SWP_manage_jamsession_slides_columns_func', 10, 2 );

function JAMSESSION_SWP_manage_jamsession_slides_columns_func($column, $slide_id)
{
	global $post;
	
	switch( $column ) 
	{
		case 'slide_message' :
			$slide_message = esc_html( get_post_meta( $slide_id, 'slide_message', true ) );
			echo $slide_message;
			break;
		case 'slide_url':
			$slide_url = esc_html( get_post_meta( $slide_id, 'slide_url', true ) );
			echo $slide_url;
			break;
		default:
			break;
	}
}

/* making custom comumns sortable*/
add_filter( 'manage_edit-jamsession_slides_sortable_columns', 'JAMSESSION_SWP_slides_sortable_columns' );

function JAMSESSION_SWP_slides_sortable_columns( $columns ) {

	$columns['slide_message'] = 'slide_message';
	$columns['slide_url'] = 'slide_url';
	$columns['author'] = 'author';

	return $columns;
}

/*========================= SLIDES SECTION END ==========================================*/




?>
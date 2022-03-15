<?php


add_action( 'init', 'JAMSESSION_SWP_create_events_post', 11);
function JAMSESSION_SWP_create_events_post() 
{
	$slug = JAMSESSION_SWP_JPT_get_plugin_option("event");
	
	if ( "" == $slug)
	{
		$slug = "js_events";
	}
	
	register_post_type( 'js_events',
		array(
			'labels' => array(
				'name' =>  __('Events', 'jamsession-post-types') ,
				'singular_name' =>  __('Events', 'jamsession-post-types') ,
				'add_new' => __('Add New Event', 'jamsession-post-types'),
				'add_new_item' => __('Add New Event', 'jamsession-post-types'),
				'edit' => __('Edit', 'jamsession-post-types'),
				'edit_item' => __('Edit Event', 'jamsession-post-types'),
				'new_item' => __('New Event', 'jamsession-post-types'),
				'view' => __('View', 'jamsession-post-types'),
				'view_item' => __('View Event', 'jamsession-post-types'),
				'search_items' => __('Search Events', 'jamsession-post-types'),
				'not_found' => __('No Event Found','jamsession-post-types'),
				'not_found_in_trash' => __('No Event Found in Trash','jamsession-post-types'),
				'parent' => __('Parent Event','jamsession-post-types')
			),
		'public' => true,
		'rewrite' => array(
			'slug' => $slug,
			'with_front' => false
			),		
	/*	'has_archive' => true,*/
		'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
		'menu_icon' => 'dashicons-calendar',
		)
	); 
}

/*
	add metabox
*/

add_action( 'admin_init', 'JAMSESSION_SWP_events_admin_init' );
function JAMSESSION_SWP_events_admin_init() 
{
	/* album information */
    add_meta_box( 'events_meta_box', 			/*the required HTML id attribute*/
        __('Event Settings','jamsession-post-types'), 		/*text visible in the heading of meta box section*/
        'JAMSESSION_SWP_display_events_meta_box',				/* callback FUNCTION which renders the contents of the meta box*/
        'js_events', 							/*the name of the custom post type where the meta box will be displayed*/
		'normal', 								/*defines the part of the page where the edit screen section should be shown*/
		'high' 									/*defines the priority within the context where the boxes should show*/
    );
}

function JAMSESSION_SWP_display_events_meta_box( $eventObject ) 
{
    // Retrieve current name of the custom fields album ID
    $event_date = esc_html( get_post_meta( $eventObject->ID, 'event_date', true ) );
	$event_time = esc_html( get_post_meta( $eventObject->ID, 'event_time', true ) );
	$event_venue = esc_html( get_post_meta( $eventObject->ID, 'event_venue', true ) );
	$event_venue_url = esc_html( get_post_meta( $eventObject->ID, 'event_venue_url', true ) );	
	$event_location = esc_html( get_post_meta( $eventObject->ID, 'event_location', true ) );	
	$event_buy_tickets_message = esc_html( get_post_meta( $eventObject->ID, 'event_buy_tickets_message', true ) );		
	$event_buy_tickets_url = esc_html( get_post_meta( $eventObject->ID, 'event_buy_tickets_url', true ) );			
	$event_fb_message = esc_html( get_post_meta( $eventObject->ID, 'event_fb_message', true ) );
	$event_fb_url  = esc_html( get_post_meta( $eventObject->ID, 'event_fb_url', true ) );
	$event_map_url  = esc_html( get_post_meta( $eventObject->ID, 'event_map_url', true ) );
	$event_youtube_url  = esc_html( get_post_meta( $eventObject->ID, 'event_youtube_url', true ) );	
	$event_vimeo_url  = esc_html( get_post_meta( $eventObject->ID, 'event_vimeo_url', true ) );		
	/*
	$event_videos_link  = esc_html( get_post_meta( $eventObject->ID, 'event_videos_link', true ) );			
	$event_gallery_link  = esc_html( get_post_meta( $eventObject->ID, 'event_gallery_link', true ) );				
	*/
	
?>

    <table style= "width: 100%;">
       <tr >
            <td style= "width: 30%;"><?php echo __('Event Date','jamsession-post-types');?></td>
			<td ><input id="datepicker" style="width: 100%;  display: block;" type="text" name="event_date" value="<?php echo $event_date; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('The Date for Event YYYY/MM/DD','jamsession-post-types'); ?></div>
			</td>
        </tr>	
        <tr >
            <td style= "width: 30%;"><?php echo __('Event Time','jamsession-post-types');?></td>
            <td ><input id="timepicker" style="width: 100%;  display: block;" type="text" name="event_time" value="<?php echo $event_time; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Event Time hh:mm','jamsession-post-types'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Event Venue','jamsession-post-types');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_venue" value="<?php echo $event_venue; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Venue ex. Glastonbury Festival','jamsession-post-types'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Venue URL','jamsession-post-types');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_venue_url" value="<?php echo $event_venue_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Venue URL ex. http://www.glastonburyfestivals.co.uk/','jamsession-post-types'); ?></div>
			</td>
        </tr>		

        <tr >
            <td style= "width: 30%;"><?php echo __('Location','jamsession-post-types');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_location" value="<?php echo $event_location; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Event Location ex. Worthy Farm, Pilton GB','jamsession-post-types'); ?></div>
			</td>
        </tr>		

        <tr >
            <td style= "width: 30%;"><?php echo __('Buy Tickets Message','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_buy_tickets_message" value="<?php echo $event_buy_tickets_message; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('ex. Buy Tickets From ...','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Buy Tickets URL','jamsession-post-types');?></td>
            <td ><input style="width: 100%;  display: block;" type="text" name="event_buy_tickets_url" value="<?php echo $event_buy_tickets_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('ex. http://www.ticketmaster.com/','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Facebook Event Message','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_fb_message" value="<?php echo $event_fb_message; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('ex. Check event on Facebook','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Facebook Event URL','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_fb_url" value="<?php echo $event_fb_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('URL to Facebook Event Page','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Google Map Embed Code','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_map_url" value="<?php echo $event_map_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Embedded code ex. &lt;iframe src="https://www.google.com/maps/embed?pb=.." &gt;&lt;/iframe&gt;','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Youtube URL','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_youtube_url" value="<?php echo $event_youtube_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('URL to Promo Video on Youtube','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Vimeo URL','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_vimeo_url" value="<?php echo $event_vimeo_url; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('URL to Promo Video on Vimeo','jamsession-post-types'); ?></div>
			</td>
        </tr>	
<?php
/*		
        <tr >
            <td style= "width: 30%;"><?php echo __('Link to Internal Video','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_videos_link" value="<?php echo $event_videos_link; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('URL to Internal Video Post - Applicable to Past Events','jamsession-post-types'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Link to Internal Gallery','jamsession-post-types');?></td>
            <td ><input  style="width: 100%;  display: block;" type="text" name="event_gallery_link" value="<?php echo $event_gallery_link; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('URL to Internal Gallery Post - Applicable to Past Events','jamsession-post-types'); ?></div>
			</td>
        </tr>
*/		
?>		
		
	</table>
	
<?php
	
}

/* register save post function */
add_action( 'save_post', 'JAMSESSION_SWP_save_event_fields', 10, 2 );

/*
	save post function - triggered on save 
	$event_id
	$eventObject
*/
function JAMSESSION_SWP_save_event_fields( $event_id, $eventObject ) 
{

    // Check post type js_events type
    if ( $eventObject->post_type == 'js_events' ) 
	{
        // Store data in post meta table if present in post data
        if ( isset( $_POST['event_date'] ) ) 
		{
            update_post_meta( $event_id, 'event_date', $_POST['event_date'] );
        }
        if ( isset( $_POST['event_time'] ) ) 
		{
            update_post_meta( $event_id, 'event_time', $_POST['event_time'] );
        }
        if ( isset( $_POST['event_venue'] ) ) 
		{
            update_post_meta( $event_id, 'event_venue', $_POST['event_venue'] );
        }
        if ( isset( $_POST['event_venue_url'] ) ) 
		{
            update_post_meta( $event_id, 'event_venue_url', $_POST['event_venue_url'] );
        }
        if ( isset( $_POST['event_location'] ) ) 
		{
            update_post_meta( $event_id, 'event_location', $_POST['event_location'] );
        }
		if ( isset( $_POST['event_buy_tickets_message'] ) ) 
		{
            update_post_meta( $event_id, 'event_buy_tickets_message', $_POST['event_buy_tickets_message'] );
        }
		if ( isset( $_POST['event_buy_tickets_url'] ) ) 
		{
            update_post_meta( $event_id, 'event_buy_tickets_url', $_POST['event_buy_tickets_url'] );
        }
		if ( isset( $_POST['event_fb_message'] ) ) 
		{
            update_post_meta( $event_id, 'event_fb_message', $_POST['event_fb_message'] );
        }
		if ( isset( $_POST['event_fb_url'] ) ) 
		{
            update_post_meta( $event_id, 'event_fb_url', $_POST['event_fb_url'] );
        }
		if ( isset( $_POST['event_map_url'] ) ) 
		{
            update_post_meta( $event_id, 'event_map_url', $_POST['event_map_url'] );
        }
		if ( isset( $_POST['event_youtube_url'] ) ) 
		{
            update_post_meta( $event_id, 'event_youtube_url', $_POST['event_youtube_url'] );
        }
		if ( isset( $_POST['event_vimeo_url'] ) ) 
		{
            update_post_meta( $event_id, 'event_vimeo_url', $_POST['event_vimeo_url'] );
        }
		/*
		if ( isset( $_POST['event_videos_link'] ) && $_POST['event_videos_link'] != '') 
		{
            update_post_meta( $event_id, 'event_videos_link', $_POST['event_videos_link'] );
        }
		if ( isset( $_POST['event_gallery_link'] ) && $_POST['event_gallery_link'] != '') 
		{
            update_post_meta( $event_id, 'event_gallery_link', $_POST['event_gallery_link'] );
        }
		*/
		
		
	}
}


/*
	adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]
*/
add_filter('manage_edit-js_events_columns', 'JAMSESSION_SWP_events_admin_columns_func');
function JAMSESSION_SWP_events_admin_columns_func( $columns)
{
	$columns = array(
		'cb'	=> '<input type="checkbox" />',
		'title' => __('Event Title', 'jamsession-post-types'),
		'event_date'	=>	__('Event Date', 'jamsession-post-types'),				
		'event_location' => __('Location', 'jamsession-post-types'),
		'event_venue'	=>	__('Venue', 'jamsession-post-types'),
		'author'	=> __('Author', 'jamsession-post-types'),
		'date'		=> __('Date', 'jamsession-post-types')		
	);
	
	return $columns;
}


/*
	fill the custom columns on admin
*/

add_action( 'manage_js_events_posts_custom_column', 'JAMSESSION_SWP_manage_js_events_columns_func', 10, 2 );

function JAMSESSION_SWP_manage_js_events_columns_func($column, $event_id)
{
	global $post;
	
	switch( $column ) 
	{
		case 'event_date' :
			$event_date = esc_html( get_post_meta( $event_id, 'event_date', true ) );
			echo $event_date;
			break;
		case 'event_location':
			$event_location = esc_html( get_post_meta( $event_id, 'event_location', true ) );
			echo $event_location;
			break;
		case 'event_venue':
			$event_venue = esc_html( get_post_meta( $event_id, 'event_venue', true ) );
			echo $event_venue;
			break;			
		default:
			break;
	}
}

/*
	adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]
*/
add_filter('manage_edit-js_events_sortable_columns', 'JAMSESSION_SWP_jamsession_events_admin_sortable_columns_func');
function JAMSESSION_SWP_jamsession_events_admin_sortable_columns_func( $columns)
{

	$columns['title'] = 'title';
	$columns['event_date'] = 'event_date';
	$columns['event_location'] = 'event_location';
	$columns['event_venue'] = 'event_venue';
	$columns['author'] = 'author';

	return $columns;
}




/*
	Create Category for Events
*/
add_action( 'init', 'JAMSESSION_SWP_create_event_category', 11);

function JAMSESSION_SWP_create_event_category()
{
	$slug = JAMSESSION_SWP_JPT_get_plugin_option("event_tax");
	if ("" == $slug) {
		$slug = "event_category";
	}
	
	register_taxonomy(
			'event_category',
			'js_events',
			array(
				'labels' => array(
					'name' => __('Event Categories', 'jamsession-post-types'),
					'singular_name'     => __( 'Event Category', 'jamsession-post-types' ),
					'search_items'      => __( 'Search Event Categories', 'jamsession-post-types'  ),
					'all_items'         => __( 'All Event Categories', 'jamsession-post-types'  ),
					'parent_item'       => __( 'Parent Event Category', 'jamsession-post-types'  ),
					'parent_item_colon' => __( 'Parent Event Category:', 'jamsession-post-types'  ),
					'edit_item'         => __( 'Edit Event Category', 'jamsession-post-types'  ),
					'update_item'       => __( 'Update Event Category', 'jamsession-post-types'  ),
					'add_new_item' 		=> __('Add New Event Category', 'jamsession-post-types'),
					'new_item_name' 	=> __('New Event Category', 'jamsession-post-types'),
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
<?php

add_action( 'init', 'JAMSESSION_SWP_create_albums_post', 11);
function JAMSESSION_SWP_create_albums_post() 
{
	$slug = JAMSESSION_SWP_JPT_get_plugin_option("album");
	
	if ( "" == $slug)
	{
		$slug = "js_albums";
	}
	
	register_post_type( 'js_albums',
		array(
			'labels' => array(
				'name' =>  __('Albums', 'jamsession-post-types') ,
				'singular_name' =>  __('Album', 'jamsession-post-types') ,
				'add_new' => __('Add New Album', 'jamsession-post-types'),
				'add_new_item' => __('Add New Album', 'jamsession-post-types'),
				'edit' => __('Edit', 'jamsession-post-types'),
				'edit_item' => __('Edit Album', 'jamsession-post-types'),
				'new_item' => __('New Album', 'jamsession-post-types'),
				'view' => __('View', 'jamsession-post-types'),
				'view_item' => __('View Album', 'jamsession-post-types'),
				'search_items' => __('Search Albums', 'jamsession-post-types'),
				'not_found' => __('No Album Found','jamsession-post-types'),
				'not_found_in_trash' => __('No Album Found in Trash','jamsession-post-types'),
				'parent' => __('Parent Album','jamsession-post-types')
			),
			'public' => true,
			'rewrite' => array(
				'slug' => $slug,
				'with_front' => false
			),	
			/*'has_archive' => true,*/
			'supports' => array( 'title', 'editor', 'comments', 'thumbnail'),
			'menu_icon' => 'dashicons-format-audio',
		)
	); 
}


/*
	admin section - custom metabox
*/

add_action( 'admin_init', 'JAMSESSION_SWP_albums_admin_init' );
function JAMSESSION_SWP_albums_admin_init() 
{
	/* album information */
    add_meta_box( 'albums_meta_box', 			/*the required HTML id attribute*/
        __('Album Settings','jamsession-post-types'), 		/*text visible in the heading of meta box section*/
        'JAMSESSION_SWP_display_albums_meta_box',				/* callback FUNCTION which renders the contents of the meta box*/
        'js_albums', 							/*the name of the custom post type where the meta box will be displayed*/
		'normal', 								/*defines the part of the page where the edit screen section should be shown*/
		'high' 									/*defines the priority within the context where the boxes should show*/
    );
	
	/* album songs */	
    add_meta_box( 'albums_song_list_meta_box', 			/*the required HTML id attribute*/
        __('Song List','jamsession-post-types'), 		/*text visible in the heading of meta box section*/
        'JAMSESSION_SWP_display_albums_song_list_meta_box',				/* callback FUNCTION which renders the contents of the meta box*/
        'js_albums', 							/*the name of the custom post type where the meta box will be displayed*/
		'normal', 								/*defines the part of the page where the edit screen section should be shown*/
		'default' 									/*defines the priority within the context where the boxes should show*/
    );	
}


/*
	callback FUNCTION which renders the contents of the meta box
	$albumObject
*/
function JAMSESSION_SWP_display_albums_meta_box( $albumObject ) 
{
    // Retrieve current name of the custom fields album ID
	$album_artist = esc_html( get_post_meta( $albumObject->ID, 'album_artist', true ) );
    $album_release_date = esc_html( get_post_meta( $albumObject->ID, 'album_release_date', true ) );
    $album_no_disc = esc_html( get_post_meta( $albumObject->ID, 'album_no_disc', true ) ); 
	$album_label = esc_html( get_post_meta( $albumObject->ID, 'album_label', true ) ); 	
	$album_producer	= esc_html( get_post_meta( $albumObject->ID, 'album_producer', true ) );
	$album_catalogue_number = esc_html( get_post_meta( $albumObject->ID, 'album_catalogue_number', true ) );

	$album_youtube = esc_html( get_post_meta( $albumObject->ID, 'album_youtube', true ) ); 			
	$album_vimeo = esc_html( get_post_meta( $albumObject->ID, 'album_vimeo', true ) );
	
	$album_buy_message1 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_message1', true ) ); 			
	$album_buy_link1 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_link1', true ) ); 			
	
	$album_buy_message2 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_message2', true ) ); 			
	$album_buy_link2 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_link2', true ) ); 			

	$album_buy_message3 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_message3', true ) ); 			
	$album_buy_link3 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_link3', true ) ); 			

	$album_buy_message4 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_message4', true ) ); 			
	$album_buy_link4 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_link4', true ) );
	
	$album_buy_message5 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_message5', true ) ); 			
	$album_buy_link5 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_link5', true ) );

	$album_buy_message6 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_message6', true ) ); 			
	$album_buy_link6 = esc_html( get_post_meta( $albumObject->ID, 'album_buy_link6', true ) );
	
	$album_SC = esc_html( get_post_meta( $albumObject->ID, 'album_SC', true ) );
	
	
    ?>
    <table style= "width: 100%;">
       <tr >
            <td style= "width: 30%;"><?php echo __('Artist/Band','jamsession-post-types');?></td>
			<td ><input style="width: 100%;  display: block;" type="text" name="album_artist" value="<?php echo $album_artist; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Artist/Band Name','jamsession-post-types'); ?></div>
			</td>
        </tr>	
        <tr >
            <td style= "width: 30%;"><?php echo __('Release Date','jamsession-post-types');?></td>
            <td ><input id="datepicker" style="width: 100%;  display: block;" type="text" name="album_release_date" value="<?php echo $album_release_date; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Album Release Date YYYY/MM/DD','jamsession-post-types'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Number of Discs','jamsession-post-types');?></td>
			<td ><input style="width: 100%;  display: block;"  type="text"  name="album_no_disc" value="<?php echo $album_no_disc; ?>" /> 
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Number of Discs  1/2/3...','jamsession-post-types');  ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Label','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text"  name="album_label" value="<?php echo $album_label; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Record Label - like - Chess Records','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Producer','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text"  name="album_producer" value="<?php echo $album_producer; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Album Producer - like - Bob Rock','jamsession-post-types'); ?></div>
			</td>
        </tr>
        <tr >
            <td style= "width: 30%;"><?php echo __('Catalogue Number','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text"  name="album_catalogue_number" value="<?php echo $album_catalogue_number; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"><?php echo __('Catalogue Number - like - 650001','jamsession-post-types'); ?></div>
			</td>
        </tr>		
        <tr >
            <td style= "width: 30%;"><?php echo __('Youtube Promo URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_youtube" value="<?php echo $album_youtube; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Youtube URL - like - http://youtu.be/jUk-5nsGedM ','jamsession-post-types'); ?></div>
			</td>
        </tr>						
        <tr >
            <td style= "width: 30%;"><?php echo __('Vimeo Promo URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_vimeo" value="<?php echo $album_vimeo; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Vimeo URL - like - http://vimeo.com/8119784 ','jamsession-post-types'); ?></div>
			</td>
        </tr>
		
        <tr >
            <td style= "width: 30%;"><?php echo __('Buy Message','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_message1" value="<?php echo $album_buy_message1; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy Message - like - Buy It from Amazon','jamsession-post-types'); ?></div>
			</td>
        </tr>
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_link1" value="<?php echo $album_buy_link1; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy URL - like - http://www.amazon.com/Old-Sock-Eric-Clapton/dp/B00B23O96A/ref=ntt_mus_ep_dpi_1 ','jamsession-post-types'); ?></div>
			</td>
        </tr>

        <tr >
            <td style= "width: 30%;"><?php echo __('Buy Message','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_message2" value="<?php echo $album_buy_message2; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy Message - like - Buy It from iTunes','jamsession-post-types'); ?></div>
			</td>
        </tr>
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_link2" value="<?php echo $album_buy_link2; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy URL - like - https://itunes.apple.com/us/album/living-proof/id394442693 ','jamsession-post-types'); ?></div>
			</td>
        </tr>

		<tr >
            <td style= "width: 30%;"><?php echo __('Buy Message','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_message3" value="<?php echo $album_buy_message3; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy Message - like - Buy It from SoundCloud','jamsession-post-types'); ?></div>
			</td>
        </tr>
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_link3" value="<?php echo $album_buy_link3; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy URL - like - http://www.last.fm/music/Radiohead/1995-06-01:+Tramps,+New+York,+NY,+USA ','jamsession-post-types'); ?></div>
			</td>
        </tr>	
		
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy Message','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_message4" value="<?php echo $album_buy_message4; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy Message - like - Buy It from eBay','jamsession-post-types'); ?></div>
			</td>
        </tr>
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_link4" value="<?php echo $album_buy_link4; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy URL - like - http://www.ebay.com/soc/itm/330938741705 ','jamsession-post-types'); ?></div>
			</td>
        </tr>

		<tr >
            <td style= "width: 30%;"><?php echo __('Buy Message','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_message5" value="<?php echo $album_buy_message5; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy Message - like - Buy It from Google Play','jamsession-post-types'); ?></div>
			</td>
        </tr>
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_link5" value="<?php echo $album_buy_link5; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy URL - like - http://www.ebay.com/soc/itm/330938741705 ','jamsession-post-types'); ?></div>
			</td>
        </tr>

		<tr >
            <td style= "width: 30%;"><?php echo __('Buy Message','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_message6" value="<?php echo $album_buy_message6; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy Message - like - Buy It from Google Play','jamsession-post-types'); ?></div>
			</td>
        </tr>
		<tr >
            <td style= "width: 30%;"><?php echo __('Buy URL','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_buy_link6" value="<?php echo $album_buy_link6; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('Buy URL - like - http://www.ebay.com/soc/itm/330938741705 ','jamsession-post-types'); ?></div>
			</td>
        </tr>		
		
		<tr >
            <td style= "width: 30%;"><?php echo __('SoundCloud','jamsession-post-types');?></td>
			<td ><input style="width: 100%; display: block;"  type="text" name="album_SC" value="<?php echo $album_SC; ?>" />
				<div style="color: #999999; font-size: 0.9em; margin-left: 5px;"> <?php echo __('SoundCloud Embed URL - If this field is filled, it will be shown instead of the uploaded media','jamsession-post-types'); ?></div>
			</td>
        </tr>		
    </table>
    <?php
}

function JAMSESSION_SWP_display_albums_song_list_meta_box( $albumObject)
{
	echo JAMSESSION_SWP_display_song_list( $albumObject->ID);

	/* display upload media form */
	global $post;
			
	wp_enqueue_script('plupload-handlers');
			
	$form_class='media-upload-form type-form validate';
	$post_id = $post->ID;
	$_REQUEST['post_id'] = $post_id;

	media_upload_form(); 
	
	$media_params = array( 
						'post_id' => $post_id,
						'short_form' => '3');	
	?>
	<div id="media-items" class="hide-if-no-js"></div>
	 <?php
	wp_localize_script( 
						'media_upload_assets', 
						'JAMSESSION_SWP_scriptParams',
						$media_params ); 	 

}

function JAMSESSION_SWP_display_song_list( $albumID)
{
	$args = array(
		'post_type'         => 'attachment',
		'post_status'       => 'inherit',
		'post_parent'       => $albumID,
		'post_mime_type'    => 'audio',
		'posts_per_page'    => -1,
		'order'             => 'ASC',
		'orderby'           => 'menu_order'		
		);

	$loop = get_posts( $args );
		

	if( empty( $loop ) )
	{
		return "";
	}

	$gallery = '<div id="audio_list"><ul id="ul_sortable_list">';
	foreach( $loop as $audio ):
	
		/*put it in html*/
		$gallery .= '<li id="'.$audio->ID.'">';
		$gallery .= '<div class="song_name">'.$audio->post_title.'</div>';
		$gallery .= '<div class="song_controls"><span class="remove_audio" rel="' . $audio->ID .'">Remove</span></div>';		
		$gallery .= '</li>';
		
	endforeach;

	$gallery .= '</ul></div>';

	return $gallery;	
}
/*
	AJAX functions
*/
add_action( 'wp_ajax_JAMSESSION_SWP_update_my_audio_list', 'JAMSESSION_SWP_update_my_audio_list');
add_action( 'wp_ajax_JAMSESSION_SWP_update_track_order', 'JAMSESSION_SWP_update_track_order'); 
add_action( 'wp_ajax_JAMSESSION_SWP_remove_from_album', 'JAMSESSION_SWP_remove_from_album');

/*
	update audio listing in html code - called from js
*/

function JAMSESSION_SWP_update_my_audio_list()
{
	$parent	= $_POST['parent'];
	
	$mp3List = JAMSESSION_SWP_display_song_list($parent);
	
	$ret['success'] = true;
	$ret['audio_list'] = $mp3List;
	
	echo json_encode( $ret );
	die();
	
}

/*
	update track order after drop
*/
function JAMSESSION_SWP_update_track_order()
{
	$trackList = $_POST['trackList'];

	
	$trackList = explode(",", $trackList);
	$order = 0;
	foreach ( $trackList as $trackID)
	{
		$ret[] = $trackID;
		
		$a = array(
                'ID' => $trackID,
                'menu_order' => $order
            );
			
            wp_update_post( $a );
			$order++;
	}
	
	echo json_encode( $ret );
	die();
}

/* register save post function */
add_action( 'save_post', 'JAMSESSION_SWP_save_album_fields', 10, 2 );

/*
	save post function - triggered on save 
	$album_id
	$albumObject
*/
function JAMSESSION_SWP_save_album_fields( $album_id, $album ) 
{

    // Check post type jamsession_slides type
    if ( $album->post_type == 'js_albums' ) 
	{
        // Store data in post meta table if present in post data
        if ( isset( $_POST['album_artist'] )) 
		{
            update_post_meta( $album_id, 'album_artist', $_POST['album_artist'] );
        }

        if ( isset( $_POST['album_release_date'] ) ) 
		{
            update_post_meta( $album_id, 'album_release_date', $_POST['album_release_date'] );
        }
        if ( isset( $_POST['album_no_disc'] )) 
		{
            update_post_meta( $album_id, 'album_no_disc', $_POST['album_no_disc'] );
        }
        if ( isset( $_POST['album_label'] ) ) 
		{
            update_post_meta( $album_id, 'album_label', $_POST['album_label'] );
        }
		if ( isset( $_POST['album_producer'] )) 
		{
            update_post_meta( $album_id, 'album_producer', $_POST['album_producer'] );
        }
		if ( isset( $_POST['album_catalogue_number'] )) 
		{
            update_post_meta( $album_id, 'album_catalogue_number', $_POST['album_catalogue_number'] );
        }		
		
		

        if ( isset( $_POST['album_youtube'] ) ) 
		{
            update_post_meta( $album_id, 'album_youtube', $_POST['album_youtube'] );
        }				
        if ( isset( $_POST['album_vimeo'] )  ) 
		{
            update_post_meta( $album_id, 'album_vimeo', $_POST['album_vimeo'] );
        }
		
        if ( isset( $_POST['album_buy_message1'] )  ) 
		{
            update_post_meta( $album_id, 'album_buy_message1', $_POST['album_buy_message1'] );
        }				
        if ( isset( $_POST['album_buy_link1'] )  ) 
		{
            update_post_meta( $album_id, 'album_buy_link1', $_POST['album_buy_link1'] );
        }
        if ( isset( $_POST['album_buy_message2'] ) ) 
		{
            update_post_meta( $album_id, 'album_buy_message2', $_POST['album_buy_message2'] );
        }				
        if ( isset( $_POST['album_buy_link2'] ) ) 
		{
            update_post_meta( $album_id, 'album_buy_link2', $_POST['album_buy_link2'] );
        }
        if ( isset( $_POST['album_buy_message3'] ) ) 
		{
            update_post_meta( $album_id, 'album_buy_message3', $_POST['album_buy_message3'] );
        }				
        if ( isset( $_POST['album_buy_link3'] )  ) 
		{
            update_post_meta( $album_id, 'album_buy_link3', $_POST['album_buy_link3'] );
        }
        if ( isset( $_POST['album_buy_message4'] ) ) 
		{
            update_post_meta( $album_id, 'album_buy_message4', $_POST['album_buy_message4'] );
        }				
        if ( isset( $_POST['album_buy_link4'] )  ) 
		{
            update_post_meta( $album_id, 'album_buy_link4', $_POST['album_buy_link4'] );
        }
        if ( isset( $_POST['album_buy_message5'] ) ) 
		{
            update_post_meta( $album_id, 'album_buy_message5', $_POST['album_buy_message5'] );
        }				
        if ( isset( $_POST['album_buy_link5'] )  ) 
		{
            update_post_meta( $album_id, 'album_buy_link5', $_POST['album_buy_link5'] );
        }
        if ( isset( $_POST['album_buy_message6'] ) ) 
		{
            update_post_meta( $album_id, 'album_buy_message6', $_POST['album_buy_message6'] );
        }				
        if ( isset( $_POST['album_buy_link6'] )  ) 
		{
            update_post_meta( $album_id, 'album_buy_link6', $_POST['album_buy_link6'] );
        }		
        if ( isset( $_POST['album_SC'] )  ) 
		{
            update_post_meta( $album_id, 'album_SC', $_POST['album_SC'] );
        }		
		
    }
}


/*
	adding custom columns to admin menu using filter  [manage_edit-{post_type}_columns]
*/
add_filter('manage_edit-js_albums_columns', 'JAMSESSION_SWP_albums_admin_columns_func');

function JAMSESSION_SWP_albums_admin_columns_func( $columns)
{
	$columns = array(
		'cb'	=> '<input type="checkbox" />',
		'title' => __('Album Title', 'jamsession-post-types'),
		'album_artist' => __('Album Artist', 'jamsession-post-types'),
		'album_label'	=>	__('Label', 'jamsession-post-types'),
		'album_producer'	=>	__('Producer', 'jamsession-post-types'),		
		'author'	=> __('Author', 'jamsession-post-types'),
		'date'		=> __('Date', 'jamsession-post-types')		
		
	);
	
	return $columns;
}

/*
	fill the custom columns on admin
*/

add_action( 'manage_js_albums_posts_custom_column', 'JAMSESSION_SWP_manage_js_albums_columns_func', 10, 2 );

function JAMSESSION_SWP_manage_js_albums_columns_func($column, $album_id)
{
	global $post;
	
	switch( $column ) 
	{
		case 'album_artist' :
			$album_artist = esc_html( get_post_meta( $album_id, 'album_artist', true ) );
			echo $album_artist;
			break;
		case 'album_label':
			$album_label = esc_html( get_post_meta( $album_id, 'album_label', true ) );
			echo $album_label;
			break;
		case 'album_producer':
			$album_producer = esc_html( get_post_meta( $album_id, 'album_producer', true ) );
			echo $album_producer;
			break;			
		default:
			break;
	}
}



/* 
	making custom comumns sortable
*/

add_filter( 'manage_edit-js_albums_sortable_columns', 'JAMSESSION_SWP_albums_sortable_columns' );

function JAMSESSION_SWP_albums_sortable_columns( $columns ) {

	$columns['album_artist'] = 'album_artist';
	$columns['album_label'] = 'album_label';
	$columns['author'] = 'author';
	$columns['album_producer'] = 'album_producer';	

	return $columns;
}



/*
	Create Category for Albums
*/
add_action( 'init', 'JAMSESSION_SWP_create_album_category', 11);

function JAMSESSION_SWP_create_album_category()
{
	$slug = JAMSESSION_SWP_JPT_get_plugin_option("album_tax");
	if ( "" == $slug) {
		$slug = "album_category";
	}
	
	register_taxonomy(
			'album_category',
			'js_albums',
			array(
				'labels' => array(
					'name' => __('Album Categories', 'jamsession-post-types'),
					'singular_name'     => __( 'Album Category', 'jamsession-post-types' ),
					'search_items'      => __( 'Search Album Categories', 'jamsession-post-types'  ),
					'all_items'         => __( 'All Album Categories', 'jamsession-post-types'  ),
					'parent_item'       => __( 'Parent Album Category', 'jamsession-post-types'  ),
					'parent_item_colon' => __( 'Parent Album Category:' , 'jamsession-post-types' ),
					'edit_item'         => __( 'Edit Album Category', 'jamsession-post-types'  ),
					'update_item'       => __( 'Update Album Category', 'jamsession-post-types'  ),
					'add_new_item' 		=> __('Add New Album Category', 'jamsession-post-types'),
					'new_item_name' 	=> __('New Album Category', 'jamsession-post-types'),
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


/*
	remove picture item from gallery - called from js
*/

function JAMSESSION_SWP_remove_from_album() 
{
		/*	 get content from AJAX post */
		$audio = $_POST['audio'];
		$parent	= $_POST['parent'];

		/* no audio ID .. this is strange */
		if( empty( $audio ) ) 
		{
			$ret['success'] = false;
			echo json_encode( $ret );
			die();
		}

		/* setup removal function*/
		$remove                 = array();
		$remove['ID']           = $audio;
		$remove['post_parent']	= 0;

		$update = wp_update_post( $remove );

		// AJAX return array
		$ret = array();

		if( $update !== 0 )
		{
			/* refresh the album */
			$tracks = JAMSESSION_SWP_display_song_list( $parent);
			
			/* return values */
			$ret['success'] = true;
			$ret['tracklist'] = $tracks;

		} 
		else 
		{
			/* return fails */
			$ret['success'] = false;
		}

		echo json_encode( $ret );
		die();
}



?>
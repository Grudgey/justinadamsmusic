<?php

if ( ! function_exists( 'JAMSESSION_SWP_setup' ) ) :
/* 
	JamSession Setup 
*/
function JAMSESSION_SWP_setup() {
	//theme textdomain for translation/localization support - load_theme_textdomain( $domain, $path )
	$domain = 'jamsession';
	// wp-content/languages/jamsession/de_DE.mo
	if (!load_theme_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain )) {
		// wp-content/themes/jamsession/languages
		load_theme_textdomain('jamsession', get_template_directory() . '/languages');
	}

	// Add Editor Style
	add_editor_style( 'custom-editor-style.css' );
	
	// enables post and comment RSS feed links to head
	add_theme_support( 'automatic-feed-links' );		
 
	// enable support for Post Thumbnails, 
	add_theme_support('post-thumbnails');
	
	// register Menu
	register_nav_menus(
		array(
		  'main-menu' => __( 'Main Menu', 'jamsession'  ),
		)
	);
	
	// custom background support
	global $wp_version;
	if ( version_compare( $wp_version, '3.4', '>=' ) ) 
	{
		$defaults = array(
			'default-color'          => '1c2023',
			'default-image'          => '',
			'wp-head-callback'       => 'JAMSESSION_SWP_custom_background_cb',
			'admin-head-callback'    => '',
			'admin-preview-callback' => ''
		);
		
		add_theme_support( 'custom-background',  $defaults); 
	}	

}
endif; /* end of JAMSESSION_SWP_setup */
add_action( 'after_setup_theme', 'JAMSESSION_SWP_setup' );

/*
	Theme Settings Menu
*/
require_once(get_template_directory()."/theme_settings.php");
require_once(get_template_directory()."/import/JS_SWP_Import_Main.php");


/*
	Load Theme Fonts
*/
if (!function_exists( 'JAMSESSION_SWP_load_fonts_css')) {
	function JAMSESSION_SWP_load_fonts_css() {
		wp_enqueue_style('default_fonts', get_template_directory_uri() . "/css/default_fonts.css");	

		if (!JAMSESSION_SWP_use_default_fonts()) {
			$primary_font = JAMSESSION_SWP_get_user_primary_font();
			$secondary_font = JAMSESSION_SWP_get_user_secondary_font();

			$user_fonts_css = '
				body, #main_menu ul ul li a, .menu ul ul li a,
				.woocommerce table.shop_table th, .woocommerce-page table.shop_table th,
				.woocommerce .order_details li, .woocommerce-page .order_details li, #sidebar ul li,
				nav.mobile_navigation ul.sub-menu li a  {
					font-family: ' . $primary_font . ', sans-serif;
				}

				h1, h2, h3, h4, h5, h6, blockquote, th, ul, ul li, ol, ol li, 
				#TB_ajaxWindowTitle, .slideTitle, .slideMessage, 
				#main_menu ul li a, .menu ul li a, #logo,
				#wp-calendar caption, #post_title, #page_title, #archive_title, #album_title, #title_all, 
				#comments-title, #commentform label, #contactform label, .woocommerce form .form-row label, .woocommerce-page form .form-row label, 
				#commentform input[type="submit"], #contactform input[type="submit"], #sidebar input[type="submit"], #inline_search input[type="submit"], .js_swp_theme_button, 
				.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
				.woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, 
				.woocommerce-page input.button, #respond h3, .reply, .post_tag a, .post_cat a, #sidebar .tagcloud a, .current_tax, 
				.post_item_title, .event_brick_date, .event_brick_venue, .event_meta_date, 
				.custom_actions a, .fb_actions a, 
				.album_meta_title, .share_text, .pagination_links, .page_navigation, .copy, #front_page_news_bar, #front_page_news_bar a, #news_badge, 
				.woocommerce span.onsale, .woocommerce-page span.onsale,
				.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce a.added_to_cart, .woocommerce-page a.added_to_cart, 
				#maintenance_logo a, #maintenance_title, .album_widget_right h3, .js_swp_event_buy, .event_date_list, .event_buy_list, .js_swp_lt_name, .wg_event_date, #logo_mobile {
					font-family: ' . $secondary_font . ', sans-serif;
				}
			';

			wp_add_inline_style( 'default_fonts', $user_fonts_css );		
		}
	}
}
add_action('wp_enqueue_scripts', 'JAMSESSION_SWP_load_fonts_css');


/*
	Load the main stylesheet - style.css
*/
if ( ! function_exists( 'JAMSESSION_SWP_load_main_stylesheet' ) ) :
function JAMSESSION_SWP_load_main_stylesheet()
{
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}
endif;
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_load_main_stylesheet' );


/*
	Add VC related files
*/
require_once(get_template_directory()."/vc_jamsession/add_params.php");

/*
	Slider Functionality
*/
require_once(get_template_directory()."/slider.php");

add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_js_add_slider_scripts' );	
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_js_slider_initialize_script' );
add_action('wp_enqueue_scripts', 'JAMSESSION_SWP_js_slider_initialize', 100);
add_action('wp_enqueue_scripts', 'JAMSESSION_SWP_js_slider_initialize_single', 100);


/*
	Theme Customizer
*/
require_once(get_template_directory()."/theme_customizer.php");

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'JAMSESSION_SWP_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'JAMSESSION_SWP_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'JAMSESSION_SWP_Customize' , 'live_preview' ) );



/*
	Load Needed Google Fonts
*/
if ( !function_exists('JAMSESSION_SWP_load_google_fonts') ) {
	function JAMSESSION_SWP_load_google_fonts() {
		$google_fonts_family = JAMSESSION_SWP_get_fonts_family_from_settings();

		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'jamsession-opensans-oswald', $protocol."://fonts.googleapis.com/css?family=".$google_fonts_family);
	}
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_load_google_fonts' );

if ( !function_exists('JAMSESSION_SWP_sticky_menu') ) {
function JAMSESSION_SWP_sticky_menu()
{
	if ( !JAMSESSION_SWP_disable_sticky_menu_setting()) {
		wp_register_script( 'sticky_menu',  get_template_directory_uri().'/js/sticky_menu.js', array('jquery'), '', true );
		wp_enqueue_script( 'sticky_menu');
	}
	
	if (JAMSESSION_SWP_is_back_to_top_active()) {
		wp_register_script( 'back_to_top_js',  get_template_directory_uri().'/js/back_to_top.js', array('jquery'), '', true );
		wp_enqueue_script( 'back_to_top_js');
	}
}
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_sticky_menu' );

function JAMSESSION_SWP_VC_related_scripts()
{
	wp_register_script( 'justified_gallery',  get_template_directory_uri().'/js/jquery.justifiedGallery.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'justified_gallery');	
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_VC_related_scripts' );

function JAMSESSION_SWP_VC_related_styles()
{
	wp_register_style('justified_gallery_css', get_template_directory_uri(). '/css/justifiedGallery.min.css');
	wp_enqueue_style('justified_gallery_css');	
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_VC_related_styles' );


/*
	Add Sidebar Right
*/
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Main Sidebar',
		'id' => 'main-sidebar',
		'description' => 'Right Sidebar',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));

	register_sidebar(
		array(
			'name' => esc_html__('Footer Sidebar 1', 'jamsession'),
			'id' => 'footer-sidebar-1',
			'description' => esc_html__('Appears in the footer area', 'jamsession'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Footer Sidebar 2', 'jamsession'),
			'id' => 'footer-sidebar-2',
			'description' => esc_html__('Appears in the footer area', 'jamsession'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
	));

	register_sidebar(
		array(
			'name' => esc_html__('Footer Sidebar 3', 'jamsession'),
			'id' => 'footer-sidebar-3',
			'description' => esc_html__('Appears in the footer area', 'jamsession'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name' => esc_html__('Footer Sidebar 4', 'jamsession'),
			'id' => 'footer-sidebar-4',
			'description' => esc_html__('Appears in the footer area', 'jamsession'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="footer-widget-title">',
			'after_title' => '</h3>',
		)
	);	
}

/*
	Comments Callback Function
*/
if ( ! function_exists( 'JAMSESSION_SWP_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own JAMSESSION_SWP_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
    function JAMSESSION_SWP_comment( $comment, $args, $depth )
    {
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :
            case '' :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <div id="comment-<?php comment_ID(); ?>">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, 40 ); ?>
                    <?php printf( __( '%s <span class="says">says:</span>', 'jamsession' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
                </div><!-- .comment-author .vcard -->
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em class="comment-awaiting-moderation"><?php echo __( 'Your comment is awaiting moderation.', 'jamsession' ); ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                    <?php
                        /* translators: 1: date, 2: time */
                        printf( __( '%1$s at %2$s', 'jamsession' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'jamsession' ), ' ' );
                    ?>
                </div><!-- .comment-meta .commentmetadata -->

                <div class="comment-body"><?php comment_text(); ?></div>

                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
            </div><!-- #comment-##  -->

        <?php
                break;
            case 'pingback'  :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><?php __( 'Pingback:', 'jamsession' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'jamsession' ), ' ' ); ?></p>
        <?php
                break;
        endswitch;
    }
endif;


function JAMSESSION_SWP_comment_fields( $arg)
{
	$arg['comment_notes_before'] = "";
	$arg['comment_notes_after'] = "";
	
	
	return $arg;
}
add_filter('comment_form_defaults', 'JAMSESSION_SWP_comment_fields');

if ( ! function_exists( 'JAMSESSION_SWP_masonry' ) ) :

function JAMSESSION_SWP_masonry()
{
	wp_register_script( 'images-loaded', get_template_directory_uri(). '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script( 'images-loaded');

	wp_register_script( 'debounce-resize', get_template_directory_uri(). '/js/jquery.debouncedresize.js', array( 'jquery' ), '', true);
	wp_enqueue_script( 'debounce-resize');
	
	/* start isotope script*/
	if (!JAMSESSION_SWP_is_events_discography()) {
		/* load isotope script*/
		wp_register_script( 'isotope-script', get_template_directory_uri(). '/js/isotope.pkgd.min.js', array( 'jquery'), '', true);
		wp_enqueue_script( 'isotope-script');
	
		wp_register_script( 'start_isotope', get_template_directory_uri(). '/js/start_isotope.js', array( 'jquery', 'isotope-script'), '', true);
		wp_enqueue_script( 'start_isotope');
	} else {
		wp_register_script( 'salvattore', get_template_directory_uri(). '/js/salvattore.min.js', array( 'jquery' ), '', true);
		wp_enqueue_script( 'salvattore');
		
		wp_register_script( 'prepare-salv-columns', get_template_directory_uri(). '/js/prepare.salv.columns.js', array( 'jquery', 'salvattore'), '', true);
		wp_enqueue_script( 'prepare-salv-columns');		
	}

	wp_register_script( 'jquery-easing',  get_template_directory_uri().'/supersized/js/jquery.easing.min.js', array('jquery'), '', true);
	wp_enqueue_script( 'jquery-easing');
}
endif;

add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_masonry' );


function JAMSESSION_SWP_is_events_discography() {
	return (is_page_template('page_events.php') || 
		is_page_template('page_past_events.php') || 
		is_page_template('page_all_events.php') || 
		is_page_template('page_discography.php') || 
		is_tax('album_category') || 
		is_tax('event_category'));
}

/*
	Collapsible Responsive Menu 	
*/
function JAMSESSION_SWP_responsive_menu()
{
	wp_register_script( 'responsive_menu', get_template_directory_uri(). '/js/responsive_menu.js', array('jquery'), '', true);
	wp_enqueue_script( 'responsive_menu');	
}

add_action('wp_enqueue_scripts', 'JAMSESSION_SWP_responsive_menu');

/*
	Load Parallax Script
*/
if ( ! function_exists( 'JAMSESSION_SWP_vc_swp' ) ) {
function JAMSESSION_SWP_vc_swp()
{
	wp_register_script( 'vc_swp', get_template_directory_uri(). '/js/vc_swp.js', array( 'jquery', 'justified_gallery', 'wp-mediaelement'), '', true);
	wp_enqueue_script( 'vc_swp');	

	wp_register_script( 'js_swp_ajaxcf', get_template_directory_uri(). '/js/js_swp_ajaxcf.js', array( 'jquery'), '', true);
	wp_enqueue_script( 'js_swp_ajaxcf');
	
	$ajaxurl_val = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	);
    wp_localize_script('js_swp_ajaxcf', 'DATAVALUES', $ajaxurl_val);	
	
	wp_enqueue_style('wp-mediaelement'); 
}
}
add_action('wp_enqueue_scripts', 'JAMSESSION_SWP_vc_swp');

/*
	Control Excerpt Length
*/
if ( ! function_exists( 'JAMSESSION_SWP_excerpt_length' ) ) {
	function JAMSESSION_SWP_excerpt_length( $length )
	{
		return 20;
	}
}
add_filter( 'excerpt_length', 'JAMSESSION_SWP_excerpt_length', 999);


/*
	Remove [...] string
*/
if ( ! function_exists( 'JAMSESSION_SWP_excerpt_more' ) ) {
	function JAMSESSION_SWP_excerpt_more( $more ) {
		return '';
	}
}
add_filter('excerpt_more', 'JAMSESSION_SWP_excerpt_more');


/*
	Load Lightbox Script
*/
function JAMSESSION_SWP_load_lightbox()
{
	wp_register_script( 'lightbox', get_template_directory_uri(). '/js/lightbox-2.6.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'lightbox');
	
	wp_register_style('lightbox_style', get_template_directory_uri(). '/css/lightbox.css');
	wp_enqueue_style('lightbox_style');
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_load_lightbox' );

function jamsession_swp_load_font_awesome() {
	wp_enqueue_style('font-awesome-5.0.8', get_template_directory_uri(). '/assets/font-awesome-5.0.8/css/font-awesome.min.css', array(), '5.0.8', 'all');

}
add_action('wp_enqueue_scripts', 'jamsession_swp_load_font_awesome');


/*
	Fix WordPress Audio Player Volume Control
*/
function JAMSESSION_SWP_load_ap_fix()
{
	if ( !(is_single() && ('js_albums' == get_post_type())) )
	{
		return;
	}
	wp_register_script( 'audio_player', get_template_directory_uri(). '/js/audio_player.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'audio_player');
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_load_ap_fix' );


/*
	Retreive the ID from URL
*/
function JAMSESSION_SWP_getIDToEmbed($shortURL)
{
	//http://youtu.be/cxKxOglHg_4
	//http://vimeo.com/14390344
	
	@$elements = explode("/", $shortURL);
	@$dim = count( $elements); 
	if ( $dim == 0)
	{
		return "";
	}
	else
	{
		return $elements[ $dim - 1];
	}
}


/*
	Add Social Sharing Icons
*/
if ( !function_exists('JAMSESSION_SWP_add_social_sharing_icons')) :
function JAMSESSION_SWP_add_social_sharing_icons($p_link, $p_title, $image_string) {
	if (JAMSESSION_SWP_hide_sharing_icons()) {
		return;
	}
	
	$my_url = urlencode($p_link);

?>
	<div class="clearfix"></div>
	<div class="social_share">
		<a href="http://www.facebook.com/sharer.php?u=<?php  echo $my_url."&amp;t=".urlencode($p_title); ?>" target="_blank">
			<i class="icon-facebook"></i> <span class="share_text"><?php echo __('SHARE', 'jamsession'); ?></span>
		</a>
		<a href="https://twitter.com/share?url=<?php echo $my_url; ?>" target="_blank">
			<i class="icon-twitter"></i>  <span class="share_text"><?php echo __('TWEET','jamsession'); ?></span>
		</a>

		<?php
		if ( $image_string != "") {
		?>
		<a href="http://pinterest.com/pin/create/button/?url=<?php echo $my_url.'&amp;media='.$image_string; ?>" target="_blank">
			<i class="icon-pinterest"></i>  <span class="share_text"><?php echo __('PIN','jamsession'); ?></span>
		</a>
		<?php
		}
		?>
		
	</div>
<?php	
}
endif;



/*
	Make Sure Content Width is Set
*/
if ( ! isset( $content_width ) ) 
{
	$content_width = 900;
}


 
function JAMSESSION_SWP_custom_background_cb()
{
        $background = get_background_image();  
        $color = get_background_color();  
      
        if ( ! $background && ! $color )  
            return;  
      
        $style = $color ? "background-color: #$color;" : '';  
      
        if ( $background ) {  
            $image = " background-image: url('$background');";  
      
            $repeat = get_theme_mod( 'background_repeat', 'repeat' );  
      
            if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )  
                $repeat = 'repeat';  
      
            $repeat = " background-repeat: $repeat;";  
      
            $position = get_theme_mod( 'background_position_x', 'left' );  
      
            if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )  
                $position = 'left';  
      
            $position = " background-position: top $position;";  
      
            $attachment = get_theme_mod( 'background_attachment', 'scroll' );  
      
            if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )  
                $attachment = 'scroll';  
      
            $attachment = " background-attachment: $attachment;";  
      
            $style .= $image . $repeat . $position . $attachment;  
        }  
		?>  
		<style type="text/css">  
		body { <?php echo trim( $style ); ?> }  
		</style>  
		<?php  	
}

/*
	Add "events" query var as get param for events taxonomy
*/
if ( ! function_exists( 'JAMSESSION_SWP_add_events_query_var' ) ) :
function JAMSESSION_SWP_add_events_query_var( $vars ){
  $vars[] = "events";
  return $vars;
}
endif;
add_filter( 'query_vars', 'JAMSESSION_SWP_add_events_query_var' );


if ( ! function_exists( 'JAMSESSION_SWP_list_custom_terms_with_links' ) ) :
function JAMSESSION_SWP_list_custom_terms_with_links( $custom_taxonomy, $current_tax = NULL, $events = "next")
{
	$args = array(
		'taxonomy' =>  $custom_taxonomy
	);

	if ("event_category" == $custom_taxonomy) {	
		$args = array(
			'taxonomy' =>  $custom_taxonomy
		);		
	}

	$terms = get_terms($custom_taxonomy, $args);

	$count = count($terms); 
	$i=0;
	$term_list = "";

	if (($count > 0) && ( !is_wp_error( $terms)))
	{
		foreach ($terms as $term) 
		{
			$i++;
			if ( isset( $current_tax) && ($current_tax != "") && (!strcmp( $current_tax, $term->name)))
			{
				$term_list .= '<span class="current_tax">'.$term->name.'</span>';
			}
			else
			{
				if ("event_category" == $custom_taxonomy) {
					$new_url = add_query_arg('events', $events, get_term_link($term));
				} else {
					$new_url = get_term_link($term);
				}
				
				$term_list .= '<a href="' . esc_url_raw($new_url) . '" title="' . sprintf(__('View all post filed under %s', 'jamsession'), $term->name) . '">' . $term->name . '</a>';
			}
			
			if ($count != $i) 
			{
				$term_list .= ' ';
			}
		}
		echo $term_list;
	}
}
endif;

/*
	Display html code for social profiles
*/
if (!function_exists("JAMSESSION_SWP_list_social_links")) :
function JAMSESSION_SWP_list_social_links( $showHeader)
{
	/* if at least one social profile link is defined, display social links*/
	$social_options = get_option( 'jamsession_theme_social_options' );
	if( !empty($social_options['twitter']) || !empty($social_options['facebook']) || !empty($social_options['google_plus']) 
		|| !empty($social_options['youtube']) || !empty($social_options['vimeo']) 
		|| !empty($social_options['soundcloud']) || !empty($social_options['myspace']) || !empty($social_options['flickr'])
		|| !empty($social_options['pinterest']) || !empty($social_options['instagram']) || !empty($social_options['rnation'])
		|| !empty($social_options['bandcamp']) || !empty($social_options['linkedin']) || !empty($social_options['mixcloud']))
	{

		
		echo '<ul>';
		//facebook
		if  ( !empty($social_options['facebook']))
		{
			echo '<li><a target="_blank" href="'.$social_options['facebook'].'" title="Facebook"><i class="icon-facebook"></i></a></li>';
		}
		
		if  ( !empty($social_options['twitter']))
		{
			echo '<li><a target="_blank" href="'.$social_options['twitter'].'" title="Twitter"><i class="icon-twitter"></i></a></li>';
		}								

		if  ( !empty($social_options['google_plus']))
		{
			echo '<li><a target="_blank" href="'.$social_options['google_plus'].'" title="Google Plus"><i class="icon-gplus"></i></a></li>';
		}

		if  ( !empty($social_options['youtube']))
		{
			echo '<li><a target="_blank" href="'.$social_options['youtube'].'" title="YouTube"><i class="icon-youtube"></i></a></li>';
		}

		if  ( !empty($social_options['vimeo']))
		{
			echo '<li><a target="_blank" href="'.$social_options['vimeo'].'" title="Vimeo"><i class="icon-vimeo"></i></a></li>';
		}

		if  ( !empty($social_options['soundcloud']))
		{
			echo '<li><a target="_blank" href="'.$social_options['soundcloud'].'" title="SoundCloud"><i class="icon-soundcloud"></i></a></li>';
		}

		if  ( !empty($social_options['myspace']))
		{
			echo '<li><a target="_blank" href="'.$social_options['myspace'].'" title="Myspace"><i class="icon-myspace"></i></a></li>';
		}	

		if  ( !empty($social_options['flickr']))
		{
			echo '<li><a target="_blank" href="'.$social_options['flickr'].'" title="Flickr"><i class="icon-flickr"></i></a></li>';
		}	

		if  ( !empty($social_options['pinterest']))
		{
			echo '<li><a target="_blank" href="'.$social_options['pinterest'].'" title="Pinterest"><i class="icon-pinterest"></i></a></li>';
		}	

		if  ( !empty($social_options['instagram']))
		{
			echo '<li><a target="_blank" href="'.$social_options['instagram'].'" title="Instagram"><i class="icon-instagramm"></i></a></li>';
		}

		if  ( !empty($social_options['rnation']))
		{
			echo '<li><a target="_blank" href="'.$social_options['rnation'].'" title="ReverbNation"><i class="icon-star"></i></a></li>';
		}

		if  ( !empty($social_options['bandcamp']))
		{
			echo '<li><a target="_blank" href="'.$social_options['bandcamp'].'" title="BandCamp"><i class="icon-bandcamp"></i></a></li>';
		}
		
		if  ( !empty($social_options['linkedin']))
		{
			echo '<li><a target="_blank" href="'.$social_options['linkedin'].'" title="LinkedIn"><i class="icon-linkedin-squared"></i></a></li>';
		}
		
		if  ( !empty($social_options['mixcloud']))
		{
			echo '<li><a target="_blank" href="'.$social_options['mixcloud'].'" title="mixcloud"><i class="icon-mixcloud"></i></a></li>';
		}		
		echo '</ul>';
	}

}
endif;

/*
	Display html code for social profiles
*/
if ( ! function_exists( 'JAMSESSION_SWP_front_page_social_profiles' ) ) :
function JAMSESSION_SWP_front_page_social_profiles()
{
	/* if at least one social profile link is defined, display social links*/
	$social_options = get_option( 'jamsession_theme_social_options' );
	if( !empty($social_options['twitter']) || !empty($social_options['facebook']) || !empty($social_options['google_plus']) 
		|| !empty($social_options['youtube']) || !empty($social_options['vimeo']) 
		|| !empty($social_options['soundcloud']) || !empty($social_options['myspace']) || !empty($social_options['flickr'])
		|| !empty($social_options['pinterest']) || !empty($social_options['instagram'])
		|| !empty($social_options['itunes']) || !empty($social_options['spotify']) || !empty($social_options['tumblr'])
		|| !empty($social_options['rnation']) || !empty($social_options['custom']) ||  !empty($social_options['bandcamp']) || !empty($social_options['linkedin']) 
		|| !empty($social_options['mixcloud']))
	{
		
		echo '<ul class="float_container">';
		if  ( !empty($social_options['facebook']))
		{
			echo '<li><a target="_blank" href="'.$social_options['facebook'].'" title="Facebook"><i class="icon-facebook"></i></a></li>';
		}
		
		if  ( !empty($social_options['twitter']))
		{
			echo '<li><a target="_blank" href="'.$social_options['twitter'].'" title="Twitter"><i class="icon-twitter"></i></a></li>';
		}								

		if  ( !empty($social_options['google_plus']))
		{
			echo '<li><a target="_blank" href="'.$social_options['google_plus'].'" title="Google Plus"><i class="icon-gplus"></i></a></li>';
		}

		if  ( !empty($social_options['youtube']))
		{
			echo '<li><a target="_blank" href="'.$social_options['youtube'].'" title="YouTube"><i class="icon-youtube"></i></a></li>';
		}

		if  ( !empty($social_options['vimeo']))
		{
			echo '<li><a target="_blank" href="'.$social_options['vimeo'].'" title="Vimeo"><i class="icon-vimeo"></i></a></li>';
		}

		if  ( !empty($social_options['soundcloud']))
		{
			echo '<li><a target="_blank" href="'.$social_options['soundcloud'].'" title="SoundCloud"><i class="icon-soundcloud"></i></a></li>';
		}

		if  ( !empty($social_options['myspace']))
		{
			echo '<li><a target="_blank" href="'.$social_options['myspace'].'" title="Myspace"><i class="icon-myspace"></i></a></li>';
		}	

		if  ( !empty($social_options['flickr']))
		{
			echo '<li><a target="_blank" href="'.$social_options['flickr'].'" title="Flickr"><i class="icon-flickr"></i></a></li>';
		}	

		if  ( !empty($social_options['pinterest']))
		{
			echo '<li><a target="_blank" href="'.$social_options['pinterest'].'" title="Pinterest"><i class="icon-pinterest"></i></a></li>';
		}	

		if  ( !empty($social_options['instagram']))
		{
			echo '<li><a target="_blank" href="'.$social_options['instagram'].'" title="Instagram"><i class="icon-instagramm"></i></a></li>';
		}
		
		if  ( !empty($social_options['itunes']))
		{
			echo '<li><a target="_blank" href="'.$social_options['itunes'].'" title="iTunes"><i class="icon-itunes"></i></a></li>';
		}
		if  ( !empty($social_options['spotify']))
		{
			echo '<li><a target="_blank" href="'.$social_options['spotify'].'" title="Spotify"><i class="icon-spotify"></i></a></li>';
		}
		if  ( !empty($social_options['tumblr']))
		{
			echo '<li><a target="_blank" href="'.$social_options['tumblr'].'" title="Tumblr"><i class="icon-tumblr"></i></a></li>';
		}
		if  ( !empty($social_options['rnation']))
		{
			echo '<li><a target="_blank" href="'.$social_options['rnation'].'" title="ReverbNation"><i class="icon-star"></i></a></li>';
		}	

		if  ( !empty($social_options['custom']))
		{
			$social_network_name = !empty($social_options['custom_name']) ? $social_options['custom_name'] : "";
			echo '<li><a target="_blank" href="'.$social_options['custom'].'" title="'.$social_network_name.'"><i class="icon-headphones"></i></a></li>';
		}

		if  ( !empty($social_options['bandcamp']))
		{
			echo '<li><a target="_blank" href="'.$social_options['bandcamp'].'" title="BandCamp"><i class="icon-bandcamp"></i></a></li>';
		}
		
		if  ( !empty($social_options['linkedin']))
		{
			echo '<li><a target="_blank" href="'.$social_options['linkedin'].'" title="LinkedIn"><i class="icon-linkedin-squared"></i></a></li>';
		}
		
		if  ( !empty($social_options['mixcloud']))
		{
			echo '<li><a target="_blank" href="'.$social_options['mixcloud'].'" title="Mixcloud"><i class="icon-mixcloud"></i></a></li>';
		}		
		echo '</ul>';
	}

}
endif;

/*
	Retreive next concerts available for the front page bottom bar
*/
if ( ! function_exists( 'JAMSESSION_SWP_get_next_shows' ) ) :

function JAMSESSION_SWP_get_next_shows()
{
	$args = array(
		'numberposts'	=> 3,
		'posts_per_page'   => 3,
		'offset'           => 0,
		'category'         => '',
		'orderby'          => 'meta_value',
		'order'            => 'ASC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => 'event_date',
		'meta_value'       => '',
		'post_type'        => 'js_events',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'post_status'      => 'publish',
		'meta_query' => array(
			array(
			   'key' => 'event_date',
			   'value' => date('Y/m/d',time()),
			   'compare' => '>='
			)
		),
		'suppress_filters' => false
	);
	
	$shows = get_posts( $args);
	
	if ( count( $shows) > 0)
	{
		$no = 1;  
		foreach($shows as $show)
		{
			setup_postdata( $show);
			
			if ( $no == 1)
			{
				echo '<div class="one_of_three">';
			}
			elseif ( $no == 2)
			{
				echo '<div class="two_of_three">';
			}
			elseif ( $no == 3)
			{
				echo '<div class="three_of_three">';
			}
			elseif ( $no > 3)
			{	
				/* should never reach this point due to posts_per_page parameter*/
				return;
			}
			
			$releaseDate = esc_html(get_post_meta( $show->ID, 'event_date', true ));
			@$releaseDate = str_replace("/","-", $releaseDate);
			@$mydate = new DateTime($releaseDate);
			
			$venue = esc_html(get_post_meta( $show->ID, 'event_venue', true ));
			$eventTitle = get_the_title($show->ID);
			
			if ("date_and_venue" == JAMSESSION_SWP_get_upcoming_events_show()) {
				echo ' <a href="'. get_permalink( $show->ID ).'">'.date_i18n(get_option('date_format'), $mydate->format('U')).' '.$venue.'</a>';
			} else {
				echo ' <a href="'. get_permalink( $show->ID ).'">'.date_i18n(get_option('date_format'), $mydate->format('U')).' '.$eventTitle.'</a>';
			}
			echo '</div>';
			$no++;
		}
		wp_reset_postdata();
	}
	else
	{
		echo __("There is no live show for this moment, check back soon.", "jamsession");
	}
}

endif;

/*
	Decide where to send contact form emails
*/
function JAMSESSION_SWP_get_contact_to_email()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	if ( !empty(  $general_options['contact_form_email']))
	{
		return sanitize_email($general_options['contact_form_email']);
	}
	
	return get_option('admin_email');
}

/*
	Return the location of the image used as background
*/
if ( ! function_exists( 'JAMSESSION_SWP_get_background_image' ) ) :
function JAMSESSION_SWP_get_background_image($postId)
{
	/*background image from custom meta have highest priority*/
    $meta_bg = get_post_meta($postId, 'js_swp_meta_bg_image', true);
 
    // Checks and displays the retrieved value
    if( !empty( $meta_bg ) ) {
        return $meta_bg;
    }
	
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( !empty(  $general_options['bgimage_upload_value']))
	{
		return esc_url($general_options['bgimage_upload_value']);
	}
	else
	{
		if ( !JAMSESSION_SWP_remove_defa_bgimg()) {
			$default_bgimage = get_template_directory_uri().'/images/textures/tex8.jpg';
			return $default_bgimage;			
		}
	}
	
	return "";
}
endif;

/*
	THEME SETTINGS GETTERS - Get the theme options related to show/hide the front page upcoming events
*/
function JAMSESSION_SWP_remove_defa_bgimg() {
	$options = get_option( 'jamsession_theme_general_options' );

	if (!isset($options['remove_default_background'])) {
		return false;
	}
	
	if ("not_remove_bgimg" == $options['remove_default_background']) {
		return false;
	}
	
	return true;
}

function JAMSESSION_SWP_hide_sharing_icons() {
	$options = get_option( 'jamsession_theme_general_options' );
	
    if(isset($options['hide_social_sharing'])) { 
        if ('hide_sharing_icons' == $options['hide_social_sharing']) {
			return true;
		}
    }
	
	return false;
}

function JAMSESSION_SWP_get_events_view() {
	$options = get_option( 'jamsession_theme_general_options' );

	if(isset($options['events_view'])) 
	{ 
		return $options['events_view']; 
	}
	
	return 'masonry';
}

function JAMSESSION_SWP_get_upcoming_events_show() {
	$options = get_option( 'jamsession_theme_general_options' );  
      
    if( isset( $options['upcoming_events_shows'])) { 
        return $options['upcoming_events_shows']; 
    }
	
	return "date_and_venue";
}

function JAMSESSION_SWP_put_upcoming_events_title() {
	$options = get_option( 'jamsession_theme_general_options' );  

	$title = 'Upcoming Events';
    if( isset( $options['upcoming_events_title'] ) ) 
	{ 
        $title = $options['upcoming_events_title']; 
    }
	
	/*render the output*/
	echo '<div id="news_badge">'.$title.'</div>';
}

function JAMSESSION_SWP_has_upcoming_events()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( ( empty( $general_options['hide_upcoming_events'])) || ("hide_no" == $general_options['hide_upcoming_events']))
	{
		return true;
	}
	
	return false;
}

/*
	Get the theme options - prevent right click on slider
*/
function JAMSESSION_SWP_get_slider_image_protect()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( ( empty( $general_options['slider_image_protect'])) || ("allow_click" == $general_options['slider_image_protect']))
	{
		return 0;
	}
	
	return 1;
}

function JAMSESSION_SWP_get_slider_interval()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( !empty( $general_options['slider_interval']))
	{
		return $general_options['slider_interval'];
	}
	
	return 10000;
}

function JAMSESSION_SWP_get_slider_transition()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( !empty( $general_options['slider_transition']))
	{
		return $general_options['slider_transition'];
	}
	
	return 6;
}

function JAMSESSION_SWP_disable_sticky_menu_setting() 
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( empty( $general_options['disable_sticky_menu']) || ("keep_sticky" == $general_options['disable_sticky_menu']))
	{
		return false;
	}
	
	return true;
}
/*
function JAMSESSION_SWP_is_masonry_js()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( empty( $general_options['css_masonry_layout']) ||($general_options['css_masonry_layout'] == "keep_js")) {
		return true;
	}
	
	return false;
}

function JAMSESSION_SWP_get_masonry_container() 
{
	if (JAMSESSION_SWP_is_masonry_js()) {
		return "post_content_container";
	} else {
		return "post_content_container_css";
	}
}
*/

/*
*	Maintenance related functionality
*/
function JAMSESSION_SWP_is_in_maintenance()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( ( empty( $general_options['maintenance_mode'])) || ("maintenance_disabled" == $general_options['maintenance_mode']))
	{
		return false;
	}
	
	return true;
}

function JAMSESSION_SWP_get_maintenance_selected_page() 
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( ( empty( $general_options['maintenance_page'])) || ("maintenance_page_none" == $general_options['maintenance_page'])) 
	{
		return "maintenance_page_none";
	}
	
	return $general_options['maintenance_page'];
}

function JAMSESSION_SWP_maintenance_enabled_by_user()
{
	if ( (JAMSESSION_SWP_get_maintenance_selected_page() != "maintenance_page_none") && 
		 JAMSESSION_SWP_is_in_maintenance() )
	{
		return true;
	}
	
	return false;
}

function JAMSESSION_SWP_get_hide_post_meta()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( empty( $general_options['hide_post_meta']) || ("do_not_hide" == $general_options['hide_post_meta']))
	{
		return false;
	}
	
	return true;
}

function JAMSESSION_SWP_get_hide_archive_date()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	if ( empty( $general_options['hide_archive_date']) || ("do_not_hide" == $general_options['hide_archive_date']))
	{
		return false;
	}
	
	return true;	
}

if ( ! function_exists( 'JAMSESSION_SWP_put_single_post_meta' ) ) :
function JAMSESSION_SWP_put_single_post_meta()
{
	if ( !JAMSESSION_SWP_get_hide_post_meta())
	{
		echo __('by','jamsession').' <span class="post_author"><a href="'.get_author_posts_url( get_the_author_meta('ID')).'">'.get_the_author().'</a></span>';
		echo " on ".get_the_date('F j, Y');
		echo __(' in ','jamsession');
	}
}
endif;

function JAMSESSION_SWP_display_maintenance() {

	if ( JAMSESSION_SWP_maintenance_enabled_by_user()) 
	{
		if ( (!current_user_can( 'edit_themes' ) || !is_user_logged_in() ) &&  
			!is_page_template( 'page_maintenance.php' ))
		{
			wp_redirect( urldecode(JAMSESSION_SWP_get_maintenance_selected_page())); 
			exit; 
		}
	}
}
add_action('template_redirect', 'JAMSESSION_SWP_display_maintenance');


if ( ! function_exists( 'JAMSESSION_SWP_put_favicon' ) ) :
/*
	Put favicon to header.php
*/
function JAMSESSION_SWP_put_favicon() 
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	/* custom favicon */
	if ( !empty(  $general_options['favicon_upload_value']))
	{
		echo '<link rel="shortcut icon" href="'.$general_options['favicon_upload_value'].'" type="image/x-icon" />';
	}
	else
	{
		?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri().'/images/favicon.ico'; ?>" type="image/x-icon" />
		<?php		
	}	
}
endif;


if ( ! function_exists( 'JAMSESSION_SWP_use_mobile_menu_setting' ) ) :
/*
	Check theme settings for mobile menu usage
*/
function JAMSESSION_SWP_use_mobile_menu_setting()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	if ( empty($general_options['use_mobile_menu']) || ( $general_options['use_mobile_menu'] == "use_normal_menu")) 
	{
		return false;
	}
	
	return true;
}
endif;


if ( ! function_exists( 'JAMSESSION_SWP_put_page_title_for_mobile_menu' ) ) :
/*
	Put page or post title when mobile menu is set from theme settings
*/
function JAMSESSION_SWP_put_page_title_for_mobile_menu() {
	if ( !JAMSESSION_SWP_use_mobile_menu_setting() || JAMSESSION_SWP_is_main_slider_page()
		|| is_singular('jamsession_slides')) {
		return;
	}
	
	$page_title = get_the_title();
	
	if ( is_category()) {
		$page_title = __("Posts under ","jamsession").'<span class="archive_name">'.single_cat_title("", FALSE).'</span>'.__(" category ","jamsession");
	}
	if( is_tag()) {
		$page_title = __("Posts tagged under ","jamsession").'<span class="archive_name">'.single_tag_title("", FALSE).'</span>';
	}
	if( is_archive()) {
		$page_title = __("Posts for ","jamsession").'<span class="archive_name">'.get_the_time(get_option('date_format')).'</span>';	
		if (is_archive('product'))
		{
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
			{
				$page_title = woocommerce_page_title(false);
			}	
		}
	}
	if ( is_author()) {
		$page_title = __("Posts by ","jamsession").'<span class="archive_name">'.get_query_var('author_name').'</span>';
	}
	if ( is_tax('photo_album_category')) {
		$page_title = JAMSESSION_SWP_get_photo_tax_title();
	}
	if ( is_tax('album_category')) {
		$page_title = JAMSESSION_SWP_get_album_tax_title();
	}
	if ( is_tax('event_category')) {
		$page_title = JAMSESSION_SWP_get_event_tax_title();
	}
	if ( is_tax('video_category')) {
		$page_title = JAMSESSION_SWP_get_video_tax_title();
	}
	
	echo '<h1 id="title_all">'.$page_title.'</h1>';
}
endif;

if ( ! function_exists( 'JAMSESSION_SWP_put_the_title' ) ) :
function JAMSESSION_SWP_put_the_title($htmlElt, $title, $id, $class)
{
	if ( JAMSESSION_SWP_use_mobile_menu_setting()) {
		return;
	}
	
	$outId = "";
	$outClass = "";
	
	if ( !empty($id)) {
		$outId = ' id="'.$id.'" ';
	}
	
	if ( !empty($class)) {
		$outClass = ' class="'.$class.'" ';
	}
	
	echo '<'.$htmlElt.$outId.$outClass.'>'.$title.'</'.$htmlElt.'>';
}
endif;

/* 
	Get the title for archive pages for custom taxonomy for post types
*/
if ( ! function_exists( 'JAMSESSION_SWP_get_photo_tax_title' ) ) :
function JAMSESSION_SWP_get_photo_tax_title()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	if ( !empty($general_options['photo_tax_title'])) {
		return $general_options['photo_tax_title'];
	}
	
	return __("Photo Gallery", "jamsession");
}
endif;

if ( ! function_exists( 'JAMSESSION_SWP_get_album_tax_title' ) ) :
function JAMSESSION_SWP_get_album_tax_title()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	if ( !empty($general_options['album_tax_title'])) {
		return $general_options['album_tax_title'];
	}
	
	return __("Discography","jamsession");
}
endif;

if ( ! function_exists( 'JAMSESSION_SWP_get_event_tax_title' ) ) :
function JAMSESSION_SWP_get_event_tax_title()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	if ( !empty($general_options['event_tax_title'])) {
		return $general_options['event_tax_title'];
	}
	
	return __("Tour Dates","jamsession");
}
endif;

if ( ! function_exists( 'JAMSESSION_SWP_get_video_tax_title' ) ) :
function JAMSESSION_SWP_get_video_tax_title()
{
	$general_options = get_option( 'jamsession_theme_general_options' );
	
	if ( !empty($general_options['video_tax_title'])) {
		return $general_options['video_tax_title'];
	}
	
	return __("Video Gallery","jamsession");
}
endif;

/*
	Check if we are on the page based on page_main_slider.php template
*/
function JAMSESSION_SWP_is_main_slider_page()
{
	return is_page_template('page_main_slider.php') || is_page_template('page_main_rev_slider.php');	
}


/*
	Return the image used for the last defined slider or empty if no slider has been defined
*/
function JAMSESSION_SWP_get_last_slide_image()
{
	/*fallback result*/
	$post_thumbnail_url = "";
	
	
	$args = array(
	'post_type' => 'jamsession_slides', 
	'posts_per_page' => 1 
	);
	
	/*main array*/
	$slider_values = array();
	
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
		// check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) 
		{
			$post_thumbnail_id = get_post_thumbnail_id();
			$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
		}
	endwhile;

	return $post_thumbnail_url;
}

/*
	Add back to top button
*/

function JAMSESSION_SWP_is_back_to_top_active() {
	$options = get_option( 'jamsession_theme_general_options' );
	
	$back_to_top = ''; 
    if( isset( $options['back_to_top'] ) ) 
	{ 
        $back_to_top = $options['back_to_top'];
    }
	
	if ($back_to_top != 'back_to_top_enabled') {
		return false;
	}
	
	return true;
}

if ( !function_exists( 'JAMSESSION_SWP_render_back_to_top' ) ) {
function JAMSESSION_SWP_render_back_to_top() {

	if (!JAMSESSION_SWP_is_back_to_top_active()) {
		return;
	} 
	
	echo '<div class="back_to_top_btn"><div class="btt_left"></div><div class="btt_right"></div></div>';
}
}


/*
	Add copyright code
*/
if ( !function_exists( 'JAMSESSION_SWP_render_footer' ) ) {
function JAMSESSION_SWP_render_footer()
{
	/* use this call to get correct results for conditional tags like is_page() or is_home() and is_front_page() */
	wp_reset_query();
	
	if ( !JAMSESSION_SWP_is_main_slider_page())
	{
		$footer_options = get_option( 'jamsession_theme_footer_options' );
		
		if ( !empty( $footer_options['footer_text']))
		{
			echo '<div class="copy">';
			if ( !empty( $footer_options['footer_text_url']))
			{
				echo '<a href="'.$footer_options['footer_text_url'].'" target = "_blank">';
			}
			
			echo esc_html($footer_options['footer_text']);
			
			if ( !empty( $footer_options['footer_text_url']))
			{
				echo '</a>';
			}
			echo '</div>';
		}
		else
		{
			echo '<div class="copy">';
					echo "2014 JamSession &copy; All rights reserved.";
			echo '</div>';
		}
	}
}
}

if ( !function_exists( 'JAMSESSION_SWP_render_ajax_contact' ) ) {
function JAMSESSION_SWP_render_ajax_contact() 
{
	$output = '<div id="contactform">';
	$output .= '<form id="contactForm">';						
	$output .= '<ul class="contactform">';

	$output .= '<li class="comment-form-author">';
	$output .= '<label for="contactName">'.__('Name ', 'jamsession').'<span class="required_field">*</span></label>';
	$output .= '<input type="text" name="contactName" id="contactName" class="required requiredField contactNameInput" />';
	$output .= '<span class="error">'.__('Please enter your name.', 'jamsession').'</span>';
	$output .= '</li>';

	$output .= '<li class="comment-form-email">';
	$output .= '<label for="email">'.__('Email ', 'jamsession').'<span class="required_field">*</span></label>';
	$output .= '<input type="text" name="email" id="email" class="required requiredField email" />';
	$output .= '<span class="error">'.__('Please enter a correct email address.', 'jamsession').'</span>';
	$output .= '</li>';
	
	$output .= '<li class="comment-form-url">';
	$output .= '<label for="phone">'.__('Phone ', 'jamsession').'</label>';
	$output .= '<input type="text" name="phone" id="phone" />';
	$output .= '</li>';

	$output .= '<li class="comment-form-comment">';
	$output .= '<label for="commentsText">'.__('Message ', 'jamsession').'<span class="required_field">*</span></label>';
	$output .= '<textarea name="comments" id="commentsText" rows="10" cols="30" class="required requiredField" contactMessageInput></textarea>';
	$output .= '<span class="error">'.__('Please enter a message.', 'jamsession').'</span>';
	$output .= '</li>';

	$output .= '<li class="captcha_error">';
	$output .= '<span class="error">'.__('Incorrect reCaptcha. Please enter reCaptcha challenge.', 'jamsession').'</span>';
	$output .= '</li>';
	
	$output .= '<li class="wp_mail_error">';
	$output .= '<span class="error">'.__('Cannot send mail, an error occurred while delivering this message. Please try again later.', 'jamsession').'</span>';
	$output .= '</li>';	
	
	$output .= '<li class="formResultOK">';
	$output .= '<span class="error">'.__('Your message was sent successfully. Thanks!', 'jamsession').'</span>';
	$output .= '</li>';
	
	
	$output .= JAMSESSION_SWP_get_recaptcha();
	
	$output .= '<li>';
	$output .= '<input name="Button1" type="submit" id="submit" value="'.__('Send Email', 'jamsession').'" >';
	$output .= '<div class="progressAction"><img src="'.get_template_directory_uri()."/images/progress.gif".'"></div>';
	$output .= '</li>';
	$output .= '</ul>';
	$output .= '<input type="hidden" name="action" value="contactformajax_action" />';
	/*wp_nonce_field( $action = -1, $name = "_wpnonce", $referer = true , $echo = true )*/
	$output .= wp_nonce_field('JAMSESSION_SWP_render_ajax_contact', 'contactform_nonce', true, false);
	$output .= '</form>';
	$output .='</div>';

	return $output;
}
}

if ( !function_exists( 'JAMSESSION_SWP_process_contact_form' ) ) {
function JAMSESSION_SWP_process_contact_form()
{
	$data = array();
	parse_str($_POST['data'], $data);
	$namedError = '';
	$ret['success'] = false;
	
	if(isset($data['contactform_nonce']) && wp_verify_nonce($data['contactform_nonce'], 'JAMSESSION_SWP_render_ajax_contact')) {
		if (sanitize_text_field($data['contactName']) === '') {
			$hasError = true;
			$namedError = 'contactName';
		} else {
			$name = sanitize_text_field($data['contactName']);
		}

		if (trim($data['email']) === '') {
			$hasError = true;
			$namedError = 'email';
		}
		else {
			if ((!is_email($data['email']))) {
				$hasError = true;
				$namedError = 'notEmail';
			} 
			else {
				$email = trim($data['email']);
			}
		}
		
		$phone = sanitize_text_field($data['phone']);

		if(sanitize_text_field($data['comments']) === '') {
			$commentError = __('Please enter a message.', 'jamsession');
			$hasError = true;
			$namedError = 'comments';
		}
		else {
			$comments = sanitize_text_field($data['comments']);
		}

		if ( isset($data["g-recaptcha-response"])) {	
			if ( false == JAMSESSION_SWP_check_recaptcha($_SERVER["REMOTE_ADDR"], $data["g-recaptcha-response"])) {
				$hasError = true;
				$namedError = 'reCaptcha';
			}
		}
		
		if(!isset($hasError)) {
			$emailTo = JAMSESSION_SWP_get_contact_to_email();

			$email_subject = "[" . get_bloginfo( 'name' ) . "] " . __("Contact Form Message", "jamsession");

	        $email_message = $comments;
			$email_message .= "\n\n".__("From: ", "jamsession"). " " . $name . " <".$email.">\n";
			$email_message .= "\n\n".__("Contact Phone: ", "jamsession")." ".$phone."\n";

			
			$headers = "MIME-Version: 1.0\r\n" .
			"From: " . get_option('admin_email') . "\r\n" .
			"Content-Type: text/plain; charset=\"" . get_option('blog_charset') . "\"\r\n";		

			if (!wp_mail( $emailTo, $email_subject, $email_message, $headers )) {
				$namedError = 'wp_mail_failed';
			} else {
				$ret['success'] = true;	
			}
		} 
	} else {
		$namedError = 'nonce';
	}
	
	$ret['error'] = $namedError;
	echo json_encode( $ret );	
	
	die();	//important
}
}
add_action( 'wp_ajax_contactformajax_action', 'JAMSESSION_SWP_process_contact_form' );
add_action( 'wp_ajax_nopriv_contactformajax_action', 'JAMSESSION_SWP_process_contact_form' );


function JAMSESSION_SWP_get_attachment_id_from_url($attachment_url = '') {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ('' == $attachment_url ) {
		return false;
	}
		
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 	}
 
	return $attachment_id;
}

/*
Add analytics code
*/
function JAMSESSION_SWP_analytics_code()
{
	$footer_options = get_option( 'jamsession_theme_footer_options' );
	
	if ( !empty( $footer_options['analytics_code']))
	{
		echo $footer_options['analytics_code']; 
	}
}

/*
	Getting recaptcha lib
*/
require_once(get_template_directory()."/lib/ReCaptcha/loadReCaptcha.php");

/*
	Show/Get Recaptcha Challenge
*/
function JAMSESSION_SWP_show_recaptcha()
{
	echo JAMSESSION_SWP_get_recaptcha();
}

function JAMSESSION_SWP_get_recaptcha() {
	$general_options = get_option( 'jamsession_theme_general_options' );
	$output = '';
	
	/*
		Old:	 public key	
		Current: site key
	*/
	if ( !empty( $general_options['recaptcha_public_key'] ) && !empty( $general_options['recaptcha_private_key'] ) )
	{
		ob_start();
		?>
		
		<li>
			<div id="captchadiv">
				  <div class="g-recaptcha" data-sitekey="<?php echo $general_options['recaptcha_public_key']; ?>"></div>
			</div>
		</li>
		
		<?php
		$output = ob_get_clean();
	}

	return $output;
}

/*
	Check Recaptcha Response
*/
function JAMSESSION_SWP_check_recaptcha($remote_addr, $response)
{
	$general_options = get_option( 'jamsession_theme_general_options' );

	if ( !empty( $general_options['recaptcha_public_key'] ) && !empty( $general_options['recaptcha_private_key'] ) )
	{
		$secret = $general_options['recaptcha_private_key'];

		$recaptcha = new ReCaptcha($secret);
		$resp = $recaptcha->verify($response, $remote_addr);
		if (!$resp->isSuccess()) {
			return false;
		}		 
	}

	return true;
}

/*
	Add ReCaptcha Script
*/
function JAMSESSION_SWP_js_add_recaptcha_script()
{
	/* use this call to get correct results for conditional tags like is_home() and is_front_page() */
	wp_reset_query();
	
	//if ( (is_page_template('page_contact.php')) || ( is_page_template('page_contact_full.php') ) )
	{
		wp_register_script( 'recaptcha_api',  'https://www.google.com/recaptcha/api.js', array('jquery'), '', true);
		wp_enqueue_script( 'recaptcha_api');
	}
}
add_action( 'wp_enqueue_scripts', 'JAMSESSION_SWP_js_add_recaptcha_script' );	


/*
	REMOVE ACTIVATION MESSAGE FOR VISUAL COMPOSER
*/
add_action( 'vc_before_init', 'JAMSESSION_SWP_vcSetAsTheme' );

function JAMSESSION_SWP_vcSetAsTheme() {
	vc_set_as_theme(true);
}

/*
	REMOVE ACTIVATION MESSAGE FOR SLIDER REVOLUTION
*/
if(function_exists( 'set_revslider_as_theme' )){
add_action( 'init', 'JAMSESSION_SWP_RevSliderSetAsTheme' );
function JAMSESSION_SWP_RevSliderSetAsTheme() {
	set_revslider_as_theme();
}
}

/************************************* WooCommerce *******************************************************/
/*
	Declare WooCommerce Support
*/
add_theme_support( 'woocommerce' );


/*
	Unhook the WooCommerce Wrappers
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


/*
	Hook in own functions to display the wrappers that JamSession theme requires
*/
add_action('woocommerce_before_main_content', 'JAMSESSION_SWP_woocommerce_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'JAMSESSION_SWP_woocommerce_wrapper_end', 10);

function JAMSESSION_SWP_woocommerce_wrapper_start() {
  echo '<div id="main_content">';
  echo '<div id="post_content">';
}

function JAMSESSION_SWP_woocommerce_wrapper_end() {
  echo '</div>';
  echo '</div>';
}

/*
	Remove breadcrumbs
*/
add_action( 'init', 'JAMSESSION_SWP_remove_wc_breadcrumbs' );
function JAMSESSION_SWP_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

// Remove the product rating display on product loops
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/************************************* WooCommerce *******************************************************/


/*
	Checks if exists and install the required plugins that are coming with the theme
*/
require_once(get_template_directory()."/core/install_required_plugins.php");
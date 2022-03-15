<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php 
	if ( !JAMSESSION_SWP_use_mobile_menu_setting()) 
	{
?>
		<h1 itemprop="name" class="page_title product_title entry-title"><?php the_title(); ?></h1>
<?php
	}
?>
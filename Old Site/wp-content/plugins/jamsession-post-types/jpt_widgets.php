<?php

require_once( CDIR_PATH."/classes/JAMSESSION_SWP_next_events_widget.php");

function JAMSESSION_SWP_register_widegt_next_events() {
	return register_widget("JAMSESSION_SWP_next_events_widget");
}
add_action('widgets_init', 'JAMSESSION_SWP_register_widegt_next_events');

?>
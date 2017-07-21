<?php

// prevent plugin from being used with wp versions under 2.5; otherwise do nothing!
global $wp_db_version;
if ( $wp_db_version >= 7558 ) {

// prevent file from being accessed directly

if ('mmdate.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not access this file directly. Thanks!');



function MCECM_mcebutton($buttons) {
	array_push($buttons, "|","mmdate,mmyear,mmendate,mmentime,insertmmtime,insertmedate,keyboardico");
	return $buttons;
}
function MCECM_mcebutton2($buttons) {
	array_push($buttons, "fontselect,fontsizeselect,styleprops");
	return $buttons;
}

function MCECM_mceplugin($ext_plu) {
	if (is_array($ext_plu) == false) {
		$ext_plu = array();
	}
	$url = AWK_PLUGIN_URL."/tiny_mce/plugins/mmdate/editor_plugin.js";
	$url2 = AWK_PLUGIN_URL."/tiny_mce/plugins/style/editor_plugin.js";
	$result = array_merge($ext_plu, array("mmdate" => $url,"style" => $url2));
	return $result;
}

function MCECM_mceinit() {
	if (function_exists('load_plugin_textdomain')) load_plugin_textdomain('MCECM',AWK_PLUGIN_URL.'/langs');
	if ( 'true' == get_user_option('rich_editing') ) {
		add_filter("mce_external_plugins", "MCECM_mceplugin", 0);
		add_filter("mce_buttons", "MCECM_mcebutton", 0);
		add_filter("mce_buttons_3", "MCECM_mcebutton2", 0);
	}
}

function MCECM_script() {
	echo "<script type='text/javascript' src='".AWK_PLUGIN_URL."/js/mmcal_admin.js'></script>\n";
	$webroot= AWK_PLUGIN_URL;
?>

<?php
}
if ( function_exists('add_action') ) {
	add_action('init', 'MCECM_mceinit');
	add_action('admin_print_scripts', 'MCECM_script');
	add_action('comment_form', 'MCECM_script');
	//add_action('edit_page_form', 'mce_page_form');
	//add_action('edit_form_advanced', 'mce_post_form');
	//add_action('comment_form', 'mce_comment_form');
}

} // closing if for version check

?>

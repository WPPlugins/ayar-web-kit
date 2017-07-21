<?php
wp_admin_css_color('ayar', __('Green'), AWK_PLUGIN_URL.'/css/colors-green.css', array('#316c14', '#0ed869', '#a0feca', '#8bf2b9'));
function mcecomment_getlogo() {
	$mcecomment_options = get_option('mcecomment_options');
  
	if ($mcecomment_options['hlogo'] != '') {
		return $mcecomment_options['hlogo'];
   } else {
		return AWK_PLUGIN_URL . '/images/myLOGO.png';
	}
}
function mcecomment_getlogo_w() {
	$mcecomment_options = get_option('mcecomment_options');
  
	if ($mcecomment_options['hlogo_w'] != '') {
		return $mcecomment_options['hlogo_w'];
   } else {
		return '100';
	}
}
function mcecomment_getlogo_h() {
	$mcecomment_options = get_option('mcecomment_options');
  
	if ($mcecomment_options['hlogo_h'] != '') {
		return $mcecomment_options['hlogo_h'];
   } else {
		return '100';
	}
}
function admin_logo(){
$admin_logo= mcecomment_getlogo();
$logo_width= mcecomment_getlogo_w();
$logo_height= mcecomment_getlogo_h();
 ?>
<style type="text/css">
#header-logo{float:left;left:0px; padding-left:20px; width:<?php echo $logo_width; ?>px; height:<?php echo $logo_height; ?>px; background:transparent url(<?php echo $admin_logo;?>?ver=20100531) no-repeat scroll center center !important;}
</style>
<?php
}
add_action('admin_head','admin_logo');
?>
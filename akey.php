<?php
define('AMCEPATH',AWK_PLUGIN_PATH.'/tiny_mce/');
define('AMCEURL',AWK_PLUGIN_URL.'/tiny_mce/');
include (AWK_PLUGIN_PATH.'/mmdate.php');
include (AWK_PLUGIN_PATH.'/mcecomment.php');
include (AWK_PLUGIN_PATH.'/mceoptions.php');
//include (AWK_PLUGIN_PATH.'/defaultmce.php');

// prevent plugin from being used with wp versions under 2.5; otherwise do nothing!
global $wp_db_version;
if ( $wp_db_version >= 7558 ) {

// prevent file from being accessed directly

if ('AWK.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not access this file directly. Thanks!');

define("AWK_VERSION", 1);

function AWK_mcebutton($buttons) {
	array_push($buttons,"Jsvk");
	return $buttons;
}
function AWK_mcecss($mce_css) {
	$mce_css = AWK_PLUGIN_URL.'/editor-style.css';
	return $mce_css;
}
function AWK_mceplugin($ext_plu) {
	if (is_array($ext_plu) == false) {
		$ext_plu = array();
	}
	$url = AWK_PLUGIN_URL."/tiny_mce/plugins/Jsvk/editor_plugin_admin.js";
	$result = array_merge($ext_plu, array("Jsvk" => $url));
	return $result;
}
function AWK_fonts($initArray) {
$fonts= 'ဧရာ=ayar, ဧရာ ဂျူနို=ayar juno, ဧရာ တန်ခူး=ayar takhu, ဧရာ ကဆုန်=ayar kasone, ဧရာ နယုန်=ayar nayon, ဧရာ ဝါဆို=ayar wazo, ဧရာ ဝါေခါင်=ayar wagaung, ဧရာ ေတာ်သလင်း=ayar tawthalin, ဧရာ လက်နှိပ်စက်=ayar typewriter, sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
	$initArray = array_merge($initArray,array("theme_advanced_fonts" => $fonts));
	return $initArray;
}
function AWK_mceinit() {
	if ( 'true' == get_user_option('rich_editing') ) {
		add_filter("mce_external_plugins", "AWK_mceplugin", 0);
		add_filter("mce_buttons", "AWK_mcebutton", 0);
		add_filter("mce_css", "AWK_mcecss", 1);
		add_filter("tiny_mce_before_init","AWK_fonts",$initArray);
	}
}

function AWK_script() {
?>


<?php
}
if ( function_exists('add_action') ) {
	add_action('init', 'AWK_mceinit');
	add_action('admin_print_scripts', 'AWK_script');
	add_action('wp_head','AWK_script');
	add_action('login_head','AWK_script');
}

} // closing if for version check

?>
<?php function mce_footer(){ ?>		
<script type="text/javascript" src="<?php echo AMCEURL; ?>/plugins/Jsvk/jscripts/vk_easy.js"></script>
	<script type="text/javascript">
	inputArray = document.getElementsByTagName("input");
	for (var index = 0; index < inputArray.length; index++){
		if (inputArray[index].type == "text"){
			inputArray[index].className = "keyboardInput";
		}
	}
	inputArray = document.getElementsByTagName("input");
	for (var index = 0; index < inputArray.length; index++){
		if (inputArray[index].type == "password"){
			inputArray[index].className = "keyboardInput";
		}
	}
	inputArray = document.getElementsByTagName("iframe");
	for (var index = 0; index < inputArray.length; index++){
			inputArray[index].className = "keyboardInput";
	}
	inputArray = document.getElementsByTagName("textarea");
	for (var index = 0; index < inputArray.length; index++){
		if (inputArray[index].className != "theEditor"){ 
			inputArray[index].className = "keyboardInput"; 
		}
		if (inputArray[index].className == "theEditor"){ 
			inputArray[index].rows = "15"; 
		}
		if (inputArray[index].className == "comment"){ 
			inputArray[index].rows = "10"; 
		}
	}
	</script>
	

<?php 		
}
add_action('admin_footer','mce_footer');
function mce_comment_form(){
		?>
		<script type="text/javascript" src="<?php echo AMCEURL; ?>/plugins/Jsvk/jscripts/vk_easy.js"></script>
	<script type="text/javascript">
		inputArray = document.getElementsByTagName("input");
	for (var index = 0; index < inputArray.length; index++){
		if (inputArray[index].type == "text"){
			inputArray[index].className = "keyboardInput";
		}
	}
	inputArray = document.getElementsByTagName("input");
	for (var index = 0; index < inputArray.length; index++){
		if (inputArray[index].type == "password"){
			inputArray[index].className = "keyboardInput";
		}
	}
		inputArray = document.getElementsByTagName("textarea");
	for (var index = 0; index < inputArray.length; index++){
			inputArray[index].className = "keyboardInput";
	}
		inputArray = document.getElementsByTagName("iframe");
	for (var index = 0; index < inputArray.length; index++){
			inputArray[index].className = "keyboardInput";
	}
</script>	
		<?php } ?>
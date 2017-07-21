<?php

$mcecomment_nonce = 'mcecomment-update-key';
$mce_locale = ( '' == get_locale() ) ? 'en' : strtolower( substr(get_locale(), 0, 2) );

function mcecomment_adminpages() {
	$page = add_options_page('Ayar Web Kit Options', 'AyarWebKit', 8, 'AyarWebKit', 'mcecomment_optionpage');
	add_action( "admin_print_scripts-$page", 'mcecomment_admin_page_init' );
		wp_enqueue_style('thickbox');
}

//Get availabe skins for TinyMCE
function mcecomment_getskins() {
   $adv_path = AMCEPATH . 'themes/advanced/skins/';
   if ($h = opendir($adv_path)) {
		while (($file = readdir($h)) !== false) {
		   $skin_path = $adv_path . $file;
			if (is_dir($skin_path) && strpos($file, '.') !== 0) 
				$skins[] = $file;
			}
		closedir($h);
	}

	return $skins;
}

//Get available plugins of TinyMCE
function mcecomment_getplugins() {
	if ($h = opendir(AMCEPATH . 'plugins')) {
		while (($file = readdir($h)) !== false) {
			if (is_file(AMCEPATH . 'plugins/' . $file . '/editor_plugin.js')) 
				$plugins[] = $file;
			}
		closedir($h);
	}

	return $plugins;
}

function mcecomment_getcss() {
	$mcecomment_options = get_option('mcecomment_options');
  
	if ($mcecomment_options['css'] != '') {
		return $mcecomment_options['css'];
   } elseif (mcecomment_isGreaterThan('2.8.0')) {
		return get_option('siteurl') . '/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/content.css';
	} elseif (mcecomment_isGreaterThan('2.5.0')) {
		return get_option('siteurl') . '/wp-includes/js/tinymce/wordpress.css';
	} else {
		return AWK_PLUGIN_URL . '/editor-style.css';
	}
}

//Generate JS Block
function mcecomment_getInitJS($debugMode=0) {
   global $mce_locale;
   
	if ($debugMode == 1)
		$le = "\n";
	$mcecomment_options = get_option('mcecomment_options');
	
	if (!is_array($mcecomment_options)) {
		$mcecomment_options['buttons'] = 'Jsvk,keyboardico,bold,italic,underline,|,strikethrough,|,bullist,numlist,|,undo,redo,|,link,unlink,|,removeformat,help';
		$mcecomment_options['buttons_2'] = 'backcolor,charmap,fontselect,mmdate,mmyear,mmendate,mmentime,insertmmtime,insertmedate';
		$mcecomment_options['plugins'] = 'Jsvk,mmdate';
		update_option('mcecomment_options', $mcecomment_options);
	}
	$initArray = array (
	   'mode' => 'exact',
	   'elements' => 'comment',
	   'theme' => 'advanced',
	   'theme_advanced_buttons1' => $mcecomment_options['buttons'],
	   'theme_advanced_buttons2' => $mcecomment_options['buttons_2'],
	   'theme_advanced_buttons3' => "",
	   'theme_advanced_fonts' =>  "ဧရာ=ayar, ဧရာ ဂျူနို=ayar juno, ဧရာ တန်ခူး=ayar takhu, ဧရာ ကဆုန်=ayar kasone, ဧရာ နယုန်=ayar nayon, ဧရာ ဝါဆို=ayar wazo, ဧရာ ဝါေခါင်=ayar wagaung, ဧရာ ေတာ်သလင်း=ayar tawthalin, ဧရာ လက်နှိပ်စက်=ayar typewriter, sans-serif;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
	   'theme_advanced_toolbar_location' => "top",
	   'theme_advanced_toolbar_align' => "left",
	   'theme_advanced_statusbar_location' => ($mcecomment_options['resize'] ? 'bottom' : 'none'),
	   'theme_advanced_resizing' => ($mcecomment_options['resize'] ? 'true' : 'false'),
	   'theme_advanced_resize_horizontal' => false,
	   'theme_advanced_disable' => ($mcecomment_options['viewhtml'] ? '':'code'),
	   'theme_advanced_row_height' => "10",
	   'force_p_newlines' => false,
	   'force_br_newlines' => true,
	   'forced_root_block' => "p",
	   'gecko_spellcheck' => true,
 	   'skin' => ($mcecomment_options['skin'] ? $mcecomment_options['skin'] : 'default'),
	   'content_css' => mcecomment_getcss(),
	   'directionality' => ($mcecomment_options['rtl'] ? 'rtl' : 'ltr'),
	   'save_callback' => "brstonewline",
	   'entity_encoding' => "raw",
	   'plugins' => $mcecomment_options['plugins'],
	   //'extended_valid_elements' => "a[name|href|title],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style],blockquote[cite]",'.$le;
      'language' => $mce_locale,
   );
   
   $params = array();
	foreach ( $initArray as $k => $v )
		$params[] = $k . ':"' . $v . '"	';
	$res = join(',', $params);
	?>
	<script type="text/javascript">
      /* <![CDATA[ */
      function brstonewline(element_id, html, body) {
	      html = html.replace(/<br\s*\/>/gi, "\n");
	      return html;
	   }
	   
	   function insertHTML(html) {
	      tinyMCE.execCommand("mceInsertContent",false, html);
	   }
	   
      tinyMCEPreInit = {
	      base : "<?php echo AMCEURL ?>",
	      suffix : "",
	      query : "ver=20081129",
	      mceInit : {<?php echo $res ?>},

	      go : function() {
		      var t = this, sl = tinymce.ScriptLoader, ln = t.mceInit.language, th = t.mceInit.theme, pl = t.mceInit.plugins;

		      sl.markDone(t.base + '/langs/' + ln + '.js');

		      sl.markDone(t.base + '/themes/' + th + '/langs/' + ln + '.js');
		      sl.markDone(t.base + '/themes/' + th + '/langs/' + ln + '_dlg.js');

		      tinymce.each(pl.split(','), function(n) {
			      if (n && n.charAt(0) != '-') {
				      sl.markDone(t.base + '/plugins/' + n + '/langs/' + ln + '.js');
				      sl.markDone(t.base + '/plugins/' + n + '/langs/' + ln + '_dlg.js');
			      }
		      });
	      },

	      load_ext : function(url,lang) {
		      var sl = tinymce.ScriptLoader;

		      sl.markDone(url + '/langs/' + lang + '.js');
		      sl.markDone(url + '/langs/' + lang + '_dlg.js');
	      }
      };
      
      var subBtn = document.getElementById("submit");
	   if (subBtn != null) {
	      subBtn.onclick=function() {
	         var inst = tinyMCE.getInstanceById("comment");
	         document.getElementById("comment").value = inst.getContent();
	         document.getElementById("commentform").submit();
	         return false;
	      }
	   }
	   tinyMCEPreInit.go();
      tinyMCE.init(tinyMCEPreInit.mceInit);
      /* ]]> */
      </script>
      
	<?php
}

function mcecomment_init() {
	global $post;
	$loadJS = false;
	if (is_plugin_page()) {
	   $loadJS = true;
	} else if (is_singular()) {
	   if (comments_open() && ( !get_option('comment_registration') || is_user_logged_in() )) {	
	      $loadJS = true;
	   }
	}
	if ($loadJS)
	   mcecomment_getInitJS();
}

function mcecomment_isGreaterThan($ver) {
	global $wp_version;

	//Cater WP_Security
	if ($wp_version == 'abc') return true;
	list($Cmajor, $Cminor, $Crev) = explode('.', $ver);
	list($major, $minor, $rev) = explode('.', $wp_version);
	if ($major < $Cmajor) return false;
	if ($minor < $Cminor) return false;
	
	return true;
}

function mcecomment_admin_init() {
   register_setting('mceComments', 'mcecomment_options');
}

function mcecomment_admin_page_init() {
   global $mce_locale;
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', AWK_PLUGIN_URL . '/js/custom_uploader.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
   wp_enqueue_script('tiny_mce', AWK_PLUGIN_URL . '/tiny_MCE/tiny_mce.js', false, '20081129');
	//wp_enqueue_script('tiny_mce_lang', get_option('siteurl') . '/wp-includes/js/tinymce/langs/wp-langs-' . $mce_locale . '.js', false, '20081129');
	mcecomment_getInitJS();
}

function mcecomment_loadCoreJS() {
   global $post, $mce_locale;
   if (is_singular()) {
   add_action('wp_footer','mce_comment_form');
	   if (comments_open() && ( !get_option('comment_registration') || is_user_logged_in() )) {
	   $mcecomment_options = get_option('mcecomment_options');
	   if ($mcecomment_options['comment'] == "1" ) {
	      wp_enqueue_script('tiny_mce', AMCEURL . 'tiny_mce.js', false, '20081129');
//		  wp_enqueue_script('vk_easy', AMCEURL . 'plugins/Jsvk/jscripts/vk_loader.js', false, '20081129');
//	      wp_enqueue_script('tiny_mce_lang', get_option('siteurl') . '/wp-includes/js/tinymce/langs/wp-langs-' . $mce_locale . '.js', false, '20081129');
	      wp_deregister_script('comment-reply');
	      wp_enqueue_script( 'comment-reply', get_option('siteurl') . '/wp-content/plugins/' . plugin_basename ( dirname ( __FILE__ ) ) . "/js/comment-reply.dev.js", false, '20090102'); }
	   } else{
	   }
	} else {
add_action('wp_footer','mce_footer');
add_action('login_form','mce_footer');
	}
}
$mcecomment_options = get_option('mcecomment_options');
//$mcecomment_display = ($mcecomment_options['comment'] ? 'true' : 'false');
if ($mcecomment_options['comment'] == "1" ) {
add_action('wp_footer', 'mcecomment_init');
}
if ($mcecomment_options['aod'] == "1" ) {
include (AWK_PLUGIN_PATH.'/aod.php');
}
add_action('template_redirect', 'mcecomment_loadCoreJS');

add_action('admin_menu', 'mcecomment_adminpages');
add_action('admin_init', 'mcecomment_admin_init');
//add_option('mcecomment_options', '', 'TinyMCE Comments');
?>

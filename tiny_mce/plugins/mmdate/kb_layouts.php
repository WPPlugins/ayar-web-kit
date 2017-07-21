<?php
/**
 * @package TinyMCE
 * @author Moxiecode
 * @copyright Copyright © 2005-2006, Moxiecode Systems AB, All rights reserved.
 */

/** @ignore */
require_once('../../../../../../wp-load.php');
$url=AMCEURL;
header('Content-Type: text/html; charset=' . get_bloginfo('charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<title><?php _e('Myanmar Keyboard Layouts') ?></title>
	<script type="text/javascript" src="<?php echo $url; ?>utils/tiny_mce_popup.js"></script>
<?php
wp_admin_css( 'global', true );
wp_admin_css( 'wp-admin', true );
?>
<style type="text/css">
	#wphead {
		font-size: 80%;
		border-top: 0;
		color: #555;
		background-color: #f1f1f1;
	}
	#wphead h1 {
		font-size: 24px;
		color: #555;
		margin: 0;
		padding: 10px;
	}
	#tabs {
		padding: 15px 15px 3px;
		background-color: #f1f1f1;
		border-bottom: 1px solid #dfdfdf;
	}
	#tabs li {
		display: inline;
	}
	#tabs a.current {
		background-color: #fff;
		border-color: #dfdfdf;
		border-bottom-color: #fff;
		color: #d54e21;
	}
	#tabs a {
		color: #2583AD;
		padding: 6px;
		border-width: 1px 1px 0;
		border-style: solid solid none;
		border-color: #f1f1f1;
		text-decoration: none;
	}
	#tabs a:hover {
		color: #d54e21;
	}
	.wrap h2 {
		border-bottom-color: #dfdfdf;
		color: #555;
		margin: 5px 0;
		padding: 0;
		font-size: 18px;
	}
	#user_info {
		right: 5%;
		top: 5px;
	}
	h3 {
		font-size: 1.1em;
		margin-top: 10px;
		margin-bottom: 0px;
	}
	#flipper {
		margin: 0;
		padding: 5px 20px 10px;
		background-color: #fff;
		border-left: 1px solid #dfdfdf;
		border-bottom: 1px solid #dfdfdf;
	}
	* html {
        overflow-x: hidden;
        overflow-y: scroll;
    }
	#flipper div p {
		margin-top: 0.4em;
		margin-bottom: 0.8em;
		text-align: justify;
	}
	th {
		text-align: center;
	}
	.top th {
		text-decoration: underline;
	}
	.top .key {
		text-align: center;
		width: 5em;
	}
	.top .action {
		text-align: left;
	}
	.align {
		border-left: 3px double #333;
		border-right: 3px double #333;
	}
	.keys {
		margin-bottom: 15px;
	}
	.keys p {
		display: inline-block;
		margin: 0px;
		padding: 0px;
	}
	.keys .left { text-align: left; }
	.keys .center { text-align: center; }
	.keys .right { text-align: right; }
	td b {
		font-family: "Times New Roman" Times serif;
	}
	#buttoncontainer {
		text-align: center;
		margin-bottom: 20px;
	}
	#buttoncontainer a, #buttoncontainer a:hover {
		border-bottom: 0px;
	}
</style>
<?php if ( is_rtl() ) : ?>
<style type="text/css">
	#wphead, #tabs {
		padding-left: auto;
		padding-right: 15px;
	}
	#flipper {
		margin: 5px 0 3px 10px;
	}
	.keys .left, .top, .action { text-align: right; }
	.keys .right { text-align: left; }
	td b { font-family: Tahoma, "Times New Roman", Times, serif }
</style>
<?php endif; ?>
<script type="text/javascript">
	function d(id) { return document.getElementById(id); }

	function flipTab(n) {
		for (i=1;i<=6;i++) {
			c = d('content'+i.toString());
			t = d('tab'+i.toString());
			if ( n == i ) {
				c.className = '';
				t.className = 'current';
			} else {
				c.className = 'hidden';
				t.className = '';
			}
		}
	}

    function init() {
        document.getElementById('version').innerHTML = tinymce.majorVersion + "." + tinymce.minorVersion;
        document.getElementById('date').innerHTML = tinymce.releaseDate;
    }
    tinyMCEPopup.onInit.add(init);
</script>
</head>
<body>
<ul id="tabs">
	<li><a id="tab1" href="javascript:flipTab(1)" title="<?php _e('Ayar Burmese') ?>" accesskey="1" tabindex="1" class="current"><?php _e('Ayar Burmese') ?></a></li>
	<li><a id="tab2" href="javascript:flipTab(2)" title="<?php _e('Ayar Shan') ?>" accesskey="2" tabindex="2"><?php _e('Ayar Shan') ?></a></li>
	<li><a id="tab3" href="javascript:flipTab(3)" title="<?php _e('Ayar Mon') ?>" accesskey="3" tabindex="3"><?php _e('Ayar Mon') ?></a></li>
	<li><a id="tab4" href="javascript:flipTab(4)" title="<?php _e('Ayar Karen') ?>" accesskey="4" tabindex="4"><?php _e('Ayar Karen') ?></a></li>
	<li><a id="tab5" href="javascript:flipTab(5)" title="<?php _e('Ayar Karenni') ?>" accesskey="5" tabindex="5"><?php _e('Ayar Karenni') ?></a></li>
	<li><a id="tab6" href="javascript:flipTab(6)" title="<?php _e('Ayar Zawgyi') ?>" accesskey="6" tabindex="6"><?php _e('Ayar Zawgyi') ?></a></li>
</ul>

<div id="flipper" class="wrap">

<div id="content1">
	<div align="center">
<img src="../../../images/ayarkb.gif" alt="Keyboard Layout" name="burmese" title="ဗမာစာ လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
</div>

<div id="content2" class="hidden">
	<div align="center">
<img src="../../../images/shan.gif" alt="Keyboard Layout" name="shan" title="ရှမ်း ​လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
</div>

<div id="content3" class="hidden">
	<div align="center">
<img src="../../../images/mon.gif" alt="Keyboard Layout" name="mon" title="မွန် လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
</div>
</div>
<div id="content4" class="hidden">
	<div align="center">
<img src="../../../images/karen.gif" alt="Keyboard Layout" name="karen" title="ကရင် ​လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
</div>
<div id="content5" class="hidden">
	<div align="center">
<img src="../../../images/karenni.gif" alt="Keyboard Layout" name="karenni" title="ကရင်နီ/ကယား လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
</div>
<div id="content6" class="hidden">
	<div align="center">
<img src="../../../images/zawgyi.gif" alt="Keyboard Layout" name="zawgyi" title="ေဇာ်ဂျီ ​လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
</div>

</div>
</body>
</html>

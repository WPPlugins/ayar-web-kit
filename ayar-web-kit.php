<?php
/*
Plugin Name: Ayar Web Kit
Plugin URI: http://myanmapress.com/2011/02/27/ayar-web-kit/
Description: Ayar Web Kit, Combination of ayar-unicode converter, ayar admin theme, Ayar TinyMCE with Virtual Keyboard and Burmese DateTime <a href="http://www.myanmapress.com/">Documentation</a>.
Author: Sithu Thwin
Author URI: http://www.http://www.myanmapress.com/
Version: 1.0_beta_8
*/
if(defined('AWK_VERSION')) return;
define('AWK_VERSION', '1.0_beta_8');
define('AWK_PLUGIN_PATH', dirname(__FILE__));
define('AWK_PLUGIN_FOLDER', basename(AWK_PLUGIN_PATH));

if(defined('WP_ADMIN') && defined('FORCE_SSL_ADMIN') && FORCE_SSL_ADMIN){
    define('AWK_PLUGIN_URL', rtrim(str_replace('http://','https://',get_option('siteurl')),'/') . '/'. PLUGINDIR . '/' . basename(dirname(__FILE__)) );
}else{
    define('AWK_PLUGIN_URL', rtrim(get_option('siteurl'),'/') . '/'. PLUGINDIR . '/' . basename(dirname(__FILE__)) );
}

/*Language loader*/
if (function_exists('load_plugin_textdomain')) {
        load_plugin_textdomain( 'awk', false, AWK_PLUGIN_FOLDER . '/languages');
}

include (AWK_PLUGIN_PATH.'/akey.php');
include (AWK_PLUGIN_PATH.'/ayar-admin-theme.php');
include (AWK_PLUGIN_PATH.'/a2z.php');
?>
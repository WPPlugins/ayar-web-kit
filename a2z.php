<?php
// Converts Latin digits to Burmese ones
if(!function_exists('latin_2_burmese')){
function latin_2_burmese($number) {
  $latin = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'); 
  $burmese = array('​၀', '​၁', '​၂', '​၃', '​၄', '​၅', '​၆', '​၇', '​၈', '​၉');
  return str_replace($latin, $burmese, $number);
}
}
if (get_bloginfo('language') == 'my-MM' ){
foreach ( array('number_format_i18n','date_i18n','mysql2date','date_format','the_date','the_date_xml','current_time','get_date_from_gmt','get_the_time','iso8601_to_datetime','forum_date_format','comments_number','date') as $filters ) {
	add_filter( $filters, 'latin_2_burmese',$number );
}
}
function get_mmcalendar($initial = true, $echo = true) {
	global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

	$cache = array();
	$key = md5( $m . $monthnum . $year );
	if ( $cache = wp_cache_get( 'get_mmcalendar', 'calendar' ) ) {
		if ( is_array($cache) && isset( $cache[ $key ] ) ) {
			if ( $echo ) {
				echo $cache[$key];
				return;
			} else {
				return $cache[$key];
			}
		}
	}

	if ( !is_array($cache) )
		$cache = array();

	// Quick check. If we have no posts at all, abort!
	if ( !$posts ) {
		$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 1");
		if ( !$gotsome ) {
			$cache[ $key ] = '';
			wp_cache_set( 'get_mmcalendar', $cache, 'calendar' );
			return;
		}
	}

	if ( isset($_GET['w']) )
		$w = ''.intval($_GET['w']);

	// week_begins = 0 stands for Sunday
	$week_begins = intval(get_option('start_of_week'));

	// Let's figure out when we are
	if ( !empty($monthnum) && !empty($year) ) {
		$thismonth = ''.zeroise(intval($monthnum), 2);
		$thisyear = ''.intval($year);
	} elseif ( !empty($w) ) {
		// We need to get the month from MySQL
		$thisyear = ''.intval(substr($m, 0, 4));
		$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
		$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('${thisyear}0101', INTERVAL $d DAY) ), '%m')");
	} elseif ( !empty($m) ) {
		$thisyear = ''.intval(substr($m, 0, 4));
		if ( strlen($m) < 6 )
				$thismonth = '01';
		else
				$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
	} else {
		$thisyear = gmdate('Y', current_time('timestamp'));
		$thismonth = gmdate('m', current_time('timestamp'));
	}

	$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);

	// Get the next and previous month and year with at least one post
	$previous = $wpdb->get_row("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '$thisyear-$thismonth-01'
		AND post_type = 'post' AND post_status = 'publish'
			ORDER BY post_date DESC
			LIMIT 1");
	$next = $wpdb->get_row("SELECT	DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date >	'$thisyear-$thismonth-01'
		AND MONTH( post_date ) != MONTH( '$thisyear-$thismonth-01' )
		AND post_type = 'post' AND post_status = 'publish'
			ORDER	BY post_date ASC
			LIMIT 1");

	/* translators: Calendar caption: 1: month name, 2: 4-digit year */
	$calendar_caption = _x('%1$s %2$s', 'calendar caption');
	 if (get_bloginfo('language') == 'my-MM' ){	
	$calendar_output = '<table id="wp-calendar" summary="' . esc_attr__('Calendar') . '">
	<caption><script type="text/javascript">document.write("'. sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) .'".convertDigit());</script></caption>
	<thead>
	<tr>';} else {
	$calendar_output = '<table id="wp-calendar" summary="' . esc_attr__('Calendar') . '">
	<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . '</caption>
	<thead>
	<tr>';
	}

	$myweek = array();

	for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
		$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
	}

	foreach ( $myweek as $wd => $img) {
		$day_name = (true == $initial) ?  $wp_locale->get_weekday_initial($img) : $wp_locale->get_weekday_abbrev($img);
		$wd = esc_attr($wd);
		$url = AWK_PLUGIN_URL;
		$myweek[$i] = $wd;
		$wdimg = (($week_begins+$wd)%7);
		$i++;
		$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$img\" id=\"$wdimg-day\" class=\"$wdimg-day\" width=\"25px;\" height=\"25px;\"><img src=\"$url/images/$wdimg.png\" alt=\"$img\"></th>";

	}

	$calendar_output .= '
	</tr>
	</thead>

	<tfoot>
	<tr>';

	if ( $previous ) {
		$calendar_output .= "\n\t\t".'<td colspan="4" id="prev"><a href="' . get_month_link($previous->year, $previous->month) . '" title="' . sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($previous->month), date('Y', mktime(0, 0 , 0, $previous->month, 1, $previous->year))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="4" id="prev" class="pad">&nbsp;</td>';
	}

	$calendar_output .= "\n\t\t".'<td class="pad">&nbsp;</td>';

	if ( $next ) {
		$calendar_output .= "\n\t\t".'<td colspan="4" id="next"><a href="' . get_month_link($next->year, $next->month) . '" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($next->month), date('Y', mktime(0, 0 , 0, $next->month, 1, $next->year))) ) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' &raquo;</a></td>';
	} else {
		$calendar_output .= "\n\t\t".'<td colspan="4" id="next" class="pad">&nbsp;</td>';
	}

	$calendar_output .= '
	</tr>
	</tfoot>

	<tbody>
	<tr>';

	// Get days with posts
	$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(post_date)
		FROM $wpdb->posts WHERE MONTH(post_date) = '$thismonth'
		AND YEAR(post_date) = '$thisyear'
		AND post_type = 'post' AND post_status = 'publish'
		AND post_date < '" . current_time('mysql') . '\'', ARRAY_N);
	if ( $dayswithposts ) {
		foreach ( (array) $dayswithposts as $daywith ) {
			$daywithpost[] = $daywith[0];
		}
	} else {
		$daywithpost = array();
	}

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
		$ak_title_separator = "\n";
	else
		$ak_title_separator = ', ';

	$ak_titles_for_day = array();
	$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(post_date) as dom "
		."FROM $wpdb->posts "
		."WHERE YEAR(post_date) = '$thisyear' "
		."AND MONTH(post_date) = '$thismonth' "
		."AND post_date < '".current_time('mysql')."' "
		."AND post_type = 'post' AND post_status = 'publish'"
	);
	if ( $ak_post_titles ) {
		foreach ( (array) $ak_post_titles as $ak_post_title ) {

				$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );

				if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
					$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
				if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
					$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
				else
					$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
		}
	}


	// See how much we should pad in the beginning
	$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
	if ( 0 != $pad )
		$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

	$daysinmonth = intval(date('t', $unixmonth));
	for ( $day = 1; $day <= $daysinmonth; ++$day ) {
		if ( isset($newrow) && $newrow )
			$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
		$newrow = false;
$wd = calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)));
if ($wd=='0')
$wdn='sun';
if ($wd=='1')
$wdn='mon';
if ($wd=='2')
$wdn='tues';
if ($wd=='3')
$wdn='wed';
if ($wd=='4')
$wdn='thurs';
if ($wd=='5')
$wdn='fri';
if ($wd=='6')
$wdn='sat';
		if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
			$calendar_output .= '<td id="today">';
		else
			$calendar_output .= "<td class=\"$wdn\">";

		if ( in_array($day, $daywithpost) ) // any posts today?
				if (get_bloginfo('language') == 'my-MM' ){	$calendar_output .= '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"" . esc_attr($ak_titles_for_day[$day]) . "\"><script type='text/javascript'>document.write('$day'.convertDigit());</script></a>";
				}else {$calendar_output .= '<a href="' . get_day_link($thisyear, $thismonth, $day) . "\" title=\"" . esc_attr($ak_titles_for_day[$day]) . "\">$day</a>";}
		else if (get_bloginfo('language') == 'my-MM' ){	
		$calendar_output .= '<script type="text/javascript">document.write("';
			$calendar_output .= $day;
			$calendar_output .= '".convertDate());</script>';
			} else {
		$calendar_output .= $day;	
		}
		$calendar_output .= '</td>';

		if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
			$newrow = true;
	}

	$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
	if ( $pad != 0 && $pad != 7 )
		$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

	$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

	$cache[ $key ] = $calendar_output;
	wp_cache_set( 'get_mmcalendar', $cache, 'calendar' );

	if ( $echo )
		echo $calendar_output;
	else
		return $calendar_output;

}
add_filter('get_calendar','get_mmcalendar');
function AWK_head() {
?>
<LINK rel="stylesheet" type="text/css" href="<?php echo AWK_PLUGIN_URL; ?>/ayar-style.css" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" type="image/x-icon" />
<style type='text/css'>
#body{
<?php 
date_default_timezone_set('Asia/Rangoon');//here set your timezone;
$url = AWK_PLUGIN_URL;
$img = date(l);
echo "background: url('$url/images/$img.png');";
?>
    }
#wd{
<?php 
$img = date(N);
if(($img == '7') || ($img == '6')){
echo "color:red;";}
else {
echo "color:#fff;";
}
?>
}
#wp-calendar tbody{font-size:12px !important; background:url(<?php echo AWK_PLUGIN_URL; ?>/images/shadow.png) repeat !important;}
#wp-calendar tbody td{color:#777;font-weight:bold;background:url(<?php echo AWK_PLUGIN_URL; ?>/images/tdshadow.png) repeat !important;margin:1px !important;}
#wp-calendar tbody td.sun{color:#fff;background:url(<?php echo AWK_PLUGIN_URL; ?>/images/sunbk.png) repeat !important;}
#wp-calendar tbody td.sat{color:#fff;background:url(<?php echo AWK_PLUGIN_URL; ?>/images/satbk.png) repeat !important;}
#wp-calendar caption {background:url(<?php echo AWK_PLUGIN_URL; ?>/images/shadow.png) repeat !important;}
	/*this is end of burmese css from AWK*/
	</style>
<!--[if IE]>
<style type='text/css'>
a{ font-family:Ayar,AyarJuno,AyarTakhu, AyarWazo, Tahoma, Arial, Helvetica, serif; text-rendering: optimizeLegibility;}
#adminmenu .wp-submenu a{font:normal 11px/18px Ayar,AyarJuno,AyarTakhu, AyarWazo, Tahoma, Arial, Helvetica, serif; text-rendering: optimizeLegibility;}
#adminmenu a.menu-top,#adminmenu .wp-submenu-head{font:normal 13px/18px Ayar,AyarJuno,AyarTakhu, AyarWazo, Tahoma, Arial, Helvetica, serif; text-rendering: optimizeLegibility;}
#footer,#footer a{font-family:Ayar,Ayar Juno,Ayar Takhu, AyarWazo, Tahoma, Arial, Helvetica, serif; text-rendering: optimizeLegibility;}
p.help,p.description,span.description,.form-wrap p{font-family:Ayar,AyarJuno,AyarTakhu, AyarWazo, Tahoma, Arial, Helvetica, serif; text-rendering: optimizeLegibility;}
#utc-time,#local-time{font-family:Ayar,AyarJuno,AyarTakhu, AyarWazo, Tahoma, Arial, Helvetica, serif; text-rendering: optimizeLegibility;}
</style>
<script type="text/javascript" src="<?php echo AWK_PLUGIN_URL; ?>/js/zgayar.mini.js"></script>
<script type="text/javascript" src="<?php echo AWK_PLUGIN_URL; ?>/js/ayarzg.mini.js"></script>
<![endif]-->

<script src="<?php echo AWK_PLUGIN_URL; ?>/js/burmese.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript">
//Original code from saturngod
//modified by Sithu Thwin
/*
	This script from http://www.quirksmode.org/js/detect.html
	Add iPad and Android by saturngod ( http://www.saturngod.net )
*/

var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [
	 {
			   string: navigator.userAgent,
			   subString: "Android",
			   identity: "Android"
	    },
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
	    {
			   string: navigator.userAgent,
			   subString: "iPad",
			   identity: "iPad"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();

if(BrowserDetect.browser=="Opera" || BrowserDetect.browser=="Explorer")
{
document.write('<scr'+'ipt type="text/javascript" src="'+'<?php echo AWK_PLUGIN_URL; ?>'+'/js/zgayar.js"></scr'+'ipt>');
document.write('<scr'+'ipt type="text/javascript" src="'+'<?php echo AWK_PLUGIN_URL; ?>'+'/js/ayarzg.js"></scr'+'ipt>');
}
if(BrowserDetect.browser=="Firefox")
{
document.write('<scr'+'ipt type="text/javascript" src="'+'<?php echo AWK_PLUGIN_URL; ?>'+'/js/zgayar.mini.js"></scr'+'ipt>');
document.write('<scr'+'ipt type="text/javascript" src="'+'<?php echo AWK_PLUGIN_URL; ?>'+'/js/ayarzg.mini.js"></scr'+'ipt>');
}
	
</script>
<script type="text/javascript">
original_content_font = 'ayar';
display_content_font = 'ayar';
function init() {
// quit if this function has already been called
if (arguments.callee.done) return;

// flag this function so we don't do the same thing twice
arguments.callee.done = true;

if (original_content_font == 'zawgyi-one'){
ToA();
}
else if (original_content_font == 'ayar'){
ToZ();
}
if (display_content_font == 'zawgyi-one'){
ToZ();
}
else if (display_content_font == 'ayar'){
ToA();
}
};

/* for Mozilla/Opera9 */
if (document.addEventListener) {
  document.addEventListener("DOMContentLoaded", init, false);
}

/* for Internet Explorer */
/*@cc_on @*/
/*@if (@_win32)
  document.write("<script id=__ie_onload defer src=javascript:void(0)><\/script>");
  var script = document.getElementById("__ie_onload");
  script.onreadystatechange = function() {
    if (this.readyState == "complete") {
      init(); // call the onload handler
    }
  };
/*@end @*/

/* for Safari */
if (/WebKit/i.test(navigator.userAgent)) { // sniff
  var _timer = setInterval(function() {
    if (/loaded|complete/.test(document.readyState)) {
      init(); // call the onload handler
    }
  }, 10);
}

/* for other browsers */
window.onload = init;
</script>


<script>
function stoperror(){
return true
}
window.onerror=stoperror;
</script>

<?php
}
add_action('wp_head', 'AWK_head');
add_action('admin_head', 'AWK_head');
add_action('login_head', 'AWK_head');
add_action('register_head', 'AWK_head');

 function AWK_footer() {
?>
<!-- /*AWK footer*/ -->

<div class="otf">
<a id="A" class="selected" href="javascript:" onclick="if 
(this.className=='selected')return;toA();this.className='selected';document.getElementById('Z').className=''">
AYAR FONT</a>
</div>
<div class="otf" style="right: 0px;">
<a id="Z" href="javascript:" onclick="if 
(this.className=='selected')return;toZ();this.className='selected';document.getElementById('A').className=''">

ZAWGYI FONT</a>
</div>
<?php
}
add_action('wp_footer', 'AWK_footer');
add_action('login_form', 'AWK_footer');
add_action('register_form', 'AWK_footer');
add_action('retrieve_password', 'AWK_footer');
add_action('password_reset', 'AWK_footer');
add_action('lostpassword_form', 'AWK_footer');
add_action('admin_footer', 'AWK_footer');

function mon_calendar() {  ?>
<div style="padding:0px;text-align:justify;" id="body"><div id="imgBackground">
<script type="text/javascript" src="<?php echo AWK_PLUGIN_URL; ?>/js/moncal.js"></script>
</div></div>
 <?php } 
function widget_mon_calendar($args) {
	extract($args); 
	echo $before_widget;
			echo $args['before_title'];
	_e('Mon Calendar','AWK');
			echo $args['after_title'];
	mon_calendar();
	echo $after_widget; 
}
register_sidebar_widget(__('Mon Calendar','AWK'), 'widget_mon_calendar');
function burmese_calendar() {  ?>
<div style="padding:0px;align:center;" id="body"><div id="imgBackground">
<script type="text/javascript" src="<?php echo AWK_PLUGIN_URL; ?>/js/mmcal.js"></script>
</div></div>
 <?php } 
function widget_burmese_calendar($args) {
	extract($args); 
	echo $before_widget;
			echo $args['before_title'];
	_e('Burmese Calendar','AWK');
			echo $args['after_title'];
	burmese_calendar();
	echo $after_widget; 
}
register_sidebar_widget(__('Burmese Calendar','AWK'), 'widget_burmese_calendar');
function ayar_admin(){
	global $wp_styles;
	$handle="ayar_admin";
	$src= AWK_PLUGIN_URL.'/css/ayar_admin.css';
	wp_register_style( $handle, $src);
	wp_enqueue_style( 'ayar_admin',0);
}
function ayar_embed(){
	global $wp_styles;
	$handle="ayar_embed";
	$src= 'http://www.ayarunicodegroup.org/fonts.css';
	wp_register_style( $handle, $src);
	wp_enqueue_style( 'ayar_embed',0);
}
add_action('wp_print_styles','ayar_embed');
if (get_bloginfo('language') == 'my-MM' ){
add_action('admin_init','ayar_admin',0);
}
if (is_admin){
add_action('admin_print_styles','ayar_embed');
}
?>
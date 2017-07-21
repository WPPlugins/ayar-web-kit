<?php
function aod_scripts(){
?>
<script type="text/javascript" src="<?php echo AWK_PLUGIN_URL; ?>/js/xhr.js"></script>
<script type="text/javascript" src="<?php echo AWK_PLUGIN_URL; ?>/js/clickeffect.js"></script>
<script type="text/javascript">
siteclick_base="http://ayar.co/plugin.php?page=1&q=";
siteclick_translatable="";
siteclick_target="_blank";
siteclick_tip="";
</script>
<?php }
add_action('wp_footer','aod_scripts');
add_action('admin_footer', 'aod_scripts');
?>
<?php

function mcecomment_optionpage() {
	global $mcecomment_nonce, $wp_version;
	
	$mcecomment_options = get_option('mcecomment_options');
	
	if ( isset($_POST['submit']) ) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') )
			die(__('Cheatin&#8217; uh?'));

      if (!function_exists('settings_fields')) {
		   check_admin_referer($mcecomment_nonce);
      } else {
         check_admin_referer('mceComments-options');
      }
      
      if (isset($mcecomment_options['language']))
   		unset($mcecomment_options['language']);
			
		$mcecomment_options['rtl'] = (isset($_POST['mcecomment_rtl']) ? '1' : '0');
		$mcecomment_options['viewhtml'] = (isset($_POST['mcecomment_viewhtml']) ? '1' : '0');
		$mcecomment_options['resize'] = (isset($_POST['mcecomment_resize']) ? '1' : '0');
		$mcecomment_options['comment'] = (isset($_POST['mcecomment_comment']) ? '1' : '0');
		$mcecomment_options['aod'] = (isset($_POST['mcecomment_aod']) ? '1' : '0');
      $mcecomment_options['skin'] = (isset($_POST['mcecomment_skin']) ? $_POST['mcecomment_skin'] : 'default');
      
		if (isset($_POST['mcecomment_buttons'])) {
			$buttons = trim($_POST['mcecomment_buttons']);
			if ($buttons[strlen($buttons)-1] == ',') {
				$buttons = substr($buttons, 0, -1);
			}
			$mcecomment_options['buttons'] = $buttons;
		}
		if (isset($_POST['mcecomment_buttons_2'])) {
			$buttons = trim($_POST['mcecomment_buttons_2']);
			if ($buttons[strlen($buttons)-1] == ',') {
				$buttons = substr($buttons, 0, -1);
			}
			$mcecomment_options['buttons_2'] = $buttons;
		}

		if (isset($_POST['mcecomment_plugins'])) {
			$plugins = trim($_POST['mcecomment_plugins']);
			if ($plugins[strlen($plugins)-1] == ',') {
				$plugins = substr($plugins, 0, -1);
			}
			$mcecomment_options['plugins'] = $plugins;
		}

		if (isset($_POST['mcecomment_css']))
			$mcecomment_options['css'] = trim($_POST['mcecomment_css']);
		if (isset($_POST['mcecomment_hlogo']))
			$mcecomment_options['hlogo'] = trim($_POST['mcecomment_hlogo']);
		if (isset($_POST['mcecomment_hlogo_w']))
			$mcecomment_options['hlogo_w'] = trim($_POST['mcecomment_hlogo_w']);
		if (isset($_POST['mcecomment_hlogo_h']))
			$mcecomment_options['hlogo_h'] = trim($_POST['mcecomment_hlogo_h']);
	
		update_option('mcecomment_options', $mcecomment_options);
	}
	 
	mcecomment_init();
?>

<?php if ( !empty($_POST ) ) : 
?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
<?php endif; ?>

<div class="wrap">
<h2>Ayar Web Kit Options</h2>

<form method="post">
<?php 
if ( !function_exists('settings_fields') ) {
   wp_nonce_field($action);
} else {
	settings_fields('mceComments');
}
?>
<h3>Interface</h3> 
<script type="text/javascript">
//<![CDATA[
function inserttext(obj_out,obj_in) {
	obj = document.getElementById(obj_out);
	obj.value += ((obj.value != '') ? ',' : '') + (obj_in).innerHTML;
}
//]]>
</script>
<table width="100%" cellspacing="2" cellpadding="5" class="form-table">

<tr class="form-field">
<p><input name="mcecomment_comment" type="checkbox" id="mcecomment_comment" value="1" <?php echo ($mcecomment_options['comment'] ? 'checked="checked"':''); ?>/>
<label for="mcecomment_comment">Enable tinyMCE Editor in comment form (Should disable for some Theme's compatibality)</label></p>
<p><input name="mcecomment_aod" type="checkbox" id="mcecomment_aod" value="1" <?php echo ($mcecomment_options['aod'] ? 'checked="checked"':''); ?>/>
<label for="mcecomment_aod">Enable Ayar Online Editor</label></p>
<p><input name="mcecomment_rtl" type="checkbox" id="mcecomment_rtl" value="1" <?php echo ($mcecomment_options['rtl'] ? 'checked="checked"':''); ?>/>
<label for="mcecomment_rtl">Enable right-to-left (RTL) editing mode in comment field</label></p>
<p><input name="mcecomment_viewhtml" type="checkbox" id="mcecomment_viewhtml" value="1" <?php echo ($mcecomment_options['viewhtml'] ? 'checked="checked"':''); ?>  />
<label for="mcecomment_viewhtml">Enable HTML source editing of the comment field</label></p>
<p><input name="mcecomment_resize" type="checkbox" id="mcecomment_resize" value="1" <?php echo ($mcecomment_options['resize'] ? 'checked="checked"':''); ?>  />
<label for="mcecomment_resize">Enable vertical resizing of the comment field writing area</label></p>
</tr>
<tr class="form-field"> 
<th>Skin:</th><td>
<p><select name="mcecomment_skin" id="mcecomment_skin">
   <?php
      $skins = mcecomment_getskins();
      for ($i=0; $i<count($skins); $i++) {
         if ($skins[$i] == $mcecomment_options['skin'])
            echo "<option value=\"$skins[$i]\" selected=\"selected\">$skins[$i]</option>";
         else
            echo "<option value=\"$skins[$i]\">$skins[$i]</option>";
      }
   ?>
 </select></p>
 </td></tr>
</table>

<h3>Advance Options</h3> 
<table width="100%" cellspacing="2" cellpadding="5" class="form-table"> 
<tr class="form-field">
<th>Admin Header Logo Url:</th>
<td><input id="mcecomment_hlogo" class="uploadfield" type="text" size="90" name="mcecomment_hlogo" value="<?php echo $mcecomment_options['hlogo']; ?>" />
				<div class="upload_buttons">
					<input class="upload_image_button" type="button" value="Upload Image" style="width:100px;" />
				</div>
Fully qualified URL required (leave blank to use default). Upload your logo image from your computer. Copy and paste your image link.
</td>
</tr>
<tr class="form-field">
<th>Admin Header Logo Width:</th>
<td><input name="mcecomment_hlogo_w" type="text" id="mcecomment_hlogo_w" value="<?php echo $mcecomment_options['hlogo_w']; ?>" style="width:50px" /> px ( Your Header Logo Width. Only value. No need to add px.)
</td>
</tr>
<tr class="form-field">
<th>Admin Header Logo Height:</th>
<td><input name="mcecomment_hlogo_h" type="text" id="mcecomment_hlogo_h" value="<?php echo $mcecomment_options['hlogo_h']; ?>" style="width:50px" /> px ( Your Header Logo Height. Only value. No need to add px. )
</td>
</tr>
<tr class="form-field">
<th>Buttons in use:</th>
<td><input name="mcecomment_buttons" type="text" id="mcecomment_buttons" value="<?php echo $mcecomment_options['buttons']; ?>" style="width:98%" /><br />
(separated with commas)<br /> 
Available buttons: 
<?php $pls = array('separator','Jsvk','mmdate','mmyear','mmendate','mmentime','insertmmtime','insertmedate','keyboardico','bold','italic','underline','strikethrough','justifyleft','justifycenter','justifyright','justifyfull','bullist','numlist','outdent','indent','cut','copy','paste','undo','redo','link','unlink','cleanup','help','code','hr','removeformat','sub','sup','forecolor','backcolor','charmap','visualaid','blockquote','spellchecker','fullscreen','wp_gallerybtns');
for ($i=0; $i<count($pls); $i++) {
echo '<span style="cursor: pointer; text-decoration: underline;" onclick="inserttext(\'mcecomment_buttons\', this);">'.$pls[$i].'</span>  '; 
}?>
</td>
</tr>
<tr class="form-field">
<th>Buttons in use (second row):</th>
<td><input name="mcecomment_buttons_2" type="text" id="mcecomment_buttons_2" value="<?php echo $mcecomment_options['buttons_2']; ?>" style="width:98%" /><br />
(separated with commas)<br /> 
Available buttons: 
<?php $pls = array('separator','Jsvk','mmdate','mmyear','mmendate','mmentime','insertmmtime','insertmedate','keyboardico','bold','italic','underline','strikethrough','justifyleft','justifycenter','justifyright','justifyfull','bullist','numlist','outdent','indent','cut','copy','paste','undo','redo','link','unlink','cleanup','help','code','hr','removeformat','sub','sup','forecolor','backcolor','charmap','visualaid','blockquote','spellchecker','fullscreen','wp_gallerybtns');
for ($i=0; $i<count($pls); $i++) {
echo '<span style="cursor: pointer; text-decoration: underline;" onclick="inserttext(\'mcecomment_buttons_2\', this);">'.$pls[$i].'</span>  '; 
}?>
</td>
</tr><tr class="form-field"> 
<th>Plugins in use:</th>
<td><input name="mcecomment_plugins" type="text" id="mcecomment_plugins" value="<?php echo $mcecomment_options['plugins']; ?>" style="width:98%" /><br />
(separated with commas)<br /> 
Detected plugins: 
<?php $pls = mcecomment_getplugins(); 
for ($i=0; $i<count($pls); $i++) {
echo '<span style="cursor: pointer; text-decoration: underline;" onclick="inserttext(\'mcecomment_plugins\', this);">'.$pls[$i].'</span>  '; 
}?>
</td>
</tr><tr class="form-field">
<th>User defined CSS:</th>
<td><input name="mcecomment_css" type="text" id="mcecomment_css" value="<?php echo $mcecomment_options['css']; ?>" style="width:98%" /><br />
Fully qualified URL required (leave blank to use default CSS)
</td></tr>
</table>

<h3>Preview</h3> 
<table width="100%" cellspacing="2" cellpadding="5" class="form-table"> 
<tr valign="top" class="form-field"> 
<th>Preview:</th>
<td>Update options to preview how the comment textarea box will appear.<br /><textarea name="comment" id="comment" rows="5" tabindex="4" style="width:99%">This is a preview textarea</textarea>
</td></tr>
</table>

<p class="submit">
<?php if (!function_exists('settings_fields')) : ?>
   <input type="hidden" name="action" value="update" />
<?php endif; ?>
<input type="submit" name="submit" value="Update Options &raquo;" />
</p>
</form>
<div id="help_mss" name="help_mss">
<h1><?php _e('HELP','akey'); ?></h1>
<?php _e('I am not sure all plugins and button will work in comment form. If you want to add your own tinyMCE plugin to comment form, Just put your plugin folder into "tiny_mce/plugins" folder, your plugin will show in detected plugins list. If your plugin have a button, insert your button name in "buttons in use" field','akey'); ?>
</div>
</div>
<?php
}
?>

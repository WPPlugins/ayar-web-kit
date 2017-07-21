<?php include_once('../../../../../../wp-load.php');$url=includes_url();/*this is keyboard layout popups*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{#keyboard_dlg.title}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript" src="<?php echo AMCEURL; ?>tiny_mce_popup.js"></script>
	<script type="text/javascript" src="<?php echo AMCEURL; ?>utils/mctabs.js"></script>
	<script type="text/javascript" src="js/keyboard.js"></script>
	<style type="text/css">
	*{font-family:Ayar;}
	#burmese_panel{padding-bottom:110px;}
	#burmese_tab{font-family:Ayar;}
	#shan_panel{padding-bottom:110px;}
	#shan_tab{font-family:Ayar;}
	#mon_panel{padding-bottom:110px;}
	#mon_tab{font-family:Ayar;}
	#karen_panel{padding-bottom:110px;}
	#karen_tab{font-family:Ayar;}
	#karenni_panel{padding-bottom:110px;}
	#zawgyi_tab{font-family:Ayar;}
	#zawgyi_panel{padding-bottom:110px;}
	.tabs{font-family:Ayar;}
	</style>
</head>
<body>
		<div class="tabs">
			<ul>
<li id="burmese_tab" class="current"><span><a href="javascript:mcTabs.displayTab('burmese_tab','burmese_panel');" onmousedown="return false;">{#keyboard_dlg.burmese}</a></span></li>
<li id="shan_tab"><span><a href="javascript:mcTabs.displayTab('shan_tab','shan_panel');" onmousedown="return false;">{#keyboard_dlg.shan}</a></span></li>
<li id="mon_tab"><span><a href="javascript:mcTabs.displayTab('mon_tab','mon_panel');" onmousedown="return false;">{#keyboard_dlg.mon}</a></span></li>
<li id="karen_tab"><span><a href="javascript:mcTabs.displayTab('karen_tab','karen_panel');" onmousedown="return false;">{#keyboard_dlg.karen}</a></span></li>
<li id="karenni_tab"><span><a href="javascript:mcTabs.displayTab('karenni_tab','karenni_panel');" onmousedown="return false;">{#keyboard_dlg.karenni}</a></span></li>
<li id="zawgyi_tab"><span><a href="javascript:mcTabs.displayTab('zawgyi_tab','zawgyi_panel');" onmousedown="return false;">{#keyboard_dlg.zawgyi}</a></span></li>
			</ul>
		</div>
				<div class="panel_wrapper">
							<div id="burmese_panel" class="panel current">
	<div align="center">
<img src="../../../images/ayarkb.gif" alt="Keyboard Layout" name="burmese" title="ဗမာစာ လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
	</div>
								<div id="shan_panel" class="panel">
	<div align="center">
<img src="../../../images/shan.gif" alt="Keyboard Layout" name="shan" title="ရှမ်း ​လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
	</div>
								<div id="mon_panel" class="panel">
	<div align="center">
<img src="../../../images/mon.gif" alt="Keyboard Layout" name="mon" title="မွန် လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
	</div>
								<div id="karen_panel" class="panel">
	<div align="center">
<img src="../../../images/karen.gif" alt="Keyboard Layout" name="karen" title="ကရင် ​လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
	</div>
									<div id="karenni_panel" class="panel">
	<div align="center">
<img src="../../../images/karenni.gif" alt="Keyboard Layout" name="karenni" title="ကရင်နီ/ကယား လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
	</div>
<div id="zawgyi_panel" class="panel">
	<div align="center">
<img src="../../../images/zawgyi.gif" alt="Keyboard Layout" name="zawgyi" title="ေဇာ်ဂျီ ​လက်​ကွက်​ပံု​စံ" style="font-family:Ayar;">
	</div>
	</div>
	</div>
			<div class="mceActionPanel">
			<input type="button" id="cancel" name="cancel" value="{#close}" onclick="tinyMCEPopup.close();" />
		</div>
</body>
</html>

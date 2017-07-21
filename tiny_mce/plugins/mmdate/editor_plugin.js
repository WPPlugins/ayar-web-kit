(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('mmdate');
	
	tinymce.create('tinymce.plugins.mmdatePlugin', {
		init : function(ed, url) {
			var t = this;
			t.editor = ed;
			ed.addCommand('mce_mmdate', function() {
			mmtodaydate=md(mr.Myear)+" ခုနှစ် "+mr.MMonth+" "+mr.HMonth+(mr.Mday!=15?" "+md(mr.Mday)+' ရက် ':' ');
			tinyMCE.execCommand('mceInsertContent',false, mmtodaydate);
			});
			ed.addButton('mmdate',{
				title : 'mmdate.insertmmdate_desc', 
				cmd : 'mce_mmdate',
				image : url + '/img/date.gif'
			});
			ed.addCommand('mce_mmyear', function() {
			mmyear=md(mr.Myear);
			tinyMCE.execCommand('mceInsertContent',false, mmyear +' ခုနှစ် ');
			});
			ed.addButton('mmyear',{
				title : 'mmdate.insertmmyear_desc', 
				cmd : 'mce_mmyear',
				image : url + '/img/year.gif'
			});
						ed.addCommand('mce_kb', function() {
		toggleKeyboard(ed)
			});
			ed.addButton('mmkb',{
				title : 'mmdate.insertmmkb_desc', 
				cmd : 'mce_kb',
				image : url + '/img/jsvk.gif'
			});
			ed.addCommand('mceInsertmeDate', function() {
				var str = t._getDateTime(new Date(), ed.getParam("plugin_insertdate_dateFormat", ed.getLang('mmdate.date_fmt')));

				ed.execCommand('mceInsertContent', false, str);
			});

			ed.addCommand('mceInsertmmTime', function() {
				var str = t._getDateTime(new Date(), ed.getParam("plugin_insertdate_timeFormat", ed.getLang('mmdate.time_fmt')));

				ed.execCommand('mceInsertContent', false, str);
			});
			ed.addButton('insertmedate', {title : 'mmdate.insertdate_desc', cmd : 'mceInsertmeDate', image : url + '/img/dateen.gif'});			
			ed.addButton('insertmmtime', {title : 'mmdate.inserttime_desc', cmd : 'mceInsertmmTime', image : url + '/img/time.gif'});
						// Register commands
			ed.addCommand('mceKeyboard', function() {
				ed.windowManager.open({
					file : url + '/keyboard.php',
					width : 700 + parseInt(ed.getLang('mmdate.delta_width', 0)),
					height : 500 + parseInt(ed.getLang('mmdate.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url
				});
			});

			// Register buttons
			ed.addButton('keyboardico', {title : 'mmdate.keyboardlayout_desc', cmd : 'mceKeyboard',image : url + '/img/kblayout.gif'});
		},
		
		getInfo : function() {
			return {
				longname : 'On Screen Keyboard for TinyMCE',
				author : 'Sithu Thwin',
				authorurl : 'http://www.myanmapress.com',
				infourl : 'http://www.myanmapress.com/',
				version : '1.0'
			};
		},

		// Private methods

		_getDateTime : function(d, fmt) {
			var ed = this.editor;

			function addZeros(value, len) {
				value = "" + value;

				if (value.length < len) {
					for (var i=0; i<(len-value.length); i++)
						value = "0" + value;
				}

				return value;
			};

			fmt = fmt.replace("%D", "%m/%d/%y");
			fmt = fmt.replace("%r", "%I:%M:%S %p");
			fmt = fmt.replace("%Y", "" + md(d.getFullYear()));
			fmt = fmt.replace("%y", "" + md(d.getYear()));
			fmt = fmt.replace("%m", md(addZeros(d.getMonth()+1, 2)));
			fmt = fmt.replace("%d", md(addZeros(d.getDate(), 2)));
			fmt = fmt.replace("%H", "" + md(addZeros(d.getHours(), 2)));
			fmt = fmt.replace("%M", "" + md(addZeros(d.getMinutes(), 2)));
			fmt = fmt.replace("%S", "" + md(addZeros(d.getSeconds(), 2)));
			fmt = fmt.replace("%I", "" + (md((d.getHours() + 11) % 12 + 1)));
			fmt = fmt.replace("%p", "" + (d.getHours() < 12 ? "မနက်" : "မွန်းလွဲ"));
			fmt = fmt.replace("%B", "" + ed.getLang("mmdate.months_long").split(',')[d.getMonth()]);
			fmt = fmt.replace("%b", "" + ed.getLang("mmdate.months_short").split(',')[d.getMonth()]);
			fmt = fmt.replace("%A", "" + ed.getLang("mmdate.day_long").split(',')[d.getDay()]);
			fmt = fmt.replace("%a", "" + ed.getLang("mmdate.day_short").split(',')[d.getDay()]);
			fmt = fmt.replace("%%", "%");

			return fmt;
		}
	});

	// Register plugin
	tinymce.PluginManager.add('mmdate', tinymce.plugins.mmdatePlugin);
})();
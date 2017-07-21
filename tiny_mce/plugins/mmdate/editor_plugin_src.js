/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
	tinymce.create('tinymce.plugins.InsertmmDateTime', {
		init : function(ed, url) {
			var t = this;

			t.editor = ed;

			ed.addCommand('mceInsertmmDate', function() {
				var str = t._getDateTime(new Date(), ed.getParam("plugin_Insertmmdate_dateFormat", ed.getLang('Insertmmdatetime.date_fmt')));

				ed.execCommand('mceInsertmmContent', false, str);
			});

			ed.addCommand('mceInsertmmTime', function() {
				var str = t._getDateTime(new Date(), ed.getParam("plugin_Insertmmdate_timeFormat", ed.getLang('Insertmmdatetime.time_fmt')));

				ed.execCommand('mceInsertmmContent', false, str);
			});

			ed.addButton('Insertmmdate', {title : 'Insertmmdatetime.Insertmmdate_desc', cmd : 'mceInsertmmDate'});
			ed.addButton('Insertmmtime', {title : 'Insertmmdatetime.Insertmmtime_desc', cmd : 'mceInsertmmTime'});
		},

		getInfo : function() {
			return {
				longname : 'Insertmm date/time',
				author : 'Moxiecode Systems AB',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/Insertmmdatetime',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
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
			fmt = fmt.replace("%Y", "" + d.getFullYear());
			fmt = fmt.replace("%y", "" + d.getYear());
			fmt = fmt.replace("%m", addZeros(d.getMonth()+1, 2));
			fmt = fmt.replace("%d", addZeros(d.getDate(), 2));
			fmt = fmt.replace("%H", "" + addZeros(d.getHours(), 2));
			fmt = fmt.replace("%M", "" + addZeros(d.getMinutes(), 2));
			fmt = fmt.replace("%S", "" + addZeros(d.getSeconds(), 2));
			fmt = fmt.replace("%I", "" + ((d.getHours() + 11) % 12 + 1));
			fmt = fmt.replace("%p", "" + (d.getHours() < 12 ? "AM" : "PM"));
			fmt = fmt.replace("%B", "" + ed.getLang("Insertmmdatetime.months_long").split(',')[d.getMonth()]);
			fmt = fmt.replace("%b", "" + ed.getLang("Insertmmdatetime.months_short").split(',')[d.getMonth()]);
			fmt = fmt.replace("%A", "" + ed.getLang("Insertmmdatetime.day_long").split(',')[d.getDay()]);
			fmt = fmt.replace("%a", "" + ed.getLang("Insertmmdatetime.day_short").split(',')[d.getDay()]);
			fmt = fmt.replace("%%", "%");

			return fmt;
		}
	});

	// Register plugin
	tinymce.PluginManager.add('Insertmmdatetime', tinymce.plugins.InsertmmDateTime);
})();
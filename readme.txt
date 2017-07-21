=== Ayar Web Kit ===
Contributors: Sithu Thwin, Minn Kyaw ...
Plugin Name: Ayar Web Kit
Plugin URI: http://myanmapress.com/2011/02/27/ayar-web-kit/
Description: Ayar Web Kit, Combination of ayar-unicode converter, ayar admin theme, Ayar TinyMCE with Virtual Keyboard and Burmese DateTime <a href="http://myanmapress.com/2011/02/27/ayar-web-kit/">Documentation</a>.
Version: 1.0_beta_8
Author: Sithu Thwin
Author URI: http://www.mynmapress.com/
Credits:TinyMCE, Ilya Lebedev, mk_is_here, Ko Soe Min, Saturngod, Ayar Unicode Group.
Tested up to: 3.1.2


This plugin adds the buttons to burmese unicode fonts ayar to zawgyi vice versa..

== Description ==
Full version of TinyMCE Editor. Add RichText Editor to comment form, Automatic selection of Keyboard between English(US) and Burmese(Ayar). Displays a virtual, on-screen keyboard to enter the wordpress password in a safer way on login form, for example in internet cafés. Easy Typing in comment form with on-screen Keyboard. Support burmese language. No need to install Keyboard Input Method on your computer. New tinyMCE buttons for burmese date time and fonts. Every textarea and input attached with Virtual Keyboard. Combination of ayar-unicode converter, ayar admin theme, Ayar TinyMCE with Virtual Keyboard and Burmese DateTime <a href="http://myanmapress.com/2011/02/27/ayar-web-kit/">Documentation</a>.

Features list:<ul>
<li>Add TinyMCE to comment form.</li>
<li>Virtual Keyboard TinyMCE Plugin with ayar myanmar unicode support.</li>
<li>TinyMCE Plugin for localized date and time buttons.</li>
<li>TinyMCE Plugin for full date in burmese language and burmese calendar button.</li>
<li>Ayar Unicode Layouts for burmese, shan, mon, karen, kayah</li>
<li>Can type burmese, shan, mon, karen, kayah with or without installation of IME Keyboard.</li>
<li>Every typing area such as textarea, text and password input attached with Virtual Keyboard.</li>
<li>Ayar Unicode Converter</li>
<li>Burmese and Mon Calendar Widgets</li>
<li>Ayar Online Dictionary</li>
<li>New Admin Color Scheme (Green)</li>
</ul>

== Installation ==
* Just put the plug-in into your plug-in directory and activate it. After activation you can modified plugin setting on options page.
You can set tinyMCE skin for comment in MCE Comment Option.
default is recommended. (The best for all theme).
If you cannot view myanmar font in firefox, add below code into your .htaccess file.
<code>
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} "\.ttf$"
RewriteRule ^.*$ %{REQUEST_URI}.gz [L]

<FilesMatch "\.ttf.gz$">
AddEncoding gzip .gz
ForceType "text/plain"
Header set Access-Control-Allow-Origin *
</FilesMatch>
</code>

== Important Recommendation ==
You should not use this plugin together with ayar unicode converter plugin, calendar header bar image plugin, zawgyi-to-ayar-unicode converter plugin. If use, you will get Fetal Errors: Could not redeclare function...

== Change Log ==
Changes and feature additions for the Ayar Web Kit plugin:<ul>
<li>1.0_beta - Initial release.</li>
<li>1.0_beta_2 - try to solve some bug in some theme.
<ul>
<li> - known issues - twenty-ten theme do not show tinyMCE and virtual keyboard correctly in comment form.</li>
</ul>
</li>
<li>1.0_beta_3 - removed svg fonts from embeded fonts for ligatures error</li>
<li>1.0_beta_4 - change fonts for ligature errors.</li>
<li>1.0_beta_5 - 
<ul>
<li>all fonts errors are solve.</li>
<li>add options to enable or disable ayar online editor.</li>
<li>add options to add Admin Header Logo.</li>
</ul>
</li>
<li>1.0_beta_6 - correct font for embedded font errors</li>
<li>1.0_beta_7 - change font converter java.</li>
<li>1.0_beta_8 - bugs fixed and excluded fonts and css from plugin.</li>
<ul>
<li>links fonts embed css and fonts files to ayarunicodegroup.org</li>
<li>ie font converter button bug fixed</li>
<li>fixed mozilla font face errors.</li>
</ul>
</ul>
== Others Notes ==
Road Maps
- will be compatiable with other plugins I wrote and I modified and added some others plugin's code in this plugin.
- will include css editing options for font face 
- will include functionality to post from front end of the sites.

Feed back or Help
Any sugession welcome !
Anyone who want to contribute my project are Welcome ! (contact me at myanmapress.com)

== Screenshots ==
1. comment form options page.
2. the Virtual Keyboard and TinyMCE editor new buttons in post and page edit form.
3. English Calendar in burmese language.
4. Burmese Calendar Widgets.
5. comment form while user not logged in.
6. login form.
7. font converter buttons.
8. comment form with tinyMCE editor and virtual keyboard.
9. Keyboard Layout tinyMCE popup.


== Thanks ==
A lot of hard work has gone in to this plug-in, and I hope it is useful to you !<ul>
<li>Please recognise your use of the plug-in on your blog.  Maybe post an article to say how you've integrated the plug-in into your site?</li>
<li>Special thanks to ayar unicode group,  Ilya Lebedev <ilya@lebedev.net>(Virtual Keyboard plugin for TinyMCE v3 editor), mk_is_here(TinyMCEComments) and Saturngod</li>
<li>Special Thanks to Ko Soemin(soemin.net) - Cannot be done without his javascripts.</li>
<li>Ayar Unicode Group, Ayar Online Dictionary, Ayar Online Editor</li>
</ul>
== Special Notes ==
I'm not a programmer and I know nothing about PHP and Javascript. But Nothing is impossible for willing mind!!!

Enjoy!


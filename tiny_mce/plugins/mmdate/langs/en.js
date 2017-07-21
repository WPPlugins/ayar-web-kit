// EN lang variables

if (navigator.userAgent.indexOf('Mac OS') != -1) {
// Mac OS browsers use Ctrl to hit accesskeys
	var metaKey = 'Ctrl';
}
else {
	var metaKey = 'Alt';
}

tinyMCE.addI18n('en.mmdate',{
delta_width:"",
delta_height:"",
desc : 'Myanmar Date',
insertmmdate_desc:"Insert Myanmar Date",
insertdate_desc:"Insert Date",
insertmmyear_desc:"Insert Myanmar Year",
inserttime_desc:"Insert Time",
keyboard_desc:"Keyboard",
date_fmt:"%Y-ခုနှစ်၊ %Bလ၊ %d-ရက်၊ %Aေန့ ",
time_fmt:"%p %I နာရီ : %M မိနစ် : %S စက္ကန့် ",
months_long:"ဇန်နဝါရီ,ေဖေဖာ်ဝါရီ,မတ်,ဧြပီ,ေမ,ဇွန်,ဇူလိုင်,ဩဂုတ်,စက်တင်ဘာ,ေအာက်တိုဘာ,နိုဝင်ဘာ,ဒီဇင်ဘာ",
months_short:"ဇန်,ေဖ,မတ်,ဧြပီ,ေမ,ဇွန်,ဇူ,ဩ,စက်,ေအာက်,နိုဝင်,ဒီဇင်",
day_long:"တနဂင်္ေနွ,တနလင်္ာ,အဂင်္ါ,ဗုဒ္ဓဟူး,ြကာသပေတး,ေသာြကာ,စေန,တနဂင်္ေနွ",
day_short:"Sun,Mon,Tue,Wed,Thu,Fri,Sat,Sun"
});
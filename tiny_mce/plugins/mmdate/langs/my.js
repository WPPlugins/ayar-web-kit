// EN lang variables

if (navigator.userAgent.indexOf('Mac OS') != -1) {
// Mac OS browsers use Ctrl to hit accesskeys
	var metaKey = 'Ctrl';
}
else {
	var metaKey = 'Alt';
}

tinyMCE.addI18n('my.mmdate',{
delta_width:"",
delta_height:"",
desc : 'ြမန်​မာ ေန့စွဲ',
insertmmdate_desc:"ြမန်မာေန့စွဲ ထည့်သွင်းပါ",
insertdate_desc:"အဂင်္လိပ်ေန့စွဲ ထည့်သွင်းပါ",
insertmmyear_desc:"ြမန်မာခုနှစ် ထည့်သွင်းပါ",
inserttime_desc:"အချိန် ထည့်သွင်းပါ",
keyboard_desc:"လက်ကွက်",
keyboardlayout_desc:"လက်ကွက်နမူနာပံုစံ",
delta_width:"",
delta_height:"",
date_fmt:"%Y-ခုနှစ်၊ %Bလ၊ %d-ရက်၊ %Aေန့ ",
time_fmt:"%p %I နာရီ : %M မိနစ် : %S စက္ကန့် ",
months_long:"ဇန်နဝါရီ,ေဖေဖာ်ဝါရီ,မတ်,ဧြပီ,ေမ,ဇွန်,ဇူလိုင်,ဩဂုတ်,စက်တင်ဘာ,ေအာက်တိုဘာ,နိုဝင်ဘာ,ဒီဇင်ဘာ",
months_short:"ဇန်,ေဖ,မတ်,ဧြပီ,ေမ,ဇွန်,ဇူ,ဩ,စက်,ေအာက်,နိုဝင်,ဒီဇင်",
day_long:"တနဂင်္ေနွ,တနလင်္ာ,အဂင်္ါ,ဗုဒ္ဓဟူး,ြကာသပေတး,ေသာြကာ,စေန,တနဂင်္ေနွ",
day_short:"Sun,Mon,Tue,Wed,Thu,Fri,Sat,Sun"
});
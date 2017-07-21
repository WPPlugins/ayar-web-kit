// Original C# Code - Grand Master (Ko Wunna Ko?)
// Ported to Javascript & Changed Output to Zawgyi - Soe Min (Mark) (soemin@my-mm.org)
// License for Javascript - Non-Commercial
// Some Changes by Sithu Thwin and Minn Kyaw
var MyanmarCalendar={
	Mday:'',Myear:'',MMon:'',typeyear:'',typemonth:'',MMonth:'',HMonth:'',My:'',aTartday:'',Overdays:'',Odays:'',Firstday:'',Marthday:''
}
var PII = 0.0174532925199433;
var PIII = 57.2957795130823;
var a=b=Result1=d=t=x=t0=ut=sg=TJd=0;
function SunTransist(Year, Total) {
	var Tinkan, Kali, C;
	var Nyear = 0;
	Tinkan = Totaldays(31, 12, (Year - 1), 0, 0);
	Kali = Year + 3101;
	C = (Kali - (Tinkan / 365.2587565)) * 365.2587565;
	C += Tinkan;
	if (Total < C)
		Nyear = 0;
	else if (Total >= C)
		Nyear = 1;
	return Nyear;
}
function TotalJdays(day, month, year, Hour, Min) {
	var H1 = 0, M1 = 0;
	var Tim = 0;
	var Dj = 0;
	H1 = 1.0*(Hour);
	M1 = 1.0*(Min);
	Tim = (H1 + (M1 / 60));
	Dj = julday(year, month, day, Tim, 1);
	Dj -= 2415019.5;
	TJd = Dj;
	return TJd;
}
function Totaldays(day, month, year, Hour, Min) {
	var H1 = 0, M1 = 0;
	var Tim = 0;
	var Tot = 0, Dj = 0;
	H1 = 1.0*(Hour);
	M1 = 1.0*(Min);
	Tim = (H1 + (M1 / 60));
	Dj = julday(year, month, day, Tim, 1);
	Dj -= 2415019.5;
	TJd = Dj;	
	Tot = Dj + 1826554;
	return Tot;
}
function julday(year, month, day, hour, gregflag) {
	var jd = 0;
	var u = 0, u0 = 0, u1 = 0, u2 = 0;
	u = year;
	if (month < 3) u -= 1;
	u0 = u + 4712.0;
	u1 = month + 1.0;
	if (u1 < 4) u1 += 12.0;
	jd = Math.floor(u0 * 365.25) + Math.floor(30.6 * u1 + 0.000001) + day + hour / 24.0 - 63.5;
	if (gregflag == 1) {
		u2 = Math.floor(Math.abs(u) / 100) - Math.floor(Math.abs(u) / 400);
		if (u < 0.0) u2 = -u2;
		jd = jd - u2 + 2;
		if ((u < 0.0) && (u / 100 == Math.floor(u / 100)) && (u / 400 != Math.floor(u / 400)))
			jd -= 1;
	}
	return jd;
}
function SuraMyear(day, month, Year, Wa) {
	var mr = MyanmarCalendar;
	var NameHm;
	var ResD;
	var NameMo;
	var ResY = 0;
	var Tyear = 0;
	var MMM, MMY;
	var MDay;
	var My, aTartday, Overdays, Odays, Firstday, Marthday;
	var total, Mo;
	var Cyear =[ 0, 30, 61, 91, 122, 153, 183, 214, 244, 275, 306, 334 ];
	var Zy = 0;
	var SMyear =[ -1, 28, 58, 87, 117, 146, 176, 205, 235, 264, 294, 323, 353, 382, 411, 441 ];
	var DMyear =[ -1, 28, 58, 87, 117, 147, 176, 206, 235, 265, 294, 324, 354, 383, 412, 442 ];
	var DDMyear =[ -1, 28, 58, 88, 118, 148, 177, 207, 236, 266, 295, 325, 355, 384, 413, 443 ];
	var S =[ 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30 ];
	var D =[ 29, 30, 29, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30 ];
	var DD =[ 29, 30, 30, 30, 30, 29, 30, 29, 30, 29, 30, 29, 30 ];
	var SMon =[ 'ဂတုစဲ', 'ဂတုပသာ်', 'ဂတု​ေဇှ်', 'ဂတုဒဂိုန်', 'ဂတုထ္ဍဲသဳ', 'ဂတုဘတ်', 'ဂတုဝှ်', 'ဂတုကထိုန်', 'ဂတု​ေြမက္ကသဵု', 'ဂတုပုဟ်', 'ဂတုမာ်', 'ဂတုဖဝ်ရဂိုန်', 'ဂတုစဲ', 'ဂတုပသာ်', 'ဂတု​ေဇှ်' ];
	var DMon =['ဂတုစဲ', 'ဂတုပသာ်', 'ဂတု​ေဇှ်', 'ဂတု ပ-ဒဂိုန်', 'ဂတု ဒု-ဒဂိုန်', 'ဂတုထ္ဍဲသဳ', 'ဂတုဘတ်', 'ဂတုဝှ်', 'ဂတုကထိုန်', 'ဂတု​ေြမက္ကသဵု', 'ဂတုပုဟ်', 'ဂတုမာ်', 'ဂတုဖဝ်ရဂိုန်', 'ဂတုစဲ', 'ဂတုပသာ်' ];
	var Tot = Totaldays(day, month, Year, 0, 0);
	Tyear = Math.abs(Year);	
	if ((Tyear % 4 == 0) && (Tyear % 100 != 0) || Tyear % 400 == 0)
		Cyear[11] = 335;
	month -= 4;
	if (month < 0) {
		month += 12;
		if (Year <= 0)
			Year++;
		else
			Year--;
	}
	if (Year == 0)
		Year = -1;
	Tyear = Year;
	if (Tyear <= -1)
		Year++;
	My = Year + 3101;
	aTartday = Math.floor((My * 365.2587565));
	Odays = My * 11.06483;
	Overdays = Math.floor(Odays % 30.0);
	Firstday = aTartday - Overdays;
	Marthday = Math.floor(Totaldays(30, 3, Tyear, 0, 0));
	Zy = Number(Math.floor((Marthday - Firstday)));
	total = Zy + Cyear[month] + day;
	Mo = month;
	MMY = Wa;
	if (Wa == 0) {
		total -= SMyear[month];
		if (total > S[month]) {
			total -= S[month];
			month++;
			if (month > 12) month -= 12;
			Mo = month;
		}
		MDay = S[month] - 15;
	} else if (Wa == 1) {
		total -= DMyear[month];
		if (total > D[month]) {
			total -= D[month];
			month++;
			if (month > 12) month -= 12;
			Mo = month;
		}
		MDay = D[month] - 15;
	} else {
		total -= DDMyear[month];
		if (total > DD[month]) {
			total -= DD[month];
			month++;
			if (month > 12) month -= 12;
			Mo = month;
		}
		MDay = DD[month] - 15;
	}
	MMM = Mo;
	if (SunTransist(Year, Tot) == 1)
		ResY = Year - 638;
	else if (SunTransist(Year, Tot) == 0)
		ResY = Year - 639;
	ResD = total;
	if (ResD <= 0) {
		Mo--;
		if (Mo < 0) Mo += 12;
		if (Wa == 0) ResD += S[Mo];
		else if (Wa == 1) ResD += D[Mo];
		else ResD += DD[Mo];
	}
	if(ResD==30){
		ResD=15;
		NameHm = ' အိုတ်၊​ ';
	}else if (ResD > 15) {
		ResD -= 15;
		NameHm = ' ​ေစွက်၊​ ';
	} else if (ResD == 15) {
		NameHm = ' ​ေပင်၊​ ';
	} else {
		NameHm = ' မံက်၊​ ';
	}
	var Yres = ResY;
	if (Wa == 0)
		NameMo = SMon[Mo];
	else
		NameMo = DMon[Mo];
	if (Yres < 639)
		ResY += 3739;
	mr.MMon = Mo;
	mr.HMonth = NameHm;
	mr.Mday = ResD;
	mr.MMonth = NameMo;
	mr.Myear = ResY;
	mr.typeyear = MMY;
	mr.aTartday = aTartday;
	mr.Firstday = Firstday;
	mr.Odays = Odays;
	mr.Overdays = Overdays;
	mr.Marthday = Marthday;
	return mr;
}
var d=new Date();
var weekday=new Array(7);
weekday[0]="တဲ္ရအဒိုတ်";
weekday[1]="တဲ္ရစန်";
weekday[2]="တဲ္ရအင္ရာ";
weekday[3]="တဲ္ရဗုဒ္ဓဝါ";
weekday[4]="တဲ္ရဲြဗဲဗ္တိ";
weekday[5]="တဲ္ရသိုက်";
weekday[6]="တဲ္ရသိ္ရသဝ်";
var mr=SuraMyear(d.getDate(),d.getMonth()+1,d.getFullYear(),0);
md=function(x){return String(x).replace(/[\d]/g,function (x){return String.fromCharCode(x.charCodeAt(0)+0x1010)})}
//document.write('သက္ကရာဇ်ဍုင် '+md(mr.Myear)+' သဵာံ၊​ '+mr.MMonth+" "+(mr.Mday!=15?" "+md(mr.Mday)+' ':'')+mr.HMonth  + weekday[d.getDay()]);
var daylist=new Array ("အဒိုတ်","စန်","အင္ရာ","ဗုဒ္ဓဝါ","ြဗဲဗ္တိ","သိုက်","သိ္ရသဝ်");
var monthlist=new Array("ဂျာန်နျူအာရီ","ေဝှြဗူအာရီ","မာတ်","ဨေြပဲ","ေမ","ဂျုန်","ဂျု​လာဝ်","အဝ်​ဂါတ်","သိပ်​တီ​ဗာ","အံက်​တဝ်​ဗာ","နို​ဝင်​ဗာ","ဒဳ​သီ​ဗာ");
var now=new Date();
var mmtodaydate=mr.MMonth+" "+mr.HMonth+(mr.Mday!=15?" "+md(mr.Mday)+' ရက်':'');
document.write("<div class='cal'>");
//document.write("<p align='center'>"+daylist[now.getDay()]+"</p>");
//document.write("<p id='datestyle'>"+md(now.getDate())+"</p>");
//document.write("<p>"+monthlist[now.getMonth()]+" "+now.getFullYear()+"</p>");
document.write("<p id='ystyle' class='mon'>သက္ကရာဇ်ဍုင် "+md(mr.Myear)+"</p>");
document.write("<p id='mstyle' class='mon'>သဵာံ၊​"+mr.MMonth+"</p>");
document.write("<p id='date' class='mon'>"+mr.HMonth);
document.write((mr.Mday!=15?" "+md(mr.Mday):"</p>"));
document.write("<p class='mon' id='wd'>"+weekday[d.getDay()]+"</p>");
//Print Special Day
function specialday(month,date)
{
if (mr.Mday == 10)
{
if (mr.HMonth == ' ​ေစွက်၊​ ')
{
if (mr.MMonth == 'ဂတုကထိုန်')
{
var dayname="အ​မျိုး​သား​​ေန့​";
return dayname;
}}}
if (month==6)
{
if(date==19)
{
var dayname="အာဇာနည်ေန့";
return dayname;
}
}
else if(month==0)
{
if(date==4)
{
var dayname="လွတ်လပ်ေရးေန့";
return dayname;
}
if(date==5)
{
var dayname="ကရင်နှစ်သစ်ကူးေန့";
return dayname;
}}else if(month==1){
if(date==12){
var dayname="ြပည်ေထာင်စုေန့";
return dayname;
}if(date==3){
var dayname="တရုတ်နှစ်သစ်ကူး";
return dayname;
}}else if(month==2){
if(date==2){
var dayname="လယ်သမားေန့";
return dayname;
}if(date==27){
var dayname="တပ်မေတာ်ေန့";
return dayname;
}}else if(month==4){
if(date==1){
var dayname="အလုပ်သမားေန့";
return dayname;
}}else if(month==11){
if(date==25){
var dayname="ခရစ္စမတ်ေန့";
return dayname;
}}else if(month==3){
if(date==13){
var dayname="သြကင်္န်အြကိုေန့";
return dayname;
}if(date==14){
var dayname="သြကင်္န်အကျေန့";
return dayname;
}if(date==15){
var dayname="သြကင်္န်အြကတ်ေန့";
return dayname;
}if(date==16){
var dayname="သြကင်္န်အတက်ေန့";
return dayname;
}if(date==17){
var dayname="နှစ်ဆန်းတစ်ရက်ေန့";
return dayname;
}}else{
return ;
}
return;
}

var now=new Date();
special=specialday(now.getMonth(),now.getDate());
if (typeof special !="undefined")
document.write("<p class='special mon'><style type='text/css'>#body{margin-bottom:50px;}</style>"+special+"</p>");
document.write("</div>");
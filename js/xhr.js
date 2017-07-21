// ---- XHR-funktioner ----

var active_xhr=[];

function createXHR(){
    var request = false;
    try {
        request = new ActiveXObject('Msxml2.XMLHTTP');
    }
    catch (err2) {
        try {
            request = new ActiveXObject('Microsoft.XMLHTTP');
        }
        catch (err3) {
	    try {
		request = new XMLHttpRequest();
	    }
	    catch (err1) 
	    {
		request = false;
	    }
        }
    }
    return request;
};

function run_call(f,process,id){
    // effekt: kör process med resultatet av php-funktion f (array)
    //         registrera hämtning som uppdaterare av ev id
    // retur : eventuellt xhr-anrop

    e=[];
    for(var i=0;i < f.length;i++){
	e.push(encodeURIComponent(f[i]));
    };
    url='/interface/call?c='+encodeURIComponent(e.join(','));
    runXHR(url,process,id);
};

function run_call_param(f,param,process,id){
    // effekt: kör process med resultatet av php-funktion f (array)
    //         registrera hämtning som uppdaterare av ev id
    //         parametrar är formulär-kodad sträng utöver anrop
    // retur : eventuellt xhr-anrop

    e=[];
    for(var i=0;i < f.length;i++){
	e.push(encodeURIComponent(f[i]));
    };
    url='/interface/call?c='+encodeURIComponent(e.join(','))+param;
    runXHR(url,process,id);
};

function runXHR(url,process,id){
    // effekt: kör process med resultatet av url
    //         registrera hämtning som uppdaterare av ev id
    // retur : eventuellt xhr-anrop

    // skicka med dokumentets URL ifall anrop sker till ajax_call
    url=extend_url(url);

    // provar alternativ XHR för tredjepart
    if(url.match(/^http/)){
	return script_runXHR(url,process,id);
    };

    var xhr=createXHR();
    xhr.onreadystatechange=function(){
        if(xhr.readyState != 4) return false;

	// oavsett om resulat är 200,404 osv ...
	process(xhr.responseText,xhr);
    };

    xhr.open("GET",url,true); 
    xhr.send(null);

    // registrera xhr
    if(id){
	register_id(id,xhr);
    };

    return xhr;
};

function register_id(id,xhr){
    // effekt: registrerar xhr som aktiv uppdaterare av id
    active_xhr[id]=xhr;
};

function cancel_id(id){
    // effekt: avbryter ev aktiv XHR associerad med id

    if(active_xhr[id]){
	active_xhr[id].onreadystatechange=function(){};
	active_xhr[id].abort();
	delete(active_xhr[id]);
    };

    // ökar aktuell-flaggan för script-xhr
    if(script_xhr_active[id]){
	script_xhr_active[id]++;
    };
};

function replace_id(id,url){ 
    // effekt: ersätter id med första elementet i innehållet i url,
    //         registrerar xhr
    // pre   : url genererar minst ett element
    
    // stänger ev. tidigare XHR-begäran
    cancel_id(id);

    var xhr=replace(document.getElementById(id),url);
    register_id(id,xhr);
};

function replace(element,url){ 
    // effekt: ersätter element med första elementet i innehållet i url
    // pre   : url genererar minst ett element
    // retur : xhr-anrop

    // skicka med dokumentets URL ifall anrop sker till ajax_call
    url=extend_url(url);

    var xhr=createXHR();
    xhr.onreadystatechange=function(){replace_element(element,xhr)}; 
    xhr.open("GET",url,true);
    xhr.send(null);

    return xhr;
} 

function replace_element(element,xhr){
    // effekt: ersätter element med element från xhr

    if(xhr.readyState != 4) return false;
    var n;

    if(xhr.responseText.match(/"INTERNAL_ERROR"/)){
	window_status('Inget resultat från AJAX-anrop hittat');
	return;
    };

    switch(element.nodeName.toLowerCase()){
    case 'td':
	if(document.selection){
	    // alternativt metod för vissa läsare
	    var di=document.createElement('div');
	    var text='<table><tbody><tr>'+xhr.responseText+'</tr></tbody></table>';
	    var e=di.getElementsByTagName('table');
	    var ta=e[0];
	}
	else{
	    // gör något som kan innehålla en td
	    var ta=document.createElement('table');
	    var tb=document.createElement('tbody');
	    ta.appendChild(tb);
	    var tr=document.createElement('tr');
	    tb.appendChild(tr);
	    var td=document.createElement('td');
	    tr.appendChild(td);
	    tr.innerHTML=xhr.responseText;
	};

	// leta efter td
	var e=ta.getElementsByTagName('td');
	n=e[0];
	break;
    case 'tr':
	if(document.selection){
	    // alternativt metod för vissa läsare
	    var di=document.createElement('div');
	    var text='<table><tbody>'+xhr.responseText+'</tbody></table>';
	    di.innerHTML=text;
	    var e=di.getElementsByTagName('table');
	    var ta=e[0];
	}
	else{
	    // gör något som kan innehålla en tr
	    var ta=document.createElement('table');
	    ta.innerHTML=xhr.responseText;
	};

	// se till att första barnobjekt är tr
	e=ta.getElementsByTagName('tbody');
	if(e[0] && e[0].nodeName.toLowerCase()=='tbody'){
	    var tb=e[0];
	}
	else{
	    // ingen tbody hittad - använd tabell som body
	    var tb=ta;
	};
	var e=tb.getElementsByTagName('tr');
	n=e[0];
	break;
    case 'tbody':
	if(document.selection){
	    // alternativt metod för vissa läsare
	    var di=document.createElement('div');
	    var text='<table>'+xhr.responseText+'</table>';
	    di.innerHTML=text;
	    var e=di.getElementsByTagName('table');
	    var ta=e[0];
	}
	else{
	    // gör något som kan innehålla en tbody
	    var ta=document.createElement('table');
	    ta.innerHTML=xhr.responseText;
	};
	var e=ta.getElementsByTagName('tbody');
	n=e[0];
	break;
    default:
	var di=document.createElement('div');
	di.innerHTML=xhr.responseText;
	n=di.firstChild;
    };

    if(n){
	copy_values(element,n);
	if(!element.parentNode) return;
	element.parentNode.replaceChild(n,element);
	if(document.selection){
	    eval_script(n);
	};
    };
};

function replace_content_id(id,url){ 
    // effekt: ersätter innehållet i element med innehållet i url
    //         (tar inte bort själva element)

    replace_content(document.getElementById(id),url);
};

function replace_content(element,url){ 
    // effekt: ersätter innehållet i element med innehållet i url
    //         (tar inte bort själva element)

    // skicka med dokumentets URL ifall anrop sker till ajax_call
    url=extend_url(url);

    var xhr=createXHR();
    xhr.onreadystatechange=function(){
        if(xhr.readyState != 4) return false;

	if(xhr.responseText.match(/"INTERNAL_ERROR"/)){
	    window_status('Inget resultat från AJAX-anrop hittat');
	    return;
	};

	element.innerHTML=xhr.responseText;
	if(document.selection){
	    eval_script(element);
	};
    }; 
    xhr.open("GET",url,true); 
    xhr.send(null);
};

function eval_script(element){
    // effekt: kör script-taggar i element

    // hämtar taggar
    var matches=element.getElementsByTagName("script");
    for(var i=0;i < matches.length;i++){
	if(matches[i].firstChild){
	    // funkar inte i IE : childNodes har inga element
	    eval(matches[i].firstChild.nodeValue);
	}
	else{
	    // special för IE
	    eval(matches[i].innerHTML);
	}; 
    };
};

function copy_values(old,n){
    // effekt: kopierar över formulärvärden från text-input i old till new
    
    var values=[];

    // -- hämtar gamla --
    // input
    var matches=old.getElementsByTagName("input");
    for(var i=0;i < matches.length;i++){
	// skippa element utan namn
	if(!matches[i].name) continue;

	if(matches[i].type == "text"){
	    // vanliga textfält
	    values[matches[i].name]=matches[i].value;
	}
	else if(matches[i].type=="checkbox" || matches[i].type=="radio"){
	    if(!(values[matches[i].name])) values[matches[i].name]=[];
	    values[matches[i].name][matches[i].value]=matches[i].checked;
	};
    };
    // textarea
    var matches=old.getElementsByTagName("textarea");
    for(var i=0;i < matches.length;i++){
	if(!matches[i].name) continue;
	values[matches[i].name]=matches[i].value;
    };

    // -- behandlar nya --
    // input
    var matches=n.getElementsByTagName("input");
    for(var i=0;i < matches.length;i++){
	// skippa element utan namn
	if(!matches[i].name) continue;
	// skipa element utan registrerat tidigare värde
	if(!values[matches[i].name]) continue;
	
	// kopierar
	if(matches[i].type == "text"){
	    // vanliga textfält
	    matches[i].value=values[matches[i].name];
	}
	else if(matches[i].type == "checkbox" || matches[i].type=="radio"){
	    // checkrutor och radio, ev flervärdes
	    if(typeof(values[matches[i].name][matches[i].value])){
		// kopierar bara checked om ruta med detta värde fanns
		matches[i].checked=values[matches[i].name][matches[i].value];
	    };
	};
    };

    // textarea
    var matches=n.getElementsByTagName("textarea");
    for(var i=0;i < matches.length;i++){
	// skippa element utan namn
	if(!matches[i].name) continue;

	// kopierar
	if(values[matches[i].name]){
	    matches[i].value=values[matches[i].name];
	};
    };
};

function extend_url(url){
    // retur: url med parameter med dokumentets URL
    //        ifall anrop sker till ajax_call
    if(url.match(/\/interface\/call/)){
	url=url+"&orig="+encodeURIComponent(window.location.pathname+window.location.search+window.location.hash);
    };
    return url;
};

function add_param(url,v){
    // pre:   url är url från PHP-funktion ajax_call
    // retur: url med positionell parameter v dynamiskt tillagd
    url=url+encodeURIComponent(','+encodeURIComponent(v));
    return url;
};

function add_params(url,vs){
    // pre:   url är url från PHP-funktion ajax_call
    // retur: url med positionella parametrar i vs dynamiskt tillagda
    for(var i=0;i < vs.length;i++){
	url=url+encodeURIComponent(','+encodeURIComponent(vs[i]));
    };
    return url;
};

// -- funktioner för dynamisk script-tag (tredjepart ajax) --

var script_xhr_nr=0;
var script_xhr_process=[];
var script_xhr_active=[];

function script_runXHR(url,process,id){
    // effekt: kör process med text från url (som ska returnera JS)
    //         registrera hämtning som uppdaterare av ev id

    if(id){
	if(!script_xhr_active[id]) script_xhr_active[id]=1;
	var orig_active=script_xhr_active[id];
    };
    
    var nr=script_xhr_nr++;
    url=url+"&xhr="+nr;

    url=url+"&encode=js";

    var script=document.createElement('script');

    // sätter funktion som anropas av script
    // detta är än så länge inte asynkron / trådsäkert
    script_xhr_process[nr]=function(text){
	// kör bara om id saknas, eller id fortfarande aktuellt
	if((!id) || (orig_active==script_xhr_active[id])){
	    process(text,null)
	};
    };

    script.src=url;
    script.type="text/javascript";
    // infogar script, och bör därmed ladda och köra js från url
    document.getElementsByTagName('head')[0].appendChild(script);
};

function script_xhr_run(xhr,text){
    // effekt: anropar funktion registrerad för anrop-nr xhr med text
    //         raderar sen registrerad funktion
    
    // gör något bara om mottagarare är registrerad (kan köras i fel dokument)
    if(!script_xhr_process[xhr]) return;

    // kör registrerad mottagare
    script_xhr_process[xhr](text);

    // raderar funktion som inte längre behövs
    delete script_xhr_process[xhr];
};

// ---- händelser (events) ----

function add_listener(element,event,f){
    // effekt: lägger funktion f till elements händelse event

    try {
	element.addEventListener(event,f,false);
    }
    catch (err1) {
	// provar IE-kompatibel metod
	element.attachEvent("on"+event,f);
    };
};

function remove_listener(element,event,f){
    // effekt: lägger funktion f till elements händelse event

    try {
	element.removeEventListener(event,f,false);
    }
    catch (err1) {
	// provar IE-kompatibel metod
	element.detachEvent("on"+event,f);
    };
};

function event_target(event){
    // retur: målobjekt för händelse event, även MSIE-kompatibel

    var target = event.target ? event.target : event.srcElement;
    if( target && ( target.nodeType == 3 || target.nodeType == 4 ) ) {
      target = target.parentNode;
    };
    return target;
};

// ---- mushantering ----

var mouse_down_state=0;

add_listener(document,'mousedown',function(){mouse_down_state=1})
add_listener(document,'mouseup',function(){mouse_down_state=0})

function mouse_down(){
    // retur: huruvida musen är nere
    return mouse_down_state;
};

function mouse_wait(element,timeout,func){
    // effekt: kör func efter timout om inte element släppt musen

    var t=window.setTimeout(func,timeout);
    element.onblur=function(){window.clearTimeout(t)};	
    element.onmouseup=function(){window.clearTimeout(t)};
};

// ---- fokus ----

var focus_history=[];

// lägger till fokus i historiken för element som inte hanterar fokus själv
add_listener(document,"click",function(e){
    // hämtar faktiskt element som fokuserades
    var target=event_target(e);
    focus_history_add(target);
});

function focus_history_add(e){
    // lägger till element e i fokushistoriken, om det inte är med redan

    if(focus_history[0]==e) return;
    focus_history.unshift(e);
    // tar bort senare del
    focus_history.splice(2,1);
};

function focus_history_prev(){
    // retur: näst senaste objekt som hade fokus

    return focus_history[1];
};

// ---- för session / meddelanden ----

function message(string){
    // effekt: visar meddelande string på något sätt

    var div=document.getElementById("tyda_message");
    if(div){
	div.innerHTML='<div class="tyda_messages"><div class="tyda_message">'+string+'</div></div>';
    }
    else{
	// i nödfall
	alert(string);
    };
};

// ---- för formulär ----

function field_check(id,url,input){
    // effekt: ersätter element med id id med innehållet i url +
    //         parameter med element inputs namn och värde
    // pre:    url innehåller andra argument (dvs redan ett "?")
    
    var value=input.value;
    // specialhantering av checkbox, förutsätter singular
    if(input.type=="checkbox"){
	value=input.checked+0;
    };

    url=url+"&"+encodeURIComponent(input.name)+"="+encodeURIComponent(value);
    replace_id(id,url);
};

// ---- för UI-moduler ----

function module_activate(id){
    // effekt: sätter js-kopplingar för element i UI-modul id
    //         * klick på tr ger klick på a inuti
    //         * klick på stängruta stänger ner
    
    var module=document.getElementById(id);

    // hänger på visa / dölj
    var td_head=find_below(module,'div','class','tyda_module_head')[0];
    if(td_head){
	add_listener(td_head,'click',function(){module_roll(id)});
    };

    // gå igenom alla tr
    var trs=find_below(module,'tr','class',"tyda_module_row_first");
    trs=trs.concat(find_below(module,'tr','class',"tyda_module_row"))
    for(var i=0;i < trs.length;i++){
	// se till att klick på tr ger klick på ev a
	add_listener(trs[i],'click',function(e){
	    as=find_below(event_target(e),'a');
	    if(as[0]){
		if(as[0].onclick){
		    as[0].onclick();
		}
		else{
		    document.location=as[0].href;
		};
	    };
	});
    };
};

function module_roll(id){
    // effekt: byter synlighet för tbody för modul id

    var module=document.getElementById(id);
    var tbody=find_below(module,'tbody','class','tyda_module_body')[0];

    if(tbody.style.display=="none"){
	// visas inte - visa nu
	tbody.style.display="";
    }
    else{
	// visas - visa inte nu
	tbody.style.display="none";
    };
};

function module_highlight(element,state){
    // effekt: byter klass på modul-element för highlight

    if(state){
	set_attribute(element,'class',"tyda_module_highlight_on");
    }
    else{
	set_attribute(element,'class',"tyda_module_highlight_off");
    };
};

function module_close(id,name){
    // effekt: tar bort UI-modul id med namn name från sida med persistens

    var module=document.getElementById(id);
    var parent=module.parentNode;
    parent.removeChild(module);

    // avkryssar ev. kontrollerande ruta
    var check=find_below(document,'input','name','show_'+name)[0];
    if(check) check.checked=0;

};

var modules_source=null;

function modules_reload(input){
    // effekt: läser om ev. moduler, med nya värden från input

    if(modules_source){
	// laddar om sökresultat, med nya värdet på input
	var value=input.value;
	// specialhantering av checkbox, förutsätter singular
	if(input.type=="checkbox"){
	    value=input.checked+0;
	};

	replace_id(modules_source[0],modules_source[1]+"&"+encodeURIComponent(input.name)+"="+encodeURIComponent(value));
    };
};

// ---- för sökformulär / resultat ----

var search_source=null;

function search_reload(input){
    // effekt: läser om ev. sökresultat som är registrerat, från input

    var value=input.value;
    // specialhantering av checkbox, förutsätter singular
    if(input.type=="checkbox"){
	value=input.checked+0;
    };

    if(search_source){
	// laddar om sökresultat, och sparar nya värdet på input
	replace_id(search_source[0],search_source[1]+"&"+encodeURIComponent(input.name)+"="+encodeURIComponent(value));
    }
    else{
	// sparar nya värden på input för session / användare
	run_call_param(['save_search_form',null],"&"+encodeURIComponent(input.name)+"="+encodeURIComponent(value),function(){},null);
    };
    
    // läs om reklam också
    ads_reload();
};

function ads_reload(){
    // effekt: läser om ev. reklamfält
    ads=document.getElementById('tyda_ads');
    if(ads){
	old=find_below(ads,"div","class","tyda_ads_box")[0];
	var di=document.createElement('div');
	ads.appendChild(di);
	set_attribute(di,'class','tyda_ads_box');
	set_attribute(old,"style","left:0px;z-index:10");
	set_attribute(di,"style","left:0px;z-index:1");
	di.innerHTML='<iframe allowtransparency="true" style="display:block" class="tyda_ads" frameborder=0 src="/interface/ads.php"></iframe>';
	window.setTimeout(function(){
	    ads.removeChild(old);
	},1000);
    };
};

// ---- för input-widgets generellt ----

// vad som ska hända om menyval klickas på (eller bläddras till)
var input_common_onclick=[];

function key_code(e){
    // retur: keyCode eller kompatibelt för e

    if( typeof( e.keyCode ) == 'number'  ) {
	//DOM
	return e.keyCode;
    } else if( typeof( e.which ) == 'number' ) {
    	//NS 4 compatible
    	return e.which;
    } else if( typeof( e.charCode ) == 'number'  ) {
	//also NS 6+, Mozilla 0.9+
    	return charCode;
    } else {
    	//total failure, we have no way of obtaining the key code
    	return;
    };
};

function input_common_onclick_register(id,f){
    // registerar onclick-hanterare f för input id
    input_common_onclick[id]=f;
};

function input_common_menu_keyup(input,id,event){
    // behandlar tangentupp för input-widget input och dess meny

    var key=key_code(event);

    // tar hand om key-up som inte ska betyda något
    if(key==38 || key==40 || key==33 || key==34){
	return 1;
    };
    return 0;
};

function input_common_menu_key(input,id,event){
    // behandlar tangenttryckningar för input-widget input och dess meny
    
    var base=document.getElementById(id+'base');
    if(!base) return 0;
    var key=key_code(event);

    var active=find_below(base,'div','class',"tyda_input_menu_active")[0];
    // sätt tillbaka aktiv så att den ingår i listan
    if(active) set_attribute(active,"class","tyda_input_menu");

    var semi=find_below(base,'div','class',"tyda_input_menu_semiactive")[0];
    // sätt tillbaka semiaktiv så att den ingår i listan
    if(semi) set_attribute(semi,"class","tyda_input_menu");

    // hitta alla rader att bläddra mellan
    var lines=find_below(base,'div','class',"tyda_input_menu");

    // återgå om inga övriga div
    if(!lines.length) return 0;

    // hämta riktning och storlek på bläddring
    var dir=null;
    if(key==38 || key==33) dir='u';
    if(key==40 || key==34) dir='d';
    var size=null;
    if(key==33 || key==34){
	// page up/down
	size=10;
    }
    else{
	// vanliga pilar
	size=1;
    }

    if(active){
	var prev=null;
	var next=null;
	for(var i=0;i < lines.length;i++){
	    if(lines[i]==active){
		if(lines[i-1]){
		    var index=i-size;
		    if(index < 0) index=0;
		    prev=lines[index];
		};
		if(lines[i+1]){
		    var index=i+size;
		    if(index >= lines.length) index=lines.length-1;
		    next=lines[index];
		};
	    };
	};
	if(dir=='u' && prev){
	    input_common_menu_activate(input,id,prev);
	    return 1;
	};
	if(dir=='u'){
	    // återställ active
	    set_attribute(active,"class","tyda_input_menu_active");
	    return 1;
	};
	if(dir=='d' && next){
	    input_common_menu_activate(input,id,next);
	    return 1;
	};
	if(dir=='d'){
	    // återställ active
	    set_attribute(active,"class","tyda_input_menu_active");
	    return 1;
	};
    }
    else{
	// inget tidigare val
	if(dir=='u'){
	    input_common_menu_activate(input,id,lines[lines.length-1]);
	    return 1;
	};
	if(dir=='d'){
	    input_common_menu_activate(input,id,lines[0]);
	    return 1;
	};
    };
    
    return 0;
};

function input_common_menu_activate(input,id,line){
    // hanterar "klick" - bläddring till menyelement

    set_attribute(line,"class","tyda_input_menu_active");
    var as=line.getElementsByTagName('a');
    if(as[0] && input_common_onclick[id]){
	// skickar till registrerad hanterare (satt av barn-klass)
	input_common_onclick[id](as[0]);
    };
};

// ---- för navigator (små JS-widgets) ----

var expanders=[];
var expander_status=[];

function expander_client_click(a,id,text){
    // effekt: hantering av klick på expander-knapp a
    //         som skiftar synlighet på element id

    var e=document.getElementById(id);

    if(e.style.display=="none"){
	// visas inte - visa nu
	expander_client_set(a,id,1,null);
    }
    else{
	// visas - visa inte nu
	expander_client_set(a,id,0,null);
    };
};

function expander_client_text_click(a,id,text_show,text_hide){
    // effekt: hantering av klick på expander-knapp a som skiftar synlighet
    //         på element id och ev växlar mellan knapp mellan text_*

    var e=document.getElementById(id);

    if(e.style.display=="none"){
	// visas inte - visa nu
	expander_client_set(a,id,1,text_hide);
    }
    else{
	// visas - visa inte nu
	expander_client_set(a,id,0,text_show);
    };
};

function expander_client_set(a,id,status,text){
    // effekt: sätter span status till synlig eller ej, och 
    //         eventuell knapp under a till matchande symbol och ev text

    var e=document.getElementById(id);

    var i=null;
    if(a){
	i=find_below(a,'img')[0];
	// sätt textinnehåll på lämpliga ställen
	if(text){
	    if(i){
		set_attribute(a,'alt',text);
		set_attribute(a,'title',text);
	    }
	    else{
		a.innerHTML=text;
	    };
	};
    };

    if(status){
	if(i) i.src="/images/data_minus.png";
	e.style.display="";
    }
    else{
	if(i) i.src="/images/data_plus.png";
	e.style.display="none";
    };

    // registrera
    expander_register_status(id,status);
};

function expander_register(group_id,id,status,f){
    // effekt: registrerar funktion f för att ändra status på expander id
    //         till status, med i grupp group_id

    // säkerställ grupp
    if(!expanders[group_id]) expanders[group_id]=[];

    // säkerställ id
    if(!expanders[group_id][id]) expanders[group_id][id]=[];

    // registrerar vilken funktion för id och status den ger
    expanders[group_id][id][status]=f;
};

function expander_register_status(id,status){
    // effekt: registrerar att expander id nu har status

    // registrerar vilken funktion för id och status den ger
    expander_status[id]=status;
};

function expand_group(group_id,status){
    // effekt: sätter expanderad-status för alla expanders i group_id
    //         till status (rör inte de som redan verkar ha status)

    // kräv att grupp finns
    if(!expanders[group_id]) return;

    // kör funktion som ger önskad status för id
    for(var id in expanders[group_id]){
	// kör om funktion finns och status inte verkar rätt
	if(expanders[group_id][id][status] && ((typeof(expander_status[id])=='undefined') || expander_status[id] != status)){
	    expanders[group_id][id][status]();
	};
    };
};

function uset(key,value){
    // effekt: sätter key till value för session/användare på serversidan
    //         om tillåtet

    run_call(['uset',null,key,value],function(){},null);
};

// ---- funktioner för markering och markör ----

function cursor_position(input){
    // retur: position för markör för input

    if(document.selection){
	// från http://www.bazon.net/mishoo/articles.epl?art_id=1292
	return Math.abs(document.selection.createRange().moveEnd("character", -1000000));
    };

    var i2=input.selectionEnd;
    return i2;
};

function get_selection(input){
    // retur: eventuellt markerat område i input

    if(document.selection){
	return document.selection.createRange().text;
    };

    var i1=input.selectionStart;
    var i2=input.selectionEnd;

    if(i2 > i1){
	// markering
	return input.value.substr(i1,i2-i1);
    }
    else{
	return '';
    };
};

function replace_selection(input,text) {
    // effekt: byter ut markerat område i input till text

    if(document.selection){
	// FIXME
	var range=document.selection.createRange();
	if(range.parentElement != input){
	    //alert("selection error");
	    //return;
	    
	};
	return;
	// range.text=text;
    };

    var i1=input.selectionStart;
    var i2=input.selectionEnd;

    // byter innehåll
    input.value=input.value.substr(0,i1)+text+input.value.substr(i2);

    // flyttar markör
    if(i2 > i1){
	// markering
	input.selectionStart=i1;
	input.selectionEnd=i1+text.length;
    }
    else{
	// bara markör
	input.selectionStart=i1;
	input.selectionEnd=i1+text.length;
    };
};

function insert_selection(input,text) {
    // effekt: byter ut markerat område i input till text
    //         infogar text som vore den tecken från tangentbordet
    //         (dvs ersätter markering och ger bara markör)

    if(document.selection){
	// FIXME
	var range=document.selection.createRange();
	if(range.parentElement != input){
	    //alert("selection error");
	    //return;
	    
	};
	// range.text=text;
	return;
    };

    var i1=input.selectionStart;
    var i2=input.selectionEnd;

    // byter innehåll
    input.value=input.value.substr(0,i1)+text+input.value.substr(i2);

    // flyttar markör
    if(i2 > i1){
	// markering
	input.selectionStart=i1;
	input.selectionEnd=i1+text.length;
    }
    else{
	input.selectionStart=i1+text.length;
	input.selectionEnd=i1+text.length;
    };
};

// ---- fönsterstatus ----

var status_timer=null;

function window_status(text){
    if(status_timer){
	window.clearTimeout(status_timer);
    };
    status_timer=window.setTimeout(function(){window.clearTimeout(status_timer);window.status=''},5000);

    window.status=text;
};

// ---- hjälpfunktioner ----

function find_near(element,type,key,value){
    // retur: närmaste ovanstående element av typ type för element
    //        som, om key är satt har attribut key=value

    // om element själv har rätt typ och egenskap
    if(element.tagName.toLowerCase()==type.toLowerCase()){
	if((!key)||(attribute(element,key)==value)){
	    return(element);
	};
    };

    // om element innehåller element av rätt typ och egenskap
    var matches=element.getElementsByTagName(type);
    for(var i=0;i < matches.length;i++){
	if((!key)||(attribute(matches[i],key)==value)){
	    return(matches[i]);
	};
    };

    if(element.parentNode) return(find_near(element.parentNode,type,key,value));

    return false;
};

function find_below(element,type,key,value){
    // retur: array med alla understående element av typ type för element
    //        som, om key är satt har attribut key=value

    // om element innehåller form
    var matches=element.getElementsByTagName(type);
    var ret=[];
    for(var i=0;i < matches.length;i++){
	if((!key)||(attribute(matches[i],key)==value)){
	    ret.push(matches[i]);
	};
    };

    return ret;
};

function attribute(e,key){
    // retur: attribut e från key, även CSS-klass
    if(key=='class'){
	return e.className;
    }
    else{
	return e.getAttribute(key);
    };
};

function set_attribute(e,key,value){
    // retur: sätter attribut e från key till value, även CSS-klass
    if(key=='class'){
	e.className=value;
    }
    else{
	e.setAttribute(key,value);
    };
};
// ---- JS för att skicka till tyda vid högerklick på ord ----

function siteclick(){
    // effekt: öppnar tyda-sök för sträng i markering, ev i nytt fönster

    var userSelection;
    var text;

    // provar mozilla-metoden först
    if (window.getSelection){
	userSelection = window.getSelection();
	text=userSelection+'';
    }
    else if (document.selection){
	userSelection = document.selection.createRange();
	text=userSelection.text+'';
    };

    // trimma text (bara för mozilla)
    if(document.getSelection){
	text=text.replace(/^[\"\'\.\:\,\;\-_\!\(\) ]+/,'');
	text=text.replace(/[\"\'\.\:\,\;\-_\!\(\) ]+$/,'');
    };

    // öppna i tyda.se-fönster
    var n=window.open(siteclick_base+encodeURIComponent(text),'tyda_se','width=400,status=yes,scrollbars=yes');
    n.focus();
};

function siteclick_activate(element){
    // effekt:    aktiverar element med tooltip
    // rekursion: tills trädet i element bottnar

    var children=element.childNodes;
    for(var i=0;i < children.length;i++){
	var c=children[i];
	if(!c.tagName || !((c.tagName.toLowerCase()=='a')||(c.tagName.toLowerCase()=='button')||(c.tagName.toLowerCase()=='script')||(c.tagName.toLowerCase()=='object')||(c.tagName.toLowerCase()=='embed'))){
	    siteclick_activate(c);
	};
	if((c.nodeType==3) && c.nodeValue.match(/\S/)){
	    // gör span kring varje textblock
	    var span=document.createElement('span');
	    var parent=c.parentNode;
	    parent.replaceChild(span,c);
	    span.appendChild(c);
	    
	    // sätter titel för span
	    if(siteclick_tip){
		set_attribute(span,'title',siteclick_tip);
	    };

	    // gör span dubbelklickbar
	    add_listener(span,"dblclick",function(){siteclick()});
	};
    };
};

// när body är inläst, aktivera
add_listener(window,'load',function(){
    if(siteclick_translatable){
	// översätt inom vissa div (de som är en viss klass)
	var t=find_below(document,'div','class',siteclick_translatable);
	for(var i=0;i < t.length;i++){
	    siteclick_activate(t[i]);
	};

    }
    else{
	// övesätt inom hela dokument
	siteclick_activate(document.getElementsByTagName('body')[0]);
    };
});

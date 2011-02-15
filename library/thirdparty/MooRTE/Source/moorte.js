/*
---
description: Rich Text Editor (WYSIWYG / NAWTE / Editor Framework) that can be applied directly to any collection of DOM elements.

copyright:
- November 2008, 2010 Sam Goody

license: OSL v3.0 (http://www.opensource.org/licenses/osl-3.0.php)

authors:
- Sam Goody <siteroller - |at| - gmail>

requires:
- core

provides: [MooRTE, MooRTE.Elements, MooRTE.Utilities, MooRTE.Range, MooRTE.Path, MooRTE.ranges, MooRTE.activeField, MooRTE.activeBar ]

credits:
- Based on the tutorial at - http://dev.opera.com/articles/view/rich-html-editing-in-the-browser-part-1.  Bravo, Olav!!
- Ideas and inspiration - Guillerr, CheeAun, HugoBuriel
- Some icons from OpenWysiwyg - http://www.openwebware.com
- Cleanup regexs from CheeAun and Ryan's work on MooEditable (methodology is our own!)
- MooRTE needs YOU!!

Join our group at: http://groups.google.com/group/moorte

...
*/

Browser.webkit = Browser.safari || Browser.chrome;
Object.extend('set', function(key, val){
	var obj = {};
	obj[key] = val;
	return obj;
});

var MooRTE = new Class({
	
	Implements: [Options]

	, options: { floating: true // false broken by WK bug - "an editable element may not contain non-editable content".
			   , where: 'before' // 'top/bottom/before/after' (Mootools standard.)
			   , padFloat: true // before/after: add to existing margins when true. top/bottom: padding always added. If false shrinks element accordingly.
			   , stretch: false // If element grows, should it stretch the element or add toolbars. Other options abound.
			   , location: 'elements'
			   , buttons: 'div.Menu:[Main,File,Insert]'
			   , skin: 'Word03'
			   , elements: 'textarea, .rte'
	}
	, initialize: function(options){
		this.setOptions(options);
		var rte
		  , self = this
		  , els = $$(this.options.elements)
		  , l = this.options.location.substr(4,1).toLowerCase();
		  
		if (!MooRTE.activeField) MooRTE.extend({ ranges:{}, btnVals:[], activeField:'', activeBar:'' });
		if (!Browser.ie) MooRTE.btnVals.push('unselectable');
		
		els.each(function(el,index){
			if (el.get('tag') == 'textarea' || el.get('tag') == 'input') els[index] = el = self.textArea(el); 
			if (l=='e' || !rte) rte = self.insertToolbar(l);	
			if (l=='b' || l=='t' || !l) el.set('contentEditable', true);
			else l == 'e'
				? self.positionToolbar(el,rte)
				: el.set('contentEditable',true).addEvents({
					'focus': function(){ self.positionToolbar(el, rte); },
					'blur': function(){
						this.setStyle( 'padding-top'
									 , this.getStyle('padding-top')
										.slice(0,-2)
										- rte
											.getFirst()
											.getSize()
											.y
									).removeClass('rteShow');
						rte.addClass('rteHide'); 
					}
				});
			
			if (Browser.firefox) el.innerHTML += '&nbsp;<p id="rteMozFix"><br></p>';
			
			el.store('bar', rte)
				.addEvents({ keydown: MooRTE.Utilities.shortcuts
					        , keyup  : MooRTE.Utilities.updateBtns
					        , mouseup: MooRTE.Utilities.updateBtns
					        , focus  : function(){ MooRTE.activeField = this; MooRTE.activeBar = rte; }
					        });
			rte.addEvent('mouseup', MooRTE.Utilities.updateBtns);
		});
		rte.store('fields', els);
		
		MooRTE.activeField = els[0];
		MooRTE.activeBar = MooRTE.activeField.retrieve('bar');
		
		if (l=='t') rte.addClass('rtePageTop').getFirst().addClass('rteTopDown');
		else if (l=='b') rte.addClass('rtePageBottom');
		if (Browser.firefox) MooRTE.Utilities.exec('styleWithCSS');
		// MooRTE.Utilities.exec('useCSS', 'true'); - FF2, perhaps other browsers?
	}
	, insertToolbar: function (pos){
		var self = this;
		var rte = new Element( 'div', {'class':'rteRemove MooRTE '+(!pos||pos=='n'?'rteHide':''), 'contentEditable':false })
					.adopt(new Element('div', {'class':'RTE '+self.options.skin }))
					.inject(document.body);
		MooRTE.activeBar = rte; // not used!
		MooRTE.Utilities.addElements(this.options.buttons, rte.getFirst(), 'bottom', 'rteGroup_Auto'); ////3rdel. Should give more appropriate name. Also, allow for last of multiple classes  
		return rte;
	}
	, positionToolbar: function (el, rte){
		el.set('contentEditable', true).addClass('rteShow');
		var o = this.options
		  , elSize = el.getCoordinates()
		  , bw = el
				.addClass('rte'+(o.stretch?'':'No')+'Stretch')
				.getStyle('border-width')
				.match(/(\d)/g)
		  , rteHeight = rte
				.removeClass('rteHide')
				.setStyle('width', elSize.width-(o.floating?0:bw[1]*1+bw[3]*1))
				.getFirst()
				.getCoordinates()
				.height;

		if (o.floating){
			if (o.padFloat){
				var pad = {before:'margin-top',after:'margin-after',top:'padding-top',bottom:'padding-bottom'}[o.where];
				el.setStyle(pad, parseInt(el.getStyle(pad)) + rteHeight);
			}
			rte
				.setStyles({ 'left': elSize.left, 'top': (elSize.top - rteHeight > 0 ? elSize.top : elSize.bottom) })
				.addClass('rteFloat')
				.getFirst()
				.addClass('rteFloat');
		}		
		//else rte.inject(el,'top').setStyle('margin','-'+el.getStyle('padding-top')+' -'+el.getStyle('padding-left'));
		else el.setStyle('padding-top', el.getStyle('padding-top').slice(0,-2)*1 + rteHeight).grab(rte,'top');
	}
	, textArea: function (el){
		var div = new Element('div', {
			text:el.get('value'),
			'class':'rteTextArea '+el.get('class'), 
			'styles':{width:el.getSize().x}
		}).setStyle(Browser.ie?'height':'min-height',el.getSize().y).inject(el,'before');
		
		var form = el.addClass('rteHide').getParent('form');
		if (form) form.addEvent('submit',function(e){
			el.set('value', MooRTE.Utilities.clean(div)); 
		});
		return div;
	}
});

MooRTE.Range = {
	create: function(range){
		var sel = window.document.selection || window.getSelection();
		if (!sel) return null;
		return MooRTE.ranges[range || 'a1'] = sel.getRangeAt ? sel.getRangeAt(0) : sel.createRange();
	}
	, get: function(type, range){
		if (!range) range = MooRTE.Range.create();
		
		switch (type){
			case 'text': return range.text || range.toString();
			case 'node': return range.cloneContents 
				? range.cloneContents() 
				: new Element('div', {html:range.htmlText});
			default: case 'html': 
				var content = range.htmlText;
				if (!content){
					var html = range.cloneContents();
					MooRTE.Range.content.empty().appendChild(html);
					content = MooRTE.Range.content.innerHTML;
				}; 
				return content;
		}
	}
	, set: function(range){
		range = MooRTE.ranges[range || 'a1'];
		if (range.select) range.select();
		else {
			var sel = window.getSelection();
			sel.removeAllRanges();
			sel.addRange(range);
		}
		return MooRTE.Range;
	}
	, insert: function(what, range){ //html option that says if text or html?
		if (Browser.ie){
			if(!range) range = MooRTE.Range.create();
			range.pasteHTML(what); 
		} else MooRTE.Utilities.exec('insertHTML',what);
		return MooRTE.Range;
	}
	, wrap: function(element, options, range){
		if (!range) range = MooRTE.Range.create();
		var El = new Element(element, options);
		try {
			Browser.ie 
				? range.pasteHTML(El.set('html', range.htmlText).outerHTML) 
				: range.surroundContents(El);
		} catch(e) {
			if (e.code == 1) return false; // "Bad Boundary Points"
		}
		return El;
	}
	, wrapText: function(element, caller){
		var area = caller.getParent('.RTE').getElement('textarea');
		if (!(element.substr(0,1)=='<')) element = '<span style="'+element+'">';
		if (!Browser.ie){
			var start = area.selectionStart
			  , reg = new RegExp('(.{'+start+'})(.{'+(area.selectionEnd-start)+'})(.*)', 'm').exec(area.get('value'))
			  , el = element + reg[2] + '</' + element.match(/^<(\w+)/)[1] + '>';
			area.set('value', reg[1] + el + reg[3]).selectionEnd = start + el.length;
		} else {
			var el = new Element(element||'span', {html:range.get()});
			range.pasteHTML(el);
		}
		return MooRTE.Range;
	}
	, replace: function(node, range){
		if (!range) range = MooRTE.Range.create();
		if (Browser.ie){
			var id = document.uniqueID;
			range.pasteHTML("<span id='" + id + "'></span>");
			node.replaces(document.id(id));
		} else {
			MooRTE.Utilities.exec('inserthtml', node); return;  //ToDo: is this really supposed to return?!
			range.deleteContents();  // Consider using Range.insert() instead of the following (Olav's method).
			if (range.startContainer.nodeType==3) {
				var refNode = range.startContainer.splitText(range.startOffset);
				refNode.parentNode.insertBefore(node, refNode);
			} else {
				var refNode = range.startContainer.childNodes[range.startOffset];
				range.startContainer.insertBefore(node, refNode);
			}	
		}
	}
	, parent: function(range){
		if (!(range = range || MooRTE.Range.create())) return false;
		return Browser.ie ? 
			typeOf(range) == 'object' ? range.parentElement() : range
			: range.commonAncestorContainer;
	}
};

(function(){
		if (Browser.firefox) MooRTE.Range.selection = window.getSelection();
		if (!Browser.ie) MooRTE.Range.content = new Element('div');
}());

MooRTE.Utilities = {
	exec: function(args){
		args = Array.from(args);
		document.execCommand(args[0], args[2]||null, args[1]||false);
	}
	, shortcuts: function(e){
		if (e.key=='enter'){
			if (!Browser.ie) return;
			e.stop();
			return MooRTE.Range.insert('<br/>');
		}
		var be, btn, shorts = MooRTE.activeBar.retrieve('shortcuts');	

		if (e && e.control && shorts[e.key]){
			e.stop();
			btn = MooRTE.activeBar.getElement('.rte'+shorts[e.key]);
			btn.fireEvent('mousedown', btn);
		};
	}
	, updateBtns: function(e){
		var val
		  , update = MooRTE.activeBar.retrieve('update');

		update.state.each(function(vals){
			if (vals[2])
				vals[2].call(vals[1], vals[0]);
			else {
				try { val = window.document.queryCommandState(vals[0]) }
				catch(e){ val = false }
				vals[1][(val ? 'add' : 'remove') + 'Class']('rteSelected');
				// Try/Catch works around issue #2.
				// Note1.
			}
		});
		update.value.each(function(vals){
			val = window.document.queryCommandValue(vals[0]);
			if (val) vals[2].call(vals[1], vals[0], val);
		});
		update.custom.each(function(){
			vals[2].call(vals[1], vals[0]);
		});
		if (Browser.firefox && MooRTE.Range.selection.anchorNode.id == 'rteMozFix'){
			MooRTE.Range.selection.extend(MooRTE.Range.selection.anchorNode.parentNode, 0);
			//MooRTE.Range.selection.collapseToStart();
		}
	}
	, addElements: function(buttons, place, relative, name){
		if (!place) place = MooRTE.activeBar.getFirst();
		if (!MooRTE.btnVals.args) MooRTE.btnVals.combine(['args','shortcut','element','onClick','img','onLoad','source']);
		var parent = place.hasClass('MooRTE') ? place : place.getParent('.MooRTE'), btns = []; 
		if (typeOf(buttons) == 'string'){
			buttons = buttons.replace(/'([^']*)'|"([^"]*)"|([^{}:,\][\s]+)/gm, "'$1$2$3'");
			buttons = buttons.replace(/((?:[,[:]|^)\s*)('[^']+'\s*:\s*'[^']+'\s*(?=[\],}]))/gm, "$1{$2}");
			buttons = buttons.replace(/((?:[,[:]|^)\s*)('[^']+'\s*:\s*{[^{}]+})/gm, "$1{$2}");
			while (buttons != (buttons = buttons.replace(/((?:[,[]|^)\s*)('[^']+'\s*:\s*\[(?:(?=([^\],\[]+))\3|\]}|[,[](?!\s*'[^']+'\s*:\s*\[([^\]]|\]})+\]))*\](?!}))/gm, "$1{$2}")));
			buttons = JSON.decode('['+buttons+']');
		}
	
		// The following was a loop till 2009-04-28 12:11:22, commit fc4da3. It was then removed, probably by mistake, till 2009-12-09 13:18:15 
		var loopStop = loop = 0; //Remove loopstop variable after testing!!
		do {
			if (btns[0]) buttons = btns, btns = [];
			Array.from(buttons).each(function(item){
				switch(typeOf(item)){
					case 'string': btns.push(item); break;
					case 'array' : item.each(function(val){btns.push(val)}); loop = (item.length==1); break;	//item.each(buttons.push);
					case 'object': Object.each(item, function(val,key){ btns.push(Object.set(key,val)) }); break;			
				}
			})
		} while (loop && ++loopStop < 5); //Remove loopstop variable after testing!!

		btns.each(function(btn){
			var btnVals;
			if (Type.isObject(btn)){
				btnVals = Object.values(btn)[0];
				btn = Object.keys(btn)[0];
			}
			var btnClass = btn.split('.'); //[btn,btnClass] = btn.split('.'); - Code sunk by IE6
			btn = btnClass.shift();

			var e = parent.getElement('[class~='+name+']');//|| parent.getElement('.rte'+btn );
			// console.log('addElements called. buttons:',buttons,', btn is:',btn,', e is:',e,', func args are:',arguments);
			if (!e || name == 'rteGroup_Auto'){
				var bgPos = 0, val = MooRTE.Elements[btn], input = 'text,password,submit,button,checkbox,file,hidden,image,radio,reset'.contains(val.type), textarea = (val.element && val.element.toLowerCase() == 'textarea');
				var state = 'bold,italic,underline,strikethrough,subscript,superscript,unlink,insertorderedlist,insertunorderedlist'.contains(btn.toLowerCase()+',');  //Note1
				
				var properties = Object.append({
					href:'#',
					unselectable:(input || textarea ? 'off' : 'on'),
					title: btn + (val.shortcut ? ' (Ctrl+'+val.shortcut.capitalize()+')':''),	
					styles: val.img ? (isNaN(val.img) ? {'background-image':'url('+val.img+')'} : {'background-position':'0 '+(-20*val.img)+'px'}):{},
					events: {
						mousedown: function(e){
							var bar = MooRTE.activeBar = this.getParent('.MooRTE')
							  , source = bar.retrieve('source')
							  , fields = bar.retrieve('fields');
							// If the active field is not one of those controlled by the active tooolbar, update the activeField to one that is.
							// Should probably go through all fields connected to this toolbar looking for the one which contains the selected text.
							if (!fields.contains(MooRTE.activeField)) MooRTE.activeField = fields[0];//.focus()
							
							// Works around https://mootools.lighthouseapp.com/projects/2706/tickets/1113-contains-not-including-textnodes
							// Should be: if (!MooRTE.activeField.contains(MooRTE.Range.parent())) return;
							var holder = MooRTE.Range.parent();
							if (Browser.webkit && holder.nodeType == 3) holder = holder.parentElement; 
							if (!MooRTE.activeField.contains(holder)) return;
							
							if (!val.onClick && !source && (!val.element || val.element == 'a')) MooRTE.Utilities.exec(val.args||btn);
							else MooRTE.Utilities.eventHandler(source || 'onClick', this, btn);
							if (e && e.stop) input || textarea ? e.stopPropagation() : e.stop();
						}
					}
				}, val);
				
				MooRTE.btnVals[val.element ? 'include' : 'erase']('href')
					.each(function(key){
						delete properties[key];
					});
				
				e = new Element(input && !val.element ? 'input' : val.element || 'a', properties)
					.addClass((name||'') + ' rte' + btn + (btnClass ? ' rte' + btnClass : ''))
					.inject(place, relative);
				
				if (val.onUpdate || state)
					parent.retrieve('update', {'value':[], 'state':[], 'custom':[] })[ 
						'fontname,fontsize,backcolor,forecolor,hilitecolor,justifyleft,justifyright,justifycenter,'.contains(btn.toLowerCase()+',') ? 
						'value' : (state ? 'state' : 'custom')
					].push([btn, e, val.onUpdate]);
				//if (val.shortcut) parent.retrieve('shortcuts',{}).set(val.shortcut,btn);
				if (val.shortcut) parent.retrieve('shortcuts',{})[val.shortcut] = btn;
				MooRTE.Utilities.eventHandler('onLoad', e, btn);

				var sub = btnVals || val.contains;
				if (sub) MooRTE.Utilities.addElements(sub, e);
				//if (collection.getCoordinates().top < 0)toolbar.addClass('rteTopDown'); //untested!!
			}
			e.removeClass('rteHide')
		})
			
	}
	, eventHandler: function(onEvent, caller, name){
		// UNTESTED: Function rewritten do to removal of $unlink in v1.3  //if(!event) return;
		// Must check if function or string is modified now that ulink is gone. Should be OK.
		var event = MooRTE.Elements[name][onEvent];
		switch(typeOf(event)){
			case 'function':
				event.call(caller, name, onEvent); break;
			case 'array':
				event = Array.clone(event);
				event.push(name, onEvent);
				MooRTE.Utilities[event.shift()].apply(caller, event); break;
			case 'string':
				onEvent == 'source' && onEvent.substr(0,2) != 'on'
					? MooRTE.Range.wrapText(event, caller)
					: MooRTE.Utilities.eventHandler(event, caller, name);
		}
	}
	, group: function(elements, name){
		var self = this, parent = this.getParent('.RTE');
		MooRTE.btnVals.combine(['onExpand','onHide','onShow','onUpdate']);
		Object.each(MooRTE.Elements[name].hides||self.getSiblings('*[class*=rteAdd]'), function(el){ 
			el.removeClass('rteSelected');
			parent.getFirst('.rteGroup_'+(el.get('class').match(/rteAdd([^ ]+?)\b/)[1])).addClass('rteHide');	//In the siteroller php selector engine, one can get a class that begins with a string by combining characters - caller.getSiblings('[class~^=rteAdd]').  Unfortunately, Moo does not support this!
			MooRTE.Utilities.eventHandler('onHide', self, name);
		});
		this.addClass('rteSelected rteAdd'+name);
		MooRTE.Utilities.addElements(elements, this.getParent('[class*=rteGroup_]'), 'after', 'rteGroup_'+name);//3rdel
		MooRTE.Utilities.eventHandler('onShow', this, name);	
	}
	, clipStickyWin: function(caller){
		// ToDo: create the instance of the AssetLoader, once, afterwrds, just call the load function.
		if (Browser.firefox || (Browser.webkit && caller=='paste')) 
			if (window.AssetLoader) new AssetLoader({
				onComplete: function(command){
					var body = "For your protection, "+(Browser.webkit?"Webkit":"Firefox")+" does not allow access to the clipboard.<br/>  <b>Please use Ctrl+C to copy, Ctrl+X to cut, and Ctrl+V to paste.</b><br/>\
						(Those lucky enough to be on a Mac use Cmd instead of Ctrl.)<br/><br/>\
						If this functionality is important, consider switching to a browser such as IE,<br/> which will allow us to easily access [and modify] your system."; 
					MooRTE.Elements.clipPop = new StickyWin.Modal({content: StickyWin.ui('Security Restriction', body, {buttons:[{ text:'close'}]})});	
					MooRTE.Elements.clipPop.hide();
				}
			}, 'StickyWinModalUI.js');
	}
	, clean: function(html, options){
	
		options = Object.append({
			xhtml   : false, 
			semantic: true, 
			remove  : ''
		}, options);
		
		var br = '<br'+(xhtml?'/':'')+'>';
		var xhtml = [
			[/(<(?:img|input)[^\/>]*)>/g, '$1 />']									// Greyed out -  make img tags xhtml compatable 	#if (this.options.xhtml)
		];
		var semantic = [
			[/<li>\s*<div>(.+?)<\/div><\/li>/g, '<li>$1</li>'],						// remove divs from <li>		#if (Browser.Engine.trident)
			[/<span style="font-weight: bold;">(.*)<\/span>/gi, '<strong>$1</strong>'],	 			//
			[/<span style="font-style: italic;">(.*)<\/span>/gi, '<em>$1</em>'],					//
			[/<b\b[^>]*>(.*?)<\/b[^>]*>/gi, '<strong>$1</strong>'],									//
			[/<i\b[^>]*>(.*?)<\/i[^>]*>/gi, '<em>$1</em>'],											//
			[/<u\b[^>]*>(.*?)<\/u[^>]*>/gi, '<span style="text-decoration: underline;">$1</span>'],	//
			[/<p>[\s\n]*(<(?:ul|ol)>.*?<\/(?:ul|ol)>)(.*?)<\/p>/ig, '$1<p>$2</p>'], 				// <p> tags around a list will get moved to after the list.  not working properly in safari? #if (['gecko', 'presto', 'webkit'].contains(Browser.Engine.name))
			[/<\/(ol|ul)>\s*(?!<(?:p|ol|ul|img).*?>)((?:<[^>]*>)?\w.*)$/g, '</$1><p>$2</p>'],		// ''
			[/<br[^>]*><\/p>/g, '</p>'],											// Remove <br>'s that end a paragraph here.
			[/<p>\s*(<img[^>]+>)\s*<\/p>/ig, '$1\n'],				 				// If a <p> only contains <img>, remove the <p> tags	
			[/<p([^>]*)>(.*?)<\/p>(?!\n)/g, '<p$1>$2</p>\n'], 						// Break after paragraphs
			[/<\/(ul|ol|p)>(?!\n)/g, '</$1>\n'],	    							// Break after </p></ol></ul> tags
			[/><li>/g, '>\n\t<li>'],          										// Break and indent <li>
			[/([^\n])<\/(ol|ul)>/g, '$1\n</$2>'],    								// Break before </ol></ul> tags
			[/([^\n])<img/ig, '$1\n<img'],    										// Move images to their own line
			[/^\s*$/g, '']										        			// Delete empty lines in the source code (not working in opera)
		];
		var nonSemantic = [	
			[/\s*<br ?\/?>\s*<\/p>/gi, '</p>']										// if (!this.options.semantics) - Remove padded paragraphs
		];	
		var appleCleanup = [
			[/<br class\="webkit-block-placeholder">/gi, "<br />"],					// Webkit cleanup - add an if(webkit) check
			[/<span class="Apple-style-span">(.*)<\/span>/gi, '$1'],				// Webkit cleanup - should be corrected not to get messed over on nested spans - SG!!!
			[/ class="Apple-style-span"/gi, ''],									// Webkit cleanup
			[/<span style="">/gi, ''],												// Webkit cleanup	
			[/^([\w\s]+.*?)<div>/i, '<p>$1</p><div>'],								// remove stupid apple divs 	#if (Browser.Engine.webkit)
			[/<div>(.+?)<\/div>/ig, '<p>$1</p>']									// remove stupid apple divs 	#if (Browser.Engine.webkit)
		];
		var cleanup = [
			[/<br\s*\/?>/gi, br],													// Fix BRs, make it easier for next BR steps.
			[/><br\/?>/g, '>'],														// Remove (arguably) useless BRs
			[/^<br\/?>/g, ''],														// Remove leading BRs - perhaps combine with removing useless brs.
			[/<br\/?>$/g, ''],														// Remove trailing BRs
			[/<br\/?>\s*<\/(h1|h2|h3|h4|h5|h6|li|p)/gi, '</$1'],					// Remove BRs from end of blocks
			[/<p>\s*<br\/?>\s*<\/p>/gi, '<p>\u00a0</p>'],							// Remove padded paragraphs - replace with non breaking space
			[/<p>(&nbsp;|\s)*<\/p>/gi, '<p>\u00a0</p>'],							// ''
			[/<p>\W*<\/p>/g, ''],													// Remove ps with other stuff, may mess up some formatting.
			[/<\/p>\s*<\/p>/g, '</p>'],												// Remove empty <p> tags
			[/<[^> ]*/g, function(match){return match.toLowerCase();}],				// Replace uppercase element names with lowercase
			[/<[^>]*>/g, function(match){											// Replace uppercase attribute names with lowercase
			   match = match.replace(/ [^=]+=/g, function(match2){return match2.toLowerCase();});
			   return match;
			}],
			[/<[^>]*>/g, function(match){											// Put quotes around unquoted attributes
			   match = match.replace(/( [^=]+=)([^"][^ >]*)/g, "$1\"$2\"");
			   return match;
			}]
		];
		var depracated = [
			// The same except for BRs have had optional space removed
			[/<p>\s*<br ?\/?>\s*<\/p>/gi, '<p>\u00a0</p>'],							// modified as <br> is handled previously
			[/<br>/gi, "<br />"],													// Replace improper BRs if (this.options.xhtml) Handled at very beginning			
			[/<br ?\/?>$/gi, ''],													// Remove leading and trailing BRs
			[/^<br ?\/?>/gi, ''],													// Remove trailing BRs
			[/><br ?\/?>/gi,'>'],													// Remove useless BRs
			[/<br ?\/?>\s*<\/(h1|h2|h3|h4|h5|h6|li|p)/gi, '</$1'],					// Remove BRs right before the end of blocks
			//Handled with DOM:
			[/<p>(?:\s*)<p>/g, '<p>']												// Remove empty <p> tags
		];
		
		var washer;
		if (typeOf(html)=='element'){
			washer = html;
			var bar = washer.retrieve('bar');
			if (washer.contains(bar) && washer != bar) washer.moorte('remove');
			//if(washer.hasChild(washer.retrieve('bar'))) washer.moorte('remove');
		} else washer = $('washer') || new Element('div',{id:'washer'}).inject(document.body);

		washer.getElements('p:empty'+(options.remove ? ','+options.remove : '')).destroy();
		if (!Browser.firefox) washer.getElements('p>p:only-child').each(function(el){ var p = el.getParent(); if(p.childNodes.length == 1) el.replaces(p)  });  // The following will not apply in Firefox, as it redraws the p's to surround the inner one with empty outer ones.  It should be tested for in other browsers. 
		html = washer.get('html');
		if (washer != $('washer')) washer.moorte();
		
		if (xhtml) cleanup.append(xhtml);
		if (semantic) cleanup.append(semantic);
		if (Browser.webkit) cleanup.append(appleCleanup);

		// var loopStop = 0;  //while testing.
		do {
			var cleaned = html;
			cleanup.each(function(reg){ html = html.replace(reg[0], reg[1]); });		
		} while (cleaned != html); // && ++loopStop <3
		
		return html.trim();
	}
	, fontsize: function(dir, size){
		if (size == undefined)
			size = window.document.queryCommandValue('fontsize') 
				|| MooRTE.Range.parent().getStyle('font-size');
		
		if (size == +size) size = +size + dir;
		else {
			// MooRTE.Utilities.convertunit(size[0],size[1],'px'); Convert em's, xx-small, etc.
			size = size.split(/([^\d]+)/)[0];
			[0,10,13,16,18,24,32,48].every(function(s,i){	
				if ((s - size) < 0) return true;
				size = !(s - size) || dir < 0 ? i + dir : i;
			});
		}
		MooRTE.Utilities.exec('fontsize', size);		
	}
};

Element.implement({
	moorte: function(){
		var removed
		  , params = Array.link(arguments, {'options': Type.isObject, 'cmd': Type.isString})
		  , bar = this.hasClass('MooRTE') ? this : this.retrieve('bar') || '';
		
		if (!params.cmd || 'create,show,restore'.contains(params.cmd.toLowerCase())){
			if (removed = this.retrieve('removed')){
				bar.inject(removed[0], removed[1])
					.retrieve('fields').each(function(el){
						el.hasClass('rteTextArea')
							? el
								.addClass('rteShow')
								.removeClass('rteHide')
								.getNext('textarea')
								.addClass('rteHide')
								.removeClass('rteShow')
							: el
								.set('contentEditable', true)
								.cloneEvents(el.retrieve('elEvents'));
					});
				this.eliminate('removed');
			}
			return bar
				? this.removeClass('rteHide') 
				: new MooRTE(Object.append(params.options||{},{'elements':this}));
		} else {
			if (!bar) return false;
			switch (params.cmd.toLowerCase()){
				case 'hide': bar.addClass('rteHide'); break;
				case 'remove':
					var location = bar.getPrevious() 
						? [bar.getPrevious(),'after'] 
						: [bar.getParent(),'top'];
					this.store('removed', location);
					bar.dispose().retrieve('fields').each(function(el){
						el.hasClass('rteTextArea')
							? el
								.addClass('rteHide')
								.removeClass('rteShow')
								.getNext('textarea')
								.addClass('rteShow')
								.removeClass('rteHide')
							: el
								.store('elEvents', new Element('div').cloneEvents(el))
								.removeEvents()
								.set('contentEditable',false);
					});
				break;
				case 'destroy':
					bar.retrieve('fields').each(function(el){
						if (el.hasClass('rteTextArea')){
							el.getNext('textarea').removeClass('rteHide');
							el.destroy();
						} else el.eliminate('bar').removeEvents().set('contentEditable',false);
					});
					bar.destroy();
			}
		}
	}
});
Elements.implement({ 
	moorte:function(){
		var opts = Array.link(arguments, { 'options': Object.type }).options;
		return new MooRTE(Object.append(opts||{}, {'elements':this}));
	}
});


MooRTE.Elements = {

   // Groups are Samples - They can be created manually, or dynamically by the download builder.
	// Groups (Menus)
     Main			:{text:'Main',   'class':'rteText', onClick:'onLoad', onLoad:['group',{Toolbar:['start','bold','italic','underline','strikethrough','Justify','Lists','Indents','subscript','superscript']}] }
   , File			:{text:'File',   'class':'rteText', onClick:['group',{Toolbar:['start','save','cut','copy','paste','redo','undo','selectall','removeformat','viewSource']}] }
   , Font			:{text:'Font',   'class':'rteText', onClick:['group',{Toolbar:['start','fontsize','decreasefontsize','increasefontsize','backcolor','forecolor']}] }
   , Insert			:{text:'Insert', 'class':'rteText', onClick:['group',{Toolbar:['start','inserthorizontalrule', 'blockquote','hyperlink']}] }//'Upload Photo'
   , View			:{text:'Views',  'class':'rteText', onClick:['group',{Toolbar:['start','Html/Text']}] }

   // Groups (Flyouts)
   , Justify		:{img:06, 'class':'Flyout rteSelected', contains:'div.Flyout:[justifyleft,justifycenter,justifyright,justifyfull]' }
   , Lists			:{img:14, 'class':'Flyout', contains:'div.Flyout:[insertorderedlist,insertunorderedlist]' }
   , Indents		:{img:11, 'class':'Flyout', contains:'div.Flyout:[indent,outdent]' }
	                
   // Buttons
   , div				:{ element:'div' }
   , bold		 	:{ img:1, shortcut:'b', source:'<b>' }
   , italic		 	:{ img:2, shortcut:'i', source:'<i>' }
   , underline	 	:{ img:3, shortcut:'u', source:'<u>' }
   , strikethrough:{ img:4 }
   , justifyleft	:{ img:6
						 , title:'Justify Left'
						 , onUpdate:function(cmd,val){
								var t = MooRTE
											.activeField
											.retrieve('bar')
											.getElement('.rtejustify' + (val == 'justify' ? 'full' : val))
								  , pos = t.addClass('rteSelected').getStyle('background-position');
								t.getParent()
									.getParent()
									.setStyle('background-position', pos);
							}
						 }
   , justifyfull	:{ img:7, title:'Justify Full'  }
   , justifycenter:{ img:8, title:'Justify Center'}
   , justifyright	:{ img:9, title:'Justify Right' }
   , subscript		:{ img:18 }
   , superscript	:{ img:17 }
   , outdent		:{ img:11 }
   , indent			:{ img:12 }
   , insertorderedlist:  { img:14, title:'Numbered List' }
   , insertunorderedlist:{ img:15, title:'Bulleted List' }
   , selectall   	:{ img:25, title:'Select All (Ctrl + A)' }
   , removeformat	:{ img:26, title:'Clear Formatting' }
   , undo        	:{ img:31, title:'Undo (Ctrl + Z)' }
   , redo         :{ img:32, title:'Redo (Ctrl+Y)' }
   , inserthorizontalrule:{img:56, title:'Insert Horizontal Line'}
   , cut				:{ img:20
						 , title:'Cut (Ctrl+X)'
						 , onLoad:MooRTE.Utilities.clipStickyWin
						 , onClick:function(action){ Browser.firefox ? MooRTE.Elements.clipPop.show() : MooRTE.Utilities.exec(action); }
						 }
   , copy			:{ img:21
						 , title:'Copy (Ctrl+C)'
						 , onLoad:MooRTE.Utilities.clipStickyWin
						 ,	onClick: function(action){ 
								Browser.firefox 
									? MooRTE.Elements.clipPop.show() 
									: MooRTE.Utilities.exec(action); 
							}
						 }
   , paste			:{ img:22
						 , title: 'Paste (Ctrl+V)'
						 , onLoad: MooRTE.Utilities.clipStickyWin //onLoad:function() { MooRTE.Utilities.clipStickyWin(1) },
						 , onClick: function(action){ 
								Browser.firefox || Browser.webkit 
									? MooRTE.Elements.clipPop.show() 
									: MooRTE.Utilities.exec(action); 
							}
						 }
   , save			:{ img:27
						 , src:'http://siteroller.net/test/save.php'
						 , onClick:function(){
								var content = { 'page': window.location.pathname }
								  , next = 0; 
								content.content = []; 
								this.getParent('.MooRTE').retrieve('fields').each(function(el){
									content['content'][next++] = MooRTE.Utilities.clean(el);
								});
								new Request(
									{ url: MooRTE.Elements.save.src
									, onComplete:function(response){alert("Your submission has been received:\n\n"+response);}
									}
								).send(Object.toQueryString(content));
							}
						 }
   , 'Html/Text'	:{ img:'26', onClick:['DisplayHTML'] }
   , DisplayHTML	:{ element: 'textarea'
						 , unselectable:'off'
						 , 'class': 'displayHtml'
						 , init:function(){ 
								var el= this.getParent('.MooRTE').retrieve('fields')
								  , p = el.getParent()
								  , size = (p.hasClass('rteTextArea') ? p : el).getSize(); 
								this.set({'styles':{width:size.x, height:size.y}, 'text':el.innerHTML.trim()})
							}
						 }
   , colorpicker	:{ 'element':'img', 'src':'images/colorPicker.jpg', 'class':'colorPicker', onClick:function(){
							//c[i] = ((hue - brightness) * saturation + brightness) * 255;  hue=angle of ColorWheel.  saturation =percent of radius, brightness = scrollWheel.
							//for(i=0;i<3;i++) c[i] = ((((h=Math.abs(++hue)) < 1 ? 1 : h > 2 ? 0 : -(h-2)) - brightness) * saturation + brightness) * 255;  
							//c[1] = -(c[2] - 255*saturation);var hex = c.rgbToHex();
							//var c, radius = this.getSize().x/2, x = mouse.x - radius, y = mouse.y - radius, brightness = hue.y / hue.getSize().y, hue = Math.atan2(x,y)/Math.PI * 3 - 2, saturation = Math.sqrt(x*x+y*y) / radius;
							var c, radius = this.getSize().x/2, x = mouse.x - radius, y = mouse.y - radius, brightness = hue.y / hue.getSize().y, hue = Math.atan2(x,y)/Math.PI * 3 + 1, saturation = Math.sqrt(x*x+y*y) / radius;
							for(var i=0;i<3;i++) c[i] = (((Math.abs((hue+=2)%6 - 3) < 1 ? 1 : h > 2 ? 0 : -(h-2)) - brightness) * saturation + brightness) * 255;  
							var hex = [c[0],c[2],c[1]].rgbToHex();
						 }}
   , hyperlink		:{ img:46
					   , title:'Create hyperlink'
					   , onClick:function(){
								MooRTE.Range.create();
								$('popTXT').set('value',MooRTE.Range.get('text', MooRTE.ranges.a1));
								MooRTE.Elements.linkPop.show();
						}
					   , onLoad: function(){
							if (window.Asset) new Asset.javascript('StickyWinModalUI.js', {
								self: this
								, path: 'CMS/library/thirdparty/MooRTE/Source/Assets/scripts/'
								, onComplete: function(){
									var body = "<span style='display:inline-block; width:100px'>Text of Link:</span><input id='popTXT'/><br/>\
												<span style='display:inline-block; width:100px'>Link To Location:</span><input id='popURL'/><br/>\
												<input type='radio' name='pURL'  value='web' checked/>Web<input type='radio' name='pURL' id='pURL1' value='email'/>Email"
									  , buttons = 
										[ { text:'cancel' }
										, { text:'OK'
										  , onClick: function(){
												// if(me.getParent('.MooRTE').hasClass('rteHide'))MooRTE.ranges.a1.commonAncestorContainer.set('contenteditable',true);
												MooRTE.Range.set();
												var value = $('popURL').get('value');
												if ($('pURL1').get('checked')) value = 'mailto:' + value;
												MooRTE.Utilities.exec(value ? 'createlink' : 'unlink', value); 
												} 
										  }
										];
									MooRTE.Elements.linkPop = new StickyWin.Modal({content: StickyWin.ui('Edit Link', body, {buttons:buttons})});	
									MooRTE.Elements.linkPop.hide();
								}
							})
						}}  // Ah, but its a shame this ain't LISP ;) ))))))))))!
   , 'Upload Photo':{ img: 15
					   , onLoad: function(){
							MooRTE.Utilities.assetLoader({ //new Loader({
								scripts: ['/siteroller/classes/fancyupload/fancyupload/source/Swiff.Uploader.js'], 
								styles:  ['/siteroller/classes/fancyupload/fancyupload/source/Swiff.Uploader.css'], 
								onComplete:function(){
									var uploader = new Swiff.Uploader({
										verbose: true 
										, target: this
										, queued: false
										, multiple: false
										, instantStart: true
										, fieldName:'photoupload' 
										, typeFilter: { 'Images (*.jpg, *.jpeg, *.gif, *.png)': '*.jpg; *.jpeg; *.gif; *.png'}
										, path: '/siteroller/classes/fancyupload/fancyupload/source/Swiff.Uploader.swf'
										, url: '/siteroller/classes/moorte/source/plugins/fancyUpload/uploadHandler.php'
										, onButtonDown :function(){ MooRTE.Range.set() }
										, onButtonEnter :function(){ MooRTE.Range.create() }
										, onFileProgress: function(val){  } //self.set('text',val);
										, onFileComplete: function(args){ MooRTE.Range.set().exec('insertimage',JSON.decode(args.response.text).file) }
									});
									this.addEvent('mouseenter',function(){ uploader.target = this; uploader.reposition(); })
								}
							})
						}							
					}
   , blockquote	:{ img:59, onClick:function(){	MooRTE.Range.wrap('blockquote'); } }
   , start			:{ element:'span' }
   , viewSource		:{ img:35, onClick:'source', source:function(btn){
						var bar = MooRTE.activeBar, el = bar.retrieve('fields')[0], ta = bar.getElement('textarea.rtesource');
						if(this.hasClass('rteSelected')){
							bar.eliminate('source');
							this.removeClass('rteSelected');
							if(el.contains(el.retrieve('bar'))) el.moorte('remove'); //was hasChild
							el.set('html',ta.addClass('rteHide').get('value')).moorte();
						} else {
							bar.store('source','source');
							if(ta){
								this.addClass('rteSelected');
								ta.removeClass('rteHide').set('text',MooRTE.Utilities.clean(bar.retrieve('fields')[0]));
							} else MooRTE.Utilities.group.apply(this, ['source', btn]);
						}
					}}
   , source			:{ element:'textarea', 'class':'displayHtml', unselectable:'off', onLoad:function(){ 
						var bar = this.getParent('.MooRTE'), el = bar.retrieve('fields')[0], size = el.getSize(), barY = bar.getSize().y;
						this.set({'styles':{ width:size.x, height: size.y - barY, top:barY }, 'text':MooRTE.Utilities.clean(el) });
					}}
   , input			:{ img:59, 
						onClick:function(){ MooRTE.Range.insert("<input>") } 
					}
   , submit			:{ img:59, 
						onClick:function(){ MooRTE.Range.insert('<input type="submit" value="Submit">') }
					}
   , cleanWord		:{	onClick: function() {
						var s = this.replace(/\r/g, '\n').replace(/\n/g, ' ');
						var rs = [
							/<!--.+?-->/g,			// Comments
							/<title>.+?<\/title>/g,	// Title
							/<(meta|link|.?o:|.?style|.?div|.?head|.?html|body|.?body|.?span|!\[)[^>]*?>/g, // Unnecessary tags
							/ v:.*?=".*?"/g,		// Weird nonsense attributes
							/ style=".*?"/g,		// Styles
							/ class=".*?"/g,		// Classes
							/(&nbsp;){2,}/g,		// Redundant &nbsp;s
							/<p>(\s|&nbsp;)*?<\/p>/g// Empty paragraphs
						]; 
						rs.each(function(regex) {
							s = s.replace(regex, '');
						});
						return s.replace(/\s+/g, ' ');
					} }
   , decreasefontsize:{  img:42, 
						onClick: function(){
							if (!Browser.firefox) return MooRTE.Utilities.fontsize.pass(-1);
						}()
						/* 	Fontsize was originally only supposed to accept valuies between 1 - 7.
								It was afterwards changed to accept a much, much greater range of values, but not a single browser has a correct implementation.
									http://msdn.microsoft.com/en-us/library/ms530759(VS.85).aspx
									http://msdn.microsoft.com/en-us/library/aa219652(office.11).aspx
									(Linked to by http://msdn.microsoft.com/en-us/library/aa220275(office.11).aspx)
								
								Table of values:
									
								Webkit is particularly bad:
									#12874 [WontFix]: execCommand FontSize -webkit-xxx-large instead of passed px value - https://bugs.webkit.org/show_bug.cgi?id=12874
										Now this gives me (no matter what I pass): <span class="Apple-style-span" style="font-size: -webkit-xxx-large;">Text</span>		
									#21679 [New]: execCommand FontSize does not change size of background color - https://bugs.webkit.org/show_bug.cgi?id=21679
										Double the text height, the previous background color will only cover the bottom half of the new text.
									#21033 [Resolved]: QueryCommandValue('FontSize') returns bogus pixel values - https://bugs.webkit.org/show_bug.cgi?id=21033
										The actual text is much smaller than the px values Safari gives. WK should return 1-7, as in IE and FF.
									The actual ridiculous results of the command:
										https://bug-21033-attachments.webkit.org/attachment.cgi?id=66960
										Test: http://gitorious.org/webkit/webkit/blobs/860c3cf250187b1679ce9701fe5892a482d319e6/LayoutTests/editing/execCommand/query-font-size.html
										Results: http://gitorious.org/webkit/webkit/blobs/860c3cf250187b1679ce9701fe5892a482d319e6/LayoutTests/editing/execCommand/query-font-size-expected.txt
										
										Possible values "reference a table of font sizes computed by the user-agent". Possible values are:
										http://www.w3schools.com/CSS/pr_font_font-size.asp
										http://style.cleverchimp.com/font_size_intervals/altintervals.html
								*/
								//MooRTE.Range.parent().parentElement.parentElement.getElements('span[style^="font-size:"]').setStyle('font-size',+fontsize[0] - 1 + fontsize[1]);
					}
   , increasefontsize:{	img:41, 
						onClick: function(){
							if (!Browser.firefox) return MooRTE.Utilities.fontsize.pass(1);
						}()
					}
   , fontsize		:{}
   , insertimage	:{}
   , forecolor		:{}			
   , formatblock	:{}
   , backcolor		:{ 	img:43,
						onLoad:function(){
							MooRTE.Utilities.assetLoader({
								scripts: ['/siteroller/classes/colorpicker/Source/ColorRoller.js'], 
								styles:  ['/siteroller/classes/colorpicker/Source/ColorRoller.js'], 
								onComplete:function(){

								}
							})
						},
						onClick: function(){
							var empty = (Browser.Engine.gecko ? 'hilitecolor' : 'backcolor');
						}
					}
					
   // Deprecated
   , 'Toolbar'      :{element:'div'} //div.Toolbar would create the same div (with a class of rteToolbar).  But since it is the default, I dont wish to confuse people...
};


// Note1: insertorderedlist & insertunorderedlist restored to btn loop in MooRTE.Elements. Had been removed due to FF errs when textfield was empty.
/*
---
description: Class for creating floating balloon tips that nicely appears when hovering an element.

license: MIT-style

authors:
- Lorenzo Stanco

requires:
- core/1.3: '*'

provides: [FloatingTips]

...
*/

var FloatingTips = new Class({

	Implements: [Options, Events],

	options: {
		position: 'top',
		fixed: false,
		center: true,
		content: 'title',
		html: false,
		balloon: true,
		arrowSize: 6,
		arrowOffset: 6,
		distance: 3,
		motion: 6,
		motionOnShow: true,
		motionOnHide: true,
		showOn: 'mouseenter',
		hideOn: 'mouseleave',
		showDelay: 0,
		hideDelay: 0,
		className: 'floating-tip',
		offset: { x: 0, y: 0 },
		fx: { 'duration': 'short' }
	},

	initialize: function(elements, options) {
		this.setOptions(options);
		var s = this;
		this.boundShow = (function() { s.show(this); });
		this.boundHide = (function() { s.hide(this); });
		if (!['top', 'right', 'bottom', 'left', 'inside'].contains(this.options.position)) this.options.position = 'top';
		if (elements) this.attach(elements);
		return this;
	},

	attach: function(elements) {
		var s = this;
		$$(elements).each(function(e) {
			if (e.retrieve('floatingtip_hasevents')) { return; }
			evs = { };
			evs[s.options.showOn] = s.boundShow;
			evs[s.options.hideOn] = s.boundHide;
			e.addEvents(evs);
			e.store('floatingtip_hasevents', true);
			e.store('floatingtip_object', s);
		});
		return this;
	},

	detach: function(elements) {
		var s = this;
		var evs = { };
		evs[this.options.showOn] = this.boundShow;
		evs[this.options.hideOn] = this.boundHide;
		$$(elements).each(function(e) {
			s.hide(e);
			e.removeEvents(evs);
			e.eliminate('floatingtip_hasevents');
			e.eliminate('floatingtip_object');
		});
		return this;
	},

	show: function(element) {
		var old = element.retrieve('floatingtip');
		if (old) if (old.getStyle('opacity') == 1) { clearTimeout(old.retrieve('timeout')); return this; }
		var tip = this._create(element);
		if (tip == null) return this;
		element.store('floatingtip', tip);
		this._animate(tip, 'in');
		element.store('floatingtip_visible', true);
		this.fireEvent('show', [tip, element]);
		return this;
	},
	
	hide: function(element) {
		var tip = element.retrieve('floatingtip');
		if (!tip) return this;
		this._animate(tip, 'out');
		element.store('floatingtip_visible', false);
		this.fireEvent('hide', [tip, element]);
		return this;
	},
	
	toggle: function(element) {
        if (element.retrieve('floatingtip_visible')) return this.hide(element);
        else return this.show(element);
    },
	
	_create: function(elem) {
		
		var o = this.options;
		var oc = o.content;
		var opos = o.position;
		
		if (oc == 'title') {
			oc = 'floatingtitle';
			if (!elem.get('floatingtitle')) elem.setProperty('floatingtitle', elem.get('title'));
			elem.set('title', '');
		}
		
		var cnt = (typeof(oc) == 'string' ? elem.get(oc) : oc(elem));
		var cwr = new Element('div').addClass(o.className).setStyle('margin', 0);
		var tip = new Element('div').addClass(o.className + '-wrapper').setStyles({ 'margin': 0, 'padding': 0, 'z-index': cwr.getStyle('z-index') }).adopt(cwr);
		
		if (cnt) { 
			if (o.html) {
				if (o.html_adopt) cwr.adopt(cnt);
				else cwr.set('html', typeof(cnt) == 'string' ? cnt : cnt.get('html'));
			} else {
				cwr.set('text', cnt); 
			}
		} else { 
			return null;
		}
		
		var body = document.id(document.body);
		tip.setStyles({ 'position': (o.fixed ? 'fixed' : 'absolute'), 'opacity': 0, 'top': 0, 'left': 0 }).inject(body);
		
		if (o.balloon && !Browser.ie6) {
			
			var trg = new Element('div').addClass(o.className + '-triangle').setStyles({ 'margin': 0, 'padding': 0 });
			var trgSt = { 'border-color': cwr.getStyle('background-color'), 'border-width': o.arrowSize, 'border-style': 'solid','width': 0, 'height': 0 };
			
			switch (opos) {
				case 'inside': 
				case 'top'   : trgSt['border-bottom-width'] = 0; break;
				case 'right' : trgSt['border-left-width'  ] = 0; trgSt['float'] = 'left'; cwr.setStyle('margin-left', o.arrowSize); break;
				case 'bottom': trgSt['border-top-width'   ] = 0; break;
				case 'left'  : trgSt['border-right-width' ] = 0; 
					if (Browser.ie7) { trgSt['position'] = 'absolute'; trgSt['right'] = 0; } else { trgSt['float'] = 'right'; }
					cwr.setStyle('margin-right', o.arrowSize); break;
			}
			
			switch (opos) {
				case 'inside': case 'top': case 'bottom': 
					trgSt['border-left-color'] = trgSt['border-right-color'] = 'transparent';
					trgSt['margin-left'] = o.center ? tip.getSize().x / 2 - o.arrowSize : o.arrowOffset; break;
				case 'left': case 'right': 
					trgSt['border-top-color'] = trgSt['border-bottom-color'] = 'transparent';
					trgSt['margin-top'] = o.center ?  tip.getSize().y / 2 - o.arrowSize : o.arrowOffset; break;
			}
			
			trg.setStyles(trgSt).inject(tip, (opos == 'top' || opos == 'inside') ? 'bottom' : 'top');
			
		}
		
		var tipSz = tip.getSize(), trgC = elem.getCoordinates();
		var offsetOption = ('function' === typeof(o.offset) ? Object.merge({ x: 0, y: 0 }, o.offset(elem)) : o.offset);
		var pos = { x: trgC.left + offsetOption.x, y: trgC.top + offsetOption.y };
		
		if (opos == 'inside') {
			tip.setStyles({ 'width': tip.getStyle('width'), 'height': tip.getStyle('height') });
			elem.setStyle('position', 'relative').adopt(tip);
			pos = { x: o.offset.x, y: o.offset.y };
		} else {
			switch (opos) {
				case 'top'   :  pos.y -= tipSz.y + o.distance; break;
				case 'right' :  pos.x += trgC.width + o.distance; break;
				case 'bottom':  pos.y += trgC.height + o.distance; break;
				case 'left'  :  pos.x -= tipSz.x + o.distance; break;
			}
		}
		
		if (o.center) {
			switch (opos) {
				case 'top' : case 'bottom': pos.x += (trgC.width / 2 - tipSz.x / 2); break;
				case 'left': case 'right' : pos.y += (trgC.height / 2 - tipSz.y / 2); break;
				case 'inside':
					pos.x += (trgC.width / 2 - tipSz.x / 2);
					pos.y += (trgC.height / 2 - tipSz.y / 2); break;
			}
		}
		
		tip.set('morph', o.fx).store('position', pos);
		tip.setStyles({ 'top': pos.y, 'left': pos.x });
		
		return tip;
		
	},
	
	_animate: function(tip, d) {
		
		clearTimeout(tip.retrieve('timeout'));
		tip.store('timeout', (function(t) { 
			
			var o = this.options, din = (d == 'in');
			var m = { 'opacity': din ? 1 : 0 };
			
			if ((o.motionOnShow && din) || (o.motionOnHide && !din)) {
				var pos = t.retrieve('position');
				if (!pos) return;
				switch (o.position) {
					case 'inside': 
					case 'top'   : m['top']  = din ? [pos.y - o.motion, pos.y] : pos.y - o.motion; break;
					case 'right' : m['left'] = din ? [pos.x + o.motion, pos.x] : pos.x + o.motion; break;
					case 'bottom': m['top']  = din ? [pos.y + o.motion, pos.y] : pos.y + o.motion; break;
					case 'left'  : m['left'] = din ? [pos.x - o.motion, pos.x] : pos.x - o.motion; break;
				}
			}
			
			t.morph(m);
			if (!din) t.get('morph').chain(function() { this.dispose(); }.bind(t)); 
			
		}).delay((d == 'in') ? this.options.showDelay : this.options.hideDelay, this, tip));
		
		return this;
		
	}

});

Elements.implement({
	
	floatingTips: function(options) {
		new FloatingTips(this, options);
		return this;
	}
	
});

Element.implement({
	
	floatingTips: function(options) {
		new FloatingTips($$(this), options);
		return this;
	},
	
	floatingTipsShow: function() {
		var tip = this.retrieve('floatingtip_object');
		if (tip) tip.show(this);
		return this;
	},
	
	floatingTipsHide: function() {
		var tip = this.retrieve('floatingtip_object');
		if (tip) tip.hide(this);
		return this;
	},
	
	floatingTipsToggle: function() {
		var tip = this.retrieve('floatingtip_object');
		if (tip) tip.toggle(this);
		return this;
	}
	
});

Element.Properties.floatingTips = {
 
    get: function(){
        return this.retrieve('floatingtip_object');
    }
 
};

/*
* FancyForm 1.1
* By Vacuous Virtuoso, lipidity.com
* 
* 1.1 by Fabian Vogelsteller, frozeman.de
* 
* methods:
* 
* add(elements)
* setDepency(element,depencies)
* all()
* none() 
*
* ---
* Checkbox and radio input replacement script.
* Toggles defined class when input is selected.
*/

var FancyForm = new Class ({
  
  Implements: Options,
	
		options: {
			onClasses: {
        checkbox: 'fancyform_checked',
			  radio: 'fancyform_selected'
      },
			offClasses: {
        checkbox: 'fancyform_unchecked',
        radio: 'fancyform_unselected'
      },
      extraClasses: false,
      onSelect: function(){},
      onDeselect: function(){}
		},
  
	initialize: function(elements, options){
	  this.setOptions(options);
		if(this.initing != undefined) return;
		this.elements = (elements) ? $$(elements) : $$('input');
		if(typeOf(this.options['extraClasses']) == 'object'){
			this.extra = this.options['extraClasses'];
		} else if(this.options['extraClasses']){
			this.extra = {
				checkbox: 'fancyform_checkbox',
				radio: 'fancyform_radio',
				on: 'fancyform_on',
				off: 'fancyform_off',
				all: 'fancyform'
			}
		} else {
			this.extra = {};
		}
		this.chks = [];
		this.add();
		Array.each($$('form'), function(x) {
			x.addEvent('reset', function(a) {
				window.setTimeout(function(){this.chks.each(function(x){this.update(x);x.inputElement.blur()})}, 200);
			});
		});
	},
	add: function(){
		this.initing = 1;
		var keeps = [];
		var filteredElements = [];
		var self = this;
		var newChks = this.elements.filter(function(chk){
			if(typeOf(chk) != 'element' || chk.inputElement || (chk.get('tag') == 'input' && chk.getParent().inputElement))
				return false;
			if(chk.get('tag') == 'input' && (self.options.onClasses[chk.getProperty('type')])){
				var el = new Element('div')
				chk.grab(el,'before');
				if(el.getNext('input')==chk){
					el.type = chk.getProperty('type');
					el.inputElement = chk;
					if(chk.getProperty('disabled')) el.addClass('fancyform_disabled');
					keeps.push(el);
					chk.store('fancyform_replacment',el);
					filteredElements.push(chk);
				} else {
					chk.addEvent('click',function(f){
						if(f.event.stopPropagation) f.event.stopPropagation();
					});
				}
			} else if((chk.inputElement = chk.getElement('input')) && (self.options.onClasses[(chk.type = chk.inputElement.getProperty('type'))])){
				return true;
			}
			return false;
		});
		newChks = newChks.combine(keeps);
		newChks.each((function(chk){
			var c = chk.inputElement;
			c.setStyle('position', 'absolute');
			c.setStyle('left', '-9999px');
			chk.addEvent('selectStart', function(f){f.stop()});
			chk.name = c.getProperty('name');
			this.update(chk);
		}).bind(this));
		newChks.each((function(chk){
			var c = chk.inputElement;
			chk.addEvent('click', function(f){
				f.stop(); f.type = 'prop';
				c.fireEvent('click', f, 1);
			});
			chk.addEvent('mousedown', function(f){
				if(typeOf(c.onmousedown) == 'function')
					c.onmousedown();
				f.preventDefault();
			});
			chk.addEvent('mouseup', function(f){
				if(typeOf(c.onmouseup) == 'function')
					c.onmouseup();
			});
			c.addEvent('focus', function(f){
				if(this.focus)
					chk.addClass('fancyform_focus');
			});
			c.addEvent('blur', function(f){
				chk.removeClass('fancyform_focus');
			});
			c.addEvent('click', (function(f){
				if(f.event.stopPropagation) f.event.stopPropagation();
				if(c.getProperty('disabled'))
					return;
				if (!chk.hasClass(this.options.onClasses[chk.type]))
					c.setAttribute('checked', 'checked');
				else if(chk.type != 'radio')
					c.setProperty('checked', false);
				if(f.type == 'prop')
					this.focus = 0;
				this.update(chk);
				this.focus = 1;
				if(f.type == 'prop' && !this.initing && typeOf(c.onclick) == 'function')
					 c.onclick();
					 
				// click depencies
				if(typeOf(c.retrieve('fancyform_depencies')) == 'elements') {
				  c.retrieve('fancyform_depencies').each(function(depency) {
				    depency = depency.retrieve('fancyform_replacment');
				    if(((c.type == 'checkbox' && c.getProperty('checked')) || (c.type == 'radio' && c.getProperty('selected'))) &&
               !depency.hasClass('fancyform_disabled') && (depency.hasClass('fancyform_unchecked') || depency.hasClass('fancyform_unselected')))
              depency.inputElement.setAttribute('checked', 'checked');
			        this.update(depency);
          },this);
        }
			}).bind(this));
			c.addEvent('mouseup', function(f){
				if(f.event.stopPropagation) f.event.stopPropagation();
			});
			c.addEvent('mousedown', function(f){
				if(f.event.stopPropagation) f.event.stopPropagation();
			});
			if(extraclass = this.extra[chk.type])
				chk.addClass(extraclass);
			if(extraclass = this.extra['all'])
				chk.addClass(extraclass);
		}).bind(this));
		this.chks.combine(newChks);
		this.initing = 0;
	},
	update: function(chk){
		if(chk.inputElement.getProperty('checked')) {
			chk.removeClass(this.options.offClasses[chk.type]);
			chk.addClass(this.options.onClasses[chk.type]);
			if (chk.type == 'radio'){
				this.chks.each((function(other){
					if (other.name == chk.name && other != chk) {
						other.inputElement.setProperty('checked', false);
						this.update(other);
					}
				}).bind(this));
			}
			if(extraclass = this.extra['on'])
				chk.addClass(extraclass);
			if(extraclass = this.extra['off'])
				chk.removeClass(extraclass);
			if(!this.initing)
				this.options.onSelect(chk);
		} else {
			chk.removeClass(this.options.onClasses[chk.type]);
			chk.addClass(this.options.offClasses[chk.type]);
			if(extraclass = this.extra['off'])
				chk.addClass(extraclass);
			if(extraclass = this.extra['on'])
				chk.removeClass(extraclass);
			if(!this.initing)
				this.options.onDeselect(chk);
		}
		if(!this.initing)
			chk.inputElement.focus();
	},
	setDepency: function(element,depencies) {	  
	  if(this.elements.contains($(element))) {
	    depencies = (depencies) ? $$(depencies) : [];
	    if(typeOf($(element).retrieve('fancyform_depencies')) == 'array')
	       depencies.combine($(element).retrieve('fancyform_depencies'));
      $(element).store('fancyform_depencies',depencies);
    }
  },
	all: function(){
		this.chks.each((function(chk){
			chk.inputElement.setAttribute('checked', 'checked');
			this.update(chk);
		}).bind(this));
	},
	none: function(){
		this.chks.each((function(chk){
			chk.inputElement.setProperty('checked', false);
			this.update(chk);
		}).bind(this));
	}
});

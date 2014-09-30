/*
* FancyForm 1.1.2
*
* Author
* Vacuous Virtuoso, lipidity.com
* Fabian Vogelsteller, frozeman.de
*
*
* methods:
*
* add(elements)
* setDepency(
*   element = the element which has depencies,
*   depencies = the element or elements which will be checked or unchecked,
*   checkElement = (boolean, default: TRUE) whether the depencies will be changed when the element is checked (TRUE) or unchecked (FALSE)
*   checkDepencies = (boolean, default: TRUE) whether the elements will be checked (TRUE) or unchecked (FALSE)
* all()
* none()
*
* requires: mootools core 1.3.1
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
		if(this.initing !== undefined) return;
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
			};
		} else {
			this.extra = {};
		}
		this.chks = [];
		this.add();
		if(!Browser.ie6 && !Browser.ie7 && !Browser.ie8) {
			$$('form').each(function(x) {
				x.addEvent('reset', function(a) {
					window.setTimeout(function(){
						this.chks.each(function(x){
							this.update(x);
							x.inputElement.blur();
						});
					}, 200);
				});
			});
		}
	},
	add: function(){
		this.initing = 1;
		var keeps = [];
		var filteredElements = [];
		var self = this;
		var newChks = this.elements.filter(function(chk){
			if(typeOf(chk) != 'element' || chk.inputElement || (chk.get('tag') == 'input' && chk.getParent().inputElement) || chk.retrieve('fancyform_replacment'))
				return false;
			if(chk.get('tag') == 'input' && (self.options.onClasses[chk.getProperty('type')])){
				var el = new Element('div');
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
			// replace the imput element
			var c = chk.inputElement;
			c.setStyle('position', 'fixed'); // absolute
			c.setStyle('top', '0px');
			c.setStyle('left', '-9999px');
			chk.addEvent('selectStart', function(f){f.stop();});
			chk.name = c.getProperty('name');
			this.update(chk);

			// ->> add events
			chk.addEvent('click', function(f){
				f.stop();
        f.type = 'prop';
				c.fireEvent('click', f, 1);
			});
			// -> prevent default
			chk.addEvent('mousedown', function(f){
				if(typeOf(c.onmousedown) == 'function')
					c.onmousedown();
				f.preventDefault();
			});
			// -> prevent default
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
			// ->> CHANGE STATE
			c.addEvent('click', (function(f){
				if(f.event.stopPropagation) f.event.stopPropagation();
				if(c.getProperty('disabled'))
					return;
				if (!chk.hasClass(this.options.onClasses[chk.type]))
					c.setProperty('checked', 'checked');
				else if(chk.type != 'radio')
					c.removeProperty('checked');
				/*
				if(f.type == 'prop')
					this.focus = 0;
					*/
				this.update(chk);
				this.focus = 1;
				if(f.type == 'prop' && !this.initing && typeOf(c.onclick) == 'function')
					c.onclick();

				// click depencies
				if(typeOf(c.retrieve('fancyform_depencies')) == 'elements') {
					c.retrieve('fancyform_depencies').each(function(depency) {
						var depencyReplacement = depency.retrieve('fancyform_replacment');
						/*
            if(depency.disabled)
							return;
            */
						var elementValue = depency.retrieve('fancyform_checkElement_-' + c.retrieve('fancyform_uniqueID'));
						var depencyValue = depency.retrieve('fancyform_checkDepencies_-' + c.retrieve('fancyform_uniqueID'));
						if(depencyValue === true && c.checked == elementValue &&
               (depencyReplacement.hasClass('fancyform_unchecked') || depencyReplacement.hasClass('fancyform_unselected')))
              depency.setProperty('checked', 'checked');
            else if(depencyValue === false && c.checked == elementValue &&
                    (depencyReplacement.hasClass('fancyform_checked') || depencyReplacement.hasClass('fancyform_selected')))
              depency.removeProperty('checked');
						this.update(depencyReplacement);
          },this);
        }
			}).bind(this));
			// -> prevent default
			c.addEvent('mouseup', function(f){
				if(f.event.stopPropagation) f.event.stopPropagation();
			});
			// -> prevent default
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
						other.inputElement.removeProperty('checked');
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
		if(!this.initing) {
			chk.inputElement.focus();
			if(chk.type == 'radio' || chk.type == 'checkbox')
				chk.inputElement.fireEvent('change');
		}
	},
	setDepency: function(element,depencies,checkElement,checkDepencies) {

		if(typeOf(checkElement) == 'null')
			checkElement = true;
		if(typeOf(checkDepencies) == 'null')
			checkDepencies = true;

		if(this.elements.contains($(element))) {
			depencies = (depencies) ? $$(depencies) : [];
			depencies.each(function(depency){
				var unique = String.uniqueID();
        depency.store('fancyform_checkElement_-'+$(element).retrieve('fancyform_uniqueID',unique),checkElement);
        depency.store('fancyform_checkDepencies_-'+$(element).retrieve('fancyform_uniqueID',unique),checkDepencies);
      });
			if(typeOf($(element).retrieve('fancyform_depencies')) == 'array')
				depencies.combine($(element).retrieve('fancyform_depencies'));
      $(element).store('fancyform_depencies',depencies);
    }
  },
	all: function(){
		this.chks.each((function(chk){
			chk.inputElement.setProperty('checked', 'checked');
			this.update(chk);
		}).bind(this));
	},
	none: function(){
		this.chks.each((function(chk){
			chk.inputElement.removeProperty('checked');
			this.update(chk);
		}).bind(this));
	}
});

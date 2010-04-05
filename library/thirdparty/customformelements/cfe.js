/*
LICENCE INFORMATION ON Custom Form Elements
****************************************************

Custom Form Elements (CFE) for mootools 1.2 - style form elements on your own
by Maik Vlcek (http://www.mediavrog.net)

Copyright (c) Maik Vlcek (mediavrog.net)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

The file GNU.txt contains the complete license text.
If this package didn't come with an GNU.txt, you may
get the full text on http://www.gnu.org/licenses/gpl.html
*/
/**
 * The core of custom form elements. Includes cfe.generic and some slight addons to the native Element object. 
 *
 * @module core
 * @namespace cfe
 */

var cfe = {};
cfe.module = {};
cfe.addon = {};

cfe.version = "0.9.3";
cfe.spacer = "spacer.gif";

/**
 * cfe.generic gets extended by modules to start off with standard, button-like behaviours.
 * @class generic
 */
cfe.generic = new Class(
{
    Implements: [new Options, new Events],
    /**
     * Describes the type of this element (e.g. Selector, Checkbox or Radiobutton)
     * @property type
     * @type string
     */
    type : "Generic",

    /**
     * basic options for all cfes and always available
     * @property options
     */
    options: {

        /**
         * instance id for all cfe
         * @config instanceID
         * @type int
         */
        instanceID:0,
        
        /**
         * path to transparent spacer.gif; it's used for easy css-styling
         * @config spacer
         * @type string
         */
        spacer: "",

        /**
         * the element's wrapper will be of this type (e.g. span or div)
         * @config aliasType
         * @type string
         */
        aliasType: "span",

        /**
         * if this element shall replace an existing html form element, pass it here
         * @config replaces
         * @type HTMLElement
         */
        replaces: null,

        /**
         * may pass any element as a label (toggling, hovering,..) for this cfe
         * @config label
         * @type HTMLElement
         */
        label: null,

        /**
         * if this cfe is created programatically, it's possible to set the name attribute of the generated input element
         * @config name
         * @type string
         */
        name: "",

        /**
         * setting this to true will create a disabled element
         * @config disabled
         * @type boolean
         */
        disabled: false,

        /**
         * Fired when the mouse is moved over the "decorator" element
         * @event onMouseOver
         */
        onMouseOver: Class.empty,

        /**
         * Fired when the mouse is moved away from the "decorator" element
         * @event onMouseOut
         */
        onMouseOut: Class.empty,

        /**
         * Fired when the "original" element gets focus (e.g. by tabbing)
         * @event onFocus
         */
        onFocus: Class.empty,

        /**
         * Fired when the "original" element loses focus
         * @event onBlur
         */
        onBlur: Class.empty,

        /**
         * Fired when "decorator" is clicked by mouse
         * @event onClick
         */
        onClick: Class.empty,

        /**
         * Fired when pressing down with the mouse button on the "decorator"
         * Fired when pressing the space key while "original" has focus
         * @event onPress
         */
        onPress: Class.empty,

        /**
         * Fired when "decorator" was pressed and the mouse button is released
         * Fired when "original" was pressed by space key and this key is released
         * @event onRelease
         */
        onRelease: Class.empty,

        /**
         * Fired when "original"'s value changes
         * @event onUpdate
         */
        onUpdate: Class.empty,

        /**
         * Fired when "original" gets disabled by HTMLElement.enable()
         * @event onEnable
         */
        onEnable: Class.empty,

        /**
         * Fired when "original" gets disabled by HTMLElement.disable()
         * @event onDisable
         */
        onDisable: Class.empty
    },

    /**
	 * constructor<br />
	 * building algorithm for cfe (template method)<br />
     * <ol>
     * <li>setOptions: set Options</li>
     * <li>buildWrapper: setup the "decorator"</li>
     * <li>setupOriginal: procede the "original" element (add Events...)</li>
     * <li>addLabel: add and procede the label</li>
     * <li>initializeAdv: last chance for subclasses to do initialization</li>
     * <li>build: various specific dom handling and "decorator" building</li>
	 *
     * @method initialize
     * @constructor
     *
     * @param {Object} options
	 */
    initialize: function(opt)
    {
        this.setOptions(this.options, opt);
        
        if(!this.options.spacer) this.options.spacer = cfe.spacer;

        // build standard wrapping element
        this.buildWrapper.bind(this)();

        // prepares original html element for use with cfe
        this.setupOriginal();

        // add a label, if present
        this.addLabel( $pick(this.o.getLabel(), this.setupLabel(this.options.label) ) );

        // specific initialization
        this.initializeAdv();

        // each cfe must implement this function
        this.build();

    },

    /**
     * retreive the "decorator"
     * 
     * @method getAlias
     * @return {HTMLElement}
     */
    getAlias: function()
    {
        return this.a;
    },

    /**
     * retreive the label
     *
     * @method getLabel
     * @return {HTMLElement}
     */
    getLabel: function()
    {
        return this.l;
    },

    /**
     * retreive the label and the alias
     *
     * @method getFull
     * @return {HTMLElement[label, alias]}
     */
    getFull: function()
    {
        return [this.l, this.a];
    },

    /**
     * builds the "decorator"
     *
     * @method buildWrapper
     * @protected
     */
    buildWrapper: function()
    {
        // create standard span as replacement
        this.a = new Element(this.options.aliasType);

        this.setupWrapper();
    },

    /**
     * adds events and mousepointer style to the "decorator"
     * usually gets called by buildWrapper
     *
     * @method setupWrapper
     * @protected
     */
    setupWrapper: function()
    {
        this.a.addClass("js"+this.type).addEvents({
            mouseover: this.hover.bind(this),
            mouseout: this.unhover.bind(this),
            mousedown: this.press.bind(this),
            mouseup: this.release.bind(this),
            disable: this.disable.bind(this),
            enable: this.enable.bind(this)
        }).setStyle("cursor","pointer");
    },

    /**
     * handles the creation of the underlying original form element <br />
     * stores a reference to the cfe object in the original form element
     *
     * @method setupOriginal
     * @protected
     */
    setupOriginal: function()
    {
        // get original element
        if($defined(this.options.replaces))
        {
            this.o = this.options.replaces;

            // if this shall replace a form element, add id as class
            this.a.addClass("js"+this.o.id).inject(this.o, 'before');
        }
        else // standalone
        {
            this.o = this.createOriginal();

            if(this.options.id) this.o.setProperty("id", this.options.id);
                
            if(this.options.disabled) this.o.disable();

            if(this.options.name)
            {
                this.o.setProperty("name", this.options.name);
                
                if( !$chk(this.o.id)) this.o.setProperty("id", this.options.name+this.options.instanceID);
            }
            
            if(this.options.value) this.o.setProperty("value", this.options.value);

            this.a.adopt(this.o);
        }

        // little hack since mootools doesn't support selectors like input[name="fieldName[foo]"]
        if( $chk(this.o.name) ) this.o.setProperty("clearname", this.o.name.replace("]", "b-.-d").replace("[", "d-.-b") );

        this.o.addEvents({
            focus: this.setFocus.bind(this),
            blur: this.removeFocus.bind(this),
            change: this.update.bind(this),
            keydown: function(e){
                if(new Event(e).key == "space") this.press();
            }.bind(this),
            keyup: function(e){
                if(new Event(e).key == "space") this.release();
            }.bind(this),
            onDisable: function(){ 
                this.a.fireEvent("disable");
            }.bind(this),
            onEnable: function(){  
                this.a.fireEvent("enable");
            }.bind(this)
        });

        // store a reference to this cfe "in" the original form element
        this.o.store("cfe", this);
    },

    /**
     * getter for retrieving the disabled state of the "original" element
     *
     * @method isDisabled
     * @return boolean
     */
    isDisabled: function()
    {
        return this.o.getProperty("disabled");
    },

    /**
     * programatically creates an "original" element<br />
     * each subclass has to implement this
     *
     * @method createOriginal
     * @return {HTMLElement}
     */
    createOriginal: function()
    {
        return new Element("img", {
            "src": this.options.spacer,
            "class": "spc"
        });
    },

    /**
	 * hides the original input element by pushing it out of the viewport <br />
     * (no display:none since it's important for screenreaders to parse the original element)
     *
     * @method hideOriginal
     * @protected
	 */
    hideOriginal: function()
    {
        // hide original input
        this.o.setStyles({
            position: "absolute",
            left: "-9999px",
            opacity: 0.01
        });

        // fix for internet explorer 7;
        if(Browser.Engine.trident && !Browser.Features.query){
            this.o.setStyles({
                width: 0,
                height: "1px"
            });
        }
    },

    /*
     * creates a label element and fills it with the contents (may be html) given by option "label"
     *
     * @method setupLabel
     * @protected
     *
     * @return {HTMLElement or NULL} if option "label" is not set
     */
    setupLabel: function()
    {
        if( $defined(this.options.label) ) return new Element("label").set("html", this.options.label).setProperty("for", this.o.id);
        
        return null;
    },

    /*
     * adds a label element to this cfe
     *
     * @method addLabel
     * @protected
     *
     * @param {HTMLElement} the label element to set as label for this cfe
     */
    addLabel: function(label)
    {
        if( !$defined(label) ) return;

        this.l = label;

        // remove for property
        if(!this.dontRemoveForFromLabel) this.l.removeProperty("for");

        // add adequate className, add stdEvents
        this.l.addClass("js"+this.type+"L");

        if(this.o.id || this.o.name) this.l.addClass("for_"+ (this.o.id || (this.o.name+this.o.value).replace("]","-").replace("[","") ));

        // add stdevents
        this.l.addEvents({
            mouseover: this.hover.bind(this),
            mouseout: this.unhover.bind(this),
            mousedown: this.press.bind(this),
            mouseup: this.release.bind(this)
        });

        if(!this.o.implicitLabel || (this.o.implicitLabel && !Browser.Engine.gecko)) this.l.addEvent("click", this.clicked.bindWithEvent(this));

        this.addEvents({
            "onPress": function()
            {
                this.l.addClass("P");
            },
            "onRelease": function()
            {
                this.l.removeClass("P");
            },
            "onMouseOver": function()
            {
                this.l.addClass("H");
            },
            "onMouseOut": function()
            {
                this.l.removeClass("H");
                this.l.removeClass("P");
            },
            "onFocus": function()
            {
                this.l.addClass("F");
            },
            "onBlur": function()
            {
                this.l.removeClass("F");
            //this.l.removeClass("P");
            },
            "onEnable": function()
            {
                this.l.removeClass("D");
            },
            "onDisable": function()
            {
                this.l.addClass("D");
            }
        });        
    },

    /**
     * part of the main template method for building the "decorator"<br />
     * gets called immediately before the build-method<br />
     * may be extended by subclasses
     *
     * @method initializeAdv
     * @protected
     */
    initializeAdv: function()
    {
        if(!this.o.implicitLabel) this.a.addEvent("click", this.clicked.bindWithEvent(this));

        if(this.isDisabled()) this.a.fireEvent("disable");
    },
    
    /**
     * part of the main template method for building the "decorator"<br />
     * must be extended by subclasses
     *
     * @method build
     * @protected
     */
    build: function(){},
    
    
    /**
     * wrapper method for event onPress<br />
     * may be extended by subclasses
     *
     * @method press
     * @protected
     */
    press: function()
    {
        if(!this.isDisabled())
        {
            this.a.addClass("P");
            this.fireEvent("onPress");
        }
    },

    /**
     * wrapper method for event onRelease<br />
     * may be extended by subclasses
     *
     * @method release
     * @protected
     */
    release: function()
    {
        if(!this.isDisabled())
        {
            this.a.removeClass("P");
            this.fireEvent("onRelease");
        }
    },

    /**
     * wrapper method for event onMouseOver<br />
     * may be extended by subclasses
     *
     * @method onMouseOver
     * @protected
     */
    hover: function()
    {
        if(!this.isDisabled())
        {
            this.a.addClass("H");
            this.fireEvent("onMouseOver");
        }
    },

    /**
     * wrapper method for event onMouseOut<br />
     * may be extended by subclasses
     *
     * @method unhover
     * @protected
     */
    unhover: function()
    {
        if(!this.isDisabled())
        {
            this.a.removeClass("H");
            this.fireEvent("onMouseOut");
            this.release();
        }
    },

    /**
     * wrapper method for event onFocus<br />
     * may be extended by subclasses
     *
     * @method setFocus
     * @protected
     */
    setFocus: function()
    {
        this.a.addClass("F");
        this.fireEvent("onFocus");
    },

    /**
     * wrapper method for event onBlur<br />
     * may be extended by subclasses
     *
     * @method removeFocus
     * @protected
     */
    removeFocus: function()
    {
        //console.log("o blurred");
        this.a.removeClass("F");
        // if cfe gets blurred, also clear press state
        //this.a.removeClass("P");
        this.fireEvent("onBlur");

    },

    /**
     * wrapper method for event onClick<br />
     * delegates the click to the "original" element<br />
     * may be extended by subclasses
     *
     * @method clicked
     * @protected
     */
    clicked: function()
    {
        if(!this.isDisabled())
        {
            if( $chk(this.o.click) ) this.o.click();
            this.o.focus();

            this.fireEvent("onClick");
        }
    },

    /**
     * wrapper method for event onUpdate<br />
     * may be extended by subclasses
     *
     * @method update
     * @protected
     */
    update: function()
    {
        this.fireEvent("onUpdate");
    },

    /**
     * wrapper method for event onEnable<br />
     * may be extended by subclasses
     *
     * @method enable
     * @protected
     */
    enable: function()
    {
        this.a.removeClass("D");
        this.fireEvent("onEnable");
    },

    /**
     * wrapper method for event onDisable<br />
     * may be extended by subclasses
     *
     * @method disable
     * @protected
     */
    disable: function()
    {
        this.a.addClass("D");
        this.fireEvent("onDisable");
    }
});

/**
 * extend Elements with some Helper functions
 * @class Helpers
 * @namespace Element
 */
Element.Helpers = new Class({

    /**
     * cross-browser method for disabling the text selection by setting css attributes
     * 
     * @method disableTextSelection
     */
    disableTextSelection: function(){
        if(Browser.Engine.trident || Browser.Engine.presto){
            this.setProperty("unselectable","on");
        }
        else if(Browser.Engine.gecko){
            this.setStyle("MozUserSelect","none");
        }
        else if(Browser.Engine.webkit){
            this.setStyle("KhtmlUserSelect","none");
        }
    },

    /**
     * disables a HTMLElement if its a form element by setting the disabled attribute to true
     *
     * @method disable
     * @return boolean true, if element could be disabled
     */
    disable: function()
    {
        if($type(this) === "element" && ["button", "input", "option", "optgroup", "select", "textarea"].contains( this.get("tag") )            )
        {
            this.setProperty("disabled", true);
            this.fireEvent("onDisable");
            return true;
        }

        return false;
    },

    /**
     * enables a HTMLElement if its a form element by setting the disabled attribute to false
     *
     * @method enable
     * @return {boolean} true, if element could be enabled
     */
    enable: function()
    {
        if($type(this) === "element" && ["button", "input", "option", "optgroup", "select", "textarea"].contains( this.get("tag") )            )
        {
            this.setProperty("disabled", false);
            this.fireEvent("onEnable");
            return true;
        }

        return false;
    },

    /**
     * enables or disabled a HTMLElement if its a form element depending on it's current state
     *
     * @method toggleDisabled
     * @return {boolean} true, if element could be toggled
     */
    toggleDisabled: function()
    {
        if($type(this) === "element" && ["button", "input", "option", "optgroup", "select", "textarea"].contains( this.get("tag") )            )
        {
            this.setProperty("disabled", !this.getProperty("disabled") );
            this.fireEvent(this.getProperty("disabled")?"onDisable":"onEnable");
            return true;
        }
        return false;
    },

    /**
     * returns the label-element which belongs to this element
     *
     * @method getLabel
     * @return HTMLElement or NULL
     */
    getLabel: function()
    {
        var label = null;

        // get label by id/for-combo
        if(this.id) label = $$("label[for="+this.id+"]")[0];
        
        // no label was found for id/for, let's see if it's implicitly labelled
        if(!label)
        {
            label = this.getParents('label')[0];

            if(label) this.implicitLabel = true;
        }

        return label;
    },

    /**
     * generates the markup used by sliding doors css technique to use with this element
     *
     * @method setSlidingDoors
     *
     * @param count
     * @param type
     * @param prefix
     * 
     * @return HTMLElement or NULL the wrapped HTMLElement
     */
    setSlidingDoors: function(count, type, prefix)
    {
        var slide = null;
        var wrapped = this;
        prefix = $pick(prefix, "sd");

        for(i = count; i > 0; i--)
        {
            slide = new Element(type);
            slide.addClass(i==count?prefix:i==0?prefix+"Slide":prefix+"Slide"+i);

            slide.grab(wrapped);
            wrapped = slide;
        }

        wrapped = null;

        return slide;
    }
});
Element.implement(new Element.Helpers);/**
 * replacement class for automated replacment of scoped form elements
 *
 * @module replace
 * @namespace cfe
 *
 */

cfe.replace = new Class(
{
    Implements: [new Options, new Events],

	options:{
		scope: false,
		
		spacer: "",
		
		onInit: $empty,
		onInitSingle: $empty,
		onBeforeInitSingle: $empty,
		onSetModuleOption: $empty,
		onRegisterModule: $empty,
		onUnregisterModule: $empty,
		onComplete: $empty
	},
		
	modules: {},
	moduleOptions: {},
	moduleOptionsAll: {},
	
	initialize: function()
    {

        this.options.spacer = cfe.spacer;
		
		this.registerAllModules.bind(this)();

	},
	
	/**
     * @method registerAllModules
	 * registeres all loaded modules onInitialize
	 */
	registerAllModules: function(){
		
		//console.log("Register all modules");
		
		$each(cfe.module, function(modObj, modType){
			//console.log("Registering type "+modType);
			if(modType != "Generic")
				this.registerModule(modType);
				
		}.bind(this));
	},
	
	/* call to register module */
	registerModule: function(mod){
		
		//console.log("Call to registerModule with arg:"+mod);
		modObj = cfe.module[mod];
		
        this.fireEvent("onRegisterModule", [mod,modObj]);
        this.modules[mod] = modObj;
        this.moduleOptions[mod] = {};

        return true;
	},
	
	registerModules: function(mods)
    {
		$each(mods,function(mod){
			this.registerModule(mod);
		},this);
	},
	
	unregisterModule: function(mod)
    {
		modObj = cfe.module[mod];
		
		this.fireEvent("onUnregisterModule", [mod,modObj]);

		delete this.modules[mod];
	},
	
	unregisterModules: function(mods)
    {
		$each(mods,function(mod){
			this.unregisterModule(mod);
		},this);
	},
	/**
	 * sets a single option for a specified module
	 * if no module was given, it sets the options for all modules
	 *
     * @method setModuleOption
     *
	 * @param {String} 	mod 	Name of the module
	 * @param {String} 	opt 	Name of the option
	 * @param {Mixed} 	val		The options value
	 */
	setModuleOption: function(mod,opt,val){
		
		modObj = cfe.module[mod];
		
		this.fireEvent("onSetModuleOption", [mod,modObj,opt,val]);
		
		if(!modObj){
			this.moduleOptionsAll[opt] = val;
		}
		else{
			this.moduleOptions[mod][opt] = val;
		}
	},

	setModuleOptions: function(mod,opt){
		
		$each(opt, function(optionValue, optionName){
			this.setModuleOption(mod,optionName,optionValue);
		}.bind(this));
		
	},

	init: function(options){

		this.setOptions(this.options, options);

		if($type(this.options.scope) != "element"){
			this.options.scope = $(document.body);
		}

		this.fireEvent("onInit");
		
		$each(this.modules,function(module,moduleName,i){
			
			var selector = module.prototype.selector;
			
			this.options.scope.getElements(selector).each(function(el,i){
				
				var basicOptions = {instanceID: i, spacer:this.options.spacer, replaces: el};

				this.fireEvent("onBeforeInitSingle", [el,i,basicOptions]);
			
				var single = new module($merge(basicOptions,$merge(this.moduleOptions[moduleName],this.moduleOptionsAll)));
				
				this.fireEvent("onInitSingle", single);
				
			},this);
		},this);
		
		this.fireEvent("onComplete");
	}
});/**
 * @module check
 */

/**
 * replaces checkboxes
 *
 * bug:
 * opera        - original update triggers twince when clicking the ori
 * ie 8         - original update triggers twince when clicking the ori
 * ie 7         - original update triggers twince when clicking the ori
 *
 * @class checkbox
 * @namespace cfe.modules
 * 
 * @requires generic
 * @extends cfe.generic
 */
cfe.module.checkbox = new Class({
    
	Extends: cfe.generic,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
	type: "Checkbox",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
	selector: "input[type=checkbox]",

    options:{
        /**
         * Fired when the original element gets checked
         * @event onCheck
         */
        onCheck: Class.empty,
        /**
         * Fired when the original element's checked state is set to false
         * @event onUnCheck
         */
        onUncheck: Class.empty
    },
    /**
     * retreive the label and the alias in inverted direction, since with checkboxes, the decorator is more often placed in front of the label
     *
     * @method getFull
     * @return {HTMLElement[label, alias]}
     */
    getFull: function()
    {
        return [this.a, this.l];
    },

    initializeAdv: function()
    {
        this.parent();
        this.hideOriginal();

        // important for resetting dynamically created cfe
        this.o.defaultChecked = this.o.checked;

        // fix for internet explorer and opera > raises new probs: see above
        if(Browser.Engine.presto)
        {
            if(!this.o.implicitLabel){
                this.a.addEvent( "click", this.update.bind(this) );
                if(this.l)
                {
                    this.l.addEvent( "click", this.update.bind(this) );
                }
            }else
            {
                this.o.addEvent( "click", this.update.bind(this) );
            }
        }

        if(Browser.Engine.trident)
        {
            this.o.addEvent( "click", this.update.bind(this) );
        }
    },

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "checkbox"
     * @protected
     */
    createOriginal: function()
    {
        return new Element("input",{
            type: "checkbox",
            checked: this.options.checked
            });
    },

    /**
     * creates the decorator checkbox as simple img[src=spacer] element
     * after creation, update is called to properly set the state
     *
     * @method build
     * @protected
     */
    build: function()
    {
        new Element("img",{"src": this.options.spacer, "class": "spc"}).inject(this.a, "top");
        this.update();
    },

    /**
     * public method to set the state of a checkbox programmatically
     * TODO: check if this is obsolete, because the original should have an onupdate listener
     *
     * @method setStateTo
     * @public
     */
    setStateTo: function(state)
    {
        state?this.check():this.uncheck();
    },

    /**
     * public method to check a checkbox programatically
     *
     * @method check
     * @public
     */
    check: function()
    {
        this.a.addClass("A");
        this.fireEvent("onCheck");
    },

    /**
     * public method to uncheck a checkbox programatically
     *
     * @method uncheck
     * @public
     */
    uncheck: function()
    {
        this.a.removeClass("A");
        this.fireEvent("onUncheck");
    },

    /**
     * wrapper method for event onUpdate<br />
     * additionally adds the correct checked state to the decorator
     *
     * @method update
     * @protected
     */
    update: function()
    {
        this.setStateTo(this.o.checked);
        this.parent();
    }
});/**
 * @module select
 */

/**
 * replaces select fields
 *
 * bug:
 * height of options too small if option with linebreak; standalone and scrolling bug
 *
 * @class select
 * @namespace cfe.module
 *
 * @requires generic
 * @extends cfe.generic
 *
 */
cfe.module.select = new Class({
	
    Extends: cfe.generic,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type: "Selector",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "select:not(select[multiple])",
	
    options: {
        size: 4,
        scrolling: true,
        scrollSteps: 5
    },

    initializeAdv: function()
    {
        this.parent();
		
        this.hideOriginal();

        this.o.addEvent("keyup", this.keyup.bind(this));
        this.o.addEvent("keydown", this.keydown.bind(this));

        this.origOptions = this.o.getChildren();
        this.selectedIndex = this.o.selectedIndex || 0;
		
        // key indices
        this.kind = [];
		
        // integrity check
        if(this.options.size > this.origOptions.length || this.options.scrolling != true) this.options.size = this.origOptions.length;
        
        // needed for adding and removing events
        this.boundWheelListener = this.mouseListener.bindWithEvent(this);
        this.boundClickedOutsideListener = this.clickOutsideListener.bindWithEvent(this);
       
    },

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} a select input
     */
    createOriginal: function()
    {
        var ori = new Element("select");

        if( $chk(this.options.options) )
        {
            for(var key in this.options.options)
            {
                ori.adopt( new Element("option", {
                    value: key,
                    selected: this.options.options[key].selected?"selected":""
                }).set("html", this.options.options[key].label ) );
            }
        }
        return ori;
    },

    build: function()
    {
        /* build the select element showing the currently selected item */
        this.a.addClass("js"+this.type+this.options.instanceID);
		
        this.arrow = new Element("img",{
            "class": "js"+this.type+"Arrow",
            "src": this.options.spacer,
            "styles": {
                "float":"right",
                "display":"inline"
            }
        }).injectInside(this.a);
		
        this.ai = new Element("span").addClass("js"+this.type+"Slide").injectInside(this.a).adopt(this.arrow);

        this.activeEl = new Element("span",{
            "class": "jsOptionSelected",
            "styles": {
                "float":"left",
                "display":"inline"
            }
        }).set('html', this.origOptions[0].get("text") ).injectBefore(this.arrow);
			
        /* build container which shows on click */
        this.buildContainer();
       
        // select default option
        this.selectOption(this.selectedIndex, false, true);
    },

    buildOption: function(el, index)
    {
        var oOpt = new Element("div",{
            "class": "jsOption jsOption"+index+(el.get('class')?" "+el.get('class'):""),
            "events":{
                "mouseover": this.highlightOption.pass([index,true],this),
                "mouseout": this.highlightOption.pass([index,true],this)
            }
        }).set('html', el.innerHTML);

        oOpt.index = index;
        oOpt.disableTextSelection();

        return oOpt;
    },

    setupScrolling: function()
    {
        // slider config
        this.scrollerWrapper = new Element("div",{
            "class": "js"+this.type+"ScrollerWrapper",
            "styles":{
                height: this.gfxHeight
            }
        }).injectInside(this.cContent);

        this.scrollerTop = new cfe.generic().getAlias().addClass("scrollTop").addEvent("click", function(ev){
            this.moveScroller.pass(-1*this.options.scrollSteps,this)();
        }.bind(this));

        this.scrollerBottom = new cfe.generic().getAlias().addClass("scrollBottom").addEvent("click", function(ev){
            this.moveScroller.pass(this.options.scrollSteps,this)();
        }.bind(this));

        this.scrollerKnob = new Element("span",{
            "class": "scrollKnob spc"
        });

        this.scrollerBack = new Element("div");

        this.scrollerBack.adopt(this.scrollerKnob);
        this.scrollerWrapper.adopt([this.scrollerTop, this.scrollerBack, this.scrollerBottom]);

        this.scrollerBack.setStyle("height",this.gfxHeight - 2*this.scrollerTop.getFirst().getHeight());

        // slider
        this.sliderSteps = this.aliasOptions.getScrollSize().y - (this.options.size*this.aliasOptions.getScrollSize().y/this.aOptions.length);

        this.slider = new Slider(this.scrollerBack, this.scrollerKnob, {
            steps: this.sliderSteps,
            mode: "vertical" ,
            onChange: function(step){
                this.aliasOptions.scrollTo(false,step);
            }.bind(this)
        }).set(0);
    },
    
    buildContainer: function()
    {
        /* always shown */
        this.container = new Element("div",{
            "class": "js"+this.type+"Container",
            "styles":{
                "overflow":"hidden"
            }
        });
        this.container.setSlidingDoors(4, "div", "jsSelectorContent").injectInside(this.a);

        this.cContent = this.container.getParent();
        this.containerSlide = this.cContent.getParents(".jsSelectorContentSlide1")[0];
        
        this.aliasOptions = this.container;

        if(this.cContent.getStyle("width").toInt() === 0){
            var letFloat = true;
        }

        // insert option elements
        this.origOptions.each(function(el,i)
        {
            this.buildOption(el, i).inject(this.aliasOptions);
        }.bind(this));

        this.aOptions = this.aliasOptions.getChildren();

        this.gfxHeight = this.aOptions[0].getHeight()*this.options.size;
        this.gfxWidth = this.cContent.getWidth()-(this.cContent.getStyle("padding-left")).toInt()-this.cContent.getStyle("padding-right").toInt();

        // scroller if scrolling enabled
        if(this.options.scrolling)
        {
            this.setupScrolling();
            this.gfxWidth = this.gfxWidth-this.scrollerWrapper.getWidth();
        }
        
        if(this.gfxHeight != 0) this.aliasOptions.setStyle("height", this.gfxHeight);
        if(this.gfxWidth != 0 && !letFloat) this.aliasOptions.setStyle("width", this.gfxWidth);
    },

    selectOption: function(index,stayOpenAfterSelect, dontScroll)
    {
        index = index.limit(0,this.origOptions.length-1);

        this.highlightOption(index, dontScroll);

        this.selectedIndex = index;

        this.activeEl.set('html', (this.aOptions[index]).innerHTML);

        if( !$chk(stayOpenAfterSelect) ) this.hideContainer();
    },

    highlightOption: function(index, dontScroll)
    {
        index = index.limit(0,this.origOptions.length-1);
        
        if(this.highlighted) this.highlighted.removeClass("H");
        
        this.highlighted = this.aOptions[index].addClass("H");

        this.highlightedIndex = index;

        if( !dontScroll ) this.scrollToSelectedItem(this.highlightedIndex);
    },
	
    scrollToSelectedItem: function(index)
    {
        if( this.options.scrolling ) this.slider.set( (this.sliderSteps/(this.aOptions.length-this.options.size))*index );
    },

    moveScroller:function(by)
    {
        var scrol = this.aliasOptions.getScroll().y;
        this.slider.set( scrol+by<this.sliderSteps?scrol+by:this.sliderSteps );
    },

    hideContainer: function()
    {
        $(document.body).removeEvent("mousewheel", this.boundWheelListener);
        $(document.body).removeEvent("click", this.boundClickedOutsideListener);
        
        this.containerSlide.setStyle("display","none");
        this.isShown = false;
    },

    showContainer: function()
    {
       $(document.body).addEvent("mousewheel", this.boundWheelListener);
       $(document.body).addEvent("click", this.boundClickedOutsideListener);

        // show container
        this.containerSlide.setStyles({
            display:"block",
            position:"absolute",
            top: this.a.getTop(),
            left: this.a.getLeft(),
            "z-index": 1000 - this.options.instanceID
        });
        
        this.isShown = true;

        this.highlightOption(this.o.selectedIndex);
    },

    clicked: function(e)
    {
        if(!this.isDisabled())
        {
            var ev = new Event(e);

            if( $defined(ev.target) )
            {
                var oTarget = $(ev.target);

                if( oTarget.getParent() == this.aliasOptions )
                {
                    this.selectOption(oTarget.index, true, true);
                    this.hideContainer();
                    this.parent();
                    this.o.selectedIndex = oTarget.index;
                    return;
                }
                else if(this.options.scrolling && oTarget.getParents("."+this.scrollerWrapper.getProperty("class"))[0] == this.scrollerWrapper)
                {
                    //console.log("no toggle");
                    return;
                }
            }

        this.toggle();
        this.parent();
        }        
    },

    toggle: function()
    {
        $chk(this.isShown)?this.hideContainer():this.showContainer();
    },
	
    keyup: function(e)
    {
        var ev = new Event(e);

        // toggle on alt+arrow
        if(ev.alt && (ev.key == "up" || ev.key == "down") )
        {
            this.toggle();
            return;
        }

        switch(ev.key){
            case "enter":
            case "space":
                this.toggle();
                break;

            case "up":
                this.updateOption(-1);
                break;

            case "down":
                this.updateOption(1);
                break;

            case "esc":
                this.hideContainer();
                break;
                
            default:
                this.o.fireEvent("change");
                break;
        }
    },

    keydown: function(e)
    {
        var ev = new Event(e);

        if(ev.key == "tab")
        {
            this.hideContainer();
        }
    },

    mouseListener: function(e)
    {
        var ev = new Event(e).stop();
        this.updateOption(-1*ev.wheel);
    },

    updateOption: function(by)
    {
        this.o.selectedIndex = (this.highlightedIndex+by).limit(0,this.origOptions.length-1);
        this.o.fireEvent("change");
    },
    
    clickOutsideListener: function(ev)
    {
        var e = new Event(ev);
        
        var testPar = $(e.target).getParents(".js"+this.type+this.options.instanceID);

        if (testPar.length === 0 && !(Browser.Engine.trident && e.target == this.o) && (this.l && $(e.target) != this.l) ) this.hideContainer();
    },

    update: function()
    {
        this.parent();
        this.selectOption(this.o.selectedIndex, true);
    }
});/**
 * @module button
 */

/**
 * Extends the generic module to replace inputs of type 'submit'
 *
 * @class submit
 * @namespace cfe.module
 * 
 * @requires generic
 * @extends cfe.generic
 *
 * @constructor
 *
 * bug: - press then click outside > press state doesn't clear
 */
cfe.module.submit = new Class({
	
	Extends: cfe.generic,

    /**
     * Describes the type of this element (Submit)
     * @property type
     * @type string
     */
	type:"Submit",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
	selector: "input[type=submit]",

	options: {
        /**
         * if > 0, it will create markup for css sliding doors tech<br />
         * the number defines the amount of wrappers to create around this element<br />
         * 2: standard sliding doors (x- or y-Axis)<br />
         * 4: sliding doors in all directions (x/y-Axis)
         *
         * @config slidingDoors
         * @type int
         * @default 4
         */
		slidingDoors: true
	},

    /**
     * Hides the original element and adds class jsButton to decorator
     *
     * @method initializeAdv
     */
	initializeAdv: function()
    {
        this.parent();
		this.hideOriginal();
        this.a.addClass("jsButton");
	},

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "submit"
     */
    createOriginal: function()
    {
        return new Element("input",{
            type: "submit"
            });
    },

    /**
     * customize the "decorator" (=> sliding doors wrappers)
     * disables text selection on the injected label
     *
     * @method build
     * @protected
     */
	build: function()
    {
		this.lab = new Element("span").addClass("label").set("html", this.o.value).inject(this.a);
        this.lab.disableTextSelection();
        
		if( $chk(this.options.slidingDoors) )
        {
            var additionalWrapper = new Element("span",{"class": "js"+this.type});
            additionalWrapper.wraps(this.lab);
            
			this.a.addClass("js"+this.type+"Slide").removeClass("js"+this.type).adopt(additionalWrapper);
		}
	}
});/**
 * @module text
 */

/**
 * replaces input[type=text]
 *
 * @class text
 * @namespace cfe.module
 *
 * @requires generic
 * @extends cfe.generic
 *
 */
cfe.module.text = new Class({
	
	Extends: cfe.generic,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
	type: "Text",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
	selector: "input[type=text]",
	
	options: {
        /**
         * if > 0, it will create markup for css sliding doors tech<br />
         * the number defines the amount of wrappers to create around this element<br />
         * 2: standard sliding doors (x- or y-Axis)<br />
         * 4: sliding doors in all directions (x/y-Axis)
         * @config slidingDoors
         * @type int
         * @default 2
         */
		slidingDoors: 2
	},

    /**
     * flag to prevent deleting the for attribute from the label<br />
     * for text fields this is important, since the "original" element doesn't get hidden
     * @property dontRemoveForFromLabel
     * @type boolean
     * @protected
     */
    dontRemoveForFromLabel: true,

    /**
     * since there's no real "decorator" (just wrapping for sliding doors) for textfields, it won't fetch events
     * @method setupWrapper
     * @protected
     */
    setupWrapper: function()
    {
       this.a.addClass("js"+this.type).addEvents({
            disable: this.disable.bind(this),
            enable: this.enable.bind(this)
        });
    },

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "text"
     */
    createOriginal: function()
    {
        return new Element("input", {
            type: "text"
        });
    },

    /**
     * customize the "decorator" (=> sliding doors wrappers)
     *
     * @method build
     * @protected
     */
	build: function()
    {
		if( $chk(this.options.slidingDoors) )
        {
			this.a.addClass("js"+this.type+"Slide");

            this.o.setSlidingDoors(this.options.slidingDoors-1, "span", "js"+this.type).inject(this.a);

            this.o.setStyles({
                background: "none",
                padding: 0,
                margin: 0,
                border: "none"
            });
		}
        else
        {
            this.a.wraps(this.o);
        }
    }
});/**
 * @module file
 */

/**
 * replaces file upload fields
 *
 * bug:
 * update event onMouseOut triggers even if nothing changed
 * ff 3.0.7     - no pointer
 * opera        - no pointer; no focus on label if ori focussed, click event triggers twice
 * ie 8         - no focus on label if ori focussed
 * ie 7         - no focus on label if ori focussed
 *
 * @class file
 * @namespace cfe.modules
 *
 * @requires generic
 * @extends cfe.generic
 */
cfe.module.file = new Class({
    
	Extends: cfe.generic,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type: "File",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "input[type=file]",
	
    options: {
        /**
         * enables the use of fileicons through a bit of markup and css
         * @config fileIcons
         * @type boolean
         * @default true
         */
        fileIcons: true,
        /**
         * show only the filename, not the whole path
         * @config trimFilePath
         * @type boolean
         * @default true
         */
        trimFilePath: true
    },

    /**
     * retreive the filepath
     *
     * @method getFilePath
     * @return {HTMLElement}
     */
    getFilePath: function()
    {
        return this.v;
    },

    /**
     * retreive the label, the alias and the filepath
     *
     * @method getFull
     * @return {HTMLElement[label, alias, filePath]}
     */
    getFull: function()
    {
        return [this.l, this.a, this.v];
    },

    initializeAdv: function()
    {
        // fixes safari double click bug
        if(!this.o.implicitLabel && !Browser.Engine.webkit)
        {
            this.a.addEvent("click", this.clicked.bindWithEvent(this));
        }

        if(this.isDisabled()) this.a.fireEvent("disable");
    },

    build: function()
    {
        this.a.addEvent("mousemove", this.follow.bindWithEvent(this)).setStyle("overflow","hidden");
        this.o.inject(this.a);

        this.initO();

        // add filepath
        this.v = new Element("div",{
            "class": "js"+this.type+"Path"
        }).inject(this.a, 'after').addClass("hidden");
		
        if(this.options.fileIcons){
            this.fileIcon = new Element("img",{
                "src": this.options.spacer,
                "class": "fileIcon"
            }).inject(this.v);
        }
		
        this.path = new Element("span",{
            "class":"filePath"
        }).inject(this.v);
        
        this.cross = new cfe.generic().addEvent("click", this.deleteCurrentFile.bind(this)).getAlias().addClass("delete").inject(this.v);

        this.update();
    },

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "file"
     */
    createOriginal: function()
    {
        return new Element("input",{
            type: "file"
        });
    },

    initO: function()
    {
        this.o.addEvent("mouseout", this.update.bind(this));
        this.o.addEvent("change", this.update.bind(this));

        this.o.setStyles({
            cursor: "pointer",
            opacity: "0",
            visibility: "visible",
            height: "100%",
            width: "auto",
            position: "relative"
        });
    },
	
    follow: function(e)
    {
        var ev = new Event(e);
        this.o.setStyle("left",(ev.client.x-this.a.getLeft()-(this.o.getWidth()-30)));
		
        /* special treatment for internet explorer as the fileinput will not be cut off by overflow:hidden */
        if(Browser.Engine.trident){
            if(ev.client.x < this.a.getLeft() || ev.client.x > this.a.getLeft()+this.a.getWidth())
                this.o.setStyle("left", -999);
        }
    },
	
    update: function()
    {
        if( this.o.value != "" )
        {
            this.oldValue = this.o.getProperty("value");
            this.oldValue = this.options.trimFilePath?this.trimFilePath(this.oldValue):this.oldValue;
            this.path.set("html", this.oldValue);
			
            if(this.options.fileIcons)
            {
                var ind = this.oldValue.lastIndexOf(".");
                this.fileIcon.setProperty("class","fileIcon "+this.oldValue.substring(++ind).toLowerCase());
            }
            this.v.removeClass("hidden");
        }
        else
        {
            this.path.set("html", "");
            this.v.addClass("hidden");
        }

        this.parent();
    },
	
    deleteCurrentFile: function()
    {
        // maybe better: this.setupOriginal()
        var newFileinput = this.createOriginal();

        newFileinput.addClass(this.o.getProperty("class")).setProperties({
            name: this.o.name,
            id: this.o.id
        });
        
        newFileinput.replaces(this.o);
        this.o = newFileinput;
		
        this.initO();
		
        this.update();
    },
	
    trimFilePath: function(path)
    {
        var ind = false;
        if(!(ind = path.lastIndexOf("\\")))
            if(!(ind = path.lastIndexOf("\/")))
                ind = 0;
	
        return path.substring(++ind);
    }
});/**
 * Provides replacement for input[type=image]<br />
 * This module dynamically appends the current state (hover, press) to the image filename given in the src attribute
 *
 * @class image
 * @namespace cfe.module
 *
 * @requires generic
 * @extends cfe.generic
 *
 * @constructor
 */
cfe.module.image = new Class({
    
    Extends: cfe.generic,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type:"Image",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
	selector: "input[type=image]",


    options:{
        /**
         * the prefix which will get appended to the name of the image, just before the state suffix<br />
         * e.g. if the name of the image is 'cfeSubmit.gif' the resulting name of the hovered state will be cfeSubmit-cfeState-H.gif (when using default value)<br />
         * @config statePrefix
         * @type string
         * @default -cfeState-
         */
        statePrefix: "-cfeState-"
    },

    /**
     * wraps the decorator around the original element
     * cretaes a regual expression with the given statePrefix to set/clear the different states
     *
     * @method initializeAdv
     * @protected
     */
    initializeAdv: function()
    {
        this.parent();

        this.a.wraps(this.o);
        this.stateRegEx = new RegExp(this.options.statePrefix+"([HFP])");
    },

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "image"
     */
    createOriginal: function()
    {
        return new Element("input", {
            type: "image"
        });
    },

    /**
     * sets a given state
     *
     * @method setState
     * @protected
     */
    setState: function(state)
    {
        this.clearState();
        var ind = this.o.src.lastIndexOf(".");
		this.o.src = this.o.src.substring(0,ind) + this.options.statePrefix + state + this.o.src.substring(ind);
	},

    /**
     * clears all states
     *
     * @method clearState
     * @protected
     */
    clearState: function()
    {
        this.o.src = this.o.src.replace(this.stateRegEx, "");
    },

    /**
     * wrapper method for event onMouseOver<br />
     * sets the "hover" state of the image button
     *
     * @method hover
     * @protected
     */
    hover: function()
    {
        this.parent();
        this.setState("H");
    },

    /**
     * wrapper method for event onMouseOut<br />
     * clears the "hover" state of the image button
     *
     * @method unhover
     * @protected
     */
    unhover: function()
    {
        this.parent();
        this.clearState();
        if(this.a.hasClass("F")) this.setState("F");
    },

    /**
     * wrapper method for event onFocus<br />
     * sets the "focus" state of the image button
     *
     * @method setFocus
     * @protected
     */
    setFocus: function()
    {
        this.parent();
        if(!this.a.hasClass("P")) this.setState("F");
    },

    /**
     * wrapper method for event onBlur<br />
     * clears the "focus" state of the image button
     *
     * @method removeFocus
     * @protected
     */
    removeFocus: function()
    {
        this.parent();
        this.clearState();
    },

    /**
     * wrapper method for event onPress<br />
     * sets the "pressed" state of the image button
     *
     * @method press
     * @protected
     */
    press: function()
    {
        this.parent();
        this.setState("P");
    },

    /**
     * wrapper method for event onRelease<br />
     * clears the "pressed" state of the image button
     *
     * @method release
     * @protected
     */
    release: function()
    {
        this.parent();
        this.clearState();
        if(this.a.hasClass("F")) this.setState("F");
    },

    /**
     * wrapper method for event onEnable<br />
     *
     * @method enable
     * @protected
     */
    enable: function()
    {
        this.parent();
        this.clearState();
    },

    /**
     * wrapper method for event onDisable<br />
     *
     * @method disable
     * @protected
     */
    disable: function()
    {
        this.parent();
        this.setState("D");
    }
});/**
 * Replacement for elements of type: input[type=password]
 *
 * @class password
 * @namespace cfe.module
 *
 * @requires text
 * @extends cfe.module.text
 *
 */
cfe.module.password = new Class({
    
    Extends: cfe.module.text,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type:"Password",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "input[type=password]",

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "password"
     */
    createOriginal: function()
    {
        return new Element("input",{
            type: "password"
            });
    }
});/**
 * replaces radiobuttons
 *
 * bug:
 * ie 8         - rb alias w/o implicit labelling trigger update twice; ori triggers update twice
 * ie 7         - rb alias w/o implicit labelling trigger update twice; ori triggers update twice
 * 
 * @class radio
 * @namespace cfe.modules
 *
 * @requires checkbox
 * @extends cfe.modules.checkbox
 */
cfe.module.radio = new Class({

    Extends: cfe.module.checkbox,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type: "Radiobutton",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "input[type=radio]",

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "radio"
     */
    createOriginal: function()
    {
        return new Element("input",{
            "type": "radio",
            "checked": this.options.checked
        });
    },

    /**
     * fixes a bug in other browsers than those with trident or gecko engine
     *
     * @method initializeAdv
     * @protected
     */
    initializeAdv: function()
    {
        this.parent();
        
        if( !(Browser.Engine.trident || Browser.Engine.gecko) ) this.o.addEvent("click", this.update.bind(this));
    },

    /**
     * public method to check a radiobutton programatically
     * all other radio buttons in the same group (== same name att) are unchecked
     *
     * @method check
     * @public
     */
    check: function()
    {
        this.parent();

        $$('input[clearName="'+this.o.getProperty("clearName")+'"]').each(function(el)
        {
            if(el != this.o) el.retrieve("cfe").uncheck();
        }.bind(this));
    }
});/**
 * Provides replacement for input[type=reset]
 *
 * @class reset
 * @namespace cfe.module
 *
 * @requires submit
 * @extends cfe.module.submit
 *
 * @constructor
 *
 * bug: - press then click outside > press state doesn't clear
 */
cfe.module.reset = new Class({

    Extends: cfe.module.submit,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type:"Reset",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "input[type=reset]",

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} an input field of type "reset"
     */
    createOriginal: function()
    {
        return new Element("input",{
            type: "reset"
        });
    },

    /**
     * adds an additional click event to the button to procede a form's reset
     *
     * @method setupOriginal
     */
    setupOriginal: function()
    {
        this.parent();
        this.o.addEvent("click", this.notifyReset.bind(this));
    },

    /**
     * traverses all input, textarea, select elements in the current scope (form)
     * and fires their change event to notify all listeners, the elements have beed resetted
     *
     * @method notifyReset
     */
    notifyReset: function()
    {
        (function(){
            $A(this.o.form.getElements( "input, textarea, select" )).each( function(el)
            {
                el.fireEvent("change");
            });
        }).delay(40, this);
    }
});/**
 * replaces select fields with attribute multiple set
 *
 * bug:
 * mouseWheel support needed
 * 
 * @class select_multiple
 * @namespace cfe.module
 *
 * @requires select
 * @extends cfe.module.select
 */
cfe.module.select_multiple = new Class({
	
    Extends: cfe.module.select,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
    type: "Selector",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
    selector: "select[multiple]",
	
    options: {
        size: 4,
        scrolling: true,
        scrollSteps: 5
    },

    /**
     * customize the "decorator"
     * sets sliding doors and creates and injects options
     *
     * @method build
     * @protected
     */
    build: function()
    {	
        this.a.addClass("jsSelectorMultiple jsSelectorMultiple"+this.options.instanceID);
        this.a.removeClass("jsSelector");

        this.buildContainer();

        this.o.addEvents({
            onDisable: function(){
                this.aliasOptions.getChildren().each(function(el){
                    el.getChildren("input")[0].disable();
                });
            }.bind(this),
            onEnable: function(){
                this.aliasOptions.getChildren().each(function(el){
                   el.getChildren("input")[0].enable();
                });
            }.bind(this)
        });
    },

    buildOption: function(el, index)
    {
        var oOpt = new cfe.module.checkbox({
            label: el.innerHTML,
            checked: $chk(el.selected),
            aliasType: "div",
            disabled: this.isDisabled()
        });
        oOpt.index = index;

        oOpt.addEvents({
            "check": function(index){
                this.origOptions[index].selected = true;
                this.o.fireEvent("change")
            }.pass(index, this),
            "uncheck": function(index){
                this.origOptions[index].selected = false;
                this.o.fireEvent("change")
            }.pass(index, this)
        });

        oOpt.getAlias().addClass("jsOption jsOption"+index+(el.get('class')?" ".el.get('class'):"")).disableTextSelection();
        oOpt.getLabel().removeEvents().inject(oOpt.getAlias());

        return oOpt.getAlias();
    },

    selectOption: function(index)
    {
        index = index.limit(0,this.origOptions.length-1);

        this.highlightOption(index);
    },

    scrollToSelectedItem: function(index){},
	
    clicked: function()
    {
        if(!this.isDisabled())
        {
            this.o.focus();
            this.fireEvent("onClick");
        }
    },
    
    update: function()
    {
        this.fireEvent("onUpdate");
    },
    keyup: function(e)
    {
        var ev = new Event(e);

        switch(ev.key){
            case "enter":
            case "space":
                //this.toggle();
                break;

            case "up":
                this.updateOption(-1);
                break;

            case "down":
                this.updateOption(1);
                break;

            case "esc":
                this.hideContainer();
                break;

            default:
                this.o.fireEvent("change");
                break;
        }
    },

    keydown: function(){}
});/**
 * replaces textarea
 *
 * @module text
 * @namespace cfe.module
 *
 * @requires text
 * @extends cfe.module.text
 *
 */
cfe.module.textarea = new Class({

	Extends: cfe.module.text,

    /**
     * Describes the type of this element
     * @property type
     * @type string
     */
	type:"Textarea",

    /**
     * CSS Selector to fetch "original" HTMLElements for replacement with this module
     * @property selector
     * @type string
     */
	selector: "textarea",
    
    options: {
        /**
         * if > 0, it will create markup for css sliding doors tech<br />
         * the number defines the amount of wrappers to create around this element<br />
         * 2: standard sliding doors (x- or y-Axis)<br />
         * 4: sliding doors in all directions (x/y-Axis)
         *
         * @config slidingDoors
         * @type int
         * @default 4
         */
		slidingDoors: 4
	},

    /**
     * Method to programmatically create an "original" HTMLElement
     *
     * @method createOriginal
     * @return {HTMLElement} a textarea element
     */
    createOriginal: function()
    {
        return new Element("textarea");
    }
});/**
 * @module addon
 */

/**
 * ujsd
 * @class dependencies
 * @author Maik
 */
cfe.addon.dependencies = new Class({
	
	/**
	 * adds dependencies for an element 
	 * @param {Object} el
	 * @param {Array} dep
	 */
	addDependencies: function(el, deps){
		$each(deps,function(dep){
			this.addDependency(el,dep);		
		}.bind(this));
		
		return true;
	},
	
	/**
	 * adds dependency for an element 
	 * @param {Object} el
	 * @param {Object} dep
	 */
	addDependency: function(el, dep){
		
		// create an array if needed
		if($type( el.retrieve('deps') ) !== "array"){ el.store('deps', []); }
		
		// deps may be objects or strings > if a string was given, try to interpret it as id and fetch element by $()
		if($type(dep) === "string"){dep = $(dep);}
		
		if($type(dep) === "element"){
			el.retrieve('deps').push(dep);
			return true;
		}
		
		return false;		
	},
	
	getDependencies: function(el)
    {
		return el.retrieve('deps');
	},
	
	/**
	 * this is called when a new item of a cfemodule gets initialized
	 * it checks, whether there are dependencies for this element and adds them to its options
	 * 
	 * @param {Object} el
	 */
	attachDependencies: function(el,i,baseOptions)
    {
	    var deps = this.getDependencies(el);
		
		if($type(deps) === "array"){
			baseOptions.deps = deps;
			return true;
		}
	
		return false;
	}
		
});
cfe.replace.implement(new cfe.addon.dependencies);
cfe.replace.prototype.addEvent("onBeforeInitSingle", cfe.replace.prototype.attachDependencies);

cfe.addon.dependencies.modules = new Class({
	resolveDependencies: function()
    {
		var deps = this.o.retrieve('deps');
		
		if(deps){
			$each(deps, function(dep,i){
				dep.checked = true;
                dep.fireEvent("change");
			}.bind(this));
		}
	}
});

cfe.generic.implement(new cfe.addon.dependencies.modules);

// support for checkboxes
cfe.module.checkbox.prototype.addEvent("onCheck", function(){this.resolveDependencies();});/**
 * implements selectAll/deselectAll functionality into custom form elements
 * @class toggleCheckboxes
 *
 */
cfe.addon.toggleCheckboxes = new Class({

    // select all checkboxes in scope
    selectAll: function(scope){
        (scope || $(document.body)).getElements("input[type=checkbox]")[0].each(function(el){
            if(el.checked != true)
            {
                el.checked = true;
                el.fireEvent("change");
            }
        });
    },

    // deselect all checkboxes in scope
    deselectAll: function(scope){
        (scope || $(document.body)).getElements("input[type=checkbox]")[0].each(function(el){
            if(el.checked != false)
            {
                el.checked = false;
                el.fireEvent("change");
            }
        });
    }
});
cfe.replace.implement(new cfe.addon.toggleCheckboxes);/**
 * @class toolTips
 * @author Maik
 */
cfe.addon.toolTips = new Class({
	
    options: $merge(this.parent, {
        enableTips: true,
        ttStyle: "label",
        ttClass: "jsQM"
    }),
	
    initToolTips: function(){
		
        if(!window.Tips || !this.options.enableTips){
            if(this.options.debug){
                this.throwMsg.bind(this)("CustomFormElements: initialization of toolTips failed.\nReason: Mootools Plugin 'Tips' not available.");
            }
                        
            return false;
        }
	
        switch(this.options.ttStyle){
            default:case 'label': this.toolTipsLabel.bind(this)();break;
        }

        return true;
    },
	
    toolTipsLabel: function(){
		
        var labels = this.options.scope.getElements('label');
        		
        labels.each(function(lbl,i){
			
            forEl = lbl.getProperty("for");
			
            if(!forEl){
                var cl = lbl.getProperty("class");
				
                if( $defined(cl) ){
                    var forEl = cl.match(/for_[a-zA-Z0-9\-]+/);

                    if(forEl){
                        forEl = forEl.toString();
                        el = $( forEl.replace(/for_/,"") );
                    }                    
                }
				
                if(!el){
                    el = lbl.getElement("input");
                }
            }else{
                el = $(forEl);
            }

            if(el){
                if($chk(qmTitle = el.getProperty("title"))){
					
                    el.setProperty("title","").setProperty("hint", qmTitle)
					
                    var qm = new Element("img",{
                        "src": this.options.spacer,
                        "class": this.options.ttClass,
                        "title": qmTitle
                    });
                    
                    // check if implicit label span is present
                    var impLabel = lbl.getElement("span[class=label]");
                    
                    qm.injectInside($chk(impLabel)?impLabel:lbl);
                }
            }
        },this);
		
        new Tips($$('.'+this.options.ttClass+'[title]'));
    }
});

cfe.replace.implement(new cfe.addon.toolTips);
cfe.replace.prototype.addEvent("onComplete", function(){
    this.initToolTips();
});
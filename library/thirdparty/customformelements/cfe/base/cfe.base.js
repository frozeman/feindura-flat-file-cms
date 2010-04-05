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
Element.implement(new Element.Helpers);
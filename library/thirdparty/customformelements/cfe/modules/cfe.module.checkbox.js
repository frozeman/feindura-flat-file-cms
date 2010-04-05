/**
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
});
/**
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
});
/**
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
});
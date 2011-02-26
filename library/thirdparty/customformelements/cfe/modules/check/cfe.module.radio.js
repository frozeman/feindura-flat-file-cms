/**
 * @module Checkable
 */

/**
 * <p><strong>replaces radiobuttons</strong></p>
 *
 * <h6>Tested in:</h6>
 * <ul>
 * <li>Safari 4.</li>
 * <li>Firefox 3.6.</li>
 * <li>Google Chrome 6.</li>
 * <li>Opera 10.62.</li>
 * <li>IE 7.</li>
 *
 *  <li>IE 8
 *    <ul>
 *      <li>labels dont work for normal labelled elements</li>
 *    </ul>
 *  </li>
 *
 *  </ul>
 *
 * @class Radiobutton
 * @namespace cfe.module
 *
 * @extends cfe.modules.Checkbox
 */
cfe.module.Radiobutton = new Class({

    Extends: cfe.module.Checkbox,

    instance: 0,

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
     * @method initializeAdv
     * @protected
     */
    afterInitialize: function()
    {
        this.parent();
        
        if( !(Browser.ie || Browser.firefox) ) this.o.addEvent("click", this.update.bind(this));

        // on check, disable all other radiobuttons in this group
        this.addEvent("check", function(){
            $$("input[name='"+this.o.get("name")+"']").each(function(el)
            {
                if(el != this.o && el.retrieve("cfe")) el.retrieve("cfe").uncheck();
            }.bind(this));
        })
    }
});
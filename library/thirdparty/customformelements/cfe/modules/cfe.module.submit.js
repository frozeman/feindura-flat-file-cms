/**
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
});
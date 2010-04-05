/**
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
});
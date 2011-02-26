/**
 * The core of custom form elements. Includes cfe.Generic and some slight addons to the native Element object. 
 *
 * @module Core
 * @namespace cfe
 */

var cfe = {
  version: "0.9.9",
  prefix: "cfe",
  module: {},
  addon: {}
};

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
    if(Browser.ie || Browser.opera){
      this.setProperty("unselectable","on");
    }
    else if(Browser.firefox){
      this.setStyle("MozUserSelect","none");
    }
    else if(Browser.safari || Browser.chrome){
      this.setStyle("KhtmlUserSelect","none");
    }

    return this;
  },

  /**
     * disables a HTMLElement if its a form element by setting the disabled attribute to true
     *
     * @method disable
     * @return boolean true, if element could be disabled
     */
  disable: function()
  {
    if(typeOf(this) === "element" && ["button", "input", "option", "optgroup", "select", "textarea"].contains( this.get("tag") )            )
    {
      this.setProperty("disabled", true);
      this.fireEvent("onDisable");
    }

    return this;
  },

  /**
     * enables a HTMLElement if its a form element by setting the disabled attribute to false
     *
     * @method enable
     * @return {boolean} true, if element could be enabled
     */
  enable: function()
  {
    if(typeOf(this) === "element" && ["button", "input", "option", "optgroup", "select", "textarea"].contains( this.get("tag") )            )
    {
      this.setProperty("disabled", false);
      this.fireEvent("onEnable");
    }

    return this;
  },

  /**
     * enables or disabled a HTMLElement if its a form element depending on it's current state
     *
     * @method toggleDisabled
     * @return {boolean} true, if element could be toggled
     */
  toggleDisabled: function()
  {
    if(typeOf(this) === "element" && ["button", "input", "option", "optgroup", "select", "textarea"].contains( this.get("tag") )            )
    {
      this.setProperty("disabled", !this.getProperty("disabled") );
      this.fireEvent(this.getProperty("disabled")?"onDisable":"onEnable");
    }
    return this;
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
      label = this.getParent('label');

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
  setSlidingDoors: function(count, type, prefix, suffixes)
  {
    var slide = null;
    var wrapped = this;

    prefix = [prefix, "sd"].pick();

    suffixes = [suffixes, []].pick();

    for(var i = count; i > 0; --i)
    {
      wrapped.addClass( prefix+"Slide"+( (i == 1 && count == i) ? "" : (suffixes[i] || i) ));
      slide = new Element(type);

      try{
        wrapped = slide.wraps(wrapped);
      }catch(e){
        wrapped = slide.grab(wrapped);
      }
    }
    wrapped = null;

    return slide;
  },

  /**
     * hide an element but keep it's vertical position and leave it tab- & screenreader-able :)
     *
     * @method hideInPlace
     *
     * @return HTMLElement
     */
  hideInPlace: function()
  {
    return this.setStyles({
      position: "absolute",
      left: -99999,
      width: 1,
      height: 1
    });
  }
});

Element.implement(new Element.Helpers);
/**
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
});
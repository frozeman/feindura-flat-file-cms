/**
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
});
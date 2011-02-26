/**
 * @module Addon
 */

/**
 * pretty simple integration of auto-generated tooltips (from title-attribute)
 * depends on mootools Tips
 *
 * @class Tips
 * @namespace cfe.addon
 *
 */
cfe.addon.Tips = new Class({
	
    options: Object.merge({},this.parent, {
        enableTips: true,
        ttStyle: "label",
        ttClass: cfe.prefix+"Tip"
    }),
	
    initToolTips: function(){
		
        if(!window.Tips || !this.options.enableTips){
            if(this.options.debug){
                this.throwMsg.bind(this)("CustomFormElements: initialization of toolTips failed.\nReason: Mootools Plugin 'Tips' not available.");
            }
                        
            return false;
        }
	
        switch(this.options.ttStyle){
            default:case 'label': this.toolTipsLabel.bind(this)();break;
        }

        return true;
    },
	
    toolTipsLabel: function(){
		
        var labels = this.options.scope.getElements('label');
        		
        labels.each(function(lbl,i){

            forEl = lbl.getProperty("for");
			
            if(!forEl){
                var cl = lbl.getProperty("class");
				
                if( cl != null ){
                    var forEl = cl.match(/for_[a-zA-Z0-9\-]+/);

                    if(forEl){
                        forEl = forEl.toString();
                        el = $( forEl.replace(/for_/,"") );
                    }                    
                }
				
                if(!el){
                    el = lbl.getElement("input");
                }
            }else{
                el = $(forEl);
            }

            if(el){
                if((qmTitle = el.getProperty("title")) != null){
					
                    el.setProperty("title","").setProperty("hint", qmTitle)
					
                    var qm = new Element("span",{
                        "class": this.options.ttClass,
                        "title": qmTitle
                    });
                    
                    // check if implicit label span is present
                    var impLabel = lbl.getFirst("span[class=label]");
                    
                    qm.inject((impLabel != null)?impLabel:lbl,'inside');
                }
            }
        },this);
		
        new Tips($$('.'+this.options.ttClass+'[title]'));
    }
});

cfe.Replace.implement(new cfe.addon.Tips);
cfe.Replace.prototype.addEvent("onComplete", function(){
    this.initToolTips();
});
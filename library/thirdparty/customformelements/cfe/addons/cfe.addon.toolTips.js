/**
 * @class toolTips
 * @author Maik
 */
cfe.addon.toolTips = new Class({
	
    options: $merge(this.parent, {
        enableTips: true,
        ttStyle: "label",
        ttClass: "jsQM"
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
				
                if( $defined(cl) ){
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
                if($chk(qmTitle = el.getProperty("title"))){
					
                    el.setProperty("title","").setProperty("hint", qmTitle)
					
                    var qm = new Element("img",{
                        "src": this.options.spacer,
                        "class": this.options.ttClass,
                        "title": qmTitle
                    });
                    
                    // check if implicit label span is present
                    var impLabel = lbl.getElement("span[class=label]");
                    
                    qm.injectInside($chk(impLabel)?impLabel:lbl);
                }
            }
        },this);
		
        new Tips($$('.'+this.options.ttClass+'[title]'));
    }
});

cfe.replace.implement(new cfe.addon.toolTips);
cfe.replace.prototype.addEvent("onComplete", function(){
    this.initToolTips();
});
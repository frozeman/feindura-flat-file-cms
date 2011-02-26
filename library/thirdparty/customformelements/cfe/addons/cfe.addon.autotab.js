/**
 * @module Addon
 */

/**
 * enables auto-jumping from textfield to textfield
 *
 * @class Autotab
 * @namespace cfe.addon
 *
 */
cfe.addon.Autotab = new Class({
	
    initAutoTabbing: function(){
		
        $$('input[class*="autotab-"]').each(function(el, i){
			
            var atOptions = el.get("class").match(/autotab-(\w*\d*)-?(\d)?-?(\w*\d*)?/);
			
            if(atOptions[2]){
											
                el.store("cfeAutoTabOptions", atOptions);
								
                el.addEvent("keyup", function(e){

                    var opt = this.retrieve("cfeAutoTabOptions");
					
                    if(this.get("value").length >= opt[2] && e.code != 16 && !e.shift && e.key != "tab" && e.key != "left" && e.key != "right"){
						
                        this.set("value",this.get("value").substr(0, opt[2]));
						
                        var groupies = $$('input[class*="autotab-'+opt[1]+'"]');
                        var next = groupies[groupies.indexOf(this)+1]?groupies[groupies.indexOf(this)+1]:opt[3]?$(opt[3]):false;
						
                        if(next)
                        {
                            next.focus();
                        }else
                        {
                            this.blur();
                        }
                    }else if(e.key == "backspace" && this.get("value").length == 0){
						
                        var groupies = $$('input[class*="autotab-'+opt[1]+'"]');
                        var prev = groupies[groupies.indexOf(this)-1]?groupies[groupies.indexOf(this)-1]:false;
						
                        if(prev)
                        {
                            prev.focus();
                        }
							
                    }
                });
				
                el.addEvent("focus", function(e){
					
                    var opt = this.retrieve("cfeAutoTabOptions");
					
                    if(this.get("value").length >= opt[2])
                    {
                        this.select();
                    }
                })
            }
        });
    }
});

cfe.replace.implement(new cfe.addon.autotab);
cfe.replace.prototype.addEvent("onComplete", function()
{
    this.initAutoTabbing();
});
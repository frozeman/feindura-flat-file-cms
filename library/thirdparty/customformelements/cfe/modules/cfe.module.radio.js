cfe.module.radio=new Class({Extends:cfe.module.checkbox,instance:0,type:"Radiobutton",selector:"input[type=radio]",createOriginal:function(){return new Element("input",{"type":"radio","checked":this.options.checked});},initializeAdv:function(){this.parent();if(!(Browser.Engine.trident||Browser.Engine.gecko)){this.o.addEvent("click",this.update.bind(this));
}},check:function(){this.parent();$$("input[name='"+this.o.get("name")+"']").each(function(a){if(a!=this.o&&a.retrieve("cfe")){a.retrieve("cfe").uncheck();}}.bind(this));}});
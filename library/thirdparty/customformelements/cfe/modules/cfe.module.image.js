cfe.module.image=new Class({Extends:cfe.generic,type:"Image",selector:"input[type=image]",options:{statePrefix:"-cfeState-"},initializeAdv:function(){this.parent();this.a.wraps(this.o);this.stateRegEx=new RegExp(this.options.statePrefix+"([HFP])");},createOriginal:function(){return new Element("input",{type:"image"});
},setState:function(b){this.clearState();var a=this.o.src.lastIndexOf(".");this.o.src=this.o.src.substring(0,a)+this.options.statePrefix+b+this.o.src.substring(a);},clearState:function(){this.o.src=this.o.src.replace(this.stateRegEx,"");},hover:function(){this.parent();this.setState("H");},unhover:function(){this.parent();
this.clearState();if(this.a.hasClass("F")){this.setState("F");}},setFocus:function(){this.parent();if(!this.a.hasClass("P")){this.setState("F");}},removeFocus:function(){this.parent();this.clearState();},press:function(){this.parent();this.setState("P");},release:function(){this.parent();this.clearState();
if(this.a.hasClass("F")){this.setState("F");}},enable:function(){this.parent();this.clearState();},disable:function(){this.parent();this.setState("D");}});
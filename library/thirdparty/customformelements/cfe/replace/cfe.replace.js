/**
 * replacement class for automated replacment of scoped form elements
 *
 * @module replace
 * @namespace cfe
 *
 */

cfe.Replace = new Class(
{
  Implements: [Options, Events],

  options:{
    scope: false/*,
		
    onInit: function(){},
    onInitSingle: function(){},
    onBeforeInitSingle: function(){},
    onSetModuleOption: function(){},
    onRegisterModule: function(){},
    onUnregisterModule: function(){},
    onComplete: function(){}*/
  },
		
  modules: {},
  moduleOptions: {},
  moduleOptionsAll: {},
	
  initialize: function()
  {
    this.registerAllModules.attempt([], this);
  },
	
  /**
   * @method registerAllModules
   * registeres all loaded modules onInitialize
   */
  registerAllModules: function(){
		
    //console.log("Register all modules");

    Object.each(cfe.module, function(modObj, modType){
      //console.log("Registering type "+modType);
      if(modType != "Generic")
        this.registerModule(modType);
				
    },this);
  },
	
  /* call to register module */
  registerModule: function(mod){
		
    //console.log("Call to registerModule with arg:"+mod);
    var modObj = cfe.module[mod];

    this.fireEvent("onRegisterModule", [mod, modObj]);
    this.modules[mod] = modObj;
    this.moduleOptions[mod] = {};

    return true;
  },
	
  registerModules: function(mods)
  {
    Object.each(mods,function(mod){
      this.registerModule(mod);
    },this);
  },
	
  unregisterModule: function(mod)
  {
    var modObj = cfe.module[mod];
		
    this.fireEvent("onUnregisterModule", [mod, modObj]);

    delete this.modules[mod];
  },
	
  unregisterModules: function(mods)
  {
    Object.each(mods,function(mod){
      this.unregisterModule(mod);
    },this);
  },
  /**
   * sets a single option for a specified module
   * if no module was given, it sets the options for all modules
   *
   * @method setModuleOption
   *
   * @param {String} 	mod 	Name of the module
   * @param {String} 	opt 	Name of the option
   * @param {Mixed} 	val		The options value
   */
  setModuleOption: function(mod, opt, val){
		
    var modObj = cfe.module[mod];
		
    this.fireEvent("onSetModuleOption", [mod,modObj,opt,val]);
		
    if(!modObj){
      this.moduleOptionsAll[opt] = val;
    }
    else{
      this.moduleOptions[mod][opt] = val;
    }
  },

  setModuleOptions: function(mod,opt){
		
    Object.each(opt, function(optionValue, optionName){
      this.setModuleOption(mod,optionName,optionValue);
    },this);
		
  },

  engage: function(options){

    this.setOptions(this.options, options);

    if(typeOf(this.options.scope) != "element"){
      this.options.scope = $(document.body);
    }

    this.fireEvent("onInit");
		
    Object.each(this.modules,function(module,moduleName,i){

      var selector = module.prototype.selector;

      this.options.scope.getElements(selector).each(function(el,i){

        if(el.retrieve("cfe") == null){

          var basicOptions = {
            replaces: el
          };

          this.fireEvent("onBeforeInitSingle", [el,i,basicOptions]);

          console.log("creating "+moduleName+" ...");

          var single = new module( Object.merge(basicOptions, this.moduleOptions[moduleName], this.moduleOptionsAll) );

          console.log("creating "+moduleName+" OK");
          console.log("##########################");

          this.fireEvent("onInitSingle", single);
        }else{
          this.fireEvent("onSkippedInitSingle", [el,i,basicOptions]); 
        }
				
      },this);
    },this);
		
    this.fireEvent("onComplete");
  }
});
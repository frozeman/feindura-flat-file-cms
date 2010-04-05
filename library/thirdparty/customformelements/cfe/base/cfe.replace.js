/**
 * replacement class for automated replacment of scoped form elements
 *
 * @module replace
 * @namespace cfe
 *
 */

cfe.replace = new Class(
{
    Implements: [new Options, new Events],

	options:{
		scope: false,
		
		spacer: "",
		
		onInit: $empty,
		onInitSingle: $empty,
		onBeforeInitSingle: $empty,
		onSetModuleOption: $empty,
		onRegisterModule: $empty,
		onUnregisterModule: $empty,
		onComplete: $empty
	},
		
	modules: {},
	moduleOptions: {},
	moduleOptionsAll: {},
	
	initialize: function()
    {

        this.options.spacer = cfe.spacer;
		
		this.registerAllModules.bind(this)();

	},
	
	/**
     * @method registerAllModules
	 * registeres all loaded modules onInitialize
	 */
	registerAllModules: function(){
		
		//console.log("Register all modules");
		
		$each(cfe.module, function(modObj, modType){
			//console.log("Registering type "+modType);
			if(modType != "Generic")
				this.registerModule(modType);
				
		}.bind(this));
	},
	
	/* call to register module */
	registerModule: function(mod){
		
		//console.log("Call to registerModule with arg:"+mod);
		modObj = cfe.module[mod];
		
        this.fireEvent("onRegisterModule", [mod,modObj]);
        this.modules[mod] = modObj;
        this.moduleOptions[mod] = {};

        return true;
	},
	
	registerModules: function(mods)
    {
		$each(mods,function(mod){
			this.registerModule(mod);
		},this);
	},
	
	unregisterModule: function(mod)
    {
		modObj = cfe.module[mod];
		
		this.fireEvent("onUnregisterModule", [mod,modObj]);

		delete this.modules[mod];
	},
	
	unregisterModules: function(mods)
    {
		$each(mods,function(mod){
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
	setModuleOption: function(mod,opt,val){
		
		modObj = cfe.module[mod];
		
		this.fireEvent("onSetModuleOption", [mod,modObj,opt,val]);
		
		if(!modObj){
			this.moduleOptionsAll[opt] = val;
		}
		else{
			this.moduleOptions[mod][opt] = val;
		}
	},

	setModuleOptions: function(mod,opt){
		
		$each(opt, function(optionValue, optionName){
			this.setModuleOption(mod,optionName,optionValue);
		}.bind(this));
		
	},

	init: function(options){

		this.setOptions(this.options, options);

		if($type(this.options.scope) != "element"){
			this.options.scope = $(document.body);
		}

		this.fireEvent("onInit");
		
		$each(this.modules,function(module,moduleName,i){
			
			var selector = module.prototype.selector;
			
			this.options.scope.getElements(selector).each(function(el,i){
				
				var basicOptions = {instanceID: i, spacer:this.options.spacer, replaces: el};

				this.fireEvent("onBeforeInitSingle", [el,i,basicOptions]);
			
				var single = new module($merge(basicOptions,$merge(this.moduleOptions[moduleName],this.moduleOptionsAll)));
				
				this.fireEvent("onInitSingle", single);
				
			},this);
		},this);
		
		this.fireEvent("onComplete");
	}
});
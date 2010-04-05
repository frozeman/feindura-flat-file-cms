/**
 * @module addon
 */

/**
 * ujsd
 * @class dependencies
 * @author Maik
 */
cfe.addon.dependencies = new Class({
	
	/**
	 * adds dependencies for an element 
	 * @param {Object} el
	 * @param {Array} dep
	 */
	addDependencies: function(el, deps){
		$each(deps,function(dep){
			this.addDependency(el,dep);		
		}.bind(this));
		
		return true;
	},
	
	/**
	 * adds dependency for an element 
	 * @param {Object} el
	 * @param {Object} dep
	 */
	addDependency: function(el, dep){
		
		// create an array if needed
		if($type( el.retrieve('deps') ) !== "array"){ el.store('deps', []); }
		
		// deps may be objects or strings > if a string was given, try to interpret it as id and fetch element by $()
		if($type(dep) === "string"){dep = $(dep);}
		
		if($type(dep) === "element"){
			el.retrieve('deps').push(dep);
			return true;
		}
		
		return false;		
	},
	
	getDependencies: function(el)
    {
		return el.retrieve('deps');
	},
	
	/**
	 * this is called when a new item of a cfemodule gets initialized
	 * it checks, whether there are dependencies for this element and adds them to its options
	 * 
	 * @param {Object} el
	 */
	attachDependencies: function(el,i,baseOptions)
    {
	    var deps = this.getDependencies(el);
		
		if($type(deps) === "array"){
			baseOptions.deps = deps;
			return true;
		}
	
		return false;
	}
		
});
cfe.replace.implement(new cfe.addon.dependencies);
cfe.replace.prototype.addEvent("onBeforeInitSingle", cfe.replace.prototype.attachDependencies);

cfe.addon.dependencies.modules = new Class({
	resolveDependencies: function()
    {
		var deps = this.o.retrieve('deps');
		
		if(deps){
			$each(deps, function(dep,i){
				dep.checked = true;
                dep.fireEvent("change");
			}.bind(this));
		}
	}
});

cfe.generic.implement(new cfe.addon.dependencies.modules);

// support for checkboxes
cfe.module.checkbox.prototype.addEvent("onCheck", function(){this.resolveDependencies();});
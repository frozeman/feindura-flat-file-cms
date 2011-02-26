/**
 * @module Addon
 */

/**
 * adds dependencies to checkboxes
 *
 * @class Dependencies
 * @namespace cfe.addon
 *
 */
cfe.addon.Dependencies = new Class({
	
    /**
	 * adds dependencies for an element 
	 * @param {Object} el
	 * @param {Array} dep
	 */
    addDependencies: function(el, deps){
        Array.each(deps,function(dep){
            this.addDependency(el,dep);
        },this);
    },
	
    /**
	 * adds dependency for an element 
	 * @param {Object} el
	 * @param {Object} dep
	 */
    addDependency: function(el, dep){
		
        // create an array if needed
        if(typeOf( el.retrieve('deps') ) !== "array"){
            el.store('deps', []);
        }
		
        // deps may be objects or strings > if a string was given, try to interpret it as id and fetch element by $()
        if(typeOf(dep) === "string" || typeOf(dep) === "element"){
            el.retrieve('deps').push( $(dep) );
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
		
        if(typeOf(deps) === "array"){
            baseOptions.deps = deps;
            return true;
        }
	
        return false;
    }
		
});
cfe.Replace.implement(new cfe.addon.Dependencies);
cfe.Replace.prototype.addEvent("onBeforeInitSingle", cfe.Replace.prototype.attachDependencies);

cfe.addon.Dependencies.Helper = new Class({
    resolveDependencies: function()
    {
        var deps = this.o.retrieve('deps');
		
        if(deps){
            Array.each(deps, function(dep,i){
                dep.checked = true;
                dep.fireEvent("change");
            },this);
        }
    }
});

// support for checkboxes
cfe.module.Checkbox.implement(new cfe.addon.Dependencies.Helper);
cfe.module.Checkbox.prototype.addEvent("onCheck", function(){
    this.resolveDependencies();
});
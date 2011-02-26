/**
 * @module Addon
 */

/**
 * implements selectAll/deselectAll functionality into custom form elements
 *
 * @class ToggleCheckboxes
 * @namespace cfe.addon
 *
 */
cfe.addon.ToggleCheckboxes = new Class({

    // select all checkboxes in scope
    selectAllCheckboxes: function(scope){
        (scope || $(document.body)).getElements("input[type=checkbox]")[0].each(function(el){
            if(el.checked != true)
            {
                el.checked = true;
                el.fireEvent("change");
            }
        });
    },

    // deselect all checkboxes in scope
    deselectAllCheckboxes: function(scope){
        (scope || $(document.body)).getElements("input[type=checkbox]")[0].each(function(el){
            if(el.checked != false)
            {
                el.checked = false;
                el.fireEvent("change");
            }
        });
    }
});

cfe.Replace.implement(new cfe.addon.ToggleCheckboxes);
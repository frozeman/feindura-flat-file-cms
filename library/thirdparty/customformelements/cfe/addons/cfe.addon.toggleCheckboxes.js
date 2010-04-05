/**
 * implements selectAll/deselectAll functionality into custom form elements
 * @class toggleCheckboxes
 *
 */
cfe.addon.toggleCheckboxes = new Class({

    // select all checkboxes in scope
    selectAll: function(scope){
        (scope || $(document.body)).getElements("input[type=checkbox]")[0].each(function(el){
            if(el.checked != true)
            {
                el.checked = true;
                el.fireEvent("change");
            }
        });
    },

    // deselect all checkboxes in scope
    deselectAll: function(scope){
        (scope || $(document.body)).getElements("input[type=checkbox]")[0].each(function(el){
            if(el.checked != false)
            {
                el.checked = false;
                el.fireEvent("change");
            }
        });
    }
});
cfe.replace.implement(new cfe.addon.toggleCheckboxes);
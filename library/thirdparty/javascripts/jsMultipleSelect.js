/*
---
description: Creates a multiple selection where you can have multiple option boxes adding values into one destination box.
You can also change the behavior of the option boxes: remove the options after selecting, or be able to add options multiple times to the destination box.

license: MIT-License

authors:
- Fabian Vogelsteller [frozeman.de]

requires:
- core/1.3: [Class,Options,Events]

provides: [jsMultipleSelect]

...
*/
var jsMultipleSelect = new Class({
  Implements: [Options,Events],
  options: {
    highlightColor: '#cedee6',
    removeButton: new Element('a',{'html':'&#215;'}),
    removeButtonClass: 'remove'
  },
  initialize : function(options){

    // vars
    self = this;
    this.setOptions(options);

    // setup the remove button
    this.options.removeButton.addClass(this.options.removeButtonClass);
    this.options.removeButton.setStyle('cursor','pointer');


    // GO THROUGH ALL DESTINATIONS
    $$('.jsMultipleSelectDestination').each(function(jsMultipleSelectDestination){

      // prevent double parsing of the jsMultipleSelects
      if(jsMultipleSelectDestination.retrieve('parsed') === true) return;
      else jsMultipleSelectDestination.store('parsed',true);

      // vars
      var jsMultipleSelectId = jsMultipleSelectDestination.getProperty('data-jsMultipleSelect'); // to allocate the selection boxes
      var jsMultipleSelectDestinationBg = jsMultipleSelectDestination.getStyle('background-color');
      var removedItems = [];


      // CLOSE FUNCTION
      var closeFunction = function() {
        var clone          = this.getParent('li');
        var item           = clone.retrieve('item');
        var duplicateCount = item.retrieve('duplicateCount');

        if(item.retrieve('remove')) {
          removedItems.erase(item);
          item.setStyle('display','block');
        }
        if(item.retrieve('duplicate'))
          item.store('duplicateCount',--duplicateCount);

        clone.dispose();
      };


      // GO THROUGH ALL OPTION BOXES
      $$('.jsMultipleSelect[data-jsMultipleSelect="'+jsMultipleSelectId+'"]').each(function(jsMultipleSelect){
        // vars
        var items = [];
        var name = jsMultipleSelect.getProperty('data-name'); // later the inputs anme attribute

        // setup CLEAR DESTINATION
        $$('a.clearJsMultipleSelect').each(function(clearButton){
          if(clearButton.getProperty('data-jsMultipleSelect') == jsMultipleSelectId) {
            clearButton.addEvent('click',function(e){
              e.stop();
              jsMultipleSelectDestination.getElements('li.jsMultipleSelectOption').dispose();

              items.each(function(item){
                var duplicateCount = item.retrieve('duplicateCount');
                if(item.retrieve('remove')) {
                  removedItems.erase(item);
                  item.setStyle('display','block');
                }
                if(item.retrieve('duplicate'))
                  item.store('duplicateCount',1);

              });
            });
          }
        });

        // ADD SELECTIONS
        jsMultipleSelect.getChildren('li.jsMultipleSelectOption').each(function(item){

            // vars
            var duplicateCount = 1;
            items.push(item);
            item.setStyle('cursor','pointer');
            var value = item.getProperty('data-value');

            // store values
            item.store('duplicateCount',duplicateCount);
            // item can be cloned or will be removed
            item.store('remove',(item.getProperty('data-type') === 'remove' || item.getParent('ul.jsMultipleSelect').getProperty('data-type') === 'remove'));
            // item can be add multiple times
            item.store('duplicate',(item.getProperty('data-type') === 'duplicates' || item.getParent('ul.jsMultipleSelect').getProperty('data-type') === 'duplicates'));

            // create clone, which will be add to the ul.jsMultipleSelectDestination
            var clone = item.clone();
            clone.setStyle('cursor','auto');

            // add close button
            var close = self.options.removeButton.clone();
            close.addClass(self.options.removeButtonClass);
            close.addEvent('click',closeFunction);
            // form input element
            var input = new Element('input',{
              'type':'hidden',
              'name':name+'[]',
              'value':value
            });
            clone.grab(input,'bottom');
            clone.grab(close,'bottom');

            // store a reference to the clone
            item.store('clone',clone);

            // add click event
            item.addEvent('click',function() {
              duplicateCount = item.retrieve('duplicateCount');

              var injectItem = (item.retrieve('duplicate')) ? clone.clone() : clone;
              // give the injected item a reference to the original item
              injectItem.store('item',item);

              // add event to the duplicated item
              if(item.retrieve('duplicate')) {
                injectItem.getChildren('a.'+self.options.removeButtonClass).addEvent('click',closeFunction);
                if(duplicateCount > 1) {
                  injectItem.grab(new Element('span',{'text':' #'+duplicateCount}));
                }
                item.store('duplicateCount',++duplicateCount);
              }

              if(!jsMultipleSelectDestination.contains(clone) || item.retrieve('duplicate')) {
                injectItem.inject(jsMultipleSelectDestination);
                jsMultipleSelectDestination.highlight(self.options.highlightColor, jsMultipleSelectDestinationBg);

                if(item.retrieve('remove')) {
                  removedItems.push(item);
                  item.setStyle('display','none');
                }

                // fire event
                jsMultipleSelectDestination.fireEvent('select',[value,name,item,injectItem,jsMultipleSelect]);
              }
            });
        });

        // ADD FILTER
        jsMultipleSelect.getChildren('li.filter input').each(function(filter){
          var close = self.options.removeButton.clone();
          close.addClass(self.options.removeButtonClass);
          close.setStyle('display','none');
          close.addEvent('click',function(){
            filter.setProperty('value','');
            filter.fireEvent('keyup');
          });
          close.inject(filter.getParent('li.filter'),'bottom');

          // prevent form submit on ENTER
          filter.addEvent('keydown',function(e){
            if(typeOf(e) != 'null' && e.key == 'enter')
              return false;
          });

          // filter
          filter.addEvent('keyup',function(e){
            // clear on ESC
            if(typeOf(e) != 'null' && e.key == 'esc')
              filter.setProperty('value','');

            // vars
            var filterValue = filter.getProperty('value');

            // ->> FILTER the PAGES
            if(filterValue.length > 0) {
              close.setStyle('display','block');
              items.each(function(item) {
                var itemName = item.get('text');
                if(typeOf(itemName) !== 'null' && itemName.toLowerCase().contains(filterValue.toLowerCase())) {
                  if(!removedItems.contains(item))
                    item.setStyle('display','block');
                } else {
                  item.setStyle('display','none');
                }
              });

            // else SHOW ALL ITEMS AGAIN
            } else {
              close.setStyle('display','none');

              items.each(function(item) {
                if(!removedItems.contains(item))
                  item.setStyle('display','block');
              });
            }
          });
        });
      });

      // PARSE already SELECTED ITEMS (which are in the jsMultipleSelectDestination)
      jsMultipleSelectDestination.getChildren('li[data-name]').each(function(selected) {

        var value = selected.getProperty('data-value');
        var name = selected.getProperty('data-name');

        $$('ul[data-name="'+name+'"] > li.jsMultipleSelectOption[data-value="'+value+'"]').each(function(item){

          var clone          = item.retrieve('clone');
          var duplicateCount = item.retrieve('duplicateCount');
          if(clone === null) return;

          var injectItem = (item.retrieve('duplicate')) ? clone.clone() : clone;
          // give the injected item a reference to the original item
          injectItem.store('item',item);

          // add event to the cloned item
          if(item.retrieve('duplicate')) {
            injectItem.getChildren('a.'+self.options.removeButtonClass).addEvent('click',closeFunction);
            if(duplicateCount > 1)
              injectItem.grab(new Element('span',{'text':' #'+duplicateCount}));

            item.store('duplicateCount',++duplicateCount);
          }

          injectItem.replaces(selected);

          if(item.retrieve('remove')) {
            removedItems.push(item);
            item.setStyle('display','none');
          }

          // fire event
          jsMultipleSelectDestination.fireEvent('parsed',[value,name,item,injectItem,item.getParent('ul.jsMultipleSelect')]);

        });
      });
    });
  }
});
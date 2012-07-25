/*
---
description: Creates a multiple selection where you can have multiple option boxes adding values into one destination box.
You can also change the behavior of the option boxes: remove the options after selecting, or be able to add options multiple times to the destination box.

license: MIT-License

authors:
- Fabian Vogelsteller [frozeman.de]

requires:
- core/1.4: [Class,Options,Events]

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

    self.selections = $$('.jsMultipleSelect');
    self.selectionDropBoxes = $$('.jsMultipleSelectDestination');

    // GO THROUGH ALL SELECTIONS
    self.selections.each(function(jsMultipleSelect){

      // prevent double parsing of the jsMultipleSelects
      if(jsMultipleSelect.retrieve('parsed') === true) return;
      else jsMultipleSelect.store('parsed',true);

      // vars
      var jsMultipleSelectId = jsMultipleSelect.getProperty('data-jsMultipleSelect'); // to allocate the selection boxes
      var name = jsMultipleSelect.getProperty('data-name'); // later the inputs anme attribute
      var items = [];
      var removedItems = [];

      // DROPBOX
      // the <ul> element where all the selections will be droped into
      var dropBox;
      self.selectionDropBoxes.each(function(box){
        if(box.getProperty('data-jsMultipleSelect') == jsMultipleSelectId) {
          dropBox = box;
          return;
        }
      });

      // QUIT IF NO DROPBOX was found
      if(typeOf(dropBox) === 'null')
        return;

      // get DROPBOX BGCOLOR
      var dropBoxBg = dropBox.getStyle('background-color');

      // setup CLEAR DESTINATION
      $$('a.clearJsMultipleSelect').each(function(clearButton){
        if(clearButton.getProperty('data-jsMultipleSelect') == jsMultipleSelectId) {
          clearButton.addEvent('click',function(e){
            e.stop();
            dropBox.getElements('li.jsMultipleSelectItem').dispose();

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

      // ADD SELECTIONS
      jsMultipleSelect.getChildren('li.jsMultipleSelectItem').each(function(item){

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

            if(!dropBox.contains(clone) || item.retrieve('duplicate')) {
              injectItem.inject(dropBox);
              dropBox.highlight(self.options.highlightColor, dropBoxBg);

              if(item.retrieve('remove')) {
                removedItems.push(item);
                item.setStyle('display','none');
              }

              // fire event
              dropBox.fireEvent('select',[value,name,item,injectItem,jsMultipleSelect]);
            }
          });
      });


      // PARSE already SELECTED ITEMS (which are in the jsMultipleSelectDestination)
      dropBox.getChildren('li').each(function(selected) {

        var value = selected.getProperty('data-value');
        var item = jsMultipleSelect.getChildren('li.jsMultipleSelectItem[data-value="'+value+'"]');
        item = (typeOf(item[0]) !== 'null') ? item[0] : null;
        if(item === null)
          return;

        if(selected.getProperty('data-name') === name) {

          var clone          = item.retrieve('clone');
          var duplicateCount = item.retrieve('duplicateCount');

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
          dropBox.fireEvent('parsed',[value,name,item,injectItem,jsMultipleSelect]);
        }
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
  }
});
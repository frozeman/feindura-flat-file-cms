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
    removeButton: new Element('a',{'html':'&#215;','href':'#'}),
    removeButtonClass: 'remove'
  },
  initialize : function(options){

    // vars
    thisInstance = this;
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
      var removedOptions     = [];// removed from the option boxes
      var selectedOptions    = [];

      jsMultipleSelectDestination.store('removedOptions',removedOptions);
      jsMultipleSelectDestination.store('selectedOptions',selectedOptions);

      var jsMultipleSelectDestinationBg = jsMultipleSelectDestination.getStyle('background-color');


      // CLOSE FUNCTION
      var closeFunction = function(e) {
        if(e) e.stop();

        var clone          = this.getParent('li');
        var option         = clone.retrieve('option');

        if(option.retrieve('remove')) {
          removedOptions.erase(option);
          option.setStyle('display','block');
        }

        clone.dispose();

        selectedOptions.erase(clone);

        // fire event
        jsMultipleSelectDestination.fireEvent('remove',[option.getProperty('data-value'),option.getParent('ul.jsMultipleSelect').getProperty('data-name'),clone,option,option.getParent('ul.jsMultipleSelect')]);
      };

      // GET DUPLICATE NUMBER
      // gets the next higher number of an already injected option, is one option number missing, it will fill thsi one first
      var getDuplicateNumber = function(orgOption) {
        var highestNumber = 0;
        var storedNumbers = [];
        var countedNumbers = [];
        var count = 1;

        jsMultipleSelectDestination.getChildren('li.jsMultipleSelectOption').each(function(clone){
          if(orgOption == clone.retrieve('option')) {
            storedNumbers.push(clone.retrieve('number'));
            countedNumbers.push(count++);
            if(clone.retrieve('number') >= highestNumber) {
              highestNumber = clone.retrieve('number');
            }
          }
        });

        // get the missing numbers
        for (var i = 0; i < storedNumbers.length; i++) {
          countedNumbers.erase(storedNumbers[i]);
        }
        // use either a missing number or the next highest number
        if(countedNumbers.length > 0)
          return countedNumbers[0];
        else
          return ++highestNumber;
      };


      // PREPARE the OPTION to INJECT
      var prepareInjectOption = function(option,clone,number) {

        var injectOption = (option.retrieve('duplicate')) ? clone.clone() : clone;
        var duplicateNumber = (number) ? Number(number) : getDuplicateNumber(option);

        injectOption.setProperty('data-number',duplicateNumber);

        injectOption.store('number',duplicateNumber);
        injectOption.store('value',injectOption.getProperty('data-value'));
        injectOption.store('name',injectOption.getProperty('data-name'));
        injectOption.store('option',option);

        if(option.retrieve('duplicate')) {
          // add the remove function to the cloned option
          injectOption.getChildren('a.'+thisInstance.options.removeButtonClass).addEvent('click',closeFunction);

          // add a number to the duplicated option
          if(duplicateNumber > 1)
            injectOption.grab(new Element('span',{'text':' #'+duplicateNumber}));
        }

        return injectOption;
      };

      // CLEAR DESTINATION
      $$('a.clearJsMultipleSelect[data-jsMultipleSelect="'+jsMultipleSelectId+'"]').each(function(clearButton){
        clearButton.addEvent('click',function(e){
          e.stop();
          jsMultipleSelectDestination.getElements('li.jsMultipleSelectOption').dispose();

          $$('.jsMultipleSelect[data-jsMultipleSelect="'+jsMultipleSelectId+'"] li.jsMultipleSelectOption').each(function(option){
            if(option.retrieve('remove')) {
              removedOptions.erase(option);
              option.setStyle('display','block');
            }
            if(option.retrieve('duplicate'))
              option.store('number',0);

            selectedOptions = [];
          });
        });
      });


      // GO THROUGH ALL OPTION BOXES
      $$('.jsMultipleSelect[data-jsMultipleSelect="'+jsMultipleSelectId+'"]').each(function(jsMultipleSelect){
        // vars
        var options = [];
        var name = jsMultipleSelect.getProperty('data-name'); // later the inputs anme attribute


        // ADD SELECTIONS
        jsMultipleSelect.getChildren('li.jsMultipleSelectOption').each(function(option){

            // vars
            options.push(option);
            option.setStyle('cursor','pointer');
            var value = option.getProperty('data-value');

            // store values
            // option can be cloned or will be removed
            option.store('remove',(option.getProperty('data-type') === 'remove' || option.getParent('ul.jsMultipleSelect').getProperty('data-type') === 'remove'));
            // option can be add multiple times
            option.store('duplicate',(option.getProperty('data-type') === 'duplicates' || option.getParent('ul.jsMultipleSelect').getProperty('data-type') === 'duplicates'));

            // create clone, which will be add to the ul.jsMultipleSelectDestination
            var clone = option.clone();
            clone.setStyle('cursor','auto');

            // add close button
            var close = thisInstance.options.removeButton.clone();
            close.addClass(thisInstance.options.removeButtonClass);
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
            option.store('clone',clone);

            // add click event
            option.addEvent('click',function() {
              if(!jsMultipleSelectDestination.contains(clone) || option.retrieve('duplicate')) {

                var injectOption = prepareInjectOption(option,clone);
                injectOption.inject(jsMultipleSelectDestination);

                jsMultipleSelectDestination.highlight(thisInstance.options.highlightColor, jsMultipleSelectDestinationBg);

                if(option.retrieve('remove')) {
                  removedOptions.push(option);
                  option.setStyle('display','none');
                }

                selectedOptions.push(injectOption);

                // fire event
                jsMultipleSelectDestination.fireEvent('select',[value,name,injectOption,option,jsMultipleSelect]);
              }
            });
        });

        // ADD FILTER
        jsMultipleSelect.getChildren('li.filter input').each(function(filter){
          var close = thisInstance.options.removeButton.clone();
          close.addClass(thisInstance.options.removeButtonClass);
          close.setStyle('display','none');
          close.addEvent('click',function(e){
            e.stop();
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
              options.each(function(option) {
                var optionName = option.get('text');
                if(typeOf(optionName) !== 'null' && optionName.toLowerCase().contains(filterValue.toLowerCase())) {
                  if(!removedOptions.contains(option))
                    option.setStyle('display','block');
                } else {
                  option.setStyle('display','none');
                }
              });

            // else SHOW ALL OPTIONS AGAIN
            } else {
              close.setStyle('display','none');

              options.each(function(option) {
                if(!removedOptions.contains(option))
                  option.setStyle('display','block');
              });
            }
          });
        });
      });

      // PARSE already SELECTED OPTIONS (which are in the jsMultipleSelectDestination)
      jsMultipleSelectDestination.getChildren('li[data-name]').each(function(selected) {

        var value = selected.getProperty('data-value');
        var name = selected.getProperty('data-name');
        var number = selected.getProperty('data-number');

        $$('ul[data-name="'+name+'"][data-jsMultipleSelect="'+jsMultipleSelectId+'"] > li.jsMultipleSelectOption[data-value="'+value+'"]').each(function(option){

          var clone = option.retrieve('clone');
          if(clone === null) return;

          var injectOption = prepareInjectOption(option,clone,number);
          injectOption.replaces(selected);

          if(option.retrieve('remove')) {
            removedOptions.push(option);
            option.setStyle('display','none');
          }

          selectedOptions.push(injectOption);

          // fire event
          jsMultipleSelectDestination.fireEvent('parsed',[value,name,injectOption,option,option.getParent('ul.jsMultipleSelect')]);

        });
      });
    });
  }
});
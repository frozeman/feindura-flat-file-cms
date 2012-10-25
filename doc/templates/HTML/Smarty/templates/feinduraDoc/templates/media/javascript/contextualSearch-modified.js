/*
---
description: ContextualSearch is a small but a powerful MooTools plugin
             that allows you to make searching within a set of documentation.

authors:
- Adrian Statescu (http://thinkphp.ro)

license:
- MIT-style license

requires:
core/1.2.1: '*'

provides:
- contextSearch

!! modified for feindura.org/api !!
add PAGE-SEARCH-ENGINE

*/

var contextualSearch = new Class({

    Implements: [Options,Events],

    boxInit: new Element('div',{'class':'moo-search-module-results'}),
    inputElement: null,

    initialize: function(inputId) {

      var thisClass = this;
      this.inputElement = $(inputId);


      // this.setOptions(this.options.targetID);

      this.inputElement.grab(this.boxInit,'after');

      this.inputElement.getNext('[type="submit"]').addEvent('click',function(){
        thisClass.fetchData();
      }.bind(this));

      this.inputElement.addEvent('keydown',function(event){
        this.boxInit.setStyle('display','block');
        // on enter
        if(event.key == 'enter') {
          event.stop();
          this.fetchGoogleData();
        } else {
          // while typing
          this.fetchData();
        }
      }.bind(this));

      // set up

      /* PAGE-SEARCH-ENGINE: search for inpage elements */
      this.resultsOutput = this.boxInit;
      this.hitEnterString = '<br>Hit ENTER to search on other pages';


      // BLEND OUT results if clicked somwhere
      document.addEvent('click',function(e){
        if(e.target !== thisClass.boxInit)
           thisClass.boxInit.setStyle('display','none');
      });
    },

    fetchGoogleData: function() {

        // this gets the user input for the search
        var input = escape(this.inputElement.get('value'));
        var loadingString = '<br><b>Loading...</b>';
        var root = "https://www.googleapis.com/customsearch/v1?";

        // make the GOOGLE call. Use the path var from above and what the user has typed into the input box
        var googleQuery = 'key=AIzaSyARZLhzOLGymoj8_4U2IhMCw39vgO2iW3Y&cx=001444423393092991869:pfv8g8avuc8&q='+encodeURIComponent(input); //+'&callback=hndlr';

        url = root + googleQuery;


        // REQUEST
        new Request.JSONP({

            url: url,

            onRequest: function(){

                this.fireEvent('request');
                // blend out the results after clicking somwhere
                this.resultsOutput.setStyle('display','block');

                // prepare uotput and add "Loading..."
                this.resultsOutput.set("html",this.resultsOutput.get("html").replace(this.hitEnterString,'').replace(loadingString,'') + loadingString);


            }.bind(this),
            onFailure: function(error) {
              //console.log(error);
            },
            onComplete: function(searchResults) {

              var liTemplate = "<li><a href=\"{url}\">{title}</a></li>", markup = '',i;
              //console.log(searchResults);

              if(searchResults.items) {
                // start off the unordered list
                markup = '<br><br><ul>';
                 for (i = 0; i < searchResults.items.length; i++) {
                    markup += '<li><a href="'+ searchResults.items[i].link +'">'+ searchResults.items[i].htmlTitle.replace('feindura API - ','') + '</a></li>';
                 }
                markup += '</ul>';
              } else {
                markup = "<br>Nothing found on other pages";
              }

              this.resultsOutput.set("html", this.resultsOutput.get("html").replace(loadingString,markup));

        }.bind(this)

      }).send();

      return this;
    },

    fetchData: function(){

        // this gets the user input for the search
        var input = escape(this.inputElement.get('value'));

        // blend out the results after clicking somwhere
        this.resultsOutput.setStyle('display','block');

        this.resultsOutput.set("html",'<p><b>Loading...</b></p>');

        var elementsInPage = [];
        if(input) {
          $$('[class$=title]').each(function(element) {
           if(element.getProperty('text') && element.getProperty('text').test(input,"i"))
              elementsInPage.push(element);
          });
        }


         // PAGE-SEARCH-ENGINE: add list for elements in page results
         var markup = '';
         if (elementsInPage.length >= 1) {
           markup += '<ul id="elementsInPageResult"></ul>';
         }

         markup += this.hitEnterString;

         // hook the markup on the DOM now that it's complete
         this.resultsOutput.set("html", markup);

         //  PAGE-SEARCH-ENGINE: INJECT elements ion page result links
         elementsInPage.each(function(element){
              var elementText = element.getProperty('text');
              var elementTextLower = elementText.toLowerCase();
              var inputLower = input.toLowerCase();
              elementText = elementText.substring(elementTextLower.indexOf(inputLower) - 20, elementTextLower.indexOf(inputLower) + inputLower.length + 20);

              var inPageElementLi = new Element('li');

              var inPageElementLink = new Element('a',{
                  'href': '#',
                  'html': elementText, //'..' + elementText + '..',
                  'events': {
                        'click': function(e){
                            e.stop();

                            var anchor = element.getParent('div[class$=row]');
                            anchor = (anchor !== null) ? anchor.getPrevious('a.anchor') : null;

                            if(anchor !== null)
                              window.location.hash = anchor.getProperty('id');
                            else
                              new Fx.Scroll(window,{duration: '300'}).start(0,element.getPosition().y - 50);
                        }
                    }
                  }
              );
              inPageElementLi.grab(inPageElementLink);

              $('elementsInPageResult').grab(inPageElementLi,'bottom');
          });

        return this;
    }

});//end class

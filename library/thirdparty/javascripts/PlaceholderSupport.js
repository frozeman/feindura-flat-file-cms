/*
---
description: Adds cross browser Placeholder support to inputs and textareas, which have a placholder attribute.

license: MIT-License

authors:
- Fabian Vogelsteller [frozeman.de]

requires:
- core/1.3: [Class]

provides: [PlaceholderSupport]

...
*/
var PlaceholderSupport = new Class({
  initialize : function(els){
    if(('placeholder' in document.createElement('input')))
      return;

    var self = this;

    this.elements = (typeOf(els) === 'string') ? $$(els) : els;
    if(typeOf(this.elements) === 'null' || typeOf(this.elements[0]) === 'null') {
      this.elements = $$('input[placeholder],textarea[placeholder]');
    }

    this.elements.each(function(input){
      var textColor = input.getStyle('color');
      var lighterTextColor = self.LightenDarkenColor(textColor,80);

      if(input.getProperty('value') === '') {
        input.setProperty('value',input.getProperty('placeholder'));
        input.setStyle('color',lighterTextColor);
      }

      input.addEvents({
        focus: function(){
          if(input.getProperty('value') === input.getProperty('placeholder')) {
            input.setProperty('value','');
            input.setStyle('color',textColor);
          }
        },
        blur: function(){
          if(input.getProperty('value') === '') {
            input.setProperty('value',input.getProperty('placeholder'));
            input.setStyle('color',lighterTextColor);
          }
        }
      });
    });
  },

  LightenDarkenColor: function LightenDarkenColor(col,amt) {
     var usePound = false;
    if ( col[0] == "#" ) {
        col = col.slice(1);
        usePound = true;
    }

    var num = parseInt(col,16);

    var r = (num >> 16) + amt;

    if ( r > 255 ) r = 255;
    else if  (r < 0) r = 0;

    var b = ((num >> 8) & 0x00FF) + amt;

    if ( b > 255 ) b = 255;
    else if  (b < 0) b = 0;

    var g = (num & 0x0000FF) + amt;

    if ( g > 255 ) g = 255;
    else if  ( g < 0 ) g = 0;
    var rStr = (r.toString(16).length < 2)?'0'+r.toString(16):r.toString(16);
    var gStr = (g.toString(16).length < 2)?'0'+g.toString(16):g.toString(16);
    var bStr = (b.toString(16).length < 2)?'0'+b.toString(16):b.toString(16);

    return (usePound?"#":"") + rStr + gStr + bStr;
  }
});
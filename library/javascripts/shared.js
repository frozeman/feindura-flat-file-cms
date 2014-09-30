/*  feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.

*
*
* shared.php version 0.1 (requires raphael)  */

// vars
var notification = null;
var notificationTimeout;


// EXTEND MOOTOOLS ELEMENTS
Element.implement({
  show: function(){
    var element = this;

    // store the opacity style, if not available
    if(!element.retrieve('opacityStyle')) {
      if(element.getStyle('opacity') !== 0)
        element.store('opacityStyle',element.getStyle('opacity'));
      else
        element.store('opacityStyle',1);
    }

    // store the display style, if not available
    if(!element.retrieve('displayStyle')) {
      if(element.getStyle('display') && element.getStyle('display') !== 'none')
        element.store('displayStyle',element.getStyle('display'));
      else
        element.store('displayStyle','block');
    }

    element.fade('hide');
    element.setStyle('display',element.retrieve('displayStyle'));
    element.fade(element.retrieve('opacityStyle'));
    element.get('tween').chain(function(){
      element.fireEvent('show');
    });
    return element;
  },
  hide: function(){
    var element = this;

    // store the opacity style, if not available
    if(!element.retrieve('opacityStyle')) {
      if(element.getStyle('opacity') !== 0)
        element.store('opacityStyle',element.getStyle('opacity'));
      else
        element.store('opacityStyle',1);
    }

    // store the display style, if not available
    if(!element.retrieve('displayStyle')) {
      if(element.getStyle('display') && element.getStyle('display') !== 'none')
        element.store('displayStyle',element.getStyle('display'));
      else
        element.store('displayStyle','block');
    }

    element.fade(0);
    element.get('tween').chain(function(){
      element.setStyle('display','none');
      element.fireEvent('hide');
    });
    return element;
  },
  getString: function() {
      var tmp = new Element('div');
      this.inject(tmp);

      return tmp.get('html');
  }
});

// create the JS LOADING-CIRCLE
function feindura_loadingCircle(holderid, R1, R2, count, stroke_width, colour) {
    var sectorsCount = count || 12,
        color = colour || "#fff",
        width = stroke_width || 15,
        r1 = Math.min(R1, R2) || 35,
        r2 = Math.max(R1, R2) || 60,
        cx = r2 + width,
        cy = r2 + width,
        r = Raphael(holderid, r2 * 2 + width * 2, r2 * 2 + width * 2),

        sectors = [],
        opacity = [],
        beta = 2 * Math.PI / sectorsCount,

        pathParams = {stroke: color, "stroke-width": width, "stroke-linecap": "round"};
        Raphael.getColor.reset();
    for (var i = 0; i < sectorsCount; i++) {
        var alpha = beta * i - Math.PI / 2,
            cos = Math.cos(alpha),
            sin = Math.sin(alpha);
        opacity[i] = 1 / sectorsCount * i;
        sectors[i] = r.path([["M", cx + r1 * cos, cy + r1 * sin], ["L", cx + r2 * cos, cy + r2 * sin]]).attr(pathParams);
        if (color == "rainbow") {
            sectors[i].attr("stroke", Raphael.getColor());
        }
    }
    var tick;
    (function ticker() {
        opacity.unshift(opacity.pop());
        for (var i = 0; i < sectorsCount; i++) {
            sectors[i].attr("opacity", opacity[i]);
        }
        r.safari();
        tick = setTimeout(ticker, 1000 / sectorsCount);
    })();
    return function () {
        clearTimeout(tick);
        r.remove();
    };
}

// str_replace function
function feindura_str_replace(s, r, c) {
   if (typeof s === 'object' && s && s instanceof Array) {
      for(i=0; i < s.length; i++) {
         c = c.split(s[i]).join(r[i]);
      }
   }
   else {
      c = c.split(s).join(r);
   }
   return c;
}

/* ---------------------------------------------------------------------------------- */
// ->> DISPLAY MESSAGE
function feindura_showNotification(html) {
  clearTimeout(notificationTimeout);

  // var
  var hideNotification = function(){
    notification.set('tween',{duration: 200});
    notification.tween('top',-notification.getSize().y);
    notification.removeEvents('mouseover');
    notification.get('tween').chain(function(){
      notification.dispose();
      notification.empty();
    });
  };
  var showNotification = function(notification) {
    notification.set('tween',{duration: 700});
    notification.setStyle('top',-notification.getSize().y);
    notification.setStyle('visibility','visible');
    notification.tween('top',0);

    notification.addEvent('mouseover',hideNotification);
    notificationTimeout = hideNotification.delay(5000);
  };

  // -> create NEW MESSAGE BOX
  if(!notification) {
    // creates the errorWindow
    notification = new Element('div',{'class':'messagePopUp feindura'});
    notification.set('html',html);
    document.body.grab(notification);
    showNotification(notification);

  // -> fade out and in EXISTING MESSAGE BOX
  } else {
    document.body.grab(notification);
    notification.tween('top',-notification.getSize().y);
    notification.get('tween').chain(function(){
      notification.set('html',html);
      showNotification(notification);
    });
  }
}

/* ---------------------------------------------------------------------------------- */
// ->> DISPLAY ERROR
function feindura_showError(title,errorText) {

  // vars
  var feindura_closeErrorWindow = function(e){
    if(e) e.stop();
    if(errorWindow === null || !errorWindow.hasClass('feindura'))
      return;
    errorWindow.fade('out');
    errorWindow.get('tween').chain(function(){
      errorWindow.destroy();
    });
  };

  if($('errorWindow') !== null)
    $('errorWindow').destroy();

  // creates the errorWindow
  var errorWindow = new Element('div',{id:'errorWindow','class':'feindura', 'style':'left:50%;margin-left:-260px;'});
  errorWindow.grab(new Element('h1',{'text': title}));
  var errorWindowContent = new Element('div',{'class':'content warning', 'html':'<div class="scroll">'+errorText+'</div>'});
  var errorWindowOkButton = new Element('a',{'class':'ok button center', 'href':'#'});
  errorWindow.grab(errorWindowContent);
  errorWindow.grab(errorWindowOkButton);

  document.body.grab(errorWindow);
  errorWindow.setStyle('top',window.getScroll().y + 150);

  // add functionality to the ok button
  errorWindowOkButton.addEvent('click',feindura_closeErrorWindow);

  document.addEvent('keypress',function(e){
    if($('errorWindow') !== null && (e.key == 'esc' || e.key == 'enter')) {
      feindura_closeErrorWindow(e);
    }
  });

  window.addEvent('load',function(){
    errorWindow.setStyle('top',window.getScroll().y + 150); // do it again to make sure, its repositioned
  });
}

// -> STORES the title text in the elements storage
function feindura_storeTipTexts(elements) {
  $$(elements).each(function(element,index) {

    if(element.get('title')) {
      var content = element.get('title').split('::');

      // converts "[" , "]" in "<" , ">"  but BEFORE it changes "<" and ">" in "&lt;","&gt;"
      if(content[1])
        content[1] = feindura_str_replace(new Array("<",">","[", "]"), new Array("&lt;","&gt;","<", ">"), content[1]);

      if(content[0])
        content[0] = feindura_str_replace(new Array("<",">","[", "]"), new Array("&lt;","&gt;","<", ">"), content[0]);

      element.store('tip:title', '<h2>'+content[0]+'</h2>');
      element.store('tip:text', content[1]);
      element.removeProperty('title');
    }
  });
}

// -> STORES the page ID and category ID in the editable element storage
function feindura_setPageIds(editable) {
  var ids = editable.get('data-feindura').split(' ');
  editable.store('page', ids[0]);
  editable.store('category', ids[1]);
  editable.store('language', ids[2]);
  return editable;
}
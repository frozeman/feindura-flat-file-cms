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
// ->> DISPLAY ERROR
function feindura_displayError(title,errorText) {
  // creates the errorWindow
  var errorWindow = new Element('div',{id:'feindura_errorWindow', 'style':'left:50%;margin-left:-260px;'});
  errorWindow.grab(new Element('div',{'class':'feindura_top', 'html': title}));
  var errorWindowContent = new Element('div',{'class':'feindura_content feindura_warning', 'html':'<div class="scroll">'+errorText+'</div>'});
  var errorWindowOkButton = new Element('a',{'class':'feindura_ok', 'href':'#'});
  errorWindowContent.grab(errorWindowOkButton);
  errorWindow.grab(errorWindowContent);
  errorWindow.grab(new Element('div',{'class':'feindura_bottom'}));

  // add functionality to the ok button
  errorWindowOkButton.addEvent('click',feindura_closeErrorWindow);
  document.addEvent('keypress',function(e){
    if(e.key == 'esc' || e.key == 'enter')
      feindura_closeErrorWindow(e);
  });

  return errorWindow;
}
function feindura_closeErrorWindow(e) {
  if(e) e.stop();
  $('feindura_errorWindow').fade('out');
    $('feindura_errorWindow').get('tween').chain(function(){
    $('feindura_errorWindow').destroy();
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

      element.store('tip:title', content[0]);
      element.store('tip:text', content[1]);
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
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
* toolTips.php version 0.12 (require mootools-core AND mootools-more) */

// !!!! TOOLTIPS IN IE DEACTIVATED, WAITING FOR mootools UPDATE !!!!

/* str_replace funktion */
function is_array(value) {
   if (typeof value === 'object' && value && value instanceof Array) {
      return true;
   }
   return false;
}
function str_replace(s, r, c) {
   if (is_array(s)) {
      for(i=0; i < s.length; i++) {
         c = c.split(s[i]).join(r[i]);
      }
   }
   else {
      c = c.split(s).join(r);
   }
   return c;
}

/* set toolTips to all objects with a toolTip class */
function setToolTips() {

  //store titles and text
	$$('.toolTip, .inputToolTip, .thumbnailToolTip').each(function(element,index) {
	  if(element.get('title')) {
      var content = element.get('title').split('::');
     		
     	// converts "[" , "]" in "<" , ">"  but BEFORE it changes "<" and ">" in "&lt;","&gt;"
  		if(content[1]) {      		  
    		content[1] = str_replace(new Array("<",">","[", "]"), new Array("&lt;","&gt;","<", ">"), content[1]);
  		}
  		if(content[0]) {      		  
    		content[0] = str_replace(new Array("<",">","[", "]"), new Array("&lt;","&gt;","<", ">"), content[0]);
  		}
  		
  		element.store('tip:title', content[0]);
  		element.store('tip:text', content[1]);    		
  	}

	});

  
  /* add Tooltips */
  var toolTips = new Tips('.toolTip',{
    className: 'toolTipBox',
    //onShow: function(tip){ tip.fade('show'); }, //tip.fade('hide'); tip.fade('in');
    //onHide: function(tip){ tip.fade('hide'); }, //tip.fade('hide'); tip.fade('out');
    offset: {'x': 10,'y': 15},
    fixed: false,
    showDelay: 200,
    hideDelay: 0 });
  
  /* thumbnailToolTip */
  var toolTipsInput = new Tips('.thumbnailToolTip',{
    className: 'toolTipBox',
    offset: {'x': -320,'y': -20},
    fixed: true,
    showDelay: 130,
    hideDelay: 100 });
  
  // -> window is smaller 1255px
  if(window.getSize().x < 1255) {
    /* inputToolTip */
    var toolTipsInput = new Tips('.inputToolTip',{
      className: 'toolTipBox',
      offset: {'x': -275,'y': -20},
      fixed: true,
      showDelay: 100,
      hideDelay: 100 });    
      
  // -> window is larger 1255px   
  } else {
    /* inputToolTip */
    var toolTipsInput = new Tips('.inputToolTip',{
      className: 'toolTipBox',
      offset: {'x': 500,'y': -20},
      fixed: true,
      showDelay: 100,
      hideDelay: 100 });

  }
}


/* when the DOM is ready */
window.addEvent('domready', function() {
    // toolTips throw error in IE when tooltTips are in a <form> tag
    if(!navigator.appVersion.match(/MSIE ([0-8]\.\d)/))
      setToolTips();
});
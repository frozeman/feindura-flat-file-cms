/*
    feindura - Flat File Content Management System
    Copyright (C) 2009 Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// java/sortPages.js version 0.34 (requires mootools-core and mootools-more)
//
// partly code from http://davidwalsh.name/mootools-drag-drop
// Drag and Drop of the Pages and between the categories

/* when the DOM is ready */
window.addEvent('domready', function() {  
  
  // -------------------------------------------------------------------------------------------
  // HIDE FUNCTIONS of the PAGES ---------------------------------------------------------------
  if($$('ul li div.functions') != null) {  
    
    $$('ul li').each(function(li) {
      var functionsDiv = false;
      
      // get the .functions div
      li.getElements('div').each(function(divs) {
        if(divs.hasClass('functions')) {
          functionsDiv = divs;
        }
      });
      
      // add fade in and out event on mouseover
      if(functionsDiv != false) {
        functionsDiv.set('tween',{duration: '500', transition: Fx.Transitions.Pow.easeOut});
        
        li.addEvent('mouseover',function(e) {
          e.stop();
          
          if(navigator.appVersion.match(/MSIE/))
            functionsDiv.tween('width','140px');
          else
            functionsDiv.tween('opacity','1');
        });
        li.addEvent('mouseout',function(e) {
          e.stop();
          if(navigator.appVersion.match(/MSIE/))
            functionsDiv.tween('width','0px');
          else
            functionsDiv.tween('opacity','0.2');
        });      
      
        // HIDE the functions AT STARTUP
        if(navigator.appVersion.match(/MSIE/))
            functionsDiv.setStyle('width','0px');
          else
            functionsDiv.setStyle('opacity','0.2');            
      }
      
    });    
  }
  
  // -------------------------------------------------------------------------------------------
  // LIST PAGES SORTABLE -----------------------------------------------------------------------
  var clicked = false;
  var categoryOld;
  var categoryNew;
  
  if($('sortablePageList_status') != null)
    var sortablePageList_status = $('sortablePageList_status').get('value').split("|");

  var preventLink = function (){
      return false;
  }  
  
	var sb = new Sortables('.sortablePageList', {
		/* set options */
		//clone: true,
		revert: true,
		opacity: 1,
		snap: 8,
			
		/* --> initialization stuff here */
		initialize: function() {
        
		},
		/* --> once an item is selected */
		onStart: function(el,elClone) {
			//$$('.listPagesSortable li').setStyle('cursor','move'); // ändert den Cursor
			el.setStyle('background-position', '0px -81px');
      			
			categoryOld = el.getParent().get('id').substr(8); // gets the category id where the element comes from

		},
    // überprüft ob sortiert wurde oder nicht		
		onSort: function(el){
  		clicked = true;
  		$$('.sortablePageList a').each(function(a) { a.addEvent('click',preventLink); }); // prevent clicking the link on sort
  	},		
		/* --> when a drag is complete */
		onComplete: function(el) {
			
			// --> SAVE SORT ----------------------
			/* nur wenn sortiert wurde wird werden die seiten neu gespeichert */
			if(clicked) {
			clicked = false;
			
			categoryNew = el.getParent().get('id').substr(8); // gets the category id where the element comes from
			var sortedPageId = el.get('id').substr(4);

			// build a string of the order
			var sort_order = '';
      var count_sort = 0;
          
			$$('.sortablePageList li').each(function(li) {
        if(li.getParent().get('id') == el.getParent().get('id') && li.get('id') != null) {
          sort_order = sort_order + li.get('id').substr(4)  + '|'; count_sort++;
        } });
			$('sort_order' + categoryNew).value = sort_order;
			
			// if pages has changed the category id in the href!
			if(categoryOld != categoryNew) {
        el.getElements('div').each(function(div){
            if(div.hasClass('name')) {
                var oldHref = String(div.getElement('a').get('href'));
                var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                div.getElement('a').set('href',newHref);
            }
            
            if(div.hasClass('status')) {
                var oldHref = String(div.getElement('a').get('href'));      
                var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                div.getElement('a').set('href',newHref);
            }
            
            if(div.hasClass('functions')) {
                div.getElements('a').each(function(a){
                  var oldHref = String(a.get('href'));
                  var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                  a.set('href',newHref);
                  
                  if(a.hasClass('deletePage')) {
                      var oldHref = String(a.get('onclick'));
                      var newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);                
                      a.set('onclick',newHref);
                  }                    
                });                
            }
        });
      }
			
			// shows a nummeration (not in use)
      // dreht die reihenfolge um, wenn sortdesc == true      
			/*if($('reverse' + categoryNew).value)
			 count_sort = count_sort+1;
			else
			 count_sort = 0;
			$$('.sortablePageList span').each(function(span) { if($('reverse').value) count_sort--;	else count_sort++; span.innerHTML = count_sort + '.';});
			*/
			
			// --> sortiert die Seite mithilfe einer AJAX anfrage an library/process/sortPages.php	------------------------------
				var req = new Request({
					url:'library/process/sortPages.php',
					method:'post',
					//autoCancel:true,
					data:'sort_order=' + sort_order + '&categoryOld=' + categoryOld +'&categoryNew=' + categoryNew + '&sortedPageId=' + sortedPageId , // + '&do_submit=1&byajax=1&ajax=' + $('auto_submit').checked
					//-------------------------------------
          onRequest: function() {
            
						//$('sortPagesMessageBox').set('html','<span style="text-decoration:blink;color:#D36100;font-weight:bold;font-size:18px;">'+sortablePageList_status[0]+'</span>');
						
            // put the save new order - text in the loadingBox AND show the loadingBox
            $$('#loadingBox .content')[0].set('html','<span style="text-decoration:blink;color:#D36100;font-weight:bold;font-size:18px;">'+sortablePageList_status[0]+'</span>');
            $('loadingBox').setStyle('display','block');
            $('loadingBox').fade('hide');
            $('loadingBox').fade('in');
            
					},
					//-------------------------------------
					onSuccess: function(responseText) {
            
            // hide the loadingBox
            //$('loadingBox').setStyle('visibility','hidden');
            $('loadingBox').fade('show');
            $('loadingBox').fade('out');
            
            	  
					  // puts the right message which is get from the sortablePageList_status array (hidden input) in the sortPagesMessageBox
					  //$('sortPagesMessageBox').set('html',sortablePageList_status[responseText.substr(6,1)]);
					  $('sortPagesMessageBox').set('html',responseText);
						
						// remove prevent clicking the link on sort
						$$('.sortablePageList a').each(function(a) { a.removeEvent('click',preventLink); });
						
						// remove the "no pages notice" li if there is a page put in this category
            $$('.sortablePageList li').each(function(li) { 
                if(li.get('id') == null && li.getParent().get('id').substr(8) == categoryNew && responseText.substr(-1) != '4') {
                  li.destroy();
                }
            });
            
            // adds the "no page - notice" li if the old category is empty
            if(responseText.substr(0,6) == '&nbsp;') {              
              $$('.sortablePageList').each(function(ul) {
                if(ul.get('id').substr(8) == categoryOld) { // && responseText.substr(-1) != '4'
                  var newLi = new Element('li', {html: '<div>' + sortablePageList_status[1] + '</div>'});
                  newLi.setStyle('cursor','auto');
                  ul.grab(newLi,'top');
                }
              });
            }
					}
				}).send();

	   } // <-- SAVE SORT -- END --------------------
	 }
	});  
  
  // makes the "no pages notice" li un-dragable
  $$('.sortablePageList li').each(function(li) {
      if(li.get('id') == null) {
        li.removeEvents(); 
        li.setStyle('cursor','auto');
      }
      
      /*
      li.hasChild($$('.functions')).addEvent('mouseover',function(e) {
        alert('dd');
        functions.fade('in');
      });
      */
  });



  //var borderStyleBefore;
  //var backgroundStyleBefore;

	// MENU SORTABLE --------------------------------------------
	var sb = new Sortables('sortPagesList', {
		/* set options */
		clone: true,
		revert: true,
		opacity: 1,
		snap: 8,
			
		/* initialization stuff here */
		initialize: function() {			
		},
		/* once an item is selected */
		onStart: function(el,elClone) { 
			$$('#sortPagesList a').setStyle('cursor','move'); // ändert den Cursor
			elClone.setStyle('z-index','1');		
		},
    // überprüft ob sortiert wurde oder nicht		
		onSort: function(el){
  		clicked = true;
  		$$('#sortPagesList a').addEvent('click',preventLink); // prevent clicking the link on sort
  	},		
		/* when a drag is complete */
		onComplete: function(el) {
		  // sets the cursor back
			$$('#sortPagesList a').setStyle('cursor','pointer');
			
			// SAVE SORT ---------------------------
			/* nur wenn sortiert wurde wird werden die seiten neu gespeichert */
			if(clicked) {
			clicked = false;
			
			$$('#sortPagesList a').removeEvent('click',preventLink);// remove prevent clicking the link on sort
			
			// build a string of the order
			var sort_order = '';
      var count_sort = 0;
          
			$$('#sortPagesList a').each(function(a) { sort_order = sort_order + a.get('alt')  + '|'; count_sort++; });
			$('sort_order').value = sort_order;
			
			// nummeriert die seiten neu     
      // dreht die reihenfolge um, wenn sortdesc == true
      
			if($('reverse').value)
			 count_sort = count_sort+1;
			else
			 count_sort = 0;
			$$('#sortPagesList span').each(function(span) { if($('reverse').value) count_sort--;	else count_sort++; span.innerHTML = count_sort + '.';});
			
			
			// sortiert die Seite mithilfe einer AJAX anfrage an library/sortPages.php
			//autosubmit if the checkbox says to	//if($('auto_submit').checked) {			
				// ajax request
				var req = new Request({
					url:'library/sortPages.php',
					method:'post',
					autoCancel:true,
					data:'sort_order=' + sort_order + '&group=' + $('group').value +'&do_submit=1&byajax=1', // '&ajax=' + $('auto_submit').checked
					onRequest: function() {
						$('sortMessageBox').set('text','Speichere die neue Anordnung...');
					},
					onSuccess: function(responseText) {
					  //$('sortMessageBox').set('text',responseText);
						$('sortMessageBox').set('text','Neue Anordnung erfolgreich gespeichert');
					}
				}).send();
			//}
	   }
	 }
	});
});

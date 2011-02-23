/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program;
    if not,see <http://www.gnu.org/licenses/>.
*/
// javascripts/frontendEditing.js version 1.0 (requires mootools and MooRTE)

(function() {
  
  // var
  var pageSaved = false;
  var pageContent = null;
  var editableBlocks = new Array();
  var editableTitles = new Array();
  var pageToolbars =  new Array();
  
  var logo = new Element('a',{ 'href': feindura_url + feindura_basePath, 'id': 'feindura_logo', 'class': 'feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND });
  var topBar = new Element('div',{id: 'feindura_topBar'});
  var topBarVisible = true;
  
  var jsLoadingCircleContainer = new Element('div',{'class':'feindura_loadingCircleContainer'});
  var jsLoadingCircle = new Element('div',{'class': 'feindura_loadingCircleHolder','style':'margin-left: -40px;margin-top: -25px;'});
  jsLoadingCircleContainer.grab(jsLoadingCircle);
  var finishPicture = new Element('div',{'class':'feindura_requestFinish'});
  var editDisabledIcon = new Element('div',{'class':'feindura_editDisabledIcon'});
  var removeLoadingCircle;
  
  // -> set up toolbar  
  var MooRTEButtons = {Toolbar:['save','undo','redo','removeformat', // 'Html/Text'
                                'bold','italic','underline','strikethrough',
                                'justifyleft','justifycenter','justifyright','justifyfull',
                                'outdent','indent','superscript','subscript',
                                'insertorderedlist','insertunorderedlist','blockquote','inserthorizontalrule',
                                'decreasefontsize','increasefontsize'//,'hyperlink'
                                ]};
  
  // ->> FUNCTIONS
  // *************
  
  /* ---------------------------------------------------------------------------------- */
  // ->> SAVE PAGE
  function savePage(pageBlock,type) {
    if(pageSaved === false && pageContent != pageBlock.get('html')) {    
      // removes eventually existing loadingCircleContainers
      $$('.feindura_loadingCircleContainer').each(function(container){
        container.destroy();
      });      
      // url encodes the string
      var content = encodeURIComponent(pageBlock.get('html')).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
      // save the page
      request(pageBlock,feindura_basePath + 'library/processes/frontendEditing.process.php','save=true&type='+type+'&category='+pageBlock.retrieve('category')+'&page='+pageBlock.retrieve('page')+'&data='+content,{title: feindura_langFile.ERRORWINDOW_TITLE,text: feindura_langFile.ERROR_SAVE},'post',true);
      pageSaved = true;
    }
  }
  
  /* ---------------------------------------------------------------------------------- */
  // FRONTEND EDITING AJAX REQUEST
  function request(pageBlock,url,data,errorTexts,method,update) {
    
    // vars
    if(!method) method = 'get';
    
    // creates the request Object
    new Request({
      url: url,
      method: method,
      
      //-----------------------------------------------------------------------------
      onRequest: function() { //-----------------------------------------------------		
        
        // -> ADD the LOADING CIRCLE
        if(!pageBlock.get('html').contains(jsLoadingCircleContainer))
    		  pageBlock.grab(jsLoadingCircleContainer,'top');
    		removeLoadingCircle = feindura_loadingCircle(jsLoadingCircle, 24, 40, 12, 4, "#000");  		
    		// -> TWEEN jsLoadingCircleContainer    
        jsLoadingCircleContainer.set('tween',{duration: 100});
        jsLoadingCircleContainer.setStyle('opacity',0);
        jsLoadingCircleContainer.tween('opacity',0.8);
  
      },
      //-----------------------------------------------------------------------------
  		onSuccess: function(html) { //-------------------------------------------------
  			
  			// -> fade out the loadingCircle
  			jsLoadingCircleContainer.set('tween',{duration: 200});
  			jsLoadingCircleContainer.fade('out');
  			jsLoadingCircleContainer.get('tween').chain(function(){
  			   // -> REMOVE the LOADING CIRCLE
  			   removeLoadingCircle();
           jsLoadingCircleContainer.setStyle('background','transparent');
           jsLoadingCircleContainer.setStyle('opacity',1);
           // request finish picture
  			   jsLoadingCircleContainer.grab(finishPicture,'top');
        });
  			
        finishPicture.set('tween',{duration: 400});
        finishPicture.fade('in');
        finishPicture.get('tween').chain(function(){
          finishPicture.tween('opacity',0);
        }).chain(function(){
          finishPicture.dispose();
          jsLoadingCircleContainer.dispose();
          // update the pageBlock content
          if(update) {
            pageBlock.set('html', html);
      			//Inject the new DOM elements into the results div.
      			//pageBlock.adopt(html);
          }        
        });
  
  		},
  		//-----------------------------------------------------------------------------
  		//Our request will most likely succeed, but just in case, we'll add an
  		//onFailure method which will let the user know what happened.
  		onFailure: function() { //-----------------------------------------------------
        
        // creates the errorWindow
        var errorWindow = new Element('div',{id:'feindura_errorWindow', 'style':'left:50%;margin-left:-260px;'});
        errorWindow.grab(new Element('div',{'class':'feindura_top', 'html': errorTexts.title}));
        var errorWindowContent = new Element('div',{'class':'feindura_content feindura_warning', 'html':'<p>'+errorTexts.text+'</p>'});
        var errorWindowOkButton = new Element('a',{'class':'feindura_ok', 'href':'#'});
        errorWindowContent.grab(errorWindowOkButton);
        errorWindow.grab(errorWindowContent);
        errorWindow.grab(new Element('div',{'class':'feindura_bottom'}));     
        
        // add functionality to the ok button
        errorWindowOkButton.addEvent('click',function(e) {
          e.stop();
          errorWindow.fade('out');
          errorWindow.get('tween').chain(function(){
            errorWindow.destroy();
          });
        });      
        
        // -> fade out the loadingCircle
        if(!pageBlock.get('html').contains(jsLoadingCircleContainer))
          pageBlock.grab(jsLoadingCircleContainer,'top');
  			jsLoadingCircleContainer.set('tween',{duration: 200});
  			jsLoadingCircleContainer.fade('out');
        
  			jsLoadingCircleContainer.get('tween').chain(function(){
  			   // -> REMOVE the LOADING CIRCLE
  			   removeLoadingCircle();
  			   jsLoadingCircleContainer.dispose();
  			   // add errorWindow
           $(document.body).grab(errorWindow,'top');
        });
  
  		}
    }).send(data);
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> ADD TOOLTIPS
  function addToolTips() {
    // store titles and text
    feindura_storeTipTexts('.feindura_toolTip');
  	
  	// add the tooltips to the elements
    var toolTips = new Tips('.feindura_toolTip',{
      className: 'feindura_toolTipBox',
      offset: {'x': 10,'y': 15},
      fixed: false,
      showDelay: 200,
      hideDelay: 0 });
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> GET PAGE ID
  function setPageIds(pageBlock) {
    if(pageBlock.hasClass('feindura_editPage') || pageBlock.hasClass('feindura_editPageDisabled')  || pageBlock.hasClass('feindura_editTitle')) {
      var classes = pageBlock.get('class').split(' ');
      pageBlock.store('page', classes[1].substr(15));
      pageBlock.store('category', classes[2].substr(19));
      return true;
    } else
      return false;
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> deactivate frontend editing
  function deactivate(instant) {
      
    topBarVisible = false;
    
    if(instant) {
      logo.setStyle('top', '-55px');
      $$('div.MooRTE.rtePageTop')[0].setStyle('top', '-25px');
      topBar.setStyle('top', '-55px');
      
      $(document.body).setStyle('padding-top','5px');
      $(document.body).setStyle('background-position-y','5px');

      $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
        pageBlock.moorte('destroy');
      });
      
      pageToolbars.each(function(pageToolbar){
        pageToolbar.setStyle('display','none');
      });
      editableBlocks.each(function(editableBlock){
        editableBlock.removeClass('feindura_editPage');
      });
      editableTitles.each(function(editableTitle){
        editableTitle.removeClass('feindura_editTitle');
      });
    
    } else {
      
      // set the session var
      new Request({ url: feindura_basePath + 'library/processes/frontendEditing.process.php' }).send('deactivateFrontendEditing=true');
    
      logo.tween('top', '-55px');
      $$('div.MooRTE.rtePageTop')[0].tween('top', '-25px');
      topBar.tween('top', '-55px');
      
      topBar.get('tween').chain(function() {
        $(document.body).setStyle('padding-top','5px');
        $(document.body).setStyle('background-position-y','5px');
  
        $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
          pageBlock.moorte('destroy');
        });
        
        pageToolbars.each(function(pageToolbar){
          pageToolbar.setStyle('display','none');
        });
        editableBlocks.each(function(editableBlock){
          editableBlock.removeClass('feindura_editPage');
        });
        editableTitles.each(function(editableTitle){
          editableTitle.removeClass('feindura_editTitle');
        });
      });
    }
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> activate frontend editing
  function activate() {
    
    // set the session var
    new Request({ url: feindura_basePath + 'library/processes/frontendEditing.process.php' }).send('deactivateFrontendEditing=false');
    
    topBarVisible = true;
    
    pageToolbars.each(function(pageToolbar){
      pageToolbar.setStyle('display','block');
    });
    editableBlocks.each(function(editableBlock){
      editableBlock.addClass('feindura_editPage');
    });
    editableTitles.each(function(editableTitle){
      editableTitle.addClass('feindura_editTitle');
    });
    
    /*
    $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
      pageBlock.moorte('create');
    });
    */
    
    new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
    $$('div.MooRTE.rtePageTop')[0].setStyle('top', '-25px');
    
    logo.tween('top', '0px');
    $$('div.MooRTE.rtePageTop')[0].tween('top', '30px');
    topBar.tween('top', '0px');
    
    topBar.get('tween').chain(function() {
      $(document.body).setStyle('padding-top','60px');
      $(document.body).setStyle('background-position-y','60px');
    });    
    
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> create TOP BAR
  function topBarTemplate() {
    var links = new Array();
    links[0] = new Element('a',{ 'href': feindura_logoutUrl, 'class': 'feindura_logout feindura_toolTip', 'title': feindura_langFile.BUTTON_LOGOUT });
    links[1] = new Element('a',{ 'href': feindura_url + feindura_basePath, 'class': 'feindura_toBackend feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND });
    
    // Hide button
    links[2] =new Element('a',{ 'href': '#', 'class': 'feindura_topBarHide'});
    links[2].addEvent('mouseup', function() {
        if(topBarVisible)
          deactivate();
        else         
          activate();
      });
    
    links.each(function(link){
      topBar.grab(link,'bottom');
    });
    
    return topBar;
  };
  
  /* ---------------------------------------------------------------------------------- */
  // ->> create PAGE BAR
  function pageBarTemplate(values) {
    if(feindura_startPage == values.pageId) {
      values.startPageActive = ' active';
      values.startPageText = feindura_langFile.FUNCTIONS_STARTPAGE_SET;
    } else {
      values.startPageActive = '';
      values.startPageText = feindura_langFile.FUNCTIONS_STARTPAGE;
    }
    
    var links = new Array();
    
    // setStartPage
    if(feindura_setStartPage == '1') {
      links[0] = new Element('a',{ 'href': '#', 'class': 'feindura_startPage' + values.startPageActive + ' feindura_toolTip', 'title': values.startPageText + '::'});
      links[0].addEvent('click',function(e) {
        e.stop();
        pageSaved = true;
        request(e.target.getParent('div').getNext('div'),feindura_basePath + 'library/processes/listPages.process.php','status=setStartPage&category=' + values.categoryId + '&page=' + values.pageId,{'title': feindura_langFile.ERRORWINDOW_TITLE,'text': feindura_langFile.ERROR_SETSTARTPAGE});
      });
    }
    // editPage
    links[1] = new Element('a',{ 'href': feindura_basePath + 'index.php?category=' + values.categoryId + '&page=' + values.pageId + '#htmlEditorAnchor', 'class': 'feindura_editPage feindura_toolTip', 'title': feindura_langFile.FUNCTIONS_EDITPAGE + '::' });
    
    return links;
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> DOMREADY
  // ************
  window.addEvent('domready',function() {
  
    // ->> add TOP BAR
    // ***************
    var topBar = topBarTemplate();
    topBar.inject($(document.body),'top');
    logo.inject($(document.body),'top');
    $(document.body).setStyle('padding-top','60px');
    $(document.body).setStyle('background-position-y','60px');
    
    // ->> GO TROUGH ALL EDITABLE BLOCK
    $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
      
      if(pageBlock.hasClass('feindura_editPage'))
        editableBlocks.push(pageBlock);
      if(pageBlock.hasClass('feindura_editTitle'))
        editableTitles.push(pageBlock);
      
      // STORE page IDS in the elements storage
      setPageIds(pageBlock);
      
      // save on blur
      pageBlock.addEvent('blur', function(e) {
        var page = $(e.target);
        
        //alert(MooRTE.Elements.linkPop.visible);
        if(page != null && ((MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false) || MooRTE.Elements.linkPop == null )) {
          if(page.hasClass('feindura_editPage'))
            savePage(page,'content');
          else if(page.hasClass('feindura_editTitle'))
            savePage(page,'title');   
        }
      });    
      // on focus
      pageBlock.addEvent('focus', function() {
        pageContent = pageBlock.get('html');
        if(pageSaved)
          pageSaved = false;
      });
      
    });
    $$('div.feindura_editPageDisabled').each(function(pageBlock) {
      setPageIds(pageBlock);
      
      pageBlock.addEvents({
        mouseenter: function() {
          editDisabledIcon.inject(pageBlock);
        },
        mouseleave: function() {
          editDisabledIcon.dispose();
        }
      });
      
    });
    
    // ->> add BAR to EACH PAGE BLOCK  
    // ******************************  
    $$('div.feindura_editPage, div.feindura_editPageDisabled').each(function(pageBlock) {
      
      //var      
      var pageBarVisible = false;
      var pageBlockFocused = false;
      var parent = pageBlock.getParent();
      
      // ->> create PAGE BAR
      var pageBar = new Element('div',{'class': 'feindura_pageBar'});
      var pageBarContent = pageBarTemplate({ pageId: pageBlock.retrieve('page'), categoryId: pageBlock.retrieve('category'), pageBlockClasses: pageBlock.get('class') });
      pageBarContent.each(function(link){
        link.inject(pageBar,'bottom');
      });
      
      pageToolbars.push(pageBar);
      
      // -> inject the page bar
      pageBar.inject(pageBlock,'before');
      pageBar.set('tween',{duration: 300});
      pageBar.fade('hide');      
      
      // -> set the parent to position: relative      
      if(parent.getStyle('position') != 'relative' && parent.getStyle('position') != 'absolute') { parent.setStyle('position','relative'); }      
      
      // ->> add page bar on focus
      pageBlock.addEvent('mouseenter', function() {
        // -> show the page bar
        // -> set the position of the page bar
        pageBar.setPosition({
          x: pageBlock.getPosition(parent).x + (pageBlock.getSize().x - pageBar.getSize().x),
          y: pageBlock.getPosition(parent).y - pageBar.getSize().y - 5}
        );    
        pageBar.fade('in');
      });
      // ->> set pageBlockFocused on focus
      pageBlock.addEvent('focus', function(e) {
        pageBlockFocused = true;
      });
      
      // ->> remove all page bars on mouseout
      pageBlock.addEvent('mouseleave', function(e) {      
        // -> check if target is not feindura_editPage block
        if(!pageBlockFocused) {          
          pageBar.fade('out');
        }
      });
      // ->> set pageBlockFocused on focus
      pageBlock.addEvent('blur', function(e) {
        pageBar.fade('out');
        pageBlockFocused = false;
      });
      
      // ->> set page bar mouse events
      pageBar.addEvent('mouseenter', function(e) { pageBar.fade('in'); });
      pageBar.addEvent('mouseleave', function(e) { if(!pageBlockFocused) pageBar.fade('out'); });    
    });
    
    addToolTips()
    
    // ->> ADD EDITOR
    // **************
    
    // -> add SAVE BUTTON
    Object.merge(MooRTE.Elements, {
      save : { img:27, onClick: function() {
          $$('div.feindura_editPage, span.feindura_editTitle').each(function(page) {
              if(MooRTE.activeField == page) {
                pageSaved = false;
                if(page.hasClass('feindura_editPage'))
                  savePage(page,'content');
                else if(page.hasClass('feindura_editTitle'))
                  savePage(page,'title');      
              }
          });
        }}
    });
                                          
    // -> create editor instance to edit all divs which have the class "feindura_editPage"
    new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
    
    // -> deactivates frontend editing on start (when the session var is set)
    if(feindura_deactivateFrontendEditing == true)
      deactivate(true);
  });
})();
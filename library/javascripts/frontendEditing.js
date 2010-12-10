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
// javascripts/frontendEditing.js version 0.5 (requires mootools and MooRTE)

/*
// ->> FUNCTIONS

// ->> the function to SAVE the edited page data
function saveEditedPage(editorInstance) {
  editorInstance.updateElement();
  alert(editorInstance.getData());
  editorInstance.destroy();
}


// ->> the function will be execute when a user CLICK on the EDIT BUTTON
function feinduraEditPage(pageId,styleFiles,styleId,styleClass) {
  
  var pageContentName = 'feinduraPage' + pageId;
  var pageContentBlock = $(styleId);

  if(pageContentBlock != null) {
  
    // -> CHECK if instance alrady exists, close and save the page
    for(var i in CKEDITOR.instances) {    
       if(CKEDITOR.instances[i].name == pageContentName) {
        saveEditedPage(CKEDITOR.instances[i])
        return;
       }
    }

    // -> CREATES an editor instance by replacing the container DIV fo the page content
  	var editorInstance = CKEDITOR.replace(pageContentName, {
        width       : pageContentBlock.getSize().x + 24, // 2x 12px
        height      : pageContentBlock.getSize().y + 160, // 125px + 35px
        contentsCss : styleFiles,
        bodyId      : styleId,
        bodyClass   : styleClass
    });
    
    
    editorInstance.on('instanceReady',function(){
      var editorBlock = $('cke_' + pageContentName);
    
      editorBlock.setStyle('margin','-125px -12px -35px -12px');
    });
    
    // -> SAVE automatically IF user LET the editor
    editorInstance.on('blur',function() {
      saveEditedPage(editorInstance);
    });
  }
};

// ->> SET UP CKEDITOR
// *******************
CKEDITOR.config.dialog_backgroundCoverColor   = '#fff';
CKEDITOR.config.uiColor                       = '#cccccc';
CKEDITOR.config.forcePasteAsPlainText         = false;
CKEDITOR.config.scayt_autoStartup             = false;
CKEDITOR.config.colorButton_enableMore        = true;
//CKEDITOR.config.disableNativeSpellChecker = false;

CKEDITOR.config.toolbar = [
                          ['Save','-','Maximize','-','Source'],
                          ['Undo','Redo','-','RemoveFormat','SelectAll'],
                          ['Cut','Copy','Paste','PasteText','PasteFromWord'],
                          ['Find','Replace','-','Print','SpellChecker', 'Scayt'],
                           '/',
                          ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],	                                               
                          ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
                          ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                          ['Link','Unlink','Anchor'],
                          ['Image','Flash','Table','HorizontalRule','SpecialChar'],
                           '/',
                          ['Styles','Format','FontSize'], // 'Font','FontName',
                          ['TextColor','BGColor','-'],
                          ['ShowBlocks','-','About']
                          ];		// No comma for the last row.


// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready',function(){
  CKEDITOR.plugins.registered['save'] = {
     init : function( editorInstance )
     {
        var command = editorInstance.addCommand( 'save',
           {
              modes : { wysiwyg:1, source:0 },
              exec : function( editorInstance ) {
                 //var fo=editor.element.$.form;
                 saveEditedPage(editorInstance);
              }
           }
        );
        editorInstance.ui.addButton( 'Save',{label : 'Save',command : 'save'});
     }
  }
});
*/

(function() {
  
  // var
  var pageSaved = false;
  var pageContent = null;  
  
  var jsLoadingCircleContainer = new Element('div',{'class':'feindura_loadingCircleContainer'});
  var jsLoadingCircle = new Element('div',{'class': 'feindura_loadingCircleHolder','style':'margin-left: -40px;margin-top: -25px;'});
  jsLoadingCircleContainer.grab(jsLoadingCircle);
  var finishPicture = new Element('div',{'class':'feindura_requestFinish'});
  var removeLoadingCircle;
  
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
    if(pageBlock.hasClass('feindura_editPage') || pageBlock.hasClass('feindura_editTitle')) {
      var classes = pageBlock.get('class').split(' ');
      pageBlock.store('page', classes[1].substr(15));
      pageBlock.store('category', classes[2].substr(19));
      return true;
    } else
      return false;
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> RENDER PAGEBAR
  function renderPageBar(values) {
    var startpage = feindura_startPage;
    
    if(startpage == values.pageId) {
      values.startPageActive = ' active';
      values.startPageText = feindura_langFile.FUNCTIONS_STARTPAGE_SET;
    } else {
      values.startPageActive = '';
      values.startPageText = feindura_langFile.FUNCTIONS_STARTPAGE;
    }
    return pageBarTemplate(values);
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> create TOP BAR
  function topBarTemplate() {
    var div = new Element('div',{id: 'feindura_topBar'});
    var logo = new Element('a',{ 'href': feindura_url + feindura_basePath, 'id': 'feindura_logo', 'class': 'feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND });
    var links = new Array();
    links.push(new Element('a',{ 'href': feindura_logoutUrl, 'class': 'feindura_logout feindura_toolTip', 'title': feindura_langFile.BUTTON_LOGOUT }));
    links.push(new Element('a',{ 'href': feindura_url + feindura_basePath, 'class': 'feindura_toBackend feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND }));
    links.each(function(link){
      div.grab(link,'bottom');
    });
    return [div,logo];
  };
  
  /* ---------------------------------------------------------------------------------- */
  // ->> create PAGE BAR
  function pageBarTemplate(values) {
    var links = new Array();
    // editPage
    links[0] = new Element('a',{ 'href': feindura_basePath + 'index.php?category=' + values.categoryId + '&page=' + values.pageId + '#htmlEditorAnchor', 'class': 'feindura_editPage feindura_toolTip', 'title': feindura_langFile.FUNCTIONS_EDITPAGE + '::' });
    // setStartPage
    links[1] = new Element('a',{ 'href': '#', 'class': 'feindura_startPage' + values.startPageActive + ' feindura_toolTip', 'title': values.startPageText + '::'});
    links[1].addEvent('click',function(e) {
      e.stop();
      pageSaved = true;
      request(e.target.getParent('div').getNext('div'),feindura_basePath + 'library/processes/listPages.process.php','status=setStartPage&category=' + values.categoryId + '&page=' + values.pageId,{'title': feindura_langFile.ERRORWINDOW_TITLE,'text': feindura_langFile.ERROR_SETSTARTPAGE});
    });
    
    return links;
  }
  
  /* ---------------------------------------------------------------------------------- */
  // ->> DOMREADY
  // ************
  window.addEvent('domready',function() {
  
    // ->> add TOP BAR
    // ***************
    var topBar = topBarTemplate();
    topBar.each(function(link){
      link.inject($(document.body),'top');
    });
    $(document.body).setStyle('padding-top','60px');
    $(document.body).setStyle('background-position','0px 60px');
    
    // ->> GO TROUGH ALL EDITABLE BLOCK
    $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
      
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
    
    // ->> add BAR to EACH PAGE BLOCK  
    // ******************************  
    $$('div.feindura_editPage').each(function(pageBlock) {    
      
      //var      
      var pageBarVisible = false;
      var pageBlockFocused = false;
      var parent = pageBlock.getParent();
      
      // ->> create PAGE BAR
      var pageBar = new Element('div',{'class': 'feindura_pageBar'});
      var pageBarContent = renderPageBar({ pageId: pageBlock.retrieve('page'), categoryId: pageBlock.retrieve('category'), pageBlockClasses: pageBlock.get('class') });
      pageBarContent.each(function(link){
        link.inject(pageBar,'bottom');
      });
      
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
    Object.extend(MooRTE.Elements, {
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
  
    // -> set up toolbar  
    var MooRTEButtons = {Toolbar:['save.saveBtn','undo','redo','removeformat', // 'Html/Text'
                                  'bold','italic','underline','strikethrough',
                                  'justifyleft','justifycenter','justifyright','justifyfull',
                                  'outdent','indent','superscript','subscript',
                                  'insertorderedlist','insertunorderedlist','blockquote','inserthorizontalrule',
                                  'decreasefontsize','increasefontsize'//,'hyperlink'
                                  ]};
                                          
    // -> create editor instance to edit all divs which have the class "feindura_editPage"
    new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
  
  });
})();
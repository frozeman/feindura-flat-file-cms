/*
    feindura - Flat File Content Management System
    Copyright (C) Fabian Vogelsteller [frozeman.de]

    This program is free software;
    you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program; if not,see <http://www.gnu.org/licenses/>.
*/
// javascripts/frontendEditing.js version 1.0 (requires mootools and MooRTE)

(function() {
  if(!window.MooTools || window.Prototype) // CHECK js libraries - 1 (next one when DOM loaded)
    return;

  // var
  var pageSaved = false;
  var pageContent = null;
  var nonEditableBlocks = [];
  var editableBlocks = [];
  var editableTitles = [];
  var pageToolbars =  [];

  var toolTips = null;

  var logo = new Element('a',{ 'href': feindura_url + feindura_currentBackendLocation, 'id': 'feindura_logo', 'class': 'feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND });
  var topBar = new Element('div',{id: 'feindura_topBar'});
  var topBarVisible = (feindura_deactivateFrontendEditing) ? false : true;

  var jsLoadingCircle = new Element('div',{'class': 'feindura_loadingCircleHolder'});
  var loadingFill = new Element('div',{'class':'feindura_loadingFill'});
  var finishPicture = new Element('div',{'class':'feindura_editFinishIcon'});
  var editDisabledIcon = new Element('div',{'class':'feindura_editDisabledIcon'});
  var removeLoadingCircle = function(){};

  var feinduraMooRTE;

  // -> set up toolbar
  var MooRTEButtons = {Toolbar:['save','undo','redo','removeformat', // 'Html/Text'
                                'bold','italic','underline','strikethrough',
                                'justifyleft','justifycenter','justifyright','justifyfull',
                                'outdent','indent','superscript','subscript',
                                'insertorderedlist','insertunorderedlist','inserthorizontalrule', //,'blockquote'
                                'decreasefontsize','increasefontsize' //,'hyperlink'
                                ]};

  // ->> FUNCTIONS
  // *************

  /* ---------------------------------------------------------------------------------- */
  // ->> SAVE PAGE
  function savePage(pageBlock,type) {
    if(pageSaved === false && pageContent != pageBlock.get('html')) {
      pageBlock.getChildren('#rteMozFix').destroy();
      // url encodes the string
      var content = encodeURIComponent(pageBlock.get('html')).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
      // save the page
      request(pageBlock,feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php','save=true&type='+type+'&language='+pageBlock.retrieve('language')+'&category='+pageBlock.retrieve('category')+'&page='+pageBlock.retrieve('page')+'&data='+content,{title: feindura_langFile.ERRORWINDOW_TITLE,text: feindura_langFile.ERROR_SAVE},'post',true);
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

      onRequest: function() { //-----------------------------------------------------

        // -> TWEEN jsLoadingCircleContainer
        if(!pageBlock.contains(loadingFill))
          pageBlock.grab(loadingFill,'top');
        loadingFill.set('tween',{duration: 100});
        loadingFill.setStyle('opacity',0);
        loadingFill.tween('opacity',0.8);

        // -> ADD the LOADING CIRCLE
        if(!pageBlock.contains(jsLoadingCircle))
          pageBlock.grab(jsLoadingCircle,'top');
        centerOnElement(jsLoadingCircle,pageBlock);
        removeLoadingCircle = feindura_loadingCircle(jsLoadingCircle, 24, 40, 12, 4, "#000");
        jsLoadingCircle.fade('in');
      },
      onSuccess: function(html) { //-------------------------------------------------

        // -> fade out the loading fill
        loadingFill.set('tween',{duration: 200});
        loadingFill.fade('out');
        loadingFill.get('tween').chain(function(){
          loadingFill.dispose();
        });

        // -> fade out the loadingCircle
        jsLoadingCircle.set('tween',{duration: 200});
        jsLoadingCircle.fade('out');
        jsLoadingCircle.get('tween').chain(function(){
          // -> REMOVE the LOADING CIRCLE
          removeLoadingCircle();
          jsLoadingCircle.dispose();

          if(html.contains('####SAVING-ERROR####'))
            document.body.grab(feindura_displayError(errorTexts.title,errorTexts.text),'top');
          else {
            // display finish picture
            pageBlock.grab(finishPicture,'top');
            centerOnElement(finishPicture,pageBlock);
            finishPicture.set('tween',{duration: 400});
            finishPicture.fade('in');
            finishPicture.get('tween').chain(function(){
              finishPicture.fade('out');
            }).chain(function(){
              finishPicture.dispose();
              // -> UPDATE the pageBlock CONTENT
              if(update)
                pageBlock.set('html', html+"<p id='rteMozFix' style='display:none'><br></p>");
            });
          }
        });
      },
      // The request will most likely succeed, but just in case, we'll add an
      // onFailure method which will let the user know what happened.
      onFailure: function() { //-----------------------------------------------------
        console.log('failure');
        // -> fade out the loading fill
        loadingFill.set('tween',{duration: 200});
        loadingFill.fade('out');
        loadingFill.get('tween').chain(function(){
          loadingFill.dispose();
        });

        // -> fade out the loadingCircle
        if(!pageBlock.contains(jsLoadingCircle))
          pageBlock.grab(jsLoadingCircle,'top');
        jsLoadingCircle.set('tween',{duration: 200});
        jsLoadingCircle.fade('out');
        jsLoadingCircle.get('tween').chain(function(){
          // -> REMOVE the LOADING CIRCLE
          removeLoadingCircle();
          jsLoadingCircle.dispose();
          // add errorWindow
          document.body.grab(feindura_displayError(errorTexts.title,errorTexts.text),'top');
        });

      }
    }).send(data);
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> Center Icon in Element, but moves the center up when the element is scrolled away
  function centerOnElement(icon,element) {

    // vars
    var elementXtop = element.getPosition().x - window.getScroll().x;
    var elementYtop = element.getPosition().y - window.getScroll().y;
    var elementXbottom = (window.getScroll().x + window.getSize().x) - (element.getPosition().x + element.getSize().x);
    var elementYbottom = (window.getScroll().y + window.getSize().y) - (element.getPosition().y + element.getSize().y);
    var iconX = 0;
    var iconY = 0;

    // X
    if(element.getPosition().x + element.getSize().x > window.getSize().x) {
      if(elementXtop > 0)
        iconX = (window.getSize().x - elementXtop) / 2;
      else if(elementXtop < 0 && elementXbottom < 0)
        iconX = window.getScroll().x - element.getPosition().x + (window.getSize().x / 2);
      else if(elementXbottom > 0)
        iconX = window.getScroll().x - element.getPosition().x + ((window.getSize().x - elementXbottom) / 2);
    } else
      iconX = '50%';

    // Y
    if(element.getPosition().y + element.getSize().y > window.getSize().y) {
      if(elementYtop > 0)
        iconY = (window.getSize().y - elementYtop) / 2;
      else if(elementYtop < 0 && elementYbottom < 0)
        iconY = window.getScroll().y - element.getPosition().y + (window.getSize().y / 2);
      else if(elementYbottom > 0)
        iconY = window.getScroll().y - element.getPosition().y + ((window.getSize().y - elementYbottom) / 2);
    } else
      iconY = '50%';

    // set the position
		icon.setStyles({
      left: iconX,
      top: iconY
    });
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> ADD TOOLTIPS
  function addToolTips() {
    // store titles and text
    feindura_storeTipTexts('.feindura_toolTip');

    // add the tooltips to the elements
    toolTips = new Tips('.feindura_toolTip',{
      className: 'feindura_toolTipBox',
      offset: {'x': 10,'y': 15},
      fixed: false,
      showDelay: 200,
      hideDelay: 0 });
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> deactivate frontend editing
  function deactivate(instant) {

    // remove classes
    function removeEditClasses() {
      $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
        pageBlock.moorte('destroy');
      });

      pageToolbars.each(function(pageToolbar) {
        pageToolbar.setStyle('display','none');
      });
      nonEditableBlocks.each(function(nonEditableBlock) {
        nonEditableBlock.removeProperty('title');
        nonEditableBlock.removeClass('feindura_editPageDisabled');
        nonEditableBlock.removeEvents();
        // toolTips.detach(nonEditableBlock);
      });
      editableBlocks.each(function(editableBlock) {
        editableBlock.removeClass('feindura_editPage');
        editableBlock.removeProperty('title');
      });
      editableTitles.each(function(editableTitle) {
        editableTitle.removeClass('feindura_editTitle');
        editableTitle.removeProperty('title');
      });
    }

    topBarVisible = false;

    // INSTANT
    if(instant) {
      logo.setStyle('top', '-55px');
      if(typeof($$('div.MooRTE.rtePageTop')[0]) !== 'undefined')
        $$('div.MooRTE.rtePageTop')[0].setStyle('top', '-25px');
      topBar.setStyle('top', '-55px');

      document.body.setStyle('padding-top',5);
      document.body.setStyle('background-position-y',5);

      removeEditClasses();

    // BY TWEEN
    } else {

      // set the session var
      new Request({ url: feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php' }).send('deactivateFrontendEditing=true');

      logo.tween('top', '-55px');
      if($$('div.MooRTE.rtePageTop')[0] !== null)
        $$('div.MooRTE.rtePageTop')[0].tween('top', '-25px');
      topBar.tween('top', '-55px');

      document.body.morph({'padding-top':'5px','background-position-y':'5px'});

      removeEditClasses();
    }
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> activate frontend editing
  function activate() {

    // set the session var
    new Request({ url: feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php' }).send('deactivateFrontendEditing=false');

    topBarVisible = true;

    pageToolbars.each(function(pageToolbar){
      pageToolbar.setStyle('display','block');
    });
    nonEditableBlocks.each(function(nonEditableBlock){
      nonEditableBlock.addClass('feindura_editPageDisabled');
      nonEditableBlock.setProperty('title',nonEditableBlock.retrieve('title'));
      toolTips.attach(nonEditableBlock);
      nonEditableBlock.addEvents({
        mouseenter: function(e) {
            editDisabledIcon.inject(this);
      },
        mouseleave: function(e) {
            editDisabledIcon.dispose();
      }
      });
    });
    editableBlocks.each(function(editableBlock){
      editableBlock.addClass('feindura_editPage');
      editableBlock.setProperty('title',editableBlock.retrieve('title'));
    });
    editableTitles.each(function(editableTitle){
      editableTitle.addClass('feindura_editTitle');
      editableTitle.setProperty('title',editableTitle.retrieve('title'));
    });

    /*
    $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
      pageBlock.moorte('create');
    });
    */

    if($$('div.feindura_editPage, span.feindura_editTitle')[0] !== null) {
      //$$('div.feindura_editPage, span.feindura_editTitle').moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'})
      feinduraMooRTE = new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
      $$('div.MooRTE.rtePageTop')[0].setStyle('top', '-25px');
    }

    logo.tween('top', '0px');
    if($$('div.MooRTE.rtePageTop')[0] !== null)
      $$('div.MooRTE.rtePageTop')[0].tween('top', '30px');
    topBar.tween('top', '0px');
    document.body.morph({'padding-top':'60px','background-position-y':'60px'});

  }

  /* ---------------------------------------------------------------------------------- */
  // ->> disable frontend editing
  function disableEditing(pageBlock) {
      console.log(pageBlock);
      if(pageBlock.hasClass('feindura_editPage') || pageBlock.hasClass('feindura_editPageDisabled')) {

        pageBlock.removeClass('feindura_editPage');
        pageBlock.addClass('feindura_editPageDisabled');
        nonEditableBlocks.push(pageBlock);
        pageBlock.moorte('destroy');

        pageBlock.addEvents({
          mouseenter: function(e) {
              editDisabledIcon.inject(this);
        },
          mouseleave: function(e) {
              editDisabledIcon.dispose();
        }
        });
      }
    }

  /* ---------------------------------------------------------------------------------- */
  // ->> create TOP BAR
  function topBarTemplate() {
    var links = [];
    links[0] = new Element('a',{ 'href': feindura_logoutUrl, 'class': 'feindura_logout feindura_toolTip', 'title': feindura_langFile.BUTTON_LOGOUT });
    links[1] = new Element('a',{ 'href': feindura_url + feindura_currentBackendLocation, 'class': 'feindura_toBackend feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND });

    // Hide button
    links[2] = new Element('a',{ 'href': 'javascript:void(0)', 'class': 'feindura_topBarHide'});
    links[2].addEvent('mouseup', function(e) {
        e.stop();
        if(topBarVisible) deactivate();
        else activate();
      });

    links.each(function(link){
      topBar.grab(link,'bottom');
    });

    return topBar;
  }

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

    var links = [];

    // setStartPage
    if(feindura_setStartPage == '1') {
      links[0] = new Element('a',{ 'href': '#', 'class': 'feindura_startPage' + values.startPageActive + ' feindura_toolTip', 'title': values.startPageText + '::'});
      links[0].addEvent('click',function(e) {
        e.stop();
        pageSaved = true;
        request(e.target.getParent('div').getNext('div'),feindura_url + feindura_basePath + 'library/controllers/listPages.controller.php','status=setStartPage&category=' + values.categoryId + '&page=' + values.pageId,{'title': feindura_langFile.ERRORWINDOW_TITLE,'text': feindura_langFile.ERROR_SETSTARTPAGE});
      });
    }
    // editPage
    links[1] = new Element('a',{ 'href': feindura_url + feindura_basePath + 'index.php?category=' + values.categoryId + '&page=' + values.pageId + '', 'class': 'feindura_editPage feindura_toolTip', 'title': feindura_langFile.FUNCTIONS_EDITPAGE + '::' });

    return links;
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> DOMREADY
  // ************
  window.addEvent('domready',function() {

    if(!window.MooTools || window.Prototype) // CHECK js libraries - 2 (first one on the beginning of the script)
      return;

    // ->> add TOP BAR
    // ***************
    var topBar = topBarTemplate();
    topBar.inject(document.body,'top');
    logo.inject(document.body,'top');
    if(!feindura_deactivateFrontendEditing) {
      document.body.setStyle('padding-top','60px');
      document.body.setStyle('background-position-y','60px');
    }
    document.id('feindura_bodyStyle').destroy(); // removes the <style> tag where it set body padding before the domready event


    // ->> GO TROUGH ALL EDITABLE BLOCK
    $$('div.feindura_editPage, span.feindura_editTitle, div.feindura_editPageDisabled').each(function(pageBlock) {

      // pageBlock.addEventListener('DOMNodeInserted',function(ev){
      //   ev.stopPropagation();
      //   ev.preventDefault();
      //   disableEditing(this);
      // });
      // pageBlock.addEventListener('DOMNodeRemoved',function(ev){
      //   ev.stopPropagation();
      //   ev.preventDefault();
      //   disableEditing(this);
      // });

      // store title
      pageBlock.store('title',pageBlock.getProperty('title'));

      // store editable blocks in arrays
      if(pageBlock.hasClass('feindura_editPage'))
        editableBlocks.push(pageBlock);
      if(pageBlock.hasClass('feindura_editTitle'))
        editableTitles.push(pageBlock);

      // STORE page IDS in the elements storage
      feindura_setPageIds(pageBlock);

      // DECATIVATE DISABLED pageblocks
      if(pageBlock.hasClass('feindura_editPageDisabled')) {
        disableEditing(pageBlock);
        return;
      }

      // save on blur
      pageBlock.addEvent('blur', function(e) {
        //alert(MooRTE.Elements.linkPop.visible);
        if((typeof(MooRTE.Elements.linkPop) == 'undefined' || (MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false))) {
          if(this.hasClass('feindura_editPage'))
            savePage(this,'content');
          else if(this.hasClass('feindura_editTitle'))
            savePage(this,'title');
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

    addToolTips();

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
    if(!feindura_deactivateFrontendEditing && $$('div.feindura_editPage, span.feindura_editTitle')[0] !== null)
      //$$('div.feindura_editPage, span.feindura_editTitle').moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'})
      feinduraMooRTE = new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});

    if(feindura_deactivateFrontendEditing)
      deactivate(true);
  });
})();
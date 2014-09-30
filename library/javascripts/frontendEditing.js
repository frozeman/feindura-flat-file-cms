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
  var nonEditableBlocks = [];
  var editableBlocks = [];
  var editableTitles = [];
  var pageToolbars =  [];

  var toolTips = null;

  var logo = new Element('a',{ 'href': feindura_url + feindura_currentBackendLocation, 'class': 'feindura_logo feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND });
  var topBar = new Element('div',{id: 'feindura_topBar' });
  var topBarText = new Element('p',{'html': feindura_langFile.TOPBAR_TIP_FRONTENDEDITING});
  var topBarVisible = (feindura_deactivateFrontendEditing) ? false : true;

  var jsLoadingCircle = new Element('div',{'class': 'feindura_loadingCircleHolder'});
  var loadingFill = new Element('div',{'class':'feindura_loadingFill'});
  var finishPicture = new Element('div',{'class':'feindura_editFinishIcon'});
  var editDisabledIcon = new Element('div',{'class':'feindura_editDisabledIcon'});
  var removeLoadingCircle = function(){};

  var isUnloading = false;
  window.addEvent('beforeunload',function(){
    isUnloading = true;
  });

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
    if(pageSaved === false && (pageBlock.hasClass('feindura_editPage') || pageBlock.hasClass('feindura_editTitle')) && pageBlock.retrieve('editContent') != pageBlock.get('html')) {
      pageBlock.getChildren('#rteMozFix').destroy();
      // url encodes the string
      var content = encodeURIComponent(pageBlock.get('html')).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
      // save the page
      request(pageBlock,feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php','save=true&type='+type+'&language='+pageBlock.retrieve('language')+'&category='+pageBlock.retrieve('category')+'&page='+pageBlock.retrieve('page')+'&data='+content,{title: feindura_langFile.ERRORWINDOW_TITLE,text: feindura_langFile.ERROR_SAVE},'post');
      pageSaved = true;
    }
  }

  /* ---------------------------------------------------------------------------------- */
  // FRONTEND EDITING AJAX REQUEST
  function request(pageBlock, url, data, errorTexts, method) {

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
        loadingFill.set('tween',{duration: 200});
        loadingFill.fade('hide').fade(0.5);

        // -> ADD the LOADING CIRCLE
        if(!document.body.contains(jsLoadingCircle))
          document.body.grab(jsLoadingCircle,'bottom');
        centerOnElement(jsLoadingCircle,pageBlock);
        removeLoadingCircle = feindura_loadingCircle(jsLoadingCircle, 24, 40, 12, 4, "#000");
        jsLoadingCircle.set('tween',{duration: 200});
        jsLoadingCircle.fade('hide').fade(1);
      },
      onComplete: function() {
        // -> fade out the loading fill
        loadingFill.fade(0);
        loadingFill.get('tween').chain(function(){
          loadingFill.dispose();
        });

        // -> fade out the loadingCircle
        jsLoadingCircle.fade(0);
        jsLoadingCircle.get('tween').chain(function(){
          // -> REMOVE the LOADING CIRCLE
          removeLoadingCircle();
          jsLoadingCircle.dispose();
        });
      },
      onSuccess: function(html) { //-------------------------------------------------

        if(html.contains('####SAVING-ERROR####'))
          document.body.grab(feindura_showError(errorTexts.title,errorTexts.text),'top');
        else {
          // display finish picture
          document.body.grab(finishPicture,'bottom');
          centerOnElement(finishPicture,pageBlock);
          finishPicture.set('tween',{duration: 400});
          finishPicture.fade('in');
          finishPicture.get('tween').chain(function(){
            finishPicture.fade('out');
          }).chain(function(){
            finishPicture.dispose();

            // store the actual content to make a dirtyCheck later
            pageSaved = false;
            pageBlock.store('editContent',pageBlock.get('html'));

          });
        }
      },
      // The request will most likely succeed, but just in case, we'll add an
      // onFailure method which will let the user know what happened.
      onFailure: function() { //-----------------------------------------------------

        // prevent showing of the error message when leaving the page
        if(isUnloading)
          return;

        // add errorWindow
        document.body.grab(feindura_showError(errorTexts.title,errorTexts.text),'top');
      }
    }).send(data);
  }

  /* ---------------------------------------------------------------------------------- */
  // REPLACE CONTENT EDIT CONTENT <-> REAL CONTENT
  function replaceContent(block, mode) {

    if(isUnloading)
      return;

    new Request.HTML({
      url: feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php',
      method: 'post',
      link: 'cancel',
      update: block,
      evalScripts: false,
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {

        // if(mode == 'deactivate')
          // window.fireEvent('domready');

        // block.set('html',responseHTML);

        // var scriptElement = new Element('script',{text:responseJavaScript});
        // block.grab(scriptElement,'bottom');

        // Browser.exec(responseJavaScript);
        

        // if(mode == 'activate') {
        //   // bring the moorte back
        //   block.moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
        //   block.moorte('hide');
        // }
      }
    }).send('replaceContent=true&mode='+ mode +'&page='+ block.retrieve('page') +'&category='+ block.retrieve('category') +'&language='+ block.retrieve('language') +'&xHtml='+ feindura_xHtml);

  }

  /* ---------------------------------------------------------------------------------- */
  // ->> Center Icon in Element, but moves the center up when the element is scrolled away
  function centerOnElement(icon,element) {

    // vars
    // var iconX = 0;
    // var iconY = 0;
    // var elementXtop = (window.getScroll().x < element.getPosition().x) ? element.getPosition().x - window.getScroll().x : 0;
    // var elementYtop = (window.getScroll().y < element.getPosition().y) ? element.getPosition().y - window.getScroll().y : 0;
    // var elementXbottom = ((element.getPosition().x + element.getSize().x) > (window.getScroll().x + window.getSize().x)) ? element.getSize().x - elementXtop : element.getSize().x - elementXtop;
    // var elementYbottom = ((element.getPosition().y + element.getSize().y) > (window.getScroll().y + window.getSize().y)) ? window.getSize().y - elementYtop : element.getSize().y - elementYtop;

    // console.log('scrollY: '+window.getScroll().y,element.getPosition().y);

    // // X
    // iconX = ((elementXbottom - elementXtop) / 2) ;
    // // console.log('elementXbottom: '+elementXbottom,'elementXtop: '+elementXtop,'result: '+iconX);

    // // Y
    // iconY = ((elementYbottom - elementYtop) / 2);
    // console.log('elementYbottom: '+elementYbottom,'elementYtop: '+elementYtop,'result: '+iconY);

    // set the position
    // element.setStyle('position','relative');
		icon.setStyles({
      'position':'fixed',
      'left': (window.getSize().x / 2), //- (icon.getSize().x / 2),
      'top': (window.getSize().y / 2) //- (icon.getSize().y / 2)
    });
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> ADD TOOLTIPS
  function addToolTips() {
    // store titles and text
    feindura_storeTipTexts('.feindura_toolTip');

    // add the tooltips to the elements
    toolTips = new FloatingTips('.feindura_toolTip',{
      className: 'feindura_toolTipBox',
      offset: {'x': 10,'y': 15},
      fixed: false,
      showDelay: 400,
      hideDelay: 0 });
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> deactivate frontend editing
  function deactivate(instant) {

    topBarVisible = false;

    // INSTANT
    if(instant) {
      // logo.setStyle('top', '-55px');
      if(typeOf($$('div.MooRTE.rtePageTop')[0]) !== 'null')
        $$('div.MooRTE.rtePageTop')[0].setStyle('top', '-25px');
      topBar.setStyle('top', '-55px');

      document.body.setStyle('padding-top',5);
      document.body.setStyle('background-position-y',5);


    // BY TWEEN
    } else {

      // set the session var
      new Request({ url: feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php', link: 'chain' }).send('changeFrontendEditing=true&mode=deactivate');

      // logo.tween('top', '-55px');
      if(typeOf($$('div.MooRTE.rtePageTop')[0]) !== 'null')
        $$('div.MooRTE.rtePageTop')[0].tween('top', '-25px');
      topBar.tween('top', '-55px');

      document.body.morph({'padding-top':'5px','background-position-y':'5px'});

    }

    // document.body.get('morph').chain(function(){

      // remove classes
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

        // replace editable content with real one
        replaceContent(editableBlock,'deactivate');
      });
      editableTitles.each(function(editableTitle) {
        editableTitle.removeClass('feindura_editTitle');
        editableTitle.removeProperty('title');
      });

    // });

    // checkForChanges();
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> activate frontend editing
  function activate() {

    // set the session var
    new Request({ url: feindura_url + feindura_basePath + 'library/controllers/frontendEditing.controller.php', link: 'chain' }).send('changeFrontendEditing=true&mode=activate');

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

      // replace real content with editable one
      replaceContent(editableBlock,'activate'); // also activates moorte

      // bring the moorte back
      editableBlock.moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
      editableBlock.moorte('hide');
    });
    editableTitles.each(function(editableTitle){
      editableTitle.addClass('feindura_editTitle');
      editableTitle.setProperty('title',editableTitle.retrieve('title'));

      // bring the moorte back
      editableTitle.moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
      editableTitle.moorte('hide');
    });

    if(typeOf($$('div.feindura_editPage, span.feindura_editTitle')[0]) !== 'null') {
      // $$('div.feindura_editPage, span.feindura_editTitle').moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
      // READD MOORTE
      // feinduraMooRTE = new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
      $$('div.MooRTE.rtePageTop')[0].setStyle('top', '-25px');
    }

    // logo.tween('top', '0px');
    if(typeOf($$('div.MooRTE.rtePageTop')[0]) !== 'null')
      $$('div.MooRTE.rtePageTop')[0].tween('top', '30px');
    topBar.tween('top', '0px');
    document.body.morph({'padding-top':'60px','background-position-y':'60px'});

    // document.body.get('morph').chain(function(){
    //   editableBlocks.each(function(editableBlock){
    //     // replace real content with editable one
    //     replaceContent(editableBlock,'activate'); // also activates moorte
    //   });
    // });

  }

  /* ---------------------------------------------------------------------------------- */
  // ->> disable frontend editing
  function disableEditing(pageBlock) {

      if(pageBlock.hasClass('feindura_editPage') || pageBlock.hasClass('feindura_editTitle') || pageBlock.hasClass('feindura_editPageDisabled')) {

        // is already disabled, dont need to be check again later
        pageBlock.store('firstSelection',false);

        // is pageTITLE
        if(pageBlock.hasClass('feindura_editPage')) {
          // remove from the editable blocks array
          editableBlocks.erase(pageBlock);

          pageBlock.removeClass('feindura_editPage');
          pageBlock.addClass('feindura_editPageDisabled');
        }
        // is pageBLOCK
        if(pageBlock.hasClass('feindura_editTitle')) {
          // remove from the editable blocks array
          editableTitles.erase(pageBlock);

          pageBlock.removeClass('feindura_editTitle');
          pageBlock.addClass('feindura_editTitleDisabled');
        }

        // add tip
        pageBlock.addClass('feindura_toolTip');
        pageBlock.setProperty('title',feindura_langFile.EDITPAGE_TIP_DISABLED);
        // store titles and text
        feindura_storeTipTexts(pageBlock);
        toolTips.attach(pageBlock);

        pageBlock.moorte('destroy');
        nonEditableBlocks.push(pageBlock);

        // remove old events
        pageBlock.removeEvents('focus');
        pageBlock.removeEvents('blur');
        pageBlock.removeEvents('mouseover');

        // add new events
        pageBlock.addEvents({
          mouseenter: function(e) {
              editDisabledIcon.inject(this);
        },
          mouseover: function(e) {
              editDisabledIcon.inject(this);
        },
          mouseleave: function(e) {
              editDisabledIcon.dispose();
        }
        });

        // RE-ADD MOORTE to all other elements
        // if(!feindura_deactivateFrontendEditing && typeOf($$('div.feindura_editPage, span.feindura_editTitle')[0]) !== 'null')
        //   feinduraMooRTE = new MooRTE({elements:$$('div.feindura_editPage, span.feindura_editTitle'),skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
      }
    }

  function checkForChanges(pageBlock) {

    // -> check the GIVEN PAGEBLOCK
    if(pageBlock) {
      if(pageBlock.retrieve('editContent') != pageBlock.get('html')) {
        disableEditing(pageBlock);
        return true;
      } else
        return false;

    // -> otherwise check ALL EDITABLE BLOCKs and disable, if content has changed
    } else {
      $$('div.feindura_editPage, span.feindura_editTitle').each(function(pageBlock) {
        if(pageBlock.retrieve('editContent') != pageBlock.get('html')) {
          disableEditing(pageBlock);
          return;
        }
      });
    }
  }

  /* ---------------------------------------------------------------------------------- */
  // ->> create TOP BAR
  function topBarTemplate() {
    var links = [];
    links[0] = new Element('a',{ 'href': feindura_logoutUrl, 'class': 'feindura_logout feindura_toolTip', 'title': feindura_langFile.BUTTON_LOGOUT,'text':'X' });
    links[1] = new Element('a',{ 'href': feindura_url + feindura_currentBackendLocation, 'class': 'feindura_toBackend feindura_toolTip', 'title': feindura_langFile.BUTTON_GOTOBACKEND, 'text':'>' });

    // Hide button
    links[2] = new Element('a',{ 'href': '#', 'onclick':'return false;', 'class': 'feindura_topBarHide feindura_toolTip', 'title': feindura_langFile.TOPBAR_TIP_DEACTIVATEFRONTENDEDITING+'::'});
    links[2].addEvent('mouseup', function(e) {
        e.stop();
        if(topBarVisible) deactivate();
        else activate();
      });

    links.each(function(link){
      topBar.grab(link,'bottom');
    });

    topBarText.inject(topBar);
    logo.inject(topBar);

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

    // setStartPage (deactivated)
    // links[0] = new Element('a',{ 'href': '#', 'class': 'feindura_startPage' + values.startPageActive + ' feindura_toolTip', 'title': values.startPageText + '::'});
    // links[0].addEvent('click',function(e) {
    //   e.stop();
    //   pageSaved = true;
    //   request(e.target.getParent('div').getNext('div'),feindura_url + feindura_basePath + 'library/controllers/listPages.controller.php','status=setStartPage&category=' + values.categoryId + '&page=' + values.pageId,{'title': feindura_langFile.ERRORWINDOW_TITLE,'text': feindura_langFile.ERROR_SETSTARTPAGE});
    // });
    // editPage
    links[0] = new Element('a',{ 'href': feindura_url + feindura_basePath + 'index.php?category=' + values.categoryId + '&page=' + values.pageId + '', 'class': 'feindura_editPage feindura_toolTip', 'title': feindura_langFile.FUNCTIONS_EDITPAGE + '::' });

    // add tooltips
    feindura_storeTipTexts(links);
    toolTips.attach(links);

    return links;
  }

window.addEvent('load',function(){

    // -> GO TROUGH ALL EDITABLE BLOCKs and disable, if after load something has changed
    checkForChanges();

});

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
    if(!feindura_deactivateFrontendEditing) {
      document.body.setStyle('padding-top','60px');
      document.body.setStyle('background-position-y','60px');
    }
    if(document.id('feindura_bodyStyle') !== null)
      document.id('feindura_bodyStyle').destroy(); // removes the <style> tag where it set body padding before the domready event

    // TOOLTIPS
    addToolTips();

    // ->> GO TROUGH ALL EDITABLE BLOCK
    $$('div.feindura_editPage, span.feindura_editTitle, div.feindura_editPageDisabled').each(function(pageBlock) {

      // store title
      pageBlock.store('title',pageBlock.getProperty('title'));

      // STORE page IDS in the elements storage
      feindura_setPageIds(pageBlock);

      // -> DISABLE CHANGED BLOCKS
      // disable editBlock if it was changed after loading
      if(checkForChanges(pageBlock))
        return;
      pageBlock.store('firstSelection',true);

      // DECATIVATE DISABLED pageblocks
      if(pageBlock.hasClass('feindura_editPageDisabled')) {
        disableEditing(pageBlock);
        return;
      }

      // store editable blocks in arrays
      if(pageBlock.hasClass('feindura_editPage'))
        editableBlocks.push(pageBlock);
      if(pageBlock.hasClass('feindura_editTitle'))
        editableTitles.push(pageBlock);

      // ADD MOORTE to pageBlock
      if(!feindura_deactivateFrontendEditing) {
        pageBlock.moorte({skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});
        pageBlock.moorte('hide');
      }

      // save on blur
      pageBlock.addEvent('blur', function(e) {

        // deactivate the moorte toolbar
        this.moorte('hide');

        // show topBarText
        topBarText.setStyle('display','block');

        //alert(MooRTE.Elements.linkPop.visible);
        if((typeOf(MooRTE.Elements.linkPop) === 'null' || (MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false))) {
          if(this.hasClass('feindura_editPage'))
            savePage(this,'editContent');
          else if(this.hasClass('feindura_editTitle'))
            savePage(this,'title');
        }
      });
      // on focus
      pageBlock.addEvent('focus', function() {

        // disable editBlock if it was changed before first focus
        if(this.retrieve('firstSelection') === true  && checkForChanges(this)) {
          this.blur();
          return;
        }
        this.store('firstSelection',false);

        // store th current content
        this.store('editContent',this.get('html'));

        // activate the moorte toolbar
        this.moorte('show');

        // hide topBarText
        topBarText.setStyle('display','none');
      });

      // on mouse over
      pageBlock.addEvent('mouseover', function(event) {
        // disable editBlock if it was changed before first focus
        if(this.retrieve('firstSelection') === true  && checkForChanges(this)) {
          this.removeEvent('mouseover',this);
          return;
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

    // ->> ADD EDITOR
    // **************

    // -> add SAVE BUTTON
    Object.merge(MooRTE.Elements, {
      save : { img:27, onClick: function() {
          $$('div.feindura_editPage, span.feindura_editTitle').each(function(page) {
              if(MooRTE.activeField == page) {
                if(page.hasClass('feindura_editPage'))
                  savePage(page,'editContent');
                else if(page.hasClass('feindura_editTitle'))
                  savePage(page,'title');
              }
          });
        }}
    });

    // -> ADD MOORTE editor instance to all divs which have the class "feindura_editPage or feindura_editTitle"
    // if(!feindura_deactivateFrontendEditing && typeOf($$('div.feindura_editPage, span.feindura_editTitle')[0]) !== 'null')
    //   feinduraMooRTE = new MooRTE({elements:'div.feindura_editPage, span.feindura_editTitle',skin:'rteFeinduraSkin', buttons: MooRTEButtons,location:'pageTop'});

    if(feindura_deactivateFrontendEditing)
      deactivate(true);
  });
})();
/*
 * feindura - Flat File Content Management System
 * Copyright (C) Fabian Vogelsteller [frozeman.de]
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not,see <http://www.gnu.org/licenses/>.
 *
 *
 * javascripts/content.js version 0.9 (requires mootools-core and mootools-more)
 */

// vars
var userCacheUpdateFrequency = 100; // seconds
var visitorsCountUpdateFrequency = 22; // seconds 22
var currentVisitorsUpdateFrequency = 20; // seconds 20

var toolTipsTop, toolTipsBottom, toolTipsLeft, toolTipsRight;
var deactivateType = 'disabled'; // disabled/readonly
var pageContentChanged = false; // used to give a warning, if a page in the editor.php has been changed and not saved
var HTMLEditor;
var listPagesBars = []; // stores all pages li elements

var staticScrollers = [];


/* GENERAL FUNCTIONS */

// add parameter to a url
function addParameterToUrl(key,value) {

  var parameter = '';
  var newLocation = window.location.href;
  if(window.location.href.indexOf('#') != -1) {
    newLocation = window.location.href.substr(0,window.location.href.indexOf('#'));
    parameter = window.location.href.substr(window.location.href.indexOf('#'));
  }
  newLocation = (newLocation.indexOf('&'+key) != -1) ? newLocation.substr(0,newLocation.indexOf('&'+key)) : newLocation;
  newLocation += '&'+key + '=' + value + parameter;

  return newLocation;
}

// *** ->> TOOLTIPS - functions -----------------------------------------------------------------------------------------------------------------------

/* set toolTips to all objects with a toolTip class */
function setToolTips(containerSelector) {

  var containerSelectorString = (containerSelector)? containerSelector : '';

  //store titles and text
  feindura_storeTipTexts(containerSelectorString + ' .toolTipLeft, '+containerSelectorString+' .toolTipRight, '+containerSelectorString+' .toolTipTop, '+containerSelectorString+' .toolTipBottom');

  var tipOptions = {
    content: function(e){
      var content = '';
      if(e.retrieve('tip:title'))
        content = e.retrieve('tip:title');
      if(e.retrieve('tip:text'))
        content += e.retrieve('tip:text');
      return content;
    },
    html: true,
    arrowSize: 10,
    distance: 5,
    motionOnHide: false,
    showDelay: 400
  };

  toolTipsTop = new FloatingTips(containerSelectorString + ' .toolTipTop',Object.merge(tipOptions,{
    position: 'top'
  }));
  toolTipsBottom = new FloatingTips(containerSelectorString + ' .toolTipBottom',Object.merge(tipOptions,{
    position: 'bottom'
  }));
  toolTipsLeft = new FloatingTips(containerSelectorString + ' .toolTipLeft',Object.merge(tipOptions,{
    position: 'left'
  }));
  toolTipsRight = new FloatingTips(containerSelectorString + ' .toolTipRight',Object.merge(tipOptions,{
    position: 'right'
  }));
}


// ------------------------------------------------------------------------------
// RELOAD the content of an container periodical
function reloadPeriodical(url,updateFrequency,container,divBlockedContainer,extraData) {

  // vars
  container = $(container);
  if(!divBlockedContainer)
    divBlockedContainer = container;

  if(container !== null) {
    (function(){
      var divBlocked = new Element('div',{'class':'divBlocked'}).grab(new Element('div'));
      var removeLoadingCircle;

      new Request({
        'url': url,
        onRequest: function(){
          removeLoadingCircle = feindura_loadingCircle(divBlocked.getChildren('div')[0], 15, 28, 12, 3, "#000");
          divBlockedContainer.grab(divBlocked,'bottom');
          divBlocked.show();
        },
        onSuccess: function(html) {
          divBlocked.hide();
          divBlocked.removeEvents('hide');
          divBlocked.addEvent('hide',function(){
            removeLoadingCircle();
            divBlocked.destroy();

            if(html && html !== '#LOGOUT#') {
              toolTipsTop.detach(container.getElements('.toolTipTop'));
              toolTipsBottom.detach(container.getElements('.toolTipBottom'));
              toolTipsLeft.detach(container.getElements('.toolTipLeft'));
              toolTipsRight.detach(container.getElements('.toolTipRight'));


              container.set('html',html);

              setToolTips('#'+container.getProperty('id'));
              inBlockSlider();
              resizeOnHover();

            } else if(html !== '#LOGOUT#')
              container.empty();
          });
        }
      }).send('status=reloadPeriodical&request=true'+extraData); // status prevents userCache overwriting
    }).periodical(updateFrequency * 1000);
  }
}

// *** ->> SETUP - functions -----------------------------------------------------------------------------------------------------------------------

// ------------------------------------------------------------------------------
// ADD a INPUT FIELD
function addInputField(containerId,inputName) {

  //var newInput = new Element('input', {name: inputName});

  if(containerId && $(containerId) !== null) {
    var newInput  = new Element('input', {type:'text','name': inputName,'class':'input-xlarge'});
    $(containerId).grab(newInput,'bottom');
    $(containerId).grab(new Element('br'),'bottom');
    return true;
  } else
    return false;
}

function disableSafeHtml(checkbox) {
  if(checkbox.checked) {
    $('cfg_editorSafeHtml').disabled = false;
    $('cfg_editorSafeHtml').retrieve('fancyform_replacment').removeClass('fancyform_disabled');
  } else {
    $('cfg_editorSafeHtml').disabled = true;
    $('cfg_editorSafeHtml').retrieve('fancyform_replacment').addClass('fancyform_disabled');
  }
}

// ------------------------------------------------------------------------------
// SET UP the REALTIME THUMBNAIL SIZE SCALE, all given vars are the object IDs
function setThumbScale(thumbWidth,thumbWidthScale,thumbHeight,thumbHeightScale) {

  var scaleWidth = function(){
        $(thumbWidthScale).tween('width',$(thumbWidth).get('value'));
      };
  var scaleHeight = function(){
        $(thumbHeightScale).tween('width',$(thumbHeight).get('value'));
      };

  // thumbwidth
  if($(thumbWidth) !== null) {
      $(thumbWidth).addEvents({
        'keyup': scaleWidth,
        'mouseup': scaleWidth
      });
  }

  // thumbheight
  if($(thumbHeight) !== null) {
      $(thumbHeight).addEvents({
        'keyup': scaleHeight,
        'mouseup': scaleHeight
      });
  }
}


// ------------------------------------------------------------------------------
// DISABLE THUMBNAIL SIZE IF RATIO is ON, all given vars are the object IDs
function setThumbRatio(thumbWidth,thumbWidthRatio,thumbHeight,thumbHeightRatio,thumbNoRatio) {

  // thumbwidth
  if($(thumbWidthRatio) !== null) {
      $(thumbWidthRatio).addEvent('click', function() {
          $(thumbHeight).setProperty(deactivateType,deactivateType);
          $(thumbWidth).removeProperty(deactivateType);
      });
  }

  // thumbheight
  if($(thumbHeightRatio) !== null) {
      $(thumbHeightRatio).addEvent('click', function() {
          $(thumbWidth).setProperty(deactivateType,deactivateType);
          $(thumbHeight).removeProperty(deactivateType);
      });
  }

  // no Ratio
  if($(thumbNoRatio) !== null) {
      $(thumbNoRatio).addEvent('click', function() {
          $(thumbWidth).removeProperty(deactivateType);
          $(thumbHeight).removeProperty(deactivateType);
      });
  }
}

// -------------------------------------------------
// -> editFiles
function changeEditFile( site, fileName, status, anchorName ) {
  window.location.href = window.location.pathname + "?site=" + site + "&status=" + status + "&file=" + fileName + "#" + anchorName ;
}

function setupForm(formId) {
  var form = $(formId);

  // places the right anchor in the form action
  form.addEvent('submit',function(){
    onSubmitSetAnchor(this);
  });

  // places the right anchor, when a submit button is clicked
  form.getElements('input[type="submit"]').addEvent('click',function(){
    onSubmitSetAnchor(form,null,this);
  });
}

// -------------------------------------------------
// -> on SUBMIT goto ANCHOR
function onSubmitSetAnchor(formId,anchorName,activeElement) {
  var form       = $(formId);
  var actionAttr = form.getProperty('action');

  // try to get the anchor manually
  if(!anchorName) {
    if(!activeElement && typeOf(document.activeElement) !== 'null')
      activeElement = document.activeElement;

    if(typeOf(activeElement) !== 'null') {

      var getAnchor;

      // first if its the submit button try to just get the pevious sibling
      if(activeElement.getProperty('type')) {
        getAnchor = activeElement.getAllPrevious('a.anchorTarget');
        if(typeOf(getAnchor) !== 'null' && typeOf(getAnchor[0]) !== 'null')
          anchorName = getAnchor[0].getProperty('id');
      }

      // then try to get it the previous sibling of the .row
      getAnchor = activeElement.getParents('.row');
      if(typeOf(anchorName) === 'null' && typeOf(getAnchor[0]) !== 'null') {
        getAnchor = getAnchor[0].getAllPrevious('a.anchorTarget');
        if(typeOf(getAnchor) !== 'null' && typeOf(getAnchor[0]) !== 'null')
          anchorName = getAnchor[0].getProperty('id');
      }

      // then try to get it the previous sibling of the .block
      if(typeOf(anchorName) === 'null') {
        getAnchor = activeElement.getParents('.block');
        if(typeOf(getAnchor[0]) !== 'null') {
          getAnchor = getAnchor[0].getAllPrevious('a.anchorTarget');
          if(typeOf(getAnchor) !== 'null' && typeOf(getAnchor[0]) !== 'null')
            anchorName = getAnchor[0].getProperty('id');

        }
      }
    }
  }

  // if there is an anchor, set the new one
  if(typeOf(anchorName) !== 'null') {
    // console.log(document.activeElement);
    // console.log(anchorName);
    if(actionAttr.contains('#')) {
      actionAttr = actionAttr.substr(0,actionAttr.indexOf('#'));
    }
    form.set('action',(actionAttr + '#' + anchorName));

    if(typeOf(form.getElement('#savedBlock')) !== 'null')
      form.getElement('#savedBlock').setProperty('value',anchorName);
  }
}

// *** ->> CONTENT - functions -----------------------------------------------------------------------------------------------------------------------

// -------------------------------------------------
// remove the checked="checked" property from a selection of elements
function removeChecked(selector) {
  $$(selector).each(function(selection) {
    selection.removeProperty('checked');
  });
}

// -------------------------------------------------
// RESIZE ELEMENTS ON HOVER
function resizeOnHover() {

  // vars
  var startSize = 100;

  $$('.resizeOnHover').each(function(element){

    // quit if it has already been setup
    if(element.retrieve('resizeOnHover') === true)
      return;

    // vars
    var orgSize = element.getSize().y;
    var slideOutTimeout;
    var slideOut = function(){
        slideOutTimeout = (function() {element.tween('height',orgSize);}).delay(500);
      };
    var slideIn = function(){
        clearTimeout(slideOutTimeout);
        element.tween('height',startSize);
      };

    if(orgSize < startSize)
      return;

    var parentBox = element.getParents('div.box');
    if(typeOf(parentBox[0]) !== 'null') {
      var arrow = new Element('div',{'class':'spacer arrow'});
      parentBox[0].grab(arrow);
      arrow.addEvents({
        'mouseenter': slideOut,
        'mouseleave': function(){
          clearTimeout(slideOutTimeout);
        }
      });
    }

    element.setStyle('height',startSize);
    element.set('tween',{transition: Fx.Transitions.Quint.easeInOut});
    element.addEvents({
      'mouseenter': slideOut,
      'mouseleave': slideIn
    });

    element.store('resizeOnHover',true);
  });
}

// -------------------------------------------------
// BLOCK SLIDE IN/OUT
function blockSlider(givenId) {

  var blocksInDiv = '';
  var scrollToElement = new Fx.Scroll(window,{duration: 400,transition: Fx.Transitions.Quint.easeInOut});

  // prepares the given container div id or class
  if(givenId)
    blocksInDiv = givenId + ' ';

  $$(blocksInDiv + '.block').each(function(block,i) {

    // quit if already setup
    if(block.retrieve('blockSlider') === true)
      return;

     var h1SlideButton, slideContent, bottomBorder;

     // gets the <a> tag in the <h1>
     if(block.getElement('h1') !== null && block.getElement('h1').getElement('a')) {

       h1SlideButton = block.getElement('h1').getElement('a');

       block.getElements('div').each(function(passedDiv) {
         // gets slideing content
         if(passedDiv.hasClass('content')) {
           slideContent = passedDiv;
         }
         if(passedDiv.hasClass('bottom')) {
           bottomBorder = passedDiv;
         }
      });

      // -> CREATE the SLIDE EFFECT
      slideContent.set('slide',{
        duration: 500,
        //transition: Fx.Transitions.Pow.easeInOut, //Fx.Transitions.Back.easeInOut
        transition: Fx.Transitions.Quint.easeInOut,
        onComplete: function(el) {
          if(!slideContent.getChildren('textarea.editFiles')[0]) { // necessary for CodeMirror to calculate the size of the Codemirror div
            if(!this.open) {
                slideContent.setStyle('display','none'); // to allow sorting above the slided in box
                this.wrapper.setStyle('height',slideContent.getSize().y);
                //this.open = false;
            } else {
                this.wrapper.setStyle('height','auto'); // mootools creates an container around slideContent, so that it doesn't resize anymore automaticly, so i have to reset height auto for this container
                //this.open = true;
            }

            // move the listPages
            if($('listPagesBlock') !== null) {
              subCategoryArrows();
              // show sub category arrows
              $$('div.subCategoryArrowLine').fade(1);
            }
          }
        }
      });

      // -> hide the block at start, if it has class "hidden"
      if(block.hasClass('hidden'))  {
        slideContent.slide('hide');
        if(!slideContent.getChildren('textarea.editFiles')[0]) // necessary for CodeMirror to calculate the size of the Codemirror div
          slideContent.setStyle('display','none'); // to allow sorting above the slided in box
      }

      // DONT show the content bottom if IE 0-7
      if(Browser.ie6 || Browser.ie7)
        bottomBorder.setStyle('display', 'none');
      if(Browser.ie6 || Browser.ie7 || Browser.ie8)
        slideContent.set('slide',{transition: Fx.Transitions.Pow.easeInOut});

      // -> set click Event for the SLIDE EFFECT to the buttons
      h1SlideButton.addEvent('click', function(e) {
        e.stop();

        // hide sub category arrows
        if($('listPagesBlock') !== null)
          $$('div.subCategoryArrowLine').fade(0);

        if(!slideContent.get('slide').open) {
          scrollToElement.start(window.getPosition().x,block.getPosition().y - 100);
          slideContent.setStyle('display','block'); // to allow sorting above the slided in box (reset)
          block.removeClass('hidden'); // change the arrow
        } else
          block.addClass('hidden'); // change the arrow
        slideContent.slide('toggle');
      });
    }

    block.store('blockSlider',true);
  });
}

// -------------------------------------------------
// BLOCK SLIDE IN/OUT
function inBlockSlider() {

  $$('.inBlockSlider').each(function(inBlockSlider) {

    var inBlockSliderLinks = [];
    $$('.inBlockSliderLink[data-inBlockSlider="'+inBlockSlider.getProperty('data-inBlockSlider')+'"]').each(function(sliderLink) {
        inBlockSliderLinks.push(sliderLink);
    });

    if(typeOf(inBlockSliderLinks[0]) === 'null')
      return;

    var slide = inBlockSlider.get('slide');
    var wrapper = slide.wrapper;

    // transfer insetBlock class to the wrapper
    if(inBlockSlider.hasClass('insetBlock')) {
      inBlockSlider.removeClass('insetBlock');
      wrapper.addClass('insetBlock');
      wrapper.set('fade',{duration:'short'});
    }

    // slides the hotky div in, on start
    if(inBlockSlider.hasClass('hidden')) {
      // hides the wrapper on start
      wrapper.fade('hide');
     slide.hide();
    }

    // sets the SLIDE effect to the SLIDE links
    inBlockSliderLinks.each(function(inBlockSliderLink){

      // quit if already setup
      if(inBlockSliderLink.retrieve('inBlockSlider') === true)
        return;

      inBlockSliderLink.addEvent('click', function(e) {
        if(e.target.match('a')) e.stop();

        if(inBlockSlider.hasClass('hidden'))
          wrapper.fade(1);
        else
          wrapper.fade(0);

        inBlockSlider.toggleClass('hidden');
        slide.toggle();
      });

      inBlockSliderLink.store('inBlockSlider',true);
    });
  });
}

/* pageChangedSign function
adds a * to the head and the sideBarMenu link of the page, to show that the page was modified, but not saved yet */
function pageContentChangedSign() {

  // shows the submit in the submenu
  if($('subMenuSubmit').getStyle('display') === 'none') {
    $$('.subMenu').setStyle('width',810);
    $('subMenuSubmit').show();
  }

  if($('editorForm') !== null && !pageContentChanged) {
    $$('.notSavedSign' + $('editorForm').get('class')).each(function(notSavedSign) {
      notSavedSign.setStyle('display','inline');
    });
  }

  pageContentChanged = true;
}

// *** ->> SIDEBARS - functions -----------------------------------------------------------------------------------------------------------------------

// -------------------------------------------------
// SLIDE IN/OUT and MOUSEOVER RESIZE
function sidebarMenu() {

  $$('.sidebarMenu').each(function(sideBarMenu) {

    // ->> SLIDE IN/OUT on click -------------------------------------------------------------------------------------------
    // gets the <a> tag in the <div class="content"> container and <div class="bottom">

    // gets the upper toogle button
    var slideTopButton = sideBarMenu.getChildren('div.top a')[0];
    // gets the bottom toogle button
    var slideBottomButton = sideBarMenu.getChildren('div.bottom a')[0];
    // gets slideing content
    var slideContent = sideBarMenu.getChildren('div.menuWrapper')[0];


    // creates the slide effect
    slideContent.set('slide',{duration: '750', transition: Fx.Transitions.Pow.easeOut});

    // changes the up and down button class from the <div class="top">
    // so that the picture of the upper Toogle Buttons changes
    slideContent.get('slide').addEvent('complete', function(el) {
        if(!navigator.appVersion.match(/MSIE ([0-6]\.\d)/))
          sideBarMenu.toggleClass('hidden');
    });

    // -> sets the SLIDE EFFECT to the buttons
    slideTopButton.addEvent('click', function(e){
      e.stop();
      slideContent.get('slide').toggle();
    });
    slideBottomButton.addEvent('click', function(e){
      e.stop();
      slideContent.get('slide').toggle();
    });

    // -> HIDE the Menu IF it has CLASS "HIDDEN"
    if(sideBarMenu.hasClass('hidden')) {
      slideContent.get('slide').hide();
    }

    // ->> RESIZE on MouseOver -------------------------------------------------------------------------------------------

    // -> sets the RESIZE-TWEEN to the sideBarMenu
    sideBarMenu.set('tween', {duration: '650', transition: Fx.Transitions.Pow.easeOut});

  });
}

/* ---------------------------------------------------------------------------------- */
// SIDEBAR AJAX REQUEST
// send a HTML request to load the new Sidebar content
function loadSideBarMenu(site,page,category) {

  // vars
  if(!page) page = 0;
  if(!category) category = 0;
  var rightSidebar = $('rightSidebar');

  var jsLoadingCircleContainer = new Element('div', {'class':'rightSidebarLoadingCircle'});
  var removeLoadingCircle;

  // creates the request Object
  var requestCategory = new Request.HTML({
    url:'library/rightSidebar.loader.php',
    method: 'get',
    data: 'site=' + site + '&category=' + category + '&page=' + page + '&loadSideBarMenu=true',
    update: $('sidebarMenu'),

    //-----------------------------------------------------------------------------
    onRequest: function() { //-----------------------------------------------------

        // -> TWEEN rightSidebar
        rightSidebar.set('tween',{duration: 150});
        rightSidebar.tween('top',-rightSidebar.getSize().y);

        // -> ADD the LOADING CIRCLE
        rightSidebar.grab(jsLoadingCircleContainer,'before');
        removeLoadingCircle = feindura_loadingCircle(jsLoadingCircleContainer, 25, 40, 12, 4, "#999");

    },
    //-----------------------------------------------------------------------------
    onSuccess: function(html) { //-------------------------------------------------

      // -> TWEEN rightSidebar
      rightSidebar.set('tween',{duration: 300});
      rightSidebar.tween('top',0);

      rightSidebar.get('tween').chain(function(){
        // -> REMOVE the LOADING CIRCLE
        jsLoadingCircleContainer.destroy();
        removeLoadingCircle();
      });

      // re-check static scroller
      staticScrollers.each(function(staticScroller){
        staticScroller.checkHeight();
      });

      LeavingWithoutSavingWarning();
      sidebarMenu();
      setToolTips();
    },
    //-----------------------------------------------------------------------------
    //Our request will most likely succeed, but just in case, we'll add an
    //onFailure method which will let the user know what happened.
    onFailure: function() { //-----------------------------------------------------
      sideBarMenus.set('html','<div class="alert alert-error">Couldn\'t load the sidebar?</div>');
    }
  });

  // send only the site
  if(!page && !category)
    requestCategory.send('site=' + site);
  // or with the data string
  else
    requestCategory.send();
}

// -------------------------------------------------
// -> THROW a WARNING when user want to LEAVE THE PAGE WITHOUT SAVING
function LeavingWithoutSavingWarning() {
  $$('a').each(function(link) {
    var href = link.getProperty('href');
    var onclick = link.getProperty('onclick');

    // only on external links (not the sideBarMenu page selection or links which open the windowBox)
    if((onclick === null ||
       (onclick !== null &&
        onclick.toString().indexOf('openWindowBox') == -1 &&
        onclick.toString().indexOf('loadSideBarMenu') == -1)) &&
        (href === null ||
        href.toString().indexOf('#') == -1)) {


      link.addEvent('click',function(e) {
        if(pageContentChanged) {
          e.stop();
          openWindowBox('library/views/windowBox/unsavedPage.php?target=' + escape(href),false);
        }
      });
    }
  });
}


// --------------------------------------------------------------------------------------------
// SHOW SUBCATEGORY ARROW PAGES ---------------------------------------------------------------
function subCategoryArrows() {

  // vars
  var countSubCategoryArrows = 1;
  var subCategoryArrowElements = $$('div.subCategoryArrowLine');
  subCategoryArrowElements.reverse(); // because the array is also in the dom reversed

  subCategoryArrowElements.each(function(arrow){
    countSubCategoryArrows++;

    if($(arrow.getProperty('data-subCategory')) !== null) {
      // vars
      arrow.set('tween', {duration:'short',transition: Fx.Transitions.Quint.easeOut});
      var listPagesBlock        = $('listPagesBlock');
      var parentPage            = $(arrow.getProperty('data-parentPage'));
      var category              = $(arrow.getProperty('data-category')).getParent('div.block');
      var subCategory           = $(arrow.getProperty('data-subCategory')).getParent('div.block');
      var top,height = 0;
      // if the subCategory is under the category with the parent page
      if(subCategory.getPosition(listPagesBlock).y > category.getPosition(listPagesBlock).y) {
        top = (category.hasClass('hidden')) ? (category.getPosition(listPagesBlock).y + 22): (parentPage.getPosition(listPagesBlock).y + 16);
        height = subCategory.getPosition(listPagesBlock).y - top + 30;

        arrow.removeClass('up');
        arrow.addClass('down');

      // if the category with the parent page is under the subCategory
      } else {
        top = subCategory.getPosition(listPagesBlock).y + 20;
        height = (category.hasClass('hidden')) ? (category.getPosition(listPagesBlock).y - subCategory.getPosition(listPagesBlock).y ): (parentPage.getPosition(listPagesBlock).y  - subCategory.getPosition(listPagesBlock).y - 11);

        arrow.removeClass('down');
        arrow.addClass('up');
      }

      // arrow.fade(0);
      // arrow.get('tween').chain(function(){
        arrow.setStyles({
          'display': 'block',
          'top': top,
          'height': height
        });
        // arrow.fade(1);
      // });

      // arrow.morph({'top': top, 'height': subCategory.getPosition(listPagesBlock).y - top + 10});

      if(arrow.getStyle('width') === '0px') {
        arrow.setStyles({
          'width': (countSubCategoryArrows * 20),
          'left': -(countSubCategoryArrows * 20) - 4
        });
      }
    } else
      console.log('Couldn\'t create sub category arrows');

  });
}


// *---------------------------------------------------------------------------------------------------*
//  LOAD (if all pics are loaded)
// *---------------------------------------------------------------------------------------------------*
window.addEvent('load', function() {

  // SCROLL to ANCHORS AFTER LOADING (should fix problems with the scroll position)
  // Also below after blockSlider()
  var anchorId = window.location.hash.substring(1);
  if($(anchorId) !== null)
    (function(){ window.scrollTo(0,this.getPosition().y); }).delay(100,$(anchorId));

});

// *---------------------------------------------------------------------------------------------------*
//  DOMREADY
// *---------------------------------------------------------------------------------------------------*
window.addEvent('domready', function() {

  // adds cross browser placeholder support
  new PlaceholderSupport();

  // enable drag selections
  new jsMultipleSelect();

  // BLOCK SLIDE IN/OUT
  blockSlider();
  inBlockSlider();

  // slide out elements on hover
  resizeOnHover();

  subCategoryArrows();
  // window.addEvent('scroll',moveArrow);


  // STORES all pages LI ELEMENTS
  listPagesBars = $$('div.block.listPagesBlock li');


  // SCROLL to ANCHORS AFTER LOADING (should fix problems with the scroll position)
  // Also above on window 'load'
  var anchorId = window.location.hash.substring(1);
  if($(anchorId) !== null)
    (function(){ window.scrollTo(0,this.getPosition().y); }).delay(100,$(anchorId));


  // UPDATE the USER-CACHE every 3 minutes
  var currentSite = (typeOf(currentSite) == 'null') ? 'login' : currentSite;
  if(currentSite !== 'login'){
    (function(){

      new Request({
        url:'library/includes/backend.include.php',
        method: 'get',
        onSuccess: function(html) {
          if(html == '###RELEASEBLOCK###' && $('contentBlocked') !== null)
            $('contentBlocked').destroy();
        }
      }).send('status=updateUserCache&site='+currentSite+'&page='+currentPage);
    }).periodical(userCacheUpdateFrequency *  1000);
  }


  // -> CHANGE WEBSITE LANGUAGE by the SELECTION
  if($('websiteLanguageSelection') !== null) {
    $('websiteLanguageSelection').addEvent('change',function() {

      var language = this.getSelected().get('value');
      var newLocation = addParameterToUrl('websiteLanguage',language);

      if(pageContentChanged)
        openWindowBox('library/views/windowBox/unsavedPage.php?target=' + escape(newLocation),false);
      else
        window.location.href = newLocation;
    });
  }


  // *** ->> SIDEBAR MENU -----------------------------------------------------------------------------------------------------------------------

  // ->> SIDEBAR SCROLLES LIKE FIXED
  // ---------------------------
  $$('.staticScroller').each(function(element){
    var offset = 1;
    if(element.getProperty('data-offset'))
      offset = element.getProperty('data-offset');

    staticScrollers.push(new StaticScroller(element,{offset:offset}));
  });

  // ADD .active to links which get clicked
  $$('#rightSidebar .menuWrapper a').addEvent('click',function(){
    if(this.hasClass('btn'))
      return;
    $$('#rightSidebar a').removeClass('active');
    this.addClass('active');
  });

  // makes sidebarmenu dynamic
  sidebarMenu();


  // ->> LOG LIST
  // ------------
  if($('sideBarActivityLog') !== null) {
    // var activityScroller = new Scroller('sideBarActivityLog', {area: 150, velocity: 0.1});
    // activityScroller.start();
   }

  // *** ->> CONTENT -----------------------------------------------------------------------------------------------------------------------

  // ADDs SMOOTHSCROLL to ANCHORS
  var smoothAnchorScroll = new Fx.SmoothScroll({
      wheelStops: true,
      duration: 200
  });

  // -------------------------------------------------------------------------------------------
  // TOOLTIPS
  setToolTips();

  // -> RELOAD THE VISITORS COUNT periodical
  reloadPeriodical('library/includes/visitorCount.include.php',visitorsCountUpdateFrequency,'visitorCountInsetBox');

  // -> RELOAD THE CURRENTVISITORS periodical
  reloadPeriodical('library/includes/currentVisitors.include.php',currentVisitorsUpdateFrequency,'currentVisitorsDashboard',$$('#currentVisitorsDashboard > .insetBlock'),'&mode=dashboard');
  reloadPeriodical('library/includes/currentVisitors.include.php',currentVisitorsUpdateFrequency - 1,'currentVisitorsSideBar',$$('#currentVisitorsSideBar > .box'));


  // *** ->> LISTPAGES -----------------------------------------------------------------------------------------------------------------------

  // TWEEN FUNCTIONS in LIST PAGES ---------------------------------------------------------------
  if($$('ul li div.functions') !== null) {

    $$('ul li').each(function(li) {
      var functionsDiv = false;

      // get the .functions div
      li.getElements('div').each(function(divs) {
        if(divs.hasClass('functions')) {
          functionsDiv = divs;
        }
      });

      // add fade in and out event on mouseover
      if(functionsDiv !== false) {
        functionsDiv.set('tween',{duration: '1500', transition: Fx.Transitions.Pow.easeOut});

        li.addEvent('mouseover',function(e) {
          e.stop();

          if(navigator.appVersion.match(/MSIE [0-8]/)) functionsDiv.tween('right','0px');
          else functionsDiv.tween('opacity','1');
        });
        li.addEvent('mouseout',function(e) {
          e.stop();
          if(navigator.appVersion.match(/MSIE [0-8]/)) functionsDiv.tween('right','-150px');
          else functionsDiv.tween('opacity','0.2');
        });

        // HIDE the functions AT STARTUP
        if(navigator.appVersion.match(/MSIE [0-8]/)) functionsDiv.setStyle('right','-150px');
        else functionsDiv.setStyle('opacity','0.2');
      }

    });
  }

  // SELECT PAGES ------------------------------------------------------------------------------
  if($('listPagesBlock') !== null) {
    window.addEvent('keydown',function(e){

      // move the cursor to select pages
      if(typeOf(e.key) != 'null' && (e.key == 'up' || e.key == 'down' ||  e.key == 'enter')) {
        e.stop();

        var pageBefore = null;
        var pageAfter = null;
        var selectedPage = false;

        if($('listPagesFilter').getProperty('value').length === 0)
          listPagesBars = $$('div.block.listPagesBlock li');

        // get the selected page
        listPagesBars.each(function(page){
          if(page.retrieve('selected') === true) {
            selectedPage = page;
            // deselect the old page
            selectedPage.removeClass('active');
            // remove: is selected page
            selectedPage.eliminate('selected');
          }
        });

        // OPEN the page on ENTER
        if(typeOf(e.key) != 'null' && e.key == 'enter' && typeOf(selectedPage) !== 'null' && selectedPage !== false) {
          // e.preventDefault();
          window.location.href = 'index.php?category='+selectedPage.get('data-categoryId')+'&page='+selectedPage.get('data-pageId');
          return;
        }

        // move the selection up or down
        listPagesBars.each(function(curPage,index) {
          if(curPage === selectedPage) {
            pageBefore = listPagesBars[index-1];
            pageAfter = listPagesBars[index+1];
          }
        });
        // move the cursor
        if(typeOf(e) != 'null' && e.key == 'up' && typeOf(pageBefore) !== 'null')
          selectedPage = pageBefore;
        else if(typeOf(e) != 'null' && e.key == 'down' && typeOf(pageAfter) !== 'null')
          selectedPage = pageAfter;

        // select the first if no page was selected
        if(selectedPage === false) {
          selectedPage = listPagesBars[0];
        }


        // mark the selected page
        if(selectedPage !== null && typeOf(selectedPage) !== 'null') {
          selectedPage.addClass('active');
          selectedPage.store('selected',true);

          // slide the current category
          var categoryBlock =  $('category' + selectedPage.get('data-categoryId')).getParent('div.listPagesBlock');
          if(categoryBlock.hasClass('hidden')) {
            categoryBlock.removeClass('hidden'); // change the arrow
            categoryBlock.getElement('div.content').setStyle('display','block'); // to allow sorting above the slided in box (reset)
            categoryBlock.getElement('div.content').slide('show');
            categoryBlock.getElement('div.content').get('slide').wrapper.setStyle('height','auto');
          }
        }
      }
    });
  }

  // FILTER LIST PAGES -------------------------------------------------------------------------
  if($('listPagesFilter') !== null) {
    var cancelListPagesFilter = function(e) {
      if(e) e.stop();

      listPagesBars = $$('div.block.listPagesBlock li');

      $('listPagesFilter').setProperty('value','');
      $('listPagesFilter').fireEvent('keyup');
      $$('.subCategoryArrowLine').setStyle('display','block');
    };
    $('listPagesFilterCancel').addEvent('click',cancelListPagesFilter);
    var storedOpenBlocks = false;
    var openBlocks = [];

    // -> stop moving the cursor on up and down
    $('listPagesFilter').addEvent('keydown',function(e){
      if(e.key == 'up' || e.key == 'down' || e.key == 'enter') {
        e.preventDefault();
      }
    });

    // ->> filter on input
    $('listPagesFilter').addEvent('keyup',function(e){

      // clear on ESC
      if(typeOf(e) != 'null' && e.key == 'esc')
        this.setProperty('value','');

      // vars
      var filter = this.getProperty('value');

      // clear the listPagesBars, to add filtered pages
      if(filter.length > 0) {
        listPagesBars = [];
      }

      // ->> FILTER the PAGES
      if(filter) {

        $$('div.block.listPagesBlock li').each(function(page) {
          var pageTitle = page.getChildren('div div.name a')[0];
          if(typeOf(pageTitle) !== 'null' && pageTitle.get('text').toLowerCase().contains(filter.toLowerCase())) {
            page.setStyle('display','block');
            listPagesBars.push(page);
          } else {
            page.setStyle('display','none');
          }
        });

        // hide empty blocks
        $$('div.block.listPagesBlock').each(function(block) {
          var isEmpty = true;
          block.getElements('li').each(function(li) {
            if(li.getStyle('display') == 'block' && typeOf(li.getChildren('div.emptyList')[0]) == 'null')
              isEmpty = false;
          });

          if(!isEmpty)
            block.setStyle('display','block');
          else
            block.setStyle('display','none');
        });

      // SHOW the category and pages again, when filter is empty
      } else {
        $$('div.block.listPagesBlock li').each(function(page) {
          page.setStyle('display','block');
        });
        $$('div.block.listPagesBlock').each(function(block) {
          block.setStyle('display','block');
        });
      }

      // ->> WHEN filter is started
      // ->> SLIDE all blocks IN
      if(filter.length > 0) {

        // hide subCategory arrows
        $$('.subCategoryArrowLine').setStyle('display','none');

        $('listPagesFilterCancel').setStyle('display','inline');

        $$('div.block.listPagesBlock').each(function(block){
          if(block.hasClass('hidden')) {
            block.removeClass('hidden'); // change the arrow
            block.getElement('div.content').slide('show');
            block.getElement('div.content').setStyle('display','block'); // to allow sorting above the slided in box (reset)
            block.getElement('div.content').get('slide').wrapper.setStyle('height','auto');

          // store the open blocks
          } else if(!storedOpenBlocks) {
            openBlocks.push(block);
          }
        });
        storedOpenBlocks = true;

      // ->> WHEN filter is cleared
      // ->> SLIDE the blocks OUT again, besides the one which was in at the beginning
      } else if(filter === '' && storedOpenBlocks) {

        $('listPagesFilterCancel').setStyle('display','none');

        $$('div.block.listPagesBlock').each(function(block){
          if(!openBlocks.contains(block)) {
            block.addClass('hidden'); // change the arrow
            block.getElement('div.content').slide('hide');
            block.getElement('div.content').setStyle('display','none'); // to allow sorting above the slided in box (reset)
            block.getElement('div.content').get('slide').wrapper.setStyle('height',block.getElement('div.content').getSize().y);
            openBlocks.erase(block);
          }
        });
        // clean the stored blocks array
        if(storedOpenBlocks) {
          openBlocks = [];
          storedOpenBlocks = false;
        }

        cancelListPagesFilter();
      }
    });
  }

  // -------------------------------------------------------------------------------------------
  // LIST PAGES SORTABLE -----------------------------------------------------------------------
  var clicked = false;
  var categoryOld;
  var categoryNew;

  if($('sortablePageList_status') !== null)
    var sortablePageList_status = $('sortablePageList_status').get('value').split("|");

  var preventLink = function (){
      return false;
  };

  var sb = new Sortables('.sortablePageList', {
    /* set options */
    //clone: true,
    revert: true,
    opacity: 1,
    snap: 10,

    /* --> initialization stuff here */
    initialize: function() {

    },
    /* --> once an item is selected */
    onStart: function(el,elClone) {
      // clear all last active pages bars
      $$('.sortablePageList li').each(function(li) {
        li.removeClass('active');
        li.eliminate('selected');
      });
      el.addClass('active');
      el.store('selected',true);

      categoryOld = el.getParent().get('id').substr(8); // gets the category id where the element comes from

    },
    // check if sorted
    onSort: function(el){
      clicked = true;
      $$('.sortablePageList a').each(function(a) { a.addEvent('click',preventLink); }); // prevent clicking the link on sort
    },
    /* --> when a drag is complete */
    onComplete: function(el) {

      subCategoryArrows();

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
        if(li.getParent().get('id') == el.getParent().get('id') && li.get('id') !== null) {
          sort_order = sort_order + li.get('id').substr(4)  + '|'; count_sort++;
        } });
      $('sort_order' + categoryNew).value = sort_order;

      // if pages has changed the category id in the href!
      if(categoryOld != categoryNew) {
        el.getElements('div').each(function(div){
          var newHref,oldHref;

          if(div.hasClass('name')) {
              oldHref = String(div.getElement('a').get('href'));
              newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);
              div.getElement('a').set('href',newHref);
          }

          if(div.hasClass('status')) {
              oldHref = String(div.getElement('a').get('href'));
              newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);
              div.getElement('a').set('href',newHref);
          }

          if(div.hasClass('functions')) {
              div.getElements('a').each(function(a){
                oldHref = String(a.get('href'));
                newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);
                a.set('href',newHref);

                if(a.hasClass('deletePage')) {
                    oldHref = String(a.get('onclick'));
                    newHref = oldHref.replace('category=' + categoryOld,'category=' + categoryNew);
                    a.set('onclick',newHref);
                }
              });
          }
        });
      }

      // --> sortiert die Seite mithilfe einer AJAX anfrage an library/controllers/sortPages.controller.php ------------------------------
      var req = new Request({
        url:'library/controllers/sortPages.controller.php',
        method:'post',
        //autoCancel:true,
        data:'sort_order=' + sort_order + '&categoryOld=' + categoryOld +'&categoryNew=' + categoryNew + '&sortedPageId=' + sortedPageId , // + '&do_submit=1&byajax=1&ajax=' + $('auto_submit').checked
        //-------------------------------------
        onRequest: function() {

          // PUT the save new order - TEXT in the loadingBox AND SHOW the LOADINGBOX
          $('loadingBox').set('html','<span style="color:#D36100;font-weight:bold;font-size:16px;">'+sortablePageList_status[0]+'</span>');
          // set tween
          $('loadingBox').set('tween',{duration: 200});
          $('loadingBox').setStyle('display','block');
          $('loadingBox').setStyle('opacity','1');

        },
        //-------------------------------------
        onSuccess: function(responseText) {

          // FINAL SORT MESSAGE
          feindura_showNotification('<div class="alert alert-success">'+responseText+'</div>');

          // remove prevent clicking the link on sort
          $$('.sortablePageList a').each(function(a) { a.removeEvent('click',preventLink); });

          // remove the "no pages notice" li if there is a page put in this category
          $$('.sortablePageList li').each(function(li) {
            if(li.get('id') === null && li.getParent().get('id').substr(8) == categoryNew && responseText.substr(-1) != '4') {
              li.destroy();
            }
          });

          // adds the "no page - notice" li if the old category is empty
          if(responseText.substr(0,13) == '<span></span>') {
            $$('.sortablePageList').each(function(ul) {
              if(ul.get('id').substr(8) == categoryOld) { // && responseText.substr(-1) != '4'
                var newLi = new Element('li', {html: '<div class="emptyList">' + sortablePageList_status[1] + '</div>'});
                newLi.setStyle('cursor','auto');
                ul.grab(newLi,'top');
              }
            });
          }

          // HIDE the LOADINGBOX
          $('loadingBox').tween('opacity','0');
          $('loadingBox').get('tween').chain(function(){
            $('loadingBox').empty();
            $('loadingBox').setStyle('display','none');
          });

        }
      }).send();

    } // <-- SAVE SORT -- END --------------------
  }
  });

  // makes the "no pages notice" li un-dragable
  $$('.sortablePageList li').each(function(li) {
      if(li.get('id') === null) {
        li.removeEvents();
        li.setStyle('cursor','auto');
      }
  });

  // *** ->> SETUP -----------------------------------------------------------------------------------------------------------------------

  // -> ADD auto grow to textareas which have the "autogrow" class
  $$('textarea.autogrow').each(function(textarea){
    textarea.setStyle('overflow-y','hidden');
    new Form.AutoGrow(textarea);
  });

  // ->> ADMIN-SETUP
  // ---------------

  // -> adds realtime THUMBSCALE to the thumbnail Settings
  setThumbScale('cfg_thumbWidth','thumbWidthScale','cfg_thumbHeight','thumbHeightScale');

  // -> adds THUMBRATIO deactivation
  setThumbRatio('cfg_thumbWidth','ratioX','cfg_thumbHeight','ratioY','noRatio');

  // change enterMode opposite text
  if($('cfg_editorEnterMode') !== null) {
    $('cfg_editorEnterMode').addEvent('change',function() {
      var opposite = $('enterModeOpposite');

      if(opposite !== null) {
        if(opposite.get('html') == '&lt;br&gt;')
          opposite.set('html','&lt;p&gt;');
        else
          opposite.set('html','&lt;br&gt;');
      }
    });
  }

  // -> adds Fields to styleSheetsFilePaths
  $$('.addStyleFilePath').each(function(addButton){
    if(addButton !== null) {
      var containerId = addButton.getParent().getElement('div').getProperty('id');
      var inputName = addButton.getParent().getElement('div').getElement('input').getProperty('name');

      addButton.addEvent('click', function(e) {
        e.stop();
        addInputField(containerId,inputName);
      });
    }
  });

  // -> DISABLE cache timeout
  if($('cfg_cacheTimeout') !== null) {
    $('cfg_cache').addEvent('change',function() {
      // disable
      if(this.checked) {
        $('cacheTimeoutRow').reveal();
      // activate
      } else {
        $('cacheTimeoutRow').dissolve();
      }
    });
  }

  // ->> PAGE SETUP
  // ---------------

  // -> GO TROUGH every CATEGORY and add thumbScale to the advanced category settings
  if($$('.advancedcategoryConfig') !== null) {
    var countCategories = 0;
    // -----------------------------------------
    // ADD SLIDE TO THE ADVANCED CATEGORY SETTINGS
    // go trough every advancedcategoryConfig class and add the slide effect
    $$('.categoryConfig').each(function(categoryConfig) {
      // count categories
      countCategories++;
      // -----------------------------------------
      // adds realtime THUMBSCALE to the advanced category settings
      setThumbScale('categories'+countCategories+'thumbWidth','categories'+countCategories+'thumbWidthScale','categories'+countCategories+'thumbHeight','categories'+countCategories+'thumbHeightScale');
      // adds THUMBRATIO deactivation
      setThumbRatio('categories'+countCategories+'thumbWidth','categories'+countCategories+'ratioX','categories'+countCategories+'thumbHeight','categories'+countCategories+'ratioY','categories'+countCategories+'noRatio');
    });
  }

  // ----------------------------------------------------
  // ADD CodeMirror TO ALL TEXTAREAs with class editFiles
  $$('textarea.editFiles').each(function(textarea){
    // var
    var hlLine;
    var mode;
    if(textarea.hasClass('css') || textarea.hasClass('php'))
      mode = textarea.getProperty('class').replace('editFiles ','');
    else if(textarea.hasClass('js'))
      mode = 'javascript';
    else
      mode = 'htmlmixed';

    var editor = CodeMirror.fromTextArea(textarea, {
      mode: mode,
      lineNumbers: false,
      theme: 'feindura',
      onCursorActivity: function() {
        editor.setLineClass(hlLine, null);
        hlLine = editor.setLineClass(editor.getCursor().line, "CodeMirrorActiveline");
      }
    });

    // make sure, webkit spellchecking is turned off
    $$('div.CodeMirror textarea').setProperty('spellcheck','false');
  });


  // *** ->> FORMS -----------------------------------------------------------------------------------------------------------------------

  // ------------------------------------------------------------
  // ADD FANCY-FORM
  feinduraFancyForm = new FancyForm('input[type="checkbox"], input[type="radio"]');

  // ADD DEPENCIES for CHECKBOXES
  $$('input[type="radio"]').each(function(checkbox) {
    var checkboxId = checkbox.get('id');

    // go trough checkboxes with id
    if(checkboxId) {

      // -> ** categories[0-9]sortByPageDate
      if(checkboxId.match(/^categories[0-9]+sortByPageDate$/)) {
        var categoryNumber = checkboxId.match(/[0-9]+/);
        feinduraFancyForm.setDepency(checkbox,$('categories'+categoryNumber+'showPageDate'));
        feinduraFancyForm.setDepency($('categories'+categoryNumber+'showPageDate'),$('categories'+categoryNumber+'sortByPageDate'),false,false);
      }
    }
  });
  // set depency for page sortingByDate
  feinduraFancyForm.setDepency($('nonCategorySortByPageDate'),$('nonCategoryShowPageDate'));
  feinduraFancyForm.setDepency($('nonCategoryShowPageDate'),$('nonCategorySortByPageDate'),false,false);

  // set depency for page editorHtmlLawed
  feinduraFancyForm.setDepency($('cfg_editorHtmlLawed'),$('cfg_editorSafeHtml'),false,false);


  // *** ->> EDITOR -----------------------------------------------------------------------------------------------------------------------
  if($('HTMLEditor') !== null) {

    // vars
    var editorStartHeight   = window.getSize().y * 0.40;
    var editorToHeight      = (window.getSize().y * 0.60 > 420) ? window.getSize().y * 0.60 : 420;
    var editorHasFocus      = false;
    var editorIsClicked     = false;


    // ------------------------------
    // CONFIG the HTMlEditor
    CKEDITOR.config.skin                               = 'feindura-skin';
    // CKEDITOR.config.width                              = 770;
    CKEDITOR.config.height = ($('documentSaved') !== null && $('documentSaved').hasClass('saved')) ? editorToHeight : editorStartHeight;
    CKEDITOR.config.resize_minWidth                    = 831;
    CKEDITOR.config.resize_maxWidth                    = 831;
    CKEDITOR.config.resize_minHeight                   = (editorStartHeight+136);
    CKEDITOR.config.resize_maxHeight                   = 1000;
    CKEDITOR.config.autoGrow_maxHeight                 = 1000;
    CKEDITOR.config.autoGrow_minHeight                 = (editorStartHeight+136);
    CKEDITOR.config.autoGrow_onStartup                 = false;
    CKEDITOR.config.forcePasteAsPlainText              = false; // was true
    CKEDITOR.config.pasteFromWordNumberedHeadingToList = true;
    CKEDITOR.config.scayt_autoStartup                  = false;
    CKEDITOR.config.colorButton_enableMore             = true;
    CKEDITOR.config.entities                           = false;
    CKEDITOR.config.protectedSource.push( /<\?[\s\S]*?\?>/g ); // protect php code
    //CKEDITOR.config.disableNativeSpellChecker = false;
    CKEDITOR.config.toolbarCanCollapse                 = true;
    if($('documentSaved') === null || !$('documentSaved').hasClass('saved'))
      CKEDITOR.config.toolbarStartupExpanded = false;


    CKEDITOR.config.toolbar = [
      { name: 'document', items : ['Save','-','Maximize','-','Source'] },
      { name: 'tools', items : ['ShowBlocks'] },
      { name: 'clipboard', items : [ 'Undo','Redo','-','Cut','Copy','Paste','PasteText','PasteFromWord'] },
      { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-', 'Scayt' ] }, //'SpellChecker',
      '/',
      { name: 'colors', items : [ 'TextColor','BGColor' ] },
      { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
      { name: 'align', items : [ 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] }, //,'-','BidiLtr','BidiRtl' ] },
      { name: 'paragraph', items : [ 'Outdent','Indent','-','NumberedList','BulletedList','-','Blockquote','CreateDiv'] },
      '/',
      { name: 'styles', items : [ 'Styles','Format','FontSize' ] }, //'Font'
      { name: 'media', items : [ 'Image','Flash','MediaEmbed','Iframe'] },
      { name: 'links', items : [ 'Link','Unlink','Anchor' ] },
      { name: 'insert', items : [ 'Table','HorizontalRule','SpecialChar'] },
      { name: 'feindura', items : [ 'Snippets'] },
      { name: 'tools', items : [ 'About' ] }
    ];

    // -> CREATES the editor instance, with replacing the textarea with the id="HTMLEditor"
    HTMLEditor = CKEDITOR.replace('HTMLEditor');

    // ADD FEINDURA CLASS back to the <html> element, ON MAXIMIZE
    // also FIXES the height of the editor content
    HTMLEditor.on('afterCommandExec',function(e){
      if(e.data.name === 'maximize' && e.data.command.state == CKEDITOR.TRISTATE_ON) {
        $$('html').addClass('feindura');
        $$('html, body').setStyles({
          'position': 'static',
          'width': '100%',
          'overflow':null
        });

        // fix editor size
        $$('.cke_contents').setStyle('height',$$('.cke_contents')[0].getStyle('height').replace('px',''));
        $$('.cke_maximized').setStyle('width',window.getSize().x);

        // also hide some divs
        $$('header.main, footer.main, div.pageHeader, #leftSidebar, #rightSidebar, div.content, a.fastUp').setStyle('display','none');

      } else if(e.data.name === 'maximize' ) {

        // let them reapear again
        $$('header.main, footer.main, div.pageHeader, #leftSidebar, #rightSidebar, div.content, a.fastUp').setStyle('display',null);
      }
    });

    HTMLEditor.on('instanceReady',function() {
      // -> add TOOLTIPS for ckeditor
      $$('.cke_button').each(function(button) {
        if(button !== null) {
          // store tip text
          button.store('tip:text', button.get('title'));
          toolTipsBottom.attach(button);
          button.removeProperty('title');
        }
      });

      // -> setup OUTPUT FORMAT
      HTMLEditor.dataProcessor.writer.setRules( 'p', {
          indent: true,
          breakBeforeOpen: true,
          breakAfterOpen: true,
          breakBeforeClose: true,
          breakAfterClose: true
      });
      HTMLEditor.dataProcessor.writer.setRules( 'div', {
          indent: true,
          breakBeforeOpen: true,
          breakAfterOpen: true,
          breakBeforeClose: true,
          breakAfterClose: true
      });
      HTMLEditor.dataProcessor.writer.setRules( 'table', {
          indent: true,
          breakBeforeOpen: true,
          breakAfterOpen: true,
          breakBeforeClose: true,
          breakAfterClose: true
      });
    });


    // -> adds the EDITOR SLIDE IN/OUT tweens
    if($('documentSaved') !== null && $('documentSaved').hasClass('saved'))
      editorIsClicked = true;


    HTMLEditor.on('instanceReady',function() {
      var windowScroll = new Fx.Scroll(window.document,{duration:'normal'});
      var ckeditorContent = $$('.cke_contents')[0];
      ckeditorContent.set('tween',{duration:400, transition: Fx.Transitions.Pow.easeIn});

      // var editorTweenTimeout;

      $$('div.editor #cke_HTMLEditor').addEvent('click',function(e){
        // clearTimeout(editorTweenTimeout);

        if(!editorHasFocus && ckeditorContent.getHeight() <= (editorStartHeight+20))
          HTMLEditor.resize(798,editorToHeight + 100);

        if(!editorIsClicked && !editorHasFocus) {
          editorHasFocus = true;
          HTMLEditor.execCommand('toolbarCollapse'); //toggles
        }

        // scroll to editor
        if($('editorAnchor') !== 'null')
          windowScroll.toElement($('editorAnchor'));

        editorHasFocus = true;
      });

      HTMLEditor.on('focus',function(e) {
        // clearTimeout(editorTweenTimeout);
        if(editorHasFocus)
          return;

        if(!editorHasFocus && ckeditorContent.getHeight() <= (editorStartHeight+20)) {
          HTMLEditor.resize(798,editorToHeight + 100);
        }

        // show toolbar directly
        if(!editorIsClicked && !editorHasFocus) {
          HTMLEditor.execCommand('toolbarCollapse'); //toggles
        }

        // scroll to editor
        if($('editorAnchor') !== 'null')
          windowScroll.toElement($('editorAnchor'));

        editorHasFocus = true;
      });
    });
  }
  // ->> make PAGE TITLE EDITABLE

  // -> SAVE TITLE
  function saveTitle(title,type) {
    if(titleContent != title.get('html')) {

      // var
      var jsLoadingCircle = new Element('div',{'class': 'smallLoadingCircle'});
      var removeLoadingCircle = function(){};

      // url encodes the string
      title.getChildren('#rteMozFix').destroy();
      var content = encodeURIComponent(title.get('html')).replace( /\%20/g, '+' ).replace( /!/g, '%21' ).replace( /'/g, '%27' ).replace( /\(/g, '%28' ).replace( /\)/g, '%29' ).replace( /\*/g, '%2A' ).replace( /\~/g, '%7E' );
      //request(title,,,{title: feindura_langFile.ERRORWINDOW_TITLE,text: feindura_langFile.ERROR_SAVE},'post',true);

      // save the title
      new Request.HTML({
        url: feindura_basePath + 'library/controllers/frontendEditing.controller.php',
        method: 'post',
        data: 'save=true&type='+type+'&language='+title.retrieve('language')+'&category='+title.retrieve('category')+'&page='+title.retrieve('page')+'&data='+content,

        onRequest: function() {

          // -> ADD the LOADING CIRCLE
          if(!title.contains(jsLoadingCircle))
            title.grab(jsLoadingCircle,'top');
          removeLoadingCircle = feindura_loadingCircle(jsLoadingCircle, 8, 15, 12, 2, "#000");
        },
        onSuccess: function(responseTree, responseElements, responseHTML) {

        // -> fade out the loadingCircle
        jsLoadingCircle.set('tween',{duration: 200});
        jsLoadingCircle.fade('out');
        jsLoadingCircle.get('tween').chain(function(){
        // -> REMOVE the LOADING CIRCLE
        removeLoadingCircle();
        jsLoadingCircle.dispose();

        if(responseHTML.contains('####SAVING-ERROR####'))
          document.body.grab(feindura_showError(feindura_langFile.ERRORWINDOW_TITLE,feindura_langFile.ERROR_SAVE),'top');
        else {
          // -> UPDATE the TITLE everywhere
          title.set('html', responseHTML+"<p id='rteMozFix' style='display:none'><br></p>");
          var activeLink = $$('#rightSidebar menu.vertical.nonCategory a.active, #rightSidebar menu.vertical.category a.active');
          var star = activeLink.getElement('span');
          activeLink.set('html',responseHTML);
          // update input, with the value from the activeLink
          $('edit_title').setProperty('value',activeLink.get('text'));
          activeLink.grab(star[0],'bottom');
          titleContent = $('editablePageTitle').get('html');
          // display document saved
          showDocumentSaved();
        }
          });
        },
        //-----------------------------------------------------------------------------
        //Our request will most likely succeed, but just in case, we'll add an
        //onFailure method which will let the user know what happened.
        onFailure: function() { //-----------------------------------------------------

          // -> fade out the loadingCircle
          if(!title.contains(jsLoadingCircle))
            title.grab(jsLoadingCircle,'top');
            jsLoadingCircle.set('tween',{duration: 200});
            jsLoadingCircle.fade('out');
            jsLoadingCircle.get('tween').chain(function(){
            // -> REMOVE the LOADING CIRCLE
            removeLoadingCircle();
            jsLoadingCircle.dispose();
            // add errorWindow
            feindura_showError(feindura_langFile.ERRORWINDOW_TITLE,feindura_langFile.ERROR_SAVE);
          });

        }
      }).send();

      titleSaved = true;
    }
  }

  if($('editablePageTitle') !== null) {

    // vars
    var titleSaved = false;
    var titleContent = '';

    $('editablePageTitle').moorte({location:'none'});

    // ->> GO TROUGH ALL EDITABLE BLOCK

    // STORE page IDS in the elements storage
    feindura_setPageIds($('editablePageTitle'));

    // save on enter
    $('editablePageTitle').addEvent('keydown', function(e) {
      if(e.key == 'enter' && (typeOf(MooRTE.Elements.linkPop) == 'null' || (MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false))) {
          e.stop();
          saveTitle(this,'title');
      }
    });
    // save on blur
    $('editablePageTitle').addEvent('blur', function(e) {
      if((typeOf(MooRTE.Elements.linkPop) == 'null' || (MooRTE.Elements.linkPop && MooRTE.Elements.linkPop.visible === false))) {
          saveTitle(this,'title');
      }
    });
    // on focus
    $('editablePageTitle').addEvent('focus', function() {
      titleContent = $('editablePageTitle').get('html');
      if(titleSaved)
        titleSaved = false;
    });
  }

  // CHANGE CATEGORY
  if($('categorySelection') !== null) {
    $('categorySelection').addEvent('change',function() {
      window.location.href = '?category=' + this[this.selectedIndex].value + '&page=new';
    });
  }

  // CHANGE TEMPLATE
  if($('templateSelection') !== null) {
    $('templateSelection').addEvent('change',function() {
      newLocation = (window.location.href.indexOf('&template') != -1) ? window.location.href.substr(0,window.location.href.indexOf('&template')) : window.location.href;
      if(this[this.selectedIndex].value == '-')
        window.location.href = newLocation;
      else
        window.location.href = newLocation + '&template=' + this[this.selectedIndex].value;
    });
  }

  // -----------------------------------------
  // LEAVING WITHOUT SAVING CHECKS
  // ->> CHECKS if changes in the editor page was made and add a *

  // CHECK if fields are changed
  $$('#editorForm input, #editorForm textarea').each(function(formfields){
    formfields.addEvent('change',function() {
      pageContentChangedSign();
    });
  });
  // CHECK if the HTMLeditor content was changed
  if($('HTMLEditor') !== null) {
    HTMLEditor.on('blur',function() {
      if(HTMLEditor.checkDirty()) {
        pageContentChangedSign();
        // adds the editorAnchor to the form
        onSubmitSetAnchor('editorForm','editorAnchor');
      }
    });
    // on typing
    HTMLEditor.on("instanceReady", function() {
        this.document.on("keyup", function(){
          pageContentChangedSign();
          // adds the editorAnchor to the form
          onSubmitSetAnchor('editorForm','editorAnchor');
        });
        this.document.on("paste", function(){
          pageContentChangedSign();
          // adds the editorAnchor to the form
          onSubmitSetAnchor('editorForm','editorAnchor');
        });
      }
    );
    // on mode changeing
    HTMLEditor.on('mode', function(e) {
      if(e.editor.mode === 'source' && HTMLEditor.checkDirty()) {
        pageContentChangedSign();
        // adds the editorAnchor to the form
        onSubmitSetAnchor('editorForm','editorAnchor');
      }
      }
    );
    LeavingWithoutSavingWarning();
  }
});
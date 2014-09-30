window.addEvent('domready', function() {
  
  /* adds SMOOTHSCROLL to anchors */

  var smoothAnchorScroll = new Fx.SmoothScroll({
    //links: alink,
    wheelStops: true,
    duration: 400,
    transition: Fx.Transitions.Pow.easeInOut
  });


  // add CONTEXTUAL SEARCH

  if(!navigator.appVersion.match(/MSIE ([0-6]\.\d)/))
    new contextualSearch({targetID: 'searchBox'});
  
  // add search input overtext
  new OverText('search-input',{ //searchfield
    positionOptions: {
      offset: {x: 4,y: 2}
    }
  });
  
  
  // SIDEBARS

  var blendOut = '-180px';
  var minWindowSize = 1520;
  var delayForHide = 1500;
  
  /* slideOut function*/
  var slideOut = function(direction){ this.tween(direction,blendOut);};

  
  /* select every link, and change the adress url in the window.href wehn clicked */
  
  /* SIDEBAR LEFT */
  $$('div.sidebarMenu.left').each(function(sideBarMenu){
    
    /* set tween */
    sideBarMenu.set('tween',{duration: '400', transition: Fx.Transitions.Pow.easeOut});
    
    // set the height of the sidebar conatiner
    // sideBarMenu.setStyle('height',(window.getSize().y - 40)); // -40px padding
    // sideBarMenu.setStyle('overflow','hidden');
    
    // add DIV SCROLLER
    // var leftScroller = new Scroller(sideBarMenu, {area: (window.getSize().y / 2.5), velocity: 0.1});
    // leftScroller.start();
    
    /* slide out on startup */
    if(window.getSize().x <= minWindowSize)
      slideOut.delay(delayForHide,sideBarMenu,'left');

    
    sideBarMenu.addEvent('mouseover',function(){
      if(window.getSize().x <= minWindowSize)
        sideBarMenu.tween('left','0px');
      
    });
    sideBarMenu.addEvent('mouseout',function(){
      if(window.getSize().x <= minWindowSize)
       sideBarMenu.tween('left',blendOut);
      else
       sideBarMenu.tween('left','0px');
    });
  });
  
  /* SIDEBAR RIGHT */
  $$('div.sidebarMenu.right').each(function(sideBarMenu){
    
    /* set tween */
    sideBarMenu.set('tween',{duration: '400', transition: Fx.Transitions.Pow.easeOut});
    
    // set the height of the sidebar conatiner
    // sideBarMenu.setStyle('height',(window.getSize().y - 40)); // -40px padding
    // sideBarMenu.setStyle('overflow','hidden');
    
    // add DIV SCROLLER
    // var rightScroller = new Scroller(sideBarMenu, {area: (window.getSize().y / 2.5), velocity: 0.1});
    // rightScroller.start();
    
    /* slide out on startup */
    if(window.getSize().x <= minWindowSize)
      slideOut.delay(delayForHide,sideBarMenu,'right');
    
    sideBarMenu.addEvent('mouseover',function(){
      if(window.getSize().x <= minWindowSize)
        sideBarMenu.tween('right','0px');
        
      // reset the height of the sidebar conatiner
      // sideBarMenu.setStyle('height',(window.getSize().y - 40));
      // rightScroller.setOptions({area: window.getSize().y / 2.5});
          
    });
    sideBarMenu.addEvent('mouseout',function(){
      if(window.getSize().x <= minWindowSize)
       sideBarMenu.tween('right',blendOut);
      else
       sideBarMenu.tween('right','0px');
      
      // reset the height of the sidebar conatiner
      // sideBarMenu.setStyle('height',(window.getSize().y - 40));
      // rightScroller.setOptions({area: window.getSize().y / 2.5});
    });
  });

});
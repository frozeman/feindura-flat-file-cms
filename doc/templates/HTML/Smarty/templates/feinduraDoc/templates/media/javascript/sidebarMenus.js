window.addEvent('domready', function() {
  
  var blendOut = '-180px';
  var minWindowSize = 1420;
  
  /* select every link, and change the adress url in the window.href wehn clicked */
  
  /* SIDEBAR LEFT */
  $$('div.sidebarMenu.left').each(function(sideBarMenu){
    
    if(window.getSize().x <= minWindowSize)
     sideBarMenu.setStyle('left',blendOut);
    
    sideBarMenu.set('tween',{duration: '400', transition: Fx.Transitions.Pow.easeOut});
    
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
    
    if(window.getSize().x <= minWindowSize)
     sideBarMenu.setStyle('right',blendOut);
    
    sideBarMenu.set('tween',{duration: '400', transition: Fx.Transitions.Pow.easeOut});
    
    sideBarMenu.addEvent('mouseover',function(){
      if(window.getSize().x <= minWindowSize)
        sideBarMenu.tween('right','0px');
      
    });
    sideBarMenu.addEvent('mouseout',function(){
      if(window.getSize().x <= minWindowSize)
       sideBarMenu.tween('right',blendOut);
      else
       sideBarMenu.tween('right','0px');      
    });
  });
});
window.addEvent('domready', function() {
  
  var blendOut = '-120px';
  
  /* select every link, and change the adress url in the window.href wehn clicked */  
  $$('div.sidebarMenu.left').each(function(sideBarMenu){
    
    sideBarMenu.setStyle('left',blendOut);
    
    sideBarMenu.set('tween',{duration: '400', transition: Fx.Transitions.Pow.easeOut});
    
    sideBarMenu.addEvent('mouseover',function(){
      sideBarMenu.tween('left','0px');
      
    });
    sideBarMenu.addEvent('mouseout',function(){
      sideBarMenu.tween('left',blendOut);
      
    });

  });

});
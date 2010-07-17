window.addEvent('domready', function() {
  
  /* adds smoothscroll to anchors */      
  var smoothAnchorScroll = new Fx.SmoothScroll({
    //links: alink,
    wheelStops: true,
    duration: 400,
    transition: Fx.Transitions.Pow.easeInOut
  });      

});
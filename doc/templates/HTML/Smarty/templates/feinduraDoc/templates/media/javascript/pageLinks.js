window.addEvent('domready', function() {
  
  /* select every link, and if its an anchor it adds smoothscroll */  
  $$('a').each(function(alink){    
    if(alink.getProperty('href') == null)
      return;    
    var linkHref = alink.getProperty('href').toString();    
    if(linkHref.substring(0,4) != 'http' &&
       linkHref.substring(0,1) == '#') {      
      var smoothAnchorScroll = new Fx.SmoothScroll({
        links: alink,
        wheelStops: true,
        duration: 400,
        transition: Fx.Transitions.Pow.easeInOut
      });      
    } else return;
  });
});
window.addEvent('domready', function() {
  /* select every link, and change the adress url in the window.href wehn clicked */
  
  $$('a').each(function(alink){ 
    
    if(alink.getProperty('href') == null)
      return;
    
    var linkHref = alink.getProperty('href').toString();
    
    if(linkHref.substring(0,12) != 'elementindex' &&
       linkHref.substring(0,10) != 'classtrees' &&
       linkHref.substring(0,1) != '#' &&
       linkHref.substring(0,4) != 'http') {
      
      alink.addEvent('click',function(e){
          e.stop();
          top.window.location.search = linkHref;
      
      });
      
    } else
      return;

  });

});
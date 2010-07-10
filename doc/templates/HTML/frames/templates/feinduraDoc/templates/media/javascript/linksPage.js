window.addEvent('domready', function() {
  var smoothAnchorScroll = new Fx.SmoothScroll({
    links: '.smoothAnchor',
    wheelStops: true,
    duration: 400,
    transition: Fx.Transitions.Pow.easeInOut
  });

});
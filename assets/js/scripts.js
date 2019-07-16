(function($) {
  $(document).ready(function(e) {
    $.when( $('.product-slider').bxSlider({
      captions: true,
      keyboardEnabled: true,
      nextText: '<i class="fa fa-2x fa-chevron-right"></i>',
      prevText: '<i class="fa fa-2x fa-chevron-left"></i>'
    }) ).then(function() {
      $('.product-slider').removeClass('hidden');
    });
  });
})( jQuery );

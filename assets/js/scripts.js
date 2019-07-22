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

    $('.tour-trigger').on('click touchstart', function(e) {
      e.preventDefault();
      var clicked = $(this);
      var targetId = clicked.attr('data-target');
      var target = $('#' + targetId);

      if (clicked.hasClass('active')) {
        return false;
      }

      clicked.siblings().removeClass('active');
      clicked.addClass('active');

      target.removeClass('toggle');
      target.siblings().addClass('toggle');
    });
  });
})( jQuery );

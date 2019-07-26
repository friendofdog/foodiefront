(function($) {
  $(document).ready(function(e) {
    const scrollToTopButton = document.getElementById('js-top');
    const scrollFunc = () => {
      let y = window.scrollY;

      if (y > 500) {
        scrollToTopButton.className = "top-link";
      } else {
        scrollToTopButton.className = "top-link hidden";
      }
    };

    window.addEventListener("scroll", scrollFunc);

    const scrollToTop = () => {
      const c = document.documentElement.scrollTop || document.body.scrollTop;

      if (c > 0) {
        window.requestAnimationFrame(scrollToTop);
        window.scrollTo(0, c - c / 10);
      }
    };

    scrollToTopButton.onclick = function(e) {
      e.preventDefault();
      scrollToTop();
    }
  });
})( jQuery );

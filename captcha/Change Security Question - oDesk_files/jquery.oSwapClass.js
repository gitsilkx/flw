(function($) {
     $.fn.oSwapClass = function(class1, class2) {
        if(this.attr('class') == class1) {
          this.attr('class', class2);
        } else if(this.attr('class') == class2) {
          this.attr('class', class1);
        }
     };

})(jQuery);


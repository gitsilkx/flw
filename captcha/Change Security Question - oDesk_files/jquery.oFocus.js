(function($) {
  $.fn.oFocus = function(defaultValue) {
    return this.each(function(){
      var $this = $(this);
      
      if ($this.val() == defaultValue) {
        $this.focus();
      }
    });
  };
})(jQuery);

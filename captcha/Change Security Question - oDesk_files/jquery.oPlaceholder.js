(function($) {
    
    function oPlaceholder() {
        this.init.apply(this, arguments);
    }
    
    oPlaceholder.prototype = {
        
        init: function(element) {
            this.$element = $(element);
            var placeholder = this.$element.attr('placeholder');
            if(this.$element.val() != placeholder) {
                this.$element.removeClass('placeholder');
                if(document.activeElement == element) this.$element.addClass('focused');
            }
            if(!placeholder) return;
            this.events();
            
        },
        
        events: function() {
            this.$element.bind('focus', $.proxy(this.focus, this)).bind('blur', $.proxy(this.blur, this));
        },
        
        focus: function() {
            if(this.$element.hasClass('placeholder')) {
                this.$element.val('').removeClass('placeholder').addClass('focused');
            }
        },
        
        blur: function() {
            if(this.$element.val()) return;
            this.$element.val(this.$element.attr('placeholder')).addClass('placeholder').removeClass('focused');
        }
         
    };
    
    $.fn.oPlaceholder = function() {
        for(var i = 0, l = this.length; i < l; i++) {
            new oPlaceholder(this[i]);
        }
        return this;
    };
    
})(jQuery);

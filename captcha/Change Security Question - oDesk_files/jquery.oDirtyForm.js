(function($) {

function oDirtyForm() {
    this.initialize.apply(this, arguments);
    return this;
}

oDirtyForm.prototype = {

    initialize: function(element, cancel) {
        this.element = $(element);
        this.cancel = $(cancel);
        this.element.find('input[type="text"], textarea').each(function() {
            $(this).data('default-value', this.value);
        });
        this.events();
    },

    isDirty: function() {
        var dirty = false;
        this.element.find('input[type="text"], textarea').each(function() {
            if(this.value && this.value != $(this).data('default-value')) {
                dirty = true;
                return false;
            }
        });
        return dirty;
    },

    events: function() {
        $(window).bind('beforeunload.dirty', $.proxy(this.onBeforeUnload, this));
        var self = this;
        function leave() {
            self.canLeave = true;
            setTimeout(function() {
                self.canLeave = false;
            }, 300);
        }
        this.element.bind('submit', function() {
            leave();
        });
        this.cancel.bind('click', function() {
            leave();
        });
    },

    onBeforeUnload: function(event) {
        if(this.unloaded || this.canLeave || !this.isDirty()) return;
        var self = this;
        setTimeout(function() {
            self.unloaded = false;
        }, 100);
        this.unloaded = true;
        return 'You are about to lose your unsaved changes. Are you sure you want to leave this page?';
    }

};


$.fn.oDirtyForm = function(cancel) {
    new oDirtyForm(this, cancel);
    return this;
};


})(jQuery);

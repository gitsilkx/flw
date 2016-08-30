(function($) {
  
if(!window.odesk) odesk = {};

odesk.SimpleCompanySelector = function() {
    this.init.apply(this, arguments);
};

odesk.SimpleCompanySelector.prototype = {
    
    options: {
        cookie: {
            name: 'company_last_accessed'
        },
        preOnChange: function() {},
        onChange: function() {
            document.location = this.changeHref(this.selected.ref);
        }
    },
    
    init: function(element, options) {
        this.$element = $(element);
        this.options = $.extend(true, {}, this.options, options);
        
        this.$items = this.$element.find('.items');
        this.$display = this.$element.find('.display');
        this.$items.show();
        this.$items.hide();
        this.addEvents();
    },
    
    addEvents: function() {
        this.bound = {};
        var self = this;
        for(var p in {'onOpen': 1, 'onSelect': 1, 'onOuterMousedown': 1, 'onClick': 1}) {
            (function(p) {
                self.bound[p] = function() {
                    self[p].apply(self, arguments);
                };
            })(p);
        }
        if(this.$items.length) this.$element.find('.display').bind('mousedown', this.bound.onOpen).bind('click', this.bound.onClick);
        this.$element.find('.item').bind('click', this.bound.onSelect);
    },
    
    onOpen: function(event) {
        this.mousedown = false;
        if(this.opened || event.which != 1) return;
        this.mousedown = true;
        this.open();
    },
    
    onClick: function() {
        if(!this.mousedown) this.close();
    },
    
    onOuterMousedown: function(event) {
        var $target = $(event.target);
        if($target.closest('.simple-company-selector').length) return;
        this.close();
    },
    
    onSelect: function(event) {
        this.select($(event.target));
        this.close();
    },
    
    onChange: function() {
        this.options.preOnChange.apply(this);
        $.cookie(this.options.cookie.prefix + this.options.cookie.name, this.selected.ref, {expires: 3600, path: '/', domain: this.options.cookie.domain});
        this.options.onChange.apply(this);
    },
    
    changeHref: function(newRef) {
        return '/home/index/' + newRef;
    },
    
    select: function($item) {
        this.selected = {
            ref: $item.attr('data-reference'),
            name: $item.html()
        };
        this.$display.attr('data-reference', this.selected.ref).find('span').html(this.selected.name);
        this.onChange();
    },
    
    open: function() {
        this.opened = true;
        $(document).bind('mousedown', this.bound.onOuterMousedown);
        this.$display.addClass('open');
        this.$items.hide();
        if(!$.browser.msie) {
            this.$items.animate({opacity: 'show'}, 350);
        } else {
            this.$items.show();
        }
    },
    
    close: function() {
        this.opened = false;
        this.$display.removeClass('open');
        $(document).unbind('mousedown', this.bound.onOuterMousedown);
        if(!$.browser.msie) {
            this.$items.animate({opacity: 'hide'}, 200);
        } else {
            this.$items.hide();
        }
    }
    
};

})(jQuery);

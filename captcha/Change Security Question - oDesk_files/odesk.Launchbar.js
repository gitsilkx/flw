(function($) {
    
odesk.Launchbar = function() {
    this.init.apply(this, arguments);
    return this;
};

odesk.Launchbar.prototype = {
    
    options: {
        delay: 180000,
        cookie: {
            options: {
                expires: 180000/86400000,
                path: '/'
            }
        },
        url: '/api/mc/v1/trays.json',
        onRemove: function(id) {
            
        }
    },
    
    init: function(element, options) {
        this.$element = $(element);
        this.options = $.extend(true, {}, this.options, options);

        if(!$('.navigation.v2').length) return;
        $('.navigation.v2').prependTo(document.body);

        var cookie = $.cookie(this.options.cookie.name);
        if(cookie) {
            var data = this.encodeCookie(cookie);
            this.update(data);
        } else if(!(/\/mc\//).test(location.pathname)) {
            this.loadTraysCount();
        }
        var self = this;
        this.timer = setInterval(function() {
            self.loadTraysCount();
        }, this.options.delay);
        this.trayLoading = {};
        this.initMenus();
        this.initRemoveNotifications();
        this.initInputPlaceholder();
        this.initSearch();
        this._fixIE();
    },
    
    /**
        loads data from api and runs update
    */
    loadTraysCount: function() {
        var self = this;
        $.ajax({
            dataType: 'json',
            url: this.options.url,
            success: function(json) {
                var data = self._getTraysData(json.trays);
                self.update(data).saveCookie();
            },
            error: function() {

            }
        });
    },
    
    _getTraysData: function(trays) {
        var data = {};
        for(var i = 0, l = trays.length; i < l; i++) {
            data[trays[i].type] = parseInt(trays[i].unread, 10);
        }
        return data;
    },

    encodeCookie: function(cookie) {
        var splited = cookie.split(',');
        var data = {};
        for(var i = 0, l = splited.length; i < l; i++) {
            var bit = splited[i];
            if(!bit) continue;
            data[bit.split('=')[0]] = parseInt(bit.split('=')[1], 10);
        }
        return data;
    },

    decodeCookie: function(data) {
        var decoded = '';
        for(var p in data) {
            decoded += p + '=' + data[p] + ',';
        }
        return decoded;
    },

    saveCookie: function() {
        $.cookie(this.options.cookie.name, this.decodeCookie(this.data), this.options.cookie.options);
        return this;
    },
    
    clearCookie: function() {
        $.cookie(this.options.cookie.name, '', this.options.cookie.options);
        return this;
    },
    
    update: function(data) {
        this.data = data;
        data.notifications = data.notifications || 0;
        data.inbox = data.inbox || 0;
        data.tickets = data.tickets || 0;
        this.$element.find('span.notifications-count, span.inbox-count').remove();
        if(data.notifications) {
            $('<span class="notifications-count">' + data.notifications + '</span>').insertAfter(this.$element.find('span.notifications'));
        }
        if(data.inbox + data.tickets) {
            $('<span class="inbox-count">' + (data.inbox + data.tickets) + '</span>').insertAfter(this.$element.find('span.inbox'));
        }
        for(var tray in {'inbox': 1, 'notifications': 1, 'tickets': 1}) {
            var $menu = this.$element.find('span.' + (tray == 'tickets' ? 'inbox' : tray) + ' .menu');
            $menu.find('.unread-' + tray + ' .count-unread').html(data[tray]);
            if(data[tray]) {
                $menu.find('.unread-' + tray).show();
                $menu.find('.see-' + tray + ' .see-unread').show();
            } else {
                $menu.find('.unread-' + tray).hide();
                $menu.find('.see-' + tray + ' .see-unread').hide();
            }
            $menu.find('.many')[data[tray] > 1 ? 'show' : 'hide']();
        }
        return this;
    },
    
    showMenu: function($menu) {
        $menu.prev().addClass('open');
        if(!$.browser.msie) {
            $menu.animate({opacity: 'show'}, 350);
        } else {
            $menu.show().css('visibility', 'visible');
        }
    },
    
    hideMenu: function($menu) {
        $menu.prev().removeClass('open');
        if(!$.browser.msie) {
            $menu.animate({opacity: 'hide'}, 200);
        } else {
            $menu.hide().css('visibility', 'hidden');
        }
    },
    
    initMenus: function() {
        var self = this;
        var menus = ['username', 'inbox', 'notifications', 'help', 'settings', 'more'];
        for(var i = 0, l = menus.length; i < l; i++) {
            var item = menus[i];
            (function(item) {
                self.$element.find('a.' + item).bind('click dragstart', function(event) {
                    event.preventDefault();
                });
                self.$element.find('a.' + item).bind('click', function() {
                    var $menu = $(this).parent().find('.menu');
                    if($menu.prev().hasClass('open')) {
                        self.hideMenu($menu);
                        return;
                    }
                    self.showMenu($menu);
                    if($menu.find('.loader').length) {
                        self.loadTray(item);
                    }
                    function mousedown(event) {
                        if($(event.target).closest('.menu')[0] == $menu[0] || $(event.target).closest('span.' + item).find('> .menu')[0] == $menu[0]) return;
                        self.hideMenu($menu);
                        $(document).unbind('mousedown', mousedown);
                    }
                    $(document).bind('mousedown', mousedown);
                });
            })(item);
        }
        this.$element.bind('click', function(event) {
            if(!$(event.target).closest('.inbox-count').length) return;
            self.$element.find('a.inbox').click();
        })
        .bind('click', function(event) {
            if(!$(event.target).closest('.notifications-count').length) return;
            self.$element.find('a.notifications').click();
        })
        .bind('click', function(event) {
            var $message = $(event.target).closest('a.message');
            if(!$message.length || !$message.hasClass('unread') || !$message.closest('.inbox').length) return;
            self.clearCookie();
            self.hideMenu($message.closest('.menu'));
        });
    },
    
    initRemoveNotifications: function() {
        var self = this;
        self.removed = {};
        this.$element.bind('click', function(event) {
            var $remove = $(event.target).closest('span.notifications .menu .remove');
            if(!$remove.length) return;
            event.preventDefault();
            var $message = $remove.closest('.message');
            var id = $message.attr('data-id');
            self.remove(id);
        });
    },
    
    remove: function(id, onlyHtml) {
        if(this.removed[id]) return;
        this.removed[id] = true;
        var $message = this.$element.find('.notifications .message[data-id="' + id + '"]');
        var $messages = $message.closest('.messages');
        if(!$message.hasClass('hidden')) {
            $messages.find('.message.hidden:eq(0)').removeClass('hidden').hide().slideDown(400);
        }
        $message.slideUp(400, function() {
            $message.remove();
        });
        if(onlyHtml) return;
        $.ajax({
            dataType: 'json',
            url: '/api/mc/v1/threads/' + this.options.uid + '/' + id + '.json',
            data: {
                deleted: true,
                http_method: 'put'
            },
            type: 'post'
        });
        this.options.onRemove.call(this, id);
    },
    
    loadTray: function(tray) {
        if(this.trayLoading[tray]) return;
        this.trayLoading[tray] = true;
        var self = this;
        $.ajax({
            dataType: 'json',
            url: '/api/mc/v2/trays/' + this.options.uid + '/' + tray + '.json?page=0%3B' + (tray == 'inbox' ? 5 : 20),
            success: function(json) {
                self.trayLoading[tray] = false;
                self.renderTray(tray, json);
                var data = self._getTraysData(json.trays);
                if(data.inbox != self.data.inbox || data.tickets != self.data.tickets || (data.notifications != self.data.notifications && tray == 'inbox')) {
                    var $messages;
                    if(data.notifications != self.data.notifications) {
                        $messages = self.$element.find('.notifications .messages');
                    } else if(tray != 'inbox') {
                        $messages = self.$element.find('.inbox .messages');
                    }
                    if($messages && !$messages.find('.loader').length) $messages.prepend('<div class="loader"><img src="/images/winbox_throbber.gif"></div>');
                    self.saveCookie().update(data);
                }
                if(tray == 'notifications') {
                    self.data.notifications = 0;
                    self.saveCookie();
                }
            },
            error: function() {
                self.trayLoading[tray] = false;
            }
        });
    },
    
    renderTray: function(tray, json) {
        var html = [];
        var $menu = this.$element.find('span.' + tray + ' .menu');
        var $messages = $menu.find('.messages');
        var threads = json.current_tray ? json.current_tray.threads : null;
        if(!threads) thread = [];
        if(!$.isArray(threads)) threads = [threads];
        if(threads.length) {
            for(var i = 0, l = threads.length; i < l; i++) {
                var thread = threads[i];
                var subject = tray == 'inbox' ? thread.last_post_preview : thread.subject;
                var time = parseInt(thread.last_post_ts, 10) + parseInt(json.auth_user.timezone_offset, 10);
                if(odesk.date) {
                    time = odesk.date.format(new Date(time*1000), '%L');
                } else {
                    window.server_time = json.server_time*1000;
                    time = new Date(time*1000).format('%L');
                }
                var link = null, matched;
                if(tray == 'inbox') {
                    var context = thread.context;
                    matched = context && context.match(/^Interviews:(\d+):(\d+)$/);
                    if(matched) {
                        link = '/applications/' + matched[2];
                    } else {
                        link = '/mc/#inbox/thread/' + thread.id;
                    }
                    var senders = [];
                    for(var j = 0, m = thread.participants.length; j < m; j++) {
                        var participant = thread.participants[j];
                        if(!participant.last_post_id) continue;
                        var name = participant.username == this.options.uid ? 'me' : (participant.last_name ? participant.first_name + ' ' + participant.last_name : participant.first_name);
                        senders[thread.sender == participant.username ? 'unshift' : 'push'](name);
                    }
                } else {
                    if(!subject) continue;
                    matched = subject.match(/href="(.*?)"/);
                    var gMatched = subject.match(/href="(.*?)"/g);
                    if(gMatched && gMatched.length == 1) {
                        link = matched[1];
                        subject = subject.replace(/<a.*?>(.*?)<\/a>/, '$1');
                    }
                }
                html.push(
                    '<' + (link ? ('a href="' + link + '"') : 'span') + ' data-id="' + thread.id + '" class="message ' + (thread.read != '1' ? 'unread' : '') + (i >= 5 ? ' hidden' : '') + '">' +
                        (tray == 'inbox' ? ('<span class="sender">' + senders.join(', ') + '</span>') : '<span class="remove"></span>') +
                        '<span class="subject">' + subject + '</span>' +
                        (tray == 'inbox' ? '<span class="time">' + time + '</span>' : '') +
                    '</' + (link ? 'a' : 'span') + '>'
                );
            }
        }
        $messages.html(html.join(''));
        if(tray == 'notifications') {
            this.$element.find('span.notifications-count').remove();
            $menu.find('.message a').addClass('gaet-tracking')
            .attr('gaet-category', 'db_notification')
            .attr('gaet-action', 'click');
        }
    },
    
    initInputPlaceholder: function() {
        this.$element.find('input[placeholder]').oPlaceholder();
    },
    
    getSearchAction: function() {
        var $form = this.$element.find('.level_2 form');
        var $selected = $form.find('option:selected');
        
        if ($form.find('input[type="text"]').val() == 'Find Jobs' || $form.find('input[type="text"]').val() == 'Find Contractors') {
            $form.find('input[type="text"]').val('');
        }
        
        var params = {
            'nbs': 1,
            'g': '',
            'q': $form.find('input[type="text"]').val()
        };
        
        return ($selected.val() == 'Find Jobs' ? '/jobs/?' : '/users/?') + $.param(params);
    },
    
    initSearch: function() {
        var self = this;
        this.$element.find('.level_2 form').bind('submit', function() {
            document.location.href = self.getSearchAction();
            return false;
        });
        this.$element.find('.level_2 select').bind('change', function() {
            var $input = self.$element.find('.level_2 input[type="text"]').attr('placeholder', $(this).val());
            if($input.hasClass('placeholder')) $input.val($(this).val());
        }).change();
    },
    
    _fixIE: function() {
        if(!($.browser.msie && $.browser.version < 9)) return;
        $('.navigation.v2 .main > div').css('z-index', 2);
        $('.navigation.v2 .level_2 .bg').css('border-top', 'solid 1px #F4F5F7');
        if($.browser.version == 7) $('.navigation.v2 .level_1 li').css('top', -1);
        $('.navigation.v2 .level_2 a').each(function() {
            $(this).append('<span style="position: absolute; z-index: -1; top: 1px; left: 0; color: #fff">' + $(this).html() + '</span>').css('position', 'relative');
        });
    }
    
};

})(jQuery);

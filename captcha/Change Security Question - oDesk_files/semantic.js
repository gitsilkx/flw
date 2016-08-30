// vim:set ts=2 sw=2 et ff=unix fdm=marker:

$(document).ready(function(){
  $(".section.toggler h2").append("<a href='#' class='boxlink small'>hide</a>");
  $(".box.toggler h2").append("<a href='#' class='boxlink small'>basic</a>");
  $(".dismissable h2:not(.noclose)").append("<a href='#' class='boxlink small'>[close]</a>");

  $('.dismissable h2:not(.noclose)').click(function(){
    $(this).parent('.dismissable').hide("fast");
    return false; // preventing scroll jump
  });

  $('.toggler h2').addClass('icon expanded');
  $('.section.toggler h2').toggle(function(){
    $('.content', $(this).parent()).hide('fast');
    $(this).removeClass('expanded').addClass('collapsed');
    $('a', $(this)).text('show');
  }, function(){
    $('.content', $(this).parent()).show('fast');
    $(this).removeClass('collapsed').addClass('expanded');
    $('a', $(this)).text('hide');
  });

  if ($.browser.msie) {
    $('.section h2').hover(function(){
      $(this).addClass('hover_section_h2');
    },function(){
      $(this).removeClass('hover_section_h2');
    });
  }

  $.extend($.fn.Tooltip.defaults, {
    delay:    0,
    track:    true,
    showURL:  false,
    showBody: false
  });

  $('.tooltip', $(this)).Tooltip();


  // Forms {{{
  $('.button').hover(function(){
    if ($(this).is(':not(.disabled)')) {
      $(this).addClass('hover');
    }
  },function(){
    $(this).removeClass('hover');
  });

  $('.button.submit').click(function(){
    if ($(this).is(':not(.disabled)')) {
      if ("" != $(this).attr('alt')) {
          var f = $("form#"+$(this).attr('alt'));
          $('.section.error:visible', $(f)).hide('fast');
          $('.section.error ul', $(f)).empty();
      }
      return true;
    } else {
      return false;
    }
  });

  $('.button.cancel').click(function(){
    if ($(this).is(':not(.disabled)')) {
      var f = null;
      if ("" != $(this).attr('alt'))
        var f = $("form#"+$(this).attr('alt'));
      if ($(f).is('.floating') && typeof parent.window.tb_remove != "undefined") {
        parent.window.tb_remove();
      } else {
        var cancel_url = $(f).attr('action');
        if ($('#return_url').length && '' != $('#return_url').val()) {
          cancel_url = $('#return_url').val();
        } else {
          cancel_url = $(this).attr('href');
        }
        location.href = cancel_url;
      }
      $.disableButtons(f);
    }
  });

  $('.button.reset').click(function(){
    if ($(this).is(':not(.disabled)')) {
      var f = $("form#"+$(this).attr('alt'));
      if ($(f).is('form')){
        if ("function" == eval("typeof "+$(f).attr('_onreset'))) {
          eval($(f).attr('_onreset')+'()');
        }
        $('.resetable', $(f)).each(function(){
          $(this).jsReset();
        });
        return false;
      }
    }
  });

  $('form').submit(function(){
    if ($(this).is('.floating')) {
      $.blockUI();
    }
    if ($(this).is("[method='post']")) {
      $.disableButtons(this);
    }
  }); // }}}
});

jQuery.extend({
  disableButtons: function(_parent) {
    _parent = _parent || 'html';
    return $('.button:not(.disabled)', $(_parent))
      .removeClass('hover')
      .addClass('disabled')
      .attr('disabled', true);
  },

  enableButtons: function(_parent) {
    _parent = _parent || 'html';
    return $('.button.disabled', $(_parent))
      .removeClass('disabled')
      .removeAttr('disabled');
  },

  toggleButtons: function(state, _parent) {
    _parent = _parent || '*';
    if ('off' == state) {
      return $.disableButtons(_parent);
    } else {
      return $.enableButtons(_parent);
    }
  }
});

$.fn.extend({
  isDefault: function(){
    var opts = $(this).readOpts();
    if (typeof opts != "undefined") {
      return $(this).val() == opts.def;
    }
    return true;
  },

  readOpts: function(attr) {
    attr  = attr  || 'alt';
    return eval('Object.prototype = '+$(this).attr(attr));
  },

  jsReset: function() {
    if ($(this).is('input[type=checkbox]')) {
      $(this)._jsResetCheckbox();
    } else if ($(this).is('select')) {
      $(this)._jsResetSelect();
    } else {
      $(this)._jsResetText();
    }

    return this;
  },

  saveState: function(state) {
    if ($(this).is('.can_save_state')) {
      var id = $(this).attr('id')+'_state';
      if ($(this).is('.store_state_in_cookie')) {
        $.cookie(ODESK_COOKIE_PREFIX+id, state, {domain: ODESK_COOKIE_DOMAIN});
      } else {
        $('#'+id).val(state);
      }
    }
    return this;
  },

  _jsResetCheckbox: function() {
    var def = $(this).attr('alt') || false;

    if (def && $(this).is(':not(:checked)')) {
      $(this).attr('checked', true);
    } else if (!def && $(this).is(':checked')) {
      $(this).removeAttr('checked');
    }

    return this;
  },

  _jsResetSelect: function() {
    var def = $(this).attr('alt') || false;
    if (def && $("option[value='"+def+"']", $(this)).length) {
      $(this).selectOptions(def);
    } else {
      $(this).selectOptions($('option:first', $(this)).val());
    }

    return this;
  }
});

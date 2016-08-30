$(function(){
  var enable_submit_if_ready = function() {
    var old_answer = !$('#answer').size() || $.trim($('#answer').val()).length > 0;

    var new_quest = false;
    if ($('#new_question').val().length) {
      if ('other' == $('#new_question').val()) {
        n = $.trim($('#custom_question').val());
        new_quest = (n.length > 0 && 'Type your question here' != n);
      } else {
        new_quest = true;
      }
    }

    var new_answer = $.trim($('#new_answer').val()).length > 0;

    var lockout = $('#lockout').is(':checked');

    if (old_answer && new_quest && new_answer && lockout) {
      $('#changesq :submit:disabled.button.disabled').removeAttr('disabled').removeClass('disabled');
    } else {
      $('#changesq :submit.button').attr('disabled', 'disabled').addClass('disabled');
    }
  }
  $('#changesq :submit.button').attr('disabled', 'disabled').addClass('disabled');
  $('#new_question').change(function(){
    if ('other' != $(this).val()) {
      $('#custom_question:visible').hide('fast');
    } else {
      $('#custom_question:hidden').show('fast');
    }
  });

  $('#changesq input:not(.button), #changesq select')
                                  .click(enable_submit_if_ready)
                                  .keyup(enable_submit_if_ready)
                                  .change(enable_submit_if_ready);

  $('#custom_question').focus(function(){
    if ($(this).val() == $(this).attr('title')) {
      $(this).val('');
    }
  }).blur(function(){
    if ('' == $(this).val()) {
      $(this).val($(this).attr('title'));
    }
  });

  $('#changesq .button.cancel').click(function(){
    disable_buttons();
    location.href = $(this).attr('alt');
  });
});

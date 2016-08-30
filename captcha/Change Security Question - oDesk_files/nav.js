
(function($){$(function(){$(".menuitem .menu").parent().hover(function(){trigger=$(this);l=escape($('a:first',this)[0].innerHTML);menu=$(".menu",this);$(".menuitem .menu").not(menu).hide();menu.filter(':not(:visible)').show().stopTime(l);},function(){l=escape($('a:first',this)[0].innerHTML);$('.menu',this).oneTime(750,l,function(){$(this).hide();});});$(".has_dropdown").append('<span class="icon arrow_down">&nbsp;&nbsp;</span>');$('#searchText').focus(function(){var _=$(this).attr('alt');if($(this).val()==_)
$(this).val('').css({color:'#000',fontStyle:'normal'});}).blur(function(){if($(this).val()==''){var _=$(this).attr('alt');$(this).val(_).css({color:'#666',fontStyle:'italic'});}});$('#searchText, #where').mouseover(function(){$(".menuitem .menu").hide();});$('.nav-tooltip[title]').Tooltip({track:true,delay:500,showURL:false,showBody:" - ",fade:250});(function(url){var where="Jobs";if(url.match('/users'))
where='Providers';else if(url.match('/tests'))
where='Tests';else if(url.match('/community')||url.match('/drupal')||url.match('/helpcms.*more%3Acommunity'))
where='Community';else if(url.match('/help')||url.match('/helpcms'))
where='Help';$('#where').val(where);})(document.location.toString());$('#searchform').submit(function(){ChangeSearchCondition();var i=$('input:text',this);var str=i.val();var def=i.attr('alt');if(''==str||def==str)
alert('Please provide your search terms.');else
window.location.href=$(this).attr('action');return false;});if($('#where').length){$('#where').change(function(){ChangeSearchCondition();});}
if("undefined"!=typeof mc_app)
$('#messages_dropdown .menu .menuitem a').click(function(){mc_app.set_uri($(this).attr('href').replace(/^.*\/mc\/#/,''));});});})(jQuery);
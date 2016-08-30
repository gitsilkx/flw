    var is_init = false;
    var flag_ids;
    var global_user_id;

    function initFlags(group_id, user_id) {
        var postdata = {};
        global_user_id = user_id;

        var toappend = '<div id="fo-poll-container"><b>Flag as inappropriate</b><form id="fo-poll" method="post"><p id="fo_note" class="small">Tell us why you are flagging this</p><div id="img-loader"><img src="/images/winbox_throbber.gif"/></div><div id="flags-list"></div><div id="flg"><input id="flag-button" type="button" onclick="return setUserFlags(\''+user_id+'\')" value="Submit" /> <input id="flag-button" type="button" onclick="return fo_toggle()" value="Cancel" /></div></form></div>';

        $("#fo_link").parent().append(toappend);

        postdata.func = "getFlagList";
        postdata.group_id = group_id;
        postdata.flagged_item = 'user';
        postdata.flagged_item_id = user_id;
        jQuery.ajax({
            url: "/api/hr/v1/flagging.json",
            type: "get",
            data:postdata,
            dataType:"json",
            complete: function(jsondata,stat) {
                if(stat=="success") {
                    var res = JSON.parse(jsondata.responseText);
                    if (res["type_ids"]) {
                        flag_ids = res["type_ids"];
                        is_init = true;
                        for(i=0; i < res["type_ids"].length; i++) {
                            $("#flags-list").append("<div><input type=\"checkbox\" name=\"poll\" value=\""+res["type_ids"][i]+"\" id=\"flag_id_"+res["type_ids"][i]+"\" ><label for=\"flag_id_"+res["type_ids"][i]+"\">"+res["flag_names"][i]+"</label></div>");
                        }
                        $('#fo_link').live('click', function() {fo_toggle(global_user_id)});
                    }
                }
            },
            error: function(jsondata,stat,error) {
                $("#fo-poll-container").html('<b>Flag as inappropriate</b><form id="fo-poll" method="post"><p id="fo_note" class="small">Tell us why you are flagging this</p><div>Sorry, Flagging is temporarily unavailable</div><div id="flg"><input id="flag-button" type="button" onclick="return fo_toggle()" value="Cancel" /></div></form></div>');
                $("#img-loader").hide();
                $("#flags-list").hide();
            }
        });
    }

    function getUserFlags(flagged_user_id) {
        var postdata = {};
        var fo_id = flag_ids;
        postdata.func = "getFlag";
        postdata.flagged_item_id = flagged_user_id;
        postdata.type_id = JSON.stringify(fo_id);
        postdata.flagged_item = 'user';
        jQuery.ajax({
            url: "/api/hr/v1/flagging.json",
            type: "get",
            data:postdata,
            dataType:"json",
            complete: function(jsondata,stat){
                if(stat=="success") {
                    var res = JSON.parse(jsondata.responseText);
                    if (res["type_ids"]) {
                        $("div#flags-list > div input[type=checkbox]").removeAttr("checked");
                        for(i=0; i < res["type_ids"].length; i++) {
                            $("#flag_id_" + res["type_ids"][i]).attr("checked","checked");
                        }
                        $("#img-loader").hide();
                        $("#flags-list").show();
                    }
                }
            },
            error: function(jsondata,stat,error) {
                $("#fo-poll-container").html('<b>Flag as inappropriate</b><form id="fo-poll" method="post"><p id="fo_note" class="small">Tell us why you are flagging this</p><div>Sorry, Flagging is temporarily unavailable</div><div id="flg"><input id="flag-button" type="button" onclick="return fo_toggle()" value="Cancel" /></div></form></div>');
                $("#img-loader").hide();
                $("#flags-list").hide();
            }
        });
    }

    function fo_toggle(user_id) {
        if ($("#fo-poll-container").is(":hidden") && is_init) {
            getUserFlags(user_id);
            $("#fo-poll-container").slideDown("fast");
        } else {
            $("#fo-poll-container").slideUp("fast");
            $("#flags-list").hide();
            $("#img-loader").show();
        }
    }

    function setUserFlags(flagged_user_id) {
        $("#flags-list").hide();
        $("#img-loader").show();

        var postdata = {};
        var w = jQuery("input[name=poll]:checkbox");
        var fo_id = new Array();
        var fo_unset_id = new Array();
        for(i=0;i<w.length;i++){
            if (w[i].checked) {
                fo_id.push(w[i].value);
            } else {
                fo_unset_id.push(w[i].value);
            }
        }

        postdata.func = "toggleFlag";
        postdata.flagged_item_id = flagged_user_id;
        postdata.type_id = JSON.stringify(fo_id);
        postdata.flagged_item = 'user';
        postdata.unset_type_id = JSON.stringify(fo_unset_id);
        jQuery.ajax({
            url: "/api/hr/v1/flagging.json",
            type: "get",
            data:postdata,
            dataType:"json",
            complete: function(jsondata,stat){
                if(stat=="success") {
                    fo_toggle();
                }
            },
            error: function(jsondata,stat,error) {
                $("#fo-poll-container").html('<b>Flag as inappropriate</b><form id="fo-poll" method="post"><p id="fo_note" class="small">Tell us why you are flagging this</p><div>Sorry, Flagging is temporarily unavailable</div><div id="flg"><input id="flag-button" type="button" onclick="return fo_toggle()" value="Cancel" /></div></form></div>');
                $("#img-loader").hide();
                $("#flags-list").hide();
            }
        });
        return false;
    };

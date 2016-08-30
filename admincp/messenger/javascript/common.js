/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2005 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: common.js 107 2007-03-25 19:49:18Z matt.simpson $
*/

var domTT_classPrefix	= 'domTT';
var domTT_maxWidth		= 125;

function cookie_get(name) {
	cname = name+'=';
	cpos  = document.cookie.indexOf(cname);

	if(cpos != -1) {
		cstart = cpos + cname.length;
		cend   = document.cookie.indexOf(';', cstart);

		if(cend == -1) {
			cend = document.cookie.length;
		}

		return unescape(document.cookie.substring(cstart, cend));
	}

	return null;
}

function cookie_set(name, value, expires) {
	document.cookie = name+'='+value+'; path=/; expires='+expires+';';
}

function element_type(elemID) {
	if(document.getElementById) {
		return document.getElementById(elemID);
	} else if (document.all) {
		return document.all[elemID];
	} else if (document.layers) {
		return document.layers[elemID];
	}
}

function div_hide(element) {
	if(!element) {
		return;
	}
	element.style.display = 'none';
}

function div_show(element) {
	if(!element) {
		return;
	}
	element.style.display = '';
}

function toggle_section(divid, add, expires, section) {
	saved = new Array();
	clean = new Array();

	if(tmp = cookie_get('display['+section+'][collapsed]'))	{
		saved = tmp.split(',');
	}

	for( i = 0 ; i < saved.length; i++ ) {
		if(saved[i] != divid && saved[i] != '') {
			clean[clean.length] = saved[i];
		}
	}

	if(add) {
		clean[clean.length] = divid;
		div_show(element_type('closed_'+divid));
		div_hide(element_type('opened_'+divid));
	} else {
		div_show(element_type('opened_'+divid));
		div_hide(element_type('closed_'+divid));
	}

	cookie_set('display['+section+'][collapsed]', clean.join(','), expires);
}

function toggle_row(rowid, show) {
	if(show) {
		div_show(element_type('closed_'+rowid));
		div_hide(element_type('opened_'+rowid));
	} else {
		div_show(element_type('opened_'+rowid));
		div_hide(element_type('closed_'+rowid));
	}
}

function openAbout(sid){
	if(!sid) {
		return;
	} else {
		var windowW = 545;
		var windowH = 505;

		var windowX = (screen.width / 2) - (windowW / 2);
		var windowY = (screen.height / 2) - (windowH / 2);

		aboutDialog = window.open('./about.php?sid='+sid, 'aboutDialogBox', 'width='+windowW+', height='+windowH+', scrollbars=no');
		aboutDialog.blur();
		window.focus();

		aboutDialog.resizeTo(windowW, windowH);
		aboutDialog.moveTo(windowX, windowY);

		aboutDialog.focus();
	}
}

function openAttachements(sid){
	if(!sid) {
		return;
	} else {
		var windowW = 640;
		var windowH = 445;

		var windowX = (screen.width / 2) - (windowW / 2);
		var windowY = (screen.height / 2) - (windowH / 2);

		attachmentsDialog = window.open('./attachments.php?sid='+sid, 'attachmentDialogBox', 'statusbar=yes, width='+windowW+', height='+windowH);
		attachmentsDialog.blur();
		window.focus();

		attachmentsDialog.resizeTo(windowW, windowH);
		attachmentsDialog.moveTo(windowX, windowY);

		attachmentsDialog.focus();
	}
}
function loadHTMLArea(textarea_id) {
	var editor = new HTMLArea(textarea_id);
	editor.generate();
}

var checkflag = 'false';
function selection(field) {
	if(checkflag == 'false') {
		if(!field.length) {
			field.checked = true;
		} else {
			for (i = 0; i < field.length; i++) {
				field[i].checked = true;
			}
		}
		checkflag = 'true';
		return;
	} else {
		if(!field.length) {
			field.checked = false;
		} else {
			for (i = 0; i < field.length; i++) {
				field[i].checked = false;
			}
		}
		checkflag = 'false';
		return;
	}
}

/***********************************************
* Disable "Enter" key in Form script- By Nurul Fadilah(nurul@REMOVETHISvolmedia.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
function handleEnter (field, event) {
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) {
		var i;
		for (i = 0; i < field.form.elements.length; i++) {
			if (field == field.form.elements[i]) {
				break;
			}
		}
		i = (i + 1) % field.form.elements.length;
		field.form.elements[i].focus();
		return false;
	} else {
		return true;
	}
}

function getSelectedRadio(buttonGroup) {
	if (buttonGroup[0]) {
		for (var i = 0; i < buttonGroup.length; i++) {
			if (buttonGroup[i].checked) {
				return i
			}
		}
	} else {
		if (buttonGroup.checked) {
			return 0;
		}
	}
	return -1;
}

function getSelectedRadioValue(buttonGroup) {
	var i = getSelectedRadio(buttonGroup);
	if (i == -1) {
		return '';
	} else {
		if (buttonGroup[i]) {
			return buttonGroup[i].value;
		} else {
			return buttonGroup.value;
		}
	}
}

function submitOnlineFile() {
	window.opener.document.getElementById('online_filename').value = getSelectedRadioValue(document.attachment_list.online_file);
	if(window.opener.document.getElementById('online_filename').value != "") {
		window.opener.document.getElementById('compose_message').submit();
		parent.window.focus();
		top.window.close();

		return;
	} else {
		alert('You must select a file to attach to your message; otherwise, click Close Window');
	}
}

function confirmRestore() {
	var doublecheck = confirm('Restoring this backup file will empty your current ListMessenger database and restore the contents of the selected tables to it.\n\nClick OK if you understand that your current data will be deleted and if you are sure that this is the action you wish to take. You can cancel this request, by clicking the Cancel button.', '');
	if(doublecheck != null && doublecheck != '') {
		document.getElementById('restoreData').submit();
	}

	return;
}

function setImportType(type) {
	document.getElementById('excel').style.display	= 'none';
	document.getElementById('csv').style.display	= 'none';
	document.getElementById('text').style.display	= 'none';

	document.getElementById(type).style.display		= '';

	return;
}
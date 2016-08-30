<?php
/*
<language name="German" version="2.1.0">
	<translator_name>Wekemann Udo</translator_name>
	<translator_email>udo@wekemann.de</translator_email>
	<translator_url>http://www.listmessenger.com/index.php/languages</translator_url>
	<updated>11:22 2005-10-04</updated>
	<notes>German Language File</notes>
</language>
*/
$language_pack = array();

$language_pack["default_page_title"]					= "ListMessenger Mailing List Management System";
$language_pack["default_page_message"]					= "Besuchen Sie bitte unsere Webseite um sich in unseren Mailverteiler ein- bzw. auszutragen.";
$language_pack["error_default_title"]					= "Fehler innerhalb Ihrer Anfrage";
$language_pack["error_invalid_action"]					= "Die gewünschte Aktion ist unzulässig. Bitte überprüfen Sie den korrekten Systemzugriff durch das auf unserer Webseite zur Verfügung gestellte Eintragungsformular.";

$language_pack["error_subscribe_no_groups"]				= "Sie müssen mindestens eine Mailing Liste auswählen damit Sie sich eintragen können. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_subscribe_group_not_found"]		= "Eine Mailing Liste, auf der Sie sich eintragen möchten, ist nicht länger in diesem System vorhanden. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_subscribe_email_exists"]			= "Die eMail-Adresse, die Sie angegeben haben, existiert bereits in der/den Mailing Liste/n. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_subscribe_no_email"]				= "Bitte geben Sie eine eMail Adresse an, unter der Sie sich in unserem Mailverteiler eintragen möchten.";
$language_pack["error_subscribe_invalid_email"]			= "Die eMail Adresse, die Sie angegeben haben, scheint keine gültige eMail Adresse zu sein.";
$language_pack["error_subscribe_banned_email"]			= "Die eMail Adresse, die Sie angegeben haben, ist leider nicht erlaubt.";
$language_pack["error_subscribe_banned_domain"]			= "Der Domain Name Ihrer angegebenen eMail Adresse ist leider nicht erlaubt.";
$language_pack["error_subscribe_invalid_domain"]		= "Der Domain Name Ihrer angegebenen eMail Adresse scheint kein gültiger Domain Name zu sein.";
$language_pack["error_subscribe_required_cfield"]		= "&quot;[cfield_name]&quot; ist ein Pflichtfeld. Bitte gehen Sie zurück zur entsprechenden Informationsseite und geben Sie diese benötigte Information an."; // Requires [cfield_name] variable in sentence.
$language_pack["error_subscribe_failed_optin"]			= "Es ist uns leider nicht möglich Ihnen eine Bestätigungs-eMail zu senden. Bitte kontaktieren Sie den Webseite Administrator und unterrichten Sie ihn über dieses Problem. Danke.";
$language_pack["error_subscribe_failed"]				= "Es ist uns leider nicht möglich Ihre eMail Adresse in unserem Mailverteiler einzutragen. Bitte kontaktieren Sie den Webseite Administrator und unterrichten Sie ihn über dieses Problem. Danke.";
$language_pack["success_subscribe_optin_title"]			= "Eintragebestätigungsmeldung gesendet";
$language_pack["success_subscribe_optin_message"]		= "Vielen Dank für Ihr Interesse an unserem Mailverteiler. Sie werden in Kürze eine Eintragsbestätigung per eMail erhalten. Bitte bestätigen Sie Ihren Eintrag durch klicken auf den Bestätigungs-Link in dieser eMail.";
$language_pack["success_subscribe_title"]				= "Erfolgreicher Eintrag in unseren Mailverteiler";
$language_pack["success_subscribe_message"]				= "Vielen Dank für Ihr Interesse an unserem Mailverteiler. Ihre eMail Adresse wurde erfolgreich in unseren Mailverteiler eintragen. Zukünftig werden alle Nachrichten an Sie über diese eMail Adresse versandt.";

$language_pack["error_unsubscribe_no_groups"]			= "Sie müssen mindestens eine Mailverteilerliste auswählen, damit Sie sich austragen können. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_group_not_found"]		= "Eine Mailverteilerliste, auf der Sie sich austragen möchten, ist nicht länger in diesem System vorhanden. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_email_not_found"]		= "Die eMail Adresse, die Sie angegeben haben, existiert nicht in unserer Datenbank. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_email_not_exists"]	= "Die eMail Adresse, mit der Sie sich von unserer Mailverteilerliste austragen möchten, existiert leider nicht in diesem Mailverteiler. Sollten Sie weitere Hilfestellung benötigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_no_email"]			= "Bitte geben Sie Ihre eMail Adresse an, damit es uns möglich ist, Sie aus dem Verteiler unserer Mailing Liste auszutragen.";
$language_pack["error_unsubscribe_invalid_email"]		= "Die von Ihnen angegebene eMail Adresse scheint nicht gültig zu sein.";
$language_pack["error_unsubscribe_failed_optout"]		= "Leider war es uns aufgrund eines technischen Problems nicht möglich Ihnen eine Austragebestätigungs eMail zu zusenden. Bitte kontaktieren Sie den Webseite Administrator und informieren Sie ihn darüber, dass Sie Probleme beim Austragen Ihrer eMail Adresse hatten.";
$language_pack["error_update_profile"]					= "We were unfortunately unable to send you an update profile confirmation notice due to a problem that we are currently experiencing. Please contact the website administrator and let the know you are having difficulty while trying to update your profile.";
$language_pack["success_unsubscribe_optout_title"]		= "Austragebestätigungsmeldung gesendet";
$language_pack["success_unsubscribe_optout_message"]	= "Schade, dass Sie sich aus unserem Mailverteiler ausgetragen haben. Bitte bestätigen Sie Ihre Adresslöschung in der Bestätigungs eMail die wir Ihnen zugesandt haben durch klicken auf den entsprechenden Internet Link.";
$language_pack["success_unsubscribe_title"]				= "Erfolgreiche Löschung aus der Mailverteilerliste";
$language_pack["success_unsubscribe_message"]			= "Schade, dass Sie sich aus unserer Mailverteilerliste ausgetragen haben. Ihre eMail Adresse wurde erfolgreich aus der gewählten Verteilerliste ausgetragen. Sie können sich aber jederzeit wieder in diese Verteilerliste eintragen.";

$language_pack["error_invalid_captcha"]					= "The security code you entered was not correct, please go back and re-enter the text that appears in the security image.";
$language_pack["error_expired_code"]					= "This confirmation code has expired after 7 days. To update your profile, please request a new confirmation code.";
$language_pack["error_confirm_invalid_request"]			= "Leider konnten wir keine gültige Bestätigungsinformation in Ihrer Anfrage finden. Sollten Sie den Link, den wir Ihnen in der Bestätigungs-eMail zugesandt haben, durch Kopieren und Einsetzen kopiert haben, könnte es sein, dass versehentlich unnötige Zeilenumbrüche erzeugt wurden. Der Link wird dadurch fehlerhaft.";
$language_pack["error_confirm_completed"]				= "Es scheint als hŠtten Sie die Anfrage bereits bestätigt. Es sind deshalb keine weiteren Aktionen notwendig. Danke.";
$language_pack["error_confirm_unable_request"]			= "Wir entschuldigen uns für diese Unannehmlichkeiten. Wie auch immer, leider ist es uns zurzeit nicht möglich Ihre Anfrage auszuführen. Bitte kontaktieren Sie den Webseiten-Administrator und informieren Sie ihn über dieses Problem.";
$language_pack["error_confirm_unable_find_info"]		= "Wir entschuldigen uns für diese Unannehmlichkeiten. Wir können keinen gültigen Eintrag Ihrer eMail Adresse bezüglich dieses Mailverteilers in unserer Datenbank finden. Bitte kontaktieren Sie den Webseiten-Administrator und informieren Sie ihn über dieses Problem.";
$language_pack["page_confirm_title"]					= "Mailverteiler-Eintragsbestätigung";
$language_pack["page_confirm_message_sentence"]			= "Bitte überprüfen Sie die folgenden Informationen bevor Sie den Bestätigungs-Button anklicken.";
$language_pack["page_confirm_firstname"]				= "Vorname:";
$language_pack["page_confirm_lastname"]					= "Nachname:";
$language_pack["page_confirm_email_address"]			= "eMail Adresse:";
$language_pack["page_confirm_group_info"]				= "Verteilergruppe:";
$language_pack["page_confirm_cancel_button"]			= "Abbruch";
$language_pack["page_confirm_submit_button"]			= "Bestätigung";

$language_pack["page_unsubscribe_title"]				= "Mailverteilerlistenbestätigung";
$language_pack["page_unsubscribe_message_sentence"]		= "Bitte wählen Sie die Liste oder Listen aus der/denen Sie sich austragen möchten:";
$language_pack["page_unsubscribe_list_groups"]			= "[email] von [groupname].";	// Requires [email] and [groupname] variable in sentence.
$language_pack["page_unsubscribe_cancel_button"]		= "Abbruch";
$language_pack["page_unsubscribe_submit_button"]		= "Austragen";

$language_pack["page_help_title"]						= "Mailverteilerliste Hilfefunktion";
$language_pack["page_help_message_sentence"]			= "Willkommen zur Mailverteiler-Hilfe. Diese Filefunktion versucht einige Basisfragen, die bei Ihnen als Nutzer vielleicht auftreten, zu klären. Sollten Sie Fragen haben die hier nicht erklärt werden, kontaktieren Sie bitte den Administrator unter folgenden eMail-Adresse: [abuse_address]";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_subtitle"]					= "Allgemeine Fragen:";
$language_pack["page_help_question_1"]					= "Wie kann ich diesen Mailverteiler abonnieren?";
$language_pack["page_help_answer_1_optin"]				= "Unser Mailverteiler verlangt vom Anmelder eine doppelte Bestätigung bevor er endgültig in unserer Verteilerleiste eingetragen ist. Das geschieht aus dem Grund, da Sie oder jemand anderes Ihre eMail Adresse zu unserem Mailverteiler hinzugefügt hat. Damit Missbrauch mit Ihrer eMail-Adresse vermieden werden kann, schicken wir an die neu eingetragene eMail-Adresse eine Bestätigungs-eMail, die Sie dann über den dort angegebenen Link bestätigen müssen. Sollten Sie trotzdem ohne Bestätigungs-eMail unseren Newsletter erhalten, kann das daran liegen, dass der Administrator Sie manuell in die Verteilerliste aufgenommen hat. Details über diese Transaktion können Sie direkt beim Administrator erfahren. Nutzen Sie dazu bitte diese eMail [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_answer_1_no_optin"]			= "Unser Mailverteiler verlangt vom Anwender keine doppelte Bestätigung bevor er in eine Mailverteilungsliste von uns aufgenommen wird. Das bedeutet, dass Sie oder irgendjemand Ihre eMail Adresse in unser Verteilsystem eingegeben hat und Sie nicht aufgefordert wurden diese Eingabe zu bestätigen. Details über diese Transaktion können Sie direkt beim Administrator erfahren. Nutzen Sie dazu bitte diese eMail [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_2"]					= "Wie trage ich mich selbst aus der Mailverteilerliste aus?";
$language_pack["page_help_answer_2_optout"]				= "Sollten Sie sich selbst aus einer oder mehreren Mailverteilerlisten austragen wollen, füllen Sie bitte das folgende Formular aus. Nachdem Sie Ihre eMail Adresse angegeben und die Liste bzw. Listen ausgewählt haben, aus der bzw. denen Sie ausgetragen werden möchten, müssen Sie Ihren Austrag in der erhaltenen eMail mittels Klick auf den Bestätigungs-Link bestätigen.";
$language_pack["page_help_answer_2_no_optout"]			= "Sollten Sie sich selbst aus einer oder mehreren Mailverteilerlisten austragen wollen, füllen Sie bitte das folgende Formular aus. Nachdem Sie Ihre eMail Adresse angegeben haben und die Liste bzw. Listen ausgewählt haben, aus der bzw. denen Sie ausgetragen werden möchten, wird Ihre eMail Adresse unmittelbar aus unserer Datenbank entfernt.";
$language_pack["page_help_question_3"]					= "Was bedeutet diese eMail, die ich erhalten habe?";
$language_pack["page_help_answer_3"]					= "Diese Mailverteiler-Hilfe ist leider nicht in der Lage den Inhalt der eMail, die Sie erhalten haben, zu erklären. Es ist also davon auszugehen, dass die eMail, die Sie erhielten, von unserem Newslettersystem stammt. Sollten Sie aber davon überzeugt sein, dass Sie diese eMail aufgrund eines Irrtums erhalten haben, informieren Sie bitte den Administrator unter [abuse_address] über diesen Irrtum.";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_4"]					= "How do I update my personal details for this mailing list?";
$language_pack["page_help_answer_4"]					= "You can update your personal details by visiting the <a href=\"[URL]\">Update User Profile</a> page."; // Requires [URL] variable.

$language_pack["page_archive_closed_title"]				= "Mailverteilerarchiv geschlossen";
$language_pack["page_archive_closed_message_sentence"]	= "Unser Mailverteilerarchiv ist für die Öffentlichkeit zur Zeit geschlossen. Sollten Sie eine bereits gesendete Mail oder weitere Hilfe benötigen, wenden Sie sich bitte an den Administrator unter [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_archive_opened_title"]				= "Öffentliches Mailverteilerarchiv";
$language_pack["page_archive_opened_message_sentence"]	= "Welcome to our public mailing list archive. Here you can view our collection of e-mail newsletters that have previously been sent to our subscriber base. As a matter of convenience you can also subscribe to our [rssfeed_url]."; // Requires [rssfeed_url] in sentence.
$language_pack["page_archive_view_title"]				= "Öffentliches Mailverteilerarchiv - Nachricht lesen";
$language_pack["page_archive_error_html_title"]			= "Fehler in der Darstellung einer HTML Nachricht";
$language_pack["page_archive_error_no_message"]			= "Die angeforderte Nachricht konnte in unserer Verteilerliste nicht gefunden werden. Bitte kehren Sie zum Archiv zurück.";
$language_pack["page_archive_error_no_messages"]		= "Zur Zeit gibt es keine Nachrichten, die Sie im Archiv betrachten könnten. Versuchen Sie es später bitte noch einmal.";
$language_pack["page_archive_view_from"]				= "Von:";
$language_pack["page_archive_view_subject"]				= "Betreff:";
$language_pack["page_archive_view_date"]				= "Datum:";
$language_pack["page_archive_view_to"]					= "Für:";
$language_pack["page_archive_view_attachments"]			= "Anhänge:";
$language_pack["page_archive_view_missing_attachment"]	= "Anhang ist nicht länger verfügbar";
$language_pack["page_archive_view_message_from"]		= "Nachricht von";
$language_pack["page_archive_view_message_subject"]		= "Betreff der Nachricht";
$language_pack["page_archive_view_message_sent"]		= "Sendedatum";
$language_pack["page_archive_rss_title"]				= "Newsletter RSS Feed";
$language_pack["page_archive_rss_description"]			= "Welcome to the RSS version of our mailing list archive. Here you can view our collection of e-mail newsletters that have previously been sent to our subscriber base.";
$language_pack["page_archive_rss_link"]					= ""; // You can optionally set this to the web-address of your website.

$language_pack["page_profile_closed_title"]				= "Subscriber Profile Update Closed";
$language_pack["page_profile_closed_message_sentence"]	= "Our subscriber profile update section is currently closed. If you require assistance, please contact an administrator at [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_profile_opened_title"] 			= "Update Subscriber Profile";
$language_pack["page_profile_instructions"] 			= "Thank-you for keeping your subscriber information up to date. To proceed with updating your information please enter your e-mail address in the form below. The system will then send you an e-mail containing a customized link that you can follow to make the changes to your account.";
$language_pack["page_profile_submit_button"] 			= "Continue";
$language_pack["page_profile_update_button"] 			= "Update";
$language_pack["page_profile_close_button"] 			= "Close";
$language_pack["page_profile_cancel_button"] 			= "Cancel";
$language_pack["page_profile_email_address"]			= "E-Mail Address:";
$language_pack["page_profile_step1_complete"] 			= "In order to protect your privacy, we require that you verify that you are the owner of this e-mail address. You will receive an update profile confirmation notice shortly. Please follow the link included in that e-mail to continue.";
$language_pack["page_profile_step2_instructions"] 		= "To proceed with updating your information please review the form below and make any required changes.";
$language_pack["page_profile_step2_complete"] 			= "Your subscriber information had been updated. Thank-you for keeping your subscriber information up to date.";
$language_pack["update_profile_confirmation_subject"]	= "Instructions for Updating Subscriber Information";
$language_pack["update_profile_confirmation_message"]	= <<<UPDATEPROFILE
Hello [name],
Thank you for your recent request to update your subscriber information.

To review and update your information, please follow the link below:
[url]

If you did not submit a request to update your information, please ignore this e-mail and do not follow the above link. If requests persist, you may wish to notify our abuse account at [abuse_address].

Sincerely,
[from]
UPDATEPROFILE;

$language_pack["unsubscribe_message"]					= <<<UNSUBSCRIBEMSG
-------------------------------------------------------------------
Diese eMail wurde an [email] versandt, da Sie in einer oder mehreren Mailverteilerlisten eingetragen sind. Sollten Sie sich selbst von dieser oder diesen Verteilerlisten streichen wollen, können Sie dies jederzeit indem Sie folgenden Internet Link anklicken:
[unsubscribe_url]
UNSUBSCRIBEMSG;

$language_pack["subscribe_confirmation_subject"]		= "Bestätigung für die Aufnahme in unserer Mailverteilerliste";
$language_pack["subscribe_confirmation_message"]		= <<<SUBSCRIBEEMAIL
Hallo [name]
Jemand (Sie selbst oder unser Administrator) hat angefragt, dass Ihre eMail Adresse zu einer oder mehreren Mailverteilerlisten hinzugefügt werden soll.


Ihnen wurde diese eMail zugeschickt, damit Sie die Eintragung in unsere Mailverteilerliste bestätigen. Klicken Sie dazu bitte auf folgenden Internet Link:
[url]

Sollten Sie diesen Wunsch nicht geäußert haben, dann ignorieren Sie bitte diese eMail und klicken auch nicht auf den oben genannten Internet Link. Sollten Sie weiterhin nicht angeforderte eMails dieser Art von uns erhalten, dann bitten wir Sie, diesen Missbrauch an folgende eMail Adresse zu melden: [abuse_address]

Mit freundlichen Grüßen,
[from]
SUBSCRIBEEMAIL;

$language_pack["unsubscribe_confirmation_subject"]	= "Bestätigung der Löschung aus unserer Mailverteilerliste";
$language_pack["unsubscribe_confirmation_message"]	= <<<UNSUBSCRIBEEMAIL
Jemand (Sie selbst oder unser Administrator) hat angefragt, das Ihre eMail Adresse von einer oder mehreren Mailverteilerlisten entfernt werden soll.

Ihnen wurde diese eMail zugeschickt, damit Sie die Austragung aus unserer Mailverteilerliste bestätigen. Klicken Sie dazu bitte auf folgenden Internet Link:
[url]

Sollten Sie diesen Wunsch nicht geäußert haben, dann ignorieren Sie bitte diese eMail und klicken auch nicht auf den oben genannten Internet Link. Sollten Sie weiterhin nicht angeforderte eMails dieser Art von uns erhalten, dann bitten wir Sie, diesen Missbrauch an folgende eMail Adresse zu melden: [abuse_address]

Mit freundlichen Grüßen,
[from]
UNSUBSCRIBEEMAIL;

$language_pack["subscribe_notification_subject"]		= "[ListMessenger Nachricht] Neuer Abonnent";
$language_pack["subscribe_notification_message"]		= <<<SUBSCRIBENOTICEEMAIL
Diese eMail soll Sie darüber informieren, dass sich ein neuer Abonnent in eine oder mehrere ListMessenger Mailverteilerlisten eingetragen hat.

Daten des neuen Abonnenten:
Full Name:\t[firstname] [lastname]
eMail Addresse:\t[email_address]
Eingetragen in:
[group_ids]

-------------------------------------------------------------------
Sie haben diese Benachrichtigung bekommen, da die Benachrichtigungfunktion Neuer Abonnent im ListMessenger Control Panel aktiviert ist. Sollten Sie diesen Service nicht wünschen, loggen Sie sich bitte einfach in ListMessenger ein. Klicken Sie dann auf den Menüpunkt Control Panel / End-User Preferences und setzen Sie die Funktion New Subscriber Notification auf inaktive (disable).
SUBSCRIBENOTICEEMAIL;

$language_pack["unsubscribe_notification_subject"]	= "[ListMessenger Nachricht] Abonnent gelöscht";
$language_pack["unsubscribe_notification_message"]	= <<<UNSUBSCRIBENOTICEEMAIL
Diese eMail soll Sie darüber informieren, dass sich ein Abonnent in einer oder mehreren ListMessenger Mailverteilerlisten ausgetragen hat.

Daten des gelöschten Abonnenten:
Full Name:\t[firstname] [lastname]
eMail Addresse:\t[email_address]
Gelöscht aus folgenden Gruppen:
[group_ids]

-------------------------------------------------------------------
Sie haben diese Benachrichtigung bekommen, da die Benachrichtigungfunktion Abonnent gelöscht im ListMessenger Control Panel aktiviert ist. Sollten Sie diesen Service nicht wünschen, loggen Sie sich bitte einfach in ListMessenger ein. Klicken Sie dann auf den Menüpunkt Control Panel / End-User Preferences und setzen Sie die Funktion Unsubscribe Notification auf inaktive (disable).
UNSUBSCRIBENOTICEEMAIL;
?>
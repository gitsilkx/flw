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
$language_pack["error_invalid_action"]					= "Die gew�nschte Aktion ist unzul�ssig. Bitte �berpr�fen Sie den korrekten Systemzugriff durch das auf unserer Webseite zur Verf�gung gestellte Eintragungsformular.";

$language_pack["error_subscribe_no_groups"]				= "Sie m�ssen mindestens eine Mailing Liste ausw�hlen damit Sie sich eintragen k�nnen. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_subscribe_group_not_found"]		= "Eine Mailing Liste, auf der Sie sich eintragen m�chten, ist nicht l�nger in diesem System vorhanden. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_subscribe_email_exists"]			= "Die eMail-Adresse, die Sie angegeben haben, existiert bereits in der/den Mailing Liste/n. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_subscribe_no_email"]				= "Bitte geben Sie eine eMail Adresse an, unter der Sie sich in unserem Mailverteiler eintragen m�chten.";
$language_pack["error_subscribe_invalid_email"]			= "Die eMail Adresse, die Sie angegeben haben, scheint keine g�ltige eMail Adresse zu sein.";
$language_pack["error_subscribe_banned_email"]			= "Die eMail Adresse, die Sie angegeben haben, ist leider nicht erlaubt.";
$language_pack["error_subscribe_banned_domain"]			= "Der Domain Name Ihrer angegebenen eMail Adresse ist leider nicht erlaubt.";
$language_pack["error_subscribe_invalid_domain"]		= "Der Domain Name Ihrer angegebenen eMail Adresse scheint kein g�ltiger Domain Name zu sein.";
$language_pack["error_subscribe_required_cfield"]		= "&quot;[cfield_name]&quot; ist ein Pflichtfeld. Bitte gehen Sie zur�ck zur entsprechenden Informationsseite und geben Sie diese ben�tigte Information an."; // Requires [cfield_name] variable in sentence.
$language_pack["error_subscribe_failed_optin"]			= "Es ist uns leider nicht m�glich Ihnen eine Best�tigungs-eMail zu senden. Bitte kontaktieren Sie den Webseite Administrator und unterrichten Sie ihn �ber dieses Problem. Danke.";
$language_pack["error_subscribe_failed"]				= "Es ist uns leider nicht m�glich Ihre eMail Adresse in unserem Mailverteiler einzutragen. Bitte kontaktieren Sie den Webseite Administrator und unterrichten Sie ihn �ber dieses Problem. Danke.";
$language_pack["success_subscribe_optin_title"]			= "Eintragebest�tigungsmeldung gesendet";
$language_pack["success_subscribe_optin_message"]		= "Vielen Dank f�r Ihr Interesse an unserem Mailverteiler. Sie werden in K�rze eine Eintragsbest�tigung per eMail erhalten. Bitte best�tigen Sie Ihren Eintrag durch klicken auf den Best�tigungs-Link in dieser eMail.";
$language_pack["success_subscribe_title"]				= "Erfolgreicher Eintrag in unseren Mailverteiler";
$language_pack["success_subscribe_message"]				= "Vielen Dank f�r Ihr Interesse an unserem Mailverteiler. Ihre eMail Adresse wurde erfolgreich in unseren Mailverteiler eintragen. Zuk�nftig werden alle Nachrichten an Sie �ber diese eMail Adresse versandt.";

$language_pack["error_unsubscribe_no_groups"]			= "Sie m�ssen mindestens eine Mailverteilerliste ausw�hlen, damit Sie sich austragen k�nnen. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_group_not_found"]		= "Eine Mailverteilerliste, auf der Sie sich austragen m�chten, ist nicht l�nger in diesem System vorhanden. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_email_not_found"]		= "Die eMail Adresse, die Sie angegeben haben, existiert nicht in unserer Datenbank. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_email_not_exists"]	= "Die eMail Adresse, mit der Sie sich von unserer Mailverteilerliste austragen m�chten, existiert leider nicht in diesem Mailverteiler. Sollten Sie weitere Hilfestellung ben�tigen, kontaktieren Sie bitte den Webseite-Administrator.";
$language_pack["error_unsubscribe_no_email"]			= "Bitte geben Sie Ihre eMail Adresse an, damit es uns m�glich ist, Sie aus dem Verteiler unserer Mailing Liste auszutragen.";
$language_pack["error_unsubscribe_invalid_email"]		= "Die von Ihnen angegebene eMail Adresse scheint nicht g�ltig zu sein.";
$language_pack["error_unsubscribe_failed_optout"]		= "Leider war es uns aufgrund eines technischen Problems nicht m�glich Ihnen eine Austragebest�tigungs eMail zu zusenden. Bitte kontaktieren Sie den Webseite Administrator und informieren Sie ihn dar�ber, dass Sie Probleme beim Austragen Ihrer eMail Adresse hatten.";
$language_pack["error_update_profile"]					= "We were unfortunately unable to send you an update profile confirmation notice due to a problem that we are currently experiencing. Please contact the website administrator and let the know you are having difficulty while trying to update your profile.";
$language_pack["success_unsubscribe_optout_title"]		= "Austragebest�tigungsmeldung gesendet";
$language_pack["success_unsubscribe_optout_message"]	= "Schade, dass Sie sich aus unserem Mailverteiler ausgetragen haben. Bitte best�tigen Sie Ihre Adressl�schung in der Best�tigungs eMail die wir Ihnen zugesandt haben durch klicken auf den entsprechenden Internet Link.";
$language_pack["success_unsubscribe_title"]				= "Erfolgreiche L�schung aus der Mailverteilerliste";
$language_pack["success_unsubscribe_message"]			= "Schade, dass Sie sich aus unserer Mailverteilerliste ausgetragen haben. Ihre eMail Adresse wurde erfolgreich aus der gew�hlten Verteilerliste ausgetragen. Sie k�nnen sich aber jederzeit wieder in diese Verteilerliste eintragen.";

$language_pack["error_invalid_captcha"]					= "The security code you entered was not correct, please go back and re-enter the text that appears in the security image.";
$language_pack["error_expired_code"]					= "This confirmation code has expired after 7 days. To update your profile, please request a new confirmation code.";
$language_pack["error_confirm_invalid_request"]			= "Leider konnten wir keine g�ltige Best�tigungsinformation in Ihrer Anfrage finden. Sollten Sie den Link, den wir Ihnen in der Best�tigungs-eMail zugesandt haben, durch Kopieren und Einsetzen kopiert haben, k�nnte es sein, dass versehentlich unn�tige Zeilenumbr�che erzeugt wurden. Der Link wird dadurch fehlerhaft.";
$language_pack["error_confirm_completed"]				= "Es scheint als h�tten Sie die Anfrage bereits best�tigt. Es sind deshalb keine weiteren Aktionen notwendig. Danke.";
$language_pack["error_confirm_unable_request"]			= "Wir entschuldigen uns f�r diese Unannehmlichkeiten. Wie auch immer, leider ist es uns zurzeit nicht m�glich Ihre Anfrage auszuf�hren. Bitte kontaktieren Sie den Webseiten-Administrator und informieren Sie ihn �ber dieses Problem.";
$language_pack["error_confirm_unable_find_info"]		= "Wir entschuldigen uns f�r diese Unannehmlichkeiten. Wir k�nnen keinen g�ltigen Eintrag Ihrer eMail Adresse bez�glich dieses Mailverteilers in unserer Datenbank finden. Bitte kontaktieren Sie den Webseiten-Administrator und informieren Sie ihn �ber dieses Problem.";
$language_pack["page_confirm_title"]					= "Mailverteiler-Eintragsbest�tigung";
$language_pack["page_confirm_message_sentence"]			= "Bitte �berpr�fen Sie die folgenden Informationen bevor Sie den Best�tigungs-Button anklicken.";
$language_pack["page_confirm_firstname"]				= "Vorname:";
$language_pack["page_confirm_lastname"]					= "Nachname:";
$language_pack["page_confirm_email_address"]			= "eMail Adresse:";
$language_pack["page_confirm_group_info"]				= "Verteilergruppe:";
$language_pack["page_confirm_cancel_button"]			= "Abbruch";
$language_pack["page_confirm_submit_button"]			= "Best�tigung";

$language_pack["page_unsubscribe_title"]				= "Mailverteilerlistenbest�tigung";
$language_pack["page_unsubscribe_message_sentence"]		= "Bitte w�hlen Sie die Liste oder Listen aus der/denen Sie sich austragen m�chten:";
$language_pack["page_unsubscribe_list_groups"]			= "[email] von [groupname].";	// Requires [email] and [groupname] variable in sentence.
$language_pack["page_unsubscribe_cancel_button"]		= "Abbruch";
$language_pack["page_unsubscribe_submit_button"]		= "Austragen";

$language_pack["page_help_title"]						= "Mailverteilerliste Hilfefunktion";
$language_pack["page_help_message_sentence"]			= "Willkommen zur Mailverteiler-Hilfe. Diese Filefunktion versucht einige Basisfragen, die bei Ihnen als Nutzer vielleicht auftreten, zu kl�ren. Sollten Sie Fragen haben die hier nicht erkl�rt werden, kontaktieren Sie bitte den Administrator unter folgenden eMail-Adresse: [abuse_address]";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_subtitle"]					= "Allgemeine Fragen:";
$language_pack["page_help_question_1"]					= "Wie kann ich diesen Mailverteiler abonnieren?";
$language_pack["page_help_answer_1_optin"]				= "Unser Mailverteiler verlangt vom Anmelder eine doppelte Best�tigung bevor er endg�ltig in unserer Verteilerleiste eingetragen ist. Das geschieht aus dem Grund, da Sie oder jemand anderes Ihre eMail Adresse zu unserem Mailverteiler hinzugef�gt hat. Damit Missbrauch mit Ihrer eMail-Adresse vermieden werden kann, schicken wir an die neu eingetragene eMail-Adresse eine Best�tigungs-eMail, die Sie dann �ber den dort angegebenen Link best�tigen m�ssen. Sollten Sie trotzdem ohne Best�tigungs-eMail unseren Newsletter erhalten, kann das daran liegen, dass der Administrator Sie manuell in die Verteilerliste aufgenommen hat. Details �ber diese Transaktion k�nnen Sie direkt beim Administrator erfahren. Nutzen Sie dazu bitte diese eMail [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_answer_1_no_optin"]			= "Unser Mailverteiler verlangt vom Anwender keine doppelte Best�tigung bevor er in eine Mailverteilungsliste von uns aufgenommen wird. Das bedeutet, dass Sie oder irgendjemand Ihre eMail Adresse in unser Verteilsystem eingegeben hat und Sie nicht aufgefordert wurden diese Eingabe zu best�tigen. Details �ber diese Transaktion k�nnen Sie direkt beim Administrator erfahren. Nutzen Sie dazu bitte diese eMail [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_2"]					= "Wie trage ich mich selbst aus der Mailverteilerliste aus?";
$language_pack["page_help_answer_2_optout"]				= "Sollten Sie sich selbst aus einer oder mehreren Mailverteilerlisten austragen wollen, f�llen Sie bitte das folgende Formular aus. Nachdem Sie Ihre eMail Adresse angegeben und die Liste bzw. Listen ausgew�hlt haben, aus der bzw. denen Sie ausgetragen werden m�chten, m�ssen Sie Ihren Austrag in der erhaltenen eMail mittels Klick auf den Best�tigungs-Link best�tigen.";
$language_pack["page_help_answer_2_no_optout"]			= "Sollten Sie sich selbst aus einer oder mehreren Mailverteilerlisten austragen wollen, f�llen Sie bitte das folgende Formular aus. Nachdem Sie Ihre eMail Adresse angegeben haben und die Liste bzw. Listen ausgew�hlt haben, aus der bzw. denen Sie ausgetragen werden m�chten, wird Ihre eMail Adresse unmittelbar aus unserer Datenbank entfernt.";
$language_pack["page_help_question_3"]					= "Was bedeutet diese eMail, die ich erhalten habe?";
$language_pack["page_help_answer_3"]					= "Diese Mailverteiler-Hilfe ist leider nicht in der Lage den Inhalt der eMail, die Sie erhalten haben, zu erkl�ren. Es ist also davon auszugehen, dass die eMail, die Sie erhielten, von unserem Newslettersystem stammt. Sollten Sie aber davon �berzeugt sein, dass Sie diese eMail aufgrund eines Irrtums erhalten haben, informieren Sie bitte den Administrator unter [abuse_address] �ber diesen Irrtum.";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_4"]					= "How do I update my personal details for this mailing list?";
$language_pack["page_help_answer_4"]					= "You can update your personal details by visiting the <a href=\"[URL]\">Update User Profile</a> page."; // Requires [URL] variable.

$language_pack["page_archive_closed_title"]				= "Mailverteilerarchiv geschlossen";
$language_pack["page_archive_closed_message_sentence"]	= "Unser Mailverteilerarchiv ist f�r die �ffentlichkeit zur Zeit geschlossen. Sollten Sie eine bereits gesendete Mail oder weitere Hilfe ben�tigen, wenden Sie sich bitte an den Administrator unter [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_archive_opened_title"]				= "�ffentliches Mailverteilerarchiv";
$language_pack["page_archive_opened_message_sentence"]	= "Welcome to our public mailing list archive. Here you can view our collection of e-mail newsletters that have previously been sent to our subscriber base. As a matter of convenience you can also subscribe to our [rssfeed_url]."; // Requires [rssfeed_url] in sentence.
$language_pack["page_archive_view_title"]				= "�ffentliches Mailverteilerarchiv - Nachricht lesen";
$language_pack["page_archive_error_html_title"]			= "Fehler in der Darstellung einer HTML Nachricht";
$language_pack["page_archive_error_no_message"]			= "Die angeforderte Nachricht konnte in unserer Verteilerliste nicht gefunden werden. Bitte kehren Sie zum Archiv zur�ck.";
$language_pack["page_archive_error_no_messages"]		= "Zur Zeit gibt es keine Nachrichten, die Sie im Archiv betrachten k�nnten. Versuchen Sie es sp�ter bitte noch einmal.";
$language_pack["page_archive_view_from"]				= "Von:";
$language_pack["page_archive_view_subject"]				= "Betreff:";
$language_pack["page_archive_view_date"]				= "Datum:";
$language_pack["page_archive_view_to"]					= "F�r:";
$language_pack["page_archive_view_attachments"]			= "Anh�nge:";
$language_pack["page_archive_view_missing_attachment"]	= "Anhang ist nicht l�nger verf�gbar";
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
Diese eMail wurde an [email] versandt, da Sie in einer oder mehreren Mailverteilerlisten eingetragen sind. Sollten Sie sich selbst von dieser oder diesen Verteilerlisten streichen wollen, k�nnen Sie dies jederzeit indem Sie folgenden Internet Link anklicken:
[unsubscribe_url]
UNSUBSCRIBEMSG;

$language_pack["subscribe_confirmation_subject"]		= "Best�tigung f�r die Aufnahme in unserer Mailverteilerliste";
$language_pack["subscribe_confirmation_message"]		= <<<SUBSCRIBEEMAIL
Hallo [name]
Jemand (Sie selbst oder unser Administrator) hat angefragt, dass Ihre eMail Adresse zu einer oder mehreren Mailverteilerlisten hinzugef�gt werden soll.


Ihnen wurde diese eMail zugeschickt, damit Sie die Eintragung in unsere Mailverteilerliste best�tigen. Klicken Sie dazu bitte auf folgenden Internet Link:
[url]

Sollten Sie diesen Wunsch nicht ge�u�ert haben, dann ignorieren Sie bitte diese eMail und klicken auch nicht auf den oben genannten Internet Link. Sollten Sie weiterhin nicht angeforderte eMails dieser Art von uns erhalten, dann bitten wir Sie, diesen Missbrauch an folgende eMail Adresse zu melden: [abuse_address]

Mit freundlichen Gr��en,
[from]
SUBSCRIBEEMAIL;

$language_pack["unsubscribe_confirmation_subject"]	= "Best�tigung der L�schung aus unserer Mailverteilerliste";
$language_pack["unsubscribe_confirmation_message"]	= <<<UNSUBSCRIBEEMAIL
Jemand (Sie selbst oder unser Administrator) hat angefragt, das Ihre eMail Adresse von einer oder mehreren Mailverteilerlisten entfernt werden soll.

Ihnen wurde diese eMail zugeschickt, damit Sie die Austragung aus unserer Mailverteilerliste best�tigen. Klicken Sie dazu bitte auf folgenden Internet Link:
[url]

Sollten Sie diesen Wunsch nicht ge�u�ert haben, dann ignorieren Sie bitte diese eMail und klicken auch nicht auf den oben genannten Internet Link. Sollten Sie weiterhin nicht angeforderte eMails dieser Art von uns erhalten, dann bitten wir Sie, diesen Missbrauch an folgende eMail Adresse zu melden: [abuse_address]

Mit freundlichen Gr��en,
[from]
UNSUBSCRIBEEMAIL;

$language_pack["subscribe_notification_subject"]		= "[ListMessenger Nachricht] Neuer Abonnent";
$language_pack["subscribe_notification_message"]		= <<<SUBSCRIBENOTICEEMAIL
Diese eMail soll Sie dar�ber informieren, dass sich ein neuer Abonnent in eine oder mehrere ListMessenger Mailverteilerlisten eingetragen hat.

Daten des neuen Abonnenten:
Full Name:\t[firstname] [lastname]
eMail Addresse:\t[email_address]
Eingetragen in:
[group_ids]

-------------------------------------------------------------------
Sie haben diese Benachrichtigung bekommen, da die Benachrichtigungfunktion Neuer Abonnent im ListMessenger Control Panel aktiviert ist. Sollten Sie diesen Service nicht w�nschen, loggen Sie sich bitte einfach in ListMessenger ein. Klicken Sie dann auf den Men�punkt Control Panel / End-User Preferences und setzen Sie die Funktion New Subscriber Notification auf inaktive (disable).
SUBSCRIBENOTICEEMAIL;

$language_pack["unsubscribe_notification_subject"]	= "[ListMessenger Nachricht] Abonnent gel�scht";
$language_pack["unsubscribe_notification_message"]	= <<<UNSUBSCRIBENOTICEEMAIL
Diese eMail soll Sie dar�ber informieren, dass sich ein Abonnent in einer oder mehreren ListMessenger Mailverteilerlisten ausgetragen hat.

Daten des gel�schten Abonnenten:
Full Name:\t[firstname] [lastname]
eMail Addresse:\t[email_address]
Gel�scht aus folgenden Gruppen:
[group_ids]

-------------------------------------------------------------------
Sie haben diese Benachrichtigung bekommen, da die Benachrichtigungfunktion Abonnent gel�scht im ListMessenger Control Panel aktiviert ist. Sollten Sie diesen Service nicht w�nschen, loggen Sie sich bitte einfach in ListMessenger ein. Klicken Sie dann auf den Men�punkt Control Panel / End-User Preferences und setzen Sie die Funktion Unsubscribe Notification auf inaktive (disable).
UNSUBSCRIBENOTICEEMAIL;
?>
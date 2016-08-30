<?php
/*
<language name="English" version="2.1.0">
	<translator_name>Matt Simpson</translator_name>
	<translator_email>msimpson@listmessenger.com</translator_email>
	<translator_url>http://www.listmessenger.com/index.php/languages</translator_url>
	<updated>19:48 10-13-2004</updated>
	<notes>Default Language File</notes>
</language>
*/
$language_pack = array();

$language_pack["default_page_title"]					= "ListMessenger Mailing List Management System";
$language_pack["default_page_message"]					= "Please visit our main website to subscribe to or be removed from one more more of our mailing lists.";
$language_pack["error_default_title"]					= "Error In Your Request";
$language_pack["error_invalid_action"]					= "The requested action is invalid, please ensure you access this system correctly through a subscription form provided by our website. If you require further assistance, please contact the website administrator.";

$language_pack["error_subscribe_no_groups"]				= "You must select at least one mailing list to subscribe to. If you require further assistance, please contact the website administrator.";
$language_pack["error_subscribe_group_not_found"]		= "A mailing list that you were trying to subscribe to no longer exists in this system. If you require further assistance, please contact the website administrator.";
$language_pack["error_subscribe_email_exists"]			= "The e-mail address you have provided already exists in the mailing list(s) you have selected to subscribe to. If you require further assistance, please contact the website administrator.";
$language_pack["error_subscribe_no_email"]				= "Please enter an e-mail address that you would like subscribed to our mailing list.";
$language_pack["error_subscribe_invalid_email"]			= "The e-mail address that you have provided is not recognized as a valid e-mail address.";
$language_pack["error_subscribe_banned_email"]			= "The e-mail address that you have provided is prohibited from subscribing to this system at this time.";
$language_pack["error_subscribe_banned_domain"]			= "The domain name of the e-mail address that you have provided is prohibited from subscribing to this system.";
$language_pack["error_subscribe_invalid_domain"]		= "The domain name of the e-mail address that you have provided does not appear to be a valid e-mail domain name.";
$language_pack["error_subscribe_required_cfield"]		= "&quot;[cfield_name]&quot; is a required custom field. Please go back and enter this information.";	// Requires [cfield_name] variable in sentence.
$language_pack["error_subscribe_failed_optin"]			= "We were unfortunately unable to send you a mailing list confirmation e-mail. Please contact the website administrator and inform them of this problem.";
$language_pack["error_subscribe_failed"]				= "We were unfortunately unable to subscribe your e-mail address to our mailing list. Please contact the website administrator and inform them of this problem.";
$language_pack["success_subscribe_optin_title"]			= "Opt-in Confirmation Message Sent";
$language_pack["success_subscribe_optin_message"]		= "Thank-you for your interest in our mailing list. You will receive a mailing list confirmation notice shortly, please confirm your subscription by following the confirmation link included in that e-mail.";
$language_pack["success_subscribe_title"]				= "Successful Mailing List Subscription";
$language_pack["success_subscribe_message"]				= "Thank-you for your interest in our mailing list. Your e-mail address has been successfully added to our mailing list and you will receive all future messages to the address you have provided.";

$language_pack["error_unsubscribe_no_groups"]			= "You must select at least one mailing list to unsubscribe from. If you require further assistance, please contact the website administrator.";
$language_pack["error_unsubscribe_group_not_found"]		= "A mailing list that you were trying to unsubscribe from no longer exists in this system. If you require further assistance, please contact the website administrator.";
$language_pack["error_unsubscribe_email_not_found"]		= "The e-mail address you have provided does not exist in our database. If you require further assistance, please contact the website administrator.";
$language_pack["error_unsubscribe_email_not_exists"]	= "The e-mail address you have provided does not exist in the mailing list you are requesting to be removed from. If you require further assistance, please contact the website administrator.";
$language_pack["error_unsubscribe_no_email"]			= "Please provide your e-mail address so we're able to unsubscribe you from our mailing list system.";
$language_pack["error_unsubscribe_invalid_email"]		= "The e-mail address that you have provided is not recognized as a valid e-mail address.";
$language_pack["error_unsubscribe_failed_optout"]		= "We were unfortunately unable to send you an opt-out confirmation e-mail due to a problem that we are currently experiencing. Please contact the website administrator and let the know you are having difficulty while trying to unsubscribing.";
$language_pack["error_update_profile"]					= "We were unfortunately unable to send you an update profile confirmation notice due to a problem that we are currently experiencing. Please contact the website administrator and let the know you are having difficulty while trying to update your profile.";
$language_pack["success_unsubscribe_optout_title"]		= "Opt-out Confirmation Message Sent";
$language_pack["success_unsubscribe_optout_message"]	= "We're sorry to see you leaving our mailing list. To complete the opt-out process, please follow the link that resides in the removal confirmation e-mail we have sent to your address.";
$language_pack["success_unsubscribe_title"]				= "Successful Mailing List Removal";
$language_pack["success_unsubscribe_message"]			= "We're sorry to see you leaving our mailing list. Your e-mail address has successfully been removed from the selected mailing list(s), but if at any time to wish to subscribe again you can do so by visiting our website.";

$language_pack["error_invalid_captcha"]					= "The security code you entered was not correct, please go back and re-enter the text that appears in the security image.";
$language_pack["error_expired_code"]					= "This confirmation code has expired after 7 days. To update your profile, please request a new confirmation code.";
$language_pack["error_confirm_invalid_request"]			= "We were unable to locate a valid confirmation information in your request. If you clicked a link from a confirmation e-mail that you received, you might try copying and pasting the link as it may span multiple lines.";
$language_pack["error_confirm_completed"]				= "It appears as though you have already confirmed this request. No further action is required, thank-you.";
$language_pack["error_confirm_unable_request"]			= "We apologize for the inconvenience; however, we were unable to process your request at this time. Please contact the website administrator and inform them of this problem.";
$language_pack["error_confirm_unable_find_info"]		= "We apologize for the inconvenience; however, we cannot find any valid mailing list information for your e-mail address in our database. Please contact the website administrator and inform them of this problem.";
$language_pack["page_confirm_title"]					= "Confirmation Required";
$language_pack["page_confirm_message_sentence"]			= "Please confirm the following information prior to clicking the confirm button.";
$language_pack["page_confirm_firstname"]				= "Firstname:";
$language_pack["page_confirm_lastname"]					= "Lastname:";
$language_pack["page_confirm_email_address"]			= "E-Mail Address:";
$language_pack["page_confirm_group_info"]				= "Group Information:";
$language_pack["page_confirm_cancel_button"]			= "Cancel";
$language_pack["page_confirm_submit_button"]			= "Confirm";

$language_pack["page_unsubscribe_title"]				= "Mailing List Unsubscribe Confirmation";
$language_pack["page_unsubscribe_message_sentence"]		= "Please select the mailing list or lists you wish to unsubscribe from:";
$language_pack["page_unsubscribe_list_groups"]			= "[email] from [groupname].";	// Requires [email] and [groupname] variable in sentence.
$language_pack["page_unsubscribe_cancel_button"]		= "Cancel";
$language_pack["page_unsubscribe_submit_button"]		= "Unsubscribe";

$language_pack["page_help_title"]						= "Mailing List Help Information";
$language_pack["page_help_message_sentence"]			= "Welcome to the mailing list help file. This help file will attempt to answer some basic questions that you as a subscriber may have about this mailing list. If you have a question that is not answered by this help file, please contact an administrator at [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_subtitle"]					= "Common Questions:";
$language_pack["page_help_question_1"]					= "How did I get subscribed to this mailing list?";
$language_pack["page_help_answer_1_optin"]				= "Our mailing list application currently requires subscribers to double opt-in before they are subscribed to any of our mailing lists. This means that you or someone using your e-mail address has requested to be added to our mailing list, at which time our system sent a confirmation e-mail that was confirmed. If you did not confirm the subscription confirmation yourself, it is possible that our mailing list administrator has added your e-mail address to our system manually. Details about this transaction may be available upon request by e-mailing an administrator at [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_answer_1_no_optin"]			= "Our mailing list application currently does not require subscribers to double opt-in prior to being subscribed to any of our mailing lists. This means that you or someone using your e-mail address has entered your e-mail address into our system and you were not required to confirm your subscription. Details about this transaction may be available upon request by e-mailing an administrator at [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_2"]					= "How do I remove myself from this mailing list?";
$language_pack["page_help_answer_2_optout"]				= "If you would like to remove yourself from one or more of our mailing lists, you are free to do so by completing the following form. Once you have entered your e-mail address and selected which mailing list or lists you wish to be removed from, you will be required to confirm your opt-out request by following the hyperlink in an e-mail that you will receive.";
$language_pack["page_help_answer_2_no_optout"]			= "If you would like to remove yourself from one or more of our mailing lists, you are free to do so by completing the following form. Once you have entered your e-mail address and selected which mailing list or lists you wish to be removed from, you will be immediately be removed from our system.";
$language_pack["page_help_question_3"]					= "What is this e-mail that I received?";
$language_pack["page_help_answer_3"]					= "This mailing list help file is not able to determine the content of the message you have received; however, if you have ended up at this page then it is likely that the message you received was sent using our mailing list management software. If you believe you have received  a message in error, please contact an administrator at [abuse_address] and inform them of your situation.";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_4"]					= "How do I update my personal details for this mailing list?";
$language_pack["page_help_answer_4"]					= "You can update your personal details by visiting the <a href=\"[URL]\">Update User Profile</a> page."; // Requires [URL] variable.

$language_pack["page_archive_closed_title"]				= "Mailing List Archive Closed";
$language_pack["page_archive_closed_message_sentence"]	= "Our mailing list archive is currently closed to the public. If you require a previous mailing or require assistance, please contact an administrator at [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_archive_opened_title"]				= "Public Mailing List Archive";
$language_pack["page_archive_opened_message_sentence"]	= "Welcome to our public mailing list archive. Here you can view our collection of e-mail newsletters that have previously been sent to our subscriber base. As a matter of convenience you can also subscribe to our [rssfeed_url]."; // Requires [rssfeed_url] in sentence.
$language_pack["page_archive_view_title"]				= "Public Mailing List Archive - Viewing Message";
$language_pack["page_archive_error_html_title"]			= "Error Displaying HTML Message Content";
$language_pack["page_archive_error_no_message"]			= "The requested message could not be found in our mailing list. Please return to the archive.";
$language_pack["page_archive_error_no_messages"]		= "There are currently no messages to view in the archive; please try again later.";
$language_pack["page_archive_view_from"]				= "From:";
$language_pack["page_archive_view_subject"]				= "Subject:";
$language_pack["page_archive_view_date"]				= "Date:";
$language_pack["page_archive_view_to"]					= "To:";
$language_pack["page_archive_view_attachments"]			= "Attachments:";
$language_pack["page_archive_view_missing_attachment"]	= "Attachment is no longer available";
$language_pack["page_archive_view_message_from"]		= "Message From";
$language_pack["page_archive_view_message_subject"]		= "Message Subject";
$language_pack["page_archive_view_message_sent"]		= "Date Sent";
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

$language_pack["unsubscribe_message"]				= <<<UNSUBSCRIBEMSG
-------------------------------------------------------------------
This e-mail was sent to [email] because you are subscribed to at least one of our mailing lists. If at any time you would like to remove yourself from our mailing list, please feel free to do so by visiting:
[unsubscribe_url]
UNSUBSCRIBEMSG;

$language_pack["subscribe_confirmation_subject"]		= "Mailing List Subscription Confirmation Notice";
$language_pack["subscribe_confirmation_message"]		= <<<SUBSCRIBEEMAIL
Hello [name]
Someone (either yourself or the list administrator) has requested that your e-mail address be included on one or more of our mailing lists.

This e-mail is being sent to confirm that you wish to be subscribed to the list. If you would like to opt-in, please follow the link below:
[url]

If you did not request to be included on any mailing list, please ignore this e-mail and do not follow the above link. If requests persist, you may wish to notify our abuse account at [abuse_address].

Sincerely,
[from]
SUBSCRIBEEMAIL;

$language_pack["unsubscribe_confirmation_subject"]	= "Mailing List Removal Confirmation Notice";
$language_pack["unsubscribe_confirmation_message"]	= <<<UNSUBSCRIBEEMAIL
Someone (either yourself or the list administrator) has requested that your e-mail address be removed from one or more of our mailing lists.

This e-mail is being sent to confirm that you wish to be removed from our system. If you would like to opt-out, please follow the link below:
[url]

If you did not request to be removed from our mailing lists, please ignore this e-mail and do not follow the above link. If requests persist, you may wish to notify our abuse account at [abuse_address].

Sincerely,
[from]
UNSUBSCRIBEEMAIL;

$language_pack["subscribe_notification_subject"]		= "[ListMessenger Notice] New Subscriber";
$language_pack["subscribe_notification_message"]		= <<<SUBSCRIBENOTICEEMAIL
This is an e-mail to inform you that a new subscriber has joined one or more of your ListMessenger mailing lists.

Basic New Subscriber Details:
Full Name:\t[firstname] [lastname]
E-Mail Address:\t[email_address]
Subscribed to:
[group_ids]

-------------------------------------------------------------------
You are receiving this notification because the New Subscriber Notification is enabled in the ListMessenger Control Panel. If you wish to disable notifications, simply log into ListMessenger, click Control Panel, End-User Preferences and set New Subscriber Notification to Disabled.
SUBSCRIBENOTICEEMAIL;

$language_pack["unsubscribe_notification_subject"]	= "[ListMessenger Notice] Unsubscribed User";
$language_pack["unsubscribe_notification_message"]	= <<<UNSUBSCRIBENOTICEEMAIL
This is an e-mail to inform you that the following individual has unsubscribed from one or more of your ListMessenger mailing lists.

Unsubscribed User Details:
Full Name:\t[firstname] [lastname]
E-Mail Address:\t[email_address]
Unsubscribed from:
[group_ids]

-------------------------------------------------------------------
You are receiving this notification because the Unsubscribe Notification is enabled in the ListMessenger Control Panel. If you wish to disable notifications, simply log into ListMessenger, click Control Panel, End-User Preferences and set Unsubscribe Notification to Disabled.
UNSUBSCRIBENOTICEEMAIL;
?>
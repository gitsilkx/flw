<?php
/*
<language name="Spanish" version="2.1.0">
	<translator_name>Nicolas Cohen</translator_name>
	<translator_email>nicolas@bananafilms.com</translator_email>
	<translator_url>http://www.listmessenger.com/index.php/languages</translator_url>
	<updated>19:48 10-13-2004</updated>
	<notes>Spanish Language File</notes>
</language>
*/
$language_pack = array();

$language_pack["default_page_title"]					= "Sistema de Administracion de Listas de Correo ListMessenger";
$language_pack["default_page_message"]					= "Por favor visite nuestro sitio web para suscribirse o desuscribirse de una o varias de nuestras listas de correo.";
$language_pack["error_default_title"]					= "Error en su solicitud";
$language_pack["error_invalid_action"]					= "La accion solicitada es invalida, por favor corrobore que ha accedido a este sistema correctamente a traves de un formulario de suscripcion provisto por nuestro sitio web. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";

$language_pack["error_subscribe_no_groups"]				= "Usted debe seleccionar al menos una lista de correo a la cual suscribirse. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_subscribe_group_not_found"]		= "Una lista de correo a la que intentaba suscribirse no existe mas en el sistema. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_subscribe_email_exists"]			= "La direccion de correo ingresada ya esta suscripta a la(s) lista(s) de correo que usted selecciono. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_subscribe_no_email"]				= "Por favor ingrese una direccion de correo que usted desee suscribir a nuestra lista de correo.";
$language_pack["error_subscribe_invalid_email"]			= "La direccion de correo ingresada no es una direccion de correo valida.";
$language_pack["error_subscribe_banned_email"]			= "La direccion de correo ingresada esta prohibida en el sistema en este momento.";
$language_pack["error_subscribe_banned_domain"]			= "El dominio de la direccion de correo ingresada esta prohibido en el sistema en este momento.";
$language_pack["error_subscribe_invalid_domain"]		= "El dominio de la direccion de correo ingresada parece no ser un dominio de correo valido.";
$language_pack["error_subscribe_required_cfield"]		= "&quot;[cfield_name]&quot; es un campo requerido. Por favor vuelva e ingrese la informacion.";	// Requires [cfield_name] variable in sentence.
$language_pack["error_subscribe_failed_optin"]			= "Desafortunadamente no hemos podido enviar el mensaje de confirmacion de la lista de correo. Por favor contacte al administrador del sitio web e informele sobre el problema.";
$language_pack["error_subscribe_failed"]				= "Desafortunadamente no hemos podido suscribir su direccion a nuestra lista de correo. Por favor contacte al administrador del sitio web e informele sobre el problema.";
$language_pack["success_subscribe_optin_title"]			= "Mensaje de confirmacion enviado";
$language_pack["success_subscribe_optin_message"]		= "Gracias por su interes en nuestra lista de correo. Recibira un mensaje de confirmacion en breve, por favor confirme su suscripcion siguiendo el link de confirmacion incluido en el mensaje.";
$language_pack["success_subscribe_title"]				= "Suscripcion a la lista de correo exitosa.";
$language_pack["success_subscribe_message"]				= "Gracias por su interes en nuestra lista de correo. Su direccion de correo ha sido agregada exitosamente a nuestra lista de correo y recibira todos los nuevos mensajes en la direccion de correo ingresada.";

$language_pack["error_unsubscribe_no_groups"]			= "Usted debe seleccionar al menos una lista de correo de la cual desuscribirse. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_unsubscribe_group_not_found"]		= "Una lista de correo de la que intentaba suscribirse no existe mas en el sistema. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_unsubscribe_email_not_found"]		= "La direccion de correo ingresada no existe en nuestra base de datos. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_unsubscribe_email_not_exists"]	= "La direccion de correo ingresada no esta suscripta a la(s) lista(s) de correo que usted selecciono. Si necesita mas asistencia, por favor contacte al administrador del sitio web.";
$language_pack["error_unsubscribe_no_email"]			= "Por favor ingrese una direccion de correo para que podamos desuscribirlo de nuestra lista de correo.";
$language_pack["error_unsubscribe_invalid_email"]		= "La direccion de correo ingresada no es una direccion de correo valida.";
$language_pack["error_unsubscribe_failed_optout"]		= "Desafortunadamente no hemos podido enviar el mensaje de confirmacion de la lista de correo. Por favor contacte al administrador del sitio web e informele que tiene problemas al desuscribirse.";
$language_pack["error_update_profile"]					= "We were unfortunately unable to send you an update profile confirmation notice due to a problem that we are currently experiencing. Please contact the website administrator and let the know you are having difficulty while trying to update your profile.";
$language_pack["success_unsubscribe_optout_title"]		= "Mensaje de confirmacion enviado";
$language_pack["success_unsubscribe_optout_message"]	= "Lamentamos que deje la lista. Para completar el proceso de desuscripcion, por favor confirme su desuscripcion siguiendo el link incluido en el mensaje de confirmacion.";
$language_pack["success_unsubscribe_title"]				= "Desuscripcion de la lista exitosa";
$language_pack["success_unsubscribe_message"]			= "Lamentamos que deje la lista. Su direccion de correo ha sido eliminada de nuestra lista de correo. Si desea volver a suscribirse, visite nuestro sitio web.";

$language_pack["error_invalid_captcha"]					= "The security code you entered was not correct, please go back and re-enter the text that appears in the security image.";
$language_pack["error_expired_code"]					= "This confirmation code has expired after 7 days. To update your profile, please request a new confirmation code.";
$language_pack["error_confirm_invalid_request"]			= "No hemos podido encontrar informacion de confirmacion valida en su solicitud. Si clickeo el link de un mensaje de confirmacion que recibio, pruebe copiando y pegando el link en su navegador ya que podria prolongarse por multiples lineas.";
$language_pack["error_confirm_completed"]				= "Parece que usted ya confirmo esta solicitud. No se requieren acciones futuras, gracias.";
$language_pack["error_confirm_unable_request"]			= "Disculpe por el inconveniente, no podemos procesar su solicitud en este momento. Por favor contacte al administrador del sitio web e informele sobre el problema.";
$language_pack["error_confirm_unable_find_info"]		= "Disculpe por el inconveniente, no podemos encontrar informacion valida para su direccion de correo en nuestra base de datos. Por favor contacte al administrador del sitio web e informele sobre el problema.";
$language_pack["page_confirm_title"]					= "Confirmacion de Suscripcion a la Lista de Correo";
$language_pack["page_confirm_message_sentence"]			= "Por favor confirme la siguiente informacion antes de presionar el boton de confirmacion.";
$language_pack["page_confirm_firstname"]				= "Nombre:";
$language_pack["page_confirm_lastname"]					= "Apellido:";
$language_pack["page_confirm_email_address"]			= "Direccion de Correo:";
$language_pack["page_confirm_group_info"]				= "Informacion de Grupo:";
$language_pack["page_confirm_cancel_button"]			= "Cancelar";
$language_pack["page_confirm_submit_button"]			= "Confirmar";

$language_pack["page_unsubscribe_title"]				= "Confirmacion de Desuscripcion a la Lista de Correo";
$language_pack["page_unsubscribe_message_sentence"]		= "Por favor elija la(s) lista(s) de correo de la(s) que desea desuscribirse:";
$language_pack["page_unsubscribe_list_groups"]			= "[email] de [groupname].";	// Requires [email] and [groupname] variable in sentence.
$language_pack["page_unsubscribe_cancel_button"]		= "Cancelar";
$language_pack["page_unsubscribe_submit_button"]		= "Desuscribir";

$language_pack["page_help_title"]						= "Ayuda de la Lista de Correo";
$language_pack["page_help_message_sentence"]			= "Bienvenido al archivo de ayuda de la lista de correo. Este archivo de ayuda intentara responder algunas preguntas basicas que usted, como suscriptor, pueda tener sobre esta lista de correo. Si usted tiene una pregunta que no ha sido contestada en este archivo de ayuda, por favor contacte al administrador en [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_subtitle"]					= "Preguntas Comunes:";
$language_pack["page_help_question_1"]					= "¿Como me suscribo a esta lista de correo?";
$language_pack["page_help_answer_1_optin"]				= "Nuestra aplicacion de listas de correo requiere una segunda confirmacion previa a la suscripcion a alguna de las listas. Esto quiere decir que usted o alguien usando su direccion de correo ha solicitado suscripcion a nuestra lista de correo, y nuestro sistema envio un mensaje de confirmacion que fue confirmado. Si usted no confirmo el mensaje de confirmacion, es posible que el administrador de nuestra lista de correo lo haya agregado manualmente a la lista. Detalles sobre esta transaccion pueden ser solicitados a [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_answer_1_no_optin"]			= "Nuestra aplicacion de listas de correo no requiere una segunda confirmacion previa a la suscripcion a alguna de las listas. Esto quiere decir que usted o alguien usando su direccion de correo ha solicitado suscripcion a nuestra lista de correo, y no se solicito confirmacion de su parte. Detalles sobre esta transaccion pueden ser solicitados a [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_2"]					= "¿Como me desuscribo de esta lista de correo?";
$language_pack["page_help_answer_2_optout"]				= "Si usted desea desuscribirse de alguna de nuestras listas, es libre de hacerlo completando el siguiente formulario. Una vez ingresada su direccion de correo y que seleccione de cual lista desea desuscribirse, se le solicitara confirmacion de su desuscripcion siguiendo el link incluido en un mensaje que recibira.";
$language_pack["page_help_answer_2_no_optout"]			= "Si usted desea desuscribirse de alguna de nuestras listas, es libre de hacerlo completando el siguiente formulario. Una vez ingresada su direccion de correo y que seleccione de cual lista desea desuscribirse, se desuscribira inmediatamente de la(s) lista(s) seleccionada(s).";
$language_pack["page_help_question_3"]					= "¿Que es este mensaje que recibi?";
$language_pack["page_help_answer_3"]					= "El archivo de ayuda de esta lista de correo no puede determinar el contenido del mensaje que recibio; sin embargo, si usted llego a esta pagina es probable que el mensaje que recibio haya sido enviado usando nuestra aplicacion de listas de correo. Si cree que recibio un mensaje por error, por favor contacte al administrador en [abuse_address] e informe su situacion.";	// Requires [abuse_address] variable in sentence.
$language_pack["page_help_question_4"]					= "How do I update my personal details for this mailing list?";
$language_pack["page_help_answer_4"]					= "You can update your personal details by visiting the <a href=\"[URL]\">Update User Profile</a> page."; // Requires [URL] variable.

$language_pack["page_archive_closed_title"]				= "Archivo de Lista de Correo Cerrado";
$language_pack["page_archive_closed_message_sentence"]	= "Nuestro archivo de lista de correo esta cerrado al publico. Si solicita un envio anterior o necesita asistencia, por favor contacte un administrador en [abuse_address].";	// Requires [abuse_address] variable in sentence.
$language_pack["page_archive_opened_title"]				= "Archivo Publico de Lista de Correo";
$language_pack["page_archive_opened_message_sentence"]	= "Welcome to our public mailing list archive. Here you can view our collection of e-mail newsletters that have previously been sent to our subscriber base. As a matter of convenience you can also subscribe to our [rssfeed_url]."; // Requires [rssfeed_url] in sentence.
$language_pack["page_archive_view_title"]				= "Archivo Publico de Lista de Correo - Viendo Mensaje";
$language_pack["page_archive_error_html_title"]			= "Error mostrando el contenido HTML del mensaje";
$language_pack["page_archive_error_no_message"]			= "El mensaje solicitado no pudo ser encontrad en nuestra lista de correo. Por favor regrese al archivo.";
$language_pack["page_archive_error_no_messages"]		= "En este momento no hay mensajes para ver; por favor intente mas tarde.";
$language_pack["page_archive_view_from"]				= "De:";
$language_pack["page_archive_view_subject"]				= "Asunto:";
$language_pack["page_archive_view_date"]				= "Fecha:";
$language_pack["page_archive_view_to"]					= "Para:";
$language_pack["page_archive_view_attachments"]			= "Archivo Adjunto:";
$language_pack["page_archive_view_missing_attachment"]	= "Archivo adjunto no disponible";
$language_pack["page_archive_view_message_from"]		= "Mensaje de";
$language_pack["page_archive_view_message_subject"]		= "Asunto del  mensaje";
$language_pack["page_archive_view_message_sent"]		= "Fecha de envio";
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
Usted recibe este mensaje a [email] por que esta suscripto a alguna de nuestras listas. Si desea desuscribirse, puede hacerlo siguiendo este link:
[unsubscribe_url]
UNSUBSCRIBEMSG;

$language_pack["subscribe_confirmation_subject"]		= "Mensaje de Confirmacion de Suscripcion a la Lista de Correo";
$language_pack["subscribe_confirmation_message"]		= <<<SUBSCRIBEEMAIL
Hola [name]
Alguien (tal vez usted, o el administrador de la lista) ha solicitado que su direccion de correo sea incluida en nuestra lista.

Este mensaje se envia para confirmar que usted desea suscribirse a la lista. Para confirmar su suscripcion:
[url]

Si usted no solicito suscripcion en ninguna lista, por favor ignore este mensaje y no siga el link. Si las solicitudes persisten, quizas desee notificar el abuso en [abuse_address].

Saludos,
[from]
SUBSCRIBEEMAIL;

$language_pack["unsubscribe_confirmation_subject"]	= "Mensaje de Confirmacion de Desuscripcion a la Lista de Correo";
$language_pack["unsubscribe_confirmation_message"]	= <<<UNSUBSCRIBEEMAIL
Hola [name]
Alguien (tal vez usted, o el administrador de la lista) ha solicitado que su direccion de correo sea desuscripta de nuestra lista.

Este mensaje se envia para confirmar que usted desea desuscribirse de la lista. Para confirmar su desuscripcion:
[url]

Si usted no solicito desuscripcion de ninguna lista, por favor ignore este mensaje y no siga el link. Si las solicitudes persisten, quizas desee notificar el abuso en [abuse_address].

Saludos,
[from]
UNSUBSCRIBEEMAIL;

$language_pack["subscribe_notification_subject"]		= "[Aviso de ListMessenger] Nuevo Suscriptor";
$language_pack["subscribe_notification_message"]		= <<<SUBSCRIBENOTICEEMAIL
Este es un mensaje para avisarle que un nuevo suscriptor se ha unido a la lista de correo.

Detalles Basicos del Usuario:
Full Name:\t[firstname] [lastname]
Direccion de Correo:\t[email_address]
Suscripto a:
[group_ids]

-------------------------------------------------------------------
Recibio este aviso porque la Notificacion de Nuevos Suscriptores esta activada en el Panel de Control de ListMessenger. Si desea desactivar las notificaciones, ingrese a ListMessenger,haga click en Control Panel, End-User Preferences y configure New Subscriber Notification como Disabled.
SUBSCRIBENOTICEEMAIL;

$language_pack["unsubscribe_notification_subject"]	= "[Aviso de ListMessenger] Desuscripcion";
$language_pack["unsubscribe_notification_message"]	= <<<UNSUBSCRIBENOTICEEMAIL
Este es un mensaje para avisarle que un usuario se ha  desuscripto de una o mas lista(s) de correo.

Detalles Basicos del Usuario:
Full Name:\t[firstname] [lastname]
Direccion de Correo:\t[email_address]
Desuscripto de:
[group_ids]

-------------------------------------------------------------------
Recibio este aviso porque la Notificacion de Desuscripciones esta activada en el Panel de Control de ListMessenger. Si desea desactivar las notificaciones, ingrese a ListMessenger,haga click en Control Panel, End-User Preferences y configure Unsubscribe Notification como Disabled.
UNSUBSCRIBENOTICEEMAIL;
?>
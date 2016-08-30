<?php
/*
	ListMessenger - Professional Mailing List Management
	Copyright © 2007 Silentweb [http://www.silentweb.ca]

	Developed By: Matt Simpson <msimpson@listmessenger.com>

	For the most recent version, visit the ListMessenger website:
	[http://www.listmessenger.com]

	License Information is found in docs/licence.html
	$Id: pref_ids.inc.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

// Program Preferences
	define("PREF_ADMUSER_ID",			8);
	define("PREF_ADMPASS_ID",			1);
	define("PREF_FRMNAME_ID",			2);
	define("PREF_FRMEMAL_ID",			3);
	define("PREF_RPYEMAL_ID",			4);
	define("PREF_ABUEMAL_ID",			35);
	define("PREF_ERREMAL_ID",			19);
	define("PREF_NOTEMAL_ID",			43);
	define("PREF_PROPATH_ID",			14);
	define("PREF_PROGURL_ID",			15);
	define("PREF_PUBLIC_PATH",			16);
	define("PREF_PUBLIC_URL",			47);
	define("PREF_PRIVATE_PATH",			48);
	define("PREF_DEFAULT_CHARSET",		49);
	define("PREF_DATEFORMAT",			23);
	define("PREF_USERTE",				30);
	define("PREF_PERPAGE_ID",			9);
	define("PREF_ERROR_LOGGING",		51);
	define("PREF_TIMEZONE",				52);
	define("PREF_DAYLIGHT_SAVINGS",		45);

// End-User Preferences
	define("ENDUSER_UNSUBCON",			36);
	define("ENDUSER_SUBCON",			41);
	define("PREF_EXPIRE_CONFIRM",		50);
	define("ENDUSER_NEWSUBNOTICE",		7);
	define("ENDUSER_UNSUBNOTICE",		31);
	define("PREF_FOPEN_URL",			32);
	define("ENDUSER_MXRECORD",			37);
	define("ENDUSER_ARCHIVE",			44);
	define("ENDUSER_PROFILE",			56);
	define("ENDUSER_LANG_ID",			40);
	define("ENDUSER_ARCHIVE_FILENAME",	10);
	define("ENDUSER_CONFIRM_FILENAME",	11);
	define("ENDUSER_HELP_FILENAME",		12);
	define("ENDUSER_PROFILE_FILENAME",	57);
	define("ENDUSER_FILENAME",			33);
	define("ENDUSER_TEMPLATE",			34);
	define("ENDUSER_UNSUB_FILENAME",	13);
	define("ENDUSER_BANEMAIL",			38);
	define("ENDUSER_BANDOMS",			39);
	define("ENDUSER_CAPTCHA",			58);
	define("ENDUSER_AUDIO_CAPTCHA",		59);
	define("ENDUSER_FLITE_PATH",		60);
	define("PREF_POSTSUBSCRIBE_MSG",	54);
	define("PREF_POSTUNSUBSCRIBE_MSG",	55);

// E-Mail Configuration
	define("PREF_WORDWRAP",				17);
	define("PREF_ADD_UNSUB_LINK",		46);
	define("PREF_MSG_PER_REFRESH",		18);
	define("PREF_PAUSE_BETWEEN",		24);
	define("PREF_QUEUE_TIMEOUT",		42);
	define("PREF_MAILER_BY_ID",			25);
	define("PREF_MAILER_BY_VALUE",		26);
	define("PREF_MAILER_SMTP_KALIVE",	61);
	define("PREF_MAILER_AUTH_ID",		27);
	define("PREF_MAILER_AUTHUSER_ID",	28);
	define("PREF_MAILER_AUTHPASS_ID",	29);

// About Information
	define("VERSION_TYPE",				"Pro");
	define("VERSION_INFO",				"2.1.0");
	define("VERSION_BUILD",				"P0224");
	define("VERSION_BUILD_DATE",		"2007-03-24");
	define("REG_DOMAIN",				6);
	define("REG_NAME",					20);
	define("REG_EMAIL",					21);
	define("REG_SERIAL",				22);
	define("PREF_SERIAL_ID",			22);
	define("PREF_VERSION",				5);

// Miscellaneous Settings
	define("MAINTENANCE_PERFORMED",		53);
	define("PREF_COOKIE_TIMEOUT",		(time() + 604800));

// Database Session Support
	define("PREF_DATABASE_SESSIONS",	"no"); // Set this to "yes" if you want DB sessions, "no" otherwise.

// Listing of all reserved variables that by default will be searched and replaced.
	$RESERVED_VARIABLES		= array();
	$RESERVED_VARIABLES[]	= "name";
	$RESERVED_VARIABLES[]	= "firstname";
	$RESERVED_VARIABLES[]	= "lastname";
	$RESERVED_VARIABLES[]	= "email";
	$RESERVED_VARIABLES[]	= "date";
	$RESERVED_VARIABLES[]	= "groupname";
	$RESERVED_VARIABLES[]	= "groupid";
	$RESERVED_VARIABLES[]	= "userid";
	$RESERVED_VARIABLES[]	= "messageid";
	$RESERVED_VARIABLES[]	= "password";
	$RESERVED_VARIABLES[]	= "profileurl";
	$RESERVED_VARIABLES[]	= "signupdate";
	$RESERVED_VARIABLES[]	= "unsubscribe";
	$RESERVED_VARIABLES[]	= "message";
	$RESERVED_VARIABLES[]	= "title";
?>
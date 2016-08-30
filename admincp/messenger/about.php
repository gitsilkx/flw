<?php
/*
  ListMessenger - Professional Mailing List Management
  Copyright © 2007 Silentweb [http://www.silentweb.ca]

  Developed By: Matt Simpson <msimpson@listmessenger.com>

  For the most recent version, visit the ListMessenger website:
  [http://www.listmessenger.com]

  License Information is found in docs/licence.html
  $Id: about.php 107 2007-03-25 19:49:18Z matt.simpson $
*/

// Setup PHP and start page setup.
  @ini_set("include_path", str_replace("\\", "/", dirname(__FILE__))."/includes");
  @ini_set("allow_url_fopen", 1);
  @ini_set("session.name", "LMSID");
  @ini_set("session.use_trans_sid", 0);
  @ini_set("session.cookie_lifetime", 0);
  @ini_set("session.cookie_secure", 0);
  @ini_set("session.referer_check", "");
  @ini_set("error_reporting",  E_ALL ^ E_NOTICE);
  @ini_set("magic_quotes_runtime", 0);

  if((!isset($_GET["sid"])) || (!trim($_GET["sid"]))) {
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    echo "<body>\n";
    echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
    echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
    echo "if(window.opener) {\n";
    echo "  window.opener.location = './index.php?action=logout';\n";
    echo "  top.window.close();\n";
    echo "} else {\n";
    echo "  window.location = './index.php?action=logout';\n";
    echo "}\n";
    echo "</script>\n";
    echo "</body>\n";
    echo "</html>\n";
    exit;
  }

  require_once("pref_ids.inc.php");
  require_once("config.inc.php");
  require_once("classes/adodb/adodb.inc.php");
  require_once("dbconnection.inc.php");

  session_start(trim($_GET["sid"]));

  if((!isset($_SESSION["isAuthenticated"])) || (!(bool) $_SESSION["isAuthenticated"])) {
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
    echo "<body>\n";
    echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
    echo "alert('It appears as though you are either not currently logged into ListMessenger or your session has expired. You will now be taken to the ListMessenger login page; please re-login.');\n";
    echo "if(window.opener) {\n";
    echo "  window.opener.location = './index.php?action=logout';\n";
    echo "  top.window.close();\n";
    echo "} else {\n";
    echo "  window.location = './index.php?action=logout';\n";
    echo "}\n";
    echo "</script>\n";
    echo "</body>\n";
    echo "</html>\n";
    exit;
  } else {
    require_once("functions.inc.php");
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=<?php echo html_encode($_SESSION["config"][PREF_DEFAULT_CHARSET]); ?>" />

      <title>About ListMessenger</title>

      <link rel="stylesheet" type="text/css" href="./css/common.css" title="ListMessenger Style" />
      <link rel="shortcut icon" href="./images/listmessenger.ico" />

      <style>
        @import url('./css/luna/tab.css');
      </style>

      <script type="text/javascript" src="./javascript/tabpane/tabpane.js"></script>

      <meta name="MSSmartTagsPreventParsing" content="true" />
      <meta http-equiv="imagetoolbar" content="no" />
    </head>
    <body scroll="no" onblur="self.focus()">
    <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
    <colgroup>
      <col style="width: 30%" />
      <col style="width: 70%" />
    </colgroup>
    <tbody>
      <tr>
        <td>
          <img src="./images/listmessenger.gif" width="139" height="167" alt="ListMessenger" title="ListMessenger" />
        </td>
        <td>
          <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
          <colgroup>
            <col style="width: 25%" />
            <col style="width: 75%" />
          </colgroup>
          <tbody>
            <tr>
              <td><strong>Version:</strong>&nbsp;</td>
              <td><span class="titlea-positive">List</span><span class="titleb-positive">Messenger</span> <span class="titlea-positive"><?php echo html_encode(VERSION_TYPE)." ".html_encode(VERSION_INFO); ?></span></td>
            </tr>
            <tr>
              <td><strong>URL:</strong>&nbsp;</td>
              <td><a>http://www.listmessenger.com</a></td>
            </tr>
            <tr>
              <td><strong>Author:</strong>&nbsp;</td>
              <td><a>Matt Simpson</a></td>
            </tr>
            <tr>
              <td><strong>Copyright:</strong>&nbsp;</td>
              <td>Copyright &copy; 2001-<?php echo gmdate("Y", time() + ($_SESSION["config"][PREF_TIMEZONE] * 3600)); ?> <a>Silentweb</a></td>
            </tr>
            <tr>
              <td style="vertical-align: top"><strong>Details:</strong>&nbsp;</td>
              <td style="vertical-align: top; text-align: justify">
                ListMessenger exceeds expectations as a well designed, easy to use and extremely robust electronic mailing list management solution for any PHP and MySQL enabled website.
              </td>
            </tr>
          </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding-top: 10px">
          <div class="tab-pane" id="tab-pane-1">
            <div class="tab-page" style="height: 200px; overflow: auto">
              <h2 class="tab">Credits</h2>
              <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
              <colgroup>
                <col style="width: 30%" />
                <col style="width: 70%" />
              </colgroup>
              <tbody>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a>PixelPoint</a>&nbsp;&nbsp;</td>
                  <td>(Nina Vecchi) for initial project sponsorship.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://www.hotscripts.com/>HotScripts</a>&nbsp;&nbsp;</td>
                  <td>Providing such a quality and dependable listing.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://www.dynarch.com/projects/htmlarea/" target="_blank">Mihai Bazon</a>&nbsp;&nbsp;</td>
                  <td>Providing the WYSIWYG editor HTMLArea.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://webfx.eae.net" target="_blank">Erik Arvidsson</a>&nbsp;&nbsp;</td>
                  <td>Writing very useful DHTML tabs; Tab Pane.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://phpmailer.sourceforge.net" target="_blank">Brent Matzelle</a>&nbsp;&nbsp;</td>
                  <td>Writing superb mail class for PHP; PHPMailer.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://www.phpconcept.net/index.en.php" target="_blank">Vincent Blavet</a>&nbsp;&nbsp;</td>
                  <td>Writing outstanding ZIP class; PCLZip.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://adodb.sourceforge.net" target="_blank">John Lim</a>&nbsp;&nbsp;</td>
                  <td>Developing the perfect DAL; ADOdb.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a href="http://phpsniff.sourceforge.net" target="_blank">Roger Raymond</a>&nbsp;&nbsp;</td>
                  <td>Developing such a handy sniffing class; PHPSniff.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a>Erik Geurts</a>&nbsp;&nbsp;</td>
                  <td>For all your help on the forums and the User Guide.</td>
                </tr>
              </tbody>
              </table>
            </div>
            <div class="tab-page" style="height: 200px; overflow: auto">
              <h2 class="tab">More Credits</h2>
              <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
              <colgroup>
                <col style="width: 30%" />
                <col style="width: 70%" />
              </colgroup>
              <tbody>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a>Nathaniel Murray</a>&nbsp;&nbsp;</td>
                  <td>Designing sweet ListMessenger logo.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a>Greg MacLellan</a>&nbsp;&nbsp;</td>
                  <td>Helping write through some difficult areas.</td>
                </tr>
                <tr>
                  <td>&nbsp;<img src="./images/record-next-on.gif" width="9" height="9" alt="" title="" />&nbsp;<a>Karla Simpson</a>&nbsp;&nbsp;</td>
                  <td>For all her love and support.</td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right; padding-top: 25px"><a><img src="./images/firefox.gif" width="80" height="15" alt="Get Firefox" title="Get Firefox!" border="0" /></a></td>
                </tr>
                <tr>
                  <td colspan="2" style="text-align: right; padding-top: 15px">
                    <table style="width: 100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                      <td><a href="http://www.hotscripts.com/><img src="./images/logo-hotscripts.png" width="173" height="56" alt="HotScripts - Application Resources" title="HotScripts - Application Resources" border="0" /></a></td>
                      <td><a href="http://www.jdrf.ca" target="_blank"><img src="./images/logo-jdrf.jpg" width="223" height="56" alt="Juvenile Diabetes Research Foundation of Canada" title="Juvenile Diabetes Research Foundation of Canada" border="0" /></a></td>
                    </tr>
                    </table>
                  </td>
                </tr>
              </tbody>
              </table>
            </div>
            <div class="tab-page" style="height: 200px; overflow: auto">
              <h2 class="tab">Licence</h2>
              <iframe style="width: 98%; height:198px; border: 0px; margin: 0px; padding: 0px" src="./docs/licence.html"></iframe>
            </div>
            <div class="tab-page" style="height: 200px; overflow: auto">
              <h2 class="tab">Registration</h2>
              <table style="width: 100%" cellspacing="1" cellpadding="1" border="0">
              <colgroup>
                <col style="width: 30%" />
                <col style="width: 70%" />
              </colgroup>
              <tbody>
                <tr>
                  <td><strong>Program Name:</strong>&nbsp;</td>
                  <td>ListMessenger</td>
                </tr>
                <tr>
                  <td><strong>Program Version:</strong>&nbsp;</td>
                  <td><?php echo html_encode(VERSION_INFO)." ".((VERSION_BUILD != "") ? "<span class=\"small-grey\">Build ".html_encode(VERSION_BUILD)."</span>" : ""); ?></td>
                </tr>
                <tr>
                  <td><strong>Release Type:</strong>&nbsp;</td>
                  <td><?php echo html_encode(VERSION_TYPE); ?></td>
                </tr>
                <tr>
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Registered To:</strong>&nbsp;</td>
                  <td><?php echo "DGT"; ?></td>
                </tr>
                <tr>
                  <td><strong>Registered Domain:</strong>&nbsp;</td>
                  <td><?php echo "Unlimited domains"; ?></td>
                </tr>
                <tr>
                  <td><strong>Authorization Code:</strong>&nbsp;</td>
                  <td><?php echo "DGT-000-000-000-000-000"; ?></td>
                </tr>
              </tbody>
              </table>
            </div>
          </div>
          <script language="Javascript" type="text/javascript">setupAllTabs(false);</script>
        </td>
      </tr>
    </tbody>
    </table>

    </body>
    </html>
    <?php
  }
?>
<?php
require_once("../configs/path.php");

if( !empty( $_SESSION[admin_id] ) ) {
	pageRedirect('index.php');
}

$now=date("Y-m-d H", mktime((date("H")),0,0,date("m"),date("d"),date("Y")));
$q4="select * from  ".$prev."admin_login where date_format(t, '%Y-%m-%d %H')='".$now."' and ip_address='".$_SERVER['REMOTE_ADDR']."' and login_stat=0";
//echo $q4;
$r4=mysql_query($q4);
if(@mysql_num_rows($r4)>5)
{
	echo'<br /><h1 style="color:#F00;" align="center">You are now banned for 1 hrs</h1>';
	exit();
}

$prev_month=date("Y-m", mktime(0,0,0,(date("m")-1),1,date("Y")));
$q3="delete from  ".$prev."admin_login where date_format('t', '%Y-%m')<'".$prev_month."'";
$r3=mysql_query($q3);
$optimize_query = mysql_query("OPTIMIZE TABLE ".$prev."admin_login");

if($_POST['SBMT'])
{
	if(trim(strtolower($_REQUEST['captchatext'])) != $_SESSION['captcha'])
	{
		$captchaerror="Please enter the correct security code.<br />";
		unset($_SESSION['captcha']);
	}
	if(empty($_REQUEST['username'])){$usernameerror="Please enter username.<br />";}
	if(empty($_REQUEST['password'])){$passworderror="Please enter password.<br />";}

	if(!$captchaerror && !$usernameerror && !$passworderror)
	{
		
		$_POST['password']=mysql_escape_string(stripslashes($_POST['password']));
		$_POST['username']=mysql_escape_string(stripslashes($_POST['username']));
		
		$r_query = "SELECT * FROM " . $prev . "admin
					WHERE STRCMP('".md5( $_POST['password'] )."', password) = 0
					AND username='".$_POST['username']."'";
		$r = mysql_query( $r_query );

		if(@mysql_num_rows($r))
		{
			session_regenerate_id();
			$_SESSION['admin_id']		= @mysql_result($r, 0, "admin_id");
			$_SESSION['username']		= @mysql_result($r, 0, "username");
			$_SESSION['admin_type']		= @mysql_result($r, 0, "type");
			$_SESSION['chk']			= md5($_SESSION['username']);

			$r2=mysql_query("insert into " . $prev . "admin_login set admin_name='".txt_value($_POST['username'])."',ip_address='".$_SERVER['REMOTE_ADDR']."',user_aget='".addslashes($_SERVER['HTTP_USER_AGENT'])."',t=NOW(), login_stat=1 ");
			$d4=@mysql_fetch_array(mysql_query("SELECT curdate() - INTERVAL 30 day as times"));

			$r3=mysql_query("delete from " . $prev . "user_login where date_format(t, '%Y-%m-%d')<'".$d4['times']."' and  admin_name='".txt_value($_SESSION['username'])."'");

			session_write_close();



			pageRedirect('index.php');
		}
		else
		{
			$r2=mysql_query("insert into " . $prev . "admin_login set admin_name='".txt_value($_POST['username'])."',ip_address='".$_SERVER['REMOTE_ADDR']."',user_aget='".addslashes($_SERVER['HTTP_USER_AGENT'])."',t=NOW(), login_stat=0 ");
			$msg = "<span class='lnkred' style='font-size: 13px;'>Login Failure! Please try again.</span>";
		}
		/*unset($_SESSION['captcha']);*/
	}
}

require_once("includes/header.php");
?>
<br /><br />
<?php
if($msg) {
	echo "<p align='center'>" . $msg . "</p>";
}
?>
<script src="<?=$scriptaculous_path?>lib/prototype.js" type="text/javascript"></script>
<script src="<?=$scriptaculous_path?>src/scriptaculous.js" type="text/javascript"></script>
<script src="<?=$scriptaculous_path?>src/effects.js" type="text/javascript"></script>
<script src="<?=$scriptaculous_path?>src/validation.js" type="text/javascript"></script>
<form method="post" action="<?php echo basename( $_SERVER['PHP_SELF'] ); ?>" name="login_form" id="login_form">
<table cellpadding="4" cellspacing="0" border="0" align="center" width="500" class="table">
  <tr>
	<td bgcolor="<?=$light?>" class="header"  height=30 colspan=2>Admin Login</td><td align=right bgcolor="<?=$light?>"><img src='images/login.png' border=0 height=30 /></td>
  </tr>
  <tr class="lnk" bgcolor="#ffffff">
	<td align="right" width="185" valign="middle" height=30 colspan=2>Username</td>
	<td align="left">
    	<input type="text" name="username" id="username" size="20" class="lnk required" value="<?php echo $_POST['username']; ?>" title="Please enter username" />
        <? if($usernameerror){echo"<br /><span class='lnkred'><b>".$usernameerror."</b></span><br>";}?>
    </td>
  </tr>
  <tr class="lnk" bgcolor="#ffffff">
	<td align="right" valign="middle" height=30 colspan=2>Password</td>
	<td align="left">
    	<input type="password" name="password" id="password" class="lnk required" size="20" title="Please enter password" />
        <? if($passworderror){echo"<br /><span class='lnkred'><b>".$passworderror."</b></span><br>";}?>
    </td>
  </tr>
  <tr class="lnk" bgcolor="#ffffff">
    <td align=center><img src='images/lock.png' /></td><td align="right" valign="top" >Security Code</td>
    <td align="left" valign="top">
    <img src="<?=$vpath?>captcha/captcha.php" id="captcha" name="captcha" alt="Captcha" /><br/>
    <a onclick="ChnageCaptchText('captcha','captcha-form','');" id="change-image" class="lnk" style="cursor:pointer;"><u>Not readable? change text</u></a><br/><br/>
    <input type="text" name="captchatext" id="captcha-form" size="20" class="lnk required" title="Please enter captcha code" />
	<br/>
    <? if($captchaerror){echo"<br /><span class='lnkred'><b>".$captchaerror."</b></span><br>";}?>
    </td>
  </tr>

  <tr bgcolor="#FFFFFF">
	<td colspan=2>&nbsp;</td>
	<td height="8" align="left"><input type="submit" name="SBMT" value="    Go &raquo;   " class="button" tabindex="3" /></td>
  </tr>
  <tr bgcolor="#eaeaea">
	<td align=center colspan=3 height=30><a href="forgot_password.php" class="lnk">Forgot Password?</a></td>
  </tr>
</table>
</form><br /><br /><br /><br /><br /><br />

<script type="text/javascript" language="javascript">
<!--
var uname = document.forms['login_form'].elements['username'];
var pword = document.forms['login_form'].elements['password'];
if (uname.value == '') {
	uname.focus();
} else {
	pword.focus();
}
document.write('<style type="text/css"> @import url("<?=$scriptaculous_path?>form-style.css");<\/style>');
function formCallback(result, form)
{
		window.status = "valiation callback for form '" + form.id + "': result = " + result;
}

var valid = new Validation('login_form', {immediate : true, useTitles: true, onFormValidate : formCallback});
function ChnageCaptchText(captchaid,captchaform,sell)
{
	document.getElementById(captchaid).src='../<?=$captcha_path?>captcha.php?'+Math.random();
	document.getElementById(captchaform).focus();
	return true;
}
//-->
</script>
<?php
require_once("includes/footer.php");
?>
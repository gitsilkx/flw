<?
include("includes/access.php");
include("includes/header.php");
?>


<form method="post" action="<?=$_SERVER['PHP_SELF']?>" onSubmit="javascript:return ValidPass(this);"><br>
<table cellpadding=4 cellspacing=1 border=0 align=center width=30%  align=center style="border:solid 1px <?=$dark?>" >
<?php
if($_POST['SBMT']):
      $r=mysql_query("select * from ".TABLE_ADMIN." where admin_id=\"".$_SESSION['admin_id']."\" and password=\"" . md5($_POST['old_pass']) . "\"");
	   if(@mysql_num_rows($r)):
	     $r=mysql_query("update ".TABLE_ADMIN." set password=\"" . md5($_POST['pass']) . "\" where admin_id=\"".$_SESSION['admin_id']."\"");
	     if($r):
	        echo"<tr  bgcolor=yellow class=lnkred ><td colspan=2 align=center>Password Change Successful <br><br><input type=button value='Back to Login Page' onClick=\"javascript:window.location.href='login.php'\"; class=lnk> </td></tr>";
	     endif;
	  else:
	      echo"<tr  bgcolor=yellow class=lnk ><td colspan=2 align=center>Wrong Old Password</td></tr>";
	  endif;	 
  endif;   
  ?>
<tr bgcolor=<?=$light?>>
	<td colspan=2 align=center class=header>Change Password</td>
</tr>
<tr  class=lnk bgcolor=silver>
	<td colspan=2 align=center><img width=1 height=1 alt="" src=""></td>
</tr>

<tr class=lnk bgcolor=#ffffff>
	<td>Old Password </td><td> <input type="password" class=lnk name="old_pass"  size=6 maxlength="25"></td>
</tr>

<tr class=lnk bgcolor=#ffffff>
	<td>New Password </td><td> <input type="password" class=lnk name="pass" size=6 maxlength="25"></td>
</tr>
<tr class=lnk bgcolor=silver>
	<td colspan=2 align=center><img width=1 height=1 alt="" src=""></td>
</tr>
<tr class=lnk bgcolor=<?=$light?>>
	<td align=center colspan=2><input type=submit name='SBMT' value="Submit" class=lnk></td>
</tr></table></form>

<?
include("includes/footer.php");
?>
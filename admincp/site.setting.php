<?

require_once("includes/access.php");

require_once("includes/header.php");

$light2="#16559c";



if($_POST[SBMT_REG]):

   $r=mysql_query("update  " . $prev . "setting set 

   site_title=\"" . $_REQUEST[site_title] . "\",

   site_url=\"" . $_REQUEST[site_url] . "\",

   meta_keys=\"" . $_REQUEST[meta_keys] . "\",
   contents=\"" . htmlentities($_REQUEST[contents]) . "\",    
   meta_desc=\"" . $_REQUEST[meta_desc] . "\",

   admin_mail=\"" . $_REQUEST[admin_mail] . "\",

   support_mail=\"" . $_REQUEST[support_mail] . "\",
   header_msg ='".mysql_real_escape_string($_REQUEST[header_msg])."',    
   footer_msg ='".mysql_real_escape_string($_REQUEST[footer_msg])."', 
   paypal_mail=\"" . $_REQUEST[paypal_mail] . "\",

   twitter_url=\"" . $_REQUEST[twitter_url_txt] . "\",

   facebook_url=\"" . $_REQUEST[facebook_url_txt] . "\",

   linkedin_url=\"" . $_REQUEST[linkedin_url_txt] . "\",

   skype_url=\"" . $_REQUEST[skype_url_txt] . "\",
   develop_by=\"" . $_REQUEST[develop_by] . "\",
    copyright=\"" . $_REQUEST[ 	copyright] . "\"");
   
   $r=mysql_query("update  ".$prev."admin set email=\"" . $_REQUEST[admin_mail] . "\" where admin_id=1");
   
   

   if($r):

      $msg="<p align=center class=header_tr><br><br>Update Successful.</p>";
	  pageRedirect('site.setting.php?menuid=7&menupid=4');

   else:

      $msg="<p align=center class=lnkred><br><br>Update Failure.</p>";
	  pageRedirect('site.setting.php?menuid=7&menupid=4');

   endif;	  

endif;

     $r=mysql_query("select * from " . $prev . "setting");
   

    $d=@mysql_fetch_array($r);

	$class="lnk";

    ?>

   <table border="0" align=center cellpadding="4" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1"> 

   <!-- <tr bgcolor=<?//=$light?>>

    <td  height="20" align="center" <?if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}?>><a  href='site.setting.php?menuid=7&menupid=4' class=<?//=$class?>>Site Setting</a></td>

	<td align=center <?if(substr_count($_SERVER[PHP_SELF],"email_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='email_setting.php'class=<?//=$class?>>Email Setting</a></td>

    <td align=center <?if(substr_count($_SERVER[PHP_SELF],"account_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='account_setting.php' class=<?//=$class?>>Account Setting</a></td>

	<td align=center <?if(substr_count($_SERVER[PHP_SELF],"static_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='static_setting.php' class=<?//=$class?>>Statistics Setting</a></td>

    <td align=center <?if(substr_count($_SERVER[PHP_SELF],"transfer_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href='transfer_setting.php' class=<?//=$class?>>Transfer Setting</a></td>
	
	<td height="20" width="25%" align=center <?php// if(substr_count($_SERVER[PHP_SELF],"site_under_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href="site_under_setting.php" class=<?//=$class?>>Site Under Maintainance</a></td>
		</tr>
	
	</tr>

    <tr bgcolor=<?//=$light2?>><td colspan=8 height=6><img width=1 height=1></td></tr>-->

    

       <br>

	<?if($msg){echo $msg . "<br>";}?>

    <form name=register method=post action="<?=$_SERVER['PHP_SELF']?>" onSubmit="javscript:return ValidSet(this);">

    <table width="100%" border="1" align="center" cellspacing="0" cellpadding="0" class="table">

    <tr bgcolor=<?=$light?> class=header_tr><td height=25 >&nbsp;Site Setting</td></tr>

    <tr><td align=center valign=top>

    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >

    <tr bgcolor=#ffffff class=lnk>

    	<td valign=top width=20%><b>Site Title :</b></td>

        <td ><input type=text class=lnk name=site_title value="<?=$d[site_title]?>" size=40><br>

      Description: This is the title of landing page of the website.<br>

      Example: MyWebsite - Changing how the world works.</td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td valign=top width="25%"><b>Site URL :</b></td>

        <td ><input type=text class=lnk name=site_url value="<?=$d[site_url]?>" size=40><br>

      Description: This is the url of the website.<br>

      Example: http://www.mywebsite.com</td>

    </tr>

	<tr  bgcolor=#ffffff class=lnk>

    	<td valign=top width="25%"><b>Meta Keys :</b></td>

        <td ><textarea name=meta_keys cols=70 rows=5 class=lnk><?=$d[meta_keys]?></textarea></td>

    </tr>

	<tr  bgcolor=#ffffff class=lnk>

    	<td valign=top width="25%"><b>Meta Description :</b></td>

        <td ><textarea name="meta_desc" cols=70 rows=5 class="lnk"><?=$d[meta_desc]?></textarea></td>

    </tr>
<tr  bgcolor=#ffffff class=lnk>

    	<td valign=top width="25%"><b>Header Msg. Description :</b></td>

        <td ><textarea name="header_msg" cols=70 rows=5 class="lnk"><?=$d[header_msg]?></textarea></td>

    </tr>
	<tr  bgcolor=#ffffff class=lnk>

    	<td valign=top width="25%"><b>Footer Msg. Description :</b></td>

        <td ><textarea name="footer_msg" cols=70 rows=5 class="lnk"><?=$d[footer_msg]?></textarea></td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Admin Email :</b></td>

        <td ><input type="text" class="lnk" name="admin_mail" value="<?=$d[admin_mail]?>" size="40"><br>

      Description: This is the mail id where users will contact the administrator.<br>

      </td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Support Email :</b></td>

        <td ><input type="text" class="lnk" name="support_mail" value="<?=$d[support_mail]?>" size="40"><br>

      Description: This is the support mail id where users will contact support team.<br>

      </td>

    </tr>
    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Paypal Email :</b></td>

        <td ><input type="text" class="lnk" name="paypal_mail" value="<?=$d[paypal_mail]?>" size="40"><br>

      Description: This is the paypal mail id where users will contact administrator.<br>

      </td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Twitter URL :</b></td>

        <td ><input type="text" class="lnk" name="twitter_url_txt" title="Twitter" value="<?=$d[twitter_url]?>" size="40"><br>

      Example: www.twitter.com/admin</td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Facebook URL :</b></td>

        <td ><input type="text" class="lnk" name="facebook_url_txt" title="Facebook" value="<?=$d[facebook_url]?>" size="40"><br>

      Example: www.facebook.com/admin</td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>LinkedIn URL :</b></td>

        <td ><input type="text" class="lnk" name="linkedin_url_txt" title="Linkedin" value="<?=$d[linkedin_url]?>" size="40"><br>

      Example: www.linkedin.com/admin</td>

    </tr>

    <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Skype URL :</b></td>

        <td ><input type="text" class="lnk" name="skype_url_txt" title="Skype" value="<?=$d[skype_url]?>" size="40"><br>

      Example:www.skype.com/admin</td>

    </tr>
      <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>Developed By:</b></td>

        <td ><input type="text" class="lnk" name="develop_by"  value="<?=$d[develop_by]?>" size="40"><br>

      </td>

    </tr>
      <tr bgcolor=#ffffff class=lnk>

    	<td width="25%"><b>CopyRight :</b></td>

        <td ><input type="text" class="lnk" name="copyright"  value="<?=$d[copyright]?>" size="40"><br>

     </td>

    </tr>
    <tr bgcolor="#ffffff" class="lnk">
            <td  valign="top" colspan="2"><b>Page Contents</b></td>
        </tr>

        <tr  bgcolor="#ffffff" class="lnk">
            <td colspan="2">
                <?php
                include_once '../ckeditor/ckeditor.php';
                include_once '../ckfinder/ckfinder.php';
                $ckeditor = new CKEditor();
                $ckeditor->basePath = '../ckeditor/';
                $ckfinder = new CKFinder();
                $ckfinder->BasePath = '../ckfinder/';
                $ckfinder->SetupCKEditorObject($ckeditor);
                echo $ckeditor->editor('contents', html_entity_decode($d["contents"]));
                ?>
            </td>
        </tr>

    <tr bgcolor=<?=$light?>>
		<td>&nbsp;</td><td height=25 align="left"><input type="submit" class="button" name='SBMT_REG' value="Update">
        <a class="CanceButton" href="site.setting.php?menuid=7&menupid=4">Cancel</a>
</td>
	</tr>


</table>
</td>
</tr>
</table>
</form>


<? require_once("includes/footer.php");?>


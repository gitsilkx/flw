<?
require_once("includes/access.php");
require_once("includes/header.php");

$id=$_REQUEST["id"];
$rst=mysql_fetch_array(mysql_query("select * from " . $prev."messages where id='".$id."'"));
?>
<div align="center">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
 <!--  <tr>
    <td>&nbsp;</td>
  </tr>-->
  <tr>
    <td><table width="100%"  align="center" cellpadding="0" cellspacing="0"  style="border:solid 1px #b7b5b5;">
        <tr> 
          <td valign="top"> <div align="center">
<table width="100%"  cellspacing="0" cellpadding="4" >
                <tr> 
                  <td height="25" bgcolor="#b7b5b5" class="header" style="border-bottom:#b7b5b5 solid 2px; font-size:16px;">  
					<strong>Messages : <?php print ucwords($row123['fname']).' '.ucwords($row123['lname']);?></strong>
                  </td>
                </tr>
            </table>
  <table width="84%" border="0" align="center" cellpadding="0" cellspacing="0" class="onepxtable">
          <tr  style="border-bottom:#b7b5b5 solid 2px; background-color:#CCCCCC; font-size:16px;"> 
            <td height="25" class="titlestyle">&nbsp;<strong>Read Message</strong></td>
          </tr>
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="5">
          <tr> 
            <td width="126" align="left" valign="top" class="lnk"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">To:</font></strong></td>
            <td> <font class="normal"> 
              <?  
			//$to=mysql_fetch_array(mysql_query("select * from " . $prev."user where user_id=".$rst["tid"]));
			//echo $_GET['to'];?>
			
			Admin
              </font></td>
          </tr>
          <tr> 
            <td height="23" align="left" valign="top" class="lnk"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">From:</font></strong></td>
            <td> <font class="normal"> 
              <? 
			//$from=mysql_fetch_array(mysql_query("select * from " . $prev."user where user_id=".$rst["fid"]));
			echo $_GET['fr'];?>
              </font></td>
          </tr>
          <tr> 
            <td align="left" valign="top" class="lnk"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Subject:</font></strong></td>
            <td><font class="normal"><? echo $rst["subject"];?></font></td>
          </tr>
          
          <tr> 
            <td align="left" valign="top" class="lnk"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Message:</font></strong></td>
            <td><font class="normal"><? echo str_replace("\n","<br>",$rst["message"]);?></font></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td height="25" align="center" bgcolor="#b7b5b5" class="header" style="border-bottom:#b7b5b5 solid 2px; font-size:12px;">
				  
				  <input class="button" type="button" onclick="javascript:window.location.href='messages.php?m=u'" value="Back">
				  
				  
				   </td>
                </tr>
            </table>
            </div></td>
        </tr>

        <tr> 
          <td><div align="center"></div></td>
        </tr>
      </table>
  
</div>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>



<?


include("includes/footer.php");
?>
<?php
require_once("includes/access.php");
require_once("includes/header.php");

#toal_members
$r=mysql_query("select count(*) as total from " . $prev. "user");
$total_user=@mysql_result($r,0,"total");

$r=mysql_query("select count(*) as total from " . $prev. "categories where parent_id=0");
$total_categories=@mysql_result($r,0,"total");

$r=mysql_query("select count(*) as total from " . $prev. "products");
$total_products=@mysql_result($r,0,"total");

$r=mysql_query("select count(*) as total from " . $prev. "orders where status='D'");
$total_successful_orders=@mysql_result($r,0,"total");

$r=mysql_query("select count(*) as total from " . $prev. "orders where status='P'");
$total_pending_orders=@mysql_result($r,0,"total");

$r=mysql_query("select sum(amount) as total from " . $prev. "orders where status='d'");
$total_amount_sales=@mysql_result($r,0,"total");
?>
<script language="JavaScript">
//<!--
	function validate(form)
	{
		if(isNaN(form.keyword.value)&&(form.radio.value==2))
		{
			alert('Please Enter a valid numeric value for Item #');
			form.keyword.select();
			form.keyword.focus();
			return false;
		}
			return true;
	}
//-->
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="table">
              <tr bgcolor=<?=$lightgray?>> 
                <td height="30" class="header" colspan=2>&nbsp;Site Statistics</td>
              </tr><tr><td colspan=2 align=center>
			  <table width="100%" border="0" cellspacing="0" cellpadding="4">
			  <tr><td>
			  <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr><td  valign=top class=lnk width=200 style='padding-left:20px'><strong>Total Members</strong></td><td valign=top>[<?=$total_user?>]	</td></tr>
			  <tr><td  valign=top class=lnk style='padding-left:20px'><strong>Total Categories</strong></td><td valign=top>[<?=$total_categories?>]	</td></tr>	
			  <tr><td  valign=top class=lnk style='padding-left:20px'><strong>Total Products</strong></td><td valign=top>[<?=$total_products?>]	</td></tr>
              </table></td><td width=50%>
			   <table width="100%" border="0" cellspacing="0" cellpadding="4">
              <tr><td  valign=top class=lnk width=200 style='padding-left:20px'><strong>Total Successful Orders</strong></td><td valign=top>[<?=$total_successful_orders?>]	</td></tr>
			  <tr><td  valign=top class=lnk style='padding-left:20px'><strong>Total Pending Orders</strong></td><td valign=top>[<?=$total_pending_orders?>]	</td></tr>	
			  <tr><td  valign=top class=lnk style='padding-left:20px'><strong>Total Sales Amount</strong></td><td valign=top>[<?=$total_amount_sales?>]	</td></tr>
              </table>
			  
			  </td></tr></table><br /><br /><br /><br /><br />
			
			</td></tr></table> 
    
<?php
//}
include("includes/footer.php"); ?>
<?php
include("includes/access.php");
include("includes/header.php");
$pid=($_REQUEST['pid']=='')?0:$_REQUEST['pid'];
if($_REQUEST['del']):
  mysql_query("delete from " .$prev."user where user_id=" . $_REQUEST['user_id']);
  pageRedirect('registration.list.php?menuid=52&menupid=46');
  //exit();
endif;

if(isset($_REQUEST['status'])){
	   $update=mysql_query("UPDATE ".$prev."user SET status='".$_REQUEST['status']."' WHERE user_id=".$_REQUEST['user_id']);	
	}
?>
<form name="form1" method="post" action="registration.list.php?menuid=52&menupid=46">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor="silver" cellpadding="4" style="border:solid 1px <?=$dark?>">
	<tr bgcolor="<?=$light?>">
		<td class="header"><a class="header">Customers List</a>
	    <input type="button" class="button" onClick="javascritp:window.location.href='registration.entryform.php?menuid=52&menupid=46&user_id=0'" value="Add New Member"> 	
    </td>
    	</td><td width="40%" align="right">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="lnk">
					<td>
					  <select name="parama" size="1" class="lnk">
						<option value="user_id" <? if($_REQUEST['parama']=="user_id"){echo" selected";}?>>ID</option>
						<option value="f_name" <? if($_REQUEST['parama']=="f_name"){echo" selected";}?>>First Name</option>
						<option value="l_name" <? if($_REQUEST['parama']=="l_name"){echo" selected";}?>>Last Name</option>
					  </select>
					</td>
					<td> == <input type="text" size="8" name="search"  value="<?=$_REQUEST[search]?>" class="lnk"> &nbsp;</td>
					<td><input type="submit" class="button" name="SBMT_SEARCH"  value="  Search  "></td>
				</tr>
			</table>		</td>
	</tr>
</table>
<table id="table-1" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
	<thead>
	
		<tr>
		<td width="5%" height="25"><b>ID</b></td>
		<td  width="20%" height="25"><b>Email</b></td>
        <td  width="20%" align="left"><b>Name</b></td>
		<td  width="10%" align="left"><b>Phone No.</b></td>
		<td  width="10%" align="left"><b>Mobile</b></td>
		<td  width="10%" align="left"><b>City</b></td>
        <td  width="10%" align="center"><b>Zip</b></td>
		<td  width="5%" align="center"><b>Status</b></td>
		<td  width="10%" align="center"><b>Action</b></td>
		</tr>
	</thead>
	<tbody>
		<?
		$conds='';
		if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
		
		if($_REQUEST[SBMT_SEARCH] && $_REQUEST[parama] && $_REQUEST[search]):
   			$cond=" ".$_REQUEST[parama] . " ='" . $_REQUEST[search] . "'";
		endif;
		if($cond){
			$conds=' where '.$cond;
			
		}
		
		$r=mysql_query("select count(*) as total from " .$prev."user " . $conds);
		$total=@mysql_result($r,0,"total");
		

		$r=mysql_query("select * from ".$prev."user ". $conds ." order by user_id desc limit " . ($_REQUEST['limit']-1)*10 . ",10");
	
		if($total=='0')
		{
   		?>
			<tr class='lnkred'><td colspan='9' align='center'>No record found.</td></tr>
		<?php
		}
		else
		{
		$j=0;
		while($d=@mysql_fetch_array($r))
		{
			
    		if(!($j%2)){$class="even";}else{$class="odd";}
			if($d['registration_status']=="A"){$registration_status="Active";}else{$registration_status="<span class='lnkred'>In Active</span>";}
			
			?>
			<tr  bgcolor='#ffffff' class="<?=$class?>">
				<td align="center" height="25"><?=$d['user_id']?></td>
				<td align="left"><?=$d['email_id']?></td>
				<td align="left"><?=$d['f_name']." ".$d['l_name']?></td>
				<td align="left"><?=$d['contact_1']?></td>
				<td align="left"><?=$d['contact_2']?></td>
				<td align="left"><?=getCitynameById($d['city_id'])?></td>
                <td align="center"><?=getZipcodeById($d['zip_id'])?></td>
				<td align="center" class="listCont" id="chgstatus1987">
					<?php if($d['status']=='Y'){?>
                     <a href="registration.list.php?menuid=52&menupid=46&user_id=<?=$d['user_id']?>&status=N">
                        <img src='images/icon_active.png' alt='Active' title='Active' style="cursor:pointer;"  />
                    </a>
                    <?php }else{?>
                    <a href="registration.list.php?menuid=52&menupid=46&user_id=<?=$d['user_id']?>&status=Y">
                   <img src='images/delete.png' alt='Inactive' title='Inactive' style="cursor:pointer;"  />
                    </a>
                    <?php }?>
				</td>

				<td align="center" class="listCont">
					<span class="EditDeleteButton">
						<a href="registration.entryform.php?menuid=52&menupid=46&user_id=<?=$d['user_id']?>">
							<img width="16" height="16" title="Edit" alt="Edit" src="images/icon_edit.png">
						</a>
					</span>&nbsp;
					<span class="EditDeleteButton">
						<a href="<?=$_SERVER['PHP_SELF']?>?user_id=<?=$d['user_id']?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete this record?')">
						<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete"  border="0" style="cursor:pointer;" />
						</a>
					</span>
				</td>
			</tr>
			<?php
   			$j++;
		} 
		}  
		?>
	</tbody>
	<?php if($total>10):?>
	<tr><td align="center" class="lnk" colspan=10 bgcolor=<?=$lightgray?> height=28><?=paging($total,10,"$param","lnk")?></td></tr>
<?php endif;?>
</table>
<?php
if($_REQUEST[cat_id]):
	$param="&cat_id=" . $_REQUEST[cat_id];
elseif($_REQUEST[cat_id]):
	$param="&cat_id=" . $_REQUEST[cat_id];
else:
	$param="";
endif;
?>

</form>
<script cat_id="text/javascript">
//<![CDATA[
function addClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var l = p.length;
	for (var i = 0; i < l; i++) {
		if (p[i] == sClassName)
			return;
	}
	p[p.length] = sClassName;
	el.className = p.join(" ");

}

function removeClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var np = [];
	var l = p.length;
	var j = 0;
	for (var i = 0; i < l; i++) {
		if (p[i] != sClassName)
			np[j++] = p[i];
	}
	el.className = np.join(" ");
}
var st = new SortableTable(document.getElementById("table-1"),
	["Number","None","String","String","Number","date","date","String","None"]);
	// restore the class names
st.onsort = function () {
	var rows = st.tBody.rows;
	var l = rows.length;
	for (var i = 0; i < l; i++) {
		removeClassName(rows[i], i % 2 ? "odd" : "even");
		addClassName(rows[i], i % 2 ? "even" : "odd");
	}
};
//]]>
</script>
<?
include("includes/footer.php");
?>

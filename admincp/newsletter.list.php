<?php
include("includes/access.php");
include("includes/header.php");


/************************Send mail***************************************************/	
if(isset($_REQUEST['send'])) 
{
	$to  = $_REQUEST['email'];
	$from=$setting['admin_mail'];
	$message=$_REQUEST['news_content'];

	// subject
	$subject = 'Newsletter Information';

	// message
	$message = "
	<html>
	<head>
	 <title>Newsletter Information</title>
	</head>
	<body>
		<table>
			 <tr>
				<td><b>Myfooding News</b></td>
			 </tr>
			 <tr>
				<td><b>News : </b></td><td align='left'>$message</td>
			 </tr>
		</table>
	</body>
	</html>
	";

	// To send HTML mail, the Content-type header must be set
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'From:'.$from . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Mail it
	$mail=mail($to, $subject, $message, $headers);

	if($mail)
	{
		mysql_query("UPDATE ".$prev."newsletter SET
		news_content='".mysql_real_escape_string(addslashes(strip_tags($_REQUEST['news_content'])))."' WHERE email='$to'");
		
	}
	
	$_SESSION['succ_message']="Newsletter sent successfully.";
	pageRedirect('newsletter.list.php?menuid=137&menupid=128');
}
/***********************End Send mail**************************/


 /************************Delete***************************************************/	
if($_REQUEST['del']):
  mysql_query("delete from " .$prev."newsletter where id=" . $_GET['id']);
  $_SESSION['succ_message']="Email ID Deleted Successfully !!";
  pageRedirect('newsletter.list.php?menuid=137&menupid=128');
  exit();
endif;
/***********************End Delete**************************/

 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

  
	if($_REQUEST[sortby])
	{
	   if($_REQUEST[sortby]=="Y"){$cond[]=" status='Y'";}	
	   if($_REQUEST[sortby]=="N"){$cond[]=" status='N'";}
	 // $parama.="&shortby=".$_REQUEST[shortby];
	}
/***********************End Search**************************/


	if(count($cond))
	{
		if($_REQUEST['search'])
		{
			$conds="and ".implode(" and ",$cond);

		}
		else
		{
			$conds="and ". implode(" and ",$cond);
			//$parama="&".implode("&",$cond);
		}
	}
	
	/*************************Main Query******************************/	

 $sql="SELECT * FROM ".$prev."newsletter where 1 ".$conds." ".$sortby;
  $resut=mysql_query($sql);
  $totalrow=mysql_num_rows($resut);
?>
<!------------------------Multiple Checkbox---------------->
<script type="text/javascript">
checked=false;
function checkedAll (formListContainer) {
	
 var aa= document.getElementById('formListContainer');
  if (checked == false)
          {
           checked = true;
		   $("#but_delete").css("display", "block");
          }
        else
          {
          checked = false;
		   $("#but_delete").css("display", "none");
          }
 for (var i =0; i < aa.elements.length; i++) 
 {
  aa.elements[i].checked = checked;
 }
}
function del()
{	
	if(confirm('Are you sure you want to delete Customer?')==true)
	{
		document.formListContainer.method="post";
		document.formListContainer.action="delete.php?id=id";
		document.formListContainer.submit();
	}
}
</script>


<script type="text/javascript">
//jQuery.noConflict();
$(document).ready( function () {
	//alert('asd');
   $('#tableListContent').dataTable( {
  "sPaginationType": "full_numbers",
    "aoColumns": [
                { "bSortable": false },
                null,
                null,
                { "bSortable": false },
                { "bSortable": false },
				{ "bSortable": false },
				
            ],
			
		"iDisplayLength": 50,
        "aLengthMenu": [
        [50,100,300,-1],
		[50,100,300,'All']
		]
			
 } );
 
$('.checkbox_id').click(function(){

	    var checkbox_id=$(this).attr("id");

	if($('#'+checkbox_id).is(':checked')==true){
		$("#but_delete").css("display", "block");
		
	}
	else
	{
		$("#but_delete").css("display", "none");
	}
	
	
	}); 
} );
</script>
<div class="adminRight">
	<div id="loadingrefresh">
		<div class="rightContHeading Heading">Manage Newsletter</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <!--<div class="manageButtonLeft marginBot">
			<form name="restaurantmanage" method="post" action="newsletter.list.php?menuid=137&menupid=128" >
		
			<span class="restManageNameSort">Sort By</span><span class="restManageCol">:</span>
			<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.restaurantmanage.submit();">
				<option value="">Select</option>
				<optgroup label="Status">
                   <option value="Y" <? if($_REQUEST[sortby]=="Y"){echo "selected";}?>>&nbsp;&nbsp;Active</option>
                   <option value="N" <? if($_REQUEST[sortby]=="N"){echo "selected";}?>>&nbsp;&nbsp;Deactiv</option>
				</optgroup>
			</select>
			</form>
		</div>-->
				<!--<div class="manageButtonLeft marginBot">	
					<form name="categorymanage" method="post" action="categoryManage.php" />
					<span class="restManageNameSort">Sort By</span><span class="restManageCol">:</span>
                    
					<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.categorymanage.submit();">
						<option value="">Select</option>
						<optgroup label="Status">
							<option value="active" >&nbsp;&nbsp;Active</option>
							<option value="deactive" >&nbsp;&nbsp;Deactive</option>
						</optgroup>
						<optgroup label="Others">
							<option value="casc" >&nbsp;&nbsp;Category Name A to Z</option>
							<option value="cdesc" >&nbsp;&nbsp;Category Name Z to A</option>
							
						</optgroup>				
					</select>
					</form>
				</div>-->
								<!--Button Left start-->
				
				<!--Button Left End-->
                
                <div  class="manageButtonLeft" style="width:400px; text-align:center;">
                <?php if(isset($_SESSION['succ_message'])){?>
                <strong style="color:#006600;"><?php echo $_SESSION['succ_message']; unset($_SESSION["succ_message"]);?></strong>
                <?php }if(isset($_SESSION['err_message'])){?>
                <strong style="color:#900;"><?php echo $_SESSION['err_message']; unset($_SESSION["err_message"]);?></strong>
                <?php }?>
                </div>
                
				<!--Button Right start-->
				<div class="manageButtonLastCont">
					<!--<a class="manageButton_addnw thickbox" href="categoryAddEdit.php?height=300&width=700">Add New</a>-->
					<!--<a class="manageButton_addnw" href="couisine.entryform.php?menuid=119&menupid=117">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>-->
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');"  />
					<input type="button" class="manageButton but_delete" id="but_delete" value="Delete" style="display:none;" onclick="del();" />
				</div>
				<!--Button List End-->
				<!--Pagination Start-->
				
				<!--Pagination End-->
				<!--List Start-->
				<div class="tableListContainer">
                <form name="formListContainer" id="formListContainer" action="">
					<table id="tableListContent" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
                    <thead>
					<tr class="listHeader">
						<td width="3%" align="center" class="listHeaderCont">
							<input type="checkbox" onclick="checkedAll(formListContainer)" />
						</td>
						<td width="7%" align="center" class="listHeaderCont">Sl.No</td>
						<td width="25%" align="left" class="listHeaderCont">
							<a href="javascript:void(0);" onclick="sortByAscDesc('cdesc','','');">Email ID</a>
						</td>
						<td width="40%" align="center" class="listHeaderCont">
							<a href="javascript:void(0);" onclick="sortByAscDesc('idesc','','');">News</a>
						</td>
						<td width="10%" align="center" class="listHeaderCont">Added Date</td>
						<td width="15%" align="center" class="listHeaderCont">Action</td>
						
					</tr>
                            
                            </thead>
                            <tbody>
						<?php if($totalrow){
							$i=1;
							while($d=mysql_fetch_array($resut))
							{
							?>
						<tr>
						<td align="center" class="listCont"><span class="listContResta">
						  <input type='checkbox' name="chk[]" id="checkbox_id_<?=$d['id']; ?>" class="checkbox_id"  value="<?php echo $d['id'];?>"/>
						</span></td>
						<td align="center" class="listCont"><?=$i;?></td>
						<td align="left" class="listCont"><?=$d['email']?></td>
						<td align="center" class="listCont">
							<input type="hidden" name="email" value="<?=$d['email']?>">
							<textarea name="news_content" id="news_content" style="height:42px; width:185px;"></textarea>
						</td>
						<td align="center" class="listCont"><?php echo date('M d,Y',strtotime($d['cur_date']));?></td>				
						<td align="center" class="listCont">
							<span class="EditDeleteButton">
							<input type="submit" value="Send" name="send" class="button">
							</span>&nbsp;&nbsp;
							<span class="EditDeleteButton">
                <a href="<?=$_SERVER['PHP_SELF']?>?id=<?=$d['id']?>&del=1&menuid=119&menupid=117" class='lnk'  onclick="return confirm('Are you sure you want to delete?')">
								<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete"  style="cursor:pointer;" />
							</a>
                            </span>
						</td>
					</tr>
                        
                        <?php
						      $i++; } 
							} else {?>
                       <tr class="listLightGray">
						  <td colspan="8" align="center" class="listCont">No record found</td>
					  </tr>
                            <?php }?>
					
                    </tbody>
                    </table>
                    </form>
</div>
				<!--List End-->
				<!--Pagination start-->
				
				<!--Pagination End-->
				<div class="clr"></div>
				<!--Button List start-->
				<div class="manageButtonLastCont">
					<!--<a class="manageButton_addnw thickbox" href="couisine.entryform.php?menuid=119&menupid=117">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>-->
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');" />
					<input type="button" class="manageButton but_delete" value="Delete" style="display:none;" onclick="adminActivateDeactivate('delete','deletefield','maincateid','rt_category_main','Main Category','category');" />
				</div>
				<!--Button List End-->
			
			</div>
		</div>
	</div>
</div>
<?
include("includes/footer.php");
?>
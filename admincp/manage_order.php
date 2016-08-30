<?php
include("includes/access.php");
include("includes/header.php");

 /************************Delete***************************************************/	
if($_REQUEST['del']):
  mysql_query("delete from " .$prev."orders where OrderID=" . $_GET['OrderID']);
  mysql_query("delete from ".$prev."cart where OrderID=".$_GET['OrderID'])	;
  $_SESSION["succ_message"]="Record deleted successfully.";
  pageRedirect('manage_order.php?menuid=108&menupid=103');
  exit();
endif;
/***********************End Delete**************************/

/******************************Popular****************************************/
if(isset($_REQUEST['delivered_new'])){
	
	
	$value=$_REQUEST['delivered_new'];
	$array=explode('_',$value);
	$delivered=$array[0];
	$OrderID=$array[1];
	
	   $update=mysql_query("UPDATE ".$prev."orders SET delivered='".$delivered."' WHERE OrderID=".$OrderID);
	
	if($update)
	{	
		$row_ord=mysql_fetch_array(mysql_query("SELECT user_id FROM ".$prev."orders WHERE OrderID='$OrderID'"));
		$user_id1=$row_ord['user_id'];
		
		$row_user=mysql_fetch_array(mysql_query("SELECT email_id FROM ".$prev."user WHERE user_id='$user_id1'"));
		
		
		$to= $row_user['email_id'];
		$from=$setting['admin_mail'];
		$OrderID1="ORD".$OrderID;
		$message="Your order status is ".$delivered;


		// subject
		$subject = "Order Delivery Status";

		// message
		$message = "
			<html>
			<head>
			  <title>$subject</title>
			</head>
			<body>
			  <table>
				<tr>
					<td>Order ID</td>
					<td>:</td>
					<td>$OrderID1</td>
				</tr>
				<tr>
					<td>Message</td>
					<td>:</td>
					<td>$message</td>
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
		
	}
}

if(isset($_REQUEST['delivery_boy'])){
	
	
	$value=$_REQUEST['delivery_boy'];
	$array=explode('_',$value);
	$delivery_boy=$array[0];
	$OrderID=$array[1];
	   $update=mysql_query("UPDATE ".$prev."orders SET delivery_boy='".$delivery_boy."' WHERE OrderID=".$OrderID);	
	//print_r("UPDATE ".$prev."orders SET delivery_boy='".$delivery_boy."' WHERE OrderID=".$OrderID);
}
 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

	if($_REQUEST['searchrestaurantid']){

		$cond[]=" rest_id='".$_REQUEST['searchrestaurantid']."'";
		//$parama.="&product_brand=".$_REQUEST[brand_id];
	}

  
	if($_REQUEST[sortby])
	{
		
	   $cond[]=" delivered='".$_REQUEST[sortby]."'";	
	   
	  
	 // $parama.="&shortby=".$_REQUEST[shortby];
	}
/***********************End Search**************************/

/*************************End pagination*******************************/	
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

 /* $sql="SELECT * FROM ".$prev."restaurant where 1 ".$conds." ".$sortby;
  $resut=mysql_query($sql);
  $totalrow=mysql_num_rows($resut);*/
  
 //================================For Menu Select=====================================================	
  $sql = "SELECT * FROM ".$prev."orders  WHERE 1 ".$conds." ".$sortby;
  $result = mysql_query($sql);
  $totalrow=mysql_num_rows($result);
//================================For Menu Select End=====================================================	
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
		document.formListContainer.action="delete.php?OrderID=OrderID";
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
                 { "bSortable": false },
                 null,
                 null,
                 null,
				 null,
				  { "bSortable": false },
				  { "bSortable": false },
				 { "bSortable": false },
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
		<div class="rightContHeading Heading">Manage Main Category</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <div class="manageButtonLeft marginBot">
			<form name="restaurantorder" method="post" action="manage_order.php?menuid=108&menupid=103" />
			<select class="restManageNameDrop" name="searchrestaurantid" id="searchrestaurant" onchange="document.restaurantorder.submit();">
				<option value="">Select Restaurant Name</option>
				<?php 
				$result1=mysql_query("SELECT `rest_id`,`rest_name` FROM ".$prev."restaurant");
				$totno=mysql_num_rows($result1);
				if($totno){
				while($row1=mysql_fetch_object($result1)){
                ?>
                <option value="<?= $row1->rest_id?>" <?php if($_REQUEST['searchrestaurantid']==$row1->rest_id){?> selected="selected"<?php }?> ><?= $row1->rest_name?></option>
                
                <?php 
				}
				mysql_free_result($result1);
				}?>
							</select>&nbsp;
			<span class="restManageNameSort">Sort By</span><span class="restManageCol">:</span>
			<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.restaurantorder.submit();">
				<option value="">Select</option>
				<optgroup label="Status">
                   <option value="pending" <? if($_REQUEST[sortby]=="pending"){echo "selected";}?>>&nbsp;&nbsp;Pending</option>
                   <option value="process" <? if($_REQUEST[sortby]=="process"){echo "selected";}?>>&nbsp;&nbsp;Processing</option>
                   <option value="deliver" <? if($_REQUEST[sortby]=="deliver"){echo "selected";}?>>&nbsp;&nbsp;Delivered</option>
                   <option value="fail" <? if($_REQUEST[sortby]=="fail"){echo "selected";}?>>&nbsp;&nbsp;Failed</option>
				</optgroup>
	
			</select>
			</form>
		</div>
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
					
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');"  />
					<input type="button" class="manageButton but_delete" id="but_delete" value="Delete" style="display:none;" onclick="del();" />
				</div>
				<!--Button List End-->
				<!--Pagination Start-->
				
				<!--Pagination End-->
				<!--List Start-->
				<div class="tableListContainer">
                <form name="formListContainer" id="formListContainer" action="manage_order.php?menuid=108&menupid=103">
               
					<table id="tableListContent" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
                    <thead>
					<tr class="listHeader">
					<td width="5%" align="center" class="listHeaderCont"><input type="checkbox" onclick="checkedAll(formListContainer)" /></td>
					<td width="5%" align="center" class="listHeaderCont">S.No</td>
					<td width="15%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('mdesc','','');">Order No						</a>
					</td>
					<td width="10%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('tdesc','','');">Order Type						</a>
					</td>
					<td width="20%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('cdesc','','');">Order Date					</a>
  </td>
										<td width="10%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('resdesc','','');">Order Price						</a>
  </td>
										<td width="10%" align="center" class="listHeaderCont">Phone</td>
					<td width="15%" align="center" class="listHeaderCont">Restaurant</td>
					<td width="0%" align="center" class="listHeaderCont">Status</td>
					<td width="0%" align="center" class="listHeaderCont">Delivery Boy</td>
					<td width="20%" align="center" class="listHeaderCont">Order At</td>
					<td width="0%" align="center" class="listHeaderCont">Action</td>
				</tr>
                            
                            </thead>
                            <tbody>
						<?php if($totalrow){
							  $i=1;
							  
							  while($row=mysql_fetch_object($result)){
								$delivered_new=$row->delivered.'_'.$row->OrderID;
								$delivery_boy=$row->delivery_boy;
//echo "'pending_".$row->OrderID."'";
							 // print_r($row);
							?>
					
					<tr  id="deletecate1987">
					<td align="center" class="listCont"><span class="listContResta">
					  <input type='checkbox' name="chk[]" id="checkbox_id_<?=$row->OrderID ?>" class="checkbox_id"  value="<?php echo $row->OrderID?>"/>
					</span></td>
					<td align="center" class="listCont"><?php echo $i;?></td>
					<td align="left" class="listCont"><?php echo 'ORD'.$row->OrderID;?></td>
					<td align="left" class="listCont"><?php echo $row->delivery_type;?></td>
					<td align="left" class="listCont"><?php echo $row->ord_date.$row->Ord_time.$row->delivery_time.$row->delivery_status;?></td>
					<td align="left" class="listCont"><?php echo $row->amount+$row->vat+$row->shipping_charges;?></td>
					<td align="center" class="listCont"><?php echo $row->contact_no;?></td>
					<td align="center" class="listCont"><?php echo getRestuarantnameById($row->rest_id);?></td>
					<td align="center" class="listCont">
                    <select name="delivered"  onchange="$(this).attr('name','delivered_new');window.location = 'manage_order.php?menuid=108&menupid=103&delivered_new='+$(this).val()">
          
                     <option value="pending_<?=$row->OrderID?>" <?php  if($delivered_new=='pending_'.$row->OrderID) {?> selected="selected" <?php }?>>Pending</option>
                     <option value="process_<?=$row->OrderID?>" <?php  if($delivered_new=='process_'.$row->OrderID) {?> selected="selected" <?php }?>>Processing</option>
                     <option value="deliver_<?=$row->OrderID?>" <?php  if($delivered_new=='deliver_'.$row->OrderID) {?> selected="selected" <?php }?>>Delivered</option>
                     <option value="fail_<?=$row->OrderID?>" <?php  if($delivered_new=='fail_'.$row->OrderID) {?> selected="selected" <?php }?>>Failed</option>
                    
                    </select>
				
					</td>
					
					<td align="center" class="listCont">
                    <select name="delivery_boy" onchange="$(this).attr('name','delivery_boy');window.location = 'manage_order.php?menuid=108&menupid=103&delivery_boy='+$(this).val()">
					<option value="">Select</option>
					<?php
					$res_boy=mysql_query("SELECT id,name FROM ".$prev."delivery_boy");
					while($row_boy=mysql_fetch_object($res_boy))
					{
					?>
                     <option value="<?=$row_boy->id.'_'.$row->OrderID;?>" <?php if($delivery_boy==$row_boy->id) {?> selected="selected" <?php }?>><?=$row_boy->name?></option>
                    <?php
					}
					?>
                    </select>
					</td>
					
					<td align="center" class="listCont" id="chgstatus1987">
					<?php echo date('M d,Y',strtotime($row->cur_date));?>
					</td>
					<td align="center" class="listCont">
						<span class="EditDeleteButton">
							<a href="view_orders.php?menuid=108&menupid=103&OrderID=<?php echo $row->OrderID;?>">
								<img src="images/icon_edit.png" width="16" height="16" alt="Edit" title="Edit" />
							</a>
						</span>
						<span class="EditDeleteButton">
                          <a href="<?=$_SERVER['PHP_SELF']?>?OrderID=<?=$row->OrderID?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')">
							<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete" onclick="return changeStatus('delete','status','id','rt_restaurant_menu','Menu','1987');" style="cursor:pointer;" />
							</a>
                        </span>
					</td>
				</tr>
                        
                        <?php
						      $i++; } 
							} else {?>
                       <tr class="listLightGray">
						  <td colspan="11" align="center" class="listCont">No record found</td>
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
					
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>
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
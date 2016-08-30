<?php
include("includes/access.php");
include("includes/header.php");

/******************************Popular****************************************/
if(isset($_REQUEST['id'])){
	
	if(isset($_REQUEST['status'])){
		if($_REQUEST['status']=='N'){ $updated="De-activated"; }
		if($_REQUEST['status']=='Y'){ $updated="Activated"; }
		
		$update=mysql_query("UPDATE ".$prev."review SET status='".$_REQUEST['status']."' WHERE id=".$_REQUEST['id']);
		if($update)
		{
		$_SESSION['succ_message']="Status ".$updated." Successfully !!";
		}
	}
	
	if($_REQUEST['act']=="del"){
	   $delete=mysql_query("DELETE FROM ".$prev."review WHERE id=".$_REQUEST['id']);
		if($delete)
		{
		$_SESSION['succ_message']="Review Deleted Successfully !!";
		}
	}
	
}
 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

	if($_REQUEST['searchrestaurantid']){

		$cond[]=" rev.rest_id='".$_REQUEST['searchrestaurantid']."'";
		//$parama.="&product_brand=".$_REQUEST[brand_id];
	}
	
  
	if($_REQUEST[sortby])
	{
		echo $_REQUEST[sortby];
	   if($_REQUEST[sortby]=="Y"){$cond[]=" rev.status='Y'";}	
	   if($_REQUEST[sortby]=="N"){$cond[]=" rev.status='N'";}	
	 
	  
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

  $sql="SELECT count(rev.id) cnt FROM ".$prev."review as rev LEFT JOIN ".$prev."restaurant as res ON rev.rest_id = res.rest_id WHERE 1 ".$conds." ".$sortby;
  $resut=mysql_query($sql);
  $totalrow=mysql_num_rows($resut);
  
 //================================For Menu Select=====================================================	
 
  $sql = "SELECT rev.id,rev.user_id,rev.rest_id,rev.review,rev.status,rev.cur_date,res.rest_name FROM ".$prev."review as rev LEFT JOIN ".$prev."restaurant as res ON rev.rest_id = res.rest_id WHERE 1 ".$conds." ".$sortby;

 
  $result = mysql_query($sql);
 // $totalrow=mysql_num_rows($result);
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
		document.formListContainer.action="delete.php?menu_id=menu_id";
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
				 
                
				
            ],
			
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
		<div class="rightContHeading Heading">Manage Restaurant Review</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <div class="manageButtonLeft marginBot">
			<form name="restaurantmanage" method="post" action="manage_review.php?menuid=110&menupid=103" />
			<select class="restManageNameDrop" name="searchrestaurantid" id="searchrestaurant" onchange="document.restaurantmanage.submit();">
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
			<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.restaurantmanage.submit();">
				<option value="">Select</option>
				<optgroup label="Status">
                   <option value="Y" <? if($_REQUEST[sortby]=="Y"){echo "selected";}?>>&nbsp;&nbsp;Active</option>
                   <option value="N" <? if($_REQUEST[sortby]=="N"){echo "selected";}?>>&nbsp;&nbsp;Deactiv</option>
                  
				</optgroup>
				
			</select>
			</form>
		</div>

                
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
					<!--<a class="manageButton_addnw" href="add_menu.php?menuid=106&menupid=103&rest_id=<?=$_REQUEST['rest_id'];?>">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>-->
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');"  />
					<input type="button" class="manageButton but_delete" id="but_delete" value="Delete" style="display:none;" onclick="del();" />
				</div>
				<!--Button List End-->
				
				
				<div class="tableListContainer">
                <form name="formListContainer" id="formListContainer" action="">
					<table id="tableListContent" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
                    <thead>
					<tr class="listHeader">
					<td width="5%" align="center" class="listHeaderCont"><input type="checkbox" onclick="checkedAll(formListContainer)" /></td>
					<td width="5%" align="center" class="listHeaderCont">S.No</td>
					<td width="15%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('resdesc','','');">Restaurant						</a>
					</td>
					<td width="30%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('resdesc','','');">Review						</a>
					</td>
					<td width="15%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('mdesc','','');">Customer Name						</a>
					</td>

					
					<td width="12%" align="center" class="listHeaderCont">Review Date</td>
					<td width="8%" align="center" class="listHeaderCont">Status</td>
					<td width="10%" align="center" class="listHeaderCont">Action</td>
				</tr>
                            
                            </thead>
                            <tbody>
						<?php if($totalrow){
							  $i=1;
							  while($row=mysql_fetch_object($result)){

							 // print_r($row);
							?>
					
					<tr  id="deletecate1987">
					<td align="center" class="listCont"><span class="listContResta">
					  <input type='checkbox' name="chk[]" id="checkbox_id_<?=$row->menu_id ?>" class="checkbox_id"  value="<?php echo $row->menu_id?>"/>
					</span></td>
					<td align="center" class="listCont"><?php echo $i;?></td>
					<td align="left" class="listCont"><?php echo $row->rest_name;?></td>
					<td align="left" class="listCont"><?php echo $row->review;?></td>
					<td align="left" class="listCont">
					<?php
					$res_user=mysql_query("SELECT f_name,l_name FROM ".$prev."user WHERE user_id='$row->user_id'");
					$row_user=mysql_fetch_array($res_user);
					echo $row_user['f_name']." ".$row_user['l_name'];
					?>
					</td>
					
					<td align="center" class="listCont"><?php echo date('M d,Y',strtotime($row->cur_date));?></td>
				
					<td align="center" class="listCont" id="chgstatus1987">
					<?php if($row->status=='Y'){?>
                     <a href="manage_review.php?menuid=110&menupid=103&id=<?=$row->id?>&status=N">
                        <img src='images/icon_active.png' alt='Active' title='Active' style="cursor:pointer;"  />
                    </a>
                    <?php }else{?>
                    <a href="manage_review.php?menuid=110&menupid=103&id=<?=$row->id?>&status=Y">
                   <img src='images/delete.png' alt='Inactive' title='Inactive' style="cursor:pointer;"  />
                    </a>
                    <?php }?>
					</td>
					
					<td align="center" class="listCont">
						<span class="EditDeleteButton">
							<a href="manage_review_edit.php?menuid=110&menupid=103&id=<?=$row->id?>">
								<img src="images/icon_edit.png" width="16" height="16" alt="Edit" title="Edit" />
							</a>
						</span>&nbsp;
						<span class="EditDeleteButton">
							<a href="manage_review.php?menuid=110&menupid=103&id=<?=$row->id?>&act=del">
								<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete" onclick="return confirm('Are you sure want to delete?');" style="cursor:pointer;" />
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
				<!--<div class="manageButtonLastCont">
					<a class="manageButton_addnw thickbox" href="add_menu.php?menuid=106&menupid=103">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');" />
					<input type="button" class="manageButton but_delete" value="Delete" style="display:none;" onclick="adminActivateDeactivate('delete','deletefield','maincateid','rt_category_main','Main Category','category');" />
				</div>-->
				<!--Button List End-->
			
			</div>
		</div>

	</div>
</div>
<?
include("includes/footer.php");
?>
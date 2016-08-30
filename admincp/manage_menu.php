<?php
include("includes/access.php");
include("includes/header.php");

/******************************Popular****************************************/
if(isset($_REQUEST['menu_id'])){
	if(isset($_REQUEST['menu_spl_ins'])){
	   $update=mysql_query("UPDATE ".$prev."menu SET menu_spl_ins='".$_REQUEST['menu_spl_ins']."' WHERE menu_id=".$_REQUEST['menu_id']);	
	}
	
	if(isset($_REQUEST['status'])){
	   $update=mysql_query("UPDATE ".$prev."menu SET status='".$_REQUEST['status']."' WHERE menu_id=".$_REQUEST['menu_id']);	
	}
	
	

}
 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

	if($_REQUEST['searchrestaurantid']){

		$cond[]="rest_id='".$_REQUEST['searchrestaurantid']."'";
		//$parama.="&product_brand=".$_REQUEST[brand_id];
	}
	else if($_REQUEST['rest_id'])
	{
		$cond[]="menu.rest_id='".$_REQUEST['rest_id']."'";
	}
  
	if($_REQUEST[sortby])
	{
		echo $_REQUEST[sortby];
	   if($_REQUEST[sortby]=="Y"){
		   
		   $cond[]=" status='Y'";}	
	   if($_REQUEST[sortby]=="N"){$cond[]=" and status='N'";}	
	   if($_REQUEST[sortby]=="P"){$cond[]=" and status='P'";}	
	   if($_REQUEST[sortby]=="rasc"){$sortby=" order by rest_name asc";}
	   if($_REQUEST[sortby]=="rdesc"){$sortby=" order by rest_name desc";}
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
 $sql = "SELECT menu.memu_name,menu.menu_id,menu.menu_type,menu.menu_photo,menu.cur_date,res.rest_name,menu.cat_id,menu.menu_spl_ins,menu.status FROM ".$prev."menu as menu LEFT JOIN ".$prev."restaurant as res ON menu.rest_id = res.rest_id WHERE 1 ".$conds." ".$sortby;
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
				 { "bSortable": false },
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
		<div class="rightContHeading Heading">Manage Menu</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <div class="manageButtonLeft marginBot">
			<form name="restaurantmanage" method="post" action="manage_restaurant.php?menuid=105&menupid=103" />
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
                   <option value="P" <? if($_REQUEST[sortby]=="P"){echo "selected";}?>>&nbsp;&nbsp;Pending Activation</option>
				</optgroup>
				<optgroup label="Others">
                    <option value="rasc" <? if($_REQUEST[sortby]=="rasc"){echo "selected";}?>>&nbsp;&nbsp;Restaurant Name A to Z</option>
			        <option value="rdesc" <? if($_REQUEST[sortby]=="rdesc"){echo "selected";}?>>&nbsp;&nbsp;Restaurant Name Z to A</option>

                   

					
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
					<a class="manageButton_addnw" href="add_menu.php?menuid=106&menupid=103&rest_id=<?=$_REQUEST['rest_id'];?>">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>
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
					<td width="5%" align="center" class="listHeaderCont"><input type="checkbox" onclick="checkedAll(formListContainer)" /></td>
					<td width="5%" align="center" class="listHeaderCont">S.No</td>
					<td width="25%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('mdesc','','');">Menu Name						</a>
					</td>
					<td width="10%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('tdesc','','');">Type						</a>
					</td>
					<td width="10%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('cdesc','','');">Category						</a>
  </td>
										<td width="20%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('resdesc','','');">Restaurant						</a>
  </td>
										<td width="10%" align="center" class="listHeaderCont">Photo</td>
					<td width="10%" align="center" class="listHeaderCont">Added Date</td>
					<td width="5%" align="center" class="listHeaderCont">Popular</td>
					<td width="5%" align="center" class="listHeaderCont">Status</td>
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
					<td align="left" class="listCont"><?php echo $row->memu_name;?></td>
					<td align="left" class="listCont"><?php echo $row->menu_type;?></td>
					<td align="left" class="listCont"><?php $cat = getCategoryId($row->cat_id);echo $cat;?></td>
					<td align="left" class="listCont"><?php echo $row->rest_name;?></td>
					<td align="center" class="listCont"><img src="<?php echo $vpath.$row->menu_photo;?>" height="30" width="50"></td>
					<td align="center" class="listCont"><?php echo date('M d,Y',strtotime($row->cur_date));?></td>
					<td align="center" class="listCont">
						<?php if($row->menu_spl_ins=='Yes'){?>
                     <a href="manage_menu.php?menuid=105&menupid=103&menu_id=<?=$row->menu_id?>&menu_spl_ins=No">
                        <img src="images/star_yellow.png" alt="Payment Select" title="Payment Select"  style="cursor:pointer;" />
                    </a>
                    <?php }else{?>
                    <a href="manage_menu.php?menuid=105&menupid=103&menu_id=<?=$row->menu_id?>&menu_spl_ins=Yes">
                    <img src="images/star_grey.png" alt="barzahlung" title="barzahlung" class="imgborder" style="cursor:pointer;" />
                    </a>
                    <?php }?>
					</td>
					<td align="center" class="listCont" id="chgstatus1987">
					<?php if($row->status=='Y'){?>
                     <a href="manage_menu.php?menuid=105&menupid=103&menu_id=<?=$row->menu_id?>&status=N">
                        <img src='images/icon_active.png' alt='Active' title='Active' style="cursor:pointer;"  />
                    </a>
                    <?php }else{?>
                    <a href="manage_menu.php?menuid=105&menupid=103&menu_id=<?=$row->menu_id?>&status=Y">
                   <img src='images/delete.png' alt='Inactive' title='Inactive' style="cursor:pointer;"  />
                    </a>
                    <?php }?>
					</td>
					<td align="center" class="listCont">
						<span class="EditDeleteButton">
							<a href="add_menu.php?menuid=106&menupid=103&menu_id=<?php echo $row->menu_id;?>">
								<img src="images/icon_edit.png" width="16" height="16" alt="Edit" title="Edit" />
							</a>
						</span>
						<span class="EditDeleteButton">
							<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete" onclick="return changeStatus('delete','status','id','rt_restaurant_menu','Menu','1987');" style="cursor:pointer;" />
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
					<a class="manageButton_addnw thickbox" href="add_menu.php?menuid=106&menupid=103">Add New</a>
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
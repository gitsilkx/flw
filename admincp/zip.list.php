<?php
include("includes/access.php");
include("includes/header.php");



 /************************Delete***************************************************/	
if($_GET['del']):
//echo "delete from " .$prev."zip where zip_id=" . $_GET['zip_id'];
//die();
  mysql_query("DELETE FROM " .$prev."zip WHERE zip_id=" . $_GET['zip_id']);
  $_SESSION['succ_message']="Zipcode Deleted Successfully !!";
  pageRedirect('zip.list.php?menuid=116&menupid=113');
  exit();
endif;
/***********************End Delete**************************/

if(isset($_REQUEST['status'])){
	   $update=mysql_query("UPDATE ".$prev."zip SET status='".$_REQUEST['status']."' WHERE zip_id=".$_REQUEST['zip_id']);	
	}


 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

  
	if($_POST[sortby])
	{
	   if($_POST[sortby]=="Y"){$cond[]=" status='Y'";}	
	   if($_POST[sortby]=="N"){$cond[]=" status='N'";}	
	   if($_POST[sortby]=="rasc"){$sortby=" ORDER BY zip_code asc";}
	   if($_POST[sortby]=="rdesc"){$sortby=" ORDER BY zip_code desc";}
	 // $parama.="&shortby=".$_POST[shortby];
	}
/***********************End Search**************************/


	if(count($cond))
	{
		if($_POST['search'])
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

  $sql="SELECT * FROM ".$prev."zip  WHERE 1 ".$conds." ".$sortby;
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
	if(confirm('Are you sure you want to delete all Zip Codes?')==true)
	{
		document.formListContainer.method="post";
		document.formListContainer.action="delete.php?zip_id=zip_id";
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
		<div class="rightContHeading Heading">Manage Zip</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <div class="manageButtonLeft marginBot">
			<form name="restaurantmanage" method="post" action="zip.list.php?menuid=116&menupid=113" />
		
			<span class="restManageNameSort">Sort By</span><span class="restManageCol">:</span>
			<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.restaurantmanage.submit();">
				<option value="">Select</option>
				<optgroup label="Status">
                   <option value="Y" <? if($_POST[sortby]=="Y"){echo "selected";}?>>&nbsp;&nbsp;Active</option>
                   <option value="N" <? if($_POST[sortby]=="N"){echo "selected";}?>>&nbsp;&nbsp;Deactiv</option>
				</optgroup>
				<optgroup label="Others">
                    <option value="rasc" <? if($_POST[sortby]=="rasc"){echo "selected";}?>>&nbsp;&nbsp;Zip Code A to Z</option>
			        <option value="rdesc" <? if($_POST[sortby]=="rdesc"){echo "selected";}?>>&nbsp;&nbsp;Zip Code Z to A</option>

                   

					
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
					<a class="manageButton_addnw" href="zip.entryform.php?menuid=116&menupid=113">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');"  />
					<input type="button" class="manageButton but_delete" id="but_delete" value="Delete" style="display:none;" onclick="del();" />
				</div>
				<!--Button List End-->
				<!--Pagination Start-->
				
				<!--Pagination End-->
				<!--List Start-->
                <form name="formListContainer" id="formListContainer" action="">
				<div class="tableListContainer">
				<table id="tableListContent" width="100%" align="left" class="sort-table" border="0" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
				<thead>
				<tr class="listHeader">
					<td width="3%" align="center" class="listHeaderCont"><input type="checkbox" onclick="checkedAll(formListContainer)" /></td>
					<td width="7%" align="center" class="listHeaderCont">S.No</td>
					<td width="10%" align="left" class="listHeaderCont">
						<a onclick="sortByAscDesc('zdesc','','');" href="javascript:void(0);">Zipcode						</a>
				  </td>
					<td width="10%" align="left" class="listHeaderCont">
						<a onclick="sortByAscDesc('sdesc','','');" href="javascript:void(0);">State Code						</a>
				  </td>				
					<td width="30%" align="left" class="listHeaderCont">
						<a onclick="sortByAscDesc('adesc','','');" href="javascript:void(0);">Area Name						</a>
				  </td>
					<td width="10%" align="center" class="listHeaderCont">
						<a onclick="sortByAscDesc('idesc','','');" href="javascript:void(0);">Zipcode Id						</a>
				  </td>
					<td width="15%" align="center" class="listHeaderCont">Added Date</td>
					<td width="5%" align="center" class="listHeaderCont">Status</td>
					<td width="10%" align="center" class="listHeaderCont">Action</td>
				</tr>
                </thead>
                <tbody>
                <?php if($totalrow){
							$i=1;
							while($row=mysql_fetch_object($resut)){
							?>
					<tr id="deletecate346">
					<td align="center" class="listCont"><span class="listContResta">
					  <input type='checkbox' name="chk[]" id="checkbox_id_<?=$row->zip_id ?>" class="checkbox_id"  value="<?php echo $row->zip_id?>"/>
					</span></td>
					<td align="center" class="listCont"><?=$i?></td>
					<td align="left" class="listCont"><?=$row->zip_code?></td>
					<td align="left" class="listCont"><?=getstatecodeById($row->state_id)?></td>
					<td align="left" class="listCont"><?=$row->area_name?></td>
					<td align="center" class="listCont"><?=$row->zip_id?></td>
					<td align="center" class="listCont"><?php echo date("M j, Y",strtotime($row->cur_date)); ?></td>
					
					<td align="center" class="listCont" id="chgstatus1987">
					<?php if($row->status=='Y'){?>
                     <a href="zip.list.php?menuid=116&menupid=113&zip_id=<?=$row->zip_id?>&status=N">
                        <img src='images/icon_active.png' alt='Active' title='Active' style="cursor:pointer;"  />
                    </a>
                    <?php }else{?>
                    <a href="zip.list.php?menuid=116&menupid=113&zip_id=<?=$row->zip_id?>&status=Y">
                   <img src='images/delete.png' alt='Inactive' title='Inactive' style="cursor:pointer;"  />
                    </a>
                    <?php }?>
					</td>
					
					<td align="center" class="listCont">
						<span class="EditDeleteButton">
							<a href="zip.entryform.php?menuid=116&menupid=113&zip_id=<?php echo $row->zip_id; ?>">
								<img width="16" height="16" title="Edit" alt="Edit" src="images/icon_edit.png" border="0">
							</a>
						</span>
						<span class="EditDeleteButton">
                            <a href="<?=$_SERVER['PHP_SELF']?>?zip_id=<?=$row->zip_id?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete this record?')">
							<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete"  border="0" style="cursor:pointer;" />
                            </a>
                        </span>
					</td>
				</tr>
												
                 <?php
						      $i++; } 
							} else {?>
                       <tr class="listLightGray">
						  <td colspan="9" align="center" class="listCont">No record found</td>
					  </tr>
                            <?php }?>
							</tbody></table>
    </div>
    			</form>
				<!--List End-->
				<!--Pagination start-->
				
				<!--Pagination End-->
				<div class="clr"></div>
				<!--Button List start-->
				<div class="manageButtonLastCont">
					<a class="manageButton_addnw thickbox" href="zip.entryform.php?menuid=116&menupid=113">Add New</a>
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
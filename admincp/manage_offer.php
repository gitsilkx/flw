<?php
include("includes/access.php");
include("includes/header.php");
 /************************Delete***************************************************/	
if($_REQUEST['del']):
  mysql_query("delete from " .$prev."offer where offer_id=" . $_GET['offer_id']);
  $_SESSION['succ_message']='Deleted successfully';
  pageRedirect('manage_offer.php?menuid=107&menupid=103');
endif;

if(isset($_REQUEST['status'])){
	   $update=mysql_query("UPDATE ".$prev."offer SET status='".$_REQUEST['status']."' WHERE offer_id=".$_REQUEST['offer_id']);	
	   $_SESSION['succ_message']='Status Updated successfully';
	}
	
/***********************End Delete**************************/
 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

	if($_REQUEST['searchrestaurantid']){

		$cond[]="rest_id='".$_REQUEST['searchrestaurantid']."'";
		//$parama.="&product_brand=".$_REQUEST[brand_id];
	}
	else if($_REQUEST['rest_id'])
	{
		$cond[]="rest_id='".$_REQUEST['rest_id']."'";
	}
  
	if($_REQUEST[sortby])
	{
		//echo $_REQUEST[sortby];
	   if($_REQUEST[sortby]=="Y"){$cond[]=" status='Y'";}	
	   if($_REQUEST[sortby]=="N"){$cond[]=" status='N'";}	
	   if($_REQUEST[sortby]=="P"){$cond[]=" status='P'";}	
	   if($_REQUEST[sortby]=="rasc"){$sortby=" order by offer_id asc";}
	   if($_REQUEST[sortby]=="rdesc"){$sortby=" order by offer_id desc";}
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

  $sql="SELECT * FROM ".$prev."offer where 1 ".$conds." ".$sortby;
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
	if(confirm('Are you sure you want to delete all Offers?')==true)
	{
		document.formListContainer.method="post";
		document.formListContainer.action="delete.php?offer_id=offer_id";
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
                 { "bSortable": false },
                 null,
				 null,
				 null,
				 null,
				null,
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
		<div class="rightContHeading Heading">Manage Offer</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <div class="manageButtonLeft marginBot">
			<form name="offermanage" method="post" action="manage_offer.php?menuid=107&menupid=103" />
			<select class="restManageNameDrop" name="searchrestaurantid" id="searchrestaurant" onchange="document.offermanage.submit();">
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
			<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.offermanage.submit();">
				<option value="">Select</option>
				<optgroup label="Status">
                   <option value="Y" <? if($_REQUEST[sortby]=="Y"){echo "selected";}?>>&nbsp;&nbsp;Active</option>
                   <option value="N" <? if($_REQUEST[sortby]=="N"){echo "selected";}?>>&nbsp;&nbsp;Deactive</option>
                   <option value="P" <? if($_REQUEST[sortby]=="P"){echo "selected";}?>>&nbsp;&nbsp;Pending Activation</option>
				</optgroup>
				<optgroup label="Others">
                    <option value="rasc" <? if($_REQUEST[sortby]=="rasc"){echo "selected";}?>>&nbsp;&nbsp;offer Name A to Z</option>
			        <option value="rdesc" <? if($_REQUEST[sortby]=="rdesc"){echo "selected";}?>>&nbsp;&nbsp;offer Name Z to A</option>

                   

					
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
				<!--<div  class="manageButtonLeft">-->
										<!--Filter-->
					<!--<div class="filterbutton" onclick="return filterOptShowHide();">Filter<img src="images/icon_plus.png" alt="Filter" title="Filter" /></div>
					<div class="fliterbuttonContShow processButton" id="searchkey" style="display:none;">
						<form name="filterform" method="post" onsubmit="return filterValidation();">
							<input type="hidden" name="action"  value="filterProcess" />
							
							Keyword:
							<input type="text" name="keyword" id="keyword" value="" class="textboxFilter">
							<input type="submit" name="filter" value="Filter" class="buttonFilter">
							<input type="button" name="clear" value="Clear" class="buttonFilter" id="clear" onclick="return clearFilterTxtBox();">		 
						</form>	 
					</div>-->
					<!--Export-->
					<!--<div class="filterbutton" onclick="return exportOptShowHide();">Export<img src="images/icon_plus.png" alt="Export" title="Export" /></div>-->
					<!--<div class="fliterbuttonContShow processButton" id="export" style="display:none;">
						<form name="exportform" method="post" onsubmit="return exportValidation();">
							<input type="hidden" name="action"  value="exportProcess" />
									
							<select name="exportfile" id="exportfile">				 	 
								<option value="CSV">CSV</option>
								<option value="Excel">Excel</option>	
							</select>
							<input type="submit" name="export" value="Export" class="buttonFilter" />	
						</form>				 
					</div>-->
										<!--Import-->
					<!--<div class="filterbutton" onclick="return importOptShowHide();">Import<img src="images/icon_plus.png" alt="Import" title="Import" /></div>-->
					<!--<div class="fliterbuttonContShow processButton" id="import" style="display:none;">
						<form name="importform" method="post"  enctype="multipart/form-data" onsubmit="return importValidation();" >
							<input type="hidden" name="action" value="importProcess" />	
							
							 <input type="file" name="importfile" id="importfile" />
							 <input type="radio" name="rd_import"  value="emptab" />&nbsp;Empty table
							 <input type="radio" name="rd_import"  value="upttab" checked="checked" />&nbsp;Update table	         
							 <input type="submit" name="submitImport" value="Import" class="buttonFilter" />
									 
						</form>
				  </div>
				</div>-->
				<!--Button Left End-->
                
                <div  class="manageButtonLeft" style="width:700px; text-align:center;">
                <?php if(isset($_SESSION['succ_message'])){?>
                <strong style="color:#006600;"><?php echo $_SESSION['succ_message']; unset($_SESSION["succ_message"]);?></strong>
                <?php }if(isset($_SESSION['err_message'])){?>
                <strong style="color:#900;"><?php echo $_SESSION['err_message']; unset($_SESSION["err_message"]);?></strong>
                <?php }?>
                </div>
                
				<!--Button Right start-->
				<div class="manageButtonLastCont">
					<!--<a class="manageButton_addnw thickbox" href="categoryAddEdit.php?height=300&width=700">Add New</a>-->
					<a class="manageButton_addnw" href="add_offer.php?menuid=107&menupid=103&rest_id=<?=$_REQUEST['rest_id'];?>">Add New</a>
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
					<td width="15%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('perdesc','','');">Offer Percentage(%)<img src="images/icon_arrow_up.png" alt="" title="Ascending" />						</a>
					</td>
					<td width="10%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('pricedesc','','');">Offer Price<img src="images/icon_arrow_up.png" alt="" title="Ascending" />						</a>
					</td>
					<td width="10%" align="left" class="listHeaderCont">Offer From</td>
					<td width="10%" align="left" class="listHeaderCont">Offer To</td>
										<td width="15%" align="left" class="listHeaderCont"><a href="javascript:void(0);" onclick="sortByAscDesc('rdesc','','');">Resturant<img src="images/icon_arrow_up.png" alt="" title="Ascending" />						</a>
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
					
						<tr  id="deletecate5">
					<td align="center" class="listCont"><span class="listContResta">
					  <input type='checkbox' name="chk[]" id="checkbox_id_<?=$row->offer_id ?>" class="checkbox_id"  value="<?php echo $row->offer_id?>"/>
					</span></td>
					<td align="center" class="listCont"><?=$i?></td>
					<td align="left" class="listCont"><?php echo $row->offer_percentage; ?></td>
					<td align="left" class="listCont"><?php echo $row->offer_price; ?></td>
					<td align="left" class="listCont"><?php echo date("d-m-Y",strtotime($row->offer_valid_from)); ?></td>
					<td align="left" class="listCont"><?php echo date("d-m-Y",strtotime($row->offer_valid_to)); ?></td>
										<td align="left" class="listCont"><?php echo getRestuarantnameById($row->rest_id); ?></td>
										<td align="center" class="listCont"><?php echo date("M j, Y",strtotime($row->cur_date)); ?></td>
					
					<td align="center" class="listCont" id="chgstatus1987">
					<?php if($row->status=='Y'){?>
                     <a href="manage_offer.php?menuid=107&menupid=103&offer_id=<?=$row->offer_id?>&status=N">
                        <img src='images/icon_active.png' alt='Active' title='Active' style="cursor:pointer;"  />
                    </a>
                    <?php }else{?>
                    <a href="manage_offer.php?menuid=107&menupid=103&offer_id=<?=$row->offer_id?>&status=Y">
                   <img src='images/delete.png' alt='Inactive' title='Inactive' style="cursor:pointer;"  />
                    </a>
                    <?php }?>
					</td>
					
					<td align="center" class="listCont">
						<span class="EditDeleteButton">
							<a href="add_offer.php?menuid=107&menupid=103&offer_id=<?php echo $row->offer_id; ?>">
								<img src="images/icon_edit.png" width="16" height="16" border="0" alt="Edit" title="Edit" />
							</a>
						</span>
						<span class="EditDeleteButton">
                    <a href="<?=$_SERVER['PHP_SELF']?>?offer_id=<?=$row->offer_id?>&del=1" class='lnk'  onclick="return confirm('Are you sure you want to delete?')">
							<img src="images/icon_delete.png" width="14" height="14" alt="Delete" title="Delete"  border="0" style="cursor:pointer;" />
                            </a>
						</span>
					</td>
				</tr>
                        
                        <?php
						      $i++; } 
							} else {?>
                       <tr class="listLightGray">
						  <td colspan="10" align="center" class="listCont">No record found</td>
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
					<a class="manageButton_addnw thickbox" href="add_offer.php?menuid=107&menupid=103">Add New</a>
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
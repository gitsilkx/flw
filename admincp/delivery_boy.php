<?php
include("includes/access.php");
include("includes/header.php");

/******************************Popular****************************************/
if(isset($_REQUEST['id'])){
	
	
	if($_REQUEST['act']=="del"){
	   $delete=mysql_query("DELETE FROM ".$prev."delivery_boy WHERE id=".$_REQUEST['id']);
		if($delete)
		{
		$_SESSION['succ_message']="Delivery Boy Deleted Successfully !!";
		}
	}
	
}
 /************************Search***************************************************/	
  $sortby='';$cond=array();$parama="";

	if($_REQUEST['searchrestaurantid']){

		$cond[]=" id='".$_REQUEST['searchrestaurantid']."'";
		//$parama.="&product_brand=".$_REQUEST[brand_id];
	}
	
  
	if($_REQUEST[sortby])
	{
		echo $_REQUEST[sortby];
	   if($_REQUEST[sortby]=="Y"){$cond[]=" status='Y'";}	
	   if($_REQUEST[sortby]=="N"){$cond[]=" status='N'";}	
	 
	  
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

  $sql="SELECT count(id) cnt FROM ".$prev."delivery_boy WHERE 1 ".$conds." ".$sortby;
  $resut=mysql_query($sql);
  $totalrow=mysql_num_rows($resut);
  
 //================================For Menu Select=====================================================	
 
  $sql = "SELECT * FROM ".$prev."delivery_boy WHERE 1 ".$conds." ".$sortby;

 
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
                 { "bSortable": false },
                 null,
                 null,
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
		<div class="rightContHeading Heading">Manage Delivery Boy</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							

                
                <div  class="manageButtonLeft" style="width:400px; text-align:center;">
                <?php if(isset($_SESSION['succ_message'])){?>
                <strong style="color:#006600;"><?php echo $_SESSION['succ_message']; unset($_SESSION["succ_message"]);?></strong>
                <?php }if(isset($_SESSION['err_message'])){?>
                <strong style="color:#900;"><?php echo $_SESSION['err_message']; unset($_SESSION["err_message"]);?></strong>
                <?php }?>
                </div>
                
				<!--Button Right start-->
				<div class="manageButtonLastCont">
					<a class="manageButton_addnw thickbox" href="add_delivery_boy.php?menuid=136&menupid=103">Add New</a>
					<input type="button"  class="manageButton but_activate" value="Activate" onclick="adminActivateDeactivate('1','status','maincateid','rt_category_main','Main Category');" style="display:none;"/>
					<input type="button" class="manageButton but_deactivate" value="Deactivate" style="display:none;" onclick="adminActivateDeactivate('0','status','maincateid','rt_category_main','Main Category');" />
					<input type="button" class="manageButton but_delete" value="Delete" style="display:none;" onclick="adminActivateDeactivate('delete','deletefield','maincateid','rt_category_main','Main Category','category');" />
				</div>
				<!--Button List End-->
				
				
				<div class="tableListContainer">
                <form name="formListContainer" id="formListContainer" action="">
					<table id="tableListContent" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
                    <thead>
					<tr class="listHeader">
					<td width="5%" align="center" class="listHeaderCont"><input type="checkbox" onclick="checkedAll(formListContainer)" /></td>
					<td width="5%" align="center" class="listHeaderCont">S.No</td>
					<td width="50%" align="left" class="listHeaderCont">
						<a href="javascript:void(0);" onclick="sortByAscDesc('resdesc','','');">Delivery Boy Name</a>
					</td>
					<td width="20%" align="center" class="listHeaderCont">Review Date</td>
					<td width="20%" align="center" class="listHeaderCont">Action</td>
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
					  <input type='checkbox' name="chk[]" id="checkbox_id_<?=$row->id ?>" class="checkbox_id"  value="<?php echo $row->id?>"/>
					</span></td>
					<td align="center" class="listCont"><?php echo $i;?></td>
					<td align="left" class="listCont"><?php echo $row->name;?></td>	
					<td align="center" class="listCont"><?php echo date('M d,Y',strtotime($row->cur_date));?></td>
					
					<td align="center" class="listCont">
						<span class="EditDeleteButton">
							<a href="add_delivery_boy.php?menuid=136&menupid=103&id=<?=$row->id?>">
								<img src="images/icon_edit.png" width="16" height="16" alt="Edit" title="Edit" />
							</a>
						</span>&nbsp;
						<span class="EditDeleteButton">
							<a href="delivery_boy.php?menuid=136&menupid=103&id=<?=$row->id?>&act=del">
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
				<div class="manageButtonLastCont">
					<a class="manageButton_addnw thickbox" href="add_delivery_boy.php?menuid=136&menupid=103">Add New</a>
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
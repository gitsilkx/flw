<?php
include("includes/access.php");
include("includes/header.php");


if(isset($_REQUEST['rest_id'])){
	if(isset($_REQUEST['cod'])){
	   $update=mysql_query("UPDATE ".$prev."restaurant SET cod='".$_REQUEST['cod']."' WHERE rest_id=".$_REQUEST['rest_id']);	
	}
	if(isset($_REQUEST['paypal'])){
	   $update=mysql_query("UPDATE ".$prev."restaurant SET paypal='".$_REQUEST['paypal']."' WHERE rest_id=".$_REQUEST['rest_id']);	
	}
}

/*************************End pagination*******************************/	


 $sql="SELECT `cod`,`paypal`,`rest_id` FROM ".$prev."restaurant where rest_id='".$_REQUEST['rest_id']."' ";
  $resut=mysql_query($sql);
  $row=mysql_fetch_object($resut);
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
		<div class="rightContHeading Heading">Manage Main Category</div>
		<div class="rightContBody">
			<div class="riteContWrap1">	
							<!-- Sort By -->
                <!--<div class="manageButtonLeft marginBot">
			<form name="offermanage" method="post" action="manage_payment.php?menuid=105&menupid=103" />
						    <input type="hidden" name="rest_id" value="<?php echo $row->rest_id;?>">

			<span class="restManageNameSort">Sort By</span><span class="restManageCol">:</span>
			<select class="restManageNameDrop" name="sortby" id="sortby" size="1" onchange="document.offermanage.submit();">
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
                
                
                
				<!--Button Right start-->
				
				<!--Button List End-->
				<!--Pagination Start-->
				
				<!--Pagination End-->
				<!--List Start-->
				<div class="tableListContainer">
                <form name="formListContainer" id="formListContainer" action="<?php echo $_SERVER['PHP_SELF']?>?menuid=105&menupid=103">
            <table id="tableListContent" width="100%" class="sort-table" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>">
                    <thead>
					<tr class="listHeader">
					<td width="7%" align="center" class="listHeaderCont">S.No</td>
					<td width="30%" align="left" class="listHeaderCont">Payment Name</td>
										<td width="15%" align="center" class="listHeaderCont">Payment Method</td>
										<td width="15%" align="center" class="listHeaderCont">Payment Photo</td>
									</tr>
                            
                            </thead>
                            <tbody>

                      <?php if($totalrow){?>
						<tr >
					<td align="center" class="listCont">1</td>
					<td align="left" class="listCont">Cash On Delivery</td>
										<td align="center" class="listCont">
                                        <?php if($row->cod=='Y'){?>
                                             <a href="manage_payment.php?menuid=105&menupid=103&rest_id=<?=$row->rest_id?>&cod=N">
												<img src="images/star_yellow.png" alt="Payment Select" title="Payment Select"  style="cursor:pointer;" />
											</a>
											<?php }else{?>
                                            <a href="manage_payment.php?menuid=105&menupid=103&rest_id=<?=$row->rest_id?>&cod=Y">
                                            <img src="images/star_grey.png" alt="barzahlung" title="barzahlung" class="imgborder" />
											</a>
                                            <?php }?>
                                            
                                            </td>
										<td align="center" class="listCont">
								<img src="images/thumb_cash.jpg" alt="COD" title="COD" class="imgborder" />
                            
											</td>
									</tr>
                                   
                                    <tr >
					
					<td align="center" class="listCont">2</td>
					<td align="left" class="listCont">Paypal</td>
										<td align="center" class="listCont">
                                        <?php if($row->paypal=='Y'){?>
                                        <a href="manage_payment.php?menuid=105&menupid=103&rest_id=<?=$row->rest_id?>&paypal=N">
												<img src="images/star_yellow.png" alt="Payment Delete" title="Payment Delete" onclick="return selectPaymentMethod('Yes','paymentmethod','paymentinfo_id','rt_paymentinfo','Paymentinfo','2','201','1');" style="cursor:pointer;" />
										</a>
										<?php }else{?>
                                        <a href="manage_payment.php?menuid=105&menupid=103&rest_id=<?=$row->rest_id?>&paypal=Y">
                                            <img src="images/star_grey.png" alt="barzahlung" title="barzahlung" class="imgborder" />
										</a>
                                            <?php }?>
                                            </td>
										<td align="center" class="listCont">
													<div class="largeImgTooltip">
								<img src="images/thumb_paypal.jpg" alt="Paypal" title="Paypal" class="imgborder" />
							</div>
											</td>
									</tr>
                                    <?php }else{?>
                                     <tr >
                                      <td colspan="4" align="center" class="listCont">No records found</td>
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
				
				<!--Button List End-->
			
			</div>
		</div>
	</div>
</div>
<?
include("includes/footer.php");
?>
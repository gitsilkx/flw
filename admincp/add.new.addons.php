<?php
include("includes/access.php");
include("includes/header.php");



?>
 
	<!--Script for validation-->
	
	<script language="javascript">
		<!--
		
		function ValidProd()
			{
				var txt="";
				if(document.getElementById('addons_name').value=='')
				{
					txt+="  Addons name should not be empty.\n"
				}
				if(txt)
				{
					alert("Sorry!! you left some mandatory fields :\n\n"+ txt +"\n     Please Check");
					return false;
				}
				return true;	
			}//-->
		</script>
     <script type="text/javascript">
			var intTextBox=0;
			var count=0;
			$(document).ready(function(){
				count = $('#counts').val()*1; 
				})
			//var counts = document.getElementById('counts').value();
			//alert(counts);
			//FUNCTION TO ADD TEXT BOX ELEMENT
			function addElement()
			{
			if(count!=0)
			{
				count = count + 1;
				var contentID = document.getElementById('content');
				var newTBDiv = document.createElement('div');
				newTBDiv.setAttribute('id','strText'+count);
				newTBDiv.innerHTML = "<input  type='text' id='" + count + "' name='subaddons[]' placeholder='Enter Name'/>&nbsp;<input  type='text' id='" + intTextBox + "' name='subaddonsprice[]' placeholder='Enter Price(Rs)'/>&nbsp;<a href='javascript:removeElement();' style='text-decoration:none;' >Remove</a>"; 
				/*var brk=document.createElement('br')
				contentID.appendChild(brk)   */    
				contentID.appendChild(newTBDiv);
			}
			else
			{
				intTextBox = intTextBox + 1;
				var contentID = document.getElementById('content');
				var newTBDiv = document.createElement('div');
				newTBDiv.setAttribute('id','strText'+intTextBox);
				newTBDiv.innerHTML = "<input  type='text' id='" + intTextBox + "' name='subaddons[]' placeholder='Enter Name'/>&nbsp;<input  type='text' id='" + intTextBox + "' name='subaddonsprice[]' placeholder='Enter Price(Rs)'/>&nbsp;<a href='javascript:removeElement();' style='text-decoration:none;' >Remove</a>"; 
				/*var brk=document.createElement('br')
				contentID.appendChild(brk)   */    
				contentID.appendChild(newTBDiv);
			}
			
			}
			
			//FUNCTION TO REMOVE TEXT BOX ELEMENT
			function removeElement()
			{
			if(count!=0)
				{
					var contentID = document.getElementById('content');
					contentID.removeChild(document.getElementById('strText'+count));
					count = count-1;
				}
			else
				{
				if(intTextBox != 0)
					{
					var contentID = document.getElementById('content');
					contentID.removeChild(document.getElementById('strText'+intTextBox));
					intTextBox = intTextBox-1;
					}
				}
			}
	
		function delsubAddons(ids)
		{
	    if(window.confirm('Would you like to remove this already added Addon?')==true)
		{
		var addons_id=$('#addons_id'+ids).val(); 
		var sub_addons_id=$('#sub_addons_id'+ids).val(); 
		//alert(sub_addons_id);
		
	  	var dataString='sub_addons_id='+sub_addons_id+'&addons_id='+addons_id;
				 $.ajax({
					type:"POST",
					data:dataString,
					url:"<?=$vpath?>ajax/delsubaddons.php",
					beforeSend:function(data){ $('#msgs'+ids).html('Please wait...');},
					success:function(return_data)
					{
						$('#content').html(return_data);
					}
				});
		}
			
		}
<!-------------------- Tooltip---------->
		$(function() {
$( document ).tooltip();
});
</script>

<?php

if($_REQUEST[Update])
{
 
	if(!$_REQUEST['addons_id'])
	{
		
	     $insert_query = "insert into " .$prev."addons set 
		cat_id='" . mysql_real_escape_string($_POST['category_type_id']) .  "',
		restaurent_id='" . mysql_real_escape_string($_POST['product_type_id']) .  "',
		addons_price='" . mysql_real_escape_string($_POST['addons_price']) .  "',
		addons_name='" . mysql_real_escape_string($_POST['addons_name']) .  "',
		status='".mysql_real_escape_string($_POST['addons_status'])."', cur_date=now()";		
		
		
		$r=mysql_query($insert_query);
		$addons_id=mysql_insert_id();
		
		$count_subaddons=$_POST['subaddons'];
		$count_subaddonsprice=$_POST['subaddonsprice'];
		if(count($count_subaddons)>0)
		{
			for($i=0;$i<count($count_subaddons);$i++)
			{
			$insert_query_sub = mysql_query("insert into " .$prev."sub_addons set addons_id=".$addons_id.",sub_addons_name='".$count_subaddons[$i]."',sub_addons_price='".$count_subaddonsprice[$i]."',cur_date=CURDATE()");
			}
		}
		else
		{
		$_SESSION['succ_message'] = "You can add subaddons later for <blink><font color=red>".$_POST['addons_name']."</font></blink> !!</br>";
		}
		
		if($r)
		{
		$_SESSION['succ_message'] .= "Addons Inserted Successfully !!";
		pageRedirect('addons.list.php?menuid=127&menupid=125');
		}
		
	}
   	else
	{
   		  $upd_query = "update ".$prev."addons set 
		addons_name='".mysql_real_escape_string($_POST['addons_name']) ."',
		addons_price='" . mysql_real_escape_string($_POST['addons_price']) .  "',
		cat_id='" . mysql_real_escape_string($_POST['category_type_id']) .  "',
		restaurent_id='". mysql_real_escape_string($_POST['product_type_id']) ."',
		status='".mysql_real_escape_string($_POST['addons_status'])."',cur_date=now()
		where addons_id='".mysql_real_escape_string($_POST['addons_id'])."'";
		
		
		$count_subaddons=$_POST['subaddons'];
		$count_subaddonsprice=$_POST['subaddonsprice'];
		
		if(count($count_subaddons)>0)
		{
			$del_query_sub = mysql_query("delete from " .$prev."sub_addons where addons_id=".$_POST['addons_id']);
			for($i=0;$i<count($count_subaddons);$i++)
			{
			
			$insert_query_sub = mysql_query("insert into " .$prev."sub_addons set addons_id=".$_POST['addons_id'].",sub_addons_name='".$count_subaddons[$i]."',sub_addons_price='".$count_subaddonsprice[$i]."',cur_date=CURDATE()");
			}
		}
		else
		{
		$_SESSION['succ_message'] = "You can update subaddons later for <blink><font color=red>".$_POST['addons_name']."</font> </blink>!!</br>";
		}
		
		$r=mysql_query($upd_query) or die("Error :". mysql_error());
		
		//$addons_id=$_REQUEST['addons_id'];
		
		if($r)
		{
		$_SESSION['succ_message'] .= "Addons Updated Successfully !!";
		pageRedirect('addons.list.php?menuid=127&menupid=125');
		}
	   
	}
	/*if($r)
	{
		$msg = "<font color='green'>Data Updated Successfully</font>";
	}
	else
	{
		$msg = "<font color='red'>Sorry. There is some error.</font>";
	}*/
}
	
   	   

if($_REQUEST['addons_id'])
{
	$addons_id=$_REQUEST['addons_id'];
	$r=mysql_query("select * from ".$prev."addons where addons_id=" . $addons_id);
	$d=@mysql_fetch_array($r);
	
	$restaurent_id=$d['restaurent_id'];//by 10.09.13
	
}
  // start By 10.09.13
if($_REQUEST['rest_id']){
	$restaurent_id=$_REQUEST['rest_id'];
}
// end
if($msg):
   echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" .$msg . "</div></td></tr></table><br>"; 
endif;
?>
<script>
function addRestaurantAddonsValidate()
{
	//alert('aaaaaa');
	var txt = '';
	if(document.getElementById('product_type_id').value == "") {
			$("#resResNameAddErr").html("Please select Restaurant Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resResNameAddErr").html("");
	}
	if(document.getElementById('category_type_id').value == "") {
			$("#resAddCatErr").html("Please select Category");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resAddCatErr").html("");
	}
	if(document.getElementById('addons_price').value == "") {
			$("#resAddPrErr").html("Please enter Addons Price");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resAddPrErr").html("");
	}
	if(document.getElementById('addons_name').value == "") {
			$("#resNameAddErr").html("Please enter Addons Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNameAddErr").html("");
	}
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
}
</script>
	
    <div class="adminRight">
<div class="rightContHeading Heading"> Add New Addons</div>
<div class="rightContBody">
	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewResOffr" method="post" action="" onsubmit=" return addRestaurantAddonsValidate(); " >
			<input type="hidden" name="addons_id" id="addons_id" value="<?=$_GET['addons_id']?>">
			<!--<input type="hidden" name="resid" id="resid" value="">
			<input type="hidden" name="action" value="Add">-->
				<div class="addPageCont">
				<span class="addPageRightFont">Restaurant <a class='lnkred'>*</a> :</span>
				<span class="colon1">:</span>
                <? $res_type=mysql_query("select * from ".$prev."restaurant where status='Y' order by rest_name");?>
<select name="product_type_id" class="selectbx" id="product_type_id" style="width:304px;" <?php if($_REQUEST['rest_id']){?> disabled="disabled" <?php }?> >
				<option value="">Select Product Type</option>
        		<?
        			 while($row_type=mysql_fetch_array($res_type))
        				{
				?><option value="<?=$row_type['rest_id']?>" <? if($row_type['rest_id']==$restaurent_id){?> selected="selected" <? }?>><?=$row_type['rest_name']?></option>
				<?
						}

				?>
              
        		</select>
                
				<div class="tooltip"><div class="HelpButton" title="Select Restaurant Name">?</div>
                </div>
                <span class="errClass" id="resResNameAddErr"></span>
			</div>
						
			<div class="addPageCont">
					<span class="addPageRightFont">Category <span class="color1">*</span></span>
					<span class="colon1">:</span>
                    <? $res_type=mysql_query("select * from ".$prev."category where status='Y' order by cat_name");?>
					<select name="category_type_id" id="category_type_id" style="width:304px;" class="selectbx" >
                    <option value="">Select</option>
					<?
                    while($row_type=mysql_fetch_array($res_type))
					{
					?>

			<option value="<?=$row_type['cat_id']?>" <? if($row_type['cat_id']==$d['cat_id']){?> selected="selected" <? }?>><?=$row_type['cat_name']?></option>
					<? 
					}
					?>
				</select>
					<script type="text/javascript">document.addNewResOffr.offer_percentage.focus();</script>
					<div class="tooltip"><div class="HelpButton" title="Enter Category Name">?</div></div>
					<!--<input type="hidden" name="offer_id" id="offer_id" value="" />-->
                    <span class="errClass" id="resAddCatErr"></span>
			</div>
			<?php
			$res_addons=mysql_query("select * from ".$prev."sub_addons where addons_id='".$_GET['addons_id']."' order by sub_addons_name");
			?>
            <div class="addPageCont">
                <span class="addPageRightFont">Addons Price <a class='lnkred'>*</a></span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont">
                <input name="addons_price" type="text" id="addons_price" class="textbox" value="<?=$d['addons_price']?>" >
                </span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Enter Addons Price">?</div></div>
                <span class="errClass" id="resAddPrErr"></span>
            </div>
            <div class="addPageCont">
					<span class="addPageRightFont">Addons Name <a class='lnkred'>*</a></span>
					<span class="colon1">:</span>
				<input name="addons_name" type="text" id="addons_name" class="textbox" value="<?=$d['addons_name']?>" >
					<div class="tooltip"><div class="HelpButton" title="Enter Addons Name">?</div></div>
                    <a href="javascript:addElement();" style='text-decoration:none;'>Add Sub Addons <input type="hidden" id="counts" name="counts" value="<?=mysql_num_rows($res_addons)?>" /></a> 
                    <span class="errClass" id="resNameAddErr"></span>
                    <br />
                    <div id="content" style="margin:22px;" align='center'>
                    <?php
					$i=0;
					while($row_addons=mysql_fetch_array($res_addons))
					{
						$i++;
					?>
                    <div id="content" style="" align='center'>
					<input  type='text' id='<?=$i?>' name='subaddons[]' value="<?=$row_addons['sub_addons_name']?>"/>&nbsp;
                    <input  type='text' id='<?=$i?>' name='subaddonsprice[]' value="<?=$row_addons['sub_addons_price']?>"/>
                    <input  type='hidden' id='addons_id<?=$i?>'  value="<?=$row_addons['addons_id']?>"/>
                    <input  type='hidden' id='sub_addons_id<?=$i?>'  value="<?=$row_addons['sub_addons_id']?>"/>
                    &nbsp;<a href='javascript:delsubAddons(<?=$i?>)'  style='text-decoration:none;' >Remove</a>&nbsp;
                    <span id='msgs<?=$i?>' style="padding-left:22px;"></span></div>
                    <?php
					}
					?>
                    </div>
			</div>
			
			<div class="addPageCont">
                <span class="addPageRightFont">Status </span>
                <span class="colon1">:</span>
                <span class="radioBtn">
                <span class="labelcont"><input type="radio" name="addons_status"  checked="checked" value="Y" <? if($d["status"]=="Y"){ echo" checked";}?> >Active <input type="radio" name="addons_status" value="N" <? if($d["status"]=="N"){echo" checked";}?>> In Active</span>
                </span>
                <div class="tooltip"><div class="HelpButton" title="Select any one  pickup option">?</div></div>
            </div>
			
			<div class="buttonCont2">
				<input type="submit" name="Update" value="<?=($_REQUEST['addons_id']!="")?'Update':'Add'?>" class="button">
				<a class="CanceButton" href="add.new.addons.php?menuid=127&menupid=125">Cancel</a>
				<!--<a class="CanceButton" href="javascript:void(0);" onclick="tb_remove()">Cancel</a>-->
			</div>
		</form>
	</div>
</div>
</div>
<?
include("includes/footer.php");
?>

<?php
session_start();
include("includes/access.php");
include("includes/header.php");

    $id = 0;
  	if(isset($_GET['id']))
		{
			$id = $_GET['id'];
			//echo $id;exit; 
			$Boysql = "SELECT * FROM ".$prev."delivery_boy WHERE id='".$id."'";
			$Boyresult = mysql_query($Boysql);
			$row = mysql_fetch_object($Boyresult);
			//print_r($row);exit;
			$name = $row->name;
		}

  if(isset($_POST['addEdit']))
		{
			$id = $_POST['id'];
			
			$name = mysql_real_escape_string(trim($_REQUEST['name']));
			
		    //==========================Add new Boy Start==========================================
			//echo $flag;
				if($flag == 0 && $id == 0)
				{
					$sql_add = "INSERT INTO ".$prev."delivery_boy SET 
					 name='".$name."',cur_date=NOW()";

					$result_add = mysql_query($sql_add);
					if($result_add)
					{
						$_SESSION["succ_message"]='Delivery Boy added successful';
						pageRedirect('delivery_boy.php?menuid=136&menupid=103');
				    }		
				}
			//==========================Add new Boy End==========================================
				if($flag == 0 && $id <> 0)
			//==========================Edit Menu ================================================
				{
		
					$sql_boy_up = "UPDATE ".$prev."delivery_boy SET 
					 name='".$name."',cur_date=NOW() WHERE id=".$id;
					$result_up = mysql_query($sql_boy_up);
					if($result_up)
					 {
						$_SESSION["succ_message"] = 'Updated successful';
						pageRedirect('delivery_boy.php?menuid=136&menupid=103');
				     }
	            }
			//==========================Edit Menu End================================================
				
		}		
		
		
if($_REQUEST['id'])
{
	$id=$_REQUEST['id'];
	$r=mysql_query("select * from ".$prev."delivery_boy where id=" . $id);
	$d=@mysql_fetch_array($r);
	
	$rest_id=$d['rest_id'];//by 10.09.13
	
}
	
?>
<script>
	 function fixedOption()
      {
	    $('#fixedOption').show();
		$('#pizzaOtherOption').hide();
		$('#pizzaDefaultOption').hide();
	  }	 
	 function defaultOption()
      {
	    $('#pizzaDefaultOption').show();
		$('#pizzaOtherOption').hide();
		$('#fixedOption').hide();
	  }	
	 function otherOption()
      {
	    $('#pizzaOtherOption').show();
		$('#pizzaDefaultOption').hide();
		$('#fixedOption').hide();
	  }
	  var specialsize = 0;
     function addMorePizzaSize(obj)
	 {
		if(obj!=0)
		{
		  specialsize = parseInt(obj);
		}	
	    html  = '<tbody id="specialsize' + specialsize + '">';
		html += '<tr>'; 
		html += '<td class="left" height="30" width="50%"><input type="text" name="morepizzasize['+specialsize+'][sizename]" id="sizename['+specialsize+']" class="mar4"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="morepizzasize['+specialsize+'][sizevalue]" value="" /></span></td>';	
		html += '<td class="left1"  height="30" width="20%" align="left"><a onclick="removeSlice('+specialsize+');" style="color:#f34571;cursor:pointer;margin-left:0px;"><span>Remove</span></a></td>';
		html += '</tr>';
		html += '</tbody>';
	    $('#specialPizzaSize tfoot').before(html);
		specialsize++;
     }

	function removeSlice(slice_id)
	 {	
         $('#specialsize'+ slice_id).remove();
	 }	
     function showSmallPrice()
      {
			if(document.getElementById("small").checked == true){
				$("#smallpriceshow").show();
			}else{
				$("#smallval").val('');
				$("#smallpriceshow").hide();
			}
	  }
     function showMediumPrice()
      {
		  	if(document.getElementById("medium").checked == true){
				$("#mediumpriceshow").show();
			}else{
				$("#mediumval").val('');
				$("#mediumpriceshow").hide();
			}
	  }
     function showLargePrice()
      {
		  if(document.getElementById("large").checked == true){
				$("#largepriceshow").show();
			}else{
				$("#largeval").val('');
				$("#largepriceshow").hide();
			}
	  }
	function otherSpecify(option){
		
		if(option=="category")
		{
			if(document.getElementById("categoryOther").selected){
				document.getElementById("catoters").style.display = "block";
			}else {
				document.getElementById("catoters").style.display = "none";
				$("#menu_catothers").val('');
			}
			return false;
		}
	} 
	  
	function menuValidateNew() {
	//alert('aaaaaa');
	var txt = '';

	if(document.getElementById('name').value == "") {
			$("#resNamePerErr").html("Please enter Name");
			txt ='err';
			/*alert(txt);*/
		}else{
			$("#resNamePerErr").html("");
	}
	
	if(txt != "") {
		//alert("Hello guest, the following fields are mandatory:-\n\n" + txt);
		return false;
	}
} 
	 
<!-------------------- Tooltip---------->
		$(function() {
$( document ).tooltip();
});
</script>
 <div class="contain">
				<!--Menu start-->
								<div class="adminLeft">
	
	<div class="adminLeftInner">
		
		
		<div class="adminLeftBox indexRightTabContent"  id="index_restaurant_content" style="display:none;">
			<ul class="dashLeftBottomUl">
				<li>
					<label class="name">Total Restaurants</label>
					<label class="count">193</label>
				</li>
				<li>
					<label class="name">Active Restaurants</label>
					<label class="count">57</label>
				</li>
				<li>
					<label class="name">Inactive Restaurants</label>
					<label class="count">114</label>
				</li>
				<li>
					<label class="name">Pending Activation Restaurants</label>
					<label class="count">22</label>
				</li>
				<li>
					<label class="name">Restaurants joined this week</label>
					<label class="count">2</label>
				</li>
				<li>
					<label class="name">Restaurants joined this month</label>
					<label class="count">4</label>
				</li>
				<li>
					<label class="name">Restaurants joined this year</label>
					<label class="count">110</label>
				</li>
			</ul>
		</div>
	</div>
</div>								<!--Menu End-->
				<div class="adminRight">
<div class="rightContHeading Heading">Add Delivery Boy</div>
<div class="rightContBody">

	<div class="riteContWrap1">
		<div id="errormsg"></div>
		<div class="mandatoryField"><span class="color1">*</span> - Mandatory Fields</div>
		<form name="addNewMenu" method="post" action="" onsubmit="return menuValidateNew();" enctype="multipart/form-data">
			<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
			<input type="hidden" name="action" value="Add">
			
			<!--Boy Name-->
			<div class="addPageCont">
				<span class="addPageRightFont">Name <span class="color1">*</span></span>
				<span class="colon1">:</span>
				<input class="textbox" type="text" name="name" id="name" value="<?php echo $name;?>" />
				<script>document.addNewMenu.name.focus();</script>
				<div class="tooltip"><div class="HelpButton" title="Enter Delivery Boy name">?</div></div>
				<span class="errClass" id="resNamePerErr"><?= $err_name ?></span>
			</div>
			
			<div class="buttonCont2">
				<input type="submit" class="button" name="addEdit" value="<?=($id!=0)?'Update':'Add'?>"> 
				<a class="CanceButton" href="menuManage.php">Cancel</a>
			</div>
		</form>
	</div>
</div>
</div>
		</div>

<?
include("includes/footer.php");
?>

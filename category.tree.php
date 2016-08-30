<?
include("configs/path.php");
?>

<style type="text/css">
body {margin:0 0 0 0; padding:0; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#393939; }
.rounded{
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
	color:#005295;
	background-color:#f3f3f3;
	text-decoration:none;
    border:solid 1px silver;
	width:100%
	font-style:normal;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding:5px;
}
select{
color:#0000FF;
border:1px solid #c0c0c0;
margin-left:10px;
}
</style>
<script type="text/javascript" language="javascript">
function pageScroll() {
    	window.scrollBy(50,0); // horizontal and vertical scroll increments
    	scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds

}
function pageScroll2() {
    	window.scrollBy(0,50); // horizontal and vertical scroll increments
    	scrolldelay = setTimeout('pageScroll2()',100); // scrolls every 100 milliseconds

}




</script>
<script type="text/javascript" language="javascript">
function validate(frm)
{
  if(!frm.country_id.value && frm.cat_id.value  && frm.city.value)
  {
     alert("Please select country ,state & city");
	 return false;

  }

}
function moveright(id){
var el = document.getElementById(id);
var cp = el.offsetRight;
el.style.right = cp - amount + "px";
//window.scroll();
}
function moveleft(amount){
var el = document.getElementById(id);
var cp = el.offsetLeft;
el.style.left = cp - amount + "px";
}
function moveup(id, amount){
var el = document.getElementById(id);
var cp = el.offsetTop;
el.style.top = cp - amount + "px";
}
function movedown(id, amount){
var el = document.getElementById(id);
var cp = el.offsetTop;
el.style.top = cp + amount + "px";
}


function findPosX(obj)
  {
    var curleft = 0;
    if(obj.offsetParent)
        while(1)
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
  }

  function findPosY(obj)
  {
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
  }
  function al(id)
    {
	//window.scroll(findPosX(id)+","+findPosY(id));
	//alert(findPosX(id)+","+findPosY(id));
	//moveleft('him',1000);
	//moveleft('him',findPosX(id));
    }

function doit(n)
{
	direction='r';
    if(direction=='r')
        window.scroll((n*200),1) //modify 1st number to change x position
    if(direction=='l')
         window.scroll(0,1) //modify 1st number to change x position
 }
function doit1()
{
	var j;
	j=document.getElementById('n').value;
	window.scroll((j*200),1);
}

</script>
</head>
<body onLoad="doit1();">
<?
function get_subtree($parent_id=0,$cat_id)
{
 	global $db,$prev;
	$r1=mysql_query("select * from " . $prev. "categories where parent_id='" . $parent_id . "'  order by cat_name");
	//echo"select * from " . $prev. "categories where parent_id='" . $parent_id . "'  order by cat_name";
    if(@mysql_num_rows($r1)):
		$combotxt="<select size=10  name='cat_id' onChange=\"javascript:window.parent.document.forms['catf'].cat_id.value=document.cats.cat_id.options[document.cats.cat_id.selectedIndex].value;this.form.submit();\" style='width:200px;'>";
		while($d=mysql_fetch_array($r1)):
		    $sub="";
			$r2=@mysql_query("select * from " . $prev. "categories where cat_id=" . $d[cat_id] . "  order by cat_name");
			if(@mysql_num_rows($r2)):
			    $sub=" > ";
			endif;
        	if($d[id]==$cat_id):
				$combotxt.="<option value='" . $d[cat_id] . "' selected>" . $d[cat_name] . " " . $sub ."</option>\n";
			else:
			    $combotxt.="<option value='" . $d[cat_id] . "'>" . $d[cat_name] . " " . $sub ."</option>\n";
			endif;
		endwhile;
		$combotxt.="</select>\n";
    endif;
	return  $combotxt;
}
?>
<form method="post" name='cats' action="<?=$_SERVER[PHP_SELF]?>" onSubmit="javascript:return validate(this)">
<table cellpadding="0" cellspacing="0" border="0" width="100%" align="left" >
<tr><td valign=top>

								  <select name="parent_id"   onChange="javascript:window.parent.document.forms['prod_entry'].parent_id.value=this.options[this.selectedIndex].value;this.form.submit();" style='width:160px;'>
									<option value="" >-- Category--</option>
									<?php
									$query = "select * from " .$prev."categories where status = 'Y' and parent_id=0 order by cat_name";
									$results = mysql_query($query);

									while ($rows = mysql_fetch_array(@$results))
									{

									?>
										<option value="<?php echo $rows['cat_id'];?>" <? if($rows['cat_id']==$_REQUEST[parent_id]){echo "selected";}?>><?php echo $rows['cat_name'];?></option>
									<?php
									}?>
									</select> &nbsp;
									<?

									if($_REQUEST[parent_id]):
										$query  = "select * from " . $prev. "categories where parent_id = ".$_REQUEST[parent_id] . " and status='Y' order by cat_name";
										$txt="Sub Category";
										$results  = @mysql_query( $query);
										$num_rows = @mysql_num_rows($results);

										?>
											<select name="sub_cat_id"  style='width:160px;' onChange="javascript:window.parent.document.forms['prod_entry'].sub_cat_id.value=this.options[this.selectedIndex].value;this.form.submit();">
											<option value="" >-- <?=$txt;?> --</option>
											<?php
											while ($rows = mysql_fetch_array($results))
											{?>
											<option value="<?php echo $rows['cat_id'];?>" <? if($rows['cat_id']==$_REQUEST[sub_cat_id]){echo 'selected';}?>><?php echo $rows['cat_name'];?></option>
										<?php
										}?>

										</select>
								    <?
									endif;
									?>
								    &nbsp;
									<?
									if($_REQUEST[sub_cat_id]):
										$query  = "select * from " . $prev. "categories where parent_id = ".$_REQUEST[sub_cat_id] . " and status='Y' order by cat_name";
										$txt="Sub Sub Categories";
										$results  = @mysql_query( $query);
										$num_rows = @mysql_num_rows($results);
										if($num_rows):
										?>
											<select name="cat_id" style='width:160px;' onChange="javascript:window.parent.document.forms['prod_entry'].cat_id.value=this.options[this.selectedIndex].value;">
											<option value="" >-- <?=$txt;?> --</option>
											<?php
												while ($rows = mysql_fetch_array($results))
											{?>
												<option value="<?php echo $rows['cat_id'];?>" <? if($_REQUEST[cat_id]==$rows['cat_id']){echo 'selected';}?>><?php echo $rows['cat_name'];?></option>
											<?php
										}?>

										</select>
									    <?php
									   endif;
									endif;
									?>
								  </td></tr>

</table>
</form>

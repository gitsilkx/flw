<?
require_once("includes/access.php");
require_once("includes/header.php");
?>
<Script Language="JavaScript">
<!--
function isValid(T)
{
    if(!Trim(T.co_name.value))
    {
        alert("Category Name is empty");
        return false;
    }
}

function Trim (s)
{
    var iLen = s.length;
    var sOut = "";
    var chr = "";
    for (var i=0; i<iLen; i++)
    {
        chr = s.charAt (i); 
        if (chr!=" ")
            sOut = sOut + chr; 
    }
    return sOut;
}
//-->
</Script>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" class="table">
<tr bgcolor=<?=$light?>><td width="47%" height="25" class="header"><a href='faqcategory.list.php?tid=<?=$_GET[tid]?>' class="header"><b>Category List :</b></a></td>
</tr></table>
<br/>
<?php
$l=mysql_query("select * from  " . $prev . "language where status='Y'");
	
$ln=mysql_num_rows($l);

$msg="";
if($_POST[Update]) {
	//echo "id==".$_POST[id]."<br>";
   if(!$_POST[id]) {
       $r=mysql_query("insert into " . $prev . "faq_category set name=\"" . $_POST[name] . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\"");
	   //print("insert into " . $prev . "faq_category set name=\"" . $_POST[name] . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\"");
	   //echo "<br>";
	   $id=mysql_insert_id();
	      if($ln){	
	   
       while($lng=mysql_fetch_array($l)){
	   
			$cat_name_lang=$lng['lang_id']."_cat_name";
			
			$lang_cat_name_id=$lng['lang_id']."_lang_cat_name_id";
			
			if($_POST[$lang_cat_name_id]){  
			   $sqllang=mysql_query("update ".$prev."language_content set table_name = 'faq_category',field_name = 'name',content_field_id = '".$id."',content = '".$_POST[$cat_name_lang]."',lang_id ='".$lng[lang_id]."'where id='".$_POST[$lang_cat_name_id]."'");
			   
			}else{
			//echo "insert into ".$prev."language_content set table_name = 'faq_category',field_name = 'name',content_field_id = '".$id."',content = '".$_POST[$cat_name_lang]."',lang_id ='".$lng[lang_id]."'";
			
			   $sqllang=mysql_query("insert into ".$prev."language_content set table_name = 'faq_category',field_name = 'name',content_field_id = '".$id."',content = '".$_POST[$cat_name_lang]."',lang_id ='".$lng[lang_id]."'");
	        }
	   }
	   }
	   }
   else {
       $r=mysql_query("update " . $prev . "faq_category set name=\"" . $_POST[name] . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\" where id=" . $_POST[id]);
	   //print("update " . $prev . "faq_category set name=\"" . $_POST[name] . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\" where id=" . $_POST[id]);
	   //echo "<br>";
	   $id=$_POST[id];
	    if($ln){	
	   
       while($lng=mysql_fetch_array($l)){
	   
			$cat_name_lang=$lng['lang_id']."_cat_name";
			
			$lang_cat_name_id=$lng['lang_id']."_lang_cat_name_id";
			
			if($_POST[$lang_cat_name_id]){  
			   $sqllang=mysql_query("update ".$prev."language_content set table_name = 'faq_category',field_name = 'name',content_field_id = '".$id."',content = '".$_POST[$cat_name_lang]."',lang_id ='".$lng[lang_id]."'where id='".$_POST[$lang_cat_name_id]."'");
			}else{
			   $sqllang=mysql_query("insert into ".$prev."language_content set table_name = 'faq_category',field_name = 'name',content_field_id = '".$id."',content = '".$_POST[$cat_name_lang]."',lang_id ='".$lng[lang_id]."'");
	        }
	   }
	   }
  }
   if($r){
       $msg="<font face=verdana size=1 color=#ffffff><b>Update Successful.</b></font>";
	   echo"<script>window.location.href='faqcategory.list.php?tid=" . $_GET[tid] . "';</script>";
       }
   else {
       $msg="<font face=verdana size=1 color=#ffffff><b>Update Failure.</b></font>";
	   }
  }		
elseif($_POST[DELT]){
   $r=mysql_query("select * from " . $prev . "projects where cat_id=" . $_POST[id]);
   if(@mysql_num_rows($r)){
      $msg="<font face=verdana size=1 color=#ffffff><b>You Can't delete. Projects are there.</b></font>";
}
else	  
  {
   	  $r=mysql_query("delete from " . $prev . "faq_category where id=\"" . $_POST[id] . "\"");
      echo"<script>window.location.href='faqcategory.list.php?tid=" . $_GET[tid] . "';</script>";
   }
}
if($_GET[id]){
   $r=mysql_query("select * from  " . $prev . "faq_category where id=" . $_GET[id]);
   $d=mysql_fetch_array($r);
}
if(!$_GET[parent_id]){$_GET[parent_id]="0";}
?>
<form method="post" action="<?=$PHP_SELF?>" enctype="multipart/form-data">
<input type="hidden" name="parent_id" value=<?=$_GET[parent_id]?>>
<input type="hidden" name="id" value="<?=$_GET[id]?>">
<input type="hidden" name="tid" value="<?=$_GET[tid]?>">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="<?=$light?>" class="table"> 
<tr class=header><td height=25 colspan=2><b>Add/Modify Category :
      <?=$d["name"]?>
</b></td>
</tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Category Name</td><td><input type="text" size=35 name="name" value="<?=$d[name]?>" class=lnk></td></tr>
<?php
if($ln){
	
while($lng=mysql_fetch_array($l)){
	
	$rr1=mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where lang_id='".$lng[lang_id]."' and field_name='name' and content_field_id=" . $d[id]));	
	?>
	<input type="hidden" name="<?=$lng[lang_id]?>_lang_cat_name_id" value="<?=$rr1['id']?>">
	<tr class=lnk bgcolor=#ffffff>
		<td valign=top>Category Name(<?=$lng[lang_name]?>)</td>
		<td><input type="text" size=35 name="<?=$lng[lang_id ]?>_cat_name" value="<?=$rr1[content]?>" class=lnk></td>
	</tr>
<?php
}
}
?>
<tr bgcolor=#ffffff class=lnk><td>Status</td><td><input type=radio name=status value="Y" <?php if($d["status"]=="Y"){echo" checked";}?> >Online <input type=radio name=status value="N" <? if($d["status"]=="N"){echo" checked";}?>> Offline </td></tr>
<tr>
  <td align=center  colspan=2><input type="submit" name="Update" value="Update" class="button" />    &nbsp;&nbsp;<?if($_GET[id]){?>
    <input type="submit" name="DELT" value="Delete" class="button" ><?}?>&nbsp;&nbsp;<input type="Button"  value="Back" onClick="JavaScript:window.location.href='faqcategory.list.php';" class="button" >&nbsp;&nbsp;<Blnk><?=$msg?></Blnk></td></tr>
</table>
</form>
<br>
<? require_once("includes/footer.php");?>

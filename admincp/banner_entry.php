<?php
include("includes/access.php");
include("includes/header.php");
if($_REQUEST[submit]):
	if($_POST[id]):
		
	    $sql1="update  " . $prev . "banner set
		 sbtitle='" . $_POST[sbtitle] ."',
		  status='" . $_POST['status'] ."'
		  where id=" . $_POST[id];
		$r=mysql_query($sql1);
		$id=$_REQUEST[id];
	else:
		$sql1="insert into " . $prev . "banner set
		 sbtitle= '" . $_POST[sbtitle] ."',
		
		 status='" . $_POST[status] ."'";
		
		$r=mysql_query($sql1);
		$id=mysql_insert_id();
	endif;

	if($r)
	{	
		if($_FILES['file'][name]!="")
		{
			
			$ext=substr($_FILES['file'][name],-3,3); 
			copy($_FILES['file'][tmp_name],"../banners/" . $id . "." . $ext);
			$up="update " . $prev . "banner set
			banner='banners/". $id . "." . $ext."' 
			where id=$id";
			mysql_query($up);	
		}
	    $msg="Banner has been added/updated successfully.";
    }
    else
    {
	    $msg="Some error occurred, please try again.";
	
	}
endif;	
?>

<SCRIPT language=javascript> 
<!--

  function formValidate() {
  if(document.form1.sbtitle.value == "" )
  {
  	alert('Website Title is required!');
	document.form1.sbtitle.focus();
  	return false;
  }
	if ( (document.form1.url.value == "http://")  || (document.form1.url.value == "") )
	 {
      alert('Website Url is required!');
		document.form1.url.focus();   
	   return false;
	   }

       /* if( (document.form1.bannerurl.value == "http://") || (document.form1.bannerurl.value == "") )
		{
	   alert('Banner url is required.');
	   document.form1.bannerurl.focus();
           return false; 
           }*/
		   
		   
		   if (document.form1.credits.value==''  || isNaN(document.form1.credits.value) || document.form1.credits.value<=0  )
{
	alert("Please provide some non-negative numeric value  for credits");
	document.form1.credits.focus();
	return (false);
}
if (isNaN(document.form1.displays.value) || document.form1.displays.value<0  )
{
	alert("Please provide some non-negative numeric value for displays");
	document.form1.displays.focus();
	return (false);
}

	return true;
  }
// -->
</SCRIPT>
<? if($msg):
   echo $msg;
endif;
if($_REQUEST[id]):
	$sql=mysql_query("select * from " . $prev . "banner  where id=" . $_REQUEST["id"]);
	$data=mysql_fetch_array($sql);
endif;	
?>
 <form action="<?=$_SERVER[PHP_SELF];?>" method="post" enctype="multipart/form-data" name="form1" onsubmit="return(formValidate());">
              <TABLE width=100% border=0 cellPadding=4 cellSpacing=1 style="border:solid 1px #0080C0">
                <TBODY>
                  <TR valign="middle"> 
                    <TD height="30" colspan="3" align="left" bgcolor="#A8D3FF" class="header" style="border-bottom:#0080C0 solid 2px;"><a href='banner_list.php?sbad_type=<?=$_REQUEST[sbad_type]?>' class="header">Banner Advertisement</a> > <strong>&nbsp;New 
                      Banner Advertisement</TD>
                  </TR>
                  <TR> 
                    <TD width="20%" height="25" align=left valign="top" bgcolor="#F5F5F5"> 
                      <div align="right"><strong><font color=red 
                        size=1>&nbsp;</font><font size="2" face="Arial, Helvetica, sans-serif">Title: 
                        </font></strong></div></TD>
                    <TD width="2%" align=left valign="top"><font color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*</font></TD>
                    <TD > 
                      <INPUT name="sbtitle" class="textbox" value="<? echo $data["sbtitle"];?>" maxLength=120 style='width:300px'> 
                      <font size="2" face="Arial, Helvetica, sans-serif"> 
                     
                      </font></TD>
                  </TR>
                  
				
				  
                  <TR>
                    <TD height="25" align=left valign="top" bgcolor="#F5F5F5"><div align="right"><strong>Select Banner Image: </strong></div></TD>
                    <TD align=left valign="top">&nbsp;</TD>
                    <TD ><input type="file" name="file" class="textbox"/></TD>
                  </TR>
                  
                  <tr> <TD height="25" align=left valign="top" bgcolor="#F5F5F5"><div align="right"><strong>Status: </strong></div></TD>
				  <TD align=left valign="top">&nbsp;</TD>
				  <td>
					<?php
					$selectedy="";
					$selectedn="";
					if($data['status']=="Y")
					{
					$selectedy='checked="checked"';
					}
					else
					{
					$selectedn='checked="checked"';
					}

					?>
					<input type="radio" class="lnk" name="status" id="yes" <?php echo  $selectedy; ?> value="Y"  />Online
					<input type="radio" class="lnk" name="status" <?php echo  $selectedn; ?> id="no" value="N"  /> Offline
				  
				   </td></tr>
				  
				  
                  <TR> 
                    <TD  height="25" align=left valign="top" bgcolor="#F5F5F5"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></TD>
                    <TD align=left valign="top">&nbsp;</TD>
                    <TD >
					<input type="hidden" id="id" name="id" value="<?php echo  $data['id']; ?>"  />
<INPUT type="submit" value="Submit" name="submit">&nbsp;                    </TD>
                  </TR>
                </TBODY>
              </TABLE>
</form>

<?


include("includes/footer.php");
?>
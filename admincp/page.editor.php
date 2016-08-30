<?
require_once("includes/access.php");
require_once("includes/header.php");
$upload_ext = array("jpg", "jpeg", "png", "gif");

function getExtension($str) {
    $ext = pathinfo($str, PATHINFO_EXTENSION);

    return strtolower($ext);
}

function generateRandomString($length = 10, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm') {
    $s = '';
    $lettersLength = strlen($letters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $s .= $letters[rand(0, $lettersLength)];
    }

    return $s;
}
?>
<?
if ($_POST[SBMT_REG]):

    if (!$_POST[status]) {
        $status = "Y";
    } else {
        $status = $_POST[status];
    }
    $contents = htmlentities($_POST[contents]);
    $post_url = str_replace(' ', '_', $_POST[url]);

    if ($_POST[id]) {
        $r = mysql_query("update " . $prev . "contents set
		cont_title=\"" . $_POST[cont_title] . "\",
                page_code=\"" . $_POST[page_code] . "\",    
		site_title=\"" . $_POST[site_title] . "\",
                canonical=\"" . $_POST[canonical] . "\",
                header_prm1=\"" . $_POST[header_prm1] . "\",
                header_prm2=\"" . $_POST[header_prm2] . "\",
                header_prm3=\"" . $_POST[header_prm3] . "\",
                header_prm4=\"" . $_POST[header_prm4] . "\",
                footer_content=\"" . $_POST[footer_content] . "\",       
		meta_keys=\"" . $_POST[meta_keys] . "\",
		meta_desc=\"" . $_POST[meta_desc] . "\",
                top_menu=\"" . $_POST[top_menu] . "\",    
		contents=\"" . $contents . "\",
                ord=\"" . $_POST[ord] . "\",
		status=\"" . $status . "\" where id=" . $_POST[id]);
        $id = $_POST[id];
    } else {
        $r = mysql_query("insert into " . $prev . "contents set

		cont_title=\"" . $_POST[cont_title] . "\",
                parent_id=\"" . $_POST[parent_id] . "\",
                page_code=\"" . $_POST[page_code] . "\",    
		contents=\"" . $contents . "\",
		site_title=\"" . $_POST[site_title] . "\",
                canonical=\"" . $_POST[canonical] . "\",
                header_prm1=\"" . $_POST[header_prm1] . "\",
                header_prm2=\"" . $_POST[header_prm2] . "\",
                header_prm3=\"" . $_POST[header_prm3] . "\",
                header_prm4=\"" . $_POST[header_prm4] . "\",
                footer_content=\"" . $_POST[footer_content] . "\",    
                ord=\"" . $_POST[ord] . "\",
		meta_keys=\"" . $_POST[meta_keys] . "\",
                top_menu=\"" . $_POST[top_menu] . "\",
		meta_desc=\"" . $_POST[meta_desc] . "\",

		status=\"" . $status . "\"
		");
        $id = mysql_insert_id();
        
    }
    pageRedirect("content.list.php?menuid=129&menupid=128");
endif;

if ($_REQUEST[id]) {
    $id = $_REQUEST[id];
}

if ($id):
    $r = mysql_query("select * from " . $prev . "contents where id=" . $id);

    $d = @mysql_fetch_array($r);

endif;

if (!$d['status']) {
    $d['status'] = "Y";
}
if (!$d['top_menu']) {
    $d['top_menu'] = "N";
}
?>

<script language="javascript" type="text/javascript">
<!--
    function ValidEditor(register)
    {
        var txt = "";
        if (!register.cont_title.value)
        {
            txt += "     Title should not be empty.\n"
        }

        if (txt)
        {
            alert("Sorry!! Following errors has been occured :\n\n" + txt + "\n     Please Check");
            return false
        }
        return true
    }
    function txtduplicate(dest, src)
    {
        var src3 = document.getElementById(src).value;
        if (src3 != "" && document.getElementById('id').value != '1')
        {
            var src2 = src3.replace(/\s/g, "_");
            document.getElementById(dest).value = "<?= $vpath ?>cms/" + src2 + ".htm";
        }
        else
        {
            document.getElementById(dest).value = "";
        }
    }
    function textCounter(field, cntfield, maxlimit) {
        if (field.value.length > maxlimit) {
            field.value = field.value.substring(0, maxlimit);
            alert('Max lenght is 1000 characters. You have typed ' + field.value.length + ' charachters.');
        }
        // otherwise, update 'characters left' counter
        else
            cntfield.value = maxlimit - field.value.length;
    }

//-->
    var browser = navigator.appName;
    if (browser == "Microsoft Internet Explorer")
    {
        var displaystyle = "block";
    }
    else
    {
        var displaystyle = "table-row";
    }
    function appearmenu()
    {
        if (document.getElementById("menu").checked == true)
        {
            document.getElementById("aurl").style.display = displaystyle;
            document.getElementById("aord").style.display = displaystyle;
            document.getElementById("mimage").style.display = displaystyle;
            document.getElementById("mhimage").style.display = displaystyle;
            document.getElementById("imimage").style.display = displaystyle;
            document.getElementById("imhimage").style.display = displaystyle;
        }
        else
        {
            document.getElementById("aurl").style.display = "none";
            document.getElementById("aord").style.display = "none";
            document.getElementById("mimage").style.display = "none";
            document.getElementById("mhimage").style.display = "none";
            document.getElementById("imimage").style.display = "none";
            document.getElementById("imhimage").style.display = "none";
        }
    }
    function mylogo(str)
    {
        if (str != 'choose')
        {
            location.href = 'page.editor.php?id=8&lid=' + str;
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
<script>

    function display_alert()

    {

        alert("No update! It's a demo version.!!");

    }

</script>
<form method='post' name="minform" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" onSubmit="javascript:return ValidEditor(this);">
    <input type="hidden" name="id" value="<?= $d[id] ?>">
    <input type="hidden" name="parent_id" value="<?=$_REQUEST[parent_id]?>">
    <table width="100%" border="0" align="left" cellspacing="1" cellpadding="4" bgcolor="<?= $light ?>" style="border:solid 1px <?= $dark ?>">
        <tr class="header">
            <td height=30 style="border-bottom:solid 2px <?= $dark ?>" colspan=2><a href="content.list.php" class="header" ><b><u>Content Management</u></b></a>&nbsp;:&nbsp; Page Editor : <?= ucwords($d[cont_title]) ?> &nbsp;&nbsp;<? if ($msg) { ?><BLINK><?= $msg ?></BLINK><? } ?></td>
        </tr>

        <tr bgcolor="#ffffff" class="lnk">
            <td valign="top" width="25%"><b>Title</b><font color="#CC3300">*</font></td>
            <td width="75%"><input type="text" name='cont_title' id="cont_title"  size="30" value="<?= $d[cont_title] ?>" onkeyup="txtduplicate('url', 'cont_title');" style="width:50%;"></td>
        </tr>

        <tr bgcolor="#ffffff" class="lnk">
            <td valign="top" width="25%"><b>Status</b></td>
            <td>
                <input name="status" type="radio" value='Y'  <? if ($d[status] == "Y") {
    echo"checked";
} ?>>Online
                <input type="radio" name="status" value='N' <? if ($d[status] == "N") {
    echo"checked";
} ?>>Offline
            </td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td valign="top" width="25%"><b>Top Menu?</b></td>
            <td>
                <input name="top_menu" type="radio" value='Y'  <? if ($d[top_menu] == "Y") {
    echo"checked";
} ?>>Yes
                <input type="radio" name="top_menu" value='N' <? if ($d[top_menu] == "N") {
    echo"checked";
} ?>>No
            </td>
        </tr>

        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Site Title </b></td>
            <td align="left"><input type="text" class="lnk" name="site_title" value="<?= $d[site_title] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Page Code </b></td>
            <td align="left"><input type="text" class="lnk" name="page_code" value="<?= $d[page_code] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Canonical </b></td>
            <td align="left"><input type="text" class="lnk" name="canonical" value="<?= $d[canonical] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Header Parameter1 </b></td>
            <td align="left"><input type="text" class="lnk" name="header_prm1" value="<?= $d[header_prm1] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Header Parameter2 </b></td>
            <td align="left"><input type="text" class="lnk" name="header_prm2" value="<?= $d[header_prm2] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Header Parameter3 </b></td>
            <td align="left"><input type="text" class="lnk" name="header_prm3" value="<?= $d[header_prm3] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Header Parameter4 </b></td>
            <td align="left"><input type="text" class="lnk" name="header_prm4" value="<?= $d[header_prm4] ?>" size="40" style="width:50%;"></td>
        </tr>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Footer Content </b></td>
            <td align="left"><input type="text" class="lnk" name="footer_content" value="<?= $d[footer_content] ?>" size="40" style="width:50%;"></td>
        </tr>
        <?php
        /* $l=mysql_query("select * from  " . $prev . "language where status='Y'");

          $ln=mysql_num_rows($l);

          if($ln){

          while($lng=mysql_fetch_array($l)){

          $rr1=mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where lang_id='".$lng[lang_id]."' and field_name='site_title' and content_field_id=" . $d[id]));
          ?>
          <input type="hidden" name="<?=$lng[lang_id]?>_lang_site_title_id" value="<?=$rr1['id']?>">
          <tr bgcolor="#ffffff" class="lnk">
          <td align="left" valign="top"><b>Site Title(<?=$lng[lang_name]?>) </b></td>
          <td align="left"><input type="text" class="lnk" name="<?=$lng[lang_id ]?>_site_title" value="<?=$rr1[content]?>" size="40" style="width:50%;"></td>
          </tr>
          <?php
          }
          } */
        ?>

        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" class="lnk" valign="top"><strong>Meta Keys</strong></td>
            <td >
                <textarea  cols="50" rows="5" name="meta_keys" style="width:50%;" class="lnk" onkeydown="textCounter(minform.meta_keys, minform.remLen1, 1000)" onkeyup="textCounter(minform.meta_keys, minform.remLen1, 1000)" ><?= $d[meta_keys] ?></textarea>

                <br />

                <input class="lnk" readonly="readOnly" size="5" value="1000" name="remLen1" />
            </td>
        </tr>
        <?php
        /* $l=mysql_query("select * from  " . $prev . "language where status='Y'");

          $ln=mysql_num_rows($l);

          if($ln){

          while($lng=mysql_fetch_array($l)){

          $rr11=mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where lang_id='".$lng[lang_id]."' and field_name='meta_keys' and content_field_id=" . $d[id]));
          ?>
          <input type="hidden" name="<?=$lng[lang_id]?>_lang_meta_keys_id" value="<?=$rr11['id']?>">
          <tr bgcolor="#ffffff" class="lnk">
          <td align="left" class="lnk" valign="top"><strong>Meta Keys(<?=$lng[lang_name]?>)</strong></td>
          <td >
          <textarea  cols="50" rows="5" name="<?=$lng[lang_id ]?>_meta_keys" style="width:50%;" class="lnk" onkeydown="textCounter(minform.meta_keys,minform.remLen1,300)" onkeyup="textCounter(minform.meta_keys,minform.remLen1,300)" ><?=$rr11[content]?></textarea>

          <br />

          <input class="lnk" readonly="readOnly" size="5" value="300" name="remLen1" />
          </td>
          </tr>
          <?php
          }
          } */
        ?>

        <tr bgcolor="#ffffff" valign="top" class="lnk">
            <td  align="left" valign="top"><b>Meta Description </b></td>
            <td >
                <textarea  cols="50" rows="5" name="meta_desc" class="lnk" style="width:50%;" onkeydown="textCounter(minform.meta_desc, minform.remLen12, 1000)" onkeyup="textCounter(minform.meta_desc, minform.remLen12, 1000)" ><?= $d[meta_desc] ?></textarea>

                <br />
                <input class="lnk" readonly="readOnly" size="5" value="1000" name="remLen12" />
            </td>
        </tr>
        <?php
        /* $l=mysql_query("select * from  " . $prev . "language where status='Y'");

          $ln=mysql_num_rows($l);

          if($ln){

          while($lng=mysql_fetch_array($l)){

          $rr12=mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where lang_id='".$lng[lang_id]."' and field_name='meta_desc' and content_field_id=" . $d[id]));
          ?>
          <input type="hidden" name="<?=$lng[lang_id]?>_lang_meta_desc_id" value="<?=$rr12['id']?>">
          <tr bgcolor="#ffffff" valign="top" class="lnk">
          <td  align="left" valign="top"><b>Meta Description(<?=$lng[lang_name]?>)</b></td>
          <td >
          <textarea  cols="50" rows="5" name="<?=$lng[lang_id ]?>_meta_desc" class="lnk" style="width:50%;" onkeydown="textCounter(minform.meta_desc,minform.remLen12,300)" onkeyup="textCounter(minform.meta_desc,minform.remLen12,300)" ><?=$rr12[content]?></textarea>

          <br />
          <input class="lnk" readonly="readOnly" size="5" value="300" name="remLen12" />
          </td>
          </tr>
          <?php
          }
          } */
        ?>

        <tr bgcolor="#ffffff" class="lnk">
            <td  valign="top" colspan="2"><b>Page Contents</b></td>
        </tr>

        <tr  bgcolor="#ffffff" class="lnk">
            <td colspan="2">
                <?php
                include_once '../ckeditor/ckeditor.php';
                include_once '../ckfinder/ckfinder.php';
                $ckeditor = new CKEditor();
                $ckeditor->basePath = '../ckeditor/';
                $ckfinder = new CKFinder();
                $ckfinder->BasePath = '../ckfinder/';
                $ckfinder->SetupCKEditorObject($ckeditor);
                echo $ckeditor->editor('contents', html_entity_decode($d["contents"]));
                ?>
            </td>
        </tr>
        <?php
        /* $l=mysql_query("select * from  " . $prev . "language where status='Y'");

          $ln=mysql_num_rows($l);

          if($ln){

          while($lng=mysql_fetch_array($l)){

          $rr13=mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where lang_id='".$lng[lang_id]."' and field_name='contents' and content_field_id=" . $d[id]));
          ?>
          <input type="hidden" name="<?=$lng[lang_id]?>_lang_contents_id" value="<?=$rr13['id']?>">
          <tr bgcolor="#ffffff" class="lnk">
          <td  valign="top" colspan="2"><b>Page Contents(<?=$lng[lang_name]?>)</b></td>
          </tr>

          <tr  bgcolor="#ffffff" class="lnk">
          <td colspan="2">
          <?php
          include_once '../ckeditor/ckeditor.php';
          include_once '../ckfinder/ckfinder.php';
          $ckeditor = new CKEditor();
          $ckeditor->basePath = '../ckeditor/';
          $ckfinder = new CKFinder();
          $ckfinder->BasePath = '../ckfinder/';
          $ckfinder->SetupCKEditorObject($ckeditor);
          $ckeditor->editor($lng[lang_id].'_contents',html_entity_decode($rr13[content]));
          ?>
          </td>
          </tr>
          <?php
          }
          } */
        ?>
        <tr bgcolor="#ffffff" class="lnk">
            <td align="left" valign="top"><b>Order </b></td>
            <td align="left"><input type="text" class="lnk" name="ord" value="<?= $d[ord] ?>" size="20" style="width:25%;"></td>
        </tr>
        <tr><td colspan="2" height="20" align="center" >
                <?php
                if ($_REQUEST['id']) {
                    ?>
                    <input type="submit"  name='SBMT_REG' value='Update' class="lnk" >
                    <?php
                } else {
                    ?>
                    <input type="submit"  name='SBMT_REG' value='Add' class="lnk"  >
    <?php
}
?>&nbsp;&nbsp;<input type="Reset" class="lnk"></td></tr>
    </table>
</form>
<!------------------------------------------------end  upload---------------------------------------------------->



<? include("includes/footer.php"); ?>
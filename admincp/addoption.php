<?php
include("includes/access.php");
include("includes/header_pop.php");

$pid = $_REQUEST['pid'];
$update = '';
?>


<?php
$msg = "";
if ($_REQUEST[Update]) {
     
    if (!$_REQUEST['action']) {
   
        $insert_query = "insert into images set		
                code='" . $_REQUEST['product_code'] . "',
                type='" . $_REQUEST['type'] . "',
                flower_name='" . $_REQUEST['flower_name'] . "',
                imageurl='" . $_REQUEST['imageurl'] . "',
                exotic='" . $_REQUEST['exotic'] . "',
                shop='" . $_REQUEST['shop'] . "',
                flower_order='" . $_REQUEST['flower_order'] . "',
                easter='" . $_REQUEST['easter'] . "',
                thank_you='" . $_REQUEST['thank_you'] . "',
                romance='" . $_REQUEST['romance'] . "',
                christmas='" . $_REQUEST['christmas'] . "',
                new_baby='" . $_REQUEST['new_baby'] . "',
                common='" . $_REQUEST['common'] . "',
                today='" . $_REQUEST['today'] . "',
                tomorrow='" . $_REQUEST['tomorrow'] . "',
                arrangements='" . $_REQUEST['arrangements'] . "',
                plants='" . $_REQUEST['plants'] . "',
                bouquets='" . $_REQUEST['bouquets'] . "',
                deals='" . $_REQUEST['deals'] . "',
                anniversary='" . $_REQUEST['anniversary'] . "',
                birthday='" . $_REQUEST['birthday'] . "',
                funerals='" . $_REQUEST['funerals'] . "',
                mothers_day='" . $_REQUEST['mothers_day'] . "',
                sympathy='" . $_REQUEST['sympathy'] . "',
                valentines_day='" . $_REQUEST['valentines_day'] . "',
                wedding='" . $_REQUEST['wedding'] . "',  
                get_well='" . $_REQUEST['get_well'] . "',
                roses='" . $_REQUEST['roses'] . "',
                centerprices='" . $_REQUEST['centerprices'] . "',
                funeral_casket_sprays='" . $_REQUEST['funeral_casket_sprays'] . "',
                funeral_plants='" . $_REQUEST['funeral_plants'] . "',
                funeral_wreaths='" . $_REQUEST['funeral_wreaths'] . "',
                funeral_sprays='" . $_REQUEST['funeral_sprays'] . "',
                funeral_baskets='" . $_REQUEST['funeral_baskets'] . "',
                everyday='" . $_REQUEST['everyday'] . "',
                one_sided_arrangements='" . $_REQUEST['one_sided_arrangements'] . "',
                novelty_arrangements='" . $_REQUEST['novelty_arrangements'] . "',      
                vased_arrangement='" . $_REQUEST['vased_arrangement'] . "',
                fruit_baskets='" . $_REQUEST['fruit_baskets'] . "',
                balloons='" . $_REQUEST['balloons'] . "',
                inside_casket='" . $_REQUEST['inside_casket'] . "',
                crosses='" . $_REQUEST['crosses'] . "',
                hearts='" . $_REQUEST['hearts'] . "',
                status='" . $_REQUEST['status'] . "'";

        $r = mysql_query($insert_query);
    } else {
   
        $upd_query = "update images set
		code='" . $_REQUEST['product_code'] . "',
                exotic='" . $_REQUEST['exotic'] . "',
                shop='" . $_REQUEST['shop'] . "',
                flower_order='" . $_REQUEST['flower_order'] . "',
                easter='" . $_REQUEST['easter'] . "',
                thank_you='" . $_REQUEST['thank_you'] . "',
                romance='" . $_REQUEST['romance'] . "',
                christmas='" . $_REQUEST['christmas'] . "',
                new_baby='" . $_REQUEST['new_baby'] . "',
                common='" . $_REQUEST['common'] . "',
                today='" . $_REQUEST['today'] . "',
                tomorrow='" . $_REQUEST['tomorrow'] . "',
                arrangements='" . $_REQUEST['arrangements'] . "',
                plants='" . $_REQUEST['plants'] . "',
                bouquets='" . $_REQUEST['bouquets'] . "',
                deals='" . $_REQUEST['deals'] . "',
                anniversary='" . $_REQUEST['anniversary'] . "',
                birthday='" . $_REQUEST['birthday'] . "',
                funerals='" . $_REQUEST['funerals'] . "',
                mothers_day='" . $_REQUEST['mothers_day'] . "',
                sympathy='" . $_REQUEST['sympathy'] . "',
                valentines_day='" . $_REQUEST['valentines_day'] . "',
                wedding='" . $_REQUEST['wedding'] . "',  
                get_well='" . $_REQUEST['get_well'] . "',
                roses='" . $_REQUEST['roses'] . "',
                centerprices='" . $_REQUEST['centerprices'] . "',
                funeral_casket_sprays='" . $_REQUEST['funeral_casket_sprays'] . "',
                funeral_plants='" . $_REQUEST['funeral_plants'] . "',
                funeral_wreaths='" . $_REQUEST['funeral_wreaths'] . "',
                funeral_sprays='" . $_REQUEST['funeral_sprays'] . "',
                funeral_baskets='" . $_REQUEST['funeral_baskets'] . "',
                everyday='" . $_REQUEST['everyday'] . "',
                one_sided_arrangements='" . $_REQUEST['one_sided_arrangements'] . "',
                novelty_arrangements='" . $_REQUEST['novelty_arrangements'] . "',      
                vased_arrangement='" . $_REQUEST['vased_arrangement'] . "',
                fruit_baskets='" . $_REQUEST['fruit_baskets'] . "',
                balloons='" . $_REQUEST['balloons'] . "',
                inside_casket='" . $_REQUEST['inside_casket'] . "',
                crosses='" . $_REQUEST['crosses'] . "',
                hearts='" . $_REQUEST['hearts'] . "',
		status='" . $_REQUEST['status'] . "'
                where code='" . $_REQUEST['product_code'] . "'";

        $r = mysql_query($upd_query) or die("Error :" . mysql_error());
    }
    if ($r):
        if ($_FILES[flowerurl][name] != ""):
            //$ext = substr($_FILES[flowerurl][name], -3, 3);
            copy($_FILES[flowerurl][tmp_name], "../images/" . $_FILES[flowerurl][name]);
            //echo "update images set flowerurl='https://www.flowerwyz.com/images/" . $_FILES[flowerurl][name] . "' where code='" . $_REQUEST['product_code'] . "'";
            mysql_query("update images set flowerurl='https://www.flowerwyz.com/images/" . $_FILES[flowerurl][name] . "' where code='" . $_REQUEST['product_code'] . "'");
        endif;
    endif;

    echo"<script>window.opener.location.reload();</script><p align=center>Update successful</p>";
}
if ($_REQUEST['product_code']) {
    $product_code = $_REQUEST['product_code'];
    //echo "select * from images where code=" . $product_code;
    $r = mysql_query("select * from images where code='" . $product_code . "'");
    $d = @mysql_fetch_array($r);
    if($d['id'] <> '')
        $action = 'update';
    $rr = mysql_query("select * from products where product_no='" . $product_code . "'");
    $dd = @mysql_fetch_array($rr);
}

if ($msg):
    echo"<br><table align='center' cellpadding='5' align='center' cellspacing='0' width='100%' style='border:solid 1px $dark'><tr><td align='center' height='25'><div class='lnk'>" . $msg . "</div></td></tr></table><br>";
endif;
?>
<br />
<form method="post" name="attribute_entry" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
    <input type="hidden" name="product_code" value="<?= $product_code ?>">
    <input type="hidden" name="action" value="<?= $action ?>">
    <input type="hidden" name="type" value="<?= $dd['category'] ?>">
    <input type="hidden" name="imageurl" value="<?= $dd['image'] ?>">
    <input type="hidden" name="flower_name" value="<?= $dd['name'] ?>">
    <input type="hidden" name="pid" value="<?= $pid ?>">
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="0">
        <tr bgcolor=<?= $light ?>>
            <td height="32"  class="header"  style='border-bottom:solid 1px #333333'> Add/Modify Product: <?= $dd['name'] ?> </td>

        </tr>
    </table> 
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="4" bgcolor="whitesmoke" style="border:solid 1px <?= $light ?>">
        <tr bgcolor="#ffffff"><td valign="top" class="lnk">Picture</td><td>
<?
$pic = '';
if ($d['flowerurl'] != '') {
    $pic = $d[flowerurl];
} else {
    //$imgsize1 = GetThumbnailSize("../images/cart1.jpg",80,80);
    $pic = "../images/cart1.jpg";
}

echo "<img src='" . $pic . "' width='80' height='80' border=0>";
?>
                <input type="file" name="flowerurl" class="lnk" size="20"></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>Exotic:</b></td><td width="67%" ><input name="exotic" type="text" class="lnk" value="<?= $d['exotic'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>shop:</b></td><td width="67%" ><input name="shop" type="text" class="lnk" value="<?= $d['shop'] ?>" size="40" ></td></tr>        
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>flower_order:</b></td><td width="67%" ><input name="flower_order" type="text" class="lnk" value="<?= $d['flower_order'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>easter:</b></td><td width="67%" ><input name="easter" type="text" class="lnk" value="<?= $d['easter'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>thank_you:</b></td><td width="67%" ><input name="thank_you" type="text" class="lnk" value="<?= $d['thank_you'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>romance:</b></td><td width="67%" ><input name="romance" type="text" class="lnk" value="<?= $d['romance'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>christmas:</b></td><td width="67%" ><input name="christmas" type="text" class="lnk" value="<?= $d['christmas'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>new_baby:</b></td><td width="67%" ><input name="new_baby" type="text" class="lnk" value="<?= $d['new_baby'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>common:</b></td><td width="67%" ><input name="common" type="text" class="lnk" value="<?= $d['common'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>today:</b></td><td width="67%" ><input name="today" type="text" class="lnk" value="<?= $d['today'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>tomorrow:</b></td><td width="67%" ><input name="tomorrow" type="text" class="lnk" value="<?= $d['tomorrow'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>arrangements:</b></td><td width="67%" ><input name="arrangements" type="text" class="lnk" value="<?= $d['arrangements'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>plants:</b></td><td width="67%" ><input name="plants" type="text" class="lnk" value="<?= $d['plants'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>bouquets:</b></td><td width="67%" ><input name="bouquets" type="text" class="lnk" value="<?= $d['bouquets'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>deals:</b></td><td width="67%" ><input name="deals" type="text" class="lnk" value="<?= $d['deals'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>anniversary:</b></td><td width="67%" ><input name="anniversary" type="text" class="lnk" value="<?= $d['anniversary'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>birthday:</b></td><td width="67%" ><input name="birthday" type="text" class="lnk" value="<?= $d['birthday'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>funerals:</b></td><td width="67%" ><input name="funerals" type="text" class="lnk" value="<?= $d['funerals'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>mothers_day:</b></td><td width="67%" ><input name="mothers_day" type="text" class="lnk" value="<?= $d['mothers_day'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>sympathy:</b></td><td width="67%" ><input name="sympathy" type="text" class="lnk" value="<?= $d['sympathy'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>valentines_day:</b></td><td width="67%" ><input name="valentines_day" type="text" class="lnk" value="<?= $d['valentines_day'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>wedding:</b></td><td width="67%" ><input name="wedding" type="text" class="lnk" value="<?= $d['wedding'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>get_well:</b></td><td width="67%" ><input name="get_well" type="text" class="lnk" value="<?= $d['get_well'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>roses:</b></td><td width="67%" ><input name="roses" type="text" class="lnk" value="<?= $d['roses'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>centerprices:</b></td><td width="67%" ><input name="centerprices" type="text" class="lnk" value="<?= $d['centerprices'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>funeral_casket_sprays:</b></td><td width="67%" ><input name="funeral_casket_sprays" type="text" class="lnk" value="<?= $d['funeral_casket_sprays'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>funeral_plants:</b></td><td width="67%" ><input name="funeral_plants" type="text" class="lnk" value="<?= $d['funeral_plants'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>funeral_wreaths:</b></td><td width="67%" ><input name="funeral_wreaths" type="text" class="lnk" value="<?= $d['funeral_wreaths'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>funeral_sprays:</b></td><td width="67%" ><input name="funeral_sprays" type="text" class="lnk" value="<?= $d['funeral_sprays'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>funeral_baskets:</b></td><td width="67%" ><input name="funeral_baskets" type="text" class="lnk" value="<?= $d['funeral_baskets'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>everyday:</b></td><td width="67%" ><input name="everyday" type="text" class="lnk" value="<?= $d['everyday'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>one_sided_arrangements:</b></td><td width="67%" ><input name="one_sided_arrangements" type="text" class="lnk" value="<?= $d['one_sided_arrangements'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>novelty_arrangements:</b></td><td width="67%" ><input name="novelty_arrangements" type="text" class="lnk" value="<?= $d['novelty_arrangements'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>vased_arrangement:</b></td><td width="67%" ><input name="vased_arrangement" type="text" class="lnk" value="<?= $d['vased_arrangement'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>fruit_baskets:</b></td><td width="67%" ><input name="fruit_baskets" type="text" class="lnk" value="<?= $d['fruit_baskets'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>balloons:</b></td><td width="67%" ><input name="balloons" type="text" class="lnk" value="<?= $d['balloons'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>inside_casket:</b></td><td width="67%" ><input name="inside_casket" type="text" class="lnk" value="<?= $d['inside_casket'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>crosses:</b></td><td width="67%" ><input name="crosses" type="text" class="lnk" value="<?= $d['crosses'] ?>" size="40" ></td></tr>
        <tr class="lnk" bgcolor="#ffffff"><td width="33%" bgcolor="#e9e9e9"><b>hearts:</b></td><td width="67%" ><input name="hearts" type="text" class="lnk" value="<?= $d['hearts'] ?>" size="40" ></td></tr>
        <tr bgcolor="#ffffff" class="lnk"> <td bgcolor="#e9e9e9"><b>Status :</b></td><td align="left"><input type="radio" name="status"  checked="checked" value="y" <? if ($d["status"] == "y") {
                    echo" checked";
                } ?> >Active <input type="radio" name="status" value="n" <? if ($d["status"] == "n") {
                    echo" checked";
                } ?>> In Active</td></tr>

        <tr bgcolor=<?= $light ?> ><td></td>
            <td >
                <input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="reset" value="Reset" class="button"></td></tr>
    </table>
</form>
<p align=center><a href="javascript:;" onclick="closeAndReload()">Close and reload parent</a></p>
</body></html>

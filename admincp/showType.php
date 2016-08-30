<?
ini_set('display_errors','On');
require_once("../configs/path.php");
$id=$_REQUEST['id'];
$product_type=$_REQUEST['product_type'];
$id++;

		$res_type=mysql_query("select * from ".TABLE_PRODUCT_TYPE." where pid=$product_type ");
		if(mysql_num_rows($res_type)!=0)
		{
	?>
	<br />
    <br />
	<select name="product_type_id[]" id="product_type_id_<?=$id?>" style="width:200px;" onchange="showType('<?=$id?>')">
		<option value=""></option>
		<?
		while($row_type=mysql_fetch_array($res_type))
		{
			?>
			<option value="<?=$row_type['product_type_id']?>" <? if($row_type['product_type_id']==$key){?> selected="selected" <? }?>><?=$row_type['product_type_name']?></option>
			<?
		}
		?>
	</select>
<span id="section_<?=$id?>">
</span>
<?
	}
?>
<?php
include("include/header.php");
include("getProducts.php");

$intStart = '1';
$num_records_per_page = '20';
$offset = 0;
$parama = "&amp;pg_id=37";
$where_clause = " AND B.common !=0";
 $order_by = 'B.common asc';

$keywords = array('Send Flowers Anywhere', 'Cheap Flower Delivery', 'Smooth Online Flowers', 'Flowers Delivered Fresh', 'Best Online Flowers', 'Best Flower Delivery
', 'Cheap Flowers Anytime', 'Send Flowers Online', 'Cheap Flowers Delivery', 'Free Sending Flowers', 'Online Flower Delivery', 'Send Flowers Cheap', 'Cheap Flowers Delivered', 'Flowers For Delivery', 'Hand Deliver Flowers', 'Cool Flowers To Send', 'Cheap Flowers Online', 'Easy Flower Deliveries', 'Best Online Flowers', 'Cheapest Flower Delivery');

if ($_GET['limit'] && $_GET['limit'] != '') {
    $offset = ($_GET['limit'] - 1) * $num_records_per_page;
}

if ($_GET['filter'] && $_GET['filter'] != '') {
    $strCategory = $_GET['filter'];
     if($_GET['filter'] == 'apop')
        $order_by = 'A.name asc';
    if($_GET['filter'] == 'aaz')
        $order_by = 'A.name asc';
    if($_GET['filter'] == 'apa') // price ascending
        $order_by = 'A.price asc';
    if($_GET['filter'] == 'apd') // price descending
        $order_by = 'A.price desc';
    $parama .= "&amp;filter=" . $_GET['filter'];
}
else{
    $strCategory = 'apop';

}
if ($_GET['range'] && $_GET['range'] != '') {

	$range = $_GET['range'];
	if($range == '40-60')
			$where_clause .= " AND A.price>=40 AND A.price<=60";
		elseif($range == '60-80')
			$where_clause .= " AND A.price>=60 AND A.price<=80";
		 elseif($range == '80-100')
		 	$where_clause .= " AND A.price>=80 AND A.price<=100";
		 elseif($range == '100')
		 	$where_clause .= " AND A.price>=100";
		$parama = "&amp;range=" . $range;
}

if ($_GET['category'] && $_GET['category'] != '') {
    $strCategory = $_GET['category'];
    if($strCategory == 'ao') // Everyday
       $field_name = 'everyday';
    elseif($strCategory == 'bd') //Birthday
        $field_name = 'birthday';
    elseif($strCategory == 'an') //Anniversary
        $field_name = 'anniversary';
    elseif($strCategory == 'lr') //Love & Romance
        $field_name = 'romance';
    elseif($strCategory == 'gw') //Get Well
        $field_name = 'get_well';
    elseif($strCategory == 'nb') //New Baby
        $field_name = 'new_baby';
    elseif($strCategory == 'ty') //Thank You
        $field_name = 'thank_you';
    elseif($strCategory == 'sy') //Sympathy
        $field_name = 'sympathy';
    elseif($strCategory == 'c') //Centerpieces
        $field_name = 'centerprices';
    elseif($strCategory == 'o') //One Sided Arrangements
        $field_name = 'one_sided_arrangements';
    elseif($strCategory == 'n') //Novelty Arrangements
        $field_name = 'novelty_arrangements';
    elseif($strCategory == 'v') //Vased Arrangements
        $field_name = 'vased_arrangement';
    elseif($strCategory == 'r') //Roses
        $field_name = 'roses';
    elseif($strCategory == 'x') //Fruit Baskets
        $field_name = 'fruit_baskets';
    elseif($strCategory == 'p') //Plants
        $field_name = 'plants';
    elseif($strCategory == 'b') //Balloons
        $field_name = 'balloons';
    elseif($strCategory == 'fa') //Funeral Table Arrangements
        $field_name = 'arrangements';
    elseif($strCategory == 'fb') //Funeral Baskets
        $field_name = 'funeral_baskets';
    elseif($strCategory == 'fs') //Funeral Sprays
        $field_name = 'funeral_sprays';
    elseif($strCategory == 'fp') //Floor Plants
        $field_name = 'funeral_plants';
    elseif($strCategory == 'fl') //Funeral Inside Casket Flowers
        $field_name = 'inside_casket';
    elseif($strCategory == 'fw') //Funeral Wreaths
        $field_name = 'funeral_wreaths';
    elseif($strCategory == 'fh') //Hearts
        $field_name = 'hearts';
    elseif($strCategory == 'fx') //Funeral Crosses
        $field_name = 'crosses';
    elseif($strCategory == 'fc') //Funeral Casket Sprays
        $field_name = 'funeral_casket_sprays';
    elseif($strCategory == 'cm') //Christmas
        $field_name = 'christmas';
    elseif($strCategory == 'ea') //Easter
        $field_name = 'easter';
    elseif($strCategory == 'vd') //Valentines Day
        $field_name = 'valentines_day';
    elseif($strCategory == 'md') //Mothers Day
        $field_name = 'mothers_day';

    $keywords = array();

     $where_clause .= " AND B.".$field_name."!=0";
     $order_by = "B.".$field_name;
    $parama .= "&amp;category=" . $_GET['category'];
}
if ($_GET['code'] && $_GET['code'] != '') {
    $where_clause .= " AND (A.product_no='".$_GET['code']."' OR A.name like '%".$_GET['code']."%')";
    $parama .= "&amp;code=" . $_GET['code'];
    $keywords = array();
}

if (CheckCron()) { // API Call
    $ins->getProductDetails(API_USER, API_PASSWORD, $strCategory, $num_records_per_page, $intStart);
    $products = $ins->arrProducts;
    $total = '400';
} else { // Our Data Base Call
    $total_exe = mysql_query("SELECT A.*,B.* FROM " . TABLE_PRODUCT . " as A," . TABLE_IMAGE . " as B WHERE A.product_no = B.code " . $where_clause . " ORDER BY ".$order_by." ");
    $total = mysql_num_rows($total_exe);

    $resut = mysql_query("SELECT A.*,B.* FROM " . TABLE_PRODUCT . " as A," . TABLE_IMAGE . " as B WHERE A.product_no = B.code " . $where_clause . " ORDER BY ".$order_by." LIMIT $offset, $num_records_per_page");
  // echo "SELECT A.*,B.* FROM " . TABLE_PRODUCT . " as A," . TABLE_IMAGE . " as B WHERE A.product_no = B.code " . $where_clause . " ORDER BY ".$order_by." LIMIT $offset, $num_records_per_page";
    $i = 0;
    while ($array = mysql_fetch_array($resut)) {
        $products[$i]['code'] = $array['product_no'];
        $products[$i]['description'] = $array['description'];
        $products[$i]['image'] = $array['flowerurl'];

        $products[$i]['price'] = $array['price'];
        if($array['flower_name'] == "" || $array['flower_name'] == null)
            $products[$i]['name'] = $array['name'];
        else
            $products[$i]['name'] = $array['flower_name'];
        $i++;
    }
}
?>
<div class="innerWrap">
    <div class="row-fluid">
        <?php include("include/sidebar.php"); ?>
        <div class="Content" id="section">
            <ul class="featuredAdd">
                <li class="add_green">
                    <a href="<?= $vpath ?>same-day-flower-delivery-same-day-flowers-today.htm">
                        <span class="thumbpic_featuredAdd">
                            <img src="<?= $vpath ?>images/flowers-online.jpg" alt="Flowers Online" height="91" width="142" /></span>
                        <span class="featured_content"><span class="title">Flowers Today</span>
                            Select locations</span>
                        <span class="btn_box"></span>
                    </a>
                </li>
                <li class="add_pink nomarginRgt">
                    <a href="<?= $vpath ?>next-day-flower-delivery-next-day-flowers-tomorrow.htm">
                        <span class="thumbpic_featuredAdd">
                            <img src="<?= $vpath ?>images/flower-delivery.jpg" alt="Flower Delivery" height="91" width="142" /></span>
                        <span class="featured_content"><span class="title">Flowers Next Day</span>Anywhere in the nation
                        </span><span class="btn_box"></span>
                    </a>
                </li>
            </ul>
            <div class="filterPan">
                <ul class="listing">

                    <li class="bt40-60"><a href="<?= $vpath ?>index.php?range=40-60">UNDER $60</a></li>
                    <li class="bt60-80"><a href="<?= $vpath ?>index.php?range=60-80">$60 - $80</a></li>
                    <li class="bt80-100"><a href="<?= $vpath ?>index.php?range=80-100">$80 - $100</a></li>
                    <li class="o100"><a href="<?= $vpath ?>index.php?range=100">OVER $100</a></li>

                </ul>
                <form action="" method="get">
                    <div class="sort_flower" style="margin:10px 14px 0 0;float: right;">
                        <div class="select-drop" style="width:250px;">
                            <select name="filter" onchange='this.form.submit()'>
                                <option value="apop" <?PHP if ($strCategory == 'apop') { ?> selected="selected" <?php } ?>>--Sort Flowers By--</option>
                                <option value="aaz" <?PHP if ($strCategory == 'aaz') { ?> selected="selected" <?php } ?>>Alphabetically</option>
                                <option value="apa" <?PHP if ($strCategory == 'apa') { ?> selected="selected" <?php } ?>>Price (Ascending)</option>
                                <option value="apd" <?PHP if ($strCategory == 'apd') { ?> selected="selected" <?php } ?>>Price (Descending)</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <table class="FeaturedProducts" width="100%" align="center" border="0" cellpadding="0" cellspacing="1">
                <tbody>
                    <?php
                    if (isset($products) && count($products) > 0):
                        ?>
                        <tr>
                            <?php
                            $i = 0;
                            foreach ($products as $product):
                               /*
                                $word_cnt = strlen($product['name']);
                                if ($word_cnt > 29)
                                    $name = WordTruncate(ucwords($product['name']), '3');
                                else
                                    $name = WordTruncate(ucwords($product['name']), '4');
                                *
                                */

                                ?>
                                <td>
                                    <div class="ProductImage ">
                                        <a><img src="<?php echo $product['image']; ?>" alt="<?php echo $keywords[$i]; ?>" height="211px" width="183px" /></a>
                                    </div>
                                    <div class="ProductDetails">
                                        <a><?php echo $keywords[$i]; ?></a>
                                    </div>
                                    <div class="ProductPriceRating">
                                        <em><?php echo substr($product['name'],0,27); ?></em>
                                        <em><?php echo '$' . $product['price']; ?></em>
                                    </div>
                                    <div style="text-align:center; margin-top:5px;">
                                        <a href="<?= $vpath; ?>item.php?code=<?php echo $product['code']; ?>" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                    </div>
                                </td>

                                <?php
                                $i++;
								if($i == '20')
									break;
                                if ($i % 4 == 0) {
                                    echo '</tr><tr>';
                                }
                            endforeach;
                            ?>

                        </tr>
                        <tr class="pagination_area">
                            <td colspan="8" align="center" height="25"><?= paging($total, $num_records_per_page, $parama, "paging"); ?></td>
                        </tr>
                        <?php
                    else:
                        echo '<tr><td class="norecords">No Records Found</td></tr>';
                    endif;
                    ?>
                </tbody>
            </table>

            <?php
            include_once($page_content);?>
        </div>
    </div>
</div>
<?php include("include/footer.php");
?>

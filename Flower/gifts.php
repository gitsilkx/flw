<?php
include("include/header.php");




//echo "SELECT A.*,B.* FROM ".TABLE_PRODUCT." as A,".TABLE_IMAGE." as B WHERE A.product_no = B.code ".$where_clause. " ORDER BY B.common ASC LIMIT $offset, $num_records_per_page";
?>


<div class="innerWrap">
    <div class="row-fluid">
<?php include("include/sidebar.php"); ?>
        <div class="Content" id="section">

                <div class="filterPan">
                    <ul class="listing">
                        <?PHP
                         $r=mysql_query("select * from " . $prev . "contents where top_menu='N' and parent_id='63' and status='Y' order by ord asc");
                            while($d=@mysql_fetch_array($r)): 
                        ?>
                        <li><a href="<?= $vpath.$d['canonical'];?>"><?php echo $d['cont_title'];?></a></li>
                        
                        <?php endwhile;?>
                    </ul>
             
                </div>

            <table class="FeaturedProducts" width="100%" align="center" border="0" cellpadding="0" cellspacing="1">
                <tbody>
                    <?php 
                    $i = 0;
                      
                            $r=mysql_query("select * from " . $prev . "contents where top_menu='N' and parent_id='63' and status='Y' order by ord asc");
                            while($d=@mysql_fetch_array($r)):
                    ?>
                   <tr> <td> <?=$d['cont_title']?><a href=""> more</a></td></tr>
                        <tr>
                        <?php
                         
                                $rr=mysql_query("select * from products where type_id='2' and category='".$d['page_code']."' and status='Y' order by ord asc limit 0,4");
                            ?>
                
                            <?php
                            while($product=@mysql_fetch_array($rr)):
                            ?>
                                <td>
                                    <div class="ProductImage ">
                                        <a><img src="<?php echo $product['image']; ?>" alt="<?php echo $keywords[$i]; ?>" height="211px" width="183px" /></a>
                                    </div>
                                    <div class="ProductDetails">
                                        <a><?php echo $keywords[$i]; ?></a>
                                    </div>
                                    <div class="ProductPriceRating">
                                        <em><?php echo substr($product['name'], 0, 27); ?></em>
                                        <em><?php echo '$' . $product['price']; ?></em>
                                    </div>
                                    <div style="text-align:center; margin-top:5px;">
                                        <a href="<?= $vpath; ?>item.php?code=<?php echo $product['product_no']; ?>" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                      <!--  <div id="ajax_cart_<?php echo $product['id']; ?>" style="float: left;">
                                        <a style="cursor:pointer;" name="<?php echo $product['id']; ?>" class="btn-pink add-to-cart" id="add-to-cart">BUY NOW</a></div> -->
                                    </div>
                                </td>
                                <?php
                                $i++;
                                if ($i == '28')
                                    break;
                                if ($i % 4 == 0) {
                                    echo '</tr><tr>';
                                }
                            endwhile;
                            endwhile;
                            ?>
                        </tr>              
                </tbody>
            </table>
<div class="page_content">
            <?php
            echo html_entity_decode($contents);?>
                <div class="cboth"></div>
                </div>
        </div>
    </div>
</div>
<?php
include("include/footer.php");
?>

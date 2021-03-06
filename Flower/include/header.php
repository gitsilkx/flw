<?php
session_start();
ini_set('display_errors', 'Off');
require_once("configs/path.php");
$ip = $_SERVER['REMOTE_ADDR'];
$geopluginURL = 'http://www.geoplugin.net/php.gp?ip=' . $ip;
$details = unserialize(file_get_contents($geopluginURL));
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--<html lang="en">-->
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="robots" content="noindex,nofollow" />
        <title><?= $site_title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="keywords" content="<?php echo $site_keys ?>" />
        <meta name="description" content="<?php echo $site_desc ?>" />

        <link rel="canonical" href="<?php echo $vpath . $canonical; ?>" />
        <link href="<?= $vpath ?>css/styles.css" rel="stylesheet" type="text/css" />
        <link href="<?= $vpath ?>css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?= $vpath ?>css/responsive.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/slicknav.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/skin.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/Arvo.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/Lato.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/OpenSans.css" />
        <link rel="stylesheet" type="text/css" href="<?= $vpath ?>css/splay.css"/>
        <link href="<?= $vpath ?>css/custom.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?= $vpath ?>js/jquery.min.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/jquery.slicknav.min.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/jquery.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/menudrop.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/iselector.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/general.js"></script>
        <script src="<?=$vpath?>js/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?=$vpath?>css/jquery-ui.css" />
        <script type="text/javascript">

            var ThumbImageWidth = 183;
            var ThumbImageHeight = 183;

            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-57269771-1', 'auto');
            ga('send', 'pageview');



        </script>


        <script type="text/javascript" src="<?= $vpath ?>js/jquery_002.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/superfish.js"></script>

        <script type="text/javascript">

            $(function() {

                if (typeof $.fn.superfish == "function") {

                    $("ul.sf-menu").superfish({
                        delay: 800,
                        dropShadows: 0,
                        speed: "fast"

                    })

                            .find("ul")
                            .bgIframe();

                }

            })

        </script>
        <link rel="stylesheet" href="<?= $vpath ?>bootstrap/css/bootstrap.min.css"> 
            <script type="text/javascript" src="<?= $vpath ?>bootstrap/js/bootstrap.min.js"></script>
            <!-- Script For Fancy Box START -->

            <script type="text/javascript" src="<?= $vpath; ?>fancybox/jquery.fancybox-1.3.4.js"></script>
            <link rel="stylesheet" type="text/css" href="<?= $vpath; ?>fancybox/jquery.fancybox-1.3.4.css" media="screen" />
            <script type="text/javascript">
                $(function(event) {
                    $(".fancyboxIframe").fancybox({
                        minWidth: 250,
                        width: '80%',
                        maxWidth: 700,
                        minHeight: 500,
                        height: 500,
                        'autoScale': false,
                        'autoDimensions': false,
                        'scrolling': 'yes',
                        'transitionIn': 'none',
                        'transitionOut': 'none',
                    });
                    $(".splFancyIframe").fancybox({
                        minWidth: 250,
                        maxWidth: 700,
                        width: '90%',
                        minHeight: 500,
                        height: 500,
                        'autoScale': false,
                        'autoDimensions': false,
                        'scrolling': 'yes',
                        'transitionIn': 'none',
                        'transitionOut': 'none',
                    });
                    $(".fancyboxIframeCustome").fancybox({
                        minWidth: '90%',
                        maxWidth: 700,
                        width: '90%',
                        minHeight: 450,
                        height: 450,
                        'autoScale': false,
                        'autoDimensions': false,
                        'scrolling': 'no',
                        'transitionIn': 'none',
                        'transitionOut': 'none',
                    });
                    //window.location.href = 'http://localhost/flowerwyz/flower-shops-online-flower-stores.htm?search=Best+Flower+Shops&find_loc=Bangalore+Nagarbhavi';

                });

            </script>

            <!-- Script For Fancy Box END -->

            <?php
            if ($header_page_id == '8') {
                if ($url <> '')
                    echo '<meta http-equiv=Refresh content="0;url=' . $url . '">';
            }
            ?>
    </head>
    <body>
        <?php
        $cnt1 = @mysql_fetch_array(mysql_query("select sum(qty) as cnt, sum(total) as ntotals  from " . $prev . "cart where   OrderID='" . GetCartId() . "'"));

        if ($cnt1[cnt] > 0) {

            $cnt = $cnt1[cnt];

            $totp = '$' . $cnt1[ntotals];
        } else {

            $cnt = 0;

            $totp = 0.00;
        }
        ?>
        <!--Main Container Start-->
        <div id="Container">
            <div id="header">
                <div class="h_top">
                    <div class="innerWrap">
                        <div class="t-Txt">
                            <h3><?PHP echo $head_prm1; ?></h3>
                            <div class="cboth"></div>
                        </div>

                        <div class="t-TxtRight">
                            <h3>** Order Before 1.00PM Recipient Time for Same Day Delivery.</h3>
                            <div class="cboth"></div>
                        </div>
                    </div>
                </div>
                <div class="h_bottom">
                    <div class="innerWrap">
                        <div class="logo_area">
                            <a href="<?= $vpath ?>" class="h_logo">
                                <span class="h_logo_icons"></span>
                                <span class="h_logo_name">Flower WyZ</span>
                            </a>
                            <div class="h_social_icon">
                                <ul>
                                    <li><a href="#" class="fb"></a></li>
                                    <li><a href="#" class="gplus"></a></li>
                                    <li><a href="#"  class="insti"></a></li>
                                    <li><a href="#"  class="pintit"></a></li>
                                    <li><a href="#"  class="twitter"></a></li>
                                </ul>
                                <img src="<?php echo $vpath; ?>images/send-flower-online.png" alt="Send Flower Online" style="margin:10px 0;" />
                            </div>
                        </div>
                        <div class="h_oderSec">
                            <div class="h_orderby_icons"></div>
                            <div class="h_oderby_rgt">

                                Order NOW

                                <br/>

                                <strong><?php echo $head_prm2; ?></strong> <?php echo $head_prm3; ?>

                                <br/>

                                <span><?php echo $head_prm4; ?></span>

                                <p><span></span>USA &amp; CANADA</p>
                                <p class="small">
                                    <img src="<?php echo $vpath; ?>images/online-flower-delivery.png" alt="Online Flower Delivery" style="margin:8px 0 0 0;" /></p>

                            </div>
                        </div>
                        <form action="<?php echo $vpath; ?>index.php" method="get" onSubmit="return validation()">
                            <div class="h_contacts">


                                <div class="header-serch-container">
                                    <div class="header-search">
                                        <div class="select-search"  style="margin-bottom: 5px;" >

                                            <select name="category" id="category" class="select">
                                                <option value="">All Categories &amp; Products</option>
                                                <option value="ao" <?PHP if ($_REQUEST['category'] == 'ao') { ?> selected="selected" <?php } ?>>Everyday</option>
                                                <option value="bd" <?PHP if ($_REQUEST['category'] == 'bd') { ?> selected="selected" <?php } ?>>Birthday </option>
                                                <option value="an" <?PHP if ($_REQUEST['category'] == 'an') { ?> selected="selected" <?php } ?>>Anniversary</option>
                                                <option value="lr" <?PHP if ($_REQUEST['category'] == 'lr') { ?> selected="selected" <?php } ?>>Love &amp; Romance</option>
                                                <option value="gw" <?PHP if ($_REQUEST['category'] == 'gw') { ?> selected="selected" <?php } ?>>Get Well</option>
                                                <option value="nb" <?PHP if ($_REQUEST['category'] == 'nb') { ?> selected="selected" <?php } ?>>New Baby</option>
                                                <option value="ty" <?PHP if ($_REQUEST['category'] == 'ty') { ?> selected="selected" <?php } ?>>Thank You </option>
                                                <option value="sy" <?PHP if ($_REQUEST['category'] == 'sy') { ?> selected="selected" <?php } ?>>Sympathy </option>
                                                <option value="c" <?PHP if ($_REQUEST['category'] == 'c') { ?> selected="selected" <?php } ?>>Centerpieces</option>
                                                <option value="o" <?PHP if ($_REQUEST['category'] == 'o') { ?> selected="selected" <?php } ?>>One Sided Arrangements</option>
                                                <option value="n" <?PHP if ($_REQUEST['category'] == 'n') { ?> selected="selected" <?php } ?>>Novelty Arrangements</option>
                                                <option value="v" <?PHP if ($_REQUEST['category'] == 'v') { ?> selected="selected" <?php } ?>>Vased Arrangements</option>
                                                <option value="r" <?PHP if ($_REQUEST['category'] == 'r') { ?> selected="selected" <?php } ?>>Roses</option>
                                                <option value="x" <?PHP if ($_REQUEST['category'] == 'x') { ?> selected="selected" <?php } ?>>Fruit Baskets</option>
                                                <option value="p" <?PHP if ($_REQUEST['category'] == 'p') { ?> selected="selected" <?php } ?>>Plants</option>
                                                <option value="b" <?PHP if ($_REQUEST['category'] == 'b') { ?> selected="selected" <?php } ?>>Balloons</option>
                                                <option value="fa" <?PHP if ($_REQUEST['category'] == 'fa') { ?> selected="selected" <?php } ?>>Funeral Table Arrangements</option>
                                                <option value="fb" <?PHP if ($_REQUEST['category'] == 'fb') { ?> selected="selected" <?php } ?>>Funeral Baskets</option>
                                                <option value="fs" <?PHP if ($_REQUEST['category'] == 'fs') { ?> selected="selected" <?php } ?>>Funeral Sprays</option>
                                                <option value="fp" <?PHP if ($_REQUEST['category'] == 'fp') { ?> selected="selected" <?php } ?>>Floor Plants</option>
                                                <option value="fl" <?PHP if ($_REQUEST['category'] == 'fl') { ?> selected="selected" <?php } ?>>Funeral Inside Casket Flowers</option>
                                                <option value="fw" <?PHP if ($_REQUEST['category'] == 'fw') { ?> selected="selected" <?php } ?>>Funeral Wreaths</option>
                                                <option value="fh" <?PHP if ($_REQUEST['category'] == 'fh') { ?> selected="selected" <?php } ?>>Hearts</option>
                                                <option value="fx" <?PHP if ($_REQUEST['category'] == 'fx') { ?> selected="selected" <?php } ?>>Funeral Crosses</option>
                                                <option value="fc" <?PHP if ($_REQUEST['category'] == 'fc') { ?> selected="selected" <?php } ?>>Funeral Casket Sprays</option>
                                                <option value="cm" <?PHP if ($_REQUEST['category'] == 'cm') { ?> selected="selected" <?php } ?>>Christmas</option>
                                                <option value="ea" <?PHP if ($_REQUEST['category'] == 'ea') { ?> selected="selected" <?php } ?>>Easter</option>
                                                <option value="vd" <?PHP if ($_REQUEST['category'] == 'vd') { ?> selected="selected" <?php } ?>>Valentines Day</option>
                                                <option value="md" <?PHP if ($_REQUEST['category'] == 'md') { ?> selected="selected" <?php } ?>>Mothers Day</option>
                                            </select>
                                        </div>
                                        <input type="text" id = "srctxt" name="code" value="<?php if (isset($_GET['code'])) {
            echo $_GET['code'];
        } ?>" placeholder="Enter Item No."  class="florist_log" />
                                    </div>
                                    <div class="search_sec">
                                        <button type="submit" class="spl_btn glyphicon glyphicon-search"></button>
                                    </div>


                                    <div class="cboth"></div>

                                </div>
                                <div class="header-serch-container your_cart">
                                    <div class="cart_image">
                                        <div class="item_qty"  id="crtup"><?= $cnt ?></div>
                                        <img src="<?php echo $vpath; ?>images/cart.png"/> 
                                    </div>
                                    <div class="ur_cart">
                                        <h3>YOUR CART</h3>
                                        <span id="totpr"><?=$totp?></span>
                                        <!--<p>Total <span id="totpr"><?= $totp ?></span> in your cart </p>-->

                                        <span class="churcart"><a href="#"><b>CHECK OUT</b></a></span>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="cboth"></div>
                        <?php
                        if ($city_name1)
                            $city_name1 = ' , ' . $city_name1;
                        if ($city_name2)
                            $city_name2 = ' , ' . $city_name2;
                        if ($city_name3)
                            $city_name3 = ' , ' . $city_name3;
                        if ($city_name4)
                            $city_name4 = ' , ' . $city_name4;
                        if ($city_name5)
                            $city_name5 = ' , ' . $city_name5;
                        echo $city_name . $city_name1 . $city_name2 . $city_name3 . $city_name4 . $city_name5;
                        ?>
                    </div>
                </div>
            </div>

            <div id="navigation">

                <div class="innerWrap">

                    <div class="row-fluid mainNavBg">

                        <div id="Menu"><ul><li class="First ActivePage"><a href="<?= $vpath ?>"><span>Home</span></a></li>

<?php
$r = mysql_query("select * from " . $prev . "contents where top_menu='Y' and status='Y' order by ord asc");
while ($d = @mysql_fetch_array($r)):
    ?>
                                    <li>
                                        <a href="<?= $vpath . $d['canonical']; ?>"><span><?php echo $d['cont_title']; ?></span></a>
                                    </li>
<?php endwhile; ?>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
            <div id="Wrapper">
                <style>
                    .stick {
                        position: fixed;
                        top: 0;
                    }
                </style>
                <script>

     /*           var mq = window.matchMedia("(max-width: 320)");
                if (mq.matches) {
                    var initTopPosition = $('.your_cart').offset().top;
                    $(window).scroll(function() {
                        if ($(window).scrollTop() > initTopPosition)
                            $('.your_cart').css({'position': 'fixed', 'top': '0px', 'width': '318px', 'height': '69', 'z-index': '9999', 'margin': '4px', });
                        else
                            $('.your_cart').css({'position': 'absolute', 'top': initTopPosition + 'px', 'width': '318px', 'height': '69'});
                    });
                } else {
                    var initTopPosition = $('.your_cart').offset().top;
                    $(window).scroll(function() {
                        if ($(window).scrollTop() > initTopPosition)
                            $('.your_cart').css({'position': 'fixed', 'top': '0px', 'width': '278px', 'height': '69', 'z-index': '9999'});
                        else
                            $('.your_cart').css({'position': 'absolute', 'top': initTopPosition + 'px', 'width': '278px', 'height': '69'});
                    });
                }*/

                function validation() {
                    var category = $('#category').val();
                    var srctxt = $('#srctxt').val();
                    if (category == '' && srctxt == '') {
                        alert('Please select category or item no.');
                        return false;
                    }
                }

                $(document).ready(function() {
                    $('#srctxt').focus(function() {
                        if ($(this).attr('placeholder') == 'Enter Item No.') {
                            $(this).attr("placeholder", "");
                        }
                    }).blur(function() {
                        if ($(this).attr('placeholder') == '') {
                            $(this).attr("placeholder", "Enter Item No.");
                        }
                    });
                });
                </script>       
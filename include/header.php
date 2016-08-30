<?php
session_start();
ini_set('display_errors', 'Off');
require_once("configs/path.php");
$ip = $_SERVER['REMOTE_ADDR'];
$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip;
$details = unserialize(file_get_contents($geopluginURL));

$canonical = '';
$city_name = '';
$city_name1 = '';
$city_name2 = '';
$city_name3 = '';
$city_name4 = '';
$city_name5 = '';
$url = '';


if (isset($_GET['pg_id'])) {
    $header_page_id = $_GET['pg_id'];
    if ($header_page_id == '37') { //Home
        $page_content = 'home_content.php';
        $canonical = 'wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm';
        $head_prm1 = 'Online Flowers Delivery | Send Flowers Online | Cheap Flower Delivery';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'FLOWER DELIVERY';
        $page_title = 'FlowerWyz Online Flowers Delivery | Send Flowers Online | Cheap Flower Delivery';
        $meta_description = 'Looking for The Best Cheap Flower Delivery Service? Send Flowers Online With FlowerWyz Online Flowers Delivery Service. Accredited Same or Next Day Delivery Service. call us Today!';
        $meta_keywords = 'flower delivery, send flowers, flowers online, flowers delivery, online flowers, online flower delivery, cheap flower delivery, send flowers online, cheap flowers, sending flowers,best flower delivery,flowers delivered,flowers for delivery,send flowers cheap,flowers for delivery,deliver flowers';
        $footer_content = 'FlowerWyz | Online Flowers Delivery | Send Flowers Online | Cheap Flower Delivery.';
    } elseif ($header_page_id == '4') { // Today
        $page_content = 'today_content.php';
        $canonical = 'same-day-flower-delivery-same-day-flowers-today.htm';
        $head_prm1 = 'Send Flowers Today | Same Day Flower Delivery | Same Day Flowers Delivered Today';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'FLOWERS TODAY';
        $page_title = 'FlowerWyz Same Day Flower Delivery | Same Day Delivery Flowers Delivered Today | Same Day Flowers';
        $meta_description = 'Looking for a Great Same Day Flower Delivery Service? Same Day Delivery Flowers Delivered Today by FlowerWyz. Accredited Same Day Flowers Delivery Service. Call us Today!';
        $meta_keywords = 'same day flower delivery, same day delivery flowers, flowers delivered today, same day flowers, flowers same day delivery, send flowers today, deliver flowers today, flower delivery same day, flowers delivery same day, flowers today, cheap same day flower delivery, flower delivery today,flowers for delivery today, same day flowers delivery, send flowers same day, cheap flowers delivered today';
        $footer_content = 'FlowerWyz | Same Day Flower Delivery | Same Day Delivery Flowers Delivered Today | Same Day Flowers.';
    } elseif ($header_page_id == '5') { //TOMORROW
        $page_content = 'tomorrow_content.php';

        $head_prm1 = 'Next Day Flower Delivery | Next Day Flowers Delivered Tomorrow';
        $head_prm2 = 'SEND';
        $canonical = 'next-day-flower-delivery-next-day-flowers-tomorrow.htm';
        $head_prm3 = 'NEXT DAY **';
        $head_prm4 = 'FLOWERS TOMORROW';
        $page_title = 'FlowerWyz Next Day Flower Delivery | Next Day Delivery Flowers Delivered Tomorrow | Next Day Flowers';
        $meta_description = 'Looking for a Great Next Day Flower Delivery Service? Next Day Delivery Flowers Delivered Tomorrow by FlowerWyz. Accredited Next Day Flowers Delivery Service. Call us Today!';
        $meta_keywords = 'Next day flower delivery, Next day delivery flowers, flowers delivered Tomorrow, Next day flowers, flowers Next day delivery, send flowers Tomorrow, deliver flowers Tomorrow, flower delivery Next day, flowers delivery Next day, flowers Tomorrow, cheap Next day flower delivery, flower delivery Tomorrow,flowers for delivery Tomorrow, Next day flowers delivery, send flowers Next day, cheap flowers delivered Tomorrow';
        $footer_content = 'FlowerWyz | Next Day Flower Delivery | Next Day Delivery Flowers Delivered Tomorrow | Next Day Flowers.';
    } elseif ($header_page_id == '6') { // DEALS
        $page_content = 'deal_content.php';
        $canonical = 'discount-flowers-flower-deals-flower-coupons-cheap-flowers-free-delivery.htm';
        $head_prm1 = 'Discount Flowers | Flower Deals and Flower Coupons | Inexpensive Flowers';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'DISCOUNT FLOWER DEALS';
        $footer_content = 'FlowerWyz | Discount Flowers | Flower Deals and Flower Coupons | Inexpensive Flowers | Affordable Flowers.';
        $page_title = 'FlowerWyz Discount Flowers | Flower Deals and Flower Coupons | Inexpensive Flowers | Affordable Flowers';
        $meta_description = 'Looking for Great Flower Deals and Flower Coupons? Check out FlowerWyz Discount Flowers Delivery Service. You can Order Inexpensive Flowers or Affordable Flowers for Same or Next Day Delivery. Call us Today!';
        $meta_keywords = 'discount flowers,flower coupons,flower deals,inexpensive flowers,flower delivery coupons,affordable flowers,discount flower delivery,inexpensive flower delivery,affordable flower delivery,flowers discount,flower delivery coupon,discount flowers delivered,discount flowers online,flower coupons online,flower deals online,inexpensive flowers online';
    } elseif ($header_page_id == '7') { // WHOLESALE
        $page_content = 'wholesale_content.php';
        $canonical = 'wholesale-flowers-wholesale-roses-bulk-flowers-online.htm';
        $head_prm1 = 'Wholesale Flowers Wholesale Roses | Bulk Flowers Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'WHOLESALE FLOWERS';
        $footer_content = 'FlowerWyz | Wholesale Flowers Wholesale Roses | Bulk Flowers Online.';
        $page_title = 'FlowerWyz Wholesale Flowers Wholesale Roses | Bulk Flowers Online';
        $meta_description = 'Looking for Cheap Bulk Flowers Online? Send Wholesale Flowers Online With FlowerWyz Delivery Service. Accredited Wholesale Roses for Same or Next Day Delivery Service. Call us Today!';
        $meta_keywords = 'wholesale flowers, bulk flowers, wholesale roses, flowers wholesale, bulk flowers online, flower wholesale, flowers in bulk, wholesale flowers online, wholesale florist, cut flower wholesale, wholesale cut flowers, cut flowers wholesale, cheap bulk flowers, buy flowers in bulk, wholesale flower';
    } elseif ($header_page_id == '8') { // SHOPS
        $page_content = 'shop_content.php';
        $canonical = 'flower-shops-online-flower-stores.htm';
        $head_prm1 = 'Floral Shops | Florist shops | Flower Shops Near Me';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'FLOWER SHOPS DELIVERY';
        $footer_content = 'FlowerWyz Flower Shops Near Me | Floral Shops | Florist Shops | Online Flower Shop Near Me Flowershops.';
        $page_title = 'FlowerWyz Flower Shops Near Me | Floral Shops | Florist Shops | Online Flower Shop Near Me Flowershops';
        $meta_description = 'Looking for Online Flower Shop Near Me? Check out FlowerWyz Floral Shops, Florist shops & Flower Shops Near Me. Accredited Online Florist for Best Flowershops Deliveries. Call us Today!';
        $meta_keywords = 'flower shops near me,flower shop,flower shop near me,flower shops,flowers near me,floral shops near me,floral shops,nearest flower shop,floral shop,the flower shop,flowers shop,flowers shop near me,flower shops nearby,florist shop,flowershop,closest flower shop';
        
        $result = mysql_query("SELECT * FROM ". TABLE_CITY ." WHERE tag LIKE '%".$details['geoplugin_city']."%' AND status='Y' LIMIT 1");
        $row= mysql_fetch_object($result);
        $city_name = $row->city_name;
        $url = $row->url;
        $city_name1 = $row->city1;
        $city_name2 = $row->city2;
        $city_name3 = $row->city3;
        $city_name4 = $row->city4;
        $city_name5 = $row->city5;
        //$url = $city_name;
        //if($state) $url .='+'. $state;
     
        mysql_free_result($result);
         //$url = 'https://www.flowerwyz.com/flower-shops-online-flower-stores.htm?search=Best+Flower+Shops&find_loc='.$url;
        
        

        
       // header("Refresh:0; url=".$url);
      //  die;
       // exit();
        //header('Status: 301 Moved Permanently', false, 301); 
       //header("Location: ".$url,TRUE,301);
//exit();
       //echo '<META HTTP-EQUIV="Refresh" Content="5; URL="'.$url.'>';
    } elseif ($header_page_id == '9') { //ORDER
        $page_content = 'order_content.php';

        $canonical = 'order-flowers-online-for-delivery-where-to-buy-flowers-online.htm';
        $head_prm1 = 'Order Flowers Online for Delivery | Learn Where to Buy Flowers Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'ORDER FLOWERS ONLINE';
        $footer_content = 'FlowerWyz | Order Flowers Online for Delivery | Learn Where to Buy Flowers Online.';
        $page_title = 'FlowerWyz Order Flowers Online for Delivery | Learn Where to Buy Flowers Online';
        $meta_description = 'Looking TO Order Flowers Online for Delivery? Learn Where to Buy Flowers Online at FlowerWyz. Accredited Service for Ordering Flowers Online. Call us Today!';
        $meta_keywords = 'order flowers,order flowers online,buy flowers online,buy flowers,ordering flowers,where to buy flowers,ordering flowers online,where can i buy flowers,order flowers online cheap,order flowers for delivery,flower orders,order flowers cheap,flowers order,where to buy cheap flowers,order flowers online for delivery,buying flowers online';
    } elseif ($header_page_id == '1') { //ANNIVERSARY
        $page_content = 'anniversary_content.php';
        $canonical = 'wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm';
        $head_prm1 = 'Wedding Anniversary Gifts | Anniversary Flowers | Anniversary Gift Ideas';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'ANNIVERSARY FLOWERS';
        $footer_content = 'FlowerWyz | Wedding Anniversary Gifts | Anniversary Flowers for Anniversary Gift Ideas and Baskets.';
        $page_title = 'FlowerWyz Wedding Anniversary Gifts | Anniversary Flowers for Anniversary Gift Ideas and Baskets';
        $meta_description = 'Looking for Great Anniversary Gift Ideas and Baskets? Check out Wedding Anniversary Gifts and Anniversary Flowers at FlowerWyz. Accredited Same or Next Day Delivery Service for Flowers for Anniversary . Call us Today!';
        $meta_keywords = 'wedding anniversary gifts, anniversary gift ideas, anniversary flowers, flowers for anniversary, wedding anniversary flowers, anniversary gift baskets, anniversary gift basket, anniversary flowers, anniversary flower, anniversary flower delivery, anniversary flowers delivery, anniversary flower online, anniversary flowers online, order anniversary flower online, order anniversary flowers online, buy anniversary flower online';
    } elseif ($header_page_id == '2') { //BIRTHDAY
        $page_content = 'birthday_content.php';
        $canonical = 'birthday-flowers-birthday-gifts-for-mom-birthday-delivery-ideas.htm';
        $head_prm1 = 'Birthday Flowers Delivery | Birthday Gift Baskets | Birthday Delivery Ideas';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'BIRTHDAY FLOWERS';
        $footer_content = 'FlowerWyz | Birthday Flowers Delivery | Birthday Gift Baskets | Birthday Gifts for Mom | Birthday Delivery Ideas.';
        $page_title = 'FlowerWyz Birthday Flowers Delivery | Birthday Gift Baskets | Birthday Gifts for Mom | Birthday Delivery Ideas';
        $meta_description = 'Looking for The Best Birthday Flowers Delivery Service? Send Birthday Gift Baskets Online With FlowerWyz. Birthday Delivery Ideas for Birthday Gifts for Moms and Family Members. Call us Today!';
        $meta_keywords = 'birthday flowers, birthday gifts, birthday gifts for mom, birthday gift, birthday delivery, birthday gift baskets, birthday delivery ideas, birthday baskets, flowers for birthday, birthday flower, birthday gift delivery, birthday deliveries, birthday flowers delivery, birthday flower delivery, birthday delivery gifts, birthday gift basket';
    } elseif ($header_page_id == '3') { //EASTER
        $page_content = 'easter_content.php';
        $canonical = 'easter-flowers-easter-flower-arrangements.htm';
        $head_prm1 = 'Easter Flowers Online | Flowers for Easter Flower Arrangements';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'EASTER FLOWERS ONLINE';
        $footer_content = 'FlowerWyz | Easter Flowers Online | Flowers for Easter Flower Arrangements.';
        $page_title = 'FlowerWyz Easter Flowers Online | Flowers for Easter Flower Arrangements';
        $meta_description = 'Looking for The Best Cheap Easter Flowers Online? Send Flowers for Easter With FlowerWyz. Accredited Same or Next Day Delivery Service for Easter Flower Arrangements. Call us Today!';
        $meta_keywords = 'easter flowers, easter flower, easter flower arrangements, easter floral arrangements, easter flowers arrangements, easter arrangements, flowers for easter, easter flower delivery, easter flowers delivery, easter flower online, easter flowers online, order easter flower online, order easter flowers online, buy easter flower online, buy easter flowers online';
    } elseif ($header_page_id == '10') { //MOTHERS DAY
        $page_content = 'mother_content.php';
        $canonical = 'mothers-day-gifts-mothers-day-flowers-for-mothers-day.htm';
        $head_prm1 = 'Mothers Day Gifts Baskets | Mothers Day Flowers for Mothers Day';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'MOTHERS DAY FLOWERS';
        $footer_content = 'FlowerWyz | Mothers Day Gifts Baskets | Mothers Day Flowers for Mothers Day.';
        $page_title = 'FlowerWyz | Mothers Day Gifts Baskets | Mothers Day Flowers for Mothers Day.';
        $meta_description = 'Looking for Great Mothers Day Gifts Baskets? Send Mothers Day Flowers Online With FlowerWyz. Accredited Same or Next Day Delivery Service for Flowers for Mothers Day. Call us Today!';
        $meta_keywords = 'mothers day gifts, mothers day flowers, flowers for mothers day, flowers mothers day, mother day flowers, mothers day gift baskets, cheap mothers day flowers, mothers day flower delivery, mothers day flowers free delivery, mothers day flowers delivery, mothersday flowers, send mothers day flowers, flower delivery mothers day, send flowers for mothers day, send flowers mothers day, mothers day flowers online';
    } elseif ($header_page_id == '11') { //SYMPATHY
        $page_content = 'sympathy_content.php';
        $canonical = 'sympathy-flowers-delivery-sympathy-gift-baskets.htm';
        $head_prm1 = 'Sympathy Flowers | Sympathy Baskets | Condolence Flowers | Sympathy Gifts';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'SYMPATHY FLOWERS';
        $footer_content = 'FlowerWyz | Sympathy Flowers | Sympathy Baskets | Condolence Flowers | Sympathy Gift Baskets and Ideas Online.';
        $page_title = 'FlowerWyz Sympathy Flowers | Sympathy Baskets | Condolence Flowers | Sympathy Gift Baskets and Ideas Online';
        $meta_description = 'Looking for a Great Sympathy Flowers Delivery Service? Send Condolence Flowers and Sympathy Gift Baskets Online With FlowerWyz. Accredited Delivery Service for Flowers for Sympathy Gifts Online. Call us Today!';
        $meta_keywords = 'sympathy flowers,sympathy gift baskets,sympathy baskets,sympathy basket,sympathy gifts,sympathy gift,sympathy gift ideas,sympathy flower baskets,sympathy gift basket,sympathy flowers delivery,flowers for sympathy,sympathy flower,sympathy flowers online,sympathy flowers delivery,Condolence Flowers,Condolences Flowers';
    } elseif ($header_page_id == '12') {//VALENTINES DAY
        $page_content = 'valentines_content.php';
        $head_prm1 = 'Valentines Day Flowers | Valentines Flowers Delivery | Valentine Flowers & Gifts';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'VALENTINES DAY FLOWERS';
        $canonical = 'valentines-day-flowers-valentines-flowers-delivery.htm';
        $footer_content = 'FlowerWyz | Valentines Day Flowers | Valentines Flowers Delivery | Valentine Flowers | Valentine Gift Baskets.';
        $page_title = 'FlowerWyz Valentines Day Flowers | Valentines Flowers Delivery | Valentine Flowers | Valentine Gift Baskets';
        $meta_description = 'Looking for Great Valentines Day Flowers? Send Flowers Online With FlowerWyz Valentines Flowers Delivery Service. Accredited Same or Next Day Delivery Service for Valentine Flowers and Valentine Gift Baskets. Call us Today!';
        $meta_keywords = 'valentines day flowers, valentines flowers, valentine flowers, valentine gift baskets, valentines flowers delivery, cheap valentines day flowers, valentines day flower delivery, valentine flower, valentine delivery gifts, valentine flower delivery, valentines flower delivery, cheap valentines flowers, valentine day flowers delivery, valentine gift basket';
    } elseif ($header_page_id == '13') { //GET WELL
        $page_content = 'getwell_content.php';
        $canonical = 'get-well-gift-baskets-get-well-flowers-online.htm';
        $head_prm1 = 'Get Well Gift Baskets | Buy Get Well Flowers Delivery Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'GET WELL FLOWERS';
        $footer_content = 'FlowerWyz | Get Well Gift Baskets | Buy Get Well Flowers Delivery.';
        $page_title = 'FlowerWyz Get Well Gift Baskets | Buy Get Well Flowers Delivery';
        $meta_description = 'Looking for Great Get Well Gift Baskets? Buy Get Well Flowers Delivery Online With FlowerWyz. Accredited Delivery Service for Homes and Hospitals - Get Well Soon Flowers and Get Well Baskets. Call us Today!';
        $meta_keywords = 'get well gift baskets, get well flowers, get well gift basket, get well flower, get well flower delivery, get well flowers delivery, get well flower online, get well flowers online, order get well flower online, order get well flowers online, buy get well flower online, buy get well flowers online, buy get well flower, buy get well flowers';
    } elseif ($header_page_id == '14') { //FRESH FLOWERS
        $page_content = 'fresh_content.php';
        $canonical = 'fresh-flowers.htm';
        $head_prm1 = 'Fresh Cut Flowers Online | Order Fresh Flower Delivery | Fresh Flowers Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'FRESH CUT FLOWERS';
        $footer_content = 'FlowerWyz | Fresh Cut Flowers Online | Order Fresh Flower Delivery | Fresh Flowers Wholesale.';
        $page_title = 'FlowerWyz Fresh Cut Flowers Online | Order Fresh Flower Delivery | Fresh Flowers Wholesale';
        $meta_description = 'Looking for Fresh Cut Flowers Online? Order Fresh Flower Delivery Online With FlowerWyz. Accredited Same or Next Day Delivery Service for Fresh Flowers Wholesale. Call us Today!';
        $meta_keywords = 'fresh flowers, fresh cut flowers, fresh flowers wholesale, fresh flower delivery, fresh flowers online, fresh flower arrangements, fresh flowers delivery, cheap fresh flowers. fresh flower, fresh cut flowers online, order fresh flowers online, freshest flowers online, fresh flowers online delivery';
    } elseif ($header_page_id == '15') { //LOCAL
        $page_content = 'local_content.php';
        $canonical = 'local-flowers.htm';
        $head_prm1 = 'Local Flower Delivery | Local Flowers from Local Florists & Local Flower Shops';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'LOCAL FLOWERS ONLINE';
        $footer_content = 'FlowerWyz | Local Flower Delivery | Local Flowers from Local Florists and Local Flower Shops.';
        $page_title = 'FlowerWyz Local Flower Delivery | Local Flowers from Local Florists and Local Flower Shops';
        $meta_description = 'Looking for a Great Local Flower Delivery Service? Send Local Flowers from Local Florists and Local Flower Shops via FlowerWyz. Accredited Same or Next Day Delivery Service. Call us Today!';
        $meta_keywords = 'local florist, local flower shops, local flower delivery, local florists, local florist delivery, local flowers, local flower shop, local flowers delivery, local flower delivery service';
    } elseif ($header_page_id == '16') { //INTERNATIONAL
        $page_content = 'international_content.php';
        $canonical = 'international-flowers.htm';
        $head_prm1 = 'International Flower Delivery | International Flowers | Send Flowers Internationally';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'INTERNATIONAL FLOWERS';
        $footer_content = 'FlowerWyz | International Flower Delivery | International Flowers | Send Flowers Internationally.';
        $page_title = 'FlowerWyz International Flower Delivery | International Flowers | Send Flowers Internationally';
        $meta_description = 'Looking for The Best Cheap International Flower Delivery Service? Send Flowers Internationally Online With FlowerWyz. Accredited Same or Next Day Delivery Service for International Flowers. Call us Today!';
        $meta_keywords = 'international flower delivery, send flowers internationally, international flowers, sending flowers internationally, flowers international, international florist, flowers international delivery, flower delivery international, international flower, flower international, international florists, international flowers online, international flower online';
    } elseif ($header_page_id == '17') { //ROSES
        $page_content = 'roses_content.php';
        $canonical = 'fresh-flowers/cheap-roses-a-dozen-roses-buy-roses-delivery-online.htm';
        $head_prm1 = 'Cheap Roses for Sale | A Dozen Roses Delivery | Buy Roses and Rose Bushes';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'CHEAP ROSES DELIVERY';
        $footer_content = 'FlowerWyz | Cheap Roses for Sale | A Dozen Roses Delivery | Buy Roses and Rose Bushes for Sale.';
        $page_title = 'FlowerWyz Cheap Roses for Sale | A Dozen Roses Delivery | Buy Roses and Rose Bushes for Sale';
        $meta_description = 'Looking for Cheap Roses for Sale? Buy Roses and Rose Bushes for Sale at FlowerWyz. A Dozen Roses Delivery Same or Next Day. Call us Today!';
        $meta_keywords = 'roses, dozen roses, a dozen roses, roses for sale, rose bushes for sale, roses delivery, cheap roses, rose delivery, 2 dozen roses, flowers roses, dozen red roses, buy roses, 3 dozen roses, send roses, dozen roses price, where to buy roses';
    } elseif ($header_page_id == '18') { //ATLANTA
        $page_content = 'atlanta_content.php';
        $canonical = 'local-flowers/atlanta-florists-atlanta-flower-shops-atlanta-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Atlanta | Cheap Atlanta Flowers Delivery from Atlanta Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'ATLANTA FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Atlanta | Cheap Atlanta Flowers Delivery from Atlanta Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Atlanta | Cheap Atlanta Flowers Delivery from Atlanta Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Atlanta? Buy Cheap Atlanta Flowers Delivery from Atlanta Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Atlanta, Atlanta Flower Delivery, Atlanta Flowers, Atlanta Flower, Cheap Atlanta Flowers, Cheap Atlanta Flower, Atlanta Flowers Delivery, Flowers Delivery Atlanta, Atlanta Florists, Atlanta Florist, Florists Atlanta, Florist Atlanta, Atlanta Flower Shop, Atlanta Flower Shops, Flower Shops Atlanta, Atlanta Flower Market';
    } elseif ($header_page_id == '19') { //BALTIMORE
        $page_content = 'baltimore_content.php';
        $canonical = 'local-flowers/baltimore-florists-baltimore-flower-shops-baltimore-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Baltimore | Cheap Baltimore Flowers Delivery from Baltimore Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'BALTIMORE FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Baltimore | Cheap Baltimore Flowers Delivery from Baltimore Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Baltimore | Cheap Baltimore Flowers Delivery from Baltimore Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Baltimore? Buy Cheap Baltimore Flowers Delivery from Baltimore Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Baltimore, Baltimore Flower Delivery, Baltimore Flowers, Baltimore Flower, Cheap Baltimore Flowers, Cheap Baltimore Flower, Baltimore Flowers Delivery, Flowers Delivery Baltimore, Baltimore Florists, Baltimore Florist, Florists Baltimore, Florist Baltimore, Baltimore Flower Shop, Baltimore Flower Shops, Flower Shops Baltimore, Baltimore Flower Market';
    } elseif ($header_page_id == '20') { //BOSTON
        $page_content = 'boston_content.php';
        $canonical = 'local-flowers/boston-florists-boston-flower-shops-boston-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Boston | Cheap Boston Flowers Delivery from Boston Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'BOSTON FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Boston | Cheap Boston Flowers Delivery from Boston Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Boston | Cheap Boston Flowers Delivery from Boston Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Boston? Buy Cheap Boston Flowers Delivery from Boston Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Boston, Boston Flower Delivery, Boston Flowers, Boston Flower, Cheap Boston Flowers, Cheap Boston Flower, Boston Flowers Delivery, Flowers Delivery Boston, Boston Florists, Boston Florist, Florists Boston, Florist Boston, Boston Flower Shop, Boston Flower Shops, Flower Shops Boston, Boston Flower Market';
    } elseif ($header_page_id == '21') { // CHICAGO
        $page_content = 'chicago_content.php';
        $canonical = 'local-flowers/chicago-florists-chicago-flower-shops-chicago-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Chicago | Cheap Chicago Flowers Delivery from Chicago Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'CHICAGO FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Chicago | Cheap Chicago Flowers Delivery from Chicago Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Chicago | Cheap Chicago Flowers Delivery from Chicago Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Chicago? Buy Cheap Chicago Flowers Delivery from Chicago Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Chicago, Chicago Flower Delivery, Chicago Flowers, Chicago Flower, Cheap Chicago Flowers, Cheap Chicago Flower, Chicago Flowers Delivery, Flowers Delivery Chicago, Chicago Florists, Chicago Florist, Florists Chicago, Florist Chicago, Chicago Flower Shop, Chicago Flower Shops, Flower Shops Chicago, Chicago Flower Market';
    } elseif ($header_page_id == '22') { //DALLAS
        $page_content = 'dallas_content.php';
        $canonical = 'local-flowers/dallas-florists-dallas-flower-shops-dallas-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Dallas | Cheap Dallas Flowers Delivery from Dallas Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'DALLAS FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Dallas | Cheap Dallas Flowers Delivery from Dallas Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Dallas | Cheap Dallas Flowers Delivery from Dallas Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Dallas? Buy Cheap Dallas Flowers Delivery from Dallas Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Dallas, Dallas Flower Delivery, Dallas Flowers, Dallas Flower, Cheap Dallas Flowers, Cheap Dallas Flower, Dallas Flowers Delivery, Flowers Delivery Dallas, Dallas Florists, Dallas Florist, Florists Dallas, Florist Dallas, Dallas Flower Shop, Dallas Flower Shops, Flower Shops Dallas, Dallas Flower Market';
    } elseif ($header_page_id == '23') { //DENVER
        $page_content = 'denver_content.php';
        $canonical = 'local-flowers/denver-florists-denver-flower-shops-denver-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Denver | Cheap Denver Flowers Delivery from Denver Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'DENVER FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Denver | Cheap Denver Flowers Delivery from Denver Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Denver | Cheap Denver Flowers Delivery from Denver Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Denver? Buy Cheap Denver Flowers Delivery from Denver Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Denver, Denver Flower Delivery, Denver Flowers, Denver Flower, Cheap Denver Flowers, Cheap Denver Flower, Denver Flowers Delivery, Flowers Delivery Denver, Denver Florists, Denver Florist, Florists Denver, Florist Denver, Denver Flower Shop, Denver Flower Shops, Flower Shops Denver, Denver Flower Market';
    } elseif ($header_page_id == '24') { //HOUSTON
        $page_content = 'houston_content.php';
        $canonical = 'local-flowers/houston-florists-houston-flower-shops-houston-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Houston | Cheap Houston Flowers Delivery from Houston Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'HOUSTON FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Houston | Cheap Houston Flowers Delivery from Houston Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Houston | Cheap Houston Flowers Delivery from Houston Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Houston? Buy Cheap Houston Flowers Delivery from Houston Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Houston, Houston Flower Delivery, Houston Flowers, Houston Flower, Cheap Houston Flowers, Cheap Houston Flower, Houston Flowers Delivery, Flowers Delivery Houston, Houston Florists, Houston Florist, Florists Houston, Florist Houston, Houston Flower Shop, Houston Flower Shops, Flower Shops Houston, Houston Flower Market';
    } elseif ($header_page_id == '38') { //LOS ANGELES
        $page_content = 'los_angeles_content.php';
        $canonical = 'local-flowers/la-florists-la-flower-shops-los-angeles-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery LA | Cheap Los Angeles Flowers Delivery from LA Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'LOS ANGELES FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery LA | Cheap Los Angeles Flowers Delivery from LA Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery LA | Cheap Los Angeles Flowers Delivery from LA Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery LA? Buy Cheap Los Angeles Flowers Delivery from LA Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery LA, LA Flower Delivery, LA Flowers, LA Flower, Flower Delivery Los Angeles, Los Angeles Flower Delivery, Los Angeles Flowers, Los Angeles Flower, Cheap LA Flowers, Cheap LA Flower, LA Flowers Delivery, Flowers Delivery LA, LA Florists, LA Florist, Florists LA, Florist LA';
    } elseif ($header_page_id == '25') { //MINNEAPOLIS
        $page_content = 'minneapolis_content.php';
        $canonical = 'local-flowers/minneapolis-florists-minneapolis-flower-shops-minneapolis-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Minneapolis | Cheap Minneapolis Flowers Delivery Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'MINNEAPOLIS FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Minneapolis | Cheap Minneapolis Flowers Delivery from Minneapolis Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Minneapolis | Cheap Minneapolis Flowers Delivery from Minneapolis Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Minneapolis? Buy Cheap Minneapolis Flowers Delivery from Minneapolis Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Minneapolis, Minneapolis Flower Delivery, Minneapolis Flowers, Minneapolis Flower, Cheap Minneapolis Flowers, Cheap Minneapolis Flower, Minneapolis Flowers Delivery, Flowers Delivery Minneapolis, Minneapolis Florists, Minneapolis Florist, Florists Minneapolis, Florist Minneapolis, Minneapolis Flower Shop, Minneapolis Flower Shops, Flower Shops Minneapolis, Minneapolis Flower Market';
    } elseif ($header_page_id == '26') { //NEW YORK
        $page_content = 'new_york_content.php';
        $canonical = 'local-flowers/nyc-florists-nyc-flower-shops-nyc-flower-delivery-online-newyork.htm';
        $head_prm1 = 'Flower Delivery NYC | Flowers NYC | New York Flowers Delivery from Florists NYC';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'NEW YORK FLOWERS NYC';
        $footer_content = 'FlowerWyz | Flower Delivery NYC | Flowers NYC | New York Flowers Delivery from Flower District NYC & Florist NYC.';
        $page_title = 'FlowerWyz Flower Delivery NYC | Flowers NYC | New York Flowers Delivery from Flower District NYC & Florist NYC';
        $meta_description = 'Looking for The Best Flower Delivery NYC? Buy New York Flowers Delivery from NYC Florists and Flower District NYC via FlowerWyz. Call us Today for Flowers NYC!';
        $meta_keywords = 'flower delivery nyc, flower district nyc, florist nyc, flowers nyc, nyc flower delivery, new york flower, flower delivery new york, nyc florist, new york flower delivery, nyc flower district, flower market nyc, new york florist, florists nyc, new york flowers, flower shops nyc, wholesale flowers nyc';
    } elseif ($header_page_id == '27') { //PITTSBURGH
        $page_content = 'pittsburgh_content.php';
        $canonical = 'local-flowers/pittsburgh-florists-pittsburgh-flower-shops-pittsburgh-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Pittsburgh | Cheap Pittsburgh Flowers Delivery Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'PITTSBURGH FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Pittsburgh | Cheap Pittsburgh Flowers Delivery from Pittsburgh Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Pittsburgh | Cheap Pittsburgh Flowers Delivery from Pittsburgh Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Pittsburgh? Buy Cheap Pittsburgh Flowers Delivery from Pittsburgh Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Pittsburgh, Pittsburgh Flower Delivery, Pittsburgh Flowers, Pittsburgh Flower, Cheap Pittsburgh Flowers, Cheap Pittsburgh Flower, Pittsburgh Flowers Delivery, Flowers Delivery Pittsburgh, Pittsburgh Florists, Pittsburgh Florist, Florists Pittsburgh, Florist Pittsburgh, Pittsburgh Flower Shop, Pittsburgh Flower Shops, Flower Shops Pittsburgh, Pittsburgh Flower Market';
    } elseif ($header_page_id == '39') { //SAN DIEGO
        $page_content = 'san_diego_content.php';
        $canonical = 'local-flowers/san-diego-florists-san-diego-flower-shops-san-diego-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery San Diego | Cheap San Diego Flowers Delivery Online';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'SAN DIEGO FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery San Diego | Cheap San Diego Flowers Delivery from San Diego Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery San Diego | Cheap San Diego Flowers Delivery from San Diego Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery San Diego? Buy Cheap San Diego Flowers Delivery from San Diego Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery San Diego, San Diego Flower Delivery, San Diego Flowers, San Diego Flower, Cheap San Diego Flowers, Cheap San Diego Flower, San Diego Flowers Delivery, Flowers Delivery San Diego, San Diego Florists, San Diego Florist, Florists San Diego, Florist San Diego, San Diego Flower Shop, San Diego Flower Shops, Flower Shops San Diego, San Diego Flower Market';
    } elseif ($header_page_id == '28') { //SAN FRANCISCO
        $page_content = 'san_francisco_content.php';
        $canonical = 'local-flowers/san-francisco-florists-san-francisco-flower-shops-san-francisco-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery San Francisco | Flowers San Francisco from San Francisco Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'SF FLOWER DELIVERY';
        $footer_content = 'FlowerWyz | Flower Delivery San Francisco | Flowers San Francisco from San Francisco Florists and San Francisco Flower Mart.';
        $page_title = 'FlowerWyz Flower Delivery San Francisco | Flowers San Francisco from San Francisco Florists and San Francisco Flower Mart';
        $meta_description = 'Looking for The Best Flower Delivery San Francisco? Buy Flowers San Francisco from San Francisco Florists and San Francisco Flower Mart via FlowerWyz. Call us Today!';
        $meta_keywords = 'flower delivery san francisco, san francisco flower mart, san francisco flower market, san francisco flower delivery, san francisco florist, flowers san francisco, florist san francisco, san francisco florists, flower shop san francisco, san francisco flower show, florists san francisco, san francisco flowers, sf flower delivery, flower mart san francisco, flower market san francisco, florists in san francisco';
    } elseif ($header_page_id == '29') { //SEATTLE
        $page_content = 'seattle_content.php';
        $canonical = 'local-flowers/seattle-florists-seattle-flower-shops-seattle-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Seattle | Cheap Seattle Flowers Delivery from Seattle Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'SEATTLE FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Seattle | Cheap Seattle Flowers Delivery from Seattle Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Seattle | Cheap Seattle Flowers Delivery from Seattle Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Seattle? Buy Cheap Seattle Flowers Delivery from Seattle Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Seattle, Seattle Flower Delivery, Seattle Flowers, Seattle Flower, Cheap Seattle Flowers, Cheap Seattle Flower, Seattle Flowers Delivery, Flowers Delivery Seattle, Seattle Florists, Seattle Florist, Florists Seattle, Florist Seattle, Seattle Flower Shop, Seattle Flower Shops, Flower Shops Seattle, Seattle Flower Market';
    } elseif ($header_page_id == '30') { //ST LOUIS
        $page_content = 'st_louis_content.php';
        $canonical = 'local-flowers/st-louis-florists-st-louis-flower-shops-st-louis-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery St Louis | Cheap St Louis Flowers Delivery from St Louis Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'ST LOUIS FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery St Louis | Cheap St Louis Flowers Delivery from St Louis Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery St Louis | Cheap St Louis Flowers Delivery from St Louis Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery St Louis? Buy Cheap St Louis Flowers Delivery from St Louis Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery St Louis, St Louis Flower Delivery, St Louis Flowers, St Louis Flower, Cheap St Louis Flowers, Cheap St Louis Flower, St Louis Flowers Delivery, Flowers Delivery St Louis, St Louis Florists, St Louis Florist, Florists St Louis, Florist St Louis, St Louis Flower Shop, St Louis Flower Shops, Flower Shops St Louis, St Louis Flower Market';
    } elseif ($header_page_id == '31') { //TULSA
        $page_content = 'tulsa_content.php';
        $canonical = 'local-flowers/tulsa-florists-tulsa-flower-shops-tulsa-flower-delivery-online.htm';
        $head_prm1 = 'Flower Delivery Tulsa | Cheap Tulsa Flowers Delivery from Tulsa Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'TULSA FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Tulsa | Cheap Tulsa Flowers Delivery from Tulsa Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Tulsa | Cheap Tulsa Flowers Delivery from Tulsa Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Tulsa? Buy Cheap Tulsa Flowers Delivery from Tulsa Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Tulsa, Tulsa Flower Delivery, Tulsa Flowers, Tulsa Flower, Cheap Tulsa Flowers, Cheap Tulsa Flower, Tulsa Flowers Delivery, Flowers Delivery Tulsa, Tulsa Florists, Tulsa Florist, Florists Tulsa, Florist Tulsa, Tulsa Flower Shop, Tulsa Flower Shops, Flower Shops Tulsa, Tulsa Flower Market';
    } elseif ($header_page_id == '32') { //TO CANADA
        $page_content = 'canada_content.php';
        $canonical = 'international-flowers/send-flowers-to-canada-from-usa.htm';
        $head_prm1 = 'Flower Delivery Canada | Cheap Canada Flowers Delivery | Send Flowers to Canada';
        $head_prm2 = 'SEND';
        $head_prm3 = 'INTERNATIONAL **';
        $head_prm4 = 'FLOWERS TO CANADA';
        $footer_content = 'FlowerWyz | Simple & Cheap Flower Delivery Service.';
        $page_title = 'FlowerWyz Flower Delivery Canada | Cheap Canada Flowers Delivery | Send Flowers to Canada';
        $meta_description = 'Looking for The Best Flower Delivery Canada? Buy Cheap Canada Flowers Delivery and Send Flowers to Canada via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Canada,Canada Flower Delivery,Canada Flowers,Canada Flower,Cheap Canada Flowers,Cheap Canada Flower,Canada Flowers Delivery,Flowers Delivery Canada,Canada Florists,Canada Florist,Florists Canada,Florist Canada,send flowers to Canada,flowers to Canada,flower to Canada,send flowers Canada';
    } elseif ($header_page_id == '33') { //TO GERMANY
        $page_content = 'germany_content.php';
        $canonical = 'wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm';
        $head_prm1 = 'Flower to Germany | Send Flowers to Germany from USA';
        $head_prm2 = 'SEND';
        $head_prm3 = 'INTERNATIONAL **';
        $head_prm4 = 'FLOWERS TO GERMANY';
        $footer_content = 'FlowerWyz | Simple & Cheap Flower Delivery Service.';
        $page_title = 'FlowerWyz Flower to Germany | Send Flowers to Germany from USA';
        $meta_description = 'FlowerWyz Flower to Germany - Sending Flowers to Germany has never been easier. Send Flowers to Germany from USA anyday and everyday. Call us Today!';
        $meta_keywords = 'send flowers to Germany, flowers to Germany, flower to Germany, sending flowers to Germany, send flowers to Germany from usa, send flowers Germany, send flower to Germany, sending flowers to Germany from usa, send flowers online Germany, how to send flowers to Germany, send flowers to Germany from usa online, how to send flowers to Germany from usa, sending flower to Germany';
    } elseif ($header_page_id == '34') { //TO INDIA
        $page_content = 'india_content.php';
        $canonical = 'wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm';
        $head_prm1 = 'Flower to India | Send Flowers to India from USA';
        $head_prm2 = 'SEND';
        $head_prm3 = 'INTERNATIONAL **';
        $head_prm4 = 'FLOWERS TO INDIA';
        $footer_content = 'FlowerWyz | Simple & Cheap Flower Delivery Service.';
        $page_title = 'FlowerWyz Flower to India | Send Flowers to India from USA';
        $meta_description = 'FlowerWyz Flower to India - Sending Flowers to India has never been easier. Send Flowers to India from USA anyday and everyday. Call us Today!';
        $meta_keywords = 'send flowers to India, flowers to India, flower to India, sending flowers to India, send flowers to India from usa, send flowers India, send flower to India, sending flowers to India from usa, send flowers online India, how to send flowers to India, send flowers to India from usa online, how to send flowers to India from usa, sending flower to India';
    } elseif ($header_page_id == '35') { //TO MEXICO
        $page_content = 'mexico_content.php';
        $canonical = 'wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm';
        $head_prm1 = 'Flower to Mexico | Send Flowers to Mexico from USA';
        $head_prm2 = 'SEND';
        $head_prm3 = 'INTERNATIONAL **';
        $head_prm4 = 'FLOWERS TO MEXICO';
        $footer_content = 'FlowerWyz | Simple & Cheap Flower Delivery Service.';
        $page_title = 'FlowerWyz Flower to Mexico | Send Flowers to Mexico from USA';
        $meta_description = 'FlowerWyz Flower to Mexico - Sending Flowers to Mexico has never been easier. Send Flowers to Mexico from USA anyday and everyday. Call us Today!';
        $meta_keywords = 'send flowers to Mexico, flowers to Mexico, flower to Mexico, sending flowers to Mexico, send flowers to Mexico from usa, send flowers Mexico, send flower to Mexico, sending flowers to Mexico from usa, send flowers online Mexico, how to send flowers to Mexico, send flowers to Mexico from usa online, how to send flowers to Mexico from usa, sending flower to Mexico';
    } elseif ($header_page_id == '36') { //TO RUSSIA
        $page_content = 'russia_content.php';
        $canonical = 'wedding-anniversary-flowers-wedding-anniversary-gifts-ideas.htm';
        $head_prm1 = 'Flower to Russia | Send Flowers to Russia from USA';
        $head_prm2 = 'SEND';
        $head_prm3 = 'INTERNATIONAL **';
        $head_prm4 = 'FLOWERS TO RUSSIA';
        $footer_content = 'FlowerWyz | Simple & Cheap Flower Delivery Service.';
        $page_title = 'FlowerWyz Flower to Russia | Send Flowers to Russia from USA';
        $meta_description = 'FlowerWyz Flower to Russia - Sending Flowers to Russia has never been easier. Send Flowers to Russia from USA anyday and everyday. Call us Today!';
        $meta_keywords = 'send flowers to Russia, flowers to Russia, flower to Russia, sending flowers to Russia, send flowers to Russia from usa, send flowers Russia, send flower to Russia, sending flowers to Russia from usa, send flowers online Russia, how to send flowers to Russia, send flowers to Russia from usa online, how to send flowers to Russia from usa, sending flower to Russia';
    } elseif ($header_page_id == '40') { //ARRANGEMENTS
        $page_content = 'arrangement_content.php';
        $canonical = 'floral-arrangements-floral-delivery-from-local-florists-and-online-florists.htm';
        $head_prm1 = 'Cheap Floral Arrangements | Floral Delivery and Flower Arrangements Ideas';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY **';
        $head_prm4 = 'FLOWER ARRANGEMENTS';
        $footer_content = 'FlowerWyz | Cheap Floral Arrangements | Floral Delivery and Flower Arrangements Ideas.';
        $page_title = 'FlowerWyz Cheap Floral Arrangements | Floral Delivery and Flower Arrangements Ideas';
        $meta_description = 'Looking for Cheap Floral Arrangements? Check out FlowerWyz for Floral Delivery and Flower Arrangements Ideas. Learn How to Make Floral Arrangements. Call us Today!';
        $meta_keywords = 'flower arrangements,floral arrangements,floral delivery,flower arrangement,flowers arrangements,flower arrangements ideas,floral arrangement,how to make floral arrangements,cheap flower arrangements,modern floral arrangements,floral arrangement ideas,spring floral arrangements,cheap floral arrangements,unique floral arrangements,large floral arrangements,dried floral arrangements';
    } elseif ($header_page_id == '41') { //PLANTS
        $page_content = 'plant_content.php';
        $canonical = 'send-plants-send-a-plant-delivery-orchid-delivery.htm';
        $head_prm1 = 'Plant Delivery | Indoor Plants | Potted Plants | Indoor House Plants';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'HOUSE PLANT DELIVERY';
        $footer_content = 'FlowerWyz Plant Delivery | Indoor Plants | Potted Plants | Indoor House Plants for Sale | Buy Plants Online at Our Plant Store.';
        $page_title = 'FlowerWyz Plant Delivery | Indoor Plants | Potted Plants | Indoor House Plants for Sale | Buy Plants Online at Our Plant Store';
        $meta_description = 'Looking for The Best Cheap Plant Delivery Service? Check Out Our Indoor Plants, Potted Plants & Indoor House Plants for Sale. Buy Plants Online at Our Plant Store. Call us Today!';
        $meta_keywords = 'indoor plants,house plants,plants for sale,potted plants,indoor house plants,buy plants online,indoor plant,house plants for sale,plant store,plant delivery,flower plants,flowering house plants,indoor hanging plants,order plants online,buy trees online,tropical plants for sale';
    } elseif ($header_page_id == '42') { //BOUQUETS
        $page_content = 'bouquet_content.php';
        $canonical = 'bouquet-of-flowers-flower-bouquets-balloon-bouquets-bouquet-of-roses.htm';
        $head_prm1 = 'Bouquet of Flowers | Flower Bouquets | Balloon Bouquets | Bouquet of Roses';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FLOWERT BOUQUETS';
        $footer_content = 'FlowerWyz | Bouquet of Flowers | Flower Bouquets | Balloon Bouquets | Bouquet of Roses.';
        $page_title = 'FlowerWyz Bouquet of Flowers | Flower Bouquets | Balloon Bouquets | Bouquet of Roses';
        $meta_description = 'Looking for Great Flower Bouquets and Balloon Bouquets? Check out FlowerWyz for Beautiful Bouquet of Flowers and Bouquet of Roses for Same or Next Day Delivery Service. Call us Today!';
        $meta_keywords = 'bouquet, bouquet of flowers, flower bouquets, balloon bouquets, bouquet of roses, bouquets, flower bouquet, rose bouquets, rose bouquet, flowers bouquet, bouquet flowers, balloon bouquet, roses bouquet, balloon bouquet delivery, balloon bouquets delivered, bouquet delivery';
    } elseif ($header_page_id == '43') { //EXOTIC
        $page_content = 'exotic_content.php';
        $canonical = 'exotic-flowers-and-exotic-plants-for-sale.htm';
        $head_prm1 = 'Exotic House Plants | Exotic Flowers and Exotic Plants for Sale';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'EXOTIC FLOWERS';
        $footer_content = 'FlowerWyz | Exotic House Plants | Exotic Flowers and Exotic Plants for Sale.';
        $page_title = 'FlowerWyz Exotic House Plants | Exotic Flowers and Exotic Plants for Sale';
        $meta_description = 'Looking for Exotic Flowers and Exotic Plants for Sale? Send Exotic House Plants Online With FlowerWyz Delivery Service. Accredited Same or Next Day Delivery Service. Call us Today!';
        $meta_keywords = 'exotic flowers, exotic plants, exotic flower, exotic house plants, exotic plants for sale, exotic indoor plants, exotic plants and flowers, exotic flower delivery, exotic flowers delivery, exotic flower online, exotic flowers online, order exotic flower online, order exotic flowers online, buy exotic flower online, buy exotic flowers online, buy exotic flower';
    } elseif ($header_page_id == '44') { //FUNERALS
        $page_content = 'funeral_content.php';
        $canonical = 'funeral-flowers-for-funeral-flower-arrangements.htm';
        $head_prm1 = 'Cheap Funeral Flowers Delivery | Flowers for Funeral Flower Arrangements';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FLOWERS FOR FUNERAL';
        $footer_content = 'FlowerWyz | Cheap Funeral Flowers Delivery | Flowers for Funeral Flower Arrangements.';
        $page_title = 'FlowerWyz Cheap Funeral Flowers Delivery | Flowers for Funeral Flower Arrangements';
        $meta_description = 'Looking for a Cheap Funeral Flowers Delivery Service? Send Flowers for Funeral Online With FlowerWyz. Accredited Same or Next Day Delivery Service for Funeral Flower Arrangements. Call us Today!';
        $meta_keywords = 'funeral flowers, flowers for funeral, funeral flower arrangements, flower arrangements for funerals, funeral floral arrangements, cheap funeral flowers, funeral flower, flowers for funerals, floral arrangements for funerals, funeral flowers online, order flowers for funeral, funeral flower arrangement';
    } elseif ($header_page_id == '45') { //WEDDING
        $page_content = 'wedding_content.php';
        $canonical = 'wedding-bouquets-bridal-bouquets-flowers-for-wedding-flowers-online.htm';
        $head_prm1 = 'Wedding Flowers Online | Wedding Bouquets | Bridal Bouquets | Flowers for Weddings';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'WEDDING FLOWERS';
        $footer_content = 'FlowerWyz | Wedding Flowers Online | Wedding Bouquets | Bridal Bouquets | Flowers for Weddings Flower Arrangements.';
        $page_title = 'FlowerWyz Wedding Flowers Online | Wedding Bouquets | Bridal Bouquets | Flowers for Weddings Flower Arrangements';
        $meta_description = 'Looking for Great Wedding Flowers Online? Check out Wedding Bouquets and Bridal Bouquets at FlowerWyz. Accredited Same or Next Day Delivery Service for Flowers for Weddings Flower Arrangements. Call us Today!';
        $meta_keywords = 'wedding flowers, wedding bouquets, bridal bouquets, flowers for weddings, wedding flowers online, wedding flower arrangements, silk wedding bouquets, bridesmaid bouquets, cheap wedding flowers, bridal flowers, wedding florist, wedding floral arrangements, bridesmaids bouquets,flower arrangements for weddings, wholesale wedding flowers, cheap wedding bouquets';
    } elseif ($header_page_id == '46') { //Montreal, Canada
        $page_content = 'montreal_content.php';
        $canonical = 'international-flowers/montreal-florists-montreal-flower-delivery-montreal-canada.htm';
        $head_prm1 = 'Flower Delivery Montreal | Cheap Montreal Flowers Delivery from Montreal Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'MONTREAL FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Montreal | Cheap Montreal Flowers Delivery from Montreal Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Montreal Canada | Cheap Montreal Flowers Delivery from Montreal Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Montreal Canada? Buy Cheap Montreal Flowers Delivery from Montreal Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Montreal,Best Florists Montreal,Montreal Flower Delivery,Montreal Flowers,Montreal Flower,Cheap Montreal Flowers,Online Florist Montreal,Cheap Montreal Flower,Montreal Flowers Delivery,Montreal Flower Online,Flowers Delivery Montreal,Best Montreal Florists,Montreal Flower Shop,Montreal Flower Market,Flower Shops Montreal Canada,Send Flower Montreal Canada';
    } elseif ($header_page_id == '47') { //Toronto, Canada
        $page_content = 'toronto_content.php';
        $canonical = 'international-flowers/toronto-florists-toronto-flower-delivery-toronto-canada.htm';
        $head_prm1 = 'Flower Delivery Toronto | Cheap Toronto Flowers Delivery from Toronto Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'TORONTO FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Toronto | Cheap Toronto Flowers Delivery from Toronto Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Toronto Canada | Cheap Toronto Flowers Delivery from Toronto Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Toronto Canada? Buy Cheap Toronto Flowers Delivery from Toronto Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Toronto,Best Florists Toronto,Toronto Flower Delivery,Toronto Flowers,Toronto Flower,Cheap Toronto Flowers,Online Florist Toronto,Cheap Toronto Flower,Toronto Flowers Delivery,Toronto Flower Online,Flowers Delivery Toronto,Best Toronto Florists,Toronto Flower Shop,Toronto Flower Market,Flower Shops Toronto Canada,Send Flower Toronto Canada';
    } elseif ($header_page_id == '48') { //Quebec, Canada
        $page_content = 'quebec_content.php';
        $canonical = 'international-flowers/quebec-florists-quebec-flower-delivery-quebec-canada.htm';
        $head_prm1 = 'Flower Delivery Quebec | Cheap Quebec Flowers Delivery from Quebec Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'QUEBEC FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Quebec | Cheap Quebec Flowers Delivery from Quebec Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Quebec Canada | Cheap Quebec Flowers Delivery from Quebec Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Quebec Canada? Buy Cheap Quebec Flowers Delivery from Quebec Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Quebec,Best Florists Quebec,Quebec Flower Delivery,Quebec Flowers,Quebec Flower,Cheap Quebec Flowers,Online Florist Quebec,Cheap Quebec Flower,Quebec Flowers Delivery,Quebec Flower Online,Flowers Delivery Quebec,Best Quebec Florists,Quebec Flower Shop,Quebec Flower Market,Flower Shops Quebec Canada,Send Flower Quebec Canada';
    } elseif ($header_page_id == '49') { //Halifax, Canada
        $page_content = 'halifax_content.php';
        $canonical = 'international-flowers/halifax-florists-halifax-flower-delivery-halifax-canada.htm';
        $head_prm1 = 'Flower Delivery Halifax | Cheap Halifax Flowers Delivery from Halifax Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'HALIFAX FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Halifax | Cheap Halifax Flowers Delivery from Halifax Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Halifax Canada | Cheap Halifax Flowers Delivery from Halifax Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Halifax Canada? Buy Cheap Halifax Flowers Delivery from Halifax Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Halifax,Best Florists Halifax,Halifax Flower Delivery,Halifax Flowers,Halifax Flower,Cheap Halifax Flowers,Online Florist Halifax,Cheap Halifax Flower,Halifax Flowers Delivery,Halifax Flower Online,Flowers Delivery Halifax,Best Halifax Florists,Halifax Flower Shop,Halifax Flower Market,Flower Shops Halifax Canada,Send Flower Halifax Canada';
    } elseif ($header_page_id == '50') { //Hamilton, Canada
        $page_content = 'hamilton_content.php';
        $canonical = 'international-flowers/hamilton-florists-hamilton-flower-delivery-hamilton-canada.htm';
        $head_prm1 = 'Flower Delivery Hamilton | Cheap Hamilton Flowers Delivery from Hamilton Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'HAMILTON FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Hamilton | Cheap Hamilton Flowers Delivery from Hamilton Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Hamilton Canada | Cheap Hamilton Flowers Delivery from Hamilton Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Hamilton Canada? Buy Cheap Hamilton Flowers Delivery from Hamilton Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Hamilton,Best Florists Hamilton,Hamilton Flower Delivery,Hamilton Flowers,Hamilton Flower,Cheap Hamilton Flowers,Online Florist Hamilton,Cheap Hamilton Flower,Hamilton Flowers Delivery,Hamilton Flower Online,Flowers Delivery Hamilton,Best Hamilton Florists,Hamilton Flower Shop,Hamilton Flower Market,Flower Shops Hamilton Canada,Send Flower Hamilton Canada';
    } elseif ($header_page_id == '51') { //Ottawa, Canada
        $page_content = 'ottawa_content.php';
        $canonical = 'international-flowers/ottawa-florists-ottawa-flower-delivery-ottawa-canada.htm';
        $head_prm1 = 'Flower Delivery Ottawa | Cheap Ottawa Flowers Delivery from Ottawa Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'OTTAWA FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Ottawa | Cheap Ottawa Flowers Delivery from Ottawa Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Ottawa Canada | Cheap Ottawa Flowers Delivery from Ottawa Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Ottawa Canada? Buy Cheap Ottawa Flowers Delivery from Ottawa Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Ottawa,Best Florists Ottawa,Ottawa Flower Delivery,Ottawa Flowers,Ottawa Flower,Cheap Ottawa Flowers,Online Florist Ottawa,Cheap Ottawa Flower,Ottawa Flowers Delivery,Ottawa Flower Online,Flowers Delivery Ottawa,Best Ottawa Florists,Ottawa Flower Shop,Ottawa Flower Market,Flower Shops Ottawa Canada,Send Flower Ottawa Canada';
    } elseif ($header_page_id == '52') { //Portland, Canada
        $page_content = 'portland_content.php';
        $canonical = 'international-flowers/portland-florists-portland-flower-delivery-portland-canada.htm';
        $head_prm1 = 'Flower Delivery Portland | Cheap Portland Flowers Delivery from Portland Florists';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'PORTLAND FLOWERS';
        $footer_content = 'FlowerWyz | Flower Delivery Portland | Cheap Portland Flowers Delivery from Portland Florists and Flower Shops.';
        $page_title = 'FlowerWyz Flower Delivery Portland Canada | Cheap Portland Flowers Delivery from Portland Florists and Flower Shops';
        $meta_description = 'Looking for The Best Flower Delivery Portland Canada? Buy Cheap Portland Flowers Delivery from Portland Florists and Flower Shops via FlowerWyz. Call us Today!';
        $meta_keywords = 'Flower Delivery Portland,Best Florists Portland,Portland Flower Delivery,Portland Flowers,Portland Flower,Cheap Portland Flowers,Online Florist Portland,Cheap Portland Flower,Portland Flowers Delivery,Portland Flower Online,Flowers Delivery Portland,Best Portland Florists,Portland Flower Shop,Portland Flower Market,Flower Shops Portland Canada,Send Flower Portland Canada';
    } elseif ($header_page_id == '53') { //CENTERPIECES
        $page_content = 'centerpiece_content.php';
        $canonical = 'cheap-centerpiece-ideas-flower-centerpieces-dining-table-centerpieces-floating-candle-centerpieces.htm';
        $head_prm1 = 'Cheap Centerpiece Ideas | Flower Centerpieces | Floating Candle Centerpieces Ideas';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FLOWER CENTERPIECES';
        $footer_content = 'FlowerWyz | Cheap Centerpiece Ideas | Flower Centerpieces | Dining Table Centerpieces | Floating Candle Centerpieces Ideas.';
        $page_title = 'FlowerWyz Cheap Centerpiece Ideas | Flower Centerpieces | Dining Table Centerpieces | Floating Candle Centerpieces Ideas';
        $meta_description = 'Looking for The Best Cheap Centerpiece Ideas? Check out FlowerWyz for Simple Flower Centerpieces, Dining Table Centerpieces, Floating Candle Centerpieces Ideas. Call us Today!';
        $meta_keywords = 'centerpieces,table centerpieces,centerpiece ideas,centerpiece,flower centerpieces,dining table centerpieces,candle centerpieces,cheap centerpiece ideas,floral centerpieces,party centerpieces,table decoration ideas,simple centerpieces,centerpieces ideas,cheap centerpieces,floating candle centerpieces,centerpiece vases';
    } elseif ($header_page_id == '54') { //FUNERAL CASKET SPRAYS
        $page_content = 'casket_content.php';
        $canonical = 'funeral-flowers/funeral-casket-sprays-funeral-casket-flowers.htm';
        $head_prm1 = 'Cheap Funeral Casket Sprays and Casket Flowers | Top & Inside Casket Flowers';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FUNERAL CASKET SPRAYS';
        $footer_content = 'FlowerWyz | Cheap Funeral Casket Sprays and Casket Flowers | Inside Casket Flowers | Funeral Flowers For Top Of Casket.';
        $page_title = 'FlowerWyz Cheap Funeral Casket Sprays and Casket Flowers | Inside Casket Flowers | Funeral Flowers For Top Of Casket';
        $meta_description = 'Looking for The Best Cheap Funeral Casket Sprays and Casket Flowers? Check out FlowerWyz for All Flowers For Casket including Inside Casket Flowers and Funeral Flowers For Top Of Casket. Call us Today!';
        $meta_keywords = 'Casket Flowers,Casket Sprays,Funeral Casket Sprays,Cheap Casket Sprays,White Casket Spray,Casket Flower Blanket,Flowers For Casket,Funeral Casket Spray,Pink Casket Spray,Casket Blanket Of Flowers,Spray For Casket,Casket Spray,Funeral Casket Flowers,Casket With Flowers,Funeral Flowers For Top Of Casket';
    } elseif ($header_page_id == '55') { //FUNERAL PLANTS
        $page_content = 'funeralplant_content.php';
        $canonical = 'funeral-flowers/popular-funeral-plants-for-funerals.htm';
        $head_prm1 = 'Cheap Funeral Plants | Plants For Funerals | Common & Popular Funeral Plants';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FUNERAL PLANTS';
        $footer_content = 'FlowerWyz | Cheap Funeral Plants | Plants For Funerals | Popular Funeral Plants | Common Funeral Plants.';
        $page_title = 'FlowerWyz Cheap Funeral Plants | Plants For Funerals | Popular Funeral Plants | Common Funeral Plants';
        $meta_description = 'Looking for The Best Cheap Funeral Plants? Check out FlowerWyz for All Plants For Funerals including the Popular Funeral Plants and Common Funeral Plants. Call us Today!';
        $meta_keywords = 'Funeral Plants,Plants For Funerals,Popular Funeral Plants,Common Funeral Plants,Plants For Funeral,Funeral Plants And Flowers,Funeral Plants Names,Plants For Funeral,Green Plants For Funerals,Funeral Plant Arrangements,Funeral Plants Arrangements,Plant For Funeral,Plants For A Funeral,Potted Plants For Funerals,Plants For Funeral Service,Plant Arrangements For Funerals';
    } elseif ($header_page_id == '56') { //FUNERAL WREATHS
        $page_content = 'wreath_content.php';
        $canonical = 'funeral-flowers/cheap-funeral-wreaths-for-funerals.htm';
        $head_prm1 = 'Cheap Funeral Wreaths | Wreath Of Flowers | Wreaths For Funerals Designs';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FUNERAL WREATHS';
        $footer_content = 'FlowerWyz | Cheap Funeral Wreaths | Wreath Of Flowers | Wreaths For Funerals Designs | Flower Wreaths For Doors.';
        $page_title = 'FlowerWyz Cheap Funeral Wreaths | Wreath Of Flowers | Wreaths For Funerals Designs | Flower Wreaths For Doors';
        $meta_description = 'Looking for The Best Cheap Funeral Wreaths? Check out FlowerWyz for All Wreath Of Flowers including Wreaths For Funerals Designs as well as Flower Wreaths For Doors. Call us Today!';
        $meta_keywords = 'Flower Wreath,Funeral Wreaths,Flower Wreaths,Funeral Wreath,Wreath Of Flowers,Funeral Wreath Flowers,Wreath For Funeral,Wreaths For Funerals,Wreaths For Funeral,Wreath Funeral,Flower Wreaths For Doors,Wreath Flowers,Wreaths For Funerals Designs,Wreaths For A Funeral,Funeral Flower Wreath,Flower Wreaths For Funerals,Fresh Flower Wreath,Funeral Flower Wreaths';
    } elseif ($header_page_id == '57') { //FUNERAL SPRAYS
        $page_content = 'sprays_content.php';
        $canonical = 'funeral-flowers/cheap-funeral-sprays-flower-sprays-funeral-standing-sprays.htm';
        $head_prm1 = 'Cheap Funeral Flower Sprays | Spray Of Flowers | Funeral Standing Sprays';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FUNERAL SPRAYS';
        $footer_content = 'FlowerWyz | Cheap Funeral Flower Sprays | Spray Of Flowers | Funeral Standing Sprays.';
        $page_title = 'FlowerWyz Cheap Funeral Flower Sprays | Spray Of Flowers | Funeral Standing Sprays';
        $meta_description = 'Looking for The Best Cheap Funeral Flower Sprays? Check out FlowerWyz for All Funeral Sprays - Spray Of Flowers including a Variety of Funeral Standing Sprays. Call us Today!';
        $meta_keywords = 'Flower Spray,Spray Of Flowers,Spray Flowers,Funeral Flower Sprays,Funeral Sprays,Funeral Spray,Funeral Standing Spray,Funeral Standing Sprays,Funeral Sprays For Caskets,Standing Sprays For Funeral,Standing Funeral Sprays,Standing Spray For Funeral,Cheap Funeral Sprays,Funeral Sprays Cheap,Spray For Funeral,Sprays For Funerals';
    } elseif ($header_page_id == '58') { //FUNERAL BASKETS
        $page_content = 'basket_content.php';
        $canonical = 'funeral-flowers/funeral-baskets-funeral-gift-baskets-bereavement-gift-baskets.htm';
        $head_prm1 = 'Cheap Funeral Baskets | Bereavement Gift Baskets | Funeral Gift Baskets';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'FUNERAL BASKETS';
        $footer_content = 'FlowerWyz | Cheap Funeral Baskets | Bereavement Gift Baskets | Funeral Gift Baskets | Funeral Gifts.';
        $page_title = 'FlowerWyz Cheap Funeral Baskets | Bereavement Gift Baskets | Funeral Gift Baskets | Funeral Gifts';
        $meta_description = 'Looking for The Best Cheap Funeral Baskets and Bereavement Gift Baskets? Check out FlowerWyz for All Funeral Gift Baskets, Funeral Gifts and Bereavement Gift Ideas. Call us Today!';
        $meta_keywords = 'Funeral Baskets,Funeral Baske,Bereavement Gift Baskets,Bereavement Gifts,Funeral Gift Baskets,Funeral Gifts,Funeral Gift Ideas,Funeral Home Gifts,Gifts For Funeral,Funeral Gift,Funeral Basket Arrangements,Funeral Flower Baskets,Funeral Basket Flower Arrangements,Bereavement Gift Ideas,Bereavement Gift,Basket for Funeral';
    } elseif ($header_page_id == '59') { //THANK YOU
        $page_content = 'thank_content.php';
        $canonical = 'thank-you-flowers-delivery-thank-you-flower-arrangements.htm';
        $head_prm1 = 'Thank You Flowers | Thank You Flowers Delivery | Thank You Flower Arrangements';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'THANK YOU FLOWERS';
        $footer_content = 'FlowerWyz | Thank You Flowers | Thank You Flowers Delivery | Thank You Flower Arrangements.';
        $page_title = 'FlowerWyz Cheap Thank You Flowers | Thank You Flowers Delivery | Thank You Flower Arrangements';
        $meta_description = 'Looking for The Best Cheap Thank You Flowers? Check out FlowerWyz for the Best Thank You Flowers Delivery for all Kinds of Thank You Flower Arrangements. Call us Today!';
        $meta_keywords = 'Thank You Flowers,Thank You For The Flowers,Thank You For Flowers,Thank You With Flowers,Flowers Thank You,Thank You Flowers delivery,Thank You Images With Flowers,Thank You Flower Arrangements,How To Say Thank You For Flowers,Flowers To Say Thank You,Flowers That Say Thank You,Flower Thank You,Flowers For Thank You,Flower Thank You Cards,Send Thank You Flowers,Thank You Flowers Color';
    } elseif ($header_page_id == '60') {  // ROMANCE
        $page_content = 'romance_content.php';
        $canonical = 'flower-of-love-flowers-romantic-flowers-for-you.htm';
        $head_prm1 = 'Love Flowers | Romantic Flowers | Best Flowers For You Flowers of Love & Romance';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'ROMANTIC FLOWERS';
        $footer_content = 'FlowerWyz | Love Flowers | Romantic Flowers | Best Flowers For You Flowers of Love | Romantic Flower Arrangements.';
        $page_title = 'FlowerWyz Love Flowers | Romantic Flowers | Best Flowers For You Flowers of Love | Romantic Flower Arrangements';
        $meta_description = 'Looking for The Best Love Flowers or Romantic Flowers? Check out FlowerWyz for the Best Flowers For You Flowers of Love and Romantic Flower Arrangements. Call us Today!';
        $meta_keywords = 'Flowers For You,Love Flowers,For You Flowers,Romantic Flowers,You Flowers,Flowers From You,Flower Of Love,I Love You Flowers,Flowers Of Love,Thinking Of You Flowers,Flower Love,Flowers Love,I Love Flowers,Flowers For Love,Flowers To You,Romantic Flower Arrangements';
    } elseif ($header_page_id == '61') { //CHRISTMAS
        $page_content = 'christmas_content.php';
        $canonical = 'christmas-centerpieces-christmas-plants-christmas-flower-arrangements.htm';
        $head_prm1 = 'Christmas Centerpieces | Christmas Plants | Christmas Flower Arrangements';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'CHRISTMAS FLOWERS';
        $footer_content = 'FlowerWyz | Simple & Cheap Flower Delivery Service.';
        $page_title = 'FlowerWyz | Christmas Centerpieces | Christmas Plants | Christmas Flower Arrangements.';
        $meta_description = 'Looking for The Best Christmas Centerpieces and Christmas Floral Arrangements? Check out FlowerWyz for the Best  Christmas Plants and Christmas Flower Arrangements. Call us Today!';
        $meta_keywords = 'Christmas Centerpieces,Christmas Plants,Christmas Floral Arrangements,Christmas Table Centerpieces,Christmas Plant,Christmas Flower Arrangements,Christmas Arrangements,Red Christmas Flower,Christmas Floral Centerpieces,Centerpieces For Christmas,Red Christmas Flowers,Christmas Flower Arrangement,Christmas Flower Centerpieces,Christmas Flower Delivery,Christmas Table Arrangements,Table Centerpieces For Christmas';
    } elseif ($header_page_id == '62') { //NEW BABY
        $page_content = 'newbaby_content.php';
        $canonical = 'new-baby-flowers-new-baby-gifts-ideas.htm';
        $head_prm1 = 'New Baby Gift Ideas | New Baby Flowers | Baby Shower Flower Arrangements';
        $head_prm2 = 'SEND';
        $head_prm3 = 'SAME DAY ** ';
        $head_prm4 = 'NEW BABY FLOWERS';
        $footer_content = 'FlowerWyz | New Baby Gift Ideas | New Baby Flowers | Baby Shower Flower Arrangements.';
        $page_title = 'FlowerWyz New Baby Gift Ideas | New Baby Flowers | Baby Shower Flower Arrangements';
        $meta_description = 'Looking for The Best New Baby Gift Ideas? Check out FlowerWyz for the Best New Baby Gifts, New Baby Flowers and also Baby Shower Flower Arrangements. Call us Today!';
        $meta_keywords = 'New Baby Gifts,New Baby Gift,New Baby Gift Ideas,New Baby Flowers,Baby Shower Flower Arrangements,Flowers For New Baby,Gifts For New Baby,New Baby Boy Gifts,New Baby Girl Gifts,Flower Arrangements For Baby Shower,Baby Shower Arrangements,Gift For New Baby,Baby Boy Flower Arrangements,New Baby Gifts Delivered,Gifts For New Baby Girl,Gifts For New Baby Boy';
    }
} else {
    $page_content = 'home_content.php';
    $head_prm1 = 'Online Flowers Delivery | Send Flowers Online | Cheap Flower Delivery';
    $head_prm2 = 'SEND';
    $head_prm3 = 'SAME DAY **';
    $head_prm4 = 'FLOWER DELIVERY';
    $page_title = 'FlowerWyz Online Flowers Delivery | Send Flowers Online | Cheap Flower Delivery';
    $meta_description = 'Looking for The Best Cheap Flower Delivery Service? Send Flowers Online With FlowerWyz Online Flowers Delivery Service. Accredited Same or Next Day Delivery Service. call us Today!';
    $meta_keywords = 'flower delivery, send flowers, flowers online, flowers delivery, online flowers, online flower delivery, cheap flower delivery, send flowers online, cheap flowers, sending flowers,best flower delivery,flowers delivered,flowers for delivery,send flowers cheap,flowers for delivery,deliver flowers';
    $footer_content = 'FlowerWyz | Online Flowers Delivery | Send Flowers Online | Cheap Flower Delivery.';
}

/*
$cur_page = end(explode('/', $_SERVER[REQUEST_URI]));
$page1 = explode('/', $_SERVER[REQUEST_URI]);
$page3 = explode("?", $cur_page);
if ($cur_page == 'categories.php' || $cur_page == 'index.php' || $cur_page == 'index.htm' || $page3[0] == 'categories.php' || $page3[0] == 'index.php') {
    $page = explode("?", $cur_page);
    $page = $vpath . '';
} elseif ($cur_page <> '') {
    $page = explode("?", $cur_page);
    if ($page1[1] <> '')
        $page2 .= $page1[1];
    if ($page1[2] <> '')
        $page2 .= '/' . $page1[2];
    $page = $vpath . $page2;
}
else
    $page = $vpath . '';
	*/

/*
if($canonical == ''){
	$cur_page =  $_SERVER['REQUEST_URI'];
    if ($cur_page <> '') {
        $page = explode("?", $cur_page);
        if($page[0] == '/index.php' || $page[0] == '/')
            $page = $vpath;
        else
            $page = 'https://www.flowerwyz.com'.$page[0];
    }
}
else
    $page = $vpath.$canonical;
 *
 */
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--<html lang="en">-->
    <head>

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
       
        <title><?php echo $page_title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="keywords" content="<?php echo $meta_keywords ?>" />
        <meta name="description" content="<?php echo $meta_description ?>" />

        <link rel="canonical" href="<?php echo $vpath.$canonical; ?>" />
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
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/jquery.slicknav.min.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/jquery.js"></script>
        <script  type="text/javascript" src="<?= $vpath ?>js/menudrop.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/iselector.js"></script>
        <script type="text/javascript" src="<?= $vpath ?>js/general.js"></script>



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
        if($header_page_id == '8'){    
            if($url <> '')
                echo '<meta http-equiv=Refresh content="0;url='.$url.'">';
        }
            ?>
    </head>
    <body>

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
                        <form action="<?php echo $vpath; ?>index.php" method="get">
                            <div class="h_contacts">

                                <div class="h_sociallinks">
                                    <img src="<?php echo $vpath; ?>images/find-cheap-flowers.jpg" alt="Cheap Flowers"/>

                                        
                                    <div class="cboth"></div>

                                </div>

                                <div class="header-serch-container">
                                    <div class="header-search">
                                        <div class="select-search"  style="margin-bottom: 5px;" >

                                            <select name="category" class="select">
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
                                        <input type="text" name="code" value="<?php if (isset($_GET['code'])) echo $_GET['code']; ?>"  class="florist_log" />

                                        <div class="search_sec">
                                            <button type="submit" class="spl_btn">Search <img src="<?php echo $vpath; ?>images/header_search.png" alt=""></button>
                                        </div>
                                    </div>

                                    <div class="cboth"></div>

                                </div>

                            </div>
                        </form>
                        <div class="cboth"></div>
                         <?php 
                         if($city_name1) $city_name1=' , '. $city_name1;
                         if($city_name2) $city_name2 = ' , '.$city_name2;
                         if($city_name3) $city_name3= ' , '.$city_name3;
                         if($city_name4) $city_name4 = ' , '.$city_name4;
                         if($city_name5) $city_name5 = ' , '.$city_name5;
                         echo $city_name.$city_name1.$city_name2.$city_name3.$city_name4.$city_name5;
                                         
                                   ?>
                    </div>
                </div>
            </div>

            <div id="navigation">

                <div class="innerWrap">

                    <div class="row-fluid mainNavBg">

                        <div id="Menu"><ul><li class="First ActivePage"><a href="<?= $vpath ?>"><span>Home</span></a></li>

                                <li class="HasSubMenu ">

                                    <a href="<?= $vpath ?>floral-arrangements-floral-delivery-from-local-florists-and-online-florists.htm"><span>Floral Delivery</span></a>

                                    <!--<ul>

                             <li><a href="<?= $vpath ?>index.htm">Same Day Flowers</a></li>

                     </ul>-->

                                </li>   <li class=" ">

                                    <a href="<?= $vpath ?>send-plants-send-a-plant-delivery-orchid-delivery.htm"><span>plant delivery</span></a>



                                </li>   <li class=" ">

                                    <a href="<?= $vpath ?>bouquet-of-flowers-flower-bouquets-balloon-bouquets-bouquet-of-roses.htm"><span>Flower Bouquets</span></a>



                                </li>   <li class=" ">

                                    <a href="<?= $vpath ?>discount-flowers-flower-deals-flower-coupons-cheap-flowers-free-delivery.htm"><span>Discount Flowers</span></a>



                                </li>   <li class=" ">

                                    <a href="<?= $vpath ?>wholesale-flowers-wholesale-roses-bulk-flowers-online.htm"><span>Wholesale Flowers</span></a>



                                </li>   <li class=" ">

                                    <a href="<?= $vpath ?>exotic-flowers-and-exotic-plants-for-sale.htm"><span>Exotic Flowers</span></a>



                                </li>   <li class=" ">
                                    <a href="<?= $vpath ?>flower-shops-online-flower-stores.htm"><span>Flower Shops</span></a>
                                </li>
                                <li class=" ">

                                    <a href="<?= $vpath ?>order-flowers-online-for-delivery-where-to-buy-flowers-online.htm"><span>Order Flowers</span></a>
                                </li>

                            </ul>
                        </div>

                    </div>

                </div>
            </div>
            <div id="Wrapper">
<?php
include("include/header.php");
include("getProducts.php");


$intStart = '1';
$num_records_per_page = 20;

$offset = 0;
$parama = "";
$order_by = 'A.name asc';
//echo $_SERVER['REQUEST_URI'];
$a = explode('?', $_SERVER['REQUEST_URI']);
$b = explode('&', $a[1]);
$b = array_filter($b);
if (!empty($b)) {
    $c = explode('=', $b[0]);
    $intStart = $c[1] * $num_records_per_page - ($num_records_per_page) + 1;
    $offset = ($c[1] - 1) * $num_records_per_page;
}

if ($_GET['category'] && $_GET['category'] != '' && $_GET['pg_id'] != '') {
    $strCategory = $_GET['category'];
    $page_id = $_GET['pg_id'];
    if ($strCategory == 'ao') // Everyday
        $field_name = 'everyday';
    elseif ($strCategory == 'bd' && $page_id == '2') //Birthday
        $field_name = 'birthday';
    elseif ($strCategory == 'an' && $page_id == '1') //Anniversary
        $field_name = 'anniversary';
    elseif ($strCategory == 'lr' && $page_id == '60') //Love & Romance
        $field_name = 'romance';
    elseif ($strCategory == 'gw' && $page_id == '13') //Get Well
        $field_name = 'get_well';
    elseif ($strCategory == 'nb' && $page_id == '62') //New Baby
        $field_name = 'new_baby';
    elseif ($strCategory == 'ty' && $page_id == '59') //Thank You
        $field_name = 'thank_you';
    elseif ($strCategory == 'sy' && $page_id == '11') //Sympathy
        $field_name = 'sympathy';
    elseif ($strCategory == 'c' && $page_id == '53') //Centerpieces
        $field_name = 'centerprices';
    elseif ($strCategory == 'o'  && $page_id == '40') //One Sided Arrangements
        $field_name = 'one_sided_arrangements';
    elseif ($strCategory == 'n') //Novelty Arrangements
        $field_name = 'novelty_arrangements';
    elseif ($strCategory == 'v') //Vased Arrangements
        $field_name = 'vased_arrangement';
    elseif ($strCategory == 'r' && $page_id == '17') //Roses
        $field_name = 'roses';
    elseif ($strCategory == 'x') //Fruit Baskets
        $field_name = 'fruit_baskets';
    elseif ($strCategory == 'p' && $page_id == '41') //Plants
        $field_name = 'plants';
    elseif ($strCategory == 'b') //Balloons
        $field_name = 'balloons';
    elseif ($strCategory == 'fa') //Funeral Table Arrangements
        $field_name = 'arrangements';
    elseif ($strCategory == 'fb' && $page_id == '58') //Funeral Baskets
        $field_name = 'funeral_baskets';
    elseif ($strCategory == 'fs' && $page_id == '57') //Funeral Sprays
        $field_name = 'funeral_sprays';
    elseif ($strCategory == 'fp' && $page_id == '55') //Floor Plants
        $field_name = 'funeral_plants';
    elseif ($strCategory == 'fl') //Funeral Inside Casket Flowers
        $field_name = 'inside_casket';
    elseif ($strCategory == 'fw' && $page_id == '56') //Funeral Wreaths
        $field_name = 'funeral_wreaths';
    elseif ($strCategory == 'fh') //Hearts
        $field_name = 'hearts';
    elseif ($strCategory == 'fx') //Funeral Crosses
        $field_name = 'crosses';
    elseif ($strCategory == 'fc' && $page_id == '54') //Funeral Casket Sprays
        $field_name = 'funeral_casket_sprays';
    elseif ($strCategory == 'cm' && $page_id == '61') //Christmas
        $field_name = 'christmas';
    elseif ($strCategory == 'ea' && $page_id == '3') //Easter
        $field_name = 'easter';
    elseif ($strCategory == 'vd' && $page_id == '12') //Valentines Day
        $field_name = 'valentines_day';
    elseif ($strCategory == 'md' && $page_id == '10') //Mothers Day
        $field_name = 'mothers_day';
    elseif ($strCategory == 'apop' && $page_id == '45') //Wedding
        $field_name = 'wedding';
    elseif ($strCategory == 'apop' && $page_id == '18') //Mothers Day
        $field_name = 'wedding';
    elseif ($strCategory == 'apop' && $page_id == '42') //Bouquets
        $field_name = 'bouquets';
   elseif ($strCategory == 'apop' && $page_id == '43') //Exotic
        $field_name = 'exotic';
   elseif ($strCategory == 'apop' && $page_id == '8') //Shop
        $field_name = 'shop';
   elseif ($strCategory == 'apop' && $page_id == '9') //Flower_order
        $field_name = 'flower_order';
   elseif ($strCategory == 'fp' && $page_id == '44') //Funerals
        $field_name = 'funerals';
    else
    $field_name = 'common';
    
    $keywords = array();

    $where_clause .= " AND B." . $field_name . "!=0";
    $order_by = "B." . $field_name;
    $parama = "&amp;category=" . $_GET['category'] . "&amp;pg_id=" . $_GET['pg_id'];
}

if ($_GET['pg_id'] && $_GET['pg_id'] != '') {
    $page_id = $_GET['pg_id'];
    if ($page_id == '1') {
        $keywords = array('WSedding Anniversary Gifts', 'Anniversary Gift Ideas', 'Anniversary Flowers', 'Flowers For Anniversary', 'Wedding Anniversary Flowers',
            'Anniversary Gift Baskets', 'Anniversary Gift Basket', 'Anniversary Flowers', 'Anniversary Flower', 'Anniversary Flower Delivery', 'Anniversary Flower Delivery',
            'Anniversary Flower Online', 'Anniversary Flowers Online', '1st Anniversary Flowers', '2nd Anniversary Flowers', '3rd Anniversary Flowers',
            '5th Anniversary Flowers', '10th Anniversary Flowers', '25th Anniversary Flowers', '30th Anniversary Flowers');
    } elseif ($page_id == '2') {
        $keywords = array('Best Birthday Flowers', 'Birthday Gifts Delivery', 'Birthday Gifts For Mom', 'Cheapest Birthday Gift', 'Birthday Delivery Flower',
            'Birthday Gift Baskets', 'Birthday Delivery Ideas', 'Sending Birthday Flowers', 'Birthday Baskets Online', 'Flowers For Birthday', 'Birthday Flower Online',
            'Birthday Gift Delivery', 'Online Birthday Deliveries', 'Birthday Flowers Delivery', 'Birthday Flower Delivery', 'Birthday Delivery Gifts',
            'Birthday Gift Basket', 'Send Birthday Flowers', 'Birthday Gifts Delivered', 'Online Birthday Gifts');
    } elseif ($page_id == '3') {
        $keywords = array('Easter Flowers', 'Lovely Easter Wishes', 'Easter Flower', 'Easy Easter Arrangements', 'Easter Flower Arrangements',
            'Love Of The Spring', 'Easter Flowers Arrangements', 'Easter Arrangements', 'For This Special Easter', 'Flowers For Easter',
            'Easter Flower Delivery', 'Fresh From The Garden', 'Easter Flowers Delivery', 'Easter Flower Online', 'Wild Scent For Easter',
            'Easter Floral Arrangements', 'Easter Flowers Online', 'For The Best Easter Ever', 'Fun, Family And Easter', 'Flower Delivery Easter');
    } elseif ($page_id == '4') {
        $keywords = array('Same Day Flower Delivery', 'Flowers Delivered Today', 'Flower Delivery Today', 'Same Day Delivery Flowers', 'Same Day Flowers',
            'Flowers Same Day Delivery', 'Send Flowers Today', 'Deliver Flowers Today', 'Flower Delivery Same Day', 'Flowers Today', 'Cheap Same Day Flower',
            'Flowers For Delivery Today', 'Same Day Flowers Delivery', 'Send Flowers Same Day', 'Flowers Delivery Same Day', 'Cheap Flowers Delivered Today',
            'Flowers Same Day', 'Flower Same Day Delivery', 'Flowers Delivered Same Day', 'Flowers Delivery Today');
    } elseif ($page_id == '5') {
        $keywords = array('Next Day Flower Delivery', 'Flowers Delivered Tomorrow', 'Next Day Flowers', 'Deliver Flowers Tomorrow', 'Next Day Delivery Flowers',
            'Send Flowers Tomorrow', 'Flower Delivery Next Day', 'Sweet Flowers Tomorrow', 'Flower Delivery Tomorrow', 'Next Day Flowers Delivery', 'Send Flowers Next Day',
            'Flowers Next Day Delivery', 'Cheap Flowers Tomorrow', 'Flowers Next Day', 'Flower Next Day Delivery', 'Flowers Delivered Next Day', 'Flowers Delivery Tomorrow',
            'Flowers For Next Day', 'Cheap Next Day Flower', 'Flowers For Tomorrow');
    } elseif ($page_id == '6') {
        $keywords = array('Cool Discount Flowers', 'Easy Flower Coupons', 'Flowers Free Delivery', 'Best Flower Deals', 'Truly Inexpensive Flowers',
            'Flower Delivery Coupons', 'Affordable Flowers', 'Discount Flower Delivery', 'Free Flower Delivery', 'Inexpensive Flower Delivery', 'Affordable Flower Delivery',
            'Free Delivery Flowers', 'Cheap Flower Deals', 'Flowers Discount', 'Flower Delivery Coupon', 'Discount Flowers Delivered', 'Flowers Free Shipping',
            'Flower Free Delivery', 'Inexpensive Flowers Delivery', 'Free Shipping Flowers');
    } elseif ($page_id == '7') {
        $keywords = array('Wholesale Flowers', 'Bulk Flowers', 'Wholesale Roses', 'Flowers Wholesale', 'Bulk Flowers Online',
            'Flower Wholesale', 'Flowers In Bulk', 'Wholesale Flowers Online', 'Wholesale Florist', 'Buy Flowers In Bulk', 'Cut Flower Wholesale',
            'Wholesale Cut Flowers', 'Cut Flowers Wholesale', 'Cheap Bulk Flowers', 'Buy Flowers In Bulk', 'Wholesale Flower', 'Buy Wholesale Flowers', 'Buy Bulk Flowers',
            'Bulk Flower Delivery', 'Cut Flowers In Bulk');
    } elseif ($page_id == '8') {
        $keywords = array(‘FlowerWyz Flower Shop’, ‘Local Flower Shops’, ‘National Flower Stores’, ‘Flowes Attico’, ‘Best Online Florists’, ‘Floral Shop Anywhere’, ‘Flowers Shop Online’, ‘Fresh Flower Stores’, ‘The Flower Shop Special’, ‘FlowerWyz Flowershop’, ‘Online Florist Delivery’, ‘City Florist Shops’, ‘Flowers Shops Locally’, ‘Online Florists & Designers’, ‘Best Florist Online’, ‘Best Online Florist’, ‘Florist Shops in Your City’, ‘Find A Florist Online’, ‘Florists Online Available’, ‘Flower Shops that Deliver’);
    } elseif ($page_id == '9') {
        $keywords = array('Order Flowers Flowerwyz', 'Order Flowers Online', 'Buy Flowers Online', 'Buy Flowers Cheap', 'Ordering Flowers',
            'Where To Buy Flowers', 'Order Flowers Delivery', 'Order Flowers Online Cheap', 'Ordering Flowers Online', 'Easy Flowers Order', 'Flowers To Order',
            'Flower Order Cheap', 'Order Flowers Cheap', 'Order Flowers For Delivery', 'Online Flower Order', 'Buying Flowers Online', 'Buying Flowers Cheap', 'Order Flower & Send',
            'Order Flower Delivery', 'Ordering Flower online');
    } elseif ($page_id == '10') {
        $keywords = array('Mothers Day Gifts', 'Mothers Day Flowers', 'Flowers For Mothers Day', 'Flowers Mothers Day', 'Mother Day Flowers',
            'Mothers Day Gift Baskets', 'Cheap Mothers Day Flowers', 'Mothers Day Flower Delivery', 'Best Flowers For Mother', 'Mothers Day Gift Delivery', 'Mothers Day Flowers Delivery',
            'Mothersday Flowers', 'Send Mothers Day Flowers', 'Flower Delivery Mothers Day', 'Send Flowers For Mothers Day', 'Send Flowers Mothers Day', 'Mothers Day Flowers Online', 'Gift For Mothers Day',
            'Flowers Delivery Mothers Day', 'Flowers For My Mother');
    } elseif ($page_id == '11') {
        $keywords = array('Sympathy Flowers', 'Flowers To Care', 'Sympathy Gift Baskets', 'Sympathy Flowers Online', 'We Are With You',
            'Sympathy Gift Basket', 'Sympathy Flowers Delivery', 'Flowers For Sympathy', 'Most Heart Felt Feelings', 'Sympathy Flower', 'Sympathy Flowers Online',
            'Nothing Ever Ends', 'Sympathy Flowers Delivery', 'Time Heals Always', 'Sympathy Flowers Delivery', 'Sympathy Flower Online', 'Saying I Care', 'Silent Flower That Touches',
            'Eternity Is Awake', 'My Heartfelt Sympathies');
    } elseif ($page_id == '12') {
        $keywords = array('Valentines Day Flowers', 'Valentines Flowers', 'Cool Valentine Gift', 'Valentine Flowers',
            'Valentine Gift Baskets', 'Flowers For Valentine', 'Valentines Flowers Delivery', 'Cheap Valentines Day Flowers', 'Valentines Day Flower Delivery',
            'Valentine Flower', 'Valentine Delivery Gifts', 'Valentine Flower Delivery', 'Valentines Flower Delivery', 'Best Valentine Gifts',
            'Cheap Valentines Flowers', 'Valentine Day Flowers Delivery', 'Valentine Gift Basket', 'Flower For Valentine', 'Valentines Day Giftpack', 'Best Valentine Ever');
    } elseif ($page_id == '13') {
        $keywords = array('Get Well Gift Baskets', 'Get Well Flowers', 'Get Well Balloon', 'Get Well Soon Flowers', 'Flowers And Balloons',
            'Get Well Gift Basket', 'Get Well Flower', 'Saying I Care', 'Getting Well Gifts', 'Get Well Flower Delivery',
            'Get Well Flower Online', 'Take Best Care', 'Get Well Gift Packs', 'Get Well Flowers Online', 'Getting Well Soon',
            'Get Well Balloons', 'Get Well Flowers Delivery', 'Gifts For Getting Well', 'Flowers & Chocolates', 'For The Quickest Recovery');
    } elseif ($page_id == '14') {
        $keywords = array('Fresh Flower Delivery', 'Send Flowers Freshly', 'Fresh Flowers', 'Sending Flowers Fresh', 'Flowers Fresh',
            'Best Fresh Florists', 'Fresh Flower Designs', 'Flowers Fresh Delivery', 'Flower Delivery Fresh', 'Long Distance Flower Delivery',
            'Fresh Flower', 'Flower Fresh', 'Fresh Florists', 'Fresh Flowers Online', 'Fresh Flower Online',
            'Flowers Fresh Cut', 'Flower Styles Fresh', 'Floral Fresh', 'Fresh Delivery Flower', 'Sending Flowers Freshly');
    } elseif ($page_id == '15') {
        $keywords = array('Local Flower Delivery', 'Send Flowers Locally', 'Local Flowers', 'Sending Flowers Foreign', 'Sending Flowers Locally',
            'Flowers Local', 'Best Local Florists', 'Local Flower Designs', 'Flowers Local Delivery', 'Flower Delivery Local',
            'Long Distance Flower Delivery', 'Local Flower', 'Flower Local', 'Local Florists', 'Local Flowers Online',
            'Local Flower Online', 'Flowers To Foreign', 'Flower Styles Local', 'Floral Local', 'Local Delivery Flower');
    } elseif ($page_id == '16') {
        $keywords = array('International Flower Delivery', 'Send Flowers Internationally', 'International Flowers', 'Sending Flowers Foreign', 'Sending Flowers Internationally',
            'Flowers International', 'Best International Florists', 'International Flower Designs', 'Flowers International Delivery', 'Flower Delivery International',
            'Long Distance Flower Delivery', 'International Flower', 'Flower International', 'International Florists', 'International Flowers Online',
            'International Flower Online', 'Flowers To Foreign', 'Flower Styles International', 'Floral International', 'International Delivery Flower');
    } elseif ($page_id == '16') {
        $keywords = array('International Flower Delivery', 'Send Flowers Internationally', 'International Flowers', 'Sending Flowers Foreign', 'Sending Flowers Internationally',
            'Flowers International', 'Best International Florists', 'International Flower Designs', 'Flowers International Delivery', 'Flower Delivery International',
            'Long Distance Flower Delivery', 'International Flower', 'Flower International', 'International Florists', 'International Flowers Online',
            'International Flower Online', 'Flowers To Foreign', 'Flower Styles International', 'Floral International', 'International Delivery Flower');
    } elseif ($page_id == '17') {
        $keywords = array('Smooth Dozen Roses', 'Roses For Sale', 'Rose Bushes For Sale', 'Roses Delivery', 'Cheap Roses',
            'Rose Delivery', 'Blue Roses For Sale', '2 Dozen Roses', 'Flowers Roses', 'Dozen Red Roses',
            'Buy Roses Online', '3 Dozen Roses', 'Send Roses', 'Dozen Roses Price', 'Where To Buy Roses',
            'A Dozen Roses', 'Fresh Roses Delivered', 'Single Rose Delivery', 'Send Roses Online', 'Roses Only For You');
    } elseif ($page_id == '18') {
        $keywords = array('Flower Delivery Atlanta', 'Best Florists Atlanta', 'Atlanta Flower Delivery', 'Atlanta Flowers', 'Atlanta Flower',
            'Cheap Atlanta Flowers', 'Online Florist Atlanta', 'Cheap Atlanta Flower', 'Atlanta Flowers Delivery', 'Atlanta Flower Online',
            'Flowers Delivery Atlanta', 'Best Atlanta Florists', 'Atlanta Flower Shop', 'Atlanta Flower Market', 'Flower Shops Atlanta',
            'Send Flower Atlanta', 'Atlanta Flowers Online', 'Online Atlanta Florist', 'Atlanta Flower Shops', 'Flower Delivery Atlanta');
    } elseif ($page_id == '19') {
        $keywords = array('Flower Delivery Baltimore', 'Best Florists Baltimore', 'Baltimore Flower Delivery', 'Baltimore Flowers', 'Baltimore Flower',
            'Cheap Baltimore Flowers', 'Online Florist Baltimore', 'Cheap Baltimore Flower', 'Baltimore Flowers Delivery', 'Baltimore Flower Online',
            'Flowers Delivery Baltimore', 'Best Baltimore Florists', 'Baltimore Flower Shop', 'Baltimore Flower Market', 'Flower Shops Baltimore',
            'Send Flower Baltimore', 'Baltimore Flowers Online', 'Online Baltimore Florist', 'Baltimore Flower Shops', 'Flower Delivery Baltimore');
    } elseif ($page_id == '20') {
        $keywords = array('Flower Delivery Boston', 'Best Florists Boston', 'Boston Flower Delivery', 'Boston Flowers', 'Boston Flower',
            'Cheap Boston Flowers', 'Online Florist Boston', 'Cheap Boston Flower', 'Boston Flowers Delivery', 'Boston Flower Online',
            'Flowers Delivery Boston', 'Best Boston Florists', 'Boston Flower Shop', 'Boston Flower Market', 'Flower Shops Boston',
            'Send Flower Boston', 'Boston Flowers Online', 'Online Boston Florist', 'Boston Flower Shops', 'Flower Delivery Boston');
    } elseif ($page_id == '21') {
        $keywords = array('Flower Delivery Chicago', 'Best Florists Chicago', 'Chicago Flower Delivery', 'Chicago Flowers', 'Chicago Flower',
            'Cheap Chicago Flowers', 'Cheap Chicago Flowers', 'Cheap Chicago Flower', 'Chicago Flowers Delivery', 'Chicago Flower Online',
            'Flowers Delivery Chicago', 'Best Chicago Florists', 'Chicago Flower Shop', 'Chicago Flower Market', 'Flower Shops Chicago',
            'Send Flower Chicago', 'Chicago Flowers Online', 'Online Chicago Florist', 'Chicago Flower Shops', 'Flower Delivery Chicago');
    } elseif ($page_id == '22') { //DALLAS
        $keywords = array('Flower Delivery Dallas', 'Best Florists Dallas', 'Dallas Flower Delivery', 'Dallas Flowers', 'Dallas Flower',
            'Cheap Dallas Flowers', 'Online Florist Dallas', 'Cheap Dallas Flower', 'Dallas Flowers Delivery', 'Dallas Flower Online',
            'Flowers Delivery Dallas', 'Best Dallas Florists', 'Dallas Flower Shop', 'Dallas Flower Market', 'Flower Shops Dallas',
            'Send Flower Dallas', 'Dallas Flowers Online', 'Online Dallas Florist', 'Dallas Flower Shops', 'Flower Delivery Dallas');
    } elseif ($page_id == '23') { //DENVER
        $keywords = array('Flower Delivery Denver', 'Best Florists Denver', 'Denver Flower Delivery', 'Denver Flowers', 'Denver Flower',
            'Cheap Denver Flowers', 'Online Florist Denver', 'Cheap Denver Flower', 'Denver Flowers Delivery', 'Denver Flower Online',
            'Flowers Delivery Denver', 'Best Denver Florists', 'Denver Flower Shop', 'Denver Flower Market', 'Flower Shops Denver',
            'Send Flower Denver', 'Denver Flowers Online', 'Online Denver Florist', 'Denver Flower Shops', 'Flower Delivery Denver');
    } elseif ($page_id == '24') { //HOUSTON
        $keywords = array('Flower Delivery Houston', 'Best Florists Houston', 'Houston Flower Delivery', 'Houston Flowers', 'Houston Flower',
            'Cheap Houston Flowers', 'Online Florist Houston', 'Cheap Houston Flower', 'Houston Flowers Delivery', 'Houston Flower Online',
            'Flowers Delivery Houston', 'Best Houston Florists', 'Houston Flower Shop', 'Houston Flower Market', 'Flower Shops Houston',
            'Send Flower Houston', 'Houston Flowers Online', 'Online Houston Florist', 'Houston Flower Shops', 'Flower Delivery Houston');
    } elseif ($page_id == '38') { //LOS ANGELES
        $keywords = array('Flower Delivery LA', 'LA Flower Delivery', 'LA Flowers', 'LA Flower', 'Flower Delivery Los Angeles',
            'Los Angeles Flower Delivery', 'Los Angeles Flowers', 'Los Angeles Flower', 'Cheap LA Flowers', 'Cheap LA Flower',
            'LA Flowers Delivery', 'Flowers Delivery LA', 'LA Florists', 'LA Florist', 'Florists LA',
            'Florist LA', 'LA Flower Shop', 'LA Flower Shops', 'Flower Shops LA', 'LA Flower Market');
    } elseif ($page_id == '25') { //MINNEAPOLIS
        $keywords = array('Flower Delivery Minneapolis', 'Best Florists Minneapolis', 'Minneapolis Flower Delivery', 'Minneapolis Flowers', 'Minneapolis Flower',
            'Cheap Minneapolis Flowers', 'Online Florist Minneapolis', 'Cheap Minneapolis Flower', 'Minneapolis Flowers Delivery', 'Minneapolis Flower Online',
            'Flowers Delivery Minneapolis', 'Best Minneapolis Florists', 'Minneapolis Flower Shop', 'Minneapolis Flower Market', 'Flower Shops Minneapolis',
            'Send Flower Minneapolis', 'Minneapolis Flowers Online', 'Online Minneapolis Florist', 'Minneapolis Flower Shops', 'Flower Delivery Minneapolis');
    } elseif ($page_id == '26') { //NEW YORK
        $keywords = array('Flower Delivery NYC', 'Flower District NYC', 'Florist NYC', 'Flowers NYC', 'NYC Flower Delivery',
            'New York Flower', 'Flower Delivery New York', 'NYC Florist', 'New York Flower Delivery', 'NYC Flower District',
            'Flower Market NYC', 'New York Florist', 'Florists NYC', 'New York Flowers', 'Flower Shops NYC',
            'Wholesale Flowers NYC', 'Flowers New York', 'Same Day Flower Delivery NYC', 'NYC Flowers', 'Send Flowers NYC');
    } elseif ($page_id == '27') { //PITTSBURGH
        $keywords = array('Flower Delivery Pittsburgh', 'Best Florists Pittsburgh', 'Pittsburgh Flower Delivery', 'Pittsburgh Flower', 'Pittsburgh Flower',
            'Cheap Pittsburgh Flowers', 'Online Florist Pittsburgh', 'Cheap Pittsburgh Flower', 'Pittsburgh Flowers Delivery', 'Pittsburgh Flower Online',
            'Flowers Delivery Pittsburgh', 'Best Pittsburgh Florists', 'Pittsburgh Flower Shop', 'Pittsburgh Flower Market', 'Flower Shops Pittsburgh',
            'Send Flower Pittsburgh', 'Pittsburgh Flowers Online', 'Online Pittsburgh Florist', 'Pittsburgh Flower Shops', 'Flower Delivery Pittsburgh');
    } elseif ($page_id == '39') { //SAN DIEGO
        $keywords = array('Flower Delivery San Diego', 'Best Florists San Diego', 'San Diego Flower Delivery', 'San Diego Flowers', 'San Diego Flower',
            'Cheap San Diego Flowers', 'Online Florist San Diego', 'Cheap San Diego Flower', 'San Diego Flowers Delivery', 'San Diego Flower Online',
            'Flowers Delivery San Diego', 'Best San Diego Florists', 'San Diego Flower Shop', 'San Diego Flower Market', 'Flower Shops San Diego',
            'Send Flower San Diego', 'San Diego Flowers Online', 'Online San Diego Florist', 'San Diego Flower Shops', 'Flower Delivery San Diego');
    } elseif ($page_id == '28') { //SAN FRANCISCO
        $keywords = array('Flower Delivery San Francisco', 'San Francisco Flower Mart', 'San Francisco Flower Market', 'San Francisco Flower Delivery', 'San Francisco Florist',
            'Flowers San Francisco', 'Florist San Francisco', 'San Francisco Florists', 'Flower Shop San Francisco', 'San Francisco Flower Show',
            'Florists San Francisco', 'San Francisco Flowers', 'SF Flower Delivery', 'Flower Mart San Francisco', 'Flower Market San Francisco',
            'Florists In San Francisco', 'Gifts From San Francisco', 'Flowers SF', 'Flower Shops In San Francisco', 'Florist In San Francisco');
    } elseif ($page_id == '29') { //SEATTLE
        $keywords = array('Flower Delivery Seattle', 'Best Florists Seattle', 'Seattle Flower Delivery', 'Seattle Flowers', 'Seattle Flower',
            'Cheap Seattle Flowers', 'Online Florist Seattle', 'Cheap Seattle Flower', 'Seattle Flowers Delivery', 'Seattle Flower Online',
            'Flowers Delivery Seattle', 'Best Seattle Florists', 'Seattle Flower Shop', 'Seattle Flower Market', 'Flower Shops Seattle',
            'Send Flower Seattle', 'Seattle Flowers Online', 'Online Seattle Florist', 'Seattle Flower Shops', 'Flower Delivery Seattle');
    } elseif ($page_id == '30') { //ST LOUIS
        $keywords = array('Flower Delivery St Louis', 'Best Florists St Louis', 'St Louis Flowers', 'Seattle Flowers', 'St Louis Flower',
            'Cheap St Louis Flowers', 'Online Florist St Louis', 'Cheap St Louis Flower', 'St Louis Flowers Delivery', 'St Louis Flower Online',
            'Flowers Delivery St Louis', 'Best St Louis Florists', 'St Louis Flower Shop', 'St Louis Flower Market', 'Flower Shops St Louis',
            'Send Flower St Louis', 'St Louis Flowers Online', 'Online St Louis Florist', 'St Louis Flower Shops', 'Flower Delivery St Louis');
    } elseif ($page_id == '31') { //TULSA
        $keywords = array('Flower Delivery Tulsa', 'Best Florists Tulsa', 'Tulsa Flower Delivery', 'Tulsa Flowers', 'Tulsa Flower',
            'Cheap Tulsa Flowers', 'Online Florist Tulsa', 'Cheap Tulsa Flower', 'Tulsa Flowers Delivery', 'Tulsa Flower Online',
            'Flowers Delivery Tulsa', 'Best Tulsa Florists', 'Tulsa Flower Shop', 'Tulsa Flower Market', 'Flower Shops Tulsa',
            'Send Flower Tulsa', 'Tulsa Flowers Online', 'Online Tulsa Florist', 'Tulsa Flower Shops', 'Flower Delivery Tulsa');
    } elseif ($page_id == '32') { //TO CANADA
        $keywords = array('Send Flowers To Canada', 'Flowers To Canada', 'Flower To Canada', 'Canada Flowers Online', 'Sending Flowers To Canada',
            'Buy Flowers For Canada', 'Send Flowers Canada', 'Send Flower To Canada', 'Sending To Canada From USA', 'Fresh Flowers To Canada',
            'Send Canada Flowers', 'Send Flowers Canada', 'Canada Flowers How To', 'To Canada From USA', 'Online Flowers Canada',
            'Order Flowers For Canada', 'Sending Flower To Canada', 'Easy Flowers To Canada', 'Canada Online Flowers', 'Sending Flowers Canada');
    } elseif ($page_id == '33') { //TO GERMANY
        $keywords = array('Send Flowers To Germany', 'Flowers To Germany', 'Flower To Germany', 'Germany Flowers Online', 'Sending Flowers To Germany',
            'Buy Flowers For Germany', 'Send Flowers Germany', 'Send Flower To Germany', 'Sending To Germany From USA', 'Fresh Flowers To Germany',
            'Send Germany Flowers', 'Send Flowers Germany', 'Germany Flowers How To', 'To Germany From USA', 'Online Flowers Germany',
            'Order Flowers For Germany', 'Sending Flower To Germany', 'Easy Flowers To Germany', 'Germany Online Flowers', 'Sending Flowers Germany');
    } elseif ($page_id == '34') { //TO INDIA
        $keywords = array('Send Flowers To India', 'Flowers To India', 'Flower To India', 'India Flowers Online', 'Sending Flowers To India',
            'Buy Flowers For India', 'Send Flowers India', 'Send Flower To India', 'Sending To India From USA', 'Fresh Flowers To India',
            'Send India Flowers', 'Send Flowers India', 'India Flowers How To', 'To India From USA', 'Online Flowers India',
            'Order Flowers For India', 'Sending Flower To India', 'Easy Flowers To India', 'India Online Flowers', 'Sending Flowers India');
    } elseif ($page_id == '35') { //TO MEXICO
        $keywords = array('Send Flowers To Mexico', 'Flowers To Mexico', 'Flower To Mexico', 'Mexico Flowers Online', 'Sending Flowers To Mexico',
            'Buy Flowers For Mexico', 'Send Flowers Mexico', 'Send Flower To Mexico', 'Sending To Mexico From USA', 'Fresh Flowers To Mexico',
            'Send Mexico Flowers', 'Send Flowers Mexico', 'Mexico Flowers How To', 'To Mexico From USA', 'Online Flowers Mexico',
            'Order Flowers For Mexico', 'Sending Flower To Mexico', 'Easy Flowers To Mexico', 'Mexico Online Flowers', 'Sending Flowers Mexico');
    } elseif ($page_id == '36') { //TO RUSSIA
        $keywords = array('Send Flowers To Russia', 'Flowers To Russia', 'Flower To Russia', 'Russia Flowers Online', 'Sending Flowers To Russia',
            'Buy Flowers For Russia', 'Send Flowers Russia', 'Send Flower To Russia', 'Sending To Russia From USA', 'Fresh Flowers To Russia',
            'Send Russia Flowers', 'Send Flowers Russia', 'Russia Flowers How To', 'To Russia From USA', 'Online Flowers Russia',
            'Order Flowers For Russia', 'Sending Flower To Russia', 'Easy Flowers To Russia', 'Russia Online Flowers', 'Sending Flowers Russia');
    } elseif ($page_id == '40') { //ARRANGEMENTS
        $keywords = array(‘Best Flower Arrangements’, ‘Unique Floral Arrangements’, ‘Timely Floral Delivery’, ‘Flower Arrangement Specials’, ‘Lovely Flowers Arrangements’, ‘Flower Arrangements Ideas’, ‘Novelty Floral Arrangement’, ‘How To Make Floral Arrangements’, ‘Cheap Flower Arrangements’, ‘Spring Floral Arrangements’, ‘Cheap Floral Arrangements’, ‘Unique Floral Arrangements’, ‘Large Floral Arrangements’, ‘Dried Floral Arrangements’, ‘Tropical Floral Arrangements’, ‘White Floral Arrangements’, ‘Flower Arrangements Delivery’, ‘Cool Flower Arrangements’, ‘Modern Floral Arrangements’, ‘Floral Arrangement Ideas’);
    } elseif ($page_id == '41') { //PLANTS
        $keywords = array('Floor Plant Delivery', 'Send A Plant Today', 'Cool Orchid Delivery', 'Plants Delivered Cheap', 'Send Plants Anywhere',
            'Rare Plant Delivered', 'Send Plant Online', "Plant Delivery Online", 'Online Plant Delivery', 'Send Orchid Online',
            'Deliver Plants Cheap', 'Best Plant Delivery', 'Best Online Plants', 'Cheapest Plants Online', 'Cools Plants To Send',
            'Plants Online Delivery', 'Exotic Plants Available', 'Deliver Rare Plants', 'Order Orchid Delivery', 'Send Plants Online');
    } elseif ($page_id == '42') { //BOUQUETS
        $keywords = array('Fresh Garden Bouquet', 'Bouquet of Flowers', 'Flower Bouquets', 'Love Flower Bouquet', 'Bouquet of Roses',
            'Yellow Rose Bouquets', 'White Rose Bouquet', "Roses Bouquet", 'Balloon Bouquets', 'Balloon Flowers Bouquet',
            'Romantic Balloon Bouquet', 'Balloon Bouquet Delivery', 'Balloon Bouquets Delivered', 'Bouquet Delivery', 'Beautiful Flower Bouquets',
            'Cheap Bouquets', 'Flower Bouquet Delivery', 'Cheap Flower Bouquets', 'A Bouquet Of Roses', 'Flower Bouquets Delivered');
    } elseif ($page_id == '43') { //BOUQUETS
        $keywords = array('Exotic Flowers', 'Exotic Plants', 'Exotic Flower', 'Exotic House Plants', 'Online Exotic Flowers',
            'Exotic Flowers & Plants', 'Exotic Plants For Sale', "Exotic Indoor Plants", 'Exotic Flower Delivery', 'Exotic Flowers Delivery',
            'Exotic Flower Online', 'Buy Exotic Flowers', 'Exotic Flowers Online', 'Order Exotic Flower Online', 'Order Exotic Flowers Online',
            'House Plants Exotic', 'Exotic Plants & Flowers', 'Send Exotic Flowers', 'Online Exotic Flower', 'Buy Exotic Flower');
    } elseif ($page_id == '44') { //BOUQUETS
        $keywords = array('Funeral Flowers', 'Flowers For Funeral', 'Funeral Flower Arrangements', 'Eternal Sunshine Of Heaven', 'Flower Arrangements For Funerals',
            'Funeral Floral Arrangements', 'A Starlit Waterway', "Cheap Funeral Flowers", 'Funeral Flower', 'Flowers For Funerals',
            'For An Immortal  Journey', 'Floral Arrangements For Funerals', 'Funeral Flowers Online', 'We Will Miss You', 'Order Flowers For Funeral',
            'Funeral Flower Arrangement', 'Peace, Love And Light', 'Funeral Flower Delivery', 'You Will Be In My Heart', 'Funeral Flowers Online');
    } elseif ($page_id == '45') { //WEDDING
        $keywords = array('Wedding Flowers', 'Wedding Bouquets', 'Bridal Bouquets', 'Flowers For Weddings', 'Wedding Flowers Online',
            'Wedding Flower Arrangements', 'Silk Wedding Bouquets', "Bridesmaid Bouquets", 'Cheap Wedding Flowers', 'Bridal Flowers',
            'Wedding Florist', 'Wedding Floral Arrangements', 'Bridesmaids Bouquets', 'Flower Arrangements Weddings', 'Wholesale Wedding Flowers',
            'Cheap Wedding Bouquets', 'Silk Bridal Bouquets', 'Wedding Bouquets Online', 'Wedding Florists', 'Cheap Flowers For Weddings');
    } elseif ($page_id == '46') { //Montreal, Canada
        $keywords = array('Flower Delivery Montreal', 'Best Florists Montreal', 'Montreal Flower Delivery', 'Montreal Flowers', 'Montreal Flower',
            'Cheap Montreal Flowers', 'Online Florist Montreal', "Cheap Montreal Flower", 'Montreal Flowers Delivery', 'Montreal Flower Online',
            'Flowers Delivery Montreal', 'Best Montreal Florists', 'Montreal Flower Shop', 'Montreal Flower Market', 'Flower Shops Montreal Canada',
            'Send Flower Montreal Canada', 'Montreal Flowers Online', 'Online Montreal Florist', 'Montreal Flower Shops', 'Flower Delivery Montreal Canada');
    } elseif ($page_id == '47') { //Toronto, Canada
        $keywords = array('Flower Delivery Toronto', 'Best Florists Toronto', 'Toronto Flower Delivery', 'Toronto Flowers', 'Toronto Flower',
            'Cheap Toronto Flowers', 'Online Florist Toronto', "Cheap Toronto Flower", 'Toronto Flowers Delivery', 'Toronto Flower Online',
            'Flowers Delivery Toronto', 'Best Toronto Florists', 'Toronto Flower Shop', 'Toronto Flower Market', 'Flower Shops Toronto Canada',
            'Send Flower Toronto Canada', 'Toronto Flowers Online', 'Online Toronto Florist', 'Toronto Flower Shops', 'Flower Delivery Toronto Canada');
    } elseif ($page_id == '48') { //Quebec, Canada
        $keywords = array('Flower Delivery Quebec', 'Best Florists Quebec', 'Quebec Flower Delivery', 'Quebec Flowers', 'Quebec Flower',
            'Cheap Quebec Flowers', 'Online Florist Quebec', "Cheap Quebec Flower", 'Quebec Flowers Delivery', 'Quebec Flower Online',
            'Flowers Delivery Quebec', 'Best Quebec Florists', 'Quebec Flower Shop', 'Quebec Flower Market', 'Flower Shops Quebec Canada',
            'Send Flower Quebec Canada', 'Quebec Flowers Online', 'Online Quebec Florist', 'Quebec Flower Shops', 'Flower Delivery Quebec Canada');
    } elseif ($page_id == '49') { //Halifax, Canada
        $keywords = array('Flower Delivery Halifax', 'Best Florists Halifax', 'Halifax Flower Delivery', 'Halifax Flowers', 'Halifax Flower',
            'Cheap Halifax Flowers', 'Online Florist Halifax', "Cheap Halifax Flower", 'Halifax Flowers Delivery', 'Halifax Flower Online',
            'Flowers Delivery Halifax', 'Best Halifax Florists', 'Halifax Flower Shop', 'Halifax Flower Market', 'Flower Shops Halifax Canada',
            'Send Flower Halifax Canada', 'Halifax Flowers Online', 'Online Halifax Florist', 'Halifax Flower Shops', 'Flower Delivery Halifax Canada');
    } elseif ($page_id == '50') { //Hamilton, Canada
        $keywords = array('Flower Delivery Hamilton', 'Best Florists Hamilton', 'Hamilton Flower Delivery', 'Hamilton Flowers', 'Hamilton Flower',
            'Cheap Hamilton Flowers', 'Online Florist Hamilton', "Cheap Hamilton Flower", 'Hamilton Flowers Delivery', 'Hamilton Flower Online',
            'Flowers Delivery Hamilton', 'Best Hamilton Florists', 'Hamilton Flower Shop', 'Hamilton Flower Market', 'Flower Shops Hamilton Canada',
            'Send Flower Hamilton Canada', 'Hamilton Flowers Online', 'Online Hamilton Florist', 'Hamilton Flower Shops', 'Flower Delivery Hamilton Canada');
    } elseif ($page_id == '51') { //Ottawa, Canada
        $keywords = array('Flower Delivery Ottawa', 'Best Florists Ottawa', 'Ottawa Flower Delivery', 'Ottawa Flowers', 'Ottawa Flower',
            'Cheap Ottawa Flowers', 'Online Florist Ottawa', "Cheap Ottawa Flower", 'Ottawa Flowers Delivery', 'Ottawa Flower Online',
            'Flowers Delivery Ottawa', 'Best Ottawa Florists', 'Ottawa Flower Shop', 'Ottawa Flower Market', 'Flower Shops Ottawa Canada',
            'Send Flower Ottawa Canada', 'Ottawa Flowers Online', 'Online Ottawa Florist', 'Ottawa Flower Shops', 'Flower Delivery Ottawa Canada');
    } elseif ($page_id == '52') { //Portland, Canada
        $keywords = array('Flower Delivery Portland', 'Best Florists Portland', 'Portland Flower Delivery', 'Portland Flowers', 'Portland Flower',
            'Cheap Portland Flowers', 'Online Florist Portland', "Cheap Portland Flower", 'Portland Flowers Delivery', 'Portland Flower Online',
            'Flowers Delivery Portland', 'Best Portland Florists', 'Portland Flower Shop', 'Portland Flower Market', 'Flower Shops Portland Canada',
            'Send Flower Portland Canada', 'Portland Flowers Online', 'Online Portland Florist', 'Portland Flower Shops', 'Flower Delivery Portland Canada');
    } elseif ($page_id == '53') { //CENTERPIECES
        $keywords = array('Beautiful Centerpieces', 'Table Centerpieces', 'Best Centerpiece Ideas', 'Unique Centerpiece Concepts', 'Fresh Flower Centerpieces',
            'Dining Table Centerpieces', 'Candle Centerpieces', "Cheap Centerpiece Ideas", 'Smooth Floral Centerpieces', 'Best Party Centerpieces',
            'Table Decoration Ideas', 'Simple Centerpieces', 'Best Centerpieces Ideas', 'Cheap Centerpieces', 'Floating Candle Centerpieces',
            'Centerpiece Vases', 'Kitchen Table Centerpieces', 'Simple Center Piece Ideas', 'Centerpieces for Tables', 'Table Centerpiece Ideas');
    } elseif ($page_id == '54') { //FUNERAL CASKET SPRAYS
        $keywords = array('Casket Flowers', 'Casket Sprays', 'Funeral Casket Sprays', 'Cheap Casket Sprays', 'White Casket Spray',
            'Casket Flower Blanket', 'Full Casket Spray', "Flowers For Casket", 'Funeral Casket Spray', 'Pink Casket Spray',
            'Casket Blanket Of Flowers', 'Spray For Casket', 'Casket Spray', 'Funeral Casket Flowers', 'Casket With Flowers',
            'Inside Casket Flowers', 'Funeral Flowers For Top Of Casket', 'Casket Flowers Roses', 'Flowers For Caskets', 'Flower For Casket');
    } elseif ($page_id == '55') { //FUNERAL PLANTS
        $keywords = array('Funeral Plants', 'Plants For Funerals', 'Popular Funeral Plants', 'Common Funeral Plants', 'Plants For Funeral',
            'Funeral Plants And Flowers', 'Funeral Plants Names', "Plants For Funeral", 'Green Plants For Funerals', 'Funeral Plant Arrangements',
            'Funeral Plants Arrangements', 'Plant For Funeral', 'Plants For A Funeral', 'Potted Plants For Funerals', 'Plants For Funeral Service',
            'Plant Arrangements For Funerals', 'Best Funeral Plants', 'Funeral Plants Trees', 'Best Funeral Plant', 'Funeral Plant');
    } elseif ($page_id == '56') { //FUNERAL WREATHS
        $keywords = array('Flower Wreath', 'Funeral Wreaths', 'Flower Wreaths', 'Funeral Wreath', 'Wreath Of Flowers',
            'Funeral Wreath Flowers', 'Wreath For Funeral', "Wreaths For Funerals", 'Wreaths For Funeral', 'Wreath Funeral',
            'Flower Wreaths For Doors', 'Wreath Flowers', 'Wreaths For Funerals Designs', 'Wreaths For A Funeral', 'Funeral Flower Wreath',
            'Flower Wreaths For Funerals', 'Fresh Flower Wreath', 'Funeral Flower Wreaths', 'Flower Wreath For Funeral', 'Wreath Flowers For Funeral');
    } elseif ($page_id == '57') { //FUNERAL SPRAYS
        $keywords = array('Flower Spray', 'Spray Of Flowers', 'Spray Flowers', 'Funeral Flower Sprays', 'Funeral Sprays',
            'Funeral Spray', 'Funeral Standing Spray', "Funeral Standing Sprays", 'Funeral Sprays For Caskets', 'Standing Sprays For Funeral',
            'Standing Funeral Sprays', 'Standing Spray For Funeral', 'Cheap Funeral Sprays', 'Funeral Sprays Cheap', 'Spray For Funeral',
            'Sprays For Funerals', 'Sprays For Funeral', 'Coffin Sprays For Funeral', 'Funeral Spray Flowers', 'Flower Sprays For Funeral');
    } elseif ($page_id == '58') { //FUNERAL BASKETS
        $keywords = array('Funeral Baskets', 'Funeral Baske', 'Bereavement Gift Baskets', 'Bereavement Gifts', 'Funeral Gift Baskets',
            'Funeral Gifts', 'Funeral Gift Ideas', "Funeral Home Gifts", 'Gifts For Funeral', 'Funeral Gift',
            'Funeral Basket Arrangements', 'Funeral Flower Baskets', 'Funeral Basket Flower Arrangements', 'Bereavement Gift Ideas', 'Bereavement Gift',
            'Basket for Funeral', 'Bereavement Gift Basket', 'Gifts For Bereavement', 'Funeral Gifts Ideas', 'Baskets for Funerals');
    } elseif ($page_id == '59') { //THANK YOU
        $keywords = array('Thank You Flowers', 'Thank You For The Flowers', 'Thank You For Flowers', 'Thank You With Flowers', 'Flowers Thank You',
            'Thank You Flowers Delivery', 'Thank You Images With Flowers', "Thank You Flower Arrangements", 'How To Say Thank You For Flowers', 'Flowers To Say Thank You',
            'Flowers That Say Thank You', 'Flower Thank You', 'Flowers For Thank You', 'Flower Thank You Cards', 'Send Thank You Flowers',
            'Thank You Flowers Color', 'Thank You Flower Color', 'Thank You For My Flowers', 'Thank You For The Flower', 'Thank You In Flowers');
    } elseif ($page_id == '60') { // ROMANCE
        $keywords = array('Flowers For You', 'Love Flowers', 'For You Flowers', 'Romantic Flowers', 'You Flowers',
            'Flowers From You', 'Flower Of Love', "I Love You Flowers", 'Flowers Of Love', 'Thinking Of You Flowers',
            'Flower Love', 'Flowers Love', 'I Love Flowers', 'Flowers For Love', 'Flowers To You',
            'Romantic Flower Arrangements', 'Love You Flowers', 'Romantic Wedding Flowers', 'Love Me Not Flower', 'Most Romantic Flower');
    } elseif ($page_id == '61') { // CHRISTMAS
        $keywords = array('Christmas Centerpieces', 'Christmas Plants', 'Christmas Floral Arrangements', 'Christmas Table Centerpieces', 'Christmas Plant',
            'Christmas Flower Arrangements', 'Christmas Arrangements', "Red Christmas Flower", 'Christmas Floral Centerpieces', 'Centerpieces For Christmas',
            'Red Christmas Flowers', 'Christmas Flower Arrangement', 'Christmas Flower Centerpieces', 'Christmas Flower Delivery', 'Christmas Table Arrangements',
            'Table Centerpieces For Christmas', 'Christmas Flower Arrangement Ideas', 'Christmas Flower Arrangements Centerpieces', 'Flower Arrangements For Christmas', 'Christmas Flowers For Delivery');
    } elseif ($page_id == '62') { //NEW BABY
        $keywords = array('New Baby Gifts', 'New Baby Gift', 'New Baby Gift Ideas', 'New Baby Flowers', 'Baby Shower Flower Arrangements',
            'Flowers For New Baby', 'Gifts For New Baby', "New Baby Boy Gifts", 'New Baby Girl Gifts', 'Flower Arrangements For Baby Shower',
            'Baby Shower Arrangements', 'Gift For New Baby', 'Baby Boy Flower Arrangements', 'New Baby Gifts Delivered', 'Gifts For New Baby Girl',
            'Gifts For New Baby Boy', 'New Baby Gifts For Mom', 'Flowers For New Baby Girl', 'New Baby Flower Arrangements', 'Baby Shower Floral Arrangements');
    }
}

if (CheckCron()) { // API Call
    $ins->getProductDetails(API_USER, API_PASSWORD, $strCategory, $num_records_per_page, $intStart);
    $products = $ins->arrProducts;
    $total = '400';
} else { // Our Data Base Call
    $total_exe = mysql_query("SELECT A.*,B.* FROM " . TABLE_PRODUCT . " as A," . TABLE_IMAGE . " as B WHERE A.product_no = B.code " . $where_clause . " ORDER BY " . $order_by . " ");
    $total = mysql_num_rows($total_exe);

    $resut = mysql_query("SELECT A.*,B.* FROM " . TABLE_PRODUCT . " as A," . TABLE_IMAGE . " as B WHERE A.product_no = B.code " . $where_clause . " ORDER BY " . $order_by . " LIMIT $offset, $num_records_per_page");
     // echo "SELECT A.*,B.* FROM " . TABLE_PRODUCT . " as A," . TABLE_IMAGE . " as B WHERE A.product_no = B.code " . $where_clause . " ORDER BY ".$order_by." LIMIT $offset, $num_records_per_page";
    $i = 0;
    while ($array = mysql_fetch_array($resut)) {
        $products[$i]['code'] = $array['product_no'];
        $products[$i]['description'] = $array['description'];
        $products[$i]['image'] = $array['flowerurl'];

        $products[$i]['price'] = $array['price'];
        if ($array['flower_name'] == "" || $array['flower_name'] == null)
            $products[$i]['name'] = $array['name'];
        else
            $products[$i]['name'] = $array['flower_name'];
        $i++;
    }
}

//echo "SELECT A.*,B.* FROM ".TABLE_PRODUCT." as A,".TABLE_IMAGE." as B WHERE A.product_no = B.code ".$where_clause. " ORDER BY B.common ASC LIMIT $offset, $num_records_per_page";
?>
<div class="innerWrap">        
    <div class="row-fluid">
<?php include("include/sidebar.php"); ?>
        <div class="Content" id="section">
            <ul class="featuredAdd">
                <li class="add_green">
                    <a href="<?= $vpath ?>same-day-flower-delivery-same-day-flowers-today.htm">
                        <span class="thumbpic_featuredAdd">
                            <img src="<?= $vpath ?>images/flowers-online.jpg" alt="Flowers Online" height="91" width="142"></span>
                        <span class="featured_content"><span class="title">Flowers Today</span>
                            Select locations</span>
                        <span class="btn_box"></span>
                    </a>
                </li>
                <li class="add_pink nomarginRgt">
                    <a href="<?= $vpath ?>next-day-flower-delivery-next-day-flowers-tomorrow.htm">
                        <span class="thumbpic_featuredAdd">
                            <img src="<?= $vpath ?>images/flower-delivery.jpg" alt="Flower Delivery" height="91" width="142"></span>
                        <span class="featured_content"><span class="title">Flowers Next Day</span>Anywhere in the nation
                        </span><span class="btn_box"></span>
                    </a>
                </li>
            </ul>
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
                                        <a><img src="<?php echo $product['image']; ?>" alt="<?php echo $keywords[$i]; ?>" height="211px" width="183px"></a>
                                    </div>
                                    <div class="ProductDetails">
                                        <a><?php echo $keywords[$i]; ?></a>
                                    </div>
                                    <div class="ProductPriceRating">
                                        <em><?php echo substr($product['name'], 0, 27); ?></em>
                                        <em><?php echo '$' . $product['price']; ?></em>
                                    </div>
                                    <div style="text-align:center; margin-top:5px;">
                                        <a href="<?= $vpath; ?>item.php?code=<?php echo $product['code']; ?>"  data-fancybox-type="iframe" class="splFancyIframe btn-pink">VIEW ITEM</a>
                                    </div>
                                </td>

        <?php
        $i++;
        if ($i % 4 == 0) {
            echo '</tr><tr>';
        }
    endforeach;
    ?>

                        </tr>
                        <tr>
                            <td colspan="8" align="center" height="25"><?= paging($total, $num_records_per_page, $parama, "paging"); ?></td>
                        </tr>
            <?php
        else:
            echo '<tr><td class="norecords">No Records Found</td></tr>';
        endif;
        ?>
                </tbody>
            </table>
<?php include_once($page_content); ?>
        </div>
    </div>
</div>
<?php
include("include/footer.php");
?>

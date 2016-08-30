<?php
if (substr_count($_SERVER['PHP_SELF'], "admin")):

    require_once("../myconfig/config.php");

else:

    require_once("myconfig/config.php");

endif;




$zone_array = array("Scottish Mainland", "Remote Scottish Mainland", "Scottish Highlands and Islands", "Scottish Surcharged", "Northern Ireland", "Eire", "Isle of Wight", "Other");



$product_type = array("RP" => "Regular Pizzas", "SVP" => "Super Value Pizzas", "ET" => "Extra Toppings", "SO" => "Side Order", "G" => "Gelato");

function copyright($x) {

    global $vpath, $template_dir;

    if ($x == "admin_header") {

//echo '<a href="' . $vpath . '" target="_blank" title=" ' .$vpath . '"><img src="images/logo.png" alt="' . $dotcom . '" border="0" height="60"/></a>';
    } elseif ($x == "admin_footer") {

        echo "<font color=silver>www.flowerwyz.com</font>";
    }
}

function txt_value($x) {

    $x2 = mysql_real_escape_string(addslashes(strip_tags($x)));

    return $x2;
}

function txt_value_output($x) {

    $x2 = stripslashes(stripslashes(strip_tags($x)));

    return $x2;
}

function html_value($x) {

    $x2 = mysql_real_escape_string(htmlentities(addslashes($x)));

    return $x2;
}

function CheckCron() {
    $CUR_TIME = date('Y-m-d H:i:s');

    $result1 = mysql_query("SELECT * FROM " . TABLE_LOG . " WHERE 1 ORDER BY id DESC LIMIT 0,1");
    $row1 = mysql_fetch_array($result1);

    if ($row1['cron_end_time'] == "" || $row1['cron_end_time'] == null) {

        $result = mysql_query("SELECT id FROM " . TABLE_LOG . " WHERE cron_start_time<= '" . $CUR_TIME . "' OR flag=1  ORDER BY id DESC LIMIT 0,1");
    } else {
        //echo "SELECT id FROM ".TABLE_LOG." WHERE (cron_start_time<= '".$CUR_TIME."' AND cron_end_time >= '".$CUR_TIME."') OR flag=1 ORDER BY id DESC LIMIT 0,1";
        $result = mysql_query("SELECT id FROM " . TABLE_LOG . " WHERE (cron_start_time<= '" . $CUR_TIME . "' AND cron_end_time >= '" . $CUR_TIME . "') OR flag=1 ORDER BY id DESC LIMIT 0,1");
    }
    $row = mysql_fetch_array($result);
    if ($row['id'] > 0) {
        return 1; // API Call
    }
    else
        return 0; // Our Data Base Call
}

function html_value_output($x) {

    $x2 = stripslashes(stripslashes(html_entity_decode($x, ENT_QUOTES, 'UTF-8')));

    return $x2;
}

$spacer = "<table cellspacing='0' cellpadding='0' border='0' height='8'><tr><td height='8'><img width='1' height='1' alt='' src='' /></td></tr></table>";



$month_ary["01"] = "January";



$month_ary["02"] = "February";



$month_ary["03"] = "March";



$month_ary["04"] = "April";



$month_ary["05"] = "May";



$month_ary["06"] = "June";



$month_ary["07"] = "July";



$month_ary["08"] = "August";



$month_ary["09"] = "September";



$month_ary["10"] = "Octobar";



$month_ary["11"] = "November";



$month_ary["12"] = "December";



$day_ary["01"] = "1st";



$day_ary["02"] = "2nd";



$day_ary["03"] = "3rd";



$day_ary["04"] = "4th";



$day_ary["05"] = "5th";



$day_ary["06"] = "6th";



$day_ary["07"] = "7th";



$day_ary["08"] = "8th";



$day_ary["09"] = "9th";



$day_ary["10"] = "10th";



$day_ary["11"] = "11th";



$day_ary["12"] = "12th";



$day_ary["13"] = "13th";



$day_ary["14"] = "14th";



$day_ary["15"] = "15th";



$day_ary["16"] = "16th";



$day_ary["17"] = "17th";



$day_ary["18"] = "18th";



$day_ary["19"] = "19th";



$day_ary["20"] = "20th";



$day_ary["21"] = "21st";



$day_ary["22"] = "22nd";



$day_ary["23"] = "23rd";



$day_ary["24"] = "24th";



$day_ary["25"] = "25th";



$day_ary["26"] = "26th";



$day_ary["27"] = "27th";



$day_ary["28"] = "28th";



$day_ary["29"] = "29th";



$day_ary["30"] = "30th";



$day_ary["31"] = "31st";



#Setting paramiter  =============================================================================

/**



 * Function for each of the Row Colors for the Admin section



 */
function adminRowColor($rowNum) {



    if ($rowNum % 2) {



        return "#FFFFFF";
    }



    return "";
}

/**



 * Fetching the Settings of the Site



 */
$max_num_admin_paswd = 12;



$rs = mysql_query("SELECT * FROM " . $prev . "setting LIMIT 1");



$setting = @mysql_fetch_array($rs);







#Contents==========================================================================

function getcontent_title($x) {



    global $db, $dbh, $prev;



    $r2 = mysql_query("select * from " . $prev . "contents where status='Y' and  cont_title='" . $x . "'");



    $d = @mysql_fetch_array($r2);



    return html_value_output($d['cont_title']);
}

function getcontent_meta_key($x) {



    global $db, $dbh, $prev;



    $r2 = mysql_query("select * from " . $prev . "contents where status='Y' and  cont_title='" . $x . "'");



    $d = @mysql_fetch_array($r2);



    return html_value_output($d['meta_keys']);
}

function getcontent_meta_desc($x) {



    global $db, $dbh, $prev;



    $r2 = mysql_query("select * from " . $prev . "contents where status='Y' and  cont_title='" . $x . "'");



    $d = @mysql_fetch_array($r2);



    return html_value_output($d['meta_desc']);
}

function getcontent_contents($x) {



    global $db, $dbh, $prev;



    $r2 = mysql_query("select * from " . $prev . "contents where status='Y' and  cont_title='" . $x . "'");



    $d = @mysql_fetch_array($r2);



    return html_value_output($d['contents']);
}

#=====================================================================================

function resize($img, $target, $type = "", $class = "", $p = "") {



    $size = getimagesize($img);



    $width = $size[0];



    $height = $size[1];



    if (($width > $target && $height > $target) || $width > $target):



        $cent = 100 - round((($width - $target) / $width) * 100);



        $width = round($width * $cent / 100);



        $height = round($height * $cent / 100);



    elseif ($height > $target):



        $cent = 100 - round((($height - $target) / $height) * 100);



        $width = round($width * $cent / 100);



        $height = round($height * $cent / 100);



    endif;



    if (($width > $target && $height > $target) || $width > $target):



        $cent = 100 - round((($width - $target) / $width) * 100);



        $width = round($width * $cent / 100);



        $height = round($height * $cent / 100);



    elseif ($height > $target):



        $cent = 100 - round((($height - $target) / $height) * 100);



        $width = round($width * $cent / 100);



        $height = round($height * $cent / 100);



    endif;



    echo"<img src='" . $p . $img . "' width='" . $width . "' height='" . $height . "' border=1  style='border-color:#111111' hspace=4 vspace=3 >";
}

#=======================================================================



$r3 = mysql_query("select * from " . $prev . "setting");



$setting = @mysql_fetch_array($r3);







if (!$_REQUEST[currency] && !$_SESSION[currency_value]) {



    $_SESSION[currency_value] = 1;



    $_REQUEST[currency] = "USD";
}



if ($_REQUEST[currency] == "USD") {



    $_SESSION[currency_value] = 1;







    $_SESSION[currency] = $_REQUEST[currency];
} elseif ($_REQUEST[currency] == "EUR") {



    $_SESSION[currency_value] = $setting['usd_to_eur'];







    $_SESSION[currency] = $_REQUEST[currency];
} elseif ($_REQUEST[currency] == "CAD") {



    $_SESSION[currency_value] = $setting['usd_to_cad'];







    $_SESSION[currency] = $_REQUEST[currency];
} elseif ($_REQUEST[currency] == "GBP") {







    $_SESSION[currency_value] = $setting['usd_to_gbp'];







    $_SESSION[currency] = $_REQUEST[currency];
}



$currency = $_SESSION[currency_value];



#=============================================

function active($x) {

    if (substr_count($_SERVER[PHP_SELF], $x)) {

        return "class='button_active'";
    } else {

        return "class='button'";
    }
}

function active_home_menu($x) {

    if (substr_count($_SERVER[PHP_SELF], $x)) {

        return "class='active_top'";
    } else {

        return "";
    }
}

function GetCartId() {



    $cartId = session_id();



    $_SESSION["cartId"] = $cartId;



    return session_id();
}

#Banner==============================================================

function banner($size, $location = "") {



    global $db, $dbh, $prev;



    $r = mysql_query("update " . $prev . "adsense set status='E' where finish_date<='" . date("Y-m-d") . "'");



    global $db, $prev, $vpath;



    if ($location == 'header'):



        $location = "header='Y'";



    elseif ($location == 'footer'):



        $location = "footer='Y'";



    elseif ($location == 'body_header'):



        $location = "body_header='Y'";



    elseif ($location == 'body_footer'):



        $location = "body_footer='Y'";



    endif;



    if ($location):



        $location2 = " and " . $location;



        $banner_query = @mysql_query("select * from " . $prev . "adsense where size='" . $size . "' and status='Y' " . $location2 . " order by rand() limit 1");



    else:



        $banner_query = @mysql_query("select * from " . $prev . "adsense where size='" . $size . "' and status='Y'  order by rand() limit 1");



    //echo"select * from " . $prev . "adsense where size='" . $size . "' and status='Y'  order by rand() limit 1";



    endif;



    $d = @mysql_fetch_array($banner_query);



    $e = explode("x", $d['size']);



    $width = $e[0];
    $height = $e[1];



    if ($d[type] == 1):



        $dx = html_value_output($d['adsense']);



        $dx = str_replace("000000", "E7DEBD", $dx);



        if ($height != 240):



            $dx = str_replace("text_image", "image", $dx);



        endif;



        $dx = str_replace("F0F0F0", "E7DEBD", $dx);



        echo $dx;



    elseif ($d['type'] == 2):



        if ($d['image_type'] == "N"):
            ?>



            <a href="<?= $d['link'] ?>" target='_blank' title="<?= $d['link'] ?>"><img src="<?= $vpath ?><?= $d['banner'] ?>" width="<?= $width ?>" height="<?= $height ?>" border='0' alt="<?= $d['link'] ?>"></a>



            <?php
        elseif ($d[image_type] == "F"):
            ?>







            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0" width="<?= $width ?>" height="<?= $height ?>" name="<?= $d['banner'] ?>">





                <param name="movie" value="<?= $vpath ?><?= $d['banner'] ?>">





                <param name="Play" value="-1">





                <param name="Loop" value="-1">





                <param name="quality" value="high">





                <param name="SCALE" value="noborder">





                <embed src="<?= $vpath ?><?= $d['banner'] ?>" quality="high" width="<?= $width ?>" height="<?= $height ?>" name="<?= $d['banner'] ?>" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></embed>



            </object>	



            <?php
        endif;



    endif;
}

#Sub======================================================================================

function paging($total, $perpage = 20, $param = "", $class = "lnk") {

    $limit = $_REQUEST['limit'];
    if (!$limit)
        $limit = 1;
    $page = ceil($total / $perpage);

    $start = 1;
    $end = 10;
    $t = @($limit % 10);
    if ($t)
        $start = $limit - $t + 1;
    elseif ($limit > 10)
        $start = $limit - 9;
    $end = $start + 9;

    if ($page < $end)
        $end = $page;
    $data = '<div class="pagination"><ul>';

    $cur_page = end(explode('/', $_SERVER[REQUEST_URI]));
    if ($cur_page <> '') {
        $page = explode("?", $cur_page);
        $b = explode('&', $page[1]);
        $page = $page[0];
        $b = array_filter($b);
        if (!empty($b)) {
            $c = explode('=', $b[0]);
            $limit = $c[1];
        }
    }
    else
        $page = $_SERVER['PHP_SELF'];

    $primary_text = $page . '?limit=';

    $data .= "<li><a href='" . $primary_text . ($start - 1) . $param . "' class='" . $class . "'> &#60;&#60; </a></li>";
    $data .= "<li><a href='" . $primary_text . ($limit - 1) . $param . "' class='" . $class . "'> &#60; </a></li>";
    /*
      if ($limit > 1 && $start != 1) {



      $data .= "<li><a href='" . $primary_text . ($start - 1) . $param . "' class='active" . $class . "'> &laquo; </a></li>";
      }
     * 
     */

    for ($i = $start; $i <= $end; $i++) {
        if ($limit == $i) {
            $data .= "<li><a href='" . $primary_text . $i . $param . "' class='active'>" . $i . "</a></li>";
        } else {
            $data .= "<li><a href='" . $primary_text . $i . $param . "' class='" . $class . "'>" . $i . "</a></li>";
        }
        /*
          if ($i < $page) {



          $data .= " &nbsp; ";
          }
         * 
         */
    }
    // if ($end < $page) {
    $data .= "<li><a href='" . $primary_text . ($limit + 1) . $param . "' class='" . $class . "'> &#62; </a></li>";
    $data .= "<li><a href='" . $primary_text . $i . $param . "' class='" . $class . "'> &#62;&#62; </a></li>";
    //}

    $data .= '</ul></div>';





    if ($total > $perpage) {



        return $data;
    }
}

function paging_home($total, $perpage = 20, $param = "", $class = "lnk") {



    $limit = $_REQUEST['limit'];



    if (!$limit)
        $limit = 1;







    $page = ceil($total / $perpage);



    $start = 1;



    $end = 10;



    $t = @($limit % 10);







    if ($t)
        $start = $limit - $t + 1;



    elseif ($limit > 10)
        $start = $limit - 9;







    $end = $start + 9;







    if ($page < $end)
        $end = $page;







    $data = "";

    $data .= "<ul>";



    $primary_text = $_SERVER['PHP_SELF'] . '?limit=';







    if ($limit > 1 && $start != 1) {



        $data .= "<li><a href='" . $primary_text . ($start - 1) . $param . "' class='" . $class . "'>&laquo; Prev</a> </li>";
    }







    for ($i = $start; $i <= $end; $i++) {



        if ($limit == $i) {



            $data .= "<li><a href='" . $primary_text . $i . $param . "' class='active'><u><b>[" . $i . "]</b></u></a></li>";
        } else {



            $data .= "<li><a href='" . $primary_text . $i . $param . "' class='" . $class . "'><u>" . $i . "</u></a></li>";
        }







        if ($i < $page) {



            $data .= "  ";
        }
    }







    if ($end < $page) {



        $data .= "<li><a href='" . $primary_text . $i . $param . "' class='" . $class . "'>Next &raquo;</a></li>";
    }


    $data .="</ul>";




    if ($total > $perpage) {



        return $data;
    }
}

#date====================================================================================

function mysqldate($date) {



    global $month_ary2;



    if ($date):



        $e = explode(",", $date);



        $d = explode(" ", $e[0]);



        $month = $month_ary2[$d[0]];



        $day = $d[1];



        $f = explode(":", $date);



        $year = substr($e[1], 0, 4);



        $hour = substr($f[0], -2, 2);



        $minute = substr($f[1], 0, 2);



        $am = substr($f[1], -2, 2);



        if ($am == "PM") {
            $hour = $hour + 12;
        }



        if ($year && $month && $day):



            return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":00";



        endif;



    endif;
}

function mysqldate_show($date) {



    if ($date):



        $e = @explode("-", $date);



        $time = @explode(":", substr($e[2], 2));



        $day = @substr($e[2], 0, 2);



        if ($e[1] && $day && $e[0]):



            return date('F d,Y', @mktime($time[0], $time[1], $time[2]));



        endif;



    endif;
}

function showdate($date) {



    global $month_ary;



    if ($date):



        $e = explode("-", $date);



        //return $e[2] . " " . $month_ary[$e[1]] . "'" . $e[0];



        return $month_ary[$e[1]] . " " . $e[2] . "," . $e[0];



    endif;
}

function pagination($total, $perpage = 20, $param = "", $class = "lnk",$url='')
{
	$limit = $_REQUEST['limit'];
	if(!$limit)
		$limit = 1;
		$page = ceil($total / $perpage);
		$start = 1;
		$end = 10;
		$t = @($limit % 10);
	if($t)
		$start = $limit - $t + 1;
	elseif($limit > 10)
		$start = $limit - 9;
		$end = $start + 9;
	if($page < $end)
		$end = $page;
		$data = "";
        if(!$url){$url=$_SERVER['PHP_SELF'];}
		$primary_text = $url.'?limit=';
	if($limit > 1 && $start != 1)
	{
		$data .= "<a href='".$primary_text.($start - 1).$param."' class='".$class."'>&laquo; Prev</a> | ";
	}
	for($i = $start; $i <= $end; $i++)
	{
		if($limit == $i)
		{
			$data .= "<a href='".$primary_text.$i.$param."' class='".$class."'>".$i."</a>";
		}
		else
		{
			$data .= "<a href='".$primary_text.$i.$param."' class='".$class."'><u>".$i."</u></a>";
		}
		if($i < $page)
		{
			$data .= " | ";
		}
	}
	if($end < $page)
	{
		$data .= "<a href='".$primary_text.$i.$param."' class='".$class."'>Next &raquo;</a>";
	}
	if($total > $perpage)
	{
		return "<b>Page:</b> " . $data;
	}
}

function showdate2($date) {



    global $month_ary;



    if ($date):



        $e = explode("-", $date);



        //return $e[2] . " " . $month_ary[$e[1]] . "'" . $e[0];



        return $e[2] . "th " . $month_ary[$e[1]] . " ' " . $e[0];



    endif;
}

function sqldate($date) {



    if ($date):



        $e = explode("/", $date);



        return $e[2] . "-" . $e[1] . "-" . $e[0];



    endif;
}

function showdate3($date) {



    global $month_ary, $day_ary;



    if ($date):



        $e = @explode("-", $date);



        return $day_ary[$e[2]] . " " . $month_ary[$e[1]] . " " . $e[0];



    //return date("jS M Y");



    endif;
}

function showdate4($date) {



    global $month_ary2, $day_ary2;



    if ($date):



        $e = @explode("-", $date);



        return $day_ary2[$e[2]] . "." . $month_ary2[$e[1]] . "." . $e[0];



    endif;
}

function mysqldate_show2($date) {



    if ($date):



        $e = @explode("-", $date);



        $time = @explode(":", substr($e[2], 2));



        $day = @substr($e[2], 0, 2);



        if ($e[1] && $day && $e[0]):



            return date('F d,Y H:i:s', mktime($time[0], $time[1], $time[2], $e[1], $day, $e[0]));



        endif;



    endif;
}

#=========================================================================================================================

function redirect($x) {



    header("Location: " . $x);



    exit();
}

function pageRedirect($target, $type = 'location', $time = 0) {



    if ($type == 'location') {



        header("Location: " . $target);



        exit();
    } else if ($type == 'refresh') {



        header("Refresh: $time; url=" . $target);



        exit();
    }
}

/**



 * Mail Function



 */
function genMailing($to, $subj, $body, $from = '', $fromName = '', $reply = true, $bcc = '') {



    global $setting, $dotcom;







    if ($from == '')
        $from = stripslashes($setting['admin_mail']);







    if (empty($fromName))
        $fromName = $dotcom;







    $headers = "MIME-Version: 1.0\r\n";



    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";



    $headers .= "From: $fromName <" . $from . ">\r\n";







    if ($reply)
        $headers .= "Reply-to: $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";







    if (!empty($bcc))
        $headers .= "Bcc: " . $bcc . "\r\n";







    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";







    $return_str = mail($to, $subj, $body, $headers);







    return $return_str;
}

/**



 * Custom Date Format Modifier Function



 */
function dateModifier($db_date, $format = 'm/d/Y') {



    $datetime = new DateTime($db_date);







    if (!is_object($datetime) || $db_date == '0000-00-00' || $db_date == '0000-00-00 00:00:00')
        return "Unknown Date";







    $explode_db_date = explode(' ', $db_date);



    if (count($explode_db_date) == 1) {



        $explode_format = explode(' [', $format);



        $format = $explode_format[0];
    }



    return $datetime->format($format);
}

/**



 * Email Validation Function



 */
function checkEmail($email, $type = true) {



    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i", $email)) {



        $validResult = true;
    }



    if ($validResult) {



        $e = explode("@", $email);



        if (@checkdnsrr($e[1])) {



            $validResult = true;
        } else {



            $validResult = false;
        }
    }



    return $validResult;
}

#=========================================================================================================================

function chklogin($referer = "") {



    if (!isset($_SESSION['user_id'])):



        if ($referer) {
            $txt = "?referer=" . $referer;
        }



        header("Location: login.php" . $txt);



        exit();



    endif;
}

#Contents==========================================================================

function pagecontents($x) {



    global $db, $prev, $dbh;



    $rc = mysql_query("select * from " . $prev . "contents where status='Y' and cont_title='" . $x . "'");



    $dc = @mysql_fetch_array($rc);







    return $contents_array[$d[cont_title]] = $dc[contents];



    @mysql_free_result($rc);
}

#Number Format====================================================================

function number($n) {



    $txt = "";



    $nom = explode(",", substr(number_format($n, 3), 0, -4));



    for ($i = 0; $i < count($nom); $i++):



        if ($i == 0):



            $txt.=$nom[0] . ",";



        else:



            $txt.=$nom[$i] . ",";



        endif;



    endfor;



    return substr($txt, 0, -1);
}

#=========================================================================

function morePaging($total, $perpage = 20, $param = "", $class = "lnk") {



    $limit = $_REQUEST['limit'];



    $page = ceil($total / $perpage);



    $t = $limit + 1;



    $data = "<a href='" . $_SERVER['PHP_SELF'] . "?limit=" . $t . $param . "' class='" . $class . "'> More >> </a>";



    if ($t <= $page) {



        echo $data;
    }
}

function encrypter($string, $key) {



    $result = '';



    for ($i = 0; $i < strlen($string); $i++) {



        $char = substr($string, $i, 1);



        $keychar = substr($key, ($i % strlen($key)) - 1, 1);



        $char = chr(ord($char) + ord($keychar));



        $result.=$char;
    }



    return base64_encode($result);
}

function decrypter($string, $key) {



    $result = '';



    $string = base64_decode($string);



    for ($i = 0; $i < strlen($string); $i++) {



        $char = substr($string, $i, 1);



        $keychar = substr($key, ($i % strlen($key)) - 1, 1);



        $char = chr(ord($char) - ord($keychar));



        $result.=$char;
    }



    return $result;
}

function isInt($foo) {



    if (preg_match("/^[0-9]+$/i", $foo)) {



        return true;
    }
    else
        return false;
}

function showmyaccountmenu() {







    global $dbh, $db, $prev;



    $txt = "";



    $r = mysql_query("select id from " . $prev . "menu where featured='1' and url='products.php'");



    if (@mysql_num_rows($r) > 0) {







        if ($_SESSION['user_id']) {



            $txt.="<div align='right' style='text-align:right;padding-right:10px;float:right;' class='text8'>



<img src='images/account.png' alt='My Account' border='0' align='absmiddle' />&nbsp;<a href='my.account.php' class='text_nav' title='My Account'><b>My Account</b></a>  



&nbsp;&nbsp;&nbsp;<a href='order.list.php' class='text_nav' title='My Orders'><b>My Orders</b></a>  



&nbsp;&nbsp;&nbsp;<a href='view_cart.php' class='text_nav' title='Vtew Cart'><b>View Cart</b></a> 



&nbsp;&nbsp;&nbsp;<a href='checkout.php' class='text_nav' title='Checkout' ><b>Checkout</b></a> 



&nbsp;&nbsp;&nbsp;<a href='logout.php' class='text_nav'><b>Logout</b></a>



</div><br style='clear:both;' />



";
        }



        if (!$_SESSION['user_id']) {



            $txt.="<div align='right' style='text-align:right;padding-right:10px;float:right;' class='text8'>



<b>Not a member?</b>&nbsp;<a href='signup.php' class='text_nav' title='Sign Up'><b>Sign Up</b></a>&nbsp;&nbsp;&nbsp; 



<img src='images/account.png' alt='My Account' border='0' align='absmiddle' />&nbsp;<a href='my.account.php' class='text_nav' title='My Account'><b>My Account</b></a>  



&nbsp;&nbsp;&nbsp;<a href='view_cart.php' class='text_nav' title='Vtew Cart'><b>View Cart</b></a> 



&nbsp;&nbsp;&nbsp;<a href='javascript:void(0)' class='text_nav' title='Checkout' onclick=\"document.getElementById('confirm_member').style.display='block';\"><b>Checkout</b></a>



</div><br style='clear:both;' />



";
        }



        $txt.='<div style="float:right; padding-right:10px;">



<form name="frmsearch" id="frmsearch" action="search.php" method="post" >



<label for="search">



<img src="images/search.png" alt="Search" border="0" align="absmiddle" />



<input class="search" name="search" type="text" id="search"  onFocus="if(this.value==\'Search here\') {this.value=\'\';}" onBlur="if(this.value==\'\') {this.value=\'Search here\';}" ' . (($_REQUEST[search] != "" && $_REQUEST[search] != "Search here") ? 'value="' . $_REQUEST[search] . '"' : 'value="Search here"') . ' size="10" />



</label>



<input type="hidden" name="submit" value="submit" />



<input name="image" type="image" src="images/search_button.png" align="absmiddle" / >



</form>



</div>



<br style="clear:both;" />';
    }







    return $txt;
}

function showshoppingcart() {



    global $dbh, $db, $prev;



    $r = mysql_query("select id from " . $prev . "menu where featured='1' and url='products.php'");



    if (@mysql_num_rows($r) == 0) {



        redirect("index.php");
    }
}

function shipping_charge_slabs($weight) {

    global $dbh, $db, $prev;



    $rate = array();

    if ($weight <= 5) {

        $rate = "9,7";
    } elseif ($weight > 5 && $weight <= 15) {

        //echo "right";

        $rate = "19,10";
    } elseif ($weight >= 16 && $weight <= 25) {

        $rate = "39,16";
    } elseif ($weight >= 26) {

        $rate = "48,17";
    }



    return $rate;
}

#Add & delete product

if ($_POST[addtocart]):

    $rr = mysql_query("select * from " . $prev . "products where product_id=" . $_REQUEST[product_id]);

    $product_price = @mysql_result($rr, 0, "product_price");

    $cat_id = @mysql_result($rr, 0, "cat_id");



    $total = $product_price * $_REQUEST[qty];



    $rr = mysql_query("select * from " . $prev . "cart where  product_id='" . $_REQUEST[product_id] . "' and OrderID='" . GetCartId() . "'");

    if (@mysql_num_rows($rr)):

        $qty = @mysql_result($rr, 0, "qty");

        $qty = $qty + $_REQUEST[qty];

        $total = $qty * $product_price;

        $r1 = mysql_query("update " . $prev . "cart set qty='" . $qty . "',total='" . $total . "' where product_id='" . $_REQUEST[product_id] . "' and purchased='N' and OrderID='" . GetCartId() . "'");

    // echo"update " . $prev . "cart set qty='" . $qty . "',total='" . $total . "' where product_id='" .$_REQUEST[product_id] . "' and purchased='N' and OrderID='" . GetCartId() . "'";

    else:

        $r1 = mysql_query("insert into " . $prev . "cart set 

	   product_id='" . $_REQUEST['product_id'] . "',

	   user_id='" . $_SESSION['user_id'] . "',qty='" . $_REQUEST['qty'] . "',

	   price='" . $product_price . "',total='" . $total . "',

	   ip_address='" . $_SERVER['REMOTE_ADDR'] . "',selected_color='" . $_REQUEST[color] . "',

	   selected_size='" . $_REQUEST['product_size'] . "',

	  `date`='" . date("Y-m-d") . "',purchased='N',OrderID='" . GetCartId() . "'");

    endif;

elseif ($_POST['update']):

    for ($i = 0; $i < count($_REQUEST[product_id]); $i++):

        if ($_REQUEST[qty][$i] && !$_REQUEST[remove][$i]):

            $r1 = mysql_query("update " . $prev . "cart set qty='" . $_REQUEST['qty'][$i] . "',price='" . $_REQUEST['price'][$i] . "',total='" . ($_REQUEST[qty][$i] * $_REQUEST[price][$i]) . "' where product_id='" . $_REQUEST[product_id][$i] . "' and purchased='N' and OrderID='" . GetCartId() . "'");

        //echo"update " . $prev . "cart set qty='" . $_REQUEST[qty][$i] . "',price='".$_REQUEST[price][$i]."',total='" . ($_REQUEST[qty][$i]*$_REQUEST[price][$i]) . "' where product_id='" .$_REQUEST[product_id][$i] . "' and purchased='N' and (OrderID='" . GetCartId() . "' or user_id='".$_SESSION[user_id]."')<br>"; 

        endif;

        if ($_REQUEST[remove][$i]):

            $rr = mysql_query("delete  from " . $prev . "cart where product_id=" . $_REQUEST[remove][$i] . "  and  OrderID='" . GetCartId() . "'");

            // echo"delete  from " . $prev . "cart where product_id=" . $_REQUEST[remove][$i] . "  and  (OrderID='" . GetCartId() . "' or user_id='".$_SESSION[user_id]."')";

            $txt = "Product removed successfully";

        endif;

    endfor;

endif;





#Meta Kesys & Site Title
## meta keys ,meta description,site title





if ($_REQUEST[product_id]):

    $result = mysql_query("SELECT * FROM  " . $prev . "products WHERE product_id='" . $_REQUEST[product_id] . "'");

elseif ($_REQUEST[cat_id]):

    $result = mysql_query("SELECT * FROM  " . $prev . "categories WHERE cat_id='" . $_REQUEST[cat_id] . "'");

elseif ($_REQUEST['cont_title']):

    $result = mysql_query("select * from " . $prev . "contents where cont_title='" . $_REQUEST['cont_title'] . "'");

endif;

function randPass($n, $chars) {

    srand((double) microtime() * 1000000);

    $m = strlen($chars);

    while ($n--) {

        $randPassword .= substr($chars, rand() % $m, 1);
    }

    return $randPassword;
}

function getstatenameById($state_id) {
    global $prev;
    $result = mysql_query("SELECT `state_name` FROM " . $prev . "state WHERE state_id=" . $state_id);
    $row = mysql_fetch_object($result);
    return $row->state_name;
    mysql_free_result($result);
}

function getstatecodeById($state_id) {
    global $prev;
    $result = mysql_query("SELECT `state_code` FROM " . $prev . "state WHERE state_id=" . $state_id);
    $row = mysql_fetch_object($result);
    return $row->state_code;
    mysql_free_result($result);
}

function getCitynameById($city_id) {
    global $prev;
    $result = mysql_query("SELECT `city_name` FROM " . $prev . "city WHERE city_id=" . $city_id);
    $row = mysql_fetch_object($result);
    return $row->city_name;
    mysql_free_result($result);
}

function getZipcodeById($zip_id) {
    global $prev;
    $result = mysql_query("SELECT `zip_code` FROM " . $prev . "zip WHERE zip_id=" . $zip_id);
    $row = mysql_fetch_object($result);
    return $row->zip_code;
    mysql_free_result($result);
}

function getRestuarantnameById($rest_id) {
    global $prev;
    $result = mysql_query("SELECT `rest_name` FROM " . $prev . "restaurant WHERE rest_id=" . $rest_id);
    $row = mysql_fetch_object($result);
    return $row->rest_name;
    mysql_free_result($result);
}

function getCategoryId($cat_id) {
    global $prev;
    $result = mysql_query("SELECT `cat_name` FROM " . $prev . "category WHERE cat_id=" . $cat_id);
    $row = mysql_fetch_object($result);
    return $row->cat_name;
    mysql_free_result($result);
}

function chkRestaurantlogin($referer = "") {
    if (!isset($_SESSION['rest_id'])):
        if ($referer) {
            $txt = "?referer=" . $referer;
        }
        header("Location: login.php" . $txt);
        exit();
    endif;
}

function getCuisineByID($cuisine_id) {
    global $prev;
    if ($cuisine_id) {
        $result = mysql_query("SELECT `cuisine_name` FROM " . $prev . "cuisine WHERE cuisine_id=" . $cuisine_id);
        $row = mysql_fetch_object($result);
        return $row->cuisine_name;
        mysql_free_result($result);
    }
    return 'No';
}

function Getunique_userID() {
    $sid = session_id();
    $user_id = md5($sid);
    if (empty($_COOKIE['temp_user_id'])) {
        setcookie("temp_user_id", $user_id, time() + 172800);
    }

    return $_COOKIE['temp_user_id'];
}

function getMenuNameById($menu_id) {
    global $prev;
    $result = mysql_query("SELECT `memu_name` FROM " . $prev . "menu WHERE menu_id=" . $menu_id);
    $row = mysql_fetch_object($result);
    return $row->memu_name;
    mysql_free_result($result);
}

function getUsernameById($user_id) {
    global $prev;
    $result = mysql_query("SELECT `f_name`,`l_name` FROM " . $prev . "user WHERE user_id=" . $user_id);
    $row = mysql_fetch_object($result);
    return ucfirst($row->f_name) . ' ' . ucfirst($row->l_name);
    mysql_free_result($result);
}

function getUserAddressById($user_id) {
    global $prev;
    $result = mysql_query("SELECT `apart_ment`,`street`,`cross_street`,`land_mark`,`area` FROM " . $prev . "user WHERE user_id=" . $user_id);
    $row = mysql_fetch_object($result);
    return ucfirst($row->apart_ment) . ', ' . ucfirst($row->street) . ', ' . ucfirst($row->cross_street) . ', ' . ucfirst($row->land_mark) . ', ' . ucfirst($row->area);
    mysql_free_result($result);
}
function getPagenameById($page_id) {
    global $prev;
    $result = mysql_query("SELECT `cont_title` FROM " . $prev . "contents WHERE id=" . $page_id);
    $row = mysql_fetch_object($result);
    return ucfirst($row->cont_title);
    mysql_free_result($result);
}

function getCategorynameByCode($cat_code) {
    global $prev;
    $result = mysql_query("select cat_name from " . $prev . "categories where cat_code='".$cat_code."'");
    $row = mysql_fetch_object($result);
    return ucfirst($row->cat_name);
    mysql_free_result($result);
}

function getUserContactById($user_id) {
    global $prev;
    $result = mysql_query("SELECT `contact_1` FROM " . $prev . "user WHERE user_id=" . $user_id);
    $row = mysql_fetch_object($result);
    return $row->contact_1;
    mysql_free_result($result);
}

if ($current_page != "") {

    $site_title = $current_page;
} else {

    $r = mysql_query("select * from " . $prev . "sitemap where (url =\"" . $pageurl . "\"  or url =\"" . $pageurl . "/\")");

    //echo"select * from " . $prev . "sitemap where (url =\"" . $pageurl . "\"  or url =\"" . $pageurl . "/\")";

    if (@mysql_num_rows($r)) {

        $ds = mysql_fetch_array($r);

        $site_title = $ds['title'];

        $site_keys = $ds['meta_keys'];

        $site_desc = $ds['meta_desc'];
    } else {

        $site_title = $setting['site_title'];

        $site_keys = $setting['meta_keys'];

        $site_desc = $setting['meta_desc'];
    }
}

function getRestIdbycartId($cartid) {
    global $prev;
    $result = mysql_query("SELECT `rest_id` FROM " . $prev . "cart WHERE OrderID='" . $cartid . "'");
    $row = mysql_fetch_object($result);
    return $row->rest_id;
    mysql_free_result($result);
}

function deletecartbycartId($cartid) {
    global $prev;
    $result = mysql_query("DELETE FROM " . $prev . "cart WHERE OrderID='" . $cartid . "'");
}

function getRestaurantOrder($rest_id) {
    global $prev;
    $result = mysql_query("SELECT `rest_order` FROM " . $prev . "resturant_info WHERE rest_id='" . $rest_id . "'");
    $row = mysql_fetch_object($result);
    return $row->rest_order;
    mysql_free_result($result);
}

function WordTruncate($input, $numWords) {
    if (str_word_count($input, 0) > $numWords) {
        $WordKey = str_word_count($input, 1);
        $WordIndex = array_flip(str_word_count($input, 2));
        return substr($input, 0, $WordIndex[$WordKey[$numWords]]);
    } else {
        return $input;
    }
}

function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
    $file = $path . $filename;
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $header = "From: " . $from_name . " <" . $from_mail . ">\r\n";
    $header .= "Reply-To: " . $replyto . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message . "\r\n\r\n";
    $header .= "--" . $uid . "\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"\r\n"; // use different content types here
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
    $header .= $content . "\r\n\r\n";
    $header .= "--" . $uid . "--";
    if (mail($mailto, $subject, "", $header)) {
        echo ""; // or use booleans here
    } else {
        echo "mail send ... ERROR!";
    }
}


function userAgent($ua) {
    $iphone = strstr(strtolower($ua), 'mobile'); //Search for 'mobile' in user-agent (iPhone have that)
    $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
    $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)

    function androidTablet($ua) { //Find out if it is a tablet
        if (strstr(strtolower($ua), 'android')) {//Search for android in user-agent
            if (!strstr(strtolower($ua), 'mobile')) { //If there is no ''mobile' in user-agent (Android have that on their phones, but not tablets)
                return true;
            }
        }
    }

    $androidTablet = androidTablet($ua); //Do androidTablet function
    $ipad = strstr(strtolower($ua), 'ipad'); //Search for iPad in user-agent
    $kindle = strstr(strtolower($ua), 'kindle'); //Search for iPad in user-agent

    if ($androidTablet || $ipad || $kindle) { //If it's a tablet (iPad / Android / Kindly)
        return 'Tablet';
    } elseif ($iphone || $android || $windowsPhone) { //If it's a phone and NOT a tablet
        return 'Mobile';
    } else { //If it's not a mobile device
        return 'Desktop';
    }
}

function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

function GetDay($difference) {
    if ($difference == 0) {
        return 'Today';
    } else if ($difference > 1) {
        return 'Future Date';
    } else if ($difference > 0) {
        return 'Tomorrow';
    } else if ($difference < -1) {
        return 'Long Back';
    } else {
        return 'Yesterday';
    }
}
?>
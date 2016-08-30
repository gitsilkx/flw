<?php
include("configs/path.php");
include("getProducts.php");

if(isset($_POST['submit'])){
    $is_live = $_POST['is_live'];
    mysql_query("UPDATE " . TABLE_PERMISSION." SET `is_live`='".$is_live."' WHERE id=1");    
}
//echo "SELECT * FROM ". TABLE_PERMISSION ." WHERE id=1";
$result = mysql_query("SELECT * FROM permission WHERE id=1");
$row = mysql_fetch_object($result);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--<html lang="en">-->
    <head>
        <meta name="robots" content="noindex,nofollow" />
        <link rel="stylesheet" href="<?= $vpath ?>bootstrap/css/bootstrap.min.css">
            <!-- ebro styles -->
            <link rel="stylesheet" href="<?= $vpath ?>css/flower.css">
                </head>
                <body>
                    <form name="agent_ip" method="post">
                        <div id="main_content">

                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Is Live?</h4>
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name">&nbsp;</label>                                    
                                        <div class="col-sm-10">
                                            <input name="is_live" type="radio" value="Y" <?php if($row->is_live == 'Y'){?> checked="checked"<?php }?>>Yes
                                            <input name="is_live" type="radio" value="N" <?php if($row->is_live == 'N'){?> checked="checked"<?php }?>>No                                              
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <input type="submit" name="submit" value="Update" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>                       
                            </div>
                        </div>
                    </form>
                </body>
            </html>

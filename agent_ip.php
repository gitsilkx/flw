<?php
include("configs/path.php");
include("getProducts.php");

if(isset($_POST['submit'])){
    $agent_ip = $_POST['agent_ip'];
    mysql_query("INSERT INTO " . TABLE_AGENT_IP." (`agent_ip`) VALUES ('".$agent_ip."')");    
}
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
                                        <h4 class="panel-title">Agent IP</h4>
                                    </div>
                                    <div class="form-group">
                                        <label for="reg_input_name">&nbsp;</label>                                    
                                        <div class="col-sm-10">
                                            <input type="text" name="agent_ip" class ="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <input type="submit" name="submit" value="Add" class="btn btn-success sticky_success">

                                        </div>

                                    </div>
                                </div>


                                <table border="0" cellpadding="0" cellspacing="0" id="resp_table" class="table toggle-square myclitb" data-filter="#table_search" data-page-size="100">

                                    <tr>       
                                        <th data-toggle="true">Agent Id</th>
                                        <th data-toggle="phone">Agent IP</th>
                                    </tr>
                                    <?php
                                    $result = mysql_query("SELECT * FROM " . TABLE_AGENT_IP); // step3
                                    $cnt = mysql_num_rows($result);
                                    if ($cnt > 0):
                                        while ($row = mysql_fetch_array($result)) {
                                            ?>
                                            <tr>       
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['agent_ip']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        mysql_free_result($result);
                                    endif;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </form>
                </body>
                </html>

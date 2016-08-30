<?php
include("configs/path.php");
include("getProducts.php");

if(isset($_REQUEST['orderNo'])){

$strOrerNumber = $_REQUEST['orderNo'];
$strIssue = mysql_escape_string(trim($_REQUEST['description']));
$ins->createCustomerServiceTicket(API_USER ,API_PASSWORD ,$strOrerNumber,$strIssue);//return value stored in $this->arrTickets
if($ins->arrTickets['TicketNum'])
    echo 'Ticket No. Is='.$ins->arrTickets['TicketNum'];
else    
    echo 'Input Error!!!';
die;
}
?>
<div class="supportTicket"> 
    <h3 class="headingText">Customer Support Ticket</h3>
    <form action="<?php echo $vpath?>createCustomerServiceTicket.php" method="post" id="ticket">
        <div class="row">
            
            <div class="col-sm-6">
                <div class="form_sep">
                    <label class="req">Name : </label>
                    <input name="name" type="text" class="form-control" data-required="true" />
                </div>
                <div class="form_sep">
                    <label class="req">Phone: </label>
                    <input name="phone" type="text" maxlength="20" class="form-control" data-required="true">
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="form_sep">
                    <label class="req">Email : </label>
                    <input name="email" type="text" class="form-control" data-required="true" />
                </div>
<div class="form_sep">
                    <label class="req">Order No : </label>
                    <input name="orderNo" type="text" class="form-control" data-required="true" />
                </div>
                
                
            </div>
            
            <div class="col-sm-12">
       				<div class="form_sep">
                    <label class="req">Subject : </label>
                    <input name="subject" type="text" class="form-control3" data-required="true" />
                </div>
            </div>
            <div class="col-sm-12">
       				<div class="form_sep">
                    <label class="req">Description: </label>
                    <textarea  class="form-control2" name="description"></textarea>
                    <input type="submit" name="submit" value="submit" class="login_btn2"  />
                </div>
            </div>
            
            
            
            
            
            
        </div>
    </form>
</div>

<script type="text/javascript">
    var frm = $('#ticket');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (html) {
                //console.log(data);
                var r = confirm(html);
                if (r == true) {
                    location.reload(); 
                } 
            },
                        
        });
        ev.preventDefault();
    });
</script>
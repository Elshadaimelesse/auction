<?php include 'admin/db_connect.php' ?>
<?php
session_start();
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM products where id= ".$_GET['id']);
$_SESSION['product_id'] = $_GET['id'];

foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
$cat_qry = $conn->query("SELECT * FROM categories where id = $category_id");
$category = $cat_qry->num_rows > 0 ? $cat_qry->fetch_array()['name'] : '' ;
}
$_SESSION['pro_form_amount'] = $price_for_form;
?>
<style type="text/css">
    #bid-frm{
        display: none
    }
    .warn{
        color: red;
    }
    .d{
        background: gray;
        color: white;
    }
    .wk{
        width: 30%;
        margin-left: 35%;
    }
    .t{
        margin-left: 0px;
    }
</style>
<div class="container-fluid wh">
    <div class="payment_frm">
    <img src="images/logo.png" class="d-flex wk" alt="Logo">
    <h5 class="text-center">Payment For Bid Form</h5>
    <p >First you have to make a payment to get the bid-form by using <b>Mobile-Banking</b> or by <b>Tele-Birr</b> then after fill the form below with a correct information!</p>
    <h5 class="text-center" style="color: green">Name: <?php echo $name ?></h5>
    <b>Account Number: </b><p class="form-control"><b> 001122334455</b></p>
    <p class="form-control">Price For Form: <?php echo $price_for_form ?></p>
    

    <div class="col-md-12"> 
        <form id="manage-payment" method="POST">
                <input type="hidden" name="transaction_id" value="<?php echo $id ?>">
        <div class="form-group">
                    <label for="" class="control-label">Transaction ID</label>
                    <input type="text" class="form-control text-right" name="transaction_id" required="">
                    <small class="warn">Remember! One form payment is only for one bid!</small>
        </div>
        <div class="form-group">
                    <label for="" class="control-label">Payment Reason</label>
                    <input type="text" class="form-control text-right" name="reason" required="">
        </div>
<button class="btn btn-primary btn-block btn-sm ">Submit</button>
    </form>
    </div>   
    </div>
   <!-- ########## check the payment -->
    <div id="bid-frm">
        <div class="float-right align-top bid-tag">
    <span class="badge badge-pill badge-secondary text-white"><i class="fa fa-calendar-times"></i> DATE: <?php echo strtolower((date('F j, Y'))); ?></span>
    </div>
    <img src="auctioneer/assets/uploads/<?php echo $img_fname ?>" class="d-flex w-100" alt="">
    <p><large> Auction Title:- <?php echo $category ?></large></p>
    <p>Our Organization Needs to buy a property <b><?php echo $name ?></b></p>
    <p class=""><?php echo $description ?></p>
    <p>This Auction is avalable every where through this website Until: <b><?php echo date("m d,Y h:i A",strtotime($bid_end_datetime)) ?></b></p>
       
        <div class="col-md-12">
            <form id="manage-bid">
                <input type="hidden" name="product_id" value="<?php echo $id ?>">
                
                <div class="form-group">
                    <label for="" class="control-label">Bid Amount</label>
                    <input type="number" class="form-control text-right" name="bid_amount" required="">
                </div>
                
                <div class="row justify-content-between">
                    
                    <button class="btn col-sm-5 btn-primary btn-block btn-sm mr-2">Submit</button>
                    
                    <button class="btn col-sm-5 btn-secondary mt-0 btn-block btn-sm" type="button" id="cancel_bid">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#imagesCarousel img,#banner img').click(function(){
        viewer_modal($(this).attr('src'))
    })
    $('#participate').click(function(){
        _conf("Are you sure to commit that you will participate to this event?","participate",[<?php echo $id ?>],'mid-large')
    })
    var _updateBid = setInterval(function(){
        $.ajax({
            url:'admin/ajax.php?action=get_latest_bid',
            method:'POST',
            data:{product_id:'<?php echo $id ?>'},
            success:function(resp){
                if(resp && resp > 0){
                    $('#hbid').text(parseFloat(resp).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
                }
            }
        })
    },1000)
// ########---bid form payment

    $('#manage-payment').submit(function(e){
        e.preventDefault()
        start_load()
        if($(this).find('.alert-danger').length > 0 )
            $(this).find('.alert-danger').remove();
            $.ajax({
                url:'admin/ajax.php?action=check_payment',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                     if(resp==1){
                        alert_toast("your payment registration is in process. please try again later!",'warning')
                        end_load()
                    }
                     
                    else if(resp==3){
                        alert_toast("Not registered!",'danger')
                        end_load()
                    }
                   else if(resp==4){
                        alert_toast("Please wight Until the payment is verified by auctioneers!",'warning')
                        end_load()
                    }
                   else if(resp==5){
                        alert_toast("your payment can not fully cover the bid price. please contact us!",'danger')
                        end_load()
                    }
                    
                    else if(resp==6){
                        alert_toast("Payment Success!",'success')
                       end_load()
                   $('.payment_frm').hide()
                        $('#bid-frm').show()
                    }
                  else if(resp==7){
                        alert_toast("you may have used an Exipered payment!",'warning')
                        end_load()
                    }
                   else if(resp==8){
                        alert_toast("This payment belongs to another bid-form!",'warning')
                        end_load()
                    }
                     else if(resp==0){
                        alert_toast("empity bidder id!",'warning')
                        end_load()
                    }
                    else{
                        alert_toast("Requesting the payment!",'success')
                        end_load()
                    }
                }
            })
        })
// ##########--end of form payment    
    $('#manage-bid').submit(function(e){
        e.preventDefault()
            start_load()
            var latest = $('#hbid').text()
            latest = latest.replace(/,/g,'')
            // if(parseFloat(latest)  < $('[name="bid_amount"]').val()){
            //     alert_toast("Bid amount must be less than the Estimation Bid.",'danger')
            //     end_load()
            //     return false;
            // }
            $.ajax({
                url:'admin/ajax.php?action=save_bid',
                method:'POST',
                data:$(this).serialize(),
                success:function(resp){
                    if(resp==1){
                        alert_toast("Bid successfully submited",'success')
                         setTimeout(function(){
                        location.reload()
                    },1000)
                    }else if(resp==2){
                        alert_toast("You have a Bid already!",'danger')
                        end_load()
                    }
                    else if(resp==0){
                        alert_toast("error on expiredation of payment!",'danger')
                        setTimeout(function(){
                        location.reload()
                    },1000)
                    }
                }
            })
        })
    // $('#bid').click(function(){
    //     if('<?php //echo isset($_SESSION['login_id']) ? 1 : '' ?>' != 1){
    //         $('.modal').modal('hide')
    //          uni_modal("LOGIN",'login.php')
    //          return false;
    //     }
    //     $('.payment_frm').hide()
    //     $('#bid-frm').show()
    // })
    $('#cancel_bid').click(function(){
        $('.payment_frm').show()
        $('#bid-frm').hide()
    })
</script>

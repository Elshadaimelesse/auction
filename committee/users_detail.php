<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM users where id= $id");
    $data = $qry->fetch_assoc(); // Use fetch_assoc() to fetch associative array
    foreach($data as $k => $val){
        $$k=$val;
    }
}
?>
<style type="text/css">
    .avatar {
        max-width: calc(100%);
        max-height: 27vh;
        align-items: center;
        justify-content: center;
        padding: 5px;
    }
    .avatar img {
        max-width: calc(100%);
        max-height: 27vh;
    }
    p{
        margin: unset;
        text-align: center; /* Center aligning the content */
    }
    #uni_modal .modal-footer{
        display: none
    }
    #uni_modal .modal-footer.display{
        display: block
    }
</style>
<?php 
$type = "";
if ($status == 1) {
    $type = "Accepted by the Technical Committees";
}
elseif ($status == 2) {
    $type = "Rejected by Technical Committees";
}
else{
    $type = "New registered bidder";
}
?>
<div class="container-field">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class="avatar">
                    <?php 
                    if(!empty($photo)) { // Check if photo field is not empty
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($photo).'" alt="User Photo">'; // Display the image
                    } else {
                        echo 'No photo available';
                    }
                    ?>
                </div>
                <p>Full Name: <b><?php echo $name." ".$lname ?></b> &nbsp;UserName: <b><?php echo $username ?></b></p>
                <p>Gender: <b><?php echo $gender ?></b></p>
                <p>Age: <b><?php echo $age ?></b></p>
                <p>Contact: <b><?php echo $contact ?></b></p>
                <p>Email: <b><?php echo $email ?></b></p>
                <p>Address: <b><?php echo $address ?></b></p>
                <p>User Type: <b><?php echo $type ?></b></p>
                <p>Registration Date: <b><?php echo $data_created ?></b></p>
                <p>Tax Payment ID: <b><?php echo $TIN_number ?></b></p>
                
                <p>image : <b><?php echo $photo ?></b></p>
                
            </div>
        </div>
    </div>
</div>
<div class="modal-footer display">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<script>
    
</script>

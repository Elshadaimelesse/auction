<?php include '../admin/db_connect.php' ?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM users where id= $id");
    $data = $qry->fetch_assoc();
    foreach($data as $k => $val){
        $$k=$val;
    }
}
?>
<style type="text/css">
    .avatar-container {
        max-width: 100%;
        max-height: 27vh;
        align-items: center;
        justify-content: center;
        padding: 5px;
    }
    .avatar-container img {
        max-width: 100%;
        max-height: 27vh;
    }
    .user-info {
        text-align: center;
        margin-top: 20px;
    }
    .user-info p {
        margin: unset;
    }
    #uni_modal .modal-footer{
        display: none;
    }
    #uni_modal .modal-footer.display{
        display: block;
    }
</style>
<?php 
$userType = "";
if ($status == 1) {
    $userType = "Accepted by the Technical Committees";
} elseif ($status == 2) {
    $userType = "Rejected by Technical Committees";
} else {
    $userType = "New registered bidder";
}
?>
<div class="container-field">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class="avatar-container">
                    <?php 
                    if(!empty($photo)) { 
                        if (file_exists('../admin/'.$photo)) {
                            echo '<img src="../admin/'.$photo.'" alt="User Photo">'; 
                        } else {
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($photo).'" alt="User Photo">'; 
                        }
                    } else {
                        echo 'No photo available';
                    }
                    ?>
                </div>
                <div class="user-info">
                    <p>Full Name: <b><?php echo $name." ".$lname ?></b> &nbsp;UserName: <b><?php echo $username ?></b></p>
                    <p>Gender: <b><?php echo $gender ?></b></p>
                    <p>Age: <b><?php echo $age ?></b></p>
                    <p>Contact: <b><?php echo $contact ?></b></p>
                    <p>Email: <b><?php echo $email ?></b></p>
                    <p>Address: <b><?php echo $address ?></b></p>
                    <p>User Type: <b><?php echo $userType ?></b></p>
                    <p>Registration Date: <b><?php echo $data_created ?></b></p>
                    <p>Tax Payment ID: <b><?php echo $TIN_number ?></b></p>
                    <p>Image: <b><?php echo $photo ?></b></p>
                </div>
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

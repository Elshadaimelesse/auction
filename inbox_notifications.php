 <!-- Masthead-->

       <?php include('admin/db_connect.php');

       if (isset($_SESSION['login_id'])) {
       ?>
<div class="container-fluid d-flex h">
	<div class="col-lg-3">
		<br>
	<a href="bidder.php" class="text-start"><b><img src="images/Backspace.png" style="width: 50px; height: 50px;"> BACK To HOME</b></a>	
    <ul class='list-group ' id='opp-list'>
        <a href="index.php?page=write_notifications" class='list-group-item list-write_notifications list' id="sids"> Write New</a>
        <a href="index.php?page=inbox_notifications" class='list-group-item list-inbox_notifications list' id="sids" >Inbox</a>
        <a href="index.php?page=sent_notification" class='list-group-item list-sent_notification list' id="sids">Sent</a>
    </ul> 
	</div>
     
    <?php
$bidder_id = $_SESSION['login_id'];
     ?>
    <div class="col-lg-9">
        
        <div class="row">
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-12">
            	<br>
              <h5 class="text-center">Notification Center</h5>
              <br>
                <div class="card">
                    <div class="card-header">
                        <b>Your Inbox</b>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <?php
                   $users = $conn->query("SELECT * FROM comment where reciver_id =$bidder_id  order by 'id' asc");
                    while($row= $users->fetch_assoc()){

                        $get = $conn->query("SELECT * FROM users where id =".$row['sender_id']."  order by 'date' asc limit 1");
                        $uname = $get->num_rows > 0 ? $get->fetch_array()['name'] : '' ;
                 ?>
                 
                        <a style ="<?php if($row['status']=='unread'){ echo "font-weight:bold; font-size: 20px;"; } ?>" class="dropdown-item view_detail" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>
                            <small><i><?php echo date('F j, Y, g:i a',strtotime($row['date'])) ?></i></small><br>
                            <?php echo $row['title'] ; ?><br>
                           <small> <i><?php echo 'From:- '.$uname ?></i></small><hr>
                    </a>
                <?php }  

$d = date('g:i a',strtotime($row['date']));
                ?>
                             
<!--                     <small><i><?php #echo date('F j, Y, g:i a',strtotime($i['date'])) ?></i></small><br/>  
 -->                             
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>  

</div>
<?php } ?>
<style>
    .h{
        min-height: 400px;
    }
    td{
        vertical-align: middle !important;
    }
    td p{
        margin: unset
    }
    img{
        max-width:100px;
        max-height: :150px;
    }
</style>
<style>
#sids{
  margin-bottom: 5px;
}
.a {
    margin-bottom: 15px;
    font-family: 'Arial';
}
.mid_1 {
    margin-left: 20%;
    font-family: "Algerian";
    margin-top: 20px;
}
.mid_2 {
    margin-left: 40%;
    font-family: "Algerian";
    margin-top: 10px;
}
.mid_1 h3 {
    font-family: "Times New Roman";
    text-decoration: none;
    margin-top: 20px;
    font-style: italic;
}
#w {
    font-weight: bold;
}
#im1 {
    width: 100px;
    margin-left: 5%;
}
.row0 {
    padding-top: 25px;
    background: #f1f1f1;
    padding-bottom: 10px;
    margin-bottom: 20px;
    box-shadow: 0 0 5px black; 
    border-radius: 3px;
}
.row00 {
    background: #f1f1f1;
    margin: 10px;
    box-shadow: 0 0 5px black; 
    border-radius: 5px;
    width: 100%;
}
.row1 {
    margin-left: 10px;
}
.row2 {
    text-align: center;
    margin-top: 10px;
    padding-left: 10px;
    color: #1C2B5C;
    font-family: "Algerian";
} 
 .row4 {
    text-align: center;
    color: #1C2B5C;
    font-style: italic;
    font-family: "Algerian";
}   
 #opp-list a:hover {
        color: white;
        background: #007bff8f;
        text-decoration: none;
    }
    .list--active{
       background: gray;
        color: #000;
        text-align: left;
        transition: background 0.2s;
      }
</style>
<script>
    $(document).ready(function(){
        $('table').dataTable()
    })
    
    $('#new_book').click(function(){
        uni_modal("New Book","manage_booking.php","mid-large")
        
    })
    $('.edit_book').click(function(){
        uni_modal("Manage Book Details","manage_booking.php?id="+$(this).attr('data-id'),"mid-large")
        
    })
    $('.delete_book').click(function(){
        _conf("Are you sure to delete this book?","delete_book",[$(this).attr('data-id')])
    })
    
    function delete_book($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_book',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully deleted",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)

                }
            }
        })
    }

$('.view_detail').click(function(){
    uni_modal("<small><i><?php echo 'at: - '.$d ?></i></small>",'view_comment_detail.php?id='+$(this).attr('data-id'))
})
    $('.list-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>

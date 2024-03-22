<?php 
if (isset($_SESSION['login_id'])) {
	$uid = $_SESSION['login_id'];
?>
 
<div class="container-fluid" style="position: relative;">
	<br>
	
	<div class="row">
		<!-- <div class="col-md-12">
			<h4 class="text-center H">YOUR PAYMENT</h4><br>
		</div> -->

		<div class="col-lg-3">
	<a href="bidder.php" class="text-start"><b><img src="images/Backspace.png" style="width: 50px; "> BACK To HOME</b></a>	
	</div>
		<div class="card col-lg-9">
			<div class="card-body">
				<h1 class="text-center text-muted">YOUR PAYMENT HISTORY HERE</h1>
				<br>
				<?php
 					include 'admin/db_connect.php';
 					$payments = $conn->query("SELECT * FROM payment where bidder_id = '$uid' order by date_payed desc");
 					$i = 1;
 					if($payments->num_rows <= 0){
                                    echo "<center><h4><i>No Available Payment.</i></h4></center>";
                        }
                        else{
 					?>
				<table class="table-striped table-bordered col-md-12 tt">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Transaction ID</th>
					<th class="text-center">Reason</th>
<!-- 					<th class="text-center">Amount</th>
 -->					<th class="text-center">Payment Status</th>
 						<th class="text-center">Price You Paid</th>
 					<th class="text-center">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
 					while($row= $payments->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
				 		<?php echo $i++ ?>
				 	</td>
				 	<td><!--ucwords()-->
				 		<?php echo $row['transaction_id'] ?>
				 	</td>
				 	
				 	<td>
				 		<?php echo ucwords($row['reason']) ?>
				 	</td>
				 	<td>
				 		<?php if($row['status'] == 0){ 
				 		?>
				 		<span class="badge badge-secondary">In Process Payment</span>
				 	<?php }
				 		elseif($row['status'] == 1){ 
				 		?>
							<span class="badge badge-primary">Active Now!</span>
				 		<?php }
				 		 
				 		 else{ ?>
				 		 	<span class="badge badge-danger">Expired</span>
				 		 	<?php } ?>

				 	</td>
				 	<td>
				 		<?php echo $row['amount'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['date_payed'] ?>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	<?php } ?>
			</div>
		</div>
	</div>

</div>
<?php exit; } ?>
<script>
	$('table').dataTable();
</script>
<style>
	.tt{
		margin-bottom: 20%;
	}
</style>
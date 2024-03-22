
<style>
	.collapse a{
		text-indent:10px;
	}
</style>
<?php
include 'db_connect.php';
//$payments = $conn->query("SELECT * FROM payment where status = 0 ");
 				//	$count = 0;
 				//	while($row= $payments->fetch_assoc()):
 				////		$count++;
 				//		<?php endwhile; ?>
<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=categories" class="nav-item nav-categories"><span class='icon-field'><i class="fa fa-list"></i></span> Categories</a>
				<a href="index.php?page=products" class="nav-item nav-products"><span class='icon-field'><i class="fa fa-th-list"></i></span> Auctions</a>
				<a href="index.php?page=bids" class="nav-item nav-bids"> ▓ Bids</a>
			<a class="nav-item nav-active_payment nav-requested_payment nav-expired_payments" id="btn1"><span class='icon-field' id="btn1"><i class="fa fa-money-bill-alt"></i> Payments&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sp"> <small></>new <?php //echo $count ?></small>&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;▼</a>
					<ul id="list">
						<a href="index.php?page=requested_payment" class="nav-item nav-requested_payment a">New Requisted </>&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $count ?></a>
						<a href="index.php?page=active_payment" class="nav-item nav-active_payment a">Active Payments</a>
						<a href="index.php?page=expired_payments" class="nav-item nav-expired_payments a">Expired Payments</a>
					</ul>
				<a href="index.php?page=winers" class="nav-item nav-winers"><span class='icon-field'><i class="fa fa-users"></i></span> winners</a>
				<a href="index.php?page=feedback" class="nav-item nav-feedback">Feedback</a>
		</div>

</nav>
<style>
	.a{

		margin-right: 10px;
		margin-top: 5px;
	}
	#btn1{
		cursor: pointer;
	}
	.sp{
		background:rgba(252, 253, 253, 0.527);
	}
	
</style>
<script>
	const button = document.getElementById("btn1");
	const list = document.getElementById("list");
	list.style.display = "none";
	button.addEventListener("click", (event)=> {
		if (list.style.display == "none") {
			list.style.display = "block";
		} else {
			list.style.display = "none";
		}
	})
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>

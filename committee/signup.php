<?php session_start() ?>
<script src="sweetalert.min.js"></script>
<div class="container-fluid">
	<form action="" id="signup-frm" enctype="multipart/form-data">



<div class="form-group">
	<input type="text" name="name" class="form-control" required="" placeholder="First Name">
</div>
<div class="form-group">
	<input type="text" name="lname" class="form-control" required="" placeholder="Last Name">
</div>
<div class="form-group">
	<textarea cols="20" rows="2" name="address" required="" class="form-control" placeholder="Address"></textarea>
</div>
<div class="form-group">
	<input type="text" name="username" class="form-control" value="" placeholder="User Name">
</div>

		<div class="d-flex justify-content-center">
			<div class="p-1 col-6">
				<div class="select">
                    <select name="gender" class="form-select form-control" required="">
                    <option value="" selected="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Femal">Femal</option>
                    </select>
                </div> 
			</div >
			<div class="p-1 col-6">
				<input type="Number" min="18" name="age" class="form-control" placeholder="Age" required="">
			</div>
		</div>	

	
		<div class="d-flex justify-content-start">
			<div class="p-1 col-6">
				<input type="text" name="contact" class="form-control" value="" placeholder="Phone Number" required="">
			</div>
			<div class="p-1 col-6">
				 <input type="email" name="email" class="form-control" value="" placeholder="@Email" required="">
			</div>
		</div>	
			
		<div class="d-flex justify-content-start">
			<div class="p-1 col-6">
				<input type="password" name="password" class="form-control" placeholder="password" required="">
			</div>
			<div class="p-1 justify-content-start">
				<input type="password" name="con-password" class="form-control" placeholder="confirm password" required="">
			</div>
		</div>
		<div class="form-group">
				<input type="text" name="TIN" class="form-control" placeholder="Taxpayment ID (TIN)" required="">
		</div>

		<div class="justify-content-start">
			<div class="p-1 col-4">
				<!--<input type="file"  accept="image/*" name="image" id="file" onchange="loadFile(event)" required="" />-->
				<input type="file" class="form-control" name="img" onchange="displayImg2(this,$(this))">
			</div>
			<div class="p-1 col-6">
				<img src="<?php echo isset($photo) ? 'photos/'.$photo :'' ?>" alt="" id="img_path-field">
			</div>
		</div>
		<button class="button btn btn-primary btn-sm">Create</button>
		<button class="button btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>

	</form>
</div>
<style>
	#uni_modal .modal-footer{
		display:none;
	}
	.row {
		justify-content: start;
	}
	img#img_path-field{
		max-height: 15vh;
		max-width: 8vw;
	}
</style>
<script>
	$('#signup-frm').submit(function(e){
		e.preventDefault()
		start_load()
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=signup',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');

			},
			success:function(resp){
				if(resp == 2){
					$('#signup-frm').prepend('<div class="alert alert-danger">username already exist.</div>')
					end_load()
					
				}
				else if (resp == 0) {
					$('#signup-frm').prepend('<div class="alert alert-danger">Password Did not match!</div>')
					end_load()
				}
				else{
					alert_toast("Registered! please login.",'success')
					setTimeout(function(){
						location.reload()
					},3000)
				}
			}
		})
	})
	function displayImg2(input,_this) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	$('#img_path-field').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
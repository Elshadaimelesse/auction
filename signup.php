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
            </div>
            <div class="p-1 col-6">
                <input type="number" min="18" name="age" class="form-control" placeholder="Age" required="">
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
				<img src="<?php echo isset($photo) ? 'pho/'.$photo :'' ?>" alt="" id="img_path-field">
			</div>
		</div>
        <div> <a href="javascript:void(0)" id="login"> ◄ Back to login</a></div>
       
        <button class="button btn btn-primary btn-sm">Create</button>
        <button class="button btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
    </form>
</div>
<style>
    #uni_modal .modal-footer {
        display: none;
    }
    .row {
        justify-content: start;
    }
    img#img_preview {
        max-height: 150px;
        max-width: 150px;
    }
</style>
<script>
    $('#login').click(function () {
        uni_modal("Login", 'login.php?redirect=index.php?page=checkout')
    })

    $('#signup-frm').submit(function (e) {
        e.preventDefault()
        start_load()
        if ($(this).find('.alert-danger').length > 0)
            $(this).find('.alert-danger').remove();
        $.ajax({
            url: 'admin/ajax.php?action=signup',
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            error: err => {
                console.log(err)
                $('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');
            },
            success: function (resp) {
                if (resp == 0) {
                    $('#signup-frm').prepend('<div class="alert alert-danger">username already exists.</div>')
                    end_load()
                } else if (resp == 1) {
                    $('#signup-frm').prepend('<div class="alert alert-danger">The contact number already exists.</div>')
                    end_load()
                } else if (resp == 2) {
                    $('#signup-frm').prepend('<div class="alert alert-danger">TIN Number is already taken.</div>')
                    end_load()
                } else if (resp == 3) {
                    $('#signup-frm').prepend('<div class="alert alert-danger">Please make your password strong.</div>')
                    end_load()
                } else if (resp == 10) {
                    $('#signup-frm').prepend('<div class="alert alert-danger">Passwords did not match!</div>')
                    end_load()
                } else {
                    alert_toast("Registered! Please login.", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 3000)
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
<?php


// Directory where images will be stored
$imageDirectory = "/uploads";

// Create the directory if it doesn't exist
if (!file_exists($imageDirectory)) {
    mkdir($imageDirectory, 0777, true);
}

// Handle form submission
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'signup') {
    // Your existing form handling code here
    
    // Example code for handling image upload
    if (isset($_FILES['img'])) {
        // Debugging: Inspect $_FILES array
        echo '<pre>';
        var_dump($_FILES);
        echo '</pre>';

        // Directory where images will be stored
        $imageDirectory = "/uploads";

        // Create the directory if it doesn't exist
        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0777, true);
        }

        $target_dir = $imageDirectory;
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["img"]["size"] > 500000) {
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            // File upload failed
            echo "Sorry, your file was not uploaded.";
        } else {
            // File upload successful, move uploaded file to target directory
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                // File uploaded successfully
                // You can save the file path to your database or do any other necessary processing
                echo "The file ". htmlspecialchars( basename( $_FILES["img"]["name"])). " has been uploaded.";
            } else {
                // File upload failed
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Rest of your form handling code
}

?>


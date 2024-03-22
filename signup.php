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
        <div class="form-group">
            <input type="file" name="photo" class="form-control-file" accept="image/*" id="photo" onchange="previewImage(this)">
            <img id="image_preview" src="#" alt="Preview" style="display: none; max-width: 150px; max-height: 150px;">
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

    function previewImage(input) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image_preview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
</script>

<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if photo is uploaded
    if (isset($_FILES['photo'])) {
        // Directory for storing images
        $dir = 'uploads/';

        // Check if the directory exists, if not create it
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        // File properties
        $file_name = $_FILES['photo']['name'];
        $file_size = $_FILES['photo']['size'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_type = $_FILES['photo']['type'];
        $target_file = $dir . basename($file_name);

        // Check file size
        if ($file_size > 500000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Allow certain file formats
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG, GIF files are allowed.";
            exit;
        }

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Insert photo file name into the database
            // You should use prepared statements to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO your_table_name (photo) VALUES (?)");
            $stmt->execute([$file_name]);

            echo "Photo inserted successfully.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    } else {
        echo "No photo uploaded.";
        exit;
    }
}
?>

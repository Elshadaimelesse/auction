<?php
session_start();

// Include database connection or any necessary files
// Include database configuration
include_once 'db_connect.php'; // Assuming you have a file named db_connect.php for database connection

// Assuming 'users' table contains a column named 'photo' to store the image filename

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'signup') {
    // Your existing signup logic goes here

    // Handle file upload
    $target_dir = "uploads/"; // Specify the target directory where you want to store the images
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["img"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            // Update the database with the filename
            $photo = basename($_FILES["img"]["name"]); // Assuming your database field name is 'photo'
            // Update the user record in the database with $photo variable
            // Example query: UPDATE users SET photo = '$photo' WHERE id = $user_id;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

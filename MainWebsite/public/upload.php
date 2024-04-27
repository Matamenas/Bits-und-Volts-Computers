// Check if file is uploaded
if(isset($_FILES['upload'])) {
    $targetDir = "uploads/profile/";
    $targetFile = $targetDir . basename($_FILES["upload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["upload"]["tmp_name"]);
    if ($check === false) {
        echo "<p class='error'>File is not an image.</p>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["upload"]["size"] > 500000) {
        echo "<p class='error'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<p class='error'>Sorry, your file was not uploaded.</p>";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFile)) {
            echo "<p>The file ". htmlspecialchars(basename( $_FILES["upload"]["name"])). " has been uploaded.</p>";
        } else {
            echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
        }
    }
}

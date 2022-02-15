    <?php

    //require "model/postFunction.php";
    
    $reponse = "";
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);


    switch ($action) {
        case 'publish':
            $target_dir = "uploaded/"; // specifies the directory where the file is going to be placed
            $target_file = $target_dir . basename($_FILES["filesToUpload"]["name"]);
            $uploadOk = 1;
            $filesToUploadType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            if (isset($_POST["publish"])) {
                $check = getimagesize($_FILES["filesToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $reponse .= "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    $reponse .= "File is not an image.";
                    $uploadOk = 0;
                }
            }
            
            // Check if file already exists
            if (file_exists($target_file)) {
                $reponse .= "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["filesToUpload"]["size"] > 3000000) {
                $reponse .= "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($filesToUploadType != "jpg" && $filesToUploadType != "png" && $filesToUploadType != "jpeg" && $filesToUploadType != "gif") {
                $reponse .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $reponse .= "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
               // createPost($commentaire, date("Y-m-d H:i:s"));
                //createMedia($filesToUploadType, $_FILES["filesToUpload"]["name"], date("Y-m-d H:i:s"));

                if (move_uploaded_file($_FILES["filesToUpload"]["tmp_name"], $target_file)) {
                    $reponse .= "The file " . htmlspecialchars(basename($_FILES["filesToUpload"]["name"])) . " has been uploaded.";
                } else {
                    $reponse .= "Sorry, there was an error uploading your file.";
                }
            }
            break;
    }

    require "vue/header.php";

    require "vue/post.php";

    require "vue/footer.php";

    var_dump($_FILES);



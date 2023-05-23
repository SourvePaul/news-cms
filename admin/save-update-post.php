<?php 

include "config.php";

if(empty($_FILES['new_image']['name'])) {
    $file_name = $_POST['old_image'];
} else {
    $errors = array();

  $file_name = $_FILES['fileToUpload']['name'];
  $file_size = $_FILES['fileToUpload']['size'];
  $file_tmp = $_FILES['fileToUpload']['tmp_name'];
  $file_type = $_FILES['fileToUpload']['type'];
  $file_ext = explode('.', $file_name);
  $file_ext = end($file_ext);

  $extensions = array("jpeg", "jpg", "png");

  if (!in_array($file_ext, $extensions)) {
    $errors[] = "Please choose a JPG or PNG file.";
  }

  if ($file_size > 5242880) {
    $errors[] = "File size must be 5mb or lower.";
  }

  if (empty($errors)) {
    move_uploaded_file($file_tmp,"upload/".$file_name);
  } else {
    print_r($errors);
    die();
  }
}

?>
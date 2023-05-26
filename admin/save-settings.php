<?php 

include "config.php";

if(empty($_FILES['logo']['name'])) {
    $file_name = $_POST['old_logo'];
} else {
    $errors = array();

  $file_name = $_FILES['logo']['name'];
  $file_size = $_FILES['logo']['size'];
  $file_tmp = $_FILES['logo']['tmp_name'];
  $file_type = $_FILES['logo']['type'];
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
    move_uploaded_file($file_tmp,"images/".$file_name);
  } else {
    print_r($errors);
    die();
  }
}

    $sql2 = "UPDATE settings SET websitename = '{$_POST['website_name']}', logo = '{$file_name}', footerdesc = {$_POST['footer_desc']}";
    $result2 = mysqli_query($conn, $sql2) or die("query failed from save-setting!..");
    
    if($result2) {
        header("Location: {$hostname}/admin/setting.php");
    }

?>
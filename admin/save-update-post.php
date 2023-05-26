<?php 

include "config.php";

if(empty($_FILES['new-image']['name'])) {
    $new_name = $_POST['old-image'];
} else {
    $errors = array();

  $file_name = $_FILES['new-image']['name'];
  $file_size = $_FILES['new-image']['size'];
  $file_tmp = $_FILES['new-image']['tmp_name'];
  $file_type = $_FILES['new-image']['type'];
  $file_ext = explode('.', $file_name);
  $file_ext = end($file_ext);

  $extensions = array("jpeg", "jpg", "png");

  if (!in_array($file_ext, $extensions)) {
    $errors[] = "Please choose a JPG or PNG file.";
  }

  if ($file_size > 5242880) {
    $errors[] = "File size must be 5mb or lower.";
  }

  $new_name = rand() . "_" . basename($file_name);
  $target = "upload/" . $new_name;
  $image_name = $new_name;

  if (empty($errors)) {
    move_uploaded_file($file_tmp, $target);
  } else {
    print_r($errors);
    die();
  }
}

    $sql2 = "UPDATE post SET title = '{$_POST['post_title']}', description = '{$_POST['postdesc']}', category = {$_POST['category']},
            post_img = '{$image_name}' WHERE post_id = {$_POST['post_id']};";

    if($_POST['old_category'] != $_POST['category']) {
      $sql2 .= "UPDATE category SET post = post-1 WHERE category_id = {$_POST['old_category']};";
      $sql2 .= "UPDATE category SET post = post+1 WHERE category_id = {$_POST['category']};";
    }
   
    $result2 = mysqli_multi_query($conn, $sql2) or die("query failed from save-update-post!..");
    
    if($result2) {
        header("Location: {$hostname}/admin/users.php");
    }

?>
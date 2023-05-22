<?php
include "config.php";

if (isset($_FILES['fileToUpload'])) {
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

session_start();
$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M, Y");
$author = $_SESSION['user_id'];

$sql = "INSERT INTO post (title, description, category, post_date, author, post_img)
        VALUES ('{$title}', '{$description}', '{$category}', '{$date}', '{$author}', '{$file_name}');";

$sql .= "UPDATE category SET post = post + 1 WHERE category_id = '{$category}'";

if(mysqli_multi_query($conn, $sql)) {
    header("location: {$hostname}/admin/post.php");
}else{
  echo "<div class='alert alert-danger'>Query Failed From save-post!.</div>";
}

?>
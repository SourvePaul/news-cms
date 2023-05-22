<?php
include "config.php";
if(isset($_FILES['fileToUpload'])) {
    
}

$title = mysqli_real_escape_string($conn, $_POST['post_title']);
$description = mysqli_real_escape_string($conn, $_POST['postdesc']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$date = date("d M Y");
$author = $_SESSION['user_id'];


?>
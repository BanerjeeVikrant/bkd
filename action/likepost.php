<?php 
require "../system/connect.php"; 

session_start();
if (isset($_SESSION['user_login'])) {
	$username = $_SESSION['user_login'];
}
else{
	$username = "";
}

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

$check = $conn->query("SELECT * FROM posts WHERE id='$id'");
if ($check->num_rows == 1) {

	$get = $check->fetch_assoc();

	$likedby = $get['liked_by'];

}


if($likedby == "" || $likedby == NULL){
	$sqlcommand = $conn->query("UPDATE posts SET liked_by='$username' WHERE id='$id'");
}
else{
	$addedList = $likedby . "," . $username;
	$sqlcommand = $conn->query("UPDATE posts SET liked_by='$addedList' WHERE id='$id'");
}

?>
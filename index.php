<?php 
	require 'system/header.php'; 

//Login

if (isset($_POST["user_login"]) && isset($_POST["password_login"])) {
	$user_login = $_POST["user_login"];
    $password_login = $_POST["password_login"];
	$md5password_login = md5($password_login);
    $result = $conn->query("SELECT id FROM users WHERE username='$user_login' AND password='$md5password_login' AND activated='1' LIMIT 1"); // query the person
	//Check for their existance
	$userCount = $result->num_rows; //Count the number of rows returned
	if ($userCount == 1) {
		$row = $result->fetch_assoc();
             	$id = $row["id"];
		$_SESSION["id"] = $id;
		$_SESSION["user_login"] = $user_login;
		$_SESSION["password_login"] = $password_login;

         	
	} else {
		echo 'That information is incorrect, try again';
		exit();
	}
	
}
if ($username) {
	/*$updateIP = "UPDATE users SET ip='$ip' WHERE username='$user_login'";
	$changeIP = $conn->query($updateIP);*/
	echo "\n<script>window.location.assign('/bkd/home.php'); </script>\n";
}
?>
<style type="text/css">

	.home-img{
		width:100vw;
		min-height:calc(100vh - 59px);
		max-height:cover;
		background:
	    /* top, transparent black, faked with gradient */ 
	    linear-gradient(
	      rgba(0, 0, 0, 0.7), 
	      rgba(0, 0, 0, 0.7)
	    ),
	    /* bottom, image */
	    url(img/home-img.png);
		background-position: center center; 
	}
	.heading{
		font-size: 40px;
		font-family: "Carter One";
		color: white;
		float: right;
		position: relative;
	    right: 370px;
	    top: 60px;
	}
	.login-inputs{
		width: 350px;
		height: 45px;
		float: right;
		position: relative;
	    outline: none;
		padding: 10px;
		font-size: 18px;
		border: 5px double #29FFBF;
		background-color:#030F21;
		color:white;
		font-family: Alice;
		border-radius: 5px;
		border-bottom-right-radius: 30px;
	}
	.login-inputs:focus{
		border-color: #CC6600;
	}
	.usr-login{
		right: 130px;
    	top: 150px;
	}
	.psw-login{
		right: -220px;
		top: 205px;
	}
	.submit-login{
		width: 120px;
	    height: 40px;
		border:2px solid #29FFBF;
		border-radius: 10px;
		font-family: verdana;
		font-size: 17px;
		background: linear-gradient(#696767, #000000);
		color:#29FFBF;
		outline:none;
		float: right;
		position: relative;
		top: 270px;
		left: 450px;
	}
	.submit-login:hover{
		color: #29FFBF;
		background: #CC6600;
		border-color: #CC6600;
	}
</style>
<div class="home-img">
	<span class="heading">Log In</span>
	<form action="#" method="POST">
		<input class="login-inputs usr-login" type="text" name="user_login" placeholder="Username">
		<input class="login-inputs psw-login" type="password" name="password_login" placeholder="Password">
		<input class="submit-login" type="submit" name="submit-login" value="Log In">
	</form>
</div>

</body>
</html>

<?php
	require "system/header.php";

	$check = $conn->query("SELECT * FROM users WHERE username='$username'");
	if ($check->num_rows == 1) {
		$get = $check->fetch_assoc();

		$firstname = $get['first_name'];
		$lastname = $get['last_name'];
		$signupdate= $get['sign_up_date'];
		$profilepic = $get['profile_pic'];
		$bio = $get['bio'];
		$sex = $get['sex'];
		$interests = $get['interests'];
		$dob = $get['dob'];
		$relationship = $get['relationship'];
		$midschool = $get['ms'];
		$elemschool = $get['es'];			
	} 

?>
<div class="page-cover">
	<form id="inputForm">
		<span class="info">First Name:<input type="text" class="swift-info" name="firstname" value="<?php echo $firstname;?>"></span><br>
		<span class="info">Last Name:<input type="text" class="swift-info" name="lastname" value="<?php echo $lastname;?>"></span><br> 
		<span class="info">Elementary School:<input type="text" class="swift-info" name="elemschool" value="<?php echo $elemschool;?>"></span><br>
		<span class="info">Middle School: <input type="text" class="swift-info" name="midschool" value="<?php echo $midschool;?>"></span><br>
		<span class="info">Interests:<input type="text" class="swift-info" name="interests" value="<?php echo $interests;?>"></span><br>
		<span class="bio">Bio: </span><textarea name="bio"><?php echo $bio;?></textarea><br>

		<input type="submit" name="submitInputs">
	</form>
</div>
<style type="text/css">
	.page-cover{
		height:550px;
		background-color: white;
		width: 700px;
		position: relative;
		top:25px;
		left:50px;
		padding: 20px;
		border:1px solid grey;
	}
	.swift-info{
	    height: 40px;
	    width: 364px;
	    float: right;
	    margin-top: 15px;
	    padding: 12px;
	    font-size: 17px;
	    outline: 0;
	    border: 1px solid grey;
	    border-radius: 5px;
	    font-family: 'PT Serif Caption';
	    box-shadow: 0px 0px 7px grey;
	}
	.info{

		height: 40px;
	    width: 364px;
	    margin-top: 15px;
	    padding: 12px;
	    font-size: 17px;
	    font-family: 'PT Serif Caption';
	}
</style>
</body>
</html>

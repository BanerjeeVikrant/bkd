<?php
	require "system/header.php";

	if ($_SESSION['user_login']){
		$username = $_SESSION['user_login'];
		$adminCheck = $conn->query("SELECT admin FROM users WHERE username='$username'");
		$find = $adminCheck->fetch_assoc();
		$found = $find['admin'];
		if($found == '1'){
			$admin = true;
		}
		else{
			$admin = false;
		}
	}else{
		echo "\n<script>window.location.assign('/bkd/'); </script>\n";
		exit();
	}

?>

<?php

if (isset($_GET['u'])) {
	$profileUser = $_GET['u'];
	if($profileUser == ""){
		echo "<meta http-equiv=\"refresh\" content=\"0; url=/bkd/profile.php?u=$username\">";
	}
//check user exists
	$check = $conn->query("SELECT * FROM users WHERE username='$profileUser'");
	if ($check->num_rows == 1) {

		$get = $check->fetch_assoc();
		$activatedornot = $get['activated'];
		if($activatedornot == '0'){
						exit("ERROR 5718 No User exits. <a href = 'profile.php?u=$username'>Your profile</a>");
		}
		$adminornot = $get['admin'];
		if($adminornot == '1'){
			$adminProfile = true;
		}
		else{
			$adminProfile = false;
		}
		if(($adminProfile) && ($profileUser != "ssdf")){
			$staff = true;
		}
		else{
			$staff = false;
		}
		$firstname = $get['first_name'];
		$grade = $get['grade'];
		if($grade == 9){
			$grade = "Freshman";
		}else if($grade == 10){
			$grade = "Sophomore";
		}else if($grade == 11){
			$grade = "Junior";
		}else if($grade == 12){
			$grade = "Senior";
		}
		$lastname = $get['last_name'];
		$signupdate= $get['sign_up_date'];
		$profilepic = $get['profile_pic'];
		$bannerimg = $get['bannerimg'];
		$bio = $get['bio'];
		$sex = $get['sex'];
		$interests = $get['interests'];
		$dob = $get['dob'];
		$following = $get['following'];
		$followers = $get['followers'];

		if($bannerimg == "" || $bannerimg == NULL){
			$bannerimg = "https://upload.wikimedia.org/wikipedia/commons/1/19/Salt_Lake_City_skyline_banner.jpg";
		}
		if(($profilepic == "" || $profilepic == NULL) && ($sex == '1')){
			$profilepic = "https://upload.wikimedia.org/wikipedia/commons/3/34/PICA.jpg";
		}
		else if(($profilepic == "" || $profilepic == NULL) && ($sex == '0')){
			$profilepic = "http://ieeemjcet.org/wp-content/uploads/2014/11/default-girl.jpg";
		}

	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=/bruinskave/index.php\">";
		exit();
	}

}

?>
<style type="text/css">
	.banner{
		background:
		/* top, transparent black, faked with gradient */ 
	    linear-gradient(
	      rgba(0, 0, 0, 0.7), 
	      rgba(0, 0, 0, 0.7)
	    ),
	    /* bottom, image */
	    url(<?php echo $bannerimg; ?>);

	    height:200px;
	 	width:100vw;
	 	background-repeat: no-repeat;
	 	background-size: cover;
	}
	.profilepic{
		background-image: url(<?php echo $profilepic; ?>);
		height: 200px;
		width: 200px;
		position: relative;
		top:35px;
		left:35px;
		background-repeat: no-repeat;
	 	background-size: cover;
	 	z-index: 2;
	 	border: 5px solid #36465D;
	 	border-radius: 15px;
	}
	.option-tabs{
		background-color: #1E1E1F;
		height:50px;
		width: 100vw;
		position: relative;
		z-index: 1;
	}
	.tabs{
		display:inline-block;
		position: relative;
		left:250px;
		height:50px;
		width: calc((100vw - 360px) / 6);
		color: #f1f1f1;
		text-align: center;
		font-size:20px;
		font-family: 'PT Serif Caption';
		padding-top: 9px;
		cursor: pointer;
	}
	.tabs:hover{
		border-bottom: 5px solid #934B03;
	}
	.profile-tab{
		border-bottom: 5px solid #69BC45;
	}
	.info-tab{
		
	}
	.photos-tab{
		
	}
	.classes-tab{
		
	}
	.followers-tab{
		width: calc(((100vw - 320px) / 6) + 20px);
	}
	.following-tab{
		width: calc(((100vw - 320px) / 6) + 20px);
	}
	.num-follow{
		background: #DCDCDC;
		color: black;
		font-size: 17px;
		position: relative;
		top: -8px;
		left: 5px;
		padding:3px;
		padding-top:0px;
		padding-bottom:0px;
		border-radius: 90px;
		font-family: 'PT Serif Caption';
	}
	.unfollow{
	    background: black;
	    position: relative;
	    height: 40px;
	    width: 140px;
	    top: -60px;
	    left: calc(100vw - 200px);
	    color: white;
	    font-size: 18px;
	    font-weight: bold;
	    border: 3px solid #934B03;
	    color: #934B03;
	    outline: 0;
	    font-family: 'PT Serif Caption';
	}
	.unfollow:hover{
		background: #934B03;
		color: black;
	}
	.report{
		background: transparent;
	    position: relative;
	    height: 40px;
	    width: 120px;
	    top: -60px;
	    left: calc(100vw - 500px);
	    color: white;
	    font-size: 18px;
	    font-weight: bold;
	    border: 3px solid #FF0000;
	    color:#FF0000;
	    outline: 0;
	    font-family: 'PT Serif Caption';
	}
	.message-btn{
		background: transparent;
	    position: relative;
	    height: 40px;
	    width: 120px;
	    top: -60px;
	    left: calc(100vw - 420px);
	    color: white;
	    font-size: 18px;
	    font-weight: bold;
	    border: 3px solid #3FBD07;
	    color: #3FBD07;
	    outline: 0;
	    font-family: 'PT Serif Caption';
	}
	.follow{
		background: transparent;
	    position: relative;
	    height: 40px;
	    width: 120px;
	    top: -60px;
	    left: calc(100vw - 430px);
	    color: white;
	    font-size: 18px;
	    font-weight: bold;
	    border: 3px solid #69BC45;
	    color:#69BC45;
	    outline: 0;
	    font-family: 'PT Serif Caption';
	}
	.follow:hover{
		background: #69BC45;
		color: black;
	}
	.message-btn:hover{
		background: #3FBD07;
		color: black;
	}
	.report:hover{
		background: #FF0000;
		color: black;
	}
</style>

<div class="banner">
	<div class="profilepic"></div>

		<input class = "report" type="submit" name="report" value="Report">

		<input class = "follow" type="submit" name="follow" value="Follow">
		<input class = "message-btn" type="submit" name="message-btn" value="Message">
</div>
<div class="option-tabs">
	<div class="tabs profile-tab"><b>P</b>rofile</div>
	<div class="tabs info-tab"><b>I</b>nfo</div>
	<div class="tabs photos-tab"><b>P</b>hotos</div>
	<div class="tabs following-tab"><b>F</b>ollowing<span class="num-follow">2</span></div>
	<div class="tabs followers-tab"><b>F</b>ollowers<span class="num-follow">10</span></div>
	<div class="tabs classes-tab"><b>C</b>lasses</div>
</div>
<div class="content" id="content">
</div>

<script type="text/javascript">

</script>
</body>
</html>

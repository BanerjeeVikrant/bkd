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
		echo "<meta http-equiv=\"refresh\" content=\"0; url=profile.php?u=$username\">";
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
		$es = $get['es'];
		$ms = $get['ms'];
		$bio = $get['bio'];
		$sex = $get['sex'];
		$interests = $get['interests'];
		$relationship = $get['relationship'];
		if($relationship == 1){
			$relationship = "In a relationship";
		}
		else{
			$relationship = "Single";
		}
		$dob = $get['dob'];
		$following = $get['following'];
		$followers = $get['followers'];
		$last_online_date = $get['last_online_date'];
		$last_online_time = $get['last_online_time'];

		if($bannerimg == "" || $bannerimg == NULL){
			$bannerimg = "https://upload.wikimedia.org/wikipedia/commons/1/19/Salt_Lake_City_skyline_banner.jpg";
		}
		if($profilepic == "" || $profilepic == NULL){
			if($sex == "1"){
				$profilepic = "https://upload.wikimedia.org/wikipedia/commons/3/34/PICA.jpg";
			}
			else{
				$profilepic = "http://ieeemjcet.org/wp-content/uploads/2014/11/default-girl.jpg";
			}
		}

	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=/bruinskave/index.php\">";
		exit();
	}

}
$yourcheck = $conn->query("SELECT * FROM users WHERE username='$username'");
	if ($yourcheck->num_rows == 1) {

			$yourget = $check->fetch_assoc();
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
			$yourid = $yourget['id'];
			$yourfirstname = $yourget['first_name'];
			$yourgrade = $yourget['grade'];
			if($yourgrade == 9){
				$yourgrade = "Freshman";
			}else if($yourgrade == 10){
				$yourgrade = "Sophomore";
			}else if($yourgrade == 11){
				$grade = "Junior";
			}else if($yourgrade == 12){
				$yourgrade = "Senior";
			}
			$yourlastname = $yourget['last_name'];
			$yoursignupdate= $yourget['sign_up_date'];
			$yourprofilepic = $yourget['profile_pic'];
			$yourbannerimg = $yourget['bannerimg'];
			$yourbio = $yourget['bio'];
			$yoursex = $yourget['sex'];
			$yourinterests = $yourget['interests'];
			$yourdob = $yourget['dob'];
			$yourfollowing = $yourget['following'];
			$yourfollowers = $yourget['followers'];

			if($yourbannerimg == "" || $yourbannerimg == NULL){
				$bannerimg = "https://upload.wikimedia.org/wikipedia/commons/1/19/Salt_Lake_City_skyline_banner.jpg";
			}
			if(($yourprofilepic == "" || $yourprofilepic == NULL) && ($yoursex == '1')){
				$profilepic = "https://upload.wikimedia.org/wikipedia/commons/3/34/PICA.jpg";
			}
			else if(($yourprofilepic == "" || $yourprofilepic == NULL) && ($yoursex == '0')){
				$profilepic = "http://ieeemjcet.org/wp-content/uploads/2014/11/default-girl.jpg";
			}
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=/bruinskave/index.php\">";
		exit();
	}

?>
<?php

//Post Methods into db...

/************************/
//post text :: ln 603 :: postmethods/textpost.html
if (isset($_POST['post'])) {
	$post = @$_POST['post'];
	if($post != ""){
		date_default_timezone_set("America/Los_Angeles");
		$date_added = date("Y/m/d");
		$added_by = $username;
		$user_posted_to = $profileUser;
		$time_added = date("h:i:sa"); 

		$sqlcommand = "INSERT INTO posts VALUES ( '', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', '', '', '', '0', '')";
		$query = $conn->query($sqlcommand) or die(mysql_error());

	}
}
/*************************/

/************************/
//post picture :: ln 603 :: postmethods/photopost.html
if (isset($_FILES['pictureUpload'])) {
	$post = '';
	$post = $_POST['photopost'];
	date_default_timezone_set("America/Los_Angeles");
	$date_added = date("Y/m/d");
	$added_by = $username;
	$user_posted_to = $profileUser;
	$time_added = date("h:i:sa");


	if (((@$_FILES["pictureUpload"]["type"]=="image/jpeg") || (@$_FILES["pictureUpload"]["type"]=="image/png") || (@$_FILES["pictureUpload"]["type"]=="image/gif"))&&(@$_FILES["pictureUpload"]["size"] < 10485760)) {

		$rand_dir_name = $username;


		if (file_exists("userdata/pictures/$rand_dir_name/".@$_FILES["pictureUpload"]["name"])){

			move_uploaded_file(@$_FILES["pictureUpload"]["tmp_name"],"userdata/pictures/$rand_dir_name/".$_FILES["pictureUpload"]["name"]);
//echo "Uploaded and stored in: userdata/pictures/$rand_dir_name/".@$_FILES["pictureUpload"]["name"];
			$profile_pic_name = @$_FILES["pictureUpload"]["name"];

			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', 'userdata/pictures/$rand_dir_name/$profile_pic_name', '', '', '0', '')";
			$profile_pic_query = $conn->query($sql);

			$sql = "INSERT INTO photos VALUES ('', '$username', 'userdata/pictures/$rand_dir_name/$profile_pic_name')";
			$profile_pic_query = $conn->query($sql);
		}

		else {
			if (file_exists("userdata/pictures/$rand_dir_name")){
				mkdir("userdata/pictures/$rand_dir_name");
			}
			move_uploaded_file(@$_FILES["pictureUpload"]["tmp_name"],"userdata/pictures/$rand_dir_name/".$_FILES["pictureUpload"]["name"]);
//echo "Uploaded and stored in: userdata/pictures/$rand_dir_name/".@$_FILES["pictureUpload"]["name"];
			$profile_pic_name = @$_FILES["pictureUpload"]["name"];
			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', 'userdata/pictures/$rand_dir_name/$profile_pic_name', '', '', '0', '')";

			$profile_pic_query = $conn->query($sql);

			$sql = "INSERT INTO photos VALUES ('', '$username', 'userdata/pictures/$rand_dir_name/$profile_pic_name')";
			$profile_pic_query = $conn->query($sql);
		}


	}
}
/*************************/

/************************/
//post video :: ln 603 :: postmethods/videopost.html
if (isset($_FILES['videoUpload'])) {
	$post = '';
	$post = $_POST['videopost'];
	date_default_timezone_set("America/Los_Angeles");
	$date_added = date("Y/m/d");
	$added_by = $username;
	$user_posted_to = $profileUser;
	$time_added = date("h:i:sa");


	if (((@$_FILES["videoUpload"]["type"]=="video/mp4") || (@$_FILES["videoUpload"]["type"]=="video/webm") || (@$_FILES["videoUpload"]["type"]=="video/ogg"))&&(@$_FILES["videoUpload"]["size"] < 10485760)) {

		$rand_dir_name = $username;


		if (file_exists("userdata/videos/$rand_dir_name/".@$_FILES["videoUpload"]["name"])){

			move_uploaded_file(@$_FILES["videoUpload"]["tmp_name"],"userdata/videos/$rand_dir_name/".$_FILES["videoUpload"]["name"]);
//echo "Uploaded and stored in: userdata/videos/$rand_dir_name/".@$_FILES["videoUpload"]["name"];
			$profile_pic_name = @$_FILES["videoUpload"]["name"];

			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', '', 'userdata/videos/$rand_dir_name/$profile_pic_name', '', '0', '')";
			$profile_pic_query = $conn->query($sql);
		}

		else {
			if (file_exists("userdata/videos/$rand_dir_name")){
				
			}else{
				mkdir("userdata/videos/$rand_dir_name");
			}
			move_uploaded_file(@$_FILES["videoUpload"]["tmp_name"],"userdata/videos/$rand_dir_name/".$_FILES["videoUpload"]["name"]);
//echo "Uploaded and stored in: userdata/videos/$rand_dir_name/".@$_FILES["videoUpload"]["name"];
			$profile_pic_name = @$_FILES["videoUpload"]["name"];
			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', '', 'userdata/videos/$rand_dir_name/$profile_pic_name', '', '0', '')";

			$profile_pic_query = $conn->query($sql);
		}


	}
}
/*************************/

?>
<style type="text/css">
	.banner{
		background:
		/* top, transparent black, faked with gradient */ 
		linear-gradient(
			rgba(0, 0, 0, 0.5), 
			rgba(0, 0, 0, 0.5)
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
		height: 230px;
		width: 230px;
		position: relative;
		top: 50px;
		left: 30px;
		background-repeat: no-repeat;
		background-size: cover;
		z-index: 2;
		border: 5px solid #ffffff;
		border-radius: 15px;
	}
	.option-tabs{
		background-color: #1d2d4a;
		height:50px;
		width: 100vw;
		position: relative;
		z-index: 1;
	}
	.tabs{
		display: inline-block;
	    position: relative;
	    left: 310px;
	    height: 50px;
	    width: calc(((100vw - 360px) / 6) - 20px);
	    color: #f1f1f1;
	    text-align: center;
	    font-size: 20px;
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
		top: -100px;
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
	/*
	.report{
		background: transparent;
		position: relative;
		height: 40px;
		width: 120px;
		top: -100px;
		left: calc(100vw - 500px);
		color: white;
		font-size: 18px;
		font-weight: bold;
		border: 3px solid #FF0000;
		color:#FF0000;
		outline: 0;
		font-family: 'PT Serif Caption';
	}*/
	.message-btn{
		background: transparent;
		position: relative;
		height: 40px;
		width: 120px;
		top: -100px;
		left: calc(100vw - 320px);
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
		top: -100px;
		left: calc(100vw - 330px);
		color: white;
		font-size: 18px;
		font-weight: bold;
		border: 3px solid #004ef2;
		color:#004ef2;
		outline: 0;
		font-family: 'PT Serif Caption';
	}
	.follow:hover{
		background: #004ef2;
		color: black;
	}
	.message-btn:hover{
		background: #3FBD07;
		color: black;
	}
	/*
	.report:hover{
		background: #FF0000;
		color: black;
	}*/
	.center-col {
	    position: absolute;
	    left: calc(50% - 300px);
	}
	.left-col{
		position: absolute;
		left: 30px;
	}
	.post-tabs{
		height: 39px;
		width:100px;
		display: inline-block;
		background: #D2D2D2;
		padding: 7px;
		text-align: center;
		font-size: 16px;
		font-family: 'PT Serif Caption';
		margin-left:-4px;
		position: relative;
		top: 52px;
		left: calc(50% - 323px);
		z-index: 2;
		cursor: pointer;
	}
	.text-tab{
		background: white;
		border-right: 1px solid #c9c8c8;
		top: 51px;
	}
	.photo-tab{
		height:38px;
		top: 51px;
	}
	.video-tab{
		height:38px;
		top: 51px;
	}
	#post{
		width: 650px;
		height: 100px;
		position: relative;
		top:50px;
		left: calc(50% - 327px);
		border:0;
		border-top: 1px solid #c9c8c8;
		padding: 12px;
		padding-left: 15px;
		font-size: 15px;
		font-family: verdana;
		outline:0;
		resize: none;
		color:black;
		z-index: 1;
	}
	.tags-input{
		width: 530px;
		height: 33px;
		position: relative;
		top:42px;
		left: calc(50% - 327px);
		border:0;
		padding-left: 15px;
		outline: 0;
		color: #555;
		background: #EEE;
		font-family: arial;
	}
	.tags-input::-webkit-input-placeholder{
		color:grey;
	}
	.postsend-btn{
		background:#297FC7;
		position: relative;
		top:44px;
		left: calc(50% - 331px);
		border:0;
		width: 120px;
		height:33px;
		border:0;
		color:white;
		font-size: 20px;
	}
	.inputfile {
		width: 0.1px;
		height: 0.1px;
		opacity: 0;
		overflow: hidden;
		position: absolute;
		z-index: -1;
	}
	.inputfile + label {
		width: 325px;
		font-size: 1.25rem;
		/* 20px */
		font-weight: 700;
		text-overflow: ellipsis;
		white-space: nowrap;
		cursor: pointer;
		display: inline-block;
		overflow: hidden;
		padding: 0.625rem 1.25rem;
		text-align: center;
		position: relative;
		top:45px;
		left: calc(50% - 327px);
		color:white;
	}

	.no-js .inputfile + label {
		display: none;
	}

	.inputfile:focus + label,
	.inputfile.has-focus + label {
		outline: 1px dotted #000;
		outline: -webkit-focus-ring-color auto 5px;
	}

	.inputfile + label svg {
		width: 1em;
		height: 1em;
		vertical-align: middle;
		fill: currentColor;
		margin-top: -0.25em;
		/* 4px */
		margin-right: 0.25em;
		/* 4px */
	}

	.inputfile-1 + label {
		color: #fff;
		background-color: #9c9c9c;
	}

	.inputfile-1:focus + label,
	.inputfile-1.has-focus + label,
	.inputfile-1 + label:hover {
		background-color: #837c7f;
	}
	.link-div{
		background-color: #9c9c9c;
		display: inline-block;
		width: 324px;
		font-size: 1.25rem;
		font-weight: 700;
		white-space: nowrap;
		cursor: pointer;
		padding: 0.625rem 1.25rem;
		text-align: center;
		position: relative;
		top: 28px;
		left: calc(50% - 330px);
		color: white;
	}
	.link-div:hover{
		background-color: #837c7f;
	}
	.post-work{
		position: relative;
		width: 125px;
		padding: 5px;
		padding-left: 15px;
		font-family: verdana;
		border: 1px solid #DDDDDD;
		
	}
	.post-work:hover{
		background-color: blue;
    	color: white;
	}
	.report-post:hover{
		background-color: red;
		color: white;
	}
	.report-post{
		background-color: #F3F3F3;
	}
	
	.postoptions-div{
		border: 1px solid #DDDDDD;
		box-shadow: 4px 12px 20px #888888;
		z-index: 1;
	}
	.profile-post{
		background-color: white;
		position: relative;
		top: 70px;
		width: 650px;
		padding: 20px;
		padding-bottom: 0;
		margin-bottom: 15px;
		border-top: 1px solid #c9c8c8;
		border-left: 1px solid #c9c8c8;
		border-right: 1px solid #c9c8c8;
	}
	.posted-by-img{
		display: inline-block;
		width: 50px;
		height: 50px;
		border-radius: 45px;
		background-repeat: no-repeat;
		background-size: cover;
	}
	.samepostedby{
		margin: 10px;
		position: relative;
		top: -29px;
		font-size: 16px;
		text-decoration: none !important;
		color: black;
		font-family: 'PT Serif Caption';
	}
	.posted-to-name{
		margin: 10px;
		position: relative;
		top: -29px;
		font-size: 16px;
		text-decoration: none !important;
		color: black;
	}
	.post-options{
		position: absolute;
		left: 580px;
		top: 7px;
		font-size: 20px;
		color: #9ba0a3;
	}
	.arrow{
		margin: 5px;
		position: relative;
		top: -4px;
		font-size: 16px;
	}
	.time{
		position: relative;
		top: -30px;
		left: 63px;
		font-family: 'Alice';
	}
	.msg-body{
		font-size: 15px;
		font-family: verdana;
		color:black;
		position: relative;
	    top: -13px;
	}
	.comment-inputs{
		width: 600px;
		height: 50px;
		position: relative;
		top: 55px;
		left: 50px;
		border: 0;
		padding-left: 15px;
		font-size: 15px;
		background-color: #fff;
		outline-width: 0;
		font-family: Verdana;
		border-right: 1px solid #c9c8c8;
		border-bottom: 1px solid #c9c8c8;
	}
	.like-btn-div{
		width: 50px;
		height: 50px;
		position: absolute;
		top: 55px;
		background-color: white;
		z-index: 1;
		border-left: 1px solid #c9c8c8;
		border-bottom: 1px solid #c9c8c8;
	}	
	.notliked{
		height: 40px;
		width: 40px;
		margin: 5px;
		margin-left: 10px;
		background-image: url(img/notliked-paw.png);
		z-index: 2;
		background-repeat: no-repeat;
		background-size: cover;
	}
	.comment-body{
		background-color: #f9f9f9;
		width: 500px;
		position: relative;
		top: -135px;
		left: 340px;
	}
	.comments-img{
		width: 50px;
		height: 50px;
		padding: 5px;
		position: relative;
		top: 3px;
		left: 10px;
		border-radius: 45px;
	}
	.commentPosted{
		padding-left: 10px;
		font-size: 13px;
		margin-top: -13px;
		position: relative;
		top: 18px;
	}
	.comment-area{
		width: 400px;
		position: relative;
		left:60px;
		top: -35px;
	}
	.posted-pic{
		width: 648px;
		margin-left: -20px;
		position: relative;
		margin-top:-6px;
		top: 6px;
	}
	#last_post{
		padding-bottom: 20px;
	}
	.youtube-link-iframe{
		width: 650px;
		height: 355px;
		margin-left: -20px;
		position: relative;
		margin-top:-6px;
		top: 6px;
	}
	.posted-video{
		width: 650px;
		margin-left: -20px;
		position: relative;
		margin-top:-6px;
		top: 6px;
	}
	.about-me{
		display: inline-block;
	    width: 315px;
	    position: relative;
	    background: white;
	    top: 50px;
	    border: 1px solid #c9c8c8;
	    padding: 10px;
	}
	.about-me-tag{
		font-size: 20px;
	    position: relative;
	    top: -5px;
	    left: 10px;
	    color: #969191;
	}
	.bio{
		font-size: 13px;
		font-family: 'PT Serif Caption';
		display: block;
		line-height: 20px;
		color: #4a4949;
	}
	.breaker{
		margin: 10px;
		border-color: #cbcbcb;
	}
	.info-mid{
		font-size: 13px;
		font-family: 'PT Serif Caption';
		position: relative;
		left: 10px;
		top: -3px;
		color:#4a4949;
	}
	.dob{
		font-size: 13px;
	    font-family: 'PT Serif Caption';
	    position: relative;
	    left: 6px;
	    top: -5px;
	    color: #4a4949;
	}
	.lastonline{
		font-size: 13px;
		font-family: 'PT Serif Caption';
		position: relative;
		left: 10px;
		top: -3px;
		color:#4a4949;
	}
</style>

<div class="banner">
	<div class="profilepic"></div>

	<!--<input class = "report" type="submit" name="report" value="Report">-->

	<input class = "follow" type="submit" name="follow" value="Follow">
	<input class = "message-btn" type="submit" name="message-btn" value="Message">
</div>
<div class="option-tabs">
	<div class="tabs profile-tab"><b>P</b>rofile</div>
	<div class="tabs following-tab"><b>F</b>ollowing<span class="num-follow">2</span></div>
	<div class="tabs followers-tab"><b>F</b>ollowers<span class="num-follow">10</span></div>
	<div class="tabs photos-tab"><b>P</b>hotos</div>
</div>
<div class="left-col">
	<div class="about-me">
		<img src="img/earth.png" width="25px"><span class="about-me-tag">About Me</span><br>
		<span class="bio"><?php echo $bio; ?></span>
		<hr class="breaker">
		<img src="img/house.png" width="20px"><span class="elem info-mid">Went to <?php echo $es; ?> Elementary School</span><br>
		<img src="img/house.png" width="20px"><span class="mid info-mid">Went to <?php echo $ms; ?> Middle School</span><br>
		<img src="img/favorite.png" width="20px"><span class="relationship-info info-mid"><?php echo $relationship; ?></span>
		<hr class="breaker">
		<img src="img/bird-in-broken-egg.png" width="25px"><span class="dob">Was born on <?php echo $dob; ?></span><br>
		<img src="img/wifi.png" width="20px"><span class="lastonline">Last online <?php echo $last_online_date . ", " . $last_online_time; ?></span><br>
	</div>
</div>
<div class="center-col">
	<div class="postboxarea" id="postboxarea">
		<div class="post-tabs text-tab">Post</div>	
		<div class="post-tabs photo-tab">Photo</div>
		<div class="post-tabs video-tab">Video</div>
		<form action="profile.php?u=<?php echo $profileUser; ?>" method="POST" enctype="multipart/form-data">
			<div class="postarea" id="postarea">
				
			</div>
			<div class="postarea-send">
				<input type="text" name="tags" class="tags-input" placeholder="#tags">
				<input type="submit" name="postsend" class="postsend-btn" value="Send">
			</div>
		</form>
	</div>
	<div class="content" id="content">

	</div>
	<div id = "end">
		<div id="loading-img" style = "position: relative;">
			<img  src = "https://www.wpfaster.org/wp-content/uploads/2013/06/loading-gif.gif" style = "position: absolute; top: 100px; left:180px;" width = "200px"/>
		</div>
	</div>

	</div>
	</div>
	<div style="display:none" id="post_offset">0</div>
</div>
<script>
	var all_posts_loaded = false;
	var loading_currently = false;
	function load_more_post() {
		if (!all_posts_loaded && !loading_currently)  {
			loading_currently = true;
			offset = Number($("#post_offset").text());
			username = <?php echo '"'.$profileUser.'"'; ?>;
			posturl = "action/bringposts.php?u="+username+"&o="+offset;

			$.ajax({url: posturl, success: function(result){
				$("#content").before(result);
				$("#post_offset").text(20+offset);
				loading_currently = false;
				if ($("#last_post").length > 0) {
					all_posts_loaded = true;
				}
			}});
		}
	}	
	$(function() {
		$("#loading-img").hide();
		load_more_post();
		$("#loading-img").show();
	//alert('end reached');

		$(window).bind('scroll', function() {
			if($(window).scrollTop() >= $('#end').offset().top + $('#end').outerHeight() - window.innerHeight) {

			//alert('end reached');
			load_more_post();
			$("#loading-img").show();
			}
		});
	});

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#postarea").load("postmethods/textpost.html");

	//post tab click
	$(".photo-tab").click(function(){
		$("#postarea").load("postmethods/photopost.html");
		$(".tags-input").css("top", "27px");
		$(".postsend-btn").css("top", "29px");

		$(".text-tab").css("background", "#D2D2D2");
		$(".photo-tab").css("background", "white");
		$(".video-tab").css("background", "#D2D2D2");

		$(".text-tab").css("top", "51px");
		$(".photo-tab").css("top", "51px");
		$(".video-tab").css("top", "51px");

		$(".text-tab").css("height", "37px");
		$(".video-tab").css("height", "37px");

		$(".photo-tab").css("border-right", "1px solid #c9c8c8");
		$(".photo-tab").css("border-left", "1px solid #c9c8c8");

		$(".text-tab").css("border-right", "0");
		$(".video-tab").css("border-left", "0");
	});

	//photo tab click
	$(".text-tab").click(function(){
		$("#postarea").load("postmethods/textpost.html");
		$(".tags-input").css("top", "42px");
		$(".postsend-btn").css("top", "44px");

		$(".text-tab").css("background", "white");
		$(".photo-tab").css("background", "#D2D2D2");
		$(".video-tab").css("background", "#D2D2D2");

		$(".text-tab").css("top", "51px");
		$(".photo-tab").css("top", "50px");
		$(".video-tab").css("top", "50px");

		$(".photo-tab").css("height", "37px");
		$(".video-tab").css("height", "37px");

		$(".text-tab").css("border-right", "1px solid #c9c8c8");

		$(".photo-tab").css("border-right", "0");
		$(".photo-tab").css("border-left", "0");
		$(".video-tab").css("border-left", "0");
		$(".video-tab").css("border-right", "0");
	});

	//video tab click
	$(".video-tab").click(function(){
		$("#postarea").load("postmethods/videopost.html");
		$(".tags-input").css("top", "27px");
		$(".postsend-btn").css("top", "29px");

		$(".text-tab").css("background", "#D2D2D2");
		$(".photo-tab").css("background", "#D2D2D2");
		$(".video-tab").css("background", "white");

		$(".text-tab").css("top", "50px");
		$(".photo-tab").css("top", "50px");
		$(".video-tab").css("top", "51px");

		$(".photo-tab").css("height", "37px");
		$(".text-tab").css("height", "37px");

		$(".video-tab").css("border-left", "1px solid #c9c8c8");
		$(".video-tab").css("border-right", "1px solid #c9c8c8");

		$(".photo-tab").css("border-right", "0");
		$(".photo-tab").css("border-left", "0");
		$(".text-tab").css("border-right", "0");
	});
});
/*var $document = $(document);

$document.scroll(function() {
  if ($document.scrollTop() >= 300) {

  	alert("hello");

  } else {
  }
});*/
</script>
</body>
</html>
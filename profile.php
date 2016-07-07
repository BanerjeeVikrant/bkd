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
		$followings = $get['following'];
		$followers = $get['followers'];

		$followingArray = explode(",", $followings);
		$followersArray = explode(",", $followers);

		$followingCount = count($followingArray);
		$followersCount = count($followersArray);

		if($followings == ""){
			$followingCount = 0;
		}
		if($followers == ""){
			$followersCount = 0;
		}


		$last_online_date = $get['last_online_date'];
		$last_online_time = $get['last_online_time'];

		$sql = "SELECT id from posts ORDER BY id DESC LIMIT 1";
		$result = $conn->query($sql);
		if ($result->num_rows==1) {
			$getid = $result->fetch_assoc();

			$maxid = $getid['id'] + 1;
		}

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

	$yourget = $yourcheck->fetch_assoc();
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
	$post = str_replace("'","&apos;",$post);
	if($post != ""){
		date_default_timezone_set("America/Los_Angeles");
		$date_added = date("Y/m/d");
		$added_by = $username;
		$user_posted_to = $profileUser;
		$time_added = date("h:i:sa"); 

		$sqlcommand = "INSERT INTO posts VALUES ( '', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', '', '', '', '0', '', '')";
		$query = $conn->query($sqlcommand) or die(mysql_error());

	}
}
/*************************/

/************************/
//post picture :: ln 603 :: postmethods/photopost.html
if (isset($_FILES['pictureUpload'])) {
	$post = '';
	$post = $_POST['photopost'];
	$post = str_replace("'","&apos;",$post);
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

			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', 'userdata/pictures/$rand_dir_name/$profile_pic_name', '', '', '0', '', '')";
			$profile_pic_query = $conn->query($sql);

			$sql = "INSERT INTO photos VALUES ('', '$username', 'userdata/pictures/$rand_dir_name/$profile_pic_name', '$maxid')";
			$profile_pic_query = $conn->query($sql);
		}

		else {
			if (file_exists("userdata/pictures/$rand_dir_name")){
				mkdir("userdata/pictures/$rand_dir_name");
			}
			move_uploaded_file(@$_FILES["pictureUpload"]["tmp_name"],"userdata/pictures/$rand_dir_name/".$_FILES["pictureUpload"]["name"]);
//echo "Uploaded and stored in: userdata/pictures/$rand_dir_name/".@$_FILES["pictureUpload"]["name"];
			$profile_pic_name = @$_FILES["pictureUpload"]["name"];
			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', 'userdata/pictures/$rand_dir_name/$profile_pic_name', '', '', '0', '', '')";

			$profile_pic_query = $conn->query($sql);

			$sql = "INSERT INTO photos VALUES ('', '$username', 'userdata/pictures/$rand_dir_name/$profile_pic_name', '$maxid')";
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
	$post = str_replace("'","&apos;",$post);
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

			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', '', 'userdata/videos/$rand_dir_name/$profile_pic_name', '', '0', '', '')";
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
			$sql = "INSERT INTO posts VALUES ('', '$post', '$date_added', '$time_added', '$added_by', '1', '', '$user_posted_to', '', '', 'userdata/videos/$rand_dir_name/$profile_pic_name', '', '0', '', '')";

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
		background-size: cover;
		background-repeat: no-repeat;
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
		background-color: #1a263e;
	}
	.profile-tab{
		border-bottom: 5px solid #ec6002;
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
		background: #ea201b;
		position: relative;
		height: 40px;
		width: 120px;
		top: -100px;
		left: calc(100vw - 330px);
		font-size: 17px;
		font-weight: bold;
		border: 0;
		color: #ffffff;
		outline: 0;
		font-family: 'PT Serif Caption';
		border-bottom-right-radius: 15px;
		border-top-left-radius: 15px;
	}
	.unfollow:hover{
		background: #c1120e;
		color: white;
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
		background: #65b244;
		position: relative;
		height: 40px;
		width: 120px;
		top: -100px;
		left: calc(100vw - 325px);
		font-size: 17px;
		font-weight: bold;
		border: 0;
		color: #ffffff;
		outline: 0;
		font-family: 'PT Serif Caption';
		border-bottom-right-radius: 15px;
		border-top-left-radius: 15px;
	}
	.follow{
		background: #1378fe;
		position: relative;
		height: 40px;
		width: 120px;
		top: -100px;
		left: calc(100vw - 330px);
		font-size: 17px;
		font-weight: bold;
		border: 0;
		color: #ffffff;
		outline: 0;
		font-family: 'PT Serif Caption';
		border-bottom-right-radius: 15px;
		border-top-left-radius: 15px;
	}
	.follow:hover{
		background: #105ec5;
		color: white;
	}
	.message-btn:hover{
		background: #549936;
		color: white;
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
		background: #1d2d4a;
		position: relative;
		top: 44px;
		left: calc(50% - 331px);
		border: 0;
		width: 120px;
		height: 33px;
		border: 0;
		color: white;
		font-size: 18px;
		font-family: 'PT Serif Caption';
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
	.posted-by-name{
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
		font-family: 'PT Serif Caption';
	}

	.arrow{
		margin: 5px;
		position: relative;
		top: -27px;
		font-size: 16px;
	}

	.post-options{
		position: absolute;
		left: 580px;
		top: 7px;
		font-size: 20px;
		color: #9ba0a3;
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
		cursor: pointer;
	}
	.notliked:hover{
		height: 50px;
		width: 50px;
		margin-left: 7px;
		margin-top: -2px;
	}
	.liked{
		height: 40px;
		width: 40px;
		margin: 5px;
		margin-left: 10px;
		background-image: url(img/liked-paw.png);
		z-index: 2;
		background-repeat: no-repeat;
		background-size: cover;
		cursor: pointer;
	}
	.liked:hover{
		height: 50px;
		width: 50px;
		margin-left: 7px;
		margin-top: -2px;
	}
	.comment-body{
		background-color: #f9f9f9;
		width: 650px;
		position: relative;
		top: 55px;
		left: 0px;
		border-left: 1px solid #c9c8c8;
		border-right: 1px solid #c9c8c8;
	}
	.comments-img{
		width:35px;
		height: 35px;
		padding: 5px;
		background-repeat: no-repeat;
		background-size: cover;
		position: relative;
		top: 3px;
		left: 10px;
		border-radius: 45px;
		display:inline-block;

	}
	.commentPosted{
		padding-left: 0px;
		font-size: 13px;
		margin-top: -19px;
		position: relative;
		top: 22px;
		font-family: 'PT Serif Caption';
	}
	.comment-area{
		width: 530px;
		position: relative;
		left: 60px;
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
		left: 0px;
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
	.photo-fullscreen-div-wrapper{
		position: fixed;
		height: calc(100vh + 60px);
		width: 100vw;
		background-color: rgba(0,0,0,0.5);
		z-index: 3;
		top:-60px;
	}
	.left-col-img-wrapper{
		display: inline-block;
		height: 95vh;
		max-width: 52vw;
		min-width:48vw;
		background-color: rgba(0,0,0,0.8);
		position: relative;
		top: 80px;
		left:20px;
	}
	.right-col-img-wrapper{
		display: inline-block;
		height: 95vh;
		width: 50vw;
		position: absolute;
		top: 10px;
		left: 50vw;
	}
	.fullscreen-photo{
		max-height: 500px;
		min-height: 400px;
		max-width: 42vw;
		min-width: 38vw;
		position: relative;
		margin-top: calc(50% - 225px);
		left: calc(50% - 21vw);
	}
	#close-fullscreen{
		position: absolute;
		margin-left: calc(100vw - 50px);
		margin-top: 80px;
		color: white;
		font-size: 25px;
		cursor: pointer;
		z-index: 4;
	}
	.count-likes{
		position: absolute;
		left: 497px;
		top: -67px;
		font-size: 13px;
		font-family: 'PT Serif Caption';
	}
	.swift-info{
		height: 40px;
		width: 330px;
		padding-left: 12px;
		font-size: 17px;
		outline: 0;
		border: 1px solid grey;
		border-radius: 5px;
		font-family: 'PT Serif Caption';
	}
	.school-settings{
		width:120px;
		border-radius: 0;
		border:0;
		border-left: 1px solid grey;
		border-top: 1px solid grey;
		border-bottom: 1px solid grey;
		border-bottom-left-radius: 5px;
		border-top-left-radius: 5px;
	}
	.school-settings-text{
		display: inline-block;
		height: 40px;
		width: 210px;
		position: relative;
		padding: 8px;
		top: 1px;
		font-size: 17px;
		outline: 0;
		border-right: 1px solid grey;
		border-top: 1px solid grey;
		border-bottom: 1px solid grey;
		border-bottom-right-radius: 5px;
		border-top-right-radius: 5px;
		font-family: 'PT Serif Caption';
	}
	.bio-settings{
		height: 148px;
		width: 100%;
		padding: 12px;
		font-size: 15px;
		outline: 0;
		border: 1px solid grey;
		border-radius: 5px;
		font-family: 'PT Serif Caption';
	}
	.info{
		font-family: 'PT Serif Caption';
	}
	.modal-body{
		padding:20px;
		padding-left:30px;
		padding-right:30px;
	}
	.submitsettings{
		height: 40px;
		width: 150px;
		margin-top: 14px;
		font-size: 20px;
		padding: 0;
		position: relative;
		left: calc(50% - 77px);
	}
	.pm-body{
		height: 100vh;
		width: 400px;
		background: rgba(0,0,0,0.9);
		z-index: 9;
		position: fixed;
		top: 0;
		float: right;
		left: calc(100% - 400px);
	}
	.messages-wrapper{
		height: 100vh;
		width: 400px;
		background: rgba(0,0,0,1);
		z-index: 10;
		position: fixed;
		top: 0;
		float: right;
		left: calc(100% - 400px);
		color:white;
	}
	.search-users {
		margin: 10px;
		margin-top: 15px;
		width: 70%;
		background-color: #f9f9f9;
		color: #e2e8eb;
		border-top-right-radius: 45px;
		border-bottom-right-radius: 45px;
		outline: none;
		border: 0;
		height: 30px;
		padding-left: 5px;
		font-family: 'PT Serif Caption';
		color: #737373;
	}
	.usersearch-tool-wrapper{
		background-color: #f9f9f9;
		border-top-left-radius: 45px;
		border-bottom-left-radius: 45px;
		display: inline-block;
		width:30px;
		height:30px;
		padding:4px;
		padding-left: 10px;
		font-family: verdana;
		position: relative;
		left: 14px;
	}

	.usersearch-tool{
		font-size: 15px;
		color:#737373;
	}
	.usersearchbar-wrapper{
		width:100%;
	}
	#users{
		width: 100%;
		height: 100%;
		overflow-x: hidden;
		overflow-y: scroll;
	}
	#users::-webkit-scrollbar {
		width: 10px;
	}

	/* Track */
	#users::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
		-webkit-border-radius: 15px;
		border-radius: 10px;
	}

	/* Handle */
	#users::-webkit-scrollbar-thumb {
		-webkit-border-radius: 10px;
		border-radius: 10px;
		background: #4f3317; 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,1); 
	}
	#users::-webkit-scrollbar-thumb:window-inactive {
		background: #111111;
	}
	.chat-user-img{
		display: inline-block;
		border-radius:45px;
		height: 42px;
		width: 42px;
		background-size: cover;
		background-repeat: no-repeat;
	}
	.each-user{
		height: 50px;
		padding-left: 13px;
		padding-top: 3px;
		cursor: pointer;
	}
	.each-user:hover{
		background: #222;
	}
	.each-user-name{
		display: inline-block;
		line-height: 50px;
		text-align: center;
		position: relative;
		top: -13px;
		font-size: 20px;
		left: 5px;
		color: white;
		z-index: 11;
	}
	#messages{

	}
	#messenger-pic{
		display: inline-block;
		width: 50px;
		height: 50px;
		border-radius: 45px;
		background-size: cover;
		background-repeat: no-repeat;
		position: relative;
		left: 0px;
		top: 7px;
	}
	#messenger-name{
		position: relative;
		left: 3px;
		top: -8px;
		font-size: 20px;
		font-family: 'PT Serif Caption';
	}
	.arrow-back{
		font-size: 27px;
		position: relative;
		left: 20px;
		top: -5px;
		cursor: pointer;
		z-index: 12;
	}
	.messenger-info{
		display: inline-block;
		position: relative;
		text-align: center;
		width: 338px;
	}
	.your-message{
		background-color: white;
		color: black;
		display: inline-block;
		padding-left: 10px;
		padding-right: 10px;
		max-width: 70%;
		padding-top: 6px;
		padding-bottom: 6px;
		border-radius: 5px;
		margin-top:5px;
		margin-right: 10px;
		float: right;
	}
	.your-message-box{
		float: right;
		width: 100%;
		font-size: 14px;
		font-family: 'PT Serif Caption';
	}
	.their-message-box{
		float: left;
		width: 100%;
		font-size: 14px;
		font-family: 'PT Serif Caption';
		padding-left: 10px;
	}
	.their-message{
		background-color: white;
		color: black;
		display: inline-block;
		padding-left: 10px;
		padding-right: 10px;
		max-width: 70%;
		padding-top: 6px;
		padding-bottom: 6px;
		border-radius: 5px;
		margin-top:5px;
	}
	.toPic{
		display: inline-block;
		width: 35px;
		height: 35px;
		background-size: cover;
		background-repeat: no-repeat;
		float: left;
		margin-right: 10px;
		border-radius: 45px;
		margin-top:5px;	
	}
	.bottom-message-wrapper{
		position: absolute;
		height: 50px;
		width: 400px;
		top: calc(100vh - 50px);
		background-color: #222;
	}
	.sendingText::-webkit-input-placeholder{
		color: grey;
	}
	.sendingText{
		width: 360px;
		height: 29px;
		position: relative;
		left: 20px;
		top: 11px;
		border-radius: 30px;
		border: 0;
		padding-left: 16px;
		color:black;
		outline: 0;
		font-family: 'PT Serif Caption';
		font-size: 15px;
	}
	.message-box-close{
		color: white;
		font-size: 25px;
		position: relative;
		top: 7px;
		left: 7px;
		cursor: pointer;
	}
</style>
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title">Settings</h3>
			</div>
			<div class="modal-body">
				<form id="inputForm">
					<span class="info">First Name:</span><br><input type="text" class="swift-info" name="firstname" value="<?php echo $firstname;?>"><br>
					<span class="info">Last Name:</span><br><input type="text" class="swift-info" name="lastname" value="<?php echo $lastname;?>"><br> 
					<span class="info">Elementary School:</span><br><input type="text" class="swift-info school-settings" name="elemschool" value="<?php echo $es;?>"><div class="school-settings-text">Elementary School</div><br>
					<span class="info">Middle School: </span><br><input type="text" class="swift-info school-settings" name="midschool" value="<?php echo $ms;?>"><div class="school-settings-text">Middle School</div><br>
					<span class="info">Interests:</span><br><input type="text" class="swift-info" name="interests" value="<?php echo $interests;?>"><br>
					<span class="info-bio-settings">Bio: </span><br><textarea  class = "bio-settings" name="bio"><?php echo $bio;?></textarea><br>

					<input type="submit" name="submitInputs" class="btn btn-success submitsettings" value="Save Changes">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal">Close</button>
			</div>
		</div>

	</div>
</div>
<div class="banner">
	<div id="fullscreen-img-wrapper">
		
	</div>
	<div class="profilepic"></div>

	<!--<input class = "report" type="submit" name="report" value="Report">-->
	<?php
	if($username != $profileUser){
		if(in_array($username, $followersArray)){
			echo '
			<button id = "follow" class = "unfollow" onclick="removeFollowing();">Unfollow</button>
			';
		}else{
			echo '
			<button id = "follow" class = "follow" onclick="addFollowing();">Follow</button>
			';
		}

		echo '
		<button class = "message-btn">Message</button>
		';
	}

	?>
</div>
<div class="option-tabs">
	<div class="tabs profile-tab"><b>P</b>rofile</div>
	<div class="tabs following-tab"><b>F</b>ollowing<span class="num-follow" id = "followingCount"><?php echo $followingCount; ?></span></div>
	<div class="tabs followers-tab"><b>F</b>ollowers<span class="num-follow" id = "followersCount"><?php echo $followersCount; ?></span></div>
	<div class="tabs photos-tab"><b>P</b>hotos</div>
</div>
<div class="left-col">
	<div class="about-me">
		<span class="about-me-tag"><?php echo $firstname . " " . $lastname; ?></span><br>
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
<div class="pm-body">
	<div class="usersearchbar-wrapper">
		<div class="usersearch-tool-wrapper">
			<span class="usersearch-tool glyphicon glyphicon-search"></span>
		</div>
		<input class = "search-users" id = "search-users" placeholder = "Lookup!" />
		<span class="glyphicon glyphicon-remove message-box-close"></span>
	</div>
	<div id = "users">
		
	</div>
</div>
<div class="messages-wrapper">
	<div class="top-message-wrapper">
		<span class="glyphicon glyphicon-arrow-left arrow-back"></span>
		<div class="messenger-info">
			<div id="messenger-pic"></div>
			<span id="messenger-name"></span>
		</div>
	</div>
	<div id="messages">

	</div>
	<div class="bottom-message-wrapper">
		<input type = 'text' name = 'sendingText' class = 'sendingText' sending-to = '' placeholder = 'Type a Message...' id = 'sendingText' autocomplete="off" ></input>
		<input type = 'text' name = 'msg-id' id = 'msg-id' style = "display: none;" />
	</div>
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
	$(".pm-body").hide();
	$(".messages-wrapper").hide();
	$(".arrow-back").click(function(){
		$(".messages-wrapper").hide("slide", { direction: "left" }, 500);
	});
	$(".message-box-close").click(function(){
		$(".pm-body").hide("slide", { direction: "right" }, 500);
	});
	var disable_msg_update = false;
	$(".speech").click(function() {
		$(".pm-body").show("slide", { direction: "right" }, 500);
		$('#users').load('action/users.php', function() {

			$('.each-user').click(function(){
				var pic = $(this).children().first().css("background-image");
				var name = $(this).children().first().next().text();

				$(".messages-wrapper").show("slide", { direction: "left" }, 500);
				$("#messenger-pic").css("background-image", pic);
				$("#messenger-name").html(name);
				$(this).children().first().css("background-image");
				var lastid = 0;
				toId = $(this).attr('uid');
				$("#sendingText").attr("sending-to", toId);
				$("#msg-id").val(toId);
				url = 'action/messages.php?from=<?php echo $username; ?>&toid='+toId+'&getnew=0';

				$('#messages').load(url, function() {
					var objDiv = document.getElementById("messages");
					objDiv.scrollTop = objDiv.scrollHeight;
					setTimeout(insertNewMsg,1000);
				});
	            //alert('from: <?php echo $username; ?>  toid: ' + toId);
	        });
		});       

		$('#search-users').on("input", function()  {
	        /*var search_users_by = this.value;
	        $('#users').load('users.php?s='+search_users_by, function() {
		        $('.each-user').click(function(){
		        var lastid = 0;
		        $(".messages-wrapper").show("slide", { direction: "left" }, 500);
				//alert('user clicked');
				var toId = $(this).attr('uid');
				alert(toId);
				url = 'action/messages.php?from=<?php echo $username; ?>&toid='+toId;
				
				$('#messages').load(url, function() {
					var objDiv = document.getElementById("messages");
					objDiv.scrollTop = objDiv.scrollHeight;
					setTimeout(insertNewMsg,1000);
					
				});
				//alert('from: <?php echo $username; ?>  toid: ' + toId);
		        });
		    });*/
		});
	});
	$("#sendingText").keyup(function(event){
		if(event.keyCode == 13){
			disable_msg_update = true;
			var msgText = $("#sendingText").val();
			var sendingToId = $("#sendingText").attr("sending-to");	
			$.post( "action/add_msg.php", { sendmsg: msgText, sendto: sendingToId }, function() {disable_msg_update = false;});	
			$("#sendingText").val("");    	
		}
	});
	function insertNewMsg(){
		if (disable_msg_update) {
			setTimeout(insertNewMsg,1000);
			return;
		}
		lastid = $(".last_text").last().text();	
		if(lastid == ""){
			lastid = 0;
		}
		url = 'action/messages.php?from=<?php echo $username; ?>&toid='+toId+'&getnew='+lastid;	

		fromUser = "<?php echo $username; ?>";
		$.get("action/messages.php",{from : fromUser, toid : toId, getnew: lastid}, function(newMsgs) {		
			var info = newMsgs;
			if(info != ""){			
				$('#messages').append(newMsgs);
				var objDiv = document.getElementById("messages");
				objDiv.scrollTop = objDiv.scrollHeight;
			}
			setTimeout(insertNewMsg,1000);		
		});
	}
	$(document).ready(function(){
		$(".profile-tab").click(function(){
			$(".center-col").load("action/bringpostscode.html", function() {
				$("#postarea").load("postmethods/textpost.html");

				$(".profile-tab").css("border-bottom", "5px solid #ec6002");

				$(".followers-tab").css("border-bottom", "0");
				$(".following-tab").css("border-bottom", "0");
				$(".photos-tab").css("border-bottom", "0");

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
			});
		});
		$(".followers-tab").click(function(){
			$(".center-col").load("action/bringfollowers.php?u=<?php echo $profileUser; ?>");

			$(".followers-tab").css("border-bottom", "5px solid #ec6002");

			$(".profile-tab").css("border-bottom", "0");
			$(".following-tab").css("border-bottom", "0");
			$(".photos-tab").css("border-bottom", "0");
		});

		$(".following-tab").click(function(){
			$(".center-col").load("action/bringfollowing.php?u=<?php echo $profileUser; ?>");

			$(".following-tab").css("border-bottom", "5px solid #ec6002");

			$(".profile-tab").css("border-bottom", "0");
			$(".followers-tab").css("border-bottom", "0");
			$(".photos-tab").css("border-bottom", "0");
		});

		$(".photos-tab").click(function(){
			$(".center-col").load("action/bringphotos.php?u=<?php echo $profileUser; ?>");

			$(".photos-tab").css("border-bottom", "5px solid #ec6002");

			$(".profile-tab").css("border-bottom", "0");
			$(".following-tab").css("border-bottom", "0");
			$(".followers-tab").css("border-bottom", "0");
		});

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

function addFollowing() {

	var text = <?php echo '"'.$profileUser.'"'; ?>;
	var addurl = "action/addfollowings.php?addto="+text;

	$.ajax({url: addurl, success: function(){
		$("#follow").attr('class', 'unfollow');
		$("#follow").attr('onclick', 'removeFollowing();');
		$("#follow").html("Unfollow");
		var i = $("#followersCount").html();
		i = Number(i) + 1;
		$("#followersCount").html(i);
	}});
}

function removeFollowing() {

	var text = <?php echo '"'.$profileUser.'"'; ?>;
	var addurl = "action/removefollowings.php?rem="+text;

	$.ajax({url: addurl, success: function(){
		$("#follow").attr('class', 'follow');
		$("#follow").attr('onclick', 'addFollowing();');
		$("#follow").html("Follow");
		var i = $("#followersCount").html();
		i = Number(i) - 1;
		$("#followersCount").html(i);
	}});
}

function likePost(id) {
	var addurl = "action/likepost.php?id="+id;
	var postid = "#like-btn-"+id;
	$.ajax({url: addurl, 
		success: function(){
			$(postid).attr('class', 'liked');
			$(postid).attr('onclick', 'unlikePost(' + id + ')');
		},
		error: function(){
			alert("failed");
		}
	});
}
function unlikePost(id) {
	var addurl = "action/unlikepost.php?id="+id;
	var postid = "#like-btn-"+id;
	$.ajax({url: addurl, 
		success: function(){
			$(postid).attr('class', 'notliked');
			$(postid).attr('onclick', 'likePost(' + id + ')');
		},
		error: function(){
			alert("failed");
		}
	});
}

/*var $document = $(document);

$document.scroll(function() {
  if ($document.scrollTop() >= 300) {

  	alert("hello");

  } else {
  }
});*/

function postcomment(curr_position) {
	var url="action/post-comment.php";
	var comment = $(curr_position).children().first().val();
	comment = comment.replace('\'','');
	var id    = $(curr_position).children().first().next().val();
	var  data = "comment="+comment+"&id="+id;
	alert(data);
	var comment_html1 =
	"<div style = 'position: relative;'>"+
	"	<div class = 'comment-body'>"+
	"    <div style = '"+ "background-image:url(<?php echo $yourprofilepic; ?>);" + "' class = 'comments-img'></div>" +
	"    <div class = 'comment-area'>"+
	"      <div style = 'position: relative;'>";
	var comment_html2 =
	"        <div style = 'position: relative;'>"+
	"          <div class = 'comment-like' style = 'position:absolute; top: -3px;'></div>"+
	"        </div>"+
	"      </div>"+
	"    </div>"+
	"  </div>"+
	"</div>";
	$.ajax({
		url:url,
		type:'post',
		data:data, 
		success:function(commentText){
			if(commentText == ""){
				return;
			}
			var commenttxt =
			"          <div class = 'commentPosted'>"+
			"            <a style='position: relative;top: 0px; left: 0px;' href = '/bruinskave/php/profile.php?u=<?php echo $username; ?>'><?php echo $username; ?></a>&nbsp;&nbsp;&nbsp;" + commentText +
			"          </div>";
			curr_position.parent().before(comment_html1+commenttxt+comment_html2);

			$(".comment-inputs").val("");
            //stopCommentPosting = false;
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	alert("failed");
        }
    });
}
</script>
</body>
</html>
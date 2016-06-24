<?php require "../system/connect.php"; 

if (isset($_GET['u'])) {
	$profileUser = $_GET['u'];

	$check = $conn->query("SELECT * FROM users WHERE username='$profileUser'");
	if ($check->num_rows == 1) {
	
		$get = $check->fetch_assoc();

		$followers = $get['followers'];

		$followersArray = explode(",", $followers);
	}
}

foreach ($followersArray as $value) {
	$getFollowerQuery = $conn->query("SELECT * FROM users WHERE username='$value'");
	if ($getFollowerQuery->num_rows == 1) {

		$get = $getFollowerQuery->fetch_assoc();

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
		$profilepic = $get['profile_pic'];
		$bannerimg = $get['bannerimg'];
		$bio = $get['bio'];
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
	}
	echo '
	<div class="cover-card">
		<div class="banner-cover-card" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(' . $bannerimg . ');">
			<div class="info-bar-left">
				
			</div>
			<div class="info-bar-right">
				<div class="follow-pic" style="background-image:url(' . $profilepic . ');"></div>
			</div>
		</div>
	</div>
	'
	;
}

?>
<style type="text/css">
	.cover-card{
		width: 300px;
		height: 200px;
		border: 1px solid #c9c8c8;
		display: inline-block;
		background-color: #fff;
		border-radius: 5px;
	}
	.banner-cover-card{
		height: 100px;
		width: 300px;
		background-size: cover;
		background-repeat: no-repeat;
		border-top-right-radius: 5px;
		border-top-left-radius: 5px;
	}
	.info-bar-right{
		float: right;
	}
	.follow-pic{
		height:110px;
		width: 110px;
		background-size: cover;
		background-repeat: no-repeat;
		position: relative;
		right: 20px;
    	top: 40px;
	}
</style>
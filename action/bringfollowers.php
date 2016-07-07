
<div class="follow-cover">
<?php require "../system/connect.php"; 

session_start();
if (isset($_SESSION['user_login'])) {
	$username = $_SESSION['user_login'];
}
else{
	$username = "";
}

$check = $conn->query("SELECT * FROM users WHERE username='$username'");
if ($check->num_rows == 1) {
	$get = $check->fetch_assoc();
	$userfollowing = $get['following'];
	$userfollowingArray =  explode(",", $userfollowing);
}

if (isset($_GET['u'])) {
	$profileUser = $_GET['u'];

	$check = $conn->query("SELECT * FROM users WHERE username='$profileUser'");
	if ($check->num_rows == 1) {
	
		$get = $check->fetch_assoc();

		$followers = $get['followers'];

		$followersArray = explode(",", $followers);
	}
}
if($followers != "" || $followers != NULL){
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
		$sex = $get['sex'];

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
		$button = "";
		if($username != $value){
			if(in_array($value, $userfollowingArray)){
				$button = '<button class = "unfollow-btn-card" nameuser = "'.$value.'">Unfollow</button>';
			}else{
				$button = '<button class = "follow-btn-card" nameuser = "'.$value.'">Follow</button>';
			}
		}
	}
	echo '
	<div class="cover-card">
		<div class="banner-cover-card" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),url(' . $bannerimg . ');">
			<div style="position:relative;">
			<div class = "name-card">
				<span class = "firstname-card">' .  $firstname . ' </span>
				<span class = "lastname-card">' . $lastname . '</span>
			</div>
			</div>
			<div class="info-bar-left">
				<div class = "bio-info"> ' . $bio . '</div>
			</div>
			<div class="info-bar-right">
				<div class="follow-pic" style="background-image:url(' . $profilepic . ');"></div>
				' . 
				$button

				. '
			</div>
		</div>
	</div>
	'
	;
}
}

?>
</div>
<script type="text/javascript">
	$(".follow-btn-card").click(function(){
		var text = $(this).attr("nameuser");
		var addurl = "action/addfollowings.php?addto="+text;

		$.ajax({url: addurl, success: function(){
			$(this).attr('class', 'unfollow-btn-card');
			$(this).html("Unfollow");
			var i = $("#followersCount").html();
			i = Number(i) + 1;
			$("#followersCount").html(i);
		}});
	});
	$(".unfollow-btn-card").click(function(){
		var text = $(this).attr("nameuser");
		var addurl = "action/removefollowings.php?rem="+text;

		$.ajax({url: addurl, success: function(){
			$(this).attr("class", "follow-btn-card");
			$(this).html("Follow");
			var i = $("#followersCount").html();
			i = Number(i) - 1;
			$("#followersCount").html(i);
		}});
	});

</script>
<style type="text/css">
	.cover-card{
		width: 300px;
		height: 200px;
		border: 1px solid #c9c8c8;
		display: inline-block;
		background-color: #fff;

		margin-left: 10px;
		margin-bottom: 10px;
	}
	.banner-cover-card{
		height: 100px;
		width: 299px;
		margin-right: 1px;
		background-size: cover;
		background-repeat: no-repeat;

	}
	.info-bar-right{
		float: right;
	}
	.info-bar-left{
		float: left;
	}
	.follow-pic{
		height:110px;
		width: 110px;
		background-size: cover;
		background-repeat: no-repeat;
		position: relative;
		right: 20px;
    	top: 35px;
    	border: 4px solid white;
    	border-radius: 56px;
	}
	.follow-cover{
		position: relative;
		top:50px;
		left:-10px;
	}
	.bio-info{
		display: inline-block;
		width: 157px;
		height: 86px;
		overflow:hidden;
		position: relative;
		top: 105px;
		left: 7px;
		line-height: 18px;
		font-size: 12px;
		font-family: 'PT Serif Caption';
		color: #727272;
	}
	.follow-btn-card{
		position: relative;
		right: 20px;
		top: 35px;
		height: 33px;
		width: 110px;
		background: #1da1f2;
		color: white;
		border: 0;
		border-radius: 8px;
		outline:0;
	}
	.unfollow-btn-card{
		position: relative;
		right: 20px;
		top: 35px;
		height: 33px;
		width: 110px;
		background: #ea201b;
		color: white;
		border: 0;
		border-radius: 8px;
		outline:0;
	}
	.follow-btn-card:hover{
		background: white;
		border: 1px solid #1da1f2;
		color: #1da1f2;
	}
	.name-card{
		position: absolute;
	    width: 150px;
	    height: 45px;
	    top: 55px;
	    left: 10px;
	    color: white;
	    font-size: 20px;
	    line-height: 19px;
	}
</style>    
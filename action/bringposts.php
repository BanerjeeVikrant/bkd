<?php include '../system/connect.php';?>
<?php 
session_start();
if (isset($_SESSION['user_login'])) {
	$username = $_SESSION['user_login'];
}
else{
	$username = "";
}


?>

<?php


if (isset($_GET['u'])) {
	$profileUser = $_GET['u'];
	
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
		$bio = $get['bio'];
		$sex = $get['sex'];
		$interests = $get['interests'];
		$dob = $get['dob'];
		$followers = $get['followers'];	
		$following = $get['following'];
	}
}
$offset = $_GET['o'];
$checkme = $conn->query("SELECT * FROM users WHERE username='$username'");
if ($checkme->num_rows == 1) {
	
	$getuser = $checkme->fetch_assoc();
	
	$yourfirstname = $getuser['first_name'];
	$yourgrade = $getuser['grade'];
	if($yourgrade == 9){
		$yourgrade = "Freshman";
	}else if($yourgrade == 10){
		$yourgrade = "Sophomore";
	}else if($yourgrade == 11){
		$yourgrade = "Junior";
	}else if($yourgrade == 12){
		$yourgrade = "Senior";
	}
	$yourlastname = $getuser['last_name'];
	$yoursignupdate= $getuser['sign_up_date'];
	$yourprofilepic = $getuser['profile_pic'];
	$yourbio = $getuser['bio'];
	$yoursex = $getuser['sex'];
	$yourinterests = $getuser['interests'];
	$yourdob = $getuser['dob'];
	$yourfollowers = $getuser['followers'];	
	$yourfollowing = $getuser['following'];	
}

$getposts = $conn->query("SELECT * FROM posts WHERE user_posted_to='$profileUser' ORDER BY id DESC LIMIT $offset,20") or die(mysql_error());
$tags = array();

/* //function identifyTagsInMsg($msg) {
	$tags = array();
	$msg_space = split(' ',$msg);
	for($i=0; $i < count($msg_space); $i++) {
	    $msg_comma = split(',',$msg_space[$i]);
	    for($j=0; $j < count($msg_comma); $j++) {
	    	    $new_msg_comma = $msg_comma[$j];
		    if (preg_match('/^http:/',$msg_comma[$j]) || preg_match('/^https:/',$msg_comma[$j])) {
		    	$new_msg_comma = "<a href=\'".$msg_comma[$j]."\'>".$msg_comma[$j]."</a>";
		    } else {
		    	$msg_dot = split('\.',$msg_comma[$j]);
			for($k=0; $k < count($msg_dot); $k++) {
				if (preg_match('/^\#/',$msg_dot[$k])) {
				    array_push($tags, $msg_dot[$k]);
				    $new_msg_dot = "<a class=\'msg-tag\' href=#>".$msg_dot[$k]."</a>";
				    //$new_msg_dot = "<a href=\'/v2/profile.php?u=ssdf\'>tag</a> start ".$msg_dot[$k];
				} elseif (preg_match('/^\@/',$msg_dot[$k])) {
				    $new_msg_dot = "<a href='/bruinskave/php/profile.php?u=".substr($msg_dot[$k],1)."'>".$msg_dot[$k]."</a>";
				} else {
				    $new_msg_dot = $msg_dot[$k];
				}
				if ($k == 0) {
				    $new_msg_comma = $new_msg_dot;
				} else {
				    $new_msg_comma = $new_msg_comma.".".$new_msg_dot;
				}
			}
		    }
		    $msg_comma[$j] = $new_msg_comma;
	    }
	    $msg_space[$i] = join(',',$msg_comma);
	}
	$msg = join(' ',$msg_space);
	return $msg;
}*/
if($getposts->num_rows > 0) {
	while ($row = $getposts->fetch_assoc()) {
		$id = $row['id'];
		$hidden = $row['hidden'];
		if($hidden == '1'){
			continue;
		}
		$body = $row['body'];	

		/* //$body = identifyTagsInMsg($body);*/
		$pic = '';
		$vid = '';
		$youtube = '';
		$likedby = $row['liked_by'];
		$likedbyArray = explode(",",$likedby);
		$countLikes = count($likedbyArray);
		if($countLikes > 1){
			$numberLikes = "<span class='count-likes'>$countLikes likes</span>";
		}
		else if($countLikes == 1){
			$numberLikes = "<span class='count-likes'>$countLikes like</span>";
		}
		else{
			$numberLikes = "";
		}
		if(in_array($username, $likedbyArray)){
			$userliked = "<div class = 'like-btn-div'><div id='like-btn-$id' class = 'liked' onclick = 'unlikePost($id);'></div></div>";
		}
		else{
			$userliked = "<div class = 'like-btn-div'><div id='like-btn-$id' class = 'notliked' onclick = 'likePost($id);'></div></div>";
		}
		$picture_added = $row['picture'];
		$video_link = $row['youtubevideo'];
		$video_added = $row['video'];
		if($picture_added != NULL || $picture_added != ""){
			$pic = "<img src = '$picture_added' class = 'posted-pic'></img>";
		}else if($video_added != NULL || $video_added != ""){
			$vid = "
			<video class = 'posted-video' controls loop>
				<source src='$video_added' type='video/mp4'>
					<source src='$video_added' type='video/ogg'>
						Your browser does not support HTML5 video.
					</video>";
				}else if($video_link != NULL || $video_link != ""){
					$youtube = "<iframe class = 'youtube-link-iframe' src='$video_link' frameborder='0' allowfullscreen></iframe>";
				}
				$date_added = $row['date_added'];
				$added_by = $row['added_by'];
				$time_added = $row['time_added'];
				$username_posted_to = $row['user_posted_to'];
				$commentsid = $row['commentsid'];
				
				$sql = "SELECT * FROM users WHERE username='$added_by'"; 
				$result = $conn->query($sql);
				$pic_row  = $result->fetch_assoc();
				$userpic =  $pic_row['profile_pic'];
				$usersex = $pic_row['sex'];
				if($userpic == "" || $userpic == NULL){
					if($usersex == "1"){
						$userpic = "https://upload.wikimedia.org/wikipedia/commons/3/34/PICA.jpg";
					}
					else{
						$userpic = "http://ieeemjcet.org/wp-content/uploads/2014/11/default-girl.jpg";
					}
				}
				$userfirstname = $pic_row['first_name'];
				$userlastname = $pic_row['last_name'];
				$topName = '';
				if($username == $profileUser){
					$hide = "<a href = 'deleteposts.php?p=$id' class = 'glyphicon glyphicon-remove'></a>";
				}
				if($added_by != $profileUser){
					$topName = "<a href = '/bruinskave/php/profile.php?u=$added_by' class = 'posted-by-name'>$userfirstname $userlastname</a>
					<span class = 'glyphicon glyphicon-triangle-right arrow'>
					</span><a href = '/bruinskave/php/profile.php?u=$profileUser' class = 'posted-to-name'>$firstname $lastname</a>";
				} else{
					$topName = "<a href = '/bruinskave/php/profile.php?u=$added_by' class = 'samepostedby'>$firstname $lastname</a>";
				}
				
				$commentsArray = [];
				
				if ($commentsid != "") {
					$commentsArray = explode(",",$commentsid);
				}
				echo "
				<div class = 'profile-post'>
					<div style = 'position: relative;'>
						<div class = 'glyphicon glyphicon-option-vertical post-options'>
							<div class = 'postoptions-div' style = 'display: none; position: absolute;top: 19px;left:-113px;background-color: #F3F3F3;width: 126px;height: 90px;'>
								
								<div class = 'hide-post post-work' style = ''> <span class = 'glyphicon glyphicon-lock'></span> Hide</div>
								<div class = 'delete-post post-work' style = ''> <span class = 'glyphicon glyphicon-remove'></span> Delete</div>
								<div class = 'report-post post-work' style = ''> <span class = 'glyphicon glyphicon-flag'></span> Report</div>
							</div>
						</div>
					</div>
					<div class = 'posted-by-img' style = 'background-image: url($userpic);'></div>
					<span class = 'topName'>
						$topName<br>
						<span class = 'time'>$time_added<span>, </span>$date_added</span>
					</span>
					<div style='position:relative;'>
						$numberLikes
					</div>
					<p class = 'msg-body'>$body</p>
					$pic
					$vid
					$youtube
				</div>
				<div class = 'comments-box'>";
					
					foreach ($commentsArray as $value) {
						$getCommentQuery = $conn->query("SELECT * FROM comments WHERE id='$value' LIMIT 1");
						$getCommentRow = $getCommentQuery->fetch_assoc();
						$commentPost = $getCommentRow['comment'];
						$commentpostedby =  $getCommentRow['from'];
						$getUser = $conn->query("SELECT * FROM users WHERE username = '$commentpostedby'");
						$getfetch = $getUser->fetch_assoc();
						$userpic = $getfetch['profile_pic'];
						echo "		
						<div style = 'position: relative;'>			
							<div class = 'comment-body'>
								<div style = 'background-image:url($userpic);' class = 'comments-img'></div>
								<div class = 'comment-area'>
									<div style = 'position: relative;'>
										<div class = 'commentPosted'>
											<a style='position: relative;' href = 'profile.php?u=$commentpostedby'>$commentpostedby</a>&nbsp;&nbsp;&nbsp;$commentPost
											
										</div>
									</div>
								</div>
							</div>
						</div>
						
						";
					}
					
					echo "	
				</div>
				<textarea style = 'display: none;' id = 'comments-send'></textarea>
				<div class = 'comments-input'>
					<div style = 'position: relative;'>
						$userliked
					</div>
					<form method = 'POST' class='post-comment'>
						<input type = 'text' name = 'comment' placeholder = 'Write a Comment&hellip;' class = 'comment-inputs' autocomplete = 'off' />
						<input type = 'text' name = 'id' value = '$id' style = 'display: none;' />
						<input type = 'submit' id = 'commentid' name = 'commentid' style = 'display: none;'/>	
					</form>		
				</div>";
				
			}	
		} else {
			echo "	
			<div style = 'position: relative;'>
				<div class = 'profile-post' id='last_post' style ='position: absolute;'>
					<span><span class  = 'glyphicon glyphicon-share-alt'></span> No more Feeds!<span>
				</div>
			</div><script>document.getElementById('loading-img').remove();</script>
			";
		}
		
		?>
		<script>

			$('.post-comment').submit(function(e){
				e.preventDefault();
				var curr_position = $(this).closest('.post-comment');
				postcomment(curr_position);
				e.unbind();
			});

			var postoptionOpen = false;

			$(".post-options").click(function() {
				if(postoptionOpen == false){
					$(this).find(".postoptions-div").css("display", "block");
					postoptionOpen = true;
				}
				else if (postoptionOpen == true){
					$(this).find(".postoptions-div").css("display", "none");
					postoptionOpen = false;
				}
			});
			
		</script>
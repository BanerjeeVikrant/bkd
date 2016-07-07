<?php
require "../system/connect.php";

session_start();
if (isset($_SESSION['user_login'])) {
	$username = $_SESSION['user_login'];
}
else{
	$username = "";
}

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$getphotos = $conn->query("SELECT * FROM photos WHERE id='$id'");

	if($getphotos->num_rows == 1) {
		$row = $getphotos->fetch_assoc();

		$postid = $row['post_id'];
		$photo_link = $row['photo_link'];
		$photoSender = $row['username'];

		$getUser = $conn->query("SELECT * FROM users WHERE username='$photoSender'");
		$getU = $getUser->fetch_assoc();

		$userpic = $getU['profile_pic'];
		$firstname = $getU['first_name'];
		$lastname = $getU['last_name'];
		$topName = "<a href = 'profile.php?u=$photoSender' class = 'samepostedby'>$firstname $lastname</a>";

		echo "
			<div class='photo-fullscreen-div-wrapper'>
				<span class = 'glyphicon glyphicon-remove' id = 'close-fullscreen'></span>
				<div class='left-col-img-wrapper'>
					<div class='picture-wrapper'>
						<img src = '$photo_link' class = 'fullscreen-photo' />
					</div>
				</div>
		";
		echo"
				<div class='right-col-img-wrapper'>
		";
		$sql = "SELECT * FROM posts WHERE id='$postid'";
		$getpost = $conn->query($sql);
		if($getpost->num_rows == 1) {
			$get = $getpost->fetch_assoc();
			$body = $get['body'];
			$time_added = $get['time_added'];
			$date_added = $get['date_added'];
			$commentsid = $get['commentsid'];
			$likedby = $get['liked_by'];

			$commentsArray = explode(",",$commentsid);
			$likedbyArray = explode(",",$likedby);

			if(in_array($username, $likedbyArray)){
				$userliked = true;
			}
			else{
				$userliked = false;
			}

			echo "
				<div class = 'profile-post' style = 'width:600px'>
					<div style = 'position: relative;'>
					<div class = 'glyphicon glyphicon-option-vertical post-options' style = 'left:520px'>
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
					<p class = 'msg-body'>$body</p>
				</div>
				<div class = 'comments-box'>
			";

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
					<div class = 'comment-body' style = 'width:600px'>
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
			<textarea style = 'display: none;' id = 'comments-send'></textarea>
			<div class = 'comments-input'>
				<div style = 'position: relative;'>
				<div class = 'like-btn-div'><div class = 'notliked'></div></div>
				</div>
				<form method = 'POST' class='post-comment'>
				  <input type = 'text' name = 'comment' placeholder = 'Write a Comment&hellip;' class = 'comment-inputs' autocomplete = 'off' style = 'width:550px' />
				  <input type = 'text' name = 'id' value = '$postid' style = 'display: none;' />
				  <input type = 'submit' id = 'commentid' name = 'commentid' style = 'display: none;'/>	
				</form>		
			</div>";
		}
		echo"
				</div>
			</div>
			<script>

			</script>
		";
	}
}
?>

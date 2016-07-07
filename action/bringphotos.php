<div class="photo-cover">
<?php
	require "../system/connect.php";

	if(isset($_GET['u'])){
		$profileUser = $_GET['u'];

		$getphotos = $conn->query("SELECT * FROM photos WHERE username='$profileUser' ORDER BY id DESC");

		if($getphotos->num_rows > 0) {
			while ($row = $getphotos->fetch_assoc()) {
				$photo_id = $row['id'];
				$photo_link = $row['photo_link'];
				$post_id = $row['post_id'];

				echo '
					<div class="photo-div-wrapper">
						<div class="photo-div" photoid = "'.$photo_id.'" style="background-image: url('.$photo_link.');"></div>
					</div>
				';
			}
		}
	}
?>
</div>
<script type="text/javascript">
$(".photo-div").click(function(){
	var id = $(this).attr("photoid");
	var url = "action/bringfullscreenphoto.php?id="+id;
	$.ajax({url: url, success: function(result){
		$("#fullscreen-img-wrapper").html(result);
		$('#close-fullscreen').click(function(){
			$('#fullscreen-img-wrapper').html('');
		});
		$('.post-comment').submit(function(e){
		    e.preventDefault();
		    var curr_position = $(this).closest('.post-comment');
		    postcomment(curr_position);
		    e.unbind();
		});		
	},
	error: function(jqXHR, textStatus, errorThrown) {
        alert(textStatus);
    }});
});
</script>
<style type="text/css">
	.photo-cover{
		position: relative;
		top: 45px;
	}
	.photo-div-wrapper{
		display: inline-block;
		margin: 5px;
	}
	.photo-div{
		height: 270px;
		width: 270px;
		display: inline-block;
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center;
		cursor: pointer;
	}
</style>
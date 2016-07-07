<?php 
	require "connect.php"; 

/*	
	if ($_SERVER['HTTP_CLIENT_IP']!="") {
	    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	else if ($_SERVER['HTTP_X_FORWARDED_FOR']!=""){
	    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} 
	else {
	    $ip = $_SERVER['REMOTE_ADDR'];
	}
*/

	//background color is defined in jquery.
	$background = "#e6e6e6";
	$backgroundDark = "#7b7b7b";
	$profilePic = "http://www.deliophotostudio.com/miami_passport_photos/miami-passport-photos.jpg";

	session_start();
	if (isset($_SESSION['user_login'])) {
		$username = $_SESSION['user_login'];
	}
	else{
		$username = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>BruinsKave</title>

	<link rel="shortcut icon" href="/bkd/img/bearpic.png">

	<!--other resourses, external source(help)-->
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=IM+Fell+English+SC" />
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Carter+One" />
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Alice" />
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=PT+Serif+Caption" />

	<!--jquery 2.2.0-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>

	<!--angularjs 1.4.8-->
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

	<!--bootstrap 3.3.6-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- style sheets-->
	<link rel = "stylesheet" type = "text/css" href = "/bkd/css/style.css" />

	<!-- javascript files-->
	<script src = "/bkd/js/main.js"></script>

	<style type="text/css">	

		html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, address, cite, code, del, dfn, em, img, ins, kbd, q, samp, small, strong, sub, sup, var, b, i, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, figure, footer, header, hgroup, menu, nav, section, time, mark, audio, video {
			font-family: inherit;
			margin: 0;
			padding: 0;
		    border: 0;
		    outline: 0;
		    font-size: 100%;
		    vertical-align: baseline;
		}

		body{
			overflow-x: hidden;
		}

		.top-nav{
			display: inline-block;
		    background: #1d2d4a;
		    width:100vw;
		}

		.logo{
			width: 45px;
			height: 45px;
			margin-left: 20px;
			margin-top:5px;
			border-radius: 45px;
		}
		.logo-wrapper{
			cursor: pointer;
		}
		.logo-wrapper, .searchbar-wrapper, .speech-wrapper, .options-nav, .notifications-wrapper, .crush-wrapper,.about-btn-wrapper, .usersearchbar-wrapper{
			display: inline-block;
		}

		.logo-name{
			color: white;
			font-size: 25px;
			font-family: 'IM Fell English SC';
			position: relative;
			top:-11px;
			left:5px;
		}

		.search-tool-wrapper{
			background-color: #222;
			border-top-left-radius: 45px;
			border-bottom-left-radius: 45px;
			display: inline-block;
			width:30px;
			height:30px;
			padding:4px;
			padding-left: 10px;
			position: relative;
			top: -11px;
			left: 14px;
			/*border-top:1px solid white;
			border-bottom:1px solid white;
			border-left:1px solid white;*/
			font-family: verdana;
		}

		.search-tool{
			font-size: 15px
		}
		.glyphicon-search{
		    color:#e2e8eb;
		}

		.search{
			width: 20vw;
			background-color: #222;
			color:#e2e8eb;
			border-top-right-radius: 45px;
			border-bottom-right-radius: 45px;
			outline: none;
			border: 0;
			height: 30px;
			position: relative;
			top: -11px;
			left: 10px;
			padding-left:5px;
			font-family: 'PT Serif Caption';
			/*border-top:1px solid white;
			border-bottom:1px solid white;
			border-right:1px solid white;*/
		}
		.home-img{
			display:inline-block;
			position: relative;
			width: 40px;
			height: 40px;
			margin: 5px;
			border-radius: 45px;
			float: right;
			cursor: pointer;
			top: 5px;
			left:120px;

			background-repeat: no-repeat;

			background-position: center center; 
		}
		.speech-wrapper{
			position: relative;
			float:right;
			right: 42px;
			top: 15px;
			cursor: pointer;
		}

		.notifications-wrapper{
			position: relative;
			float:right;
			right: 120px;
			top: 15px;
			cursor: pointer;
		}
		.crush-wrapper{
			position: relative;
			float:right;
			right: 200px;
			top: 15px;
			cursor: pointer;
		}
		.notifications{
			display:inline-block;
			position: relative;
			width: 40px;
			height: 40px;
			margin: 5px;
			border-radius: 45px;
			float: right;
			cursor: pointer;
			top: -10px;
			left:35px;

			background-repeat: no-repeat;

			background-position: center center; 
		}
		.crush-notification{
			display:inline-block;
			position: relative;
			width: 40px;
			height: 40px;
			margin: 5px;
			border-radius: 45px;
			float: right;
			cursor: pointer;
		    top: -10px;
		    left: 10px;

			background-repeat: no-repeat;

			background-position: center center; 
		}
		.speech{
			display:inline-block;
			position: relative;
			width: 40px;
			height: 40px;
			margin: 5px;
			border-radius: 45px;
			float: right;
			cursor: pointer;
		    top: -10px;
		    left: 60px;

			background-repeat: no-repeat;

			background-position: center center; 
		}
		.options-nav{
			position: absolute;
			width: 150px;
			background: white;
			padding-top:5px;
			padding-bottom:5px;
			left:calc(100vw - 195px);
			top: 60px;
			box-shadow: 0px 1px 3px #607fd6;
			border-radius: 5px;
		}
		.options{
			font-size:15px;
			font-family: verdana;
			padding:2.5px;
			padding-left:12px;
		}
		.options:hover{
			background:#2B2A2A;
			color: white;
		}
		.glyphicon-triangle-top{
			color:white;
		}
		.tip-triangle{
			position: absolute;
			left: 132px;
			top: -12px;
		}
		.signup-btn-wrapper{
			display: inline-block;
			position: absolute;
			left: calc(90vw - 50px);
			top: 10px;
		}
		a{
			text-decoration: none !important;
		}
		.signup-btn{
		    width: 120px;
		    height: 40px;
			border:2px solid #29FFBF;
			border-radius: 10px;
			font-family: verdana;
			font-size: 17px;
			background: linear-gradient(#696767, #000000);
			color:#29FFBF;
			margin-left: 20px;
			outline:none;
		}
		.signup-btn:hover{
			color: #000;
			background: #29FFBF;
		}

		.about-btn{
		    width: 140px;
		    height: 40px;
			border:2px solid #CC6600;
			border-radius: 10px;
			font-family: verdana;
			font-size: 17px;
			background: linear-gradient(#696767, #000000);
			color: #CC6600;
			float: right;
			position: relative;
			right: 185px;
		    top: 10px;
		    outline:none;

		}
		.about-btn:hover{
			color: #000;
			background: #CC6600;
		}
	</style>


</head>
<body>
<div class = "background">
	<div class = "top-nav">
		<div class = "logo-wrapper">
			<img class="logo" src="/bkd/img/bearpic.png">
			<span class="logo-name">BruinsKave</span>
		</div>
		<?php
		if($username){
			echo '
				<div class="searchbar-wrapper">
					<div class="search-tool-wrapper">
						<span class="search-tool glyphicon glyphicon-search"></span>
					</div>
					<input class="search" type="text" placeholder="Search..." name="search" autocomplete="off">
				</div>

				<div class="crush-wrapper">
					<div class="crush-notification" style="background-image: url(/bkd/img/like.png);"></div>
				</div>

				<div class="notifications-wrapper">
					<div class="notifications" style="background-image: url(/bkd/img/notification-bell.png);"></div>		
				</div>

				<div class="speech-wrapper">
					<div class="speech" style="background-image: url(/bkd/img/speech-start.png);"></div>
				</div>
				<div class="home-img" data-toggle="modal" data-target="#myModal" style="background-image: url(/bkd/img/home.png);"></div>
				<!--<div class="options-nav">
				<span class="glyphicon glyphicon-triangle-top tip-triangle"></span>
					<div class="options">Settings</div>
					<div class="options">Feedback</div>
					<div class="options logout">Log Out</div>
				</div>-->
				
				';
		}else{
		echo'
			<div class = "about-btn-wrapper">
				<button class = "about-btn">Learn More</button>
			</div>
			<div class = "signup-btn-wrapper">
				<button class = "signup-btn">Sign Up</button>
			</div>
			';
		}
		?>
	</div>
</div>
<script type="text/javascript">
	//changing the background color to the variable $background
	$( "body" ).css( "background", "<?php echo $background; ?>" );

	$( ".search" ).click(function() {
		$( ".search" ).animate({ width: "40vw" }, 'slow');
	});

	/*var options_nav_open = false;
	$( ".options-nav" ).hide();

	$( ".settings-img" ).click(function() {

		if(options_nav_open == false){
			$( ".options-nav" ).show(100);
			options_nav_open = true;
		}
		else if(options_nav_open == true){
			$( ".options-nav" ).hide(100);
			options_nav_open = false;
		}
	});*/

</script>

<?php 
	include_once("session.php");
	include_once("dBug.php");
	include_once("recurse_copy.php");
	include_once("createThumbs.php");
	include_once("iniPHP.php");
	
	if(isset($_REQUEST["logout"])){
		session_unset();
		session_destroy();
		session_write_close();
	}
	if(!isset($_SESSION["start"])){
		header("Location:index.php");
	}
	

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Personal info</title>
		<link rel="stylesheet" type="text/css" href="./css/default.css" />
		<link rel="stylesheet" type="text/css" href="./css/component.css" />
		<link rel="stylesheet" type="text/css" href="./css/modules.css" />
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />
		<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="./js/loadJSON.js"></script>
		<script src="./js/modernizr.custom.js"></script>
		<script src="./js/modules.js"></script>
	</head>
	<body onload="imgLoad()">
		<a href="?logout" class="btn-logout" id="logout">Log Out</a>
		<div class="container">
			<header class="clearfix">
				<span>Year Book <span class="bp-icon bp-icon-about" data-content="A book containing photographs of the senior class in a school or college and details of activities in previous years"></span></span>
				<h1>A Look Back Before We Leap </h1>
				<nav>
					<a href="voteForm.php" class="bp-icon bp-icon-next" data-info="Next form"><span>Edit form</span></a>
				</nav>
			</header>	
			<div class="main">
				<form id="ybform" class="cbp-mc-form" action="form.php" method="post" enctype="multipart/form-data">
					<div class="cbp-mc-column">
						<label for="name">Name</label>
	  					<input type="text" id="name" name="name" placeholder="">
	  					<label for="nickName">Nick Name</label>
	  					<input type="text" id="nickName" name="nickName" placeholder="">
	  					<label for="email">Email Address</label>
	  					<input type="text" id="email" name="email" placeholder="">
	  					<label for="dob">Date of Birth</label>
	  					<input type="text" id="dob" name="dob" placeholder="dd-mm-yyyy">
						<label for="phone">Mobile Number</label>
	  					<input type="text" id="phone" name="phone" placeholder="(Optional)">
	  					<label for="address">Address</label>
	  					<textarea id="address" name="address" placeholder="Not going to send you letters.... But if you wish to give your address :P(Optional)"></textarea>
						<label for="personalPhoto">Upload your personal photo:</label>
					    <input id="perPhoto" type="file" accept="image/jpeg" name="photoPer"/>
						</br>
						<img id="imgPer" class="imgResize"/>
						<label for="gangPhoto">Upload your another gang photo:</label>
					    <input id="gangPhoto3" type="file" accept="image/jpeg" name="photoGang3"/>
						</br>
						<img id="imgGang3" class="imgResize"/>
					</div>
	  				<div class="cbp-mc-column">
						<label for="lifeLine">College life in one line</label>
						<input type="text" id="lifeLine" name="lifeLine" placeholder="">
						<label for="enggWord">Engineering in one word</label>
	  					<input type="enggWord" id="enggWord" name="enggWord" placeholder="">
						<label for="abtFrnds">About friends</label>
	  					<textarea id="abtFrnds" name="abtFrnds" placeholder="In 50 words"></textarea>
	  					<label for="embLife">Most Embarassing moment of your life</label>
	  					<textarea id="embLife" name="embLife" placeholder="In 50 words"></textarea>
					    </br></br></br>
						<div style="position:relative; top:7px;">
						<label for="gangPhoto">Upload your gang photo:</label>
					    <input id="gangPhoto" type="file" accept="image/jpeg" name="photoGang1"/>
						</br>
						<img id="imgGang" class="imgResize"/>
						</div>
					</div>
	  				<div class="cbp-mc-column">
						<label for="favProf">Favorite Professor in NMV</label>
	  					<input type="text" id="favProf" name="favProf" placeholder="">
	  					<label for="bondNMV">Bonding between you and NMV</label>
	  					<input type="text" id="bondNMV" name="bondNMV" placeholder="">
	  					<label for="addiction">Addicted to</label>
						<input type="text" id="addiction" name="addiction" placeholder="">
	  					<label for="unforDay">Unforgettable Day @ SASTRA</label>
	  					<textarea id="unforDay" name="unforDay" placeholder="In 50 words"></textarea>
						<label for="buckList">Bucket List</label>
	  					<textarea id="buckList" name="buckList" placeholder="Five things you want to do before you die"></textarea>	
<input type="hidden" name="default">
<input type="hidden" name="submitBtn" value=0>
						<label for="gangPhoto">Upload your another gang photo:</label>
					    <input id="gangPhoto2" type="file" accept="image/jpeg" name="photoGang2"/>
						</br>
						<img id="imgGang2" class="imgResize"/>
						
						</div>
					<div>
					
					</div>
					<div>
				
					</div>
					<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" id="save" type="submit" value="Save" /><input class="cbp-mc-submit" id="submit" type="submit" value="Submit" /></div>
				</form>
			</div>
			<header class="clearfix">
				<nav>
					<a href="voteForm.php" class="bp-icon bp-icon-next" style="position:relative; top:-100px; left:5px;" data-info="Next form"><span>Next form</span></a>
				</nav>
			</header>	
		</div>
	<script>
	function imgLoad(){
		function readURL(input,imgChng) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$(imgChng).attr('src', e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
			}

			$("#perPhoto").change(function(){
				readURL(this,$("#imgPer"));
			});
			$("#gangPhoto").change(function(){
				readURL(this,$("#imgGang"));
			});
			$("#gangPhoto2").change(function(){
				readURL(this,$("#imgGang2"));
			});
			$("#gangPhoto3").change(function(){
				readURL(this,$("#imgGang3"));
			});

				$("#perPhoto").change(function(event){
		var tmppath = URL.createObjectURL(event.target.files[0]);
		$("#imgPer").fadeIn("fast").attr("src", tmppath);
		});
		$("#gangPhoto").change(function(event){
		var tmppath = URL.createObjectURL(event.target.files[0]);
		$("#imgGang").fadeIn("fast").attr("src", tmppath);
		});
		$("#gangPhoto2").change(function(event){
		var tmppath = URL.createObjectURL(event.target.files[0]);
		$("#imgGang2").fadeIn("fast").attr("src", tmppath);
		});
		$("#gangPhoto3").change(function(event){
		var tmppath = URL.createObjectURL(event.target.files[0]);
		$("#imgGang3").fadeIn("fast").attr("src", tmppath);
		});
}
	</script>
</body>
</html>
<?php

	if(isset($_SESSION["new"]))
	{
		$pathToCopy = dirname(__FILE__)."/users/users_info/".$_SESSION["dir_id"]."/photo/";
		copy(dirname(__FILE__)."/setPermission.txt",$pathToCopy.".htaccess");
	echo "<script>setTimeout(displayBox('Use arrow in the right side to navigate pages'),3000);</script>";
		unset($_SESSION["new"]);
	}
	
		if(isset($_POST["default"]))
	{
		$file = dirname(__FILE__)."/users/users_info/".$_SESSION["dir_id"]."/data-1.info";//Change here to point to userid and name of the owner
		file_put_contents($file, json_encode($_REQUEST));
		move_uploaded_file($_FILES['photoPer'] ['tmp_name'], "./users/users_info/".$_SESSION['dir_id']."/photo/personalPhoto.jpg");
		move_uploaded_file($_FILES['photoGang1'] ['tmp_name'], "./users/users_info/".$_SESSION['dir_id']."/photo/gangPhoto.jpg");
		move_uploaded_file($_FILES['photoGang2'] ['tmp_name'], "./users/users_info/".$_SESSION['dir_id']."/photo/gangPhoto2.jpg");
		move_uploaded_file($_FILES['photoGang3'] ['tmp_name'], "./users/users_info/".$_SESSION['dir_id']."/photo/gangPhoto3.jpg");
		$imagePath = dirname(__FILE__)."/users/users_info/".$_SESSION["dir_id"]."/photo/";
		createThumbs($imagePath, dirname(__FILE__)."/users/users_info/".$_SESSION["dir_id"]."/thumbs/", 250);
		echo "<script>displayBox('Data Saved')</script>";
	}
	$string = file_get_contents("./users/users_info/".$_SESSION["dir_id"]."/data-1.info");
	$photo = "./users/users_info/".$_SESSION['dir_id']."/thumbs/personalPhoto.jpg";
	echo "<script>document.getElementById('imgPer').src='$photo';</script>";
	$photo = "./users/users_info/".$_SESSION['dir_id']."/thumbs/gangPhoto.jpg";
	echo "<script>document.getElementById('imgGang').src='$photo';</script>";
	$photo = "./users/users_info/".$_SESSION['dir_id']."/thumbs/gangPhoto2.jpg";
	echo "<script>document.getElementById('imgGang2').src='$photo';</script>";
	$photo = "./users/users_info/".$_SESSION['dir_id']."/thumbs/gangPhoto3.jpg";
	echo "<script>document.getElementById('imgGang3').src='$photo';</script>";
	echo "<script>$('#ybform').loadJSON($string)</script>";
?>
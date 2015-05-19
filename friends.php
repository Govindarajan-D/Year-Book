<?php 
	include_once("session.php");
	include_once("dBug.php");
	include_once("iniPHP.php");
	
	if(isset($_REQUEST["logout"])){
		session_unset();
		session_destroy();
		session_write_close();
	}
	if(!isset($_SESSION["dir_id"])){
		header("Location:index.php");
	}

?>
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>About Friends</title>
		<link rel="stylesheet" type="text/css" href="./css/default-vote.css" />
		<link rel="stylesheet" type="text/css" href="./css/component-vote.css" />
		<link rel="stylesheet" type="text/css" href="./css/modules.css" />
		<script src="./js/jquery.js"></script>
		<script src="./js/loadJSON.js"></script>
		<script src="./js/modernizr.custom.js"></script>
		<script src="./js/modules.js"></script>
		
	</head>
	<body>
	<a href="?logout=true" class="btn-logout" id="logout">Log Out</a>
		<div class="container">
			<header class="clearfix">
				<span>Year Book <span class="bp-icon bp-icon-about" data-content="A book containing photographs of the senior class in a school or college and details of activities in previous years"></span></span>
				<h1>A Look Back Before We Leap </h1>
				<nav>
					<a href="form.php" class="bp-icon bp-icon-prev" data-info="Prev form"><span>Previous Form</span></a>
					<a href="voteForm.php" class="bp-icon bp-icon-next" data-info="Next form"><span>Next form</span></a>
				</nav>
			</header>	
			<div class="main" id="voteForm">
				<form id="ybform2" class="cbp-mc-form-row" action="friends.php" method="post" >
					<div class="cbp-mc-row">
						<input type="text" name="FrndName" placeholder="Friend Name">						
	  				</div>
                                        <div class="cbp-mc-row">
						<textarea name="abtFrnd" placeholder="About Him/Her">	</textarea>					
	  				</div>
<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" id="save" type="submit" value="Save" /></div>
				</form>
			</div>
			<header class="clearfix">
				<nav>
					<a href="form.php" class="bp-icon bp-icon-prev" style="position:relative; top:-100px; left:0px;" data-info="Prev form"><span>Previous form</span></a>
					<a href="voteForm.php" class="bp-icon bp-icon-next" style="position:relative; top:-100px; left:0px;" data-info="Next form"><span>Next form</span></a>
				</nav>
			</header>	
		</div>
	</body>
</html>
<?php
	
		if(isset($_POST["default"]))
	{
		$file = dirname(__FILE__)."/users/users_info/".$_SESSION["dir_id"]."/data-2.info";//Change here to point to userid and name of the owner
		file_put_contents($file, json_encode($_REQUEST));
		echo "<script>displayBox('Data Saved')</script>";
	}
	$string = file_get_contents("./users/users_info/".$_SESSION["dir_id"]."/data-2.info");
	echo "<script>$('#ybform2').loadJSON($string)</script>";
?>		
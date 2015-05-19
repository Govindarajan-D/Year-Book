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
		<title>Voting</title>
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
					<a href="form.php" class="bp-icon bp-icon-prev" data-info="Prev form"><span>Previous form</span></a>
				</nav>
			</header>	
			<div class="main" id="voteForm">
				<form id="ybform2" class="cbp-mc-form-row" action="voteForm.php" method="post" >
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Padips</label>
						<input type="text" name="mrPadips" placeholder="">						
	  					<label for="Mr.Paidps">Ms.Padips</label>
						<input type="text" name="msPadips" placeholder="">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Cool</label>
	  					<input type="text" name="mrCool" placeholder="">
						<label for="Ms.Pretty">Ms.Pretty</label>
	  					<input type="text" name="msPretty" placeholder="">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Perfect</label>
	  					<input type="text" name="mrPerfect" placeholder="">
						<label for="Mr.Paidps">Ms.Perfect</label>
						<input type="text" name="msPerfect" placeholder="">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Sincere</label>
	  					<input type="text" name="mrSincere" placeholder="">
						<label for="Mr.Paidps">Ms.Sincere</label>
	  					<input type="text" name="msSincere" placeholder="">
						</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Rowdy</label>
	  					<input type="text" name="mrRowdy" placeholder="">
						<label for="Mr.Paidps">Ms.Rowdy</label>
	  					<input type="text" name="msRowdy" placeholder="">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Nerd</label>
	  					<input type="text" name="mrNerd" placeholder="">
						<label for="Mr.Paidps">Ms.Nerd</label>
	  					<input type="text" name="msNerd" placeholder="">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Mr.Talent</label>
	  					<input type="text" name="mrTalent" placeholder="">
						<label for="Ms.Padips">Ms.Talent</label>
	  					<input type="text" name="msTalent" placeholder="">
	  				</div>
					<h1>Best in</h1>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Behaviour</label>
	  					<input type="text" name="bbb" placeholder="Boy">
						<label for="Ms.Padips">Behaviour</label>
	  					<input type="text" name="bbg" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Attitude</label>
	  					<input type="text" name="bab" placeholder="Boy">
						<label for="Ms.Padips">Attitude</label>
	  					<input type="text" name="bag" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Patience</label>
	  					<input type="text" name="bpb" placeholder="Boy">
						<label for="Ms.Padips">Patience</label>
	  					<input type="text" name="bpg" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Simplicity</label>
	  					<input type="text" name="bsb" placeholder="Boy">
						<label for="Ms.Padips">Simplicity</label>
	  					<input type="text" name="bsg" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Frankness</label>
	  					<input type="text" name="bfb" placeholder="Boy">
						<label for="Ms.Padips">Frankness</label>
	  					<input type="text" name="bfg" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Dressing</label>
	  					<input type="text" name="bdb" placeholder="Boy">
						<label for="Ms.Padips">Dressing</label>
	  					<input type="text" name="bdg" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Helping</label>
	  					<input type="text" name="bhb" placeholder="Boy">
						<label for="Ms.Padips">Helping</label>
	  					<input type="text" name="bhg" placeholder="Girl">
	  				</div>
					<div class="cbp-mc-row">
						<label for="Mr.Paidps">Creativity</label>
	  					<input type="text" name="bcb" placeholder="Boy">
						<label for="Ms.Padips">Creativity</label>
	  					<input type="text" name="bcg" placeholder="Girl">
						<input type="hidden" name="default">
	  				</div>
					<div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" id="save" type="submit" value="Save" /></div>
				</form>
			</div>
			<header class="clearfix">
				<nav>
					<a href="form.php" class="bp-icon bp-icon-prev" style="position:relative; top:-100px; left:25px;" data-info="Prev form"><span>Previous form</span></a>
				</nav>
			</header>	
		</div>
	</body>
</html>
<?php
	
		if(isset($_POST["default"]))
	{
		$file = dirname(__FILE__)."/users/users_info/".$_SESSION["dir_id"]."/data-3.info";//Change here to point to userid and name of the owner
		file_put_contents($file, json_encode($_REQUEST));
		echo "<script>displayBox('Data Saved')</script>";
	}
	$string = file_get_contents("./users/users_info/".$_SESSION["dir_id"]."/data-3.info");
	echo "<script>$('#ybform2').loadJSON($string)</script>";
?>
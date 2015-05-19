<?php
	include_once("session.php");
	include_once("dBug.php");
	include_once("idtoken.php");
	include_once("iniPHP.php");
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sign-in form for MyAmbitionBox">
    <meta name="author" content="Govindarajan">
    <link rel="icon" href="icons/favicon.ico">
    <title>Year Book</title>
	<!--CSS-->
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/signin.css" rel="stylesheet">
    <link href="./css/modules-signin.css" rel="stylesheet">
	<!--JS-->
	<script src="./js/modules.js"></script>
	<script src="./js/form.js"></script>
	<script src="./js/sha512.js"></script>
	
  </head>
  <body onload="reset()">
    <div class="container">
		<h1 id="pageTitle" class="threeD-text">Year Book</h1>
		<h2 id="separator"><  ><h2>
		<div id="google-login">
		<? if (isset($authUrl)) { echo "<a href='" . $authUrl . "'><img src='images/Google_login.png' id='gl-image'/></a>";} ?>
		</div>
		<div id="normal-login">
			<form class="form-signin"  role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validate()">
				<h2 class="form-signin-heading">Sign in</h2>
				<div id="texts"><input type="text" class="form-control" name="user" placeholder="Username" required autofocus>
				<input type="password" name="pass" class="form-control" placeholder="Password" required></div></br>
				<input id="logIn" class="btn btn-lg btn-primary btn-block" type="submit" value="Log in">
				<input type="hidden" name="type" value="1">
				<input type="hidden" name="passw">
			</form>
			<button id="signUp" class="btn btn-lg btn-primary btn-block" onclick="signUp()">Sign up</button>
		</div>
    </div> <!-- /container -->
  </body>

</html>

<?php

if(isset($_SESSION["start"]))
		header("Location:form.php");// Change here to redirect to correct domain
	
	if(isset($_POST["type"])){
		if($_POST["type"] == "1")
			logIn();
		if($_POST["type"] == "2")
			signUp(); 
		}
	/* Naming Convention:
		1. user, passw and salt are used in both LogIn and SignUp. Hence to avoid confusion, they have been appended with L and S for LogIn and SignUp respectively 
		2. Names ending with R are retrieved from the database
	*/	
	function logIn(){
		if(isset($_POST["user"]) && isset($_POST["passw"]))
		{	
			/*Get username,password,directoryID from one database and salt from another database*/
			$my_sqlcon= new mysqli("");
			if ($my_sqlcon->connect_errno)
				echo "Failed. Try again" .mysqli_connect_error();
			
			$userL = strSafe($_POST["user"]);
			$passwL = strSafe($_POST["passw"]);
			$userS = $my_sqlcon->real_escape_string($userL);
			$passwS = $my_sqlcon->real_escape_string($passwL);
			
			$query = "SELECT passwhash FROM userlist WHERE name = '$userL'";
			if(!($retrieve = $my_sqlcon->query($query)))
				echo "Error - Hashed password Retreival";
				
				$row = $retrieve->fetch_row();
				$passHashedR = $row[0];
				
			$query = "SELECT uniqid FROM userlist WHERE name = '$userL'";
			if(!($retrieve = $my_sqlcon->query($query)))
				echo "Error - Unique ID Retrieval - LogIn";
			$row = $retrieve->fetch_row();
			$uniqIdR = $row[0];
			
			$query = "SELECT dir_id FROM userlist WHERE name = '$userL'";
			if(!($retrieve = $my_sqlcon->query($query)))
				echo "Error - Directory ID Retrieval";
			$row = $retrieve->fetch_row();
			$dir_idR = $row[0];
			
			 //Salt - separate DB
			 $my_sqlcon= new mysqli("");
			 $query = "SELECT salt FROM salt WHERE ID='$uniqIdR'";
			if(!($retrieve = $my_sqlcon->query($query)))
				echo "Error - Salt Retrieval";
			 $row = $retrieve->fetch_row();
			 $saltR = $row[0];
			 
			 /*Hash the salt got from Database and the password from user together - Check whether it is equal to the stored password*/
			 $psL = $passwL.$saltR;
			 $hashSaltPasswL = hash("sha512", $psL);
			if($hashSaltPasswL == $passHashedR){
					$_SESSION["start"]= "1";
					$_SESSION["dir_id"] = $dir_idR;
					$_SESSION["user"] = $userL;
					header("Location:form.php");
				}
			else
				echo "<script>displayBox('Username or password wrong');</script>";
		}
		
	}
	
	function signUp(){
		if(isset($_POST["user"]) && isset($_POST["passw"]))
		{	
			define("MYSQL_ERR_CODE_DUPLICATE","1062");
			
			$my_sqlcon= new mysqli("");
			if ($my_sqlcon->connect_errno)
			echo "Failed. Try again" .mysqli_connect_error();
	
			/*Get user name and password and generate a random salt for every user. Store username and password in one database(ambitionbox) and salt in seperate database(ambitionboxsalt)*/
			
			$userS = strSafe($_POST["user"]);
			$passwS = strSafe($_POST["passw"]);
			$userS = $my_sqlcon->real_escape_string($userS);
			$passwS = $my_sqlcon->real_escape_string($passwS);
			$saltS = bin2hex(mcrypt_create_iv(50, MCRYPT_DEV_URANDOM)); 
			
			/*Generate a unique directory ID and store it in the DB, this is different from the unique ID of the user*/
			$dir_idS = uniqid();
			$psS = $passwS.$saltS;
			$hashSaltPasswS = hash("sha512", $psS);
			/*Store the salted and hashed password together in database */
			$insertList = "INSERT INTO userlist(name,passwhash,dir_id)VALUES('$userS','$hashSaltPasswS','$dir_idS')" ;
			if(!$my_sqlcon->query($insertList))
			{
				if($my_sqlcon->errno == MYSQL_ERR_CODE_DUPLICATE)
					echo "<script>displayBox('Username exists');</script>";
				else
					printf("Error: %s", $my_sqlcon->error);
			}
			else 
			{
				$query = "SELECT uniqid FROM userlist WHERE name = '$userS'";
				if(!($retrieve = $my_sqlcon->query($query)))
					echo "Error - Unique ID Retrieval - SignUp";
				$row = $retrieve->fetch_row();
				$uniqIdR = $row[0];
				$my_sqlcon= new mysqli("");
				/*Store salt in separate Database*/
				$insertList = "INSERT INTO salt(ID,salt)VALUES('$uniqIdR','$saltS')" ;
				if(!$my_sqlcon->query($insertList))
					echo "Error - Salt Insertion". mysqli_error($my_sqlcon);
				else
				{	
					mkdir("./users/users_info/".$dir_idS, 0777);
					mkdir("./users/users_info/".$dir_idS."/photo/", 0777);
					mkdir("./users/users_info/".$dir_idS."/thumbs/", 0777);
					$_SESSION["start"]= "1";
					$_SESSION["new"] = "1";
					$_SESSION["dir_id"] = $dir_idS;
					$_SESSION["user"] = $userS;
					header("Location:form.php");
				}
			}
		}
		$my_sqlcon->close();
	}
	/* Function to remove unsafe characters */
		function strSafe($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
			}
	
?>
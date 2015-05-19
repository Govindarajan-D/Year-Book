<?php
include_once("dBug.php");
include_once("session.php");
include_once("iniPHP.php");

require_once realpath(dirname(__FILE__) . '/autoload.php');

//Constants
define("MYSQL_ERR_CODE_DUPLICATE","1062");

$client_id = '211147358402-q8hptjr6el9d3htauerr978p6ig853rb.apps.googleusercontent.com';
$client_secret = 'U9Iza2sQUHxkC41rzmqjudQg';
$redirect_uri = 'http://nmv2011.zz.mu/redirect.php';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope('profile');

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
    $accessToken = json_decode($_SESSION['access_token']);
$accessID = $accessToken->access_token;
$query = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=".$accessID;
$userinfo = file_get_contents($query);
$userinfoArray = json_decode($userinfo);

new dBug($userinfoArray);

$my_sqlcon= new mysqli("mysql.hostinger.in", "u383813282_govi", "password","u383813282_nmv20");
$insertList = "INSERT INTO user_Google(name,google_id,given_name)VALUES('$userinfoArray->name','$userinfoArray->id','$userinfoArray->given_name')" ;
			if(!$my_sqlcon->query($insertList))
			{
				if($my_sqlcon->errno == MYSQL_ERR_CODE_DUPLICATE){
					$dirquery = "SELECT dir_id FROM user_Google WHERE google_id='$userinfoArray->id' ";
					$retrieve = $my_sqlcon->query($dirquery);
					$row =$retrieve->fetch_row();
					$dir_id = $row[0];
					$_SESSION["dir_id"] = $dir_id;
					$_SESSION["start"]=1;
					header("Location:form.php");
				}
			}
			else{
						$dir_id=uniqid();
						mkdir("./users/users_info/".$dir_id, 0777);
						mkdir("./users/users_info/".$dir_id."/photos/", 0777);
						mkdir("./users/users_info/".$dir_id."/thumbs/", 0777);
						$updateQuery = "UPDATE user_Google SET dir_id='$dir_id' WHERE google_id='$userinfoArray->id' ";
						if(!$my_sqlcon->query($updateQuery))
							echo "Failed";
						else
						{
							$_SESSION["new"]=1;
							$_SESSION["dir_id"] = $dir_id;
							$_SESSION["start"]=1;
							header("Location:form.php");
						}
					}
}
?>
<?php
include_once("dBug.php");
include_once("session.php");
include_once("iniPHP.php");
unset($_SESSION["access_token"]);

require_once realpath(dirname(__FILE__) . '/autoload.php');

$client_id = '211147358402-q8hptjr6el9d3htauerr978p6ig853rb.apps.googleusercontent.com';
$client_secret = 'U9Iza2sQUHxkC41rzmqjudQg';
$redirect_uri = 'http://nmv2011.zz.mu/redirect.php';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('profile');

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
  $query = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=".$_SESSION['access_token'];
  $userinfo = file_get_contents($query);
  $userinfoArray = json_decode($userinfo);
}

?>
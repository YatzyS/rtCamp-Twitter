<?php
	session_start();
 	require_once 'config.php';
 	require 'TwitterOAuth/autoload.php';
  	use Abraham\TwitterOAuth\TwitterOAuth;
	if(!isset($_SESSION['access_token']))
 	{
	   
	    $request_token = [];
		$request_token['oauth_token'] = $_SESSION['oauth_token'];
		$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

		if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
		    exit("Something went wrong");
		}
		$connection = new TwitterOAuth($consumer_key, $consume_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
		$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
		$_SESSION['access_token'] = $access_token;
		header("Location: index.php");
	}
	else
	{
		header("Location:index.php");
	}

?>
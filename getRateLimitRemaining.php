<?php
	session_start();
	require_once 'config.php';
  	require 'TwitterOAuth/autoload.php';
  	use Abraham\TwitterOAuth\TwitterOAuth;
  	$access_token = $_SESSION['access_token'];
	$connection = new TwitterOAuth($consumer_key, $consume_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	$status = $connection->get("application/rate_limit_status");
	print_r($status);
?>
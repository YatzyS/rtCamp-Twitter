 	
<?php
	session_start();
	require_once 'config.php';
  	require 'TwitterOAuth/autoload.php';
  	use Abraham\TwitterOAuth\TwitterOAuth;
	if(isset($_SESSION['access_token']))
	{
	 	$access_token = $_SESSION['access_token'];
	    $connection = new TwitterOAuth($consumer_key, $consume_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	    $tweets = $connection->get("statuses/home_timeline",["count" => 10, "exclude_replies" => true]);
	    $_SESSION['tweets'] = $tweets;
	    $followers = $connection->get("followers/list",["count" => 10]);
	    $_SESSION['followers'] = $followers;
	    header("Location: index.php");
	}
	else
	{
		header("Location: index.php");
	}
?>
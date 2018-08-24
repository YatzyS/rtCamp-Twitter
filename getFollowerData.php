<?php
	session_start();
	require_once 'config.php';
  	require 'TwitterOAuth/autoload.php';
  	use Abraham\TwitterOAuth\TwitterOAuth;
	if(isset($_GET['screenNm']))
	{
		$access_token = $_SESSION['access_token'];
	    $connection = new TwitterOAuth($consumer_key, $consume_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	    $tweets = $connection->get("statuses/user_timeline",["screen_name" => $_GET['screenNm'],"count" => 10, "exclude_replies" => true]);
	    $_SESSION['tweets_follower'] = $tweets;
	    echo json_encode($tweets);
	   // header("Location: index.php");
	}
	else
	{
		echo "Didn't work";
		//header("Location: index.php");
	}
?>
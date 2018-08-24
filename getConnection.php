<?php
  
  session_start();
  require_once 'config.php';
  require 'TwitterOAuth/autoload.php';
  use Abraham\TwitterOAuth\TwitterOAuth;
  if(!isset($_SESSION['access_token']))
  {
    //Connect to API

    $connection = new TwitterOAuth($consumer_key, $consume_secret);

    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => "http://local.test/rtCamp/TwitterAssignment/callback.php"));

    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

    header("Location:".$url);
  }
  else
  {
    header("Location: index.php");
  }
?>
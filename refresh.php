<?php
	unset($_SESSION['tweets']);
	unset($_SESSION['tweets_follower']);
	unset($_SESSION['followers']);
	header("Location: getData.php")
?>
<?php
	session_start();
	require 'fpdf.php';
	require_once 'config.php';
  	require 'TwitterOAuth/autoload.php';
  	use Abraham\TwitterOAuth\TwitterOAuth;
	if(isset($_GET['format']) && isset($_GET['screenNm']) && isset($_GET['count']))
	{
		$access_token = $_SESSION['access_token'];
	    $connection = new TwitterOAuth($consumer_key, $consume_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	   	$count = $_GET['count'];
	   	$i=1;
	   	$followers = [];
	   	$followers[$i-1]['next_cursor'] = -1;
	   	$nxtCursor;
	   	while($count > 0)
	   	{
	   		if($count <200)
	   		{
	    		$followers[$i] = $connection->get("followers/list",["screen_name" => $_GET['screenNm'],"count" => $count, "cursor" => $followers[$i-1]['next_cursor']]);
	   		}
	    	else
	    	{
	    		$followers[$i] = $connection->get("followers/list",["screen_name" => $_GET['screenNm'],"count" => 200,"cursor" => $followers[$i-1]['next_cursor']]);
	    		$i++;
	    	}
	    	$count -= 200;
	    }
	    $followers = json_decode(json_encode( $followers ), True);
		$name = []; 
		$count_user = 0;
		for($j=1;$j<=$i;$j++)
		{
			for($k=0;$k<count($followers[$j]['users']);$k++)
			{
				$name[$count_user] = $followers[$j]['users'][$k]['name'];
				$count_user++;
			} 
		}
		if($_GET['format'] == "PDF")
		{
			$pdf = new FPDF();
			$pdf->AddPage();
			$pdf->SetFont('Times');
			for($j=0;$j<$count_user;$j++)
			{
				$pdf->Cell(20,5,$j+1,0);
				$pdf->Cell(0,5,$name[$j],0);
				$pdf->Ln();
				if($j%50==0 && $j!=0)
					$pdf->AddPage();
			}
			$pdf->Output();
		}
	}
	

?>
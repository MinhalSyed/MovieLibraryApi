<?php
	// process client request (via URL)
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
	include("../../functions.php");
	
	if(!empty($_GET['user'])){
		//
		$user=$_GET['user'];
		$response = get_watchlist($user);	
		deliver_response(200, '', $response);
	}
	else
	{
		deliver_response(400, "Invalid Request", Null);
	}
?>
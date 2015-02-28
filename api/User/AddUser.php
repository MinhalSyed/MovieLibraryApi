<?php
	// process client request (via URL)
	header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");
    header("Content-Type: application/json");
	include("../../functions.php");
	
	if(!empty($_GET['user']) && !empty($_GET['pass'])){
		//
		$username=$_GET['user'];
		$password=$_GET['pass'];
		$response = insert_user($username,$password);	
		deliver_response($response['status'], $response['message'], null);
	}
	else
	{
		deliver_response(400, "Invalid Request", Null);
	}
?>
<?php
	// process client request (via URL)
	header("Content-Type:application/json");
	include("functions.php");
	if(!empty($_GET['name'])){
		//
		$name=$_GET['name'];
		$price=get_price($name);
		
		if (empty($price)){
			//book not found
			deliver_response(404,"book not found", null);
		}
		else
			deliver_response(200,"book found", $price);		
	}
	else if(!empty($_GET['adduser']) && !empty($_GET['password'])){
		//
		$username=$_GET['adduser'];
		$password=$_GET['password'];
		try{
			create_user($username,$password);	
		}
		catch(Exception $e)
		{
			deliver_response(500,"Sucks", $username);	
		}
		deliver_response(400,"Created User", $username);	
	}
	else
	{
		deliver_response(400, "Invalid Request", Null);
	}
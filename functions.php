<?php
	include("db.php");
	function get_price($find){
		$books = array(
		"java"=>299,
		"c"=>348,
		"php"=>267
		);
		
		// foreach($books as $book=>$price)
		// {
			// if ($book==$find)
			// {
				// return $price;
				// break;
			// }
			
		// }
		return $books;
	}
	
	function create_user($username,$password)
	{
		insert_user($username,$password);
	}
	
	function add_movie($movieid, $title, $overview, $img, $release_date)
	{
		insert_movie(132, 'Live free or die hard', 'test test test', '', '');
	}
	
	function add_movie_to_watchlist($userid,$movieid, $ordering)
	{
		insert_to_watchlist($userid,$movieid, $ordering);
	}
	
	function deliver_response($status, $status_message, $data)
	{
		header("HTTP/1.1 $status $status_message");
		
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data'] = $data;
		
		$json_response = json_encode($response);
		echo $json_response;
	}
	
	//echo check();
	//resetDB();

?>
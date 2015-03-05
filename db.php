<?php
	include ("config.php");

	function check()
	{
		return "foobar";
	}

	function insert_user($user,$pass)
	{
		global $db_servername, $db_username, $db_password, $dbname;
		// Create connection
		$conn = mysqli_connect($db_servername, $db_username, $db_password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		//INSERT
		$sql = sprintf("INSERT INTO Users (username, password) VALUES ('%s', '%s')", $user, $pass);

		if ($conn->query($sql) === TRUE) {
			$response['status'] = 200;
			$response['message'] = "New record created successfully<br/>";
		} else {
			$response['status'] = 500;
			$response['message'] =  "Error: " . $sql . "<br>" . $conn->error;
		}
		
		mysqli_close($conn);
		
		return $response;

	}
	
	function insert_movie($movieid, $title, $overview, $img, $release_date)
	{
		global $servername, $username, $password, $dbname;
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		//INSERT
		$sql = sprintf("INSERT INTO Movies (movieid, title, overview, img, release_date) 
		VALUES ('%u', '%s','%s','%s','%s')", $movieid, $title, $overview, $img, $release_date );

		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully<br/>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		mysqli_close($conn);

	}
	
	function insert_to_watchlist($user,$movieid, $ordering)
	{
		global $servername, $username, $password, $dbname;
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		//INSERT
		$sql = sprintf("INSERT INTO WatchList (username, movieid, ordering) 
		VALUES ('%u', '%u','%u')", $user,$movieid, $ordering);

		if ($conn->query($sql) === TRUE) {
			echo "New record created successfully<br/>";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		mysqli_close($conn);
	}
	
	function get_watchlist($user)
	{
		global $db_servername, $db_username, $db_password, $dbname;
		// Create connection
		$conn = mysqli_connect($db_servername, $db_username, $db_password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		//INSERT
		
		$sql = "SELECT M.movieid, M.title, M.img  FROM WatchList W
						INNER JOIN Movies M on M.movieid = W.movieid
						where W.username = '$user'
						ORDER BY ORDERING";

		//SELECT * FROM WatchList where username =  ORDER BY ORDERING
		$result = $conn->query($sql);
		
		$movies = array();
		
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$movies[] =(int)$row['movieid'];
				
				//$movie['id'] = (int)$row['movieid'];
				//$movie['title'] = $row['title'];
				//$movie['img'] = $row['img'];
				
				//$movies[] = $movie;
			}
			return $movies;
		} else {
			echo "0 results";
		}
		mysqli_close($conn);
	}

function resetDB(){
	global $db_servername, $db_username, $db_password, $dbname;
		// Create connection
		$conn = mysqli_connect($db_servername, $db_username, $db_password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
	
	// Drop table
	$sql = "Drop TABLE Users";

	if (mysqli_query($conn, $sql)) {
		echo "Table Users dropped successfully<br/>";
	} else {
		echo "Error dropping table: " . mysqli_error($conn);
	}

	// Create table
	$sql = "CREATE TABLE Users (
	username VARCHAR(15) PRIMARY KEY,
	password VARCHAR(15) NOT NULL
	)";

	if (mysqli_query($conn, $sql)) {
		echo "Table Users created successfully<br/>";
	} else {
		echo "Error creating table: " . mysqli_error($conn);
	}
	
	//Insert Admin User into the DB:
	
	$sql = "INSERT INTO Users (username, password)
	VALUES ('Admin', '1234')";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	// Drop table
	$sql = "Drop TABLE Movies";

	if (mysqli_query($conn, $sql)) {
		echo "Table Movies dropped successfully<br/>";
	} else {
		echo "Error dropping table: " . mysqli_error($conn);
	}

	// Create table
	$sql = "CREATE TABLE Movies (
	movieid INT(6) UNSIGNED PRIMARY KEY, 
	title VARCHAR(256) NOT NULL,
	overview VARCHAR(500),
	img VARCHAR(256),
	release_date TIMESTAMP
	)";

	if (mysqli_query($conn, $sql)) {
		echo "Table Movies created successfully<br/>";
	} else {
		echo "Error creating table: " . mysqli_error($conn);
	}
	
	// Drop table
	$sql = "Drop TABLE WatchList";

	if (mysqli_query($conn, $sql)) {
		echo "Table WatchList dropped successfully<br/>";
	} else {
		echo "Error dropping table: " . mysqli_error($conn);
	}

	// Create table
	$sql = "CREATE TABLE WatchList (
		username VARCHAR(15),
		movieid INT(6) UNSIGNED,
		ordering INT(6) NOT NULL,
		CONSTRAINT Pk_Watchlist PRIMARY KEY (username,movieid),
		FOREIGN KEY (username) REFERENCES Users(username),
		FOREIGN KEY (movieid) REFERENCES Movies(movieid)
	)";

	if (mysqli_query($conn, $sql)) {
		echo "Table WatchList created successfully<br/>";
	} else {
		echo "Error creating table: " . mysqli_error($conn);
	}
	
	//Insert Mock Data
	
	$sql = "INSERT INTO Movies (movieid, title, img, release_date) VALUES (76203, '12 Years a Slave', 'https://image.tmdb.org/t/p/w130/kb3X943WMIJYVg4SOAyK0pmWL5D.jpg','2013');
			INSERT INTO Movies (movieid, title, img, release_date) VALUES (136400, '2 Guns', 'https://image.tmdb.org/t/p/w130/30lM3Uvzs6HOG5l4hzhwxYTWgd3.jpg','2013');
			
			INSERT INTO WatchList (username, movieid, ordering)	VALUES ('Admin', 136400, 0);
			INSERT INTO WatchList (username, movieid, ordering)	VALUES ('Admin', 76203, 1)";
	
	if ($conn->multi_query($sql) === TRUE) {
		echo "New record created successfully<br/>";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	mysqli_close($conn);
}




?>
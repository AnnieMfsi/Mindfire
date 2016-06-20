<?php
	$host = 'localhost';
	$uName = 'root';
	$password = 'mindfire';
	$database = 'RestaurantDatabase2';

	$conn = mysqli_connect($host, $uName, $password, $database);
	if (mysqli_connect_error($conn)) {
		die('Failed to connect to MySQL' .mysqli_connect_error());
	}


	$sql = 'SELECT  Name FROM tbl_Customer';
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		print_r($row); echo '<br>';
	}




	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($result)) {
		print_r($row); echo '<br>';
	}


	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_array($result)) {
		print_r($row); echo '<br>';
	}

	exit;

	mysqli_close($conn);

?>
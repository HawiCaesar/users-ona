<?php

//connect to database and fetch data

$mysqli = new mysqli("localhost", "root", "root", "ona");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if ($result = $mysqli->query("SELECT * from county")) {

    while($row = $result->fetch_assoc()) {
		$rows[]=$row;
	}

    $result->close();
}

print_r($rows);

//fetch ona users via curl




?>
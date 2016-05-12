<?php

//connect to database and fetch data

$mysqli = new mysqli("localhost", "root", "toor1", "ona");

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

//print_r($rows);die;

//fetch ona users via curl

$url = 'https://api.ona.io/api/v1/users';

$ch = curl_init();

// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

$decoded_usernames=json_decode($result,true);

foreach ($decoded_usernames as $value){

	if($value['first_name']==""){
		$usersnames[] = $value['username'];
	}

	$total_usersnames[] = $value['first_name'];
}
//print_r($total_usersnames);die;


$total_without_first_name = count($usersnames);
$total_users = count($total_usersnames);


$percenatge_tests_and_errors=array();
$resultant_pie_chart = array();
$percenatge_tests_and_errors['type']='pie';
$percenatge_tests_and_errors['name']='Value';

$key=0;

$array1[$key]['name']='Total Users';
$array1[$key]['y']=(int)$total_users;
$array1[$key]['color']='#c65b08';

$array1[$key+1]['name']='Users without first Names';
$array1[$key+1]['y']=(int)$total_without_first_name;
$array1[$key+1]['color']='#2372b2';		
$percenatge_tests_and_errors['data']=$array1;
array_push($resultant_pie_chart,$percenatge_tests_and_errors);

echo json_encode($resultant_pie_chart);




?>
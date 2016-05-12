<?php

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

$county_count = 0;
$reminder = 0;

$data110 = array();
$data1120 = array();
$data2030 = array();
$data3047 = array();

foreach ($rows as $row) {

	//echo $total_number_users."<br />";
	$rand = rand(1, 47);

	//echo "random number is ".$rand."<br />";

	// $county_count+=1;

	// echo $total_number_users."-".$rand."=".$reminder = $total_number_users-=$rand."<br />";
	// echo "___________________________________________".$row['id']."<br />";

	if($rand>=1 && $rand <10){
		$data110[]= array('value'=>$rand,'code'=>$row['c_code']);
	}elseif($rand>=10 && $rand <20){
		$data1120[]= array('value'=>$rand,'code'=>$row['c_code']);
	}elseif($rand>=20 && $rand <30){
		$data2030[]= array('value'=>$rand,'code'=>$row['c_code']);
	}elseif($rand>=30){
		$data3047[]= array('value'=>$rand,'code'=>$row['c_code']);
	}
	
}

echo "<pre>";
print_r($data110);
echo "</pre>";

echo "<pre>";
print_r($data1120);
echo "</pre>";

echo "<pre>";
print_r($data2030);
echo "</pre>";

echo "<pre>";
print_r($data3047);
echo "</pre>";

//Map stuff
// $a = array(
// 			array(

// 				'name' => '>=1 Users <10 Users',
// 				'color' => '#D54339',
// 				'data' => $data110
// 				),
// 			array(

// 				'name' => '>=10 Users <20 Users',
// 				'color' => '#495136',
// 				'data' => $data1120
// 				),
// 			array(

// 				'name' => '>= 20 Users < 30 Users',
// 				'color' => '#2372b2',
// 				'data' => $data2030
// 				),
// 			array(

// 				'name' => '>=30 Users',
// 				'color' => '#c65b08',
// 				'data' => $data3047
// 				)
// 		);

// echo json_encode($a);


?>
<?php

$mysqli = new mysqli("localhost", "username", "password", "database");

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

}

$total_without_first_name = count($usersnames)."<br />";

$data110 = array();
$data1120 = array();
$data2030 = array();
$data3047 = array();
$data4047 = array();

foreach ($rows as $row) {
	$map_data = $total_without_first_name-$row['value'];

	if($map_data>=5000){
		$data110[]= array('value'=>$map_data,'code'=>$row['c_code']);
	}elseif($map_data<=4999 && $map_data>=4500){
		$data1120[]= array('value'=>$map_data,'code'=>$row['c_code']);
	}elseif($map_data<=4499 && $map_data>=4000){
		$data2030[]= array('value'=>$map_data,'code'=>$row['c_code']);
	}elseif($map_data<=3999 && $map_data>=3500){
		$data3047[]= array('value'=>$map_data,'code'=>$row['c_code']);
	}elseif($map_data<=3499){
		$data4047[]= array('value'=>$map_data,'code'=>$row['c_code']);
	}
	
}

// echo "<pre>";
// print_r($data110);
// echo "</pre>";

// echo "<pre>";
// print_r($data1120);
// echo "</pre>";

// echo "<pre>";
// print_r($data2030);
// echo "</pre>";

// echo "<pre>";
// print_r($data3047);
// echo "</pre>";

//Map stuff
$a = array(
			array(

				'name' => '> = 5000 Users',
				'color' => '#D54339',
				'data' => $data110
				),
			array(

				'name' => '< = 4999 - > = 4500 Users',
				'color' => '#495136',
				'data' => $data1120
				),
			array(

				'name' => '< = 4499 - 4000 Users',
				'color' => '#2372b2',
				'data' => $data2030
				),
			array(

				'name' => '< = 3499 - 3500 Users',
				'color' => '#c65b08',
				'data' => $data3047
				),
			array(

				'name' => '< = 3499',
				'color' => '#69827f',
				'data' => $data4047
				)
		);

 echo json_encode($a);


?>
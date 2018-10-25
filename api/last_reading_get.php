<?PHP
// add connected community readings

require "cc_data_connect.php";

date_default_timezone_set("Australia/Brisbane");

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
	// echo "get most recent temperature";
	
	//var_dump($_GET);
	
	// verify device variables
	$deviceverified = false;
	
	// get post information
	$photon_device_id = $_GET['coreid'];
	$info_requested = $_GET['data'];
	
	//verify device
	$qrystmt = $db_con->prepare("SELECT * from devices WHERE photon_device_id = :deviceid");
	$qrystmt->bindParam(':deviceid', $photon_device_id, PDO::PARAM_STR);
	$qrystmt->execute();
	
	$result = $qrystmt->fetchAll();
	
// 	echo json_encode($result);
	$number_of_results = count($result);
// 	echo $number_of_results;
	
	if ($number_of_results==1)
	{
		//echo "Success - device verified";
		$deviceverified = true;
	}
	else if ($number_of_results==0)
	{
		echo "Error 002 - device not verified: ".$photon_device_id;
	}
	else
	{
		echo "Error 003 - problem verifying device";
	}
	
	// **** if verified push data into DB
	if ($deviceverified)
	{
		$qrystmt2 = $db_con->prepare("SELECT reading_value FROM readings_data WHERE reading_value_description = :info_requested ORDER BY reading_id DESC LIMIT 1");
		$qrystmt2->bindParam(':info_requested', $info_requested, PDO::PARAM_STR);
		$qrystmt2->execute();
	
		$result = $qrystmt2->fetchColumn();
		
		echo $result;
	}
		
	
	
}
else
{
	echo "Error 001 - request";	
}


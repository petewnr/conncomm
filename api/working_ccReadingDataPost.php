<?PHP
// add waste data

require "cc_data_connect.php";

date_default_timezone_set("Australia/Brisbane");

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
	// verify device variables
	$deviceverified = false;
	
	// get post information
	$photon_device_id = $_POST['coreid'];
	$reading_info = $_POST['data'];
	
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
		echo "Success - device verified";
		$deviceverified = true;
	}
	else if ($number_of_results==0)
	{
		echo "Error 002 - device not verified";
	}
	else
	{
		echo "Error 003 - problem verifying device";
	}
	
	// **** if verified push data into DB
	if ($deviceverified)
	{
		// get reading details from data variable
		$reading_json = json_decode($reading_info);
		$reading_value = $reading_json->readingvalue;
		$reading_data_type = $reading_json->readingdatatype;
		$reading_value_description = $reading_json->readingvaluedescription;
		$reading_date = $reading_json->readingdate;
		$reading_time = $reading_json->readingtime;
		$reading_hour = $reading_json->readinghour;
		$received = date('d/m/Y h:i:s a', time());
		
		
		try
		{
			$qrystmt = $db_con->prepare("INSERT INTO readings_data (photon_device_id, reading_value, reading_data_type, reading_value_description, reading_date, reading_time, reading_hour, received) VALUES (:photon_device_id, :reading_value, :reading_data_type, :reading_value_description, :reading_date, :reading_time, :reading_hour, :received)");
			$qrystmt->bindParam(':photon_device_id', $photon_device_id, PDO::PARAM_STR);
			$qrystmt->bindParam(':reading_value', $reading_value, PDO::PARAM_STR);
			$qrystmt->bindParam(':reading_data_type', $reading_data_type, PDO::PARAM_STR);
			$qrystmt->bindParam(':reading_value_description', $reading_value_description, PDO::PARAM_STR);
			$qrystmt->bindParam(':reading_date', $reading_date, PDO::PARAM_STR);
			$qrystmt->bindParam(':reading_time', $reading_time, PDO::PARAM_STR);
			$qrystmt->bindParam(':reading_hour', $reading_hour, PDO::PARAM_STR);
			$qrystmt->bindParam(':received', $received, PDO::PARAM_STR);
			
			$qrystmt->execute();
			
			
			$last_id = $db_con->lastInsertId();
			
			echo "reading for ".$photon_device_id." added to DB as id:".$last_id;
		}
		catch (PDOException $e)
		{
			echo "Error in GET all team details"/$e->getMessage();
		}	
	}
	
}
else
{
	echo "Error 001: incorrect request";
}
?>
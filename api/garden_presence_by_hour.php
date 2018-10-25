<?PHP
// add connected community readings

require "cc_data_connect.php";

date_default_timezone_set("Australia/Brisbane");

if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
	// echo "get most recent temperature";
	
	// verify device variables
	$deviceverified = false;
	
	// get post information
	$photon_device_id = $_GET['coreid'];
	
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
		echo "Error 002 - device not verified";
	}
	else
	{
		echo "Error 003 - problem verifying device";
	}
	
	// **** if verified push data into DB
	if ($deviceverified)
	{
		
		$time_value_day = time() - (24 * 60 * 60);
		//echo $time_value_day;
		$qrystmt2 = $db_con->prepare("SELECT reading_hour, SUM(reading_value) FROM readings_data WHERE reading_value_description = 'activation_count' AND reading_time > :timevalueday GROUP BY reading_hour");
		$qrystmt2->bindParam(':timevalueday', $time_value_day, PDO::PARAM_INT);
		$qrystmt2->execute();
	
		$result = $qrystmt2->fetchAll();
		
		//echo sizeof($result);
		$result_json = json_encode($result);
		//echo $result_json;
		$resultString = "";
		$starthour = 7;
		$endhour = 18;
		$resultAdded = false;
		
		for ($i = $starthour; $i <= $endhour; $i++)
		{
			for($j = 0; $j < sizeof($result); $j++)
			{	
				if ($result[$j][0] == $i)
				{
					$resultString .= $result[$j][1];
					$resultAdded = true;
				}
			}
			
			if ($resultAdded)
			{
				$resultAdded = false;
			}
			else
			{
				$resultString .= "0";
			}
			
			if ($i < $endhour)
			{
				$resultString .= ",";
			}
		}
		echo $resultString;
	}
		
	
	
}
else
{
	echo "Error 001 - request";	
}


<?PHP
//readings dbconnection
$db_host = "localhost";
$db_name = "cc_data";
$db_user = "cc_device_user";
$db_password = "this*is*cc_device_user*30007000";

$db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
$db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// test connection
try 
{
	$testresult = $db_con->query("SELECT * FROM readings_data");
	//echo "Connected to db";
} 
catch(PDOException $err) 
{
	echo "An Error occured!";
	echo $err->getMessage();
	//some_logging_function($ex->getMessage());
}

?>
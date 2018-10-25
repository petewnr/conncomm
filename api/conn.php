<?PHP
// dbconnection

$servername = "localhost";
$username = "justareducewebuser";
$password = "just**a_REDUCE_web**user";

try
{
	$conn = new PDO("mysql:host=$servername;dbname=reduce", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	echo "Connected to amazingdb successfully";
}
catch (PDOException $e)
{
	//echo "Connection failed: ".$e->getMessage();
}


?>
<?PHP
$servername = "localhost";
$username = "garden_webuser";
$password = "G8CNPolQcIKSsb59";

try
{
	$conn = new PDO("mysql:host=$servername;dbname=thegardenworkshops", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connected to thegardenworkshops successfully";
}
catch (PDOException $e)
{
	echo "Connection failed: ".$e->getMessage();
}

	
?>
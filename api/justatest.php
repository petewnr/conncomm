<?PHP
if ($_SERVER['REQUEST_METHOD'] === 'GET') 
{
	$_formdata = $_POST['data'];
	
	echo "post receieved: ".$_formdata;
}
else
{
	echo "Error 001 - request";	
}

	
?>
<?PHP
// register participant

require "connect.php";

$form_name = $_POST['name'];
$form_email = $_POST['email'];
$form_phone = $_POST['phone'];
$form_workshops = $_POST['workshops'];
$form_comments = $_POST['comments'];

try
{
	$qrystmt = $conn->prepare("INSERT INTO registrations (name, email, contactphone, workshops, comments) VALUES (:newname, :newemail, :newphone, :newworkshops, :newcomments)");
	$qrystmt->bindParam(':newname', $form_name, PDO::PARAM_STR);
	$qrystmt->bindParam(':newemail', $form_email, PDO::PARAM_STR);
	$qrystmt->bindParam(':newphone', $form_phone, PDO::PARAM_STR);
	$qrystmt->bindParam(':newworkshops', $form_workshops, PDO::PARAM_STR);
	$qrystmt->bindParam(':newcomments', $form_comments, PDO::PARAM_STR);
	
	$qrystmt->execute();
	
	
	$last_id = $conn->lastInsertId();
	
	echo "Success ".$form_name." registered as id:".$last_id;
}
catch (PDOException $e)
{
	echo "Error in POST new participant"/$e->getMessage();
}

$conn=null;
	
?>
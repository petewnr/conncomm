$(document).ready(function()
{
	console.log("workshops.js is active");
	
	$("#registerbtn").on("click", function(event)
	{
		event.preventDefault();
		console.log("registerbtn has been clicked");
		var registrationDetails = $('#workshopRegistrationForm').serialize();
		console.log(registrationDetails);
		
		$.post("../api/registerparticipant.php", $('#workshopRegistrationForm').serialize())
			.done(function(data)
			{
				//alert("done:" + data);
				alertMessage("success", "Thanks! Your registration has been received.");
			})
			.fail(function(data)
			{
				console.log("post failed");
				alertMessage("danger", "Sorry, there was a problem with your registration.  Please check your details and try again.");
			})
	});
	
	function alertMessage(type, msg)
	{
		$('#registrationmessages').removeClass();
		var alerttype = "alert alert-" + type;
		$('#registrationmessages').addClass(alerttype);
		$('#registrationmessages').text(msg);
	}
})
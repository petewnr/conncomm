$(document).ready(function()
{
	console.log("coursedetails.js active");
	
	tabOptions();
	tabDetailsOnOpen();
	
	$('.tab-option').on('click', function()
	{
		$('.tab-option').each(function()
		{
			$(this).data('selected', 'N');
			$(this).removeClass('text-info');
		});
		
		$(this).data('selected', 'Y');
		var newTabDetails = $(this).data('tabdetails');
		
		tabOptions();
		
		$('.tab-details').each(function()
		{
			if ($(this).data('selected')=='Y')
			{
				$(this).data('selected', 'N');
				$(this).fadeOut("slow", function()
				{
					$(newTabDetails).data('selected', 'Y');
					fadeInSelectedTab();
				});
			}
		})
	})
	
	
	function tabOptions()
	{
		$('.tab-option').each(function()
		{
			if ($(this).data('selected')=='Y')
			{
				$(this).addClass('text-info');
			}
		})
	}
	
	function tabDetailsOnOpen()
	{
		$('.tab-details').each(function()
		{
			if ($(this).data('selected')=='Y')
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
		})
	}
	
	function fadeInSelectedTab()
	{
		$('.tab-details').each(function()
		{
			if ($(this).data('selected')=='Y')
			{
				$(this).fadeIn("slow");
			}
		})
	}
});
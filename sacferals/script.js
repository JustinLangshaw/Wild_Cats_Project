$(document).ready(function () 
{
    $('.checkdisplay').change(function () 
	{
        if (this.checked) 
		{ 
          $('.todisplay').fadeIn('fast'); 
        }
        else 
		{
          $('.todisplay').fadeOut('fast'); 
        }

    });
});


function displayForm(c) {
    if (c.value == "catcolony") {    
        jQuery('#catcolony1').fadeIn('fast');
        jQuery('#intervention1').fadeOut('fast'); 
    }
    if (c.value == "intervention") {
         jQuery('#intervention1').fadeIn('fast');
         jQuery('#catcolony1').fadeOut('fast'); 
    }

    if (c.value == "Yes") {
	if(c.name == "caregiver[]")
	    $("#feederID").fadeOut('fast');
	if(c.name == "recentlyinjured[]")
	    jQuery('#recentlyinjuredID').fadeIn('fast');
	if(c.name == "othersworking[]")
	    jQuery('#othersworkingID').fadeIn('fast');
    }
    if (c.value == "No") {	
	if(c.name == "caregiver[]")
	    $("#feederID").fadeIn('fast');
	if(c.name == "recentlyinjured[]")
	    jQuery('#recentlyinjuredID').fadeOut('fast');
	if(c.name == "othersworking[]")
	    jQuery('#othersworkingID').fadeOut('fast'); 
    }
};

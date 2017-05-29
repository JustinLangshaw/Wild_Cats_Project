$(document).ready(function () {
    $('.checkdisplay').change(function () {
        if (this.checked) { 
          $('.todisplay').fadeIn('slow'); 
        }
        else {
          $('.todisplay').fadeOut('slow'); 
        }

    });
});


function displayForm(c) {
    if (c.value == "catcolony") 
	{    
        jQuery('#catcolony1').fadeIn('fast');
        jQuery('#intervention1').fadeOut('fast'); 
    }
    if (c.value == "intervention") 
	{
         jQuery('#intervention1').fadeIn('fast');
         jQuery('#catcolony1').fadeOut('fast'); 
    }
	if (c.value == "Yes") 
	{
         jQuery('#othersworkingID').fadeIn('fast');
    }
	if (c.value == "No") 
	{
         jQuery('#othersworkingID').fadeOut('fast'); 
    }
};
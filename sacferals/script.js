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


function displayForm(c) 
{
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

	if (c.value == "Yes") 
	{
         jQuery('#recentlyinjuredID').fadeIn('fast');
    }
	if (c.value == "No") 
	{
         jQuery('#recentlyinjuredID').fadeOut('fast'); 
    }
};

/*window.onload = function() // always wrap jfiddle functions in this.....
{ 
	document.getElementById('imageToHover').onmouseover = function() 
	{
		document.getElementById('imageToShow').style.display = 'inline-block';   
	}

	document.getElementById('imageToHover').onmouseout = function() 
	{
	   document.getElementById('imageToShow').style.display = 'none';   
	}
	
	document.getElementById('imageToHover1').onmouseover = function() 
	{
		document.getElementById('imageToShow1').style.display = 'inline-block';   
	}

	document.getElementById('imageToHover1').onmouseout = function() 
	{
	   document.getElementById('imageToShow1').style.display = 'none';   
	}
	
	document.getElementById('imageToHover2').onmouseover = function() 
	{
		document.getElementById('imageToShow2').style.display = 'inline-block';   
	}

	document.getElementById('imageToHover2').onmouseout = function() 
	{
	   document.getElementById('imageToShow2').style.display = 'none';   
	}
	
};*/


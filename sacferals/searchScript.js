window.onload = function() // always wrap jfiddle functions in this.....
{
	$('table').on('scroll', function () {
		$("table > *").width($("table").width() + $("table").scrollLeft());
	});
	
	$('.confirmation').on('click', function () {
		return confirm('Are you sure?');
	});
}

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


	
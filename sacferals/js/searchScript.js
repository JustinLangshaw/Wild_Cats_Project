window.onload = function() // always wrap jfiddle functions in this.....
{
	/*$('table').on('scroll', function () {
		$("table > *").width($("table").width() + $("table").scrollLeft());
	});*/
	
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

function copyFunction(el){
	//combine all cells into singe string
	var str=el.cells[1].innerHTML;
	for(var i=2; i<(el.cells.length)-2; i++){
		col = el.cells[i];
		if($(col).find("textarea").length){
			if($(col).find("textarea").val()!='')
				str=str+" "+$(col).find("textarea").val();
		}
		else {
			if(col.innerHTML!='')
				str=str+" "+col.innerHTML;
		}
	}

	//For IE
	if(window.clipboardData){
		window.clipboardData.setData("Text", str);
	} 
	//For other browsers
	else {
		var success = true, 
			range = document.createRange(), 
			selection;
		//create temp element off screen
		var tmpElem = $('<div>');
		tmpElem.css({position:"absolute",left:"-1000px",top:"-1000px",});
		//add string to temp element
		tmpElem.text(str);
		$("body").append(tmpElem);
		//select temp element
		range.selectNodeContents(tmpElem.get(0));
		selection = window.getSelection();
		selection.removeAllRanges();
		selection.addRange(range);
		//try to copy
		try{
			success = document.execCommand("copy",false,null);
		}
		catch(e){
			alert("error when copying");
		}
		if(success){ //remove temp element if successsful copy
			tmpElem.remove();
		}
	}
}
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

function copyFunction(el){ //copy single row
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

	copyToClipboard(str);
}
function copyFunction2(){ //copy multiple rows, each separated by a semicolon
	var str="";
	var table = document.getElementsByTagName("tbody");
	for(var j=0, row; row=table[0].rows[j]; j++){
		if($(row).attr("selected")=="selected"){
			str=str+row.cells[1].innerHTML;
			for(var i=2; i<(row.cells.length)-2; i++){
				col = row.cells[i];
				if($(col).find("textarea").length){
					if($(col).find("textarea").val()!='')
						str=str+" "+$(col).find("textarea").val();
				}
				else {
					if(col.innerHTML!='')
						str=str+" "+col.innerHTML;
				}
			}
			str=str+"; ";
		}
	}

	if(str=="") alert("Nothing selected");
	else{
		copyToClipboard(str);
	}
}
function copyToClipboard(str){
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
			$(".copysuccessmsg").fadeIn(300).delay(900).fadeOut(400);
			tmpElem.remove();
		}
	}
}

function editFunction(){
	var table = document.getElementsByTagName("tbody");
	for(var j=0, row; row=table[0].rows[j]; j++){
		if($(row).attr("selected")=="selected"){
			window.location.replace("search.php?editrow=yes&RecordNumber="+$(row).attr('id'));
			break;
		}
	}
}
function deleteFunction(){
	var result=confirm("Are you sure?");
	if(result){
		var str="search.php?del=yes";
		var table = document.getElementsByTagName("tbody");
		for(var j=0, row; row=table[0].rows[j]; j++){
			if($(row).attr("selected")=="selected"){
				str=str+"&RecordNumber[]="+$(row).attr('id');
			}
		}
		window.location.replace(str);
	}
}
function formviewFunction(){
	var table = document.getElementsByTagName("tbody");
	for(var j=0, row; row=table[0].rows[j]; j++){
		if($(row).attr("selected")=="selected"){
			window.open("form_view.php?&RecordNumber="+$(row).attr('id'));
			break;
		}
	}
}

//Will check if a row is selected to be edited everytime page refresh
$(document).ready(function(){
		//Focus on Submit Edit button
		$("#recordEdit").focus();
});




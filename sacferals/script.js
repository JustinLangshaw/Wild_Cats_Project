$(document).ready(function () {
    $('.checkdisplay').change(function () {
        if (this.checked)
          $('.todisplay').fadeIn('fast'); 
        else
          $('.todisplay').fadeOut('fast'); 
    });
	
	//for volunteerform and triage updateprofile
	$('form').submit(function(){ //dont submit form (clear out) if work not chosen
		var work = $('#workchecks').find('input');
		for(var i=0; i<work.length; i++){
			if(work[i].checked) return true;
		}
		
		$('#worklabel').attr('style','color: red');
		$('#workerror').html('<small>Must select at least one</small>');
		$('#workerror').removeAttr('hidden');
		return false;
	});
});


function displayForm(c) {
    if (c.value == "Yes") {
        if(c.name == "caregiver[]")
            $("#feederID").fadeOut('fast');
		if(c.name == "trapattempt[]")
            $("#trapdetails").fadeIn('fast');
		if(c.name == "kittens[]")
			$("#kittensdetails").fadeIn('fast');
        if(c.name == "recentlyinjured[]")
            $('#recentlyinjuredID').fadeIn('fast');
        if(c.name == "othersworking[]")
            $('#othersworkingID').fadeIn('fast');
		if(c.name=='addrdetails' && c.checked==true)
			$('#addrdetails').fadeIn('fast');
		else if(c.name=='addrdetails' && c.checked==false)
			$('#addrdetails').fadeOut('fast');
		if(c.name=='settingdetails' && c.checked==true)
			$('#settingdetails').fadeIn('fast');
		else if(c.name=='settingdetails' && c.checked==false)
			$('#settingdetails').fadeOut('fast');
		if(c.name=='typeofwork[]' && c.checked==true)
			$('#othertasks').fadeIn('fast');
		else if(c.name=='typeofwork[]' && c.checked==false)
			$('#othertasks').fadeOut('fast');
    }
    if (c.value == "No") {  
        if(c.name == "caregiver[]")
            $("#feederID").fadeIn('fast');
		if(c.name == "trapattempt[]")
            $("#trapdetails").fadeOut('fast');
		if(c.name == "kittens[]")
			$("#kittensdetails").fadeOut('fast');
        if(c.name == "recentlyinjured[]")
            $('#recentlyinjuredID').fadeOut('fast');
        if(c.name == "othersworking[]")
            $('#othersworkingID').fadeOut('fast'); 
    }
};

$(document).ready(function () {
    $('.checkdisplay').change(function () {
        if (this.checked)
          $('.todisplay').fadeIn('fast'); 
        else
          $('.todisplay').fadeOut('fast'); 
    });
});


function displayForm(c) {
    if (c.value == "Yes") {
        if(c.name == "caregiver[]")
            $("#feederID").fadeOut('fast');
        if(c.name == "recentlyinjured[]")
            $('#recentlyinjuredID').fadeIn('fast');
        if(c.name == "othersworking[]")
            $('#othersworkingID').fadeIn('fast');
    }
    if (c.value == "No") {  
        if(c.name == "caregiver[]")
            $("#feederID").fadeIn('fast');
        if(c.name == "recentlyinjured[]")
            $('#recentlyinjuredID').fadeOut('fast');
        if(c.name == "othersworking[]")
            $('#othersworkingID').fadeOut('fast'); 
    }
};

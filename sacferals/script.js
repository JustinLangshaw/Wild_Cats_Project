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
    if (c.value == "catcolony") {    
        jQuery('#catcolony1').toggle('show');
        jQuery('#intervention1').hide();
    }
        if (c.value == "intervention") {
         jQuery('#intervention1').toggle('show');
         jQuery('#catcolony1').hide();
    }
};
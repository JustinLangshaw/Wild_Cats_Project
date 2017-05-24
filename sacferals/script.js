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
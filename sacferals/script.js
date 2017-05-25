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

$(document).ready(function () {
    $('.checkdisplay1').change(function () {
        if (this.checked) { 
          $('.todisplay1').fadeIn('slow'); 
        }
        else {
          $('.todisplay1').fadeOut('slow'); 
        }

    });
});
$(document).ready(function () 
{
	var cells = document.querySelectorAll("td");

	for (var i = 0; i < cells.length; i++) {
		cells[i].addEventListener("click", function() {
		   this.className= this.className == "white" ? "green" : "white";
		});
	}
});
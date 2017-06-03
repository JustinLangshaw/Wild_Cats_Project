window.onload = function() // always wrap jfiddle functions in this.....
{ 
	$('table').on('scroll', function () {
		$("table > *").width($("table").width() + $("table").scrollLeft());
	});
}
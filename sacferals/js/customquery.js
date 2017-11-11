//custom query builder

$(document).ready(function(){
	var ctr=1;
	$('#cqaddbtn').on('click', function(){
		var clone = $('#blueprint').clone();
		clone.find('[id]').each(function() {this.id+=ctr;});
		clone.find('#queryvalue'+ctr).val("");
		clone.find('#cqaddbtn'+ctr).prop('id','cqrmvbtn'+ctr);
		$('#cqrow').append(clone);
		$('#cqrmvbtn'+ctr).prop('class','btn btn-danger btn-outline');
		$('#cqrmvbtn'+ctr).prop('value','x');
		$('#cqrmvbtn'+ctr).prop('name','rmvquery');
		var div = document.getElementById('cqrmvbtn'+ctr);
		div.setAttribute('onclick','this.parentNode.parentNode.removeChild(this.parentNode)');
		clone.prepend("<select class='input-sm' id='andor' name='andor[]'>"+
				"<option value='AND'>AND</option>"+
				"<option value='OR'>OR</option>"+
			"</select>");
		ctr++;
	});
});

function rmvquery(){
	alert(this.id);
}
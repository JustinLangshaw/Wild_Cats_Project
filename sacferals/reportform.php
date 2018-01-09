<?php
	session_start();
	include('authenticate.php');
	$link = connectdb($host, $user, $pass, $db);
?>

<script type="text/javascript">
function displayformdiv(){ 
	var check = document.getElementById('maincheckbox');
	if(check.checked) {
		document.getElementById('inner-form').style.display="block";
		document.getElementById('hr-show').style.display="block";
	}
	else {
		document.getElementById('inner-form').style.display="none";
		document.getElementById('hr-show').style.display="none";
	}
}

function formatPhone(phoneId) {
	var startCursor = $("#"+phoneId).get(0).selectionStart;
	var	endCursor = $("#"+phoneId).get(0).selectionEnd;
	
	var output;	
    var input = $("#"+phoneId).val();
	input = input.replace(/[^0-9]/g, '');
	var area = input.substr(0, 3);
    var pre = input.substr(3, 3);
    var tel = input.substr(6, 4);
	
	if (input.length >= 10){
		output = input.replace(/^(\d{3})(\d{3})(\d{4})+$/, "($1)$2-$3");		
	} else {
		output = input;
	}
	
	$("#"+phoneId).val(output);
	$("#"+phoneId).get(0).setSelectionRange(startCursor, endCursor);
}
</script>

<?php

if(isset($_POST['submitcolony'])) //this processes after user submits data.
{
	$fullname = $_POST['fullname'];
	$email = $_POST['email'];
	$phone1 = $_POST['phone1'];
	$phone2 = $_POST['phone2'];	
	
	$caregiver = $_POST['caregiver'];
	$feederdescription = preg_replace("!\s+!", ' ', $_POST['feederdescription']);
	$colonystreet = $_POST['colonystreet'];
	$city = $_POST['city'];
	$county = $_POST['county'];
	$zipcode = $_POST['zipcode'];
	$addrcomment = preg_replace("!\s+!", ' ', $_POST['addrcomment']); //prepend to additional comments
	$trapattempt = $_POST['trapattempt'];
	$trapcomment = preg_replace("!\s+!", ' ', $_POST['trapcomment']); //prepend to additional comments
	$numberofcats = $_POST['numberofcats'];
	$kittens = $_POST['kittens'];
	$kittenscomment = preg_replace("!\s+!", ' ', $_POST['kittenscomment']); //prepend to additional comments
	$injured = $_POST['recentlyinjured'];
	$injurydescription = preg_replace("!\s+!", ' ', $_POST['injurydescription']);
	$friendlypet = $_POST['friendlypet'];
	$setting = $_POST['setting'];
	$settingcomment = preg_replace("!\s+!", ' ', $_POST['settingcomment']); //prepend to additional comments
	$feedifreturned = $_POST['feedifreturned'];
	$notfeedcomment = preg_replace("!\s+!", ' ', $_POST['notfeeddescription']); //prepend to additional comments
	$comments = preg_replace("!\s+!", ' ', $_POST['comments']);
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	
	//combining all comments
	if($settingcomment!='') {
		if (preg_match("/^[a-zA-Z0-9]$/", substr($settingcomment, -1))) $settingcomment.=".";
		$comments=$settingcomment.' '.$comments;
	}
	if($kittenscomment!='') {
		if (preg_match("/^[a-zA-Z0-9]$/", substr($kittenscomment, -1))) $kittenscomment.=".";
		$comments=$kittenscomment.' '.$comments;
	}
	if($notfeedcomment!='') {
		if (preg_match("/^[a-zA-Z0-9]$/", substr($notfeedcomment, -1))) $notfeedcomment.=".";
		$comments=$notfeedcomment.' '.$comments;
	}
	if($trapcomment!='') {
		if (preg_match("/^[a-zA-Z0-9]$/", substr($trapcomment, -1))) $trapcomment.=".";
		$comments=$trapcomment.' '.$comments;
	}
	if($addrcomment!='') {
		if (preg_match("/^[a-zA-Z0-9]$/", substr($addrcomment, -1))) $addrcomment.=".";
		$comments=$addrcomment.' '.$comments;
	}
	
	
	// Required field names
	// this line should be used, since the 'required' attribute isn't supported in all web browsers
	$required = array('fullname','email','colonystreet','zipcode','city','numberofcats','county');

	// Loop over field names, make sure each one exists and is not empty
	$error = false;
	foreach($required as $field) 
	{
		if (empty($_POST[$field])) 
		{
			$error = true;
		}
	}
	
	//re's need updating for all fields. or we can use javascript (better)
	$re = "/^[a-zA-Z]+(([\'\- ][a-zA-Z])?[a-zA-Z]*)*$/";
	list($first, $last) = split(" ", $fullname, 2);
	
	//if user passes re test
	if(!$error)
	{
		if(preg_match($re, $first) && preg_match($re, $last))
		{	//no need to check for duplicates
			if(!$query = $link->prepare("insert into ReportColonyForm values('', '', 'Open', '', Now(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
				'', '', '', '', '', '', ?, ?)")){ echo "Failure to submit: Prepare statement failed. "; }
			
			if(!$query->bind_param("ssssssssssissssssssdd", $feedifreturned[0], $fullname, $email, $phone1, $phone2,$colonystreet, $city, $county, $zipcode, $trapattempt[0], 
				$numberofcats, $kittens[0],$caregiver[0], $feederdescription, $injured[0], $injurydescription, $friendlypet[0], $setting[0], $comments, $lat, $lng))
				{ echo "Failure to submit: Binding failed. "; }
	
			if(!$query->execute()){
				echo "Failure to submit: Execute failed. ";
			}else{	
				echo "<script type='text/javascript'> document.location = 'formsubmitted.php'; </script>";
			}
			$query->close();
		}
		else
		{
			//print "You did not fill out the form correctly!";
			$result='<div style="padding-bottom:10px">
						<div class="alert">
							<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
							"'.$fullname.'" is not a valid name.</div></div>';
		}
	}
	else
	{
		$result='<div style="padding-bottom:10px">
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='."'none'".';">&times;</span>
						<b>ERROR!!</b> Please fill out all fields</div></div>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>	
	<title>Report Stray or Un-owned Cats</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!--<link rel="shortcut icon" href="images/sacferals.png" type="image/x-icon">-->
	<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="css/reportform.css">
	
	<!-- This must preceed any code that uses JQuery. It links out to that library so you can use it -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/script.js"></script> 
</head>
<body>

	<?php echo $result; ?>
	<div class="alert" id='alert' style='display:none'>
		<span class="closebtn" onclick="this.parentElement.style.display='none'">&times;</span>
		<label id='errorMsg'></label>
	</div>

	<h2> Report Stray or Un-owned Cats </h2>
	<div id="form-wrapper">
		<form method="post" action="reportform.php" id='reportform'>
			<div class="form-row">
				<p>Thank you for reporting these cats in your community. They are likely part of a cat colony. 
				The term “colony" is used to describe a group of cats living together outdoors.</p>
				<p>Please answer the questions below to the best of your ability. The more details you can provide, 
				the better we can help determine the best way to proceed. It's important that we are able to contact 
				you to follow-up on this request. Without your name and contact information this may not be possible.
				Since most correspondence is by email, be sure to include an email address as well as a phone number.</p>
				<p>Although we may provide assistance for people with physical challenges, we ask that you do all that 
				you can to be actively involved in the TNR process. Our volunteers can offer guidance from start to finish 
				and address any concerns you may have. We want you to succeed with gaining control of the cat population.</p>
			</div>

			<div class="form-row">
				<div class="form-check">
					<label><input type="checkbox" id="maincheckbox" onclick="displayformdiv()"> &nbsp; I have read all the information required for filling out this form.</input></label>
				</div>
			</div>
		
			<span id="hr-show" class="todisplay"><hr></span>
		
			<div class="form-row todisplay" id="inner-form">
				<div class="form-group"><font color="red">* Required Fields</font></div>
				<div class="form-group row">
					<label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label" for="fullname">*Full Name </label>									<!--L+ [-] L+ 							middle          L+ [-'] L+-->				    
					<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">	
						<input class="form-control" type="text" name="fullname" id="fullname" pattern="[a-zA-Z]+[-]{0,1}[a-zA-Z]+\s[a-zA-Z\s]{0,}[a-zA-Z]+[-']{0,1}[a-zA-Z]+" 
							title="Enter first and last name" placeholder="First Last" required>
					</div>
					<label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label" for="email">*Email<br>Address
						<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
							<span class="tooltiptext">This is our preferred method of contact.</span>
						</div>
					</label>
					<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
						<input class="form-control" type="email" name="email" id="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}$" placeholder="email@domain.com" required>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 col-form-label" for="phone1">Primary Phone</label>
					<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
						<input class="form-control" type="tel" id="phone1" name="phone1" placeholder="1234567890" pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone1');" />
					</div>
					<label class="col-xs-2  col-sm-2 col-md-2 col-lg-2 col-form-label" for="phone2">Secondary Phone</label>
					<div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">
						<input class="form-control" type="tel" id="phone2" name="phone2" placeholder="1234567890" pattern=".{10,13}" maxlength="10" onkeyup="formatPhone('phone2');" />
					</div>
				</div>
				
				
				<label class="col-form-label">*Address of where cats are located</label>
				<span id="invalidAddr" type="hidden"></span>
				<div class="well">
					<div class="form-group row">
						<label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 col-form-label" for="colonystreet">*Street</label>
						<div class="col-xs-5 col-sm-5 col-md-4 col-lg-3">
							<input class="form-control" type="text" name="colonystreet" placeholder="1234 Sesame St"
								pattern="[0-9]{1,3}.?[0-9]{0,3}(\s[a-zA-Z0-9]{2,30})*" title="Enter street# and street name" id="colonystreet" required>
						</div>
						<label class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-form-label" for="state">State</label>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
							<input class="form-control" type="text" id="state" value="CA" tabindex="-1" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label" for="zipcode">*Zip</label>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
							<input class="form-control" type="text" name="zipcode" id="zipcode" maxlength="5" required>
							<span id="ziperror"></span>
						</div>
						<label class="col-xs-1 col-sm-1 col-md-1 col-lg-1 col-form-label" for="city">*City</label>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<span id="city_wrap"><input class="form-control" type="text" name="city" id="city" title="Enter a City" required></span>
						</div>
						<label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 col-form-label" for="county">*County</label>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<input class="form-control" type="text" name="county" id="county" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="form-check">
						<label><input type="checkbox" name="addrdetails" value="Yes" onClick="displayForm(this)"> Additional information about the address?</input></label>
					</div>
					<div class='form-group indent todisplay' id="addrdetails">
						Please describe<br>
						<textarea class="form-control" rows="4"  name="addrcomment"></textarea>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-md-12 form-check-label">Are you the primary caregiver/feeder?</label>
					<div class="col-md-12">
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="caregiver[]" value="Yes" onclick="displayForm(this)"> Yes</label></div>
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="caregiver[]" value="No" onclick="displayForm(this)"> No</label></div>
						<div class='form-group  indent todisplay' id="feederID">
							Does anyone feed the cats?<br>
							<textarea class="form-control" id="textarea" rows="4" name="feederdescription"></textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-md-12 form-check-label">Has trapping been attempted and/or are any of the cats ear-tipped?
						<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
							<span class="tooltiptext">If the cat has the tip of one ear cut off or "tipped", this means this
								cat has already been trapped and is altered. Release this cat immediately.</span>
						</div>
					</label>
					<div class="col-md-12">
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="trapattempt[]" value="Yes" id="trapattemtyes" onClick="displayForm(this)"> Yes</label></div>
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="trapattempt[]" value="No" id="trapattemptno" onClick="displayForm(this)"> No</label></div>
						<div class='form-group  indent todisplay' id="trapdetails">
							Please elaborate<br>
							<textarea class="form-control" rows="4" name="trapcomment"></textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-md-12 form-check-label">If cats are altered and returned, will anyone provide long-term food/water?</label>
					<div class="col-md-12">
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="feedifreturned[]" value="Yes" id="feedifreturnedyes" onClick="displayForm(this)"> Yes</label></div>
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="feedifreturned[]" value="No" id="feedifreturnedno" onClick="displayForm(this)"> No</label></div>
						<div class='form-group indent todisplay' id="notfeed">
							Comments<br>
							<textarea class="form-control" rows="4"  name="notfeeddescription"></textarea>
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label class="col-xs-5 col-sm-5 col-md-4 col-lg-3 col-form-label" for="numberofcats">*Number of Cats
						<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
							<span class="tooltiptext">Enter a number up to 99</span>
						</div>
						<br> <small>(including Kittens)</small>
					</label>
					<div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
						<input class="form-control" type="number" name="numberofcats" min="1" max="99" id="numberofcats" required>
						<span id="catserror"></span>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-12 form-check-label">Are any kittens under 8 weeks old and/or still nursing?
						<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
							<span class="tooltiptext">Kitten Description<br>
								Will be provided by SacFerals later.</span>
						</div>
					</label>
					<div class="col-md-12">
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="kittens[]" value="Yes" id="kittensyes" onClick="displayForm(this)"> Yes</label></div>
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="kittens[]" value="No" id="kittensno" onClick="displayForm(this)"> No</label></div>
						<div class='form-group  indent todisplay' id="kittensdetails">
							Describe the number of kittens and their ages<br>
							<textarea class="form-control" rows="4" name="kittenscomment"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-12 form-check-label">Sick, injured, or pregnant cats?
						<div id="tooltip"><img src="images/blue_question_mark.png" alt="?"/>
							<span class="tooltiptext">Signs of INJURED cats can include inflammation/swelling, limping, 
								rapid breathing or other signs of stress, and blood.<br>
								Signs of a PREGNANT cat can include nesting activities, vomiting,
								and an enlarged abdomen.</span>
						</div>
					</label>
					<div class="col-md-12">
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="recentlyinjured[]" value="Yes" id="recentlyinjuredinjuredyes" onClick="displayForm(this)"> Yes</label></div>
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="recentlyinjured[]" value="No" id="recentlyinjuredinjuredno" onClick="displayForm(this)"> No</label></div>
						<div class='form-group indent todisplay' id="recentlyinjuredID">
							Describe Condition<br>
							<textarea class="form-control" rows="4"  name="injurydescription"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-md-12 form-check-label">Are any of the cats friendly or pets?</label>
					<div class="col-md-12">
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="friendlypet[]" value="Yes" id="friendlypetyes"> Yes</label></div>
						<div class="form-check checkbox-inline">
							<label><input type="radio" name="friendlypet[]" value="No" id="friendlypetno"> No</label></div>
					</div>
				</div>
				<div class="form-group">
					<label class="form-check-label">What is the setting of this colony?</label>
					<div class="form-check">
						<label><input type="radio" name="setting[]" value="Residential" id="residentialsetting"> Residential</label></div>
					<div class="form-check">
						<label><input type="radio" name="setting[]" value="Commercial" id="commercialsetting"> Commercial</label></div>
					<div class="form-check">
						<label><input type="radio" name="setting[]" value="Industrial"id="industrialsetting"> Industrial</label></div>
					<br>
					<div class="form-check">
						<label><input type="checkbox" name="settingdetails" value="Yes" onClick="displayForm(this)"> Any additional information about the Setting?</input></label>
					</div>
					<div class='form-group indent todisplay' id="settingdetails">
						Please describe<br>
						<textarea class="form-control" rows="4"  name="settingcomment"></textarea>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form-check-label">Additional Comments</label>
					<textarea class="form-control" rows="4"  name="comments" id="textarea"></textarea>
				</div>
				
				<input type="hidden" name="lat" id="lat"/>
				<input type="hidden" name="lng" id="lng"/>
				
				<br>
				<div class="form-group row" id="buttons">
					<input class="btn btn-primary" type="submit" name="submitcolony" value="Submit"  > <!-- button itself -->
				</div>
			</div>
		</form>
	</div>

<script>
//Checks user input for street, city, and zipcode
$(document).ready(function(){
	$('#colonystreet').focusout(getGeocode)	
	$('#zipcode').focusout(getGeocode);
	$('#city_wrap').focusout(getGeocode);
});

//Gets geocode if address is availible 
function getGeocode() {
    var lat = null;
    var lng = null;
    var street = $('#colonystreet').val();
    var city = $('#city').val();
    var state = $('#state').val();
    var zip = $('#zipcode').val();
    var address = street + "," + city + "," + state + "," + zip;
    var redBanner = $('#alert');
    var errorMsg = $('#invalidAddr');

    if ((street != "") && (city != "") && (zip != "")) {
        $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address=' +
            address + '&key=AIzaSyDz2ZSC6IJEf38QeSbLwIxTEohm4ATem9M').done(function(response) {
            if (response.results != "") {
                if ((response.status == 'OK') && (response.results[0].geometry.location_type == 'ROOFTOP') && (response.results[0].partial_match != true) && (response.results.length < 2)) {
                    lat = response.results[0].geometry.location.lat;
                    lng = response.results[0].geometry.location.lng;
                    $('#lat').val(lat);
                    $('#lng').val(lng);
                    errorMsg.html('');
                    $('#zipcode').attr('style', '');
                    $('#colonystreet').attr('style', '');
                    $('#city').attr('style', '');
                } else {
                    errorMsg.html("<small>Cannot locate exact location of address. Please check if address is valid.</small>");
                    $('#zipcode').attr('style', 'border: 1px solid #d66');
                    $('#colonystreet').attr('style', 'border: 1px solid #d66');
                    $('#city').attr('style', 'border: 1px solid #d66');
                    $('#invalidAddr').attr('style', 'color: RED');
                    $('#zipcode').val(''); //clear so doens't submit form with illegal address
                }
            } else {
                errorMsg.html("<small>Cannot identfy address entered. Make sure you are entering an address in the proper format.</small>");
                $('#zipcode').attr('style', 'border: 1px solid #d66');
                $('#colonystreet').attr('style', 'border: 1px solid #d66');
                $('#city').attr('style', 'border: 1px solid #d66');
                $('#invalidAddr').attr('style', 'color: RED');
                $('#zipcode').val(''); //clear so doens't submit form with illegal address
            }
        });
    }
}

//when user clicks off of the zip field:
$(document).ready(function(){
	$('#zipcode').on('keyup focus', function(){
		if($(this).val().length==5){
			var zip = $(this).val();
			var city = '';
			var	citybackup = '';
			var county = '';
			var state = '';
			
			//make a request to the google geocode api
			$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='
					+zip+'&key=AIzaSyDz2ZSC6IJEf38QeSbLwIxTEohm4ATem9M').done(function(response){
				//find the city and county
				if(response.results[0]!=null){ //if zip even exists
					var address_components = response.results[0].address_components;
					$.each(address_components, function(index, component){
						var types = component.types;
						$.each(types, function(index, type){
							if(type == 'locality') city = component.long_name;
							if(type == 'administrative_area_level_1') state = component.short_name;
							if(type == 'administrative_area_level_2') county = component.long_name;
							if(type == 'neighborhood') citybackup = component.long_name;
						});
					});
					if(city=='') city=citybackup;
					if(state=='CA'){
						$('#zipcode').attr('style','');
						$('#ziperror').html('');
						//pre-fill the city and state
						var cities = response.results[0].postcode_localities;
						if(cities){
							//turn city into a dropdown if necessary
							var $select = $(document.createElement('select'));
							$.each(cities, function(index,locality){
								var $option = $(document.createElement('option'));
								$option.html(locality);
								$option.attr('value',locality);
								if(city == locality) $option.attr('selected','selected');
								$select.append($option);
							});
							$select.append('<option value="Other">Other</option>');
							$select.attr('id','city');
							$select.attr('name','city');
							$select.attr('class','form-control');
							$('#city_wrap').html($select);
						}
						else {
							$('#city_wrap').html('<input class="form-control" type="text" name="city" id="city" title="Enter a City" required>');
							$('#city').val(city);
						}
						if(county == '') {
							$.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='
								+city+'&key=AIzaSyDz2ZSC6IJEf38QeSbLwIxTEohm4ATem9M').done(function(res){
								var address_components2 = res.results[0].address_components;
								$.each(address_components2, function(indx, compnt){
									var types2 = compnt.types;
									$.each(types2, function(indx, typ){
										if(typ == 'administrative_area_level_2'){
											county = compnt.long_name;
											$('#county').val(county);
										}
									});
								});
							});
						}
						else $('#county').val(county);
					}
					else{
						$('#zipcode').attr('style','border: 1px solid #d66');
						$('#ziperror').html('<small>Must be in California</small>');
						$('#zipcode').val('');
						if($('#city_wrap').find('select').length!=0)
							$('#city_wrap').html('<input class="form-control" type="text" name="city" id="city" title="Enter a City" required>');
						else $('#city').val('');
						$('#county').val('');
					}
				}
				else{
					$('#zipcode').attr('style','border: 1px solid #d66');
					$('#ziperror').html('<small>That Zip Code doesn\'t exist</small>');
					$('#zipcode').val('');
					if($('#city_wrap').find('select').length!=0)
						$('#city_wrap').html('<input class="form-control" type="text" name="city" id="city" title="Enter a City" required>');
					else $('#city').val('');
					$('#county').val('');
				}
			});
		}
	});
	
	$('#city_wrap').on('change', '#city', function(){
		if($(this).val() == 'Other'){
			$('#city_wrap').html('<input class="form-control" type="text" name="city" id="city" placeholder="Enter a City" title="Enter a City" required>');
			$('#city').focus();
		}
	});
	
	$('#numberofcats').on('keyup change', function(){
		if($(this).val()>99 || $(this).val()<1){
			$('#numberofcats').attr('style','border: 1px solid #d66');
			$('#catserror').html('<small>only 1 to 99</small>');
			$('#numberofcats').val('');
		}
		else{
			$('#numberofcats').attr('style','');
			$('#catserror').html('');
		}
	});
});
</script>

</body>
</html>

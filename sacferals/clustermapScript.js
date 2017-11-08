/*Contains code that deals with things related to Google Maps*/

//Map Query button
var clusterAddrBtn = document.getElementById('clusterAddrBtn');

//Initialize the Google Map display
var geocoder;
var map;
function initMap() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(38.6041169, -121.4182844);
    var mapOptions = {
        zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

//Grabs ColonyAddress, City, and ZipCode and other report details 
var invalidCols = false;
function mapQuery() {
    var search = [];
    var searchDetails = [];
    var reportStatus = null;
    var dateTime = null;
    var address = null;
    var city = null;
    var zipcode = null;
    var table = document.getElementById('reportTable');
    var reportStatusIndex = document.getElementById('statusCol');
    var dateTimeIndex = document.getElementById('dateTimeCol');
    var addrIndex = document.getElementById('addressCol');
    var cityIndex = document.getElementById('cityCol');
    var zipIndex = document.getElementById('zipCodeCol');

    //If detail columns cannot be found, detail is blank
    if (reportStatusIndex == null) {
        reportStatus = "";
    } else {
        reportStatusIndex = reportStatusIndex.cellIndex;
    }
    if (dateTimeIndex == null) {
        dateTime = "";
    } else {
        dateTimeIndex = dateTimeIndex.cellIndex;
    }

    //If any address info columns cannot be found, do not proceed
    if ((addrIndex == null) || (cityIndex == null) || (zipIndex == null)) {
		invalidCols = true;
			
        return;
    } else {
        addrIndex = addrIndex.cellIndex;
        cityIndex = cityIndex.cellIndex;
        zipIndex = zipIndex.cellIndex;
    }

    //Iterate through rows of Report table and grab the text in cells if columns availible 
    for (var r = 1; r < table.rows.length; r++) {
        if (dateTimeIndex != null) dateTime = table.rows[r].cells[dateTimeIndex].innerHTML;
        if (reportStatusIndex != null) reportStatus = table.rows[r].cells[reportStatusIndex].innerHTML;

        address = table.rows[r].cells[addrIndex].innerHTML;
        city = table.rows[r].cells[cityIndex].innerHTML;
        zipcode = table.rows[r].cells[zipIndex].innerHTML;
        search[r] = address + " " + city + " " + zipcode;
        searchDetails[r] = "<p><b>Address: " + search[r] +
            "<br>Reported at: " + dateTime +
            "<br>Status: " + reportStatus + "</b></p>";
    }

    //Pass the addresses and it's details to be plotted
    plotMap(search, searchDetails);
}

//Iterate through addresses and call geocode()
function plotMap(search, searchDetails) {
    geocoder = new google.maps.Geocoder();
    
	for (i = 1; i < search.length; i++) {
        geocoder.geocode({
            'address': search[i]
        }, geocodeEncapsulation(i, searchDetails[i]));
    }
}

//Geocode converts addresses to coordinates
//Add details to the plot markers about location
var markerList = [];
var error = 0;
function geocodeEncapsulation(i, searchDetails) {
    return (function(results, status) {
        if ((status == google.maps.GeocoderStatus.OK) && (results[0].geometry.location_type == 'ROOFTOP') 
			&& (results[0].partial_match != true) && (results.length == 1)) {

            map.setCenter(results[0].geometry.location);
            var infowindow = new google.maps.InfoWindow({
                content: searchDetails
            });
            var marker = new google.maps.Marker({
                map: map,
                title: results[0].formatted_address,
                position: results[0].geometry.location,
            });
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map, marker);
            });			
            markerList.push(marker);
        } else {
            error++;
			toggleRedBanner = true;
        }
    });
}

//Remove all markers from map
function clearMap() {
    for (i = 0; i < markerList.length; i++) {
        markerList[i].setMap(null);
    }
}

function errorCheck() {
    var redBanner = document.getElementById('alert');
    var errorMsg = document.getElementById('errorMsg');
    
	//Show how many addresses Google cannot locate for Map Query
    if (error > 0) {
        errorMsg.innerHTML = error + " address cannot be found.";
        redBanner.style.display = "block";
        error = 0;
    } else if (error > 1) {
        errorMsg.innerHTML = error + " addresses cannot be found.";
        redBanner.style.display = "block";
        error = 0;
    }

	//Warn user that they are missing columns for mapping
    if (invalidCols == true) {
        errorMsg.innerHTML = "Must have at least address, city, and zip code included in query.";
        redBanner.style.display = "block";
        invalidCols = false;
    }
}




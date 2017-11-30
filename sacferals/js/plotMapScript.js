//Code for plotting locations from Reports table on a map

//Initialize Google Map
var map;
function initMap() {
    var latlng = new google.maps.LatLng(38.6041169, -121.4182844);
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: latlng
    });
    var geocoder = new google.maps.Geocoder();

    document.getElementById('clusterAddrBtn').addEventListener('click', function() {
        var locDetails = getMapQueries();
        for (var i = 1; i < locDetails.length; i++) {
            if (locDetails[i].latlng == '(0, 0)') {
                error++;
            } else {
                plotMarkers(map, locDetails[i]);
            }
        }
    });
}

//Plot locations on map including details on the report
var markerList = [];
function plotMarkers(resultsMap, locDetails) {
	map.setCenter(locDetails.latlng);
    var marker = new google.maps.Marker({
        map: resultsMap,
        title: locDetails.address,
        position: locDetails.latlng, //results[0].geometry.location
    });
    var infowindow = new google.maps.InfoWindow({
        content: locDetails.details
    });
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
    });
	markerList.push(marker);	
}

//Get the address infos for mapping
var invalidCols = false;
function getMapQueries() {
    var bundle = [];
    var search = null;
    var searchDetails = null;
    var geocode = null;
    var reportStatus = null;
    var dateTime = null;
    var address = null;
    var city = null;
    var zipcode = null;
    var lat = null;
    var lng = null;
    var table = document.getElementById('reportTable');
    var reportStatusIndex = document.getElementById('statusCol');
    var dateTimeIndex = document.getElementById('dateTimeCol');
    var addrIndex = document.getElementById('addressCol');
    var cityIndex = document.getElementById('cityCol');
    var zipIndex = document.getElementById('zipCodeCol');
    var latIndex = document.getElementById('latCol');
    var lngIndex = document.getElementById('lngCol');

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
	if(addrIndex == null){
		address = "";
	}else{
		addrIndex = addrIndex.cellIndex;
	}
	if(cityIndex == null){
		city = "";	
	}else{
		cityIndex = cityIndex.cellIndex;
	}
	if(zipIndex == null){
		zipcode = "";
	}else{
		zipIndex = zipIndex.cellIndex;
	}
	
    //If latitude and longitude columns cannot be found, do not proceed
    if ((latIndex == null) || (lngIndex == null)) {
        invalidCols = true;
        return;
    } else {
        latIndex = latIndex.cellIndex;
        lngIndex = lngIndex.cellIndex;
    }

    //Iterate through rows of Report table and grab the text in cells if columns availible 
    for (var r = 1; r < table.rows.length; r++) {
        if (dateTimeIndex != null) dateTime = table.rows[r].cells[dateTimeIndex].innerHTML;		
        if (reportStatusIndex != null) reportStatus = table.rows[r].cells[reportStatusIndex].innerHTML;		
		if (addrIndex != null) address = table.rows[r].cells[addrIndex].innerHTML;	
		if (cityIndex != null) city = table.rows[r].cells[cityIndex].innerHTML; 
		if (zipIndex != null) zipcode = table.rows[r].cells[zipIndex].innerHTML; 
			
        lat = table.rows[r].cells[latIndex].innerHTML;
        lng = table.rows[r].cells[lngIndex].innerHTML;
        geocode = new google.maps.LatLng(lat, lng);
        search = address + " " + city + " " + zipcode
        searchDetails = "<p><b>Address: " + search +
            "<br>Reported at: " + dateTime +
            "<br>Status: " + reportStatus + "</b></p>";
        bundle[r] = {
            latlng: geocode,          
            details: searchDetails
        };
    }
    return bundle;
}

//Remove all markers from map
function clearMap() {
    for (i = 0; i < markerList.length; i++) {
        markerList[i].setMap(null);
    }
}

//Display error message on red banner
var error = 0;
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
        errorMsg.innerHTML = "Must have at least Latitude and Longitude included in query.";
        redBanner.style.display = "block";
        invalidCols = false;
    }
}
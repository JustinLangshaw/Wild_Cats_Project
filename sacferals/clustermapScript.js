/*Contains code that deals with things related to Google Maps*/


//Map Query button
var clusterAddrBtn = document.getElementById('clusterAddrBtn');

//Grabs ColonyAddress, City, and ZipCode and concatenate them 
function mapQuery(){	
	var search = [];
    var address = null;
    var city = null;
    var zipcode = null;
    var table = document.getElementById('reportTable');
    var addrIndex = document.getElementById('addressCol').cellIndex;
    var cityIndex = document.getElementById('cityCol').cellIndex;
    var zipIndex = document.getElementById('zipCodeCol').cellIndex;

    for (var r = 1; r < table.rows.length; r++) {
        address = table.rows[r].cells[addrIndex].innerHTML;
        city = table.rows[r].cells[cityIndex].innerHTML;
        zipcode = table.rows[r].cells[zipIndex].innerHTML;
        search[r] = address + " " + city + " " + zipcode;
    }
    codeAddress(search);
}

//Initialize the Google Map display
var geocoder;
var map;
function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(38.6041169, -121.4182844);
    var mapOptions = {
        zoom: 15,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
}

//Mark location of all addresses displayed on report table
var markerList = [];
function codeAddress(search) {
    var index = 1;
    for (var i = 1; i < search.length; i++) {
        geocoder.geocode({'address': search[i]}, 
			function(results, status) {
				var hoverInfo = search[index++];
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);

					var infowindow = new google.maps.InfoWindow({
						content: hoverInfo
					});

					var marker = new google.maps.Marker({
						map: map,
						title: hoverInfo,
						position: results[0].geometry.location,
					});

					google.maps.event.addListener(marker, 'click', function() {
						infowindow.open(map, marker);
					});

					markerList.push(marker);
				} else {
					alert('Geocode was not successful for the following reason: ' + status +
						'. \nFailure on: ' + hoverInfo);
				}
			});
    }
}

//Removes all markers from map
function clearMap(){
	for(i=0; i<markerList.length; i++){
        markerList[i].setMap(null);
    }
}
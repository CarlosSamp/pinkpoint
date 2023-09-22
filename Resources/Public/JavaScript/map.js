var map;

// read CSV file
// CSV file from: https://developers.google.com/public-data/docs/canonical/countries_csv
$(document).ready(function() {

    $.ajax({
        type: "GET",
        url: "/pinkpoint/typo3conf/ext/pinkpoint/Resources/Public/Csv/countries.csv",
        dataType: "text",
        success: function(data) {
          list = processData(data);
          console.log('SUCESS');

        },
        error: function(xhr, ajaxOptions, thrownError){
          console.log(thrownError);
          console.log(xhr.status);
        }
     });

     // Get Country Code
     $.get("https://ipinfo.io", function(response) {
        console.log(response.city, response.country);
        startIsoCode = response.country;
        initMap(list);
    }, "jsonp");

});

///csperedo.website/public_html/pinkpoint/typo3conf/ext/pinkpoint/Resources/Public/Csv/countries.csv
// get coordinates of all countries
// save data from CSV to Array, line 20 to 34
// https://stackoverflow.com/questions/7431268/how-to-read-data-from-csv-file-using-javascript
var countriesList = [];
function processData(allText) {
    var record_num = 4;  // elements in each row
    var allTextLines = allText.split(/\r\n|\n/);
    for(line of allTextLines){
        var entries = line.split('\t');
        countriesList.push({
            country: entries[0],
    		lat: parseFloat(entries[1]),
    		lng: parseFloat(entries[2])
    	});
    }

    return countriesList;
}

// guarantee opening of the Map
// google.maps.event.addDomListener(
//     window,
//     'load',
//     function () {
//          //1000 milliseconds == 1 second,
//         window.setTimeout(initMap, 1000);
//     }
// );

// marker to set and remove after new marker set
var lastMarker;

var startIsoCode;
// fetch('https://extreme-ip-lookup.com/json/')
//     .then(res => res.json())
//     .then(response => {
//         console.log("Country: ", response.countryCode);
//         console.log("response: ", response);
//         if ($('.localUser').text() != '') {
//             startIsoCode = $('.localUser').text().toUpperCase();
//         }else {
//             startIsoCode = response.countryCode;
//         }

//     })
//     .catch((data, status) => {
//         console.log('Country Request failed');
//     });



// added lines 55-67, 120
// else Clustering Documentation
// https://developers.google.com/maps/documentation/javascript/marker-clustering?hl=de
function initMap(countriesList) {
    var location;

    if ($('.countrySearch').text() != '') {
        startIsoCode = $('.countrySearch').text().toUpperCase();
    }
    var isoCode = startIsoCode;
    
    console.log('ISO:' , startIsoCode);
    // set initial location of the Map depending on location of User
    for (var i = 0; i < countriesList.length; i++) {
        if (countriesList[i].country == isoCode) {
        
            location = {
                lat: countriesList[i].lat,
                lng: countriesList[i].lng
            }
        }
    }
    
    console.log('Location start:' ,location);
    // console.log(countriesList);
    if (typeof(location) == 'undefined' || isNaN(location.lat)) {

      location = {
          lat: 46.818188,
          lng: 8.227512
      }
    }


    console.log('Location:' ,location.lng);
    // set the map options
	var mapOptions = {
		center:  location,
		zoom: 6,
        mapTypeId: 'hybrid',
        streetViewControl: true,
        zoomControl:true,
        styles: [
            {elementType: 'geometry', stylers: [{color: '#20C760F'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#000000', width: 0.5}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#CF973E'}]},

            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#3367BB'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]
	}

	map = new google.maps.Map(document.getElementById('map'), mapOptions);
    //map.setMapTypeId('hybrid');
	// Create an array of alphabetical characters used to label the markers.

    console.log('Locations:' ,locations);
	// Add some markers to the map.
	// Note: The code uses the JavaScript Array.prototype.map() method to
	// create an array of markers based on a given "locations" array.
	// The map() method here has nothing to do with the Google Maps API.
    if (locations.length >0) {
        var markers = locations.map(function(location, i) {
            // set label of marker
            var contentString = '<div id="content">' +
                '<div id="siteNotice">' +
                '</div>' +
                '<h4 id="firstHeading" class="firstHeading">' + sectorInfo[i].name + '</h4>' +
                '<a href="' + sectorInfo[i].link + '">Details</a>' +
                '<div id="bodyContent">' +
                '<p></p>' +
                '</div>' +
                '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            var marker = new google.maps.Marker({
                position: location,
                icon: '/pinkpoint/typo3conf/ext/pinkpoint/Resources/Public/Icons/marker.svg'
            });

            // open marker label on click
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
            return marker;
        });
        var markerCluster = new MarkerClusterer(map, markers, { imagePath: '/pinkpoint/typo3conf/ext/pinkpoint/Resources/Public/Icons/m' });

    }

	// get coords on click, refresh Marker
    // https://developers.google.com/maps/documentation/javascript/events?hl=sr
	google.maps.event.addListener(map, 'click', function(event) {

    console.log(document.getElementById('displayLat'));
		document.getElementById('displayLat').value = event.latLng.lat().toFixed(8);
		document.getElementById('displayLong').value = event.latLng.lng().toFixed(8);
		if(lastMarker) {
			lastMarker.setMap(null);
		}
		lastMarker = new google.maps.Marker({
			position: event.latLng,
			map: map,
		});
	});
}

// All locations coordinates to show on map
var locations = [];
$('.coords').each(function(index) {
	var tempArray = $(this).text().split(',');
	locations.push({
		lat: parseFloat(tempArray[0]),
		lng: parseFloat(tempArray[1])
	});
});

// links and description from the locations
var sectorInfo = [];
$('.sectorName').each(function(index) {
	var tempArray = $(this).text();
	var link = $(this).attr("href")

	sectorInfo.push({
		name: $(this).text(),
		link: link
	});

});

var map;
// var center = new google.maps.LatLng($Lat, $Lng);
var marker_bounds;

// document.addEventListener("DOMContentLoaded", function () {
//   init();
// });

// document.body.addEventListener("htmx:afterSettle", function (event) {
//   init();
// });

// var icon = {
//   url: '/_resources/themes/default/dist/images/marker.png',
// 	size: new google.maps.Size(300,110),
// 	origin: new google.maps.Point(0, 0),
// 	anchor: new google.maps.Point(75, 65),
// 	scaledSize: new google.maps.Size(150,55)
// };

function init() {
  var mapOptions = {
    Zoom: $Zoom,
    scaleControl: $Scale,
    streetViewControl: $StreetView,
    mapTypeControl: true,
    mapTypeControlOptions: {
      position: google.maps.ControlPosition.RIGHT_TOP,
    },
    mapTypeId: "$MapType",
    //		scrollwheel: true,
    fullscreenControl: $Fullscreen,
    fullscreenControlOptions: {
      position: google.maps.ControlPosition.LEFT_TOP,
    },
  };

  if ($ShowZoom) {
    mapOptions.zoomControl = true;
    mapOptions.zoomControlOptions = {
      position: google.maps.ControlPosition.LEFT_TOP,
    };
  } else {
    mapOptions.zoomControl = false;
  }

  map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

  marker_bounds = new google.maps.LatLngBounds();

  var Link = "$ControllerLink";

  fetch(Link + "?ajax=1")
    .then(function (response) {
      return response.json();
    })
    .then(function (json) {
      json.forEach(function (marker) {
        var latlng = new google.maps.LatLng(
          parseFloat(marker.Latitude),
          parseFloat(marker.Longitude)
        );
        marker_bounds.extend(latlng);
        createMarker(latlng, marker.PointURL, marker.Type);
      });
      resize();
    });
}

function createMarker(latlng, PointURL, type) {
  if (type == 'parking') {
    var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			icon:{
				path: 'M56 0c30.928 0 56 25.166 56 56.21 0 31.043-29.387 84.207-56 119.79C30.796 141.888 0 87.253 0 56.21 0 25.166 25.072 0 56 0zm10.244 28H32v83h21.512V83.48h12.732c9.293 0 16.408-2.422 21.347-7.265C92.531 71.37 95 64.546 95 55.74c0-8.806-2.47-15.631-7.409-20.475-4.836-4.742-11.759-7.163-20.77-7.262L66.245 28zm-5.598 17.393c7.903 0 11.854 3.449 11.854 10.347s-3.951 10.348-11.854 10.348h-7.134V45.393h7.134z',
				fillColor: '#4673EA',
				fillOpacity: 1.0,
				strokeColor: '#4673EA',
				strokeWeight: 1,
				scale: .16,
				anchor: new google.maps.Point(58, 184),
			},
			zIndex: 1
		});
	} else {
		var marker = new google.maps.Marker({
			position: latlng,
			map: map,
			// icon:{
			// 	path: 'M100,313.113281 C54.9921875,252.425781 0,155.228475 0,100 C0,44.771525 44.771525,0 100,0 C155.228475,0 200,44.771525 200,100 C200,155.228475 147.523437,249.808594 100,313.113281 Z M101,132 C118.120827,132 132,118.120827 132,101 C132,83.8791728 118.120827,70 101,70 C83.8791728,70 70,83.8791728 70,101 C70,118.120827 83.8791728,132 101,132 Z',
			// 	fillColor: '#1a295a',
			// 	fillOpacity: 1.0,
			// 	strokeColor: '#f6f6f6',
			// 	strokeWeight: 1,
			// 	scale: .16,
			// 	anchor: new google.maps.Point(100, 313),
			// },
			zIndex: 2
		});
	}
  if (PointURL) {
    google.maps.event.addListener(marker, "click", function () {
      window.open(PointURL, "_blank");
    });
  }
}

// google.maps.event.addDomListener(window, 'deviceorientation', resize);
// google.maps.event.addDomListener(window, 'resize', resize);
function resize() {
  if (!marker_bounds.isEmpty()) {
    map.fitBounds(marker_bounds);
  } else {
    var defaultCenter = new google.maps.LatLng($Lat, $Lng);
    map.setCenter(defaultCenter);
  }

  // Wait for the map to be idle before checking and setting zoom level
  google.maps.event.addListenerOnce(map, 'idle', function() {
    if (map.getZoom() > $Zoom) {
      map.setZoom($Zoom);
    }
  });
}

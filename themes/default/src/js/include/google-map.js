var map;
// var center = new google.maps.LatLng($Lat, $Lng);
var marker_bounds;

function init(){
	var mapOptions = {
		Zoom: $Zoom,
		scaleControl: $Scale,
		streetViewControl: $StreetView,
		mapTypeControl: true,
		mapTypeControlOptions: {
			position: google.maps.ControlPosition.RIGHT_TOP
		},
		mapTypeId: google.maps.MapTypeId.$MapType,
		zoomControl: true,
		zoomControlOptions: {
			position: google.maps.ControlPosition.LEFT_TOP
		},
//		scrollwheel: true,
		fullscreenControl: $Fullscreen,
		fullscreenControlOptions: {
			position: google.maps.ControlPosition.LEFT_TOP
		}
	};

	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

	marker_bounds = new google.maps.LatLngBounds();

	var Link = '$ControllerLink';

	$.getJSON(Link, function(data){
		$.each(data, function(i,marker){
			var latlng = new google.maps.LatLng(parseFloat(marker.Latitude), parseFloat(marker.Longitude));
			marker_bounds.extend(latlng);
			var marker = createMarker(latlng, marker.PointURL);
		});
	});
}

function createMarker(latlng, PointURL) {
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		icon:{
			path: 'M100 313.113C54.992 252.426 0 155.228 0 100 0 44.772 44.772 0 100 0s100 44.772 100 100-52.477 149.809-100 213.113zM101 132c17.12 0 31-13.88 31-31 0-17.12-13.88-31-31-31-17.12 0-31 13.88-31 31 0 17.12 13.88 31 31 31z',
			fillColor: '#FFA569',
			fillOpacity: 1.0,
			strokeColor: '#6A891A',
			strokeWeight: 1,
			scale: .16,
			anchor: new google.maps.Point(100, 313),
		},
		zIndex: 1
	});
	if(PointURL) {
		google.maps.event.addListener(marker, 'click', function() {
			window.open (PointURL, '_blank');
		});
	}
	resize();
}

// google.maps.event.addDomListener(window, 'deviceorientation', resize);
// google.maps.event.addDomListener(window, 'resize', resize);
function resize() {
	map.fitBounds(marker_bounds);
	if (map.getZoom() > $Zoom) {
		map.setZoom($Zoom);
	}
}

$(function(){
	init();
});

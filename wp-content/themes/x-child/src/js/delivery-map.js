var southnash_coords = [
	{lat:36.136035, lng:-86.821334},
	{lat:36.050588, lng:-86.879012},
	{lat:36.019632, lng:-86.886737},
	{lat:35.963798, lng:-86.809146},
	{lat:35.937117, lng:-86.707866},
	{lat:35.925858, lng:-86.658084},
	{lat:35.913903, lng:-86.623924},
	{lat:35.990331, lng:-86.625812},
	{lat:36.031849, lng:-86.667697},
	{lat:36.045869, lng:-86.710613},
	{lat:36.135203, lng:-86.759880},
	{lat:36.137698, lng:-86.801422}
];

var map;
var southNash_map;
var geocoder;

function initMap() {

	geocoder = new google.maps.Geocoder();
	
    // Create the map.
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11,
      center: {lat: 36.061924, lng: -86.769504},
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
        
    // Construct polygon
    var southNash_map = new google.maps.Polygon({
	    paths: southnash_coords,
	    strokeColor: '#0c63c5',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#0c63c5',
        fillOpacity: 0.35,
        map: map
    });     
}


function codeAddress(){
	var address = jQuery("input#address").val();
	var results=[];
	var test_lat=[];
	var test_lng=[];

	geocoder.geocode( { 'address': address, 'region': 'us'}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var test_lat = JSON.stringify(results[0].geometry.location.lat());
			var test_lng = JSON.stringify(results[0].geometry.location.lng());
			
			var southNash_map = new google.maps.Polygon({
				paths: southnash_coords,
				map: map
			});

			var testPoint = new google.maps.LatLng(test_lat, test_lng);
			
			if(google.maps.geometry.poly.containsLocation(testPoint, southNash_map) == true) {
	    		console.log('Address inside!');
	    	}else{
		    	console.log('Address outside.');
	    	}
		} else {
			console.log('bad geocode. address didnt take');
		}
	});
}

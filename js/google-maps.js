(function($) {

/*
*  render_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function render_map( $el ) {

	// var
	var $markers = $el.find('.marker');

	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP,
		scrollwheel : false,
		draggable: false
	};

	// create map	        	
	var map = new google.maps.Map( $el[0], args);

	// add a markers reference
	var markerslist = [];

	// add markers
	$markers.each(function(){

    	add_marker( $(this), map, markerslist );

	});

	// center map
	center_map( map , markerslist );

	var clusterStyles = [
  {
    	url: '../wp-content/themes/skipahoy/js/pin.png',
       	height: 32,
      	width: 20,
        anchorText: [-5, 0],
        textColor: '#ffffff',
        textSize: 10,
        anchorIcon: [32, 10]
  }
];
	
	var mcOptions = {
    gridSize: 15,
    styles: clusterStyles,
    maxZoom: 15,
    averageCenter: true
};

	var mc = new MarkerClusterer(map, markerslist, mcOptions);

}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map, markerslist ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	var category = $marker.attr('cat');

	if (category == 'Haven') {
		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			icon		: 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
		});
	} else if (category == "Ankerplaats") {
		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			icon		: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
		});
	} else {
		// create marker
		var marker = new google.maps.Marker({
			position	: latlng,
			map			: map,
			icon		: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
		});
	}

	// add to array
	markerslist.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map , markerslist ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( markerslist, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( markerslist.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/

$(document).ready(function(){

	$('.acf-map').each(function(){

		render_map( $(this) );

	});

});

})(jQuery);
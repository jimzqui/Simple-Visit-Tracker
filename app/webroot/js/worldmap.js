/**
 * World Map
 * worldmap.js
 */
(function(worldmap, undefined) {

	// Main object
	worldmap = {

		// Default settings
        defaults: {

        	// Map icons
        	map_icons: {
				'visit': 'img/icon-visit.png'
			},

			// Map options
			map_options: {
				zoom: 2,
				minZoom: 2,
				maxZoom: 4,
				center: new google.maps.LatLng(40, 30),
				disableDefaultUI: true
			}
        },

        // DOM objects
        el: {
        	map_canvas: $('#map-canvas')
        },

        // Initialize
        init: function(options) {
            var that = worldmap;

            // Construct final settings
            that.settings = $.extend({}, that.defaults, options);

            // Setup main data
            that.markers = [];
            that.ips = [];

            // Load map
			that.map = new google.maps.Map(that.el.map_canvas[0], that.settings.map_options);

			// Start tracking
            if(typeof(EventSource) !== 'undefined') {
            	that.startTrack();
            }
        },

        // Start SSE
        startTrack: function() {
        	var that = this;
			var source = new EventSource('data/track');
			console.log(source);

			// Listen for new messages
			source.onmessage = function(event) {
				console.log(event);
				var events = event.data.split('\n');
				for (var i = events.length - 1; i >= 0; i--) {
					var _event = events[i]
					var json = jQuery.parseJSON(_event);
					var ipindex = $.inArray(json.userip, that.ips);

					// New data received
					if (ipindex == -1) {
						that.addMarker(json);
					} else {
						if (!that.isMarkerPresent(ipindex)) {
							that.markers[ipindex].setMap(map);
						}
					}
				};
			};
        },

        // Check if marker is present
        isMarkerPresent: function(ipindex) {
        	var that = this;
        	return that.map.getBounds().contains(that.markers[ipindex].getPosition());
        },

        // Add new markers
        addMarker:function(json) {
        	var that = this;
			var marker = null;

			(function(json) {
				marker = that.placeMarker(json);
			})(json);

			(function(marker) {
				that.countdownMarker(marker);
			})(marker);
		},

		// Place marker to map
		placeMarker: function(json) {
			var that = this;
			var marker = new google.maps.Marker({
				map: that.map,
				draggable: false,
				animation: google.maps.Animation.DROP,
				icon: that.settings.map_icons[json.action],
				position: new google.maps.LatLng(json.latitude, json.longitude),
			});
			
			marker.userip = json.userip;
			marker.intervals = {count: 100, holder: false};
			marker.setOpacity(1);

			// Push marker to list
			that.markers.push(marker);

			// Push ips to list
			that.ips.push(json.userip);

			// Center markers
			that.fitBounds();

			// Setup infowindow
			var capitaliseFirstLetter = function(string) {
			    return string.charAt(0).toUpperCase() + string.slice(1);
			};

			var infowindow = new google.maps.InfoWindow({
				content: '<div class="infowindow"><b>' + 
				capitaliseFirstLetter(json.action) + 
				'</b> made at ' + json.source + '</div>'
			});

			// Add event listener for infowindow
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(that.map, marker);
			});

			return marker;
		},

		// Countdown to remove marker
		countdownMarker: function(marker) {
			var that = this;
			marker.intervals.holder = setInterval(function() {
				var interval = marker.intervals.count - 2;

				if (interval <= 20) {
					clearInterval(marker.intervals.holder);

					var ipindex = $.inArray(marker.userip, that.ips);
					that.removeMarker(ipindex);
				} else {
					marker.setOpacity(interval / 100);
					marker.intervals.count = interval;
				}
			}, 1000);
		},

		// Remove marker
		removeMarker: function(index) {
			var that = this;
			if (that.markers[index] == undefined) return;

			that.markers[index].setMap(null);
			that.markers.splice(index, 1);
			that.ips.splice(index, 1)

			if (that.markers.length == 0) {
				that.map.setZoom(2);
				that.map.setCenter(new google.maps.LatLng(40, 30));
			}
		},

		// Fit markers to screen
		fitBounds: function() {
			var that = this;
			var latlngbounds = new google.maps.LatLngBounds();
			for (var i = 0; i < that.markers.length; i++) {
				var marker = that.markers[i];
				latlngbounds.extend(marker.getPosition());
			}

			that.map.panToBounds(latlngbounds);
			that.map.fitBounds(latlngbounds);
		}
	}

	// Start worldmap
	google.maps.event.addDomListener(window, 'load', worldmap.init);

})( window.worldmap = window.worldmap || {});


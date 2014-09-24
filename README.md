# Simple Visit Tracker v1.0

This project is a simple visit tracker using a basic push notification 
made with SSE (Server Sent Events). The tracked visits are reflected in 
a Google Map. This can be installed on any website.

The push notification is inspired by Piwik's push method. It uses an 
unconventional way of pushing data to a server. Since it is not your 
usual ajax, it is hardly detected on any website consoles. It fast and
easy to use.

* Author: Jimbo Quijano
* Homepage: jimboquijano.com
* Email: jimzqui@yahoo.com


## DATABASE

1. Export database dump from sql/ dir
2. Modify database settings in app/Config/datase.php


## INSTALLATION

1. Include jqtracker.js in your page (get it inside webroot/js/ dir)
2. Change the jq_host variable in jqtracker.js
**Note: jQuery must be added before jqtracker**


## SAMPLE CODE

To push data to this application, you can call _jq.push() inside any jQuery handler.

```html
<script src="link/to/jqtracker.js"></script>
<script>
$(document).ready(function() {
    _jq.push({
		action: 'visit',
		userip: ip_address // Get this using PHPs $_SERVER['REMOTE_ADDR'] or equivalent
	});
});
</script>
```
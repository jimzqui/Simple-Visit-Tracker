/**
 * JQ Tracker v1.0
 * jqtracler.js
 * (c) 2014, Jimbo Quijano
 */

(function(_jq, undefined) {

    // Change this to your domain
    var jq_host = 'visittracker.localhost';

    _jq.push = function(options) {
        var opts = $.extend({}, {
            action: false,
            userip: false,
            source: document.URL,
            host: jq_host
        }, options);

        if (opts.action == false || opts.userip == false) { return; }
        var request = 'action=' + opts.action + '&source=' + opts.source + '&userip=' + opts.userip;
        _jq.sendRequest(request, opts.host)
    };
    _jq.sendRequest = function(request, host) {
        var image = new Image(1, 1);
        image.onload = function () { iterator = 0; };
        image.src = 'http://' + host + '/data/push?' + request;
    };
})( window._jq = window._jq || {});
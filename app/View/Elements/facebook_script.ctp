<!-- FACEBOOK -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId                : '',
      status               : true, // check the login status upon init?
      cookie               : true, // set sessions cookies to allow your server to access the session?
      xfbml                : true, // parse XFBML tags on this page?
    });
  };

(function(d, debug){
var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
if (d.getElementById(id)) {return;}
js = d.createElement('script'); js.id = id; js.async = true;
js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
ref.parentNode.insertBefore(js, ref);
}(document, /*debug*/ false));
</script>

<!DOCTYPE html>
<!--[if IEMobile 7 ]><html class="no-js iem7"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 lt-ie10"> <![endif]-->
<!--[if IE 9]><html class="no-js lt-ie10"><![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"><!--<![endif]-->
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $title_for_layout ?></title>
		<meta name="description" content="<?php echo $title_for_layout ?>">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php echo $this->fetch('meta'); ?>

		<!-- Load jQuery -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

		<!-- Google Map -->
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

		<!-- Load JS exports -->
		<?php echo $this->element('javascript_export') ?>

		<!-- Load CSS and JS -->
		<?php
		echo $this->Html->css(array('jquery-ui-1.10.2.custom.min', 'bootstrap', 'style'));
		echo $this->Html->script(array('vendor/modernizr-2.6.2.min'));
		?>
	</head>
	<body>
		<!-- FB scripts -->
		<?php echo $this->element('facebook_script') ?>

		<!-- Yield content -->
		<div id="container">
			<?php echo $this->fetch('content'); ?>
		</div>

		<!-- Main JS -->
		<?php echo $this->Html->script(array('functions')); ?>

		<script type="text/javascript">
		  //<![CDATA[
		  $(function() {
			<?php echo $this->fetch('onload'); ?>
		  })
		  //]]>
		</script>

		<script src="http://worldmap.stg.marketing4restaurants.com/js/worldmap.js"></script>
		<script>
			$('#button1').click(function() {
				_m4r.push({
					action: 'visit',
					userip: '122.148.126.234',
					host: 'worldmap.localhost'
				});
			});
			$('#button2').click(function() {
				_m4r.push({
					action: 'visit',
					userip: '144.76.43.70',
					host: 'worldmap.localhost'
				});
			});
			$('#button3').click(function() {
				_m4r.push({
					action: 'visit',
					userip: '203.35.82.165',
					host: 'worldmap.localhost'
				});
			});
			$('#button4').click(function() {
				_m4r.push({
					action: 'visit',
					userip: '22.231.113.64',
					host: 'worldmap.localhost'
				});
			});
			$('#button5').click(function() {
				_m4r.push({
					action: 'call',
					userip: '194.66.82.11'
				});
			});
			$('#button6').click(function() {
				_m4r.push({
					action: 'call',
					userip: '112.210.61.127',
					host: 'worldmap.localhost'
				});
			});
			$('#button7').click(function() {
				_m4r.push({
					action: 'call',
					userip: '216.27.61.137',
					host: 'worldmap.localhost'
				});
			});
			$('#button8').click(function() {
				_m4r.push({
					action: 'booking',
					userip: '194.153.205.26',
					host: 'worldmap.localhost'
				});
			});
			$('#button9').click(function() {
				_m4r.push({
					action: 'booking',
					userip: '95.108.142.138',
					host: 'worldmap.localhost'
				});
			});
			$('#button10').click(function() {
				_m4r.push({
					action: 'booking',
					userip: '122.59.104.29',
					host: 'worldmap.localhost'
				});
			});
		</script>
	</body>
</html>
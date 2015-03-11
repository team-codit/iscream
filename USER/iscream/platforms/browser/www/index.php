<!DOCTYPE html>
<html>
    <head>
	    <meta charset="utf-8"> 
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="format-detection" content="telephone=no" />
        <meta name="msapplication-tap-highlight" content="no" />
        <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"/>
        <link rel="icon" type="image/png" href="img/logo.png" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/animate.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/header.css"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" href="css/scroll-css/jquery.mCustomScrollbar.min.css"/>
        <title>I'Scream</title>
        <!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>

	    
		<?php require_once("header.html"); ?>
		<?php require_once("content.php"); ?>


        <script type="text/javascript" src="js/library/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="js/library/transparency.min.js"></script>
        <script type="text/javascript" src="js/library/bootstrap.min.js"></script>
        <!-- <script type="text/javascript" src="cordova.js"></script> -->
        <script type="text/javascript" src="js/functions/config.js"></script>
        <script type="text/javascript" src="js/functions/events.js"></script>
        <script type="text/javascript" src="js/functions/api.js"></script>
        <script type="text/javascript" src="js/functions/load.js"></script>
        <script type="text/javascript" src="js/functions/index.js"></script>
        <script type="text/javascript" src="js/library/scroll-js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script>
			(function($){
				$(window).load(function(){
					$(".dropdown-menu").mCustomScrollbar();
   				});
			})(jQuery);
		</script>
    </body>
</html>

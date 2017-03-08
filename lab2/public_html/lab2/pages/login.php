<!DOCTYPE html>

<?php
include_once '../includes/dbConnect.php';
include_once '../includes/functions.php';

sec_session_start();
if (!isset($_SESSION['roleID'], $_SESSION['userEmail'])):

?>
<html lang="en">

<head>
    <title>Login</title>

    <!-- Header Information, CSS, and JS -->
    <?php include("../includes/header.php"); ?>
<style style="text/css">
.scroll-left {
 height: 50px;	
 overflow: hidden;
 position: relative;
}
.scroll-left h1 {
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: center;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);	
 transform:translateX(100%);
 /* Apply animation to this element */	
 -moz-animation: scroll-left 10s linear infinite;
 -webkit-animation: scroll-left 10s linear infinite;
 animation: scroll-left 10s linear infinite;
}
/* Move it (define the animation) */
@-moz-keyframes scroll-left {
 0%   { -moz-transform: translateX(100%); }
 100% { -moz-transform: translateX(-100%); }
}
@-webkit-keyframes scroll-left {
 0%   { -webkit-transform: translateX(100%); }
 100% { -webkit-transform: translateX(-100%); }
}
@keyframes scroll-left {
 0%   { 
 -moz-transform: translateX(100%); /* Browser bug fix */
 -webkit-transform: translateX(100%); /* Browser bug fix */
 transform: translateX(100%); 		
 }
 100% { 
 -moz-transform: translateX(-100%); /* Browser bug fix */
 -webkit-transform: translateX(-100%); /* Browser bug fix */
 transform: translateX(-100%); 
 }
}


@keyframes rainbow-text {
  0% {
    color: #e87d7d;
  }
  2% {
    color: #e88a7d;
  }
  4% {
    color: #e8977d;
  }
  6% {
    color: #e8a47d;
  }
  8% {
    color: #e8b07d;
  }
  10% {
    color: #e8bd7d;
  }
  12% {
    color: #e8ca7d;
  }
  14% {
    color: #e8d77d;
  }
  16% {
    color: #e8e47d;
  }
  18% {
    color: #dfe87d;
  }
  20% {
    color: #d3e87d;
  }
  22% {
    color: #c6e87d;
  }
  24% {
    color: #b9e87d;
  }
  26% {
    color: #ace87d;
  }
  28% {
    color: #9fe87d;
  }
  30% {
    color: #92e87d;
  }
  32% {
    color: #86e87d;
  }
  34% {
    color: #7de881;
  }
  36% {
    color: #7de88e;
  }
  38% {
    color: #7de89b;
  }
  40% {
    color: #7de8a8;
  }
  42% {
    color: #7de8b5;
  }
  44% {
    color: #7de8c1;
  }
  46% {
    color: #7de8ce;
  }
  48% {
    color: #7de8db;
  }
  50% {
    color: #7de8e8;
  }
  52% {
    color: #7ddbe8;
  }
  54% {
    color: #7dcee8;
  }
  56% {
    color: #7dc1e8;
  }
  58% {
    color: #7db5e8;
  }
  60% {
    color: #7da8e8;
  }
  62% {
    color: #7d9be8;
  }
  64% {
    color: #7d8ee8;
  }
  66% {
    color: #7d81e8;
  }
  68% {
    color: #867de8;
  }
  70% {
    color: #927de8;
  }
  72% {
    color: #9f7de8;
  }
  74% {
    color: #ac7de8;
  }
  76% {
    color: #b97de8;
  }
  78% {
    color: #c67de8;
  }
  80% {
    color: #d37de8;
  }
  82% {
    color: #df7de8;
  }
  84% {
    color: #e87de4;
  }
  86% {
    color: #e87dd7;
  }
  88% {
    color: #e87dca;
  }
  90% {
    color: #e87dbd;
  }
  92% {
    color: #e87db0;
  }
  94% {
    color: #e87da4;
  }
  96% {
    color: #e87d97;
  }
  98% {
    color: #e87d8a;
  }
  100% {
    color: #e87d7d;
  }
}
.rainbow-text {
  animation: rainbow-text 1s infinite;
}

</style>
</head>

<body>
<!-- displaySite("Login"); -->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                    	<h3 class="panel-title">Inventory System by Tyler Postma, Josh Hester, and Joel Blumenthal</h3>
                    </div>
<div class="scroll-left rainbow-text">
		<h1>Book Inventory System!</h1>
	</div>
                    <div class="panel-body">
                        <!--<form role="form">-->
			<form action="../includes/processLogin" method="post" name="login_form" role="form">
                            <fieldset>
                                <div class="form-group">
				    <label> Use zcat@lssu.edu to log in and the password discussed in class </label>
                                    <input class="form-control" placeholder="E-mail" name="userEmail" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
				<div class="form-group">
				    <a href="register_form">Register an Account</a>
				</div>	
				<input type="Submit" class="btn btn-lg btn-success btn-block" 
                                                   value="Sign in" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $.fn.downCount = function (options, callback) {
        var settings = $.extend({
                date: null,
                offset: null
            }, options);

        // Save container
        var container = this;

        /**
         * Change client's local date to match offset timezone
         * @return {Object} Fixed Date object.
         */
        var currentDate = function () {
            // get client's current date
            var date = new Date();

            // turn date to utc
            var utc = date.getTime() + (date.getTimezoneOffset() * 60000);

            // set new Date object
            var new_date = new Date(utc + (3600000*settings.offset))

            return new_date;
        };

        /**
         * Main downCount function that calculates everything
         */
var original_date = currentDate();
var target_date = new Date('12/31/2020 12:00:00'); // Count up to this date

function onButtonClick() {
    original_date = currentDate();
}

function countdown () {
        var current_date = currentDate(); // get fixed current date

        // difference of dates
        var difference = current_date - original_date;

        if (current_date >= target_date) {
            // stop timer
            clearInterval(interval);

            if (callback && typeof callback === 'function') callback();

            return;
        }

        // basic math variables
        var _second = 1000,
            _minute = _second * 60,
            _hour = _minute * 60,
            _day = _hour * 24;

        // calculate dates
        var days = Math.floor(difference / _day),
            hours = Math.floor((difference % _day) / _hour),
            minutes = Math.floor((difference % _hour) / _minute),
            seconds = Math.floor((difference % _minute) / _second);

            // fix dates so that it will show two digets
            days = (String(days).length >= 2) ? days : '0' + days;
            hours = (String(hours).length >= 2) ? hours : '0' + hours;
            minutes = (String(minutes).length >= 2) ? minutes : '0' + minutes;
            seconds = (String(seconds).length >= 2) ? seconds : '0' + seconds;
    
            // based on the date change the refrence wording
            var ref_days = (days === 1) ? 'day' : 'days',
                ref_hours = (hours === 1) ? 'hour' : 'hours',
                ref_minutes = (minutes === 1) ? 'minute' : 'minutes',
                ref_seconds = (seconds === 1) ? 'second' : 'seconds';

            // set to DOM
            container.find('.days').text(days);
            container.find('.hours').text(hours);
            container.find('.minutes').text(minutes);
            container.find('.seconds').text(seconds);

            container.find('.days_ref').text(ref_days);
            container.find('.hours_ref').text(ref_hours);
            container.find('.minutes_ref').text(ref_minutes);
            container.find('.seconds_ref').text(ref_seconds);
        };
        
        // start
        var interval = setInterval(countdown, 1000);
    };





$(document).ready(function(){
   $('.countdown').downCount();
});
</script>
</body>

</html>

<?php

else:
//TODO: Update this with a better page
$url = "../pages/viewProfile";
header("Location:$url");
return;
endif;
?>

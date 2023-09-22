
// https://stackoverflow.com/questions/1987524/turn-a-number-into-star-rating-display-using-jquery-and-css, Zeile 4 bis 16.
// Zeile 7 bis 16 angepasst.
$.fn.stars = function() {
	return $('.star-cont').each(function() {
		// Get the value
		var val = parseFloat(jQuery(this).attr('data'));
		// if val max = 10 then val / 2 else only val
		if (typeof val == "number") {
			var size = Math.max(0, (Math.min(5, (val / 2)))) * 18;
		}else {
			size = 0;
		}
		jQuery(this).append('<span><span class="star-inactive"><span class="stars" style="width: ' + (size) + 'px;"></span>');
	});
}

// Texteditor einbinden
if ($('.description').html()) {
	$('.description').jqte();
}

$(function() {
	$('span.star-cont').stars();
});

var countDown = 10000; // 10 secs
var countTime = 1000; // 1 sec
// https://www.w3schools.com/howto/howto_js_countdown.asp Zeile 22 bis 40,
// einige Zeile entfernt und Zeile 26 angepasst
function countdown() {
	var x = setInterval(function() {

		// Find the distance between countTime and the count down
		var timeLeft = countDown - countTime;
		countDown = timeLeft;
		// Time calculations for days, hours, minutes and seconds
		var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

		// Display the result in the element with id="demo"
		document.getElementById("demo").innerHTML = seconds + "s ";

		// If the count down is finished, write some text
		if(timeLeft < 0) {
			clearInterval(x);
			document.getElementById("demo").innerHTML = "0s";
		}
	}, 1000);
}

// Delay redirect
// https://www.w3schools.com/jsref/met_win_settimeout.asp
// Zeile 50 bis 54
var hasDelay = document.getElementById("delay");
if(hasDelay) {
	countdown();
	setTimeout(function() {
		document.getElementById("foward").click();
	}, 5000);
}

/* Log Button Trigger */
$('#logbutton').click(
function logTrigger(){
	console.log('BUTTON');
	var data = $('#logbutton').attr("data");
	var button = $('#logbutton');
	$('.log').each(function() {
		if(data == 'show') {
			$(this).removeClass("hide");
		} else if(data == 'hide') {
			$(this).addClass("hide");
		}
	});

	if(data == 'show') {
		button.text($('.hide-log').text());
		button.attr("data", 'hide');
		$('.not-log').each(function() {
			$(this).addClass("hide");
		});
	} else {
		button.text($('.make-log').text());
		button.attr("data", 'show');
		$('.not-log').each(function() {
			$(this).removeClass("hide");
		});
	}
});

function burgerToggle() {
	var x = document.getElementById("navbarSupportedContent");
	if (x.style.display === "block") {
	  x.style.display = "none";
	} else {
	  x.style.display = "block";
	}
	console.log('burger: ', x);
  }

// Get Country with IP
// https://blog.logrocket.com/detect-location-and-local-timezone-of-users-in-javascript-3d9523c011b9/
// fetch('https://extreme-ip-lookup.com/json/')
// 	.then(res => res.json())
// 	.then(response => {
// 		console.log("Country: ", response.countryCode);
// 	})
// 	.catch((data, status) => {
// 		console.log('Request failed');
// 	});

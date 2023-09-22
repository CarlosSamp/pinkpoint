var language = $('.lang-select option').first().text().toLowerCase();
$.datetimepicker.setLocale(language);
$('.datetimepicker').datetimepicker({
	format: 'd.m.Y', // insert '... H:i' to add time
	timepicker: 0,
	setDate: new Date()
});

const form = document.getElementsByTagName('form')[0];
var regExp = /^(0?[1-9]|[12][0-9]|3[01])[\.](0?[1-9]|1[012])[\.]\d{4}$/;

// distinct the past validation
var mode = jQuery.isEmptyObject($("#modeEdit"))
mode = true;

$(".datetimepicker").focusin(function() {

	$(this).on('change', checkInput);
	$(this).bind('input propertychange', checkInput);

	function checkInput() {
		var errorMsg = $(this).siblings('span');
		if(errorMsg.length == 0) {
			$(this).after('<span id="error"></span>');
		}

		var status = formatDate($(this).val());
		if(regExp.test($(this).val()) && status <= 2) {
			errorMsg.html('');
			$(this).removeClass('invalid');
		} else {
			if(regExp.test($(this).val()) && status == 3 && !mode) {
				errorMsg.html($('.date-later').text()); //'<span id="error"> Bitte ein späteres Datum eintragen </span>');
			} else {
				errorMsg.html($('.date-invalid').text());
			}
			$(this).removeClass('valid').addClass('invalid');
		}
	}

	// https://www.w3resource.com/javascript/form/javascript-date-validation.php, Zeile 40 bis 90
	function formatDate(date) {
		var status = 1;
		var now = new Date();
		var monthNames = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];

		var day = now.getDate();
		var monthIndex = now.getMonth();
		var year = now.getFullYear();
		//var now = day + '.' + monthNames[monthIndex] + '.' + year;
		date = date.split(".");

		// Check if date is in the Past
		if(!mode) {
			if(date[2] >= year) {
				status = 1;
				if(date[2] == year) {
					// for today unvalid set <= day else <
					if(date[0] < day && date[1] <= monthNames[monthIndex]) {
						status = 3;
					}
				}
				if(date[1] < monthNames[monthIndex] && date[2] == year) {
					status = 3;
				}
			} else {
				status = 3;
			}
		}

		// Check Days of the Month
		var ListofDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		if(date[1] == 01 || date[1] > 02) {
			if(date[0] > ListofDays[(date[1] - 1) - 0]) {
				status = 4;
			}
		}
		// Check for odd Years
		if(date[1] == 02) {
			var lyear = false;
			if((!(date[2] % 4) && date[2] % 100) || !(date[2] % 400)) {
				lyear = true;
			}
			if((lyear == false) && (date[0] >= 29)) {
				status = 4;
			}
			if((lyear == true) && (date[0] > 29)) {
				status = 4;
			}
		}
		return status
	}

});

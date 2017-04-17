$(function() {

	$(".need_validation").validate({
		focusInvalid: true,
		ignore: ':hidden',
		errorPlacement: function(error, element) {
			if (element.parent().parent().attr("class") == "checker" || element.parent().parent().attr("class") == "choice" ) {
				error.appendTo( element.parent().parent().parent().parent().parent() );
			} 
			else if (element.parent().parent().attr("class") == "checkbox" || element.parent().parent().attr("class") == "radio" ) {
				error.appendTo( element.parent().parent().parent() );
			} 
			else {
				error.insertAfter(element);
			}
		},
		rules: {
			minimum_characters: {
				required: true,
				minlength: 3
			},
			maximum_characters: {
				required: true,
				maxlength: 6
			},
			minimum_number: {
				required: true,
				min: 3
			},
			maximum_number: {
				required: true,
				max: 6
			},
			range: {
				required: true,
				range: [6, 16]
			},
			email_field: {
				required: true,
				email: true
			},
			url_field: {
				required: true,
				url: true
			},
			date_field: {
				required: true,
				date: true
			},
			digits_only: {
				required: true,
				digits: true
			},
			password: {
				required: true,
			},
			password_again: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			custom_message: "required",
			group_styled: {
				required: true,
				minlength: 2
			},
			group_unstyled: {
				required: true,
				minlength: 2
			},
			agree: "required"
		},
		messages: {
			custom_message: {
				required: "Bazinga! This message is editable",
			},
			agree: "Please accept our policy"
		},
		success: function(label) {
			label.text('Success!').addClass('valid');
			label.remove();
		},
		submitHandler: function (form) {
			form.submit();
		}
	});

$('select.select2ajax', $('form.need_validation')).on("change",function () {
	$('form.need_validation').validate().element($(this));
});
$('select.select2_new', $('form.need_validation')).on("change", function () {
	$('form.need_validation').validate().element($(this));
});
$('select.select2', $('form.need_validation')).on("change", function () {
	$('form.need_validation').validate().element($(this));
});
$('select.select2_new_clear', $('form.need_validation')).on("change", function () {
	$('form.need_validation').validate().element($(this));
});

$.validator.addClassRules({
	wajib: {
		required: true
	},
	wajibcheckbox: {
		required: true
	},
	wajibfile: {
		required: true,
		extension: "xls|csv"
	}
});


$.extend($.validator.messages, {
	required: "Kolom ini Wajib di isi.",
	remote: "Please fix this field.",
	email: "Harap Gunakan Format Email.",
	url: "Please enter a valid URL.",
	date: "Harap Gunakan Format Tanggal",
	dateISO: "Please enter a valid date (ISO).",
	number: "Hanya Angka yang di perbolehkan",
	digits: "Hanya Angka yang di perbolehkan",
	creditcard: "Please enter a valid credit card number.",
	equalTo: "Tidak Sama.",
	accept: "Please enter a value with a valid extension.",
	maxlength: $.validator.format("Kurang dari {0} characters."),
	minlength: $.validator.format("Lebih {0} characters."),
	rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
	range: $.validator.format("Please enter a value between {0} and {1}."),
	max: $.validator.format("Maksimal {0}."),
	min: $.validator.format("Minimal {0}."),
});
});
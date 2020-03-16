$(function() {
/*	popbuttons([{
		text:'Submit Suggestion',
		click:function() {
			$.post(
				'[afurl.base]/event/suggest/submit',
				$('#frm-submit-event').serialize(),
				function(data) { $('#popup-window').html(data); }
			);
		}
	}], true);*/


	$('#new-event-from').datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		defaultDate: Date.now(),
		onSelect: function(selectedDate) {
			$('#new-event-to').datepicker('option', 'minDate', selectedDate);
			$('#new-event-start').val(selectedDate);
		}
	});

	$('#new-event-to').datepicker({
		changeMonth: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		defaultDate: Date.now(),
		onSelect: function(selectedDate) {
			$('#new-event-from').datepicker('option', 'maxDate', selectedDate);
			$('#new-event-end').val(selectedDate);
		}
	});
});

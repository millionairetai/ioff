$(function () {
//	$('#datepicker_start').datetimepicker({
//		format: 'mm/dd/yyyy'
//	}
//	);
//	$('#datetimepicker4').datetimepicker({
//	});
//	
//	$('#datepicker_end').datetimepicker();
//	$('#timepicker_end').datetimepicker({
//		format: 'LT'
//	});
	
	 $('#datetimepicker_start').datetimepicker();
     $('#datetimepicker_end').datetimepicker({
         useCurrent: false //Important! See issue #1075
     });
     $("#datetimepicker_start").on("dp.change", function (e) {
         $('#datetimepicker_end').data("DateTimePicker").minDate(e.date);
     });
     $("#datetimepicker_end").on("dp.change", function (e) {
         $('#datetimepicker_start').data("DateTimePicker").maxDate(e.date);
     });
});

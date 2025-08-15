$('#toggleFormBtn').on('click', function (e) {
	e.stopPropagation();
	$('#dropdownForm').toggle();
});

$('#dropdownForm').on('click', function (e) {
	e.stopPropagation();
});

$(document).on('click', function () {
	$('#dropdownForm').hide();
});

function checkExportForm()
{
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
	if(from_date!='' && to_date !='' ){
		$('#dateRangeModal').modal('hide');
	}
}
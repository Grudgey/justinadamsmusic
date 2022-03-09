jQuery(document).ready(function($) {
	$('.import_jamsession_btn').click(function(){

		$('#demo_to_import').val($(this).data("importname"));
		return;
	});
});

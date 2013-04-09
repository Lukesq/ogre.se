$(document).ready(function() {
	var list = $("#skills .list");
	$("html").click(
		function() {
			list.hide();
		}
	);
	$("#skills .current").click(
		function(event) {
			list.toggle();
			return false;
		}
	);
});

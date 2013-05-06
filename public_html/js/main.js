$(document).ready(function() {
	$("#highscore").tablesorter({
		sortInitialOrder: "desc",
		sortList: [[0,0]]
	});
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

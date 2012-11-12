$(document).ready(function() {

	$("#advSearchToggle").click(function() {
		console.log("click");
		if ($(this).children().hasClass("icon-chevron-down"))
			$(this).children().removeClass("icon-chevron-down").addClass("icon-chevron-up");
		else
			$(this).children().removeClass("icon-chevron-up").addClass("icon-chevron-down");
		
		$("#advSearch").slideToggle();
	});
	
});
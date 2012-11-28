function setupSwapFade(a, b, c) {
	$(a).click(function() {
		$(b).fadeOut('fast', function() {
			$(c).fadeIn();
		});
	});
}


$(document).ready(function() {

	setupSwapFade("#gotoSignIn", "#notSignedIn", "#signInFormContainer");
	setupSwapFade("#closeBtn", "#signInFormContainer", "#notSignedIn");
	
	$("#signInBtn").click(function() {
		$("#signInForm").submit();
	});
	
	$("#searchBtn").click(function() {
		$("#searchForm").submit();
	});
	
});
function setupSwapFade(a, b, c) {
	$(a).click(function() {
		$(b).fadeOut('fast', function() {
			$(c).fadeIn();
		});
	});
}

function setTitle(title) {
	if (title && title.length > 0)
		document.title  = "PicTwist - " + title;
	else
		document.title = "PicTwist";
}

function redirectParent(location) {
	parent.location.href = location;
}


$(document).ready(function() {

	setUpFancybox();

	setupSwapFade("#gotoSignIn", "#notSignedIn", "#signInFormContainer");
	setupSwapFade("#closeBtn", "#signInFormContainer", "#notSignedIn");
	
	$("#signInBtn").click(function() {
		$("#signInForm").submit();
	});
	
	$("#searchBtn").click(function() {
		$("#searchForm").submit();
	});
	
	$("#register").submit(validateRegister);	
	
	
	$("#showAddTags").click(function() {
		$("#addTags").slideToggle();
	});
	
	$("#addTagBtn").click(function() {
		$("#addTagsForm").submit();
	});
	
	$(".tag, .tagContainer .flagBtn").hover(
		function() {
			$(this).closest(".tagContainer").children(".flagBtn").show();
		},
		function() {		
			$(this).closest(".tagContainer").children(".flagBtn").hide();
		});
		
	$("#showShareAlbum").click(function() {
		$("#shareAlbum").fadeToggle();	
	});	
	
	setupSwapFade("#albums_newAlbumToggle", "#albums_newAlbumToggle", "#albums_newAlbum");
	
	
	
});


function checkPassword() {
	var val1 = $("#password_hash").val();
	var val2 = $("#password_hash2").val();
	
	var min = 6;
	
	if (val1 && val1.length < min)
		$("#passwordLengthMsg").show();
	else
		$("#passwordLengthMsg").hide();	
		
	
	if (!val1 || !val2) {
		$("#passwordMatchIcon").removeClass("icon-ok").removeClass("icon-remove").hide();
	} else {
		if (val1 != val2) {
			$("#passwordMatchIcon").removeClass("icon-ok").addClass("icon-remove").show();
		} else {
			$("#passwordMatchIcon").removeClass("icon-remove").addClass("icon-ok").show();
		}
	}
}

function validateRegister() {
	var name = $("#name").val();
	var email = $("#email").val();
	var pass1 = $("#password_hash").val();
	var pass2 = $("#password_hash2").val();
	
	var min = 6;
	
	if (!name || !email || !pass1 || !pass2) {
		$("#registerValidation").html("Please fill out required fields (*)").show().fadeOut(5000);
		return false;
	 } else if (!validateEmail(email)) {		
		$("#registerValidation").html("E-mail is not valid").show().fadeOut(5000);
		return false; 
	} else if ($("#password_hash").val() != $("#password_hash2").val()) {
		$("#registerValidation").html("Passwords do not match").show().fadeOut(5000);
		return false;
	} else if (pass1.length < min) {
		$("#registerValidation").html("Password too short (6+ characters)").show().fadeOut(5000);
		return false;
	} else {
		return true;
	}
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 


function setUpFancybox() {
	//alert("Hey there");
	$(".fancybox").fancybox();
	
	$(".fancybox-iframe").fancybox({
		
		type : 'iframe',
		prevEffect : 'fade',
		nextEffect : 'fade',
		openEffect : 'none',
		closeEffect : 'none',
		margin : [20, 60, 20, 60],				
		
		closeBtn : true,
		arrows : true,
		nextClick : false,
		
		helpers: {
			title : {
				type : 'inside'
			}
		},
		
		beforeShow: function() {
			this.width = 1000;
		}
		
	});
	//alert("leaving...");
}
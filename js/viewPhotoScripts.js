
$(function() {
	$(".submitTag").live('click', function() {
			
			var n = document.createElement("a");
			var x = document.createElement("a");
			$(x).addClass("closetext");
			x.innerHTML = " x";
			var v = $(this).parent().find('.newTag').val();
			if(v != "") {
				n.innerHTML = ", " + v;
				
				$(this).parent().find(".tags").append(n);
				$(this).parent().find(".tags").append(x);

				$(this).closest('div').find("input[type=text]").val("");
				
				
			}

			return false;
	});
});

$(function() {
	$(".closetext").live('click', function() {
		
		$(this).prev().remove();
		$(this).remove();
		
		return false;
	});
});

$(function() {
	$(".submitComment").live('click', function() {
			
			var n = document.createElement("div");
			$(n).addClass("comment");
			
			var v = $(this).parent().find(".commentText").val();
			if(v != "") {
			
				n.innerHTML = "<h5>Test User</h5><p>" + v + "</p>";
				
				$(this).parent().parent().find(".comments").append(n);

				$(this).closest('div').find(".commentText").val("Add a comment");
					
			}

			return false;
	});
});
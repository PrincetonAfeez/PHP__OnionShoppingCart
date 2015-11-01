$(function(){

	$("form#add-vendor-form").on("submit", function(e) {
		e.preventDefault();
		thisForm = $("form#add-vendor-form");
		$.ajax({
			url: thisForm.attr("action"),
			type: thisForm.attr("method"),
			data: {
				name:thisForm.find("input[name=name]").val(),
				country_code:thisForm.find("select[name=country_code]").val(),
				address:thisForm.find("input[name=address]").val(),
				tel:thisForm.find("input[name=tel]").val(),
				fax:thisForm.find("input[name=fax]").val()
			},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				if (data.result == true) {
					setModal("Information updated successfully.<p>Refresh to see the effect.", true);
				} else {
					setModal("Error on saving data.<p>If it still occurs after retrying, please report to the website administration.",
							 false);
				}
				$('#AjaxResultModal').modal();
			},
			error: function() {
				setModal("Server error on saving data.<p>Please report to the website administrator.",false);
				$('#AjaxResultModal').modal();
			}
		});	
	});
		    
});
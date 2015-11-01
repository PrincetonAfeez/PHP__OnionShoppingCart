
$(function() {
	$('#btn_change_feature_image').on('click',function() {
		$.ajax({
			url: "../api/get-upload-image-list",
			type: "POST",
			data: {},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				if (data.result == true) {
					$("#selectImageModal .modal-body").html('');
					$.each(data.images, function(key,value) {
						$("#selectImageModal .modal-body").append('<button><img src="'+value+'" /><br/>'+value+'</button>');
					});
					$("#selectImageModal .modal-body button").on("click", function(e){
						e.preventDefault();
						$('#image-list #img-preview').attr('src',$(this).find("img").attr('src'));
						$('#image-list input[name=feature_image_url]').val($(this).find("img").attr('src'));
						$("#selectImageModal").modal('hide');
					});
					$("#selectImageModal").modal();
				} else {
					setModal("Error on loading data.<p>If it still occurs after retrying, please report to the website administration.",
							 false);
					$('#AjaxResultModal').modal();
				}
			},
			error: function() {
				setModal("Server error on loading data.<p>Please report to the website administrator.", false);
				$('#AjaxResultModal').modal();
			}
		});
	});
	
	var observer = $("#selectImageModal .modal-body");
	observer.on('dragenter', function (e) 
	{
	    e.stopPropagation();
	    e.preventDefault();
	    $(this).css('border', '2px solid #0B85A1');
	});
	observer.on('dragover', function (e) 
	{
	     e.stopPropagation();
	     e.preventDefault();
	});
	observer.on('drop', function (e) 
	{
	 
	     $(this).css('border', 'none');
	     e.preventDefault();
	     var files = e.originalEvent.dataTransfer.files;
	     var fd = new FormData();
	     fd.append('file', files[0]);
	     $.ajax({
				url: "../api/upload-image",
				type: "POST",
				contentType:false,
			    processData: false,
		        cache: false,
				dataType: "json",
				data:fd,
				success: function(response, status, xhr) {
					var data = $.parseJSON(xhr.responseText);
					if (data.result == true) {
						$('#image-list #img-preview').attr('src',data.filepath);
						$('#image-list input[name=feature_image_url]').val(data.filepath);
						$("#selectImageModal").modal('hide');
					} else {
					}
				},
				error: function() {
				}
			});
	     //We need to send dropped files to Server
	});
});

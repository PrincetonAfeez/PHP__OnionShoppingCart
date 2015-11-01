/********************* Modal control **********************/
function setModal(message,greenlight){
	if (greenlight){
		$('#AjaxResultModal .modal-header .resultIcon ').removeClass("glyphicon-remove-circle");
		$('#AjaxResultModal .modal-header .resultIcon').addClass("glyphicon-ok-circle");
		$('#AjaxResultModal .modal-body').removeClass("error");
		$('#AjaxResultModal .modal-body').addClass("success");
	} else {
		$('#AjaxResultModal .modal-header .resultIcon').removeClass("glyphicon-ok-circle");
		$('#AjaxResultModal .modal-header .resultIcon').addClass("glyphicon-remove-circle");
		$('#AjaxResultModal .modal-body').removeClass("success");
		$('#AjaxResultModal .modal-body').addClass("error");
	}
	$('#AjaxResultModal .modal-body').html(message);
}
/******************** /Modal control **********************/

$(function(){

	/********************* List product bulk action control **********************/
	$(".bulk-control").on("click", function(e) {
		currentTarget = $(e.target);
		if (currentTarget.prop("tagName") == "INPUT") {
			checkboxTR = currentTarget.closest("TR");
			if ($(e.target).prop('checked')){
				checkboxTR.addClass('checked');
			} else {
				checkboxTR.removeClass('checked');
			}
		} else {
			checkboxDOM = $(this).find("input[type=checkbox]");
			if (checkboxDOM.prop('checked')){
				checkboxDOM.prop('checked', false);
				$(this).removeClass('checked');
			} else {
				checkboxDOM.prop('checked', true);
				$(this).addClass('checked');
			}
		}
	});
	
	$(".page-content.admin #btn_bulkedit_brand").on("click", function() {
		bulk_id = [];
		$(".page-content.admin .bulk-control input[type=checkbox]:checked").each(function() {
			bulk_id.push($(this).val());
		});
		$.ajax({
			url: $(".page-content.admin #bulkEditForm").attr("action"),
			type: $(".page-content.admin #bulkEditForm").attr("method"),
			data: {
				bulk_id:bulk_id.join(','),
				brand_id:$(".page-content.admin #bulkEditForm select[name=brand_id]").val()
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
	$(".page-content.admin #AjaxResultModal .modal-footer #refresh-btn").on("click", function() {
		location.reload();
	});
	/******************** /List product bulk action control **********************/
	
	
	/********************* Control status toggle switch button **********************/
	$('.edit-form input[name=status]').parent().on("click",function(){
		if ($(this).hasClass('off')){
			$('.edit-form input[name=status]').prop('checked', false);
		} else {
			$('.edit-form input[name=status]').prop('checked', true);
		}
	});
	/********************* /Control status toggle switch button **********************/

	
	/********************* Control brand select menu **********************/
	$('.edit-form input[name=newBrandName]').hide();

	$('.edit-form select[name=brand_id]').on("change",function(){
		if ($(this).val()==""){
			$('.edit-form input[name=newBrandName]').show();
		}
	});
	/********************* /Control brand select menu **********************/

	
	/********************* Control variation add button ***********************/
	$('#variation-list .add-new-variation-input').hide();

	$('#variation-list button#add-variation').on("click",function(){
		$(this).hide();
		$('#variation-list .add-new-variation-input').show();
	});
	/********************* /Control variation add button **********************/

	
	/********************* Control basic information submit event **********************/
	$('.edit-form #basic-product-information input[name=submit]').on("click",function(e){
		e.preventDefault();
		if ( $(".edit-form input[name=weight]").val().length == 0 ){
			$(".edit-form input[name=weight]").val(0);
		}

		$.ajax({
			url: "../api/update-product",
			type: "POST",
			data: {
				product_id:$(".edit-form input[name=product_id]").val(),
				slug:$(".edit-form input[name=slug]").val(),
				description:$("#tinymce-textarea_ifr").contents().find("#tinymce").html(),
				unit:$(".edit-form input[name=unit]").val(),
				weight:$(".edit-form input[name=weight]").val(),
				brand_id:$(".edit-form select[name=brand_id]").val(),
				status:$('.edit-form input[name=status]').is(":checked")?'ON':'OFF',
				cat_id:$(".edit-form select[name=cat_id]").val(),
				feature_image:$('#image-list input[name=feature_image_url]').val()
			},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				if (data.result == true) {
					setModal("Information updated successfully", true);
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
	/********************* /Control basic information submit event **********************/
	
	
	/******************** Control category list *********************/
	$(".edit-form .add-category-form").hide();
	
	$(".edit-form button#open-add-category").on("click",function(){
		$(this).hide();
		$(".edit-form .add-category-form").show();
	});
	
	$(".edit-form button#add-category-action-btn").on("click",function(){
		$.ajax({
			url: "../api/append-category",
			type: "POST",
			data: {
				product_id:$(".edit-form input[name=product_id]").val(),
				cat_id:$(".edit-form select[name=cat_id]").val(),
				name:$(".edit-form input[name=subcat_name]").val(),
				slug:$(".edit-form input[name=subcat_slug]").val()
			},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				if (data.result == true) {
					setModal("New category inserted", true);
					$(".edit-form #category-list select").html("<option value=\"\">** NOT SPECIFIED **</option>"+data.newSelectOptionList);
				} else {
					setModal("Error on saving data.<p>If it still occurs after retrying, please report to the website administration.",
							 false);
				}
				$('#AjaxResultModal').modal();
			},
			error: function() {
				setModal("Server error on saving data.<p>Please report to the website administrator.", false);
				$('#AjaxResultModal').modal();
			}
		});
	});
	/******************** Control category list *********************/

	
	/******************** Control Selling price list *********************/
	$("#selling-price-list .add-sellingprice-panel").hide();
	$('#selling-price-list button#add-supplier').on("click",function(){
		$(this).hide();
		$('#selling-price-list .add-sellingprice-panel').show();
	});
	function load_SellingPriceTable(){
		$.ajax({
			url: "../api/get-price-table",
			type: "POST",
			data: {
				product_id:$(".edit-form input[name=product_id]").val()
			},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				
				if (data.length > 0){
					$("#selling-price-list table tbody").html('');
					t_header = '<tr>';
					t_header2 = '<tr>';
					$.each(data[0],function(key,value){
						colspan=0;
						for(var i in value) {
						    if (value.hasOwnProperty(i)) {
						        colspan++;
								t_header2 += '<th>'+i+'</th>';
						    }
						}
						t_header += '<th colspan="'+colspan+'">'+
									key+'</th>';
					});
					t_header += '<td rowspan="2">動作</tr>';
					t_header2 += '</tr>';
					$("#selling-price-list table tbody").append(t_header);
					$("#selling-price-list table tbody").append(t_header2);
					
					$.each(data, function(key, index) {
						t_record = '<tr>';
						
						$.each(index, function(key, value) {
							$.each(value, function(key, value) {
								t_record += '<td contenteditable>'+value+'</td>';
							});
						});
						t_record += '<td><button class="btn btn-default glyphicon glyphicon-pencil btn-edit-price"></span></button></td>';
						t_record += '</tr>';
						$("#selling-price-list table tbody").append(t_record);
						
					});
					
					$("#selling-price-list button.btn-edit-price").on('click',function(e){
						e.preventDefault();
						$("#EditSellingPriceForm").modal();
						$("#EditSellingPriceForm input[name=supply_id]").val($(this).closest('tr').children("td:nth-child(1)").text());
						$("#EditSellingPriceForm select[name=vendor_id]").val($(this).closest('tr').children("td:nth-child(2)").text());
						$("#EditSellingPriceForm input[name=quotation_date]").val($(this).closest('tr').children("td:nth-child(4)").text());
						$("#EditSellingPriceForm input[name=currency][value="+$(this).closest('tr').children("td:nth-child(5)").text()+"]").prop('checked', true);
						$("#EditSellingPriceForm input[name=cost]").val($(this).closest('tr').children("td:nth-child(6)").text());
						$("#EditSellingPriceForm input[name=price_id]").val($(this).closest('tr').children("td:nth-child(8)").text());
						$("#EditSellingPriceForm input[name=markup]").val(
								$(this).closest('tr').children("td:nth-child(9)").text().replace(/[^0-9.]/g,'')
								);
						if ($(this).closest('tr').children("td:nth-child(9)").text().match(/^\$/)){
							$("#EditSellingPriceForm input[name=markup_type][value=A]").prop('checked',true);
						} else if ($(this).closest('tr').children("td:nth-child(9)").text().match(/\%$/)){
							$("#EditSellingPriceForm input[name=markup_type][value=P]").prop('checked',true);
						}
						$("#EditSellingPriceForm input[name=effective_date]").val($(this).closest('tr').children("td:nth-child(10)").text());
						$("#EditSellingPriceForm input[name=end_date]").val($(this).closest('tr').children("td:nth-child(11)").text());
					});
				} else {
					$("#selling-price-list .add-sellingprice-panel").show();
				}
			},
			error: function() {
				console.log( "ERROR ON LOADING PRICE TABLE" );
			}
		});
	}
	load_SellingPriceTable();
	
	$("#EditSellingPriceForm button.submit").on('click',function(e){
		currentBtn = $(this);
		e.preventDefault();
		currentBtn.prop("disabled",true);
		$('#EditSellingPriceForm').modal('hide');
		$.ajax({
			url: "../api/update-price",
			type: "POST",
			data: {
				product_id:$(".edit-form input[name=product_id]").val(),
				supply_id:$("#EditSellingPriceForm input[name=supply_id]").val(),
				vendor_id:$("#EditSellingPriceForm select[name=vendor_id]").val(),
				price_id:$("#EditSellingPriceForm input[name=price_id]").val(),
				currency:$("#EditSellingPriceForm input[name=currency]").val(),
				cost:$("#EditSellingPriceForm input[name=cost]").val(),
				markup:$("#EditSellingPriceForm input[name=markup]").val(),
				markup_type:$("#EditSellingPriceForm input[name=markup_type]:checked").val(),
				quotation_date:$("#EditSellingPriceForm input[name=quotation_date]").val(),
				effective_date:$("#EditSellingPriceForm input[name=effective_date]").val(),
				end_date:$("#EditSellingPriceForm input[name=end_date]").val()
			},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				if (data.result == true) {
					setModal("Updated price", true);
					$("#selling-price-list table tbody").html('');
					load_SellingPriceTable();
					$('#selling-price-list button#add-supplier').show();
				} else {
					setModal("Error on saving data.<p>If it still occurs after retrying, please report to the website administration.",
							 false);
				}
				$('#AjaxResultModal').modal();
				currentBtn.prop("disabled",false);
			},
			error: function() {
				setModal("Server error on saving data.<p>Please report to the website administrator.", false);
				$('#AjaxResultModal').modal();
			}
		});
	});
		
	$(".edit-form .add-sellingprice-panel input[type=submit]").on('click',function(e){
		e.preventDefault();
		$.ajax({
			url: "../api/append-supply",
			type: "POST",
			data: {
				product_id:$(".edit-form input[name=product_id]").val(),
				vendor_id:$(".edit-form  .add-sellingprice-panel select[name=newprice_vendor]").val(),
				currency:$(".edit-form  .add-sellingprice-panel input[name=currency]").val(),
				cost:$(".edit-form  .add-sellingprice-panel input[name=cost]").val()
			},
			dataType: "json",
			success: function(response, status, xhr) {
				var data = $.parseJSON(xhr.responseText);
				if (data.result == true) {
					setModal("New supplier inserted", true);
					load_SellingPriceTable();
					$('#selling-price-list button#add-supplier').show();
				} else {
					setModal("Error on saving data.<p>If it still occurs after retrying, please report to the website administration.",
							 false);
				}
				$('#AjaxResultModal').modal();
			},
			error: function() {
				setModal("Server error on saving data.<p>Please report to the website administrator.", false);
				$('#AjaxResultModal').modal();
			}
		});
	});
	/********************* /Control Selling price list **********************/
		    
});
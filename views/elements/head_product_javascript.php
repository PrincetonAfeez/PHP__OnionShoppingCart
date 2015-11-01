<script>
$(document).ready(function(){
	$(".product-details form .cart-control.option .choice .button").on("click",function(e){
		e.preventDefault();
		$(".product-details form .cart-control.option .choice .button").removeClass("checked");
		$(this).addClass("checked");
	});


	$(".product-details form .cart-control.quantity .glyphicon-minus-sign").on("click",function(e){
		e.preventDefault();
		currentVal = eval($(".product-details form .cart-control.quantity input[name=qty]").val());
		if (currentVal>1){
			$(".product-details form .cart-control.quantity input[name=qty]").val(currentVal - 1);
		}
	});


	$(".product-details form .cart-control.quantity .glyphicon-plus-sign").on("click",function(e){
		e.preventDefault();
		currentVal = eval($(".product-details form .cart-control.quantity input[name=qty]").val());
		$(".product-details form .cart-control.quantity input[name=qty]").val(currentVal + 1);
	});

	
	$("#information-tabs .nav.nav-tabs a").on("click",function(e){
		target = $(this).attr("for")

		$(this).parent().parent().find("li").removeClass('active');	
		$(this).parent().addClass('active');
			
		$(".information .tab-content li").removeClass('active');		
		$(".information .tab-content #"+target).addClass('active');
	});

	
});
</script>
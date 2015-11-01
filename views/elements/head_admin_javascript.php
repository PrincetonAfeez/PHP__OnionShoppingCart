
		<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
		<script src="<?= document_root();?>/asset/scripts/editproduct.js"></script>
		<script src="<?= document_root();?>/asset/scripts/editvendor.js"></script>
		
		<script>
		tinymce.init({
			selector:'#tinymce-textarea',
			plugins: "code autoresize",
			autoresize_min_height: 100,
			autoresize_bottom_margin: 0
		});
			
		$(function(){
		    $('#product-status').bootstrapToggle({
		      on: 'Enabled',
		      off: 'Disabled'
		    });
		});
		</script>
		

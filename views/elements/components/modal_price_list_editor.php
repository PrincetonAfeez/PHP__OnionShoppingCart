<div class="modal fade" id="EditSellingPriceForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<form method="post" action="update-price">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="AjaxResultModalLabel"><span class="resultIcon glyphicon"></span> Edit selling price</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" name="supply_id" />
					<input type="hidden" name="price_id" />
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-3">供應商</span>
						<select name="vendor_id" class="form-control">
							<option value="">Please select</option>
							<?php
							foreach ($model['vendorManager']->getVendorList() as $row) {
								echo '<option value="'.$row['vendor_id'].'">'.$row['name'].'</option>';
							}
							?>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-3">收取報價日期</span>
						<input type="date" name="quotation_date" class="form-control" />
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon3">來貨價</span>
						<span class="input-group-addon">
		                  <input type="radio" name="currency" value="AUD" />AUD
		                  <input type="radio" name="currency" value="HKD" />HKD
		                </span>
						<input type="text" name="cost" class="form-control" />
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-3">利潤加副</span>
						<span class="input-group-addon">
		                  <input type="radio" name="markup_type" value="P" />%
		                  <input type="radio" name="markup_type" value="A" />$
		                </span>
						<input type="text" name="markup" class="form-control" />
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-3">價格生效日期</span>
						<input type="date" name="effective_date" class="form-control" />
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon-3">價格結束日期</span>
						<input type="date" name="end_date" class="form-control" />
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-primary submit">Update</button>
				</div>
			</div>
		</div>
	</form>
</div>
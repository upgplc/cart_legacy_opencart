<form id="securehostingcheckout" action="<?php echo $action; ?>" method="post">
	<input type="hidden" name="filename" value="<?php echo $securehosting_shreference.'/'.$securehosting_filename ?>" />
	<input type="hidden" name="shreference" value="<?php echo $securehosting_shreference ?>" />
	<input type="hidden" name="checkcode" value="<?php echo $securehosting_checkcode ?>" />
	<input type="hidden" name="transactionamount" value="<?php echo $transactionamount; ?>" />
	<input type="hidden" name="transactioncurrency" value="<?php echo $transactioncurrency; ?>" />
	<input type="hidden" name="transactiontax" value="<?php echo $transactiontax; ?>" />
	<input type="hidden" name="shippingcharge" value="<?php echo $shippingcharge; ?>" />
	<input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>" />
	<input type="hidden" name="cardholdersname" value="<?php echo $cardholdersname; ?>" />
	<input type="hidden" name="cardholdersemail" value="<?php echo $cardholdersemail; ?>" />
	<input type="hidden" name="cardholdertelephonenumber" value="<?php echo $cardholdertelephonenumber; ?>" />
	<input type="hidden" name="cardholderaddr1" value="<?php echo $cardholderaddr1; ?>" />
	<input type="hidden" name="cardholderaddr2" value="<?php echo $cardholderaddr2; ?>" />
	<input type="hidden" name="cardholdercity" value="<?php echo $cardholdercity; ?>" />
	<input type="hidden" name="cardholderstate" value="<?php echo $cardholderstate; ?>" />
	<input type="hidden" name="cardholderpostcode" value="<?php echo $cardholderpostcode; ?>" />
	<input type="hidden" name="cardholdercountry" value="<?php echo $cardholdercountry; ?>" />
	<input type="hidden" name="deliveryname" value="<?php echo $deliveryname; ?>" />
	<input type="hidden" name="deliveryaddr1" value="<?php echo $deliveryaddr1; ?>" />
	<input type="hidden" name="deliveryaddr2" value="<?php echo $deliveryaddr2; ?>" />
	<input type="hidden" name="deliverycity" value="<?php echo $deliverycity; ?>" />
	<input type="hidden" name="deliverystate" value="<?php echo $deliverystate; ?>" />
	<input type="hidden" name="deliverypostcode" value="<?php echo $deliverypostcode; ?>" />
	<input type="hidden" name="deliverycountry" value="<?php echo $deliverycountry; ?>" />
	<input type="hidden" name="secuitems" value="<?php echo $secuitems; ?>" />
	<input type="hidden" name="success_url" value="<?php echo $success_url; ?>" />
	<input type="hidden" name="cancel_url" value="<?php echo $cancel_url; ?>" />
	<input type="hidden" name="callbackurl" value="<?php echo $callbackurl; ?>" />
	<input type="hidden" name="callbackdata" value="<?php echo $callbackdata; ?>" />
	<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />

</form>  
<div class="buttons">
	<div class="pull-right">
		<input type="button" onclick="confirmSubmit();" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
	</div>
</div>
<script type="text/javascript">
	function confirmSubmit() {
		$('#securehostingcheckout').submit();
	}
</script>

<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="button_blue button_set" data-loading-text="<?php echo $text_loading; ?>" onclick="PAYPAL.apps.PPP.doCheckout();" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=payment/pp_plus/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function() {
			PAYPAL.apps.PPP.doCheckout();
		}
	});
});
//--></script>

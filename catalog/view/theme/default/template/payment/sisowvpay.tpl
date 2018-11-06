<h2><?php echo $text_header; ?></h2>
<div id="payment">
  <img src="catalog/view/theme/default/image/sisow/sisow-vpay.png" title="V PAY" alt="V PAY" />
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({ 
		type: 'post',
		url: 'index.php?route=payment/sisowvpay/redirectbank',
		data: $('#payment :input'),
		dataType: 'json',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function(json) {
			if (json['error']) {
				alert(json['error']);
			}

			if (json['redirect']) {
				location = json['redirect'];
			}
		}
	});
});
//--></script>
<h2><?php echo $text_header; ?></h2>
<div id="payment">
  <img src="catalog/view/theme/default/image/sisow/sisow-klarna-paynow.png" title="Klarna Sofort (voorheen SofortBanking)" alt="Klarna Sofort" /><img src="catalog/view/theme/default/image/sisow/sisow-sofort.png" title="Klarna Sofort (voorheen SofortBanking)" alt="Klarna Sofort" />
  <p><?php echo $text_readmore; ?></p>
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
		url: 'index.php?route=payment/sisowde/redirectbank',
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
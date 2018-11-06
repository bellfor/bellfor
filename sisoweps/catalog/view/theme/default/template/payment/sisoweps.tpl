<h2><?php echo $text_header; ?></h2>
<link rel="stylesheet" href="https://bankauswahl.giropay.de/widget/v2/style.css" />
<script src="https://bankauswahl.giropay.de/widget/v2/girocheckoutwidget.js"></script>
<form id="payment" class="form-horizontal">
  <div><img src="catalog/view/theme/default/image/sisow/sisow-eps.png" title="EPS" alt="EPS" /></div>
  <div><br><?php echo $text_readmore; ?><div>
   <fieldset>
    <legend></legend>
	<div class="form-group required">
	  <label class="col-sm-2 control-label" for="bic_eps"><?php echo $text_bankcode; ?></label>
	  <div class="col-sm-4">
		<input type="text" id="bic_eps" name="bic_eps" class="form-control" value="" onkeyup="girocheckout_widget(this, event, 'bic', '3')">
	  </div>
	</div>
  <fieldset>
</form>
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
		url: 'index.php?route=payment/sisoweps/redirectbank',
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
<h2><?php echo $text_header; ?></h2>
<img src="catalog/view/theme/default/image/sisow/sisow-ideal.png" title="iDEAL" alt="iDEAL" />
<form id="payment" class="form-horizontal">
  <fieldset>
    <legend><?php echo $text_description; ?></legend>
	<div class="form-group required">
	  <label class="col-sm-2 control-label" for="sisowbank"><?php echo $text_bank; ?></label>
		<div class="col-sm-6">
		<select name="sisowbank" id="sisowbank" class="form-control">
		  <option value=""><?php echo $text_select; ?>...</option>
		  <?php foreach ($banks as $bankid => $bankname) { ?>
    	  <option value="<?php echo $bankid; ?>"><?php echo $bankname; ?></option>
		  <?php } ?>
	    </select>
		</div>
	</div>
  <fieldset>
</form>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=payment/sisowideal/redirectbank',
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
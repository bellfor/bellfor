<fieldset class="stripe">
	<legend><?php echo $text_credit_card; ?></legend>

	<div class="form-group">
		<label class="control-label" for="input-cc-type"><?php echo $entry_cc_type ?></label>
		<select name="cc_type" class="form-control">
			<?php foreach ($cards as $card) { ?>
				<option value="<?php echo $card['value']; ?>"><?php echo $card['text']; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="form-group">
		<label class="control-label" <?php if (!$journal_mode) echo 'class="form-control"'; ?> for="input-cc-type"><?php echo $entry_cc_number; ?></label>
		<input type="text" name="cc_number"  <?php if (!$journal_mode) echo 'class="form-control"'; ?> value="" id="input-cc-type" />
	</div>

	<div class="form-group">
		<label class="control-label" for="input-cc-type"><?php echo $entry_cc_expire_date; ?></label>
		<select name="cc_expire_date_month" class="form-control" style="width:20%;display:inline-block">
			<?php foreach ($months as $month) { ?>
				<option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
			<?php } ?>
		</select>
		/
		<select name="cc_expire_date_year" class="form-control" style="width:20%;display:inline-block">
			<?php foreach ($year_expire as $year) { ?>
				<option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
			<?php } ?>
		</select>
	</div>

	<div class="form-group">
		<label class="control-label" for="input-cc-type"><?php echo $entry_cc_cvv2; ?></label>
		<input type="text" name="cc_cvv2" value="" size="3" />
	</div>

	<div class="buttons">
		<div class="pull-right">
			<input type="button" value="<?php echo $button_confirm; ?>" id="stripe-confirm" class="btn btn-primary" />
		</div>
	</div>

</fieldset>


<script type="text/javascript">
	if (typeof window.stripe_loaded=='undefined') {
		//poorly behaving templates can load twice, keep this from happening
		window.stripe_loaded = true;

		$('#stripe-confirm').on('click', function (e) {
		   if (typeof runStripe!=='undefined') {
			   e.preventDefault();
			   runStripe();
		   }
		});
		
		$('body').append('<script type="text/javascript" src="https://js.stripe.com/v2/"></scr'+'ipt>');


<?php if ($journal_mode) { ?>
		<?php //*** for Journal mode  ?>
		var softAlert=function (msg, $element) {
			$('#stripe-error').remove();
			$('fieldset.stripe legend').after('<div class="text-danger" id="stripe-error"> ' + msg + '</div>');
			$('#stripe-confirm').attr('disabled', false).attr('value', '<?php echo addslashes($button_confirm) ?>');
			if ($element) $element.closest('.form-group').addClass('has-error');
			triggerLoadingOff();
		}

<?php } else { ?>
		<?php //*** Regular mode ?>
		var stripeJournal=function () {};

		var softAlert=function (msg, $element) {
			$('#stripe-error').remove();
			$('fieldset.stripe legend').after('<div class="alert alert-danger" id="stripe-error"> ' + msg + '</div>');
			$('#stripe-confirm').attr('disabled', false).attr('value', '<?php echo addslashes($button_confirm) ?>');
		}
<?php } ?>

	}

    var runStripe=function () {
	    var hideErr = function () {
		    $('#stripe-error').slideUp('fast', function () {
			    $(this).remove()
		    });
	    }
	    $('input[type=text],select').bind('click change', hideErr);

	    if (Stripe.card.validateCardNumber($('input[name=cc_number]').val()) == false) {
		    softAlert("<?php echo $text_valid_cc ?>",$('input[name=cc_number]'));
		    return false;
	    } else if (Stripe.card.validateCVC($('input[name=cc_cvv2]').val()) == false) {
		    softAlert("<?php echo $text_valid_cvc ?>",$('input[name=cc_cvv2]'));
		    return false;
	    } else {
		    stripeResponseHandler = function stripeResponseHandler(status, response) {
			    if (response.error) {
				    $(".payment-errors").text(response.error.message);
				    softAlert(response.error.message, false);
			    } else {
				    var token = response['id'];

				    $.ajax({
					    url: 'index.php?route=payment/stripe/send',
					    type: 'post',
					    data: {token: token},
					    dataType: 'json',
					    beforeSend: function () {
						    $('#stripe-error').remove();
						    $('#stripe-confirm').attr('disabled', true).attr('value', '<?php echo addslashes($text_please_wait) ?>');
						    $('#payment').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
					    },
					    complete: function () {
						    $('.attention').remove();
					    },
					    success: function (json) {
						    if (json['error']) {
							    softAlert(json['error'], false);
						    }

						    if (json['success']) {
							    location = json['success'];
						    }
					    },
					    error: function (data) {
						    console.log('STRIPE MODULE: There was a problem with the response received from route=payment/stripe/send. Check the response in the network tab to make sure valid JSON is being returned.');
						    softAlert('<?php echo addslashes($text_ajax_error) ?>', false);
					    }
				    });

			    }
		    }


		    Stripe.setPublishableKey('<?php echo $publishable_key ?>');
		    Stripe.card.createToken({
			    number: $('input[name=cc_number]').val(),
			    cvc: $('input[name=cc_cvv2]').val(),
			    exp_month: $('select[name=cc_expire_date_month]').val(),
			    exp_year: $('select[name=cc_expire_date_year]').val(),
			    name: '<?php echo addslashes($order_info['firstname'].' '.$order_info['lastname']) ?>',
			    address_line1: '<?php echo addslashes($order_info['payment_address_1']) ?>',
			    address_line2: '<?php echo addslashes($order_info['payment_address_2']) ?>',
			    address_city: '<?php echo addslashes($order_info['payment_city']) ?>',
			    address_state: '<?php echo addslashes($order_info['payment_zone_code']) ?>',
			    address_zip: '<?php echo addslashes($order_info['payment_postcode']) ?>',
			    address_country: '<?php echo addslashes($order_info['payment_country']) ?>'
		    }, stripeResponseHandler);
	    }
    }

</script>



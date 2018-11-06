<?php echo $header; ?>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
			

  <div class="col-md-12 col-xs-12 right-container">
  <?php echo $content_top; ?>
	<div style="text-align:center;">
		<h3><?php echo $heading_payment; ?></h3>
		<?php if(isset($amazon_login_pay_test)){ ?>
		<label>Debug Error Code     :</label>
		<div id="errorCode"></div>
		<br>
		<label>Debug Error Message  :</label>
		<div id="errorMessage"></div>
		<?php } ?>
		<div style="margin: 0 auto; width: 400px; height: 228px;" id="walletWidgetDiv">
		</div>
		<div style="clear: both;"></div>
        <div class="buttons">
 		<div class="pull-left">
			<a href="<?php echo $back; ?>" class="button_blue button_set">
			<span class="button-outer"><span class="button-inner">
			<?php echo $text_back; ?>
			</span></span>
			</a>
		</div>
		<div class="pull-right">
			<input class="button_blue button_set button_set__fix" id="continue-button" type="submit" value="<?php echo $text_continue; ?>" />
		</div>	
        </div>
        <input type="hidden" name="payment_method" value="" />
		<?php echo $content_bottom; ?>
	</div>
</div>

          </div>
          </div>
        </div>
    </div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		amazon.Login.setClientId('<?php echo $amazon_login_pay_client_id ?>');

		$('#continue-button').click(function() {
			$('div.warning').remove();

			if ($("input[name='payment_method']").val() == '1') {
				location = '<?php echo $continue ?>';
			} else {
				$('#walletWidgetDiv').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i><?php echo $error_payment_method ?></div>');
			}
		});

		new OffAmazonPayments.Widgets.Wallet({
			sellerId: '<?php echo $amazon_login_pay_merchant_id; ?>',
			onPaymentSelect: function(orderReference) {
				$("input[name='payment_method']").val('1');
			},
			design: {
				designMode: 'responsive'
			},
			onError: function(error) {
				document.getElementById("errorCode").innerHTML = error.getErrorCode();
				document.getElementById("errorMessage").innerHTML = error.getErrorMessage();
			}
		}).bind("walletWidgetDiv");
	});
	//--></script>
<?php echo $footer; ?>
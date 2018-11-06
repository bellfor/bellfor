<div id="amazon-root"></div>
<script type="text/javascript">
	$(document).ready(function() {
		amazon.Login.setClientId('<?php echo $amazon_login_pay_client_id; ?>');
		(function(d) {
			var a = d.createElement('script');
			a.type = 'text/javascript';
			a.async = true;
			a.id = 'amazon-login-sdk';
			a.src = 'https://api-cdn.amazon.com/sdk/login1.js';
			d.getElementById('amazon-root').appendChild(a);
		})(document);
	});
</script>

<div id="AmazonPayButton"></div>
<script type="text/javascript">
	$(document).ready(function() {
		var authRequest;
		OffAmazonPayments.Button("AmazonPayButton", "<?php echo $amazon_login_pay_client_id; ?>", {
			type: "<?php echo $amazon_pay_button_type; ?>",
			color: "<?php echo $amazon_pay_button_colour; ?>",
			size: "<?php echo $amazon_pay_button_size; ?>",
			authorization: function() {
				var loginOptions = {scope: 'profile postal_code payments:widget payments:shipping_address'};
				authRequest = amazon.Login.authorize(loginOptions, "<?php echo $amazon_pay_return_url; ?>");
			},
			onError: function(error) {
				document.getElementById("errorCode").innerHTML = error.getErrorCode();
				document.getElementById("errorMessage").innerHTML = error.getErrorMessage();
			}
		});
    setTimeout(function () {
      var button = $('#AmazonPayButton img');
      var attr = button.attr('src');
      attr = attr.replace('en_gb','de_de');
      button.attr('src', attr);
    },500);		
	});
</script>
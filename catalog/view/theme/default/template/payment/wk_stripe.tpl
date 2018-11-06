<?php if (!$testmode) { ?>
<div class="alert alert-warning"><?php echo $text_testmode; ?></div>
<?php } ?>
<form method="post" id="form">
<script src="https://checkout.stripe.com/checkout.js"></script>
<script>
function stripeHandler(){
    $('#paymentbtn').attr('disabled', true);
    // Open Checkout with further options
    StripeCheckout.open({
        key: "<?php echo $stripe_keys['publishable_key']; ?>",
        image: '<?php echo $stripe_image; ?>',
        name:"<?php echo $popup_title; ?>",
        description:"<?php echo $popup_description; ?>",
        panelLabel: '<?php echo $popup_btn_text; ?>',
        email:'<?php echo $enable_email; ?>',
        amount:<?php echo $cart_amount; ?>,
        currency:'<?php echo strtolower($cart_currency); ?>',
        <?php if($enable_billing){ ?>
        billingAddress:true,
        <?php } ?>
        <?php if($enable_shipping){ ?>
        shippingAddress:true,
        <?php } ?>
        <?php if(!$remember_me){ ?>
        allowRememberMe:false,
        <?php } ?>
        // zipCode:<?php echo $enable_zip; ?>,      
        token: function(token,args) {          
          // Use the token to create the charge with a server-side script.
            sendDetails(token,args);
        }
    });  
}

function sendDetails(token,args){
    $.ajax({
          url: '<?php echo $action; ?>',
          type: 'POST',          
          data: { tokenData : token , argsData : args } ,
          dataType: 'json',
          beforeSend: function() {
              $('.success, .warning').remove();
              $('.buttons').before('<div class="warning"><img src="catalog/view/theme/default/image/loading.gif" alt="" style="width:20px;height:20px;" /> <?php echo $text_wait; ?></div>');
          },
          complete: function() {
              $('.warning').remove();
          },
          success: function(data) {
                       
              if (data['success']) {
                $('.buttons').before('<div class="success">'+data['success']+'</div>');
                location = data['continue'];
              }

              if (data['error']) {                  
                $('#paymentbtn').attr('disabled', false);
                alert(data['error']);
              }
          }
      });
}
</script>
<div class="buttons">
	<div class="pull-right">
	  <input type="button" value="<?php echo $button_confirm; ?>" onclick="stripeHandler();" id="paymentbtn" class="btn btn-primary" />
	</div>
</div> 
</form>
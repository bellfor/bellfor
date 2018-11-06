<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<?php foreach ($payment_methods as $payment_method) { ?>
<div class="wrap_radio_payment">
  <div class="radio">
   
      <?php if ($payment_method['code'] == $code || !$code) { ?>
      <?php $code = $payment_method['code']; ?>
      <!-- <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" /> -->
      <input id="payment_method<?php echo $payment_method['code']; ?>" type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked">
      <?php } else { ?>
      <!-- <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" /> -->
      <input id="payment_method<?php echo $payment_method['code']; ?>" type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked">
      <?php } ?>
      <label for="payment_method<?php echo $payment_method['code']; ?>">
      <?php echo $payment_method['title']; ?>
      <?php if ($payment_method['terms']) { ?>
      (<?php echo $payment_method['terms']; ?>)
      <?php } ?></label>

  </div>
</div>
<?php } ?>
<?php } ?>
<p><strong><?php echo $text_comments; ?></strong></p>
<p>
  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right fix_checkbox_button">
    <div class="checkbox_wraper">
      <p><?php echo $text_agree; ?></p>
      <div class="checkbox_belf">
        <?php if ($agree) { ?>
        <input type="checkbox" value="1" name="agree" id="shipping_" checked="checked"/>
        <?php } else { ?>
        <input type="checkbox" value="1" name="agree" id="shipping_" />
        <?php } ?>
        <label for="shipping_"></label> 
      </div> 
    </div>
    <button id="button-payment-method" data-loading-text="<span class='button-outer'><span class='button-inner'><?php echo $text_loading; ?></span></span>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_continue; ?></span></span></button>
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right">
    <button id="button-payment-method" data-loading-text="<span class='button-outer'><span class='button-inner'><?php echo $text_loading; ?></span></span>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_continue; ?></span></span></button>
  </div>
</div>
<?php } ?>

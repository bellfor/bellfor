<div class="row">
  <div class="col-sm-6">
    <h2><?php echo $text_new_customer; ?></h2>
    <p><?php echo $text_checkout; ?></p>
    <div class="wrap_radio_checkout">
      <div class="radio">
        
          <?php if ($account == 'register') { ?>
          <input id="male" type="radio" name="account" value="register" checked="checked">
          <label for="male"><?php echo $text_register; ?></label><br />
          <?php } else { ?>
          <input id="female" type="radio" name="account" value="register">
          <label for="female"><?php echo $text_register; ?></label>
          <?php } ?>
               
      <?php if ($checkout_guest) { ?>
            
          <?php if ($account == 'guest') { ?>
          <input id="male" type="radio" name="account" value="guest" checked="checked">
          <label for="male"><?php echo $text_guest; ?></label><br />
          <?php } else { ?>
          <input id="female" type="radio" name="account" value="guest">
          <label for="female"><?php echo $text_guest; ?></label>
          <?php } ?>
               
      <?php } ?>
      </div>
    </div>
    <p><?php echo $text_register_account; ?></p>

    <button id="button-account" data-loading-text="<span class='button-outer'><span class='button-inner'><?php echo $text_loading; ?></span></span>" class="button_blue button_set"><span class='button-outer'><span class='button-inner'><?php echo $button_continue; ?></span></span></button>

  </div>
  <div class="col-sm-6">
    <h2><?php echo $text_returning_customer; ?></h2>
    <p><?php echo $text_i_am_returning_customer; ?></p>
    <div class="form-group">
      <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
      <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
    </div>
    <div class="form-group">
      <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
      <input type="password" name="password" value="" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control margin_for_password_link" />
      <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></div>


    <button id="button-login" data-loading-text="<span class='button-outer'><span class='button-inner'><?php echo $text_loading; ?></span></span>" class="button_blue button_set"><span class='button-outer'><span class='button-inner'><?php echo $button_login; ?></span></span></button>
  </div>
</div>
<?php echo $header; ?>
                        <div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation" >
						    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                            <?php } ?>
                        </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
			
			
    <div class="col-md-9 col-md-push-3 col-xs-12 right-container">
<?php echo $content_top; ?>
      <h1 class="account_head_text"><?php echo $heading_title; ?></h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_newsletter; ?></label>
            <div class="col-sm-10">
              <?php if ($newsletter) { ?>

              <div class="wrap_radio_accaunt">
                <div class="radio">
                  <input id="newsletter_1" type="radio" name="newsletter" value="1" checked="checked">
                  <label for="newsletter_1"><?php echo $text_yes; ?></label> 
                </div>
              </div>
              <div class="wrap_radio_accaunt">
                <div class="radio">
                  <input id="newsletter_2" type="radio" name="newsletter" value="0" >
                  <label for="newsletter_2"><?php echo $text_no; ?></label> 
                </div>
              </div>

              <!-- <label class="radio-inline">
                <input type="radio" name="newsletter" value="1" checked="checked" />
                <?php echo $text_yes; ?> 
              </label> -->
            
              <!-- <label class="radio-inline">
                <input type="radio" name="newsletter" value="0" />
                <?php echo $text_no; ?></label> -->
              <?php } else { ?>
              <!-- <label class="radio-inline">
                <input type="radio" name="newsletter" value="1" />
                <?php echo $text_yes; ?> </label>
              <label class="radio-inline">
                <input type="radio" name="newsletter" value="0" checked="checked" />
                <?php echo $text_no; ?></label> -->
              <div class="wrap_radio_accaunt">
                <div class="radio">
                  <input id="newsletter_1" type="radio" name="newsletter" value="0" >
                  <label for="newsletter_1"><?php echo $text_yes; ?></label> 
                </div>
              </div>
              <div class="wrap_radio_accaunt">
                <div class="radio">
                  <input id="newsletter_2" type="radio" name="newsletter" value="1" checked="checked">
                  <label for="newsletter_2"><?php echo $text_no; ?></label> 
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <div class="buttons fix_buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_back; ?></span></span></a></div>
          <div class="pull-right">
            <button type="submit" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_continue; ?></span></span></button>
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<?php echo $footer; ?> 
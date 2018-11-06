        <?php echo $header; ?>
        <div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation">
          <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="main-container">
      <div class="row">


        <div class="col-md-9 col-md-push-3 col-xs-12 right-container">
          <?php if ($error_warning) { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
          <?php } ?>
          <?php echo $content_top; ?>
          <h1><?php echo $heading_title; ?></h1>
          <p><?php echo $text_email; ?></p>
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>
              <legend><?php echo $text_your_email; ?></legend>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                <div class="col-sm-10">
                  <input type="email" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email"
                         class="form-control"/>
                </div>
              </div>
            </fieldset>
            <div class="buttons clearfix">
              <div class="log_out_button">

                <a href="<?php echo $back; ?>" class="button_blue button_set">
                  <span class="button-outer">
                    <span class="button-inner"><?php echo $button_back; ?></span>
                  </span>
                </a>
              </div>
              <div class="pull-right">
                <button type="submit" class="button_blue button_set">
                  <span class="button-outer">
                    <span class="button-inner"><?php echo $button_continue; ?></span>
                  </span>
                </button>
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
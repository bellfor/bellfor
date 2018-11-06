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
      <h1><?php echo $heading_title; ?></h1>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_password; ?></legend>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-password"><?php echo $entry_password; ?></label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control" />
              <?php if ($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
            <div class="col-sm-10">
              <input type="password" name="confirm" value="<?php echo $confirm; ?>" id="input-confirm" class="form-control" />
              <?php if ($error_confirm) { ?>
              <div class="text-danger"><?php echo $error_confirm; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right"><button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $button_continue; ?></button></div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<?php echo $footer; ?> 
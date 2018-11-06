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
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
<?php echo $content_top; ?>
      <h2 class="account_head_text"><?php echo $text_address_book; ?></h2>
      <?php if ($addresses) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <?php foreach ($addresses as $result) { ?>
          <tr>
            <td class="text-left"><?php echo $result['address']; ?></td>
            <td class="text-right"><a href="<?php echo $result['update']; ?>" class="btn btn-info"><?php echo $button_edit; ?></a> &nbsp; <a href="<?php echo $result['delete']; ?>" class="btn btn-danger"><?php echo $button_delete; ?></a></td>
          </tr>
          <?php } ?>
        </table>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons fix_buttons clearfix">
        <div class="pull-left"><a href="<?php echo $back; ?>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_back; ?></span></span></a></div>
        <div class="pull-right"><a href="<?php echo $add; ?>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_new_address; ?></span></span></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<?php echo $footer; ?> 
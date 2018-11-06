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
      <p><?php echo $text_total; ?> <b><?php echo $total; ?></b>.</p>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td class="text-left"><?php echo $column_description; ?></td>
              <td class="text-right"><?php echo $column_amount; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($transactions) { ?>
            <?php foreach ($transactions  as $transaction) { ?>
            <tr>
              <td class="text-left"><?php echo $transaction['date_added']; ?></td>
              <td class="text-left"><?php echo $transaction['description']; ?></td>
              <td class="text-right"><?php echo $transaction['amount']; ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="text-center" colspan="5"><?php echo $text_empty; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><p><?php echo $pagination; ?></p></div>
        <div class="col-sm-6 text-right"><p><?php echo $results; ?></p></div>
      </div>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_continue; ?></span></span></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<?php echo $footer; ?> 
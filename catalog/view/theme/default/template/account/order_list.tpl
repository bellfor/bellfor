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
      <?php if ($orders) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-right"><?php echo $column_order_id; ?></td>
              <td class="text-left"><?php echo $column_customer; ?></td>
              <td class="text-right"><?php echo $column_product; ?></td>
              <td class="text-left"><?php echo $column_status; ?></td>
              <td class="text-right"><?php echo $column_total; ?></td>
              <td class="text-left"><?php echo $column_date_added; ?></td>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td class="text-right">#<?php echo $order['order_id']; ?></td>
              <td class="text-left"><?php echo $order['name']; ?></td>
              <td class="text-right"><?php echo $order['products']; ?></td>
              <td class="text-left"><?php echo $order['status']; ?></td>
              <td class="text-right"><?php echo $order['total']; ?></td>
              <td class="text-left"><?php echo $order['date_added']; ?></td>
              <td class="text-right"><a href="<?php echo $order['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="button_blue button_set button_set_info"><i class="fa fa-eye"></i></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
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

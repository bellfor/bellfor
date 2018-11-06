<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-idealo-csv" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
    </div>
    <div class="panel-body">
      <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-idealo-csv" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-idealo-csv-language-id"><?php echo $entry_source_language; ?></label>
            <div class="col-sm-10">
		<select name="idealo_csv_language_id" id="idealo_csv_language_id" class="form-control">
			<?php foreach ($languages as $language) {
				echo '<option value="' . $language['language_id'] . '"' . ($language['language_id']==$idealo_csv_language_id?' selected="selected"':'') . '>' . $language['name'] . '</option>';
			}?>
		</select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-entry-category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
            <div class="col-sm-10">
              <div id="category" class="well well-sm" style="height: 150px; overflow: auto;">
                <div id="product_category">
		<?php foreach ($categories as $category) { ?>
                  <div class="checkbox">
                    <label>
			<div>
			<?php if (in_array($category['category_id'], $product_category)) { ?>
				<input type="checkbox" name="idealo_csv_product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
				<?php echo $category['name']; ?>
			<?php } else { ?>
				<input type="checkbox" name="idealo_csv_product_category[]" value="<?php echo $category['category_id']; ?>" />
				<?php echo $category['name']; ?>
			<?php } ?>
			</div>
                   </label>
                  </div>
		<?php } ?>
                </div>
              </div>
		<a onclick="$(this).parent().find(':checkbox').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
	  </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-location-zip"><?php echo $entry_location_zip; ?></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_location_zip" id="location_zip" value="<?php echo $idealo_csv_location_zip; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-delivery-time"><span data-toggle="tooltip" title="<?php echo $help_delivery_time; ?>"><?php echo $entry_delivery_time; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_delivery_time" id="delivery_time" value="<?php echo $idealo_csv_delivery_time; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-delivery-price-calc"><span data-toggle="tooltip" title="<?php echo $help_delivery_price_calc; ?>"><?php echo $entry_delivery_price_calc; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_delivery_price_calc" id="delivery_price_calc" value="<?php echo $idealo_csv_delivery_price_calc; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-delivery-weight-calc"><span data-toggle="tooltip" title="<?php echo $help_delivery_weight_calc; ?>"><?php echo $entry_delivery_weight_calc; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_delivery_weight_calc" id="delivery_weight_calc" value="<?php echo $idealo_csv_delivery_weight_calc; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-method"><span data-toggle="tooltip" title="<?php echo $help_payment_method; ?>"><?php echo $entry_payment_method; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_method" id="payment_method" value="<?php echo $idealo_csv_payment_method; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-cost"><span data-toggle="tooltip" title="<?php echo $help_payment_cost; ?>"><?php echo $entry_payment_cost; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_cost" id="payment_cost" value="<?php echo $idealo_csv_payment_cost; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-max"><span data-toggle="tooltip" title="<?php echo $help_payment_max; ?>"><?php echo $entry_payment_max; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_max" id="payment_max" value="<?php echo $idealo_csv_payment_max; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-free"><span data-toggle="tooltip" title="<?php echo $help_payment_free; ?>"><?php echo $entry_payment_free; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_free" id="payment_free" value="<?php echo $idealo_csv_payment_free; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-method-2"><span data-toggle="tooltip" title="<?php echo $help_payment_method_2; ?>"><?php echo $entry_payment_method_2; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_method_2" id="payment_method_2" value="<?php echo $idealo_csv_payment_method_2; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-cost-2"><span data-toggle="tooltip" title="<?php echo $help_payment_cost_2; ?>"><?php echo $entry_payment_cost_2; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_cost_2" id="payment_cost_2" value="<?php echo $idealo_csv_payment_cost_2; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-max-2"><span data-toggle="tooltip" title="<?php echo $help_payment_max_2; ?>"><?php echo $entry_payment_max_2; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_max_2" id="payment_max_2" value="<?php echo $idealo_csv_payment_max_2; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-free-2"><span data-toggle="tooltip" title="<?php echo $help_payment_free_2; ?>"><?php echo $entry_payment_free_2; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_free_2" id="payment_free_2" value="<?php echo $idealo_csv_payment_free_2; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-method-3"><span data-toggle="tooltip" title="<?php echo $help_payment_method_3; ?>"><?php echo $entry_payment_method_3; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_method_3" id="payment_method_3" value="<?php echo $idealo_csv_payment_method_3; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-cost-3"><span data-toggle="tooltip" title="<?php echo $help_payment_cost_3; ?>"><?php echo $entry_payment_cost_3; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_cost_3" id="payment_cost_3" value="<?php echo $idealo_csv_payment_cost_3; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-max-3"><span data-toggle="tooltip" title="<?php echo $help_payment_max_3; ?>"><?php echo $entry_payment_max_3; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_max_3" id="payment_max_3" value="<?php echo $idealo_csv_payment_max_3; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-free-3"><span data-toggle="tooltip" title="<?php echo $help_payment_free_3; ?>"><?php echo $entry_payment_free_3; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_free_3" id="payment_free_3" value="<?php echo $idealo_csv_payment_free_3; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-payment-methods"><span data-toggle="tooltip" title="<?php echo $help_payment_methods; ?>"><?php echo $entry_payment_methods; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_payment_methods" id="payment_methods" value="<?php echo $idealo_csv_payment_methods; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-minimum-sum"><span data-toggle="tooltip" title="<?php echo $help_order_minimum_sum; ?>"><?php echo $entry_order_minimum_sum; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_order_minimum_sum" id="order_minimum_sum" value="<?php echo $idealo_csv_order_minimum_sum; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-minimum-fee"><span data-toggle="tooltip" title="<?php echo $help_order_minimum_fee; ?>"><?php echo $entry_order_minimum_fee; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_order_minimum_fee" id="order_minimum_fee" value="<?php echo $idealo_csv_order_minimum_fee; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-minimum-comment"><span data-toggle="tooltip" title="<?php echo $help_order_minimum_comment; ?>"><?php echo $entry_order_minimum_comment; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_order_minimum_comment" id="order_minimum_comment" value="<?php echo $idealo_csv_order_minimum_comment; ?>" />
            </div>
          </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-entry-data-feed-seperator"><span data-toggle="tooltip" title="<?php echo $help_data_feed_seperator; ?>"><?php echo $entry_data_feed_seperator; ?></span></label>
            <div class="col-sm-10">
		<input type="text" name="idealo_csv_data_feed_seperator" id="data_feed_seperator" value="<?php echo $idealo_csv_data_feed_seperator; ?>" />
		<input type="text" name="idealo_csv_data_feed_seperator_2" id="data_feed_seperator_2" value="<?php echo $idealo_csv_data_feed_seperator_2; ?>" />
		<input type="text" name="idealo_csv_data_feed_seperator_3" id="data_feed_seperator_3" value="<?php echo $idealo_csv_data_feed_seperator; ?>" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="idealo_csv_status" id="input-status" class="form-control">
                <?php if ($idealo_csv_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-data-feed"><?php echo $entry_data_feed; ?></label>
            <div class="col-sm-10">
              <textarea rows="5" readonly="readonly" id="input-data-feed" class="form-control"><?php echo $data_feed; ?></textarea>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

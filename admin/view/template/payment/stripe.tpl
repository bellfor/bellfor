<?php echo $header; ?><?php echo $column_left; ?>
	<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-stripe" data-toggle="tooltip"
					   title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i>
				</button>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>"
				   class="btn btn-default"><i class="fa fa-reply"></i></a></div>
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>

	<div class="container-fluid">
		<?php if ($error_warning) { ?>
			<div class="alert alert-danger"><i
					 class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data"  class="form-horizontal" id="form-stripe">
					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-merchant-id"><?php echo $entry_test_secret_key; ?></label>

						<div class="col-sm-10">
							<input type="text" name="stripe_test_secret_key"
								  value="<?php echo $stripe_test_secret_key; ?>"
								  placeholder="<?php echo $entry_test_secret_key; ?>"
								  id="input-test-secret-key" class="form-control"/>
							<?php if ($error_test_secret_key) { ?>
								<div class="text-danger"><?php echo $error_test_secret_key; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-test-publishable-key"><?php echo $entry_test_publishable_key; ?></label>

						<div class="col-sm-10">
							<input type="text" name="stripe_test_publishable_key"
								  value="<?php echo $stripe_test_publishable_key; ?>"
								  placeholder="<?php echo $entry_test_publishable_key; ?>"
								  id="input-test-publishable-key" class="form-control"/>
							<?php if ($error_test_publishable_key) { ?>
								<div class="text-danger"><?php echo $error_test_publishable_key; ?></div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-merchant-id"><?php echo $entry_live_secret_key; ?></label>

						<div class="col-sm-10">
							<input type="text" name="stripe_live_secret_key"
								  value="<?php echo $stripe_live_secret_key; ?>"
								  placeholder="<?php echo $entry_live_secret_key; ?>"
								  id="input-merchant-id" class="form-control"/>
							<?php if ($error_live_secret_key) { ?>
								<div class="text-danger"><?php echo $error_live_secret_key; ?></div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-merchant-id"><?php echo $entry_live_publishable_key; ?></label>

						<div class="col-sm-10">
							<input type="text" name="stripe_live_publishable_key"
								  value="<?php echo $stripe_live_publishable_key; ?>"
								  placeholder="<?php echo $entry_live_publishable_key; ?>"
								  id="input-merchant-id" class="form-control"/>
							<?php if ($error_live_publishable_key) { ?>
								<div class="text-danger"><?php echo $error_live_publishable_key; ?></div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label"><?php echo $entry_test; ?></label>

						<div class="col-sm-10">
							<?php if ($stripe_test) { ?>
								<input type="radio" name="stripe_test" value="1" checked="checked"/>
								<?php echo $text_yes; ?>
								<input type="radio" name="stripe_test" value="0"/>
								<?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="stripe_test" value="1"/>
								<?php echo $text_yes; ?>
								<input type="radio" name="stripe_test" value="0" checked="checked"/>
								<?php echo $text_no; ?>
							<?php } ?>
							<br>
							<?php echo $entry_test_help ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-transaction"><?php echo $entry_transaction; ?></label>

						<div class="col-sm-10">
							<select name="stripe_transaction"  class="form-control">
								<?php if (!$stripe_transaction) { ?>
									<option value="0"
										   selected="selected"><?php echo $text_authorization; ?></option>
								<?php } else { ?>
									<option value="0"><?php echo $text_authorization; ?></option>
								<?php } ?>
								<?php if ($stripe_transaction) { ?>
									<option value="1"
										   selected="selected"><?php echo $text_sale; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_sale; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"
							  for="input-total"><?php echo $entry_total; ?></label>

						<div class="col-sm-10">
							<input type="text" name="stripe_total" value="<?php echo $stripe_total; ?>"
								  placeholder="<?php echo $stripe_total; ?>" id="input-total"
								  class="form-control"/>
							<?php echo $entry_total_help; ?>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-merchant-id"><?php echo $entry_order_status; ?></label>

						<div class="col-sm-10">
							<select name="stripe_order_status_id">
								<?php foreach ($order_statuses as $order_status) { ?>
									<?php if ($order_status['order_status_id'] == $stripe_order_status_id) { ?>
										<option value="<?php echo $order_status['order_status_id']; ?>"
											   selected="selected"><?php echo $order_status['name']; ?></option>
									<?php } else { ?>
										<option
											 value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>


					<div class="form-group required">
						<label class="col-sm-2 control-label"><?php echo $entry_prevent_duplicate_charge; ?></label>

						<div class="col-sm-10">
							<?php if ($stripe_prevent_duplicate_charge) { ?>
								<input type="radio" name="stripe_prevent_duplicate_charge" value="1" checked="checked"/>
								<?php echo $text_yes; ?>
								<input type="radio" name="stripe_prevent_duplicate_charge" value="0"/>
								<?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="stripe_prevent_duplicate_charge" value="1"/>
								<?php echo $text_yes; ?>
								<input type="radio" name="stripe_prevent_duplicate_charge" value="0" checked="checked"/>
								<?php echo $text_no; ?>
							<?php } ?>
							<br>
							<?php echo $entry_prevent_duplicate_charge_help ?>
						</div>
					</div>


					<div class="form-group required">
						<label class="col-sm-2 control-label"><?php echo $entry_journal_mode; ?></label>

						<div class="col-sm-10">
							<?php if ($stripe_journal_mode) { ?>
								<input type="radio" name="stripe_journal_mode" value="1" checked="checked"/>
								<?php echo $text_yes; ?>
								<input type="radio" name="stripe_journal_mode" value="0"/>
								<?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="stripe_journal_mode" value="1"/>
								<?php echo $text_yes; ?>
								<input type="radio" name="stripe_journal_mode" value="0" checked="checked"/>
								<?php echo $text_no; ?>
							<?php } ?>
							<br>
							<?php echo $entry_journal_mode_help ?>
						</div>
					</div>



					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-merchant-id"><?php echo $entry_geo_zone; ?></label>

						<div class="col-sm-10">
							<select name="stripe_geo_zone_id" class="form-control">
								<option value="0"><?php echo $text_all_zones; ?></option>
								<?php foreach ($geo_zones as $geo_zone) { ?>
									<?php if ($geo_zone['geo_zone_id'] == $stripe_geo_zone_id) { ?>
										<option value="<?php echo $geo_zone['geo_zone_id']; ?>"
											   selected="selected"><?php echo $geo_zone['name']; ?></option>
									<?php } else { ?>
										<option
											 value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-sm-2 control-label"
							  for="input-stripe-status"><?php echo $entry_status; ?></label>

						<div class="col-sm-10">
							<select name="stripe_status" id="input-stripe-status" class="form-control">
								<?php if ($stripe_status) { ?>
									<option value="1"
										   selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0"
										   selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"
							  for="input-sort-order"><?php echo $entry_sort_order; ?></label>

						<div class="col-sm-10">
							<input type="text" name="stripe_sort_order"
								  value="<?php echo $stripe_sort_order; ?>"
								  placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order"
								  class="form-control"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	</div>
<?php echo $footer; ?>
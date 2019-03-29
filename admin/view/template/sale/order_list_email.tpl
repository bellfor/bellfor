<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
          <a class="btn btn-info" href="<?php echo $backup_order_email; ?>"><i class="fa fa-print"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                    <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
                </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
		<?php if (isset($text_success)) { ?>
      <div class="alert alert-success" ><i class="fa fa-check-circle"></i> <?php echo $text_success; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
		<?php } ?>
        <form method="post" action="" enctype="multipart/form-data" target="_blank" id="form-order-email">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td class="text-center"><?php if ($sort == 'o.order_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                    <td class="text-center"><?php if ($sort == 'email') { ?>
                    <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($emails) { ?>
                <?php foreach ($emails as $email) { ?>
                <tr>
                  <td class="text-center"><?php echo $email['order_id']; ?></td>
                  <td class="text-center"><?php echo $email['customer']; ?></td>
                  <td class="text-center"><?php echo $email['email']; ?></td>
                  <td class="text-center"><?php echo $email['date_added']; ?></td>
                  <td class="text-center"><a href="<?php echo $email['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = 'index.php?route=sale/order_email&token=<?php echo $token; ?>';

	var filter_order_id = $('input[name=\'filter_order_id\']').val();

	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}

	var filter_customer = $('input[name=\'filter_customer\']').val();

	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}

	location = url;
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name^=\'selected\']:first').trigger('change');

// Login to the API
var token = '';

$.ajax({
	url: '<?php echo $store; ?>index.php?route=api/login',
	type: 'post',
	data: 'key=<?php echo $api_key; ?>',
	dataType: 'json',
	crossDomain: true,
	success: function(json) {
        $('.alert_remove').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger alert_remove"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

            if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger alert_remove"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
    		}
        }

		if (json['token']) {
			token = json['token'];
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?php echo $token; ?>&api_id=<?php echo $api_id; ?>',
		type: 'post',
		data: 'ip=<?php echo $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert_remove').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger alert_remove"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success alert_remove"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});
//--></script>
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script>
</div>
<?php echo $footer; ?>

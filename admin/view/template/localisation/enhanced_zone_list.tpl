<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $country_manager; ?>" data-toggle="tooltip" title="<?php echo $text_country_manager; ?>" class="btn btn-primary"><i class="fa fa-globe"></i></a>
        <button type="button" class="btn btn-success" data-toggle="tooltip" title="<?php echo $text_enable; ?>" id="enable_zones"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-warning" data-toggle="tooltip" title="<?php echo $text_disable; ?>" id="disable_zones"><i class="fa fa-close"></i></button> 
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-zone').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1><i class="fa fa-globe"></i> <?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">

	  <div class="well" style="padding:0 19px">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label class="control-label" for="input-country"><?php echo $entry_country; ?></label>
              <input type="text" name="filter_country" value="<?php echo $filter_country; ?>" placeholder="<?php echo $entry_country; ?>" id="input-country" class="form-control" />
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <label class="control-label" for="input-zstatus"><?php echo $entry_zstatus; ?></label>
              <select name="filter_status" id="input-zstatus" class="form-control" onchange="filterZones();">
                <option value="*"></option>
                <?php if ($filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
                <?php if (!$filter_status && !is_null($filter_status)) { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>                
            </div>          
          </div>
          <div class="col-sm-4 text-right" style="margin-top:28px; margin-bottom:0">
            <button type="button" id="button-reset" class="btn btn-warning"><i class="fa fa-close"></i> <?php echo $button_clear; ?></button>
          </div>
        </div>
      </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-zone">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'c.name') { ?>
                    <a href="<?php echo $sort_country; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_country; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_country; ?>"><?php echo $column_country; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'c.country_id') { ?>
                    <a href="<?php echo $sort_cid; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_country_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_cid; ?>"><?php echo $column_country_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'z.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'z.code') { ?>
                    <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'z.zone_id') { ?>
                    <a href="<?php echo $sort_zid; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_zone_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_zid; ?>"><?php echo $column_zone_id; ?></a>
                    <?php } ?></td>  
                  <td class="text-center"><?php if ($sort == 'z.status') { ?>
                    <a href="<?php echo $sort_zstatus; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_zstatus; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_zstatus; ?>"><?php echo $column_zstatus; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($zones) { ?>
                <?php foreach ($zones as $zone) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($zone['zone_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $zone['zone_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $zone['zone_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $zone['country']; ?></td>
                  <td class="text-left"><?php echo $zone['country_id']; ?></td>
                  <td class="text-left"><?php echo $zone['name']; ?></td>
                  <td class="text-left"><?php echo $zone['code']; ?></td>
                  <td class="text-left"><?php echo $zone['zone_id']; ?></td>
                  <td class="text-center"><a href="javascript:void(0)" class="columnstatus" id="status-<?php echo $zone['zone_id']; ?>" style="outline:none;"><?php echo $zone['zstatus']; ?></a></td>
                  <td class="text-right"><a href="<?php echo $zone['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
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
</div>

<script type="text/javascript"><!--
$(document).ready(function() {
	$(".alert-success").hide(0).delay(10).fadeIn(500);
	$(".alert-success").show(0).delay(3000).fadeOut(2000);
});

function filterZones() {
	url = 'index.php?route=localisation/enhanced_zone&token=<?php echo $token; ?>';
	var filter_country = $('input[name=\'filter_country\']').val();	
	if (filter_country) {
		url += '&filter_country=' + encodeURIComponent(filter_country);
	}
	var filter_status = $('select[name=\'filter_status\']').val();
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
	location = url;
}

$('#button-reset').on('click', function() {
    var url = 'index.php?route=localisation/enhanced_zone&token=<?php echo $token; ?>';	
	$('input[name=\'filter_country\']').val('');
	$('select[name=\'filter_status\']').val('*');
	location = url;
});

$('input[name=\'filter_country\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=localisation/enhanced_zone/autocomplete&token=<?php echo $token; ?>&filter_country=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['country_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_country\']').val(item['label']);
		filterZones();
	}	
});

$(document).delegate('.columnstatus', 'click', function(e) {
	$(".alert, .alert2").remove();
	var object_id = $(this).attr('id');
	$.ajax({
		url: 'index.php?route=localisation/enhanced_zone/updateStatus&token=<?php echo $token; ?>',
		type: 'get',
		data: {object_id:object_id},
		dataType: 'html',
		success: function(html) {
			if(html!=''){				
				$('#'+object_id).html(html);				
			}
			$(".page-header .container-fluid .pull-right").prepend('<span class="alert2 alert-success2 pull-left"><i class="fa fa-check-circle"></i> <?php echo $text_success_zstatus; ?></span>');
			$(".alert-success2").hide(0).delay(10).fadeIn(500);
   			$(".alert-success2").show(0).delay(3000).fadeOut(2000);
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$(document).delegate('#enable_zones', 'click', function(e) {
	e.preventDefault();	
	$(".alert, .alert2").remove();
	$('[data-toggle=\'tooltip\']').tooltip('hide');
	var ajaxUrl = 'index.php?route=localisation/enhanced_zone/enableZones&token=<?php echo $token; ?>';
	$.ajax({
		url: ajaxUrl,
		type: 'post',
		data: $('input[name*=\'selected\']:checked').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#enable_zones i').replaceWith('<i class="fa fa-cog fa-spin"></i>');
			$('#enable_zones').prop('disabled', true);			
		},
		complete: function() {
			$('#enable_zones i').replaceWith('<i class="fa fa-check"></i>');
			$('#enable_zones').prop('disabled', false);
		},
		success: function(json) {
			if(json['success']) {
				$(".page-header .container-fluid .pull-right").prepend('<span class="alert2 alert-success2 pull-left"><i class="fa fa-check-circle"></i> '+json['success']+'</span>');
				$(".alert-success2").hide(0).delay(10).fadeIn(500);
   				$(".alert-success2").show(0).delay(3000).fadeOut(2000);
				setTimeout(function() {
					location.reload();
				}, 1000);			
			} else {
				$(".page-header .container-fluid .pull-right").prepend('<span class="alert2 alert-danger2 pull-left"><i class="fa fa-exclamation-circle"></i> '+json['failed']+'</span>');
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
	$('[data-toggle=\'tooltip\']').tooltip('hide');
});

$(document).delegate('#disable_zones', 'click', function(e) {
	e.preventDefault();	
	$(".alert, .alert2").remove();
	$('[data-toggle=\'tooltip\']').tooltip('hide');
    var ajaxUrl = 'index.php?route=localisation/enhanced_zone/disableZones&token=<?php echo $token; ?>';
	$.ajax({
		url: ajaxUrl,
		type: 'post',
		data: $('input[name*=\'selected\']:checked').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#disable_zones i').replaceWith('<i class="fa fa-cog fa-spin"></i>');
			$('#disable_zones').prop('disabled', true);			
		},
		complete: function() {
			$('#disable_zones i').replaceWith('<i class="fa fa-close"></i>');
			$('#disable_zones').prop('disabled', false);
		},
		success: function(json) {
			if(json['success']) {
				$(".page-header .container-fluid .pull-right").prepend('<span class="alert2 alert-success2 pull-left"><i class="fa fa-check-circle"></i> '+json['success']+'</span>');
				$(".alert-success2").hide(0).delay(10).fadeIn(500);
   				$(".alert-success2").show(0).delay(3000).fadeOut(2000);
				setTimeout(function() {
					location.reload();
				}, 1000);
			} else {
				$(".page-header .container-fluid .pull-right").prepend('<span class="alert2 alert-danger2 pull-left"><i class="fa fa-exclamation-circle"></i> '+json['failed']+'</span>');	
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
	$('[data-toggle=\'tooltip\']').tooltip('hide');
});
//--></script>

<?php echo $footer; ?>
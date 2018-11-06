<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $zone_manager; ?>" data-toggle="tooltip" title="<?php echo $text_zone_manager; ?>" class="btn btn-primary"><i class="fa fa-globe"></i></a>
        <button type="button" class="btn btn-success" data-toggle="tooltip" title="<?php echo $text_enable; ?>" id="enable_countries"><i class="fa fa-check"></i></button>
        <button type="button" class="btn btn-warning" data-toggle="tooltip" title="<?php echo $text_disable; ?>" id="disable_countries"><i class="fa fa-close"></i></button>       
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-country').submit() : false;"><i class="fa fa-trash-o"></i></button>
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
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label" for="input-geo-zone-id"><?php echo $entry_geozone; ?></label>
              <select name="filter_geo_zone_id" id="input-geo-zone-id" class="form-control" onchange="selectGeozone();">
                <option value="*"></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $filter_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label" for="input-country"><?php echo $entry_name; ?></label>
              <input type="text" name="filter_country" value="<?php echo $filter_country; ?>" placeholder="<?php echo $entry_name; ?>" id="input-country" class="form-control" />
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>
              <select name="filter_status" id="input-status" class="form-control" onchange="filterCountries();">
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
          <div class="col-sm-3 text-right" style="margin-top:28px; margin-bottom:0">
            <button type="button" id="button-reset" class="btn btn-warning"><i class="fa fa-close"></i> <?php echo $button_clear; ?></button>
          </div>
        </div>
      </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-country">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left"><?php if ($sort == 'name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'iso_code_2') { ?>
                    <a href="<?php echo $sort_iso_code_2; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_iso_code_2; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_iso_code_2; ?>"><?php echo $column_iso_code_2; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'iso_code_3') { ?>
                    <a href="<?php echo $sort_iso_code_3; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_iso_code_3; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_iso_code_3; ?>"><?php echo $column_iso_code_3; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'postcode_required') { ?>
                    <a href="<?php echo $sort_postcode; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_postcode; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_postcode; ?>"><?php echo $column_postcode; ?></a>
                    <?php } ?></td>
                  <td class="text-center"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($countries) { ?>
                <?php foreach ($countries as $country) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($country['country_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $country['country_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $country['country_id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $country['name']; ?><?php if ($country['zones']) { ?><span class="pull-right">(<a href="<?php echo $country['list_zones']; ?>" data-toggle="tooltip" title="<?php echo $button_list; ?>" target="_blank"><?php echo $country['zones'] . ' ' . $text_zones; ?></a>)</span><?php } ?></td>
                  <td class="text-left"><?php echo $country['iso_code_2']; ?></td>
                  <td class="text-left"><?php echo $country['iso_code_3']; ?></td>
                  <td class="text-center"><?php echo $country['postcode']; ?></td>
                  <td class="text-center"><a href="javascript:void(0)" class="columnstatus" id="status-<?php echo $country['country_id']; ?>" style="outline:none;"><?php echo $country['status']; ?></a></td>
                  <td class="text-right"><a href="<?php echo $country['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>
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

function selectGeozone() {
	url = 'index.php?route=localisation/enhanced_country&token=<?php echo $token; ?>';
	var filter_geo_zone_id = $('select[name=\'filter_geo_zone_id\']').val();
	if (filter_geo_zone_id != '*') {
		url += '&filter_geo_zone_id=' + encodeURIComponent(filter_geo_zone_id);
	}
	$('input[name=\'filter_country\']').val('');
	$('select[name=\'filter_status\']').val('*');
	location = url;
}

function filterCountries() {
	url = 'index.php?route=localisation/enhanced_country&token=<?php echo $token; ?>';
	var filter_country = $('input[name=\'filter_country\']').val();	
	if (filter_country) {
		url += '&filter_country=' + encodeURIComponent(filter_country);
	}
	var filter_status = $('select[name=\'filter_status\']').val();
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}
	$('select[name=\'filter_geo_zone_id\']').val('*');
	location = url;
}

$('#button-reset').on('click', function() {
    var url = 'index.php?route=localisation/enhanced_country&token=<?php echo $token; ?>';	
    $('select[name=\'filter_geo_zone_id\']').val('*');
	$('input[name=\'filter_country\']').val('');
	$('select[name=\'filter_status\']').val('*');
	location = url;
});

$(document).delegate('.columnstatus', 'click', function(e) {
	$(".alert, .alert2").remove();
	var object_id = $(this).attr('id');
	$.ajax({
		url: 'index.php?route=localisation/enhanced_country/updateStatus&token=<?php echo $token; ?>',
		type: 'get',
		data: {object_id:object_id},
		dataType: 'html',
		success: function(html) {
			if(html!=''){				
				$('#'+object_id).html(html);				
			}
			$(".page-header .container-fluid .pull-right").prepend('<span class="alert2 alert-success2 pull-left"><i class="fa fa-check-circle"></i> <?php echo $text_success_status; ?></span>');
			$(".alert-success2").hide(0).delay(10).fadeIn(500);
   			$(".alert-success2").show(0).delay(3000).fadeOut(2000);
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
});

$(document).delegate('#enable_countries', 'click', function(e) {
	e.preventDefault();	
	$(".alert, .alert2").remove();
	$('[data-toggle=\'tooltip\']').tooltip('hide');
	var ajaxUrl = 'index.php?route=localisation/enhanced_country/enableCountries&token=<?php echo $token; ?>';
	$.ajax({
		url: ajaxUrl,
		type: 'post',
		data: $('input[name*=\'selected\']:checked').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#enable_countries i').replaceWith('<i class="fa fa-cog fa-spin"></i>');
			$('#enable_countries').prop('disabled', true);			
		},
		complete: function() {
			$('#enable_countries i').replaceWith('<i class="fa fa-check"></i>');
			$('#enable_countries').prop('disabled', false);
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

$(document).delegate('#disable_countries', 'click', function(e) {
	e.preventDefault();	
	$(".alert, .alert2").remove();
	$('[data-toggle=\'tooltip\']').tooltip('hide');
    var ajaxUrl = 'index.php?route=localisation/enhanced_country/disableCountries&token=<?php echo $token; ?>';
	$.ajax({
		url: ajaxUrl,
		type: 'post',
		data: $('input[name*=\'selected\']:checked').serialize(),
		dataType: 'json',
		beforeSend: function() {
			$('#disable_countries i').replaceWith('<i class="fa fa-cog fa-spin"></i>');
			$('#disable_countries').prop('disabled', true);			
		},
		complete: function() {
			$('#disable_countries i').replaceWith('<i class="fa fa-close"></i>');
			$('#disable_countries').prop('disabled', false);
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

$('input[name=\'filter_country\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=localisation/enhanced_country/autocomplete&token=<?php echo $token; ?>&filter_country=' +  encodeURIComponent(request),
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
		filterCountries();
	}	
});
//--></script>

<?php echo $footer; ?>
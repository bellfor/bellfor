<?php echo $header ?><?php echo $column_left ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">

        <button type="submit" form="form-module" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>

        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>

		&nbsp;&nbsp;&nbsp;<a href="<?php echo $update; ?>" onClick="$(this).text('<?php echo $text_loading; ?>');" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-lg btn-success"><i class="fa fa-refresh"></i></a>
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
    <?php if ($error_success) { ?>
    <div class="alert alert-success alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-module" class="form-horizontal">

              <?php
			  foreach ($currencies as $cur_code) {
				  $flag = '';
				  if(is_file(DIR_APPLICATION.'view/image/currency/'.strtoupper($cur_code['code']).'.png')) {
					$flag = '<img alt="" border="0" lowsrc="" src="view/image/currency/'.strtoupper($cur_code['code']).'.png" />';
				  }
				  ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-curr<?php echo $cur_code['code']; ?>"><?php echo $flag ; ?> <?php echo $cur_code['code'] ; ?> <span style="font-weight: normal;" data-toggle="tooltip" title="<?php echo $help_comission; ?>">(<?php echo $entry_comission; ?>) +%</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="module_currency_bellfor_code[<?php echo $cur_code['code']; ?>]" id="input-curr<?php echo $cur_code['code']; ?>" value="<?php echo isset($module_currency_bellfor_code[$cur_code['code']]) ? $module_currency_bellfor_code[$cur_code['code']] : ''; ?>" class="form-control" />
                  </div>
                </div>

              <?php } ?>



          <div class="form-group">
            <label class="col-sm-2 control-label" for="entry-source"><span data-toggle="tooltip" title="<?php echo $help_source; ?>"><?php echo $entry_source; ?></span></label>
            <div class="col-sm-10">
              <select name="module_currency_bellfor_source" id="input-source" class="form-control">
                <option value="alphavantage.co"<?php echo $module_currency_bellfor_source == 'alphavantage.co' ? ' selected="selected"' : ''; ?>><?php echo $text_source_alphavantage; ?></option>
                <option value="fixer.io"<?php echo $module_currency_bellfor_source == 'fixer.io' ? ' selected="selected"' : ''; ?>><?php echo $text_source_fixer; ?></option>
              </select>
            </div>
          </div>
          <div class="form-group optional" data-source="alphavantage.co"<?php echo $module_currency_bellfor_source == 'alphavantage.co' ? '' : ' style="display:none;"'; ?>>
            <label class="col-sm-2 control-label" for="input-alphavantage-api-key"><span data-toggle="tooltip" title="<?php echo $help_alphavantage_api_key; ?>"><?php echo $entry_alphavantage_api_key; ?></span></label>
            <div class="col-sm-6">
              <input name="module_currency_bellfor_alphavantage_api_key" value="<?php echo $module_currency_bellfor_alphavantage_api_key; ?>" id="input-alphavantage-api-key" class="form-control" />
			  <?php if ($error_alphavantage_api_key) { ?>
				<div class="text-danger"><?php echo $error_alphavantage_api_key; ?></div>
			  <?php } ?>
			</div>
			<div class="col-sm-4">
			  <div class="alert alert-info alert-dismissible" style="margin:0;padding:8px 10px 8px 10px;"><i class="fa fa-exclamation-circle"></i> <?php echo $text_alphavantage_api_key; ?></div>
			</div>
          </div>
          <div class="form-group" style="display:none;">
            <label class="col-sm-2 control-label" for="input-debug"><?php echo $entry_debug; ?></label>
            <div class="col-sm-10">
              <select name="module_currency_bellfor_debug" id="input-debug" class="form-control">
                <option value="1"<?php echo $module_currency_bellfor_debug ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php echo $module_currency_bellfor_debug ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="entry-autoupdate"><span data-toggle="tooltip" title="<?php echo $help_autoupdate; ?>"><?php echo $entry_autoupdate; ?></span></label>
            <div class="col-sm-10">
              <select name="module_currency_bellfor_autoupdate" id="input-autoupdate" class="form-control">
                <option value="1"<?php echo $module_currency_bellfor_autoupdate ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php echo $module_currency_bellfor_autoupdate ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="module_currency_bellfor_status" id="input-status" class="form-control">
                <option value="1"<?php echo $module_currency_bellfor_status ? ' selected="selected"' : ''; ?>><?php echo $text_enabled; ?></option>
                <option value="0"<?php echo $module_currency_bellfor_status ? '' : ' selected="selected"'; ?>><?php echo $text_disabled; ?></option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('select[name="module_currency_bellfor_source"]').on('change', function() {
	var sel = $('option:selected', $(this)).val();
	$('.optional[data-source!="'+sel+'"]').hide();
	$('.optional[data-source="'+sel+'"]').show();
});
</script>
<?php echo $footer; ?>
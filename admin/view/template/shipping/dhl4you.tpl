<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-dhl4you" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><img src="view/image/dhl_logo_small.gif" alt="" /> <?php echo $heading_title; ?></h1>
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
	<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_countries_customs; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-dhl4you" class="form-horizontal">
	  
	  
		<div class="form-group">
            <label class="col-sm-2 control-label"><span data-toggle="tooltip" title="<?php echo $help_use_freeshipping; ?>"><?php echo $entry_use_freeshipping; ?></span></label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <?php if ($dhl4you_use_freeshipping) { ?>
                <input type="radio" name="dhl4you_use_freeshipping" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <?php } else { ?>
                <input type="radio" name="dhl4you_use_freeshipping" value="1" />
                <?php echo $text_yes; ?>
                <?php } ?>
              </label>
              <label class="radio-inline">
                <?php if (!$dhl4you_use_freeshipping) { ?>
                <input type="radio" name="dhl4you_use_freeshipping" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="dhl4you_use_freeshipping" value="0" />
                <?php echo $text_no; ?>
                <?php } ?>
              </label>
            </div>
          </div>
		
		
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>
            <div class="col-sm-10">
              <select name="dhl4you_tax_class_id" id="input-tax-class" class="form-control">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($tax_classes as $tax_class) { ?>
                <?php if ($tax_class['tax_class_id'] == $dhl4you_tax_class_id) { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
		
		
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="dhl4you_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $dhl4you_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
		
		
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="dhl4you_status" id="input-status" class="form-control">
                <?php if ($dhl4you_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="dhl4you_sort_order" value="<?php echo $dhl4you_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
	  
	  
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-small-cost"><span data-toggle="tooltip" title="<?php echo $text_help_small; ?>"><?php echo $entry_small_cost; ?></span></label>
			<div class="col-sm-10">
              <input type="text" name="dhl4you_small_cost" value="<?php echo $dhl4you_small_cost; ?>" placeholder="<?php echo $entry_small_cost; ?>" onkeypress='validate(event)' id="input-small-cost" class="form-control" />
            </div>
      </div>
	  
	  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-large-cost"><span data-toggle="tooltip" title="<?php echo $text_help_large; ?>"><?php echo $entry_large_cost; ?></span></label>
			<div class="col-sm-10">
              <input type="text" name="dhl4you_large_cost" value="<?php echo $dhl4you_large_cost; ?>" placeholder="<?php echo $entry_large_cost; ?>" onkeypress='validate(event)' id="input-large-cost" class="form-control" />
            </div>
      </div>
	  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-germany-cost"><span data-toggle="tooltip" title="<?php echo $text_help_germany; ?>"><?php echo $entry_germany_cost; ?></span></label>
			<div class="col-sm-10">
              <input type="text" name="dhl4you_germany_cost" value="<?php echo $dhl4you_germany_cost; ?>" placeholder="<?php echo $entry_germany_cost; ?>" onkeypress='validate(event)' id="input-germany-cost" class="form-control" />
            </div>
          </div>
	  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-countries-westeurope"><span data-toggle="tooltip" title="<?php echo $text_countries_westeurope . $text_help_europe; ?>"><?php echo $entry_westeurope_cost; ?></span></label>
			<div class="col-sm-10">
              <input type="text" name="dhl4you_westeurope_cost" value="<?php echo $dhl4you_westeurope_cost; ?>" placeholder="<?php echo $entry_westeurope_cost; ?>" onkeypress='validate(event)' id="input-countries-westeurope" class="form-control" />
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-countries-europe"><span data-toggle="tooltip" title="<?php echo $text_countries_europe . $text_help_europe; ?>"><?php echo $entry_europe_cost; ?></span></label>
			<div class="col-sm-10">
              <input type="text" name="dhl4you_europe_cost" value="<?php echo $dhl4you_europe_cost; ?>" placeholder="<?php echo $entry_europe_cost; ?>" onkeypress='validate(event)' id="input-countries-europe" class="form-control" />
            </div>
          </div>
	  
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-world-cost"><span data-toggle="tooltip" title="<?php echo $text_help_world; ?>"><?php echo $entry_world_cost; ?></span></label>
			<div class="col-sm-10">
              <input type="text" name="dhl4you_world_cost" value="<?php echo $dhl4you_world_cost; ?>" placeholder="<?php echo $entry_world_cost; ?>" onkeypress='validate(event)' id="input-world-cost" class="form-control" />
            </div>
          </div>
	  
    </form>
  </div>
</div>
</div>
</script>
<script type="text/javascript" src="view/javascript/jquery/jquery.placeholder.js"></script>
  <script type="text/javascript"><!--
   // To test the @id toggling on password inputs in browsers that don’t support changing an input’s @type dynamically (e.g. Firefox 3.6 or IE), uncomment this:
   // jQuery.fn.hide = function() { return this; }
   // Then uncomment the last rule in the <style> element (in the <head>).
   $(function() {
    // Invoke the plugin
    $('input, textarea').placeholder();
    // That’s it, really.
   });
  //--></script>
  <script type="text/javascript">
  function validate(evt) {
  	var theEvent = evt || window.event;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
		if( !regex.test(key) ) {    theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
	}}
    </script>
	<script type="text/javascript"><!--
//--></script> 
<?php echo $footer; ?>
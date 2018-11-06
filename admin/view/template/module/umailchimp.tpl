<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-umailchimp" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-umailchimp" class="form-horizontal">
		<ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-list" data-toggle="tab"><?php echo $tab_list; ?></a></li>
			<li><a href="#tab-merge_tags" data-toggle="tab"><?php echo $entry_merge_tags; ?></a></li>
			<li><a href="#tab-subscribe" data-toggle="tab"><?php echo $entry_subscribe_form; ?></a></li>
			<li><a href="#tab-logs" id="logs_links" data-toggle="tab"><?php echo $entry_log; ?></a></li>
          </ul>
		  <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
			<div class="alert alert-info">
			<i class="fa fa-info-circle"></i> <?php echo $entry_info_general; ?>
			</div>
			<div class="form-group">
            <label class="col-sm-2 control-label" for="input-api-key"><?php echo $entry_api_key; ?></label>
            <div class="col-sm-7">
              <input type="text" name="umailchimp_api_key" value="<?php echo $umailchimp_api_key; ?>" id="input-api-key" class="form-control" />
              <?php if ($error_api_key) { ?>
              <div class="text-danger"><?php echo $error_api_key; ?></div>
              <?php } ?>
            </div>
			<div class="col-sm-3">
			<button type="button" class="btn btn-primary"<?php if(count($umailchimp_lists)!=0){?> disabled="disabled"<?php } ?> onclick="$('input[name=refresh]').val('1'); $('button[type=submit]').trigger('click');"><?php echo $entry_connect; ?></button>
			<input type="hidden" name="refresh" value="0">
			</div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_synchronize; ?></label>
			<div class="col-sm-3">
			<button type="button" class="btn btn-primary" onclick="$('input[name=refresh]').val('2'); $('button[type=submit]').trigger('click');"><?php echo $entry_synchron; ?></button>
			</div>
          </div>
			
			</div>
			<div class="tab-pane" id="tab-list">
			<div class="alert alert-info">
			<i class="fa fa-info-circle"></i> <?php echo $entry_info_list_settings; ?>
			</div>
<?php if((isset($umailchimp_lists))&&(count($umailchimp_lists)>0)){ ?>
		  <div class="table-responsive">
                <table id="umailchimp_lists" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_list_in_rule; ?>"><?php echo $entry_list; ?></span></td>
					  <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_workflow_in_rule; ?>"><?php echo $entry_workflow; ?></span></td>
					  <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_action_in_rule; ?>"><?php echo $entry_action; ?></span></td>
					  <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_rule_in_rule; ?>"><?php echo $entry_rules; ?></span></td>
                      <td style="width: 60px;"></td>
                    </tr>
                  </thead>
                  <tbody id="umailchimp_lists_body">
				  <?php $ulr_row = 0; ?>
				  <?php if(isset($umailchimp_list_rules)){ ?>
                    <?php foreach ($umailchimp_list_rules as $umailchimp_list_rule) { ?>
                      <tr id="umailchimp_list_rules-row<?php echo $ulr_row; ?>">
                      <td class="text-left" style="width: 20%;">
					  <select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][list]" class="form-control">
						<?php foreach($umailchimp_lists as $list) { ?>
						<option value="<?php echo $list['id']; ?>"<?php if($list['id']==$umailchimp_list_rule['list']){ ?> selected="selected"<?php } ?>><?php echo $list['name']; ?></option>
						<?php } ?>
					  </select>
					  </td>
					  <td class="text-left" style="width: 20%;">
					  <select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][workflow]" class="form-control">
					  <option></option>
					  <?php foreach($umailchimp_list_worflows as $worflow) { ?>
						<option value="<?php echo $worflow['id']; ?>"<?php if($worflow['id']==$umailchimp_list_rule['workflow']){ ?> selected="selected"<?php } ?>><?php echo $worflow['name']; ?></option>
						<?php } ?>
					  </select>
					  </td>
					  <td class="text-left">
					  <div class="checkbox">
                      <label>
					  <input type="checkbox" name="umailchimp_list_rules[<?php echo $ulr_row; ?>][action][registration]" value="1"<?php if((isset($umailchimp_list_rule['action']['registration']))&&($umailchimp_list_rule['action']['registration']==1)){ ?>checked="checked"<?php } ?>>
					  <?php echo $entry_registration; ?>
                      </label><br>
					  <label>
					  <input type="checkbox" name="umailchimp_list_rules[<?php echo $ulr_row; ?>][action][guest_order]" value="1"<?php if((isset($umailchimp_list_rule['action']['guest_order']))&&($umailchimp_list_rule['action']['guest_order']==1)){ ?>checked="checked"<?php } ?>>
					  <?php echo $entry_guest_order; ?>
                      </label>
                    </div>
					  </td>
                      <td class="text-left">
				<div class="table-responsive">

                <table class="table table-bordered table-hover" id="umailchimp_list_rules_<?php echo $ulr_row; ?>">
                  <thead>
                    <tr>
                      <td class="text-left" style="width: 200px;"><?php echo $entry_field; ?></td>
					  <td class="text-left"><?php echo $entry_equal_sign; ?></td>
					  <td class="text-left"><?php echo $entry_value; ?></td>
					  <td style="width: 60px;"></td>
                    </tr>
                  </thead>
                  <tbody>
				  <?php $ulr_field = 0; ?>
				  <?php foreach($umailchimp_list_rule['rules'] as $rule){ ?>
				  <tr id="umailchimp_list_rules_fields-row_<?php echo $ulr_row; ?>_<?php echo $ulr_field; ?>">
					<td>
					  <select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][type]" onchange="SelectTypeList(this);" class="form-control">
					  <option></option>
					  <?php foreach($umailchimp_rule_fields as $field){ ?>
					  <option value="<?php echo $field['path']; ?>"<?php if($field['path']==$rule['type']){ ?> selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
					  <?php } ?>
					  </select>
					</td>
					<td>
					<select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][equal]" onchange="SelectEkvalList(this);" class="form-control">
					<?php 
					$temp_type=0;
					foreach($umailchimp_rule_fields as $field){ 
					if($field['path']==$rule['type'])
					$temp_type=$field['type'];
					} ?>
					<?php if(($temp_type!=0)){ ?>
					<?php if($temp_type==1){ ?>
					<option></option>
					<?php foreach($umailchimp_main_equal as $equal){ ?>
					<option value="<?php echo $equal['val']; ?>"<?php if(($equal['val']==$rule['equal'])&&(isset($rule['equal']))){ ?> selected="selected"<?php } ?>><?php echo $equal['name']; ?></option>
					<?php } ?>
					<?php }elseif(($temp_type==2)||($temp_type==3)||($temp_type==4)){ ?>
					<?php foreach($umailchimp_alt_equal as $equal){ ?>
					<option value="<?php echo $equal['val']; ?>"<?php if(($equal['val']==$rule['equal'])&&(isset($rule['equal']))){ ?> selected="selected"<?php } ?>><?php echo $equal['name']; ?></option>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					</select>
					</td>
					<td>
					<?php if($rule['equal']!=''){ ?>
					<?php 
					$temp_type=0;
					foreach($umailchimp_rule_fields as $field){ 
					if($field['path']==$rule['type'])
					$temp_type=$field['type'];
					} ?>
					<?php if(($temp_type!=0)){ ?>
					<?php if($temp_type==1){ ?>
					<input type="text" name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][value]" value="<?php if(isset($rule['value'])){ ?><?php echo $rule['value']; ?><?php } ?>" class="form-control">
					<?php }elseif($temp_type==2){ ?>
					<select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][value_country]" onchange="SelectCountry(this);" zone="<?php echo $rule['value_zone']; ?>" class="form-control country_val">
					<?php foreach ($umailchimp_countries as $country) { ?>
					<?php if ($rule['value_country'] == $country['country_id']) { ?>
					<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
					<?php } ?>
					<?php } ?>
					</select>
					<select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][value_zone]"class="form-control">
					</select>
					<?php }elseif($temp_type==3){ ?>
					<label class="radio-inline"><input type="radio" name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][value]" value="1" <?php if((isset($rule['value']))&&($rule['value']==1)){ ?>checked="checked"<?php } ?>><?php echo $entry_yes; ?></label>
					<label class="radio-inline"><input type="radio" name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][value]" value="0" <?php if((!isset($rule['value']))||($rule['value']==0)){ ?>checked="checked"<?php } ?>><?php echo $entry_no; ?></label>
					<?php }elseif($temp_type==4){ ?>
					<select name="umailchimp_list_rules[<?php echo $ulr_row; ?>][rules][<?php echo $ulr_field; ?>][value]"class="form-control">
					<?php foreach ($umailchimp_stores as $store) { ?>
					<?php if ($rule['value'] == $store['store_id']) { ?>
					<option value="<?php echo $store['store_id']; ?>" selected="selected"><?php echo $store['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
					<?php } ?>
					<?php } ?>
					</select>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					</td>
					<td class="text-center">
					<button type="button" onclick="$('#umailchimp_list_rules_fields-row_<?php echo $ulr_row; ?>_<?php echo $ulr_field; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
					</td>
				  </tr>
				  <?php $ulr_field ++; ?>
				  <?php } ?>
                  </tbody>
				  <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td class="text-center"><button type="button" onclick="addRuleInList(this, 'umailchimp_list_rules_<?php echo $ulr_row; ?>');" cnt="<?php echo $ulr_field; ?>" num-lst="<?php echo $ulr_row; ?>" data-toggle="tooltip" title="<?php echo $entry_add_list_rule; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
                      </td>
					<?php /*<td></td>*/ ?>
                      <td class="text-center"><button type="button" onclick="$('#umailchimp_list_rules-row<?php echo $ulr_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                    </tr>
					<?php $ulr_row++; ?>
					<?php } ?>
				  <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-center"><button type="button" onclick="addListRule();" data-toggle="tooltip" title="<?php echo $entry_add_list_rule; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>

  <script type="text/javascript"><!--
var ulr_row = <?php echo $ulr_row; ?>;

function addListRule() {
    html  = '<tr id="umailchimp_list_rules-row' + ulr_row + '">';
	html += '<td class="text-left" style="width: 20%;">';
	html += '<select name="umailchimp_list_rules[' + ulr_row + '][list]" class="form-control">';
	<?php foreach($umailchimp_lists as $list) { ?>
	html += '<option value="<?php echo $list['id']; ?>"><?php echo $list['name']; ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td class="text-left" style="width: 20%;">';
	html += '<select name="umailchimp_list_rules[' + ulr_row + '][workflow]" class="form-control">';
	html += '<option></option>';
	<?php foreach($umailchimp_list_worflows as $worflow) { ?>
	html += '<option value="<?php echo $worflow['id']; ?>"><?php echo $worflow['name']; ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td class="text-left">';
	html += '<div class="checkbox">';
    html += '<label><input type="checkbox" name="umailchimp_list_rules[' + ulr_row + '][action][registration]" value="1"><?php echo $entry_registration; ?></label><br>';
	html += '<label><input type="checkbox" name="umailchimp_list_rules[' + ulr_row + '][action][guest_order]" value="1"><?php echo $entry_guest_order; ?></label></div></td>';
	html += '<td class="text-left">';
	html += '<div class="table-responsive">';
	html += '<table class="table table-bordered table-hover" id="umailchimp_list_rules_' + ulr_row + '">';
	html += '<thead>';
	html += '<tr><td class="text-left" style="width: 200px;"><?php echo $entry_field; ?></td><td class="text-left"><?php echo $entry_equal_sign; ?></td><td class="text-left"><?php echo $entry_value; ?></td><td style="width: 60px;"></td></tr></thead><tbody></tbody><tfoot><tr><td colspan="3"></td>';
	html += '<td class="text-center"><button type="button" onclick="addRuleInList(this, \'umailchimp_list_rules_' + ulr_row + '\');" cnt="0" num-lst="' + ulr_row + '" data-toggle="tooltip" title="<?php echo $entry_add_list_rule; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';
	html += '</tr></tfoot></table></div></td>';
	html += '<td class="text-center"><button type="button" onclick="$(\'#umailchimp_list_rules-row' + ulr_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    html += '</tr>';
	
	$('#umailchimp_lists_body').append(html);
	ulr_row++;
}

function addRuleInList(obj, tbl) {
cnt=$(obj).attr('cnt');
num_lst=$(obj).attr('num-lst');
html  = '<tr id="umailchimp_list_rules_fields-row_'+num_lst+'_'+cnt+'">';
html += '<td>';
html += '<select name="umailchimp_list_rules['+num_lst+'][rules]['+cnt+'][type]" onchange="SelectTypeList(this);" class="form-control">';
html += '<option></option>';
<?php foreach($umailchimp_rule_fields as $field){ ?>
html += '<option value="<?php echo $field['path']; ?>"><?php echo $field['name']; ?></option>';
<?php } ?>
html += '</select>';
html += '</td>';
html += '<td>';
html += '<select name="umailchimp_list_rules['+num_lst+'][rules]['+cnt+'][equal]" onchange="SelectEkvalList(this);" class="form-control">';
html += '</select></td>';
html += '<td></td>';
html += '<td class="text-center">';
html += '<button type="button" onclick="$(\'#umailchimp_list_rules_fields-row_'+num_lst+'_'+cnt+'\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';
html += '</td>';
html += '</tr>';
$('#'+tbl+' tbody').append(html);
cnt++;
$(obj).attr('cnt', cnt);

}

equals=new Array(
<?php foreach($umailchimp_main_equal as $key=>$mequal){?>
{"val":"<?php echo $mequal['val']; ?>", "name":"<?php echo $mequal['name']; ?>"}<?php if($key!=(count($umailchimp_main_equal)-1)){ ?>,<?php } ?>
<?php } ?>
);
alt_equals=new Array(
<?php foreach($umailchimp_alt_equal as $key=>$mequal){?>
{"val":"<?php echo $mequal['val']; ?>", "name":"<?php echo $mequal['name']; ?>"}<?php if($key!=(count($umailchimp_alt_equal)-1)){ ?>,<?php } ?>
<?php } ?>
);


function SelectTypeList(obj){
ekval=$(obj).parent().next().children('select');
val=$(obj).parent().next().next();
if(($(obj).val()!='country_zone_id')&&($(obj).val()!='newsletter')&&($(obj).val()!='store')&&($(obj).val()!='')){
str='<option></option>';
for(i=0;i<equals.length;i++)
str+='<option value="'+equals[i].val+'">'+equals[i].name+'</option>';
ekval.html(str);
val.html('');
}else if(($(obj).val()=='country_zone_id')||($(obj).val()=='newsletter')||($(obj).val()=='store')){
str='<option></option>';
for(i=0;i<alt_equals.length;i++)
str+='<option value="'+alt_equals[i].val+'">'+alt_equals[i].name+'</option>';
ekval.html(str);
ekval.removeAttr('disabled');
val.html('');
}else{
ekval.html('');
val.html('');
}
}

function SelectEkvalList(obj){
type=$(obj).parent().prev().children('select');
val=$(obj).parent().next();
if($(obj).val()!=''){
if((type.val()!='country_zone_id')&&(type.val()!='newsletter')&&(type.val()!='store')&&(type.val()!='')){
val.html('<input type="text" name="'+$(obj).attr('name').replace("[equal]", "[value]")+'" value="" class="form-control">');
}else if(type.val()=='newsletter'){
html='<label class="radio-inline"><input type="radio" name="'+$(obj).attr('name').replace("[equal]", "[value]")+'" value="1"><?php echo $entry_yes; ?></label>';
html+='<label class="radio-inline"><input type="radio" name="'+$(obj).attr('name').replace("[equal]", "[value]")+'" value="0" checked="checked"><?php echo $entry_no; ?></label>';
val.html(html);
}else if(type.val()=='country_zone_id'){
html='<select name="'+$(obj).attr('name').replace("[equal]", "[value_country]")+'" onchange="SelectCountry(this);" class="form-control country_val">';
<?php foreach ($umailchimp_countries as $country) { ?>
html+='<option value="<?php echo $country['country_id']; ?>"><?php echo str_replace("'", "\'", $country['name']); ?></option>';
<?php } ?>
html+='</select>';
html+='<select name="'+$(obj).attr('name').replace("[equal]", "[value_zone]")+'" class="form-control">';
html+='</select>';
val.html(html);
$('select[name="'+$(obj).attr('name').replace("[equal]", "[value_country]")+'"]').trigger('change');
}else if(type.val()=='store'){
html='<select name="'+$(obj).attr('name').replace("[equal]", "[value]")+'" class="form-control">';
<?php foreach ($umailchimp_stores as $store) { ?>
html+='<option value="<?php echo $store['store_id']; ?>"><?php echo str_replace("'", "\'", $store['name']); ?></option>';
<?php } ?>
html+='</select>';
val.html(html);
$('select[name="'+$(obj).attr('name').replace("[equal]", "[value_country]")+'"]').trigger('change');
}else{
val.html('');
}
}else{
val.html('');
}
}

function SelectCountry(obj){
	$.ajax({
		url: 'index.php?route=module/umailchimp/country&token=<?php echo $umailchimp_token; ?>&country_id=' + obj.value,
		dataType: 'json',
		success: function(json) {
			
			html = '<option value=""></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
					html += '<option value="' + json['zone'][i]['zone_id'] + '"';
					
					if (json['zone'][i]['zone_id'] == $(obj).attr('zone')) {
						html += ' selected="selected"';
					}
				
					html += '>' + json['zone'][i]['name'] + '</option>';
				}
			}
			
			$(obj).next('select').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
}

$('select.country_val').trigger('change');
//--></script>
<?php } ?>
			</div>
			<div class="tab-pane" id="tab-merge_tags">
			<div class="alert alert-info">
			<i class="fa fa-info-circle"></i> <?php echo $entry_info_merge_tags; ?>
			</div>
<style>
.vtabs {
	float: left;
	display: block;
	margin-bottom: 5px;
	margin-top: 5px;
    padding-left: 0;
    list-style: none;
}

.vtabs li{
font-family: 'Open Sans', sans-serif;
font-size: 12px;
}

.vtabs a {
	display: block;
	float: left;
	width: 160px;
	margin-bottom: 5px;
	clear: both;
	border: 1px solid #dddddd;
	padding: 10px 15px;
	text-align: left;
	text-decoration: none;
	color: #666666;
	margin-right: -1px;
	border-radius: 2px 0 0 2px;
	width: 200px;
}

.vtabs li a:hover {
background-color: #eeeeee;
}

.vtabs li.active a {
	font-weight: bold;
    color: #333;
	border: 1px solid #dddddd;
    border-right-color: transparent;
	cursor: default;
	background-color: #ffffff;
	
}

.vtabs-content {
	display: none;
	width: 100%;
}
.vtabs-content.active {
	display: inline-block;
}
.vtabs-container{
border-radius: 2px;
margin-left: 199px;
border: 1px solid #dddddd;
min-height: 100px;
padding: 15px;
}
</style>
			<ul class="vtabs">
			<?php foreach($umailchimp_lists as $key=>$list){ ?>
            <li <?php if($key==0){ ?>class="active"<?php } ?>><a href="#merge_list_<?php echo $list['id']; ?>" data-toggle="tab"><?php echo $list['name']; ?></a></li>
			<?php } ?>
          </ul>
		  <div class="vtabs-container"<?php if(count($umailchimp_lists)>0){ ?> style="min-height: <?php echo count($umailchimp_lists)*45+10; ?>px;"<?php } ?>>
		  <?php foreach($umailchimp_lists as $key=>$list){ ?>
		  <div id="merge_list_<?php echo $list['id']; ?>" class="vtabs-content<?php if($key==0){ ?> active<?php } ?>">
		  <h1><?php echo $entry_list; ?>: <?php echo $list['name']; ?></h1>
		  <?php foreach($list['fields'] as $key1=>$item){ ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="merge_<?php echo $list['id']; ?>_<?php echo $item['tag']; ?>"><?php echo $item['name']; ?></label>
            <div class="col-sm-7">
            <select name="umailchimp_merge_fields[<?php echo $list['id']; ?>][<?php echo $item['tag']; ?>]" id="merge_<?php echo $list['id']; ?>_<?php echo $item['tag']; ?>" class="form-control">
			<option></option>
			<?php foreach($umailchimp_m_fields as $field){ ?>
			<?php if((isset($umailchimp_merge_fields[$list['id']][$item['tag']]))&&($field['path']==$umailchimp_merge_fields[$list['id']][$item['tag']])){ ?>
			<option value="<?php echo $field['path']; ?>" selected="selected"><?php echo $field['name']; ?></option>
			<?php }elseif((!isset($umailchimp_merge_fields[$list['id']][$item['tag']]))&&($item['tag']=='FNAME')&&($field['path']=='firstname')){ ?>
			<option value="<?php echo $field['path']; ?>" selected="selected"><?php echo $field['name']; ?></option>
			<?php }elseif((!isset($umailchimp_merge_fields[$list['id']][$item['tag']]))&&($item['tag']=='LNAME')&&($field['path']=='lastname')){ ?>
			<option value="<?php echo $field['path']; ?>" selected="selected"><?php echo $field['name']; ?></option>
			<?php }else{ ?>
			<option value="<?php echo $field['path']; ?>"><?php echo $field['name']; ?></option>
			<?php } ?>
			<?php } ?>
			</select>
            </div>
          </div>
		  <?php } ?>
		  </div>
		  <?php } ?>
		  </div>
			</div>
		<div class="tab-pane" id="tab-subscribe">
		<div class="alert alert-info">
			<i class="fa fa-info-circle"></i> <?php echo $entry_info_module; ?>
			</div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-module_name"><?php echo $entry_module_name; ?></label>
            <div class="col-sm-7">
              <input type="text" name="umailchimp_module[name]" value="<?php if(isset($umailchimp_module['name'])){ ?><?php echo $umailchimp_module['name']; ?><?php } ?>" id="input-module_name" class="form-control" />
            </div>
          </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-module_list"><span data-toggle="tooltip" title="<?php echo $entry_info_module_list; ?>"><?php echo $entry_list; ?></span></label>
            <div class="col-sm-7">
            <select name="umailchimp_module[list]" id="input-module_list" class="form-control" onchange="checkModField();">
			<?php foreach($umailchimp_lists as $list) { ?>
			<option value="<?php echo $list['id']; ?>"<?php if((isset($umailchimp_module['list']))&&($list['id']==$umailchimp_module['list'])){ ?> selected="selected"<?php } ?>><?php echo $list['name']; ?></option>
			<?php } ?>
			</select>
            </div>
          </div>
		  	<div class="table-responsive">
                <table id="umailchimp_module_fields" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_module_merge; ?>"><?php echo $entry_merge_tag; ?></span></td>
					  <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_module_field; ?>"><?php echo $entry_field; ?></span></td>
					  <td class="text-left"><span data-toggle="tooltip" title="<?php echo $entry_info_module_type_field; ?>"><?php echo $entry_type_field; ?></span></td>
					  <td class="text-left" style="width: 240px;"><span data-toggle="tooltip" title="<?php echo $entry_info_module_name_field; ?>"><?php echo $entry_name; ?></span></td>
                      <td style="width: 60px;"></td>
                    </tr>
                  </thead>
				  <tbody>
				  <?php $module_field = 0; ?>
				  <?php if(isset($umailchimp_module['fields'])){ ?>
				  <?php foreach($umailchimp_module['fields'] as $k1=>$m_field){ ?>
				  <tr id="umailchimp_module_fields-row_<?php echo $module_field; ?>">
					<td>
					  <select name="umailchimp_module[fields][<?php echo $module_field; ?>][merge_field]" class="form-control mrg_sel">
					  <option value="email_address"<?php if($m_field['merge_field']=='email_address'){ ?> selected="selected"<?php } ?>><?php echo $entry_email; ?></option>
					  <?php 
					  $cur_list=$umailchimp_lists[0];
					  foreach($umailchimp_lists as $lst){
					  if($lst['id']==$umailchimp_module['list'])
					  $cur_list=$lst;
					  }
					  ?>
					  <?php foreach($cur_list['fields'] as $field){ ?>
					  <option value="<?php echo $field['tag']; ?>"<?php if($field['tag']==$m_field['merge_field']){ ?> selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
					  <?php } ?>
					  </select>
					</td>
					<td>
					<select name="umailchimp_module[fields][<?php echo $module_field; ?>][field]" class="form-control">
					<?php foreach($umailchimp_mod_fields as $mod_field){ ?>
					<option value="<?php echo $mod_field['path']; ?>"<?php if(($mod_field['path']==$m_field['field'])&&(isset($m_field['field']))){ ?> selected="selected"<?php } ?>><?php echo $mod_field['name']; ?></option>
					<?php } ?>
					</select>
					</td>
					<td>
						<select name="umailchimp_module[fields][<?php echo $module_field; ?>][type_field]" class="form-control">
						<option value="0"<?php if((isset($m_field['type_field']))&&($m_field['type_field']==0)){ ?> selected="selected"<?php } ?>></option>
						<option value="1"<?php if((isset($m_field['type_field']))&&($m_field['type_field']==1)){ ?> selected="selected"<?php } ?>><?php echo $entry_required; ?></option>
						<option value="2"<?php if((isset($m_field['type_field']))&&($m_field['type_field']==2)){ ?> selected="selected"<?php } ?>><?php echo $entry_hidden; ?></option>
						</select>
					</td>
					<td>
					
					<?php foreach ($languages as $key=>$language) { ?>
					<div class="input-group">
					<span class="input-group-addon">
					<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
					</span>
					<input type="text" class="form-control" style="width: 200px; display: inline-block;" name="umailchimp_module[fields][<?php echo $module_field; ?>][<?php echo $language['language_id']; ?>][name]" value="<?php echo $umailchimp_module['fields'][$k1][$language['language_id']]['name']; ?>">
					</div>
					
					<?php } ?>
					
					</td>
					<td class="text-center">
					<button type="button" onclick="$('#umailchimp_module_fields-row_<?php echo $module_field; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
					</td>
				  </tr>
				  <?php $module_field ++; ?>
				  <?php } ?>
				  <?php } ?>
                  </tbody>
				  <tfoot>
                    <tr>
                      <td colspan="4"></td>
                      <td class="text-center"><button type="button" onclick="addModField();" data-toggle="tooltip" title="<?php echo $entry_module_field; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
				</table>
			</div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-module_store"><?php echo $entry_store; ?></label>
            <div class="col-sm-7">
            <select name="umailchimp_module[store]" id="input-module_store" class="form-control">
			<?php foreach($umailchimp_stores as $list) { ?>
			<option value="<?php echo $list['store_id']; ?>"<?php if((isset($umailchimp_module['store']))&&($list['store_id']==$umailchimp_module['store'])){ ?> selected="selected"<?php } ?>><?php echo $list['name']; ?></option>
			<?php } ?>
			</select>
            </div>
          </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_popup; ?><?php echo $entry_popup_link; ?></label>
            <div class="col-sm-7">
            <label class="radio-inline">
            <input type="radio" name="umailchimp_module[popup]" value="1"<?php if((isset($umailchimp_module['popup']))&&($umailchimp_module['popup']==1)){ ?> checked="checked"<?php } ?>>
            <?php echo $entry_yes; ?></label>
			<label class="radio-inline">
            <input type="radio" name="umailchimp_module[popup]" value="0"<?php if((!isset($umailchimp_module['popup']))||($umailchimp_module['popup']==0)){ ?> checked="checked"<?php } ?>>
            <?php echo $entry_no; ?></label>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_title; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_title][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_title'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_title'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_top; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_top][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_top'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_top'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_button; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_button][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_button'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_button'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_button_loading; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_button_loading][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_button_loading'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_button_loading'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_empty; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_empty][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_empty'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_empty'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_wrong_email; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_wrong_email][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_wrong_email'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_wrong_email'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_success; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_success][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_success'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_success'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_already; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="umailchimp_module[form_already][<?php echo $language['language_id']; ?>]" value="<?php if(isset($umailchimp_module['form_already'][$language['language_id']])){ ?><?php echo $umailchimp_module['form_already'][$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-7">
              <select name="umailchimp_module[status]" id="input-status" class="form-control">
                <?php if ((isset($umailchimp_module['status']))&&($umailchimp_module['status'])) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
		</div>
		<div class="tab-pane" id="tab-logs">
		<div class="well">
          <div class="row" id="log_filters">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="col-sm-6 control-label" for="log_filter_title"><?php echo $entry_log_filter_title; ?></label>
			<div class="col-sm-6">
              <select name="log_filter_title" id="log_filter_title" class="form-control" onchange="FilterLogs();">
                <option value=""></option>
                <?php foreach($log_filter_titles as $item){ ?>
				<option value="<?php echo $item; ?>"><?php echo $item; ?></option>
				<?php } ?>
              </select>
            </div>
              </div>
            </div>
            <div class="col-sm-3">
            <div class="form-group">
                <label class="col-sm-6 control-label" for="log_filter_status"><?php echo $entry_log_filter_status; ?></label>
			<div class="col-sm-6">
              <select name="log_filter_status" id="log_filter_status" class="form-control" onchange="FilterLogs();">
                <option value=""></option>
                <?php foreach($log_filter_statuses as $item){ ?>
				<option value="<?php echo $item; ?>"><?php echo $item; ?></option>
				<?php } ?>
              </select>
            </div>
				</div>
            </div>
			<div class="col-sm-3">
            <div class="form-group">
                <label class="col-sm-6 control-label" for="log_filter_type"><?php echo $entry_log_type; ?></label>
			<div class="col-sm-6">
              <select name="log_filter_type" id="log_filter_type" class="form-control" onchange="FilterLogs();">
                <option value=""></option>
                <?php foreach($log_filter_types as $item){ ?>
				<option value="<?php echo $item; ?>"><?php echo $item; ?></option>
				<?php } ?>
              </select>
            </div>
				</div>
            </div>
            <div class="col-sm-3">
			<button type="button" data-toggle="tooltip" title="" onclick="ClearLogs();" class="btn btn-danger pull-right" style="margin-left: 10px;">
				<i class="fa fa-trash-o"></i> <?php echo $entry_clear_logs; ?>
			  </button>
              <button type="button" id="button-filter" class="btn btn-primary pull-right" onclick="$('#log_filters select[name=log_filter_title]').val(''); $('#log_filters select[name=log_filter_status]').val(''); $('#log_filters select[name=log_filter_type]').val(''); FilterLogs();"><i class="fa fa-eraser"></i> <?php echo $entry_log_filter_clear_button; ?></button>
			  
			</div>
          </div>
        </div>
		<table class="table table-bordered table-hover" id="logs_table">
              <thead>
                <tr>
                  <td class="text-left"><?php echo $entry_log_filter_title; ?></td>
                  <td class="text-left"><?php echo $entry_log_filter_status; ?></td>
				  <td class="text-left"><?php echo $entry_log_type; ?></td>
				  <td class="text-left"><?php echo $entry_log_email; ?></td>
				  <td class="text-left"><?php echo $entry_log_merge_fields; ?></td>
				  <td class="text-left"><?php echo $entry_log_details; ?></td>
				  
				  <td class="text-left"><?php echo $entry_log_date; ?></td>
				  <td class="text-center"></td>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
		</div>
<script type="text/javascript"><!--
var queryLogs='';
var inProgress = false;
var startFromLogs = 0;
var endFromLogs = <?php echo ceil($logs_count/20)-1; ?>;
$(document).ready(function(){
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress && startFromLogs<=endFromLogs && $('#tab-logs').hasClass('active')) {
        showLogs();
        }
    });
	
	$('#logs_links').click(function(){
	if(startFromLogs==0)
	showLogs();
	});
	
});

function showLogs(){
$.ajax({
            url: 'index.php?route=module/umailchimp/lines_logs&token=<?php echo $umailchimp_token; ?>'+queryLogs,
            method: 'POST',
            data: {"startFrom" : startFromLogs},
            beforeSend: function() {
            inProgress = true;}
            }).done(function(data){
            if (data.length > 0) {
            $.each(data, function(index, data){
			html='<tr style="background-color: '+data.color+'">';
            html+='<td class="text-left">'+data.title+'</td>';
            html+='<td class="text-left">'+data.status+'</td>';
			html+='<td class="text-left">'+data.type+'</td>';
			if((data.type=='synchronize')&&(data.email!='')){
			html+='<td class="text-left"></td>';
			}else{
			html+='<td class="text-left">'+data.email+'</td>';
			}
			html+='<td class="text-left">'+data.merge_fields+'</td>';
			html+='<td class="text-left">'+data.detail+'</td>';
			html+='<td class="text-left">'+data.date_added+'</td>';
            html+='<td class="text-center">';
			if((data.type=='synchronize')&&(data.email!='')){
			html+='<button type="button" data-toggle="tooltip" title="" class="btn btn-primary" onclick="RefreshBatch(\''+data.log_id+'\', \''+data.email+'\', this);">';
			html+='<i class="fa fa-refresh"></i> <?php echo $entry_refresh; ?>';
			html+='</button>';
			}
			html+='</td>';
            html+='</tr>';
			$('#logs_table tbody').append(html);
            });
            inProgress = false;
            startFromLogs++;
            }});
}

function FilterLogs(){
str='';
if($('#log_filters select[name=log_filter_title]').val()!='')
str+='&title='+$('#log_filters select[name=log_filter_title]').val();
if($('#log_filters select[name=log_filter_status]').val()!='')
str+='&status='+$('#log_filters select[name=log_filter_status]').val();
if($('#log_filters select[name=log_filter_type]').val()!='')
str+='&type='+$('#log_filters select[name=log_filter_type]').val();
queryLogs=str;
CountLogs();
$('#logs_table tbody').html('');
showLogs();
}

function CountLogs(){
$.ajax({
		url: 'index.php?route=module/umailchimp/count_logs&token=<?php echo $umailchimp_token; ?>' + queryLogs,
		dataType: 'json',
		async: false,
		success: function(json) {
			inProgress = false;
			startFromLogs = 0;
			endFromLogs = json['count'];
		}
	});
}

function ClearLogs(){
$.ajax({
		url: 'index.php?route=module/umailchimp/clear_logs&token=<?php echo $umailchimp_token; ?>',
		async: false,
		success: function(msg) {
		}
	});
CountLogs();
$('#logs_table tbody').html('');
showLogs();
}

function RefreshBatch(id, batch, obj){
line=$(obj).parent().parent();
$.ajax({
		url: 'index.php?route=module/umailchimp/checkbatch&token=<?php echo $umailchimp_token; ?>',
		method: 'POST',
		data: 'id='+id+'&batch='+batch,
		success: function(data) {
            html='<td class="text-left">'+data.title+'</td>';
            html+='<td class="text-left">'+data.status+'</td>';
			html+='<td class="text-left">'+data.type+'</td>';
			if((data.type=='synchronize')&&(data.email!='')){
			html+='<td class="text-left"></td>';
			}else{
			html+='<td class="text-left">'+data.email+'</td>';
			}
			html+='<td class="text-left">'+data.merge_fields+'</td>';
			html+='<td class="text-left">'+data.detail+'</td>';
			html+='<td class="text-left">'+data.date_added+'</td>';
            html+='<td class="text-center">';
			if((data.type=='synchronize')&&(data.email!='')){
			html+='<button type="button" data-toggle="tooltip" title="" class="btn btn-primary" onclick="RefreshBatch(\''+data.log_id+'\', \''+data.email+'\', this);">';
			html+='<i class="fa fa-refresh"></i> <?php echo $entry_refresh; ?>';
			html+='</button>';
			}
			html+='</td>';
		line.html(html);
		}
	});
}
//--></script>
		  </div>
<script type="text/javascript"><!--
<?php foreach($umailchimp_lists as $key=>$items){ ?>
var arr_<?php echo $items['id']; ?> = new Array();
<?php foreach($items['fields'] as $key1=>$item){ ?>
arr_<?php echo $items['id']; ?>[<?php echo $key1; ?>]=new Array('<?php echo $item['tag']; ?>', '<?php echo $item['name']; ?>');
<?php } ?>
<?php } ?>
module_field=<?php echo $module_field; ?>;
function addModField() {
    html  = '<tr id="umailchimp_module_fields-row_'+module_field+'">';
	html += '<td><select name="umailchimp_module[fields]['+module_field+'][merge_field]" class="form-control mrg_sel">';
	arr=eval('arr_'+$('#input-module_list').val());
	html += '<option value="email_address"><?php echo $entry_email; ?></option>';
	for(i=0;i<arr.length;i++){
	html += '<option value="'+arr[i][0]+'">'+arr[i][1]+'</option>';
	}
	html += '</select></td><td>';
	html += '<select name="umailchimp_module[fields]['+module_field+'][field]" class="form-control">';
	<?php foreach($umailchimp_mod_fields as $mod_field){ ?>
	html += '<option value="<?php echo $mod_field['path']; ?>"><?php echo $mod_field['name']; ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td><select name="umailchimp_module[fields]['+module_field+'][type_field]" class="form-control">';
	html += '<option value="0"></option>';
	html += '<option value="1"><?php echo $entry_required; ?></option>';
	html += '<option value="2"><?php echo $entry_hidden; ?></option>';
	html += '</select></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>';
	html += '<input type="text" class="form-control" style="width: 200px; display: inline-block;" name="umailchimp_module[fields]['+module_field+'][<?php echo $language['language_id']; ?>][name]" value="">';
	html += '</div>';
	<?php } ?>
	html += '</td><td class="text-center">';
	html += '<button type="button" onclick="$(\'#umailchimp_module_fields-row_'+module_field+'\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';
	html += '</td></tr>';
	
	$('#umailchimp_module_fields tbody').append(html);
	module_field++;
}

function checkModField() {
	arr=eval('arr_'+$('#input-module_list').val());
	html='<option value="email_address"><?php echo $entry_email; ?></option>';
	for(i=0;i<arr.length;i++){
	html += '<option value="'+arr[i][0]+'">'+arr[i][1]+'</option>';
	}
	$('.mrg_sel').each(function(){
	$(this).html(html);
	});
}
//--></script>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
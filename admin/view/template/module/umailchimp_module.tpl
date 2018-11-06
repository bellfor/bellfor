<?php echo $header; ?>
<?php echo $column_left; ?>
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

		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-module_name"><?php echo $entry_module_name; ?></label>
            <div class="col-sm-7">
              <input type="text" name="name" value="<?php if(isset($name)){ ?><?php echo $name; ?><?php } ?>" id="input-module_name" class="form-control" />
			  <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-module_list"><span data-toggle="tooltip" title="<?php echo $entry_info_module_list; ?>"><?php echo $entry_list; ?></span></label>
            <div class="col-sm-7">
            <select name="list" id="input-module_list" class="form-control" onchange="checkModField();">
			<?php foreach($umailchimp_lists as $lst) { ?>
			<option value="<?php echo $lst['id']; ?>"<?php if((isset($list))&&($lst['id']==$list)){ ?> selected="selected"<?php } ?>><?php echo $lst['name']; ?></option>
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
				  <?php if(isset($fields)){ ?>
				  <?php foreach($fields as $k1=>$m_field){ ?>
				  <tr id="umailchimp_module_fields-row_<?php echo $module_field; ?>">
					<td>
					  <select name="fields[<?php echo $module_field; ?>][merge_field]" class="form-control mrg_sel">
					  <option value="email_address"<?php if($m_field['merge_field']=='email_address'){ ?> selected="selected"<?php } ?>><?php echo $entry_email; ?></option>
					  <?php 
					  $cur_list=$umailchimp_lists[0];
					  foreach($umailchimp_lists as $lst){
					  if($lst['id']==$list)
					  $cur_list=$lst;
					  }
					  ?>
					  <?php foreach($cur_list['fields'] as $field){ ?>
					  <option value="<?php echo $field['tag']; ?>"<?php if($field['tag']==$m_field['merge_field']){ ?> selected="selected"<?php } ?>><?php echo $field['name']; ?></option>
					  <?php } ?>
					  </select>
					</td>
					<td>
					<select name="fields[<?php echo $module_field; ?>][field]" class="form-control">
					<?php foreach($umailchimp_mod_fields as $mod_field){ ?>
					<option value="<?php echo $mod_field['path']; ?>"<?php if(($mod_field['path']==$m_field['field'])&&(isset($m_field['field']))){ ?> selected="selected"<?php } ?>><?php echo $mod_field['name']; ?></option>
					<?php } ?>
					</select>
					</td>
					<td>
						<select name="fields[<?php echo $module_field; ?>][type_field]" class="form-control">
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
					<input type="text" class="form-control" style="width: 200px; display: inline-block;" name="fields[<?php echo $module_field; ?>][<?php echo $language['language_id']; ?>][name]" value="<?php if(isset($fields[$k1][$language['language_id']]['name'])){ ?><?php echo $fields[$k1][$language['language_id']]['name']; ?><?php } ?>">
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
            <select name="store" id="input-module_store" class="form-control">
			<?php foreach($umailchimp_stores as $list) { ?>
			<option value="<?php echo $list['store_id']; ?>"<?php if((isset($store))&&($list['store_id']==$store)){ ?> selected="selected"<?php } ?>><?php echo $list['name']; ?></option>
			<?php } ?>
			</select>
            </div>
          </div>
		 <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_popup; ?></label>
            <div class="col-sm-7">
            <label class="radio-inline">
            <input type="radio" name="popup" value="1"<?php if((isset($popup))&&($popup==1)){ ?> checked="checked"<?php } ?>>
            <?php echo $entry_yes; ?></label>
			<label class="radio-inline">
            <input type="radio" name="popup" value="0"<?php if((!isset($popup))||($popup==0)){ ?> checked="checked"<?php } ?>>
            <?php echo $entry_no; ?></label>
			<div style="color: #666; font-size: 11px; font-weight: normal; padding-top: 2px;"><?php echo $entry_popup_link_edit; ?><div style="color: #007F0E; display: inline-block;"><?php echo htmlspecialchars('<a class="popup-modal" href="#umailchimp_form_'.$_GET['module_id'].'">Open form</a>'); ?></div></div>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_form_title; ?></label>
            <div class="col-sm-7">
            <?php foreach ($languages as $key=>$language) { ?>
			<div class="input-group">
			<span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>
			<input type="text" class="form-control" name="form_title[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_title[$language['language_id']])){ ?><?php echo $form_title[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_top[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_top[$language['language_id']])){ ?><?php echo $form_top[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_button[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_button[$language['language_id']])){ ?><?php echo $form_button[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_button_loading[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_button_loading[$language['language_id']])){ ?><?php echo $form_button_loading[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_empty[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_empty[$language['language_id']])){ ?><?php echo $form_empty[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_wrong_email[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_wrong_email[$language['language_id']])){ ?><?php echo $form_wrong_email[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_success[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_success[$language['language_id']])){ ?><?php echo $form_success[$language['language_id']]; ?><?php } ?>">
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
			<input type="text" class="form-control" name="form_already[<?php echo $language['language_id']; ?>]" value="<?php if(isset($form_already[$language['language_id']])){ ?><?php echo $form_already[$language['language_id']]; ?><?php } ?>">
			</div>
			<?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-7">
              <select name="status" id="input-status" class="form-control">
                <?php if ((isset($status))&&($status)) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
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
	html += '<td><select name="fields['+module_field+'][merge_field]" class="form-control mrg_sel">';
	arr=eval('arr_'+$('#input-module_list').val());
	html += '<option value="email_address"><?php echo $entry_email; ?></option>';
	for(i=0;i<arr.length;i++){
	html += '<option value="'+arr[i][0]+'">'+arr[i][1]+'</option>';
	}
	html += '</select></td><td>';
	html += '<select name="fields['+module_field+'][field]" class="form-control">';
	<?php foreach($umailchimp_mod_fields as $mod_field){ ?>
	html += '<option value="<?php echo $mod_field['path']; ?>"><?php echo $mod_field['name']; ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '<td><select name="fields['+module_field+'][type_field]" class="form-control">';
	html += '<option value="0"></option>';
	html += '<option value="1"><?php echo $entry_required; ?></option>';
	html += '<option value="2"><?php echo $entry_hidden; ?></option>';
	html += '</select></td>';
	html += '<td>';
	<?php foreach ($languages as $language) { ?>
	html += '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></span>';
	html += '<input type="text" class="form-control" style="width: 200px; display: inline-block;" name="fields['+module_field+'][<?php echo $language['language_id']; ?>][name]" value="">';
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
<?php
/*
@Date:   Thursday, November 9th 2017, 3:20:26 pm
@Email:  oleg@webiprog.com
@Project: tooltiplabels
@Filename: tooltiplabels_form.tpl
@Last modified by:   Oleg
@Last modified time: Thursday, November 9th 2017, 4:16:38 pm
@License: free
@Copyright: webiprog.com
*/
echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-tooltiplabel" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-tooltiplabel" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active in" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="tooltiplabel_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($tooltiplabel_description[$language['language_id']]) ? $tooltiplabel_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="hidden form-group">
                    <label class="col-sm-2 control-label" for="input-names<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_names; ?>"><?php echo $entry_names; ?></span></label>
                    <div class="col-sm-10">
                      <input type="text" name="tooltiplabel_description[<?php echo $language['language_id']; ?>][name_short]" value="<?php echo isset($tooltiplabel_description[$language['language_id']]) ? $tooltiplabel_description[$language['language_id']]['name_short'] : ''; ?>" placeholder="<?php echo $entry_names; ?>" id="input-names<?php echo $language['language_id']; ?>" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_description_top; ?>"><?php echo $entry_description_top; ?></span></label>
                    <div class="col-sm-10">
                      <textarea name="tooltiplabel_description[<?php echo $language['language_id']; ?>][description_top]" placeholder="<?php echo $entry_description_top; ?>" id="input-description-top<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($tooltiplabel_description[$language['language_id']]) ? $tooltiplabel_description[$language['language_id']]['description_top'] : ''; ?></textarea>
                    </div>
                  </div>

                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane fade" id="tab-data">

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
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
          </div>
        </form>
      </div>
    </div>
  </div>


  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>

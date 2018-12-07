<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
            <li><a href="#tab-custom-links" data-toggle="tab">Custom link footer</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
                      <?php if (isset($error_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_h1[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_h1[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $information_store)) { ?>
                        <input type="checkbox" name="information_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="information_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $information_store)) { ?>
                        <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($bottom) { ?>
                      <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                      <?php } else { ?>
                      <input type="checkbox" name="bottom" value="1" id="input-bottom" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-consultant"><?php echo $entry_consultant; ?></label>
                    <div class="col-sm-10">
                        <select name="status_consultant" id="input-consultant" class="form-control">
                            <?php if ($status_consultant) { ?>
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
                    <label class="col-sm-2 control-label" for="input-race"><span data-toggle="tooltip" title="<?php echo $help_race; ?>"><?php echo $entry_race; ?></label>
                    <div class="col-sm-10">
                        <select name="race_id" id="input-race" class="form-control">
                            <?php if (isset($choose_race)){?>
                                <option value="<?php echo $choose_race['race_id'];?>" selected="selected"><?php echo $choose_race['race'];?></option>
                                <?php foreach ($race_dogs as $race_dog){ ?>
                                    <option value="<?php echo $race_dog['race_id'];?>"><?php echo $race_dog['race'];?></option>
                                <?php } ?>
                            <?php } else { ?>
                                <option value="0" selected="selected"><?php echo $select_race;?></option>
                                <?php foreach ($race_dogs as $race_dog){ ?>
                                    <option value="<?php echo $race_dog['race_id'];?>"><?php echo $race_dog['race'];?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        <?php if ($error_race) { ?>
                            <div class="text-danger"><?php echo $error_race; ?></div>
                        <?php } ?>
                    </div>
                </div>
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
			  <div class="form-group">
                <label class="col-sm-2 control-label" for="input-noindex"><span data-toggle="tooltip" title="<?php echo $help_noindex; ?>"><?php echo $entry_noindex; ?></span></label>
                <div class="col-sm-10">
                  <select name="noindex" id="input-noindex" class="form-control">
                    <?php if ($noindex) { ?>
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
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="information_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="information_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
              <div class="tab-pane" id="tab-custom-links">
                  <div class="form-group">
                      <ul class="nav nav-tabs" id="language-custom-link">
                          <?php foreach ($languages as $language) { ?>
                              <li><a href="#language-custom-link<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                          <?php } ?>
                      </ul>
                      <div class="tab-content">
                          <?php foreach ($languages as $language) { ?>
                              <div class="tab-pane" id="language-custom-link<?php echo $language['language_id']; ?>">
                                  <div class="table-responsive">
                                      <table id="custom-links<?php echo $language['language_id']; ?>" class="table table-striped table-bordered table-hover">
                                          <thead>
                                          <tr>
                                              <td class="text-left">Name Link</td>
                                              <td class="text-left">Link</td>
                                              <td></td>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php $custom_link_row = 0; ?>
                                          <?php foreach ($custom_links[$language['language_id']] as $custom_link) { ?>
                                              <tr class="custom-link<?php echo $language['language_id']; ?>" id="custom_link_row<?php echo $custom_link_row; ?>_<?php echo $language['language_id']; ?>">
                                                  <td class="text-left" style="width: 40%;">
                                                      <input type="text" name="custom_links[<?php echo $language['language_id']; ?>][<?php echo $custom_link_row; ?>][name]" value="<?php echo $custom_link['name']; ?>" placeholder="Enter name link" class="form-control" />
                                                  </td>
                                                  <td class="text-left">
                                                      <div class="input-group">
                                                          <input name="custom_links[<?php echo $language['language_id']; ?>][<?php echo $custom_link_row; ?>][href]" maxlength="120" value="<?php echo $custom_link['href']; ?>" placeholder="Enter link" class="form-control">
                                                      </div>
                                                  </td>
                                                  <td class="text-left"><button type="button" onclick="$('#custom_link_row<?php echo $custom_link_row; ?>_<?php echo $language['language_id']; ?>').remove();" data-toggle="tooltip" title="Delete link" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                              </tr>
                                              <?php $custom_link_row++; ?>
                                          <?php } ?>
                                          </tbody>
                                          <tfoot>
                                          <tr>
                                              <td colspan="2"></td>
                                              <td class="text-left"><button id="button-add-row<?php echo $language['language_id']; ?>" type="button" onclick="addCustomLinkRow(<?php echo $language['language_id']; ?>, <?php echo $custom_link_row; ?>);" data-toggle="tooltip" title="Added custom link" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                          </tr>
                                          </tfoot>
                                      </table>
                                  </div>
                              </div>
                          <?php } ?>
                      </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
    <script type="text/javascript">
        function addCustomLinkRow(language_id, custom_link_row) {
            html = '';
            html += '<tr class="custom-link' + language_id + '" id="custom_link_row' + custom_link_row + '_' + language_id + '">';
            html += '  <td class="text-left" style="width: 20%;"><input type="text" name="custom_links[' + language_id + '][' + custom_link_row + '][name]" value="" placeholder="Enter name link" class="form-control" /></td>';
            html += '  <td class="text-left">';
            html += '<div class="input-group"><input name="custom_links[' + language_id + '][' + custom_link_row + '][href]" maxlength="120" value="" placeholder="Enter link" class="form-control"></div>';
            html += '  </td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#custom_link_row' + custom_link_row + '_'+language_id+'\').remove(); minus('+custom_link_row+');" data-toggle="tooltip" title="Delete link" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            if (($('.custom-link' + language_id).size() + 1) <= 15){
                $('#custom-links' + language_id + ' tbody ').append(html);
                custom_link_row++;
                $('#button-add-row' + language_id).replaceWith('<button id="button-add-row'+language_id+'" type="button" onclick="addCustomLinkRow('+language_id+', '+custom_link_row+');" data-toggle="tooltip" title="Added custom link" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>');
            }else{
                return false;
            }
        }
    </script>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({
	height: 300
});
<?php } ?>
//--></script>
  <script type="text/javascript"><!--
$('#language-custom-link a:first').tab('show');
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>
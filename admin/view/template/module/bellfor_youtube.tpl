<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">

	<div class="page-header">
      <div class="pull-right">
        <button type="submit" form="form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>

	    <h1><img src="view/image/module.png" alt="" /><?php echo $heading_title; ?></h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>

	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } elseif (!empty($success)) {  ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>

<div class="container-fluid">

  <div class="content">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">

    <table id="module" class="table-fill slist">
    <thead>
        <tr>
         <th class="left"><?php echo $entry_code; ?></th>
         <th class="left"><?php echo $entry_status; ?></th>
         <th class="right"><?php echo $entry_sort_order; ?></th>
         <th class="left"></th>
        </tr>
    </thead>
      <?php $module_row = 0; ?>
      <?php foreach ($modules as $module) { ?>
        <tbody id="module-row<?php echo $module_row; ?>">
        <tr>
        <td width="25%" class="left"><input type="text" name="bellfor_youtube_<?php echo $module_row; ?>_code" value="<?php echo ${'bellfor_youtube_' . $module . '_code'}; ?>" size="40" />
		</td>

        <td class="left"><select name="bellfor_youtube_<?php echo $module_row; ?>_status">
                <?php if (${'bellfor_youtube_' . $module . '_status'}) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
         <td class="right"><input type="text" name="bellfor_youtube_<?php echo $module_row; ?>_sort_order" value="<?php echo ${'bellfor_youtube_' . $module . '_sort_order'}; ?>" size="3" /></td>

         <td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="btn btn-danger"><span><?php echo $button_remove; ?></span></a></td>
        </tr>
        </tr>
        </tbody>
      <?php $module_row++; ?>
      <?php } ?>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td class="left"><a onclick="addModule();" class="btn btn-default"><span><?php echo $button_add_module; ?></span></a></td>
    </tr>
    <tr class="noborder">
        <td colspan="4"></td>
    </tr>
    <tr class="noborder">
        <td colspan="4"><?php echo $entry_help ; ?></td>
    </tr>
    <tr class="noborder">
        <td colspan="4"></td>
    </tr>
    <tr class="noborder">
        <td colspan="4">
		<div class="row">
		<label class="col-sm-3 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-7">
              <select name="bellfor_youtube_status" id="input-status" class="form-control">
                <?php if ($bellfor_youtube_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div></td>
    </tr>

    </tfoot>
    </table>
     <input type="hidden" name="bellfor_youtube_module" value="<?php echo $bellfor_youtube_module; ?>" />
    </form>
  </div>
</div>
<script type="text/javascript"><!--
var module_row = <?php echo $module_row; ?>;

function addModule() {
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
    html += '    <td width="25%" class="left"><input type="text" name="bellfor_youtube_' + module_row +'_code" value="" size="40" /></td>';
	html += '    <td class="left"><select name="bellfor_youtube_' + module_row + '_status">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="bellfor_youtube_' + module_row + '_sort_order" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="btn btn-danger"><span><?php echo $button_remove; ?></span></a></td>';
	html += '  </tr>';
	html += '</tbody>';

	$('#module tfoot').before(html);

	module_row++;
}

$('#form').bind('submit', function() {
	var module = new Array();

	$('#module tbody').each(function(index, element) {
		module[index] = $(element).attr('id').substr(10);
	});

	$('input[name=\'bellfor_youtube_module\']').attr('value', module.join(','));
});
//--></script>
<style type="text/css"><!--
/*** Table Styles **/

.table-fill { background: white; border-radius:1px; border-collapse: collapse; margin: auto; max-width: 1024px; padding:5px; width: 100%; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); }

.table-fill th { color:#D5DDE5;; background:#1b1e24; border-bottom:4px solid #9ea7af; border-right: 1px solid #343a45; font-size:15px; font-weight: 500; padding:10px 15px; text-align:left; vertical-align:middle; }

.table-fill th:first-child { border-top-left-radius:1px; }

.table-fill th:last-child { border-top-right-radius:1px; border-right:none; }

.table-fill tr.noborder td{ border: none !important; }

.table-fill tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; color:#666B85; font-size:13px; font-weight:normal; /*text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);*/ }

.table-fill tr:first-child { border-top:none; }

.table-fill tr:last-child { border-bottom:none; }

.table-fill tr:nth-child(odd) td { background:#EBEBEB; }

.table-fill tr:last-child td:first-child { border-bottom-left-radius:1px; }

.table-fill tr:last-child td:last-child { border-bottom-right-radius:1px; }

.table-fill td { background:#FFFFFF; padding:10px 15px; text-align:left; vertical-align:middle; font-weight:300; font-size:13px; /*text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);*/ border-right: 1px solid #C1C3D1; }

.table-fill td:last-child { border-right: 0px; }

.table-fill th.text-left { text-align: left; }

.table-fill th.text-center { text-align: center; }

.table-fill th.text-right { text-align: right; }

.table-fill td.text-left { text-align: left; }

.table-fill td.text-center { text-align: center; }

.table-fill td.text-right { text-align: right; }
--></style>
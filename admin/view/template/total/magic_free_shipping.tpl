<?php

/**
 * OpenCart Ukrainian Community
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email

 *
 * @category   OpenCart
 * @package    Magic Free Shipping
 * @copyright  Copyright (c) 2015 Eugene Lifescale a.k.a. Shaman by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

?>
<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-store" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-store" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="magic_free_shipping_status" id="input-status" class="form-control">
                <?php if ($magic_free_shipping_status) { ?>
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
              <input type="text" name="magic_free_shipping_sort_order" value="<?php echo $magic_free_shipping_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>

          <table id="magic_free_shipping" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php echo $text_min_product_qty; ?></td>
                <td class="text-left"><?php echo $text_min_order_cost; ?></td>
                <td class="text-left"><?php echo $text_geo_zone; ?></td>
                <td></td>
              </tr>
            </thead>
            <?php $magic_free_shipping_row = 0; ?>
            <?php foreach ($magic_free_shipping_rates as $magic_free_shipping_rate) { ?>
              <tbody id="magic_free_shipping-row<?php echo $magic_free_shipping_row; ?>">
                <tr>
                  <td class="text-left">
                    <input type="text" name="magic_free_shipping_rates[<?php echo $magic_free_shipping_row; ?>][min_product_qty]" value="<?php echo $magic_free_shipping_rate['min_product_qty']; ?>" size="3" class="form-control" />
                  </td>
                  <td class="text-left">
                    <input type="text" name="magic_free_shipping_rates[<?php echo $magic_free_shipping_row; ?>][min_order_cost]" value="<?php echo $magic_free_shipping_rate['min_order_cost']; ?>" size="3" class="form-control" />
                  </td>
                  <td class="text-left">
                    <select name="magic_free_shipping_rates[<?php echo $magic_free_shipping_row ?>][geo_zone_id]" class="form-control">
                      <?php foreach ($geo_zones as $geo_zone) { ?>
                        <option value="<?php echo $geo_zone['geo_zone_id'] ?>" <?php echo ($magic_free_shipping_rate['geo_zone_id'] == $geo_zone['geo_zone_id'] ? 'selected="selected"' : false) ?>><?php echo $geo_zone['name'] ?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td class="text-left">
                    <button type="button" onclick="$('#magic_free_shipping-row<?php echo $magic_free_shipping_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                  </td>
                </tr>
              </tbody>
            <?php $magic_free_shipping_row++; ?>
            <?php } ?>
            <tfoot>
              <tr>
                <td colspan="3"></td>
                <td class="text-left">
                  <button type="button" onclick="addRate();" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>
                </td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
    <div style="text-align:center"><?php echo $text_copyright; ?></div>
  </div>
</div>


<script type="text/javascript"><!--
var magic_free_shipping_row = <?php echo $magic_free_shipping_row; ?>;

function addRate() {
  html  = '<tbody id="magic_free_shipping-row' + magic_free_shipping_row + '">';
  html += '<tr>';
  html += '  <td class="text-left"><input type="text" name="magic_free_shipping_rates[' + magic_free_shipping_row + '][min_product_qty]" value="" size="3" class="form-control" /></td>';
  html += '  <td class="text-left"><input type="text" name="magic_free_shipping_rates[' + magic_free_shipping_row + '][min_order_cost]" value="" size="3" class="form-control" /></td>';
  html += '  <td class="text-left">';
  html += '  <select name="magic_free_shipping_rates[' + magic_free_shipping_row + '][geo_zone_id]" class="form-control">';
  <?php foreach ($geo_zones as $geo_zone) { ?>
  html += '<option value="<?php echo $geo_zone["geo_zone_id"] ?>"><?php echo $geo_zone["name"] ?></option>';
  <?php } ?>
  html += '  </select>';
  html += '  </td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#magic_free_shipping-row' + magic_free_shipping_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  html += '</tbody>';

	$('#magic_free_shipping tfoot').before(html);

	magic_free_shipping_row++;
}


//--></script>

<?php echo $footer; ?>

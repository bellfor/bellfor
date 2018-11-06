<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-sisowvvv" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-register" data-toggle="tab"><?php echo $tab_register; ?></a></li>
            <li><a href="#tab-support" data-toggle="tab"><?php echo $tab_support; ?></a></li>
          </ul>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sisowvvv" class="form-horizontal">
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-merchantid"><span data-toggle="tooltip" title="<?php echo $help_merchantid; ?>"><?php echo $entry_merchantid; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="sisowvvv_merchantid" value="<?php echo $sisowvvv_merchantid; ?>" placeholder="<?php echo $entry_merchantid; ?>" id="input-merchantid" class="form-control" />
              <?php if ($error_merchantid) { ?>
              <div class="text-danger"><?php echo $error_merchantid; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-merchantkey"><span data-toggle="tooltip" title="<?php echo $help_merchantkey; ?>"><?php echo $entry_merchantkey; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="sisowvvv_merchantkey" value="<?php echo $sisowvvv_merchantkey; ?>" placeholder="<?php echo $entry_merchantkey; ?>" id="input-merchantkey" class="form-control" />
              <?php if ($error_merchantkey) { ?>
              <div class="text-danger"><?php echo $error_merchantkey; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-shopid"><span data-toggle="tooltip" title="<?php echo $help_shopid; ?>"><?php echo $entry_shopid; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="sisowvvv_shopid" value="<?php echo $sisowvvv_shopid; ?>" placeholder="<?php echo $entry_shopid; ?>" id="input-shopid" class="form-control" />
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-success"><span data-toggle="tooltip" title="<?php echo $help_order_status; ?>"><?php echo $entry_success; ?></span></label>
            <div class="col-sm-10">
              <select name="sisowvvv_status_success" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $sisowvvv_status_success) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-testmode"><?php echo $entry_testmode; ?></label>
            <div class="col-sm-10">
              <select name="sisowvvv_testmode" id="input-status" class="form-control">
                <?php if ($sisowvvv_testmode == "true") { ?>
                <option value="true" selected="selected"><?php echo $text_yes; ?></option>
                <option value="false"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="true"><?php echo $text_yes; ?></option>
                <option value="false" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="sisowvvv_total" value="<?php echo $sisowvvv_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-totalmax"><span data-toggle="tooltip" title="<?php echo $help_totalmax; ?>"><?php echo $entry_totalmax; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="sisowvvv_totalmax" value="<?php echo $sisowvvv_totalmax; ?>" placeholder="<?php echo $entry_totalmax; ?>" id="input-totalmax" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?></label>
            <div class="col-sm-10">
              <select name="sisowvvv_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $sisowvvv_geo_zone_id) { ?>
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
              <select name="sisowvvv_status" id="input-status" class="form-control">
                <?php if ($sisowvvv_status) { ?>
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
              <input type="text" name="sisowvvv_sort_order" value="<?php echo $sisowvvv_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
       </div>
       <div class="tab-pane" id="tab-register">
          <div class="form-group required">
            <div class="col-sm-2"><?php echo $text_register; ?></div>
            <div class="col-sm-10"><a href="https://www.sisow.nl/Sisow/iDeal/Aanmelden.aspx?r=65481" target="_blank" data-toggle="tooltip" title="<?php echo $text_register; ?>" class="btn btn-warning"><i class="fa fa-user"> <?php echo $button_register; ?> <?php echo $text_sisow; ?></i></a> <a href="https://www.sisow.nl/Sisow/iDeal/Login.aspx" target="_blank" data-toggle="tooltip" title="<?php echo $text_login; ?>" class="btn btn-info"><i class="fa fa-sign-in"> <?php echo $text_sisow; ?> <?php echo $button_login; ?></i></a><br /><?php echo $help_sisow_register; ?></div>
          </div>
          <div class="form-group">
            <div class="col-sm-2"><?php echo $text_login; ?></div>
            <div class="col-sm-10"><?php echo $help_sisow_login; ?></div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-2"><?php echo $text_sisow_profile; ?></div>
            <div class="col-sm-10"><?php echo $help_sisow_profile_info; ?></div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-2"><?php echo $text_add_details; ?></div>
            <div class="col-sm-10"><?php echo $help_add_details; ?> <img src="view/image/payment/sisow/sisow-details.jpg" class="img-responsive" /></div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-2 control-label"><?php echo $text_add_shops; ?></div>
            <div class="col-sm-10"><img src="view/image/payment/sisow/sisow-add-moreshops.jpg" class="img-responsive" /></div>
          </div>
       </div>
        <div class="tab-pane" id="tab-support">
          <div class="form-group">
            <div class="col-sm-2"><?php echo $entry_sisow_module ?></div>
            <div class="col-sm-10"><?php echo $text_version ?><br /><?php echo $text_compatible ?></div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-2"><?php echo $text_partner; ?></div>
            <div class="col-sm-10"><?php echo $entry_partner; ?><br /><a href="http://www.dymago.eu" target="_blank"><img src="view/image/payment/sisow/sisow-partner.png" alt="Dymago" title="Dymago" class="img-responsive" /></a></div>
          </div>
          <hr>
          <div class="form-group">
            <div class="col-sm-2"><?php echo $text_psp; ?></div>
            <div class="col-sm-10"><?php echo $entry_psp; ?><br /><a href="https://www.sisow.nl/Sisow/iDeal/Aanmelden.aspx?r=65481" target="_blank"><img src="view/image/payment/sisow/sisow.png" alt="Sisow" title="Sisow" class="img-responsive" /></a></div>
          </div>
       </div>
      </div>
	</form>	
  </div>
 </div>
</div>
<?php echo $footer; ?>
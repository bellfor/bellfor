<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-bellformailchimp" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
            <h1>
                <?php echo $heading_title; ?>
            </h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li>
                    <a href="<?php echo $breadcrumb['href']; ?>">
                        <?php echo $breadcrumb['text']; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
            <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-cogs"></i>
                    <?php echo $heading_title; ?>
                </h3>
            </div>
            <div class="panel-body">
                <p>
                    <?php echo $placeholder; ?>
                </p>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-bellformailchimp" class="form-horizontal">
                   <div class="form-group">
          <label class="col-sm-2 control-label">API Key</label>
          <div class="col-sm-10">
            <input type="text" name="bellformailchimp_api_key" id="input-api-key" class="form-control" value="<?php echo $bellformailchimp_api_key; ?>" data-toggle="tooltip" data-placement="bottom" title="Mailchimp API Key" />
          </div>
          </div>
            <div class="form-group">
            <label class="col-sm-2 control-label">List ID</label>
          <div class="col-sm-10">
            <input type="text" name="bellformailchimp_list_id" id="input-list-id" class="form-control" value="<?php echo $bellformailchimp_list_id; ?>" data-toggle="tooltip" data-placement="bottom" title="Mailchimp List ID" />
          </div>
        </div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name">Status</label>
						<div class="col-sm-10">

						  <select type="text" name="bellformailchimp_status" class="form-control">
						  <?php if($bellformailchimp_status){ ?>
								<option value="1" selected="selected">Enable</option>
								<option value="0">Disable</option>
						  <?php } else { ?>
								<option value="1">Enable</option>
								<option value="0" selected="selected">Disable</option>
						  <?php } ?>
						  </select>
						</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
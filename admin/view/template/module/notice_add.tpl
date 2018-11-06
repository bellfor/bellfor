<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-filter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary">
          <i class="fa fa-save"></i>
        </button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default">
          <i class="fa fa-reply"></i>
        </a>
      </div>
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
    <div class="alert alert-danger">
      <i class="fa fa-exclamation-circle"></i>
      <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">
          <i class="fa fa-pencil"></i>
          <?php echo $text_edit; ?>
        </h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-filter" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-status">
              <?php echo $entry_status; ?>
            </label>
            <div class="col-sm-3">
              <select name="notice_add_status" id="input-status" class="form-control">
                <?php if ($notice_add_status) { ?>
                <option value="1" selected="selected">
                  <?php echo $text_enabled; ?>
                </option>
                <option value="0">
                  <?php echo $text_disabled; ?>
                </option>
                <?php } else { ?>
                <option value="1">
                  <?php echo $text_enabled; ?>
                </option>
                <option value="0" selected="selected">
                  <?php echo $text_disabled; ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="input-status">
              <?php echo $layout_noty; ?>
            </label>
            <div class="col-sm-3">
			<?php if(empty($notice_add_layout)) {
				$notice_add_layout = 'center';
			} ; ?>
              <select name="notice_add_layout" id="input-status" class="form-control">

                <option value="bottomRight" <?php if($notice_add_layout=='bottomRight' ) echo 'selected'; ?> >
                  <?php echo $layout_bottomRight?>
                </option>

                <option value="bottomLeft" <?php if($notice_add_layout=='bottomLeft' ) echo 'selected'; ?> >
                  <?php echo $layout_bottomLeft?>
                </option>

                <option value="bottomCenter" <?php if($notice_add_layout=='bottomCenter' ) echo 'selected'; ?> >
                  <?php echo $layout_bottomCenter?>
                </option>

                <option value="bottom" <?php if($notice_add_layout=='bottom' ) echo 'selected'; ?> >
                  <?php echo $layout_bottom?>
                </option>

                <option value="center" <?php if($notice_add_layout=='center' ) echo 'selected'; ?> >
                  <?php echo $layout_center?>
                </option>

                <option value="centerRight" <?php if($notice_add_layout=='centerRight' ) echo 'selected'; ?> >
                  <?php echo $layout_centerRight?>
                </option>

                <option value="centerLeft" <?php if($notice_add_layout=='centerLeft' ) echo 'selected'; ?> >
                  <?php echo $layout_centerLeft?>
                </option>

                <option value="top" <?php if($notice_add_layout=='top' ) echo 'selected'; ?> >
                  <?php echo $layout_top?>
                </option>

                <option value="topRight" <?php if($notice_add_layout=='topRight' ) echo 'selected'; ?> >
                  <?php echo $layout_topRight?>
                </option>

                <option value="topLeft" <?php if($notice_add_layout=='topLeft' )echo 'selected'; ?> >
                  <?php echo $layout_topLeft?>
                </option>

                <option value="topCenter" <?php if($notice_add_layout=='topCenter' ) echo 'selected'; ?> >
                  <?php echo $layout_topCenter?>
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="notice_add_timeout">
              <?php echo $noty_timeout?>
            </label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="notice_add_timeout" value="<?php if(isset($notice_add_timeout)){echo $notice_add_timeout;}else{echo 5000;}?>">
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <?php echo $footer; ?>

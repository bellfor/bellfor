<?php echo $header; ?>
<div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation" >
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
   <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
 </div>
            </div>
          </div>
        </div>
    </div>
<!-- Closing header tags -->

<!-- Content begins -->
 <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">


<div class="col-md-9 col-md-push-3 col-xs-12 right-container">
<div class="row">
<div id="carousel-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->

  <?php echo $content_top; ?>

</div>
<main class="main-text-container" id="content">

      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_contact; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if ($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
            <div class="col-sm-10">
              <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"><?php echo $enquiry; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <div class="text-danger"><?php echo $error_enquiry; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php echo $captcha; ?>
        </fieldset>
        <div class="buttons">
          <div class="pull-right">
            <button type="submit" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_submit; ?></span></span></button>
          </div>
        </div>
      </form>
 </main>
</div>
</div><!-- end right container -->



<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<?php echo $footer; ?>
<style type="text/css"><!--
div.required .control-label:not(span):before {
    content: '* ';
    color: #F00;
    font-weight: bold;
}
--></style>
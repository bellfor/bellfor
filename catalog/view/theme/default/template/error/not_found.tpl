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

    <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
			

  <div class="col-md-12 col-xs-12 right-container">	
	<?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_error; ?></p>
      <div class="buttons clearfix">
	   <div class="pull-right"><a href="<?php echo $continue; ?>" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $button_continue; ?></span></span></a></div>
      </div>
     <?php echo $content_bottom; ?></div>
	  



          </div>
          </div>
        </div>
    </div>
<?php echo $footer; ?> 
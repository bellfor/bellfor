<?php if ($modules) { ?>

<aside class="col-md-3 col-md-pull-9 col-xs-12" >

  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>
        <div class="container-left-sidebar" style="padding: 0 !important;">
<div class="fb-page" data-href="<?php echo $link_facebook; ?>" data-tabs="timeline" data-width="260" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $link_facebook; ?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $link_facebook; ?>">Bellfor Hundefutter</a></blockquote></div>
        </div>

</aside>
<?php } ?>
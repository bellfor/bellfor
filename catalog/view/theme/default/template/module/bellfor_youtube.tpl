<div class="box-youtube">
<?php  if(!empty($module_title)) {?>
  <div class="box-heading name-menues"><?php echo $module_title ; ?></div>
  <?php } ; ?>
  <div class="box-content box-youtube-content" style="text-align: center;">
		<div style="text-align:center;position:relative">
        <button data-href="https://www.youtube.com/watch?v=<?php echo $code; ?>" class="webiprg-play-button" aria-label="View"><svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="webiprg-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#212121" fill-opacity="0.8"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg></button>
		<a title="View <?php echo $heading_title; ?>" class="webiprog-youtube" href="https://www.youtube.com/watch?v=<?php echo $code; ?>"><img class="img-youtube" src="https://img.youtube.com/vi/<?php echo $code; ?>/hqdefault.jpg" alt="<?php echo $heading_title ; ?>" />
		</a>
		</div>
  </div>
</div>
<style type="text/css"><!--
.box-youtube-right { margin-top: 15px; border: 1px solid #dbdbdb; padding: 0 15px 15px; }
.box-youtube .img-youtube { width: 100%; max-width: 255px; padding: 0; margin: 0; }
.webiprg-play-button { position: absolute; left: 50%; top: 50%; width: 68px; height: 48px; margin-left: -34px; margin-top: -24px; -moz-transition: opacity .25s cubic-bezier(0.0,0.0,0.2,1); -webkit-transition: opacity .25s cubic-bezier(0.0,0.0,0.2,1); transition: opacity .25s cubic-bezier(0.0,0.0,0.2,1); z-index: 63; cursor: pointer;
border: none !important; background-color: transparent !important; padding: 0 !important; color: inherit; text-align: inherit; font-size: 100%; font-family: inherit; line-height: inherit; } .webiprg-play-button svg { height: 100%; left: 0; position: absolute; top: 0; width: 100%; } .box-youtube svg { pointer-events: none; }
.webiprg-play-button:hover .webiprg-play-button-bg{ fill: #ff0000; }
--></style>
<script type="text/javascript"><!--
$('.webiprg-play-button').click(function() {
	//alert($(this).data('href'));
	var redhref = $(this).data('href');
    window.location.href = redhref;
    return false;
});
//--></script>


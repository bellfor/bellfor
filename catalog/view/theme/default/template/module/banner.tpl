<?php
# @FIX: OPPO
# @Date:   Thursday, November 5th 2015, 1:03:50 pm
# @Project: bellfor.info
# @Filename: banner.tpl
# @Last modified by:   Oleg
# @Last modified time: Tuesday, February 13th 2018, 5:09:32 pm
# @Copyright: webiprog.com
?>

<div id="banner<?php echo $module; ?>" class="owl-carousel">
  <?php $bannercount=0; ?>
  <?php foreach ($banners as $banner) { ?>
  <div class="item">
    <?php if ($banner['link']) { ?>
    <?php
    $bannercount++;
    $bannerautoPlay=3000;
	$bannertransition="fade";
    ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" />
    <?php } ?>
  </div>
  <?php } ?>
</div>
<?php
    if ($bannercount > 1) {
	$bannertransition="fade";
	$bannerautoPlay=3000;
    }else{
    $bannertransition="none";
	$bannerautoPlay=0;
    }
    ?>
<script type="text/javascript"><!--
$('#banner<?php echo $module; ?>').owlCarousel({
	<?php echo $bannerautoPlay?'items: 6, autoPlay: 3000':'autoPlay: false' ; ?>,
	singleItem: true,
	navigation: false,
	pagination: false,
	transitionStyle: '<?php echo $bannertransition; ?>'
});
--></script>

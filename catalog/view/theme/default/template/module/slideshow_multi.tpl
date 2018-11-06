<!-- ********** Banner Multilang********** -->
<div class="slideshow-box oct-slideshow">
    <div id="banners_multi<?php echo $module; ?>" class="owl-carousel" style="opacity: 1;">
        <?php foreach ($banners_multi as $banner) { ?>
            <div class="item">
                <div class="camera_caption fadeIn element-animation-fi">
                    <div class="container">
						<h2 class="first-heder-color"><?php echo $banner['title']; ?></h2>
						<p><?php echo $banner['description']; ?></p>
						<?php if(!empty($banner['link'])) { ?>
						<a class="slideshow-plus-link button-more btn-slide"
						   href="<?php echo $banner['link']; ?>"><?php echo $banner['button']; ?>
						 </a>
						 <?php } ; ?>
					 </div>
                </div>
                <div class="col-sm-12 element-animation-bi">
                    <a href="<?php echo $banner['link']; ?>">
                        <img src="<?php echo $banner['image']; ?>" alt="" class="img-responsive"/>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<!-- ********** End of Banner Multilang ********** -->




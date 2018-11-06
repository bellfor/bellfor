<div class="container-Empfehlungen">
<h2><?php echo $heading_title; ?></h2>
<div class="row">
  <?php foreach ($products as $product) { ?>
  <div class="col-md-3 col-sm-3 Empfehlungen-img">
    <div class="product-thumb transition">
      <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
      <div class="title">
        <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
        <?php if ($product['rating']) { ?>
        <div class="rating">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($product['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['price']) { ?>
        <div class="price">
		<a href="<?php echo $product['href']; ?>">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
          <?php if ($product['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
          <?php } ?>
		</a>  
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
</div>
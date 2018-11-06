<div class="container-bestseller container-left-sidebar">
<h4><?php echo $heading_title; ?></h4>
  <?php $counter = 1; foreach ($products as $product) { ?>
  <div class="single-bestseller">    
        <span class="number"><?php echo $counter; ?></span>
        <span class="title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></span>
        <?php if ($product['price']) { ?>
        <span class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
          <?php } ?>
        </span>
        <?php } ?>
  
    </div>
  <?php $counter++; } ?>
</div>
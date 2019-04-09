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
            <span class="small right-price-vat"> <?php echo $product['price_weight']; ?> <?php echo $currency; ?> <?php echo $text_pro_kg ; ?><br /></span>
            <?php if ($product['tax_rate']) { ?>
                <span class="small bestseller-font-size-tax right-price-vat"><?php echo $text_tax; ?> <?php echo $product['tax_rate'][0]['name']; ?>
                    <a class="bestseller-font-size-shipping" href="<?php echo $link_versand; ?>" target="_blank">Versand</a>
                </span>
            <?php } else { ?>
                <span><a class="bestseller-font-size-shipping right-price-vat" href="<?php echo $link_versand; ?>" target="_blank">Versand</a></span>
            <?php } ?>
        <?php } ?>
  
    </div>
  <?php $counter++; } ?>
</div>
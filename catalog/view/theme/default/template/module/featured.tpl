<div class="container-Empfehlungen">
    <h2><?php echo $heading_title; ?></h2>
    <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="col-md-3 col-sm-3 Empfehlungen-img">
            <div class="product-thumb transition">
                <a href="<?php echo $product['href']; ?>">
                    <img src="<?php echo $product['thumb']; ?>"
                         alt="<?php echo $product['name']; ?>"
                         title="<?php echo $product['name']; ?>"
                         class="img-responsive"/>
                </a>
                <div class="title">
                    <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>

                    <?php if ($product['price']) { ?>
                    <div class="price">
                        <?php if ($product['rating']) { ?>
                        <div class="rating_wrap rating_product">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <?php if ($product['rating'] < $i) { ?>
                        <span class="fa fa-stack star-<?php echo $i; ?>">
                            <i class="fa fa-star-o fa-stack-2x"></i><!-- Empty star -->
                        </span>
                            <?php } else { ?>
                        <span class="fa fa-stack star-<?php echo $i; ?>">
                            <i class="fa fa-star fa-stack-2x"></i><!-- full star -->
                            <i class="fa fa-star-o fa-stack-2x"></i>
                        </span>
                            <?php } ?>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        <a href="<?php echo $product['href']; ?>">
                            <?php if (!$product['special']) { ?>
                            <?php echo $product['price']; ?>
                            <?php } else { ?>
                            <span class="price-new"><?php echo $product['special']; ?></span> <span
                                    class="price-old"><?php echo $product['price']; ?></span>
                            <?php } ?>

                        </a>
                    </div>
                    <?php } ?>
					      <div class="article-list-item-button payment_buttons">
        <span class="quantity_container">
          <input type="text" name="products_qty" id="qty_<?php echo $product['product_id']; ?>" class="article-count-input" value="<?php echo $product['minimum']; ?>">
        </span>
        <button onclick="cart.add('<?php echo $product['product_id']; ?>', $('#qty_<?php echo $product['product_id']; ?>').val());" class="button_green"><?php echo $button_cart; ?></button>
		
      </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
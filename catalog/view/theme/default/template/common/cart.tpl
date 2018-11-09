<div id="cart" class="shopping-cart-container dropdown">
    <a class="hidden-xs" href="index.php?route=checkout/cart">
        <img src="catalog/view/theme/default/image/icon-grey-basket-big.png" class="icon-basket">
        <div class="shopping-cart text-right">
            <div class="shopping-cart-text">
                <span id="cart-text"><?php echo $text_cart; ?></span> <div id="cart-items"><?php echo $text_items; ?></div>
            </div>
        </div>
    </a>
    <a class="visible-xs" href="index.php?route=checkout/cart"  style="color: #6f6f6f;">
        <img src="catalog/view/theme/default/image/icon-grey-basket-big.png" style="float: left;" class="icon-basket">
        <div class="shopping-cart text-right">
            <div class="shopping-cart-text" style="float: left;">
                <span id="cart-items-mobile"><?php echo $count_item; ?></span>
            </div>
        </div>
    </a>
    <a href="#" data-loading-text="<?php echo $text_loading; ?>" class="dropdown-toggle dropdown_cart_button" data-toggle="dropdown"
       role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
    </a>
  <div class="product_menu dropdown-menu">
    <div id="cart-info">
      <?php if ($products || $vouchers) { ?>
        <?php foreach ($products as $product) { ?>       
          <div class="cart-item">
            <div class="cart-item-inner">
              <?php if ($product['thumb']) { ?>
                <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"
                                                               alt="<?php echo $product['name']; ?>"
                                                               title="<?php echo $product['name']; ?>"
                                                               class="img-thumbnail"/></a>
              <?php } ?>
              <p><?php echo $product['quantity']; ?>x <a
                    href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                <br><span class="price"><?php echo $product['total']; ?></span></p>
            </div>
          </div>

        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
          <tr>
            <td class="text-center"></td>
            <td class="text-left"><?php echo $voucher['description']; ?></td>
            <td class="text-right">x&nbsp;1</td>
            <td class="text-right"><?php echo $voucher['amount']; ?></td>
            <td class="text-center text-danger">
              <button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"
                      title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i>
              </button>
            </td>
          </tr>
        <?php } ?>


        <?php $total = end($totals); ?>
        <div class="dropdown_shopping_cart_total">
          <span><?php echo $total['title']; ?>: <?php echo $total['text']; ?></span>
        </div>
   
        <div class="cart-button"><a class="button_blue button_set" href="<?php echo $cart; ?>"><span
                class="button-outer"><span class="button-inner"><?php echo $text_cart; ?></span></span></a></div>

      <?php } else { ?>

        <p class="text-center"><?php echo $text_empty; ?></p>

      <?php } ?>
    </div>
  </div>
</div>

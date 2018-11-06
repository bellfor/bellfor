<div id="cart" class="shopping-cart-container dropdown">
 
   <a href="#" data-loading-text="<?php echo $text_loading; ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="catalog/view/theme/default/image/icon-grey-basket-big.png" class="icon-basket">
                                <div class="shopping-cart text-right">
                                  <div class="shopping-cart-text">
                                    <span id="cart-text">Ihr Warenkorb</span> <span id="cart-items"><?php echo $text_items; ?></span>
                                  </div>
                                  <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span> 
                                </div>
                                </a>
   <div class="product_menu dropdown-menu">
   <div id="cart-info">
    <?php if ($products || $vouchers) { ?>
        <?php $all_tax_rates = array(); ?>		
        <?php foreach ($products as $product) { ?>
        <?php if(!isset($all_tax_rates[$product['tax_rate'][0]['tax_rate_id']])) { 
		$all_tax_rates[$product['tax_rate'][0]['tax_rate_id']] = array('name' => $product['tax_rate'][0]['name'], 'amount' => $product['quantity'] * $product['clean_price'] * $product['tax_rate'][0]['rate']/100);
		} else {
		$all_tax_rates[$product['tax_rate'][0]['tax_rate_id']]['amount'] += $product['quantity'] * $product['clean_price'] * $product['tax_rate'][0]['rate']/100;
		}
		?>		
        <div class="cart-item">
		  <div class="cart-item-inner">
            <?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
            <?php } ?>
          <p><?php echo $product['quantity']; ?>x <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
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
          <td class="text-center text-danger"><button type="button" onclick="voucher.remove('<?php echo $voucher['key']; ?>');" title="<?php echo $button_remove; ?>" class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>
        </tr>	
        <?php } ?>
       

          <?php $total = end($totals);  ?>
          <div class="dropdown_shopping_cart_total">
            <span><?php echo $total['title']; ?>: <?php echo $total['text']; ?></span>
          </div>
     <p class="mwst-hint"><?php foreach ($all_tax_rates as $all_tax_rate) {  ?>
	 inkl. <?php echo $all_tax_rate['name']; ?>:  <?php echo round($all_tax_rate['amount'], 2); ?> EUR<br>  
     <?php } ?>
	 <a class="gm_shipping_link lightbox_iframe" href="http://www.bellfor.info/popup_content.php?coID=3889891&amp;lightbox_mode=1" target="_blank" rel="nofollow" data-modal-settings="{&quot;title&quot;:&quot;Versand&quot;, &quot;sectionSelector&quot;: &quot;.content_text&quot;, &quot;bootstrapClass&quot;: &quot;modal-lg&quot;}">
          <span style="text-decoration:underline">Versand</span>
            </a></p>
      <div class="cart-button"><a class="button_blue button_set" href="<?php echo $cart; ?>"><span class="button-outer"><span class="button-inner"><?php echo $text_cart; ?></span></span></a></div> 
   
    <?php } else { ?>
    
    <p class="text-center"><?php echo $text_empty; ?></p>
   
    <?php } ?>
	 </div>
  </div>
</div>

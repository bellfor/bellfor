<?php echo $header; ?>
<div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
</div>
</div>
</div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="main-container">
      <div class="row">


        <div class="col-md-12 col-xs-12 right-container">

          <?php if ($attention) { ?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
              <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
          <?php } ?>
          <?php if ($success) { ?>
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
          <?php } ?>
          <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
          <?php } ?>
          <div class="wrap_cart_page_header">
            <h1><?php echo $heading_title; ?>
              <?php if ($weight) { ?>
                &nbsp;(<?php echo $weight; ?>)
              <?php } ?>
            </h1>
            <div class="buttons clearfix">
              <div class="fix_mobile_cart_buttons pull-left margin"><a href="<?php echo $continue; ?>" class="button_blue button_set"
                                               style="height: 30px; font-size: 14px;"><span class="button-outer"><span
                        class="button-inner" style="padding-top: 6px;"><?php echo $button_shopping; ?></span></span></a>
              </div>
              <div class="fix_mobile_cart_buttons pull-right"><a href="<?php echo $checkout; ?>" class="button_blue button_set"
                                        id="cart-checkout-button" style="height: 40px; font-size: 16px;"><span class="button-outer"><span
                        class="button-inner" style="padding-top: 11px;"><?php echo $button_checkout; ?></span></span></a>
              </div>
              <div class="fix_mobile_cart_buttons pull-right">&nbsp;&nbsp;<b>oder</b>&nbsp;&nbsp;</div>
              <div class="fix_mobile_cart_buttons pull-right"><?php echo $content_top; ?></div>
            </div>
          </div>

            <div id="cart_reload" class="cart_reload_cl">
               <form id="form_reload" class="yesreload" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <td class="text-center"><?php echo $column_image; ?></td>
                              <td class="text-left"><?php echo $column_name; ?></td>
                              <td class="text-left"><?php echo $column_model; ?></td>
                              <td class="text-left"><?php echo $column_quantity; ?></td>
                              <td class="text-right"><?php echo $column_price; ?></td>
                              <td class="text-right"><?php echo $column_total; ?></td>
                           </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($products as $product) { ?>
                           <tr>
                              <td class="text-center"><?php if ($product['thumb']) { ?>
                                 <a href="<?php echo $product['href']; ?>">
                                 <img src="<?php echo $product['thumb']; ?>"
                                    alt="<?php echo $product['name']; ?>"
                                    title="<?php echo $product['name']; ?>"
                                    class="img-thumbnail img_fix"/></a>
                                 <?php } ?>
                              </td>
                              <td class="text-left">
                                 <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                 <?php if (!$product['stock']) { ?>
                                 <span class="text-danger">***</span>
                                 <?php } ?>
                                 <?php if ($product['option']) { ?>
                                 <?php foreach ($product['option'] as $option) { ?>
                                 <br/>
                                 <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                                 <?php } ?>
                                 <?php } ?>
                                 <?php if ($product['reward']) { ?>
                                 <br/>
                                 <small><?php echo $product['reward']; ?></small>
                                 <?php } ?>
                                 <?php if ($product['recurring']) { ?>
                                 <br/>
                                 <span class="label label-info"><?php echo $text_recurring_item; ?></span>
                                 <small><?php echo $product['recurring']; ?></small>
                                 <?php } ?>
                              </td>
                              <td class="text-left"><?php echo $product['model']; ?></td>
                              <td class="text-left">
                                 <div class="input_group_card input-group btn-block" style="max-width: 200px;">
                                    <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]"
                                       value="<?php echo $product['quantity']; ?>" size="1" class="form-control"/>
                                    <span class="input-group-btn">
                                    <button type="submit" data-toggle="tooltip" title="<?php echo $button_update; ?>"
                                       class="btn btn-primary fix_bg_color"><i class="fa fa-refresh"></i></button>
                                    <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>"
                                       class="btn btn-danger" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i
                                       class="fa fa-times-circle"></i></button>
                                    </span>
                                 </div>
                              </td>
                              <td class="text-right"><?php echo $product['price']; ?></td>
                              <td class="text-right"><?php echo $product['total']; ?></td>
                           </tr>
                           <?php } ?>
                           <?php foreach ($vouchers as $voucher) { ?>
                           <tr>
                              <td></td>
                              <td class="text-left"><?php echo $voucher['description']; ?></td>
                              <td class="text-left"></td>
                              <td class="text-left">
                                 <div class="input-group btn-block" style="max-width: 200px;">
                                    <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control"/>
                                    <span class="input-group-btn">
                                    <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>"
                                       class="btn btn-danger" onclick="voucher.remove('<?php echo $voucher['key']; ?>');"><i
                                       class="fa fa-times-circle"></i></button>
                                    </span>
                                 </div>
                              </td>
                              <td class="text-right"><?php echo $voucher['amount']; ?></td>
                              <td class="text-right"><?php echo $voucher['amount']; ?></td>
                           </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </form>
               <br/>
               <div class="row reload_totals yesreload">
                  <div class="col-sm-8 padding_fix padding_fix_coupon_in_cart">
                     <?php if ($coupon && !isset($check_coupon)) { ?>
                     <div class="panel-group" id="accordion"><?php echo $coupon; ?></div>
                     <?php } ?>
                  </div>
                  <div class="col-sm-4 padding_fix">
                     <table class="table table-bordered">
                        <?php foreach ($totals as $total) { ?>
                        <tr>
                           <td class="text-right"><strong><?php echo $total['title']; ?>:</strong></td>
                           <td class="text-right"><?php echo $total['text']; ?></td>
                        </tr>
                        <?php } ?>
                     </table>
                  </div>
               </div>
               <!-- end  row reload_totals -->
               <div class="buttons clearfix noreload">
                  <div class="pull-right"><a href="<?php echo $checkout; ?>" class="button_blue button_set"
                     id="cart-checkout-button" style="height: 40px; font-size: 16px;"><span class="button-outer"><span
                     class="button-inner" style="padding-top: 11px;"><?php echo $button_checkout; ?></span></span></a>
                  </div>
               </div>
               <!-- end buttons clearfix -->
            </div>
            <!-- end cart_reload -->
            <div class="clearfix">&nbsp;</div>
            <?php
            // fixed by oppo webiprog.com  12.03.2018 MAR-223 free shipping by total price
            if(isset($freeshippingbytotalprice)) { ?>
            <div class="row">
            <div class="col-sm-8 padding_fix padding_fix_coupon_in_cart"><?php echo $freeshippingbytotalprice ; ?></div>
            </div>
            <?php } ;
            // end fixed by oppo webiprog.com  12.03.2018 MAR-223 free shipping by total price
            ?>
          <?php echo $content_bottom; ?></div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>

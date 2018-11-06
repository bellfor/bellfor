<?php echo $header; ?>
                        <div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation" >
						    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                            <?php } ?>
                        </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
			

    <div class="col-md-9 col-md-push-3 col-xs-12 right-container">	
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
      <div class="buttons">
        <div class="pull-right">
          <a href="<?php echo $continue; ?>" class="button_blue button_set">
            <span class="button-outer">
              <span class="button-inner"><?php echo $button_continue; ?></span>
            </span>
          </a>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
	  
<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<?php if (isset($order_info)) { ?>
<script type="text/javascript">
    var _kkstrack = {
        merchantInfo : [{ country:"<?php echo $order_info['country']; ?>", merchantId:"<?php echo $order_info['merchantId']; ?>" }],
        orderValue: '<?php echo $order_info['total']; ?>',
        orderId: '<?php echo $order_info['order_id']; ?>',
        basket:  [
            <?php foreach ($order_info['products'] as $product) {?>
            { productname: '<?php echo $product['name']; ?>',
                productid: '<?php echo $product['product_id']; ?>',
                quantity: '<?php echo $product['quantity']; ?>',
                price: '<?php echo $product['price']; ?>',
                total: '<?php echo $product['total']; ?>'
            },
            <?php } ?>
        ]
    };
    (function() {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://s.kk-resources.com/ks.js';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();
</script>

<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer></script>

<script>
    window.renderOptIn = function() {
        window.gapi.load('surveyoptin', function() {
            window.gapi.surveyoptin.render(
                {
                    // REQUIRED FIELDS
                    "merchant_id": 100859620,
                    "order_id": "<?php echo $order_info['order_id']; ?>",
                    "email": "<?php echo $order_info['email']; ?>",
                    "delivery_country": "<?php echo $order_info['country_code']; ?>",
                    "estimated_delivery_date": "<?php echo date('Y-m-d', strtotime($order_info['date_added'] . ' + 5 days')); ?>",

                    // OPTIONAL FIELDS
                    "products": [
                        <?php foreach ($order_info['products'] as $product) {?>
                        {"gtin":"<?php echo $product['product_id']; ?>"},
                        <?php } ?>
                    ]
                });
        });
    }
</script>
<?php } ?>
<?php echo $footer; ?> 
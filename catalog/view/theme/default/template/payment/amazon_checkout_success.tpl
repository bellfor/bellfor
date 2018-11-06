<?php echo $header; ?>
            </div>
          </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
			

  <div class="col-md-12 col-xs-12 right-container">
  <?php echo $content_top; ?>
  <div style="text-align:center;">
    <h2><?php echo $text_success_title; ?></h2>
    <p><?php echo $text_payment_success; ?></p>
    <div style="margin: 0 auto; width: 392px;" id="AmazonOrderDetail"></div>
  </div>
  <?php echo $content_bottom; ?>
</div>

          </div>
          </div>
        </div>
    </div>
<script type="text/javascript"><!--
  new CBA.Widgets.OrderDetailsWidget ({
    merchantId: "<?php echo $merchant_id; ?>",
    orderID: "<?php echo $amazon_order_id; ?>"
  }).render ("AmazonOrderDetail");
//--></script>
<?php echo $footer; ?>
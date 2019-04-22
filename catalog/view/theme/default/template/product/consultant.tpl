<?php echo $header; ?>
<link href="catalog/view/theme/default/css/styles_futterassistent.css" type="text/css" rel="stylesheet" media="screen" />
<link href="catalog/view/theme/default/css/styles.css" type="text/css" rel="stylesheet" media="screen" />
<div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation" >
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php
  if ($breadcrumb['text']!=='<i class="fa fa-home"></i>')
  {
    echo '<span>»</span>';
  }
  ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
 </div>
            </div>
          </div>
        </div>
    </div>
<!-- Closing header tags -->

<!-- Content begins -->
 <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">


<div class="col-md-9 col-md-push-3 col-xs-12 right-container">
<div class="row">
<div id="carousel-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <?php echo $content_top; ?>

</div>
<main class="main-text-container" id="content">
<h1><?php echo $heading_title; ?></h1>

<!-- form for sending email BEGIN -->
                    <div style="clear: both;"></div>
                    <form class="form-discount">
                      <h3 style="background-color: #7e842e; color: #fff; font-family: Arial,Helvetica,Sans-Serif; font-size: 14px; font-style: normal; font-weight: 700; padding: 8px 10px; margin-bottom: 15px; text-align: center">10% Nachlass für  <span class="dog-name"><?php echo @$_GET['dog_name']; ?></span></h3>
                      <div class="form-group">
                        <label class="sr-only">Email address:</label>
                        <input type="email" name="discount_email" class="form-control" placeholder="Email" required>

                        <button type="button" id="submit_discount" class="button_green">Bekomme 10% Nachlass</button>
                      </div>
                    </form>
                    <!-- form for sending email END -->




<h2 style="padding-bottom: 0; margin-bottom: -10px">Wir empfehlen ihnen für <?php echo @$_GET['dog_name']; ?> folgendes Produkt:</h2>
</main>

<div class="panel">
    <form action="#" method="get">
      <div class="panel-sort sort-first-con">
        <div class="input select">
          <label><?php echo $text_sort ; ?> </label>
            <select id="input-sort" class="input-select" onchange="location = this.value;">
              <?php $sorts1 = $sorts; foreach ($sorts as $sorts) { ?>
              <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
        </div>
      </div>
      <div class="panel-itemcount">
        <div class="input select">
          <label><?php echo $text_limit ; ?> </label>
            <select id="input-limit" class="input-select" onchange="location = this.value;">
              <?php $limits1 = $limits; foreach ($limits as $limits) { ?>
              <?php if ($limits['value'] == $limit) { ?>
              <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
        </div>
      </div>


      <div class="panel-viewmode">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><img class="png-fix" src="image/elements/panel/view_mode_default_on.png" alt=""></button>&nbsp;&nbsp;
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><img class="png-fix" src="image/elements/panel/view_mode_tiled_off.png" alt=""></button>
      </div>

    </form>
    <div class="panel-pagination">
      <?php echo $results; ?>
    </div>
  </div>

<div class="container-Empfehlungen">


  <div class="row">
         <?php $counter = 1;
               $dl_products = '';
     ?>
         <?php $arra_rpdarr = array();
         foreach ($products as $product) {
          if($product['category'] != 'Nahrungsergänzung'){ ?>
<section class="row article-list-item">
    <div class="product-list-image col-md-3 col-sm-3" >
        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></a>
    </div>
    <div class="col-md-9 col-sm-9 product-container" >
      <div class="article-list-item-main">
    <div class="title">
          <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
        </div>
    <div class="description">
        <?php echo $product['description']; ?>
    </div>
      </div>

                <?php if ($product['price']) { ?>
                 <div class="price">
          <a href="<?php echo $product['href']; ?>">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price_full_formatted']; ?>
      <?php if ($product['weight'] < 1) { ?>
          <span class="small"> <?php if($product['currency_position']=='l') {echo $product['currency'];} echo round($product['price_full']/$product['weight']/10, 2); if($product['currency_position']=='r') {echo $product['currency'];} ?> pro 100 g<br></span></a>
            <?php } else {?>
          <span class="small"> <?php if($product['currency_position']=='l') {echo $product['currency'];} echo round($product['price_full']/$product['weight'], 2);  if($product['currency_position']=='r') {echo $product['currency'];} ?> pro kg<br></span></a>
            <?php } ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
          </a>
                     <?php if ($product['tax']) { ?>
                         <span class="small font-size-tax"><?php echo $text_tax; ?> <?php echo $product['tax_rate'][0]['name']; ?>
                             <a class="font-size-shipping" href="<?php echo $link_versand; ?>" target="_blank">Versand</a>
                                                            </span>
                     <?php } else { ?>
                         <a class="font-size-shipping" href="<?php echo $link_versand; ?>" target="_blank">Versand</a>
                     <?php } ?>
                 </div>
                <?php } ?>

    </div>
    <div class="article-list-item-bottom">
      <div class="article-list-item-delivery">
        <p>
            <span class="label-list">Versandgewicht je Stück: </span> <?php echo round($product['weight'], 1); ?> kg
        </p>
      </div>
      <div class="article-list-item-button payment_buttons">
          <?php if (empty($product['p2cg_product_id']) || (!empty($product['p2cg_product_id']) && $product['email_required'] == '0') ) {?>
              <span class="quantity_container">
                <input type="text" name="products_qty" id="qty_<?php echo $product['product_id']; ?>" class="article-count-input" value="<?php echo $product['minimum']; ?>">
              </span>
              <button onclick="cart.add('<?php echo $product['product_id']; ?>', $('#qty_<?php echo $product['product_id']; ?>').val());" class="button_green"><?php echo $button_cart; ?></button>
          <?php } else {?>
              <a class="button_green" href="<?php echo $product['href']; ?>"><?php echo $button_go_product; ?></a>
          <?php } ?>
      </div>
    </div>
</section>
     <?php
     $dl_products .= '     {
       \'name\': \''.$product['name'].'\',       // Name or ID is required.
       \'id\': \''.$product['model'].'\',
       \'price\': \''.$product['price_full'].'\',
       \'category\': \''.$product['category'].'\',
       \'list\': \'Category page\',
       \'position\': '.$counter.'
     },';
//var_dump($product['category']);
     $counter++;
     ?>

        <?php }else{
          $arra_rpdarr[] = $product;
        } ?>
        <?php } ?>
      </div>
  </div>
</div>

 <div class="panel">
    <form action="#" method="get">
      <div class="panel-sort sort-niz sort-con">
        <div class="input select">
          <label><?php echo $text_sort ; ?> </label>
            <select id="input-sort" class="input-select" onchange="location = this.value;">
              <?php foreach ($sorts1 as $sorts) { ?>
              <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
              <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
        </div>
      </div>
      <div class="panel-itemcount">
        <div class="input select">
          <label><?php echo $text_limit ; ?> </label>
            <select id="input-limit" class="input-select" onchange="location = this.value;">
              <?php foreach ($limits1 as $limits) { ?>
              <?php if ($limits['value'] == $limit) { ?>
              <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
        </div>
      </div>


      <div class="panel-viewmode">

            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><img class="png-fix" src="image/elements/panel/view_mode_default_on.png" alt=""></button>&nbsp;&nbsp;
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><img class="png-fix" src="image/elements/panel/view_mode_tiled_off.png" alt=""></button>

              </div>

    </form>
    <div class="panel-pagination">
     <?php echo $results; ?>
    </div>
  </div>
  <div class="panel-pagination-info">
  <?php echo $pagination; ?>
  </div>
<?php //var_dump($arra_rpdarr); ?>
<?php if(!empty($arra_rpdarr)){ ?>
<div class="after-panel-pagination-info">
<div class="container-Empfehlungen">
  <?php if(isset($dog_name)): ?>
  <div class="row">
    <h2>Zur Unterstützung empfehlen wir <?php echo $dog_name; ?> folgende, natürliche Nahrungsergänzung:</h2>
  </div>
<?php endif; ?>
  <div class="row">
    <h3>Nahrungsergänzung</h3>
  </div>
  <div class="row">
<?php foreach ($arra_rpdarr as $product) {
?>
<section class="article-grid-item col-md-3 col-sm-3  Empfehlungen-img">
    <div class="product-list-image col-md-3 col-sm-3">
        <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"></a>
    </div>
    <div class="col-md-9 col-sm-9 product-container" >
      <div class="article-list-item-main">
    <div class="title">
          <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
        </div>
    <div class="description">
        <?php echo $product['description']; ?>
    </div>
      </div>

                <?php if ($product['price']) { ?>
                 <div class="price">
          <a href="<?php echo $product['href']; ?>">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price_full_formatted']; ?>
      <?php if ($product['weight'] < 1) { ?>
          <span class="small"> <?php if($product['currency_position']=='l') {echo $product['currency'];} echo round($product['price_full']/$product['weight']/10, 2); if($product['currency_position']=='r') {echo $product['currency'];} ?> pro 100 g<br></span></a>
            <?php } else {?>
          <span class="small"> <?php if($product['currency_position']=='l') {echo $product['currency'];} echo round($product['price_full']/$product['weight'], 2);  if($product['currency_position']=='r') {echo $product['currency'];} ?> pro kg<br></span></a>
            <?php } ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
          </a>
                  <?php if ($product['tax']) { ?>
                  <span class="small tax"><?php echo $text_tax; ?> <?php echo $product['tax_rate'][0]['name']; ?><a class="" href="#">Versand</a></span>


                  <?php } ?>
                 </div>
                <?php } ?>

    </div>
    <div class="article-list-item-bottom">
      <div class="article-list-item-delivery">
        <p>
            <span class="label-list">Versandgewicht je Stück: </span> <?php echo round($product['weight'], 1); ?> kg
        </p>
      </div>
      <div class="article-list-item-button payment_buttons">
        <span class="quantity_container">
          <input type="text" name="products_qty" id="qty_<?php echo $product['product_id']; ?>" class="article-count-input" value="<?php echo $product['minimum']; ?>">
        </span>
        <button onclick="cart.add('<?php echo $product['product_id']; ?>', $('#qty_<?php echo $product['product_id']; ?>').val());" class="button_green"><?php echo $button_cart; ?></button>

      </div>
    </div>
</section>
<?php
$dl_products .= '     {
  \'name\': \''.$product['name'].'\',       // Name or ID is required.
  \'id\': \''.$product['model'].'\',
  \'price\': \''.$product['price_full'].'\',
  \'category\': \''.$product['category'].'\',
  \'list\': \'Category page\',
  \'position\': '.$counter.'
},';
$counter++;
}?>
</div>
</div>
</div>
<?php } ?>
                  <?php if($products ) { ?>
                    <!-- form for sending email BEGIN -->
                    <div style="clear: both;"></div>
                    <form class="form-discount">
                      <h3 style="background-color: #7e842e; color: #fff; font-family: Arial,Helvetica,Sans-Serif; font-size: 14px; font-style: normal; font-weight: 700; padding: 8px 10px; margin-bottom: 15px; text-align: center">10% Nachlass für  <span class="dog-name"><?php echo @$_GET['dog_name']; ?></span></h3>
                      <div class="form-group">
                        <label class="sr-only">Email address:</label>
                        <input type="email" name="discount_email" class="form-control" placeholder="Email" required>

                        <button type="button" id="submit_discount" class="button_green">Bekomme 10% Nachlass</button>
                      </div>
                    </form>
                    <!-- form for sending email END -->
                  <?php } ?>

</div><!-- end right container -->
<?php if($products ) { ?>
  <?php $found_products = array(); ?>
  <?php foreach ($products as $product) { ?>
    <?php $found_products[] = (int)$product['product_id']; ?>
  <?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#submit_discount').on('click', function() {
  var email = $('input[name=\'discount_email\']').val();

  if(email.length > 7) {
    $(".form-discount").find(".has-error").removeClass("has-error");
    $.ajax({
      url: 'index.php?route=product/consultant/sendCoupon',
      type: 'post',
      data: 'email=' + email + '&dogname=' + $(".form-discount .dog-name").html() + '&products=<?php echo implode(",", $found_products); ?>',
      //dataType: 'json',
      success: function(json) {
        if(json['message']) {
          alert(json['message']);
        }
        console.log(json);
      }
    });

    //$('input[name=\'discount_email\']').val('');
  } else {
    console.log("")
    $("[name=discount_email]").parent().addClass("has-error");
  }

});
$(".form-discount").on("submit", function(e){
  e.preventDefault();
})
//--></script>

<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>

<?php echo $footer; ?>

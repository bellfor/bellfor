<?php echo $header; ?>
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

    <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
            

<div class="col-md-9 col-md-push-3 col-xs-12 right-container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6" id="content">

          <?php if ($thumb || $images) { ?>
            <?php if ($thumb) { ?>
          <div class="wrap_card">
            <img class="card" src="<?php echo $thumb; ?>" data-large="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>">
          </div>			
            <?php } ?>
            <?php if ($images) { $i=1;?>
          <div class="wrap_photo_card" >  			
            <?php foreach ($images as $image) { ?>
			  <div class="wrap_small_card">
          <img class="for-popap-<?php echo $i; ?>" src="<?php echo $image['thumb']; ?>" data-large="<?php echo $image['popup']; ?>">
        </div>
            <?php $i++;} ?>
               
            <?php } ?>
		 </div>	
          <?php } ?>		

          
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6" >
          <div class="text-product">
            <h2><?php echo $heading_title; ?></h2>
            <dl>
              <dt>Art.Nr.:</dt>
              <dd class="products_model"><?php echo $model; ?></dd>
            </dl>
            <div class="blockpricing">
              <h4>Staffelpreise</h4>
          <?php if ($price) { ?>
          <ul class="list-unstyled">
            <?php if (!$special) { ?>
              <dl>
                    <dt>1 Stk.</dt>
                <dd>je  <?php echo $price_full_formatted; ?> 			
			<?php if (isset($weight) && ($weight > 0)) { ?> 	(<?php echo round($price_full/$weight, 2); ?> <?php echo $currency; ?> pro kg)
            <?php } ?>	
		       </dd>
				</dl>			
            <?php } else { ?>
              <dl>
                    <dt>1 Stk.</dt>					
                <dd>je  <?php echo $price_full_formatted; ?> 			
			<?php if (isset($weight) && ($weight > 0)) { ?> 	(<?php echo round($price_full/$weight, 2); ?> <?php echo $currency; ?> pro kg)
            <?php } ?>	
		       </dd>
				</dl>	
            <?php } ?>
            <?php if ($points) { ?>
            <li><?php echo $text_points; ?> <?php echo $points; ?></li>
            <?php } ?>
            <?php if ($discounts) { ?>
            <?php foreach ($discounts as $discount) { ?>
              <dl>
                    <dt><?php echo $discount['quantity']; ?> Stk.</dt>
			<?php if (isset($weight) && ($weight > 0)) { ?> 					
                <dd>je  <?php echo $discount['price_full_formatted']; ?> (<?php echo str_replace(".", ",", round($discount['price_full']/$weight, 2)); ?> EUR pro kg)</dd>
            <?php } ?>				
			 </dl>	
            <?php } ?>
            <?php } ?>
          </ul>
          <?php } ?>			  
			  
            </div>
            <div class="price-container">
              <div class="price"> <h2><?php echo $price_full_formatted; ?></h2>
			<?php if (isset($weight) && ($weight > 0)) { ?>  
			<?php if ($weight < 1) { ?> 
                <span class="small"> <?php echo round($price_full/$weight/10, 2); ?> EUR pro 100 g<br></span>
            <?php } else {?>				
                <span class="small"> <?php echo round($price_full/$weight, 2); ?> EUR pro kg<br></span>
            <?php } ?>				
            <?php } ?>
			<?php if ($tax) { ?>
                <span class="small"><?php echo $text_tax; ?> <?php echo $tax_rate[0]['name']; ?>
                  <a class="" href="#">Versand</a>
                </span>			
            <?php } ?>				
              </div>
            </div>

    <div class="price-container-bottom">            

      <div class="price-container-button">
                              
          <span class="quantity_container">
            <input type="text" name="products_qty" id="qty" class="article-count-input" value="1">
          </span>
          <a href="#"  onclick="cart.add('<?php echo $product_id; ?>', $('#qty').val()); return false;" class="button_green"><img src="catalog/view/theme/default/image/icon-white-shoppingcart.png" alt="">In den Warenkorb</a>
      </div>

      <div class="leaflet"><a href="#" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product_id; ?>'); return false;" class="button_details_add_wishlist"><?php echo $button_wishlist; ?></a></div>

      <div class="details_products_weight">
        Versandgewicht je Stück:  <?php echo $weight_formatted; ?>
      </div>

  </div>
          </div>
        </div>
    </div>
     <div class="text-container">
<?php echo $description; ?>
     </div>

        <div>
<?php if ($product_tabs) { ?>
  <!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">  
 <?php $tab_count = 0; foreach($product_tabs as $product_tab) { ?>
 <li role="presentation"<?php if ($tab_count == 0) { echo ' class="active"'; } ?>><a href="#tab_<?php echo $product_tab['product_tab_id']; ?>" aria-controls="<?php echo $product_tab['title']; ?>" role="tab" data-toggle="tab"><?php echo $product_tab['title']; ?></a></li>
 <?php $tab_count++; } ?>
</ul> 
  <!-- Tab panes -->
<div class="tab-content">  
 <?php $tab_count = 0; foreach($product_tabs as $product_tab) { ?>  
    <div role="tabpanel" class="tab-pane<?php if ($tab_count == 0) { echo ' active'; } ?>" id="tab_<?php echo $product_tab['product_tab_id']; ?>">
   <?php echo $product_tab['description']; ?>
   </div>
 <?php $tab_count++; } ?>
</div> 
<?php } ?>
       </div>

            <?php if ($review_status) { ?>
              <form class="form-horizontal" id="form-review">
                <div id="review" class="rating"></div>
                <h2><?php echo $text_write; ?></h2>
                <?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><?php echo $entry_review; ?></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">

                    <label class="control-label"><?php echo $entry_rating; ?></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                  
                    <input type="text" name="rating" value="0" style="display: none"/>

                    <div class="stars_in_form">
                      <?php for ($i = 1; $i <= 5; $i++) { ?>
                      <?php if (0 < $i) { ?>
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
                    <script type="text/javascript"><!--
                    function showRating(rating, countStars){
                      var fullStar = 
                        '<i class="fa fa-star fa-stack-2x"></i>'+
                        '<i class="fa fa-star-o fa-stack-2x"></i>';
                        var emptyStar = 
                        '<i class="fa fa-star-o fa-stack-2x"></i>';
                        for (var i = 1; i <= countStars; i++) {
                          if(rating < i)
                            $(".star-"+i).html(emptyStar);
                          else
                            $(".star-"+i).html(fullStar);
                          }
                    }
                    function starListeners(starNumber, countStars){
                      $(".star-"+starNumber).click(function() {
                        showRating(starNumber, countStars);
                        $('input[name="rating"]').val(starNumber);
                      });
                    }
                    var countStars = 5;
                    for (var i = 1; i <= countStars; i++){
                      starListeners(i,countStars);
                    }
                    //--></script>
                    
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                <?php echo $captcha; ?>
                <div class="buttons clearfix">

				  
				  
                  <div class="button-cont">
                  <button type="button" data-loading-text="<?php echo $text_loading; ?>" class="button_blue button_set" id="button-review"><span class="button-outer"><span class="button-inner"><?php echo $button_continue; ?></span></span></button>
                  </div>
				  
                </div>
                <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            <?php } ?>

      <?php if ($products) { ?>
      <div class="container-Empfehlungen">
      <h2><?php echo $text_related; ?></h2>	  
      <div class="row">	  
        <?php $i = 0; ?>
        <?php foreach ($products as $product) { ?>
		
    <div class="col-md-3 col-sm-3 Empfehlungen-img" >
        <a href="<?php echo $product['href']; ?>" target="_blank"><img src="<?php echo $product['thumb']; ?>"></a>
        <div class="title">
          <a href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
        </div>
        <div class="price">
          <a href="<?php echo $product['href']; ?>"> <?php echo $product['price']; ?></a>
          <span class="small"> <?php echo round($price/$weight, 2); ?> <?php echo $currency; ?> pro kg<br></span>
        </div>
  </div>
      
        <?php $i++; ?>
        <?php } ?>
      </div> <!-- closing container-Empfehlungen -->
	  </div>
      <?php } ?>

</div>

<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').val(json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
//--></script>
<?php echo $footer; ?>

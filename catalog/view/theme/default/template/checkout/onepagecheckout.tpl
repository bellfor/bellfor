<?php echo $header; ?>
<style>
#billing-address-load {display:none}
</style>

			<script type="text/javascript"><!--
			dataLayer.push({
            "event": "checkout",
            "ecommerce": {
            "checkout": {
            "products": [
			<?php foreach ($products as $product) { ?>
			{
            "id": "<?php echo $product['model']; ?>",
            "name": "<?php echo $product['name']; ?>",
            "price": "<?php echo $product['price_main']; ?>",
            "category": "<?php echo $product['category']; ?>",
            "quantity": <?php echo $product['quantity']; ?>,
            "offerprice": "<?php echo str_replace(array(" EUR", ","), array("", "."), $product['price']); ?>"
			},
            <?php } ?>
     ]
    }
  }
});

			//--></script>
<script src="https://www.paypalobjects.com/webstatic/ppplus/ppplus.min.js" type="text/javascript"></script>
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

        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <div class="row">
          <div id="content">
            <h1 class="header_onepagecheckout"><?php echo $heading_title ?></h1>
            <div class="checkout checkout-checkout">
              <div class="payment">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 payment-data">

                <?php if(!$c_logged) { ?>
                <div id="login_warning" class="checkout-content note">
                  <?php echo $text_notlogged ?>
                </div>
                <?php } ?>

                  <div id="payment-address">
                    <div class="checkout-content" style="overflow: hidden; display: block;">
                      <div class="fields-group row_forInputs">
                        <?php if($c_logged) { ?>
                        <div class="left_input">
                          <label for="firstname-ch"> <?php echo $text_first_name; ?>:</label><br>
                          <input type="text" class="form-control large-field" id="firstname-ch" name="firstname"
                                 value="<?php echo $f_name; ?>"/><!-- logged in -->
                          <span class="error"></span>
                        </div>
                        <div class="right_input">
                          <label for="lastname-ch"> <?php echo $text_last_name; ?>:</label><br>
                          <input type="text" class="form-control large-field" id="lastname-ch" name="lastname"
                                 value="<?php echo $l_name; ?>"/><!-- logged in -->
                          <span class="error"></span>
                        </div>
                        <?php } else { ?>
                        <div class="fields-group left_input">
                          <label for="firstname-ch"><?php echo $text_first_name; ?><span class="required">*</span>:</label><br>
                          <input type="text" id="firstname-ch" name="firstname" value=""
                                 class="form-control large-field">
                        <span class="error"></span>
                        </div>
                        <div class="fields-group right_input">
                          <label for="lastname-ch"><?php echo $text_last_name; ?><span class="required">*</span>:</label><br>
                          <input type="text" id="lastname-ch" name="lastname" value=""
                                 class="form-control large-field">
                        <span class="error"></span>
                        </div>
                        <?php }?>
                      </div>
                      <div class="fields-group">
                        <label for="address-ch"><?php echo $text_address; ?><span class="required">*</span>:</label><br>
                        <input type="text" id="address-ch" name="address_1" value="<?php echo $address_1; ?>"
                               class="form-control large-field">
                        <span class="error"></span>
                      </div>
                      <div class="row_forInputs clearfix">
                        <div class="fields-group left_input">
                          <label for="zip-ch"><?php echo $text_zip; ?><span class="required">*</span>:</label><br>
                          <input type="text" id="zip-ch" name="zip" value="<?php echo $zip; ?>"
                                 class="form-control large-field">
                          <span class="error"></span>
                        </div>
                        <div class="fields-group right_input">
                          <label for="city-ch"><?php echo $text_town; ?><span class="required">*</span>:</label><br>
                          <input type="text" id="city-ch" name="city" value="<?php echo $city; ?>"
                                 class="form-control large-field">
                          <span class="error"></span>
                        </div>
                      </div>
                      <div class="fields-group">
                        <label for="input-payment-country"><?php echo $text_country; ?><span class="required">*</span></label>

                        <select onChange="getShipping(this.value)" name="country_id" id="input-payment-country"
                                class="form-control">
                          <option value=""><?php echo $text_select_country; ?></option>
                          <?php foreach ($countries as $country) { ?>
                          <?php if ((isset($country_id) && ($country['country_id'] == $country_id)) || (!isset($country_id) && ($country['country_id'] == 81)))  { ?>
                          <option value="<?php echo $country['country_id']; ?>"
                                  selected="selected"><?php echo $countries_de[$country['country_id']]; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $country['country_id']; ?>"><?php echo $countries_de[$country['country_id']]; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select>
                        <span class="error"></span>
                      </div>
                      <div class="fields-group">
                        <label for="email-ch"><?php echo $text_email; ?><span class="required">*</span>:</label><br>
                        <input type="text" id="email-ch" name="email" value="<?php echo $email; ?>"
                               class="form-control large-field">
                        <span class="error"></span>

                      </div>
                      <div class="fields-group">
                        <label for="telephone-ch"><?php echo $text_telephone; ?>:</label><br>
                        <input type="tel" id="telephone-ch" name="telephone"
                               value="<?php echo $telephone; ?>" class="form-control large-field">
                        <span class="error"></span>

                      </div>

                      <div class="fields-group checkboxes_for_payment">
                        <div class="checkbox_wraper">
                          <div class="checkbox_belf">
                            <input type="checkbox" value="1" id="checkbox_belf111" name="create_account"
                                   checked="checked">
                            <label for="checkbox_belf111"></label>
                          </div>
                          <p><?php echo $text_create_account; ?></p>
                        </div>
                        <div class="checkbox_wraper">
                          <div class="checkbox_belf">
                            <input type="checkbox" id="checkbox_is_show_form_address" name="payment_address_different">
                            <label for="checkbox_is_show_form_address"></label>
                          </div>
                          <p><?php echo $text_payment_address_different; ?></p>
                        </div>
                      </div>
                      <div id="form_address_2" class="cleafix" style="display: none;">
                        <div class="fields-group row_forInputs">
                          <?php if($c_logged) { ?>
                          <div class="left_input">
                            <label for="shipping-firstname-ch"><?php echo $text_first_name; ?>:</label><br>
                            <input type="text" class="form-control large-field" id="shipping-firstname-ch" name="shipping_firstname"
                                   value="<?php echo $f_name; ?>" />
                          </div>
                          <div class="right_input">
                            <label for="shipping-lastname-ch"><?=$text_last_name?>:</label><br>
                            <input type="text" class="form-control large-field" id="shipping-lastname-ch" name="shipping_lastname"
                                   value="<?php echo $l_name; ?>" />
                          </div>
                          <?php } else { ?>
                          <div class="left_input">
                            <label for="shipping-firstname-ch"><?php echo $text_first_name; ?><span class="required">*</span>:</label><br>
                            <input type="text" id="shipping-firstname-ch" name="shipping_firstname" value=""
                                   class="form-control large-field">
                          </div>
                          <div class="right_input">
                            <label for="shipping-lastname-ch"><?php echo $text_last_name; ?><span class="required">*</span>:</label><br>
                            <input type="text" id="shipping-lastname-ch" name="shipping_lastname" value=""
                                   class="form-control large-field">
                          </div>
                          <span class="error"></span>
                          <?php }?>
                        </div>
                        <div class="fields-group">
                          <label for="shipping-address-ch"><?php echo $text_address; ?><span class="required">*</span>:</label><br>
                          <input type="text" id="shipping-address-ch" name="shipping_address_1" value="<?php echo $address_1; ?>"
                                 class="form-control large-field">
                          <span class="error"></span>
                        </div>
                        <div class="row_forInputs clearfix">
                          <div class="fields-group left_input">
                            <label for="shipping-zip-ch"><?php echo $text_zip; ?><span class="required">*</span>:</label><br>
                            <input type="text" id="shipping-zip-ch" name="shipping_zip" value="<?php echo $zip; ?>"
                                   class="form-control large-field">
                            <span class="error"></span>
                          </div>
                          <div class="fields-group right_input">
                            <label for="shipping-city-ch"><?php echo $text_town; ?><span class="required">*</span>:</label><br>
                            <input type="text" id="shipping-city-ch" name="shipping_city" value="<?php echo $city; ?>"
                                   class="form-control large-field">
                            <span class="error"></span>
                          </div>
                        </div>
                        <div class="fields-group">
                          <label for="input-shipping-country"><?php echo $text_country; ?><span class="required">*</span></label>

                          <select onChange="getShipping(this.value)" name="shipping_country_id" id="input-shipping-country"
                                  class="form-control">
                            <option value=""><?php echo $text_select_country; ?></option>
                            <?php foreach ($countries as $country) { ?>
                            <?php if (isset($_REQUEST['country_id']) && ($country['country_id'] == $_REQUEST['country_id'])) { ?>
                            <option value="<?php echo $country['country_id']; ?>"
                                    selected="selected"><?php echo $countries_de[$country['country_id']]; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $country['country_id']; ?>"><?php echo $countries_de[$country['country_id']]; ?></option>
                            <?php } ?>
                            <?php } ?>
                          </select>
                          <span class="error"></span>
                        </div>
                        <div class="fields-group">
                          <label for="shipping-telephone-ch"><?php echo $text_telephone; ?>:</label><br>
                          <input type="tel" id="shipping-telephone-ch" name="shipping_telephone"
                                 value="<?php echo $telephone; ?>" class="form-control large-field">
                          <span class="error"></span>

                        </div>
                      </div>
                      <div class="fields-group">
                        <label for="comment_field">  <?php echo $text_comment; ?>:</label><br>
                        <input type="text" id="comment_field" class="form-control large-field" name="comment"
                               value="<?php echo $comment ?>">
                      </div>
					  <div class="fields-group checkboxes_for_payment">
					  <div class="checkbox_wraper">
                          <div class="checkbox_belf">
                            <input type="checkbox" value="1" id="checkbox_newsletter" name="newsletter" checked="checked">
                            <label for="checkbox_newsletter"></label>
                          </div>
                          <p><?php echo $text_optin; ?></p>
                      </div>
					  </div>
                      <input type="hidden" name="shipping_method" value="">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 checkout-data">
                  <div class="cart-info table-responsive checkout-data__margin_fix">
                    <table class="table">
                      <thead>
                      <tr>
                        <td class="name t-head">  <?php echo $text_product; ?></td>
                        <td class="price t-head"><?php echo $text_price; ?></td>
                        <td class="quantity t-head"><?php echo $text_quantity; ?></td>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($products as $product) { ?>
                      <tr>
                        <td class="name">
                          <a href="/index.php?route=product/product&product_id=<?php echo $product['product_id'] ?>" class="product_name_onepagecheckout"><?php echo $product['name'] ?></a>
                          <div class="p-model">
                            <?php echo $product['model'] ?>
                          </div>
                          <div class="cart-option">
                            <?php foreach ($product['option'] as $option) { ?>
                            -
                            <small><?php echo $option['name']; ?>
                              : <?php echo $option['value']; ?></small>
                            <br/>
                            <?php } ?>
                            <?php if ($product['recurring']): ?>
                            -
                            <small><?php echo $text_payment_profile ?>
                              : <?php echo $product['profile_name'] ?></small>
                            <?php endif; ?>
                          </div>
                        </td>
                        <td class="price"><?php echo $product['price'] ?>   </td>
                        <td class="quantity"><?php echo $product['quantity'] ?>   </td>
                      </tr>

                      <?php } ?>
                    </table>
                    <hr/>
                    <table id='totals' class='table'>
                      <tbody>
                      <?php foreach ($totals as $total) { ?>
					  <?php if ($total['text']!=='0,00 EUR') { ?>
                      <tr class="subtotal">
                        <td class="name subtotal"><strong><?php echo $total['title']; ?>:</strong></td>
                        <td class="price"><?php echo $total['text']; ?></td>
                      </tr>
                      <?php }
					          } ?>

                      </tbody>
                    </table>
  <!-- fixed by oppo webiprog.com  03.05.2018 MAR-251 MAR-243 -->
  <!-- Selecting a delivery method between DPD and DHL for German customers -->
          <div id="radio-delivery" style="margin-bottom:10px;padding:0px 8px;border:1px solid #ddd;background-color: #F3F3F3" class="wrap_radio_payment">
            <div style="margin-top: 13px;margin-right: 10px;" class="pull-left">
              <?php echo $text_delivery_method ; ?>:</div>

            <div class="pull-left radio-delivery-item dhl">
              <div class="radio" data-role="controlgroup" data-type="horizontal">
                <input type="radio" id="deliveryDHL" name="delivery" value="DHL" />
                <label style="margin-top: 3px;" for="deliveryDHL"><img alt="DHL" border="0" src="image/catalog/dhl_s.png" style="height:18px;margin-right:2px;" />DHL</label>
              </div>
            </div>

            <div style="margin-left:10px; display: none;" class="pull-left radio-delivery-item dhle">
              <div class="radio" data-role="controlgroup" data-type="horizontal">
                <input type="radio" id="deliveryDHLE" name="delivery" value="DHL Express" />
                <label style="margin-top: 3px;" for="deliveryDHLE"><img alt="DHL Express" border="0" src="image/catalog/dhl express_s.png" style="height:18px;margin-right:2px;" />DHL Express</label>
              </div>
            </div>

            <div style="margin-left:10px; display: none;" class="pull-left radio-delivery-item dpd">
              <div class="radio" data-role="controlgroup" data-type="horizontal">
                <input type="radio" id="deliveryDPD" name="delivery" value="DPD" />
                <label style="margin-top: 3px;" for="deliveryDPD"><img alt="DPD" border="0" src="image/catalog/dpd_s.png" style="height:18px;margin-right:2px;" />DPD</label>
              </div>
            </div>

            <div class="clearfix"></div>
          </div>
          <div id="radio-delivery-text" style="display:none;margin-bottom:10px;padding:9px 8px;border:1px solid #ddd;;background-color: #F3F3F3">
            <div style="margin-top: 0px;margin-right: 10px;" class="delivery-text">
              <?php echo $text_delivery_method ; ?>:
              <span style="font-weight: bold" id="span-delivery-text"></span>
            </div>
          </div>
<!-- //end fixed by oppo webiprog.com 02.05.2018 -->

					<div id="shipping-terms">
					</div>
                    <?php echo $content_bottom; ?>
					<div id="payment-methods-container">

					</div>
                        <div class="button_blue button_set" id="payments-load">
                                <span class="button-outer">
                                  <span class="button-inner"><?php echo $text_display_payment_methods ;
								  //fixed by oppo webiprog.com  18.12.2017
								  //MAR-128 - Lieferfrist: bis zu 3 Tagen / Delivery time: up to 3 days ?></span>
                                </span>
                        </div>

                  </div>
                  <div class="hiden_payment_info fields-group"></div>
                  <div class="col-xs-12 checkout-subinfo">
                    <?php if (isset($content_bottom)) {?>
                        <?php echo $content_bottom; ?>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="LoginModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3><?php echo $text_returning_customer; ?></h3>
                </div>
                <div class="modal-body">

                  <p><strong><?php echo $text_i_am_returning_customer; ?></strong></p>
                  <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                      <input type="text" name="email" value="<?php echo $email; ?>"
                             placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control"/>
                    </div>
                    <div class="form-group">
                      <label class="control-label" for="input-password"><?php echo $entry_password; ?></label>
                      <input type="password" name="password" value="" placeholder="<?php echo $entry_password; ?>"
                             id="input-password" class="form-control"/>
                      <a class="link_password" href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a>
                    </div>

                    <div class="button_blue button_set submit-login-form">
                          <span class="button-outer">
                            <span class="button-inner"><?php echo $button_login; ?></span>
                          </span>
                    </div>

                    <a href="<?php echo $register ?>" class="button_blue button_set">
                          <span class="button-outer">
                            <span class="button-inner"><?php echo $text_register; ?></span>
                          </span>
                    </a>

                  </form>
                  <div class="errors-block"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
  $(document).ready(function () {
    var checkbox = $('#checkbox_is_show_form_address');
    var form = $('#form_address_2');
    if (checkbox.is(':checked'))
      form.css('display', 'block');
    else form.css('display', 'none');
    checkbox.on('click', function () {
      if (checkbox.is(':checked'))
        form.css('display', 'block');
      else form.css('display', 'none');
    });

	var country_selected = $('#input-payment-country').val();
	if (country_selected > 0) {
	getShipping (country_selected);
	}
  });

  function getShipping(s) {
    shipping(s);
     //ajax

	if (s == 81) {
	$('#shipping-terms').text('<?php echo $text_shipping_terms_3 ; ?>');
	} else {
	$('#shipping-terms').text('<?php echo $text_shipping_terms_6 ; ?>');
	}
	//204, 195, 97, 74, 21
  //fixed by oppo webiprog.com  03.05.2018 MAR-251 MAR-243
  //Selecting a delivery method between DPD and DHL for German customers
	$("#radio-delivery input[name=delivery]").prop("checked", false);
	$('#radio-delivery-text').hide();
	$('#span-delivery-text').html('');
	// if (s == 81 || s == 14) {
	if (s == 195 || s == 97 || s == 74 || s == 21) {
	    $('#radio-delivery >.dhl').hide('100');
        $('#radio-delivery >.dpd').show('100');
	    $('#radio-delivery').show();
		$("#deliveryDPD").prop("checked", true);
	} else {
	    $('#radio-delivery >.dhl').show('100');
        $('#radio-delivery >.dpd').hide('100');
	    $('#radio-delivery').show();
		$("#deliveryDHL").prop("checked", true);
	}
	if (s == 81) {
        $('#radio-delivery >.dhle').show('100');
    } else {
        $('#radio-delivery >.dhle').hide('100');
    }
	SetRumun(1);
    //end fixed by oppo webiprog.com  03.05.2018

  }

    function shipping(s, sm) {
      if (!sm) {

          sm = null;
      }
        console.log(sm);
        $.ajax({
                url: 'index.php?route=checkout/onepagecheckout/getshipping',
                type: 'post',
                data: 'country_id=' + s + '&shipping_method=' + sm,
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (json) {
                    $('.alert, .text-danger').remove();
                    if (json['error']) {
                        if (json['error']['warning']) {
                            alert(json['error']['warning']);
                        }
                    } else {
                        sh = json;
                        $.ajax({
                                url: 'index.php?route=checkout/onepagecheckout/setshipping',
                                type: 'post',
                                data: sh,
                                dataType: 'json',
                                beforeSend: function () {

                                },
                                success: function (json) {
                                    if (json['error']) {
                                        if (json['error']['warning']) {
                                            alert(json['error']['warning']);
                                        }
                                    } else {
                                        $.ajax({
                                            url: 'index.php?route=checkout/onepagecheckout/totals',
                                            type: 'get',
                                            success: function (json) {
                                                $('#totals tbody').remove();
                                                $('#totals').append('<tbody></tbody>');
                                                for (t in json['totals']) {
                                                    if(json['totals'][t]["text"]!=='0,00 EUR') {
                                                        $('#totals tbody').append('<tr class="name subtotal"><td class="name subtotal"><strong>' + json['totals'][t]['title'] + '</strong></td><td class="price">' + json['totals'][t]["text"] + '</td></tr>');
                                                    }
                                                }
                                            }
                                        });
                                        // Update Totalsi!
                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                        });

                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
        });
    }

  //fixed by oppo webiprog.com  02.05.2018 MAR-251 MAR-243
  //Selecting a delivery method between DPD and DHL for German customers
        function SetRumun(rep) {
		  var $hide_radio = rep || 0;

          if ($hide_radio==0) {
		  $('#radio-delivery').hide();
		  }
          //$("#radio-delivery input[name=delivery]").change(function() {      //});
          //ajax-button-confirm #payments-load
          var $checked_delivery_radio = $('#radio-delivery input:radio[name=delivery]:checked').val();
          var $country_selected = $('#input-payment-country').val();
          if ($checked_delivery_radio === undefined) {
              $checked_delivery_radio = '';
          }
          $.ajax({
              type: "POST",
              url: "index.php?route=checkout/onepagecheckout/rumun",
              data: {
                  'rumun_id': $checked_delivery_radio,
                  'country_selected': $country_selected
              },
              success: function (response) {
                  //  $('#radio-delivery').hide();
                  if (response && $hide_radio==0) {
                      $('#radio-delivery-text').show();
                      $('#span-delivery-text').html('<img alt="'+response+'" border="0" src="image/catalog/'+response.toLowerCase()+'_s.png" style="height:18px;margin-right:2px;" />'+response);
                  }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                  console.log(thrownError);
              }
          });
      }
  $('#deliveryDHLE').on('click', function () {
      $('#dhl-express').removeClass('hide');
      $('#shipping-terms').addClass('hide');
  });

  $('#deliveryDHL').on('click', function () {
    $('#dhl-express').addClass('hide');
    $('#shipping-terms').removeClass('hide');
  });

  $(document).ready(function () {

      $("#radio-delivery input[name=delivery]").change(function() {
		  var open_payment = $('payment-methods-container').size();
		  if (open_payment>0) {
		  SetRumun(1);
		  }
      });
      $('#payments-load').on('click', function () {
          SetRumun();
          if ($('#deliveryDHLE').prop("checked")) {
            shipping(81, 'DHLE');
          }
      });
  });
  //end fixed by oppo webiprog.com  02.05.2018


  $(document).ready(function () {

    $(' #LoginModal .submit-login-form ').on('click', function () {
      $.ajax({
          url: 'index.php?route=checkout/onepagecheckout/AjaxLogin',
          type: 'post',
          data: $('#LoginModal #input-email, #LoginModal #input-password '),
          dataType: 'json',
          beforeSend: function () {

          },
          success: function (json) {
            console.log(json);
            if (json.errors != 0) {
              if (typeof json.errors.warning != 'undefined' && json.errors.warning != '')
                $('#LoginModal .errors-block').html(json.errors.warning);
              if (typeof json.errors.errors != 'undefined' && json.errors.errors != '')
                $('#LoginModal .errors-block').append('<br>' + json.errors.error);
            }
            else if (json.errors == 0) {
              $('#firstname-ch').prop('value', json.f_name);
			  $('#firstname-ch').prop('readonly', 'true');
              $('#lastname-ch').prop('value', json.l_name);
              $('#lastname-ch').prop('readonly', 'true');
              $('#city-ch').prop('value', json.city);
              $('#zip-ch').prop('value', json.zip);
              $('#address_1').prop('value', json.address_1);
              $('#email-ch').prop('value', json.email);
              $('#telephone-ch').prop('value', json.telephone);
              $('#LoginModal').modal('hide');
              $('#login_warning').html('');
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        }
      ); //ajax
      return false;
    });

	$('#payments-load').on('click', function () {

 $.ajax({
        url: 'index.php?route=checkout/load_payments',
        type: 'post',
        data: $('.checkout-checkout .payment-data input[type=\'text\'], .checkout-checkout .payment-data input[type=\'tel\'], .checkout-checkout .payment-data input[type=\'radio\']:checked, .checkout-checkout .payment-data input[type=\'checkbox\']:checked, .checkout-checkout .payment-data  select '),
        dataType: 'html',
        beforeSend: function () {
          $('#payments-load').addClass('preloader');

        },
        complete: function () {
          $('#payments-load').removeClass('preloader');

        },
        success: function (html) {
		  $('#payment-methods-container').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });

	});

  });//--></script>

<?php echo $footer; ?>

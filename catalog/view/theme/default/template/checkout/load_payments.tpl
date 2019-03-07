<div class="fields-group payment-data" id="payment-methods" data-test="asdf">
    <?php if ($payment_methods) { ?>
        <p><?php echo $text_payment_method; ?></p>
    <?php foreach ($payment_methods as $payment_method) { ?>
        <div class="wrap_radio_payment">
            <div class="radio">

                <?php if ($payment_method['code']) { ?>
                    <!-- <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" /> -->
                    <input id="payment_method<?php echo $payment_method['code']; ?>" type="radio" name="payment_method"
                           value='{"title": "<?php echo $payment_method['title'] ?>", "code": "<?php echo $payment_method['code'] ?>"}'
                           checked="checked">
                <?php } else { ?>
                    <!-- <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" /> -->
                    <input id="payment_method<?php echo $payment_method['code']; ?>" type="radio" name="payment_method"
                           value='{"title": "<?php echo $payment_method['title'] ?>", "code": "<?php echo $payment_method['code'] ?>"}'
                           checked="checked">
                <?php } ?>
                <label for="payment_method<?php echo $payment_method['code']; ?>">
                    <?php echo $payment_method['title']; ?>


                    <?php if ($payment_method['terms']) { ?>
                        (<?php echo $payment_method['terms']; ?>)
                    <?php } ?></label>
                <?php if ($payment_method['code'] == "pp_plus") {
                    echo ' <div id="ppp_notification" class="alert alert-warning" style="display: none;">' . $ppp_notification . '</div>'; ?>
                    <div id="ppplus" style="height: 100%;width:600px; max-width:100%;"></div><?php } ?>
            </div>
        </div>

    <?php if ($payment_method['code'] == "pp_plus") { ?>
        <script type="text/javascript"><!--
            var ppp = PAYPAL.apps.PPP({
                "approvalUrl": "<?php echo $pp_plus_link; ?>",
                "placeholder": "ppplus",
                "country": "<?php echo $country; ?>",
                "language": "<?php echo $language; ?>",
                "buttonLocation": "outside",
                "enableContinue": function (data) {
                    $("input#payment_methodpp_plus").prop("checked", true);
                    $('#button-payment-method').prop('disabled', false);
                    $('#ppp_notification').hide();
                },
                "disableContinue": function (data) {
                    if ($("input#payment_methodpp_plus").is(":checked")) {
                        $('#button-payment-method').prop('disabled', true);
                        $('#ppp_notification').show();
                    }
                },
                "preselection": "paypal",
                "showPuiOnSandbox": true,
                "showLoadingIndicator": true,
                "mode": "<?php echo str_replace('.', '', $pp_plus_mode); ?>",
                "useraction": "commit",
                "styles": {
                    "psp": {
                        "font-size": "14px",
                        "font-family": "Arial,Tahoma,Verdana",
                        "color": "#666",
                    }
                }
            });

            $(document).ready(function () {
                $('input[name=payment_method]').change(function () {
                    if (!$("input#payment_methodpp_plus").is(":checked")) {
                        $('#button-payment-method').prop('disabled', false);
                        $('#ppp_notification').hide();
                        ppp.deselectPaymentMethod();
                    }
                    else {
                        $('#button-payment-method').prop('disabled', true);
                        $('#ppp_notification').show();
                    }
                });

            });
            //--></script>
    <?php } ?>

    <?php } ?>
    <?php } ?>
</div>
<div id="confirm">
    <div class="payment">
        <div id="ajax-button-confirm" class="button_blue button_set button_green">
                                <span class="button-outer">
                                  <span class="button-inner"><?php echo $text_confirm; ?></span>
                                </span>
        </div>
    </div>
</div>

<div class="agree_text">
    <div class="pull-right fix_checkbox_button">
        <div class="checkbox_wraper">
            <p><?php echo $text_agree ?><span style="color: red;" id="agree-error"></span></p>
            <div class="checkbox_belf checkbox_agree">
                <input type="checkbox" value="1" name="agree" id="agree-ch" checked="checked">
                <label for="agree-ch"></label>
            </div>
        </div>

    </div>
</div>


<script type="text/javascript"><!--
    $('#payments-load').css('display', 'none');


    $('#ajax-button-confirm').on('click', function () {

        $.ajax({
            url: 'index.php?route=checkout/onepagecheckout',
            type: 'post',
            data: $('.checkout-checkout .payment-data input[type=\'text\'], .checkout-checkout .payment-data input[type=\'tel\'], .checkout-checkout .payment-data input[type=\'radio\']:checked, .checkout-checkout .payment-data input[type=\'checkbox\']:checked, .checkout-checkout .payment-data  select, .checkbox_agree input[type=\'checkbox\']:checked '),
            dataType: 'json',
            beforeSend: function () {
                $('#ajax-button-confirm').addClass('preloader');

            },
            complete: function () {
                $('#ajax-button-confirm').removeClass('preloader');

            },
            success: function (json) {
                console.log(json);

                if (json.error) {
                    if (json['error']['firstname']) {
                        $('#firstname-ch+.error').html(json['error']['firstname']);
                    }

                    if (json['error']['lastname']) {
                        $('#lastname-ch+.error').html(json['error']['lastname']);
                    }

                    if (json['error']['email']) {
                        $('#email-ch+.error').html(json['error']['email']);
                    }

                    if (json['error']['telephone']) {
                        $('#telephone-ch+.error').html(json['error']['telephone']);
                    }

                    if (json['error']['country_id']) {
                        $('#input-payment-country+.error').html(json['error']['country_id']);
                    }

                    if (json['error']['address_1']) {
                        $('#address_1+.error').html(json['error']['address_1']);
                    }

                    if (json['error']['city']) {
                        $('#city-ch+.error').html(json['error']['city']);
                    }

                    if (json['error']['zip']) {
                        $('#zip-ch+.error').html(json['error']['zip']);
                    }

                    if (json['error']['agree']) {
                        $('#agree-error').html('<br>' + json['error']['agree']);
                    }
                }

                else if (json['cod']) {
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=extension/payment/cod/confirm',
                        cache: false,
                        beforeSend: function () {
                            $('#ajax-button-confirm').button('loading');
                        },
                        complete: function () {
                            $('#ajax-button-confirm').button('reset');
                        },
                        success: function () {
                            location = 'index.php?route=checkout/success';
                        }
                    });
                }

                else if (json['payment']) {
                    $('.agree_text').css({display: "none"});
                    $('.hiden_payment_info').html(json['payment']);
                    $('#payment-methods').css({display: "none"});
                    $('#confirm').css({display: "none"});
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });


    });
    //--></script>

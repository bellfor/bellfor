<?php echo $header; ?>
    <link href="catalog/view/theme/default/css/styles_futterassistent.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="catalog/view/theme/default/css/styles.css" type="text/css" rel="stylesheet" media="screen" />
    <div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation">
        <?php foreach ($breadcrumbs as $breadcrumb) {
            if ($breadcrumb['text']!=='<i class="fa fa-home"></i>') {
                echo '<span>»</span>';
            } ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    </div>
    </div>
    </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="main-container clearfix">
                <?php echo $column_left; ?>
                <div id="content" class="col-md-9 col-md-push-3 col-xs-12 right-container "><?php echo $content_top; ?>
                    <div class="container_article col-md-12 padding_fix">
                        <h1><?php echo $heading_title; ?></h1>
                        <div class="tab-content">
                            <div id="description"><?php echo $description; ?></div>
                            <?php if ($status_consultant) {?>
                                <div id="content_inhaltstpl" class="tpl_futterassistent wizard_type_Hund row" style="margin: 0 -15px">
                                    <hr>
                                    <script type="text/javascript">
                                        (function ($) {
                                            $.fn.extend({
                                                wizard_img_options: function (params) {

                                                    var conf = {
                                                        mainClass: "wizard_img",
                                                        wrapperClass: "wizard_img_wrapper",
                                                        textClass: "wizard_img_text",
                                                        checkedClass: "checked",
                                                        onInit: null,
                                                        onClick: null,
                                                        elementType: "<div></div>"

                                                    };

                                                    $.extend(conf, params);

                                                    var list = $(this);
                                                    list.each(function () {
                                                        var self = $(this);
                                                        var img = $(conf.elementType);
                                                        if (conf.mainClass != "") {
                                                            img.addClass(conf.mainClass);
                                                        }

                                                        if (self.prop("checked")) {
                                                            img.addClass(conf.checkedClass);
                                                        }

                                                        if (typeof self.attr("data-wig") == "string") {
                                                            img.addClass(self.attr("data-wig"));
                                                        }

                                                        var clickEvent = function () {
                                                            if (self.attr("type") == "radio" && !self.prop("checked")) {
                                                                self.prop("checked", true);
                                                                list.change();

                                                            }
                                                            if (self.attr("type") == "checkbox") {
                                                                self.prop("checked", !self.prop("checked"));
                                                                self.change();
                                                            }
                                                            ;
                                                            if (typeof conf.onClick == "function") {
                                                                conf.onClick();
                                                            }
                                                        };

                                                        if (typeof self.attr("data-wig-text") == "string") {
                                                            var wrapper = $("<div></div>");
                                                            wrapper.addClass(conf.wrapperClass);
                                                            img.appendTo(wrapper);


                                                            var text = $("<div></div>");
                                                            text.addClass(conf.textClass);
                                                            text.html(self.attr("data-wig-text"));
                                                            text.appendTo(wrapper);

                                                            wrapper.on("click", clickEvent);
                                                            wrapper.insertAfter(self);

                                                        } else {
                                                            img.on("click", clickEvent);
                                                            img.insertAfter(self);
                                                        }


                                                        self.change(function () {
                                                            if (self.prop("checked")) {
                                                                img.addClass(conf.checkedClass);
                                                            } else {
                                                                img.removeClass(conf.checkedClass);
                                                            }
                                                        });


                                                        self.hide();
                                                    });

                                                    if (typeof conf.onInit == "function") {
                                                        conf.onInit();
                                                    }

                                                },
                                                wizard_suggest: function (params) {
                                                    var conf = {
                                                        data: [],

                                                        showImage: false,
                                                        imageClass: "wizard_suggest_image",
                                                        imageAttribute: "value",
                                                        imagePrefix: "",


                                                        filterAdditionalValue: null,

                                                        inputClass: "wizard_suggest_input",
                                                        inputId: "wizard_suggest",
                                                        inputPlaceholder: "wizard_suggest",
                                                        textClass: "wizard_suggest_text",
                                                        wrapperClass: "wizard_suggest_wrapper",
                                                        elementClass: "wizard_suggest_element",
                                                        elementSelectedClass: "wizard_suggest_element_selected",
                                                        suggestClass: "wizard_suggest",

                                                        emptySuggestClass: "wizard_suggest_empty",
                                                        emptySuggestText: null,

                                                        checkedClass: "checked",
                                                        onInit: null,
                                                        onChange: null

                                                    };

                                                    $.extend(conf, params);

                                                    var self = $(this);
                                                    var input = $("<input type=\"text\" >");
                                                    input.attr("id", conf.inputId);
                                                    input.addClass(conf.inputClass);
                                                    input.attr("placeholder", "<?php echo $cons_input_plach_race; ?>");
                                                    input.attr("autocomplete", "off");
                                                    input.data("filterAdditionalValue", conf.filterAdditionalValue);

                                                    input.on("focus", function () {
                                                        addElements(input, $("." + conf.suggestClass));
                                                        $("." + conf.suggestClass).show();
                                                    });


                                                    input.on("blur", function () {
                                                        //$("." + conf.suggestClass).hide();

                                                    });


                                                    var suggestBox = $("<div></div>");
                                                    suggestBox.addClass(conf.suggestClass);

                                                    var selfVal = self.val();
                                                    for (var i = 0; i < conf.data.length; ++i) {
                                                        if (selfVal == conf.data[i].value) {

                                                            input.val(conf.data[i].text);
                                                            break;
                                                        }
                                                    }


                                                    var addElements = function (inp, sbox) {

                                                        var filterValue = inp.data("filterAdditionalValue");
                                                        if (sbox.css("display") == "none") {
                                                            sbox.show();
                                                        }
                                                        sbox.html("");
                                                        var wrapper = $("<div></div>");
                                                        wrapper.addClass(conf.wrapperClass);
                                                        wrapper.appendTo(sbox);

                                                        var currValue = self.val();
                                                        var value = $.trim(inp.val().toLowerCase());

                                                        var countElements = [];
                                                        for (var i = 0; i < conf.data.length; ++i) {
                                                            var text = conf.data[i].text.toLowerCase();
                                                            if (value != "" && text.indexOf(value) == -1) {
                                                                continue;
                                                            }

                                                            if (typeof filterValue == "string" && conf.data[i].additional != filterValue) {
                                                                continue;
                                                            }
                                                            /*
                                                             if(typeof conf.filterAdditionalValue == "string") {

                                                             if(conf.data[i].additional != conf.filterAdditionalValue) {
                                                             continue;
                                                             }
                                                             }*/
                                                            var element = $("<div></div>");
                                                            element.addClass(conf.elementClass);
                                                            if (currValue == conf.data[i].value) {
                                                                element.addClass(conf.elementSelectedClass);
                                                            }
                                                            if (conf.showImage &&
                                                                typeof conf.data[i][conf.imageAttribute] == "string") {
                                                                var imgTag = $("<div></div>");
                                                                imgTag.addClass(conf.imageClass);
                                                                imgTag.addClass(conf.imagePrefix + conf.data[i][conf.imageAttribute]);
                                                                imgTag.appendTo(element);
                                                            }

                                                            var textTag = $("<div>" + conf.data[i].text + "</div>");
                                                            textTag.addClass(conf.textClass);
                                                            textTag.appendTo(element);

                                                            element.data("ws-wse", conf.data[i]);

                                                            element.appendTo(wrapper);
                                                            countElements.push(conf.data[i]);
                                                        }
                                                        if (countElements.length == 1) {
                                                            self.val(countElements[0].value);
                                                        }

                                                        if (countElements.length == 0) {
                                                            var empty = $("<div></div>");
                                                            empty.addClass(conf.emptySuggestClass);
                                                            if (conf.emptySuggestText !== null) {
                                                                empty.html(conf.emptySuggestText);
                                                            }
                                                            empty.appendTo(wrapper);
                                                        }

                                                    };

                                                    input.on("keyup", function (ev) {
                                                        var sbox = $("." + conf.suggestClass);

                                                        if (ev.keyCode == 27) {
                                                            sbox.hide();
                                                            return false;
                                                        }
                                                        self.val("");

                                                        addElements(input, sbox);
                                                        return false;
                                                    });

                                                    input.insertAfter(self);

                                                    suggestBox.on("click", "." + conf.elementClass, function () {
                                                        var data = $(this).data("ws-wse");
                                                        self.val(data.value);
                                                        input.val(data.text);
                                                        suggestBox.hide();
                                                    });

                                                    suggestBox.insertAfter(input);
                                                    self.hide();


                                                }
                                            });
                                        })(jQuery);
                                    </script>
                                    <form name="consultant"
                                          action="/index.php?route=product/consultant/step"<? /*action="<?php echo $action; ?>"*/ ?>
                                          method="post">
                                        <div id="column_middle" class="col-md-11 col-lg-11">
                                            <h1 class="headline"><?php echo $cons_title; ?></h1>
                                            <h2 class="js-step-header"><?php echo $cons_mydata; ?></h2>
                                            <div class="questions_wrapper visible-step" id="step-1">
                                                <div class="question_wrapper name ">
                                                    <div class="frage"><?php echo $cons_input_name; ?></div>
                                                    <div class="antwort">
                                                        <input autocomplete="false" type="text" value="" placeholder="<?php echo $cons_input_plach_name; ?>" name="dog_name">
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="question_wrapper rasse ">
                                                    <div class="frage"><?php echo $cons_input_race; ?></div>
                                                    <div class="antwort">
                                                        <input type="text" name="rasse_id" value="<?php echo $race_dog['race_id'];?>" placeholder="<?php echo $cons_input_plach_race; ?>" style="display: none;">
                                                        <input type="text" name="rasse" value="<?php echo $race_dog['race'];?>" placeholder="<?php echo $cons_input_plach_race; ?>" readonly="readonly">
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="question_wrapper geschlecht ">
                                                    <div class="frage"><?php echo $cons_check_gender; ?><span>*</span></div>
                                                    <div class="antwort">

                                                        <div class="wizard_wrapper">
                                                            <input id="weiblich" type="radio" data-text="weiblich" value="weiblich" name="geschlecht" required>
                                                            <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_f; ?></div>
                                                            <div class="warning-message">*<?php echo $cons_error; ?></div>
                                                        </div>

                                                        <div class="wizard_wrapper">
                                                            <input id="männlich" type="radio" data-text="männlich" value="männlich" name="geschlecht" required>
                                                            <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_m; ?></div>
                                                        </div>
                                                        <div style="clear:both"></div>
                                                        <script type="text/javascript">
                                                            $("input[name=geschlecht]").wizard_img_options();
                                                        </script>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="question_wrapper kastriert">
                                                    <div class="frage"><?php echo $cons_check_castrated; ?></div>

                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="ja" value="67" name="kastriert">
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_y; ?></div>
                                                    </div>

                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="nein" value="68" name="kastriert">
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_n; ?></div>
                                                    </div>
                                                    <div class="clear"></div>
                                                    <script type="text/javascript">
                                                        $("input[name=kastriert]").wizard_img_options();
                                                    </script>
                                                </div>
                                                <div class="question_wrapper geburtstag">
                                                    <div class="frage  "><?php echo $cons_date; ?><span>*</span></div>
                                                    <div class="antwort">

                                                        <select id="day" name="day" class="ws_wiz_question_geburtstag">
                                                            <option value=""><?php echo $cons_date_d; ?></option>

                                                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <select id="month" name="month" class="ws_wiz_question_geburtsmonat" >
                                                            <option value=""><?php echo $cons_date_m; ?></option>
                                                            <?php $i = 1; ?>
                                                            <?php foreach ($cons_date_month as $val) { ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $val; ?></option>
                                                                <?php $i++; ?>
                                                            <?php } ?>

                                                        </select>
                                                        <select id="year" name="year" class="ws_wiz_question_geburtsjahr" >
                                                            <option value=""><?php echo $cons_date_y; ?></option>

                                                            <?php for ($i = 0; $i < 25; $i++) { ?>
                                                                <option value="<?php echo date('Y') - $i; ?>"><?php echo date('Y') - $i; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="warning-message">*<?php echo $cons_error; ?></div>
                                                    </div>
                                                    <div class="clear"></div>

                                                </div>
                                            </div>

                                            <div class="pagination-box">
                                                <div class="btn_next js-btn-next-wrapper"><input id="consultant_submit" type="submit" value="<?php echo $cons_button; ?>"></div>
                                            </div> <!-- /.pagination -->


                                        </div>
                                        <div class="clear"></div>
                                    </form>
                                </div>
                            <?php } ?>

                            <?php if ($review_status) { ?>
                                <div class="info col-md-12 col-sm-12 col-xs-12">
                                    <hr>
                                    <div class="info_wrapper">
                                        <div class="rating_wrap rating_last_articles">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <?php if ($rating < $i) { ?>
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
                                        <p><a href="" onclick="gotoReview(); return false;"><?php echo $reviews; ?></a> / <a href="" onclick="gotoReviewWrite(); return false;"><?php echo $text_write; ?></a></p>
                                    </div>
                                    <hr>
                                    <!-- AddThis Button BEGIN -->
                                    <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like"
                                                                                          fb:like:layout="button_count"></a> <a
                                                class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a
                                                class="addthis_counter addthis_pill_style"></a></div>
                                    <script type="text/javascript"
                                            src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
                                    <!-- AddThis Button END -->
                                </div>
                                <br/>
                            <?php } ?>

                            <?php if ($download_status) { ?>
                                <div class="blog-info">
                                    <?php if($downloads){ ?>
                                        <br/>
                                        <?php foreach($downloads as $download){ ?>
                                            <a href="<?php echo $download['href']; ?>" title=""><i
                                                        class="fa fa-floppy-o"></i> <?php echo $download['name']; ?> <?php echo " (". $download['size'] .")";?>
                                            </a><br>
                                        <?php } ?>
                                        <br/>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                    <?php if ($products) { ?>
                        <h3><?php echo $text_related_product; ?></h3>
                        <div class="row module box-row">
                            <?php $i = 0; ?>
                            <?php foreach ($products as $product) { ?>

                                <?php if ($column_left && $column_right) { ?>
                                    <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
                                <?php } elseif ($column_left || $column_right) { ?>
                                    <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
                                <?php } else { ?>
                                    <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
                                <?php } ?>
                                <div class="<?php echo $class; ?> related-shadow-box box-padding box-border" title="<?php echo $product['name']; ?>">
                                    <div class="product-thumb transition">
                                        <div class="related-div-img">
                                            <a href="<?php echo $product['href']; ?>"><img style="max-height: 280px;" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
                                        </div>
                                        <div class="title">
                                            <div style="height: 190px;">
                                                <h4 class="h4-style">
                                                    <a class="article-product-name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                                                </h4>
                                                <p><?php echo $product['description']; ?></p>
                                            </div>
                                            <div class="price">
                                                <div class="rating_wrap rating_product" style="height: 25px;">
                                                    <?php if ($review_status) { ?>
                                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                            <?php if ($product['rating'] < $i) { ?>
                                                                <span class="article-product-rating fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                            <?php } else { ?>
                                                                <span class="article-product-rating fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php for ($j = 1; $j <= 5; $j++) { ?>
                                                            <span class="article-product-rating fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                                <div>
                                                    <?php if ($product['price']) { ?>
                                                        <a class="article-price" href="<?php echo $product['href']; ?>">
                                                            <?php if (!$product['special']) { ?>
                                                                <?php echo $product['price']; ?>
                                                            <?php } else { ?>
                                                                <span class="price-new">><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                                                            <?php } ?>
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="article-list-item-button payment_buttons">
                        <span style="float: left;" class="quantity_container">
                        <input type="text" name="products_qty" id="qty_<?php echo $product['product_id']; ?>" class="article-count-input" value="1">
                        </span>
                                                <button onclick="cart.add('<?php echo $product['product_id']; ?>', $('#qty_<?php echo $product['product_id']; ?>').val());" class="button_green article-btn-add"><?php echo $button_cart; ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (($column_left && $column_right) && ($i % 2 == 0)) { ?>
                                    <div class="clearfix visible-md visible-sm"></div>
                                <?php } elseif (($column_left || $column_right) && ($i % 3 == 0)) { ?>
                                    <div class="clearfix visible-md"></div>
                                <?php } elseif ($i % 4 == 0) { ?>
                                    <div class="clearfix visible-md"></div>
                                <?php } ?>
                                <?php $i++; ?>


                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ($articles) { ?>
                        <h3><?php echo $text_related; ?></h3>
                        <div class="row module box-row">
                            <?php $i = 0; ?>
                            <?php foreach ($articles as $article) { ?>

                                <?php if ($column_left && $column_right) { ?>
                                    <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
                                <?php } elseif ($column_left || $column_right) { ?>
                                    <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
                                <?php } else { ?>
                                    <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
                                <?php } ?>
                                <div class="<?php echo $class; ?> related-shadow-box box-padding box-border" title="<?php echo $article['name']; ?>">
                                    <div class="product-thumb transition">
                                        <div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>"
                                                                                                          alt="<?php echo $article['name']; ?>"
                                                                                                          title="<?php echo $article['name']; ?>"
                                                                                                          class="img-responsive"/></a></div>
                                        <div class="caption" style="height: 210px;">
                                            <h4 class="h4-style"><a class="article-product-name" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h4>
                                            <p><?php echo $article['description']; ?></p>
                                        </div>
                                        <div>
                                            <?php if ($review_status) { ?>
                                                <div class="rating_wrap rating_product" style="height: 25px;">
                                                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                        <?php if ($article['rating'] < $i) { ?>
                                                            <span class="article-product-rating fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                                                        <?php } else { ?>
                                                            <span class="article-product-rating fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i
                                                                        class="fa fa-star-o fa-stack-2x"></i></span>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <p style="float: right;"><?php echo $text_views; ?> <?php echo $article["viewed"];?></p>
                                        </div>
                                        <div class="button-group">
                                            <button class="article-btn-watch" type="button" onclick="location.href = ('<?php echo $article['href']; ?>');"><i
                                                        class="fa fa-share"></i> <span
                                                        class="hidden-xs hidden-sm hidden-md"><?php echo $button_more; ?></span></button>
                                            <p style="float: right; margin: 5px 0;"><i class="fa fa-clock-o" title="Date added" style="margin-right: 5px;"></i><?php echo $article["date_added"];?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php if (($column_left && $column_right) && ($i % 2 == 0)) { ?>
                                    <div class="clearfix visible-md visible-sm"></div>
                                <?php } elseif (($column_left || $column_right) && ($i % 3 == 0)) { ?>
                                    <div class="clearfix visible-md"></div>
                                <?php } elseif ($i % 4 == 0) { ?>
                                    <div class="clearfix visible-md"></div>
                                <?php } ?>
                                <?php $i++; ?>


                            <?php } ?>
                        </div>
                    <?php } ?>

                    <?php if ($review_status) { ?>
                        <div class="tab-pane" id="tab-review">
                            <form class="form-horizontal" id="form-review">
                                <div id="review"></div>
                                <h2><?php echo $text_write; ?></h2>
                                <?php if ($review_guest) { ?>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                                            <input type="text" name="name" value="" id="input-name" class="form-control"/>
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

                                            <input type="text" name="rating" value="" style="display: none"/>

                                            <div class="rating_wrap">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <?php if (0 < $i) { ?>
                                                        <span id="star-<?php echo $i; ?>" class="fa fa-stack">
                        <i class="fa fa-star-o fa-stack-2x"></i><!-- Empty star -->
                      </span>

                                                    <?php } else { ?>
                                                        <span id="star-<?php echo $i; ?>" class="fa fa-stack">
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
                                                            $("#star-"+i).html(emptyStar);
                                                        else
                                                            $("#star-"+i).html(fullStar);
                                                    }
                                                }
                                                function starListeners(starNumber, countStars){
                                                    $("#star-"+starNumber).click(function() {
                                                        showRating(starNumber, countStars);
                                                        $('input[name="rating"]').val(starNumber);
                                                    });
                                                }
                                                var countStars = 5;
                                                for (var i = 1; i <= countStars; i++){
                                                    starListeners(i,countStars);
                                                }
                                                //--></script>


                                            &nbsp;<?php echo $entry_good; ?>
                                        </div>
                                    </div>
                                    <?php if ($site_key) { ?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="buttons clearfix">
                                        <div class="pull-right">
                                            <button type="button" id="button-review" data-loading-text="<span class='button-outer'><span class='button-inner'><?php echo $text_loading; ?></span></span>"
                                                    class="button_blue button_set">
                  <span class='button-outer'>
                    <span class='button-inner'><?php echo $button_continue; ?></span>
                  </span>
                                            </button>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <?php echo $text_login; ?>
                                <?php } ?>
                            </form>
                        </div>
                    <?php } ?>

                    <?php echo $content_bottom; ?></div>
                <?php echo $column_right; ?></div>
        </div>
    </div>
    </div>
    <script>
        $( function () {
            $('form #consultant_submit').on('click', function () {
                var result = true;
                if (!$("#weiblich").prop("checked") && !$("#männlich").prop("checked")) {
                    $(".geschlecht .wizard_img").css( "border-color", "#f00" );
                    $(".geschlecht .warning-message").addClass('show');
                    result = false;
                }else{
                    $(".geschlecht .wizard_img").css( "border-color", "" );
                    $(".geschlecht .warning-message").removeClass("show");
                }
                if (!$("#day").val() || !$("#month").val() || !$("#year").val()) {

                    $(".geburtstag .ws_wiz_question_geburtstag").css( "border-color", "#f00" );
                    $(".geburtstag .ws_wiz_question_geburtsmonat").css( "border-color", "#f00" );
                    $(".geburtstag .ws_wiz_question_geburtsjahr").css( "border-color", "#f00" );
                    $(".geburtstag .warning-message").addClass('show');
                    result = false;
                }else{
                    $(".geburtstag .ws_wiz_question_geburtstag").css( "border-color", "" );
                    $(".geburtstag .ws_wiz_question_geburtsmonat").css( "border-color", "" );
                    $(".geburtstag .ws_wiz_question_geburtsjahr").css( "border-color", "" );
                    $(".geburtstag .warning-message").removeClass("show");
                }
                return result;
            })
        });
    </script>
    <script type="text/javascript"><!--

        $('#button-cart').ready(function () {
            $("iframe[src*='//player.vimeo.com'], iframe[src*='//www.youtube.com']").resizeIframes();
            $('#button-cart').click(function () {
                var node = this;
                $.ajax({
                    url: 'index.php?route=checkout/cart/add',
                    type: 'post',
                    data: $('#product input[type=\'text\'], #product input[type=\'date\'], #product input[type=\'datetime-local\'], #product input[type=\'time\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                    dataType: 'json',
                    beforeSend: function() {
                        $(node).button('loading');
                    },
                    complete: function() {
                        $(node).button('reset');
                    },
                    success: function (json) {
                        $('.alert, .text-danger').remove();

                        if (json['error']) {
                            if (json['error']['option']) {
                                for (i in json['error']['option']) {
                                    $('#input-option' + i).after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                                }
                            }
                        }

                        if (json['success']) {
                            $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            $('#cart').load('index.php?route=module/cart' + ' #cart > *');
                            //$('#cart-total').html(json['total']);

                            $('html, body').animate({scrollTop: 0}, 'slow');
                        }
                    }
                });
            });
        });
        //--></script>
    <script type="text/javascript"><!--
        $('button[id^=\'button-upload\']').on('click', function () {
            var node = this;

            $('#form-upload').remove();

            $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

            $('#form-upload input[name=\'file\']').trigger('click');

            $('#form-upload input[name=\'file\']').on('change', function () {
                $.ajax({
                    url: 'index.php?route=product/product/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($(this).parent()[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $(node).find('i').replaceWith('<i class="fa fa-spinner fa-spin"></i>');
                        $(node).prop('disabled', true);
                    },
                    complete: function () {
                        $(node).find('i').replaceWith('<i class="fa fa-upload"></i>');
                        $(node).prop('disabled', false);
                    },
                    success: function (json) {
                        if (json['error']) {
                            $(node).parent().find('input[name^=\'option\']').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input[name^=\'option\']').attr('value', json['file']);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            });
        });
        //--></script>
    <script type="text/javascript"><!--
        $('#review').delegate('.pagination a', 'click', function (e) {
            e.preventDefault();

            $('#review').fadeOut('slow');

            $('#review').load(this.href);

            $('#review').fadeIn('slow');
        });

        $('#review').load('index.php?route=blog/article/review&article_id=<?php echo $article_id; ?>');

        $('#button-review').on('click', function () {
            var node = this;
            $.ajax({
                url: 'index.php?route=blog/article/write&article_id=<?php echo $article_id; ?>',
                type: 'post',
                dataType: 'json',
                data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']').val() ? $('input[name=\'rating\']').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
                beforeSend: function() {
                    $(node).button('loading');
                },
                complete: function() {
                    $(node).button('reset');
                },
                success: function (json) {
                    $('.alert-success, .alert-danger').remove();

                    if (json['error']) {
                        $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
                    }

                    if (json['success']) {
                        $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

                        $('input[name=\'name\']').val('');
                        $('textarea[name=\'text\']').val('');
                        $('input[name=\'rating\']').val('');
                        $('input[name=\'captcha\']').val('');
                    }
                }
            });
        });
        //--></script>
    <script type="text/javascript"><!--
        $(document).ready(function () {
            // $('#description').find('a>img').each(function () {
            //     $(this).parent().addClass('gallery');
            // });
            // $('#description').magnificPopup({
            //     delegate: 'a.gallery',
            //     type: 'image',
            //     gallery: {
            //         enabled: true
            //     }
            // });

            gotoReview = function () {
                offset = $('#form-review').offset();
                $('html, body').animate({scrollTop: offset.top - 20}, 'slow');
            }
            gotoReviewWrite = function () {
                offset = $('#form-review h2').offset();
                $('html, body').animate({scrollTop: offset.top - 20}, 'slow');
            }

        });
        --></script>
<?php echo $footer; ?>
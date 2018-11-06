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


                <div class="col-md-9 col-md-push-3 col-xs-12 right-container" >


                    <div id="content">

                        <!-- formaaa BEGIN  -->
                        <div id="content_inhaltstpl" class="tpl_futterassistent wizard_type_Hund row" style="margin: 0 -15px">

                            <script type="text/javascript">
                                (function($) {
                                    $.fn.extend({
                                        wizard_img_options: function(params) {

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
                                            list.each(function() {
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

                                                var clickEvent = function() {
                                                    if (self.attr("type") == "radio" && !self.prop("checked")) {
                                                        self.prop("checked", true);
                                                        list.change();

                                                    }
                                                    if (self.attr("type") == "checkbox") {
                                                        self.prop("checked", !self.prop("checked"));
                                                        self.change();
                                                    };
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




                                                self.change(function() {
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
                                        wizard_suggest: function(params) {
                                            var conf = {
                                                data: [],

                                                showImage: false,
                                                imageClass: "wizard_suggest_image",
                                                imageAttribute: "value",
                                                imagePrefix: "",


                                                filterAdditionalValue: null,

                                                inputClass: "wizard_suggest_input",
                                                inputId: "wizard_suggest",
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
                                            input.attr("value", "<?php echo isset($consultant['rasse_id']) ? $consultant['rasse'] : ''; ?>");
                                            input.attr("autocomplete", "off");
                                            input.data("filterAdditionalValue", conf.filterAdditionalValue);

                                            input.on("focus", function() {
                                                addElements(input, $("." + conf.suggestClass));
                                                $("." + conf.suggestClass).show();
                                            });


                                            input.on("blur", function() {
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


                                            var addElements = function(inp, sbox) {

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

                                            input.on("keyup", function(ev) {
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

                                            suggestBox.on("click", "." + conf.elementClass, function() {
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

                            <form name="consultant" action="/index.php"<?/*action="<?php echo $action; ?>"*/?> method="GET">
                                <input type="hidden" name="route" value="product/consultant">
                                <div id="column_middle" class="right col-md-9 col-lg-8">
                                    <h1 class="headline"><?php echo $cons_title; ?></h1>
                                    <h2 class="js-step-header"><?php echo $cons_mydata; ?></h2>

                                    <!-- SEITE 1 -->

                                    <div class="questions_wrapper visible-step" id="step-1">
                                        <div class="step-1 <?php echo isset($consultant['geschlecht']) && isset($consultant['day']) && isset($consultant['month']) && isset($consultant['year']) ? 'loading' : ''; ?>"></div>




                                        <div class="question_wrapper name ">
                                            <div class="frage"><?php echo $cons_input_name; ?></div>
                                            <div class="antwort">
                                                <input autocomplete="false" type="text" value="<?php echo isset($consultant['name']) ? $consultant['name'] : ''; ?>" placeholder="<?php echo $cons_input_plach_name; ?>" name="name">

                                            </div>
                                            <div class="clear"></div>
                                        </div>



                                        <div class="question_wrapper rasse ">
                                            <div class="frage"><?php echo $cons_input_race; ?></div>
                                            <div class="antwort">
                                                <input type="text" name="rasse" value="<?php echo isset($consultant['rasse']) ? $consultant['rasse'] : '';?>" style="display: none;">
                                                <script type="text/javascript">
                                                    var roptions =  [
                                                        <?php foreach ($race_dogs as $race_dog) { ?>
                                                        {   "value": "<?php echo $race_dog['value']; ?>",
                                                            "text": "<?php echo $race_dog['race']; ?>",
                                                            "additional": "<?php echo $race_dog['additional']; ?>",
                                                            "selected": <?php echo $race_dog['selected']; ?>
                                                        },
                                                        <?php } ?>
                                                    ];
                                                    $("[name=rasse]").wizard_suggest({
                                                        showImage: true,
                                                        data: roptions,
                                                        emptySuggestText: "Rasse nicht in der Liste vorhanden",
                                                        filterAdditionalValue: "Hund"
                                                    });
                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <!-- ******************* Rasse END *************************** -->

                                        <!-- 	*************** Geshlecht Begin ***************************** -->
                                        <div class="question_wrapper geschlecht ">
                                            <div class="frage"><?php echo $cons_check_gender; ?><span>*</span></div>
                                            <div class="antwort">
                                                <?php if (isset($consultant['geschlecht']) && $consultant['geschlecht'] == 'weiblich') { ?>
                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="weiblich" value="weiblich" name="geschlecht" checked required>
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_f; ?></div>
                                                        <div class="warning-message">*<?php echo $cons_error; ?></div>
                                                    </div>

                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="männlich" value="männlich" name="geschlecht" required>
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_m; ?></div>
                                                    </div>
                                                <?php } elseif (isset($consultant['geschlecht']) && $consultant['geschlecht'] == 'männlich') { ?>
                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="weiblich" value="weiblich" name="geschlecht" required>
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_f; ?></div>
                                                        <div class="warning-message">*<?php echo $cons_error; ?></div>
                                                    </div>

                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="männlich" value="männlich" name="geschlecht" checked required>
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_m; ?></div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="weiblich" value="weiblich" name="geschlecht" required>
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_f; ?></div>
                                                        <div class="warning-message">*<?php echo $cons_error; ?></div>
                                                    </div>

                                                    <div class="wizard_wrapper">
                                                        <input type="radio" data-text="männlich" value="männlich" name="geschlecht" required>
                                                        <div class="checkbox_bezeichnung"><?php echo $cons_check_gender_m; ?></div>
                                                    </div>
                                                <?php } ?>

                                                <div style="clear:both"></div>
                                                <script type="text/javascript">
                                                    $("input[name=geschlecht]").wizard_img_options();
                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <!-- 	*************** Geshlecht End ***************************** -->

                                        <!-- 	*************** kastriert Begin ***************************** -->

                                        <div class="question_wrapper kastriert">
                                            <div class="frage"><?php echo $cons_check_castrated; ?></div>
                                            <?php if (isset($consultant['kastriert']) && $consultant['kastriert'] == 67 ) { ?>
                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="ja" value="67" name="kastriert" checked>
                                                    <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_y; ?></div>
                                                </div>

                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="nein" value="68" name="kastriert">
                                                    <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_n; ?></div>
                                                </div>
                                            <?php } elseif (isset($consultant['kastriert']) && $consultant['kastriert'] == 68 ) { ?>
                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="ja" value="67" name="kastriert" >
                                                    <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_y; ?></div>
                                                </div>

                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="nein" value="68" name="kastriert" checked>
                                                    <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_n; ?></div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="ja" value="67" name="kastriert" >
                                                    <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_y; ?></div>
                                                </div>

                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="nein" value="68" name="kastriert">
                                                    <div class="checkbox_bezeichnung"><?php echo $cons_check_castrated_n; ?></div>
                                                </div>
                                            <?php } ?>

                                            <div class="clear"></div>
                                            <script type="text/javascript">
                                                $("input[name=kastriert]").wizard_img_options();
                                            </script>
                                        </div>
                                        <!-- 	*************** kastriert End ***************************** -->


                                        <?/*
                                        <!-- 	*************** wet/dry Begin ***************************** -->										
                                        <div class="question_wrapper kastriert">
                                            <div class="frage">Type</div>

                                            <div class="wizard_wrapper">
                                                <input type="radio" value="2" name="filter" >
                                                <div class="checkbox_bezeichnung">Wet</div>
                                            </div>

                                            <div class="wizard_wrapper">
                                                <input type="radio" value="3" name="filter">
                                                <div class="checkbox_bezeichnung">Dry</div>
                                            </div>



                                            <div class="clear"></div>
                                            <script type="text/javascript">
                                                $("input[name=filter]").wizard_img_options();
                                            </script>
                                        </div>										
                                        <!-- 	*************** wet/dry End ***************************** -->
										*/ ?>

                                        <div class="question_wrapper geburtstag">
                                            <div class="frage  "><?php echo $cons_date; ?><span>*</span></div>
                                            <div class="antwort">

                                                <select name="geburtstag" class="ws_wiz_question_geburtstag" required>
                                                    <?php if (isset($consultant['day'])) { ?>
                                                        <option value="<?php echo $consultant['day']; ?>" selected><?php echo $consultant['day']; ?></option>

                                                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value=""><?php echo $cons_date_d; ?></option>

                                                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>



                                                <select name="geburtsmonat" class="ws_wiz_question_geburtsmonat" required>
                                                    <?php if (isset($consultant['month'])) { ?>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($cons_date_month as $val) { ?>
                                                            <?php if ($consultant['month'] == $i) { ?>
                                                                <option value="<?php echo $consultant['month']; ?>" selected><?php echo $val; ?></option>
                                                            <?php } ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $val; ?></option>
                                                            <?php $i++; ?>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value=""><?php echo $cons_date_m; ?></option>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($cons_date_month as $val) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $val; ?></option>
                                                            <?php $i++; ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>



                                                <select name="geburtsjahr" class="ws_wiz_question_geburtsjahr  " required>
                                                    <?php if (isset($consultant['year'])) { ?>
                                                        <option value="<?php echo $consultant['year']; ?>" selected><?php echo $consultant['year']; ?></option>

                                                        <?php for ($i = 0; $i < 25; $i++) { ?>
                                                            <option value="<?php echo date('Y') - $i; ?>"><?php echo date('Y') - $i; ?></option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <option value=""><?php echo $cons_date_y; ?></option>

                                                        <?php for ($i = 0; $i < 25; $i++) { ?>
                                                            <option value="<?php echo date('Y') - $i; ?>"><?php echo date('Y') - $i; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                                <div class="warning-message">*<?php echo $cons_error; ?></div>


                                            </div>
                                            <div class="clear"></div>

                                        </div>
                                    </div>



                                    <!-- SEITE 2 -->
                                    <div class="questions_wrapper" id="step-2" style="display: none">
                                        <div class="question_wrapper gewicht col-xs-6 col-xs-offset-6">
                                            <div class="frage" style="width: auto"><strong>Gewicht<span>*</span></strong></div>
                                            <div class="antwort">
                                                <input autocomplete="false" type="text" id="input_gewicht" value="" name="ws_wiz_question_gewicht"><span>kg</span>
                                                <div class="warning-message" style="margin-left: 96px;">*Pflichtangaben</div>
                                            </div>
                                            <div id="error_wrong_val">Nur zahlen angeben</div>
                                            <div id="error_val_range">Zahlenbreich nicht korrekt</div>
                                            <div class="clear"></div>
                                        </div>
                                        <input type="hidden" id="input_gewicht_hidden" value=">9" name="ws_wiz_question_gewichthidden">
                                        <script type="text/javascript">
                                            function calcAnimalWeight() {
                                                var setX = "";
                                                var val = $.trim($("#input_gewicht").val());
                                                var ew = $("#error_wrong_val");
                                                var er = $("#error_val_range");
                                                ew.hide();
                                                er.hide();
                                                if(val != "") {
                                                    var valInt = parseInt(val);
                                                    if(isNaN(valInt) || valInt + "" != val) {
                                                        ew.show();
                                                    }
                                                    else if(valInt < 1 || valInt > 140) {
                                                        er.show();
                                                    }
                                                    else {
                                                        setX = ">9";
                                                        if(valInt <= 10)
                                                            setX = "<11";

                                                    }
                                                    if(valInt < 0 || valInt > 140) {
                                                        er.show();
                                                    }
                                                    else {
                                                        setX = ">9";
                                                        if(valInt <= 10)
                                                            setX = "<11";

                                                    }
                                                }

                                                $("#input_gewicht_hidden").val(setX);
                                            };
                                            $("#input_gewicht").on("keyup", calcAnimalWeight);
                                            calcAnimalWeight();
                                        </script>

                                        <div class="question_wrapper gewichtsgrad ">
                                            <div class="col-xs-6">
                                                <div class="img-wrapper">
                                                    <img src="/catalog/view/theme/default/images/web/futterassistent/seite2/hund/normal.png" alt="" class="js-dog-weight dog-weight" >
                                                    <p class="js-dog-weight-text">Rippen tastbar mit geringer Fettabdeckung, von oben betrachtet Taille erkennbar, von der Seite sichtbare Anhebung der Bauchlinie vor dem Becken.</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="frage">ERNÄHRUNGSZUSTAND <span>*</span></div>
                                                <div class="antwort">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                            <label>
                                                                <span class="option-label">stark untergewichtig</span>
                                                                <input type="radio" name="ws_wiz_question_gewichtsgrad"  data-text="stark untergewichtig" value="34" title="stark untergewichtig" style="display: none" required>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <span class="option-label">leicht untergewichtig</span>
                                                                <input type="radio" name="ws_wiz_question_gewichtsgrad"  data-text="leicht untergewichtig" value="35" title="leicht untergewichtig" style="display: none" required>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <span class="option-label">normal</span>
                                                                <input type="radio" name="ws_wiz_question_gewichtsgrad" data-text="normal"  value="36" title="normal" style="display: none" required>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <span class="option-label">leicht übergewichtig</span>
                                                                <input type="radio" name="ws_wiz_question_gewichtsgrad" data-text="leicht übergewichtig"  value="37" title="leicht übergewichtig" style="display: none" required>
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label>
                                                                <span class="option-label">stark übergewichtig</span>
                                                                <input type="radio" name="ws_wiz_question_gewichtsgrad" data-text="stark übergewichtig" value="38" title="stark übergewichtig" style="display: none" required>
                                                            </label>
                                                        </li>
                                                    </ul>
                                                    <div class="warning-message">*Pflichtangaben</div>



                                                </div>

                                                <div class="clear"></div>
                                                <script type="text/javascript">
                                                    //$("input[name=ws_wiz_question_gewichtsgrad]").wizard_img_options();
                                                    var dogWeightOptions = [
                                                        {
                                                            "weightType": "stark untergewichtig",
                                                            "text": "Knochenvorsprünge aus einiger Entfernung sichtbar (Rippen, Lendenwirbel, Becken), kein erkennbares Körperfett, offensichtlicher Verlust an Muskelmasse.",
                                                            "imgSrc": "/catalog/view/theme/default/images/web/futterassistent/seite2/hund/stark-untergewichtig.png"
                                                        },
                                                        {
                                                            "weightType": "leicht untergewichtig",
                                                            "text": "Rippen leicht tastbar, ohne Fettabdeckung, Lendenwirbel und Beckenknochen sichtbar, von oben betrachtet sehr deutliche Taille, von der Seite gut sichtbare Anhebung der Bauchlinie vor dem Becken.",
                                                            "imgSrc": "/catalog/view/theme/default/images/web/futterassistent/seite2/hund/leicht-untergewichtig.png"
                                                        },
                                                        {
                                                            "weightType": "normal",
                                                            "text": "Rippen tastbar mit geringer Fettabdeckung, von oben betrachtet Taille erkennbar, von der Seite sichtbare Anhebung der Bauchlinie vor dem Becken.",
                                                            "imgSrc": "/catalog/view/theme/default/images/web/futterassistent/seite2/hund/normal.png"
                                                        },
                                                        {
                                                            "weightType": "leicht übergewichtig",
                                                            "text": "Rippen nur schwer unter Fettauflage zu fühlen, erkennbare Fettdepots im Lendenbereich und am Schwanzansatz, Taille nur schwer erkennbar.",
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/leicht-ubergewichtig.png"
                                                        },
                                                        {
                                                            "weightType": "stark übergewichtig",
                                                            "text": "Massive Fettablagerungen an Brustkorb, Wirbelsäule, Hals  und Schwanzansatz, deutliche Umfangsvermehrung des Bauches.",
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/stark-ubergewichtig.png"
                                                        },
                                                    ];

                                                    $("input[name=ws_wiz_question_gewichtsgrad]").change(function(event) {
                                                        var selfTarget = $(this);

                                                        if( $(this).prop( "checked" ) ) {
                                                            $("input[name=ws_wiz_question_gewichtsgrad]").parent().removeClass('checked-input');
                                                            $(this).parent().addClass('checked-input');

                                                            dogWeightOptions.forEach(function(item) {
                                                                if(selfTarget.attr( "data-text" ) == item.weightType) {
                                                                    $( ".js-dog-weight" ).attr("src", item.imgSrc);
                                                                    $( ".js-dog-weight-text" ).html(item.text);
                                                                }
                                                            });
                                                        }
                                                    });


                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>


                                    </div> <!-- /#step2 -->

                                    <!-- SEITE 3 -->

                                    <div class="questions_wrapper" id="step-3" style="display:none">


                                        <div class="question_wrapper aktivitaet ">
                                            <div class="frage col-xs-12">Aktivitätszustand<span>*</span></div>
                                            <div class="col-xs-12">

                                                <div class="answer-wrapper">
                                                    <input type="radio" data-wig-text="<strong>Wenig aktiv</strong> <p>Hunde, die bis zu 30 Minuten am Tag spielen und spazieren gehen.</p>" data-wig="aktivitaet_weniger aktiv" value="63" data-text="weniger aktiv" title="weniger aktiv" name="ws_wiz_question_aktivitaet" checked >

                                                    <input type="radio" data-wig-text="<strong>Normal aktiv</strong> <p>Alle Hunde mit täglich 30 Minuten bis 2,5 Stunden Bewegung, sei es Spiel, Spaziergang oder Hundeplatz.</p>" data-wig="aktivitaet_aktiv" data-text="aktiv" value="64" title="aktiv" name="ws_wiz_question_aktivitaet" >

                                                    <input type="radio" data-wig-text="<strong>Sehr aktiv</strong> <p>Hierzu zählen Sportler, die über 2,5 Stunden täglich aktiv sind.</p>" data-wig="aktivitaet_sehr aktiv" data-text="sehr aktiv" value="65" title="sehr aktiv" name="ws_wiz_question_aktivitaet" >

                                                    <input type="radio" data-wig-text="<strong>Aktiver Hundesport</strong> <p>Extrem beanspruchter Hund, teilnahme an Hundesportarten</p>" data-wig="aktivitaet_sport aktiv" data-text="aktiver hudersport" value="66" title="aktiver hudersport" name="ws_wiz_question_aktivitaet" >
                                                </div>


                                                <div class="clear"></div>
                                                <script type="text/javascript">
                                                    $("input[name=ws_wiz_question_aktivitaet]").wizard_img_options();
                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div> <!-- /#step3 -->


                                    <!-- was SEITE 4 -->
                                    <!--  
                                    <div class="questions_wrapper" id="step-4" style="display: none;">
                                    
                                        <div class="question_wrapper erkrankung trocken_nassfutter">
                                            <div class="antwort">

                                                <ul class="list-inline">
                                                    <li class="fry-food-wrapper">
                                                        <div class="text-center frage">Trockenfutter</div>
                                                        <input type="radio" style="display: none" data-wig-text="Trockenfutter" data-wig="trocken_nassfutter_Trockenfutter" value="" name="ws_wiz_question_trocken_nassfutter" id="trocken_nassfutter_Trockenfutter">-->

                                    <!-- children input --> <!--
                                                        <label for="trocken_nassfutter_Trockenfutter">
                                                            <input type="checkbox" data-wig-text="Extrudiert " data-wig="trocken_nassfutter_Extrudiert" data-text="Extrudiert" value="3" title="Extrudiert" name="ws_wiz_question_trockenfutter" >
                                                            <input type="checkbox" data-wig-text="Kaltgepresst" data-wig="trocken_nassfutter_Kaltgepresst" data-text="Kaltgepresst" value="2" title="Kaltgepresst" name="ws_wiz_question_trockenfutter" >
                                                        </label>
                                                    </li>

                                                    <li>
                                                        <div class="text-center frage">Nassfutter</div>
                                                        <input type="radio" data-wig-text="Nassfutter" data-wig="trocken_nassfutter_Nassfutter" data-text="Nassfutter" value="32" title="Nassfutter" name="ws_wiz_question_trocken_nassfutter" >
                                                    </li>

                                                    <li>
                                                        <div class="text-center frage">Beides</div>
                                                        <input type="radio" data-wig-text="Beides" data-wig="trocken_nassfutter_Beides" data-text="Beides" value="33" title="Beides" name="ws_wiz_question_trocken_nassfutter" checked>
                                                    </li>
                                                </ul>

                                                <div class="clear"></div>
                                                <script type="text/javascript">
                                                    $("input[name=ws_wiz_question_trockenfutter]").wizard_img_options();
                                                    $("input[name=ws_wiz_question_trocken_nassfutter]").wizard_img_options();

                                                    $(".trocken_nassfutter_Trockenfutter").parent().css({
                                                        "position": "absolute",
                                                        "opacity": 0
                                                    });

                                                    $("input[name=ws_wiz_question_trocken_nassfutter]").change(function() {
                                                        if( $(this).attr('id') != "trocken_nassfutter_Trockenfutter" ) {

                                                            $("input[name=ws_wiz_question_trockenfutter]").prop("checked", false);
                                                            $(".trocken_nassfutter_Extrudiert").removeClass("checked");
                                                            $(".trocken_nassfutter_Kaltgepresst").removeClass("checked");
                                                        } else {
                                                            $(".trocken_nassfutter_Nassfutter").removeClass("checked");
                                                            $(".trocken_nassfutter_Beides").removeClass("checked");

                                                        }
                                                    });

                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                    </div> --> <!-- /#step-4 -->

                                    <!-- SEITE 5 -->

                                    <div class="questions_wrapper" id="step-4" style="display: none">

                                        <div class="question_wrapper unvertraeglichkeit">
                                            <div class="antwort">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <p class="frage">Gemüse und Getreide</p>
                                                    </div> <!-- /. col-xs-12col-sm-3 -->
                                                    <div class="col-xs-12 col-sm-9">

                                                        <div class="nummer unvertraeglichkeit_30">
                                                            <input type="checkbox" data-wig-text="Weizen" data-wig="unvertraeglichkeit_Weizen" data-text="Weizen" value="7" title="Weizen" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_25">
                                                            <input type="checkbox" data-wig-text="Gerste" data-wig="unvertraeglichkeit_Gerste" data-text="Gerste" value="8" title="Gerste" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_28">
                                                            <input type="checkbox" data-wig-text="Roggen" data-wig="unvertraeglichkeit_Roggen" data-text="Roggen" value="9" title="Roggen" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_27">
                                                            <input type="checkbox" data-wig-text="Hirse" data-wig="unvertraeglichkeit_Hirse" data-text="Hirse" value="10" title="Hirse" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_22">
                                                            <input type="checkbox" data-wig-text="Reis" data-wig="unvertraeglichkeit_Reis" data-text="Reis" value="11" title="Reis" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_20">
                                                            <input type="checkbox" data-wig-text="Mais" data-wig="unvertraeglichkeit_Mais" data-text="Mais" value="12" title="Mais" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_18">
                                                            <input type="checkbox" data-wig-text="Kartoffel" data-wig="unvertraeglichkeit_Kartoffel" data-text="Kartoffel" value="13" title="Kartoffel" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_29">
                                                            <input type="checkbox" data-wig-text="Soja" data-wig="unvertraeglichkeit_Soja" data-text="Soja" value="39" title="Soja" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>



                                                        <div class="nummer unvertraeglichkeit_31">
                                                            <input type="checkbox" data-wig-text="Bohnen" data-wig="unvertraeglichkeit_Sorten_Beispiele" data-text="Bohnen" value="14" title="Bohnen" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>
                                                    </div> <!-- /.col-xs-12 col-sm-9 -->
                                                </div> <!-- /.row -->
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <p class="frage">Fleisch und Fisch </p>
                                                    </div><!-- /.col-sm-3 -->
                                                    <div class="col-xs-12 col-sm-9">

                                                        <div class="nummer unvertraeglichkeit_11">
                                                            <input type="checkbox" data-wig-text="Rind" data-wig="unvertraeglichkeit_Rind" data-text="Rind" value="15" title="Rind" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_4">
                                                            <input type="checkbox" data-wig-text="Schwein" data-wig="unvertraeglichkeit_Schwein" data-text="Schwein" value="16" title="Schwein" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_1">
                                                            <input type="checkbox" data-wig-text="Huhn" data-wig="unvertraeglichkeit_Huhn" data-text="Huhn" value="17" title="Huhn" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>


                                                        <div class="nummer unvertraeglichkeit_2">
                                                            <input type="checkbox" data-wig-text="Ente" data-wig="unvertraeglichkeit_Ente" data-text="Ente" value="18" title="Ente" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_9">
                                                            <input type="checkbox" data-wig-text="Truthahn" data-wig="unvertraeglichkeit_Truthahn" data-text="Truthahn" value="19" title="Truthahn" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>


                                                        <div class="nummer unvertraeglichkeit_7">
                                                            <input type="checkbox" data-wig-text="Lamm" data-wig="unvertraeglichkeit_Lamm" data-text="Lamm" value="20" title="Lamm" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_5">
                                                            <input type="checkbox" data-wig-text="Kaninchen" data-wig="unvertraeglichkeit_Kaninchen" data-text="Kaninchen" value="21" title="Kaninchen" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>


                                                        <div class="nummer unvertraeglichkeit_12">
                                                            <input type="checkbox" data-wig-text="Strauss" data-wig="unvertraeglichkeit_Strauss" data-text="Strauss" value="22" title="Strauss" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>


                                                        <div class="nummer unvertraeglichkeit_10">
                                                            <input type="checkbox" data-wig-text="Rentier" data-wig="unvertraeglichkeit_Rentier" data-text="Rentier" value="23" title="Rentier" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_13">
                                                            <input type="checkbox" data-wig-text="Wild" data-wig="unvertraeglichkeit_Wild" data-text="Wild" value="24" title="Wild" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_3">
                                                            <input type="checkbox" data-wig-text="Lachs" data-wig="unvertraeglichkeit_Lachs" data-text="Lachs" value="25" title="Lachs" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>
                                                        <div class="nummer unvertraeglichkeit_3">
                                                            <input type="checkbox" data-wig-text="Forelle" data-wig="unvertraeglichkeit_Forelle" data-text="Forelle" value="77" title="Forelle" name="ws_wiz_question_unvertraeglichkeit">
                                                        </div>

                                                    </div><!-- /.col-xs-12 col-sm-9 -->
                                                </div><!-- /.row -->
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <p class="frage">Sonstiges </p>
                                                    </div><!-- /.col-sm-3 -->
                                                    <div class="col-xs-12 col-sm-9">

                                                        <div class="nummer unvertraeglichkeit_35">
                                                            <input type="checkbox" data-wig-text="Kräuter" data-wig="unvertraeglichkeit_Kraeuter" data-text="Kräuter" value="26" title="Kräuter" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_36">
                                                            <input type="checkbox" data-wig-text="Milch" data-wig="unvertraeglichkeit_Milch" data-text="Milch" value="27" title="Milch" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                        <div class="nummer unvertraeglichkeit_34">
                                                            <input type="checkbox" data-wig-text="Käse" data-wig="unvertraeglichkeit_Kaese" data-text="Käse" value="28" title="Käse" name="ws_wiz_question_unvertraeglichkeit" >
                                                        </div>

                                                    </div><!-- /.col-xs-12 col-sm-9 -->
                                                </div><!-- /.row -->

                                                <div class="clear"></div>
                                                <script type="text/javascript">
                                                    $("input[name=ws_wiz_question_unvertraeglichkeit]").wizard_img_options();
                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                    </div> <!-- /#step-4 -->
                                    <!-- SEITE 6 -->

                                    <div class="questions_wrapper" id="step-5" style="display: none">

                                        <div class="question_wrapper erkrankung">
                                            <div class="antwort">

                                                <input type="checkbox" data-wig-text="Gelenke" data-wig="erkrankung_Gelenke" data-text="Gelenke" value="40" title="Gelenke" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Knochen" data-wig="erkrankung_Knocken" data-text="Knochen" value="41" title="Knochen" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Sehnen & Bänder" data-wig="erkrankung_Sehnen" data-text="SehnenBänder" value="42" title="SehnenBänder" name="ws_wiz_question_erkrankung">

                                                <input type="checkbox" data-wig-text="Haut & Fell" data-wig="erkrankung_Haut" data-text="HautFell" value="43" title="HautFell" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Ohrenentzündungen" data-wig="erkrankung_Ohren" data-text="Ohrenentzündungen" value="44" title="Ohrenentzündungen" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Immunsystem" data-wig="erkrankung_Immunsystem" data-text="Immunsystem" value="45" title="Immunsystem" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Zecken & Parasiten " data-wig="erkrankung_Parasiten" data-text="ZeckenParasiten" value="46" title="ZeckenParasiten" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Schnelle Müdigkeit" data-wig="erkrankung_Mudigkeit" data-text="SchnelleMüdigkeit" value="47" title="SchnelleMüdigkeit" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Untergewicht " data-wig="erkrankung_Uebergewicht" data-text="Untergewicht" value="48" title="Untergewicht " name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Nach Operationen oder Erkrankungen " data-wig="erkrankung_Regeneration" data-text="Nach Operationen oder Erkrankungen" value="49" title="NachOperationenErkrankungen" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Nach Antibiotikagabe" data-wig="erkrankung_Diabetes" data-text="Nach Antibiotikagabe" value="50" title="NachAntibiotikagabe" name="ws_wiz_question_erkrankung">

                                                <input type="checkbox" data-wig-text="Stress" data-wig="erkrankung_Stress" data-text="Stress" value="51" title="Stress" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Hohe körperlicher Belastung " data-wig="erkrankung_Tumor" data-text="Hohe körperlicher Belastung" value="52" title="HoheKorperlicherBelastung" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Magen- und Darmtrakt" data-wig="erkrankung_Magen" data-text="MagenDarm" value="53" title="MagenDarm" name="ws_wiz_question_erkrankung" >


                                                <input type="checkbox" data-wig-text="Tränende Augen" data-wig="erkrankung_TränendeAugen" data-text="TränendeAugen" value="69" title="TränendeAugen" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Würmer" data-wig="erkrankung_Würmer" data-text="Würmer" value="70" title="Würmer" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Regeneration & Muskelaufbau bei Sporthunden" data-wig="erkrankung_RegenerationMuskelauf" data-text="RegenerationMuskelaufbauBeiSporthunden" value="71" title="RegenerationMuskelaufbauBeiSporthunden" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Giardien" data-wig="erkrankung_Giardien" data-text="Giardien" value="72" title="Giardien" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Unterstützung Kondition Aufbau" data-wig="erkrankung_Kondition_Aufbau" data-text="UnterstützungKonditionAufbau" value="73" title="UnterstützungKonditionAufbau" name="ws_wiz_question_erkrankung" >


                                                <div class="clear"></div>
                                                <script type="text/javascript">
                                                    $("input[name=ws_wiz_question_erkrankung]").wizard_img_options();
                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                    </div> <!-- /#step-5 -->

                                    <!-- SEITE 5 -->
                                    <div class="pagination-box">

                                        <div class="schritte">
                                            <ul class="list-inline">
                                                <li><a href="#step-1" class="active">1</a></li>
                                                <li><a href="#step-2" class="clickable">2</a></li>
                                                <li><a href="#step-3" class="disable">3</a></li>
                                                <li><a href="#step-4" class="disable">4</a></li>
                                                <li><a href="#step-5" class="disable">5</a></li>
                                            </ul>
                                        </div>
                                        <p class="js-btn_back" style="display: none;"><a href="" class="js-btn-back">zurück</a></p>
                                        <div id="next_step" class="btn_next js-btn-next-wrapper"><?/*<input type="submit" value="weiter">*/ ?> <a href="#step-2" class="js-btn-next">weiter</a></div>
                                        <div class="btn_next js-submit-wrapper" style="display: none;"><input type="button" id="submit_assistent" value="Berechnen"></div>
                                    </div> <!-- /.pagination -->

                                    <script>



                                        //handle click on A in pagination-box
                                        $( ".schritte" ).find("a").click(function() {
                                            if( $(this).hasClass( "disable" ) ) {
                                                return false;
                                            }

                                            var idOfNextA = "#step-" + (+$( this ).html() + 1);

                                            if( $( this ).hasClass( "clickable" ) ){


                                                declineStep = false;
                                                changeStepView($( this ).attr("href"), true);
                                                if(declineStep) return false;

                                                $( this ).removeClass( "clickable" ).addClass( "active" );

                                                $( "a[href="+idOfNextA +"]").removeClass( "disable" ).addClass( "clickable" );
                                            } else if( $( this ).hasClass( "active" )) {

                                                var mark = true;
                                                if( $( ".clickable" ).length && $( this ).parent().get(0).compareDocumentPosition($(".clickable").parent().prev().get(0)) == 4) {
                                                    mark = false;
                                                } else {
                                                    mark = false;
                                                };

                                                declineStep = false;
                                                changeStepView($( this ).attr("href"), mark);
                                                if(declineStep && mark) return false;
                                            }

                                            if( $( this ).hasClass( "active" ) || $( this ).hasClass( "clickable" )) {

                                                var lastStepAndOne = $('.schritte').find('a').length + 1;

                                                //show-hide next button and button Submit
                                                if(idOfNextA == "#step-" + lastStepAndOne) {
                                                    $( ".js-btn-next-wrapper" ).hide();
                                                    $( ".js-submit-wrapper" ).show();
                                                } else {
                                                    $( ".js-btn-next-wrapper" ).show();
                                                    $( ".js-submit-wrapper" ).hide();
                                                }

                                                //show-hide back button
                                                if((+$( this ).html()) == 1) {
                                                    $( ".js-btn_back" ).hide();
                                                } else {
                                                    $( ".js-btn_back" ).show();

                                                }


                                                //code for changing status of numbered links
                                                setClassesOnA(idOfNextA, $( this ));


                                                //set href in next-button and back-button
                                                $( ".js-btn-next" ).attr("href", idOfNextA);
                                                if( $( this ).attr("href") == "#step-1" ) {
                                                    $( ".js-btn-back" ).attr("href", "javascript:void();");
                                                } else {
                                                    $( ".js-btn-back" ).attr("href", "#step-" + (+$( this ).html() - 1) );
                                                }


                                                return false;
                                            }


                                        });

                                        //handle button back
                                        $( ".pagination-box .js-btn_back" ).click(function() {
                                            var hrefOfA = $( this ).find("a").attr("href");
                                            var currentNumber = +$( "a[href=" + hrefOfA + "]").html();
                                            var selfNextBut = $( this );
                                            declineStep = false;
                                            changeStepView(hrefOfA, false);

                                            var prevNumber = currentNumber - 1;
                                            if (prevNumber < 1) {
                                                $( this ).hide();
                                            } else {
                                                setTimeout(function() {
                                                    selfNextBut.find("a").attr("href", "#step-" + prevNumber );

                                                }, 0);
                                            }

                                            setTimeout(function() {
                                                $( ".js-btn-next-wrapper" ).find( "a" ).attr("href", "#step-" + (currentNumber + 1));
                                                return false;
                                            }, 0);




                                            if( prevNumber == $('.schritte').find('a').length - 2) {
                                                $( ".js-btn-next-wrapper" ).show();
                                                $( ".js-submit-wrapper" ).hide();
                                            }

                                            var idOfNextA = "#step-" + (currentNumber + 1);
                                            setClassesOnA(idOfNextA, $( ".schritte a[href=" + hrefOfA + "]"));

                                            return false;


                                        });

                                        $( ".pagination-box .js-btn-next-wrapper" ).click(function() {
                                            var hrefOfA = $( this ).find("a").attr("href");
                                            var currentNumber = +$( "a[href=" + hrefOfA + "]").html();
                                            var selfNextBut = $( this );

                                            declineStep = false;
                                            changeStepView(hrefOfA, true);
                                            if(declineStep) return false;

                                            var nextNumber = currentNumber + 1;
                                            if (nextNumber > $('.schritte').find('a').length) {
                                                $( this ).hide();
                                                $( ".js-submit-wrapper" ).show();
                                            } else {
                                                $( ".js-btn_back" ).show();
                                                setTimeout(function() {
                                                    selfNextBut.find("a").attr("href", "#step-" + nextNumber );
                                                }, 0);
                                            }

                                            $( "a[href=" + hrefOfA + "]").removeClass( "clickable" ).addClass( "active" );
                                            $( "a[href=#step-" + nextNumber + "]").removeClass( "disable" ).addClass( "clickable" );

                                            setTimeout(function() {
                                                $( ".js-btn_back" ).find( "a" ).attr("href", "#step-" + (currentNumber - 1));
                                                return false;
                                            }, 0);



                                            return false;

                                        });

                                        var declineStep = false;

                                        function changeStepView(id, mark) {
                                            var visibleStepItem = $( ".visible-step");
                                            setDynamicContent(id, visibleStepItem);
                                            if(declineStep && mark) return false;


                                            $( ".visible-step").removeClass( "visible-step" );
                                            $( ".questions_wrapper" ).hide();
                                            $( id ).show().addClass( "visible-step" );

                                        }



                                        function setClassesOnA(idOfNextA, elem) {

                                            $( "a[href="+idOfNextA +"]").removeClass( "active clickable" ).addClass( "clickable" );
                                            for (var i = +elem.html() + 2; i < $( ".schritte" ).find("a").length+1; i++) {
                                                var currentA = $( "a[href=#step-"+i +"]");
                                                if( currentA.hasClass( "active" )) {
                                                    currentA.removeClass( "active" ).addClass( "disable" );
                                                } else if( currentA.hasClass( "clickable" ) ) {
                                                    currentA.removeClass( "clickable" ).addClass( "disable" );
                                                }
                                            }
                                        }
                                        //.js-step-header

                                        function setDynamicContent(idStep, visibleElem) {
                                            var visibleElemId = visibleElem.attr("id");
                                            var name = "What";

                                            //.ueberblick_wrapper
                                            formModel.forEach(function(item) {
                                                if(item.step == "#" + visibleElemId) {

                                                    item.inputs.forEach(function(element) {
                                                        if(( $( "[name=" + element.field + "]").prop("required") ) ) {
                                                            validation($("[name=" + element.field + "]") );
                                                        };
                                                    })
                                                    if(declineStep) return;

                                                    item.inputs.forEach(function(element) {
                                                        createAnswerBox(element);
                                                    })
                                                }
                                            });

                                            if(declineStep) return;


                                            //set stepHeaders
                                            formModel.forEach(function(item) {
                                                if(item.step == idStep) {
                                                    $( ".js-step-header" ).html(item.header);
                                                    if( $( ".js-step-header" ).find(".dog-name").length ) {
                                                        $( ".js-step-header" ).find(".dog-name").html($( "[name=name]").val());
                                                    }
                                                }
                                            });
                                        }

                                        //***************************** New Code BEGIN ******************************

                                        $( '[required]' ).change(function() {
                                            var name = $(this).attr('name');
                                            var val = validation( $( '[name=' + name +']') );
                                            if(val) {
                                                hideMessage($(this));
                                            }
                                        });

                                        $( '[required]' ).on("input", function() {
                                            var name = $(this).attr('name');
                                            var val = validation( $( '[name=' + name +']') );
                                            if(val) {
                                                hideMessage($(this));
                                            }
                                        });

                                        function hideMessage(element) {
                                            //element.parent().find( '.warning-message' ).slideUp();
                                            var name = element.attr('name');

                                            if(element.attr('type') == "radio" ) {
                                                element.closest( '.antwort' ).find( '.warning-message' ).slideUp();
                                                element.closest( '.antwort' ).find( '.wizard_img' )
                                                    .css( "border-color", "" );
                                            }

                                            if(element.attr('type') == "text" ) {
                                                element.closest( '.antwort' ).find( '.warning-message' ).slideUp();
                                                element.css( "border-color", "" );
                                            }

                                            if( element.attr('name') == "geburtstag" ) {
                                                element.css( "border-color", "" );
                                            }

                                            if( element.attr('name') == "geburtsmonat" ) {
                                                element.css( "border-color", "" );
                                            }

                                            if( element.attr('name') == "geburtsjahr" ) {
                                                element.css( "border-color", "" );
                                            }

                                            if( $( '[name=geburtstag]').val() && $( '[name=geburtsmonat]').val() && $( '[name=geburtsjahr]').val() ) {
                                                element.parent().find( '.warning-message' ).slideUp();
                                            }

                                        }

                                        function showMessage(element) {
                                            // var messageWrapper = $( "<div class='warning-message' style='color: #ff0000;'>" );
                                            // messageWrapper.html('*Pflichtangaben')
                                            element.closest( '.antwort' ).find( '.warning-message' ).slideDown();
                                            if( element.attr('type') == "radio" ) {
                                                element.parent().find( '.wizard_img' )
                                                    .css( "border-color", "#f00" );
                                            }

                                            if( element.attr('name') == "geburtstag" ) {
                                                element.css( "border-color", "#f00" );
                                            }

                                            if( element.attr('name') == "geburtsmonat" ) {
                                                element.css( "border-color", "#f00" );
                                            }

                                            if( element.attr('name') == "geburtsjahr" ) {
                                                element.css( "border-color", "#f00" );
                                            }

                                            if( element.attr('type') == "text" ) {
                                                //element.parent().find( '.warning-message' ).slideDown();
                                                element.css( "border-color", "#f00" );
                                            }


                                        }


                                        //***************************** New Code END ******************************

                                        //**************************************************

                                        function validation(elem) {
                                            if( elem.attr("type") == "radio") {
                                                var valueN = false;
                                                elem.each(function(index, item) {
                                                    if( $(item).prop("checked") ) {
                                                        valueN = true;
                                                    }
                                                });
                                                if(!valueN) {
                                                    declineStep = true;
                                                    showMessage(elem);
                                                    return false;
                                                }

                                            } else if(elem.attr("type") == "text" && !elem.val()) {
                                                declineStep = true;
                                                showMessage(elem);

                                                return false;
                                            } else if(elem.closest('select') && !elem.val() ) {
                                                //console.log(333);
                                                declineStep = true;
                                                showMessage(elem);

                                                return false;
                                            }
                                            return true;
                                        }

                                        //***********************************************************************
                                        function createAnswerBox(elem) {
                                            var antwortWrapper;

                                            if( $("[data-text=" + elem.field + "]").length ) {
                                                antwortWrapper = $("[data-text=" + elem.field + "]").closest(".antwort_wrapper");
                                            } else {
                                                antwortWrapper = $( "<div>" );
                                                antwortWrapper.html(infoBlock);
                                                antwortWrapper.find(".bezeichnung").html(elem.name);

                                                $( ".ueberblick_wrapper" ).append(antwortWrapper);
                                            }


                                            //check if step has checkbox and if they'are checked
                                            if( $("[name=" + elem.field + "]").attr("type") == "checkbox" ) {
                                                var valueeElem = [];

                                                $("[name=" + elem.field + "]").each(function(index, item) {
                                                    if( $( item ).prop("checked") ) {
                                                        valueeElem.push( $( item ).data("text") );
                                                    }
                                                });

                                                /*if(!valueeElem.length && elem.name != "Trockenfutter:") { 
                                                    //showMessage(elem);
                                                    //declineStep = true;
                                                };*/

                                                if(!valueeElem.length && elem.name == "Trockenfutter:") {
                                                    antwortWrapper.find(".bezeichnung").html("");
                                                    return false;
                                                }



                                                antwortWrapper.find(".antwort").attr("data-text", elem.field);
                                                antwortWrapper.find(".antwort").html( valueeElem.join(", ") );

                                                //check if step has radio and if they'are checked
                                            } else if($("[name=" + elem.field + "]").attr("type") == "radio") {

                                                var valueRadio = '';

                                                $("[name=" + elem.field + "]").each(function(index, item) {
                                                    if( $( item ).prop("checked") ) {
                                                        valueRadio = $( item ).data("text");
                                                    }
                                                });

                                                antwortWrapper.find(".antwort").attr("data-text", elem.field);
                                                antwortWrapper.find(".antwort").html(valueRadio);
                                            } else {

                                                antwortWrapper.find(".antwort").attr("data-text", elem.field);
                                                antwortWrapper.find(".antwort").html( $( "[name=" + elem.field + "]").val() );

                                                if(elem.name = "Rasse:") {
                                                    var valueItem = $( "[name=" + elem.field + "]").val();
                                                    roptions.forEach(function(item) {
                                                        if(item.value == valueItem) {
                                                            antwortWrapper.find(".antwort").html( item.text );
                                                        }
                                                    });
                                                }
                                            }
                                            //check if step has radio and if they'are checked



                                        }


                                        var infoBlock = '<div class="nummer antwort_wrapper">\n' +																				'<span class="bezeichnung"></span>\n ' +
                                            '<span class="antwort" data-text=""></span>\n' +
                                            '</div>';

                                        var formModel = [
                                            {
                                                step: "#step-1",
                                                header: "Meine Daten",
                                                inputs: [
                                                    {
                                                        name: "Hundename:",
                                                        field: "name"
                                                    },
                                                    {
                                                        name: "Rasse:",
                                                        field: "rasse"
                                                    },
                                                    {
                                                        name: "Geschlecht:",
                                                        field: "geschlecht"
                                                    },
                                                    {
                                                        name: "Kastriert:",
                                                        field: "kastriert"
                                                    },
                                                    {
                                                        name: "Geburtstag:",
                                                        field: "geburtstag"
                                                    },
                                                    {
                                                        name: "Geburtsmonat:",
                                                        field: "geburtsmonat"
                                                    },
                                                    {
                                                        name: "Geburtsjahr:",
                                                        field: "geburtsjahr"
                                                    }
                                                ]
                                            },
                                            {
                                                step: "#step-2",
                                                header: "Mein Gewicht",
                                                inputs: [
                                                    {
                                                        name: "Gewicht:",
                                                        field: "ws_wiz_question_gewicht"
                                                    },
                                                    {
                                                        name: "Ernährungszustand:",
                                                        field: "ws_wiz_question_gewichtsgrad"
                                                    }
                                                ]
                                            },
                                            {
                                                step: "#step-3",
                                                header: "Meine Aktivität",
                                                inputs: [
                                                    {
                                                        name: "Aktivitätszustand:",
                                                        field: "ws_wiz_question_aktivitaet"
                                                    }
                                                ]
                                            },
                                            // {
                                            //     step: "#step-4",
                                            //     header: "Bevorzugt <span class='dog-name'></span> eher Trocken- oder Nassfutter",
                                            //     inputs: [
                                            //         {
                                            //             name: "Trocken- oder Nassfutter:",
                                            //             field: "ws_wiz_question_trocken_nassfutter"
                                            //         },
                                            //         {
                                            //             name: "Trockenfutter:",
                                            //             field: "ws_wiz_question_trockenfutter"
                                            //         }
                                            //     ]
                                            // },
                                            {
                                                step: "#step-4",
                                                header: "Das Hundefutter sollte für <span class='dog-name'></span> folgendes <strong><u>nicht</u></strong> enthalten",
                                                inputs: [
                                                    {
                                                        name: "Hundefutter:",
                                                        field: "ws_wiz_question_unvertraeglichkeit"
                                                    }
                                                ]
                                            },
                                            {
                                                step: "#step-5",
                                                header: "Ihr Hund <span class='dog-name'></span> hat folgende Probleme, oder benötigt Unterstützung bei folgenden Punkten?",
                                                inputs: [
                                                    {
                                                        name: "Unterstützung bei:",
                                                        field: "ws_wiz_question_erkrankung"
                                                    }
                                                ]
                                            }
                                        ]; //end of formModel





                                    </script>

                                </div>
                                <div id="column_left" class="content_column_left hidden-xs hidden-sm col-md-3 col-lg-4">
                                    <h3>Grundlegende Informationen</h3>

                                    <div class="ueberblick_wrapper">

                                    </div> <!-- /.ueberblick_wrapper -->
                                </div>

                                <div class="clear"></div>
                            </form>
                        </div>
                        <!-- formaaa END  -->
                        <!-- PUT FORM Here  -->
                    </div>


                </div>
                <script type="text/javascript"><!--
                    $('#submit_assistent').on('click', function() {
                        filter = [];

                        <!-- #step1 -->
                        var geburtstag = $("[name=geburtstag]").val();
                        var geburtsmonat = $("[name=geburtsmonat]").val();
                        var geburtsjahr = $("[name=geburtsjahr]").val();
                        var diff = dateDiff( new Date( geburtsjahr+'-'+geburtsmonat+'-'+geburtstag ), new Date( '<?php echo date("Y"); ?>-<?php echo date("m"); ?>-<?php echo date("d"); ?>' ) );

                        if(diff[1]<=12) {
                            filter.push(60); //Junior
                            if(diff[1]<=6) {
                                filter.push(83); //Jünger Hund (weniger als 6 Monate)
                            }
                        } else if(diff[0]<=5) {
                            filter.push(61); //Jünger Hund (über 12 Monate)
                        } else {
                            filter.push(62); //Älter Hund
                        }

                        $('input[name^=\'kastriert\']:checked').each(function(element) {
                            filter.push(this.value);
                        });

                        <!-- #step2 -->
                        var weight = +$("[name=ws_wiz_question_gewicht]").val();
                        if (isNumeric(weight)) {
                            if (weight >= 0 && weight <= 8 ) {
                                if (weight == 7 ) {
                                    filter.push(79); // dogs with weight 7 kg
                                } else {
                                    filter.push(74); // dogs with weight between 0 and 8 kg
                                }
                            } else if ( weight > 8 && weight <= 25 ) {
                                if (weight == 10) {
                                    filter.push(80);  // dogs with weight 10 kg
                                } else {
                                    filter.push(75);  // dogs with weight between 8 and 25 kg
                                }
                            } else if ( weight > 25 ) {
                                if (weight == 30) {
                                    filter.push(81);  // dogs with weight 30 kg
                                } else {
                                    filter.push(76);  // dogs with weight larger than 25 kg
                                }
                            }
                        }


                        $('input[name^=\'ws_wiz_question_gewichtsgrad\']:checked').each(function(element) {
                            filter.push(this.value);
                        });

                        <!-- #step3 -->
                        $('input[name^=\'ws_wiz_question_aktivitaet\']:checked').each(function(element) {
                            filter.push(this.value);
                        });

                        <!-- #step4 -->
                        $('input[name^=\'ws_wiz_question_trockenfutter\']:checked').each(function(element) {
                            if(this.value!='') filter.push(this.value);
                        });
                        $('input[name^=\'ws_wiz_question_trocken_nassfutter\']:checked').each(function(element) {
                            if(this.value!='') filter.push(this.value);
                        });

                        <!-- #step5 -->
                        $('input[name^=\'ws_wiz_question_unvertraeglichkeit\']:checked').each(function(element) {
                            filter.push(this.value);
                        });

                        <!-- #step6 -->
                        if ($('input[name^=\'ws_wiz_question_erkrankung\']:checked').length) {
                            $('input[name^=\'ws_wiz_question_erkrankung\']:checked').each(function(element) {
                                filter.push(this.value);
                            });
                        }
                        // else {
                        // 	filter.push(78);
                        // }

                        location = '<?php echo $action; ?>&filter=' + filter.join(',') + '&dog_name=' + $('input[name=\'name\']').val();
                    });
                    function isNumeric(n) {
                        return !isNaN(parseFloat(n)) && isFinite(n);
                    }

                    function dateDiff( date1, date2 ) {
                        var years = date2.getFullYear() - date1.getFullYear();
                        var months = years * 12 + date2.getMonth() - date1.getMonth();
                        var days = date2.getDate() - date1.getDate();

                        years -= date2.getMonth() < date1.getMonth();
                        months -= date2.getDate() < date1.getDate();
                        days += days < 0 ? new Date( date2.getFullYear(), date2.getMonth() - 1, 0 ).getDate() + 1 : 0;

                        return [ years, months, days ];
                    }
                    //--></script>


                <?php echo $column_right; ?>


            </div>
        </div>
    </div>
</div>
<?php if (isset($consultant['geschlecht']) && isset($consultant['day']) && isset($consultant['month']) && isset($consultant['year'])) {?>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#next_step').click();
                $('.step-1').removeClass("loading");
            }, 10);
        });
    </script>
<?php } ?>
<?php echo $footer; ?>

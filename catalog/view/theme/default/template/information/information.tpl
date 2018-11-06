<?php echo $header; ?>
    <link href="catalog/view/theme/default/css/styles_futterassistent.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="catalog/view/theme/default/css/styles.css" type="text/css" rel="stylesheet" media="screen" />
<div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation" >
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
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
        <?php if ($description) { ?>
        <?php echo $description; ?>
        <?php } ?>
</main>
    <?php if ($status_consultant) {?>
        <div id="content_inhaltstpl" class="tpl_futterassistent wizard_type_Hund row" style="margin: 0 -15px">
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
                                <input autocomplete="false" type="text" value="" placeholder="<?php echo $cons_input_plach_name; ?>" name="name">
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
	<div class="row">
		<div class="col-xs-12 content_bottom" >
	<?php echo $content_bottom; ?>
	   </div>
	</div><!-- end content_bottom -->

</div>

</div><!-- end right container -->



<?php echo $column_right; ?>


          </div>
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
<?php echo $footer; ?>
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
                                    <h1 class="headline">Futterassistent</h1>
                                    <h2 class="js-step-header">Meine Daten</h2>

                                    <!-- SEITE 1 -->

                                    <div class="questions_wrapper visible-step" id="step-1">




                                        <div class="question_wrapper name ">
                                            <div class="frage">Hundename</div>
                                            <div class="antwort">
                                                <input autocomplete="false" type="text" value="" name="name">

                                            </div>
                                            <div class="clear"></div>
                                        </div>



                                        <div class="question_wrapper rasse ">
                                            <div class="frage">Rasse</div>
                                            <div class="antwort">
                                                <input type="text" name="rasse" value="" style="display: none;">
                                                <script type="text/javascript">
                                                    var roptions =  [{
                                                                        "value": "dog-rasse-0",
                                                                        "text": "Affenpinscher",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-1",
                                                                        "text": "Afghanischer Windhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-2",
                                                                        "text": "Aidi",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-3",
                                                                        "text": "Ainu-Hund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-4",
                                                                        "text": "Airedale-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-5",
                                                                        "text": "Akbash",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-6",
                                                                        "text": "Akita Inu",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-7",
                                                                        "text": "Alapaha Blue Blood Bulldog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-8",
                                                                        "text": "Alaskan Malamute",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-9",
                                                                        "text": "Alpenländische Dachsbracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-10",
                                                                        "text": "Altdänischer Vorstehhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-11",
                                                                        "text": "American Bulldog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-12",
                                                                        "text": "American Foxhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-13",
                                                                        "text": "American Staghound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-14",
                                                                        "text": "American Toy Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-15",
                                                                        "text": "American Water Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-16",
                                                                        "text": "Amerikanischer Cockerspaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-17",
                                                                        "text": "Amerikanischer Pit-Bullterrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-18",
                                                                        "text": "Amerikanischer Staffordshire-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-19",
                                                                        "text": "Anglo-Francais de Petite Vénerie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-20",
                                                                        "text": "Appenzeller Sennenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-21",
                                                                        "text": "Ariegéois",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-22",
                                                                        "text": "Australian Cattle Dog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-23",
                                                                        "text": "Australian Kelpie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-24",
                                                                        "text": "Australian Shepherd Dog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-25",
                                                                        "text": "Australian Silky Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-26",
                                                                        "text": "Australian Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-27",
                                                                        "text": "Azawakh",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-28",
                                                                        "text": "Balearen Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-29",
                                                                        "text": "Balkanbracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-30",
                                                                        "text": "Barbet",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-31",
                                                                        "text": "Barsoi",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-32",
                                                                        "text": "Basenji",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-33",
                                                                        "text": "Basset Artésien-Normand",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-34",
                                                                        "text": "Basset Bleu de Gascogne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-35",
                                                                        "text": "Basset Fauve de Bretagne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-36",
                                                                        "text": "Basset Hound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-37",
                                                                        "text": "Bayerischer Gebirgsschweisshund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-38",
                                                                        "text": "Beagle",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-39",
                                                                        "text": "Beagle-Harrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-40",
                                                                        "text": "Bearded Collie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-41",
                                                                        "text": "Beauceron",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-42",
                                                                        "text": "Bedlington-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-43",
                                                                        "text": "Bergamasker Hirtenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-44",
                                                                        "text": "Berger de Pyrénées",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-45",
                                                                        "text": "Berger de Pyrénées Langhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-46",
                                                                        "text": "Berger Picard",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-47",
                                                                        "text": "Berner Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-48",
                                                                        "text": "Berner Niederlaufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-49",
                                                                        "text": "Berner Sennenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-50",
                                                                        "text": "Bernhardiner",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-51",
                                                                        "text": "Bichon Frisé",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-52",
                                                                        "text": "Bichon/Yorkie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-53",
                                                                        "text": "Billy",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-54",
                                                                        "text": "Black and Tan Coonhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-55",
                                                                        "text": "Bloodhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-56",
                                                                        "text": "Bluetick Coonhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-57",
                                                                        "text": "Bobtail",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-58",
                                                                        "text": "Boerboel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-59",
                                                                        "text": "Bologneser",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-60",
                                                                        "text": "Bolonka Zwetna",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-61",
                                                                        "text": "Bordeauxdogge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-62",
                                                                        "text": "Border Collie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-63",
                                                                        "text": "Border Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-64",
                                                                        "text": "Bosnischer Rauhhaariger Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-65",
                                                                        "text": "Boston Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-66",
                                                                        "text": "Bouvier des Flandres",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-67",
                                                                        "text": "Boxer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-68",
                                                                        "text": "Brabancon",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-69",
                                                                        "text": "Bracco Italiano",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-70",
                                                                        "text": "Braque de L´Ariège",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-71",
                                                                        "text": "Braque du Bourbonnais",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-72",
                                                                        "text": "Braque d´Auvergne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-73",
                                                                        "text": "Braque Francais de Gascoine",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-74",
                                                                        "text": "Braque Francais des Pyrénées",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-75",
                                                                        "text": "Braque Saint-Germain",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-76",
                                                                        "text": "Brasilianischer Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-77",
                                                                        "text": "Briard",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-78",
                                                                        "text": "Briquet Griffon Vendéen",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-79",
                                                                        "text": "Broholmer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-80",
                                                                        "text": "Bull-Boxer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-81",
                                                                        "text": "Bulldog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-82",
                                                                        "text": "Bullmastiff",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-83",
                                                                        "text": "Bullterrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-84",
                                                                        "text": "Ca de Bestiar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-85",
                                                                        "text": "Ca de Bou",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-86",
                                                                        "text": "Cairn-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-87",
                                                                        "text": "Cane Corso",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-88",
                                                                        "text": "Cao da Serra da Estrela",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-89",
                                                                        "text": "Cao da Serra de Aires",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-90",
                                                                        "text": "Cao de Agua Portugues",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-91",
                                                                        "text": "Cao do Castro Laboreiro",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-92",
                                                                        "text": "Carolina Dog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-93",
                                                                        "text": "Catahoula Leopard Dog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-94",
                                                                        "text": "Cavalier King Charles Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-95",
                                                                        "text": "Ceský Fousek",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-96",
                                                                        "text": "Ceský Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-97",
                                                                        "text": "Chesapeake Bay Retriever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-98",
                                                                        "text": "Chien d´Artois",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-99",
                                                                        "text": "Chihuahua kurzhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-100",
                                                                        "text": "Chihuahua langhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-101",
                                                                        "text": "Chinesischer Schopfhund Hairless-Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-102",
                                                                        "text": "Chinesischer Schopfhund Powderpuff-Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-103",
                                                                        "text": "Chinook",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-104",
                                                                        "text": "Chow-Chow",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-105",
                                                                        "text": "Cirneco dell´ Etna",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-106",
                                                                        "text": "Clumber-Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-107",
                                                                        "text": "Cockerpoo",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-108",
                                                                        "text": "Coton de Tuléar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-109",
                                                                        "text": "Curly-Coated Retriever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-110",
                                                                        "text": "Dalmatiner",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-111",
                                                                        "text": "Dandie Dinmont Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-112",
                                                                        "text": "Dänischer Bauernhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-113",
                                                                        "text": "Deerhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-114",
                                                                        "text": "Deutsch Drahthaar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-115",
                                                                        "text": "Deutsch Kurzhaar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-116",
                                                                        "text": "Deutsch Langhaar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-117",
                                                                        "text": "Deutsche Dogge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-118",
                                                                        "text": "Deutscher Jagdterrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-119",
                                                                        "text": "Deutscher Pinscher",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-120",
                                                                        "text": "Deutscher Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-121",
                                                                        "text": "Deutscher Schäferhund Brauner langhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-122",
                                                                        "text": "Deutscher Schäferhund Cremefarbener langhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-123",
                                                                        "text": "Deutscher Schäferhund Schwarzer langhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-124",
                                                                        "text": "Deutscher Wachtelhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-125",
                                                                        "text": "Deutscher Wolfsspitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-126",
                                                                        "text": "Dingo",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-127",
                                                                        "text": "Dobermann",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-128",
                                                                        "text": "Dogo Argentino",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-129",
                                                                        "text": "Dreifarbiger Serbischer Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-130",
                                                                        "text": "Drentse Patrijshond",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-131",
                                                                        "text": "Drever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-132",
                                                                        "text": "Dunker",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-133",
                                                                        "text": "Englischer Cocker Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-134",
                                                                        "text": "English Coonhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-135",
                                                                        "text": "English Foxhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-136",
                                                                        "text": "English Setter",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-137",
                                                                        "text": "English Springer Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-138",
                                                                        "text": "English Toy Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-139",
                                                                        "text": "Entlebucher Sennenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-140",
                                                                        "text": "Epagneul Bleu de Picardie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-141",
                                                                        "text": "Epagneul Breton",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-142",
                                                                        "text": "Epagneul de Pont-Audemer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-143",
                                                                        "text": "Epagneul Francais",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-144",
                                                                        "text": "Epagneul Picard",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-145",
                                                                        "text": "Eskimohund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-146",
                                                                        "text": "Eurasier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-147",
                                                                        "text": "Field Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-148",
                                                                        "text": "Fila Brasileiro",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-149",
                                                                        "text": "Finnenspitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-150",
                                                                        "text": "Finnischer Lapphund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-151",
                                                                        "text": "Finnischer Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-152",
                                                                        "text": "Flat Coated Retriever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-153",
                                                                        "text": "Foxterrier Drahthaar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-154",
                                                                        "text": "Foxterrier Glatthaar",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-155",
                                                                        "text": "Französische Bulldogge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-156",
                                                                        "text": "Französischer Laufhund Dreifarbig",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-157",
                                                                        "text": "Französischer Laufhund Weiss-Schwarz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-158",
                                                                        "text": "Glen of Imaal Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-159",
                                                                        "text": "Golden Retriever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-160",
                                                                        "text": "Gordon Setter",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-161",
                                                                        "text": "Gos d´Atura Català",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-162",
                                                                        "text": "Grand Anglo-Francais Blanc et Noir",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-163",
                                                                        "text": "Grand Anglo-Francais Tricolore",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-164",
                                                                        "text": "Grand Basset Griffon Vendéen",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-165",
                                                                        "text": "Grand Bleu de Gascogne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-166",
                                                                        "text": "Grand Gascon Saintongeois",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-167",
                                                                        "text": "Grand Griffon Vendéen",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-168",
                                                                        "text": "Greyhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-169",
                                                                        "text": "Griffon á Poil Dur",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-170",
                                                                        "text": "Griffon Belge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-171",
                                                                        "text": "Griffon Bruxellois",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-172",
                                                                        "text": "Griffon Fauve de Bretagne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-173",
                                                                        "text": "Griffon Nivernais",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-174",
                                                                        "text": "Groenendael",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-175",
                                                                        "text": "Grönlandhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-176",
                                                                        "text": "Grosser Münsterländer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-177",
                                                                        "text": "Grosser Schweizer Sennenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-178",
                                                                        "text": "Grosspudel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-179",
                                                                        "text": "Hamiltonstövare",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-180",
                                                                        "text": "Hannoverscher Schweisshund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-181",
                                                                        "text": "Harrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-182",
                                                                        "text": "Havaneser",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-183",
                                                                        "text": "Himalaja-Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-184",
                                                                        "text": "Hollandse Herdershond",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-185",
                                                                        "text": "Hollandse Herdershond Langhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-186",
                                                                        "text": "Hollandse Herdershond Rauhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-187",
                                                                        "text": "Hollandse Smoushond",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-188",
                                                                        "text": "Hovawart",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-189",
                                                                        "text": "Hygenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-190",
                                                                        "text": "Illyrischer Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-191",
                                                                        "text": "Irischer Soft Coated Wheaten Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-192",
                                                                        "text": "Irish Red Setter",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-193",
                                                                        "text": "Irish red-and-white Setter",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-194",
                                                                        "text": "Irish Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-195",
                                                                        "text": "Irish Water Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-196",
                                                                        "text": "Irish Wolfhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-197",
                                                                        "text": "Islandhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-198",
                                                                        "text": "Istrianer Kurzhaarige Bracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-199",
                                                                        "text": "Istrianer Rauhhaarige Bracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-200",
                                                                        "text": "Istrianer Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-201",
                                                                        "text": "Italienisches Windspiel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-202",
                                                                        "text": "Jack-Russell-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-203",
                                                                        "text": "Jämthund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-204",
                                                                        "text": "Japan Chin",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-205",
                                                                        "text": "Japan Spitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-206",
                                                                        "text": "Japanischer Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-207",
                                                                        "text": "Jura-Laufhund (Bruno)",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-208",
                                                                        "text": "Jura-Laufhund (Saint-Hubert)",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-209",
                                                                        "text": "Kai",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-210",
                                                                        "text": "Kanaanhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-211",
                                                                        "text": "Kanarische Dogge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-212",
                                                                        "text": "Kangal",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-213",
                                                                        "text": "Karelischer Bärenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-214",
                                                                        "text": "Kaukasischer Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-215",
                                                                        "text": "Kerry Blue Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-216",
                                                                        "text": "Kerry-Beagle",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-217",
                                                                        "text": "King Charles Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-218",
                                                                        "text": "Kleiner Münsterländer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-219",
                                                                        "text": "Komondor",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-220",
                                                                        "text": "Korea Jindo Dog",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-221",
                                                                        "text": "Kroatischer Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-222",
                                                                        "text": "Kromfohrländer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-223",
                                                                        "text": "Kurzhaarcollie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-224",
                                                                        "text": "Kurzhaardackel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-225",
                                                                        "text": "Kurzhaariger Ungarischer Vorstehhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-226",
                                                                        "text": "Kuvasz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-227",
                                                                        "text": "Kyi Leo",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-228",
                                                                        "text": "Labradoodle",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-229",
                                                                        "text": "Labrador Retriever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-230",
                                                                        "text": "Laekenois",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-231",
                                                                        "text": "Lagotto Romagnolo",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-232",
                                                                        "text": "Lakeland Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-233",
                                                                        "text": "Lancashire-Heeler",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-234",
                                                                        "text": "Landseer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-235",
                                                                        "text": "Langhaarcollie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-236",
                                                                        "text": "Langhaardackel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-237",
                                                                        "text": "Lappländer Rentierhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-238",
                                                                        "text": "Leonberger",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-239",
                                                                        "text": "Lhasa Apso",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-240",
                                                                        "text": "Löwchen",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-241",
                                                                        "text": "Lucas-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-242",
                                                                        "text": "Lurcher",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-243",
                                                                        "text": "Luzerner Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-244",
                                                                        "text": "Malinois",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-245",
                                                                        "text": "Malteser",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-246",
                                                                        "text": "Manchester-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-247",
                                                                        "text": "Maremmaner Hirtenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-248",
                                                                        "text": "Mastiff",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-249",
                                                                        "text": "Mastin Espanol",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-250",
                                                                        "text": "Mastino Napoletano",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-251",
                                                                        "text": "Mexikanischer Nackthund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-252",
                                                                        "text": "Mexikanischer Toy-Nackthund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-253",
                                                                        "text": "Mexikanischer Zwergnackthund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-254",
                                                                        "text": "Miniatur Bullterrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-255",
                                                                        "text": "Miniature American Shepherd",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-256",
                                                                        "text": "Mittelasiatischer Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-257",
                                                                        "text": "Mittelasiatischer Schäferhund Kurzhaariger Schlag",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-258",
                                                                        "text": "Mittelspitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-259",
                                                                        "text": "Montenegrinischer Gebirgslaufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-260",
                                                                        "text": "Mops",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-261",
                                                                        "text": "Mudi",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-262",
                                                                        "text": "Nederlandse Kooikerhondje",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-263",
                                                                        "text": "Neufundländer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-264",
                                                                        "text": "Neuguinea-Dingo",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-265",
                                                                        "text": "Neuseeländischer Huntaway",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-266",
                                                                        "text": "Norfolk-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-267",
                                                                        "text": "Norrbottenspitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-268",
                                                                        "text": "Norwegischer Buhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-269",
                                                                        "text": "Norwegischer Elchhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-270",
                                                                        "text": "Norwegischer Elchhund schwarz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-271",
                                                                        "text": "Norwegischer Lundehund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-272",
                                                                        "text": "Norwich Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-273",
                                                                        "text": "Nova Scotia Duck Tolling Retriever",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-274",
                                                                        "text": "Olde English Bulldogge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-275",
                                                                        "text": "Österreichischer Pinscher",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-276",
                                                                        "text": "Ostsibirischer Laika",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-277",
                                                                        "text": "Otterhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-278",
                                                                        "text": "Papillon",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-279",
                                                                        "text": "Parson-Russell-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-280",
                                                                        "text": "Patterdale-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-281",
                                                                        "text": "Pekingese",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-282",
                                                                        "text": "Perdigueiro Portugues",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-283",
                                                                        "text": "Perdiguero de Burgos",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-284",
                                                                        "text": "Perro de Agua Espanol",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-285",
                                                                        "text": "Peruanischer Nackthund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-286",
                                                                        "text": "Peruvian Inca Orchid",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-287",
                                                                        "text": "Petit Basset Griffon Vendéen",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-288",
                                                                        "text": "Petit Bleu de Gascogne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-289",
                                                                        "text": "Petit Griffon de Gascogne",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-290",
                                                                        "text": "Phalene",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-291",
                                                                        "text": "Pharaonenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-292",
                                                                        "text": "Plott Hound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-293",
                                                                        "text": "Plummer-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-294",
                                                                        "text": "Podenco Canario",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-295",
                                                                        "text": "Podengo Portugueso Medio",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-296",
                                                                        "text": "Podengo Portugueso Pequeno",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-297",
                                                                        "text": "Pointer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-298",
                                                                        "text": "Poitevin",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-299",
                                                                        "text": "Polnische Bracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-300",
                                                                        "text": "Polnischer Niederungshütehund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-301",
                                                                        "text": "Polski Owczarek Podhalanski",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-302",
                                                                        "text": "Porcelaine",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-303",
                                                                        "text": "Posavski Gonic",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-304",
                                                                        "text": "Praszký Krysavik",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-305",
                                                                        "text": "Pudel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-306",
                                                                        "text": "Pudelpointer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-307",
                                                                        "text": "Puli",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-308",
                                                                        "text": "Pumi",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-309",
                                                                        "text": "Pyrenäenberghund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-310",
                                                                        "text": "Pyrenäenhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-311",
                                                                        "text": "Rafeiro do Alentejo",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-312",
                                                                        "text": "Rampur-Windhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-313",
                                                                        "text": "Ratero",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-314",
                                                                        "text": "Rauhhaardackel (Zwergdackel)",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-315",
                                                                        "text": "Rauhhaariger Berner Niederlaufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-316",
                                                                        "text": "Redbone Coonhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-317",
                                                                        "text": "Rhodesian Ridgeback",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-318",
                                                                        "text": "Riesenschnauzer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-319",
                                                                        "text": "Rottweiler",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-320",
                                                                        "text": "Russisch-Europäischer Laika",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-321",
                                                                        "text": "Russischer Schwarzer Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-322",
                                                                        "text": "Saarlooswolfhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-323",
                                                                        "text": "Sabueso Espanol",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-324",
                                                                        "text": "Saluki",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-325",
                                                                        "text": "Samojede",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-326",
                                                                        "text": "Schapendoes",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-327",
                                                                        "text": "Schillerstövare",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-328",
                                                                        "text": "Schipperke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-329",
                                                                        "text": "Schnauzer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-330",
                                                                        "text": "Schnürenpudel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-331",
                                                                        "text": "Schwedischer Lapphund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-332",
                                                                        "text": "Schweizer Laufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-333",
                                                                        "text": "Schweizerischer Niederlaufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-334",
                                                                        "text": "Schweizerischer Niederlaufhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-335",
                                                                        "text": "Scottish Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-336",
                                                                        "text": "Sealyham-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-337",
                                                                        "text": "Segugio Italiano (Kurzhaar)",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-338",
                                                                        "text": "Shar Pei",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-339",
                                                                        "text": "Sheltie",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-340",
                                                                        "text": "Shiba",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-341",
                                                                        "text": "Shih Tzu",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-342",
                                                                        "text": "Shikoku",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-343",
                                                                        "text": "Shiloh Shepherd",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-344",
                                                                        "text": "Siberian Husky",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-345",
                                                                        "text": "Skye Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-346",
                                                                        "text": "Sloughi",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-347",
                                                                        "text": "Slovensky Cuvac",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-348",
                                                                        "text": "Slovensky Kopov",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-349",
                                                                        "text": "Slowakischer Rauhbart",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-350",
                                                                        "text": "Smaland-Stövare",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-351",
                                                                        "text": "Spanischer Windhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-352",
                                                                        "text": "Spinone Italiano",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-353",
                                                                        "text": "Stabyhond - Stabijhoun",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-354",
                                                                        "text": "Staffordshire Bullterrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-355",
                                                                        "text": "Steirische Rauhhaarbracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-356",
                                                                        "text": "Südrussischer Owtscharka",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-357",
                                                                        "text": "Sussex-Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-358",
                                                                        "text": "Tervueren",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-359",
                                                                        "text": "Thai Ridgeback",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-360",
                                                                        "text": "Tibet-Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-361",
                                                                        "text": "Tibet-Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-362",
                                                                        "text": "Tibetdogge",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-363",
                                                                        "text": "Tibetischer Kyi Apso",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-364",
                                                                        "text": "Tosa",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-365",
                                                                        "text": "Toy-Pudel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-366",
                                                                        "text": "Treeing Walker Coonhound",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-367",
                                                                        "text": "Tschechoslowakischer Wolfhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-368",
                                                                        "text": "Ungarische Bracke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-369",
                                                                        "text": "Ungarischer Windhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-370",
                                                                        "text": "Västgötaspets",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-371",
                                                                        "text": "Volpino Italiano",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-372",
                                                                        "text": "Wäller",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-373",
                                                                        "text": "Weimaraner",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-374",
                                                                        "text": "Weißer Schweizer Schäferhund",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-375",
                                                                        "text": "Welsh Corgi Cardigan",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-376",
                                                                        "text": "Welsh Corgi Pembroke",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-377",
                                                                        "text": "Welsh Springer Spaniel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-378",
                                                                        "text": "Welsh Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-379",
                                                                        "text": "West Highland White Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-380",
                                                                        "text": "Westsibirischer Laika",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-381",
                                                                        "text": "Wetterhoun",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-382",
                                                                        "text": "Whippet",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-383",
                                                                        "text": "Wolfsspitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-384",
                                                                        "text": "Yorkshire Terrier",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-385",
                                                                        "text": "Zwergpinscher",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-386",
                                                                        "text": "Zwergpudel",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-387",
                                                                        "text": "Zwergschnauzer",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }, {
                                                                        "value": "dog-rasse-388",
                                                                        "text": "Zwergspitz",
                                                                        "additional": "Hund",
                                                                        "selected": false
                                                                    }];
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
                                            <div class="frage">Geshlecht<span>*</span></div>
                                            <div class="antwort">

                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="weiblich" value="weiblich" name="geschlecht"  required>
                                                    <div class="checkbox_bezeichnung">Weiblich</div>
                                                    <div class="warning-message">*Pflichtangaben</div>
                                                </div>

                                                <div class="wizard_wrapper">
                                                    <input type="radio" data-text="männlich" value="männlich" name="geschlecht" required>
                                                    <div class="checkbox_bezeichnung">Männlich</div>
                                                </div>


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
                                            <div class="frage">Kastriert</div>

                                            <div class="wizard_wrapper">
                                                <input type="radio" data-text="ja" value="67" name="kastriert" >
                                                <div class="checkbox_bezeichnung">Ja</div>
                                            </div>

                                            <div class="wizard_wrapper">
                                                <input type="radio" data-text="nein" value="68" name="kastriert">
                                                <div class="checkbox_bezeichnung">Nein</div>
                                            </div>



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
                                            <div class="frage  ">Geburtstag<span>*</span></div>
                                            <div class="antwort">

                                                <select name="geburtstag" class="ws_wiz_question_geburtstag" required>
                                                    <option value="">Tag</option>

                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8" >8</option>
                                                    <option value="9" >9</option>
                                                    <option value="10" >10</option>
                                                    <option value="11" >11</option>
                                                    <option value="12" >12</option>
                                                    <option value="13" >13</option>
                                                    <option value="14" >14</option>
                                                    <option value="15" >15</option>
                                                    <option value="16" >16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                </select>



                                                <select name="geburtsmonat" class="ws_wiz_question_geburtsmonat" required>
                                                    <option value=""selected>Monat</option>

                                                    <option value="01"  >Januar</option>
                                                    <option value="02"  >Februar</option>
                                                    <option value="03"  >März</option>
                                                    <option value="04"  >April</option>
                                                    <option value="05"  >Mai</option>
                                                    <option value="06"  >Juni</option>
                                                    <option value="07"  >Juli</option>
                                                    <option value="08"  >August</option>
                                                    <option value="09"  >September</option>
                                                    <option value="10"  >Oktober</option>
                                                    <option value="11"  >November</option>
                                                    <option value="12"  >Dezember</option>
                                                </select>



                                                <select name="geburtsjahr" class="ws_wiz_question_geburtsjahr  " required>
                                                    <option value="">Jahr</option>

                                                    <option value="2017"  >2017</option>
                                                    <option value="2016"  >2016</option>
                                                    <option value="2015"  >2015</option>
                                                    <option value="2014"  >2014</option>
                                                    <option value="2013"  >2013</option>
                                                    <option value="2012"  >2012</option>
                                                    <option value="2011"  >2011</option>
                                                    <option value="2010"  >2010</option>
                                                    <option value="2009"  >2009</option>
                                                    <option value="2008"  >2008</option>
                                                    <option value="2007"  >2007</option>
                                                    <option value="2006"  >2006</option>
                                                    <option value="2005"  >2005</option>
                                                    <option value="2004"  >2004</option>
                                                    <option value="2003"  >2003</option>
                                                    <option value="2002"  >2002</option>
                                                    <option value="2001"  >2001</option>
                                                    <option value="2000"  >2000</option>
                                                    <option value="1999"  >1999</option>
                                                    <option value="1998"  >1998</option>
                                                    <option value="1997"  >1997</option>
                                                </select>
                                                <div class="warning-message">*Pflichtangaben</div>


                                            </div>
                                            <div class="clear"></div>

                                        </div>
                                    </div>



                                    <!-- SEITE 2 -->
                                    <div class="questions_wrapper" id="step-2" style="display: none">
                                        <div class="question_wrapper gewicht col-xs-6 col-xs-offset-6">
                                            <div class="frage" style="width: auto"><strong>Gewicht<span>*</span></strong></div>
                                            <div class="antwort">
                                                <input autocomplete="false" type="text" id="input_gewicht" value="" name="ws_wiz_question_gewicht" required><span>kg</span>
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

                                                }

                                                $("#input_gewicht_hidden").val(setX);
                                            };
                                            $("#input_gewicht").on("keyup", calcAnimalWeight);
                                            calcAnimalWeight();
                                        </script>

                                        <div class="question_wrapper gewichtsgrad ">
                                            <div class="col-xs-6">
                                                <div class="img-wrapper">
                                                    <img src="/catalog/view/theme/default/images/web/futterassistent/seite2/hund/w2.gif" alt="" class="js-dog-weight dog-weight" >
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
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/w0.gif"
                                                        },
                                                        {
                                                            "weightType": "leicht untergewichtig",
                                                            "text": "Rippen leicht tastbar, ohne Fettabdeckung, Lendenwirbel und Beckenknochen sichtbar, von oben betrachtet sehr deutliche Taille, von der Seite gut sichtbare Anhebung der Bauchlinie vor dem Becken.",
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/w1.gif"
                                                        },
                                                        {
                                                            "weightType": "normal",
                                                            "text": "Rippen tastbar mit geringer Fettabdeckung, von oben betrachtet Taille erkennbar, von der Seite sichtbare Anhebung der Bauchlinie vor dem Becken.",
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/w2.gif"
                                                        },
                                                        {
                                                            "weightType": "leicht übergewichtig",
                                                            "text": "Rippen nur schwer unter Fettauflage zu fühlen, erkennbare Fettdepots im Lendenbereich und am Schwanzansatz, Taille nur schwer erkennbar.",
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/w3.gif"
                                                        },
                                                        {
                                                            "weightType": "stark übergewichtig",
                                                            "text": "Massive Fettablagerungen an Brustkorb, Wirbelsäule, Hals  und Schwanzansatz, deutliche Umfangsvermehrung des Bauches.",
                                                            "imgSrc": "/catalog/view/theme/default/images//web/futterassistent/seite2/hund/w4.gif"
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


                                    <!-- SEITE 4 -->

                                    <div class="questions_wrapper" id="step-4" style="display: none;">

                                        <div class="question_wrapper erkrankung trocken_nassfutter">
                                            <div class="antwort">

                                                <ul class="list-inline">
                                                    <li class="fry-food-wrapper">
                                                        <div class="text-center frage">Trockenfutter</div>
                                                        <input type="radio" style="display: none" data-wig-text="Trockenfutter" data-wig="trocken_nassfutter_Trockenfutter" value="" name="ws_wiz_question_trocken_nassfutter" id="trocken_nassfutter_Trockenfutter">

                                                        <!-- children input -->
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

                                    </div> <!-- /#step-4 -->

                                    <!-- SEITE 5 -->

                                    <div class="questions_wrapper" id="step-5" style="display: none">

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
                                                            <input type="checkbox" data-wig-text="Obst und Gemüse Sorten Beispiele " data-wig="unvertraeglichkeit_Sorten_Beispiele" data-text="Obst und Gemüse Sorten Beispiele" value="14" title="Obst und Gemüse Sorten Beispiele" name="ws_wiz_question_unvertraeglichkeit" >
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
                                                            <input type="checkbox" data-wig-text="Fisch" data-wig="unvertraeglichkeit_Fisch" data-text="Fisch" value="25" title="Fisch" name="ws_wiz_question_unvertraeglichkeit" >
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

                                    </div> <!-- /#step-5 -->
                                    <!-- SEITE 6 -->

                                    <div class="questions_wrapper" id="step-6" style="display: none">

                                        <div class="question_wrapper erkrankung">
                                            <div class="antwort">

                                                <input type="checkbox" data-wig-text="Gelenke" data-wig="erkrankung_Gelenke" data-text="Gelenke" value="40" title="Gelenke" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Knochen" data-wig="erkrankung_Knocken" data-text="Knochen" value="41" title="Knochen" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Sehnen & Bänder" data-wig="erkrankung_Augen" data-text="SehnenBänder" value="42" title="SehnenBänder" name="ws_wiz_question_erkrankung">

                                                <input type="checkbox" data-wig-text="Haut & Fell" data-wig="erkrankung_Haut" data-text="HautFell" value="43" title="HautFell" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Ohrenprobleme" data-wig="erkrankung_Ohren" data-text="Ohrenprobleme" value="44" title="Ohrenprobleme" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Immunsystem" data-wig="erkrankung_Immunsystem" data-text="Immunsystem" value="45" title="Immunsystem" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Zecken & Parasiten " data-wig="erkrankung_Parasiten" data-text="ZeckenParasiten" value="46" title="ZeckenParasiten" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Schnelle Müdigkeit" data-wig="erkrankung_Mudigkeit" data-text="SchnelleMüdigkeit" value="47" title="SchnelleMüdigkeit" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Untergewicht " data-wig="erkrankung_Uebergewicht" data-text="Untergewicht" value="48" title="Untergewicht " name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Nach Operationen oder Erkrankungen " data-wig="erkrankung_Regeneration" data-text="Nach Operationen oder Erkrankungen" value="49" title="NachOperationenErkrankungen" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Nach Antibiotikagabe" data-wig="erkrankung_Diabetes" data-text="Nach Antibiotikagabe" value="50" title="NachAntibiotikagabe" name="ws_wiz_question_erkrankung">

                                                <input type="checkbox" data-wig-text="Stress" data-wig="erkrankung_Stress" data-text="Stress" value="51" title="Stress" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Hohe körperlicher Belastung " data-wig="erkrankung_Tumor" data-text="Hohe körperlicher Belastung" value="52" title="HoheKorperlicherBelastung" name="ws_wiz_question_erkrankung" >

                                                <input type="checkbox" data-wig-text="Magen- und Darmtrakt" data-wig="erkrankung_Magen" data-text="MagenDarm" value="53" title="MagenDarm" name="ws_wiz_question_erkrankung" >


                                                <div class="clear"></div>
                                                <script type="text/javascript">
                                                    $("input[name=ws_wiz_question_erkrankung]").wizard_img_options();
                                                </script>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                    </div> <!-- /#step-6 -->
									
                                    <!-- SEITE 5 -->
                                    <div class="pagination-box">

                                        <div class="schritte">
                                            <ul class="list-inline">
                                                <li><a href="#step-1" class="active">1</a></li>
                                                <li><a href="#step-2" class="clickable">2</a></li>
                                                <li><a href="#step-3" class="disable">3</a></li>
                                                <li><a href="#step-4" class="disable">4</a></li>
                                                <li><a href="#step-5" class="disable">5</a></li>
                                                <li><a href="#step-6" class="disable">6</a></li>
                                            </ul>
                                        </div>
                                        <p class="js-btn_back" style="display: none;"><a href="" class="js-btn-back">zurück</a></p>
                                        <div class="btn_next js-btn-next-wrapper"><?/*<input type="submit" value="weiter">*/ ?> <a href="#step-2" class="js-btn-next">weiter</a></div>
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

                                                //show-hide next button and button Submit
                                                if(idOfNextA == "#step-7") {
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


                                            if( prevNumber == 4) {
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
                                            if (nextNumber > 6) {
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
                                            {
                                                step: "#step-4",
                                                header: "Bevorzugt <span class='dog-name'></span> eher Trocken- oder Nassfutter",
                                                inputs: [
                                                    {
                                                        name: "Trocken- oder Nassfutter:",
                                                        field: "ws_wiz_question_trocken_nassfutter"
                                                    },
                                                    {
                                                        name: "Trockenfutter:",
                                                        field: "ws_wiz_question_trockenfutter"
                                                    }
                                                ]
                                            },
                                            {
                                                step: "#step-5",
                                                header: "Das Hundefutter sollte für <span class='dog-name'></span> folgendes <strong><u>nicht</u></strong> enthalten",
                                                inputs: [
                                                    {
                                                        name: "Hundefutter:",
                                                        field: "ws_wiz_question_unvertraeglichkeit"
                                                    }
                                                ]
                                            },
                                            {
                                                step: "#step-6",
                                                header: "Mein Hund benötigt Unterstützung bei folgenden Punkten:",
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
	} else if(diff[0]<=5) {
		filter.push(61); //Jünger Hund (über 12 Monate)		
	} else { 
		filter.push(62); //Älter Hund
	}

    $('input[name^=\'kastriert\']:checked').each(function(element) {
        filter.push(this.value);
    });

	<!-- #step2 -->
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
	$('input[name^=\'ws_wiz_question_erkrankung\']:checked').each(function(element) {
		filter.push(this.value);
	});	

	location = '<?php echo $action; ?>&filter=' + filter.join(',') + '&dog_name=' + $('input[name=\'name\']').val();
});

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

<?php echo $footer; ?>

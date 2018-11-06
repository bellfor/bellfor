<?php echo $header; ?>
    <div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
            <?php
            if ($breadcrumb['text'] !== '<i class="fa fa-home"></i>') {
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
        <div class="col-xs-12">
            <div class="main-container">
                <div class="row">


                    <div class="col-md-9 col-md-push-3 col-xs-12 right-container">
                        <div class="row">
                            <div id="carousel-generic" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <?php echo $content_top; ?>

                            </div>
                            <h1><?php echo $heading_title; ?></h1>

                            <?php if ($products) { ?>
                            <div class="panel">
                                <form action="#" method="get">
                                    <div class="panel-sort sort-first-sea">
                                        <div class="input select">
                                            <label><?php echo $text_sort; ?> </label>
                                            <select id="input-sort" class="input-select"
                                                    onchange="location = this.value;">
                                                <?php $sorts1 = $sorts;
                                                foreach ($sorts as $sorts) { ?>
                                                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                                        <option value="<?php echo $sorts['href']; ?>"
                                                                selected="selected"><?php echo $sorts['text']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="panel-itemcount">
                                        <div class="input select">
                                            <label><?php echo $text_limit; ?> </label>
                                            <select id="input-limit" class="input-select"
                                                    onchange="location = this.value;">
                                                <?php $limits1 = $limits;
                                                foreach ($limits as $limits) { ?>
                                                    <?php if ($limits['value'] == $limit) { ?>
                                                        <option value="<?php echo $limits['href']; ?>"
                                                                selected="selected"><?php echo $limits['text']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="panel-viewmode">

                                        <button type="button" id="list-view" class="btn btn-default"
                                                data-toggle="tooltip" title="<?php echo $button_list; ?>"><img
                                                    class="png-fix" src="image/elements/panel/view_mode_default_on.png"
                                                    alt=""></button>&nbsp;&nbsp;
                                        <button type="button" id="grid-view" class="btn btn-default"
                                                data-toggle="tooltip" title="<?php echo $button_grid; ?>"><img
                                                    class="png-fix" src="image/elements/panel/view_mode_tiled_off.png"
                                                    alt=""></button>

                                    </div>

                                </form>
                                <div class="panel-pagination">
                                    <?php echo $results; ?>
                                </div>
                            </div>

                            <div class="container-Empfehlungen">


                                <div class="row">
                                    <?php foreach ($products as $product) { ?>

                                        <section class="row article-list-item">
                                            <div class="product-list-image col-md-3 col-sm-3">
                                                <a href="<?php echo $product['href']; ?>"><img
                                                            src="<?php echo $product['thumb']; ?>"
                                                            alt="<?php echo $product['name']; ?>"
                                                            title="<?php echo $product['name']; ?>"></a>
                                            </div>
                                            <div class="col-md-9 col-sm-9 product-container">
                                                <div class="article-list-item-main">
                                                    <div class="title">
                                                        <a href="<?php echo $product['href']; ?>"
                                                           title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
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
                                                            <span class="small"> <?php if ($product['currency_position'] == 'l') {
                                                                    echo $product['currency'];
                                                                }
                                                                echo round($product['price_full'] / $product['weight'] / 10, 2);
                                                                if ($product['currency_position'] == 'r') {
                                                                    echo $product['currency'];
                                                                } ?> pro 100 g<br></span></a>
                                                        <?php } else { ?>
                                                            <span class="small"> <?php if ($product['currency_position'] == 'l') {
                                                                    echo $product['currency'];
                                                                }
                                                                echo round($product['price_full'] / $product['weight'], 2);
                                                                if ($product['currency_position'] == 'r') {
                                                                    echo $product['currency'];
                                                                } ?> pro kg<br></span></a>
                                                        <?php } ?>
                                                        <?php } else { ?>
                                                            <span class="price-new"><?php echo $product['special']; ?></span>
                                                            <span class="price-old"><?php echo $product['price']; ?></span>
                                                        <?php } ?>
                                                        </a>
                                                        <?php if ($product['tax']) { ?>
                                                            <span class="small tax"><?php echo $text_tax; ?> <?php echo $product['tax_rate'][0]['name']; ?>
                                                                <a class="" href="#">Versand</a></span>


                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                            <div class="article-list-item-bottom">
                                                <div class="article-list-item-delivery">
                                                    <p>
                                                        <span class="label-list">Versandgewicht je Stück: </span> <?php echo round($product['weight'], 1); ?>
                                                        kg
                                                    </p>
                                                </div>
                                                <div class="article-list-item-button payment_buttons">
        <span class="quantity_container">
          <input type="text" name="products_qty" id="qty_<?php echo $product['product_id']; ?>"
                 class="article-count-input" value="<?php echo $product['minimum']; ?>">
        </span>
                                                    <button onclick="cart.add('<?php echo $product['product_id']; ?>', $('#qty_<?php echo $product['product_id']; ?>').val());"
                                                            class="button_green"><?php echo $button_cart; ?></button>

                                                </div>
                                            </div>
                                        </section>


                                    <?php } ?>

                                </div>
                            </div>

                        <div class="panel">
                            <form action="#" method="get">
                                <div class="panel-sort sort-niz sort-sea">
                                    <div class="input select">
                                        <label><?php echo $text_sort; ?> </label>
                                        <select id="input-sort" class="input-select" onchange="location = this.value;">
                                            <?php foreach ($sorts1 as $sorts) { ?>
                                                <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                                                    <option value="<?php echo $sorts['href']; ?>"
                                                            selected="selected"><?php echo $sorts['text']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-itemcount">
                                    <div class="input select">
                                        <label><?php echo $text_limit; ?> </label>
                                        <select id="input-limit" class="input-select" onchange="location = this.value;">
                                            <?php foreach ($limits1 as $limits) { ?>
                                                <?php if ($limits['value'] == $limit) { ?>
                                                    <option value="<?php echo $limits['href']; ?>"
                                                            selected="selected"><?php echo $limits['text']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="panel-viewmode">

                                    <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip"
                                            title="<?php echo $button_list; ?>"><img class="png-fix"
                                                                                     src="image/elements/panel/view_mode_default_on.png"
                                                                                     alt=""></button>&nbsp;&nbsp;
                                    <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip"
                                            title="<?php echo $button_grid; ?>"><img class="png-fix"
                                                                                     src="image/elements/panel/view_mode_tiled_off.png"
                                                                                     alt=""></button>

                                </div>

                            </form>
                            <div class="panel-pagination">
                                <?php echo $results; ?>
                            </div>
                        </div>
                        <div class="panel-pagination-info">
                            <?php echo $pagination; ?>
                        </div>
                        <?php } else { ?>
                            <p><?php echo $text_empty; ?></p>
                        <?php } ?>
                        </div>
                    </div><!-- end right container -->


                    <?php echo $column_right; ?>


                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"><!--
        $('#button-search').bind('click', function () {
            url = 'index.php?route=product/search';

            var search = $('#content input[name=\'search\']').prop('value');

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }

            var category_id = $('#content select[name=\'category_id\']').prop('value');

            if (category_id > 0) {
                url += '&category_id=' + encodeURIComponent(category_id);
            }

            var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

            if (sub_category) {
                url += '&sub_category=true';
            }

            var filter_description = $('#content input[name=\'description\']:checked').prop('value');

            if (filter_description) {
                url += '&description=true';
            }

            location = url;
        });

        $('#content input[name=\'search\']').bind('keydown', function (e) {
            if (e.keyCode == 13) {
                $('#button-search').trigger('click');
            }
        });

        $('select[name=\'category_id\']').on('change', function () {
            if (this.value == '0') {
                $('input[name=\'sub_category\']').prop('disabled', true);
            } else {
                $('input[name=\'sub_category\']').prop('disabled', false);
            }
        });

        $('select[name=\'category_id\']').trigger('change');
        --></script>
<?php echo $footer; ?>
<?php echo $header; ?>
<style>
    .text-vision {
        height: 400px;
        overflow: hidden;
    }
</style>
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
                        <main class="main-text-container" id="content">
                            <h1><?php echo $heading_title; ?></h1>
                            <?php if ($description) { //MAR-93 fixed by oppo webiprog.com  29.11.2017 ?>
                                <div class="main-description-oppo">
                                    <div id="text-vision"
                                         class="<?php echo str_word_count($description, 0) > 200 ? 'text-vision' : ''; ?> hidden-xs">
                                        <?php echo $description; ?>
                                    </div>
                                    <?php if (str_word_count($description, 0) > 200) { ?>
                                        <div class="more more-read-description hidden-xs">
                                            <a href="#">>><?php echo $text_read_more; ?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="clr clearfix"></div>
                            <?php } ?>
                        </main>
                        <div class="panel">
                            <form action="#" method="get">
                                <div class="panel-sort sort-first-cat">
                                    <div class="input select">
                                        <label><?php echo $text_sort; ?> </label>
                                        <select id="input-sort" class="input-select" onchange="location = this.value;">
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
                                        <select id="input-limit" class="input-select" onchange="location = this.value;">
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
                        <div class="container-Empfehlungen">
                            <div class="row">
                                <?php $counter = 1;
                                $dl_products = '';
                                ?>
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
                                                                <span class="small">
                                                                    <?php if ($product['currency_position'] == 'l') {
                                                                        echo $product['currency'];
                                                                    }
                                                                    echo round($product['price_full'] / $product['weight'] / 10, 2);
                                                                    if ($product['currency_position'] == 'r') {
                                                                        echo $product['currency'];
                                                                    } ?>
                                                                    pro 100 g<br>
                                                                </span>
                                                    </a>
                                                            <?php } else { ?>
                                                            <span class="small">
                                                                <?php if ($product['currency_position'] == 'l') {
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
                                                            <span class="small"> <?php echo $product['price_weight_special']; ?> <?php echo $product['currency']; ?> <?php echo $text_pro_kg ; ?><br /></span>
                                                        <?php } ?>
                                                    </a>
                                                    <?php if ($product['tax_rate']) { ?>
                                                        <span class="small font-size-tax"><?php echo $text_tax; ?> <?php echo $product['tax_rate'][0]['name']; ?>
                                                            <a class="font-size-shipping" href="<?php echo $link_versand; ?>" target="_blank">Versand</a>
                                                        </span>
                                                    <?php } else { ?>
                                                        <span><a class="font-size-shipping" href="<?php echo $link_versand; ?>" target="_blank">Versand</a></span>
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
                                    <?php
                                    $dl_products .= '     {
       \'name\': \'' . $product['name'] . '\',       // Name or ID is required.
       \'id\': \'' . $product['model'] . '\',
       \'price\': \'' . $product['price_full'] . '\',
       \'category\': \'' . $product['category'] . '\',
       \'list\': \'Category page\',
       \'position\': ' . $counter . '
     },';

                                    $counter++;
                                    ?>

                                <?php } ?>

                            </div>
                            <?php if ($description) {//MAR-93 fixed by oppo webiprog.com  29.11.2017 ?>
                                <div class="clr clearfix"><br/></div>
                                <div class="col-xs-12">
                                    <div class="mobile hidden-sm hidden-md hidden-lg">
                                        <?php echo $description; ?>
                                    </div>
                                </div>
                                <div class="clr clearfix"></div>
                            <?php } ?>

                        </div><!-- end container-Empfehlungen -->
                    </div>

                    <div class="panel">
                        <form action="#" method="get">
                            <div class="panel-sort sort-niz sort-cat">
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
                    <main class="main-text-container" id="content">
                        <h1><?php echo $heading_title; ?></h1>
                        <?php if ($description) { //MAR-93 fixed by oppo webiprog.com  29.11.2017 ?>
                            <div class="main-description-oppo">
                                <div id="text-vision"
                                     class="<?php echo str_word_count($description, 0) > 200 ? 'text-vision' : ''; ?> hidden-xs">
                                    <?php echo $description; ?>
                                </div>
                                <?php if (str_word_count($description, 0) > 200) { ?>
                                    <div class="more more-read-description hidden-xs">
                                        <a href="#">>><?php echo $text_read_more; ?></a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clr clearfix"></div>
                        <?php } ?>
                    </main>
                </div><!-- end right container -->
                <?php echo $column_right; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"><!--

    dataLayer.push({
        'ecommerce': {
            'currencyCode': 'EUR',                       // Local currency is optional.
            'impressions': [
                <?php echo $dl_products; ?>
            ]
        }
    });


    //--></script>
<script>
    $('.more-read-description a').click(function (event) {
        event.preventDefault();
        var opened = $(this).data('opened');
        var $text = $('#text-vision');
        if (opened) {
            $text.animate({height: '400px'}, 400);
            $(this).data('opened', '');
            $(this).text('>><?php echo $text_read_more;?>');
            return false;
        }
        $(this).text('<<<?php echo $text_hide;?>');
        $text.css('height', '100%');

        var hg = $text.height();
        $text.css('height', '400px');
        $text.animate({height: hg + 'px'}, 400);
        $(this).data('opened', '1');
        return false;
    });
</script>

<?php echo $footer; ?>
<?php
/*
// expirement by oppo webiprog.com  29.11.2017
<script type="text/javascript"><!--
jQuery( document ).ready(function($) {
    $(".main-description-oppo iframe").wrap('<div class="responsive-video embed-responsive embed-responsive-16by9"/>');
    $(".main-description-oppo iframe").addClass('embed-responsive-item');
});
//--></script>
<style type="text/css"><!--
.responsive-video {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 60px; overflow: hidden;
}

.responsive-video iframe,
.responsive-video object,
.responsive-video embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
--></style>
*/; ?>

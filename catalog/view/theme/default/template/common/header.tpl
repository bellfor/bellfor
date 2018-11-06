<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <base href="<?php echo $base; ?>" />
    <?php if ($description) { ?>
        <meta name="description" content="<?php echo $description; ?>" />
    <?php } ?>
    <?php if ($keywords) { ?>
        <meta name="keywords" content= "<?php echo $keywords; ?>" />
    <?php } ?>
    <!-- jquery-2.1.1.min.js -->
    <!--    <script type="text/javascript">-->
    <!--        --><?php //echo file_get_contents("catalog/view/javascript/jquery/jquery-2.1.1.min.js");?>
    <!--    </script>-->
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js?v1" type="text/javascript"></script>
    <!-- query_func_with_documentation-v1.1.min.js -->
    <!--    <script type="text/javascript">-->
    <!--        --><?php //echo file_get_contents("catalog/view/javascript/query_func_with_documentation-v1.1.min.js");?>
    <!--    </script>-->
    <script src="catalog/view/javascript/query_func_with_documentation-v1.1.min.js?v1" type="text/javascript"></script>

    <!-- bootstrap.min.css -->
    <!-- <link rel="stylesheet" type="text/css" href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" /> -->
    <!--    <style>-->
    <!--        --><?php //echo file_get_contents("catalog/view/javascript/bootstrap/css/bootstrap.min.css");?>
    <!--    </style>-->
    <link rel="stylesheet" href="catalog/view/javascript/bootstrap/css/bootstrap.min.css?v1" type="text/css" />
    <!-- style.min.css -->
    <!--    <link rel="stylesheet" href="catalog/view/theme/default/stylesheet/style.min.css?--><?php //echo time();?><!--" type="text/css" />-->
    <link rel="stylesheet" href="catalog/view/theme/default/stylesheet/style.min.css?v1" type="text/css" />
    <!--    <style type="text/css">-->
    <!--        --><?php //echo file_get_contents("catalog/view/theme/default/stylesheet/style.min.css");?>
    <!--    </style>-->
    <!-- responsive.min.css -->
    <!--    <style type="text/css">-->
    <!--        --><?php //echo file_get_contents("catalog/view/theme/default/stylesheet/responsive.min.css");?>
    <!--    </style>-->
    <link rel="stylesheet" href="catalog/view/theme/default/stylesheet/responsive.min.css?v1" type="text/css" />

    <?php foreach ($styles as $style) { ?>
        <!-- <?php echo $style['href']."\n";?> -->
        <!--        <style type="text/css">-->
        <!--            --><?php //echo file_get_contents($style['href']);?>
        <!--        </style>-->
        <link rel="stylesheet" href="<?php echo $style['href'];?>?v1" type="text/css" />
    <?php } ?>

    <!-- common.min.js -->
    <!--    <script type="text/javascript">-->
    <!--        --><?php //echo file_get_contents("catalog/view/javascript/common.min.js");?>
    <!--    </script>-->
    <script src="catalog/view/javascript/common.min.js?v1" type="text/javascript"></script>
    <?php foreach ($links as $link) { ?>
        <!-- <?php echo $link['rel']."\n";?> -->
        <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>
    <?php foreach ($scripts as $script) { ?>
        <!-- <?php echo trim($script)."\n";?> -->
        <!--        <script type="text/javascript">-->
        <!--            --><?php //echo file_get_contents($script);?>
        <!--            -->
        <!--        </script>-->
        <script src="<?php echo $script;?>?v1" type="text/javascript"></script>
    <?php } ?>

    <meta name="theme-color" content="#000">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#000">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">
    <!-- Custom Browsers Color End -->

    <?php foreach ($analytics as $analytic) { ?>
        <?php echo $analytic; ?>
    <?php } ?>
</head>
<body class="<?php echo $class; ?>">
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.8&appId=263177127193531";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<?php
$url_bellfor = $_SERVER["HTTP_HOST"];
//$url_bellfor = 'localhost';
$sub = str_replace('www.', '', $url_bellfor);
$sub = str_replace(array('http://','https://'), '', $sub);
$sub =  strstr($sub, '.', true);

$stunl = strpos($base, 'nl.bellfor.info', 7);

?>
<header class="header">
    <div class="container">

        <div class="row">
            <div class="col-md-12" >
                <!-- cart -->
                <div class="border-cont visible-xs" style="width: 220px; position: absolute;">
                    <?php echo $cart; ?>
                </div>
                <!-- end cart -->
                <div class="icon-menu-wrap">
                    <div href="#" class="toggle-mnu hidden-lg hidden-md hidden-sm"><span></span></div>
                </div>
                <div class="menu top-menu">
                    <?php if ($categories) { ?>
                        <ul class="custom-hidden">
                            <?php foreach ($categories as $category) { ?>
                                <?php if ($category['children']) { ?>
                                    <li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
                                        <div class="dropdown-menu">
                                            <div class="dropdown-inner">
                                                <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
                                                    <ul class="list-unstyled">
                                                        <?php foreach ($children as $child) { ?>
                                                            <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </div>
                                            <a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
                                    </li>
                                <?php } else { ?>
                                    <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <ul class="grey-menu-right">
                        <?php
                        //fixed by oppo webiprog.com   MAR-164 move logo 14.12.2017
                        if($sub == 'bellfor' || !$sub ) { ?>
                            <style type="text/css"><!--
                                .header .trusted-shop {
                                    display: block !important;
                                    background: url(https://widgets.trustedshops.com/images/trustmark_32x32.png) no-repeat !important;
                                    background-color: transparent !important; width: 32px !important; height: 32px !important; display: block; background-size: 100%; text-decoration: none; left: -25px; top: -3px; outline: 0; text-align: center; position: absolute;
                                }
                                --></style>
                            <li class="hidden-xs"  style="position: relative;width: 45px !importanlot;"><a title="Trusted Shops" class="trusted-shop" href="https://www.trustedshops.de/bewertung/info_XFAB332EF7D0070F4F0E8F4B2561D47EA.html" rel="nofollow"></a></li>
                        <?php } ; ?>
                        <li><a href="<?php echo str_replace('index.php?route=common/home', '', $home); ?>" ><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                        <li><a href="<?php echo $contact; ?>" ><?php echo $text_contact; ?></a></li>
                        <?php if (!$logged) { ?>
                            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $text_login_to_account; ?> <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></a>
                                <div class="customer_login_inside dropdown-menu">
                                    <form action="<?php echo $login; ?>" method="post">
                                        <label><?php echo $text_email; ?></label><br>
                                        <input type="text" name="email" value="" class="input-text" autocomplete="off"><br>
                                        <label><?php echo $text_password; ?></label><br>
                                        <input type="password" name="password" value="" class="input-text" autocomplete="off"><br>
                                        <div class="submit-container"><button type="submit" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $text_login; ?></span></span></button></div>
                                        <div class="customer_login_links">
                                            <a href="<?php echo $register; ?>">
                                                <?php echo $text_register; ?>
                                            </a><br>
                                            <a href="index.php?route=account/forgotten">
                                                <?php echo $text_forgot_password; ?>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li><a href="<?php echo $wishlist; ?>" ><?php echo $text_wishlist; ?></a></li>
                            <li><a href="<?php echo $shopping_cart; ?>" ><?php echo $text_shopping_cart; ?></a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo $wishlist; ?>" ><?php echo $text_wishlist; ?></a></li>
                            <li><a href="<?php echo $shopping_cart; ?>" ><?php echo $text_shopping_cart; ?></a></li>
                            <li><a href="index.php?route=account/edit"><?php echo $text_account; ?></a></li>
                            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
                        <?php } ?>
                    </ul>
                </div><!--END wrap_ -->
            </div>
        </div>
        <div class="row">

            <?php
            //fixed by oppo webiprog.com  23.11.2017
            //	ADD flagswitchermultistore
            if(!empty($all_stores) && is_array($all_stores) && count($all_stores)) {?>
                <div class="col-md-12 header-img-class text-right">
                    <ul id="store-switcher" class="pull-right switcher nav nav-pills"  style="margin-top: 6px;">
                        <?php
                        foreach ($all_stores as $store) {
                            if($current_store != $store['store_name']) {
                                if($store_ssl) {
                                    $url=$store['store_ssl'];
                                }else {
                                    $url=$store['store_url'];
                                }
                            }else {
                                $url='javascript:void(0);';
                            }
                            ?>
                            <li class="pull-left text-right"><a title="<?php echo $store['store_name'] ?>" href="<?php echo $url ; ?>" ><img alt="<?php echo $store['country_name'] ?>" title="<?php echo $store['store_name'] ?>" border="0" src="image/flags/<?php echo $store['img_name'] ?>.png" /> <?php //echo $store['store_name'] ?></a>
                            </li>
                            <?php

                        }
                        ?>
                    </ul>
                    <div class="clr clearfix"></div>
                </div>
                <style type="text/css"><!--
                    #store-switcher>li>a {
                        display: block;
                        padding: 6px 9px;
                        color: #7e842e;
                        text-decoration: none;
                    }
                    #store-switcher>li>a:hover {
                        color: #808632;
                    }
                    --></style>

            <?php } ; ?>

            <div class="col-md-12 header-img-class text-center" >

                <div class="header_logo_phone">
                    <a href="<?php echo str_replace('index.php?route=common/home', '', $home); ?>"><img class="logo_header" src="catalog/view/theme/default/image/logo_header.png"></a>
                    <?php
                    /*
                    // MAR-121  Please delete the banner with hotline for the Subshops NL, UK, AT
                    //fixed by oppo webiprog.com  20.11.2017
                    Bellfor Austria	http://at.bellfor.info/
                    Bellfor Nederland	http://nl.bellfor.info/
                    Bellfor UK	http://uk.bellfor.info/

                    //fixed by oppo webiprog.com  12.07.2018 MAR-341
                    //�� ����� https://nl.bellfor.info/ ����� �������� ����� �������� (+31616140932)
                    //Gratis telefonisch advies en bestelling.

                    */
                    ; ?>
                    <div class="<?php echo $store_id == 3 ? 'col-lg-6 col-md-7 col-xs-12' : 'col-md-5 col-sm-7 col-xs-12'; ?> div-icon-phone">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px;">
                            <p class="phone-title"><?php echo $icon_phone_title; ?></p>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 icon-padding" style="margin-bottom: 10px;">
                                <div style="float: right;">
                                    <p class="phone"><?php echo $telephone; ?></p>
                                </div>
                                <div>
                                    <img class="phone-image" src="catalog/view/theme/default/image/phone.png">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 icon-padding">
                            <?php if ($store_id == 3) { ?>
                                <div class="col-md-3 col-sm-3 col-xs-3 icon-padding icon-mobile">
                                    <div class="icon-list">
                                        <img class="icon-image" src="/image/elements/icon/ideal_logo_header_blue.png">
                                    </div>
                                    <div class="icon-div-content icon-list">
                                        <p class="icon-title"><?php echo $icon_idealo; ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="<?php echo $store_id == 3 ? 'col-md-3 col-sm-3 col-xs-3' : 'col-md-4 col-sm-4 col-xs-4'; ?> icon-padding icon-mobile">
                                <div class="icon-list">
                                    <img class="icon-image" src="/image/elements/icon/shipping.png">
                                </div>
                                <div class="icon-div-content icon-list">
                                    <p class="icon-title"><?php echo $icon_shipping; ?></p>
                                    <p class="icon-info"><?php echo $config_shipping; ?></p>
                                </div>
                            </div>
                            <div class="<?php echo $store_id == 3 ? 'col-md-3 col-sm-3 col-xs-3' : 'col-md-4 col-sm-4 col-xs-4'; ?> icon-padding icon-mobile">
                                <div class="icon-list">
                                    <img class="icon-image" src="/image/elements/icon/delivery_time.png">
                                </div>
                                <div class="icon-div-content icon-list">
                                    <p class="icon-title"><?php echo $icon_delivery; ?></p>
                                    <p class="icon-info"><?php echo $config_fre_delivery; ?></p>
                                </div>
                            </div>
                            <div class="<?php echo $store_id == 3 ? 'col-md-3 col-sm-3 col-xs-3' : 'col-md-4 col-sm-4 col-xs-4'; ?> icon-padding icon-mobile">
                                <div class="icon-list">
                                    <img class="icon-image" src="/image/elements/icon/garantie_test.png">
                                </div>
                                <div class="icon-div-content icon-list">
                                    <p class="icon-title"><?php echo $icon_money_back; ?></p>
                                    <p class="icon-info"><?php echo $config_money_back; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</header>
<div class="main-section">
    <div class="container">

        <div class="row">
            <div class="col-xs-12" >
                <div class="source-container">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-6 text-center header-menu-mobile" >
                            <?php echo $search; ?>
                        </div>

                        <!-- youtube -->
                        <div class="col-md-2 col-sm-4 col-xs-6 header-menu-mobile">
                            <div class="bellfor-guide">
                                <i class="fa fa-youtube-play"></i>
                                <a data-target=".modal-1" data-toggle="modal" data-the-video="https://www.youtube.com/embed/iz8UcLL87gk?rel=0&amp;showinfo=0&amp;wmode=opaque&amp;html5=1"><?php echo $text_bellfor_video ; ?></a>
                            </div>
                        </div>
                        <!-- end youtube -->

                        <div class="col-md-3 col-sm-4 hidden-xs" style="float: right;">
                            <!-- cart -->
                            <div class="border-cont">
                                <?php echo $cart; ?>
                            </div>
                            <!-- end cart -->

                            <!-- Modal -->
                            <div aria-labelledby="modal-1-label" class="modal fade modal-media modal-video modal-slim modal-1" role="dialog" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header"><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">?</span></button></div>

                                        <div class="modal-body">
                                            <div class="embed-responsive embed-responsive-16by9"><iframe allowfullscreen="" frameborder="0" src="" width="100%"></iframe></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end Modal -->
                        </div>
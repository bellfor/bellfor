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

    <script type="text/javascript">
        <?php echo file_get_contents("catalog/view/javascript/jquery/jquery-2.1.1.min.js");?>
    </script>

    <script type="text/javascript">
      <?php echo file_get_contents("catalog/view/javascript/query_func_with_documentation-v1.1.min.js");?>
    </script>

	
    <style>
        <?php echo file_get_contents("catalog/view/javascript/bootstrap/css/bootstrap.min.css");?>
    </style>	

    <style type="text/css">
        <?php echo file_get_contents("catalog/view/theme/default/stylesheet/style.min.css");?>
    </style>


    <style type="text/css">
        <?php echo file_get_contents("catalog/view/theme/default/stylesheet/responsive.min.css");?>
    </style>

    <?php foreach ($styles as $style) { ?>
    <style type="text/css">
        <?php echo file_get_contents($style['href']);?>
    </style>
    <?php } ?>

    <script type="text/javascript">
        <?php echo file_get_contents("catalog/view/javascript/common.js");?>
    </script>
    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
    <?php } ?>
    <?php foreach ($scripts as $script) { ?>
    <script type="text/javascript">
        <?php echo file_get_contents($script);?>
    </script>
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

<header class="header">
    <div class="container">

        <div class="row">
            <div class="col-md-12" >
                <div class="icon-menu-wrap">
                    <div href="#" class="toggle-mnu hidden-lg hidden-md hidden-sm"><span></span></div>
                </div>
                <div class="menu top-menu">
                    <ul>
                        <li><a href="<?php echo str_replace('index.php?route=common/home', '', $home); ?>" ><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                        <li><a href="<?php echo $contact; ?>" ><?php echo $text_contact; ?></a></li>
                        <?php if (!$logged) { ?>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $text_login_to_account; ?> <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></a>
                            <div class="customer_login_inside dropdown-menu">
                                <form action="<?php echo $login; ?>" method="post">
                                    <label><?php echo $text_email; ?></label><br>
                                    <input type="text" name="email" value="" class="input-text"><br>
                                    <label><?php echo $text_password; ?></label><br>
                                    <input type="password" name="password" value="" class="input-text"><br>
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
            <div class="col-md-12 header-img-class text-center" >

                <div class="header_logo_phone">
                    <a href="<?php echo str_replace('index.php?route=common/home', '', $home); ?>"><img class="logo_header" src="catalog/view/theme/default/image/logo_header.png"></a>


                  <a href="tel:+49<?php echo str_replace(array(' ', '-'), '', $telephone); ?>">
                    <div class="header_phone">
                        <p class="head_text"><?php echo $text_free_consult; ?></p>
                        <div class="wrap_phone">
                            <img src="catalog/view/theme/default/image/phone.png">
                            <p><?php echo $telephone; ?></p>
                        </div>

                    </div>
                    </a>
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
                        <div class="col-md-3 col-sm-4 col-xs-12 text-center" >
                            <?php echo $search; ?>
                        </div>

                        <div class="col-md-3 col-md-push-6 col-sm-4 col-sm-push-4 col-xs-12" >
                            <div class="border-cont">
                                <?php echo $cart; ?>
                            </div>
                        </div>


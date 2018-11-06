<?php
// Heading
$_['heading_title']    = '<span style="color:#ff6600">Zooexperte Shop</span>';

// Text
$_['text_feed']        = 'Product Feeds';
$_['text_success']     = 'Success: You have modified Zooexperte feed!';
$_['text_edit']        = 'Edit Zooexperte feed';
$_['text_enabled_default']        = 'Enabled (default)';

// Entry
$_['entry_status']     = 'Status:';
$_['entry_file']     = 'Save to file only';
$_['entry_data_feed']  = 'Data Feed Url:';

$_['entry_zooexperte_category']     = 'Zooexperte Shop category';
$_['entry_zooexperte_attribute']  = 'Source of the color value';
$_['entry_zooexperte_option']  = 'Source of the size value - options (Apparel & Shoes only)';
$_['entry_zooexperte_attribute_product']  = 'Set colors in products (merchant tab)';
$_['entry_zooexperte_availability']     = 'Sold out items in product feed';
$_['entry_zooexperte_shipping_flat']  = 'Shipping rate';
$_['entry_zooexperte_base']  = 'Main categories';
$_['tab_taxonomy']  = 'Zooexperte Shop';
$_['entry_zooexperte_gender']     = 'Gender<br />(Apparel & Shoes only)';
$_['entry_zooexperte_age_group']     = 'Age group<br />(Apparel & Shoes only)';
$_['entry_zooexperte_color']     = 'Color (if not set via attributes)';
$_['entry_zooexperte_attribute_type']  = 'Source of the product type value';
$_['entry_zooexperte_attribute_product_type']  = 'Generated from categories (default)';
$_['entry_zooexperte_description']  = 'Use meta description:';
$_['entry_zooexperte_description_html']  = 'Remove html tags from the description:';
$_['entry_zooexperte_feed_id1']                = 'Product ID';
$_['entry_zooexperte_use_taxes']                = 'Include taxes in the price:';

// Help
$_['help_zooexperte_color']     = 'Set a color, or select an attribute in Extensions->Feeds->[Zooexperte]';
$_['help_zooexperte_attribute']  = "Select an attribute, or set the color in Catalog->Products[edit](Zooexperte Shop).";
$_['help_zooexperte_availability']     = 'Defines how mark zero stock products in the feed.';
$_['help_zooexperte_shipping_flat']  = 'Shipping flat rate for the product feed (merchant center shopping)';
$_['help_zooexperte_base']  = 'Selecting your category will reduce the amount of options available in the category setup Catalog->Categories[Edit](Data).';
$_['help_zooexperte_option']  = 'Select an option which contains the apparel size.';
$_['help_zooexperte_attribute_type']  = 'Category based product type or an attribute. If selected attribute is not set, category is used instead.';
$_['help_file']     = 'The feed is not displayed directly, but is saved in ../system/storage/download/feeds/';
$_['help_zooexperte_feed_id1']                = 'Product ID used on the remarketing tag (ecomm_prodid)';
$_['help_zooexperte_use_taxes']                = 'When enabled (default) prices will include taxes. In USA, Canada and India the prices will be always without taxes.';
$_['help_zooexperte_category']     = 'You can reduce the number of categories in the Zooexperte Shop feed settings.';
$_['help_data_feed']  = 'You can change the link parameters to get a feeds in different languages, currencies etc.:<br />Languages: &lang={language code}<br />Currencies: &curr={currency code}<br />Multistore: &store={store id number}<br />Skip products: &exclude_product_id={product ids separated by comma} Example: &exclude_product_id=42,30,47';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify Zooexperte feed!';
?>

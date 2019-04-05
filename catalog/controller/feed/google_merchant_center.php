<?php
class ControllerFeedGoogleMerchantCenter extends Controller
{
    public function index()
    {
        if ($this->config->get('google_merchant_center_status')) {
            //  Start TIMER
            $stimer = explode(' ', microtime());
            $stimer = $stimer[1] + $stimer[0];

            $this->load->model('catalog/category');
            $this->load->model('catalog/product');
            $this->load->model('feed/google_merchant_center');
            $this->load->model('tool/image');

            $lang="";
            $currency_code="";
            $store="";
            $isDefaultLang=true;
            $file_append="";
            $file_only=$this->config->get('google_merchant_center_file');
            $google_merchant_center_description=$this->config->get('google_merchant_center_description');
            $google_merchant_center_description_html=$this->config->get('google_merchant_center_description_html');
            $google_merchant_center_feed_id1=$this->config->get('google_merchant_center_feed_id1');
            $google_merchant_center_use_taxes=$this->config->get('google_merchant_center_use_taxes');
            $product_url="";
            if (isset($_GET['store'])) {
                $file_append.="_".$_GET['store'];
                $store=$_GET['store'];
            } else {
                $store=$this->config->get('config_store_id');
            }
            if (isset($_GET['lang'])) {
                $lang=$this->model_feed_google_merchant_center->getLangID($_GET['lang']);
                $file_append.="_".$_GET['lang'];

                if ($_GET['lang']!=$this->config->get('config_language')) {
                    $isDefaultLang=false;
                    $product_url.="&amp;language=".$_GET['lang'];
                }
            } else {
                $lang=$this->config->get('config_language_id');
            }
            if (isset($_GET['curr'])) {
                $currency_code=$_GET['curr'];
                $file_append.="_".$_GET['curr'];
                if ($_GET['curr']!=$this->config->get('config_currency')) {
                    $product_url.="&amp;currency=".$_GET['curr'];
                }
            } else {
                $currency_code = $this->config->get('config_currency');
            }
            $currency_value = $this->currency->getValue($currency_code);

            $black_product_id=[];
            if (isset($_GET['exclude_product_id'])) {
                $black_product_id = explode(",", $_GET['exclude_product_id']);
            }

            if ($file_only) {
                $filetitle='feeds/google_merchant_center'.$file_append.'.xml';
                $filename = DIR_DOWNLOAD.$filetitle;
                $dirname = dirname($filename);
                if (!is_dir($dirname)) {
                    mkdir($dirname, 0755, true);
                }
                file_put_contents($filename.'.tmp', "");
            }

            $output  = '<?xml version="1.0" encoding="UTF-8" ?>';
            $output .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">';
            $output .= '<channel>';
            $output .= '<title>' . $this->config->get('config_name') . '</title>';
            if ($isDefaultLang) {
                $meta_description = $this->config->get('config_meta_description');
                if (is_array($meta_description)) {
                    $output .= '<description>' . reset($meta_description) . '</description>';
                } else {
                    $output .= '<description>' . $meta_description . '</description>';
                }
            }
            $output .= '<link>' . HTTP_SERVER . '</link>';

            //$products = $this->model_feed_google_merchant_center->getProducts($lang,$store);
            $google_merchant_center_availability=$this->config->get('google_merchant_center_availability');
            $use_tax=true;
            if ($google_merchant_center_use_taxes==2) {
                $use_tax=false;
            }
            $tax_rate='';
            $tax_rateArray=$this->model_feed_google_merchant_center->getTax();
            $width = $this->config->get('config_image_popup_width');
            $height = $this->config->get('config_image_popup_height');
            if ($width<600 || $height<600) {
                $width=600;
                $height=600;
            }
            foreach ($tax_rateArray as $rate) {
                if ($rate['iso_code_2']=='US') { //only for US
                    $tax_rate.="<g:tax><g:country>".$rate['iso_code_2']."</g:country><g:rate>".$rate['rate']."</g:rate></g:tax>";
                    $use_tax=false;
                } elseif ($rate['iso_code_2']=='CA' || $rate['iso_code_2']=='IN') { //only USA,Canada and India
                    $use_tax=false;
                }
            }

            $attribute_id=$this->config->get('google_merchant_center_attribute');
            $attribute_id_type=$this->config->get('google_merchant_center_attribute_type');
            $shippingArray=$this->model_feed_google_merchant_center->getShipping();
            $shippingFlat=$this->config->get('google_merchant_center_shipping_flat');
            $shipping="";
            if ((float)$shippingFlat>=0 && $shippingFlat!='') {
                $shippingFlat = $this->currency->format((float)$shippingFlat, $currency_code, $currency_value, false);
                $shipping.="<g:shipping><g:price>".$shippingFlat. ' '.$currency_code."</g:price></g:shipping>";
            }
            $is_apparel=0;
            $apparel_option_id = $this->config->get('google_merchant_center_option');
            $limit=1000;
            $start=0;
            $data_limit = array(
                "start" => $start,
                "limit" => $limit,
            );
            $products = $this->model_feed_google_merchant_center->getProducts($lang, $store, $data_limit);
            while (count($products)>0) {
                foreach ($products as $product) {
                    if ($product['quantity']==0 && $google_merchant_center_availability=="skip products" || in_array($product['product_id'], $black_product_id)) {
                        continue;
                    }

                    //if ($product['description']) {
                    $item = '
<item>';
                    $title=$this->fixEncoding($product['name']);
                    $title=trim(htmlspecialchars(htmlspecialchars_decode($title, ENT_COMPAT), ENT_COMPAT, 'UTF-8'));
                    $item .= '<title>' . $title . '</title>';
                    $link=str_replace(" ", "%20", $this->url->link('product/product', 'product_id=' . $product['product_id']));
                    if (strpos($link, "index.php?") !== false) {
                        $link.=$product_url;
                    } elseif ($product_url!="") {
                        $link.="?".substr($product_url, 5);
                    }
                    $item .= '<link>' . $link . '</link>';

                    $product_details="";
                    if ($google_merchant_center_description) {
                        $product_details = $product['meta_description'];
                    } else {
                        $product_details = $product['description'];
                    }

                    if ($google_merchant_center_description_html) {
                        $product_details= str_replace("
", " ", str_replace("\t", " ", str_replace("\n", " ", str_replace("\r", " ", str_replace("\r\n", " ", htmlspecialchars($this->strip_html_tags(htmlspecialchars_decode($product_details, ENT_COMPAT)), ENT_COMPAT, 'UTF-8'))))));
                        while (strpos($product_details, "  ") !== false) {
                            $product_details=str_replace("  ", " ", $product_details);
                        }
                        $product_details=$this->fixEncoding($product_details);

                        while ($this->startsWith($product_details, "&amp;nbsp;") || $this->endsWith($product_details, "&amp;nbsp;") || $this->startsWith($product_details, " ") || $this->endsWith($product_details, " ")) {
                            $product_details = $this->clearDescription($product_details, "&amp;nbsp;");
                            $product_details = $this->clearDescription($product_details, " ");
                        }
                        $product_details=trim($product_details);
                    } else {
                        $product_details = htmlspecialchars(htmlspecialchars_decode($product_details, ENT_COMPAT), ENT_COMPAT, 'UTF-8');
                    }

                    $item .= '<description>' .  trim(htmlspecialchars(htmlspecialchars_decode(substr($product_details, 0, 5000), ENT_COMPAT), ENT_COMPAT, 'UTF-8')). '</description>';


                    $item .= '<g:condition>new</g:condition>';
                    if ($product['image']) {
                        $item .= '<g:image_link>' . str_replace(" ", "%20", htmlspecialchars($this->model_tool_image->resize($product['image'], $width, $height), ENT_COMPAT, 'UTF-8')) . '</g:image_link>';
                    } else {
                        $item .= '<g:image_link></g:image_link>';
                    }

                    $item .=$tax_rate;
                    $item .=$shipping;

                    $categories = $this->model_catalog_product->getCategories($product['product_id']);
                    $cat_string='';
                    $category_id='';

                    $counter=0;

                    $apparel_data = $this->model_feed_google_merchant_center->getProductExtra($product['product_id'], $attribute_id, $lang);

                    foreach ($categories as $category) {
                        $path = $this->getPath($category['category_id'], $lang, $store);
                        $count=1;
                        if ($path) {
                            $string = '';
                            foreach (explode('_', $path) as $path_id) {
                                $category_info = $this->model_feed_google_merchant_center->getCategory($path_id, $lang, $store);
                                $count++;
                                if ($category_info) {
                                    if (!$string) {
                                        $string = trim(htmlspecialchars(htmlspecialchars_decode($category_info['name'], ENT_COMPAT), ENT_COMPAT, 'UTF-8'));
                                    } else {
                                        $string .= ' &gt; ' . trim(htmlspecialchars(htmlspecialchars_decode($category_info['name'], ENT_COMPAT), ENT_COMPAT, 'UTF-8'));
                                    }
                                }
                            }


                            if  ($_GET['store'] = '1'){

                                if (!empty($apparel_data['product_type'])) {
                                    $string .= ', ' . $apparel_data['product_type'];
                                }

                                $this->load->model('extension/race');
                                $race_dogs = $this->model_extension_race->getRace();

                                foreach ($race_dogs as $race_dog){
                                    if (strlen($string) < 700){
                                        $string .= ', ' . $race_dog['race'];
                                    } else {
                                        break;
                                    }
                                }
                            }

                            $cat_string = '<g:product_type>' . $string . '</g:product_type>' . $cat_string;
                        }
                        if ($count>$counter) {
                            $counter=$count;
                            $category_id=$category['category_id'];
                        }
                    }
                    $category_id_google = $this->model_feed_google_merchant_center->getTaxonomy($category_id);
                    if (isset($category_id_google['taxonomy_id'])) {
                        $is_apparel = $this->model_feed_google_merchant_center->isApparel($category_id_google['taxonomy_id']);
                        $item .= '<g:google_product_category>' . $category_id_google['taxonomy_id'] .'</g:google_product_category>';
                    }

                    if ($is_apparel) {
                        $item .= '<g:item_group_id>' . $product['product_id'] . '</g:item_group_id>';
                        if ($google_merchant_center_feed_id1=='model') {
                            $item .= '<g:id>' . trim(htmlspecialchars(htmlspecialchars_decode(str_replace(',', '', $product['model']), ENT_COMPAT), ENT_COMPAT, 'UTF-8')) . '#$#SIZE#$#</g:id>';
                        } else {
                            $item .= '<g:id>' . $product['product_id'] . '#$#SIZE#$#</g:id>';
                        }
                        if (isset($apparel_data['age_group']) && $apparel_data['age_group']!='') {
                            $item .= '<g:age_group>'.$apparel_data['age_group'].'</g:age_group>';
                        } else {
                            $item .= '<g:age_group>adult</g:age_group>';
                        }
                        if (isset($apparel_data['gender']) && $apparel_data['gender']!='') {
                            $item .= '<g:gender>'.$apparel_data['gender'].'</g:gender>';
                        } else {
                            $item .= '<g:gender>unisex</g:gender>';
                        }
                        $item .= '<g:size>#$#SIZE#$#</g:size>';
                        $item .= '#$#PRICE#$#';
                    } else {
                        if ($google_merchant_center_feed_id1=='model') {
                            $item .= '<g:id>' . trim(htmlspecialchars(htmlspecialchars_decode(str_replace(',', '', $product['model']), ENT_COMPAT), ENT_COMPAT, 'UTF-8')). '</g:id>';
                        } else {
                            $item .= '<g:id>' . $product['product_id'] . '</g:id>';
                        }

                        if ((float)$product['special']) {
                            $item .= '<g:sale_price_effective_date></g:sale_price_effective_date>';
                            $item .= '<g:sale_price>' .  $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code. '</g:sale_price>';
                            $item .= '<g:price>' .  $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code.'</g:price>';
                        } else {
                            $item .= '<g:price>' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code. '</g:price>';
                        }
                    }
                    if (isset($apparel_data['color'])) {
                        $item .= '<g:color>'.trim($apparel_data['color']).'</g:color>';
                    }

                    if ($attribute_id_type=='-1') {
                        $item .= $cat_string;
                    } else {
                        $product_type = $this->model_feed_google_merchant_center->getProductExtraType($product['product_id'], $attribute_id_type, $lang);
                        if ($product_type=='') {
                            $item .= $cat_string;
                        } else {
                            $item .= '<g:product_type>' . trim(htmlspecialchars(htmlspecialchars_decode($product_type, ENT_COMPAT), ENT_COMPAT, 'UTF-8')) . '</g:product_type>';
                        }
                    }

                    $item .= '<g:quantity>' . $product['quantity'] . '</g:quantity>';

                    //fixed by oppo webiprog.com 2018-05-01 19:20:43
                    // GTIN (EAN, UPC, JAN, ISBN)
                    $identifier_exists = 0;

                    if (!empty($product['manufacturer'])) {
                        $item .= '<g:brand>' . trim(htmlspecialchars(htmlspecialchars_decode($product['manufacturer'], ENT_COMPAT), ENT_COMPAT, 'UTF-8')) . '</g:brand>';
                        ++$identifier_exists;
                    }

                    $gtin=$product['upc'];
                    if ($gtin=='') {
                        $gtin=$product['ean'];
                    }
                    if ($gtin=='') {
                        $gtin=$product['jan'];
                    }
                    if ($gtin=='') {
                        $gtin=$product['isbn'];
                    }

                    //fixed by oppo webiprog.com 2018-05-01 19:20:43
                    // check standart gtin
                    $res = $this->determine($gtin);
                    if ($res) {
                        // printf("\nGtin-13 %s : with check digit: %s\n\n", $gtin, $this->gtinWithCheckDigit);
                        $item .= '<g:gtin>' . trim($gtin) . '</g:gtin>';
                        ++$identifier_exists;
                    }

                    $mpn = $product['mpn'];
                    if ($mpn == '') {
                        $mpn = trim(htmlspecialchars(htmlspecialchars_decode(str_replace(',', '', $product['model']), ENT_COMPAT), ENT_COMPAT, 'UTF-8'));
                        $mpn = $this->xml_sanitizer($mpn);
                    }
                    if ($mpn) {
                        $item .= '<g:mpn>' . $mpn . '</g:mpn>';
                        ++$identifier_exists;
                    }

                    // Tag "identifier_exists"
                    if ($identifier_exists < 2) {
                        $item .= '<g:identifier_exists>FALSE</g:identifier_exists>';
                    }
                    //END fixed by oppo webiprog.com 2018-05-01 19:20:43

                    $weight = $this->weight->format($product['weight'], $product['weight_class_id']);

                    if (strpos($weight, 'kg') !== false) {
                        $item .= '<g:unit_pricing_measure>' . $weight . '</g:unit_pricing_measure>';
                        $item .= '<g:unit_pricing_base_measure>1kg</g:unit_pricing_base_measure>';
                    } elseif(strpos($weight, 'g') !== false) {
                        $item .= '<g:unit_pricing_measure>' . $weight . '</g:unit_pricing_measure>';
                        $item .= '<g:unit_pricing_base_measure>100g</g:unit_pricing_base_measure>';
                    }

                    if (strpos($weight, 'g') !== false || strpos($weight, 'lb') !== false || strpos($weight, 'oz') !== false) {
                        $item .= '<g:shipping_weight>' . $weight . '</g:shipping_weight>';
                    } else {
                        $item .= '<g:shipping_weight>0 kg</g:shipping_weight>';
                    }



                    if ($product['quantity']==0) {
                        $item .= '<g:availability>' . $google_merchant_center_availability . '</g:availability>';
                    } else {
                        $item .= '<g:availability>in stock</g:availability>';
                    }

                    $item .= '</item>';

                    if ($is_apparel) {
                        $options=$this->model_feed_google_merchant_center->getProductOptions($product['product_id'], $apparel_option_id, $lang);
                        $itemTMP=$item;
                        if (count($options)) {
                            $item='';
                        }
                        foreach ($options as $size) {
                            $item.=str_replace('#$#SIZE#$#', trim(htmlspecialchars(htmlspecialchars_decode($size['name'], ENT_COMPAT), ENT_COMPAT, 'UTF-8')), $itemTMP);
                            $price=$size['price'];
                            if ($size['price_prefix']=='-') {
                                $price=$price*(-1);
                            }
                            $price_item='';
                            if ((float)$product['special']) {
                                $price_item = '<g:sale_price>' .  $this->currency->format($this->tax->calculate($product['special']+$price, $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code. '</g:sale_price>';
                                $price_item .= '<g:price>' .  $this->currency->format($this->tax->calculate($product['price']+$price, $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code.'</g:price>';
                            } else {
                                $price_item = '<g:price>' . $this->currency->format($this->tax->calculate($product['price']+$price, $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code. '</g:price>';
                            }
                            $item=str_replace('#$#PRICE#$#', $price_item, $item);
                        }

                        if (strpos($item, '#$#PRICE#$#') !== false || $item== '') {
                            $price_item='';
                            if ((float)$product['special']) {
                                $price_item = '<g:sale_price>' .  $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code. '</g:sale_price>';
                                $price_item .= '<g:price>' .  $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code.'</g:price>';
                            } else {
                                $price_item = '<g:price>' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $use_tax), $currency_code, $currency_value, false) . ' '.$currency_code. '</g:price>';
                            }
                            if ($item=='') {
                                $item=str_replace('#$#PRICE#$#', $price_item, $itemTMP);
                            } else {
                                $item=str_replace('#$#PRICE#$#', $price_item, $item);
                            }
                        }
                    }
                    $item = str_replace('#$#SIZE#$#', '', $item);
                    $output.=$item;
                }
                if ($file_only) {
                    file_put_contents($filename.'.tmp', $output, FILE_APPEND | LOCK_EX);
                    $output="";
                }
                $start=$start+$limit;
                $data_limit['start'] = $start;
                $products = $this->model_feed_google_merchant_center->getProducts($lang, $store, $data_limit);
            }

            $output .= '</channel>';
            $output .= '</rss>';

            if ($file_only) {
                file_put_contents($filename.'.tmp', $output, FILE_APPEND | LOCK_EX);
                rename($filename.'.tmp', $filename);
                $explode=explode("index.php?", $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
                $this->response->setOutput("Feed link: ".reset($explode). str_replace(str_replace("catalog/", '', DIR_APPLICATION), "", DIR_DOWNLOAD) .$filetitle);
            } else {
                header('Content-Type: application/xml; charset=UTF-8');
                $this->response->addHeader('Content-Type: application/rss+xml');
                $this->response->setOutput($output);
            }

            // $etimer = explode(' ', microtime());
            // $etimer = $etimer[1] + $etimer[0];

            // echo '<p style="margin:auto; text-align:center">';

            // echo 'Done <strong>' . ($count) . '</strong> items. <br />File: <a target="_self" href="' . $url . '/export/' . $fileName . '">' . $fileName . '</a><hr />';

            // printf("Script timer: <b>%f</b> seconds.", ($etimer - $stimer));
            // echo '</p>';
        }
    }

    protected function getPath($parent_id, $lang, $store, $current_path = '')
    {
        $category_info = $this->model_feed_google_merchant_center->getCategory($parent_id, $lang, $store);

        if ($category_info) {
            $path="";
            if (!$current_path) {
                $new_path = $category_info['category_id'];
            } else {
                $new_path = $category_info['category_id'] . '_' . $current_path;
            }
            if ($parent_id != $category_info['parent_id']) {
                $path = $this->getPath($category_info['parent_id'], $lang, $store, $new_path);
            }

            if ($path) {
                return $path;
            } else {
                return $new_path;
            }
        }
    }

    protected function strip_html_tags($text)
    {
        $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text
        );
        return strip_tags($text);
    }
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }
        return false;
    }
    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }
        return false;
    }
    public static function clearDescription($string, $remove)
    {
        while (ControllerFeedGoogleMerchantCenter::startsWith($string, $remove)) {
            $string = substr($string, strlen($remove));
        }
        while (ControllerFeedGoogleMerchantCenter::endsWith($string, $remove)) {
            $string = substr($string, 0, strlen($string) - strlen($remove));
        }
        return $string;
    }
    public static function fixEncoding($string)
    {
        $string=str_replace("&amp;lt;", "&lt;", $string);
        $string=str_replace("&amp;gt;", "&gt;", $string);
        $string=str_replace("&amp;quot;", "&quot;", $string);
        $string=str_replace("&amp;amp;", "&amp;", $string);
        return $string;
    }



    public $lastError;

    /**
     * gtinCheckDigit
     *
     * The gtin determined check digit
     *
     * @var string
     * @access public
     */
    public $gtinCheckDigit;
    /**
     * gtinWithCheckDigit
     *
     * The gtin with check digit applied
     *
     * @var string
     * @access public
     */
    public $gtinWithCheckDigit;
    /**
     * determine check gtin
     *
     * Algorithm taken from http://www.gs1.org/how-calculate-check-digit-manually
     *
     * @param long int $gtin The gtin number
     * @access public
     * @return bool
     */
    public function determine($gtin = null)
    {
        $ret = false;
        if ($gtin !== null) {
            $gtinLength = strlen($gtin);
            $gtinLengthIsValid
                = ($gtinLength == 7) || ($gtinLength == 11) || ($gtinLength == 12) || ($gtinLength == 13);
            if ($gtinLengthIsValid) {
                $ns = str_split((string)$gtin);
                $multiplier = 3;
                $sums = [];
                for ($i = $gtinLength -1; $i >=0; $i--) {
                    $currentDigit = $ns[$i];
                    $sums[$i] = (int)$currentDigit * $multiplier;
                    if ($multiplier == 3) {
                        $multiplier = 1;
                    } else {
                        $multiplier = 3;
                    }
                }
                $sum = 0;
                foreach (array_reverse($sums) as $sumNum) {
                    $sum += $sumNum;
                }
                $nearestTen = round($sum, -1);
                if ($nearestTen < $sum) {
                    $nearestTen = $nearestTen + 10;
                }
                $gtinCheckDigit = $nearestTen - $sum;
                $this->gtinCheckDigit = $gtinCheckDigit;
                $this->gtinWithCheckDigit = $gtin . $gtinCheckDigit;
                if ($gtinCheckDigit > 0) {
                    $ret = true;
                } else {
                    $this->lastError = "invalid check digit determined";
                }
            } else {
                $this->lastError = "invalid length of gtin";
            }
        }
        return $ret;
    }

    public $clear_utf;

    public function xml_sanitizer($str)
    {
        $str = preg_replace('/[\x00-\x1F\x7F]/', '', $str);
        if (!$this->clear_utf) {
            $map = array(
                chr(138) => chr(169),
                chr(140) => chr(166),
                chr(141) => chr(171),
                chr(142) => chr(174),
                chr(143) => chr(172),
                chr(156) => chr(182),
                chr(157) => chr(187),
                chr(161) => chr(183),
                chr(165) => chr(161),
                chr(188) => chr(165),
                chr(159) => chr(188),
                chr(185) => chr(177),
                chr(154) => chr(185),
                chr(190) => chr(181),
                chr(158) => chr(190),
                chr(128) => '&euro;',
                chr(130) => '&sbquo;',
                chr(132) => '&bdquo;',
                chr(133) => '&hellip;',
                chr(134) => '&dagger;',
                chr(135) => '&Dagger;',
                chr(137) => '&permil;',
                chr(139) => '&lsaquo;',
                chr(145) => '&lsquo;',
                chr(146) => '&rsquo;',
                chr(147) => '&ldquo;',
                chr(148) => '&rdquo;',
                chr(149) => '&bull;',
                chr(150) => '&ndash;',
                chr(151) => '&mdash;',
                chr(153) => '&trade;',
                chr(155) => '&rsquo;',
                chr(166) => '&brvbar;',
                chr(169) => '&copy;',
                chr(171) => '&laquo;',
                chr(174) => '&reg;',
                chr(177) => '&plusmn;',
                chr(181) => '&micro;',
                chr(182) => '&para;',
                chr(183) => '&middot;',
                chr(187) => '&raquo;'
            );
            $str = html_entity_decode($str);
            $str = mb_convert_encoding($str, 'UTF-8', 'ISO-8859-15');
        }

        $str = htmlspecialchars($str);
        return $str;
    }
}

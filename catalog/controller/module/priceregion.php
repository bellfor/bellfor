<?php
# @Date:  28.02.2018
# @Email:  oleg@webiprog.com
# @Project: belfor
# @Filename: priceregion.php
# @Last modified by:   Oleg
# @License: free


class ControllerModulePriceRegion extends Controller
{
    // Module Unifier
    private $moduleName = 'priceregion';
    const URL_CURRENCIES = 'https://openexchangerates.org/api/currencies.json';
    const URL_CONVERT = 'https://openexchangerates.org/api/convert/';

    /*
    app_id=c081d4df0a3340399917fc2d422e15a2';
    $app_id = '242fb9ae64974346985dcec68f9986e8';
    'app_id' => '1c01828c30da413792ad387b78fb13bf'
    */

    /**
     * @var string
     */
    protected $url = 'https://openexchangerates.org/api/latest.json';

    /**
     * @var string
     */
    protected $app_id;

    protected function currency_code()
    {
        $ip = $this->request->server['REMOTE_ADDR'];
        // || $ip == '178.151.40.213'
        if ($ip == '::1' || $ip == '127.0.0.1') {
            //For testing purpose only
                            //$ip = '8.8.8.8'; //US
                            //$ip = '2.31.255.128'; //UK
                            //$ip = '201.59.174.194'; //BR
                            //$ip = '178.216.222.160'; //RU
                            //$ip = '95.233.0.33'; //IT
                            $ip = '178.62.74.225'; //GB
                            //$ip = '193.37.152.6'; //DE
        }
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $finf_geo_details =  unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));

            return  isset($finf_geo_details['geoplugin_currencyCode'])?$finf_geo_details['geoplugin_currencyCode']:false; //return currency code accoring to location
        }
        return false;
    }

    public function index($data)
    {
        if (empty($data['price'])) {
            return ;
        }

        $price = $data['price'];

        /*
            array (
          'price' => '12,50 EUR',
          'special' => false,
        )
        */

        if ($this->isBot()) {
            return;
        }

        $currency_code = null;
        //setcookie('priceregion-geo-ip', (string)$currency_code, time() - 3600 * 24 * 365, getenv('HTTP_HOST'));
        if (!isset($this->request->cookie['priceregion-geo-ip'])) {
            $currency_code = $this->currency_code();
            setcookie('priceregion-geo-ip', (string)$currency_code, time() + 3600 * 24 * 365, getenv('HTTP_HOST'));
        }

//        $geo_cookie_currency = $this->request->cookie['priceregion-geo-ip'];

//        if (empty($geo_cookie_currency)) {
        if (!isset($this->request->cookie['priceregion-geo-ip'])) {
            if ($currency_code) {
                $geo_cookie_currency = $currency_code;
            } else {
                return;
            }
        } else {
            $geo_cookie_currency = $this->request->cookie['priceregion-geo-ip'];
        }

        //echo "<pre>geo_cookie_currency::"; var_export($geo_cookie_currency); echo "</pre>";
        //'GBP'

        $geo_cookie_currency = strtoupper(trim($geo_cookie_currency));
        //$geo_cookie_currency = 'UAH';
        //'EUR'
        $default_currency = $this->config->get('config_currency');

        if ($geo_cookie_currency == $default_currency) {
            return;
        }

        $status = $this->config->get('priceregion_status');
        //priceregion_status
        if (empty($status)) {
            return;
        }

        $this->app_id =  $this->config->get('priceregion_app_id');
        //priceregion_app_id
        if (empty($this->app_id)) {
            //$this->error('An API key is needed from OpenExchangeRates.org to continue.');
            return;
        }

        /*
          'timestamp' => 1519821600,
          'base' => 'EUR',
          'rates' =>
        */


        $key = 'priceregion';

        //$this->cache->delete($key);

        $store_data = $this->cache->get('priceregion');

        if (!$store_data) {
            $admin_cache_store = null;
            $this->get_rates();
            $store_data = $this->cache->get('priceregion');
        } else {
            $lastUpdate = $store_data['timestamp'];
            $check = time() - $lastUpdate;
            if ($check < 86400 && date("d", $lastUpdate) == date("d")) {
            } else {
                //$this->cache->delete($key);
                $this->get_rates();
                $store_data = $this->cache->get('priceregion');
            }
            $admin_cache_store = true;
        }

        if (!$store_data) {
            return;
        }

        $rates = $store_data['rates'];
        $rate = ($rates[$geo_cookie_currency] / $rates[$default_currency]);

        $this->currencyConverter = $rate;

        if (!is_numeric($this->currencyConverter) || $this->currencyConverter == 0) {
            return false;
        }

        $value_rate = $this->currency->getValue($default_currency);
        if (!$value_rate) {
            $value_rate = $rates[$default_currency];
        }
        if (!is_numeric($value_rate) || $value_rate == 0) {
            return false;
        }

        $new_price = $price / $value_rate ;

        $first_currency = $this->currency->format($new_price);
        // ,'EUR'

        if ($this->currency->has($geo_cookie_currency)) {
            $second_currency = $this->currency->format($new_price * $this->currencyConverter, $geo_cookie_currency) ;
        } else {
            $second_currency = $this->currency->format($new_price * $this->currencyConverter, $geo_cookie_currency, '', false) ;
            $second_currency = $second_currency.' '.$geo_cookie_currency;
        }

        $this->load->language('module/priceregion');

        $text_price = sprintf($this->language->get('text_price'), $first_currency, $second_currency);

        $text_price = '<div id="priceregion" class="text-info text-left"><div class="list-group bg-info"><span class=" list-group-item" style="font-size:17px;color: #a94442;">'.$text_price.'</span></div></div>';

        return $text_price;

        /*
        // format($number, $currency = '', $value = '', $format = true)
                        $module_price = $this->currency->format(
        */
    }

    public static function mbReplace($search, $replace, $subject, $encoding = 'auto', &$count=0)
    {
        if (!is_array($subject)) {
            $searches = is_array($search) ? array_values($search) : [$search];
            $replacements = is_array($replace) ? array_values($replace) : [$replace];
            $replacements = array_pad($replacements, count($searches), '');
            foreach ($searches as $key => $search) {
                $replace = $replacements[$key];
                $search_len = mb_strlen($search, $encoding);

                $sb = [];
                while (($offset = mb_strpos($subject, $search, 0, $encoding)) !== false) {
                    $sb[] = mb_substr($subject, 0, $offset, $encoding);
                    $subject = mb_substr($subject, $offset + $search_len, null, $encoding);
                    ++$count;
                }
                $sb[] = $subject;
                $subject = implode($replace, $sb);
            }
        } else {
            foreach ($subject as $key => $value) {
                $subject[$key] = self::mbReplace($search, $replace, $value, $encoding, $count);
            }
        }
        return $subject;
    }

    //easily convert amounts to geolocated currency.
    private function convert($amount, $float=2, $symbol=false)
    {
        if (!is_numeric($this->currencyConverter) || $this->currencyConverter == 0) {
            //trigger_error('geoPlugin class Notice: currencyConverter has no value.', E_USER_NOTICE);
            return $amount;
        }
        if (!is_numeric($amount)) {
            //trigger_error ('geoPlugin class Warning: The amount passed to geoPlugin::convert is not numeric.', E_USER_WARNING);
            return $amount;
        }
        if ($symbol === true) {
            return $this->currencySymbol . round(($amount * $this->currencyConverter), $float);
        } else {
            return round(($amount * $this->currencyConverter), $float);
        }
    }

    /**
     * Return current rates from openexchangerates.org
     *
     * @return array
     */
    private function get_rates()
    {

        /*
        $api_keys=array(
            'raul@inikoo.com'=>'8158586024e345b2b798c26ee50b6987',
            'exchange1@inikoo.com'=>'21467cd6ca2847cf9fdbc913e616d6e9',
            'exchange2@inikoo.com'=>'e328d66fafc94f6391d2a8e4fbab0389',
            'exchange3@inikoo.com'=>'271f126537a84a3f98599e66781f8bed',
            'exchange4@inikoo.com'=>'756b792276ba4c80807a85b031139d7e',
            'exchange5@inikoo.com'=>'4bc72747362a496c971c528fb1b1d219',
        );
        shuffle($api_keys);
        $api_key=reset($api_keys);
        */
        /*
         $content = json_decode(file_get_contents("http://openexchangerates.org/api/latest.json?base={$default_currency}&app_id={$this->app_id}&show_alternative=1"));
        */

        $basecur =  $this->config->get('priceregion_basecur');

        // USD
        $queryData = array(
        "base" => $basecur ?: 'EUR',
        "app_id" => $this->app_id,
        "show_alternative" => 1,
        );

        $url = "http://openexchangerates.org/api/latest.json?" . http_build_query($queryData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        if ($httpCode != 200) {
            //throw new \ErrorException('API did not response with HTTP 200, got HTTP ' . $httpCode . ' instead');
            return false;
        }

        $decoded = json_decode($data, true);

        $key = 'priceregion';

        if (!is_null($decoded) && is_array($decoded)) {
            //file_put_contents(dirname(__FILE__) . '/../data/rates.json', $latestJSON, LOCK_EX);
            $this->cache->delete($key);
            $this->cache->set($key, $decoded);
        }

        return $decoded;
    }

    private function isBot()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        $bots = array(
            'Googlebot', 'Baiduspider', 'ia_archiver',
            'R6_FeedFetcher', 'NetcraftSurveyAgent', 'Sogou web spider',
            'bingbot', 'Yahoo! Slurp', 'facebookexternalhit', 'PrintfulBot',
            'msnbot', 'Twitterbot', 'UnwindFetchor',
            'urlresolver', 'Butterfly', 'TweetmemeBot' );

        foreach ($bots as $b) {
            if (stripos($_SERVER['HTTP_USER_AGENT'], $b) !== false) {
                return true;
            }
        }
        return false;
    }

    public function setcookiecurrency($currency)
    {
        $this->code = $currency;

        if ((!$this->session->has('currency')) || ($this->session->get('currency') != $currency)) {
            $this->session->set('currency', $currency);
        }

        if ((!$this->request->get('currency', 'cookie')) || ($this->request->get('currency', 'cookie') != $currency)) {
            setcookie('currency', $currency, time() + 60 * 60 * 24 * 30, '/', isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']);
        }
        if ($this->config->get('config_currency') != $currency) {
            $this->update_currency($currency);
        }
    }

    public function detect()
    {
        $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $top_level_domain = substr($host, strrpos($host, '.') + 1);

        $domains=array(
            'ad'=>'EUR',
            'ae'=>'AED',
            'af'=>'AFA',
            'ag'=>'XCD',
            'ai'=>'XCD',
            'al'=>'ALL',
            'am'=>'AMD',
            'an'=>'ANG',
            'ao'=>'AOK',
            'aq'=>'',
            'ar'=>'ARP',
            'as'=>'EUR',
            'at'=>'EUR',
            'au'=>'AUD',
            'aw'=>'ANG',
            'az'=>'AZM',
            'ba'=>'BAK',
            'bb'=>'BBD',
            'bd'=>'BDT',
            'be'=>'EUR',
            'bf'=>'XOF',
            'bg'=>'BGL',
            'bh'=>'BHD',
            'bi'=>'BIF',
            'bj'=>'XOF',
            'bm'=>'BMD',
            'bn'=>'BND',
            'bo'=>'BOB',
            'br'=>'BRR',
            'bs'=>'BSD',
            'bt'=>'INR',
            'bv'=>'NOK',
            'bw'=>'BWP',
            'by'=>'BYR',
            'bz'=>'BZD',
            'ca'=>'CAD',
            'cc'=>'AUD',
            'cf'=>'XAF',
            'cg'=>'XAF',
            'ch'=>'CHF',
            'ci'=>'XOF',
            'ck'=>'ZND',
            'cl'=>'CLP',
            'cm'=>'XAF',
            'cn'=>'CNY',
            'co'=>'COP',
            'cr'=>'CRC',
            'cs'=>'CSK',
            'cu'=>'CUP',
            'cv'=>'CVE',
            'cx'=>'AUD',
            'cy'=>'CYP',
            'cz'=>'CSK',
            'de'=>'EUR',
            'dj'=>'DJF',
            'dk'=>'DKK',
            'dm'=>'XCD',
            'do'=>'DOP',
            'dz'=>'DZD',
            'ec'=>'ECS',
            'ee'=>'EUR',
            'eg'=>'EGP',
            'eh'=>'MAD',
            'er'=>'ETB',
            'es'=>'EUR',
            'et'=>'ETB',
            'fi'=>'EUR',
            'fj'=>'FJD',
            'fk'=>'FKP',
            'fm'=>'USD',
            'fo'=>'DKK',
            'fr'=>'EUR',
            'fx'=>'EUR',
            'ga'=>'XAF',
            'gb'=>'GBP',
            'gd'=>'XCD',
            'ge'=>'GEL',
            'gf'=>'EUR',
            'gh'=>'GHC',
            'gi'=>'GIP',
            'gl'=>'DKK',
            'gm'=>'GMD',
            'gn'=>'GNF',
            'gp'=>'EUR',
            'gq'=>'XAF',
            'gr'=>'EUR',
            'gs'=>'GBP',
            'gt'=>'GTQ',
            'gu'=>'USD',
            'gw'=>'XOF',
            'gy'=>'GYD',
            'hk'=>'HKD',
            'hm'=>'AUD',
            'hn'=>'HNL',
            'hr'=>'HRK',
            'ht'=>'HTG',
            'hu'=>'HUF',
            'id'=>'IDR',
            'ie'=>'EUR',
            'il'=>'ILS',
            'in'=>'INR',
            'int'=>'',
            'io'=>'USD',
            'iq'=>'IQD',
            'ir'=>'IRR',
            'is'=>'ISK',
            'it'=>'EUR',
            'jm'=>'JMD',
            'jo'=>'JOD',
            'jp'=>'JPY',
            'ke'=>'KES',
            'kg'=>'KGS',
            'kh'=>'KHR',
            'ki'=>'AUD',
            'km'=>'KMF',
            'kn'=>'XCD',
            'kp'=>'KPW',
            'kr'=>'KRW',
            'kw'=>'KWD',
            'ky'=>'KYD',
            'kz'=>'KZT',
            'la'=>'LAK',
            'lb'=>'LBP',
            'lc'=>'XCD',
            'li'=>'CHF',
            'lk'=>'LKR',
            'lr'=>'LRD',
            'ls'=>'LSL',
            'lt'=>'LTL',
            'lu'=>'EUR',
            'lv'=>'LVL',
            'ly'=>'LYD',
            'ma'=>'MAD',
            'mc'=>'EUR',
            'md'=>'MDL',
            'mg'=>'MGF',
            'mh'=>'USD',
            'mil'=>'USD',
            'mk'=>'MKD',
            'ml'=>'XOF',
            'mm'=>'MMK',
            'mn'=>'MNT',
            'mo'=>'MOP',
            'mp'=>'USD',
            'mq'=>'EUR',
            'mr'=>'MRO',
            'ms'=>'XCD',
            'mt'=>'MTL',
            'mu'=>'MUR',
            'mv'=>'MVR',
            'mw'=>'MWK',
            'mx'=>'MXP',
            'my'=>'MYR',
            'mz'=>'MZM',
            'na'=>'NAD',
            'nc'=>'XPF',
            'ne'=>'XOF',
            'net'=>'',
            'nf'=>'AUD',
            'ng'=>'NGN',
            'ni'=>'NIO',
            'nl'=>'EUR',
            'no'=>'NOK',
            'np'=>'NPR',
            'nr'=>'AUD',
            'nt'=>'',
            'nu'=>'NZD',
            'nz'=>'NZD',
            'om'=>'OMR',
            'pa'=>'PAB',
            'pe'=>'PEN',
            'pf'=>'XPF',
            'pg'=>'PGK',
            'ph'=>'PHP',
            'pk'=>'PKR',
            'pl'=>'PLZ',
            'pm'=>'EUR',
            'pn'=>'NZD',
            'pr'=>'USD',
            'pt'=>'EUR',
            'pw'=>'USD',
            'py'=>'PYG',
            'qa'=>'QAR',
            're'=>'EUR',
            'ro'=>'ROL',
            'ru'=>'RUR',
            'rw'=>'RWF',
            'sa'=>'SAR',
            'sb'=>'SBD',
            'sc'=>'SCR',
            'sd'=>'SDD',
            'se'=>'SEK',
            'sg'=>'SGD',
            'sh'=>'SHP',
            'si'=>'EUR',
            'sj'=>'NOK',
            'sk'=>'EUR',
            'sl'=>'SLL',
            'sm'=>'EUR',
            'sn'=>'XOF',
            'so'=>'SOS',
            'sr'=>'SRG',
            'st'=>'STD',
            'su'=>'RUR',
            'sv'=>'SVC',
            'sy'=>'SYP',
            'sz'=>'SZL',
            'tc'=>'USD',
            'td'=>'XAF',
            'tf'=>'EUR',
            'tg'=>'XOF',
            'th'=>'THB',
            'tj'=>'TJR',
            'tk'=>'NZD',
            'tm'=>'TMM',
            'tn'=>'TND',
            'to'=>'TOP',
            'tp'=>'IDR',
            'tr'=>'TRL',
            'tt'=>'TTD',
            'tv'=>'AUD',
            'tw'=>'TWD',
            'tz'=>'TZS',
            'ua'=>'UAH',
            'ug'=>'UGX',
            'uk'=>'GBP',
            'um'=>'USD',
            'us'=>'USA',
            'uy'=>'UYU',
            'uz'=>'UZS',
            'va'=>'EUR',
            'vc'=>'XCD',
            've'=>'VEB',
            'vg'=>'USD',
            'vi'=>'USD',
            'vn'=>'VND',
            'vu'=>'VUV',
            'wf'=>'XPF',
            'ws'=>'WST',
            'ye'=>'YER',
            'yt'=>'EUR',
            'yu'=>'YUN',
            'za'=>'ZAR',
            'zm'=>'ZMK',
            'zr'=>'ZRZ',
            'zw'=>'ZWD');

        if (isset($domains[$top_level_domain])) {
            $currency= $domains[$top_level_domain];
            if (isset($this->currencies[$currency])) {
                return $currency;
            }
        }
        return false;
    }
}

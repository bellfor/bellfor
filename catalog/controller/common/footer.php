<?php
// *	@copyright	OPENCART.DESIGN 2015 - 2016.
// *	@forum	http://forum.opencart.design
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
        $data['text_article'] = $this->language->get('text_article');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		//Custom links for SEO footer
        $data['articles'] = array();

        if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/category' && isset($this->request->get['path'])) {

            $this->load->model('catalog/category');

            $data['articles'] = $this->customLinks($this->model_catalog_category->getCategoryCustomLinks($this->request->get['path']));

        } elseif (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product' && isset($this->request->get['product_id'])) {

            $this->load->model('catalog/product');

            $data['articles'] = $this->customLinks($this->model_catalog_product->getProductCustomLinks($this->request->get['product_id']));

        } elseif (isset($this->request->get['route']) && $this->request->get['route'] == 'blog/latest') {

            $this->load->model('blog/category');

            $data['articles'] = $this->customLinks($this->model_blog_category->getBlogLatestCustomLinks());

        } elseif (isset($this->request->get['route']) && $this->request->get['route'] == 'blog/article' && isset($this->request->get['article_id'])) {

            $this->load->model('blog/article');

            $data['articles'] = $this->customLinks($this->model_blog_article->getArticleCustomLinks($this->request->get['article_id']));

        } elseif (isset($this->request->get['route']) && $this->request->get['route'] == 'information/information' && isset($this->request->get['information_id'])) {

            $this->load->model('catalog/information');

            $data['articles'] = $this->customLinks($this->model_catalog_information->getInformationCustomLinks($this->request->get['information_id']));

        } elseif (isset($this->request->get['route']) && $this->request->get['route'] != 'checkout/cart' && $this->request->get['route'] != 'checkout/onepagecheckout' ) {

            $data['articles'] = $this->customLinks($this->config->get('config_custom_link'));

        }

        $store_id = $this->config->get('config_store_id');

        if (($store_id == 0 || $store_id == 4 || $store_id == 1) && !isset($this->request->cookie['promo_code'])) {
            $data['consultant'] = true;
        }

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}

	public function customLinks($custom_links) {
	    $result = array();

	    foreach ($custom_links as $custom_link) {
            $articles[] = array(
                'name' => $custom_link['name'],
                'href' => $custom_link['href']
            );
        }

        if (isset($articles)){
            $result = array_chunk(array_slice($articles, 0, 15), 5);
        }

        return $result;
    }

    public function promoCodePopUp (){

        if (!isset($this->request->cookie['promo_code']) && !$this->customer->isLogged()) {
            setcookie('promo_code', true, time() + 3600 * 24 * 90);
            $json = true;
        } else {
            $json = false;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}

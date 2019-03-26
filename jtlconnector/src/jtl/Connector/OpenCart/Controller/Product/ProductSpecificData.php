<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller\Product;

use jtl\Connector\Model\Product as ProductModel;
use jtl\Connector\OpenCart\Controller\BaseController;
use jtl\Connector\OpenCart\Exceptions\MethodNotAllowedException;
use jtl\Connector\OpenCart\Mapper\ProductPriceItem;
use jtl\Connector\OpenCart\Utility\SQLs;

class ProductSpecificData extends BaseController
{
    public function pullData(array $data, $model, $limit = null)
    {
        $groupPriceQuery = SQLs::productSpecificData($data['product_id']);
        $result = $this->database->query($groupPriceQuery);

        return $result;

    }

    protected function pullQuery(array $data, $limit = null)
    {
        throw new MethodNotAllowedException();
    }

    public function pushData(ProductModel $data, &$model)
    {
	    throw new MethodNotAllowedException();
    }
}
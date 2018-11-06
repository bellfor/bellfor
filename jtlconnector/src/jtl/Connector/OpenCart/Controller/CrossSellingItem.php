<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller;

use jtl\Connector\Model\CrossSellingItem as CrossSellingItemModel;
use jtl\Connector\Model\Identity;
use jtl\Connector\OpenCart\Utility\SQLs;

class CrossSellingItem extends BaseController
{
    public function pullData(array $data, $model, $limit = null)
    {
        $query = $this->pullQuery($data, $limit);
        $result = $this->database->query($query);
        if (empty($result)) {
            return [];
        }
        $model = new CrossSellingItemModel();
        foreach ($result as $row) {
            $model->addProductId(new Identity($row['related_id']));
        }
        return [$model];
    }

    protected function pullQuery(array $data, $limit = null)
    {
        return SQLs::crossSellingItemPull($data['product_id']);
    }
}

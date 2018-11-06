<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller;

use jtl\Connector\Core\Exception\DatabaseException;
use jtl\Connector\Model\CustomerOrder;
use jtl\Connector\Model\DeliveryNote as DeliveryNoteModel;
use jtl\Connector\Model\DeliveryNoteTrackingList;
use jtl\Connector\OpenCart\Exceptions\MethodNotAllowedException;
use jtl\Connector\OpenCart\Utility\SQLs;

class DeliveryNote extends BaseController
{
    public function pullData(array $data, $model, $limit = null)
    {
        throw new MethodNotAllowedException();
    }

    protected function pullQuery(array $data, $limit = null)
    {
        throw new MethodNotAllowedException();
    }

    public function pushData(DeliveryNoteModel $data, $model)
    {
        $result = $data->getTrackingLists();
        $customerOrderId = $data->getCustomerOrderId()->getEndpoint();

        foreach($result as $item)
        {
            $codes = $item->getCodes();;
            $addCodes = implode(",", $codes);
            $sql = SQLs::setTrackingCodes($addCodes, $customerOrderId);
            $this->database->query($sql);
        }
        
        return $data;
    }

}

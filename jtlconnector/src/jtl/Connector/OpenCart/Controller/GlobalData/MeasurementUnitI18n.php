<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller\GlobalData;

use jtl\Connector\OpenCart\Controller\BaseController;
use jtl\Connector\OpenCart\Exceptions\DataAlreadyFetchedException;
use jtl\Connector\OpenCart\Utility\SQLs;

class MeasurementUnitI18n extends BaseController
{
    public function pullData(array $data, $model, $limit = null)
    {
        $return = [];
        if (strrpos($data['id'], 'l_') !== false) {
            $query = SQLs::measurementUnitLengthsI18nPull(str_replace('l_', '', $data['id']));
        } else {
            $query = SQLs::measurementUnitWeightsI18nPull(str_replace('w_', '', $data['id']));
        }
        $result = $this->database->query($query);
        if (is_array($result)) {
            foreach ($result as $row) {
                $host = $this->mapper->toHost($row);
                $return[] = $host;
            }
        }
        return $return;
    }

    protected function pullQuery(array $data, $limit = null)
    {
        throw new DataAlreadyFetchedException();
    }
}
<?php
/**
 * @author Sven Mäurer <sven.maeurer@jtl-software.com>
 * @copyright 2010-2013 JTL-Software GmbH
 */

namespace jtl\Connector\OpenCart\Controller\Specific;

use jtl\Connector\Model\Specific as SpecificModel;
use jtl\Connector\OpenCart\Controller\BaseController;
use jtl\Connector\OpenCart\Utility\SQLs;

class SpecificValue extends BaseController
{
    public function pullData(array $data, $model, $limit = null)
    {
        return parent::pullDataDefault($data, $limit);
    }

    protected function pullQuery(array $data, $limit = null)
    {
        return SQLs::specificValuePull($data['filter_group_id']);
    }

    public function pushData(SpecificModel $data, &$model)
    {
        foreach ($data->getValues() as $value) {
            $id = $value->getId()->getEndpoint();
            if (empty($id)) {
                $query = SQLs::specificValuePush($data->getId()->getEndpoint(), $value->getSort());
                $id = $this->database->query($query);
                $value->getId()->setEndpoint($id);
            } else {
                $query = SQLs::specificValueUpdate($data->getId()->getEndpoint(), $value->getSort());
                $this->database->query($query);
            }
            foreach ($value->getI18ns() as $i18n) {
                $languageId = $this->utils->getLanguageId($i18n->getLanguageISO());
                $query = SQLs::specificValueI18nPush($data->getId()->getEndpoint(), $value->getId()->getEndpoint(),
                    $languageId, $i18n->getValue());
                $this->database->query($query);
            }
        }
    }
}
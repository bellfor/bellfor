<?php
class ControllerExtensionRace extends Controller {

    public function autocomplete(){
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('extension/race');

            $race_data = array(
                'race_dogs' => $this->request->get['filter_name'],
                'start'       => 0,
                'limit'       => 5
            );

            $race_dogs = $this->model_extension_race->getRace($race_data);

            foreach ($race_dogs as $race_dog) {
                $json[] = array(
                    'race_id'   => $race_dog['race_id'],
                    'race'      => $race_dog['race']
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['race'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

}
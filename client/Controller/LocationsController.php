<?php
namespace client\Controller;

use client\Model\CountryModel;
use JsonRPC\Client as ClientRpc;

class LocationsController extends AppController {

    /**
     * Index
     * @return array
     */
    public function index() {

        $this->response->set('view','locations/index.tpl');
    }

    /**
     * Listing using the Json RPC
     * @return array
     */
    public function details() {
        $locations = new ClientRpc('http://localhost/test_nph/locations_service/public/index.php');
        $countries = $locations->country($this->request->data['code']);

        return [
            'message' => 'Countries Using the RPC support',
            'success' => 1,
            'data'    => $countries,
        ];
    }

    /**
     * Listing without Json Rpc
     * @return array
     */
    public function details_norpc() {
        $countries = new CountryModel();

        return [
            'message' => 'locations listing without using the json rpc',
            'success' => 1,
            'data'    => $countries->read([
                'columns' => ['name','code'],
                'where'   => ['code','=',$this->request->data['code']],
            ]),
            //'data'    => $countries->getCustom('RO'),
        ];
    }
}
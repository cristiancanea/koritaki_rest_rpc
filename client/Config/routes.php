<?php
namespace client\config;

use \koritaki\Router\Router as Router;

//this is a simple routing
Router::get('simple', function() {
    return [
        'home'    => 'callback for a simple route',
        'request' => $this->request
    ];
});

//routing
Router::get('pages/index',             ['controller' => 'PagesController',     'action' => 'index' ]);
Router::get('locations/index',         ['controller' => 'LocationsController', 'action' => 'index' ], ['auth'], ['response_type' => 'html']);
Router::post('locations/details',       ['controller' => 'LocationsController', 'action' => 'details' ], ['auth']);
Router::post('locations/details_norpc', ['controller' => 'LocationsController', 'action' => 'details_norpc'], ['auth']);

//404
Router::get('404', ['controller' => 'Pages', 'action' => 'pagenotfound' ]);

//default route - for all the other routes
Router::get('(.*)', ['controller' => 'PagesController',     'action' => 'index' ]);

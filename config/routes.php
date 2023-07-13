<?php
use Cake\Routing\Route\DashedRoute;
$routes->plugin(
    'SimpleSaml',
    ['path' => '/simple-saml'],
    function ($routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
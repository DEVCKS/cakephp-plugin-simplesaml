<?php

namespace SimpleSaml;

use Cake\Core\Configure;

class SimpleSamlAuth
{
    public function __construct()
    {
        require_once(__DIR__.'/../simplesamlphp-1.18.7/lib/_autoload.php');
    }

    /**
     * @param string $ssoName
     */
    public function requireAuth(string $ssoName): array
    {
        $as = new \SimpleSAML\Auth\Simple($ssoName);
        return $as->requireAuth();  
    }
}
    
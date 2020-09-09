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
     * @param string $callBackURL
     * @return array
     */
    public function requireAuth(string $ssoName, string $callBackURL = ''): array
    {
        $as = new \SimpleSAML\Auth\Simple($ssoName);
        $options = [];

        if (strlen($callBackURL) > 0) {
            $options['ReturnTo'] = $callBackURL;
        }

        $as->requireAuth($options);
        return $as->getAttributes();
    }
}
    
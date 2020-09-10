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
        $attributes = $as->getAttributes();

        return $attributes;
    }

    /**
     * @param string $url
     * @return void
     */
    public function logout(string $ssoName, string $url): void
    {
        $as = new \SimpleSAML\Auth\Simple($ssoName);
        $as->logout(['ReturnTo' => $url]);
        $this->clearSession();
    }

    /**
     * @return void
     */
    public function clearSession(): void
    {
        $session = \SimpleSAML\Session::getSessionFromRequest();
        $session->cleanup();
    }
}
    
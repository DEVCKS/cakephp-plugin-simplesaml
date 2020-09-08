<?php

if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null) === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

if (($_SERVER['HTTP_X_FORWARDED_PORT'] ?? null) !== null) {
    $_SERVER['SERVER_PORT'] = $_SERVER['HTTP_X_FORWARDED_PORT'];
}

require_once('_include.php');

$config = \SimpleSAML\Configuration::getInstance();

if ($config->getBoolean('usenewui', false)) {
    \SimpleSAML\Utils\HTTP::redirectTrustedURL(SimpleSAML\Module::getModuleURL('core/login'));
}

\SimpleSAML\Utils\HTTP::redirectTrustedURL(SimpleSAML\Module::getModuleURL('core/frontpage_welcome.php'));

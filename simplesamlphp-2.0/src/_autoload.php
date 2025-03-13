<?php

/**
 * This file is a backwards compatible autoloader for SimpleSAMLphp.
 * Loads the Composer autoloader.
 *
 * @package SimpleSAMLphp
 */

declare(strict_types=1);
header_remove("X-Powered-By");
header('Strict-Transport-Security: max-age=63072000');
header('includeSubDomainsReferrer-Policy: same-origin');
header("Content-Security-Policy: default-src 'self'; img-src 'self'");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: camera(self) ; microphone(self) ; geolocation(self)");
// SSP is loaded as a separate project
if (file_exists(dirname(__FILE__, 2) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__, 2) . '/vendor/autoload.php';
} elseif (file_exists(dirname(__FILE__, 2) . '/../../autoload.php')) {
    // SSP is loaded as a library.
    require_once dirname(__FILE__, 2) . '/../../autoload.php';
} else {
    throw new Exception('Unable to load Composer autoloader');
}

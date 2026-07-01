<?php

namespace SimpleSaml\Command;

use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use SimpleSaml\SimpleSamlPhpConfig;

class SimpleSamlInstallCommand extends \App\Command\BaseCommand
{
    public static function defaultName(): string
    {
        return 'simple_saml install';
    }

    public function execute(Arguments $args, ConsoleIo $io): ?int
    {
        if ($this->recurseCopy(dirname(dirname(dirname(__FILE__))) . '/simplesamlphp-2.5.2/public', WWW_ROOT . '/simplesaml')) {
            $certificatConf = SimpleSamlPhpConfig::getCertificat();
            if (strlen($certificatConf['crt']) && strlen($certificatConf['pem'])) {
                $certPath = 'plugins/SimpleSaml/simplesamlphp-2.5.2/cert';
                if (!file_exists($certPath)) {
                    mkdir($certPath);
                }
                file_put_contents($certPath . '/saml.crt', $certificatConf['crt']);
                file_put_contents($certPath . '/saml.pem', $certificatConf['pem']);
            }
            $file = file_get_contents("webroot/simplesaml/_include.php");
            $file = str_replace(
                "require_once(dirname(__FILE__, 2) . '/src/_autoload.php');",
                "require_once(dirname(__FILE__, 3) . '/plugins/SimpleSaml/simplesamlphp-2.5.2/src/_autoload.php');",
                $file
            );
            file_put_contents("webroot/simplesaml/_include.php", $file);
            $io->success('Successfully installed !');

            return static::CODE_SUCCESS;
        }

        $io->error('Oops: Something went wrong !');

        return static::CODE_ERROR;
    }

    private function recurseCopy(string $src, string $dst): bool
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);

        return true;
    }
}

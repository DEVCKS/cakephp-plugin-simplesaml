<?php

namespace SimpleSaml\Shell;

use Cake\Console\Shell;
use SimpleSaml\SimpleSamlPhpConfig;

/*
use App\EndPoint;
return EndPoint::response($this, $res);
*/
class SimpleSamlInstallShell extends Shell
{
    /**
     * @return void
     */
    public function install(): void
    {
        if ($this->recurseCopy(dirname(dirname(dirname(__FILE__))).'/simplesamlphp-2.0/public', WWW_ROOT.'/simplesaml')) {
            $certificatConf = SimpleSamlPhpConfig::getCertificat();
            if (strlen($certificatConf['crt']) && strlen($certificatConf['pem'])) {
                $certPath = 'plugins/SimpleSaml/simplesamlphp-2.0/cert';
                mkdir($certPath);
                file_put_contents($certPath.'/saml.crt', $certificatConf['crt']);
                file_put_contents($certPath.'/saml.pem', $certificatConf['pem']);
            }           
            $this->info('Successfully installed !');
            return;
        }

        $this->info('Oops: Something went wrong !');
    }

    private function recurseCopy($src, $dst): bool
    {
        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 

        return true;
    }
}

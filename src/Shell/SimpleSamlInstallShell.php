<?php

namespace SimpleSaml\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use SimpleSaml\SimpleSamlPhpConfig;

/*
use App\EndPoint;
return EndPoint::response($this, $res);
*/
class SimpleSamlInstallShell extends Shell
{
    /**
     * @param string $confKey = 'SimpleSamlConf'
     * @return void
     */
    public function install(string $confKey = 'SimpleSamlConf'): void
    {
        if ($this->recurseCopy(dirname(dirname(dirname(__FILE__))).'/simplesamlphp-1.18.7/www', WWW_ROOT.'/simplesaml')) {
            if (!is_null($confKey)) {
                $this->update_configuration($confKey);
            }

            $this->info('Successfully installed !');
            return;
        }

        $this->info('Oops: Something went wrong !');
    }

    /**
     * @param string $confKey = 'SimpleSamlConf'
     * @return void
     */
    public function update_configuration(string $confKey = 'SimpleSamlConf'): void
    {
        $conf = Configure::read($confKey);
        if (is_null($conf)) {
            $this->abort('Unknown confKey: '.$confKey);
        }

        try {   
            SimpleSamlPhpConfig::setConfig($conf);
        } catch (\Exception $e) {
            $this->abort($e->getMessage());
        }
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

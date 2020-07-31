<?php

namespace SimpleSaml\Shell;

use Cake\Console\Shell;

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
        if ($this->recurseCopy(dirname(dirname(dirname(__FILE__))).'/simplesamlphp-1.18.7/www', WWW_ROOT.'/simplesaml')) {
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

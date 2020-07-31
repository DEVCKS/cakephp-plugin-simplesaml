# SimpleSaml plugin for CakePHP

The purpose of this plugin is to help integrate [simplesamlphp](https://simplesamlphp.org/) a SAMLv2 helper to a cakephp project. 
This repo is not publish as a composer package for several reasons : 

- simplesamlphp as a built-in web app to administrate your different federation services. It is **not recommanded** to access *vendor folder* from outside the server.
- simplesamlphp needs configuration rewriting and certificate storage inside its folders. So again, changing and adding some files to the core library are required. Of course it is **not recommanded** to do this in *vendor folder*. 

Thus, the installation has to be manual using this repository as [cakephp documentation](https://book.cakephp.org/3/en/plugins.html#manually-installing-a-plugin) indicates. The next section will you give you some guide lines to automate it.

------------------------

## Installation

### Recommanded manual plugins installation setup

*Note: you can jump to next section if you already have your own way to manage your manual plugins installation.*

To automate your manual plugin installation we recommanded the following setup :

- In your app.default.php add a new env variable as array with all your manual plugins in it. With this configuration you will be able to manage your plugin installation for each environment. Example :
```php
'Plugins' => [
    'simpleSaml' => filter_var(env('SIMPLE_SAML_PLUGIN', false), FILTER_VALIDATE_BOOLEAN)
]
``` 
- Add a shell to your application responsible for all your manual plugin installation. Example : 
```php
<?php
namespace App\Shell;

use Cake\Core\Configure;
use SimpleSaml\Shell\SimpleSamlInstallShell;

class PluginsShell extends BaseShell
{
    public function install(): void
    {
        $this->info('Start plugins installation...');
        $availablePlugins = Configure::read('Plugins');
        
        foreach ($availablePlugins as $pluginLabel => $plugin) {
            if ($plugin) {
                switch ($pluginLabel) {
                    case 'simpleSaml':
                        $this->info('Installing SimpleSaml plugin...');
                        shell_exec('git clone https://github.com/DEVCKS/cakephp-plugin-simplesaml.git plugins/SimpleSaml');
                        (new SimpleSamlInstallShell())->install();
                    break;
                }
            }
        }

        $this->info('Plugins installation end.');
    }
}
```
- In your src/Application.php and config/routes.php add the following to load the plugins:
```php
/////////////////////Application.php////////////////////////
public function bootstrap()
{
    parent::bootstrap();
    
    if (Configure::read('Plugins')['simpleSaml'] && file_exists(ROOT.'/plugins/SimpleSaml')) {
        $this->addPlugin('SimpleSaml', ['console' => true]);
    }   
}

/////////////////////routes.php////////////////////////
if (Configure::read('Plugins')['simpleSaml'] && file_exists(ROOT.'/plugins/SimpleSaml')) {
    Router::scope('/simple-saml', function (RouteBuilder $routes) {
        $routes->loadPlugin('SimpleSaml');
    });
}
```

### Plugin installation

As mentionned above to properly work this plugin as its own web app which has to be accessible from the web (tokens exchange, redirection etc...)

To accomplish this you have to add an exception in your webroot/.htaccess file. Add this line: "RewriteCond %{REQUEST_URI} !^/(webroot/)?(simplesaml)/(.*)$". If you want to learn more about cakephp url rewriting follow this link [cakephp doc url rewriting](https://book.cakephp.org/3/en/installation.html#url-rewriting). Now you'll be able to access simplesaml administration from **yourdomainname/simplesaml**

*Note: it is very important to respect the simplesaml route. Don't try to change it.*

To help you install the plugin you'll find a Shell in the src/Shell directory: SimpleSamlInstallShell.php. Basically this shell copy the web part inside your webroot in the directory you allowed access previously in your .htaccess file.

You can change SimpleSAMLPhp default configuration by creating a config file simplesaml.php app/config/plugins/simplesaml.php. You can override this path in your plugins_root_path/src/SimpleSamlPhpConfig.php. An example of conf file :

```php
<?php

return [
    'config' => [
        'auth.adminpassword' => getenv('SIMPLE_SAML_PASSWORD') === false ? 'admin' : getenv('SIMPLE_SAML_PASSWORD'),
        'admin.protectindexpage' => true,
        'admin.protectmetadata' => true,
    ],
    'authsources' => [],
    'acl' => []
];
```


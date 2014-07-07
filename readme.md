## Laravel Bukkit SwiftAPI
Wraps the Apache Thrift generated PHP library for SwiftAPI in a Laravel Package and provides easy access trough a Facade. 

SwiftAPI is a Bukkit plugin that allows you to use the generated API to make simple calls to the Bukkit server over the webz. Or if wanted, you can generate it yourself using Apache Thrift. This makes SwiftAPI usable in almost any programming language.

### Version 0.1.0 Pre-Alpha

##### Requirements
- PHP > 5.3 
- Laravel > 4.0


##### Installation
Require with composer:
`
composer require radic/bukkit-swift-api
`

Register service provder and facade in app/config/app.php
```php
'providers' => array(
    // ..
    'Radic\BukkitSwiftApi\BukkitSwiftApiServiceProvider',
),
'aliases' => array(
    // ..
    'SwiftApi'               => 'Radic\BukkitSwiftApi\Facades\SwiftApi',
)
```

##### Configuration
Use `php artisan config:publish radic\bukkit-swift-api` to edit the default configuration.

```php
array(
    'global' => [
        'host' => 'localhost',
        'port' => 21111,
        'username' => 'admin',
        'password' => 'test',
        'salt' => 'saltines'
    ]
);
```

##### Connecting
```php
$api = SwiftAPI::connect(); // Uses config settings
$api = SwiftAPI::connect('ip-or-host', 4444, 'username', 'password', 'crypt-salt'); 
if($api->isConnected())
{
    // Do stuff
    $onlinePlayers = $api->getOnlinePlayers();    
    // Always disconnect
    $api->disconnect();
}
```
##### Remote API Call methods
If there is a response for a method, it usually returns a data type class.
The structures of all data types are described in the [SwiftAPI Thrift Documentation](http://willwarren.com/docs/swiftapi/latest/) 
```php
$api->announce('Message');
$api->deOp('Playername', $boolNotifyPlayer);
$api->getBukkitVersion();
$api->getConsoleMessages($since = 0);
$api->getFileContents($fileName);
$players = $api->getPlayers();
$player = $api->getPlayer('Playername');
// etc
```
For the complete list of available API methods check out [SwiftAPI Thrift Documentation](http://willwarren.com/docs/swiftapi/latest/) or check the Radic\BukkitSwiftApi\SwiftApi class

##### Further reading
[Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi). The SwiftAPI Website.
[SwiftAPI Thrift Documentation](http://willwarren.com/docs/swiftapi/latest/). The docs for SwiftAPI generated Thrift code.
[Bukkit SwiftAPI Reposiotry](https://bitbucket.org/phybros/swiftapi). Repository for the SwiftApi Bukkit Java plugin.

##### Examples and goodies
Check my [Laravel Bukkit Console](http://dev.bukkit.org/profiles/phybros). A web based console to directly interact with your Bukkit Server.

### Credits
[Robin Radic](https://github.com/RobinRadic) created [Laravel Bukkit SwiftApi](https://github.com/RobinRadic/laravel-bukkit-swiftapi)
[Phybros](http://dev.bukkit.org/profiles/phybros) created [Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi)

### License
GNU General Public License version 3 (GPLv3)
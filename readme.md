## Laravel Bukkit SwiftAPI
Wraps the Apache Thrift generated PHP library for SwiftAPI in a Laravel Package.

SwiftAPI is a Bukkit plugin that allows you to use the generated API to make simple calls to the Bukkit server over the webz.
SwiftAPI is created and maintained by [Phybros](http://dev.bukkit.org/profiles/phybros). Check out the [Bukkit SwiftAPI Plugin Page](http://dev.bukkit.org/bukkit-plugins/swiftapi) for more information.

### Version 0.1.0 Pre-Alpha

##### Requirements
- Laravel 4.*
- Nothing else


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
If there is a response for a method, it usually returns a type class, defined in org\phybros\thrift\Types. Use var_dump() to tjek it out.. 
```php
$api->announce('Message');
$api->deOp('Playername', $boolNotifyPlayer);
$api->getBukkitVersion();
$api->getConsoleMessages();
$api->getFileContents();
$api->getOfflinePlayer();
$api->getOfflinePlayers();
$api->ping();
$api->getOps();
$players = $api->getPlayers();
$player = $api->getPlayer('Playername'); // returns org\phybros\thrift\Player 
```

##### More
[Laravel Bukkit Console](http://dev.bukkit.org/profiles/phybros). Uses the SwiftAPI and some fancy JS to create a console to directly interact with your Bukkit Server.

### Credits
[Phybros](http://dev.bukkit.org/profiles/phybros) created [Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi)

### License
GNU General Public License version 3 (GPLv3)
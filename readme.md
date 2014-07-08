## Laravel Bukkit SwiftAPI
Wraps the Apache Thrift generated PHP library for SwiftAPI in a Laravel Package and provides easy access trough a Facade. 

SwiftAPI is a Bukkit plugin that allows you to use the generated API to make simple calls to the Bukkit server over the webz. Or if wanted, you can generate it yourself using Apache Thrift. This makes SwiftAPI usable in almost any programming language.

### Version 0.3.0 Beta
[View changelog and todo](https://github.com/RobinRadic/laravel-bukkit-swiftapi/blob/master/changelog.md)

##### Requirements
- PHP > 5.3 
- Laravel > 4.0


##### Installation
Require with composer:
```Batchfile
composer require radic/bukkit-swift-api
```

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
Use `php artisan config:publish radic/bukkit-swift-api` to edit the default configuration.

```php
array(
    'global' => array(
        'host' => 'localhost',
        'port' => 21111,
        'username' => 'admin',
        'password' => 'test',
        'salt' => 'saltines'
    ),
    'my-other-server' => array(
        'host' => '11.11.11.11',        
        'username' => 'admin',
        'password' => 'test'
        // If you left out config settings, it will use the global for that setting        
    )
);
```

##### Connecting
There are several ways to connect:
```php
// Uses global config settings
$api = SwiftAPI::connect(); 
// Define all connection parameters inline
$api = SwiftAPI::connect('ip-or-host', 4444, 'username', 'password', 'crypt-salt');
// null or left out parameters will default back to the global config
$api = SwiftAPI::connect('ip-or-host', null, 'username', 'password');
// Uses 'my-other-server' from conffig.
$api = SwiftAPI::connectTo('my-other-server');   
```

Example connection:
```php
$api = SwiftApi::connect();
if($api->isConnected())
{
    var_dump('Connected');
    $serverInfo = $api->getServer();
    $api->disconnect();
    var_dump($serverInfo);
}
else
{
    var_dump( $api->getConnectionException()->getMessage() );
}
```
##### Remote API Call methods
If there is a response for a method, it usually returns a data type class.
The structures of all data types are described in the [SwiftAPI Thrift Documentation](http://willwarren.com/docs/swiftapi/latest/) 
```php
$api->addToWhitelist($name);
$api->announce($message);
$api->ban($name);
$api->banIp($ip);
$api->deOp($name, $notifyPlayer);
$api->getBannedIps();
$api->getBannedPlayers();
$api->getBukkitVersion();
$api->getConsoleMessages($since);
$api->getFileContents($fileName);
$api->getOfflinePlayer($name);
$api->getOfflinePlayers();
$api->getOps();
$api->getPlayer($name);
$api->getPlayers();
$api->getPlugin($name);
$api->getPlugins();
$api->getServer();
$api->getServerVersion();
$api->getWhitelist();
$api->getWorld($worldName);
$api->getWorlds();
$api->installPlugin($downloadUrl, $md5);
$api->kick($name, $message);
$api->op($name, $notifyPlayer);
$api->ping();
$api->reloadServer();
$api->removeFromWhitelist($name);
$api->replacePlugin($pluginName, $downloadUrl, $md5);
$api->runConsoleCommand($command);
$api->saveWorld($worldName);
$api->setFileContents($fileName, $fileContents);
$api->setGameMode($name, $mode);
$api->setPvp($worldName, $isPvp);
$api->setStorm($worldName, $hasStorm);
$api->setThundering($worldName, $isThundering);
$api->setWorldTime($worldName, $time);
$api->unBan($name);
$api->unBanIp($ip);
// etc
```

##### Example output
When requesting this info
```php
$api = SwiftApi::connect();
if($api->isConnected())
{
    var_dump('Connected');
    $calls = [];
    $calls[] = $api->getServer();
    $calls[] = $api->getPlugins();
    $calls[] = $api->getOfflinePlayers();
    $calls[] = $api->ping();
    $calls[] = $api->getOps();
    $api->disconnect();
    var_dump($calls);
}
else
{
    var_dump( $api->getConnectionError() );
}
```
[You'll get something like this in return](https://github.com/RobinRadic/laravel-bukkit-swiftapi/blob/master/example-output.html)

##### Further reading
- [Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi). The SwiftAPI Website.
- [SwiftAPI Thrift Documentation](http://willwarren.com/docs/swiftapi/latest/). The docs for SwiftAPI generated Thrift code.
- [Bukkit SwiftAPI Reposiotry](https://bitbucket.org/phybros/swiftapi). Repository for the SwiftApi Bukkit Java plugin.

##### Examples and goodies
Check my [Laravel Bukkit Console](https://github.com/RobinRadic/laravel-bukkit-console). A web based console to directly interact with your Bukkit Server.

### Credits
- [Robin Radic](https://github.com/RobinRadic) created [Laravel Bukkit SwiftApi](https://github.com/RobinRadic/laravel-bukkit-swiftapi)
- [Phybros](http://dev.bukkit.org/profiles/phybros) created [Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi)

### License
GNU General Public License version 3 (GPLv3)
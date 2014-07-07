## Laravel Bukkit SwiftAPI
Version 0.1.0

A Laravel package that wraps the Apache Thrift generated PHP library for SwiftAPI.

SwiftAPI is a Bukkit plugin that allows you to use the generated API to make simple calls to the Bukkit server over the webz.
SwiftAPI is created and maintained by [Phybros](http://dev.bukkit.org/profiles/phybros). Check out the [Bukkit SwiftAPI Plugin Page](http://dev.bukkit.org/bukkit-plugins/swiftapi) for more information.

### Documentation
Comming soon. Check code for now.

##### Installation
Require with compooser:
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
##### Basic usage

###### Connecting
```php
$api = SwiftAPI::connect(); // Uses config settings
$api = SwiftAPI::connect('ip-or-hostname', 123123, 'username', 'password', 'password-encrypot-salt'); 
if($api->isConnected())
{
    // Do stuff
    $onlinePlayers = $api->getOnlinePlayers();
    // And disconnect
    $api->disconnect();
}
```
###### Remote API Call methods
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
##### SwiftApi methods
You can probably ignore this..
```php
$api->setClient();
$api->getProtocol();
$api->setProtocol();
$api->getSocket();
$api->setSocket();
$api->getTransport();
$api->setTransport();
```
##### Installation
..

##### Might also be interesting
[Laravel Bukkit Console](http://dev.bukkit.org/profiles/phybros). Uses the SwiftAPI and some fancy JS to create a console to directly interact with your Bukkit Server.

### Third Party Credits
[Phybros](http://dev.bukkit.org/profiles/phybros): [Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi)

### License
GNU General Public License version 3 (GPLv3)
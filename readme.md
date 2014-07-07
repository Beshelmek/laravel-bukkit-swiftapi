## Laravel Bukkit SwiftAPI
Version 0.1.0

A Laravel package that wraps the Apache Thrift generated PHP library for SwiftAPI.

SwiftAPI is a Bukkit plugin that allows you to use the generated API to make simple calls to the Bukkit server over the webz.
SwiftAPI is created and maintained by [Phybros](http://dev.bukkit.org/profiles/phybros). Check out the [Bukkit SwiftAPI Plugin Page](http://dev.bukkit.org/bukkit-plugins/swiftapi) for more information.

### Documentation
Comming soon. Check code for now.

##### Installation
`
composer require radic/bukkit-swift-api
`

##### Basic usage

###### Connecting
`
$api = SwiftAPI::connect(); // Uses config settings
$api = SwiftAPI::connect('ip-or-hostname', 123123, 'username', 'password', 'password-encrypot-salt'); 
if($api->isConnected())
{
    // Do stuff
    $onlinePlayers = $api->getOnlinePlayers();
    // And disconnect
    $api->disconnect();
}
`
###### Methods 
`
$api->announce('Message');

$api->deOp('Playername', $boolNotifyPlayer); \n
$api->getBukkitVersion();
$api->getConsoleMessages();
$api->getFileContents();
$api->getOfflinePlayer();
$api->getOfflinePlayers();
$api->ping();
$api->getOps();
$players = $api->getPlayers();
$player = $api->getPlayer('Playername'); // returns instance of org\phybros\thrift\Player

`

##### Installation
..

##### Installation
..

##### Might also be interesting
[Laravel Bukkit Console](http://dev.bukkit.org/profiles/phybros). Uses the SwiftAPI and some fancy JS to create a console to directly interact with your Bukkit Server.

### Third Party Credits
[Phybros](http://dev.bukkit.org/profiles/phybros): [Bukkit SwiftAPI](http://dev.bukkit.org/bukkit-plugins/swiftapi)

### License
GNU General Public License version 3 (GPLv3)
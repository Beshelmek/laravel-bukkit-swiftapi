<?php namespace Radic\BukkitSwiftApi;

use BadMethodCallException;
use Config;
use Exception;
use org\phybros\thrift\SwiftApiClient;
use org\phybros\thrift\SwiftApiIf;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TSocket;

/**
 * Class SwiftApi
 * @author Robin Radic
 * @license GNU General Public License version 3 (GPLv3)
 * @package Radic\BukkitSwiftApi
 *
 * @method addToWhitelist(string $name);
 * @method announce(string $message);
 * @method ban(string $name);
 * @method banIp(string $ip);
 * @method deOp(string $name, bool $notifyPlayer);
 * @method mixed getBannedIps();
 * @method mixed getBannedPlayers();
 * @method mixed getBukkitVersion();
 * @method mixed getConsoleMessages(int $since);
 * @method mixed getFileContents(string $fileName);
 * @method mixed getOfflinePlayer(string $name);
 * @method mixed getOfflinePlayers();
 * @method mixed getOps();
 * @method mixed getPlayer(string $name);
 * @method mixed getPlayers();
 * @method mixed getPlugin(string $name);
 * @method mixed getPlugins();
 * @method mixed getServer();
 * @method mixed getServerVersion();
 * @method mixed getWhitelist();
 * @method mixed getWorld(string $worldName);
 * @method mixed getWorlds();
 * @method installPlugin(string $downloadUrl, string $md5);
 * @method kick(string $name, string $message);
 * @method op(string $name, bool $notifyPlayer);
 * @method int ping();
 * @method reloadServer();
 * @method removeFromWhitelist(string $name);
 * @method replacePlugin(string $pluginName, string $downloadUrl, string $md5);
 * @method runConsoleCommand(string $command);
 * @method saveWorld(string $worldName);
 * @method setFileContents(string $fileName, string $fileContents);
 * @method setGameMode(string $name, int $mode);
 * @method setPvp(string $worldName, bool $isPvp);
 * @method setStorm(string $worldName, bool $hasStorm);
 * @method setThundering(string $worldName, bool $isThundering);
 * @method setWorldTime(string $worldName, int $time);
 * @method unBan(string $name);
 * @method unBanIp(string $ip);
 */
class SwiftApi
{
    /**
     * @var \Thrift\Transport\TSocket
     */
    protected $socket;
    /**
     * @var \Thrift\Transport\TFramedTransport
     */
    protected $transport;
    /**
     * @var \Thrift\Protocol\TBinaryProtocol
     */
    protected $protocol;
    /**
     * @var \org\phybros\thrift\SwiftApiClient
     */
    protected $client;
    /**
     * @var Exception
     */
    protected $connectionException;
    /**
     * @var string
     */
    protected $host;
    /**
     * @var int
     */
    protected $port;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $salt;

    /**
     * Connect to a Bukkit server
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param string $salt
     * @return SwiftApi
     */
    public function connect($host = null, $port = null, $username = null, $password = null, $salt = null)
    {
        if (!$this->isConnected())
        {
            $this->host = is_null($host) ? Config::get('radic/bukkit-swift-api::global.host') : $host;
            $this->port = is_null($port) ? Config::get('radic/bukkit-swift-api::global.port') : $port;
            $this->username = is_null($username) ? Config::get('radic/bukkit-swift-api::global.username') : $username;
            $this->password = is_null($password) ? Config::get('radic/bukkit-swift-api::global.password') : $password;
            $this->salt = is_null($salt) ? Config::get('radic/bukkit-swift-api::global.salt') : $salt;
            $this->connectionError = null;
            try
            {
                $this->socket = new TSocket($this->host, $this->port);
                $this->socket->setRecvTimeout(10000);
                $this->transport = new TFramedTransport($this->socket);
                $this->protocol = new TBinaryProtocol($this->transport);
                $this->client = new SwiftApiClient($this->protocol, $this->protocol);
                $this->transport->open();
            } catch (Exception $e)
            {
                $this->connectionException = $e;
                # @todo change this
                # die(var_dump($e));
            }
        }

        return $this;
    }

    /**
     * Connect to a Bukkit server defined in the configuration
     * @param string $server
     */
    public function connectTo($server)
    {
        $c = Config::get('radic/bukkit-swift-api::' . $server);
        if (isset($c) && is_array($c) && !empty($c))
        {
            $this->connect(@$c['host'], @$c['port'], @$c['password'], @$c['username'], @$c['salt']);
        }
    }

    /**
     * @return Exception
     */
    public function getConnectionException()
    {
        if (isset($this->connectionException) && $this->connectionException instanceof Exception)
        {
            return $this->connectionException;
        }
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        if (!isset($this->client) || !isset($this->transport))
        {
            return false;
        }

        return $this->transport->isOpen();
    }

    /**
     * Disconnects the api client.
     */
    public function disconnect()
    {
        if ($this->isConnected())
        {
            $this->transport->close();
        }
    }

    /**
     * @param $methodName
     * @return string
     */
    protected function getAuthString($methodName)
    {
        $toHash = $this->username . $methodName . $this->password . $this->salt;

        return hash("sha256", $toHash);
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->client, $name))
        {
            array_unshift($arguments, $this->getAuthString($name)); // add to front of array
            return call_user_func_array(array($this->client, $name), $arguments);
        }
        else
        {
            throw new BadMethodCallException("Method does not exist in SwiftApi");
        }
    }

    /**
     * @return org\phybros\thrift\SwiftApiClient
     */
    public function getClient()
    {
        if (!isset($this->client))
        {
            $this->connect();
        }

        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient(SwiftApiIf $client)
    {
        $this->client = $client;
    }

    /**
     * @return \Thrift\Protocol\TProtocol
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return mixed
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @param mixed $socket
     */
    public function setSocket($socket)
    {
        $this->socket = $socket;
    }

    /**
     * @return mixed
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param mixed $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }
}

<?php namespace Radic\Bukkit;

use Config;
use Exception;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TSocket;

use org\phybros\thrift\SwiftApiClient;
class Api
{
    protected $socket;
    protected $transport;
    protected $protocol;
    protected $client;

    public function disconnect()
    {
        if ($this->isConnected())
        {
            $this->transport->close();
        }
    }

    public function isConnected()
    {
        if (!isset($this->client) || !isset($this->transport))
        {
            return false;
        }

        return $this->transport->isOpen();
    }

    public function announce($message)
    {
        return $this->client->announce($this->getAuthString('announce'), $message);
    }

    protected function getAuthString($methodName)
    {
        $username = Config::get('radic/bukkit::api.username');
        $password = Config::get('radic/bukkit::api.password');
        $salt = Config::get('radic/bukkit::api.salt');
        $toHash = $username . $methodName . $password . $salt;

        return hash("sha256", $toHash);
    }

    public function deOp($playerName, $notify)
    {
        return $this->client->deOp($this->getAuthString('deOp'), $playerName, $notify);
    }

    public function getBukkitVersion()
    {
        return $this->client->getBukkitVersion($this->getAuthString('getBukkitVersion'));
    }

    public function getConsoleMessages($since = 0)
    {
        return $this->client->getConsoleMessages($this->getAuthString('getConsoleMessages'), $since);
    }

    public function getFileContents($fileName)
    {
        return $this->client->getFileContents($this->getAuthString('getFileContents'), $fileName);
    }

    public function getOfflinePlayer($playerName)
    {
        return $this->client->getOfflinePlayer($this->getAuthString('getOfflinePlayer'), $playerName);
    }

    public function getOfflinePlayers()
    {
        return $this->client->getOfflinePlayers($this->getAuthString('getOfflinePlayers'));
    }

    public function ping()
    {
        return $this->client->ping($this->getAuthString('ping'));
    }

    public function getOps()
    {
        return $this->client->getOps($this->getAuthString('getOps'));
    }

    public function getPlayers()
    {
        return $this->client->getPlayers($this->getAuthString('getPlayers'));
    }

    public function getPlayer($name)
    {
        return $this->client->getPlayer($this->getAuthString('getPlayer'), $name);

    }

    public function getPlugins()
    {
        return $this->client->getPlugins($this->getAuthString('getPlugins'));
    }

    public function getServer()
    {
        return $this->client->getServer($this->getAuthString('getServer'));
    }

    public function getServerVersion()
    {
        return $this->client->getServerVersion($this->getAuthString('getServerVersion'));
    }

    public function installPlugin($downloadUrl, $md5)
    {
        return $this->client->installPlugin($this->getAuthString('installPlugin'), $downloadUrl, $md5);
    }

    public function op($playerName, $notify)
    {
        return $this->client->op($this->getAuthString('op'), $playerName, $notify);
    }

    public function reloadServer()
    {
        return $this->client->reloadServer($this->getAuthString('reloadServer'));
    }

    public function runConsoleCommand($command)
    {
        return $this->client->runConsoleCommand($this->getAuthString('runConsoleCommand'), $command);
    }

    public function setFileContents($fileName, $fileContents)
    {
        return $this->client->setFileContents($this->getAuthString('setFileContents'), $fileName, $fileContents);
    }

    public function setWorldTime($worldName, $time)
    {
        return $this->client->setWorldTime($this->getAuthString('setWorldTime'), $worldName, $time);
    }

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
    public function setClient($client)
    {
        $this->client = $client;
    }

    public function connect()
    {
        if (!$this->isConnected())
        {
            try
            {
                $this->socket = new TSocket(Config::get('radic/bukkit::api.host'), Config::get('radic/bukkit::api.port'));
                $this->socket->setRecvTimeout(10000);
                $this->transport = new TFramedTransport($this->socket);
                $this->protocol = new TBinaryProtocol($this->transport);
                $this->client = new SwiftApiClient($this->protocol, $this->protocol);
                $this->transport->open();
            } catch (Exception $e)
            {
                # @todo change this
                die(var_dump($e));
            }
        }
    }

    /**
     * @return mixed
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

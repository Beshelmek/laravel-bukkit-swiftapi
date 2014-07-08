<?php namespace Radic\BukkitSwiftApi;

use Config;
use Exception;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TFramedTransport;
use Thrift\Transport\TSocket;

use org\phybros\thrift\SwiftApiClient;

use BadMethodCallException;

class SwiftApi
{
    protected $socket;
    protected $transport;
    protected $protocol;
    protected $client;
    protected $connectionException;

    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $salt;




    public function connect($host = null, $port = null, $username = null, $password = null, $salt = null)
    {

        if (!$this->isConnected())
        {
            $this->host       = is_null($host) ? Config::get('radic/bukkit-swift-api::global.host') : $host;
            $this->port       = is_null($port) ? Config::get('radic/bukkit-swift-api::global.port') : $port;
            $this->username   = is_null($username) ? Config::get('radic/bukkit-swift-api::global.username') : $username;
            $this->password   = is_null($password) ? Config::get('radic/bukkit-swift-api::global.password') : $password;
            $this->salt       = is_null($salt) ? Config::get('radic/bukkit-swift-api::global.salt') : $salt;

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

    public function connectTo($server)
    {
        $c = Config::get('radic/bukkit-swift-api::' . $server);
        if(isset($c) && is_array($c) && !empty($c))
        {
            $this->connect(@$c['host'], @$c['port'], @$c['password'], @$c['username'], @$c['salt']);
        }
    }

    public function getConnectionException()
    {
        if(isset($this->connectionException) && $this->connectionException instanceof Exception)
        {
            return $this->connectionException;
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

    public function disconnect()
    {
        if ($this->isConnected())
        {
            $this->transport->close();
        }
    }

    protected function getAuthString($methodName)
    {
        $toHash = $this->username . $methodName . $this->password . $this->salt;

        return hash("sha256", $toHash);
    }

    public function __call($name, $arguments)
    {
        if(method_exists($this->client, $name))
        {
            array_unshift($arguments, $this->getAuthString($name)); // add to front of array
            return call_user_func_array(array($this->client, $name), $arguments);

        }
        else
        {
            throw new BadMethodCallException("Method does not exist in SwiftApi");
        }
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

<?php namespace Radic\BukkitSwiftApi;


$THRIFT_ROOT = dirname(__FILE__);
require_once $THRIFT_ROOT . '/Thrift/ClassLoader/ThriftClassLoader.php';
use Radic\BukkitSwiftapi\SwiftApi;
use Thrift\ClassLoader\ThriftClassLoader;

use Thrift\Transport\TSocket;
use Thrift\Transport\TFramedTransport;
use Thrift\Protocol\TBinaryProtocol;



use Illuminate\Support\ServiceProvider;

class BukkitSwiftApiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerApi();
	}


    protected  function registerApi()
    {
        $THRIFT_ROOT = dirname(__FILE__);

        $loader = new ThriftClassLoader();
        $loader->registerNamespace('Thrift', $THRIFT_ROOT);
        $loader->registerDefinition('Thrift', $THRIFT_ROOT . '/packages');
        $loader->register();

        require_once $THRIFT_ROOT . '/Thrift/packages/org/phybros/thrift/SwiftApi.php';
        require_once $THRIFT_ROOT . '/Thrift/packages/org/phybros/thrift/Types.php';


        $this->app['Radic\Bukkit\SwiftApi'] = $this->app->share(function ()
        {
            return new SwiftApi();
        });
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('Radic\Bukkit\SwiftApi');
	}

    public function boot()
    {
        $this->package('radic/bukkit-swift-api', 'radic/bukkit-swift-api');
    }

}

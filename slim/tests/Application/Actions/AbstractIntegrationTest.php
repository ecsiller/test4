<?php

namespace Tests\Application\Actions;

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Exception;
use GuzzleHttp\Client;
use PDO;
use Psr\Container\ContainerInterface;
use Selective\TestTrait\Traits\ArrayTestTrait;
use Selective\TestTrait\Traits\DatabaseTestTrait;
use Selective\TestTrait\Traits\HttpJsonTestTrait;
use Selective\TestTrait\Traits\HttpTestTrait;
use Selective\TestTrait\Traits\RouteTestTrait;
use Slim\App;
use Slim\Factory\AppFactory;
use Tests\TestCase;
use UnexpectedValueException;

abstract class AbstractIntegrationTest extends TestCase
{
    use DatabaseTestTrait;
    use HttpJsonTestTrait;
    use HttpTestTrait;
    use RouteTestTrait;
    use ArrayTestTrait;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var App
     */
    protected $app;

    /** @var Client */
    protected $client;

    /**
     * Bootstrap app.
     *
     * @return void
     * @throws UnexpectedValueException
     *
     */
    protected function setUp(): void
    {
        $this->app = $this->getAppInstance();

        $container = $this->app->getContainer();
        if ($container === null) {
            throw new UnexpectedValueException('Container must be initialized');
        }

        $this->container = $container;
        $this->client = new Client(['base_uri' => 'http://nginx']);
        $this->setUpDatabase(__DIR__ . '/../../db/muz.sql');
    }

    /**
     * Get database connection.
     *
     * @return \PDO The PDO instance
     */
    protected function getConnection(): PDO
    {
        $settings = $this->container->get(SettingsInterface::class);
        $dbSettings = $settings->get('doctrine')['connection'];
        $host = $dbSettings['host'];
        $dbname = $dbSettings['dbname'];
        $username = $dbSettings['user'];
        $password = $dbSettings['password'];
        $charset = $dbSettings['charset'];
        $flags = $dbSettings['flags'];
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";


        return new PDO($dsn, $username, $password, $flags);
    }

    /**
     * Clean up database.
     *
     * @return void
     */
    protected function truncateTables(): void
    {
    }

    /**
     * @return App
     * @throws Exception
     */
    protected function getAppInstance(): App
    {
        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        // Container intentionally not compiled for tests.

        // Set up settings
        $settings = require __DIR__ . '/../../../app/settings.php';
        $settings($containerBuilder);

        // Set up dependencies
        $dependencies = require __DIR__ . '/../../../app/dependencies.php';
        $dependencies($containerBuilder);

        // Build PHP-DI Container instance
        $container = $containerBuilder->build();

        // Instantiate the app
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        // Register middleware
        $middleware = require __DIR__ . '/../../../app/middleware.php';
        $middleware($app);

        // Register routes
        $routes = require __DIR__ . '/../../../app/routes.php';
        $routes($app);

        return $app;
    }
}
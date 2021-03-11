<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            SettingsInterface::class => function () {
                return new Settings(
                    [
                        'displayErrorDetails' => true, // Should be set to false in production
                        'logError' => false,
                        'logErrorDetails' => false,
                        'logger' => [
                            'name' => 'slim-app',
                            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                            'level' => Logger::DEBUG,
                        ],
                        'images_dir' => __DIR__ . '/../public/images',
                        'doctrine' => [
                            // if true, metadata caching is forcefully disabled
                            'dev_mode' => true,

                            // path where the compiled metadata info will be cached
                            // make sure the path exists and it is writable
                            'cache_dir' => __DIR__ . '/../var/doctrine',

                            // you should add any other path containing annotated entity classes
                            'metadata_dirs' => [__DIR__ . '/../src/Domain'],

                            'connection' => [
                                'driver' => 'pdo_mysql',
                                'host' => 'db',
                                'port' => 3306,
                                'dbname' => 'muz',
                                'user' => 'root',
                                'password' => 'hello',
                                'charset' => 'utf8'
                            ]
                        ]
                    ]
                );
            }
        ]
    );
};
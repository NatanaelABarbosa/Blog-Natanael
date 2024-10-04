<?php

use DI\ContainerBuilder;
use League\Plates\Engine;
use Natanael\Blog\Connection\Connection;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    Engine::class => function () {
        $path = __DIR__ . "/../view/";
        return new Engine($path);
    },

    PDO::class => function () {
        return Connection::createConnection();
    }
]);

$container = $builder->build();

return $container;
<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require __DIR__ . '/bin/bootstrap.php';

return ConsoleRunner::createHelperSet($container->get(EntityManager::class));
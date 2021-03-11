<?php

declare(strict_types=1);

namespace App\Application\Repositories;

use Doctrine\ORM\EntityManager;

abstract class AbstractRepository
{
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $query
     * @param array $parameters
     *
     * @return array|null
     */
    protected function executeQuery(string $query, array $parameters = []): ?array
    {
        $statement = $this->em->getConnection()->prepare($query);
        $statement->execute($parameters);

        return $statement->fetchAll();
    }
}
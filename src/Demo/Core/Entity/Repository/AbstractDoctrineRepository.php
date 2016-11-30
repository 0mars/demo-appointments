<?php

namespace Demo\Core\Entity\Repository;

use Doctrine\ORM\EntityManager;

class AbstractDoctrineRepository
{
    /**
     * @var EntityManager
     */
    protected $objectManager;

    /**
     * @param EntityManager $objectManager
     */
    public function __construct(EntityManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
}

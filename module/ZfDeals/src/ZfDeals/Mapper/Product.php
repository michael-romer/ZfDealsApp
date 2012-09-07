<?php

namespace ZfDeals\Mapper;

use ZfDeals\Entity\Product as ProductEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class Product extends TableGateway
{
    protected $tableName  = 'product';
    protected $idCol = 'id';
    protected $entityPrototype = null;
    protected $hydrator = null;

    public function __construct($adapter)
    {
        parent::__construct($this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

        $this->entityPrototype = new ProductEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
    }

    public function insert($entity) {
        return parent::insert($this->hydrator->extract($entity));
    }
}

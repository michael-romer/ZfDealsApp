<?php

namespace ZfDeals\Mapper;

use ZfDeals\Entity\Order as OrderEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class Order extends TableGateway
{
    protected $tableName  = 'ordering';
    protected $idCol = 'orderId';
    protected $entityPrototype = null;
    protected $hydrator = null;

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter
        );

        $this->entityPrototype = new OrderEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
    }

    public function insert($entity)
    {
        return parent::insert($this->hydrator->extract($entity));
    }

    public function hydrate($results)
    {
        $deals = new \Zend\Db\ResultSet\HydratingResultSet(
            $this->hydrator,
            $this->entityPrototype
        );

        return $deals->initialize($results);
    }
}

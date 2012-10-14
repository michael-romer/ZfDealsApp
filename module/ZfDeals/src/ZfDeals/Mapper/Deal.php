<?php

namespace ZfDeals\Mapper;

use ZfDeals\Entity\Deal as DealEntity;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Insert;

class Deal extends TableGateway
{
    protected $tableName  = 'deal';
    protected $idCol = 'dealId';
    protected $entityPrototype = null;
    protected $hydrator = null;

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

        $this->entityPrototype = new DealEntity();
        $this->hydrator = new \Zend\Stdlib\Hydrator\Reflection;
    }

    public function insert($entity)
    {
        return parent::insert($this->hydrator->extract($entity));
    }

    public function findActiveDealById($id)
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
            ->from($this->tableName)
            ->join('product', 'deal.product=product.productId')
            ->where('DATE(startDate) <= DATE(NOW())')
            ->where('DATE(endDate) >= DATE(NOW())')
            ->where('stock > 0')
            ->where('deal.dealId = ' . $id);

        $stmt = $sql->prepareStatementForSqlObject($select);

        $results = $stmt->execute();
        $hydratingResults = $this->hydrate($results);

        if($hydratingResults->count() != 1)
            throw new \DomainException('Deal cannot be found');
        else
            return $hydratingResults->current();
    }

    public function findActiveDeals()
    {
        $sql = new \Zend\Db\Sql\Sql($this->getAdapter());
        $select = $sql->select()
            ->from($this->tableName)
            ->join('product', 'deal.product=product.productId')
            ->where('DATE(startDate) <= DATE(NOW())')
            ->where('DATE(endDate) >= DATE(NOW())')
            ->where('stock > 0');

        $stmt = $sql->prepareStatementForSqlObject($select);
        $results = $stmt->execute();
        return $this->hydrate($results);
    }

    public function findOneById($id)
    {
        return $this->hydrator->hydrate(
            $this->select(array('dealId' => $id))->current()->getArrayCopy(),
            new $this->entityPrototype()
        );
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

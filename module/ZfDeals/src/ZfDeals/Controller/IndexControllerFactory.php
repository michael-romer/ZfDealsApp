<?php
namespace ZfDeals\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new IndexController();
        $dealMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Deal');
        $ctr->setDealMapper($dealMapper);
        $productMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
        $ctr->setproductMapper($productMapper);
        return $ctr;
    }
}


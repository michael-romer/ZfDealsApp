<?php
namespace ZfDeals\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new AdminController();
        $productAddForm = new \ZfDeals\Form\ProductAdd();
        $productAddForm->setHydrator(new\Zend\Stdlib\Hydrator\Reflection());
        $productAddForm->bind(new \ZfDeals\Entity\Product());
        $ctr->setProductAddForm($productAddForm);
        $mapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
        $ctr->setProductMapper($mapper);
        $dealAddForm = new \ZfDeals\Form\DealAdd();
        $ctr->setDealAddForm($dealAddForm);
        $dealAddForm->setHydrator(new\Zend\Stdlib\Hydrator\Reflection());
        $dealAddForm->bind(new \ZfDeals\Entity\Deal());
        $dealMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Deal');
        $ctr->setDealMapper($dealMapper);
        return $ctr;
    }
}


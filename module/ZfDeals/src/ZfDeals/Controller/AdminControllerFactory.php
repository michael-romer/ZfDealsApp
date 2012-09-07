<?php
namespace ZfDeals\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $ctr = new AdminController();
        $form = new \ZfDeals\Form\ProductAdd();
        $form->setHydrator(new\Zend\Stdlib\Hydrator\Reflection());
        $form->bind(new \ZfDeals\Entity\Product());
        $ctr->setProductAddForm($form);
        $mapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
        $ctr->setProductMapper($mapper);
        return $ctr;
    }
}

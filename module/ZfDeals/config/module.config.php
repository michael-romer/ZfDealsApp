<?php
return array(
    'router' => array(
        'routes' => array(
            'zf-deals' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'zf-deals\checkout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/checkout',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\CheckoutForm'
                    ),
                ),
            ),
            'zf-deals\admin\home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/admin',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
            ),
            'zf-deals\admin\product\add' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/admin/product/add',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\ProductAddForm',
                    ),
                ),
            ),
            'zf-deals\admin\deal\add' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/admin/deal/add',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\DealAddForm',
                    ),
                ),
            ),
            'zf-deals\admin\orders\show' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/deals/admin/orders/show',
                    'defaults' => array(
                        'controller' => 'ZfDeals\Controller\Order',
                        'action' => 'show-all'
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'ZfDeals\Controller\Admin' => 'ZfDeals\Controller\AdminController',
        ),
        'factories' => array(
            'ZfDeals\Controller\CheckoutForm' => function ($serviceLocator) {
                $form = new \ZfDeals\Form\Checkout();
                $ctr = new ZfDeals\Controller\CheckoutFormController($form);
                $productMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
                $ctr->setProductMapper($productMapper);
                $validator = $serviceLocator->getServiceLocator()->get('ZfDeals\Validator\DealAvailable');
                $ctr->setdealActiveValidator($validator);
                $checkoutService = $serviceLocator->getServiceLocator()->get('ZfDeals\Service\Checkout');
                $ctr->setCheckoutService($checkoutService);
                return $ctr;
            },
            'ZfDeals\Controller\DealAddForm' => function ($serviceLocator) {
                $form = new ZfDeals\Form\DealAdd();
                $ctr = new ZfDeals\Controller\DealAddFormController($form);
                $dealMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Deal');
                $ctr->setDealMapper($dealMapper);
                $productMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
                $ctr->setProductMapper($productMapper);
                return $ctr;
            },
            'ZfDeals\Controller\ProductAddForm' => function ($serviceLocator) {
                $form = new \ZfDeals\Form\ProductAdd();
                $ctr = new ZfDeals\Controller\ProductAddFormController($form);
                $productMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
                $ctr->setProductMapper($productMapper);
                return $ctr;
            },
            'ZfDeals\Controller\Index' => function ($serviceLocator) {
                $ctr = new ZfDeals\Controller\IndexController();
                $productMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Product');
                $dealMapper = $serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Deal');
                $ctr->setDealMapper($dealMapper);
                $ctr->setProductMapper($productMapper);
                return $ctr;
            },
            'ZfDeals\Controller\Order' => function ($serviceLocator) {
                $ctr = new ZfDeals\Controller\OrderController();
                $ctr->setOrderMapper($serviceLocator->getServiceLocator()->get('ZfDeals\Mapper\Order'));
                return $ctr;
            },
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'zf-deals/layout/admin'   => __DIR__ . '/../view/layout/admin.phtml',
            'zf-deals/layout/site'   => __DIR__ . '/../view/layout/site.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($sm) {
                $config = $sm->get('Config');
                $dbParams = $config['dbParams'];

                return new Zend\Db\Adapter\Adapter(
                    array(
                        'driver'    => 'pdo',
                        'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
                        'database'  => $dbParams['database'],
                        'username'  => $dbParams['username'],
                        'password'  => $dbParams['password'],
                        'hostname'  => $dbParams['hostname'],
                    )
                );
            },
            'ZfDeals\Mapper\Product' => function ($sm) {
                return new \ZfDeals\Mapper\Product(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
            'ZfDeals\Mapper\Deal' => function ($sm) {
                return new \ZfDeals\Mapper\Deal(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
            'ZfDeals\Mapper\Order' => function ($sm) {
                return new \ZfDeals\Mapper\Order(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
            'ZfDeals\Validator\DealAvailable' => function ($sm) {
                $validator = new \ZfDeals\Validator\DealActive();
                $validator->setDealMapper($sm->get('ZfDeals\Mapper\Deal'));
                $validator->setProductMapper($sm->get('ZfDeals\Mapper\Product'));
                return $validator;
            },
            'ZfDeals\Service\Checkout' => function ($sm) {
                $srv = new \ZfDeals\Service\Checkout();
                $srv->setDealAvailable($sm->get('ZfDeals\Validator\DealAvailable'));
                $srv->setProductMapper($sm->get('ZfDeals\Mapper\Product'));
                $srv->setOrderMapper($sm->get('ZfDeals\Mapper\Order'));
                return $srv;
            },
        ),
    ),
);

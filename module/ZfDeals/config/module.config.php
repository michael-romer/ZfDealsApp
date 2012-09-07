<?php
return array(
    'router' => array(
        'routes' => array(
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
                        'controller' => 'ZfDeals\Controller\Admin',
                        'action'     => 'add-product',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'ZfDeals\Controller\Admin' => 'ZfDeals\Controller\AdminControllerFactory'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'zf-deals/layout/admin'   => __DIR__ . '/../view/layout/admin.phtml',
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

                return new Zend\Db\Adapter\Adapter(array(
                    'driver'    => 'pdo',
                    'dsn'       => 'mysql:dbname='.$dbParams['database'].';host='.$dbParams['hostname'],
                    'database'  => $dbParams['database'],
                    'username'  => $dbParams['username'],
                    'password'  => $dbParams['password'],
                    'hostname'  => $dbParams['hostname'],
                ));
            },
            'ZfDeals\Mapper\Product' => function ($sm) {
                return new \ZfDeals\Mapper\Product(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
        ),
    ),
);

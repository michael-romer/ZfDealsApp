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
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'ZfDeals\Controller\Admin' => 'ZfDeals\Controller\AdminController'
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
);

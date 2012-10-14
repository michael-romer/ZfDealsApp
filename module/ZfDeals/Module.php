<?php
namespace ZfDeals;

use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
    {
        $layoutConfig = array(
            'admin' => array(
                'ZfDeals\Controller\ProductAddFormController',
                'ZfDeals\Controller\DealAddFormController',
                'ZfDeals\Controller\AdminController',
                'ZfDeals\Controller\OrderController',
            ),
            'site' => array(
                'ZfDeals\Controller\IndexController',
                'ZfDeals\Controller\CheckoutFormController',
            )
        );

        foreach($layoutConfig as $layout => $controllers)
        {
            foreach($controllers as $controller)
            {
                $this->configureLayoutForController(
                    $moduleManager,
                    $controller,
                    "zf-deals/layout/$layout"
                );
            }
        }
    }

    private function configureLayoutForController($moduleManager, $controller, $layout)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach(
            $controller,
            'dispatch',
            function ($e) use ($layout) {
                $controller = $e->getTarget();
                $controller->layout($layout);
            },
            100
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

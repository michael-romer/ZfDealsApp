<?php
namespace ZfDeals;

use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(\Zend\ModuleManager\ModuleManager $moduleManager)
    {
        $this->configureLayoutForController(
            $moduleManager,
            'ZfDeals\Controller\ProductAddFormController',
            'zf-deals/layout/admin'
        );

        $this->configureLayoutForController(
            $moduleManager,
            'ZfDeals\Controller\DealAddFormController',
            'zf-deals/layout/admin'
        );

        $this->configureLayoutForController(
            $moduleManager,
            'ZfDeals\Controller\IndexController',
            'zf-deals/layout/site'
        );
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

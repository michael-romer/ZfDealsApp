<?php
use Zend\Loader\StandardAutoloader;

chdir(dirname(__DIR__));

include 'init_autoloader.php';

$loader = new StandardAutoloader();
$loader->registerNamespace('ZfDealsTest', __DIR__ . '/ZfDealsTest');
$loader->register();

Zend\Mvc\Application::init(include 'config/application.config.php');

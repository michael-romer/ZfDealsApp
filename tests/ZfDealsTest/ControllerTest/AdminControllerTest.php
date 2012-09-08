<?php
namespace ZfDeals\ControllerTest;

use ZfDeals\Controller\AdminController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

class AdminControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $request;
    private $response;
    private $routeMatch;
    private $event;

    public function setUp()
    {
        $this->controller = new AdminController();
        $this->request = new Request();
        $this->response = new Response();
        $this->routeMatch = new RouteMatch(array('controller' => 'admin'));
        $this->routeMatch->setParam('action', 'add-product');
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    public function testShowFormOnGetRequest()
    {
        $fakeForm = new \Zend\Form\Form('fakeForm');
        $this->controller->setProductAddForm($fakeForm);
        $this->request->setMethod('get');
        $response = $this->controller->dispatch($this->request);
        $viewModelValues = $response->getVariables();
        $formReturned = $viewModelValues['form'];
        $this->assertEquals($formReturned->getName(), $fakeForm->getName());
    }

    public function testShowFormOnValidationError()
    {
        $fakeForm = $this->getFakeForm(false);
        $this->controller->setProductAddForm($fakeForm);
        $this->request->setMethod('post');
        $response = $this->controller->dispatch($this->request);
        $viewModelValues = $response->getVariables();
        $formReturned = $viewModelValues['form'];
        $this->assertEquals($formReturned->getName(), $fakeForm->getName());
    }

    public function testCallMapperOnFormValidationSuccessPersistenceSuccess()
    {
        $fakeForm = $this->getFakeForm();
        $fakeForm->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(new \stdClass()));

        $fakeMapper = $this->getFakeMapper();
        $fakeMapper->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(true));

        $this->controller->setProductAddForm($fakeForm);
        $this->controller->setProductMapper($fakeMapper);
        $this->request->setMethod('post');
        $response = $this->controller->dispatch($this->request);
        $viewModelValues = $response->getVariables();
        $this->assertTrue(isset($viewModelValues['success']));
    }

    public function testCallMapperOnFormValidationSuccessPersistenceError()
    {
        $fakeForm = $this->getFakeForm();
        $fakeForm->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(new \stdClass()));

        $fakeMapper = $this->getFakeMapper();
        $fakeMapper->expects($this->once())
            ->method('insert')
            ->will($this->throwException(new \Exception));

        $this->controller->setProductAddForm($fakeForm);
        $this->controller->setProductMapper($fakeMapper);
        $this->request->setMethod('post');
        $response = $this->controller->dispatch($this->request);
        $viewModelValues = $response->getVariables();
        $this->assertTrue(isset($viewModelValues['form']));
        $this->assertTrue(isset($viewModelValues['insertError']));
    }

    public function getFakeForm($isValid = true)
    {
        $fakeForm = $this->getMock('Zend\Form\Form', array('isValid', 'getData'));
        $fakeForm->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue($isValid));

        return $fakeForm;
    }

    public function getFakeMapper()
    {
        $fakeMapper = $this->getMock('ZfDeals\Mapper\Product',
            array('insert'),
            array(),
            '',
            false
        );

        return $fakeMapper;
    }
}
<?php
namespace ZfDeals\ControllerTest;

use ZfDeals\Controller\AbstractFormController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use ZfDeals\Form\ProductAdd as ProductAddForm;

class AbstractFormControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $request;
    private $response;
    private $routeMatch;
    private $event;

    public function setUp()
    {
        $fakeController = $this->getMockForAbstractClass(
            'ZfDeals\Controller\AbstractFormController',
            array(),
            '',
            false
        );

        $this->controller = $fakeController;
        $this->request = new Request();
        $this->response = new Response();
        $this->routeMatch = new RouteMatch(array('controller' => 'abstract-form'));
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
    }

    public function testShowOnGetRequest()
    {
        $this->form = new \Zend\Form\Form('fakeForm');
        $this->controller->setForm($this->form);
        $this->request->setMethod('get');
        $response = $this->controller->dispatch($this->request);
        $viewModelValues = $response->getVariables();
        $formReturned = $viewModelValues['form'];
        $this->assertEquals($formReturned->getName(), $this->form->getName());
    }

    public function testErrorOnValidationError()
    {
        $fakeForm = $this->getMock('Zend\Form\Form', array('isValid'));

        $fakeForm->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->controller->setForm($fakeForm);
        $this->request->setMethod('post');
        $response = $this->controller->dispatch($this->request);
        $viewModelValues = $response->getVariables();
        $formReturned = $viewModelValues['form'];
        $this->assertEquals($formReturned, $fakeForm);
    }

    public function testProcessOnValidationSuccess()
    {
        $fakeForm = $this->getMock('Zend\Form\Form', array('isValid'));

        $fakeForm->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->controller->setForm($fakeForm);
        $this->request->setMethod('post');

        $this->controller->expects($this->once())
            ->method('process')
            ->will($this->returnValue(true));

        $response = $this->controller->dispatch($this->request);
    }
}
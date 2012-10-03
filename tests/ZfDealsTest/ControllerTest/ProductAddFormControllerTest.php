<?php
namespace ZfDeals\ControllerTest;

use ZfDeals\Controller\ProductAddFormController;
use ZfDeals\Form\ProductAdd as ProductAddForm;

class ProductAddFormControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;

    public function setUp()
    {
        $this->controller = new ProductAddFormController(new ProductAddForm());
    }

    public function testCallMapperOnProcess()
    {
        $fakeForm = $this->getFakeForm(false);
        $fakeForm->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(new \stdClass()));

        $fakeMapper = $this->getFakeMapper();
        $fakeMapper->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(true));

        $this->controller->setForm($fakeForm);
        $this->controller->setProductMapper($fakeMapper);
        $response = $this->controller->process();
        $viewModelValues = $response->getVariables();
        $this->assertTrue(isset($viewModelValues['success']));
    }

    public function testCallMapperOnProcessPersistenceError()
    {
        $fakeForm = $this->getFakeForm(false);
        $fakeForm->expects($this->once())
            ->method('getData')
            ->will($this->returnValue(new \stdClass()));

        $fakeMapper = $this->getFakeMapper();
        $fakeMapper->expects($this->once())
            ->method('insert')
            ->will($this->throwException(new \Exception));

        $this->controller->setForm($fakeForm);
        $this->controller->setProductMapper($fakeMapper);
        $response = $this->controller->process();
        $viewModelValues = $response->getVariables();
        $this->assertTrue(isset($viewModelValues['form']));
        $this->assertTrue(isset($viewModelValues['insertError']));
    }

    public function getFakeForm($isValid = true)
    {
        $fakeForm = $this->getMock('ZfDeals\Form\ProductAdd', array('isValid', 'getData'));

        if ($isValid) {
            $fakeForm->expects($this->once())
                ->method('isValid')
                ->will($this->returnValue($isValid));
        }

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
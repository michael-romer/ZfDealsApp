<?php
namespace ZfDeals\ControllerTest;

use ZfDeals\Controller\DealAddFormController;
use ZfDeals\Form\DealAdd as DealAddForm;
use ZfDeals\Entity\Deal;
use ZfDeals\Entity\Product;

class DealAddFormControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;

    public function setUp()
    {
        $this->controller = new DealAddFormController(new DealAddForm());
    }

    public function testPrepare()
    {
        $ctr = $this->controller;
        $ctr->setProductMapper($this->getFakeProductMapper());

        $ctr->getProductMapper()->expects($this->once())
            ->method('select')
            ->will($this->returnValue(array(array('id' => 1, 'name' => 'Test-Product'))));

        $ctr->prepare();
        $values = $ctr->getForm()->get('deal')->get('product')->get('id')->getValueOptions();
        $this->assertEquals(array(1 => 'Test-Product'), $values);
    }

    public function getFakeProductMapper()
    {
        $fakeMapper = $this->getMock('ZfDeals\Mapper\Product',
            array('select', 'insert'),
            array(),
            '',
            false
        );

        return $fakeMapper;
    }

    public function testCallMapperOnProcess()
    {
        $fakeForm = $this->getFakeForm(false);
        $fakeForm->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($this->getFakeDeal()));

        $fakeMapper = $this->getFakeDealMapper();
        $fakeMapper->expects($this->once())
            ->method('insert')
            ->will($this->returnValue(true));

        $this->controller->setForm($fakeForm);
        $this->controller->setDealMapper($fakeMapper);
        $result = $this->controller->process();
        $viewModelValues = $result->getVariables();
        $this->assertTrue(isset($viewModelValues['success']));
    }

    private function getFakeDeal()
    {
        $deal = new Deal();
        $product = new Product();
        $product->setId(1);
        $deal->setProduct($product);
        return $deal;
    }

    public function getFakeForm($isValid = true)
    {
        $fakeForm = $this->getMock('ZfDeals\Form\DealAdd', array('isValid', 'getData'));

        if ($isValid) {
            $fakeForm->expects($this->once())
                ->method('isValid')
                ->will($this->returnValue($isValid));
        }

        return $fakeForm;
    }

    public function getFakeDealMapper()
    {
        $fakeMapper = $this->getMock('ZfDeals\Mapper\Deal',
            array('select', 'insert'),
            array(),
            '',
            false
        );

        return $fakeMapper;
    }

    public function testCallMapperOnProcessPersistenceError()
    {
        $fakeForm = $this->getFakeForm(false);

        $fakeForm->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($this->getFakeDeal()));

        $fakeMapper = $this->getFakeDealMapper();
        $fakeMapper->expects($this->once())
            ->method('insert')
            ->will($this->throwException(new \Exception));

        $this->controller->setForm($fakeForm);
        $this->controller->setDealMapper($fakeMapper);
        $result = $this->controller->process();
        $viewModelValues = $result->getVariables();
        $this->assertTrue(isset($viewModelValues['insertError']));
    }
}
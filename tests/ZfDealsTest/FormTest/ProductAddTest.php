<?php
namespace ZfDealsTest\FormTest;

use ZfDeals\Form\ProductAdd;

class ProductAddTest extends \PHPUnit_Framework_TestCase
{
    private $form;
    private $data;

    public function setUp()
    {
        $this->form = new ProductAdd();
        $this->data = array(
            'product' => array(
                'id' => '',
                'name' => '',
                'stock' => ''
            )
        );
    }

    public function testEmptyValues()
    {
        $form = $this->form;
        $data = $this->data;

        $this->assertFalse($form->setData($data)->isValid());

        $data['product']['id'] = 1;
        $this->assertFalse($form->setData($data)->isValid());

        $data['product']['name'] = 1;
        $this->assertFalse($form->setData($data)->isValid());

        $data['product']['stock'] = 1;
        $this->assertTrue($form->setData($data)->isValid());
    }

    public function testStockElement()
    {
        $form = $this->form;
        $data = $this->data;
        $data['product']['id'] = 1;
        $data['product']['name'] = 1;

        $data['product']['stock'] = -1;
        $this->assertFalse($form->setData($data)->isValid());

        $data['product']['stock'] = "test";
        $this->assertFalse($form->setData($data)->isValid());

        $data['product']['stock'] = 12.3;
        $this->assertFalse($form->setData($data)->isValid());

        $data['product']['stock'] = 12;
        $this->assertTrue($form->setData($data)->isValid());
    }

}

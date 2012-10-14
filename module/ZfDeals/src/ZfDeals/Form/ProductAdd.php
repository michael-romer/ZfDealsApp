<?php
namespace ZfDeals\Form;

use Zend\Form\Form;

class ProductAdd extends Form
{
    public function __construct()
    {
        parent::__construct('login');
        $this->setAttribute('action', '/deals/admin/product/add');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'ZfDeals\Form\ProductFieldset',
                'options' => array(
                    'use_as_base_fieldset' => true
                )
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type'  => 'submit',
                    'value' => 'Add Product'
                ),
            )
        );
    }
}

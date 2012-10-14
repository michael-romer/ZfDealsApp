<?php
namespace ZfDeals\Form;

use Zend\Form\Form;

class Checkout extends Form
{
    public function __construct()
    {
        parent::__construct('login');
        $this->setAttribute('action', '/deals/checkout');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'ZfDeals\Form\OrderFieldset',
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
                    'value' => 'Place order'
                ),
            )
        );
    }
}

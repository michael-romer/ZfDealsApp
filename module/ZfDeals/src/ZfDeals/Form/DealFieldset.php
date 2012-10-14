<?php
namespace ZfDeals\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;

class DealFieldset extends Fieldset
{
    public function __construct()
    {
        parent::__construct('deal');

        $this->add(
            array(
                'name' => 'product',
                'type' => 'ZfDeals\Form\ProductSelectorFieldset',
            )
        );

        $this->add(
            array(
                'name' => 'price',
                'type' => 'Zend\Form\Element\Number',
                'attributes' => array(
                    'step' => 'any'
                ),
                'options' => array(
                    'label' => 'Price',
                )
            )
        );

        $this->add(
            array(
                'name' => 'startDate',
                'type' => 'Zend\Form\Element\Date',
                'options' => array(
                    'label' => 'Start Date'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'endDate',
                'type' => 'Zend\Form\Element\Date',
                'options' => array(
                    'label' => 'End Date'
                ),
            )
        );
    }
}

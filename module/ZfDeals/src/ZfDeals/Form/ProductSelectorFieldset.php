<?php
namespace ZfDeals\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class ProductSelectorFieldset extends Fieldset
{
    public function __construct()
    {
        parent::__construct('productSelector');
        $this->setHydrator(new\Zend\Stdlib\Hydrator\Reflection());
        $this->setObject(new \ZfDeals\Entity\Product());

        $this->add(
            array(
                'name' => 'productId',
                'type'  => 'Zend\Form\Element\Select',
                'options' => array(
                    'label' => 'Product-ID',
                    'value_options' => array(
                            '1' => 'Label 1',
                            '2' => 'Label 2',
                    ),
                )
            )
        );
    }
}

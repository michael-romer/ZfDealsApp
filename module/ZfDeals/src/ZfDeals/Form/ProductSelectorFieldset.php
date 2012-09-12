<?php
namespace ZfDeals\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class ProductSelectorFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('productSelector');
        $this->setHydrator(new\Zend\Stdlib\Hydrator\Reflection());
        $this->setObject(new \ZfDeals\Entity\Product());

        $this->add(
            array(
                'name' => 'id',
                'type'  => 'Zend\Form\Element\Select',
                'options' => array(
                    'label' => 'Produkt-ID:',
                    'value_options' => array(
                            '1' => 'Label 1',
                            '2' => 'Label 2',
                    ),
                )
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array (
                'required'   => true,
                'filters' => array(
                    array(
                       'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message'  => "Bitte geben Sie die Produkt-ID an."
                        ),
                    )
                )
            ),
        );
    }
}


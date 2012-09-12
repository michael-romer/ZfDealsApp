<?php
namespace ZfDeals\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class DealFieldset extends Fieldset implements InputFilterProviderInterface
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
                    'type'  => 'text',
                ),
                'options' => array(
                    'label' => 'Price:',
                )
            )
        );

        $this->add(
            array(
                'name' => 'startDate',
                'type' => 'Zend\Form\Element\Date',
                'options' => array(
                    'label' => 'Startdatum:'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'endDate',
                'type' => 'Zend\Form\Element\Date',
                'options' => array(
                    'label' => 'Enddatum:'
                ),
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'price' => array (
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
            'startDate' => array (
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
                            'message'  => "Bitte geben Sie die Lagerbestand an."
                        ),
                    ),
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'message'  => "Bitte geben Sie einen ganzzahligen Wert an."
                        ),
                    ),
                )
            ),
            'endDate' => array (
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
                            'message'  => "Bitte geben Sie die Lagerbestand an."
                        ),
                    ),
                    array(
                        'name' => 'Date',
                        'options' => array(
                            'message'  => "Bitte geben Sie einen ganzzahligen Wert an."
                        ),
                    ),
                )
            ),
        );
    }
}


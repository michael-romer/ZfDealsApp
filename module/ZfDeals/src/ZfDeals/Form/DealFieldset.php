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
                    'step' => 'any'
                ),
                'options' => array(
                    'label' => 'Preis:',
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
            'price' => array(
                'filters' => array(
                    array(
                       'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message'  => "Bitte geben Sie einen Preis an."
                        ),
                    ),
                    array(
                        'name' => 'Regex',
                        'options' => array(
                            'pattern' => '/^[0-9]*\.[0-9]2$/',
                            'message'  => "Bitte geben Sie einen gültigen Preis ein."
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
                        'name' => 'Date',
                        'options' => array(
                            'message'  => "Bitte geben Sie ein Datum ein."
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
                        'name' => 'Date',
                        'options' => array(
                            'message'  => "Bitte geben Sie ein Datum ein."
                        ),
                    ),
                )
            ),
        );
    }
}


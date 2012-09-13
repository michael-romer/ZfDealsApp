<?php
namespace ZfDeals\Form;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;

class ProductFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('product');

        $this->add(
            array(
                'name' => 'id',
                'attributes' => array(
                    'type'  => 'text',
                ),
                'options' => array(
                    'label' => 'Produkt-ID:',
                )
            )
        );


        $this->add(
            array(
                'name' => 'name',
                'attributes' => array(
                    'type'  => 'text',
                ),
                'options' => array(
                    'label' => 'Produktbezeichnung:',
                )
            )
        );

        $this->add(
            array(
                'name' => 'stock',
                'attributes' => array(
                    'type'  => 'number',
                ),
                'options' => array(
                    'label' => '# Bestand:'
                ),
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array (
                'required' => true,
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
            'name' => array (
                'required' => true,
                'filters' => array(
                    array(
                       'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message'  => "Bitte geben Sie eine Produktbezeichnung an."
                        ),
                    )
                )
            ),
            'stock' => array (
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
                        'name' => 'Digits',
                        'options' => array(
                            'message'  => "Bitte geben Sie einen ganzzahligen Wert an."
                        ),
                    ),
                    array(
                        'name' => 'GreaterThan',
                        'options' => array(
                            'min' => 0,
                            'message'  => "Bitte geben Sie Wert >= 0 an."
                        ),
                    )
                )
            ),
        );
    }
}


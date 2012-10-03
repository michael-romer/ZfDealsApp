<?php
namespace ZfDeals\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class DealAdd extends Form
{
    public function __construct()
    {
        parent::__construct('dealAdd');
        $this->setAttribute('action', '/deals/admin/deal/add');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'ZfDeals\Form\DealFieldset',
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
                    'value' => 'Hinzufügen'
                ),
            )
        );
    }
}

<?php
namespace ZfDeals\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Hydrator\Reflection;
use ZfDeals\Entity\Deal as DealEntity;

class DealAddFormController extends AbstractFormController
{
    private $productMapper;
    private $dealMapper;

    public function prepare()
    {
        $this->form->setHydrator(new Reflection());
        $this->form->bind(new DealEntity());

        $products = $this->productMapper->select();
        $fieldElements = array();

        foreach ($products as $product) {
            $fieldElements[$product['id']] = $product['name'];
        }

        $this->form->get('deal')->get('product')->get('id')->setValueOptions($fieldElements);
    }

    public function process()
    {
        $model = new ViewModel(
            array(
                'form' => $this->form
            )
        );

        $newDeal = $this->form->getData();
        $newDeal->setProduct($newDeal->getProduct()->getId());

        try {
            $this->dealMapper->insert($newDeal);
            $model->setVariable('success', true);
        } catch (\Exception $e) {
            $model->setVariable('insertError', true);
        }

        return $model;
    }

    public function setProductMapper($productMapper)
    {
        $this->productMapper = $productMapper;
    }

    public function getProductMapper()
    {
        return $this->productMapper;
    }

    public function setDealMapper($dealMapper)
    {
        $this->dealMapper = $dealMapper;
    }

    public function getDealMapper()
    {
        return $this->dealMapper;
    }
}

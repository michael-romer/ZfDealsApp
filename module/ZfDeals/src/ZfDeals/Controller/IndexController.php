<?php
namespace ZfDeals\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

class IndexController extends AbstractActionController
{
    private $dealMapper;
    private $productMapper;

    public function indexAction()
    {
        $deals = $this->dealMapper->findActiveDeals();
        $dealsView = array();

        foreach ($deals as $deal) {
            $deal->setProduct(
                $this->productMapper->findOneById($deal->getProduct())
            );

            $dealsView[] = $deal;
        }

        return new ViewModel(
            array(
                'deals' => $dealsView
            )
        );
    }

    public function setDealMapper($dealMapper)
    {
        $this->dealMapper = $dealMapper;
    }

    public function getDealMapper()
    {
        return $this->dealMapper;
    }

    public function setProductMapper($productMapper)
    {
        $this->productMapper = $productMapper;
    }

    public function getProductMapper()
    {
        return $this->productMapper;
    }
}

<?php
namespace ZfDeals\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Stdlib\Hydrator\Reflection;
use ZfDeals\Entity\Order as OrderEntity;
use ZfDeals\Form\Checkout as Checkout;

class CheckoutFormController extends AbstractFormController
{
    private $productMapper;
    private $dealMapper;
    private $dealActiveValidator;
    private $checkoutService;

    public function setCheckoutService($checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function getCheckoutService()
    {
        return $this->checkoutService;
    }

    public function setDealActiveValidator($dealActiveValidator)
    {
        $this->dealActiveValidator = $dealActiveValidator;
    }

    public function getDealActiveValidator()
    {
        return $this->dealActiveValidator;
    }

    public function __construct(Checkout $form)
    {
        parent::__construct($form);
    }

    public function prepare()
    {
        $this->form->setHydrator(new Reflection());
        $this->form->bind(new OrderEntity());
    }

    public function show()
    {
        if (!$this->dealActiveValidator->isValid($this->params()->fromQuery('id'))) {
            $this->redirect()->toRoute('zf-deals');
        }

        $this->form->get('order')->get('deal_id')->setValue($this->params()->fromQuery('id'));

        $model = new ViewModel(
            array(
                'form' => $this->form
            )
        );

        return $model;
    }

    public function process()
    {
        $newOrder = $this->form->getData();
        $newOrder->setDeal($this->form->get('order')->get('deal_id')->getValue());

        $model = new ViewModel(
            array(
                'form' => $this->form
            )
        );

        try {
            $this->checkoutService->process($newOrder);
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

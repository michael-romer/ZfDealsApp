<?php
namespace ZfDeals\Controller;

use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\Form\Form as Form;
use Zend\View\Model\ViewModel;

abstract class AbstractFormController extends AbstractController
{
    protected $form;

    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function onDispatch(MvcEvent $e)
    {
        if (method_exists($this, 'prepare')) {
            $this->prepare();
        }

        $routeMatch = $e->getRouteMatch();

        if ($this->getRequest()->isPost()) {
            $this->form->setData($this->getRequest()->getPost());

            if ($this->form->isValid()) {
                $routeMatch->setParam('action', 'process');
                $return = $this->process();
            } else {
                $routeMatch->setParam('action', 'error');
                $return = $this->error();
            }

        } else {
            $routeMatch->setParam('action', 'show');
            $return = $this->show();
        }

        $e->setResult($return);
        return $return;
    }

    abstract protected function process();

    protected function show()
    {
        return new ViewModel(
            array(
                'form' => $this->form
            )
        );
    }

    protected function error()
    {
        return new ViewModel(
            array(
                'form' => $this->form
            )
        );
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }
}

<?php
namespace ZfDeals\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;

class AdminController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}

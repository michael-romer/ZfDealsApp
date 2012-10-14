<?php
namespace ZfDeals\Validator;

use Zend\Validator\AbstractValidator;

class DealActive extends AbstractValidator
{
    private $productMapper;
    private $dealMapper;

    public function isValid($value)
    {
        try {
            $this->dealMapper->findActiveDealById($value);
        } catch (\DomainException $e) {
            return false;
        }

        return true;
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

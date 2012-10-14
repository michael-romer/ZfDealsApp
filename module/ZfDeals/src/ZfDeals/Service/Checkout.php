<?php

namespace ZfDeals\Service;

class Checkout
{
    private $dealAvailable;
    private $orderMapper;
    private $productMapper;

    public function process($ordering)
    {
        try {
            $this->orderMapper->insert($ordering);
        } catch (\Exception $e) {
            throw new \DomainException('Order could not be processed.');
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

    public function setOrderMapper($orderMapper)
    {
        $this->orderMapper = $orderMapper;
    }

    public function setDealAvailable($dealAvailable)
    {
        $this->dealAvailable = $dealAvailable;
    }

    public function getDealAvailable()
    {
        return $this->dealAvailable;
    }

    public function getOrderMapper()
    {
        return $this->orderMapper;
    }
}

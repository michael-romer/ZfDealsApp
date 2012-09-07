<?php
namespace HelloworldTest\ControllerTest\IndexControllerTest;

use Helloworld\Service\GreetingService\HourProviderInterface;
use Helloworld\Service\GreetingServiceInterface;

class GreetingServiceFake implements GreetingServiceInterface
{
    private $getGreetingWasCalled = false;

    public function getGreeting()
    {
        $this->getGreetingWasCalled = true;
        return "Fake Greeting Line";
    }

    public function setHourProvider(HourProviderInterface $hourProvider)
    {
        return;
    }

    public function getHourProvider()
    {
        return;
    }

    public function setGetGreetingWasCalled($getGreetingWasCalled)
    {
        $this->getGreetingWasCalled = $getGreetingWasCalled;
    }

    public function getGetGreetingWasCalled()
    {
        return $this->getGreetingWasCalled;
    }
}

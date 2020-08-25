<?php

declare(strict_types=1);

namespace spec\Brille24\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\PaymentInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\PaymentMethodInterface;

class PaymentSpec extends ObjectBehavior
{
    public function it_returns_loggable_data(PaymentMethodInterface $method): void
    {
        $method->getCode()->willReturn('method_code');

        $this->setState(PaymentInterface::STATE_NEW);
        $this->setMethod($method);
        $this->setCurrencyCode('EUR');
        $this->setAmount(123);
        $this->setDetails(['bla' => 'bla']);

        $this->getLoggableData()->shouldReturn([
            'state' => PaymentInterface::STATE_NEW,
            'method' => 'method_code',
            'currencyCode' => 'EUR',
            'amount' => 123,
            'details' => '{"bla":"bla"}',
        ]);
    }
}

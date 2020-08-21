<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\PaymentLoggableTrait;

class Payment extends \Sylius\Component\Core\Model\Payment implements PaymentInterface
{
    use PaymentLoggableTrait {
        __construct as loggableConstructor;
    }

    public function __construct()
    {
        $this->loggableConstructor();
        parent::__construct();
    }
}

<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class Payment extends \Sylius\Component\Core\Model\Payment implements PaymentInterface
{
    use PaymentLoggableTrait;
}

<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\PaymentInterface;
use Brille24\SyliusOrderLogPlugin\Entity\PaymentLoggableTrait;

class Payment extends \Sylius\Component\Core\Model\Payment implements PaymentInterface
{
    use PaymentLoggableTrait;
}

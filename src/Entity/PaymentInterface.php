<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

interface PaymentInterface extends \Sylius\Component\Core\Model\PaymentInterface, LoggableInterface
{
}

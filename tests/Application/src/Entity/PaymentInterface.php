<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\PaymentLoggableInterface;

interface PaymentInterface extends \Sylius\Component\Core\Model\PaymentInterface, PaymentLoggableInterface
{

}

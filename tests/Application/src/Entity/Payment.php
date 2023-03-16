<?php

declare(strict_types=1);

namespace Tests\Application\SyliusOrderLogPlugin\Entity;

use Brille24\SyliusOrderLogPlugin\Entity\PaymentLoggableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_payment')]
class Payment extends \Sylius\Component\Core\Model\Payment implements PaymentInterface
{
    use PaymentLoggableTrait;
}

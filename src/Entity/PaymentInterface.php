<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface PaymentInterface extends \Sylius\Component\Core\Model\PaymentInterface
{
    public function getLogEntries(): Collection;

    public function setLogEntries(Collection $logEntries): void;
}

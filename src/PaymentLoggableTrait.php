<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait PaymentLoggableTrait
{
    public function getLoggableData(): array
    {
        return [
            'state' => $this->getState(),
            'method' => null !== $this->getMethod() ? $this->getMethod()->getCode() : null,
            'currencyCode' => $this->getCurrencyCode(),
            'amount' => $this->getAmount(),
            'details' => json_encode($this->getDetails(), JSON_THROW_ON_ERROR),
        ];
    }
}

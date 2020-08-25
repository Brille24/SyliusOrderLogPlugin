<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin;

trait OrderLoggableTrait
{
    public function getLoggableData(): array
    {
        return [
            'state' => $this->getState(),
            'checkoutState' => $this->getCheckoutState(),
            'paymentState' => $this->getPaymentState(),
            'shippingState' => $this->getShippingState(),
        ];
    }
}

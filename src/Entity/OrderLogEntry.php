<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

class OrderLogEntry extends LogEntry implements OrderLogEntryInterface
{
    public function __construct()
    {
        parent::__construct();
    }
}

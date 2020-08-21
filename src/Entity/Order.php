<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order extends \Sylius\Component\Core\Model\Order implements OrderInterface
{
    /** @var Collection */
    protected $logEntries;

    public function __construct()
    {
        $this->logEntries = new ArrayCollection();

        parent::__construct();
    }

    public function getLogEntries(): Collection
    {
        return $this->logEntries;
    }

    public function setLogEntries(Collection $logEntries): void
    {
        $this->logEntries = $logEntries;
    }
}

<?php

declare(strict_types=1);

namespace Brille24\SyliusOrderLogPlugin\Listener;

use Brille24\SyliusOrderLogPlugin\Entity\LogEntryInterface;
use Brille24\SyliusOrderLogPlugin\Event\LogEvent;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

trait LogListenerTrait
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private RepositoryInterface $logEntryRepository
    ) {
    }

    /**
     * @param LogEvent $event
     * @param mixed $objectId
     *
     * @return array
     */
    private function getDataToLog(LogEvent $event, $objectId): array
    {
        $data = $event->getData();
        if ($event->onlyDifferences()) {
            // Rebuild last logged data
            $loggedData = [];
            /** @var LogEntryInterface $log */
            foreach ($this->logEntryRepository->findBy(['objectId' => $objectId], ['date' => 'ASC']) as $log) {
                $loggedData = array_merge($loggedData, $log->getData());
            }

            // Get data difference
            $data = array_diff_assoc($event->getData(), $loggedData);
        }

        return $data;
    }

    private function handleUser(LogEntryInterface $logEntry): void
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token) {
            $user = $token->getUser();
            if ($user instanceof AdminUserInterface) {
                $logEntry->setUser($user);
            }
        }
    }
}

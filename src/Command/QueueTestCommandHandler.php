<?php
/**
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 */

namespace Macareux\MessengerTester\Command;

class QueueTestCommandHandler
{
    /**
     * @throws \Exception
     */
    public function __invoke(QueueTestCommand $command)
    {
        /** @var \Concrete\Core\Logging\LoggerFactory $loggerFactory */
        $loggerFactory = app('log/factory');
        $logger = $loggerFactory->createLogger('messenger_tester');
        $logger->info(t('Processing queue test command with the id: %d', $command->getId()));

        if ($command->getId() === 5) {
            throw new \Exception('Queue Test Command Handler Exception');
        }
    }
}

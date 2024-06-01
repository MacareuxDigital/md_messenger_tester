<?php

namespace Macareux\MessengerTester\Command;

use Concrete\Core\Support\Facade\Application;

class EnvironmentDetectTestCommandHandler
{
    public function __invoke(EnvironmentDetectTestCommand $command)
    {
        $app = Application::getFacadeApplication();
        /** @var \Concrete\Core\Config\Repository\Repository $config */
        $config = $app->make('config');
        /** @var \Concrete\Core\Logging\LoggerFactory $loggerFactory */
        $loggerFactory = $app->make('log/factory');
        $logger = $loggerFactory->createLogger('messenger_tester');
        $logger->info(sprintf(
            'The application is run through %s. Current environment is %s.',
            $app->isRunThroughCommandLineInterface() ? 'CLI' : 'Web',
            $app->environment()
        ));
    }
}
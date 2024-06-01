<?php

namespace Macareux\MessengerTester\Command;

use Concrete\Core\Support\Facade\Application;

class ConfigTestCommandHandler
{
    public function __invoke(ConfigTestCommand $command)
    {
        $app = Application::getFacadeApplication();
        /** @var \Concrete\Core\Config\Repository\Repository $config */
        $config = $app->make('config');
        /** @var \Concrete\Core\Logging\LoggerFactory $loggerFactory */
        $loggerFactory = $app->make('log/factory');
        $logger = $loggerFactory->createLogger('messenger_tester');
        $logger->info(sprintf(
            'Config value of %s is %s',
            $command->getConfigKey(),
            var_dump_safe($config->get($command->getConfigKey()), false, 5)
        ));
    }
}
<?php

namespace Macareux\MessengerTester\Command;

use Concrete\Core\Foundation\Command\Command;

class ConfigTestCommand extends Command
{
    protected string $configKey = '';

    public function getConfigKey(): string
    {
        return $this->configKey;
    }

    public function setConfigKey(string $config): void
    {
        $this->configKey = $config;
    }
}

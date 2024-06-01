<?php

namespace Macareux\MessengerTester\Task;

use Concrete\Core\Command\Batch\Batch;
use Concrete\Core\Command\Task\Controller\AbstractController;
use Concrete\Core\Command\Task\Input\Definition\Definition;
use Concrete\Core\Command\Task\Input\Definition\Field;
use Concrete\Core\Command\Task\Input\InputInterface;
use Concrete\Core\Command\Task\Runner\BatchProcessTaskRunner;
use Concrete\Core\Command\Task\Runner\TaskRunnerInterface;
use Concrete\Core\Command\Task\TaskInterface;
use Macareux\MessengerTester\Command\ConfigTestCommand;

class ConfigTestTaskController extends AbstractController
{
    public function getName(): string
    {
        return t('Messenger Tester: Config Test');
    }

    public function getDescription(): string
    {
        return t('A task to test whether the config values are correctly loaded through the messenger process.');
    }

    public function getInputDefinition(): ?Definition
    {
        $definition = new Definition();
        $definition->addField(new Field(
            'config_key',
            t('Config Key'),
            t('The key of the config value to test. e.g. `concrete.site`. You can specify multiple keys by separating them with commas.'),
            true
        ));

        return $definition;
    }

    public function getTaskRunner(TaskInterface $task, InputInterface $input): TaskRunnerInterface
    {
        $batch = Batch::create();
        $config_key = $input->getField('config_key')->getValue();
        $config_keys = explode(',', $config_key);
        foreach ($config_keys as $config_key) {
            $command = new ConfigTestCommand();
            $command->setConfigKey($config_key);
            $batch->add($command);
        }

        return new BatchProcessTaskRunner($task, $batch, $input, t('Config test beginning...'));
    }
}

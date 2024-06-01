<?php

namespace Macareux\MessengerTester\Task;

use Concrete\Core\Command\Task\Controller\AbstractController;
use Concrete\Core\Command\Task\Input\InputInterface;
use Concrete\Core\Command\Task\Runner\CommandTaskRunner;
use Concrete\Core\Command\Task\Runner\TaskRunnerInterface;
use Concrete\Core\Command\Task\TaskInterface;
use Macareux\MessengerTester\Command\FailedMessageTestCommand;

class FailedMessageTestTaskController extends AbstractController
{
    public function getName(): string
    {
        return t('Messenger Tester: Failed Message Test');
    }

    public function getDescription(): string
    {
        return t('A task to test whether the failed messages are correctly handled through the messenger process.');
    }

    public function getTaskRunner(TaskInterface $task, InputInterface $input): TaskRunnerInterface
    {
        return new CommandTaskRunner($task, new FailedMessageTestCommand(), t('Failed message test'));
    }
}

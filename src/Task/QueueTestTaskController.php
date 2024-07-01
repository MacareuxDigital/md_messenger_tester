<?php
/**
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 */

namespace Macareux\MessengerTester\Task;

use Concrete\Core\Command\Batch\Batch;
use Concrete\Core\Command\Task\Controller\AbstractController;
use Concrete\Core\Command\Task\Input\InputInterface;
use Concrete\Core\Command\Task\Runner\BatchProcessTaskRunner;
use Concrete\Core\Command\Task\Runner\TaskRunnerInterface;
use Concrete\Core\Command\Task\TaskInterface;
use Macareux\MessengerTester\Command\QueueTestCommand;

class QueueTestTaskController extends AbstractController
{
    public function getName(): string
    {
        return t('Messenger Tester: Queue Test');
    }

    public function getDescription(): string
    {
        return t('A task to test messenger queue with an exception.');
    }

    public function getTaskRunner(TaskInterface $task, InputInterface $input): TaskRunnerInterface
    {
        $batch = Batch::create();

        for ($i = 1; $i <= 20; $i++) {
            $command = new QueueTestCommand();
            $command->setId($i);
            $batch->add($command);
        }

        return new BatchProcessTaskRunner($task, $batch, $input, t('Queue test beginning...'));
    }
}

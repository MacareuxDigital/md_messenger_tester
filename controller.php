<?php

namespace Concrete\Package\MdMessengerTester;

use Concrete\Core\Command\Task\Manager;
use Concrete\Core\Command\Task\TaskSetService;
use Concrete\Core\Entity\Automation\Task;
use Concrete\Core\Package\Package;
use Doctrine\ORM\EntityManagerInterface;
use Macareux\MessengerTester\Task\ConfigTestTaskController;
use Macareux\MessengerTester\Task\EnvironmentDetectTestTaskController;
use Macareux\MessengerTester\Task\FailedMessageTestTaskController;
use Macareux\MessengerTester\Task\QueueTestTaskController;

class Controller extends Package
{
    protected $pkgHandle = 'md_messenger_tester';
    protected $appVersionRequired = '9.0.0';
    protected $pkgVersion = '1.0.1';
    protected $pkgAutoloaderRegistries = [
        'src' => '\Macareux\MessengerTester',
    ];

    public function getPackageName()
    {
        return t('Macareux Messenger Tester');
    }

    public function getPackageDescription()
    {
        return t('A Concrete CMS package to add tasks to test the messenger process.');
    }

    public function install()
    {
        parent::install();

        $taskHandles = [
            'md_messenger_tester_config_test',
            'md_messenger_tester_environment_detect_test',
            'md_messenger_tester_failed_message_test',
            'md_messenger_tester_queue_test',
        ];

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->app->make(EntityManagerInterface::class);
        $taskRepository = $entityManager->getRepository(Task::class);
        foreach ($taskHandles as $handle) {
            $task = $taskRepository->findOneBy(['handle' => $handle]);
            if ($task === null) {
                $task = new Task();
                $task->setHandle($handle);
                $task->setPackage($this->getPackageEntity());
                $entityManager->persist($task);
            }
        }
        $entityManager->flush();

        /** @var TaskSetService $service */
        $service = $this->app->make(TaskSetService::class);
        $set = $service->getByHandle('md_messenger_tester');
        if ($set === null) {
            $set = $service->add('md_messenger_tester', 'Macareux Messenger Tester', $this->getPackageEntity());
        }

        foreach ($taskHandles as $handle) {
            $task = $taskRepository->findOneBy(['handle' => $handle]);
            if ($task !== null && $service->taskSetContainsTask($set, $task) === false) {
                $service->addTaskToSet($task, $set);
            }
        }
    }

    public function on_start()
    {
        /** @var Manager $manager */
        $manager = $this->app->make(Manager::class);
        $manager->extend('md_messenger_tester_config_test', function () {
            return new ConfigTestTaskController();
        });
        $manager->extend('md_messenger_tester_environment_detect_test', function () {
            return new EnvironmentDetectTestTaskController();
        });
        $manager->extend('md_messenger_tester_failed_message_test', function () {
            return new FailedMessageTestTaskController();
        });

        $manager->extend('md_messenger_tester_queue_test', function () {
            return new QueueTestTaskController();
        });
    }
}
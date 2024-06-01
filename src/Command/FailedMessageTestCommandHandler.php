<?php

namespace Macareux\MessengerTester\Command;

use Concrete\Core\Error\UserMessageException;

class FailedMessageTestCommandHandler
{
    public function __invoke(FailedMessageTestCommand $command)
    {
        throw new UserMessageException(t('This is a test exception'));
    }
}
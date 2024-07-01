<?php
/**
 * @author: Biplob Hossain <biplob.ice@gmail.com>
 */

namespace Macareux\MessengerTester\Command;

use Concrete\Core\Foundation\Command\Command;

class QueueTestCommand extends Command
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}

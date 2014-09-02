<?php

namespace MiniFrame\ConsoleApplication;

use MiniFrame\Di\Di;
use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    /**
     * @return Di
     */
    public function getDi()
    {
        return $this->getHelperSet()->get('di');
    }
}

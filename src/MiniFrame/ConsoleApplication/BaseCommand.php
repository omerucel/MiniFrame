<?php

namespace MiniFrame\ConsoleApplication;

use MiniFrame\Di\Di;
use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    /**
     * @return Di
     */
    protected function getDi()
    {
        /**
         * @var DiHelper $diHelper
         */
        $diHelper = $this->getHelperSet()->get('di');
        return $diHelper->getDi();
    }
}

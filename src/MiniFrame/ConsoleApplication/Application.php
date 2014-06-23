<?php

namespace MiniFrame\ConsoleApplication;

use MiniFrame\BaseApplication;

abstract class Application extends BaseApplication
{
    public function serve()
    {
        $symfonyConsoleApp = new \Symfony\Component\Console\Application(
            $this->getDi()->getConfigs()->console_application->name,
            $this->getDi()->getConfigs()->console_application->version
        );
        $symfonyConsoleApp->getHelperSet()->set(new DiHelper($this->getDi()));
        $this->initCommands($symfonyConsoleApp);
        $symfonyConsoleApp->run();
    }

    abstract public function initCommands(\Symfony\Component\Console\Application $symfonyConsoleApp);
}

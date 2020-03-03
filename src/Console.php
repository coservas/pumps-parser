<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Application;

class Console
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->registerCommands();
    }

    private function registerCommands(): void
    {
        $commands = $this->getCommands();

        foreach ($commands as $command) {
            $this->app->add(new $command());
        }
    }

    private function getCommands(): array
    {
        $files = glob(__DIR__ . '/Command/*.php');

        return array_map(function (string $file) {
            $name = basename($file);
            $name = substr($name, 0, strlen($name) - 4);

            return sprintf('App\\Command\\%s', $name);
        }, $files);
    }

    public function run(): void
    {
        $this->app->run();
    }
}

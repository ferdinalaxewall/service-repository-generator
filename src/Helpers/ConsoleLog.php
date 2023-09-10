<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Helpers;

class ConsoleLog
{
    /**
     * create static function for generate the info console command.
     *
     * @param string $message
     *
     * @return void
     */
    public static function info(string $message): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<info>{$message}</info>");
    }

    /**
     * create static function for generate the error console command.
     *
     * @param string $message
     *
     * @return void
     */
    public static function error(string $message): void
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<error>{$message}</error>");
    }
}

<?php

namespace Ferdinalaxewall\ServiceRepositoryGenerator\Helpers;

class ConsoleLog
{
    public static function info($message)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<info>{$message}</info>");
    }

    public static function error($message)
    {
        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln("<error>{$message}</error>");
    }
}
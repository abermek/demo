#!/usr/bin/php

<?php
define('VENDOR_DIR', __DIR__.'/../../vendor');
require VENDOR_DIR.'/autoload.php';

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Process\Process;

class CodeQualityTool extends Application
{
    public function __construct()
    {
        parent::__construct('CI', '1.0.0');
    }
    //https://habr.com/ru/sandbox/137130/
    public function doRun(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Fetching Diff</info>');

        $files = [];
        $failed = false;
        exec("git diff-index --cached --name-status HEAD | egrep '^(A|M)' | awk '{print $2;}'", $output);

        $output->writeln('<info>PHPCS</info>');

        foreach ($files as $file) {
            if (!preg_match('/^src\/(.*)(\.php)$/', $file)) {
                continue;
            }

            $process = new Process(['php', VENDOR_DIR . '/bin/phpcs', '-n', '', $file]);
            $process->setWorkingDirectory(__DIR__ . '/../../');
            $process->run();

            if (!$process->isSuccessful()) {
                $output->writeln(sprintf('<error>%s</error>', trim($process->getOutput())));
                $failed = true;
            }
        }

        if ($failed) {
            throw new Exception('There are PHPCS coding standards violations!');
        }
    }
}

(new CodeQualityTool())->run();

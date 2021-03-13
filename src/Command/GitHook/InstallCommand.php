<?php

namespace App\Command\GitHook;

use DirectoryIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class InstallCommand extends Command
{
    protected static $defaultName = 'app:git:hooks:install';

    public function __construct(
        private string $gitHooksOriginDir,
        private string $gitHooksTargetDir,
        private Filesystem $filesystem
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Installing Git Hooks ...</info>');

        $iterator = new DirectoryIterator($this->gitHooksOriginDir);

        /** @var DirectoryIterator $file */
        foreach ($iterator as $file) {
            if ($file->isDir() || $file->isDot()) {
                continue;
            }

            $this->filesystem->copy(
                $file->getPathname(),
                $this->gitHooksTargetDir . DIRECTORY_SEPARATOR . (string)$file
            );

            $output->writeln(sprintf('<info>%s</info> has been installed', (string)$file));
        }

        return Command::SUCCESS;
    }
}

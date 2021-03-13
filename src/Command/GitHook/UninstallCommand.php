<?php

namespace App\Command\GitHook;

use DirectoryIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class UninstallCommand extends Command
{
    protected static $defaultName = 'app:git:hooks:uninstall';

    public function __construct(
        private string $gitHooksOriginDir,
        private string $gitHooksTargetDir,
        private Filesystem $filesystem
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Uninstalling Git Hooks ...</info>');

        $iterator = new DirectoryIterator($this->gitHooksOriginDir);
        $totalRemoved = 0;

        /** @var DirectoryIterator $file */
        foreach ($iterator as $file) {
            if ($file->isDir() || $file->isDot()) {
                continue;
            }

            $target = $this->gitHooksTargetDir . DIRECTORY_SEPARATOR . (string) $file;

            if (file_exists($target)) {
                $this->filesystem->remove($this->gitHooksTargetDir . DIRECTORY_SEPARATOR . (string) $file);
                $output->writeln(sprintf('<info>%s</info> has been removed ', (string) $file));
                $totalRemoved++;
            }
        }

        if ($totalRemoved == 0) {
            $output->writeln('<comment>No installed hooks found</comment>');
        }

        return Command::SUCCESS;
    }
}

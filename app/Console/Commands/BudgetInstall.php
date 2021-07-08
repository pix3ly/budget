<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BudgetInstall extends Command
{
    protected $signature = 'budget:install {--node-package-manager=} {--url=} {--database-host=} {--database-user=} {--database-password=}'; // phpcs:ignore
    protected $description = 'Runs most of the commands needed to make Budget work';

    public function __construct()
    {
        parent::__construct();
    }

    private function executeCommand($command): string
    {
        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function programExists(string $program): bool
    {
        try {
            $this->executeCommand(['which', $program]);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function handle(): void
    {
        // Node.js
        $nodePackageManager = $this->option('node-package-manager');
        if (!$nodePackageManager) {
            $nodePackageManager = $this->choice('Which package manager would you like to use for Node.js?', [
                'npm',
                'yarn',
            ]);
        }

        if (!$this->programExists($nodePackageManager)) {
            $this->error('Package manager "' . $nodePackageManager . '" not found, will not be able to compile front-end assets'); // phpcs:ignore
        }

        $this->executeCommand([$nodePackageManager, 'install']);
        $this->info('Installing  Node.js packages');

        $this->executeCommand([$nodePackageManager, 'run', 'production']);
        $this->info('Compiling front-end assets');

        // Configuration
        $url = $this->option('url');
        if (!$url) {
            $url = $this->ask('Which URL should Budget run on?', 'http://localhost');
        }

        $databaseHost = $this->option('database-host');
        if (!$databaseHost) {
            $databaseHost = $this->ask('What host is the database running on?', '127.0.0.1');
        }

        $databaseUser = $this->option('database-user');
        if (!$databaseUser) {
            $databaseUser = $this->ask('Which user would you like to use for the database?', 'root');
        }

        $databasePassword = $this->option('database-password');
        if (!$databasePassword) {
            $databasePassword = $this->secret('What password should be used for the database?');
        }

        $this->executeCommand(['cp', '.env.example', '.env']);
        $this->executeCommand(['php', 'artisan', 'key:generate']);
        $this->executeCommand(['php', 'artisan', 'storage:link']);

        // TODO use variables in .env

        $this->info('Done!');
    }
}

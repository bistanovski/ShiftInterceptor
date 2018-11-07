<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TestsRunner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shift:run-tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new sqlite database, runs all migrations, seeds, and unit tests.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating database.sqlite...');
        Storage::disk('tests')->put('database.sqlite', '');

        $this->info('Running database migrations...');
        $this->call('migrate', array('--database' => 'sqlite_testing'));

        $this->info('Running unit tests...');
        $process = new Process('phpunit --testsuite Unit');

        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                $this->info($buffer);
            }
        });

        // Storage::disk('tests')->delete('database.sqlite');
    }
}

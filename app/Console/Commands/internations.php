<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class internations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'internations:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting up internations configutation';

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
        $this->comment('################# Internation\'s Config ###########################');
        $this->comment('Vagrant up...');
        $this->comment('Please wait, This may take too long time...');
        $output = exec('vagrant up');
        $this->comment($output);
        $this->comment('Migration is going to start...');
        $this->call('migrate:refresh', ['--seed' => 1, '--seeder' => 'UsersSeeder' ]);
        $this->comment('Generating the Keys...');
        $this->call('passport:install');
        $this->comment('################# Operation Successful ###########################');

    }
}

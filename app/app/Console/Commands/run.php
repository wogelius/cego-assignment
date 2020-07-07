<?php

namespace App\Console\Commands;

use App\User;
use Exception;
use Illuminate\Console\Command;

class run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exports the contents of database table to file';

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
     * The amount of rows pulled from the database at a time
     *
     * @var int
     */
    protected $chunkSize = 200;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = fopen(storage_path('app/user_export.csv'), 'w');
        $bar = $this->output->createProgressBar(User::count());
        $bar->start();

        User::chunkById(200, function ($users) use ($file, $bar) {
            $users->each(function ($user) use ($file, $bar) {
                if (fputcsv($file, $user->toArray()) == false) {
                    fclose($file);
                    throw new Exception("Error writing to file.");
                };
                $user->delete();
                $bar->advance();
            });
        });

        fclose($file);
        $bar->finish();
    }
}

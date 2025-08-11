<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RefreshAndSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh-and-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate all tables and run database seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('This will delete ALL data in the database. Continue?', false)) {
            $this->info('Operation cancelled.');
            return 1;
        }

        $this->info('Disabling foreign key checks...');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = $this->getTablesToTruncate();

        foreach ($tables as $table) {
            $this->info("Truncating table: {$table}");
            DB::table($table)->truncate();
        }

        $this->info('Re-enabling foreign key checks...');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Running database seeders...');
        Artisan::call('db:seed', [], $this->output);

        $this->info('All done! The database has been refreshed and seeded.');

        return 0;
    }

    /**
     * Get the tables to truncate, excluding migrations table.
     *
     * @return array
     */
    protected function getTablesToTruncate()
    {
        return array_filter(Schema::getConnection()->getDoctrineSchemaManager()->listTableNames(), function ($table) {
            return $table !== 'migrations' && $table !== 'personal_access_tokens';
        });
    }
}

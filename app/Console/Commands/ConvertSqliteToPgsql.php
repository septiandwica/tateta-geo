<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ConvertSqliteToPgsql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:convert-sqlite-to-pgsql
                            {--host= : PostgreSQL host}
                            {--port= : PostgreSQL port}
                            {--database= : PostgreSQL database}
                            {--username= : PostgreSQL username}
                            {--password= : PostgreSQL password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely copy all data from SQLite database to PostgreSQL database with optimal memory performance.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('========================================================');
        $this->info('   TATETA GEO - SQLITE TO POSTGRESQL CONVERSION ENGINE   ');
        $this->info('========================================================');

        // Configure Postgres connection dynamically at runtime, fallback to standard Laravel env keys
        $host = $this->option('host') ?? env('PG_HOST', env('DB_HOST', '127.0.0.1'));
        $port = $this->option('port') ?? env('PG_PORT', env('DB_PORT', '5432'));
        $database = $this->option('database') ?? env('PG_DATABASE', env('DB_DATABASE', 'tateta_geo'));
        $username = $this->option('username') ?? env('PG_USERNAME', env('DB_USERNAME', 'postgres'));
        $password = $this->option('password') ?? env('PG_PASSWORD', env('DB_PASSWORD', ''));

        config([
            'database.connections.pgsql.host' => $host,
            'database.connections.pgsql.port' => $port,
            'database.connections.pgsql.database' => $database,
            'database.connections.pgsql.username' => $username,
            'database.connections.pgsql.password' => $password,
        ]);

        $this->comment("Target PostgreSQL Parameters:");
        $this->line("  Host:      {$host}");
        $this->line("  Port:      {$port}");
        $this->line("  Database:  {$database}");
        $this->line("  Username:  {$username}");
        $this->newLine();

        // Verify SQLite Source Database Connection
        try {
            DB::connection('sqlite')->getPdo();
            $this->info('✔ SQLite Source Database fully online.');
        } catch (\Exception $e) {
            $this->error('✘ Failed to connect to SQLite Source: ' . $e->getMessage());
            return 1;
        }

        // Verify target Postgres Database Connection & Auto-Create Database if missing
        try {
            DB::connection('pgsql')->getPdo();
            $this->info('✔ Target PostgreSQL Database fully online.');
        } catch (\Exception $e) {
            $message = $e->getMessage();
            // Detect if database does not exist
            if (str_contains($message, 'does not exist') || str_contains($message, 'database') || str_contains($message, '08006')) {
                $this->comment("⚠ Target database '{$database}' does not exist yet. Attempting auto-creation...");
                
                // Temporarily connect to default system database 'postgres' to run CREATE DATABASE
                config(['database.connections.pgsql.database' => 'postgres']);
                
                try {
                    DB::connection('pgsql')->disconnect();
                    DB::connection('pgsql')->getPdo();
                    
                    // Create Postgres database using safe quote escaping
                    DB::connection('pgsql')->statement("CREATE DATABASE \"{$database}\"");
                    $this->info("✔ PostgreSQL database '{$database}' successfully created!");
                    
                    // Reconnect to the newly created target database
                    config(['database.connections.pgsql.database' => $database]);
                    DB::connection('pgsql')->disconnect();
                    DB::connection('pgsql')->getPdo();
                } catch (\Exception $createEx) {
                    $this->error("✘ Failed to auto-create PostgreSQL database: " . $createEx->getMessage());
                    $this->line("  Please create the database '{$database}' manually inside PostgreSQL first.");
                    return 1;
                }
            } else {
                $this->error('✘ Failed to connect to target PostgreSQL: ' . $e->getMessage());
                $this->line('  Make sure your PostgreSQL server is active and credentials are correct.');
                return 1;
            }
        }

        // Check if schemas are deployed. If not, automatically run migrations!
        $hasTables = false;
        try {
            $hasTables = Schema::connection('pgsql')->hasTable('users');
        } catch (\Exception $e) {
            // Table doesn't exist or is empty
        }

        if (!$hasTables) {
            $this->comment("⚠ PostgreSQL schemas not found. Deploying migrations automatically...");
            try {
                $this->call('migrate', [
                    '--database' => 'pgsql',
                    '--force' => true,
                ]);
                $this->info('✔ PostgreSQL schema migrations successfully deployed!');
            } catch (\Exception $migEx) {
                $this->error('✘ Failed to run schema migrations on PostgreSQL: ' . $migEx->getMessage());
                return 1;
            }
        }

        $tables = [
            'users',
            'personal_access_tokens',
            'provinces',
            'regencies',
            'districts',
            'villages',
        ];

        $this->newLine();
        $this->comment('Disabling foreign key checks on PostgreSQL destination for bulk insertion...');
        DB::connection('pgsql')->statement('SET CONSTRAINTS ALL DEFERRED');

        foreach ($tables as $table) {
            $this->newLine();
            $this->info("▶ Migrating table: [{$table}]");

            // Verify table existences
            if (!Schema::connection('sqlite')->hasTable($table)) {
                $this->warn("  ⚠ Table '{$table}' does not exist in SQLite source. Skipping.");
                continue;
            }

            if (!Schema::connection('pgsql')->hasTable($table)) {
                $this->error("  ✘ Table '{$table}' does not exist in target PostgreSQL database.");
                return 1;
            }

            // Truncate existing data in target table
            $this->comment("  Truncating target table '{$table}'...");
            try {
                DB::connection('pgsql')->statement("TRUNCATE TABLE {$table} CASCADE");
            } catch (\Exception $e) {
                // Fallback to delete if cascade fails
                DB::connection('pgsql')->table($table)->delete();
            }

            // Get total source row count
            $totalRows = DB::connection('sqlite')->table($table)->count();
            $this->line("  Found {$totalRows} rows to migrate.");

            if ($totalRows === 0) {
                $this->info("  ✔ Table '{$table}' is empty. Completed.");
                continue;
            }

            // Setup Console Progress Bar
            $progressBar = $this->output->createProgressBar($totalRows);
            $progressBar->start();

            // Chunk records to maintain optimal memory and execution footprint
            DB::connection('sqlite')->table($table)->orderBy(DB::raw('1'))->chunk(1000, function ($rows) use ($table, $progressBar) {
                $batchData = [];
                foreach ($rows as $row) {
                    $batchData[] = (array) $row;
                }

                if (!empty($batchData)) {
                    DB::connection('pgsql')->table($table)->insert($batchData);
                    $progressBar->advance(count($batchData));
                }
            });

            $progressBar->finish();
            $this->newLine();
            $this->info("  ✔ Table '{$table}' migrated successfully!");

            // If table has auto-increment primary serial keys, reset Postgres sequence
            if ($table === 'users' || $table === 'personal_access_tokens') {
                $this->comment("  Resetting serial identity sequence for '{$table}'...");
                try {
                    $maxId = DB::connection('pgsql')->table($table)->max('id') ?: 0;
                    $sequenceName = "{$table}_id_seq";
                    DB::connection('pgsql')->statement("SELECT setval(?, ?, true)", [$sequenceName, $maxId]);
                    $this->info("  ✔ Reset sequence '{$sequenceName}' to {$maxId}");
                } catch (\Exception $e) {
                    $this->warn("  ⚠ Could not reset sequence automatically: " . $e->getMessage());
                }
            }
        }

        $this->newLine();
        $this->info('========================================================');
        $this->info('✔ ALL TABLES SUCCESSFULLY COVERTED TO POSTGRESQL!       ');
        $this->info('========================================================');
        $this->comment('Next Step: Set DB_CONNECTION=pgsql in your .env file.');
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Typesense\Client;

class SetupTypesense extends Command
{
    protected $signature = 'typesense:setup';
    protected $description = 'Create the Typesense collections for search';

    public function handle()
    {
        // 1. Correctly pull the config from scout.php
        $config = config('scout.drivers.typesense.client_settings');

        if (!$config || !isset($config['api_key'])) {
            $this->error('Config not found! Ensure TYPESENSE_API_KEY is in .env and run: php artisan config:clear');
            return;
        }

        $client = new Client($config);

        // 2. Define Schema for Protocols [cite: 45]
        $protocolSchema = [
            'name' => 'protocols',
            'fields' => [
                ['name' => 'title', 'type' => 'string'],
                ['name' => 'tags', 'type' => 'string[]', 'facet' => true],
                ['name' => 'votes', 'type' => 'int32'],
                ['name' => 'created_at', 'type' => 'int64'],
            ],
            'default_sorting_field' => 'votes'
        ];

        // 3. Define Schema for Threads [cite: 46]
        $threadSchema = [
            'name' => 'threads',
            'fields' => [
                ['name' => 'title', 'type' => 'string'],
                ['name' => 'body', 'type' => 'string'],
                ['name' => 'created_at', 'type' => 'int64'],
            ],
        ];

        try {
            // Create collections on the Typesense server [cite: 24]
            $client->collections->create($protocolSchema);
            $client->collections->create($threadSchema);
            $this->info('Typesense collections created successfully!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}

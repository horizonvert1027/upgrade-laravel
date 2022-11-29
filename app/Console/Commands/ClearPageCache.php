<?php

namespace App\Console\Commands;

use App\Services\CacheService;
use Illuminate\Console\Command;

class ClearPageCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pages:clear {--slug=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command removes page caches';

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
     * @param CacheService $cacheService
     */
    public function handle()
    {
        $slug = $this->option('slug');
        $cacheService = new CacheService();
        $this->info('Removing cached files and folders');
        $cacheService->clearCache($slug);
        $this->info('Cached files folders removed successfully!');
        return 1;
    }
}

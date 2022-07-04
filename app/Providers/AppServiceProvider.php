<?php

namespace App\Providers;

use App\Traits\Common\Providable;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\AggregateServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

class AppServiceProvider extends AggregateServiceProvider
{
    use Providable;

    /**
     * A collection of custom aliases to register
     *
     * @var array
     */
    protected array $aliases = [];

    /**
     * A collection of Shift service providers to load/register.
     *
     * @var array
     */
    protected $providers = [
        CoreProvider::class,
        AuthServiceProvider::class,
        EventServiceProvider::class,
        RouteServiceProvider::class
    ];
    /**
     * Files that require loading to bootstrap shift
     *
     * @var array
     */
    protected array $filesToBoot = [];

    /**
     * Files we need to register (include)
     *
     * @var array
     */
    protected array $filesToRegister = [];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupLogging();
    }

    /**
     *
     */
    public function setupLogging(): void
    {
        if (config('database.log')) {
            $path = storage_path('/logs/query.log');

            Event::listen(QueryExecuted::class, static function (QueryExecuted $event) use ($path) {
                // Uncomment this if you want to include bindings to queries
                $sql = str_replace(['%', '?', "\n", "\r"], ['%%', "'%s'", ' ', ' '], $event->sql);
                try {
                    $sql = vsprintf($sql, $event->bindings);
                } catch (\Exception $e) {
                    $sql = $event->sql;
                }
                $time_now = (new \DateTime)->format('Y-m-d H:i:s');
                $log = $time_now . ' | ' . $event->time . 'ms' . ' | ' . $sql . PHP_EOL;
                File::append($path, $log);
            });
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Recursive Migrations
//        $dirs = glob(database_path('migrations').'/*', GLOB_ONLYDIR);
//        $sort = array_filter($dirs, function($p) {
//            $slices = explode('/', $p);
//            return !str_starts_with($slices[count($slices) - 1], '_');
//        });
//        $paths = array_merge([database_path('migrations')], $sort);
//        $this->loadMigrationsFrom($paths);

        Relation::enforceMorphMap(config('hyperbolus.morph_map'));
    }
}

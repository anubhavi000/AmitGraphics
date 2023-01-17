<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Module;
use App\Observers\ClientLedgerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerObserervers();

        $modules = Module::with('childs')
            ->whereNull('parent_id')
            ->where('status', 'active')
            ->orderBy('sequence', 'ASC')->get();
        \View::share('modules', $modules);
    }

    // public function registerObserervers()
    // {
    //     Client::observe(ClientLedgerObserver::class);
    // }
}

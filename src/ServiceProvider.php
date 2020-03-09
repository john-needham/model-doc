<?php

namespace Needham\ModelDoc;

use Needham\ModelDoc\Commands\DocModel;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function register()
    {

    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/model-doc.php' => config_path('model-doc.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                DocModel::class
            ]);
        }
        $this->loadViewsFrom(
            __DIR__.'/../templates/stubs',
            'stubs'
        );
    }
}

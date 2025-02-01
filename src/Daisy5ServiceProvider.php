<?php

class Daisy5ServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('daisy5', function () {
            return new Daisy5();
        });
        // Register any application services.
    }
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
        // Bootstrap any application services.
    }   
    
}
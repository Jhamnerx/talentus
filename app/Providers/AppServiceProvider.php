<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Google\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\WhatsFleep\WhatsappService::class,
            \App\Services\WhatsFleep\Impl\WhatsappServiceImpl::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // Registro explícito para evitar problemas de case-sensitivity en Linux
        // (Livewire resuelve 'm2m-panel' → M2mPanel, pero la clase es M2MPanel)
        Livewire::component('admin.sim-card.m2m-panel', \App\Livewire\Admin\SimCard\M2MPanel::class);

        try {
            Storage::extend('google', function ($app, $config) {

                $options = [];
                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }

                if (!empty($config['sharedFolderId'] ?? null)) {
                    $options['sharedFolderId'] = $config['sharedFolderId'];
                }

                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);


                $service = new \Google\Service\Drive($client);

                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);

                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
        } catch (\Exception $e) {
            dd($e);
            // your exception handling logic

        }
        Gate::before(function ($user, $ability) {
            return $user->email == 'jhamnerx1x@gmail.com' ?? null;
        });
    }
}

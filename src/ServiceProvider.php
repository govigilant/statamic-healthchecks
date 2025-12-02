<?php

namespace Vigilant\StatamicHealthchecks;

use Statamic\Facades\Utility;
use Statamic\Providers\AddonServiceProvider;
use Vigilant\LaravelHealthchecks\HealthCheckRegistry;
use Vigilant\StatamicHealthchecks\Checks\StacheCheck;
use Vigilant\StatamicHealthchecks\Http\Controllers\HealthcheckUtilityController;

class ServiceProvider extends AddonServiceProvider
{
    protected $viewNamespace = 'statamic-healthchecks';

    protected $vite = [
        'input' => [
            'resources/css/addon.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function bootAddon(): void
    {
        $this
            ->bootUtility()
            ->bootRegistrations();
    }

    protected function bootUtility(): static
    {
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><polyline points="32 136 72 136 88 112 120 160 136 136 160 136" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M24,104c0-.67,0-1.33,0-2A54,54,0,0,1,78,48c22.59,0,41.94,12.31,50,32,8.06-19.69,27.41-32,50-32a54,54,0,0,1,54,54c0,66-104,122-104,122s-42-22.6-72.58-56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>';

        Utility::register('vigilant-healthchecks')
            ->action(HealthcheckUtilityController::class)
            ->title('Healthchecks')
            ->navTitle('Healthchecks')
            ->icon($icon)
            ->description('View healthchecks from the Statamic control panel.');

        return $this;
    }

    protected function bootRegistrations(): static
    {
        if (! config('vigilant-healthchecks.register', true)) {
            return $this;
        }

        $registry = app(HealthCheckRegistry::class);

        $registry->registerCheck(StacheCheck::make());

        return $this;
    }
}

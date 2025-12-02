<?php

namespace Vigilant\StatamicHealthchecks\Http\Controllers;

use Illuminate\View\View;
use Statamic\Http\Controllers\CP\CpController;
use Vigilant\HealthChecksBase\BuildResponse;
use Vigilant\LaravelHealthchecks\HealthCheckRegistry;

class HealthcheckUtilityController extends CpController
{
    public function __invoke(BuildResponse $builder, HealthCheckRegistry $registry): View
    {
        $results = $builder->build(
            $registry->getChecks(),
            $registry->getMetrics()
        );

        /** @var view-string $view */
        $view = 'statamic-healthchecks::utilities.healthchecks';

        return view($view, $results);
    }
}

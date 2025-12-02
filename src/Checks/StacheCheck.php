<?php

namespace Vigilant\StatamicHealthchecks\Checks;

use Carbon\CarbonInterface;
use Statamic\Facades\Stache;
use Vigilant\HealthChecksBase\Checks\Check;
use Vigilant\HealthChecksBase\Data\ResultData;
use Vigilant\HealthChecksBase\Enums\Status;

class StacheCheck extends Check
{
    protected string $type = 'statamic_stache';

    public function run(): ResultData
    {
        $buildDate = Stache::buildDate();

        if ($buildDate instanceof CarbonInterface) {
            return ResultData::make([
                'type' => $this->type(),
                'status' => Status::Healthy,
                'message' => 'Statamic Stache is built as of '.$buildDate->toDateTimeString(),
            ]);
        }

        return ResultData::make([
            'type' => $this->type(),
            'status' => Status::Unhealthy,
            'message' => 'Statamic Stache has not been built yet.',
        ]);
    }

    public function available(): bool
    {
        return class_exists(Stache::class);
    }
}

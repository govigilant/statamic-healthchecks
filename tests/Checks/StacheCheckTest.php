<?php

namespace Vigilant\StatamicHealthchecks\Tests\Checks;

use Carbon\CarbonImmutable;
use Statamic\Facades\Stache;
use Vigilant\HealthChecksBase\Enums\Status;
use Vigilant\StatamicHealthchecks\Checks\StacheCheck;
use Vigilant\StatamicHealthchecks\Tests\TestCase as BaseTestCase;

class StacheCheckTest extends BaseTestCase
{
    public function test_it_reports_healthy_when_stache_has_build_date(): void
    {
        $buildDate = CarbonImmutable::parse('2024-01-01 12:34:56');

        Stache::shouldReceive('buildDate')->once()->andReturn($buildDate);

        $result = (new StacheCheck())->run();

        $this->assertSame(Status::Healthy, $result->status());
        $this->assertSame('Statamic Stache is built as of '.$buildDate->toDateTimeString(), $result->message());
    }

    public function test_it_reports_unhealthy_when_stache_has_not_been_built(): void
    {
        Stache::shouldReceive('buildDate')->once()->andReturn(null);

        $result = (new StacheCheck())->run();

        $this->assertSame(Status::Unhealthy, $result->status());
        $this->assertSame('Statamic Stache has not been built yet.', $result->message());
    }
}

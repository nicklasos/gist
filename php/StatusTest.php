<?php

namespace Tests\Unit\Services;

use App\Services\Statuses;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use Statuses;

    const STATUS_OK = 'ok';
    const STATUS_CANCELED = 'canceled';

    const TYPE_ACTIVE = 'active';
    const TYPE_DISABLED = 'disabled';

    const LAUNCH_CONDITION_COMMON = 'common';
    const LAUNCH_CONDITION_PARTICIPANTS = 'participants';

    public function testStatuses()
    {
        $this->assertEquals(['ok', 'canceled'], self::statuses());
    }

    public function testTypes()
    {
        $this->assertEquals(['active', 'disabled'], self::types());
    }

    public function testLaunchConditions()
    {
        $this->assertEquals(['common', 'participants'], self::launchConditions());
    }
}

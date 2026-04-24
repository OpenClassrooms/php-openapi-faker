<?php

declare(strict_types=1);

namespace Vural\OpenAPIFaker\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

use function mt_srand;

class UnitTestCase extends TestCase
{
    use MatchesSnapshots;

    public function setUp(): void
    {
        parent::setUp();

        // Use predefined seed, so we can make realistic assertions
        mt_srand(9175);
    }
}

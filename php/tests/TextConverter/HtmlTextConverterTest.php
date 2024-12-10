<?php

declare(strict_types=1);

namespace Tests\TextConverter;

use PHPUnit\Framework\TestCase;
use RacingCar\TextConverter\HtmlTextConverter;

class HtmlTextConverterTest extends TestCase
{
    public function testFoo(): void
    {
        $htmlTextConverter = new HtmlTextConverter('foo');
        $this->assertSame('fixme', $htmlTextConverter->getFileName());
    }
}

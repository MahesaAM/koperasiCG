<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class TesKebenaranDasar extends TestCase
{
    #[Test]
    public function nilai_benar_tetap_benar(): void
    {
        $this->assertTrue(true);
    }
}

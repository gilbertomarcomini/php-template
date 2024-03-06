<?php

namespace Enums;

use App\Enums\ImagePath;
use Tests\TestCase;

class ImagePathTest extends TestCase
{
    public function testCategoryEnum(): void
    {
        $this->assertEquals('images/category', ImagePath::CATEGORY->value);
    }

    public function testProductEnum(): void
    {
        $this->assertEquals('images/product', ImagePath::PRODUCT->value);
    }
}

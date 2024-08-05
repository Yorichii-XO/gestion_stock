<?php

namespace Tests\Unit;

use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function test_it_has_a_name()
    {
        $category = new Category(['name' => 'Electronics']);
        $this->assertEquals('Electronics', $category->name);
    }

    public function test_it_can_get_formatted_name()
    {
        $category = new Category(['name' => 'Electronics']);
        $this->assertEquals('Category: Electronics', $category->getFormattedName());
    }
}

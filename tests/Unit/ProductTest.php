<?php

use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected $product;

    function setUp()
    {
        $this->product = new Product('Fallout 4', 50);
    }

    function testAProductHasName()
    {
        // Expect that product retrieved and name == 'Fallout 4'
        $this->assertEquals('Fallout 4', $this->product->name());
    }

    function testAProductHasPrice()
    {
        // Expect that product retrieved and price == 50
        $this->assertEquals(50, $this->product->price());
    }
}
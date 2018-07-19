<?php

use App\Product;
use App\Order;

class OrderTest extends Tests\TestCase
{
    protected $order;

    function setUp()
    {
        $this->order = new Order;

        $product1 = new Product('Fallout 4', 60);
        $product2 = new Product('Used Switch', 120);

        $this->order->add($product1);
        $this->order->add($product2);
    }

    function testAnOrderConsistsOfProducts()
    {
        $this->assertCount(2, $this->order->products());
    }

    function testAnOrderCanDetermineTotalCostOfProducts()
    {
        $this->assertEquals(180, $this->order->total());
    }
}
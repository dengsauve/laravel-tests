<?php

use App\Product;
use App\Order;

class OrderTest extends Tests\TestCase
{
    function testAnOrderConsistsOfProducts()
    {
        $order = $this->createOrderWithProducts();

        $this->assertCount(2, $order->products());
    }

    function testAnOrderCanDetermineTotalCostOfProducts()
    {
        $order = $this->createOrderWithProducts();

        $this->assertEquals(180, $order->total());
    }

    protected function createOrderWithProducts()
    {
        $order = new Order;

        $product1 = new Product('Fallout 4', 60);
        $product2 = new Product('Used Switch', 120);

        $order->add($product1);
        $order->add($product2);

        return $order;
    }
}
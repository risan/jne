<?php

use Jne\Weight;
use Jne\Contracts\Foundation\WeightInterface;

class WeightTest extends PHPUnit_Framework_TestCase {
    /** @test */
    function weight_can_create_from_grams()
    {
        $weight = Weight::fromGrams(1000);

        $this->assertInstanceOf(WeightInterface::class, $weight);
        $this->assertEquals(1000, $weight->grams());
    }

    /** @test */
    function weight_can_create_from_kilograms()
    {
        $weight = Weight::fromKilograms(1);

        $this->assertInstanceOf(WeightInterface::class, $weight);
        $this->assertEquals(1000, $weight->grams());
    }

    /** @test */
    function weight_can_create_from_pounds()
    {
        $weight = Weight::fromPounds(1);

        $this->assertInstanceOf(WeightInterface::class, $weight);
        $this->assertEquals(453.592, $weight->grams());
    }

    /** @test */
    function weight_can_convert_to_grams()
    {
        $weight = Weight::fromGrams(1000);

        $this->assertEquals(1000, $weight->grams());
    }

    /** @test */
    function weight_can_convert_to_kilograms()
    {
        $weight = Weight::fromGrams(1000);

        $this->assertEquals(1, $weight->kilograms());
    }

    /** @test */
    function weight_can_convert_to_pounds()
    {
        $weight = Weight::fromPounds(5);

        $this->assertEquals(5, $weight->pounds());
    }
}

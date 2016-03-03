<?php

namespace Jne;

use Jne\Contracts\Foundation\Weight as WeightInterface;

class Weight implements WeightInterface
{
    /**
     * Grams per kilogram.
     */
    const GRAMS_PER_KILOGRAM = 1000;

    /**
     * Grams per pound.
     */
    const GRAMS_PER_POUND = 453.592;

    /**
     * Weight in grams.
     *
     * @var float
     */
    protected $grams;

    /**
     * Create a new instance of Weight.
     *
     * @param float $grams
     */
    protected function __construct($grams)
    {
        $this->grams = $grams;
    }

    /**
     * Create weight from grams.
     *
     * @param float $grams
     *
     * @return \Jne\Contracts\Foudation\Weight
     */
    public static function fromGrams($grams)
    {
        return new static($grams);
    }

    /**
     * Create weight from kilograms.
     *
     * @param float $kilograms
     *
     * @return \Jne\Contracts\Foudation\Weight
     */
    public static function fromKilograms($kilograms)
    {
        return new static($kilograms * self::GRAMS_PER_KILOGRAM);
    }

    /**
     * Create weight from pounds.
     *
     * @param float $pounds
     *
     * @return \Jne\Contracts\Foudation\Weight
     */
    public static function fromPounds($pounds)
    {
        return new static($pounds * self::GRAMS_PER_POUND);
    }

    /**
     * Get weight in grams.
     *
     * @return float
     */
    public function grams()
    {
        return $this->grams;
    }

    /**
     * Get weight in kilograms.
     *
     * @return float
     */
    public function kilograms()
    {
        return $this->grams() / self::GRAMS_PER_KILOGRAM;
    }

    /**
     * Get weight in pounds.
     *
     * @return float
     */
    public function pounds()
    {
        return $this->grams() / self::GRAMS_PER_POUND;
    }
}
